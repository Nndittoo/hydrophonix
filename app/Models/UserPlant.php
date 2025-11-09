<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPlant extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Tentukan cast untuk kolom tanggal.
     */
    protected $casts = [
        'mission_started_at' => 'datetime',
    ];

    /**
     * Relasi ke user pemilik.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke data tanaman.
     */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    /**
     * Relasi ke misi yang sedang aktif.
     */
    public function currentMission()
    {
        return $this->belongsTo(PlantMission::class, 'current_mission_id');
    }
}
