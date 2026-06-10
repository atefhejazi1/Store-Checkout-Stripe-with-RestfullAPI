<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::where('status', 'active')->with(['category', 'store'])->paginate(8);
        $categories = Category::where('status', 'active')->withCount('products')->get();
        return view('welcome', compact('products', 'categories'));
    }
}
