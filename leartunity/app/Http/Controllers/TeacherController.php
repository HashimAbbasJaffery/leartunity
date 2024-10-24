<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class TeacherController extends Controller
{
    public function index() {
        $teachers = User::with(["courses"])->where("role", Roles::INSTRUCTOR->value)->paginate(9)->withQueryString();
        if(request()->expectsJson()) return $teachers;
        return Inertia::render("Teacher", compact("teachers"));
    }
}
