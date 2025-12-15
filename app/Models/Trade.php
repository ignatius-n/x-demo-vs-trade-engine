<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trade extends Model
{
    use HasUuids;

    protected $fillable = [
        'order_id', 'price', 'amount', 'commission',
    ];

    protected $casts    = [
        'price'         => 'decimal:2',
        'amount'        => 'decimal:8',
        'commission'    => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
