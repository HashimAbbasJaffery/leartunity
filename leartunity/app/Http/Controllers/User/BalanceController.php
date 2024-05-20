<?php

namespace App\Http\Controllers\User;

use App\Classes\DateCalculator;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Classes\CurrencyExchanger;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Transfer;

class BalanceController extends Controller
{
    public function get(User $user, CurrencyExchanger $exchanger, DateCalculator $dateCalculator) {
        $currency = (User::find(auth()->id()))->currency;
        $unit = $currency->unit;
        $currency = $currency->currency;
        $exchange_rate = $exchanger->rate($currency);
        $user->balance *= $exchanger->rate($currency);
        $balance = $user->balance;

        return view("User.Balance.index", compact("balance", "unit", "user", "exchange_rate"));
    }

    public function add() {
        if(request()->method() === "POST") {
            $amount = (int)request()->get("fund-amount");
            $fee = 3;
            $currency = (User::find(auth()->id()))->currency->currency;
            $amount -= (($amount * $fee) / 100);
            
            Stripe::setApiKey(env("STRIPE_SECRET"));
            try {

                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => $currency,
                            'product_data' => [
                                'name' => 'Wallet Funds',
                            ],
                            'unit_amount' => ($amount * 100), // Amount in cents ($20.00)
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('user.add-fund.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('checkout-cancel'),
                ]);

                return redirect($session->url, 303);
                
            } catch(Exception $e) {
                dd($e);
            }
        } else {
            $unit = (User::find(auth()->id()))->currency->unit;
            return view("User.Balance.add", compact("unit"));
        }
    }
    public function success_fund_transfer(Request $request) {
        Stripe::setApiKey(env("STRIPE_SECRET"));
        $session = Session::retrieve($request->get("session_id"));
        $amount = ((float)$session->amount_total) / 100;
        
        $user = User::find(auth()->id());
        $currency = \App\Helpers\exchange_rate($user->currency->currency);
        $usd_amount = $amount / $currency;
        
        $user->add($usd_amount);

        return to_route("user.balance", ["user" => auth()->id()]);
    }

}
