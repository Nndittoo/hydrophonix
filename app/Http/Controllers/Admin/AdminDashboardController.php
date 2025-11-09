<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Plant;
use App\Models\UserPlant;
use App\Models\UserQuizAttempt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon

class AdminDashboardController extends Controller
{
    /**
     * [DIPERBARUI] Menampilkan dashboard admin dengan statistik lengkap
     * dan data chart bulanan.
     */
    public function index()
    {
        // 1. K-Cards (Statistik Sederhana)
        $totalUsers = User::where('role', 'user')->count();
        $totalModules = Module::count();
        $totalPlants = Plant::count();
        $totalActiveMissions = UserPlant::where('status', 'active')->count();

        // 2. Statistik Gamifikasi
        $totalQuizzes = Quiz::count();
        $totalCompletedMissions = UserPlant::where('status', 'completed')->count();

        // 3. User dengan Skor Tertinggi
        $highestScorer = User::where('role', 'user')
                             ->orderBy('total_score', 'desc')
                             ->first();

        // 4. [LOGIKA DIPERBARUI] Data untuk Chart (Pendaftaran 12 Bulan Terakhir)
        $userChartData = User::where('role', 'user')
            ->select(
                // Kelompokkan berdasarkan TAHUN dan BULAN
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Format data untuk Chart.js (12 bulan terakhir)
        $chartLabels = [];
        $chartData = [];

        // Loop dari 11 bulan lalu hingga bulan ini (total 12 bulan)
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m'); // Format: "2025-11"
            $chartLabels[] = $date->format('M Y'); // Label: "Nov 2025"

            // Cari data count untuk bulan ini
            $data = $userChartData->firstWhere('month', $monthKey);
            $chartData[] = $data ? $data->count : 0;
        }

        // 5. Aktivitas Terbaru (5 Percobaan Kuis Terakhir)
        $recentQuizAttempts = UserQuizAttempt::with('user', 'quiz')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();


        return view('admin.dashboard', [
            // K-Cards
            'totalUsers' => $totalUsers,
            'totalModules' => $totalModules,
            'totalPlants' => $totalPlants,
            'totalActiveMissions' => $totalActiveMissions,
            // Statistik Gamifikasi
            'totalQuizzes' => $totalQuizzes,
            'totalCompletedMissions' => $totalCompletedMissions,
            'highestScorer' => $highestScorer,
            // Chart Data
            'chartLabels' => $chartLabels, // Kirim sebagai array PHP
            'chartData' => $chartData,     // Kirim sebagai array PHP
            // Aktivitas Terbaru
            'recentQuizAttempts' => $recentQuizAttempts,
        ]);
    }
}
