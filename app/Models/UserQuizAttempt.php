<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuizAttempt extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relasi ke user pemilik.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kuis yang dikerjakan.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
