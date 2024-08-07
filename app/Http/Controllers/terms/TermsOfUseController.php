<?php

namespace App\Http\Controllers\terms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermsOfUseController extends Controller
{
    //
    public function index()
    {
        return view('frontend.terms-of-use.view');
    }
}
