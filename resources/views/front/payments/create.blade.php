<x-front-layout title="Complete Payment — {{ config('app.name') }}">

<div class="page-header">
    <div class="container">
        <h1 class="page-header-title">Complete Payment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Payment</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-10">
    <div class="container">
        <div class="row justify-content-center g-5 align-items-start">

            {{-- Payment form --}}
            <div class="col-lg-6">
                <div class="bg-white rounded-3 border p-5 p-md-6" style="border-color:#e5e7eb!important;">

                    <div class="d-flex align-items-center gap-3 mb-6">
                        <div style="width:42px;height:42px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="lni lni-lock" style="color:#0167f3;font-size:1.1rem;"></i>
                        </div>
                        <div>
                            <h2 style="font-size:1.1rem;font-weight:700;color:#0f172a;margin:0;">Secure Payment</h2>
                            <p style="font-size:.78rem;color:#64748b;margin:0;">Your order #{{ $order->number }}</p>
                        </div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg"
                             alt="Stripe" style="height:22px;margin-left:auto;opacity:.5;">
                    </div>

                    {{-- Stripe error message --}}
                    <div id="payment-message"
                         style="display:none;background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;
                                border-radius:8px;padding:.75rem 1rem;font-size:.82rem;margin-bottom:1.25rem;">
                    </div>

                    <form id="payment-form">
                        <div id="payment-element"
                         style="margin-bottom:1.5rem;padding:.75rem 1rem;
                                border:1.5px solid #e2e8f0;border-radius:10px;
                                background:#fff;transition:border-color .2s;"
                         onfocus="this.style.borderColor='#0167f3'"
                         onblur="this.style.borderColor='#e2e8f0'"></div>

                        <button type="submit" id="submit"
                                style="width:100%;padding:.85rem;background:#0167f3;color:#fff;border:none;
                                       border-radius:10px;font-family:'Inter',sans-serif;font-size:.88rem;
                                       font-weight:700;letter-spacing:.03em;cursor:pointer;
                                       transition:background .2s,transform .15s,box-shadow .2s;
                                       display:flex;align-items:center;justify-content:center;gap:.6rem;">
                            <span id="button-text" style="display:flex;align-items:center;gap:.5rem;">
                                <i class="lni lni-lock"></i> Pay ${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
                            </span>
                            <span id="spinner" style="display:none;">
                                Processing…
                            </span>
                        </button>
                    </form>

                    <p style="text-align:center;margin-top:1rem;font-size:.73rem;color:#94a3b8;">
                        <i class="lni lni-lock" style="color:#10b981;"></i>
                        256-bit SSL encryption · Powered by Stripe
                    </p>
                </div>
            </div>

            {{-- Order summary --}}
            <div class="col-lg-4">
                <div class="bg-white rounded-3 border p-5" style="border-color:#e5e7eb!important;">
                    <h3 style="font-size:.9rem;font-weight:700;color:#0f172a;margin-bottom:1.25rem;
                               text-transform:uppercase;letter-spacing:.06em;">Order Summary</h3>

                    @foreach($order->items as $item)
                    <div style="display:flex;align-items:center;justify-content:space-between;
                                padding:.6rem 0;border-bottom:1px solid #f1f5f9;gap:.75rem;">
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.85rem;font-weight:600;color:#1e293b;
                                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $item->product_name }}
                            </div>
                            <div style="font-size:.75rem;color:#94a3b8;">Qty: {{ $item->quantity }}</div>
                        </div>
                        <div style="font-size:.88rem;font-weight:600;color:#0f172a;flex-shrink:0;">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                    @endforeach

                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-top:1rem;margin-top:.25rem;">
                        <span style="font-size:.82rem;color:#64748b;">Subtotal</span>
                        <span style="font-size:.88rem;font-weight:600;">
                            ${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:.5rem;">
                        <span style="font-size:.82rem;color:#64748b;">Shipping</span>
                        <span style="font-size:.88rem;font-weight:600;color:#10b981;">Free</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding-top:1rem;margin-top:.75rem;border-top:2px solid #0f172a;">
                        <span style="font-size:.95rem;font-weight:700;color:#0f172a;">Total</span>
                        <span style="font-size:1.1rem;font-weight:800;color:#0167f3;">
                            ${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe    = Stripe("{{ config('services.stripe.publishable_key') }}");
    const submitBtn = document.getElementById('submit');
    let cardElement;

    (async function initialize() {
        const res = await fetch("{{ route('stripe.paymentIntent.create', $order->id) }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ _token: "{{ csrf_token() }}" }),
        });

        if (!res.ok) {
            showMessage('Failed to initialize payment. Please refresh and try again.');
            return;
        }

        const { clientSecret } = await res.json();

        // Store for use in submit
        submitBtn.dataset.clientSecret = clientSecret;

        const elements = stripe.elements({
            fonts: [{ cssSrc: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap' }],
        });

        cardElement = elements.create('card', {
            style: {
                base: {
                    color:           '#0f172a',
                    fontFamily:      'Inter, system-ui, sans-serif',
                    fontSize:        '15px',
                    fontWeight:      '400',
                    lineHeight:      '1.6',
                    '::placeholder': { color: '#94a3b8' },
                },
                invalid: { color: '#ef4444' },
            },
            hidePostalCode: false,
        });

        cardElement.mount('#payment-element');

        cardElement.on('change', (e) => {
            if (e.error) showMessage(e.error.message);
            else document.getElementById('payment-message').style.display = 'none';
        });
    })();

    document.getElementById('payment-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        setLoading(true);

        const clientSecret = submitBtn.dataset.clientSecret;

        const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: { card: cardElement },
        });

        if (error) {
            showMessage(error.message ?? 'An unexpected error occurred.');
            setLoading(false);
            return;
        }

        if (paymentIntent && paymentIntent.status === 'succeeded') {
            window.location.href = "{{ route('stripe.return', $order->id) }}"
                + '?payment_intent=' + paymentIntent.id
                + '&payment_intent_client_secret=' + clientSecret;
            return;
        }

        setLoading(false);
    });

    function showMessage(msg) {
        const el = document.getElementById('payment-message');
        el.textContent = msg;
        el.style.display = 'block';
        setTimeout(() => { el.style.display = 'none'; }, 6000);
    }

    function setLoading(loading) {
        submitBtn.disabled = loading;
        document.getElementById('button-text').style.display = loading ? 'none'   : 'flex';
        document.getElementById('spinner').style.display     = loading ? 'inline' : 'none';
        if (!loading) submitBtn.style.transform = '';
    }
</script>
@endpush

</x-front-layout>
