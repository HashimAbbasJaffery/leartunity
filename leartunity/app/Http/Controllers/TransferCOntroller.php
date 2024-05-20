<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferCOntroller extends Controller
{
   public function transfer() {
    return view("Transfer.index");
   } 
}
