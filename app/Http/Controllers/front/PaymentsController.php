<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        // Only the order's owner can pay
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('front.payments.create', compact('order'));
    }

    public function createStripePaymentIntent(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $amount = (int) ($order->items->sum(fn ($item) => $item->price * $item->quantity) * 100);

        $stripe = new \Stripe\StripeClient([
            'api_key'        => config('services.stripe.secret_key'),
            'stripe_version' => '2025-04-30.preview',
        ]);

        $paymentIntent = $stripe->paymentIntents->create([
            'amount'               => $amount,
            'currency'             => 'usd',
            'payment_method_types' => ['card'],
        ]);

        try {
            $payment = new Payment();
            $payment->forceFill([
                'order_id'         => $order->id,
                'amount'           => $paymentIntent->amount,
                'currency'         => $paymentIntent->currency,
                'method'           => 'stripe',
                'status'           => 'pending',
                'transaction_id'   => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent),
            ])->save();
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function confirm(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent')
        );

        if ($paymentIntent->status === 'succeeded') {
            try {
                $payment = Payment::where('order_id', $order->id)->first();

                if ($payment) {
                    $payment->forceFill([
                        'status'           => 'completed',
                        'transaction_data' => json_encode($paymentIntent),
                    ])->save();
                }

                // Mark the order as paid
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'processing',
                ]);
            } catch (QueryException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->route('orders.confirmation', $order->id);
        }

        return redirect()->route('orders.payments.create', [
            'order'  => $order->id,
            'status' => $paymentIntent->status,
        ]);
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items', 'billingAddress']);

        return view('front.orders.confirmation', compact('order'));
    }
}
