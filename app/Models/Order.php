<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',    
        'total_amount',
        'status',
        'payment_status',
        'recipient_name',
        'phone',
        'shipping_provider',
        'shipping_cost',
        'shipping_area_id',
        'shipping_area_name',
        'shipping_address',
        'shipping_method_detail',
        'shipping_tracking_number',
        'payment_gateway_transaction_id',
        'payment_gateway_data',
        'payment_proof'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
