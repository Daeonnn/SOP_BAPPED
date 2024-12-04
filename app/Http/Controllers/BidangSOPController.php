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
        $bidang = Bidang::findOrFail($id);

        // Ambil subBidang yang terkait dengan Bidang ini
        $subBidangList = $bidang->subBidangs;

        // Ambil SOP yang terkait dengan Bidang ini, hanya berdasarkan bidang_id
        $sops = CoverSop::where('bidang_id', $id)->get();

        return view('pages.bidang.index', compact('bidang', 'sops', 'subBidangList'));
    }



    public function create($sop_id)
    {
        // Load SOP with its associated subBidang and bidang (if available)
        $sop = CoverSop::with('subBidang.bidang')->findOrFail($sop_id);

        // Ensure subBidang and bidang are available
        $subBidang = $sop->subBidang; // Get the sub-bidang if it exists
        $bidang = null;

        if ($subBidang) {
            $bidang = $subBidang->bidang; // If subBidang exists, get bidang
        }

        return view('pages.cover_sop', compact('sop', 'subBidang', 'bidang')); // Send data to view
    }
}
