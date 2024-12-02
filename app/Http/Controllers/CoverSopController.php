<?php

namespace App\Http\Controllers;

use App\Models\CoverSop;
use App\Models\Sub_Bidang;
use Illuminate\Http\Request;

class CoverSopController extends Controller
{
    public function index()
    {
        // Ambil semua sub_bidang
        $sub_bidangList = Sub_Bidang::all();

        return view('pages.cover_sop', compact('sub_bidangList'));
    }



    public function indexPilihSubBidang()
    {
        $sub_bidangList = Sub_Bidang::all();

        return view('pages.pilih_sub_bidang', compact('sub_bidangList'));
    }

    public function submitSop(Request $request)
    {
        // Ambil sub_bidang_id yang dipilih
        $sub_bidang_id = $request->input('sub_bidang');

        // Ambil data sub_bidang beserta bidang terkait
        $subBidang = Sub_Bidang::with('bidang')->find($sub_bidang_id);

        // Pass data bidang dan sub_bidang ke view atau ke halaman berikutnya
        return view('pages.cover_sop', compact('subBidang'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'no_sop' => 'required|string|max:255',
            'tgl_pembuatan' => 'required|date',
            'tgl_revisi' => 'nullable|date',
            'tgl_aktif' => 'required|date',
            'disahkan_oleh' => 'nullable|string',
            'nama_sop' => 'required|string|max:255',
            'dasar_hukum' => 'nullable|string',
            'kualifikasi_pelaksana' => 'nullable|string',
            'keterkaitan' => 'nullable|string',
            'peralatan' => 'nullable|string',
            'peringatan' => 'nullable|string',
            'pencatatan' => 'nullable|string',
            'sub_bidang_id' => 'required|integer|exists:sub_bidang,id', // Pastikan ID bidang ada dalam tabel terkait
        ]);

        // Menyimpan data ke dalam tabel SOP
        $sop = new CoverSop();
        $sop->name = $request->nama_sop;
        $sop->dasar_hukum = $request->dasar_hukum;
        $sop->keterkaitan = $request->keterkaitan;
        $sop->peringatan = $request->peringatan;
        $sop->no_sop = $request->no_sop;
        $sop->tgl_pembuatan = $request->tgl_pembuatan;
        $sop->tgl_revisi = $request->tgl_revisi;
        $sop->tgl_aktif = $request->tgl_aktif;
        $sop->kualifikasi_pelaksana = $request->kualifikasi_pelaksana;
        $sop->perlengkapan = $request->peralatan;
        $sop->pencatatan = $request->pencatatan;
        $sop->sub_bidang_id = $request->sub_bidang_id; // Pastikan ID sub_bidang valid
        $sop->save();

        // Redirect atau mengembalikan response setelah berhasil menyimpan
        return redirect()->route('cover_sop.index')->with('success', 'Data SOP berhasil disimpan!');
    }
}
