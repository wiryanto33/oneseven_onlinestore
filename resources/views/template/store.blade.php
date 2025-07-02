<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6666',
                        secondary: '#818CF8',
                        accent: '#C7D2FE',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Main Container -->
    <div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg pb-[70px]">
        <!-- Banner -->
        <div class="h-[180px] relative overflow-hidden bg-gradient-to-br from-primary to-secondary">
            <div class="absolute inset-0 opacity-50 pattern-dots"></div>
        </div>
        
        <!-- Profile Section -->
        <div class="px-5 relative -mt-10">
            <div class="w-[90px] h-[90px] bg-gradient-to-br from-primary to-secondary rounded-[20px] flex items-center justify-center shadow-lg transform rotate-[5deg]">
                <img src="https://dewakoding.com/user/img/logo.png" alt="Store" 
                     class="w-[45px] h-[45px] brightness-0 invert transform -rotate-[5deg]">
            </div>
            <h4 class="mt-3 mb-1 text-gray-800 font-semibold text-xl">Dewakoding Store</h4>
            <p class="text-gray-500 text-sm">Temukan koleksi fashion terkini dengan berbagai pilihan style dan warna yang menarik.</p>
        </div>
        
        <!-- Navigation Tabs -->
        <div class="mt-5 px-2.5 overflow-x-auto hide-scrollbar">
            <div class="flex gap-2.5 pb-2.5 whitespace-nowrap">
                <a href="#" class="px-6 h-10 flex items-center rounded-full bg-primary text-white border border-primary">
                    Semua
                </a>
                <a href="#" class="px-6 h-10 flex items-center rounded-full text-gray-600 border border-gray-200 hover:border-primary hover:text-primary transition-colors">
                    Kaos Polos
                </a>
                <a href="#" class="px-6 h-10 flex items-center rounded-full text-gray-600 border border-gray-200 hover:border-primary hover:text-primary transition-colors">
                    Kaos Motif
                </a>
            </div>
        </div>

        <div class="p-3">
            <div class="grid grid-cols-2 gap-3">
                <!-- Product Card 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative">
                        <span class="absolute top-2.5 left-2.5 bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-full">
                            Baru
                        </span>
                        <img src="https://i.ibb.co.com/JtLB93y/annoyed-young-pretty-girl-putting-fingers-ears-with-closed-eyes-min.jpg" 
                             alt="Kaos Polos Motif Putih" 
                             class="w-full h-[180px] object-cover">
                    </div>
                    <div class="p-3">
                        <h6 class="text-sm font-medium text-gray-700 line-clamp-2">Kaos Polos Motif Putih</h6>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs text-gray-500">Rp</span>
                            <span class="text-primary font-semibold">125.000</span>
                        </div>
                    </div>
                </div>
        
                <!-- Product Card 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative">
                        <span class="absolute top-2.5 left-2.5 bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-full">
                            Baru
                        </span>
                        <img src="https://i.ibb.co.com/L0hNqt6/man-wearing-t-shirt-gesturing-min.jpg" 
                             alt="Kaos Polos Abu Motif" 
                             class="w-full h-[180px] object-cover">
                    </div>
                    <div class="p-3">
                        <h6 class="text-sm font-medium text-gray-700 line-clamp-2">Kaos Polos Abu Motif</h6>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs text-gray-500">Rp</span>
                            <span class="text-primary font-semibold">115.000</span>
                        </div>
                    </div>
                </div>
        
                <!-- Product Card 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative">
                        <span class="absolute top-2.5 left-2.5 bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-full">
                            Baru
                        </span>
                        <img src="https://i.ibb.co.com/fp3s0b6/pleased-young-pretty-girl-doing-ok-sign-min.jpg" 
                             alt="Kaos Hitam Motif Doff" 
                             class="w-full h-[180px] object-cover">
                    </div>
                    <div class="p-3">
                        <h6 class="text-sm font-medium text-gray-700 line-clamp-2">Kaos Hitam Motif Doff</h6>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs text-gray-500">Rp</span>
                            <span class="text-primary font-semibold">135.000</span>
                        </div>
                    </div>
                </div>
        
                <!-- Product Card 4 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative">
                        <span class="absolute top-2.5 left-2.5 bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-full">
                            Baru
                        </span>
                        <img src="https://i.ibb.co.com/rpJQ8zG/excited-looking-up-young-handsome-guy-wearing-black-t-shirt-spreading-hands-isolated-orange-wall-141.jpg" 
                             alt="Kaos Coklat Hitam" 
                             class="w-full h-[180px] object-cover">
                    </div>
                    <div class="p-3">
                        <h6 class="text-sm font-medium text-gray-700 line-clamp-2">Kaos Coklat Hitam</h6>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs text-gray-500">Rp</span>
                            <span class="text-primary font-semibold">99.000</span>
                        </div>
                    </div>
                </div>
        
                <!-- Product Card 5 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative">
                        <span class="absolute top-2.5 left-2.5 bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-full">
                            Baru
                        </span>
                        <img src="https://i.ibb.co.com/TcdPpL3/charming-emotive-caucasian-woman-pointing-down-her-t-shirt-while-smiling-joyfully-expressing-positiv.jpg" 
                             alt="Kaos Putih Motif Coklat" 
                             class="w-full h-[180px] object-cover">
                    </div>
                    <div class="p-3">
                        <h6 class="text-sm font-medium text-gray-700 line-clamp-2">Kaos Putih Motif Coklat</h6>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs text-gray-500">Rp</span>
                            <span class="text-primary font-semibold">115.000</span>
                        </div>
                    </div>
                </div>
        
                <!-- Product Card 6 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative">
                        <span class="absolute top-2.5 left-2.5 bg-primary/90 text-white text-xs font-medium px-3 py-1 rounded-full">
                            Baru
                        </span>
                        <img src="https://i.ibb.co.com/TcdPpL3/charming-emotive-caucasian-woman-pointing-down-her-t-shirt-while-smiling-joyfully-expressing-positiv.jpg" 
                             alt="Kaos Casual Lengan Panjang" 
                             class="w-full h-[180px] object-cover">
                    </div>
                    <div class="p-3">
                        <h6 class="text-sm font-medium text-gray-700 line-clamp-2">Kaos Casual Lengan Panjang</h6>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs text-gray-500">Rp</span>
                            <span class="text-primary font-semibold">145.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        Last edited just now

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white border-t border-gray-200 h-[70px] z-50">
            <div class="grid grid-cols-3 h-full">
                <a href="#" class="flex flex-col items-center justify-center text-primary">
                    <i class="bi bi-house text-2xl mb-0.5"></i>
                    <span class="text-xs">Beranda</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center text-gray-500 hover:text-primary transition-colors">
                    <i class="bi bi-bag text-2xl mb-0.5"></i>
                    <span class="text-xs">Keranjang</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center text-gray-500 hover:text-primary transition-colors">
                    <i class="bi bi-receipt text-2xl mb-0.5"></i>
                    <span class="text-xs">Pesanan</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Hide Scrollbar Style -->
    <style>
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .pattern-dots {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>