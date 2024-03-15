<?php

namespace App\Http\Controllers\Payment;

use App\Classes\Points;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Stripe\Stripe;
use App\Models\User;


class StripeController extends Controller
{
    public function checkout($id) {
        $stripePriceId = $id;
        $quantity = "1";
        return auth()->user()->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout-success', ["id" => $stripePriceId]) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout-cancel'),
        ]);
    }

    public function verifyPaymentStatus($paymentIntentId) {
        Stripe::setApiKey(env("STRIPE_SECRET"));
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            if ($paymentIntent->status == 'succeeded') {
                return true;
            } elseif ($paymentIntent->status == 'requires_payment_method') {
                return false;
            } else {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }
    }

    public function success($id, Points $points) {
        $checkoutSession = request()->user()->stripe()->checkout->sessions->retrieve(request()->get("session_id"));
        $payment_intent = $checkoutSession->payment_intent;
        $status = $this->verifyPaymentStatus($payment_intent);
        if(!$status) return to_route("home");
        
        $user = auth()->user();
        $purchase = $user->purchases()->create([
            "purchase_product_id" => $id  
        ]);
        $purchase->course->tracker()->create([
            "tracking" => "[]",
            "user_id" => $user->id,
            "progress" => 0,
            "status" => 1
        ]);

        $points->add(User::find($user->id), 50);
        
        return redirect()->to(route("home"))->with("flash", "You haved purchased your course!");
    }
    public function cancel() {

    }
}
