<?php

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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->index();
            $table->foreignId('buy_order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('sell_order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('price', 12, 2)->nullable()->default(0);
            $table->decimal('amount', 18, 8)->nullable()->default(0);
            $table->decimal('commission', 12, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
