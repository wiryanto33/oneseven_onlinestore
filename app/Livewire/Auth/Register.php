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
    public $phone = '';  // Added missing property
    public $password = '';
    public $password_confirmation = '';
    public $photo;  // Added missing property
    public $member_type = '';  // Added missing property
    public $showPassword = false;
    public $passwordConfirmationTouched = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string|min:10',  // Added phone validation
        'password' => 'required|min:8|confirmed',
        'photo' => 'nullable|image|max:2048',
        'member_type' => 'required|in:distributor,reseller,stockist,retailer,agent,customer',
    ];

    protected $messages = [  // Fixed typo: was $message, should be $messages
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

    public function register()
    {
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
            'phone' => $validatedData['phone'],  // Added phone field
            'password' => Hash::make($validatedData['password']),
            'photo' => $photoPath,
            'member_type' => $validatedData['member_type'],
            'is_admin' => $isFirstUser
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($isFirstUser) {
            return redirect()->intended('/admin');
        }

        return redirect()->route('home');
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
