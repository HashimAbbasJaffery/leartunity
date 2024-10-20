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
use Illuminate\Support\Facades\Storage;
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

        $fileName = null;
        if($request->hasFile("supporting_file")) {
            $file = $request->file("supporting_file");
            $fileName = time() . "." . $file->extension();
            Storage::disk("local")->putFileAs("documents", $file, $fileName);
        }

        $user->application()->create([...$request->validated(), "supporting_file" => $fileName]);
    }
    public function update(ApplicationRequest $request) {
        $user = User::find(auth()->id());
        $application = $user->application;
        $remaining_days = now()->diff($application->cooldown_till);

        if($application->status !== 2) return;

        // Cooldown is still not finished!
        if($remaining_days->invert !== 1) return;

        $fileName = null;
        if($request->hasFile("supporting_file")) {
            Storage::disk("local")->delete("documents/$application->supporting_file");
            $file = $request->file("supporting_file");
            $fileName = time() . "." . $file->extension();
            Storage::disk("local")->putFileAs("documents", $file, $fileName);
        }

        $user->application()->update([...$request->except("read_conditions", "_method"), "status" => 0, "supporting_file" => $fileName, "cooldown_till" => null]);
    }
}
