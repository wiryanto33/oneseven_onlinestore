<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Store;
use App\Models\Order;
use App\Services\BiteshipService;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\MidtransService;

class Checkout extends Component
{
    public $carts = [];
    public $total = 0;
    public $shippingServices = [];
    public $selectedService = null;
    public $shippingCost = 0;
    public $store;
    public $areas = [];

    protected $midtrans;

    public $shippingData = [
        'recipient_name' => '',
        'phone' => '',
        'area_id' => '',
        'shipping_address' => '',
        'noted' => ''
    ];

    protected $rules = [
        'shippingData.recipient_name' => 'required|min:3',
        'shippingData.phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'shippingData.area_id' => 'required',
        'shippingData.address_detail' => 'required|min:10',
        'selectedService' => 'required'
    ];

    public function boot(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function mount()
    {
        $this->loadCarts();
        if ($this->carts->isEmpty()) {
            return redirect()->route('home');
        }
        $this->store = Store::first();

        if (auth()->check()) {
            $user = auth()->user();
            $this->shippingData['recipient_name'] = $user->name;
        }
    }

    public function loadCarts()
    {
        $this->carts = Cart::where('user_id', auth()->id())
            ->with(['product', 'variant'])
            ->get();

        $this->calculateTotal();
    }

    public function searchAreas($query)
    {
        try {
            $shipping_api_key = $this->store['shipping_api_key'];
            $shipping = new BiteshipService($shipping_api_key);
            $this->areas = $shipping->searchAreas($query);
            return collect($this->areas)->map(function ($area) {
                return [
                    'id' => $area['id'],
                    'name' => "{$area['name']} ({$area['postal_code']})"
                ];
            });
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'message' => 'Gagal memuat data area: ' . $e->getMessage(),
                'type' => 'error'
            ]);
            return collect();
        }
    }

    public function updatedShippingDataAreaId($value)
    {
        if ($value) {
            $this->updatedSelectedService = null;
            $this->shippingCost = 0;
            $this->loadShippingRates(); 
        }
    }

    public function updatedSelectedService($value)
    {
        if ($value) {
            $serviceData = json_decode($value, true);
            $this->shippingCost = $serviceData['rate'] ?? 0;
        }
    }
    
    private function getWeight()
    {
        return $this->carts->sum(fn($cart) => ($cart->product->weight ?? 1000) * $cart->quantity);
    }

    private function loadShippingRates()
    {
        try {
            $store = $this->store;
            if (!$store->shipping_area_id) {
                throw new \Exception('Store location is not configured');
            }
            $shipping = new BiteshipService($store->shipping_api_key);
            
            $items = $this->carts->map(function ($cart) {
                // Get the correct price and weight based on variant
                $price = $cart->variant ? $cart->variant->price : $cart->product->price;
                $weight = $cart->product->weight ?? 100;
                return [
                    'name' => $cart->product->name,
                    'description' => substr($cart->product->description ?? '', 0, 100),
                    'value' => $price,
                    'weight' => $weight,
                    'quantity' => $cart->quantity,
                    'length' => $cart->product->length ?? 10,
                    'width' => $cart->product->width ?? 10,
                    'height' => $cart->product->height ?? 10,
                ];
            })->toArray();


            $rates = $shipping->getRates(
                $store->shipping_area_id,
                $this->shippingData['area_id'],
                $items
            );

            $this->shippingServices = collect($rates)->map(function ($rate) {
                return [
                    'courier_code' => $rate['courier_code'],
                    'courier_name' => $rate['courier_name'],
                    'courier_service_name' => $rate['courier_service_name'],
                    'courier_service_code' => $rate['courier_service_code'],
                    'description' => $rate['description'] ?? '',
                    'duration' => $rate['duration'],
                    'price' => $rate['price'] ?? 0,
                    'type' => $rate['type'] ?? '',
                    'cod_available' => $rate['available_for_cash_on_delivery'] ?? false
                ];
            })->toArray();

        } catch(\Exception $e) {
            $this->dispatch('showAlert', [
                'message' => 'Gagal memuat biaya pengiriman: '. $e->getMessage(),
                'type' => 'error'
            ]);
            $this->shippingServices = [];
        }
    }
    public function calculateTotal()
    {
        $this->total = 0;
        $this->totalItems = 0;

        foreach($this->carts as $cart) {
            $price = $cart->variant ? $cart->variant->price : $cart->product->price;
            $this->total += $price * $cart->quantity;
            $this->totalItems += $cart->quantity;
        }
    }

    public function render()
    {
        if ($this->carts->isEmpty()) {
            return redirect()->route('home');
        }
        return view('livewire.checkout')
            ->layout('components.layouts.app', ['hideBottomNav' => true]);
    }

    public function createOrder()
    {
        if (!$this->carts->isEmpty()) {
            try {
                if ($this->selectedService != null) {
                    $serviceData = json_decode($this->selectedService, true);
                } else {
                    $this->dispatch('showAlert', [
                        'message' => 'Mohon isi alamat tujuan dan ekspedisi',
                        'type' => 'error'
                    ]);
                    return;
                }

                $selectedArea = collect($this->areas)->firstWhere('id', $this->shippingData['area_id']);

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'subtotal' => $this->total,
                    'total_amount' => $this->total + $serviceData['price'],
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    'recipient_name' => $this->shippingData['recipient_name'],
                    'phone' => $this->shippingData['phone'],
                    'shipping_provider' => $this->store->shipping_provider,
                    'shipping_area_id' => $this->shippingData['area_id'],
                    'shipping_area_name' => $selectedArea['name'],
                    'shipping_cost' => $serviceData['price'],
                    'shipping_method_detail' => json_encode($serviceData),
                    'shipping_address' => $this->shippingData['shipping_address'],
                    'noted' => $this->shippingData['noted']
                ]);

                foreach($this->carts as $cart) {
                    // Get the correct price based on variant
                    $price = $cart->variant ? $cart->variant->price : $cart->product->price;
                    
                    // Create order item data
                    $orderItemData = [
                        'product_id' => $cart->product_id,
                        'product_name' => $cart->product->name,
                        'product_variant_id' => $cart->variant ? $cart->variant->id : null,
                        'quantity' => $cart->quantity,
                        'price' => $price
                    ];
                    
                    // Tambahkan informasi varian jika ada
                    if ($cart->variant) {
                        // Simpan variant_name (gabungan semua varian)
                        $orderItemData['variant_name'] = $cart->variant->variant_name;
                        
                        // Simpan variant type 1 dan option 1
                        if ($cart->variant->variant_type1 && $cart->variant->variant_option1) {
                            $orderItemData['variant_type1'] = $cart->variant->variant_type1;
                            $orderItemData['variant_option1'] = $cart->variant->variant_option1;
                        }
                        
                        // Simpan variant type 2 dan option 2 jika ada
                        if ($cart->variant->variant_type2 && $cart->variant->variant_option2) {
                            $orderItemData['variant_type2'] = $cart->variant->variant_type2;
                            $orderItemData['variant_option2'] = $cart->variant->variant_option2;
                        }
                    }
                    
                    // Buat order item
                    $order->items()->create($orderItemData);
                }

                Cart::where('user_id', auth()->id())->delete();

                Notification::route('mail', $this->store->email_notification)
                    ->notify(new NewOrderNotification($order));

                if ($this->store->is_use_payment_gateway) {
                    $result = $this->midtrans->createTransaction($order, $order->items);

                    if (!$result['success']) {
                        throw new \Exception($result['message']);
                    }
    
                    $order->update(['payment_gateway_transaction_id' => $result['token']]);

                    $this->dispatch('payment-success', [
                        'payment_gateway_transaction_id' => $result['token'],
                        'order_id' => $order->order_number
                    ]);
                } else {
                    return redirect()->route('orders');
                }
                
            } catch(\Exception $e) {
                $this->dispatch('showAlert', [
                    'message' => $e->getMessage(),
                    'type' => 'error'
                ]);
            }
        } else {
            $this->dispatch('showAlert', [
                'message' => 'Keranjang belanja kosong',
                'type' => 'error'
            ]);
        }
    }
}