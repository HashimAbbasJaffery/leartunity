<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function update(Request $request) {
        $content = $request->quote;
        $quote = Quote::find(1);
        $quote->update([
            "quote" => $content
        ]);

    }
}
