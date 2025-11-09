<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserPlant; // <-- [BARU] Import UserPlant
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir profil pengguna.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // --- LOGIKA PROGRESS BAR (Tetap) ---
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

        // --- [LOGIKA BARU] Ambil data statistik tambahan ---

        // 1. Ambil jumlah tanaman yang selesai
        $plantsCompletedCount = UserPlant::where('user_id', $user->id)
                                         ->where('status', 'completed')
                                         ->count();

        // 2. Ambil peringkat global (sama seperti di Dashboard)
        $higherScoreUsers = User::where('total_score', '>', $user->total_score)->count();
        $userRank = $higherScoreUsers + 1;
        // --- AKHIR LOGIKA BARU ---


        return view('profile.edit', [
            'user' => $user,
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'levelMap' => User::LEVEL_MAP,
            'nextLevelScore' => $nextLevelScore,
            'scoreGainedInLevel' => $scoreGainedInLevel,
            'progressPercent' => $progressPercent,
            'plantsCompletedCount' => $plantsCompletedCount, // <-- [BARU] Kirim data tanaman
            'userRank' => $userRank, // <-- [BARU] Kirim data peringkat
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     * (Tidak berubah)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // ... (Tidak ada perubahan di sini) ...
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
