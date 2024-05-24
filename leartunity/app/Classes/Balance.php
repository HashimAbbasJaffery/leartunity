<?php 

namespace App\Classes;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;
use Stripe\Transfer;


trait Balance {
    public function add(User $user, $amount) {
        $purchases_count = $user->purchases->count();
        $referrer = $user->referrer;
        $referral_share = 0;
        
        if($purchases_count === 1 && $referrer->exists()) {
            $amount--;
            $referral_share++;

            $referrer->balance += $referral_share;
            $referrer->save();
           
            Transfer::create([
                'amount' => $referral_share * 100,
                'currency' => 'usd',
                'destination' => $user->referrer->stripe_account_id,
                'transfer_group' => 'ORDER_95',
            ]);            
        } 

        $this->balance += $amount;
        $this->save();

        $trx = new Transaction();
        $trx->amount = $amount;
        $trx->transaction_type = 1;
        $trx->transaction_id = "TX" . Str::upper(Str::random(4)) . time();
        $trx->user_id = $this->id;
        $trx->save();
        
 
        Transfer::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'destination' => $this->stripe_account_id,
            'transfer_group' => 'ORDER_95',
        ]);
    }
    public function get() {
        return $this->balance;
    }
}