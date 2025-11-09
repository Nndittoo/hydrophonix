<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'level_required',
        'file_path',
        'description',
    ];


    /**
     * Relasi ke kuis yang dimiliki modul ini (jika ada).
     */
    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}
