<?php 

namespace App\Classes;
use App\Models\User;
class Points {
    public function add(User $user, float $points) {
        $user->lts_points = $user->lts_points + $points;
        $user->save();
    }
    public function deduct(User $user, float $points) {
        $user->limit_points = $user->limit_points - $points;
        $user->save();
        return $user;
    }
    public function balance(User $user) {
        return $user->lts_points;
    }
}