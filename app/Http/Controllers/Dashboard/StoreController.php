<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class StoreController extends Controller
{
    public function index()
    {
        $stats = [
            'products'   => Product::count(),
            'categories' => Category::count(),
            'orders'     => Order::count(),
            'revenue'    => OrderItem::selectRaw('SUM(price * quantity) as total')->value('total') ?? 0,
        ];

        $recentOrders = Order::with(['user', 'items'])->latest()->limit(10)->get();

        return view('dashboard', compact('stats', 'recentOrders'));
    }
}
