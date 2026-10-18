<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim($request->input('txt', ''));

        $products = collect();

        if (mb_strlen($query) >= 2) {
            // Экранируем спецсимволы LIKE (% и _)
            $like = '%' . addcslashes($query, '%_\\') . '%';

            $products = Product::query()
                ->where('is_active', 1)
                ->where(function ($q) use ($like) {
                    $q->where('name', 'LIKE', $like)
                      ->orWhere('description', 'LIKE', $like);
                })
                ->with(['brand', 'category'])
                ->latest('id')
                ->paginate(20)
                ->withQueryString();
        }

        $breadcrumbs = [
            ['url' => route('home'), 'title' => 'Главная'],
            ['title' => $query ? "Поиск: «{$query}»" : 'Поиск'],
        ];

        return view('search.index', compact('query', 'products', 'breadcrumbs'));
    }
}
