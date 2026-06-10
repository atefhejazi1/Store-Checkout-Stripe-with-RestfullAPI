<x-front-layout title="Checkout">

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h1 class="page-header-title">Checkout</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="checkout-section">
        <div class="container">
            <div class="row g-4 align-items-start">

                <!-- Form -->
                <div class="col-lg-8">
                    <form action="{{ route('checkout') }}" method="POST" id="payment-form">
                        @csrf

                        @if($errors->any())
                        <div class="store-alert store-alert-error mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Billing Address -->
                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Billing Address</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-sm">First Name</label>
                                    <x-form.input name="addr[billing][first_name]" placeholder="First Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Last Name</label>
                                    <x-form.input name="addr[billing][last_name]" placeholder="Last Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Email Address</label>
                                    <x-form.input name="addr[billing][email]" placeholder="Email Address" type="email" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Phone Number</label>
                                    <x-form.input name="addr[billing][phone_number]" placeholder="Phone Number" type="tel" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label-sm">Street Address</label>
                                    <x-form.input name="addr[billing][street_address]" placeholder="Street Address" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">City</label>
                                    <x-form.input name="addr[billing][city]" placeholder="City" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Postal Code</label>
                                    <x-form.input name="addr[billing][postal_code]" placeholder="Postal Code" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">State / Region</label>
                                    <x-form.input name="addr[billing][state]" placeholder="State" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Country</label>
                                    <x-form.select name="addr[billing][country]" :options="$countries" />
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Shipping Address</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-sm">First Name</label>
                                    <x-form.input name="addr[shipping][first_name]" placeholder="First Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Last Name</label>
                                    <x-form.input name="addr[shipping][last_name]" placeholder="Last Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Email Address</label>
                                    <x-form.input name="addr[shipping][email]" placeholder="Email Address" type="email" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Phone Number</label>
                                    <x-form.input name="addr[shipping][phone_number]" placeholder="Phone Number" type="tel" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label-sm">Street Address</label>
                                    <x-form.input name="addr[shipping][street_address]" placeholder="Street Address" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">City</label>
                                    <x-form.input name="addr[shipping][city]" placeholder="City" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Postal Code</label>
                                    <x-form.input name="addr[shipping][postal_code]" placeholder="Postal Code" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">State / Region</label>
                                    <x-form.input name="addr[shipping][state]" placeholder="State" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-sm">Country</label>
                                    <x-form.select name="addr[shipping][country]" :options="$countries" />
                                </div>
                            </div>
                        </div>

                        <!-- Place Order -->
                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Place Your Order</h2>
                            <p style="font-size:.85rem;color:var(--color-muted);margin-bottom:1.25rem;">
                                Review your details above and click the button below to complete your order. You'll be redirected to our secure payment page.
                            </p>
                            <button type="submit" id="submit" class="btn-store-primary">
                                <i class="lni lni-lock"></i> Place Order &amp; Pay
                            </button>
                        </div>

                    </form>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="checkout-summary-box">
                        <div class="order-summary-title">Your Order</div>

                        @foreach($cart->get() as $item)
                        <div class="checkout-item-row">
                            @if($item->product->image)
                                <img class="checkout-item-img" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                            @else
                                <div class="checkout-item-img-ph"><i class="lni lni-image"></i></div>
                            @endif
                            <div class="checkout-item-info">
                                <div class="checkout-item-name">{{ $item->product->name }}</div>
                                <div class="checkout-item-qty">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="checkout-item-price">${{ number_format($item->quantity * $item->product->price, 2) }}</div>
                        </div>
                        @endforeach

                        <div class="summary-row mt-3">
                            <span class="summary-label">Subtotal</span>
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

                        <div class="mt-3 d-flex align-items-center gap-2" style="font-size:.75rem;color:var(--color-muted);">
                            <i class="lni lni-lock" style="color:var(--color-success);"></i>
                            Secured by Stripe
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-front-layout>
