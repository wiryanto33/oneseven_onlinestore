<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'banner',
        'address',
        'whatsapp',
        'email_notification',
        'is_use_payment_gateway',
        'shipping_provider',
        'shipping_api_key',
        'shipping_area_id',
        'requires_customer_email_verification',
        'primary_color',
        'secondary_color',
        'shipping_courier',
    ];

    protected $casts = [
        'banner' => 'array',
        'info_swiper' => 'array',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? url('storage/' . $this->image) : null;
    }

    public function getBannerUrlAttribute()
    {
        if (!$this->banner) {
            return [];
        }

        // Handle both single file and array of files
        if (is_array($this->banner)) {
            return array_map(function ($banner) {
                return url('storage/' . $banner);
            }, $this->banner);
        }

        // Fallback for single file (backward compatibility)
        return [url('storage/' . $this->banner)];
    }
}
