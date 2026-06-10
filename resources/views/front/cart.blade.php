<x-front-layout title="Cart">

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h1 class="page-header-title">Shopping Cart</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="cart-section">
        <div class="container">

            @if(session('success'))
                <div class="store-alert store-alert-success">{{ session('success') }}</div>
            @endif

            @php $cartItems = $cart->get(); @endphp

            @if($cartItems->count())

            <div class="row g-4 align-items-start">

                <!-- Cart Items -->
                <div class="col-lg-8">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th style="width:80px;"></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr id="cart-row-{{ $item->id }}">
                                <td data-label="Image">
                                    <a href="{{ route('products.show', $item->product->slug) }}">
                                        @if($item->product->image)
                                            <img class="cart-thumb" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="cart-thumb-ph"><i class="lni lni-image"></i></div>
                                        @endif
                                    </a>
                                </td>
                                <td data-label="Product">
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="cart-product-name">{{ $item->product->name }}</a>
                                </td>
                                <td data-label="Price">
                                    ${{ number_format($item->product->price, 2) }}
                                </td>
                                <td data-label="Quantity">
                                    <input type="number"
                                        class="cart-qty-select item-quantity"
                                        data-id="{{ $item->id }}"
                                        value="{{ $item->quantity }}"
                                        min="1" max="99">
                                </td>
                                <td data-label="Subtotal">
                                    <strong>${{ number_format($item->quantity * $item->product->price, 2) }}</strong>
                                </td>
                                <td data-label="Remove">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-remove-btn" title="Remove item">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('categories.index') }}" class="btn-store-ghost p-0">
                            <i class="lni lni-arrow-left me-1"></i> Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary-box">
                        <div class="order-summary-title">Order Summary</div>

                        <div class="summary-row">
                            <span class="summary-label">Subtotal ({{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }})</span>
                            <span class="summary-value">${{ number_format($cart->total(), 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Shipping</span>
                            <span class="summary-value" style="color:var(--color-success);">Free</span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($cart->total(), 2) }}</span>
                        </div>

                        <div class="mt-4 d-grid gap-2">
                            <a href="{{ route('checkout') }}" class="btn-store-primary justify-content-center">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            @else

            <div class="cart-empty-state">
                <i class="lni lni-cart empty-icon"></i>
                <h3>Your cart is empty</h3>
                <p style="margin-bottom:2rem;">Looks like you haven't added anything yet.</p>
                <a href="{{ route('categories.index') }}" class="btn-store-primary">Start Shopping</a>
            </div>

            @endif

        </div>
    </section>

    @push('scripts')
        <script>const csrf_token = "{{ csrf_token() }}";</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('front/assets/js/cart.js') }}"></script>
    @endpush

</x-front-layout>
