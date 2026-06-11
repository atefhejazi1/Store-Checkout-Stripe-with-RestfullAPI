<x-front-layout title="Order Confirmed — {{ config('app.name') }}">

<section class="py-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                {{-- Success card --}}
                <div class="text-center mb-8">
                    <div style="width:72px;height:72px;background:#ecfdf5;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                        <svg width="34" height="34" fill="none" stroke="#10b981" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h1 style="font-size:1.75rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:.5rem;">
                        Payment successful!
                    </h1>
                    <p style="color:#64748b;font-size:.95rem;">
                        Thank you for your order. We've received your payment and
                        your order is now being processed.
                    </p>
                </div>

                {{-- Order details card --}}
                <div class="bg-white rounded-3 border mb-5" style="border-color:#e5e7eb!important;overflow:hidden;">
                    <div style="background:#f8fafc;padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;
                                display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:.78rem;font-weight:700;text-transform:uppercase;
                                     letter-spacing:.08em;color:#64748b;">Order Details</span>
                        <span style="font-size:.88rem;font-weight:700;color:#0f172a;">
                            #{{ $order->number }}
                        </span>
                    </div>

                    <div style="padding:1.25rem 1.5rem;">
                        @foreach($order->items as $item)
                        <div style="display:flex;justify-content:space-between;align-items:center;
                                    padding:.55rem 0;border-bottom:1px solid #f1f5f9;">
                            <div>
                                <div style="font-size:.88rem;font-weight:600;color:#1e293b;">{{ $item->product_name }}</div>
                                <div style="font-size:.75rem;color:#94a3b8;">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div style="font-size:.88rem;font-weight:600;color:#0f172a;">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </div>
                        </div>
                        @endforeach

                        <div style="display:flex;justify-content:space-between;align-items:center;
                                    padding-top:1rem;margin-top:.25rem;">
                            <span style="font-size:.82rem;color:#64748b;">Shipping</span>
                            <span style="font-size:.85rem;font-weight:600;color:#10b981;">Free</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;
                                    padding-top:.75rem;margin-top:.5rem;border-top:2px solid #0f172a;">
                            <span style="font-size:.95rem;font-weight:700;">Total Paid</span>
                            <span style="font-size:1.1rem;font-weight:800;color:#0167f3;">
                                ${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Billing address --}}
                @if($order->billingAddress)
                <div class="bg-white rounded-3 border mb-6" style="border-color:#e5e7eb!important;">
                    <div style="background:#f8fafc;padding:.75rem 1.5rem;border-bottom:1px solid #e5e7eb;">
                        <span style="font-size:.75rem;font-weight:700;text-transform:uppercase;
                                     letter-spacing:.08em;color:#64748b;">Billed To</span>
                    </div>
                    <div style="padding:1rem 1.5rem;font-size:.85rem;color:#374151;line-height:1.8;">
                        {{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}<br>
                        {{ $order->billingAddress->email }}<br>
                        {{ $order->billingAddress->phone_number }}<br>
                        {{ $order->billingAddress->street_address }}
                        @if($order->billingAddress->city)
                            , {{ $order->billingAddress->city }}
                        @endif
                    </div>
                </div>
                @endif

                {{-- Actions --}}
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn-store-primary">
                        Continue Shopping
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

</x-front-layout>
