<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class BiteshipService
{
    protected $baseUrl = 'https://api.biteship.com';
    protected $apiKey;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function validateApiKey($apiKey)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey
            ])->get("{$this->baseUrl}/v1/maps/areas", [
                'countries' => 'ID',
                'input' => 'Jakarta',
                'type' => 'single'
            ]);
            
            return $response->successful() && !empty($response->json('areas'));
        } catch (\Exception $e) {
            return false;
        }
    }

    public function searchAreas($query)
    {
        try {
            if (!$this->apiKey) {
                throw new \Exception('API Key not set');
            }

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->get("{$this->baseUrl}/v1/maps/areas", [
                'countries' => 'ID',
                'input' => $query,
                'type' => 'single'
            ]);

            if (!$response->successful()) {
                Notification::make()
                    ->title('Invalid API Key')
                    ->danger()
                    ->send();
                return [];
            }

            $areas = $response->json('areas', []);
            if (empty($areas)) {
                Notification::make()
                    ->title('Invalid API Key')
                    ->danger()
                    ->send();
                return [];
            }

            return $areas;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Invalid API Key')
                ->danger()
                ->send();
            return [];
        }
    }

    public function getRates($originAreaId, $destinationAreaId, $items)
    {
        try {
            if (!$this->apiKey) {
                throw new \Exception('API Key not set');
            }

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post("{$this->baseUrl}/v1/rates/couriers", [
                'origin_area_id' => $originAreaId,
                'destination_area_id' => $destinationAreaId,
                'couriers' => 'jne,sicepat,jnt,pos',
                'items' => collect($items)->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'description' => $item['description'] ?? '',
                        'value' => $item['value'],
                        'length' => $item['length'] ?? 10,
                        'width' => $item['width'] ?? 10,
                        'height' => $item['height'] ?? 10,
                        'weight' => $item['weight'],
                        'quantity' => $item['quantity']
                    ];
                })->toArray()
            ]);


            if ($response->successful()) {
                \Log::info('Biteship Response:', $response->json());
                return $response->json('pricing', []);
            }

            if ($response->failed()) {
                \Log::error('Biteship Error:', $response->json());
                throw new \Exception($response->json('message', $response->json()));
            }

            return [];
        } catch (\Exception $e) {
            \Log::error('Biteship Exception:', ['message' => $e->getMessage()]);
            throw new \Exception('Error getting shipping rates: ' . $e->getMessage());
        }
    }

    public function getCouriers()
    {
        try {
            if (!$this->apiKey) {
                throw new \Exception('API Key not set');
            }

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->get("{$this->baseUrl}/v1/couriers");

            if (!$response->successful()) {
                \Log::error('Biteship Couriers Error:', $response->json());
                throw new \Exception($response->json('message', 'Failed to get couriers'));
            }

            return $response->json('couriers', []);
            
        } catch (\Exception $e) {
            \Log::error('Biteship Couriers Exception:', ['message' => $e->getMessage()]);
            throw new \Exception('Error getting couriers list: ' . $e->getMessage());
        }
    }
}