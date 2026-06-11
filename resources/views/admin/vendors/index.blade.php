@extends('layouts.master')
@section('page_title', 'Vendor Management')

@section('content')
<div class="card">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">All Vendors</h3>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                        <th>Store</th>
                        <th>Owner</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($vendors as $store)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($store->logo_image)
                                        <div class="symbol symbol-40px me-3">
                                            <img src="{{ asset('uploads/' . $store->logo_image) }}" alt="{{ $store->name }}" />
                                        </div>
                                    @else
                                        <div class="symbol symbol-40px me-3">
                                            <div class="symbol-label bg-light-primary fw-bold text-primary fs-7">
                                                {{ strtoupper(substr($store->name, 0, 2)) }}
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $store->name }}</div>
                                        <div class="text-muted fs-7">{{ $store->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ optional($store->user)->name }}</div>
                                <div class="text-muted fs-7">{{ optional($store->user)->email }}</div>
                            </td>
                            <td>{{ $store->business_phone ?? '—' }}</td>
                            <td>
                                @if ($store->vendor_status === 'approved')
                                    <span class="badge badge-light-success">Approved</span>
                                @elseif ($store->vendor_status === 'blocked')
                                    <span class="badge badge-light-danger">Blocked</span>
                                @else
                                    <span class="badge badge-light-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $store->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                @if ($store->vendor_status !== 'approved')
                                    <form method="POST"
                                          action="{{ route('admin.vendors.approve', $store) }}"
                                          class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-light-success me-1">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                @if ($store->vendor_status !== 'blocked')
                                    <form method="POST"
                                          action="{{ route('admin.vendors.block', $store) }}"
                                          class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-light-danger">
                                            Block
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-8">No vendors registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
@endsection
