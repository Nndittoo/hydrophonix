<?php

namespace App\Http\Controllers;

use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    /**
     * Menampilkan halaman utama kalender
     * dan mengirim data tanaman yang sedang aktif.
     */
    public function index()
    {
        $activePlant = UserPlant::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with(['plant', 'currentMission'])
            ->first();

        return view('calendar.index', [
            'activePlant' => $activePlant
        ]);
    }

    /**
     * [VERSI FINAL] Mengambil data event untuk kalender
     * dengan semua data misi untuk (eventClick).
     */
    public function getEvents(Request $request)
    {
        $activePlant = UserPlant::where('user_id', Auth::id())
            ->where('status', 'active')
            // [PENTING] Pastikan plant.missions (jamak) di-load di sini
            ->with(['plant.missions', 'currentMission'])
            ->first();

        $events = [];

        if ($activePlant) {
            $currentMission = $activePlant->currentMission;
            $startDate = $activePlant->mission_started_at;

            // Ambil koleksi misi yang sudah di-load
            $allMissions = $activePlant->plant->missions;

            // 1. Tambahkan event untuk misi yang sedang berjalan
            $events[] = [
                'title' => $currentMission->title,
                'start' => $startDate->format('Y-m-d'),
                'end'   => $startDate->copy()->addDays($currentMission->duration_days)->format('Y-m-d'),
                'backgroundColor' => '#F59E0B', // Kuning
                'borderColor' => '#F59E0B',
                'extendedProps' => [
                    'step_number' => $currentMission->step_number,
                    'description' => $currentMission->description,
                    'plant_name'  => $activePlant->plant->name,
                    'image_url'   => Storage::url($activePlant->plant->image_url),
                    'is_active'   => true,
                ]
            ];

            // 2. Hitung dan tambahkan semua event misi di masa depan
            //    Gunakan koleksi yang sudah di-load, bukan query baru
            $futureMissions = $allMissions->where('step_number', '>', $currentMission->step_number)
                                         ->sortBy('step_number'); // Gunakan sortBy (untuk koleksi)

            $cumulativeDate = $startDate->copy()->addDays($currentMission->duration_days);

            foreach ($futureMissions as $mission) {
                $events[] = [
                    'title' => $mission->title,
                    'start' => $cumulativeDate->format('Y-m-d'),
                    'end'   => $cumulativeDate->copy()->addDays($mission->duration_days)->format('Y-m-d'),
                    // 'extendedProps' ditambahkan untuk konsistensi
                    'extendedProps' => [
                        'step_number' => $mission->step_number,
                        'description' => $mission->description,
                        'plant_name'  => $activePlant->plant->name,
                        'image_url'   => Storage::url($activePlant->plant->image_url),
                        'is_active'   => false,
                    ]
                ];
                // Update tanggal kumulatif untuk iterasi berikutnya
                $cumulativeDate->addDays($mission->duration_days);
            }
        }

        return response()->json($events);
    }
}
