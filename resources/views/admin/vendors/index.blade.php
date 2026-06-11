@extends('layouts.master')
@section('page_title', 'Vendor Management')

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-6">
    <div>
        <h2 class="fw-bold text-dark mb-0">Vendor Applications</h2>
        <span class="text-muted fs-7">Review, approve, or reject vendor registrations</span>
    </div>
</div>

{{-- Status tabs --}}
<ul class="nav nav-tabs mb-6 border-bottom">
    <li class="nav-item">
        <a class="nav-link fw-semibold {{ !$status ? 'active' : '' }}"
           href="{{ route('admin.vendors.index') }}">
            All
            <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link fw-semibold {{ $status === 'pending' ? 'active' : '' }}"
           href="{{ route('admin.vendors.index', ['status' => 'pending']) }}">
            Pending
            @if($counts['pending'] > 0)
                <span class="badge bg-warning text-dark ms-1">{{ $counts['pending'] }}</span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link fw-semibold {{ $status === 'approved' ? 'active' : '' }}"
           href="{{ route('admin.vendors.index', ['status' => 'approved']) }}">
            Approved
            <span class="badge bg-success ms-1">{{ $counts['approved'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link fw-semibold {{ $status === 'blocked' ? 'active' : '' }}"
           href="{{ route('admin.vendors.index', ['status' => 'blocked']) }}">
            Rejected / Blocked
            <span class="badge bg-danger ms-1">{{ $counts['blocked'] }}</span>
        </a>
    </li>
</ul>

{{-- Table --}}
<div class="card">
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                        <th>Store</th>
                        <th>Owner</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($vendors as $store)
                        <tr>
                            {{-- Store info --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($store->logo_image)
                                        <div class="symbol symbol-40px me-3">
                                            <img src="{{ asset('uploads/' . $store->logo_image) }}"
                                                 alt="{{ $store->name }}" class="rounded" />
                                        </div>
                                    @else
                                        <div class="symbol symbol-40px me-3">
                                            <div class="symbol-label bg-light-primary fw-bold text-primary fs-6">
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

                            {{-- Owner --}}
                            <td>
                                <div class="fw-semibold">{{ optional($store->user)->name }}</div>
                                <div class="text-muted fs-7">{{ optional($store->user)->email }}</div>
                            </td>

                            {{-- Phone --}}
                            <td class="text-muted">{{ $store->business_phone ?: '—' }}</td>

                            {{-- Status badge --}}
                            <td>
                                @if ($store->vendor_status === 'approved')
                                    <span class="badge badge-light-success">Approved</span>
                                @elseif ($store->vendor_status === 'blocked')
                                    <span class="badge badge-light-danger">Rejected / Blocked</span>
                                @else
                                    <span class="badge badge-light-warning">Pending Review</span>
                                @endif
                            </td>

                            {{-- Applied date --}}
                            <td class="text-muted">{{ $store->created_at->format('M d, Y') }}</td>

                            {{-- Actions --}}
                            <td class="text-end">
                                @if ($store->vendor_status === 'pending')
                                    {{-- Pending: offer Approve + Reject --}}
                                    <form method="POST" action="{{ route('admin.vendors.approve', $store) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success me-1">
                                            <i class="bi bi-check2 me-1"></i>Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.vendors.reject', $store) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Reject this application?')">
                                            <i class="bi bi-x me-1"></i>Reject
                                        </button>
                                    </form>

                                @elseif ($store->vendor_status === 'approved')
                                    {{-- Approved: offer Block --}}
                                    <form method="POST" action="{{ route('admin.vendors.block', $store) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Block this vendor?')">
                                            <i class="bi bi-slash-circle me-1"></i>Block
                                        </button>
                                    </form>

                                @else
                                    {{-- Blocked/Rejected: offer re-approve --}}
                                    <form method="POST" action="{{ route('admin.vendors.approve', $store) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Re-approve
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-10">
                                <i class="bi bi-shop fs-2 d-block mb-2 opacity-25"></i>
                                No vendors found{{ $status ? ' with status "' . $status . '"' : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($vendors->hasPages())
            <div class="mt-5">{{ $vendors->links() }}</div>
        @endif
    </div>
</div>
@endsection
