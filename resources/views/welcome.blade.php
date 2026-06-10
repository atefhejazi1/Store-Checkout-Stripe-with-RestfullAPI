<x-front-layout>

    <!-- ── Hero ── -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-eyebrow">New Collection 2025</div>
                <h1 class="hero-title">
                    Discover <span class="highlight">Quality</span><br>
                    Products You'll Love
                </h1>
                <p class="hero-subtitle">
                    Explore our curated selection of premium products. Fast shipping, secure payment, hassle-free returns.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('categories.index') }}" class="btn-hero-primary">
                        Shop Now <i class="lni lni-arrow-right"></i>
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-hero-secondary">
                        Browse All Products
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
        </div>
    </section>
    <!-- ── /Hero ── -->

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
