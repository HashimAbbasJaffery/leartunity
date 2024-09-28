<?php

namespace App\Http\Controllers\Admin;

use App\Classes\StripeAccountCreate;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Models\User;
use App\Notifications\MessageNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->keyword;
        $users = User::where("name", "like", "%$keyword%")->where("id", "!=", auth()->id())->paginate(8)->withQueryString();
        return view("Admin.users", compact("users", "keyword"));
    }
    public function edit(Request $request, User $user) {
        $context = $request->context;

        $user->status = $context;
        $user->save();

        return 1;
    }
    public function banManager(Request $request, User $user) {
        $context = $request->context;

        if($context) {
            $user->ban();
        } else {
            $user->unban();
        }

        return 1;
    }
    public function store(Request $request, StripeAccountCreate $stripeAccount) {
        $referral_id = null;
        $referred_by = User::find($request->referred_by);
        $referral_exists = $referred_by?->exists();
        if($request->referred_by && $referral_exists) {
            $referral_id = $request->referred_by;
        }
        $validation = \Illuminate\Support\Facades\Validator::make($request->all(), [
            "name" => ["required"],
            "password" => [ "required", "confirmed" ],
            "email" => [ "required", "email", "unique:users,email" ]
        ]);
        $stripe_account_id = $stripeAccount->create();
        $attributes = [
            ...$validation->validated(),
            'ip_address' => $request->ip(),
            "referred_by" => $referral_id,
            "stripe_account_id" => $stripe_account_id
        ];
        $user = User::create($attributes);
        event(new Registered($user));
        $message = __("Ding, ding, ding! ") . $user->name . __(" is your new referral!");

        if($referral_id) {
            $referred_by->notify(new MessageNotification($message));
            NotificationEvent::dispatch($referred_by->id, $message);
        }

        return to_route("login");
    }
    public function changeCurrency(User $user) {
        $currency = request()->get("currency");
        $user->currency_id = $currency;
        $user->save();
        return $user;
    }
}
