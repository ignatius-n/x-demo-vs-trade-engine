<?php

use App\Enums\StatusOptionsEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->index();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('symbol')->nullable()->comment('Asset symbol e.g BTC');
            $table->string('side', 25)->nullable()->comment('e.g buy/sell');
            $table->decimal('price', 12, 2)->nullable()->default(0);
            $table->decimal('amount', 18, 8)->nullable()->default(0);
            $table->decimal('filled', 18, 8)->nullable()->default(0);
            $table->string('status')->nullable()->default(StatusOptionsEnum::OPEN->value)->comment('open=1, filled=2, canceled=3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
