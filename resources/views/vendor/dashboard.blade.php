@extends('layouts.master')
@section('page_title', 'My Dashboard')

@section('content')
{{-- Store header --}}
<div class="d-flex align-items-center mb-8">
    @if ($store->logo_image)
        <div class="symbol symbol-50px me-4">
            <img src="{{ asset('uploads/' . $store->logo_image) }}" alt="{{ $store->name }}" />
        </div>
    @endif
    <div>
        <h2 class="fw-bold text-dark mb-0">{{ $store->name }}</h2>
        <span class="text-muted fs-7">{{ $store->business_phone }}</span>
    </div>
</div>

{{-- Stats --}}
<div class="row g-5 mb-8">
    <div class="col-sm-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="symbol symbol-40px me-3">
                        <span class="symbol-label bg-light-primary">
                            <i class="bi bi-box-seam fs-3 text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fs-2hx fw-bold text-dark d-block">{{ $stats['products'] }}</span>
                        <span class="fs-7 text-gray-400 fw-semibold">My Products</span>
                    </div>
                </div>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-sm btn-light-primary w-100">Manage</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="symbol symbol-40px me-3">
                        <span class="symbol-label bg-light-warning">
                            <i class="bi bi-receipt fs-3 text-warning"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fs-2hx fw-bold text-dark d-block">{{ $stats['orders'] }}</span>
                        <span class="fs-7 text-gray-400 fw-semibold">My Orders</span>
                    </div>
                </div>
                <a href="{{ route('vendor.orders.index') }}" class="btn btn-sm btn-light-warning w-100">View</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="symbol symbol-40px me-3">
                        <span class="symbol-label bg-light-success">
                            <i class="bi bi-cash-stack fs-3 text-success"></i>
                        </span>
                    </div>
                    <div>
                        <span class="fs-2hx fw-bold text-dark d-block">${{ number_format($stats['revenue'], 2) }}</span>
                        <span class="fs-7 text-gray-400 fw-semibold">Total Revenue</span>
                    </div>
                </div>
                <span class="btn btn-sm btn-light w-100 disabled">All Time</span>
            </div>
        </div>
    </div>
</div>

{{-- Recent orders --}}
<div class="card">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">Recent Orders</h3>
        <div class="card-toolbar">
            <a href="{{ route('vendor.orders.index') }}" class="btn btn-sm btn-light">View All</a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="text-dark fw-bold">#{{ $order->number }}</td>
                            <td>{{ optional($order->user)->name ?? 'Guest' }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td>
                                <span class="badge badge-light-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-8">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
