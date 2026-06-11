<x-front-layout title="Sell on ShopZone — Open Your Store">

<style>
/* ── Vendor register page ──────────────────────────────────── */
.vr-wrap {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: calc(100vh - 68px);
}

/* Left: hero panel */
.vr-hero {
    background: linear-gradient(145deg, #0f172a 0%, #1e3a8a 60%, #0167f3 100%);
    padding: 4rem 3.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.vr-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.vr-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    color: #93c5fd;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: .35rem .85rem;
    border-radius: 100px;
    width: fit-content;
    margin-bottom: 2rem;
}
.vr-hero-title {
    font-size: 2.4rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 1.25rem;
    letter-spacing: -.02em;
}
.vr-hero-title span { color: #60a5fa; }
.vr-hero-sub {
    color: rgba(255,255,255,.65);
    font-size: .95rem;
    line-height: 1.7;
    margin-bottom: 2.5rem;
    max-width: 380px;
}
.vr-perk {
    display: flex;
    align-items: flex-start;
    gap: .85rem;
    margin-bottom: 1.25rem;
}
.vr-perk-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.14);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
    color: #93c5fd;
}
.vr-perk-text strong {
    display: block;
    color: #fff;
    font-size: .88rem;
    font-weight: 600;
    margin-bottom: .18rem;
}
.vr-perk-text span {
    color: rgba(255,255,255,.5);
    font-size: .8rem;
    line-height: 1.5;
}
.vr-hero-footer {
    margin-top: auto;
    padding-top: 3rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.vr-avatar-stack { display: flex; }
.vr-avatar-stack span {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #1e3a8a;
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    margin-right: -10px;
    display: block;
}
.vr-hero-stat { color: rgba(255,255,255,.6); font-size: .78rem; }
.vr-hero-stat strong { color: #fff; display: block; font-size: .95rem; font-weight: 700; }

/* Right: form panel */
.vr-form-panel {
    background: #fff;
    padding: 3.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow-y: auto;
}
.vr-form-header { margin-bottom: 2rem; }
.vr-form-header h2 {
    font-size: 1.65rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -.02em;
    margin-bottom: .4rem;
}
.vr-form-header p { color: #64748b; font-size: .88rem; }

.vr-section-label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 1rem;
    padding-bottom: .5rem;
    border-bottom: 1px solid #f1f5f9;
}
.vr-form-panel .form-label {
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .4rem;
}
.vr-form-panel .form-control {
    font-size: .88rem !important;
    padding: .65rem 1rem !important;
    border-radius: 8px !important;
    border: 1.5px solid #e2e8f0 !important;
    transition: border-color .2s, box-shadow .2s !important;
}
.vr-form-panel .form-control:focus {
    border-color: #0167f3 !important;
    box-shadow: 0 0 0 3px rgba(1,103,243,.1) !important;
}
.vr-submit-btn {
    width: 100%;
    padding: .85rem;
    background: #0167f3;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: .88rem;
    font-weight: 700;
    letter-spacing: .04em;
    cursor: pointer;
    transition: background .2s, transform .15s, box-shadow .2s;
}
.vr-submit-btn:hover {
    background: #0550c1;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(1,103,243,.32);
}
.vr-submit-btn:active { transform: translateY(0); }

/* Responsive */
@media (max-width: 900px) {
    .vr-wrap { grid-template-columns: 1fr; }
    .vr-hero { padding: 3rem 2rem; min-height: auto; }
    .vr-hero-title { font-size: 1.75rem; }
    .vr-form-panel { padding: 2.5rem 1.5rem; }
    .vr-hero-footer { display: none; }
}
</style>

<div class="vr-wrap">

    {{-- ── Left: Hero ─────────────────────────────────────── --}}
    <div class="vr-hero">
        <div style="position:relative;z-index:1;">

            <div class="vr-hero-badge">
                <i class="lni lni-store"></i>
                Vendor Program
            </div>

            <h1 class="vr-hero-title">
                Start selling on<br>
                <span>ShopZone</span> today
            </h1>

            <p class="vr-hero-sub">
                Join thousands of vendors who grow their business with ShopZone.
                Set up your store, list products, and reach customers worldwide.
            </p>

            <div class="vr-perk">
                <div class="vr-perk-icon"><i class="lni lni-rocket"></i></div>
                <div class="vr-perk-text">
                    <strong>Quick setup</strong>
                    <span>Your store goes live within 24 hours of approval.</span>
                </div>
            </div>
            <div class="vr-perk">
                <div class="vr-perk-icon"><i class="lni lni-protection"></i></div>
                <div class="vr-perk-text">
                    <strong>Secure payouts</strong>
                    <span>Get paid directly to your account. No hidden fees.</span>
                </div>
            </div>
            <div class="vr-perk">
                <div class="vr-perk-icon"><i class="lni lni-bar-chart"></i></div>
                <div class="vr-perk-text">
                    <strong>Sales dashboard</strong>
                    <span>Track your orders, revenue, and growth in real time.</span>
                </div>
            </div>

            <div class="vr-hero-footer">
                <div class="vr-avatar-stack">
                    <span></span><span></span><span></span><span></span>
                </div>
                <div class="vr-hero-stat">
                    <strong>Join our vendors</strong>
                    and grow your business
                </div>
            </div>

        </div>
    </div>

    {{-- ── Right: Form ──────────────────────────────────────── --}}
    <div class="vr-form-panel">
        <div class="vr-form-header">
            <h2>Create your store</h2>
            <p>Fill in the details below to submit your vendor application.</p>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-5 py-3 px-4" style="font-size:.83rem;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vendor.register') }}" enctype="multipart/form-data">
            @csrf

            {{-- ── Account ──────────────────────────────────── --}}
            <div class="vr-section-label">Your Account</div>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Jane Smith" autofocus />
                    @error('name')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com" />
                    @error('email')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           autocomplete="new-password" placeholder="Min. 8 characters" />
                    @error('password')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="form-control" placeholder="Repeat password" />
                </div>
            </div>

            {{-- ── Store Details ────────────────────────────── --}}
            <div class="vr-section-label">Store Details</div>

            <div class="row g-3 mb-5">
                <div class="col-sm-7">
                    <label class="form-label">Store Name <span class="text-danger">*</span></label>
                    <input type="text" name="store_name" value="{{ old('store_name') }}"
                           class="form-control @error('store_name') is-invalid @enderror"
                           placeholder="e.g. Jane's Boutique" />
                    @error('store_name')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-5">
                    <label class="form-label">Business Phone</label>
                    <input type="text" name="business_phone" value="{{ old('business_phone') }}"
                           class="form-control @error('business_phone') is-invalid @enderror"
                           placeholder="+1 555 000 0000" />
                    @error('business_phone')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Store Logo <span class="text-muted fw-normal" style="font-size:.78rem;">(optional, max 2 MB)</span></label>
                    <input type="file" name="store_logo" accept="image/png,image/jpeg,image/webp"
                           class="form-control @error('store_logo') is-invalid @enderror" />
                    @error('store_logo')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- ── Submit ───────────────────────────────────── --}}
            <button type="submit" class="vr-submit-btn">
                Submit Application →
            </button>

            <p class="text-center mt-4 mb-0" style="font-size:.8rem;color:#94a3b8;">
                Already have an account?
                <a href="{{ route('login') }}" style="color:#0167f3;font-weight:600;">Sign in</a>
            </p>

        </form>
    </div>

</div>

</x-front-layout>
