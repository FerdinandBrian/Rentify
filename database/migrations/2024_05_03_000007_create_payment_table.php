<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('status');
            $table->float('total_price', 10, 2)->nullable();
            $table->string('Order_id');

            $table->foreign('Order_id')->references('id')->on('order')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
