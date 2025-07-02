<div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg">
    <div class="p-6">
        <!-- Logo & Welcome Text -->
        <div class="text-center mb-8 pt-8">
            <div class="w-24 h-24 rounded-3xl mx-auto flex items-center justify-center mb-6">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-25 h-25 ">
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
            <p class="text-gray-500">Silakan register untuk melanjutkan</p>
        </div>

        <!-- Login Form -->
        <form wire:submit.prevent="register" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <div class="mt-1">
                    <input wire:model.lazy="name" type="text" placeholder="Masukkan nama"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>

                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label class="block w-full">
                        <div
                            class="w-full px-4 py-4 rounded-2xl border-2 border-dashed border-gray-300 hover:border-primary transition-all cursor-pointer bg-white/70 text-center">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-gray-600 text-sm">Upload Foto Profil</span>
                            <input type="file" wire:model="photo" class="hidden" accept="image/*">
                        </div>
                    </label>
                    <!-- Progress Bar -->
                    <div x-show="isUploading" class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary h-2.5 rounded-full" x-bind:style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                </div>

                @error('photo')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <div class="mt-1">
                    <input type="text" wire:model.lazy="phone" placeholder="Masukkan nomor telepon"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                @error('phone')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="mt-1">
                    <input type="email" wire:model.lazy="email" placeholder="Masukkan email anda"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Member Type</label>
                <div class="relative fade-in stagger-5">
                    <select wire:model.lazy="member_type"
                        class="w-full px-4 py-4 rounded-2xl border-2 border-gray-200 focus:border-primary focus:ring-0 outline-none input-focus bg-white/70 text-gray-700">
                        <option value="" disabled selected>Pilih Tipe Member</option>
                        <option value="distributor">🏢 Distributor</option>
                        <option value="reseller">🛒 Reseller</option>
                        <option value="stockist">📦 Stockist</option>
                        <option value="retailer">🏪 Retailer</option>
                        <option value="agent">👤 Agent</option>
                        <option value="customer">🛍️ Customer</option>
                    </select>
                </div>
                @error('member_type')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="mt-1 relative">
                    <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.lazy="password"
                        placeholder="Masukkan password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                    <!-- Password Toggle Button -->
                    <button type="button" wire:click="togglePassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if ($showPassword)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            @endif
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Confirmation</label>
                <div class="mt-1 relative">
                    <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.lazy="password_confirmation"
                        placeholder="Masukkan konfirmasi password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">

                </div>
                @error('password_confirmation')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-xl font-medium hover:bg-primary/90 transition-colors">
                Register Now
            </button>

            <p class="text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary hover:underline">Login sekarang</a>
            </p>
        </form>
    </div>
</div>
