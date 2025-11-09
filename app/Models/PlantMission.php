<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlantMission extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relasi ke tanaman induk.
     */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
