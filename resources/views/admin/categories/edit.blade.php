@extends('layouts.master')
@section('page_title', 'Edit Category')

@section('content')
<div class="card mw-800px mx-auto">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">Edit: {{ $category->name }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-6">
                <label class="form-label required fw-semibold">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="form-control @error('name') is-invalid @enderror" />
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Parent Category</label>
                <select name="parent_id" class="form-select">
                    <option value="">— None (top-level) —</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}"
                                @selected(old('parent_id', $category->parent_id) == $parent->id)>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Image</label>
                @if ($category->image)
                    <div class="mb-3">
                        <img src="{{ asset('uploads/' . $category->image) }}"
                             alt="{{ $category->name }}" class="h-60px rounded" />
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="form-control @error('image') is-invalid @enderror" />
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
