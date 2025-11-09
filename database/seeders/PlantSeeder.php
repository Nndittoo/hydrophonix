<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plant::truncate(); // Hapus data lama (opsional)

        Plant::create([
            'name' => 'Bayam',
            'description' => 'Bayam (Amaranthus) adalah tumbuhan yang biasa ditanam untuk dikonsumsi daunnya sebagai sayuran hijau.',
            'image_url' => 'images/bayam.jpeg',
        ]);

        Plant::create([
            'name' => 'Kangkung',
            'description' => 'Kangkung (Ipomoea aquatica) adalah tumbuhan yang termasuk jenis sayur-sayuran dan ditanam sebagai makanan.',
            'image_url' => 'images/kangkung.jpeg',
        ]);

        Plant::create([
            'name' => 'Selada',
            'description' => 'Selada (Lactuca sativa) adalah tumbuhan sayur yang biasa ditanam di daerah beriklim sedang maupun daerah tropika.',
            'image_url' => 'images/selada.jpg',
        ]);

        Plant::create([
            'name' => 'Pakcoy',
            'description' => 'Pakcoy atau bok choy (Brassica rapa) adalah jenis sayuran yang populer. Sayuran ini mudah dibudidayakan.',
            'image_url' => 'images/pakcoy.jpeg',
        ]);
    }
}
