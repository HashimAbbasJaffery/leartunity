<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index() {
        $user = User::find(auth()->id());
        $isAllowed = false;
        if(!$user->application) $isAllowed = true;
        $now = \Carbon\Carbon::now();
        $cooldownEnd = \Carbon\Carbon::parse($user->application->updated_at)->addMonth();
        if($user->application->status === 3 && $now->greaterThanOrEqualTo($cooldownEnd)) $isAllowed = true;
        $application = $user->application;
        return view("User.Application.apply", compact("isAllowed", "application"));
    }
    public function store(ApplicationRequest $request) {
        $user = User::find(auth()->id());
        $file = $request->file("supporting-file");
        $fileName = time() . $file->getClientOriginalName();
        $file->storePubliclyAs("documents", $fileName);
        

        // Submitting the application 
        $user->application()->updateOrCreate(
            ["user_id" => auth()->id()],
            [
                ...$request->validated(),
                "supporting_file" => $fileName
            ]
        );


        return back();
    }
}
