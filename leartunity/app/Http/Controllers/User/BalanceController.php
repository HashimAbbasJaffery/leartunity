<?php

namespace App\Http\Controllers\User;

use App\Classes\DateCalculator;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Classes\CurrencyExchanger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function get(User $user, CurrencyExchanger $exchanger, DateCalculator $dateCalculator) {
        $currency = (User::find(auth()->id()))->currency;
        $unit = $currency->unit;
        $currency = $currency->currency;
        $exchange_rate = $exchanger->rate($currency);
        $user->balance *= $exchanger->rate($currency);
        $balance = $user->balance;

        $today = Carbon::now();
        $lastMonth = $dateCalculator->getDate($today);
        $last_month_trx = Transaction::whereMonth("created_at", $lastMonth[0])
                                    ->whereYear("created_at", $lastMonth[1])->sum("amount");

        $this_month_trx = Transaction::whereMonth("created_at", $today->month)
                                    ->whereYear("created_at", $today->year)->sum("amount");
        dd(($this_month_trx / $last_month_trx) * 100 - 100);
        $profit_percentage = number_format(($this_month_trx / $last_month_trx) * 100, 0);
        return view("User.Balance.index", compact("balance", "unit", "user", "exchange_rate", "profit_percentage"));
    }
}
