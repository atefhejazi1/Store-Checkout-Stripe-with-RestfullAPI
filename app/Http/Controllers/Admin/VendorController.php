<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Store::with('user')
                        ->latest()
                        ->paginate(20);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve(Store $store)
    {
        $store->approve();

        return back()->with('success', "Store \"{$store->name}\" has been approved.");
    }

    public function block(Store $store)
    {
        $store->block();

        return back()->with('success', "Store \"{$store->name}\" has been blocked.");
    }
}
