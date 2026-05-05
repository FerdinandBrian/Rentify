<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addon_payment', function (Blueprint $table) {
            $table->foreignId('addon_id')
                ->constrained('addon')
                ->cascadeOnDelete();

            $table->foreignId('payment_id')
                ->constrained('payment')
                ->cascadeOnDelete();

            $table->decimal('total_price', 10, 2)->nullable();

            $table->primary(['addon_id', 'payment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addonpayment');
    }
};
