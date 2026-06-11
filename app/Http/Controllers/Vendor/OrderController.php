<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])
                       ->where('store_id', auth()->user()->store->id)
                       ->latest()
                       ->paginate(20);

        return view('vendor.orders.index', compact('orders'));
    }
}
