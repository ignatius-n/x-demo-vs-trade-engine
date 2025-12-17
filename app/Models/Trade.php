<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trade extends Model
{
    use HasUuids;

    protected $fillable = [
        'buy_order_id', 'sell_order_id', 'price', 'amount', 'commission',
    ];

    protected $casts    = [
        'price'         => 'decimal:2',
        'amount'        => 'decimal:8',
        'commission'    => 'decimal:2',
    ];

    public function buyOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'buy_order_id');
    }

    public function sellOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'sell_order_id');
    }
}
