<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlowchartController extends Controller
{
   public function index()
    {

        // Kirim data ke Blade Template
        return view('pages.flowchart');
    }
}
