<div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg">
    <!-- Header -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white z-50">
        <div class="flex items-center h-16 px-4 border-b border-gray-100">
            <button onclick="history.back()" class="p-2 hover:bg-gray-50 rounded-full">
                <i class="bi bi-arrow-left text-xl"></i>
            </button>
            <h1 class="ml-2 text-lg font-medium">Profil Saya</h1>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="fixed top-20 left-1/2 -translate-x-1/2 w-full max-w-[480px] px-4 z-40">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Profile Content -->
    <div class="pt-16">
        <!-- Profile Header -->
        <div class="bg-gradient-to-br from-primary to-secondary p-6 relative">
            <div class="flex items-center gap-4">
                <div
                    class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center overflow-hidden relative">
                    @if ($photo)
                        <img src="{{ $photo }}" alt="Profile Photo"
                            class="w-full h-full object-cover rounded-full">
                    @else
                        <img src="{{ asset('image/no-pictures.png') }}" alt="No Profile Photo"
                            class="w-full h-full object-cover rounded-full">
                    @endif
                    <!-- Edit Button Overlay -->
                    <div class="absolute inset-0 bg-black/30 rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer"
                        wire:click="openPhotoModal">
                        <i class="bi bi-camera text-white text-lg"></i>
                    </div>
                </div>
                <div class="text-white flex-1">
                    <h2 class="text-xl font-semibold">{{ $name }}</h2>
                    <p class="text-white/80">{{ $email }}</p>
                </div>
            </div>

            <!-- Edit Button Alternative - Top Right -->
            <button wire:click="openPhotoModal"
                class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                <i class="bi bi-pencil text-white text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Photo Modal -->
    @if ($showPhotoModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg w-full max-w-sm">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold">Edit Foto Profil</h3>
                </div>

                <!-- New Photo Preview -->
                @if ($newPhoto)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview Foto Baru</label>
                        <div
                            class="w-24 h-24 rounded-full mx-auto bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ $newPhoto->temporaryUrl() }}" alt="New Photo Preview"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <div class="p-4">
                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto Baru</label>
                        <input type="file" wire:model="newPhoto" accept="image/*"
                            class="w-full p-2 border border-gray-300 rounded-lg">
                        @error('newPhoto')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                </div>

                <div class="p-4 border-t flex gap-2">
                    @if ($photo)
                        <button wire:click="deletePhoto"
                            class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            Hapus Foto
                        </button>
                    @endif

                    <button wire:click="closePhotoModal"
                        class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </button>

                    @if ($newPhoto)
                        <button wire:click="updatePhoto"
                            class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Simpan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Profile Menu -->
    <div class="p-4 space-y-4">
        <!-- Account Settings -->
        <div class="space-y-2">
            <h3 class="text-sm font-medium text-gray-500">Akun</h3>
            <div class="space-y-1">
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank"
                    class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-whatsapp text-green-500"></i>
                        <span>Hubungi Toko via WhatsApp</span>
                    </div>
                    <i class="bi bi-chevron-right text-gray-400"></i>
                </a>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-envelope text-primary"></i>
                        <span>Email</span>
                    </div>
                    <span class="text-sm text-gray-600">{{ $email }}</span>
                </div>
            </div>
        </div>

        <!-- Member Info -->
        <div class="space-y-2">
            <h3 class="text-sm font-medium text-gray-500">Informasi Member</h3>
            <div class="space-y-1">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-award text-primary"></i>
                        <span>Status Member</span>
                    </div>
                    <span class="text-sm font-semibold text-primary">{{ ucfirst($member_type) }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-coin text-yellow-500"></i>
                        <span>Total Poin</span>
                    </div>
                    <span class="text-sm font-semibold text-yellow-600">{{ number_format($point) }} Poin</span>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <button wire:click="logout"
            class="w-full mt-6 p-4 text-red-500 flex items-center justify-center gap-2 bg-red-50 rounded-xl hover:bg-red-100">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar</span>
        </button>
    </div>
</div>
