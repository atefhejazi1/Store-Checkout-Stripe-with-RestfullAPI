<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:      #0167f3;
            --blue-dark: #0550c1;
            --dark:      #0f172a;
            --dark-2:    #1e293b;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --light:     #f8fafc;
            --white:     #ffffff;
            --danger:    #ef4444;
            --green:     #10b981;
            --radius:    10px;
        }

        html, body { height: 100%; font-family: 'Inter', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }

        /* ── Layout ─────────────────────────────────────────── */
        .reg-wrap {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            min-height: 100vh;
        }

        /* ── Left: form panel ───────────────────────────────── */
        .reg-form-panel {
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            overflow-y: auto;
        }
        .reg-form-inner { width: 100%; max-width: 400px; }

        .form-top-link {
            font-size: .78rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }
        .form-top-link a { color: var(--blue); font-weight: 600; text-decoration: none; }
        .form-top-link a:hover { text-decoration: underline; }

        .form-header { margin-bottom: 2rem; }
        .form-header h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -.03em;
            margin-bottom: .35rem;
        }
        .form-header p { font-size: .85rem; color: var(--muted); }

        .field-group { margin-bottom: 1.1rem; }
        .field-label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--dark-2);
            margin-bottom: .4rem;
        }
        .field-input {
            width: 100%;
            padding: .7rem 1rem;
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
        .field-input.is-error { border-color: var(--danger); }
        .field-error {
            display: block;
            font-size: .73rem;
            color: var(--danger);
            margin-top: .35rem;
        }

        .btn-register {
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
            margin-top: .5rem;
        }
        .btn-register:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(1,103,243,.3);
        }
        .btn-register:active { transform: translateY(0); box-shadow: none; }

        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: .78rem;
            color: var(--muted);
        }
        .form-footer a { color: var(--blue); font-weight: 600; text-decoration: none; }

        .vendor-cta {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .85rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--dark-2);
            font-size: .82rem;
            font-weight: 500;
            margin-top: 1.25rem;
            transition: border-color .2s, background .2s;
        }
        .vendor-cta:hover {
            border-color: var(--blue);
            background: #f0f6ff;
            color: var(--blue);
        }
        .vendor-cta-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: #eff6ff;
            color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; flex-shrink: 0;
        }
        .vendor-cta-arrow { margin-left: auto; color: #94a3b8; font-size: .8rem; }

        /* ── Right: hero panel ──────────────────────────────── */
        .reg-hero {
            background: linear-gradient(160deg, #ecfdf5 0%, #eff6ff 60%, #f0f9ff 100%);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem 3.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .reg-hero::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(1,103,243,.07), transparent 70%);
        }
        .reg-hero::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,.07), transparent 70%);
        }

        .hero-content { position: relative; z-index: 1; }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #059669;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: .3rem .8rem;
            border-radius: 100px;
            margin-bottom: 1.75rem;
        }
        .hero-tag::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #10b981;
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.15;
            letter-spacing: -.03em;
            margin-bottom: 1.1rem;
        }
        .hero-title .accent { color: var(--blue); }

        .hero-desc {
            font-size: .9rem;
            color: var(--muted);
            line-height: 1.75;
            max-width: 360px;
            margin-bottom: 2.5rem;
        }

        /* Benefit cards */
        .benefit-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: .85rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }
        .benefit-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .benefit-icon.blue  { background: #eff6ff; color: var(--blue); }
        .benefit-icon.green { background: #ecfdf5; color: var(--green); }
        .benefit-icon.amber { background: #fffbeb; color: #d97706; }

        .benefit-text strong {
            display: block;
            font-size: .86rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: .18rem;
        }
        .benefit-text span {
            font-size: .78rem;
            color: var(--muted);
            line-height: 1.5;
        }

        /* ── Responsive ─────────────────────────────────────── */
        @media (max-width: 860px) {
            .reg-wrap { grid-template-columns: 1fr; }
            .reg-hero { padding: 2.5rem 2rem; border-left: none; border-top: 1px solid var(--border); }
            .hero-title { font-size: 1.7rem; }
            .reg-form-panel { padding: 2.5rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="reg-wrap">

    {{-- ── Left: form ──────────────────────────────────────── --}}
    <div class="reg-form-panel">
        <div class="reg-form-inner">

            <div class="form-top-link">
                <a href="{{ route('home') }}">← {{ config('app.name') }}</a>
            </div>

            <div class="form-header">
                <h2>Create your account</h2>
                <p>Join {{ config('app.name') }} and start shopping today.</p>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;border-radius:var(--radius);
                            padding:.75rem 1rem;font-size:.8rem;margin-bottom:1.5rem;display:flex;gap:.6rem;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;margin-top:1px">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="name">Full Name</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name') }}"
                           class="field-input {{ $errors->has('name') ? 'is-error' : '' }}"
                           placeholder="Jane Smith"
                           required autofocus autocomplete="name" />
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field-group">
                    <label class="field-label" for="email">Email Address</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           class="field-input {{ $errors->has('email') ? 'is-error' : '' }}"
                           placeholder="you@example.com"
                           required autocomplete="username" />
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.85rem;">
                    <div class="field-group">
                        <label class="field-label" for="password">Password</label>
                        <input id="password" name="password" type="password"
                               class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                               placeholder="Min. 8 chars"
                               required autocomplete="new-password" />
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="password_confirmation">Confirm</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="field-input"
                               placeholder="Repeat password"
                               required autocomplete="new-password" />
                    </div>
                </div>

                <button type="submit" class="btn-register">Create Account</button>
            </form>

            <div class="form-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>

            <a href="{{ route('vendor.register') }}" class="vendor-cta">
                <span class="vendor-cta-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </span>
                <div>
                    <div style="font-weight:600;font-size:.82rem;">Want to sell on {{ config('app.name') }}?</div>
                    <div style="font-size:.73rem;color:#94a3b8;margin-top:1px;">Open your vendor store instead</div>
                </div>
                <span class="vendor-cta-arrow">→</span>
            </a>

        </div>
    </div>

    {{-- ── Right: hero ──────────────────────────────────────── --}}
    <div class="reg-hero">
        <div class="hero-content">

            <div class="hero-tag">Free to join</div>

            <h2 class="hero-title">
                Shop smarter<br>
                on <span class="accent">{{ config('app.name') }}</span>
            </h2>

            <p class="hero-desc">
                Thousands of products from verified vendors, delivered fast.
                Create your free account and enjoy a seamless shopping experience.
            </p>

            <div class="benefit-card">
                <div class="benefit-icon blue">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="benefit-text">
                    <strong>Verified vendors only</strong>
                    <span>Every store is reviewed and approved before going live.</span>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon green">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div class="benefit-text">
                    <strong>Secure Stripe checkout</strong>
                    <span>All payments are encrypted and processed by Stripe.</span>
                </div>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon amber">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="benefit-text">
                    <strong>Fast &amp; free shipping</strong>
                    <span>Free delivery on all orders, every time.</span>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
