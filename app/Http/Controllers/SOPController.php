<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use App\Models\Sop;
use Illuminate\Http\Request;
use App\Exports\SopExport;
use Maatwebsite\Excel\Facades\Excel;

class SOPController extends Controller
{

    public function index()
    {
        $sops = Sop::all(); // Mengambil semua data SOP
        return view('pages.sop', compact('sops')); // Menampilkan view 'sops.index'
    }

    public function destroy($id)
    {
        $sop = Sop::findOrFail($id);
        $sop->delete();
        return redirect()->route('sop.index')->with('success', 'SOP berhasil dihapus.');
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255|unique:sops,nomor_sk',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'hasil_monitoring' => 'nullable|in:penghapusan,revisi,penggabungan,penambahan',
            'tahun_perubahan' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'keterangan' => 'nullable|string',
            'file_sk' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file_sk')) {
            $filePath = $request->file('file_sk')->store('file_sk', 'public'); // Simpan file ke storage/public/file_sk
            $validatedData['file_sk'] = $filePath;
        }

        Sop::create($validatedData);

        return redirect()->route('sop.index')->with('success', 'SOP berhasil disimpan.');
    }

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'nomor_sk' => 'required|string|max:255|unique:sops,nomor_sk,' . $id,
        'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        'hasil_monitoring' => 'required|in:penghapusan,revisi,penggabungan,penambahan',
        'tahun_perubahan' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        'keterangan' => 'nullable|string',
        'file_sk' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $sop = Sop::findOrFail($id);

    if ($request->hasFile('file_sk')) {
        $filePath = $request->file('file_sk')->store('file_sk', 'public');
        $validatedData['file_sk'] = $filePath;
    }

    $sop->update($validatedData);

    return redirect()->route('sop.index')->with('success', 'SOP berhasil diperbarui.');
}

public function export()
{
    return Excel::download(new SopExport, 'sops.xlsx'); // Mengunduh file Excel dengan nama sops.xlsx
}

}
