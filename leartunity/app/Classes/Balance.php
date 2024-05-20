<?php 

namespace App\Classes;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Balance {
    public function add($amount) {
        $this->balance += $amount;
        $this->save();

        $trx = new Transaction();
        $trx->amount = $amount;
        $trx->transaction_type = 1;
        $trx->transaction_id = "TX" . Str::upper(Str::random(4)) . time();
        $trx->user_id = $this->id;
        $trx->save();
    }
    public function get() {
        return $this->balance;
    }
}