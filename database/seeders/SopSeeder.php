<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sop;
use Faker\Factory as Faker;

class SopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Membuat 15 data SOP secara otomatis
        for ($i = 0; $i < 15; $i++) {
            Sop::create([
                'name' => $faker->word(),
                'nomor_sk' => $faker->unique()->numerify('SK-#######'),
                'tahun' => $faker->year(),
                'hasil_monitoring' => $faker->randomElement(['penghapusan', 'revisi', 'penggabungan', 'penambahan']),
                'tahun_perubahan' => $faker->optional()->year(),
                'keterangan' => $faker->sentence(),
                'file_sk' => $faker->optional()->word() . '.pdf', // Simulasi file
            ]);
        }
    }
}
