<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * [DIPERBARUI] Menyimpan SATU pertanyaan baru via AJAX
     * dan me-return data JSON.
     */
    public function store(Request $request, Quiz $quiz)
    {
        // 1. Validasi
        $validated = $request->validate([
            'question_text' => 'required|string|max:500',
        ]);

        // 2. Buat pertanyaan
        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text']
        ]);

        // 3. Buat 4 pilihan jawaban default
        $options = $question->options()->createMany([
            ['option_text' => 'Pilihan A'],
            ['option_text' => 'Pilihan B'],
            ['option_text' => 'Pilihan C'],
            ['option_text' => 'Pilihan D'],
        ]);

        // 4. Muat relasi opsi ke pertanyaan
        $question->load('options');

        // 5. [PENTING] Kembalikan pertanyaan baru sebagai JSON
        // Ini akan ditangkap oleh Alpine.js di frontend
        return response()->json($question);
    }

    /**
     * Menghapus pertanyaan dari kuis via AJAX.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        // Kembalikan respons JSON yang sukses
        return response()->json(['message' => 'Pertanyaan berhasil dihapus.']);
    }

    // [DIHAPUS] Fungsi create() and store() (jamak) sudah tidak diperlukan
    // karena kita sekarang menggunakan builder interaktif.
}
