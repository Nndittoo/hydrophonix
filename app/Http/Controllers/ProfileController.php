<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserPlant;
use App\Models\UserQuizAttempt; // <-- [BARU]
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir profil pengguna beserta data gamifikasi.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // 1. Logika Progress Bar (Tetap)
        $currentLevelScore = User::LEVEL_MAP[$user->level];
        $nextLevelScore = $user->next_level_score;
        $progressPercent = 0;
        $scoreGainedInLevel = $user->total_score - $currentLevelScore;

        if ($nextLevelScore) {
            if ($nextLevelScore > 0) {
                $progressPercent = ($user->total_score / $nextLevelScore) * 100;
                if ($progressPercent > 100) $progressPercent = 100;
            }
        } else {
            $progressPercent = 100;
            $scoreGainedInLevel = 0;
        }

        // 2. Statistik Umum
        $plantsCompletedCount = UserPlant::where('user_id', $user->id)->where('status', 'completed')->count();
        $higherScoreUsers = User::where('total_score', '>', $user->total_score)->count();
        $userRank = $higherScoreUsers + 1;

        // 3. [BARU] Daftar Tanaman (Aktif & Selesai)
        $myPlants = UserPlant::where('user_id', $user->id)
                             ->with(['plant', 'currentMission'])
                             ->orderBy('status', 'asc') // Aktif dulu, baru completed
                             ->orderBy('created_at', 'desc')
                             ->get();

        // 4. [BARU] Riwayat Kuis
        $myQuizzes = UserQuizAttempt::where('user_id', $user->id)
                                    ->with('quiz.module')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // 5. [BARU] Logika BADGE (Penghargaan Sistem)
        // Kita buat logika manual di sini tanpa tabel database khusus
        $badges = collect([
            [
                'name' => 'Pendatang Baru',
                'desc' => 'Bergabung dengan Hidrophonix',
                'icon' => '👋',
                'unlocked' => true, // Selalu dapat
            ],
            [
                'name' => 'Petani Pemula',
                'desc' => 'Mulai menanam tanaman pertama',
                'icon' => '🌱',
                'unlocked' => $myPlants->count() > 0,
            ],
            [
                'name' => 'Si Cerdas',
                'desc' => 'Mendapat nilai 100 di kuis',
                'icon' => '💯',
                'unlocked' => $myQuizzes->where('score', 100)->count() > 0,
            ],
            [
                'name' => 'Panen Raya',
                'desc' => 'Menelesaikan siklus 1 tanaman',
                'icon' => '🌾',
                'unlocked' => $plantsCompletedCount > 0,
            ],
            [
                'name' => 'Master Hidroponik',
                'desc' => 'Mencapai Level 5',
                'icon' => '👑',
                'unlocked' => $user->level >= 5,
            ],
        ]);


        return view('profile.edit', [
            'user' => $user,
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'levelMap' => User::LEVEL_MAP,
            'nextLevelScore' => $nextLevelScore,
            'scoreGainedInLevel' => $scoreGainedInLevel,
            'progressPercent' => $progressPercent,
            'plantsCompletedCount' => $plantsCompletedCount,
            'userRank' => $userRank,
            'myPlants' => $myPlants, // Data Tanaman
            'myQuizzes' => $myQuizzes, // Data Kuis
            'badges' => $badges, // Data Badge
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
