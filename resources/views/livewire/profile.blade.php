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

    <!-- Profile Content -->
    <div class="pt-16">
        <!-- Profile Header -->
        <div class="bg-gradient-to-br from-primary to-secondary p-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                    @if ($photo)
                        <img src="{{ $photo }}" alt="Profile Photo"
                            class="w-full h-full object-cover rounded-full">
                    @else
                        <img src="{{ asset('image/no-pictures.png') }}" alt="No Profile Photo"
                            class="w-full h-full object-cover rounded-full">
                    @endif
                </div>
                <div class="text-white flex-1">
                    <h2 class="text-xl font-semibold">{{ $name }}</h2>
                    <p class="text-white/80">{{ $email }}</p>
                </div>
            </div>
        </div>
    </div>

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
</div>
