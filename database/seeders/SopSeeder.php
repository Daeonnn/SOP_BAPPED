<?php

namespace Database\Seeders;

use App\Models\CoverSop;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoverSop::create([
            'name' => 'SOP 1',
            'dasar_hukum' => 'Undang-Undang No. 1 Tahun 2020',
            'keterkaitan' => 'Prosedur keamanan jaringan',
            'peringatan' => 'Harap berhati-hati saat mengakses data sensitif',
            'no_sop' => 'SOP-001',
            'tgl_pembuatan' => Carbon::create('2023', '01', '01'),
            'tgl_revisi' => Carbon::create('2024', '01', '01'),
            'tgl_aktif' => Carbon::create('2024', '01', '01'),
            'kualifikasi_pelaksana' => 'Lulusan Teknik Informatika',
            'perlengkapan' => 'Laptop, akses internet, software keamanan',
            'pencatatan' => 'Catatan log akses',
            'sub_bidang_id' => 1,  // Sesuaikan dengan sub_bidang_id yang ada
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
