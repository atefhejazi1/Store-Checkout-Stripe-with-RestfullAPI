@extends('layouts.master')
@section('page_title', 'My Orders')

@section('content')
<div class="card">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">My Orders</h3>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="text-dark fw-bold">#{{ $order->number }}</td>
                            <td>{{ optional($order->user)->name ?? 'Guest' }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td>${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</td>
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
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
