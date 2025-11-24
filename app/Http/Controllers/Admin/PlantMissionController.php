<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantMission;
use Illuminate\Http\Request;

class PlantMissionController extends Controller
{
    /**
     * Menampilkan daftar misi untuk tanaman tertentu.
     */
    public function index(Plant $plant)
    {
        $missions = $plant->missions()->orderBy('step_number')->get();
        return view('admin.plants.missions.index', compact('plant', 'missions'));
    }

    /**
     * [DIPERBARUI] Menampilkan form create dengan nomor tahap otomatis.
     */
    public function create(Plant $plant)
    {
        // [LOGIKA BARU] Hitung step selanjutnya secara otomatis
        // Ambil step number terbesar, lalu tambah 1. Jika belum ada, mulai dari 1.
        $maxStep = $plant->missions()->max('step_number');
        $nextStepNumber = $maxStep ? $maxStep + 1 : 1;

        return view('admin.plants.missions.create', compact('plant', 'nextStepNumber'));
    }

    public function store(Request $request, Plant $plant)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:0',
        ]);

        $plant->missions()->create($validated);

        return redirect()->route('admin.plants.missions.index', $plant)
                         ->with('success', 'Misi baru berhasil ditambahkan.');
    }

    public function edit(Plant $plant, PlantMission $mission)
    {
        return view('admin.plants.missions.edit', compact('plant', 'mission'));
    }

    public function update(Request $request, Plant $plant, PlantMission $mission)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:0',
        ]);

        $mission->update($validated);

        return redirect()->route('admin.plants.missions.index', $plant)
                         ->with('success', 'Misi berhasil diperbarui.');
    }

    public function destroy(Plant $plant, PlantMission $mission)
    {
        $mission->delete();
        return redirect()->route('admin.plants.missions.index', $plant)
                         ->with('success', 'Misi berhasil dihapus.');
    }
}
