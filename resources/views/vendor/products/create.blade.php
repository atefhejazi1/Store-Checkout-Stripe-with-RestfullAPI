@extends('layouts.master')
@section('page_title', 'Add Product')

@section('content')
<div class="card mw-800px mx-auto">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">New Product</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-5">
                <div class="col-md-8">
                    <div class="mb-6">
                        <label class="form-label required fw-semibold">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Classic White Tee" />
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="4"
                                  placeholder="Product description...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-6">
                            <label class="form-label required fw-semibold">Price ($)</label>
                            <input type="number" name="price" value="{{ old('price') }}"
                                   class="form-control @error('price') is-invalid @enderror"
                                   step="0.01" min="0" />
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Compare Price ($)</label>
                            <input type="number" name="compare_price" value="{{ old('compare_price') }}"
                                   class="form-control @error('compare_price') is-invalid @enderror"
                                   step="0.01" min="0" />
                            @error('compare_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-6">
                        <label class="form-label required fw-semibold">Category</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Select category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="form-label required fw-semibold">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                            <option value="active" @selected(old('status') === 'active')>Active</option>
                            <option value="archived" @selected(old('status') === 'archived')>Archived</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="form-label fw-semibold">Product Image</label>
                        <input type="file" name="image" accept="image/*"
                               class="form-control @error('image') is-invalid @enderror" />
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('vendor.products.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
