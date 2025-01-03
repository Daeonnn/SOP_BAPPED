<?php

use App\Http\Controllers\BidangController;
use App\Http\Controllers\BidangSOPController;
use App\Http\Controllers\CoverSopController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SOPController;
use App\Http\Controllers\SubBidangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/sop', [SopController::class, 'index'])->name('sop.index');
Route::post('/sop', [SopController::class, 'store'])->name('sop.store');
Route::get('/sops/{id}/edit', [SopController::class, 'edit'])->name('sops.edit');
Route::post('/sops/{id}', [SopController::class, 'update'])->name('sops.update');
Route::delete('/sops/{id}', [SopController::class, 'destroy'])->name('sops.destroy');
Route::get('sop/export', [SopController::class, 'export'])->name('sops.export');

Route::get('/pengaturan/bidang', [BidangController::class, 'index'])->name('setting_bidang.index');
Route::post('/pengaturan/bidang', [BidangController::class, 'store'])->name('setting_bidang.store');
Route::put('/pengaturan/bidang/update/{id}', [BidangController::class, 'update'])->name('setting_bidang.update');
Route::delete('/pengaturan/bidang/delete/{id}', [BidangController::class, 'destroy'])->name('setting_bidang.destroy');

Route::get('/sub_bidang', [SubBidangController::class, 'index'])->name('sub_bidang.index');
Route::post('/sub_bidang', [SubBidangController::class, 'store'])->name('sub_bidang.store');
Route::put('/sub_bidang/update/{id}', [SubBidangController::class, 'update'])->name('sub_bidang.update');
Route::delete('/sub_bidang/delete/{id}', [SubBidangController::class, 'destroy'])->name('sub_bidang.destroy');

Route::get('/cover_sop', [CoverSopController::class, 'index'])->name('cover_sop.index');
Route::post('/cover_sop/store', [CoverSopController::class, 'store'])->name('cover_sop.store');
Route::get('/cover_sop/edit/{sop_id}', [CoverSopController::class, 'edit'])->name('cover_sop.edit');
Route::put('/cover_sop/update/{id}', [CoverSopController::class, 'update'])->name('cover_sop.update');




Route::get('/pilih-sub-bidang', [CoverSopController::class, 'indexPilihSubBidang'])->name('pilih_sub_bidang.index');
Route::post('/submit-sop', [CoverSopController::class, 'submitSop'])->name('sop.form');


Route::get('/bidang/{id}', [BidangSOPController::class, 'index'])->name('bidang.index');
Route::get('/bidang/create/{id}', [BidangSOPController::class, 'create'])->name('bidang.create');



require __DIR__.'/auth.php';
