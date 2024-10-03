<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Swatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index() {
        $setting = Setting::first();
        $swatches = Swatch::all();

        return Inertia::render("Admin/Settings/Index", [
            "setting" => $setting,
            "swatches" => $swatches
        ]);
    }
    public function update(Request $request) {
        $setting = (Setting::first())->update($request->all());
        return 1;
    }
}
