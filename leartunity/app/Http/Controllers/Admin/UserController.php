<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
