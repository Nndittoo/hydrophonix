<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlantMission;

class PlantMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlantMission::truncate();

        // --- Misi untuk Bayam (ID: 1) ---
        PlantMission::create([
            'plant_id' => 1,
            'step_number' => 1,
            'title' => 'Tahap Semai',
            'description' => 'Mulai semai bibit bayam di rockwool yang sudah dibasahi. Pastikan tetap lembab dan tidak terkena sinar matahari langsung.',
            'duration_days' => 7,
        ]);

        PlantMission::create([
            'plant_id' => 1,
            'step_number' => 2,
            'title' => 'Pindah Tanam & Nutrisi Awal',
            'description' => 'Pindahkan bibit yang sudah berdaun 2-4 helai ke sistem hidroponik (netpot). Berikan nutrisi AB Mix dengan kadar 600 PPM.',
            'duration_days' => 7,
        ]);

        PlantMission::create([
            'plant_id' => 1,
            'step_number' => 3,
            'title' => 'Pemberian Nutrisi Rutin',
            'description' => 'Jaga level air nutrisi dan naikkan kadar PPM menjadi 800-1000 PPM. Periksa pH air secara berkala (ideal 5.5 - 6.5).',
            'duration_days' => 14,
        ]);

        PlantMission::create([
            'plant_id' => 1,
            'step_number' => 4,
            'title' => 'Panen',
            'description' => 'Bayam siap dipanen setelah 25-30 hari sejak semai. Selamat menikmati hasil kebun Anda!',
            'duration_days' => 0, // Misi terakhir
        ]);
    }
}
