<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relasi ke misi-misi yang dimiliki tanaman ini.
     */
    public function missions()
    {
        return $this->hasMany(PlantMission::class);
    }
}
