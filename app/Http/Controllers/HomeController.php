<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Выбираем 5 первых товаров из БД
        $featuredProducts = Product::take(5)->get();

        return view('home', [
            'products' => $featuredProducts,
        ]);
    }
}
