<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApprovedVendor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->isApprovedVendor()) {
            return redirect()->route('vendor.pending');
        }

        return $next($request);
    }
}
