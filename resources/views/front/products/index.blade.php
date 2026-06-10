<x-front-layout :title="$activeCategory ? $activeCategory->name : 'Shop'">

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h1 class="page-header-title">{{ $activeCategory ? $activeCategory->name : 'All Products' }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        @if($activeCategory)
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Shop</a></li>
                            <li class="breadcrumb-item active">{{ $activeCategory->name }}</li>
                        @else
                            <li class="breadcrumb-item active">Shop</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="products-listing-section">
        <div class="container">
            <div class="row g-4 align-items-start">

                <!-- Sidebar: Category Filter -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <div class="filter-card">
                            <div class="filter-heading">Categories</div>
                            <ul class="filter-list">
                                <li>
                                    <a href="{{ route('products.index') }}"
                                        class="filter-link {{ !$activeCategory ? 'active' : '' }}">
                                        All Products
                                        <span class="filter-count">{{ $products->total() }}</span>
                                    </a>
                                </li>
                                @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('products.index', ['category_id' => $cat->id]) }}"
                                        class="filter-link {{ $activeCategory && $activeCategory->id === $cat->id ? 'active' : '' }}">
                                        {{ $cat->name }}
                                        <span class="filter-count">{{ $cat->products_count }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <div class="results-header">
                        <span class="results-count">
                            Showing <strong>{{ $products->count() }}</strong> of <strong>{{ $products->total() }}</strong> products
                        </span>
                        @if($activeCategory)
                            <a href="{{ route('products.index') }}" class="btn-store-ghost p-0" style="font-size:.78rem;">
                                <i class="lni lni-close me-1"></i> Clear filter
                            </a>
                        @endif
                    </div>

                    @if($products->count())
                    <div class="row g-3">
                        @foreach($products as $product)
                        <div class="col-md-4 col-6">
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

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                    @endif

                    @else
                    <div class="text-center py-5">
                        <p style="color:var(--color-muted);font-size:.95rem;">No products found in this category.</p>
                        <a href="{{ route('products.index') }}" class="btn-store-outline mt-3">View All Products</a>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

</x-front-layout>
