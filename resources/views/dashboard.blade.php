@extends('layouts.master')

@section('page_title', 'Dashboard')

@section('title', 'Home')
@section('sub_title', 'Dashboard')

@section('content')
<div class="app-content flex-column-fluid">
    <div class="app-container container-fluid">

        {{-- Stats Row --}}
        <div class="row g-5 mb-8">
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-50px me-3">
                                <span class="symbol-label bg-light-primary">
                                    <i class="bi bi-box-seam fs-2x text-primary"></i>
                                </span>
                            </div>
                            <div>
                                <span class="fs-2hx fw-bold text-dark">{{ $stats['products'] }}</span>
                                <div class="fs-6 text-gray-400 fw-semibold">Total Products</div>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-sm btn-light-primary w-100">View Products</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-50px me-3">
                                <span class="symbol-label bg-light-success">
                                    <i class="bi bi-tag fs-2x text-success"></i>
                                </span>
                            </div>
                            <div>
                                <span class="fs-2hx fw-bold text-dark">{{ $stats['categories'] }}</span>
                                <div class="fs-6 text-gray-400 fw-semibold">Total Categories</div>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-light-success w-100">View Categories</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-50px me-3">
                                <span class="symbol-label bg-light-warning">
                                    <i class="bi bi-receipt fs-2x text-warning"></i>
                                </span>
                            </div>
                            <div>
                                <span class="fs-2hx fw-bold text-dark">{{ $stats['orders'] }}</span>
                                <div class="fs-6 text-gray-400 fw-semibold">Total Orders</div>
                            </div>
                        </div>
                        <span class="btn btn-sm btn-light-warning w-100 disabled">All Time</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-50px me-3">
                                <span class="symbol-label bg-light-danger">
                                    <i class="bi bi-cash-stack fs-2x text-danger"></i>
                                </span>
                            </div>
                            <div>
                                <span class="fs-2hx fw-bold text-dark">${{ number_format($stats['revenue'], 2) }}</span>
                                <div class="fs-6 text-gray-400 fw-semibold">Total Revenue</div>
                            </div>
                        </div>
                        <span class="btn btn-sm btn-light-danger w-100 disabled">All Time</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="card">
            <div class="card-header align-items-center py-5">
                <h3 class="card-title fw-bold">Recent Orders</h3>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse ($recentOrders as $order)
                                <tr>
                                    <td class="text-dark fw-bold">#{{ $order->number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->items->count() }}</td>
                                    <td>
                                        <span class="badge badge-light-info">{{ $order->payment_method }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-8">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
