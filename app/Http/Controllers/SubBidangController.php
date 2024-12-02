<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Sub_Bidang;

use Illuminate\Http\Request;

class SubBidangController extends Controller
{
    public function index()
    {
        $sub_bidang = Sub_Bidang::all();
        $bidangList = Bidang::all();
        return view('pages.sub_bidang', compact('sub_bidang', 'bidangList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidang,id',
        ]);

        Sub_Bidang::create([
            'name' => $request->input('name'),
            'bidang_id' => $request->input('bidang_id'),
        ]);

        return redirect()->back()->with('success', 'Sub Bidang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidang,id',
        ]);

        $sub_bidang = Sub_Bidang::findOrFail($id);

        $sub_bidang->update([
            'name' => $request->input('name'),
            'bidang_id' => $request->input('bidang_id'),
        ]);

        return redirect()->back()->with('success', 'Sub Bidang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sub_bidang = Sub_Bidang::findOrFail($id);

        $sub_bidang->delete();

        return redirect()->back()->with('success', 'Sub Bidang berhasil dihapus.');
    }
}
