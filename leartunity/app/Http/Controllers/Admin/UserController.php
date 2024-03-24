<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUserRequest;
use App\Models\User;
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
            "email" => [ "required", "email" ]
        ]);
        $attributes = [
            ...$validation->validated(),
            'ip_address' => $request->ip(),
        ];
        User::create($attributes);


        return to_route("login");
    } 
}
