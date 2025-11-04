<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuidesController extends Controller
{
    public function index()
    {
        return view('guide.dashboard');
    }
}
