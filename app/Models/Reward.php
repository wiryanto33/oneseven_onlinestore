<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'name',
        'point',
        'image',
        'description',
    ];

    public function exchanges()
    {
        return $this->hasMany(RewardExchange::class);
    }

    public function isAvailable(): bool
    {
        // Bisa ditambahkan logic stock jika diperlukan
        return true;
    }
}
