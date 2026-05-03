<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addonpayment', function (Blueprint $table) {
            $table->integer('AddOn_id');
            $table->string('Payment_id');
            $table->float('total_price')->nullable();
            $table->string('Payment_Order_id');

            $table->primary(['AddOn_id', 'Payment_id']);
            $table->foreign('AddOn_id')->references('id')->on('addon')->onDelete('cascade');
            $table->foreign('Payment_id')->references('id')->on('payment')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addonpayment');
    }
};
