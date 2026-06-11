<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Store::with('user')->latest();

        if (in_array($status, ['pending', 'approved', 'blocked'])) {
            $query->where('vendor_status', $status);
        }

        $vendors = $query->paginate(20)->withQueryString();

        $counts = [
            'all'      => Store::count(),
            'pending'  => Store::pending()->count(),
            'approved' => Store::approved()->count(),
            'blocked'  => Store::blocked()->count(),
        ];

        return view('admin.vendors.index', compact('vendors', 'counts', 'status'));
    }

    public function approve(Store $store)
    {
        $store->approve();
        return back()->with('success', "Store \"{$store->name}\" approved.");
    }

    public function reject(Store $store)
    {
        $store->block();
        return back()->with('success', "Store \"{$store->name}\" rejected.");
    }

    public function block(Store $store)
    {
        $store->block();
        return back()->with('success', "Store \"{$store->name}\" blocked.");
    }
}
