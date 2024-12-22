<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\CoverSop;
use App\Models\Sub_Bidang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePdf($id)
    {
        // Ambil data SOP berdasarkan ID
        $sop = CoverSop::findOrFail($id);
        $bidang = Bidang::find($sop->bidang_id); // Ambil bidang terkait
        $subBidang = Sub_Bidang::find($sop->sub_bidang_id); // Ambil sub bidang terkait

        // Render PDF menggunakan tampilan Blade
        $pdf = Pdf::loadView('pages.pdf.template', compact('sop', 'bidang', 'subBidang'));

        // Unduh atau tampilkan PDF
        return $pdf->download('cover_sop_' . $sop->no_sop . '.pdf');
    }
}
