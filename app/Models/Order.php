<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'symbol', 'side', 'price', 'amount', 'status',
    ];

    protected $casts    = [
        'price'         => 'decimal:8',
        'amount'        => 'decimal:8',
        'status'        => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
