<?php

namespace App\Http\Controllers;
use App\Models\Sub_Bidang;

use Illuminate\Http\Request;

class SubBidangController extends Controller
{
    public function index()
    {
        $sub_bidang = Sub_Bidang::all(); // Mengambil semua data SOP
        return view('pages.sub_bidang', compact('sub_bidang')); // Menampilkan view 'sops.index'
    }
}
