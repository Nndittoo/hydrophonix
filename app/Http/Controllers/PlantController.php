<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\UserPlant; // <-- [BARU] Import UserPlant
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- [BARU] Import Auth

class PlantController extends Controller
{
    /**
     * [LOGIKA DIPERBARUI]
     * Menampilkan daftar semua tanaman & tanaman aktif pengguna.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua tanaman yang tersedia di sistem
        $allPlants = Plant::orderBy('name')->get();

        // Ambil tanaman yang sedang aktif ditanam oleh user
        $activePlant = UserPlant::where('user_id', $user->id)
                                ->where('status', 'active')
                                ->with(['plant', 'currentMission']) // Muat relasi
                                ->first();

        return view('plants.index', [
            'allPlants' => $allPlants,
            'activePlant' => $activePlant
        ]);
    }

    /**
     * Menampilkan detail satu tanaman dan daftar misinya.
     * (Tidak berubah)
     */
    public function show(Plant $plant)
    {
        // Muat relasi misi untuk tanaman ini, diurutkan berdasarkan langkah
        $plant->load(['missions' => function ($query) {
            $query->orderBy('step_number', 'asc');
        }]);

        return view('plants.show', ['plant' => $plant]);
    }
}
