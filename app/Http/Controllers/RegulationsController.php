<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegulationsController extends Controller
{
    public function regulations(){
        return view('regulations');
    }

    public function privacy_policy(){
        return view('privacy_policy');
    }
}
