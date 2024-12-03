<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\CoverSop;
use App\Models\Sub_Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BidangSOPController extends Controller
{
    public function index($id)
    {
        Log::info('Bidang ID: ' . $id);
        $bidang = Bidang::findOrFail($id);

        $sops = CoverSop::whereHas('subBidang', function ($query) use ($id) {
            $query->where('bidang_id', $id);
        })->get();

        // Tampilkan data ke view
        return view('pages.bidang.index', compact('bidang', 'sops'));
    }

    public function create($id)
    {
        // Mendapatkan data bidang berdasarkan id
        $bidang = Bidang::findOrFail($id);

        // Mendapatkan data subBidang terkait
        $subBidangs = Sub_Bidang::where('bidang_id', $id)->get();

        // Tampilkan form tambah SOP
        return view('pages.bidang.create', compact('bidang', 'subBidangs'));
    }
}

