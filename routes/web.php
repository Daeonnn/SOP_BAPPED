<?php

use App\Http\Controllers\BidangController;
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

Route::get('/bidang', [BidangController::class, 'index'])->name('bidang.index');
Route::post('/bidang', [BidangController::class, 'store'])->name('bidang.store');
Route::put('/bidang/update/{id}', [BidangController::class, 'update'])->name('bidang.update');
Route::delete('/bidang/delete/{id}', [BidangController::class, 'destroy'])->name('bidang.destroy');

Route::get('/sub_bidang', [SubBidangController::class, 'index'])->name('sub_bidang.index');
Route::post('/sub_bidang', [SubBidangController::class, 'store'])->name('sub_bidang.store');
Route::put('/sub_bidang/update/{id}', [SubBidangController::class, 'update'])->name('sub_bidang.update');
Route::delete('/sub_bidang/delete/{id}', [SubBidangController::class, 'destroy'])->name('sub_bidang.destroy');

require __DIR__.'/auth.php';
