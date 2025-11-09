<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Quiz;
// Kita tidak perlu Question atau Option lagi di sini

class adminQuizController extends Controller
{
    /**
     * Menampilkan daftar semua kuis.
     */
    public function index()
    {
        $quizzes = Quiz::with('module')
                        ->withCount('questions')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.quizzes.index', compact('quizzes'));
    }

    /**
     * Menampilkan formulir "Langkah 1: Buat Kuis Baru"
     */
    public function create()
    {
        $availableModules = Module::whereDoesntHave('quiz')
                                  ->orderBy('title')
                                  ->get();

        return view('admin.quizzes.create', [
            'availableModules' => $availableModules
        ]);
    }

    /**
     * [PERBAIKAN]
     * Menyimpan kuis baru (Langkah 1) dan mengarahkan ke "Quiz Builder" (halaman edit).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
        ]);

        $module = Module::find($validated['module_id']);

        if ($module->quiz) {
            return redirect()->route('admin.quizzes.edit', $module->quiz)
                             ->with('info', 'Modul ini sudah memiliki kuis.');
        }

        $quiz = $module->quiz()->create([
            'title' => $validated['title'],
        ]);

        // [PERBAIKAN] Redirect ke halaman 'edit' (Quiz Builder)
        return redirect()->route('admin.quizzes.edit', $quiz)
                         ->with('success', 'Kuis berhasil dibuat. Selamat datang di Quiz Builder!');
    }

    /**
     * [FILE INI SEKARANG MENJADI PENTING]
     * Menampilkan halaman "Quiz Builder" (Langkah 2 + 3)
     */
    public function edit(Quiz $quiz)
    {
        // Muat semua relasi agar Alpine.js bisa menggunakannya
        $quiz->load('module', 'questions.options');
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Mengupdate judul kuis (dari halaman Quiz Builder).
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $quiz->update($validated);
        return redirect()->back()->with('success', 'Judul kuis berhasil diperbarui.');
    }

    /**
     * Menghapus kuis.
     */
    public function destroy(Quiz $quiz)
    {
        $module = $quiz->module;
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')
                         ->with('success', 'Kuis berhasil dihapus dari modul ' . $module->title);
    }
}
