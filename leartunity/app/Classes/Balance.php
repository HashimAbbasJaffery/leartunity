<?php 

namespace App\Classes;
use Illuminate\Database\Eloquent\Builder;
trait Balance {
    public function add($amount) {
        $this->balance += $amount;
        $this->save();
    }
    public function get() {
        return $this->balance;
    }
}