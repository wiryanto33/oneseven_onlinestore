<div class="max-w-[480px] mx-auto bg-white min-h-screen relative shadow-lg pb-[140px]">
    <!-- Header -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white z-50">
        <div class="flex items-center h-16 px-4 border-b border-gray-100">
            <button onclick="history.back()" class="p-2 hover:bg-gray-50 rounded-full">
                <i class="bi bi-arrow-left text-xl"></i>
            </button>
            <h1 class="ml-2 text-lg font-medium">Checkout</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-20 pb-12 px-4 space-y-8">
        <!-- Section 1: Order Summary -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <i class="bi bi-cart-check text-lg text-primary"></i>
                <h2 class="text-lg font-medium">Ringkasan Pesanan</h2>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <div class="space-y-4">
                    @foreach($carts as $cart)
                        <div class="flex gap-3">
                            <img src="{{$cart->product->first_image_url ?? asset('image/no-pictures.png')}}" 
                                alt="{{$cart->product->name}}" 
                                class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium line-clamp-2">{{$cart->product->name}}</h3>
                                
                                @if($cart->variant)
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{$cart->variant->variant_name}}
                                    </div>
                                @endif
                                
                                @php
                                    $price = $cart->variant ? $cart->variant->price : $cart->product->price;
                                @endphp
                                
                                <div class="text-sm text-gray-500 mt-1">{{$cart->quantity}} x Rp {{number_format($price)}}</div>
                                <div class="text-primary font-medium">Rp {{number_format($price * $cart->quantity)}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section 2: Recipient Information -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <i class="bi bi-person text-lg text-primary"></i>
                <h2 class="text-lg font-medium">Data Penerima</h2>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4 space-y-4">
                <!-- Name -->
                <div>
                    <label class="text-sm text-gray-600 mb-1.5 block">Nama Lengkap</label>
                    <input type="text" 
                        wire:model="shippingData.recipient_name"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Masukkan nama lengkap penerima">
                </div>

                <!-- Phone -->
                <div>
                    <label class="text-sm text-gray-600 mb-1.5 block">Nomor Telepon</label>
                    <input wire:model="shippingData.phone"   
                        type="tel" 
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Contoh: 08123456789">
                </div>
            </div>
        </div>

        <!-- Section 3: Shipping Address -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <i class="bi bi-geo-alt text-lg text-primary"></i>
                <h2 class="text-lg font-medium">Alamat Pengiriman</h2>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4 space-y-4">
                <!-- Area Search -->
                <div x-data="{ 
                    open: false,
                    search: '',
                    areaName: '',
                    selectedId: @entangle('shippingData.area_id')
                }"
                x-init="$watch('selectedId', value => {
                    if (!value) {
                        areaName = '';
                    }
                })"
                class="relative">
                    <label class="text-sm text-gray-600 mb-1.5 block">Cari Lokasi</label>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <input type="text" 
                                x-model="search"
                                x-on:focus="open = true"
                                x-on:input.debounce.500ms="$wire.searchAreas($event.target.value)"
                                placeholder="Ketik nama kota atau kecamatan..."
                                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                            
                            <!-- Selected Area Display -->
                            <div x-show="selectedId && areaName" x-cloak
                                class="mt-2 p-2 bg-primary/10 rounded-lg text-sm">
                                <i class="bi bi-geo-fill text-primary"></i>
                                <span x-text="areaName" class="font-medium"></span>
                                <button @click="selectedId = ''; areaName = ''; search = ''" 
                                    class="ml-2 text-red-500 hover:text-red-600">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Area Suggestions -->
                    <div x-show="open && search.length > 2" x-cloak
                        @click.away="open = false"
                        class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <div class="p-2">
                            <template x-if="$wire.areas.length > 0">
                                <div class="space-y-1">
                                    <template x-for="area in $wire.areas" :key="area.id">
                                        <button 
                                            @click="
                                                selectedId = area.id; 
                                                areaName = area.name; 
                                                open = false; 
                                                search = '';
                                                $wire.set('shippingData.area_id', area.id);
                                            "
                                            class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <div class="flex items-center">
                                                <i class="bi bi-geo-alt text-primary mr-2"></i>
                                                <div>
                                                    <div x-text="area.name" class="font-medium"></div>
                                                    <div x-text="`Kode Pos: ${area.postal_code}`" class="text-sm text-gray-500"></div>
                                                </div>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </template>
                            <template x-if="search.length > 2 && $wire.areas.length === 0">
                                <div class="text-center py-3 text-gray-500">
                                    <i class="bi bi-search text-2xl mb-2 block"></i>
                                    Lokasi tidak ditemukan
                                </div>
                            </template>
                            <template x-if="search.length <= 2">
                                <div class="text-center py-3 text-gray-500">
                                    Ketik minimal 3 karakter untuk mencari
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

               
                <div>
                    <label class="text-sm text-gray-600 mb-1.5 block">Layanan Pengiriman</label>
                    <select
                        wire:model.live="selectedService"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Pilih Layanan Pengiriman</option>
                        @foreach($shippingServices as $service)
                            <option value="{{ json_encode([
                                    'code' => $service['courier_code'],
                                    'courier_name' => $service['courier_name'],
                                    'service' => $service['courier_service_name'],
                                    'duration' => $service['duration'],
                                    'price' => $service['price'],
                                    'description' => $service['description']
                                ]) }}">
                                {{$service['courier_name']}} - {{$service['courier_service_name']}}
                                ({{$service['duration']}}) - Rp. {{number_format($service['price'])}}
                                @if($service['cod_available'])
                                    ✓ COD
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @if($selectedService)
                        @php
                            $selected = json_decode($selectedService, true);
                        @endphp
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm">
                            <div class="font-medium">Detail Pengiriman:</div>
                            <div class="text-gray-600">Ekspedisi: {{ $selected['courier_name'] }}</div>
                            <div class="text-gray-600">Nama Layanan: {{ $selected['service'] }}</div>
                            
                            @if($selected['description'])
                                <div class="text-gray-600 mt-1">Deksripsi: {{ $selected['description'] }}</div>
                            @endif
                        
                            <div class="text-gray-600">Estimasi: {{ $selected['duration'] }}</div>
                            <div class="text-gray-600">Biaya: Rp {{ number_format($selected['price']) }}</div>
                        </div>
                    @endif

                </div>
                 <!-- Detailed Address -->
                 <div>
                    <label class="text-sm text-gray-600 mb-1.5 block">Detail Alamat</label>
                    <textarea 
                        wire:model.live="shippingData.shipping_address"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary"
                        rows="3"
                        placeholder="Nama jalan, nomor rumah, RT/RW, patokan"></textarea>
                </div>
            </div>
            
        </div>

    

        <!-- Section 5: Additional Notes -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <i class="bi bi-pencil text-lg text-primary"></i>
                <h2 class="text-lg font-medium">Catatan Tambahan</h2>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <textarea 
                    wire:model.live="shippingData.noted"
                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary"
                    rows="2"
                    placeholder="Catatan untuk kurir (opsional)"></textarea>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Section -->
    <div class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white border-t border-gray-100 p-4 z-50">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm text-gray-600">Total Pembayaran:</p>
                <p class="text-lg font-semibold text-primary">Rp {{number_format($total + $shippingCost)}}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">{{count($carts)}} Produk</p>
            </div>
        </div>

        <button 
            wire:click="createOrder"
            class="w-full h-12 flex items-center justify-center gap-2 rounded-full bg-primary text-white font-medium hover:bg-primary/90 transition-colors">
            <i class="bi bi-bag-check"></i>
            Buat Pesanan
        </button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('payment-success', (data) => {
                const snapToken = data[0].payment_gateway_transaction_id;
                const orderId = data[0].order_id;

                if (snapToken) {
                    try {
                        window.snap.pay(snapToken, {
                            onSuccess: function(result) {
                                window.location.href = `/order-detail/${orderId}`;
                            },
                            onPending: function(result) {
                                window.location.href = `/order-detail/${orderId}`;
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal! Silakan coba lagi.');
                            },
                            onClose: function() {
                                alert('Anda menutup halaman pembayaran sebelum menyelesaikan transaksi');
                                window.location.href = `/`;
                            }
                        });
                    } catch (error) {
                        alert('Terjadi kesalahan saat membuka popup pembayaran');
                    }
                }
            });
        });
    </script>
@endpush