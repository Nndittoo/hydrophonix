<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPlantController extends Controller
{
    public function index()
    {
        $activePlant = UserPlant::where('user_id', Auth::id())
                                ->where('status', 'active')
                                ->with(['plant', 'currentMission'])
                                ->first();

        return view('user-plants.index', ['activePlant' => $activePlant]);
    }

    /**
     * Memulai proses menanam (membuat UserPlant baru).
     */
    public function store(Plant $plant)
    {
        $user = Auth::user();

        // 1. Cek apakah user sudah punya tanaman aktif
        $existing = UserPlant::where('user_id', $user->id)
                            ->where('status', 'active')
                            ->exists();

        if ($existing) {
            return redirect()->route('plants.index')
                ->with('error', 'Anda sudah memiliki tanaman aktif. Selesaikan dulu sebelum memulai yang baru!');
        }

        // 2. Cari misi pertama untuk tanaman ini
        $firstMission = $plant->missions()->where('step_number', 1)->first();

        if (!$firstMission) {
            return redirect()->route('plants.index')
                ->with('error', 'Tanaman ini belum memiliki data misi. Hubungi admin.');
        }

        // 3. Buat entri tanaman user
        UserPlant::create([
            'user_id' => $user->id,
            'plant_id' => $plant->id,
            'current_mission_id' => $firstMission->id,
            'mission_started_at' => now(),
            'plant_age' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('user-plants.index')
            ->with('success', 'Selamat! Anda telah memulai misi menanam ' . $plant->name);
    }

    /**
     * Menyelesaikan misi saat ini dan lanjut ke misi berikutnya.
     */
    public function completeMission(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil tanaman aktif saat ini
        $activePlant = UserPlant::where('user_id', $user->id)
                                ->where('status', 'active')
                                ->with('currentMission')
                                ->first();

        if (!$activePlant) {
            return redirect()->back()->with('error', 'Anda tidak memiliki tanaman aktif.');
        }

        // 2. Cek apakah durasi misi sudah terpenuhi
        $mission = $activePlant->currentMission;
        $daysSinceStart = $activePlant->mission_started_at->diffInDays(now());

        if ($daysSinceStart < $mission->duration_days) {
            return redirect()->back()->with('error', 'Misi belum selesai. Harap tunggu ' . ($mission->duration_days - $daysSinceStart) . ' hari lagi.');
        }

        // 3. Cari misi berikutnya
        $nextMission = $activePlant->plant->missions()
                                ->where('step_number', $mission->step_number + 1)
                                ->first();

        // 4. Proses: Cek jika ini misi terakhir atau lanjut
        if ($nextMission) {
            // Lanjut ke misi berikutnya
            $activePlant->update([
                'current_mission_id' => $nextMission->id,
                'mission_started_at' => now(),
            ]);
            return redirect()->back()->with('success', 'Misi selesai! Lanjut ke tahap berikutnya: ' . $nextMission->title);
        } else {
            // Ini adalah misi terakhir, selesaikan tanaman
            $activePlant->update([
                'status' => 'completed',
            ]);
            return redirect()->route('dashboard')->with('success', 'Selamat! Anda telah berhasil menyelesaikan semua misi tanam!');
        }
    }
}
