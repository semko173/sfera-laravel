<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController; // 1. Импортируем CatalogController
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Каталог товаров
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index'); // 2. Указываем CatalogController
Route::get('/products', [CatalogController::class, 'index']); // Перенаправляем /products сюда же или удаляем