<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Menampilkan halaman kuis (DENGAN LOGIKA PENGUNCIAN 100).
     */
    public function show(Quiz $quiz)
    {
        // --- LOGIKA BARU (Request 1: Kunci skor 100) ---
        $user = Auth::user();

        // Cari skor tertinggi user untuk kuis ini
        $bestAttempt = UserQuizAttempt::where('user_id', $user->id)
                                      ->where('quiz_id', $quiz->id)
                                      ->orderBy('score', 'desc')
                                      ->first();

        // Jika skor 100, redirect kembali ke halaman modul dengan pesan info
        if ($bestAttempt && $bestAttempt->score == 100) {
            $quiz->load('module'); // Kita butuh slug modul untuk redirect
            return redirect()->route('modules.show', $quiz->module->slug)
                             ->with('info', 'Anda sudah mendapatkan skor sempurna (100) untuk kuis ini!');
        }
        // --- AKHIR LOGIKA BARU ---


        // Memuat relasi 'questions' dan 'options' (Logika lama, sudah benar)
        $quiz->load('questions.options');

        return view('quiz.show', [
            'quiz' => $quiz
        ]);
    }

    /**
     * Memproses jawaban kuis (DENGAN LOGIKA SKOR TERTINGGI).
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $answers = $request->input('answers'); // Ini adalah array [question_id => option_id]

        $score = 0;
        $totalQuestions = $quiz->questions->count();

        // 1. Validasi jawaban
        $correctOptions = Option::whereIn('question_id', $quiz->questions->pluck('id'))
                                ->where('is_correct', true)
                                ->pluck('id');

        // 2. Hitung skor
        if ($answers) {
            foreach ($answers as $question_id => $option_id) {
                if ($correctOptions->contains($option_id)) {
                    $score++;
                }
            }
        }

        // Konversi skor ke persentase
        $newScore = ($totalQuestions > 0) ? (int)(($score / $totalQuestions) * 100) : 0;

        // --- LOGIKA BARU (Request 2: Simpan Skor Tertinggi) ---

        // 3. Dapatkan skor terbaik user SEBELUMNYA
        $previousBestAttempt = UserQuizAttempt::where('user_id', $user->id)
                                            ->where('quiz_id', $quiz->id)
                                            ->orderBy('score', 'desc')
                                            ->first();

        $previousBestScore = $previousBestAttempt ? $previousBestAttempt->score : 0;
        $isFirstTime = !$previousBestAttempt;
        $isNewHighScore = $newScore > $previousBestScore;

        // 4. Simpan riwayat pengerjaan kuis ini
        $attempt = UserQuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score'   => $newScore,
            // [PERUBAHAN] Simpan data jawaban ke database
            'answers_data' => json_encode($answers)
        ]);

        // 5. Update gamifikasi
        if ($isFirstTime) {
            $user->increment('quizzes_completed', 1);
        }

        if ($isFirstTime) {
            $user->increment('total_score', $newScore);
        } elseif ($isNewHighScore) {
            $scoreDifference = $newScore - $previousBestScore;
            $user->increment('total_score', $scoreDifference);
        }

        // --- LOGIKA LEVEL UP BARU ---
        $leveledUp = $user->updateLevel();
        // --- AKHIR LOGIKA LEVEL UP ---


        // 6. Arahkan ke halaman hasil (DENGAN PESAN LEVEL UP)
        $redirect = redirect()->route('quiz.result', ['attempt' => $attempt->id]);

        if ($leveledUp) {
            // Kirim pesan "flash" ke sesi jika user naik level
            $redirect->with('level_up', "🎉 Selamat! Anda telah naik ke Level {$user->level}!");
        }

        return $redirect;
    }

    /**
     * [DIPERBARUI] Menampilkan halaman hasil kuis
     * dan data untuk tinjauan jawaban.
     */
    public function result(UserQuizAttempt $attempt)
    {
        // 1. Pastikan user hanya bisa melihat hasilnya sendiri
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // 2. Muat semua data yang diperlukan untuk tinjauan
        // (quiz, semua pertanyaan, dan semua opsi dari pertanyaan tsb)
        $attempt->load('quiz.questions.options');

        // 3. Dapatkan jawaban yang disimpan user (sebagai array [question_id => option_id])
        $userAnswers = json_decode($attempt->answers_data, true) ?? [];

        // 4. Dapatkan semua jawaban yang benar untuk kuis ini
        //    Hasilnya adalah array [question_id => correct_option_id]
        $correctOptionsMap = Option::whereIn('question_id', $attempt->quiz->questions->pluck('id'))
                                    ->where('is_correct', true)
                                    ->pluck('id', 'question_id'); // -> [1 => 3, 2 => 8, ...]

        return view('quiz.result', [
            'attempt' => $attempt,
            'userAnswers' => $userAnswers,
            'correctOptionsMap' => $correctOptionsMap
        ]);
    }
}
