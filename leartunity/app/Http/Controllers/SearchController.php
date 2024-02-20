<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class SearchController extends Controller
{
    public function get() {
        $keyword = request()->get("query");
        $type = request()->get("type");

        $table = "users";
        $column = "name";
        $flag = false;
        $path = "profile.profile_pic";
        $directories = "/profile/";

        if($type === "course") {
            $table = "courses";
            $column = "title";
            $flag = true;
            $path = "thumbnail";
            $directories = "/course/";
        }
        if($type === "categories") {
            $table = "categories";
            $column = "category";
            $flag = true;
            $path = "";
            $directories = "";
        }
        
        if($flag) {
            $result = DB::table($table)->where($column, "like", "%$keyword%")->whereStatus(1)->limit(10)->get();
        } else {
            $result = User::with("profile")->where($column, "like", "%$keyword%")->whereStatus(1)->limit(10)->get();
        }
        return [$column, $result, $path, $directories];
    }
}
