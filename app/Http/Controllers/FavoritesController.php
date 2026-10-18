<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoritesController extends Controller
{
    public function index(): View
    {
        $favorites = session()->get('favorites', []);

        $products = Product::query()
            ->whereIn('id', array_keys($favorites))
            ->where('is_active', 1)
            ->with(['brand', 'category'])
            ->get();

        return view('favorites.index', compact('products'));
    }

    public function toggle(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $id = (int) $request->input('product_id');
        $favorites = session()->get('favorites', []);

        if (isset($favorites[$id])) {
            unset($favorites[$id]);
            $isFavorite = false;
            $message = 'Удалено из избранного';
        } else {
            $favorites[$id] = true;
            $isFavorite = true;
            $message = 'Добавлено в избранное';
        }

        session()->put('favorites', $favorites);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'         => true,
                'isFavorite' => $isFavorite,
                'message'    => $message,
                'count'      => count($favorites),
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $id = (int) $request->input('product_id');
        $favorites = session()->get('favorites', []);
        unset($favorites[$id]);
        session()->put('favorites', $favorites);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'      => true,
                'message' => 'Удалено из избранного',
                'count'   => count($favorites),
            ]);
        }

        return redirect()->back()->with('success', 'Удалено из избранного');
    }

    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        session()->forget('favorites');

        if ($request->expectsJson()) {
            return response()->json([
                'ok'      => true,
                'message' => 'Избранное очищено',
                'count'   => 0,
            ]);
        }

        return redirect()->route('favorites.index')->with('success', 'Избранное очищено');
    }
}