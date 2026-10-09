<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Раньше: Product::take(12)->get();
        // Теперь: разбиваем по 12 товаров на страницу
        $products = Product::paginate(12);

        return view('products.index', [
            'products' => $products,
        ]);
    }
}
