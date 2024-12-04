<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\CoverSop;
use App\Models\Pelaksana;
use App\Models\Sop;
use App\Models\Sub_Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CoverSopController extends Controller
{
    public function index()
    {
        $subBidang = session('subBidang');  // Mengambil data subBidang dari session
        $subBidangList = Sub_Bidang::all();

        return view('pages.cover_sop', compact('subBidang', 'subBidangList'));
    }




    public function indexPilihSubBidang()
    {
        $sub_bidangList = Sub_Bidang::all();

        return view('pages.pilih_sub_bidang', compact('sub_bidangList'));
    }

    public function submitSop(Request $request)
    {
        // Mendapatkan sub_bidang_id yang dipilih
        $sub_bidang_id = $request->input('sub_bidang');
        $subBidang = Sub_Bidang::with('bidang')->find($sub_bidang_id);

        // Cek jika subBidang ada
        if (!$subBidang) {
            return redirect()->route('cover_sop.index')->with('error', 'Sub Bidang tidak ditemukan.');
        }

        // Menyimpan data subBidang ke dalam session
        session(['subBidang' => $subBidang]);

        // Redirect ke halaman cover_sop dengan data subBidang
        return redirect()->route('cover_sop.index');
    }



    public function store(Request $request)
    {
        // Debugging: Tampilkan data request untuk memastikan bidang_id ada
        Log::info('Bidang ID yang diterima: ' . $request->bidang_id);

        // Validasi input
        $request->validate([
            'no_sop' => 'required|string',
            'nama_sop' => 'required|string',
            'tgl_pembuatan' => 'required|date',
            'pelaksana' => 'nullable|array',
            'pelaksana.*' => 'nullable|string',
            'sub_bidang_id' => 'nullable|exists:sub_bidang,id', // Validasi sub_bidang_id jika ada
        ]);

        // Ambil bidang dan sub_bidang dari request
        $bidangId = $request->bidang_id;  // Ambil bidang_id yang diterima
        $subBidangId = $request->sub_bidang_id; // Ambil sub_bidang_id yang diterima

        // Debugging: Pastikan nilai bidang_id dan sub_bidang_id terambil dengan benar
        Log::info('Bidang ID: ' . $bidangId);
        Log::info('Sub Bidang ID: ' . $subBidangId);

        // Pastikan sub_bidang_id terpilih jika ada
        if ($subBidangId) {
            $subBidang = Sub_Bidang::find($subBidangId);
            if (!$subBidang || $subBidang->bidang_id != $bidangId) {
                return redirect()->back()->withErrors(['sub_bidang_id' => 'Sub Bidang tidak valid untuk Bidang ini.']);
            }
        }

        // Simpan data ke tabel cover_sop
        $coverSop = CoverSop::create([
            'name' => $request->nama_sop,
            'no_sop' => $request->no_sop,
            'tgl_pembuatan' => $request->tgl_pembuatan,
            'bidang_id' => $bidangId,  // Pastikan bidang_id disertakan
            'sub_bidang_id' => $subBidangId,
            'status' => 'Perlu Dilengkapi',
        ]);

        // Simpan data pelaksana jika ada
        if ($request->pelaksana) {
            foreach ($request->pelaksana as $pelaksanaName) {
                if (!empty($pelaksanaName)) {
                    Pelaksana::create([
                        'name' => $pelaksanaName,
                        'cover_sop_id' => $coverSop->id,
                    ]);
                }
            }
        }

        // Redirect ke halaman yang sesuai
        return redirect()->route('bidang.index', ['id' => $bidangId])
            ->with('success', 'Data SOP berhasil ditambahkan!');
    }

    // Edit method to show the form
    public function edit($id)
    {
        $sop = CoverSop::findOrFail($id);
        $bidang = Bidang::find($sop->bidang_id);  // Assuming this relationship exists
        $subBidang = Sub_Bidang::find($sop->sub_bidang_id); // Assuming this relationship exists
        return view('pages.cover_sop', compact('sop', 'bidang', 'subBidang'));
    }

    // Update method to handle form submission
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_sop' => 'required',
            'tgl_pembuatan' => 'required',
            'tgl_revisi' => 'nullable',
            'tgl_aktif' => 'nullable',
            'nama_sop' => 'required',
            'dasar_hukum' => 'required',
            'kualifikasi_pelaksana' => 'required',
            'keterkaitan' => 'required',
            'perlengkapan' => 'required',
            'peringatan' => 'required',
            'pencatatan' => 'required',
        ]);

        // Temukan SOP berdasarkan ID
        $sop = CoverSop::findOrFail($id);

        // Set status menjadi 'Menunggu' sebelum update
        $sop->status = 'Menunggu';

        // Update data SOP
        $sop->update($request->all());

        // Redirect ke halaman edit dengan pesan sukses
        return redirect()->route('cover_sop.edit', $id)->with('success', 'SOP updated successfully');
    }
}
