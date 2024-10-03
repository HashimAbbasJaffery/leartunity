<?php

namespace App\Http\Controllers;

use App\Models\Swatch;
use Illuminate\Http\Request;

class SwatchController extends Controller
{
    public function store(Request $request) {
        $swatch = Swatch::where("hexColor", $request->hexColor)->exists();
        if($swatch) return redirect()->back();

        $swatch = Swatch::create($request->all());

        return $swatch;
    }
}
