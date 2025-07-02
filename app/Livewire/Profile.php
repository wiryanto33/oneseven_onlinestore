<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    public $name;
    public $email;
    public $photo;
    public $member_type;
    public $point;
    public $whatsapp;

    public function render()
    {
        return view('livewire.profile');
    }

    public function mount()
    {
        $user = auth()->user();
        $this->whatsapp = Store::first()->whatsapp ?? null;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = $user->photo ? Storage::url($user->photo) : null;
        $this->member_type = $user->member_type;
        $this->point = $user->point;
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }
}
