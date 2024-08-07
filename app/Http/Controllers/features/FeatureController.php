<?php

namespace App\Http\Controllers\features;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    //
    public function index()
    {
        return view('frontend.features.view');
    }
}
