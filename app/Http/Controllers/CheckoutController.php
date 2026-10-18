<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Корзина пуста');
        }

        $products = Product::whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $items = [];
        $grandTotal = 0;

        foreach ($cart as $id => $qty) {
            $product = $products[$id] ?? null;
            if (!$product) {
                continue;
            }

            $sum = $product->price * $qty;
            $grandTotal += $sum;

            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'sum' => $sum,
            ];
        }

        if (empty($items)) {
            return redirect()->route('cart.index')
                ->with('error', 'Товары из корзины недоступны');
        }

        $user = auth()->user();
        $prescriptions = $user->prescriptions()->latest('created_at')->get();

        return view('checkout.index', compact('items', 'grandTotal', 'user', 'prescriptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Корзина пуста');
        }

        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['required', 'string', 'max:30'],
            'email'           => ['nullable', 'email', 'max:255'],
            'address'         => ['required', 'string', 'max:500'],
            'comment'         => ['nullable', 'string', 'max:1000'],
            'prescription_id' => ['nullable', 'integer', 'exists:prescriptions,id'],
        ]);

        // Проверить, что рецепт принадлежит пользователю
        if (!empty($data['prescription_id'])) {
            $ownsPrescription = auth()->user()
                ->prescriptions()
                ->where('id', $data['prescription_id'])
                ->exists();

            if (!$ownsPrescription) {
                return back()->withErrors(['prescription_id' => 'Рецепт не найден']);
            }
        }

        $products = Product::whereIn('id', array_keys($cart))
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        // Проверить наличие
        foreach ($cart as $id => $qty) {
            $product = $products[$id] ?? null;
            if (!$product || !$product->is_active) {
                return back()->with('error', "Товар недоступен");
            }
            if ($product->quantity < $qty) {
                return back()->with('error', "Товара «{$product->name}» недостаточно на складе");
            }
        }

        $order = DB::transaction(function () use ($cart, $products, $data) {
            $totalPrice = 0;

            $order = Order::create([
                'user_id'         => auth()->id(),
                'name'            => $data['name'],
                'phone'           => $data['phone'],
                'email'           => $data['email'] ?? null,
                'address'         => $data['address'],
                'prescription_id' => $data['prescription_id'] ?? null,
                'status'          => 'new',
                'total_price'     => 0,   // обновим ниже
                'comment'         => $data['comment'] ?? null,
            ]);

            foreach ($cart as $id => $qty) {
                $product = $products[$id];
                $sum = $product->price * $qty;
                $totalPrice += $sum;

                $order->items()->create([
                    'product_id' => $product->id,
                    'price'      => $product->price,
                    'quantity'   => $qty,
                ]);

                $product->decrement('quantity', $qty);
            }

            $order->update(['total_price' => $totalPrice]);

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('checkout.success', compact('order'));
    }
}
