<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:       #0167f3;
            --blue-dark:  #0550c1;
            --dark:       #0f172a;
            --dark-2:     #1e293b;
            --muted:      #64748b;
            --border:     #e2e8f0;
            --light:      #f8fafc;
            --white:      #ffffff;
            --danger:     #ef4444;
            --radius:     10px;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Layout ─────────────────────────────────────────── */
        .login-wrap {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            min-height: 100vh;
        }

        /* ── Left: dark panel ───────────────────────────────── */
        .login-hero {
            background: var(--dark);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 3rem 3.5rem;
        }

        /* Subtle grid overlay */
        .login-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Glow blob */
        .login-hero::after {
            content: '';
            position: absolute;
            top: -140px;
            left: -100px;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(1,103,243,.35) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Brand */
        .hero-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: auto;
        }
        .hero-brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            font-weight: 800;
            letter-spacing: -.5px;
            flex-shrink: 0;
        }
        .hero-brand-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.03em;
        }
        .hero-brand-name span {
            display: block;
            font-size: .65rem;
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255,255,255,.4);
            margin-top: 1px;
        }

        /* Hero copy */
        .hero-copy {
            margin: auto 0;
            padding: 4rem 0;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(1,103,243,.18);
            border: 1px solid rgba(1,103,243,.35);
            color: #93c5fd;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: .3rem .85rem;
            border-radius: 100px;
            margin-bottom: 1.75rem;
        }
        .hero-eyebrow::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #3b82f6;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: .3; }
        }
        .hero-title {
            font-size: 2.6rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.12;
            letter-spacing: -.04em;
            margin-bottom: 1.25rem;
        }
        .hero-title .accent { color: #60a5fa; }
        .hero-desc {
            color: rgba(255,255,255,.5);
            font-size: .92rem;
            line-height: 1.75;
            max-width: 360px;
            margin-bottom: 2.5rem;
        }

        /* Stats row */
        .hero-stats {
            display: flex;
            gap: 2rem;
        }
        .hero-stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.03em;
            line-height: 1;
        }
        .hero-stat-label {
            font-size: .72rem;
            color: rgba(255,255,255,.4);
            margin-top: .3rem;
            font-weight: 500;
            letter-spacing: .04em;
        }
        .hero-stat-divider {
            width: 1px;
            background: rgba(255,255,255,.08);
            align-self: stretch;
        }

        /* Footer note */
        .hero-footer {
            font-size: .72rem;
            color: rgba(255,255,255,.25);
            letter-spacing: .04em;
        }
        .hero-footer a {
            color: rgba(255,255,255,.4);
            text-decoration: none;
        }
        .hero-footer a:hover { color: rgba(255,255,255,.7); }

        /* ── Right: form panel ──────────────────────────────── */
        .login-form-panel {
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
        }
        .login-form-inner { width: 100%; max-width: 380px; }

        .form-header { margin-bottom: 2.25rem; }
        .form-header h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -.03em;
            margin-bottom: .4rem;
        }
        .form-header p {
            font-size: .85rem;
            color: var(--muted);
        }

        /* Form fields */
        .field-group { margin-bottom: 1.25rem; }
        .field-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--dark-2);
            margin-bottom: .45rem;
            letter-spacing: .01em;
        }
        .field-input {
            width: 100%;
            padding: .72rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: .88rem;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--dark);
            background: var(--white);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .field-input::placeholder { color: #94a3b8; }
        .field-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(1,103,243,.1);
        }
        .field-input.error { border-color: var(--danger); }

        .field-error {
            display: block;
            font-size: .75rem;
            color: var(--danger);
            margin-top: .4rem;
        }

        /* Remember + forgot row */
        .field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }
        .check-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .8rem;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }
        .check-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            accent-color: var(--blue);
            cursor: pointer;
        }
        .forgot-link {
            font-size: .78rem;
            font-weight: 600;
            color: var(--blue);
            text-decoration: none;
        }
        .forgot-link:hover { color: var(--blue-dark); text-decoration: underline; }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: .82rem;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-family: 'Inter', system-ui, sans-serif;
            font-size: .88rem;
            font-weight: 700;
            letter-spacing: .03em;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-login:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(1,103,243,.32);
        }
        .btn-login:active { transform: translateY(0); box-shadow: none; }

        /* Session error */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: var(--radius);
            padding: .75rem 1rem;
            font-size: .8rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: .6rem;
        }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.75rem 0;
        }
        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .form-divider span {
            font-size: .72rem;
            color: #94a3b8;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* Vendor / Customer links */
        .alt-links {
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }
        .alt-link {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--dark-2);
            font-size: .82rem;
            font-weight: 500;
            transition: border-color .2s, background .2s;
        }
        .alt-link:hover {
            border-color: var(--blue);
            background: #f0f6ff;
            color: var(--blue);
        }
        .alt-link-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
        }
        .alt-link-icon.vendor  { background: #eff6ff; color: #2563eb; }
        .alt-link-icon.store   { background: #f0fdf4; color: #16a34a; }
        .alt-link-arrow { margin-left: auto; font-size: .75rem; color: #94a3b8; }

        .form-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: .75rem;
            color: #94a3b8;
        }
        .form-footer a { color: var(--blue); font-weight: 600; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }

        /* ── Responsive ─────────────────────────────────────── */
        @media (max-width: 860px) {
            .login-wrap {
                grid-template-columns: 1fr;
            }
            .login-hero {
                padding: 2.5rem 2rem;
                min-height: auto;
            }
            .hero-copy { padding: 2.5rem 0; }
            .hero-title { font-size: 1.9rem; }
            .hero-footer { display: none; }
            .login-form-panel { padding: 2.5rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="login-wrap">

    {{-- ── Left: hero ──────────────────────────────────────── --}}
    <div class="login-hero">
        <div class="hero-inner">

            {{-- Brand --}}
            <div class="hero-brand">
                <div class="hero-brand-icon">S</div>
                <div class="hero-brand-name">
                    {{ config('app.name') }}
                    <span>Admin Portal</span>
                </div>
            </div>

            {{-- Copy --}}
            <div class="hero-copy">
                <div class="hero-eyebrow">Secure Access</div>
                <h1 class="hero-title">
                    Manage your<br>
                    <span class="accent">entire platform</span><br>
                    from one place
                </h1>
                <p class="hero-desc">
                    Full control over vendors, products, categories, and orders.
                    Sign in to your admin dashboard to get started.
                </p>
                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-value">Vendors</div>
                        <div class="hero-stat-label">Approve &amp; manage</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div>
                        <div class="hero-stat-value">Products</div>
                        <div class="hero-stat-label">Platform overview</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div>
                        <div class="hero-stat-value">Orders</div>
                        <div class="hero-stat-label">Real-time tracking</div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="hero-footer">
                &copy; {{ date('Y') }} {{ config('app.name') }}.
                <a href="{{ route('home') }}">Back to storefront</a>
            </div>

        </div>
    </div>

    {{-- ── Right: form ─────────────────────────────────────── --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            <div class="form-header">
                <h2>Welcome back</h2>
                <p>Sign in to your account to continue</p>
            </div>

            {{-- Session status --}}
            @if (session('status'))
                <div class="alert-error" style="background:#eff6ff;border-color:#bfdbfe;color:#1d4ed8;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;margin-top:1px"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;margin-top:1px"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="email">Email address</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                           placeholder="you@example.com"
                           required autofocus autocomplete="username" />
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <input id="password" name="password" type="password"
                           class="field-input {{ $errors->has('password') ? 'error' : '' }}"
                           placeholder="Enter your password"
                           required autocomplete="current-password" />
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign in
                </button>
            </form>

            <div class="form-divider"><span>or continue as</span></div>

            <div class="alt-links">
                <a href="{{ route('vendor.register') }}" class="alt-link">
                    <span class="alt-link-icon vendor">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </span>
                    <div>
                        <div style="font-weight:600;font-size:.82rem;">Open a vendor store</div>
                        <div style="font-size:.73rem;color:#94a3b8;margin-top:1px;">Register and start selling</div>
                    </div>
                    <span class="alt-link-arrow">→</span>
                </a>
                <a href="{{ route('register') }}" class="alt-link">
                    <span class="alt-link-icon store">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <div>
                        <div style="font-weight:600;font-size:.82rem;">Create a customer account</div>
                        <div style="font-size:.73rem;color:#94a3b8;margin-top:1px;">Shop and checkout</div>
                    </div>
                    <span class="alt-link-arrow">→</span>
                </a>
            </div>

            <div class="form-footer">
                <a href="{{ route('home') }}">← Back to {{ config('app.name') }} store</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
