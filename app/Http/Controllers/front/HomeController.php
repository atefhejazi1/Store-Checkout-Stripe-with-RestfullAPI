<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::where('status', 'active')->with(['category', 'store'])->paginate(8);
        $categories = Category::where('status', 'active')->withCount('products')->get();

        // Hero collage: up to 4 products that have an image
        $heroProducts = Product::where('status', 'active')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->with('category')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view('welcome', compact('products', 'categories', 'heroProducts'));
    }
}
