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
        $flag = false; // This Flag Determines that whether the result requires some attribute from the relationship
        $path = "profile.profile_pic"; // It provides the Database column location, '.' represents that column is inside relationship
        $directories = "/profile/"; // It provides the directory path
        $url = "/profile";
        $findingColumn = "id";

        if($type === "course") {
            $table = "courses";
            $column = "title";
            $flag = true;
            $findingColumn = "slug";
            $path = "thumbnail";
            $directories = "/course/";
            $url = "/course";
        }
        if($type === "categories") {
            $table = "categories";
            $column = "category";
            $flag = true;
            $path = "";
            $directories = "";
            $findingColumn = "";
        }

        if($flag) {
            $result = DB::table($table)->where($column, "like", "%$keyword%")->whereStatus(1)->limit(10)->get();
        } else {
            $result = User::with("profile")->where($column, "like", "%$keyword%")->whereStatus(1)->limit(10)->get();
        }
        return [$column, $result, $path, $directories];
    }
}
