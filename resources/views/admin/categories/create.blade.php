@extends('layouts.master')
@section('page_title', 'Add Category')

@section('content')
<div class="card mw-800px mx-auto">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">New Category</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="form-label required fw-semibold">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Category name" />
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Parent Category</label>
                <select name="parent_id" class="form-select">
                    <option value="">— None (top-level) —</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Image</label>
                <input type="file" name="image" accept="image/*"
                       class="form-control @error('image') is-invalid @enderror" />
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
