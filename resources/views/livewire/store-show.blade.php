<!-- Main Container -->
<div class="max-w-[480px] mx-auto bg-gray-50 min-h-screen relative shadow-xl pb-[80px]">
    <!-- Banner Section with improved aspect ratio -->
    <div id="BannerSlider" class="swiper h-80 w-full relative rounded-b-3xl overflow-hidden">
        <div class="swiper-wrapper">
            @if (!empty($store->bannerUrl) && count($store->bannerUrl) > 0)
                @foreach ($store->bannerUrl as $bannerUrl)
                    <div class="swiper-slide relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent z-10">
                        </div>
                        <img src="{{ $bannerUrl ?? asset('image/no-pictures.png') }}" alt="banner"
                            class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                    </div>
                @endforeach
            @else
                <div
                    class="swiper-slide bg-gradient-to-br from-slate-500 via-slate-600 to-slate-700 flex items-center justify-center relative">
                    <!-- Decorative Pattern -->
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60"
                        viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none"
                        fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30"
                        cy="30" r="4" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
                    <div class="text-white text-center z-10">
                        <div
                            class="w-20 h-20 mx-auto mb-4 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/30">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                                <path fill-rule="evenodd"
                                    d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold mb-2">Selamat Datang</h2>
                        <p class="text-sm opacity-90">di Toko Kami</p>
                    </div>
                </div>
            @endif
        </div>
        <!-- Enhanced Pagination Dots -->
        <div class="swiper-pagination !bottom-4 z-20"></div>
    </div>

    <!-- Enhanced Profile Section -->
    <div class="px-6 relative -mt-20 mb-8 z-30">
        <!-- Logo Container -->
        <div class="relative mb-1 z-40">
            <div class="w-32 h-32 flex items-center justify-center p-4 relative z-50">
                <img src="{{ $store->imageUrl ?? asset('image/no-pictures.png') }}" alt="Logo"
                    class="w-full h-full">
            </div>
            <!-- Verified Badge -->
            <div
                class="absolute -top-2 -right-2 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shadow-lg border-3 border-white z-50">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>

        <!-- Store Info Card -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 relative z-30">
            <div class="space-y-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 leading-tight mb-2">{{ $store->name ?? 'Toko' }}
                        </h1>
                        <div class="flex items-center gap-3 mb-3">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700 border border-green-200">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                Online
                            </span>
                            <span class="text-sm text-gray-500">• Terverifikasi</span>
                        </div>
                    </div>
                </div>

                <p class="text-gray-700 text-sm leading-relaxed">{{ $store->description ?? 'Toko' }}</p>

                <!-- Stats Row -->
                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-1 text-amber-500 mb-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="text-sm font-bold text-gray-900">4.8</span>
                        </div>
                        <p class="text-xs text-gray-600 font-medium">Rating</p>
                    </div>
                    <div class="text-center border-x border-gray-200">
                        <div class="text-sm font-bold text-gray-900 mb-1">500+</div>
                        <p class="text-xs text-gray-600 font-medium">Produk</p>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-bold text-gray-900 mb-1">1.2K+</div>
                        <p class="text-xs text-gray-600 font-medium">Terjual</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rewards Section -->
    <div class="px-6 mb-6">
        <a href="{{ route('rewards') }}" class="block">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:bg-secondary">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">ONESEVEN REWARDS</h2>
                        <p class="text-gray-600 text-sm">BELANJA DAN DAPATKAN REWARD</p>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="{{ asset('image/mobil.png') }}" width="120" alt="Reward" class="opacity-90">
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div class="px-6 mb-6">
        <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-100">
            <div class="flex gap-2 overflow-x-auto hide-scrollbar scroll-x-snap">
                <!-- Tombol Semua -->
                <button wire:click="setCategory('all')"
                    class="px-5 h-10 flex items-center rounded-xl border text-sm font-semibold whitespace-nowrap
                        transition-all duration-300
                        {{ $selectedCategory === 'all'
                            ? 'bg-primary text-white border-primary shadow-sm'
                            : 'text-gray-600 border-gray-200 hover:border-primary hover:text-primary' }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Semua
                </button>

                <!-- Tombol Kategori -->
                @foreach ($categories as $category)
                    <button wire:click="setCategory('{{ $category->id }}')"
                        class="px-5 h-10 flex items-center rounded-xl border text-sm font-semibold whitespace-nowrap
                            transition-all duration-300
                            {{ $selectedCategory == $category->id
                                ? 'bg-primary text-white border-primary shadow-sm'
                                : 'text-gray-600 border-gray-200 hover:border-primary hover:text-primary' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="px-6">
        @if ($products->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-12 text-center shadow-lg border border-gray-100">
                <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Belum Ada Produk</h3>
                <p class="text-gray-600 text-sm max-w-xs mx-auto leading-relaxed mb-6">
                    @if ($selectedCategory !== 'all')
                        Produk dalam kategori ini akan segera hadir. Cek kategori lain atau kembali lagi nanti!
                    @else
                        Toko sedang mempersiapkan produk-produk menarik untuk Anda. Nantikan ya!
                    @endif
                </p>
                <button
                    class="px-6 py-3 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                    Jelajahi Kategori Lain
                </button>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-2 gap-4">
                @foreach ($products as $item)
                    <div
                        class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <a href="{{ route('product.detail', ['slug' => $item->slug]) }}" wire:navigate>
                            <!-- Product Image -->
                            <div class="relative h-[180px] bg-gray-100 overflow-hidden">
                                @if ($item->first_image_url)
                                    <img src="{{ $item->first_image_url }}" alt="{{ $item->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Favorite Button -->
                                <button
                                    class="absolute top-3 right-3 w-9 h-9 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white hover:scale-110 transition-all duration-200">
                                    <svg class="w-4 h-4 text-gray-600 hover:text-red-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Sale Badge -->
                                @if ($item->discount)
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="bg-primary text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">SALE</span>
                                    </div>
                                @else
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="bg-blue-800 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">NEW</span>
                                    </div>
                                @endif

                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h3
                                    class="text-sm font-bold text-gray-900 line-clamp-2 mb-3 leading-snug group-hover:text-gray-700 transition-colors">
                                    {{ $item->name }}
                                </h3>

                                <!-- Price Section -->
                                <div class="space-y-2 mb-4">
                                    @if ($item->has_variants)
                                        <p class="text-xs text-gray-500 font-medium">Mulai dari</p>
                                    @endif
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-xs text-gray-500 font-medium">Rp</span>
                                        <span
                                            class="text-lg font-bold text-gray-900">{{ number_format($item->display_price, 0, ',', '.') }}</span>
                                    </div>
                                    <!-- Original price (if on sale) -->
                                    @if ($item->discount)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-400 line-through">Rp
                                                {{ number_format($item->display_price * (1 + $item->discount / 100), 0, '.', '.') }}</span>
                                            <span class="text-xs font-bold text-red-500">{{ $item->discount }}%
                                                OFF</span>
                                        </div>
                                    @endif

                                </div>

                                <!-- Product Stats -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                    <div class="flex items-center gap-1">
                                        <div class="flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $item->rating ? 'text-amber-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span
                                            class="text-xs text-gray-600 font-semibold ml-1">{{ $item->rating ?? 0 }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        <span class="text-xs text-gray-600 font-medium">{{ $item->terjual ?? 0 }}
                                            terjual</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button -->
            @if ($showLoadMore)
                <div class="mt-8 text-center">
                    <button wire:click="loadMore" wire:loading.attr="disabled"
                        class="group px-10 py-4 bg-primary text-white rounded-2xl font-semibold hover:bg-secondary transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 flex items-center gap-3 mx-auto disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="loadMore">Lihat Lebih Banyak</span>
                        <span wire:loading wire:target="loadMore"></span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove wire:target="loadMore">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                        <svg class="animate-spin w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            wire:loading wire:target="loadMore">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2v4m0 12v4m8-8h-4M4 12H0"></path>
                        </svg>
                    </button>
                </div>
            @endif
        @endif
    </div>

    <!-- Custom Styles -->
    <style>
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.6);
            opacity: 1;
            width: 8px;
            height: 8px;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: white;
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease;
        }

        /* Logo positioning */
        .logo-container {
            position: relative;
            z-index: 1000 !important;
        }

        .logo-container>div {
            position: relative;
            z-index: 1001 !important;
        }

        /* Improved card hover effects */
        .group:hover {
            transform: translateY(-4px);
        }

        /* Better spacing and typography */
        .text-balance {
            text-wrap: balance;
        }

        /* Loading animation */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</div>
