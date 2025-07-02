<div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg">
    <!-- Header -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white z-50">
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100">
            <div class="flex items-center">
                <button onclick="history.back()" class="p-2 hover:bg-gray-50 rounded-full">
                    <i class="bi bi-arrow-left text-xl"></i>
                </button>
                <h1 class="ml-2 text-lg font-medium">Hadiah Oneseven Store</h1>
            </div>

            <!-- User Points Display -->
            <div class="flex items-center bg-orange-50 px-3 py-1 rounded-full">
                <i class="bi bi-coin text-orange-500 mr-1"></i>
                <span class="text-sm font-medium text-orange-700">{{ number_format($userPoints) }} pt</span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="pt-16 pb-20">
        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 m-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="bi bi-gift text-2xl mr-3"></i>
                    <div>
                        <h2 class="font-semibold">Tukar Poinmu!</h2>
                        <p class="text-sm opacity-90">Kumpulkan poin dan dapatkan hadiah menarik</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs opacity-80">Poin Saya</p>
                    <p class="text-xl font-bold">{{ number_format($userPoints) }}</p>
                </div>
            </div>
        </div>

        <!-- Rewards Grid -->
        <div class="px-4">
            @if ($rewards && count($rewards) > 0)
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($rewards as $reward)
                        <div
                            class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow relative">
                            <!-- Reward Image -->
                            <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                @if ($reward->image)
                                    <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <i class="bi bi-gift text-4xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Point Badge -->
                                <div
                                    class="absolute top-2 right-2 bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                    {{ number_format($reward->point) }} pt
                                </div>

                                <!-- Insufficient Points Overlay -->
                                @if ($userPoints < $reward->point)
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <div class="bg-white rounded-full p-2">
                                            <i class="bi bi-lock text-gray-600"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Reward Info -->
                            <div class="p-3">
                                <h3 class="font-medium text-sm text-gray-900 mb-1 line-clamp-2">
                                    {{ $reward->name }}
                                </h3>

                                @if ($reward->description)
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">
                                        {{ $reward->description }}
                                    </p>
                                @endif

                                <!-- Point Status -->
                                <div class="mb-2">
                                    @if ($userPoints >= $reward->point)
                                        <span class="text-xs text-green-600 flex items-center">
                                            <i class="bi bi-check-circle mr-1"></i>
                                            Poin mencukupi
                                        </span>
                                    @else
                                        <span class="text-xs text-red-600 flex items-center">
                                            <i class="bi bi-x-circle mr-1"></i>
                                            Kurang {{ number_format($reward->point - $userPoints) }} pt
                                        </span>
                                    @endif
                                </div>

                                <!-- Redeem Button -->
                                @if ($userPoints >= $reward->point)
                                    <button wire:click="selectReward({{ $reward->id }})"
                                        class="w-full bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium py-2 px-3 rounded-md transition-colors">
                                        Tukar Sekarang
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full bg-gray-300 text-gray-500 text-xs font-medium py-2 px-3 rounded-md cursor-not-allowed">
                                        Poin Tidak Cukup
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mb-4">
                        <i class="bi bi-gift text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Hadiah</h3>
                    <p class="text-gray-600 text-sm px-8">
                        Saat ini belum ada hadiah yang tersedia. Silakan cek kembali nanti!
                    </p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 mx-4 space-y-3">
            <a href="{{ route('reward.history') }}"
                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <i class="bi bi-clock-history text-lg text-gray-600 mr-3"></i>
                    <div>
                        <h3 class="font-medium text-gray-900">Riwayat Penukaran</h3>
                        <p class="text-sm text-gray-600">Lihat hadiah yang sudah ditukar</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right text-gray-400"></i>
            </a>

            <a href="{{ route('earn.points') }}"
                class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg hover:from-green-100 hover:to-blue-100 transition-colors">
                <div class="flex items-center">
                    <i class="bi bi-plus-circle text-lg text-green-600 mr-3"></i>
                    <div>
                        <h3 class="font-medium text-gray-900">Kumpulkan Poin</h3>
                        <p class="text-sm text-gray-600">Cara mendapatkan poin lebih banyak</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right text-gray-400"></i>
            </a>
        </div>

        <!-- Info Section -->
        <div class="mt-6 mx-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="bi bi-info-circle text-yellow-600 text-lg mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="font-medium text-yellow-800 mb-1">Cara Menukar Hadiah</h4>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Pastikan poin kamu mencukupi</li>
                            <li>• Tekan tombol "Tukar Sekarang"</li>
                            <li>• Konfirmasi penukaran hadiah</li>
                            <li>• Tunggu proses verifikasi admin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    @if ($showConfirmModal && $selectedReward)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg w-full max-w-sm mx-auto">
                <!-- Modal Header -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Penukaran</h3>
                </div>

                <!-- Modal Content -->
                <div class="p-4">
                    <!-- Reward Preview -->
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                            @if ($selectedReward->image)
                                <img src="{{ asset('storage/' . $selectedReward->image) }}"
                                    alt="{{ $selectedReward->name }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <i class="bi bi-gift text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $selectedReward->name }}</h4>
                            <p class="text-sm text-gray-600">{{ number_format($selectedReward->point) }} poin</p>
                        </div>
                    </div>

                    <!-- Point Summary -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Poin saat ini:</span>
                            <span class="font-medium">{{ number_format($userPoints) }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Poin yang digunakan:</span>
                            <span class="font-medium text-red-600">-{{ number_format($selectedReward->point) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between text-sm font-medium">
                            <span>Sisa poin:</span>
                            <span>{{ number_format($userPoints - $selectedReward->point) }}</span>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan (Opsional)
                        </label>
                        <textarea wire:model="exchangeNote" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm" rows="3"
                            placeholder="Tambahkan catatan untuk admin..."></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-gray-200 flex space-x-3">
                    <button wire:click="resetModal"
                        class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md text-sm font-medium">
                        Batal
                    </button>
                    <button wire:click="confirmExchange"
                        class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm font-medium">
                        Tukar Hadiah
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Toast Notification -->
    <div x-data="{ show: false, type: '', message: '' }"
        x-on:show-toast.window="show = true; type = $event.detail.type; message = $event.detail.message; setTimeout(() => show = false, 3000)"
        x-show="show" x-transition class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 max-w-sm w-full mx-4">
        <div :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error',
            'bg-yellow-500': type === 'warning',
            'bg-blue-500': type === 'info'
        }"
            class="text-white px-4 py-3 rounded-lg shadow-lg">
            <p class="text-sm font-medium" x-text="message"></p>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

</div>
