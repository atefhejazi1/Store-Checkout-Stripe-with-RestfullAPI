@extends('layouts.master')
@section('page_title', 'Account Pending')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <div class="card mw-500px w-100 text-center">
        <div class="card-body py-12 px-8">
            <div class="mb-6">
                <i class="bi bi-hourglass-split text-warning" style="font-size: 3rem;"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3">Your Store is Under Review</h2>
            <p class="text-muted fs-6 mb-6">
                Thank you for registering
                <strong>{{ $store->name }}</strong>.
                Our team will review your application and activate your account within 24 hours.
            </p>
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-4 mb-6 text-start">
                <i class="bi bi-info-circle-fill fs-3 text-warning me-3 mt-1"></i>
                <div class="fs-7 text-gray-700">
                    You will be able to list products and access your full vendor dashboard once your store is
                    <strong>Approved</strong> by our admin team.
                </div>
            </div>
            <a href="{{ url('/') }}" class="btn btn-light fw-semibold">
                <i class="bi bi-house me-2"></i> Back to Storefront
            </a>
        </div>
    </div>
</div>
@endsection
