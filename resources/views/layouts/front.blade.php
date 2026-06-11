<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/LineIcons.3.0.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/store.css') }}">
</head>
<body>

    <!-- ── Navbar ── -->
    <nav class="store-navbar navbar navbar-expand-lg sticky-top" id="storeNav">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-name">{{ config('app.name', 'Store') }}</span>
            </a>

            <!-- Hamburger -->
            <button class="navbar-toggler border-0 shadow-none p-1" type="button"
                data-bs-toggle="collapse" data-bs-target="#storeNavCollapse"
                aria-controls="storeNavCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="lni lni-menu" style="font-size:1.35rem;color:var(--color-text);"></i>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="storeNavCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">Cart</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isVendor() ? route('vendor.dashboard') : '#') }}">Dashboard</a>
                    </li>
                    @endauth
                </ul>

                <!-- Right actions -->
                <div class="nav-actions">
                    <!-- Cart dropdown -->
                    <x-cart-menu />

                    <div class="nav-divider"></div>

                    @guest
                        <a href="{{ route('login') }}" class="btn-nav-login">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-nav-register">Register</a>
                    @else
                        <span class="btn-nav-text">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-nav-login">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>

        </div>
    </nav>
    <!-- ── /Navbar ── -->

    {{ $slot }}

    <!-- ── Footer ── -->
    <footer class="store-footer">
        <div class="container">
            <div class="row g-5 pb-5">

                <!-- Col 1: Brand -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">{{ config('app.name', 'Store') }}</div>
                    <p class="footer-desc">Your destination for quality products, delivered fast and securely.</p>
                    <div class="footer-social">
                        <a href="javascript:void(0)" class="footer-social-btn"><i class="lni lni-facebook-filled"></i></a>
                        <a href="javascript:void(0)" class="footer-social-btn"><i class="lni lni-instagram"></i></a>
                        <a href="javascript:void(0)" class="footer-social-btn"><i class="lni lni-twitter-original"></i></a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Shop</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">All Products</a></li>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </div>

                <!-- Col 3: Account -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Account</h6>
                    <ul class="footer-links">
                        @guest
                            <li><a href="{{ route('login') }}">Sign In</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li><a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isVendor() ? route('vendor.dashboard') : '#') }}">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>

                <!-- Col 4: Info -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-heading">We Accept</h6>
                    <p style="font-size:.78rem;color:rgba(255,255,255,.4);line-height:1.7;">
                        Secure checkout powered by Stripe. Your payment information is always encrypted.
                    </p>
                    <div style="display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.75rem;">
                        <span style="background:rgba(255,255,255,.1);border-radius:4px;padding:.25rem .6rem;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.5);letter-spacing:.05em;">VISA</span>
                        <span style="background:rgba(255,255,255,.1);border-radius:4px;padding:.25rem .6rem;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.5);letter-spacing:.05em;">MASTERCARD</span>
                        <span style="background:rgba(255,255,255,.1);border-radius:4px;padding:.25rem .6rem;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.5);letter-spacing:.05em;">STRIPE</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Store') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- ── /Footer ── -->

    <!-- Scroll to top -->
    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>

    <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script>
        // Navbar shadow on scroll
        (function () {
            var nav = document.getElementById('storeNav');
            if (!nav) return;
            window.addEventListener('scroll', function () {
                nav.classList.toggle('scrolled', window.scrollY > 10);
            }, { passive: true });
        })();
    </script>

    @stack('scripts')
</body>
</html>
