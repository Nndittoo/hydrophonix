<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\UserPlant;
use App\Models\UserQuizAttempt; // <-- [BARU] Import riwayat kuis
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- [BARU] Import DB facade

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard ringkasan untuk user.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Data Fitur Monitoring (Tetap)
        $activePlant = UserPlant::where('user_id', $user->id)
                            ->where('status', 'active')
                            ->with(['plant', 'currentMission'])
                            ->first();

        // 2. Data Fitur Modul (Tetap)
        $moduleCount = Module::count();
        $quizCompletedCount = $user->quizzes_completed;

        // 3. Data Fitur Gamifikasi (Peringkat) (Tetap)
        $higherScoreUsers = User::where('total_score', '>', $user->total_score)->count();
        $userRank = $higherScoreUsers + 1;

        // 4. Data Progres Level (Tetap)
        $nextLevelScore = $user->next_level_score;
        $progressPercent = 0;

        if ($nextLevelScore) {
            if ($nextLevelScore > 0) {
                $progressPercent = ($user->total_score / $nextLevelScore) * 100;
                if ($progressPercent > 100) $progressPercent = 100;
            }
        } else {
            $progressPercent = 100;
        }

        // 5. [LOGIKA BARU] Modul yang bisa diakses di level ini
        $accessibleModules = Module::where('level_required', '<=',$user->level)
                                   ->orderBy('title')
                                   ->get();

        // 6. [LOGIKA BARU] Kuis yang sudah dikerjakan (skor tertinggi)
        $completedQuizzes = UserQuizAttempt::where('user_id', $user->id)
            ->select('quiz_id', DB::raw('MAX(score) as best_score'))
            ->groupBy('quiz_id')
            ->with('quiz.module') // Muat relasi quiz & modulnya
            ->orderBy('best_score', 'desc')
            ->get();


        return view('dashboard', [
            'activePlant' => $activePlant,
            'moduleCount' => $moduleCount,
            'quizCompletedCount' => $quizCompletedCount,
            'userRank' => $userRank,
            'nextLevelScore' => $nextLevelScore,
            'progressPercent' => $progressPercent,
            'accessibleModules' => $accessibleModules, // <-- [BARU] Kirim data modul
            'completedQuizzes' => $completedQuizzes, // <-- [BARU] Kirim data kuis
        ]);
    }
}
