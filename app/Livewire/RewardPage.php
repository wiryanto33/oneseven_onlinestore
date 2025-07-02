<?php

namespace App\Livewire;

use App\Models\Reward;
use App\Models\RewardExchange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RewardPage extends Component
{
    public $rewards;
    public $userPoints;
    public $showConfirmModal = false;
    public $selectedReward = null;
    public $exchangeNote = '';

    public function mount()
    {
        $this->rewards = Reward::all();
        $this->userPoints = Auth::user()->current_points ?? 0;
    }

    public function selectReward($rewardId)
    {
        $this->selectedReward = Reward::find($rewardId);

        if (!$this->selectedReward) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Hadiah tidak ditemukan!'
            ]);
            return;
        }

        if (!Auth::user()->hasEnoughPoints($this->selectedReward->point)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Poin kamu tidak mencukupi!'
            ]);
            return;
        }

        $this->showConfirmModal = true;
    }

    public function confirmExchange()
    {
        if (!$this->selectedReward) {
            return;
        }

        $user = Auth::user();

        if (!$user->hasEnoughPoints($this->selectedReward->point)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Poin tidak mencukupi!'
            ]);
            return;
        }

        try {
            DB::beginTransaction();

            // Create exchange record
            RewardExchange::create([
                'user_id' => $user->id,
                'reward_id' => $this->selectedReward->id,
                'points_used' => $this->selectedReward->point,
                'status' => 'pending',
                'notes' => $this->exchangeNote,
                'exchanged_at' => now(),
            ]);

            // Deduct user points
            $user->deductPoints($this->selectedReward->point);

            // Update user points in component
            $this->userPoints = $user->fresh()->current_points;

            DB::commit();

            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Penukaran berhasil! Menunggu konfirmasi admin.'
            ]);

            $this->resetModal();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ]);
        }
    }

    public function resetModal()
    {
        $this->showConfirmModal = false;
        $this->selectedReward = null;
        $this->exchangeNote = '';
    }

    public function render()
    {
        return view('livewire.rewardPage', [
            'rewards' => $this->rewards,
            'userPoints' => $this->userPoints
        ]);
    }
}
