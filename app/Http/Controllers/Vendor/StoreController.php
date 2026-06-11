<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function edit()
    {
        $store = auth()->user()->store;

        return view('vendor.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = auth()->user()->store;

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'business_phone' => 'nullable|string|max:20',
            'logo_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('logo_image')) {
            $data['logo_image'] = $request->file('logo_image')
                                          ->store('stores', ['disk' => 'uploads']);
        } else {
            unset($data['logo_image']);
        }

        $store->update($data);

        return back()->with('success', 'Store settings updated.');
    }
}
