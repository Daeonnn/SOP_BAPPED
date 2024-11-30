<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\BidangModels;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function index()
    {
        $bidang = Bidang::all(); // Gunakan huruf kecil
        return view('pages.bidang', compact('bidang')); // Konsisten dengan nama variabel
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bidang = new Bidang();
        $bidang->name = $request->name;
        $bidang->save();

        return redirect()->back()->with('success', 'Bidang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bidang = Bidang::findOrFail($id);
        $bidang->name = $request->name;
        $bidang->save();

        return redirect()->back()->with('success', 'Bidang berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $bidang = Bidang::findOrFail($id);
        $bidang->delete();

        return redirect()->back()->with('success', 'Bidang berhasil dihapus!');
    }

}
