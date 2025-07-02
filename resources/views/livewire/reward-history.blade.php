<div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg">
    <!-- Header -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white z-50">
        <div class="flex items-center h-16 px-4 border-b border-gray-100">
            <button onclick="history.back()" class="p-2 hover:bg-gray-50 rounded-full">
                <i class="bi bi-arrow-left text-xl"></i>
            </button>
            <h1 class="ml-2 text-lg font-medium">Riwayat Penukaran</h1>
        </div>
    </div>

    <!-- Content -->
    <div class="pt-16 pb-20">
        @if($exchanges && count($exchanges) > 0)
            <div class="px-4 space-y-4">
                @foreach($exchanges as $exchange)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center flex-1">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    @if($exchange->reward->image)
                                        <img src="{{ asset('storage/' . $exchange->reward->image) }}"
                                             alt="{{ $exchange->reward->name }}"
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="bi bi-gift text-lg text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 truncate">
                                        {{ $exchange->reward->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $exchange->exchanged_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $exchange->status_badge }}">
                                {{ $exchange->status_text }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-coin mr-1"></i>
                                <span>{{ number_format($exchange->points_used) }} poin</span>
                            </div>

                            <button
                                wire:click="showDetail({{ $exchange->id }})"
                                class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                                Lihat Detail
                            </button>
                        </div>

                        <!-- Progress Indicator -->
                        <div class="mt-3">
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                <span>Progress</span>
                                <span>
                                    @switch($exchange->status)
                                        @case('pending')
                                            1/4 - Menunggu Persetujuan
                                            @break
                                        @case('approved')
                                            2/4 - Disetujui Admin
                                            @break
                                        @case('delivered')
                                            4/4 - Selesai
                                            @break
                                        @case('rejected')
                                            Ditolak
                                            @break
                                    @endswitch
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1">
                                <div class="bg-blue-500 h-1 rounded-full transition-all duration-300"
                                     style="width: {{
                                        match($exchange->status) {
                                            'pending' => '25%',
                                            'approved' => '50%',
                                            'delivered' => '100%',
                                            'rejected' => '0%',
                                            default => '0%'
                                        }
                                     }}"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 px-4">
                <div class="mb-4">
                    <i class="bi bi-clock-history text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-600 text-sm mb-6">
                    Kamu belum pernah menukar hadiah. Mulai kumpulkan poin dan tukar hadiah menarik!
                </p>
                <a href="{{ route('rewards') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                    <i class="bi bi-gift mr-2"></i>
                    Lihat Hadiah
                </a>
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedExchange)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg w-full max-w-sm mx-auto max-h-[80vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="p-4 border-b border-gray-200 sticky top-0 bg-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Detail Penukaran</h3>
                        <button wire:click="closeDetail" class="p-1 hover:bg-gray-100 rounded-full">
                            <i class="bi bi-x text-xl text-gray-500"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-4">
                    <!-- Reward Info -->
                    <div class="flex items-center mb-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                            @if($selectedExchange->reward->image)
                                <img src="{{ asset('storage/' . $selectedExchange->reward->image) }}"
                                     alt="{{ $selectedExchange->reward->name }}"
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <i class="bi bi-gift text-3xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-1">{{ $selectedExchange->reward->name }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ $selectedExchange->reward->description }}</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $selectedExchange->status_badge }}">
                                {{ $selectedExchange->status_text }}
                            </span>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="space-y-4">
                        <div>
                            <h5 class="font-medium text-gray-900 mb-3">Detail Transaksi</h5>
                            <div class="bg-gray-50 rounded-lg p-3 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">ID Transaksi:</span>
                                    <span class="font-mono">#{{ str_pad($selectedExchange->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tanggal Penukaran:</span>
                                    <span>{{ $selectedExchange->exchanged_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Poin Digunakan:</span>
                                    <span class="font-medium text-red-600">{{ number_format($selectedExchange->points_used) }} poin</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-medium">{{ $selectedExchange->status_text }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div>
                            <h5 class="font-medium text-gray-900 mb-3">Timeline</h5>
                            <div class="space-y-3">
                                <!-- Step 1: Submitted -->
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Permintaan Dikirim</p>
                                        <p class="text-xs text-gray-600">{{ $selectedExchange->exchanged_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Step 2: Processing -->
                                <div class="flex items-center">
                                    <div class="w-3 h-3 {{ in_array($selectedExchange->status, ['approved', 'delivered']) ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium {{ in_array($selectedExchange->status, ['approved', 'delivered']) ? 'text-gray-900' : 'text-gray-500' }}">
                                            Disetujui Admin
                                        </p>
                                        @if(in_array($selectedExchange->status, ['approved', 'delivered']))
                                            <p class="text-xs text-gray-600">{{ $selectedExchange->updated_at->format('d M Y, H:i') }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Menunggu persetujuan</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 3: Delivered -->
                                <div class="flex items-center">
                                    <div class="w-3 h-3 {{ $selectedExchange->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium {{ $selectedExchange->status === 'delivered' ? 'text-gray-900' : 'text-gray-500' }}">
                                            Hadiah Dikirim
                                        </p>
                                        @if($selectedExchange->status === 'delivered')
                                            <p class="text-xs text-gray-600">{{ $selectedExchange->updated_at->format('d M Y, H:i') }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Belum dikirim</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($selectedExchange->notes)
                            <div>
                                <h5 class="font-medium text-gray-900 mb-2">Catatan</h5>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-sm text-blue-800">{{ $selectedExchange->notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Status Specific Info -->
                        @if($selectedExchange->status === 'rejected')
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="bi bi-exclamation-triangle text-red-500 mr-2"></i>
                                    <div>
                                        <h6 class="font-medium text-red-800">Penukaran Ditolak</h6>
                                        <p class="text-sm text-red-700 mt-1">
                                            Mohon maaf, permintaan penukaran hadiah Anda ditolak. Poin telah dikembalikan ke akun Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($selectedExchange->status === 'pending')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="bi bi-clock text-yellow-500 mr-2"></i>
                                    <div>
                                        <h6 class="font-medium text-yellow-800">Menunggu Persetujuan</h6>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            Permintaan penukaran Anda sedang diproses. Harap menunggu konfirmasi dari admin.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($selectedExchange->status === 'delivered')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="bi bi-check-circle text-green-500 mr-2"></i>
                                    <div>
                                        <h6 class="font-medium text-green-800">Hadiah Berhasil Dikirim</h6>
                                        <p class="text-sm text-green-700 mt-1">
                                            Selamat! Hadiah Anda telah berhasil dikirim. Terima kasih telah menggunakan layanan kami.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    <button
                        wire:click="closeDetail"
                        class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
