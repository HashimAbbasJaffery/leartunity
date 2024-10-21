<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Enums\Qualification;
use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Response;

class ApplicationController extends Controller
{
    public function index() {
        $applications = Application::where("status", ApplicationStatus::PENDING->value)
                                    ->paginate(1)
                                    ->withQueryString();
        if(request()->expectsJson()) return $applications;
        return Inertia::render("Admin/Application/Index", compact("applications"));
    }
    public function show(Application $application) {
        return Inertia::render("Admin/Application/Show", compact("application"));
    }
    public function file_download($file_name) {
        return Response::download(storage_path("app/documents/$file_name"));
    }
    public function approve(Application $application) {
        $application->status = 1;
        $application->save();

        $application->user()->update([
            "role" => "instructor"
        ]);

        return redirect()->to(route("application"));
    }
    public function reject(Application $application) {
        $application->status = 2;
        $application->cooldown_till = now()->addMonths(3);
        $application->save();

        return redirect()->to(route("application"));
    }
}
