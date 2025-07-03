<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $photo;
    public $member_type;
    public $point;
    public $whatsapp;
    public $newPhoto;
    public $showPhotoModal = false;

    protected $rules = [
        'newPhoto' => 'image|max:2048', // max 2MB
    ];

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

    public function openPhotoModal()
    {
        $this->showPhotoModal = true;
    }

    public function closePhotoModal()
    {
        $this->showPhotoModal = false;
        $this->newPhoto = null;
    }

    public function updatePhoto()
    {
        $this->validate();

        $user = auth()->user();

        // Hapus foto lama jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Upload foto baru
        $photoPath = $this->newPhoto->store('photos', 'public');

        // Update database
        $user->update(['photo' => $photoPath]);

        // Update properti komponen
        $this->photo = Storage::url($photoPath);

        // Reset form
        $this->newPhoto = null;
        $this->showPhotoModal = false;

        // Tampilkan pesan sukses
        session()->flash('message', 'Foto profil berhasil diperbarui!');
    }

    public function deletePhoto()
    {
        $user = auth()->user();

        // Hapus foto dari storage
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Update database
        $user->update(['photo' => null]);

        // Update properti komponen
        $this->photo = null;
        $this->showPhotoModal = false;

        // Tampilkan pesan sukses
        session()->flash('message', 'Foto profil berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }
}
