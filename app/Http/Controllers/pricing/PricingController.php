<?php

namespace App\Http\Controllers\pricing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    //
    public function index()
    {
        return view('frontend.pricing.view');
    }
}
