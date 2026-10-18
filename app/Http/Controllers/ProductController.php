<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\ProductAttribute;

class ProductController extends Controller
{

public function index(Request $request)
    {
        // 1. Категории (только Солнцезащитные очки и Оправы)
        $categories = Category::whereIn('id', [1, 2])->get();

        // 2. Бренды (исключаем бренды контактных линз Acuvue (3) и Air Optix (6))
        $brands = Brand::whereNotIn('id', [3, 6])->get();

        // 3. Динамические атрибуты и их уникальные значения из базы
        $attributes = Attribute::all()->map(function ($attr) {
            $attr->options = ProductAttribute::where('attribute_id', $attr->id)
                ->whereNotNull('value')
                ->distinct()
                ->pluck('value');
            return $attr;
        });

        // 4. Фильтрация товаров
        $products = Product::query()
            ->where('is_active', 1)
            // Мин. цена
            ->when($request->input('price_min'), fn($q, $min) => $q->where('price', '>=', $min))
            // Макс. цена
            ->when($request->input('price_max'), fn($q, $max) => $q->where('price', '<=', $max))
            // Категории
            ->when($request->input('category'), fn($q, $cats) => $q->whereIn('category_id', (array)$cats))
            // Бренды
            ->when($request->input('brands'), fn($q, $b) => $q->whereIn('brand_id', (array)$b))
            // Атрибуты (attrs[attribute_id][] = value)
            ->when($request->input('attrs'), function ($q, $attrs) {
                foreach ($attrs as $attrId => $values) {
                    $values = array_filter((array)$values);
                    if (empty($values)) continue;

                    $q->whereHas('productAttributes', function ($attrQuery) use ($attrId, $values) {
                        $attrQuery->where('attribute_id', $attrId)
                                  ->whereIn('value', $values);
                    });
                }
            })
            ->latest('id')
            ->get();
        $breadcrumbs = [
        ['url' => '/', 'title' => 'Главная'],
        ['url' => route('product.index'), 'title' => 'Каталог'],
    ];
    
        return view('catalog.index', compact('products', 'categories', 'brands', 'attributes', 'breadcrumbs'));
    }
    
   public function show(Product $product)
{
    $product->load(['brand', 'category', 'productAttributes.attribute']);

    // 1. Начинаем с базовых
    $breadcrumbs = [
        ['url' => '/', 'title' => 'Главная'],
        ['url' => route('product.index'), 'title' => 'Каталог'],
    ];

    // 2. Добавляем категорию (если есть)
    if ($product->category) {
        $breadcrumbs[] = [
            'url'   => route('product.index', ['category' => $product->category->id]),
            'title' => $product->category->name,
        ];
    }

    // 3. Добавляем сам товар — последним
    $breadcrumbs[] = ['title' => $product->name];

    return view('product.show', compact('product', 'breadcrumbs'));
}
}
