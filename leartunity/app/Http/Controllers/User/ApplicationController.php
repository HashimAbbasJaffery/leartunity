<?php

namespace App\Http\Controllers\User;

use App\Enums\ApplicationStatus;
use App\Enums\Qualification;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index() {
        $qualifications = Qualification::toAssoc();
        $user = User::find(auth()->id());
        $application = $user->application;
        return Inertia::render("Application/Index", compact("qualifications", "application"));
    }
    public function store(ApplicationRequest $request) {
        $user = User::find(auth()->id());

        $user->application()->create($request->validated());
    }
    public function update(ApplicationRequest $request) {
        $user = User::find(auth()->id());
        dd($request->validated());
        $application = $user->application;
        $remaining_days = now()->diff($application->cooldown_till);

        if($application->status !== 2) return;

        // Cooldown is still not finished!
        if($remaining_days->d !== 0 && $remaining_days->invert !== 1) return;

        $user->application()->update([...$request->except("read_conditions"), "status" => 0]);
    }
}
