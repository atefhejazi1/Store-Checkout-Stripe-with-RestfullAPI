@extends('layouts.master')
@section('page_title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">All Categories</h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Category
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Products</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="fw-bold text-dark">{{ $category->name }}</td>
                            <td>{{ optional($category->parent)->name ?? '—' }}</td>
                            <td>
                                <span class="badge badge-light-primary">{{ $category->products_count }}</span>
                            </td>
                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-light-primary me-1">Edit</a>
                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-8">No categories yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
