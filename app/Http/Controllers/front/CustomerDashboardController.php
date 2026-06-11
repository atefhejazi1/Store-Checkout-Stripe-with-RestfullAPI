<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }

        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->get();

        $stats = [
            'total'      => $orders->count(),
            'pending'    => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'delivered'  => $orders->whereIn('status', ['delivered', 'completed'])->count(),
            'spent'      => $orders->where('payment_status', 'paid')
                                   ->sum(fn ($o) => $o->items->sum(fn ($i) => $i->price * $i->quantity)),
        ];

        $recentOrders = $orders->take(10);

        return view('front.customer.dashboard', compact('user', 'stats', 'recentOrders'));
    }
}
