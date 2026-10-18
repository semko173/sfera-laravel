<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $products = Product::whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return view('cart.index', compact('cart', 'products'));
    }

    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'integer|min:1|max:99',
        ]);

        $id  = (int) $request->input('product_id');
        $qty = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] += $qty;
        } else {
            $cart[$id] = $qty;
        }

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'       => true,
                'message'  => 'Товар добавлен в корзину',
                'cartCount'=> array_sum($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $id = (int) $request->input('product_id');
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'        => true,
                'message'   => 'Товар удалён',
                'cartCount' => array_sum($cart),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Товар удалён');
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1|max:99',
        ]);

        $id  = (int) $request->input('product_id');
        $qty = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = $qty;
            session()->put('cart', $cart);
        }

        if ($request->expectsJson()) {
            $product = Product::find($id);
            return response()->json([
                'ok'        => true,
                'quantity'  => $qty,
                'sum'       => $product ? $product->price * $qty : 0,
                'cartCount' => array_sum($cart),
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        session()->forget('cart');

        if ($request->expectsJson()) {
            return response()->json([
                'ok'        => true,
                'message'   => 'Корзина очищена',
                'cartCount' => 0,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Корзина очищена');
    }
}