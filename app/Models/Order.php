<?php

namespace App\Models;

use App\Enums\StatusOptionsEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasUuids;

    protected $fillable     = [
        'user_id', 'symbol', 'side', 'price', 'amount', 'status', 'filled',
    ];

    protected $casts        = [
        'price'             => 'decimal:2',
        'amount'            => 'decimal:8',
        'filled'            => 'decimal:8',
    ];

    protected $attributes   = [
        'status'            => StatusOptionsEnum::OPEN->value,
        'filled'            => 0,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
