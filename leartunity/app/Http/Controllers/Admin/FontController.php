<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class FontController extends Controller
{
    public function update(Request $request) {
        $setting = (Setting::first())->update($request->all());
        return 1;
    }
}
