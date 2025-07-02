<?php

namespace App\Services;

use App\Models\User;
use App\Models\Reward;
use App\Models\RewardExchange;
use Illuminate\Support\Facades\DB;

class RewardExchangeService
{
    public function exchangeReward(User $user, Reward $reward, string $notes = ''): array
    {
        if (!$user->hasEnoughPoints($reward->point)) {
            return [
                'success' => false,
                'message' => 'Poin tidak mencukupi!'
            ];
        }

        if (!$reward->isAvailable()) {
            return [
                'success' => false,
                'message' => 'Hadiah tidak tersedia!'
            ];
        }

        try {
            DB::beginTransaction();

            $exchange = RewardExchange::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'points_used' => $reward->point,
                'status' => 'pending',
                'notes' => $notes,
                'exchanged_at' => now(),
            ]);

            $user->deductPoints($reward->point);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Penukaran berhasil!',
                'exchange' => $exchange
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem!'
            ];
        }
    }

    public function getUserExchangeHistory(User $user)
    {
        return $user->rewardExchanges()
            ->with('reward')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
