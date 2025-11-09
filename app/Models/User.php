<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';


    public const LEVEL_MAP = [
        1 => 0,
        2 => 100,
        3 => 400,
        4 => 800,
        5 => 1500,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'total_score',
        'quizzes_completed',
        'level',
        'role',
    ];

    public function calculateLevel(): int
    {
        $score = $this->total_score;
        $currentLevel = 1;

        // Loop Peta Level untuk menemukan level tertinggi yang dicapai
        foreach (self::LEVEL_MAP as $level => $requiredScore) {
            if ($score >= $requiredScore) {
                $currentLevel = $level;
            } else {
                // Jika skor tidak cukup, berhenti (karena Peta Level sudah urut)
                break;
            }
        }
        return $currentLevel;
    }

    public function updateLevel(): bool
    {
        $calculatedLevel = $this->calculateLevel();

        if ($calculatedLevel > $this->level) {
            $this->level = $calculatedLevel;
            $this->save();
            return true; // Berhasil naik level!
        }
        return false; // Tidak ada kenaikan level
    }

    public function getNextLevelScoreAttribute(): ?int
    {
        $nextLevel = $this->level + 1;
        return self::LEVEL_MAP[$nextLevel] ?? null; // null jika sudah max level
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userPlants()
    {
        return $this->hasMany(UserPlant::class);
    }

    /**
     * Relasi ke riwayat percobaan kuis user.
     */
    public function quizAttempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

}
