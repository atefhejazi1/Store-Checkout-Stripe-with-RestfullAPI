<div class="cart-dropdown">
    <a href="{{ route('cart.index') }}" class="nav-action-btn" style="display:inline-flex;align-items:center;">
        <i class="lni lni-cart"></i>
        @if($items->count() > 0)
            <span class="cart-count">{{ $items->count() }}</span>
        @endif
    </a>

    @if($items->count() > 0)
    <div class="cart-dropdown-menu">
        <div class="cart-dropdown-header">
            <span>{{ $items->count() }} {{ Str::plural('item', $items->count()) }}</span>
            <a href="{{ route('cart.index') }}">View all</a>
        </div>

        <div class="cart-dropdown-items">
            @foreach($items as $item)
            <div class="cart-dropdown-item">
                @if($item->product->image)
                    <img class="cart-item-img" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                @else
                    <div class="cart-item-img-placeholder"><i class="lni lni-image"></i></div>
                @endif

                <div class="cart-item-info">
                    <a href="{{ route('products.show', $item->product->slug) }}" class="cart-item-name">{{ $item->product->name }}</a>
                    <div class="cart-item-qty">{{ $item->quantity }} &times; {{ $item->product->price }}</div>
                </div>

                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cart-item-remove" title="Remove"><i class="lni lni-close"></i></button>
                </form>
            </div>
            @endforeach
        </div>

        <div class="cart-dropdown-footer">
            <div class="cart-dropdown-total">
                <span>Total</span>
                <span>{{ $total }}</span>
            </div>
            <a href="{{ route('checkout') }}" class="btn-store-primary w-100 justify-content-center">
                Checkout
            </a>
        </div>
    </div>
    @else
    <div class="cart-dropdown-menu">
        <div class="cart-empty-msg">
            <i class="lni lni-cart cart-empty-icon"></i>
            Your cart is empty
        </div>
    </div>
    @endif
</div>
