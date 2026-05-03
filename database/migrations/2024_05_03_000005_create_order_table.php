<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('call_number');
            $table->string('email')->nullable();
            $table->string('status');
            $table->dateTime('start_rent');
            $table->dateTime('end_rent');
            $table->string('Car_series_number');
            $table->unsignedBigInteger('User_id');

            $table->foreign('Car_series_number')->references('series_number')->on('car')->onDelete('cascade');
            $table->foreign('User_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
