<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class VendorRegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.vendor-register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'store_name'     => ['required', 'string', 'max:255'],
            'business_phone' => ['nullable', 'string', 'max:20'],
            'store_logo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'vendor',
            ]);

            $logoPath = null;
            if ($request->hasFile('store_logo')) {
                $logoPath = $request->file('store_logo')->store('stores', ['disk' => 'uploads']);
            }

            Store::create([
                'user_id'        => $user->id,
                'name'           => $request->store_name,
                'business_phone' => $request->business_phone,
                'logo_image'     => $logoPath,
                'vendor_status'  => 'pending',
                'status'         => 'inactive',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect()->route('vendor.pending');
    }
}
