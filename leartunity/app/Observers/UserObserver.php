<?php

namespace App\Observers;
use App\Models\User;

class UserObserver
{
    public function created(User $user) {
        $user->profile()->create([
            "follows" => 0
        ]);
    }
}
