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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->index();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('symbol', 25)->nullable()->comment('Asset symbol e.g BTC');
            $table->decimal('amount', 18, 8)->nullable()->default(0)->comment('Available asset amount');
            $table->decimal('locked_amount', 18, 8)->nullable()->default(0)->comment('reserved for open sell orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
