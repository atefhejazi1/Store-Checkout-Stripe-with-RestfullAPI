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
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
                           href="{{ route('products.index') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                           href="{{ route('categories.index') }}">Categories</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vendor.register') ? 'active' : '' }}"
                           href="{{ route('vendor.register') }}">Sell on {{ config('app.name') }}</a>
                    </li>
                    @endguest
                </ul>

                <!-- Right actions -->
                <div class="nav-actions d-flex align-items-center gap-2">

                    <!-- Cart icon with dropdown -->
                    <x-cart-menu />

                    <div class="nav-divider"></div>

                    @guest
                        <!-- Sign In -->
                        <a href="{{ route('login') }}" class="btn-nav-login">Sign In</a>

                        <!-- Register dropdown -->
                        <div class="dropdown">
                            <button class="btn-nav-register dropdown-toggle border-0 bg-transparent"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Register
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                                style="min-width:200px;border-radius:10px;padding:.5rem;">
                                <li>
                                    <a class="dropdown-item rounded-2 py-2 px-3" href="{{ route('register') }}">
                                        <i class="lni lni-user me-2 text-muted"></i>
                                        <span class="fw-semibold" style="font-size:.875rem;">Customer Account</span>
                                        <div class="text-muted" style="font-size:.75rem;padding-left:1.5rem;">Shop and checkout</div>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item rounded-2 py-2 px-3" href="{{ route('vendor.register') }}">
                                        <i class="lni lni-store me-2 text-muted"></i>
                                        <span class="fw-semibold" style="font-size:.875rem;">Become a Vendor</span>
                                        <div class="text-muted" style="font-size:.75rem;padding-left:1.5rem;">Open your own store</div>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    @else
                        <!-- Dashboard link — admins and vendors only -->
                        @if (auth()->user()->isAdmin() || auth()->user()->isVendor())
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('vendor.dashboard') }}"
                               class="btn-nav-login">Dashboard</a>
                        @endif

                        <!-- User name + logout -->
                        <div class="dropdown">
                            <button class="btn-nav-register dropdown-toggle border-0 bg-transparent"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                                style="min-width:180px;border-radius:10px;padding:.5rem;">
                                <li>
                                    <span class="dropdown-item-text text-muted py-1 px-3"
                                          style="font-size:.75rem;">
                                        {{ auth()->user()->email }}
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="dropdown-item rounded-2 py-2 px-3 text-danger"
                                                style="font-size:.875rem;">
                                            <i class="lni lni-exit me-2"></i>Sign Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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

                <!-- Brand -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">{{ config('app.name', 'Store') }}</div>
                    <p class="footer-desc">Your destination for quality products, delivered fast and securely.</p>
                    <div class="footer-social">
                        <a href="javascript:void(0)" class="footer-social-btn"><i class="lni lni-facebook-filled"></i></a>
                        <a href="javascript:void(0)" class="footer-social-btn"><i class="lni lni-instagram"></i></a>
                        <a href="javascript:void(0)" class="footer-social-btn"><i class="lni lni-twitter-original"></i></a>
                    </div>
                </div>

                <!-- Shop links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Shop</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">All Products</a></li>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </div>

                <!-- Account links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Account</h6>
                    <ul class="footer-links">
                        @guest
                            <li><a href="{{ route('login') }}">Sign In</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                            <li><a href="{{ route('vendor.register') }}">Become a Vendor</a></li>
                        @else
                            @if (auth()->user()->isAdmin())
                                <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                            @elseif (auth()->user()->isVendor())
                                <li><a href="{{ route('vendor.dashboard') }}">My Dashboard</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                                    @csrf
                                    <button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">
                                        Sign Out
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>

                <!-- Payments -->
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

    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>

    <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script>
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
