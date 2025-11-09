<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
    ];

    /**
     * Relasi ke kuis induk.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relasi ke semua pilihan jawaban untuk pertanyaan ini.
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
