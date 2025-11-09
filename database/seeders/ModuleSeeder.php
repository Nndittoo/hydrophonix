<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::truncate();

        Module::create([
            'title' => 'Pengenalan Hidroponik',
            'slug' => 'pengenalan-hidroponik',
            'level_required' => 1,
            'file_path' => 'modules/pengenalan.pdf',
            'description' => 'Pelajari dasar-dasar hidroponik, apa saja kelebihannya, dan sistem apa saja yang paling umum digunakan.',
        ]);

        Module::create([
            'title' => 'Mengenal Nutrisi AB Mix',
            'slug' => 'mengenal-nutrisi-ab-mix',
            'level_required' => 2,
            'file_path' => 'modules/pengenalan.pdf',
            'description' => 'Pelajari dasar-dasar hidroponik, apa saja kelebihannya, dan sistem apa saja yang paling umum digunakan.',
        ]);
    }
}
