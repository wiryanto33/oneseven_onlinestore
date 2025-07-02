<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'password',
        'member_type',
        'phone',
        'point',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_admin;
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? url('storage/' . $this->photo) : null;
    }

    public function rewardExchanges()
    {
        return $this->hasMany(RewardExchange::class);
    }

    public function getCurrentPointsAttribute(): int
    {
        // Sesuaikan dengan sistem point yang ada
        // Contoh jika ada tabel user_points atau field points di users
        return $this->point ?? 0;
    }

    public function hasEnoughPoints(int $requiredPoint): bool
    {
        return $this->current_points>= $requiredPoint;
    }

    public function deductPoints(int $point): void
    {
        // Sesuaikan dengan sistem point yang ada
        $this->decrement('point', $point);
    }
}
