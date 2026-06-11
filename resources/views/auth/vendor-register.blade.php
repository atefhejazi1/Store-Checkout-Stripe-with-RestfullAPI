<x-front-layout title="Become a Vendor — {{ config('app.name') }}">

<div class="page-header">
    <div class="container">
        <h1 class="page-header-title">Become a Vendor</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Vendor Registration</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-10">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                {{-- Intro banner --}}
                <div class="d-flex align-items-start gap-4 p-5 rounded-3 border mb-8"
                     style="background:#f8f9ff;border-color:#dde3ff!important;">
                    <i class="lni lni-store fs-2 mt-1" style="color:#4f46e5;"></i>
                    <div>
                        <h5 class="fw-bold mb-1" style="color:#1e1b4b;">Open your store on {{ config('app.name') }}</h5>
                        <p class="mb-0 text-muted" style="font-size:.9rem;">
                            Fill in the form below to submit your application. Our team reviews every
                            application and you'll receive full access once approved — usually within 24 hours.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('vendor.register') }}" enctype="multipart/form-data"
                      class="bg-white rounded-3 border p-6 p-md-8" style="border-color:#e5e7eb!important;">

                    @csrf

                    {{-- Validation summary --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-6 py-3 px-4">
                            <ul class="mb-0 ps-3" style="font-size:.875rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ── Account ─────────────────────────────────────────── --}}
                    <h6 class="fw-bold text-uppercase ls-wide mb-5"
                        style="font-size:.7rem;letter-spacing:.1em;color:#6b7280;">
                        Account Details
                    </h6>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Jane Smith" autofocus />
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="you@example.com" />
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem;">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   autocomplete="new-password" />
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem;">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" />
                        </div>
                    </div>

                    <hr class="my-6" style="border-color:#f0f0f0;">

                    {{-- ── Store ────────────────────────────────────────────── --}}
                    <h6 class="fw-bold text-uppercase ls-wide mb-5"
                        style="font-size:.7rem;letter-spacing:.1em;color:#6b7280;">
                        Store Details
                    </h6>

                    <div class="row g-4 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold" style="font-size:.875rem;">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="store_name" value="{{ old('store_name') }}"
                                   class="form-control @error('store_name') is-invalid @enderror"
                                   placeholder="e.g. Jane's Boutique" />
                            @error('store_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold" style="font-size:.875rem;">Business Phone</label>
                            <input type="text" name="business_phone" value="{{ old('business_phone') }}"
                                   class="form-control @error('business_phone') is-invalid @enderror"
                                   placeholder="+1 555 000 0000" />
                            @error('business_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="form-label fw-semibold" style="font-size:.875rem;">Store Logo <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="file" name="store_logo" accept="image/png,image/jpeg,image/webp"
                               class="form-control @error('store_logo') is-invalid @enderror" />
                        <div class="form-text">PNG, JPG or WEBP — max 2 MB</div>
                        @error('store_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- ── Submit ───────────────────────────────────────────── --}}
                    <div class="d-flex align-items-center justify-content-between pt-2">
                        <span style="font-size:.82rem;color:#6b7280;">
                            Already have an account?
                            <a href="{{ route('login') }}" style="color:#4f46e5;font-weight:600;">Sign in</a>
                        </span>
                        <button type="submit" class="btn-store-primary px-6">
                            Submit Application
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

</x-front-layout>
