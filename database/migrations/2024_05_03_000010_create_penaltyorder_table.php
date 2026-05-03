<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penaltyorder', function (Blueprint $table) {
            $table->unsignedBigInteger('Penalty_id');
            $table->string('Payment_id');
            $table->string('Payment_Order_id');

            $table->primary(['Penalty_id', 'Payment_id']);
            $table->foreign('Penalty_id')->references('id')->on('penalty')->onDelete('cascade');
            $table->foreign('Payment_id')->references('id')->on('payment')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penaltyorder');
    }
};
