<div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg pb-[70px]">
        <!-- Header with Back Button -->
        <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white z-50">
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100">
                <div class="flex items-center">
                        <button onclick="history.back()" class="p-2 hover:bg-gray-50 rounded-full">
                            <i class="bi bi-arrow-left text-xl"></i>
                        </button>
                        <h1 class="ml-2 text-lg font-medium">Detail Produk</h1>
                </div>

                <a href="{{route('shopping-cart')}}" class="relative p-2">
                    <i class="bi bi-cart text-xl"></i>
                    <div class="absolute -top-1 -right-1 bg-primary text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                        {{$cartCount}}
                    </div>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="pt-16">
            <!-- Product Images Slider -->
            <div class="relative bg-gray-100 h-[400px] flex items-center justify-center">
                @if($currentImage)
                    <img src="{{ url('storage/'. $currentImage)}}" 
                        alt="{{$product->name}}" 
                        class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('image/no-pictures.png') }}" 
                        alt="No image available" 
                        class="w-1/3 h-auto object-contain opacity-60">
                @endif

                @if(count($images) > 1)
                    <button wire:click="previousImage"
                            class="absolute left-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/50 text-white"
                            @if($currentImageIndex == 0) disabled @endif>
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <button wire:click="nextImage"
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/50 text-white"
                        @if($currentImageIndex == count($images) - 1) disabled @endif>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                @endif
                
                @if(count($images) > 0)
                    <!-- Image Counter -->
                    <div class="absolute bottom-4 right-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                        {{$currentImageIndex + 1}}/{{count($images)}}
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{$product->name}}</h2>
                        <div class="mt-1 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-primary">Rp {{number_format($displayPrice, 0, ',', '.')}}</span>
                        </div>
                    </div>
                </div>
                <!-- Display stock directly for products without variants -->
                @if(!$hasVariants)
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium">Stok:</span>
                        <span class="text-sm text-gray-600">{{$product->stock}}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Variant Selector (if product has variants) -->
            @if($hasVariants && count($variantTypes) > 0)
            <div class="p-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold mb-3">Pilih Varian</h3>
                
                @foreach($variantTypes as $typeName => $options)
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">{{$typeName}}</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($options as $option)
                        <button
                            wire:click="selectOption('{{$typeName}}', '{{$option}}')"
                            class="px-3 py-2 border rounded-md text-sm
                                {{isset($selectedOptions[$typeName]) && $selectedOptions[$typeName] === $option 
                                    ? 'border-primary bg-primary/5 text-primary' 
                                    : 'border-gray-200 text-gray-700'}}">
                            {{$option}}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                <!-- Show selected variant information -->
                @if($selectedVariant)
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                    
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-sm font-medium">Stok:</span>
                        <span class="text-sm text-gray-600">{{$selectedVariant->stock}}</span>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Product Description -->
            <div class="p-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold mb-3">Deskripsi Produk</h3>
                <div class="space-y-2 text-gray-600 text-sm">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        <!-- Bottom Navigation for Add to Cart & Buy -->
        <div class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white border-t border-gray-100 p-4 z-50">
            <div class="flex gap-3">
                <button 
                    wire:click="addToCart({{$product->id}})" 
                    class="flex-1 h-12 flex items-center justify-center rounded-full bg-primary text-white font-medium hover:bg-primary/90 transition-colors
                        {{($hasVariants && !$selectedVariantId) ? 'opacity-75' : ''}}">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>