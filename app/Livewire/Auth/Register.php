<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $photo;
    public $member_type = '';
    public $showPassword = false;
    public $passwordConfirmationTouched = false;

    // Properties untuk tracking upload status
    public $photoPreview = null;
    public $uploadProgress = 0;
    public $isUploading = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string|min:10',
        'password' => 'required|min:8|confirmed',
        'photo' => 'nullable|image|max:2048',
        'member_type' => 'required|in:distributor,reseller,stockist,retailer,agent,customer',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'name.min' => 'Nama minimal 3 karakter',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'phone.required' => 'Nomor telepon wajib diisi',
        'phone.min' => 'Nomor telepon minimal 10 karakter',
        'photo.image' => 'File harus berupa gambar',
        'photo.max' => 'Ukuran gambar maksimal 2MB',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi',
        'member_type.required' => 'Tipe member wajib dipilih',
        'member_type.in' => 'Tipe member tidak valid',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'password_confirmation') {
            $this->passwordConfirmationTouched = true;
        }

        if (
            $this->passwordConfirmationTouched &&
            $this->password_confirmation !== '' &&
            $this->password !== $this->password_confirmation
        ) {
            $this->addError('password', 'The password field must match password confirmation');
        } else {
            $this->resetValidation('password');
        }

        $this->validateOnly($propertyName);
    }

    // Method khusus untuk handle photo upload
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);

        if ($this->photo) {
            // Reset error jika ada
            $this->resetErrorBag('photo');

            // Dispatch event untuk update UI
            $this->dispatch('photo-uploaded', [
                'name' => $this->photo->getClientOriginalName(),
                'size' => $this->formatBytes($this->photo->getSize())
            ]);
        }
    }

    // Method untuk format ukuran file
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    // Method untuk remove photo
    public function removePhoto()
    {
        $this->photo = null;
        $this->photoPreview = null;
        $this->resetErrorBag('photo');

        $this->dispatch('photo-removed');
    }

    public function register()
    {
        try {
            // Validate all fields
            $validatedData = $this->validate();

            // Handle photo upload
            $photoPath = null;
            if ($this->photo) {
                $photoPath = $this->photo->store('profile-photos', 'public');
            }

            $isFirstUser = User::count() === 0;

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
                'photo' => $photoPath,
                'member_type' => $validatedData['member_type'],
                'is_admin' => $isFirstUser
            ]);

            event(new Registered($user));

            Auth::login($user);

            // Flash success message
            session()->flash('success', 'Registrasi berhasil! Selamat datang.');

            if ($isFirstUser) {
                return redirect()->intended('/admin');
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.app', ['hideBottomNav' => true]);
    }
}
