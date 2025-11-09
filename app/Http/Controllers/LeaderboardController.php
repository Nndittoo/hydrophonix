<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index()
    {
        // 1. Ambil 10 pengguna teratas
        $topUsers = User::orderBy('total_score', 'desc')
                        ->orderBy('quizzes_completed', 'desc')
                        ->orderBy('created_at', 'asc') // Jika skor sama, user lama menang
                        ->take(10)
                        ->get();

        // 2. Ambil data user yang sedang login
        $currentUser = Auth::user();

        // 3. Cari peringkat user yang sedang login
        // Hitung berapa banyak user yang memiliki skor LEBIH TINGGI
        $higherScoreCount = User::where('total_score', '>', $currentUser->total_score)->count();

        // Peringkat = jumlah user di atas + 1
        $currentUserRank = $higherScoreCount + 1;

        return view('leaderboard.index', [
            'topUsers' => $topUsers,
            'currentUser' => $currentUser,
            'currentUserRank' => $currentUserRank,
        ]);
    }
}
