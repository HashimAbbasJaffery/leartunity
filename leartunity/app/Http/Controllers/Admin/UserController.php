<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Models\User;
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
    public function store(Request $request) {
        $validation = \Illuminate\Support\Facades\Validator::make($request->all(), [
            "name" => ["required"],
            "password" => [ "required", "confirmed" ],
            "email" => [ "required", "email", "unique:users,email" ]
        ]);
        $attributes = [
            ...$validation->validated(),
            'ip_address' => $request->ip(),
        ];
        $user = User::create($attributes);
        event(new Registered($user));


        return to_route("login");
    } 
    public function changeCurrency(User $user) {
        $currency = request()->get("currency");
        $user->currency_id = $currency;
        $user->save();
        return 1;
    }
}
