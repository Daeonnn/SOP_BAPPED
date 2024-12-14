<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Sop;  // Pastikan model Sop diimport
use App\Models\CoverSop;

class PdfController extends Controller
{
    public function generatePdf(Request $request, $id = null)
{
    // Validasi input yang dikirim melalui form
    $request->validate([
        'no_sop' => 'nullable',
        'tgl_pembuatan' => 'nullable',
        'tgl_revisi' => 'nullable',
        'tgl_aktif' => 'nullable',
        'nama_sop' => 'nullable',
        'dasar_hukum' => 'nullable',
        'kualifikasi_pelaksana' => 'nullable',
        'keterkaitan' => 'nullable',
        'perlengkapan' => 'nullable',
        'peringatan' => 'nullable',
        'pencatatan' => 'nullable',
    ]);

    // Ambil data SOP berdasarkan ID atau kondisi lain
    $cover_sop = CoverSop::find($id);  // Pastikan id dikirimkan dalam request
    if (!$cover_sop) {
        abort(404, 'SOP not found');
    }

    // Ambil data SubBidang berdasarkan sub_bidang_id di SOP
    $subBidang = $cover_sop->subBidang; // Menggunakan relasi yang sudah didefinisikan

    // Data untuk PDF
    $data = [
        'no_sop' => $request->no_sop,
        'tgl_pembuatan' => $request->tgl_pembuatan,
        'tgl_revisi' => $request->tgl_revisi,
        'tgl_aktif' => $request->tgl_aktif,
        'nama_sop' => $request->nama_sop,
        'dasar_hukum' => $request->dasar_hukum,
        'kualifikasi_pelaksana' => $request->kualifikasi_pelaksana,
        'keterkaitan' => $request->keterkaitan,
        'perlengkapan' => $request->perlengkapan,
        'peringatan' => $request->peringatan,
        'pencatatan' => $request->pencatatan,
        'subBidang' => $subBidang, // Sertakan data subBidang
        'bidang' => $cover_sop->bidang, // Sertakan data bidang
    ];

    // Menggunakan view untuk generate PDF
    $pdf = PDF::loadView('sop.pdf', $data);

    // Download PDF
    return $pdf->download('sop_data.pdf');
}

}
