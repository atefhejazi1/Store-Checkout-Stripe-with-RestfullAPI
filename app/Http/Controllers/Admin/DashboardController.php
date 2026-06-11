<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'vendors'    => User::where('role', 'vendor')->count(),
            'pending'    => Store::pending()->count(),
            'products'   => Product::count(),
            'categories' => Category::count(),
            'orders'     => Order::count(),
            'revenue'    => OrderItem::selectRaw('SUM(price * quantity) as total')->value('total') ?? 0,
        ];

        $recentOrders = Order::with(['user', 'items', 'store'])->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
