@extends('layouts.master')
@section('page_title', 'Store Settings')

@section('content')
<div class="card mw-700px mx-auto">
    <div class="card-header align-items-center py-5">
        <h3 class="card-title fw-bold fs-5">Store Settings</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('vendor.store.update') }}" enctype="multipart/form-data">
            @csrf @method('PATCH')

            <div class="mb-6">
                <label class="form-label required fw-semibold">Store Name</label>
                <input type="text" name="name" value="{{ old('name', $store->name) }}"
                       class="form-control @error('name') is-invalid @enderror" />
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $store->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Business Phone</label>
                <input type="text" name="business_phone" value="{{ old('business_phone', $store->business_phone) }}"
                       class="form-control" placeholder="+1 555 000 0000" />
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold">Store Logo</label>
                @if ($store->logo_image)
                    <div class="mb-3">
                        <img src="{{ asset('uploads/' . $store->logo_image) }}"
                             alt="{{ $store->name }}" class="h-60px rounded" />
                    </div>
                @endif
                <input type="file" name="logo_image" accept="image/*"
                       class="form-control @error('logo_image') is-invalid @enderror" />
                @error('logo_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label class="form-label fw-semibold required">Storefront Visibility</label>
                <select name="status" class="form-select">
                    <option value="active" @selected(old('status', $store->status) === 'active')>Active — Products visible</option>
                    <option value="inactive" @selected(old('status', $store->status) === 'inactive')>Inactive — Hidden from shoppers</option>
                </select>
                <div class="text-muted fs-7 mt-1">You can hide your store from shoppers at any time.</div>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('vendor.dashboard') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
