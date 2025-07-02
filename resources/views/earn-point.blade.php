<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumpulkan Poin - Oneseven Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg">
        <!-- Header -->
        <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white z-50">
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100">
                <div class="flex items-center">
                    <button onclick="history.back()" class="p-2 hover:bg-gray-50 rounded-full">
                        <i class="bi bi-arrow-left text-xl"></i>
                    </button>
                    <h1 class="ml-2 text-lg font-medium">Kumpulkan Poin</h1>
                </div>

                <!-- User Points Display -->
                <div class="flex items-center bg-orange-50 px-3 py-1 rounded-full">
                    <i class="bi bi-coin text-orange-500 mr-1"></i>
                    <span class="text-sm font-medium text-orange-700">{{ number_format($totalPoints) }} pt</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="pt-16 pb-20">
            <!-- Hero Section -->
            <div class="bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 text-white p-6 m-4 rounded-xl">
                <div class="text-center">
                    <i class="bi bi-gem text-4xl mb-3"></i>
                    <h2 class="text-xl font-bold mb-2">Kumpulkan Poin Lebih Banyak!</h2>
                    <p class="text-sm opacity-90 mb-4">Tukar poin dengan hadiah menarik dari Oneseven Store</p>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <p class="text-xs opacity-90">Total Poin Saya</p>
                        <p class="text-2xl font-bold">{{ number_format($totalPoints) }}</p>
                    </div>
                </div>
            </div>

            <!-- Point Sources -->
            <div class="px-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cara Mendapatkan Poin</h3>

                <div class="space-y-3">
                    @foreach ($pointSources as $source)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4">
                                    <i class="{{ $source['icon'] }} text-xl text-blue-500"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 mb-1">{{ $source['title'] }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $source['description'] }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-green-600">{{ $source['points'] }}</span>
                                        <button class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                                            Mulai →
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 px-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('rewards') }}"
                        class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-4 rounded-lg text-center hover:from-purple-600 hover:to-pink-600 transition-colors">
                        <i class="bi bi-gift text-2xl mb-2"></i>
                        <p class="text-sm font-medium">Lihat Hadiah</p>
                    </a>

                    <a href="{{ route('reward.history') }}"
                        class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white p-4 rounded-lg text-center hover:from-blue-600 hover:to-cyan-600 transition-colors">
                        <i class="bi bi-clock-history text-2xl mb-2"></i>
                        <p class="text-sm font-medium">Riwayat</p>
                    </a>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="mt-8 mx-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="bi bi-lightbulb text-green-600 text-lg mr-3 mt-0.5"></i>
                        <div>
                            <h4 class="font-medium text-green-800 mb-2">Tips Mengumpulkan Poin</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Login setiap hari untuk bonus harian</li>
                                <li>• Ajak teman untuk bonus referral besar</li>
                                <li>• Berikan review setelah pembelian</li>
                                <li>• Share produk favorit di media sosial</li>
                                <li>• Manfaatkan promo double points</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
