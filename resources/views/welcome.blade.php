<x-front-layout>

    <!-- ── Hero ── -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-split">

                {{-- Left: copy --}}
                <div class="hero-copy-col">
                    <div class="hero-eyebrow">New Collection 2025</div>
                    <h1 class="hero-title">
                        Discover <span class="highlight">Quality</span><br>
                        Products You'll Love
                    </h1>
                    <p class="hero-subtitle">
                        Explore our curated selection of premium products.
                        Fast shipping, secure payment, hassle-free returns.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('categories.index') }}" class="btn-hero-primary">
                            Shop Now <i class="lni lni-arrow-right"></i>
                        </a>
                        <a href="{{ route('products.index') }}" class="btn-hero-secondary">
                            Browse All
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div>
                            <div class="hero-stat-num">{{ $products->total() }}+</div>
                            <div class="hero-stat-lbl">Products</div>
                        </div>
                        <div>
                            <div class="hero-stat-num">{{ $categories->count() }}</div>
                            <div class="hero-stat-lbl">Categories</div>
                        </div>
                        <div>
                            <div class="hero-stat-num">100%</div>
                            <div class="hero-stat-lbl">Secure</div>
                        </div>
                    </div>
                </div>

                {{-- Right: product image collage --}}
                @if($heroProducts->count())
                @php
                    $leftCols  = $heroProducts->values()->filter(fn($v, $k) => $k % 2 === 0)->values();
                    $rightCols = $heroProducts->values()->filter(fn($v, $k) => $k % 2 !== 0)->values();
                @endphp
                <div class="hero-collage" aria-hidden="true">

                    <div class="collage-glow"></div>

                    <div class="collage-col collage-col-a">
                        @foreach($leftCols as $p)
                        <a href="{{ route('products.show', $p->slug) }}" class="collage-card">
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" loading="lazy">
                            <div class="collage-card-info">
                                <span class="collage-card-name">{{ Str::limit($p->name, 20) }}</span>
                                <span class="collage-card-price">${{ number_format($p->price, 2) }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <div class="collage-col collage-col-b">
                        @foreach($rightCols as $p)
                        <a href="{{ route('products.show', $p->slug) }}" class="collage-card">
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" loading="lazy">
                            <div class="collage-card-info">
                                <span class="collage-card-name">{{ Str::limit($p->name, 20) }}</span>
                                <span class="collage-card-price">${{ number_format($p->price, 2) }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <div class="collage-badge">
                        <i class="lni lni-star-filled"></i> Top Picks
                    </div>

                </div>
                @endif

            </div>
        </div>
    </section>
    <!-- ── /Hero ── -->

    <style>
    .hero-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 4rem;
    }
    .hero-copy-col { position: relative; z-index: 1; }

    /* ── Collage container ── */
    .hero-collage {
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        height: 480px;
        overflow: hidden;
        -webkit-mask-image: linear-gradient(to bottom,
            transparent 0%, #000 11%, #000 84%, transparent 100%);
        mask-image: linear-gradient(to bottom,
            transparent 0%, #000 11%, #000 84%, transparent 100%);
    }

    /* Decorative radial glow */
    .collage-glow {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 320px; height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(96,165,250,.2) 0%, transparent 68%);
        pointer-events: none;
        z-index: 0;
    }

    /* ── Two columns ── */
    .collage-col {
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: relative;
        z-index: 1;
    }
    /* Right column shifted down to create stagger effect */
    .collage-col-b { margin-top: 55px; }

    /* ── Cards ── */
    .collage-card {
        display: flex;
        flex-direction: column;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.13);
        background: rgba(255,255,255,.06);
        backdrop-filter: blur(8px);
        text-decoration: none;
        flex-shrink: 0;
        transition: transform .25s ease, box-shadow .25s ease;
        box-shadow: 0 6px 22px rgba(0,0,0,.28);
    }
    /* Alternating subtle rotations per column */
    .collage-col-a .collage-card:nth-child(odd)  { transform: rotate(-1.8deg); }
    .collage-col-a .collage-card:nth-child(even) { transform: rotate(1.3deg); }
    .collage-col-b .collage-card:nth-child(odd)  { transform: rotate(2deg); }
    .collage-col-b .collage-card:nth-child(even) { transform: rotate(-1.5deg); }
    .collage-card:hover {
        transform: translateY(-6px) scale(1.03) rotate(0deg) !important;
        box-shadow: 0 18px 44px rgba(0,0,0,.36);
        z-index: 5;
    }
    .collage-card img {
        width: 100%;
        height: 115px;
        object-fit: cover;
        display: block;
    }
    .collage-card-info {
        padding: .42rem .65rem;
        background: rgba(15,23,42,.82);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .4rem;
        flex-shrink: 0;
    }
    .collage-card-name {
        font-size: .62rem;
        font-weight: 600;
        color: rgba(255,255,255,.88);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .collage-card-price {
        font-size: .62rem;
        font-weight: 700;
        color: #60a5fa;
        flex-shrink: 0;
    }

    /* ── "Top Picks" badge floating in center ── */
    .collage-badge {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        color: #0f172a;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        padding: .38rem .85rem;
        border-radius: 100px;
        white-space: nowrap;
        box-shadow: 0 4px 16px rgba(0,0,0,.22);
        display: flex;
        align-items: center;
        gap: .3rem;
        pointer-events: none;
        z-index: 10;
    }
    .collage-badge i { color: #f59e0b; font-size: .65rem; }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .hero-split { grid-template-columns: 1fr; gap: 2.5rem; }
        .hero-collage { height: 340px; max-width: 440px; margin: 0 auto; }
        .collage-card img { height: 88px; }
        .collage-col-b { margin-top: 44px; }
    }
    @media (max-width: 576px) { .hero-collage { display: none; } }
    </style>

    <!-- ── Categories ── -->
    @if($categories->count())
    <section class="categories-section">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between mb-4">
                <div>
                    <span class="section-label">Browse By</span>
                    <h2 class="section-title mb-0">Shop Categories</h2>
                    <div class="section-divider"></div>
                </div>
                <a href="{{ route('categories.index') }}" class="btn-store-ghost d-none d-md-flex">
                    View All <i class="lni lni-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-3">
                @foreach($categories->take(8) as $index => $category)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="category-card">
                        @if($category->image)
                            <img class="category-card-img" src="{{ $category->image_url }}" alt="{{ $category->name }}">
                        @else
                            <div class="category-placeholder cat-c-{{ $index % 8 }}">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="category-card-body">
                            <div class="category-card-name">{{ $category->name }}</div>
                            <div class="category-card-count">{{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4 d-md-none">
                <a href="{{ route('categories.index') }}" class="btn-store-outline">View All Categories</a>
            </div>
        </div>
    </section>
    @endif
    <!-- ── /Categories ── -->

    <!-- ── Trending Products ── -->
    <section class="products-section">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between mb-4">
                <div>
                    <span class="section-label">Hand-Picked</span>
                    <h2 class="section-title mb-0">Trending Products</h2>
                    <div class="section-divider"></div>
                </div>
                <a href="{{ route('products.index') }}" class="btn-store-ghost d-none d-md-flex">
                    See All <i class="lni lni-arrow-right ms-1"></i>
                </a>
            </div>

            @if($products->count())
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->slug) }}" class="product-card-link">
                            <div class="product-card-img-wrap">
                                @if($product->image)
                                    <img class="product-card-img" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @else
                                    <div class="product-img-placeholder"><i class="lni lni-image"></i></div>
                                @endif
                                @if($product->compare_price && $product->compare_price > $product->price)
                                    <span class="product-sale-badge">Sale</span>
                                @endif
                            </div>
                            <div class="product-card-body">
                                <div class="product-card-category">{{ $product->category->name ?? '' }}</div>
                                <div class="product-card-name">{{ $product->name }}</div>
                                <div class="product-card-price">
                                    <span class="price-current">${{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_price && $product->compare_price > $product->price)
                                        <span class="price-original">${{ number_format($product->compare_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="product-card-footer">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-to-cart">
                                    <i class="lni lni-cart"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('products.index') }}" class="btn-store-outline">View All Products</a>
            </div>
            @else
            <div class="text-center py-5">
                <p style="color:var(--color-muted);">No products available yet.</p>
            </div>
            @endif
        </div>
    </section>
    <!-- ── /Trending Products ── -->

    <!-- ── Why Choose Us ── -->
    <section class="features-section">
        <div class="container">
            <div class="row g-0">
                <div class="col-6 col-md-3">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="lni lni-delivery"></i></div>
                        <div class="feature-title">Free Shipping</div>
                        <div class="feature-desc">On all orders over $99</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="lni lni-lock"></i></div>
                        <div class="feature-title">Secure Payment</div>
                        <div class="feature-desc">100% protected by Stripe</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="lni lni-support"></i></div>
                        <div class="feature-title">24/7 Support</div>
                        <div class="feature-desc">We're here when you need us</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="lni lni-reload"></i></div>
                        <div class="feature-title">Easy Returns</div>
                        <div class="feature-desc">Hassle-free 30-day returns</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ── /Why Choose Us ── -->

</x-front-layout>
