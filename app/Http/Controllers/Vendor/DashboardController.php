<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $stats = [
            'products' => Product::where('store_id', $store->id)->count(),
            'orders'   => Order::where('store_id', $store->id)->count(),
            'revenue'  => OrderItem::whereHas(
                              'order',
                              fn ($q) => $q->where('store_id', $store->id)
                          )->selectRaw('SUM(price * quantity) as total')->value('total') ?? 0,
        ];

        $recentOrders = Order::with(['user', 'items'])
                             ->where('store_id', $store->id)
                             ->latest()
                             ->limit(10)
                             ->get();

        return view('vendor.dashboard', compact('stats', 'recentOrders', 'store'));
    }

    public function pending()
    {
        $store = auth()->user()->store;

        return view('vendor.pending', compact('store'));
    }
}
