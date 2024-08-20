<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function getIndex(){
        return view('landing-page.index');
    }
}
