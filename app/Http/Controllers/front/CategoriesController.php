<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')->withCount('products')->get();
        return view('front.categories', compact('categories'));
    }
}
