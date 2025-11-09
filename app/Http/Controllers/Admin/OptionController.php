<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Option;

class OptionController extends Controller
{
    /**
     * Mengupdate pilihan jawaban (opsi) via AJAX.
     */
    public function update(Request $request, Option $option)
    {
        $validated = $request->validate([
            'option_text' => 'required|string|max:255',
        ]);

        $option->update($validated);

        // Kembalikan data opsi yang telah diupdate sebagai JSON
        return response()->json($option);
    }

    /**
     * Menghapus pilihan jawaban (opsi) via AJAX.
     */
    public function destroy(Option $option)
    {
        // Cek agar tidak menghapus opsi terakhir
        if ($option->question->options->count() <= 1) {
            // Kirim status error 422 (Unprocessable Entity)
            return response()->json(['message' => 'Tidak bisa menghapus pilihan terakhir.'], 422);
        }

        // Cek jika ini adalah jawaban yang benar
        if($option->is_correct) {
            return response()->json(['message' => 'Tidak bisa menghapus pilihan yang ditandai sebagai jawaban benar.'], 422);
        }

        $option->delete();

        // Kembalikan respons JSON yang sukses
        return response()->json(['message' => 'Pilihan berhasil dihapus.']);
    }

    /**
     * Menambah pilihan jawaban baru untuk pertanyaan via AJAX.
     */
    public function store(Request $request, Question $question)
    {
        // Cek agar tidak lebih dari 6 opsi (opsional)
        if ($question->options->count() >= 6) {
             return response()->json(['message' => 'Maksimal 6 pilihan per pertanyaan.'], 422);
        }

        // Buat opsi baru
        $option = $question->options()->create([
            'option_text' => 'Pilihan Baru'
        ]);

        // Kembalikan data opsi baru sebagai JSON
        return response()->json($option);
    }

    /**
     * Mengatur pilihan jawaban yang benar (Set Correct Answer) via AJAX.
     */
    public function setCorrect(Question $question, Option $option)
    {
        // 1. Set semua opsi lain menjadi 'false'
        $question->options()->update(['is_correct' => false]);

        // 2. Set opsi yang dipilih menjadi 'true'
        $option->update(['is_correct' => true]);

        // Kembalikan respons JSON yang sukses
        return response()->json(['message' => 'Jawaban benar berhasil diatur.']);
    }
}
