<?php 

namespace App\Services;
use App\Models\User;

class StreakService {
    public function checkAndUpdate(User $user) {
        $last_login = \Carbon\Carbon::parse((auth()->user()->last_login));
        $diff_login_in_hrs = \Carbon\Carbon::now()->diffInHours($last_login);

        // Fillin the attribute of last_login when user logs in after 24 hours
        // Or if the user has never loggedin 

        if(is_null($user->last_login)) { // If the user is new and never logged in yet
            $user->last_login = \Carbon\Carbon::now();
            $user->save();
        }

        if(($diff_login_in_hrs >= 24 && $diff_login_in_hrs <= 48)) { // User using in the system after a day
            $user->update([
                "last_login" => \Carbon\Carbon::now(),
                "streak" => $user->streak++
            ]);
        }

        if($diff_login_in_hrs > 48) { // User Missed the streak
            $user->update([
                "last_login" => \Carbon\Carbon::now(),
                "streak" => 1
            ]);
        }

    }
}