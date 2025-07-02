<?php

// 1. RewardHistory Livewire Component
// app/Livewire/RewardHistory.php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RewardHistory extends Component
{
    public $exchanges;
    public $selectedExchange = null;
    public $showDetailModal = false;

    public function mount()
    {
        $this->loadExchanges();
    }

    public function loadExchanges()
    {
        $this->exchanges = Auth::user()
            ->rewardExchanges()
            ->with('reward')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function showDetail($exchangeId)
    {
        $this->selectedExchange = $this->exchanges->find($exchangeId);
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedExchange = null;
    }

    public function render()
    {
        return view('livewire.reward-history');
    }
}
