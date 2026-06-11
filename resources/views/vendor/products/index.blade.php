@extends('layouts.master')
@section('page_title', 'My Products')

@section('content')
<div class="card">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">My Products</h3>
        <div class="card-toolbar">
            <a href="{{ route('vendor.products.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Product
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-3">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-fit-cover" />
                                    </div>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                </div>
                            </td>
                            <td>{{ optional($product->category)->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="badge badge-light-{{ $product->status === 'active' ? 'success' : ($product->status === 'draft' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('vendor.products.edit', $product) }}"
                                   class="btn btn-sm btn-light-primary me-1">Edit</a>
                                <form method="POST"
                                      action="{{ route('vendor.products.destroy', $product) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-8">
                                No products yet.
                                <a href="{{ route('vendor.products.create') }}">Add your first product.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
