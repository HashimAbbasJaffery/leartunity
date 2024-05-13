<?php

namespace App\Http\Controllers\Payment;

use App\Classes\Points;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Stripe\Account;
use Stripe\BaseStripeClient;
use Stripe\Charge;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use App\Models\User;
use Stripe\Checkout\Session;
use Stripe\StripeClient;
use Stripe\Transfer;
use Illuminate\Support\Str;


class StripeController extends Controller
{
    public function checkout($id) {
        $user = (User::find(auth()->id()))->hasVerifiedEmail();
        if(!$user) return redirect()->back()->with("flash", "Please verify your email first");
        $stripePriceId = $id;
        Stripe::setApiKey(env("STRIPE_SECRET"));
        $price = Price::retrieve($id);
        $product_id = Product::retrieve($price->product);

        $course = Course::where("stripe_id", $price->id)->first();
        $quantity = "1";
        $currency = User::find(auth()->id())->currency;
        
        return auth()->user()->checkout([$stripePriceId => $quantity], [
            'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $currency->currency, // Change currency as needed
                            'product_data' => [
                                'name' => 'Product Name',
                            ],
                            'unit_amount' => round($course->price * \App\Helpers\exchange_rate($currency->currency)) * 100, // Amount in cents
                        ],
                        'quantity' => 1,
                    ],
                ],
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

    public function success($id) {
        $checkoutSession = request()->user()->stripe()->checkout->sessions->retrieve(request()->get("session_id"));
        $payment_intent = $checkoutSession->payment_intent;
        $status = $this->verifyPaymentStatus($payment_intent);
        if(!$status) return to_route("home");
        
        $user = auth()->user();
        $course = Course::firstWhere("stripe_id", $id);
        $author = User::find($course->author->id);
        $price = $course->price;
        $author->add($price);
        
        Transfer::create([
            'amount' => $course->price * 100,
            'currency' => 'usd',
            'destination' => $author->stripe_account_id,
            'transfer_group' => 'ORDER_95',
        ]);
        
        $author->transactions()->create([
            "transaction_id" => "TX" . Str::upper(Str::random(4)) . time(),
            "amount" => $price,
            "transaction_type" => 1
        ]);

        $purchase = $user->purchases()->create([
            "purchase_product_id" => $id  
        ]);
        $purchase->course->tracker()->create([
            "tracking" => "[]",
            "user_id" => $user->id,
            "progress" => 0,
            "status" => 1
        ]);

        
        return redirect()->to(route("home"))->with("flash", "You haved purchased your course!");
    }
    public function cancel() {

    }
}
