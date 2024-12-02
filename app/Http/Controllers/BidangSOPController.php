<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\CoverSop;
use Illuminate\Http\Request;

class BidangSOPController extends Controller
{
    public function index($id)
    {
        // Mendapatkan bidang berdasarkan id
        $bidang = Bidang::findOrFail($id);

        $sops = CoverSop::whereHas('subBidang', function ($query) use ($id) {
            $query->where('bidang_id', $id); // Asumsi subBidang memiliki 'bidang_id'
        })->get();

        // Tampilkan data ke view
        return view('pages.bidang.index', compact('bidang', 'sops'));
    }

}
