<x-front-layout :title="$product->name">

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h1 class="page-header-title">{{ $product->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Shop</a></li>
                        @if($product->category)
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.index', ['category_id' => $product->category->id]) }}">{{ $product->category->name }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="product-detail-section">
        <div class="container">
            <div class="row g-5">

                <!-- Image -->
                <div class="col-lg-5">
                    <div class="product-detail-img-wrap">
                        @if($product->image)
                            <img class="product-detail-img" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-detail-placeholder"><i class="lni lni-image"></i></div>
                        @endif
                    </div>
                </div>

                <!-- Details -->
                <div class="col-lg-7">
                    @if($product->category)
                        <a href="{{ route('products.index', ['category_id' => $product->category->id]) }}" class="product-detail-category">
                            {{ $product->category->name }}
                        </a>
                    @endif

                    <h1 class="product-detail-name">{{ $product->name }}</h1>

                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <span class="product-detail-price">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price && $product->compare_price > $product->price)
                            <span class="product-detail-compare">${{ number_format($product->compare_price, 2) }}</span>
                            <span class="product-sale-badge" style="position:static;">-{{ $product->sale_percent }}%</span>
                        @endif
                    </div>

                    @if($product->description)
                        <p class="product-detail-desc">{{ $product->description }}</p>
                    @endif

                    <hr class="product-detail-divider">

                    @if(session('success'))
                        <div class="store-alert store-alert-success mb-3">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="store-alert store-alert-error mb-3">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-4">
                            <span class="qty-label">Quantity</span>
                            <select name="quantity" class="qty-select">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="d-flex gap-3 flex-wrap">
                            <button type="submit" class="btn-add-to-cart-detail">
                                <i class="lni lni-cart"></i> Add to Cart
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn-store-outline">
                                View Cart
                            </a>
                        </div>
                    </form>

                    <div class="product-meta-box">
                        @if($product->category)
                        <div class="product-meta-row">
                            <span class="meta-key">Category</span>
                            <span class="meta-val">{{ $product->category->name }}</span>
                        </div>
                        @endif
                        <div class="product-meta-row">
                            <span class="meta-key">Status</span>
                            <span class="meta-val" style="color:var(--color-success);font-weight:600;">In Stock</span>
                        </div>
                        <div class="product-meta-row">
                            <span class="meta-key">Shipping</span>
                            <span class="meta-val">Free on orders over $99</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-front-layout>
