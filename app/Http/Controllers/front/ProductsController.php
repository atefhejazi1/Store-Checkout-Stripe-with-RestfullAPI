<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', 'active')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->with(['category'])
            ->paginate(12);

        $categories = Category::where('status', 'active')->withCount('products')->get();
        $activeCategory = $request->category_id ? Category::find($request->category_id) : null;

        return view('front.products.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show(Product $product)
    {
        if ($product->status != 'active') {
            abort(404);
        }

        return view('front.products.show', compact('product'));
    }
}
