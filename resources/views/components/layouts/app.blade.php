<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name ?? 'Toko Online' }}</title>

    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/png" href="{{ $store->imageUrl ?? asset('image/store.png') }}">
    <link rel="apple-touch-icon" href="{{ $store->imageUrl ?? asset('image/store.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <meta name="msapplication-TileImage" content="{{ $store->imageUrl ?? asset('image/store.png') }}">
    <meta name="theme-color" content= "{{ $store->primary_color ?? '#ff6666' }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "{{ $store->primary_color ?? '#ff6666' }}",
                        secondary: "{{ $store->secondary_color ?? '#818CF8' }}",
                        accent: '#C7D2FE',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">

    {{ $slot }}
    @if (!isset($hideBottomNav))
        @livewire('components.bottom-navigation')
    @endif

    @livewire('components.alert')

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Required Alpine.js for toast notifications -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @livewireScripts
    @stack('scripts')

    <!-- Swiper Initialization Script -->
    <script>
        function initSwiper() {
            if (typeof Swiper !== 'undefined') {
                // Destroy existing swiper if exists
                if (window.bannerSwiper) {
                    window.bannerSwiper.destroy(true, true);
                }

                // Initialize new swiper
                window.bannerSwiper = new Swiper('#BannerSlider', {
                    direction: 'horizontal',
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    effect: 'slide',
                    slidesPerView: 1,
                    spaceBetween: 0,
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initSwiper, 100);
        });

        // Re-initialize after Livewire updates
        document.addEventListener('livewire:navigated', function() {
            setTimeout(initSwiper, 100);
        });

        // Also initialize after any Livewire update
        document.addEventListener('livewire:load', function() {
            setTimeout(initSwiper, 100);
        });
    </script>
</body>

</html>
