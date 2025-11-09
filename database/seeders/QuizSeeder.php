<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quiz::truncate();
        Question::truncate();
        Option::truncate();

        // 1. Ambil Modul 'Pengenalan Hidroponik' (ID: 1)
        $module1 = Module::find(1);
        if ($module1) {
            // Buat Kuis untuk Modul 1
            $quiz1 = $module1->quiz()->create([
                'title' => 'Kuis Dasar Hidroponik',
            ]);

            // Buat Pertanyaan 1 untuk Kuis 1
            $q1 = $quiz1->questions()->create([
                'question_text' => 'Apa media tanam utama yang TIDAK digunakan dalam hidroponik?',
            ]);
            // Buat Pilihan Jawaban untuk Q1
            $q1->options()->createMany([
                ['option_text' => 'Air', 'is_correct' => false],
                ['option_text' => 'Tanah', 'is_correct' => true],
                ['option_text' => 'Rockwool', 'is_correct' => false],
                ['option_text' => 'Sekam Bakar', 'is_correct' => false],
            ]);

            // Buat Pertanyaan 2 untuk Kuis 1
            $q2 = $quiz1->questions()->create([
                'question_text' => 'Teknik hidroponik yang mengalirkan air nutrisi tipis secara terus menerus disebut...',
            ]);
            // Buat Pilihan Jawaban untuk Q2
            $q2->options()->createMany([
                ['option_text' => 'Wick System (Sumbu)', 'is_correct' => false],
                ['option_text' => 'Deep Flow Technique (DFT)', 'is_correct' => false],
                ['option_text' => 'Nutrient Film Technique (NFT)', 'is_correct' => true],
            ]);
        }


        // 2. Ambil Modul 'Mengenal Nutrisi AB Mix' (ID: 2)
        $module2 = Module::find(2);
        if ($module2) {
            // Buat Kuis untuk Modul 2
            $quiz2 = $module2->quiz()->create([
                'title' => 'Kuis Nutrisi AB Mix',
            ]);

            // Buat Pertanyaan 1 untuk Kuis 2
            $q3 = $quiz2->questions()->create([
                'question_text' => 'Mengapa pupuk AB Mix harus dipisahkan menjadi Stok A dan Stok B?',
            ]);
            // Buat Pilihan Jawaban untuk Q3
            $q3->options()->createMany([
                ['option_text' => 'Agar lebih mudah ditakar', 'is_correct' => false],
                ['option_text' => 'Supaya warnanya berbeda', 'is_correct' => false],
                ['option_text' => 'Mencegah pengendapan Kalsium (A) dengan Sulfat/Fosfat (B)', 'is_correct' => true],
                ['option_text' => 'Stok B lebih mahal dari Stok A', 'is_correct' => false],
            ]);
        }
    }
}
