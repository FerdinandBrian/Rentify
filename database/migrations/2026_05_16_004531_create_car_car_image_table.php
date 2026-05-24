<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_car_image', function (Blueprint $table) {
            $table->id();
            $table->string('car_series_number');
            $table->unsignedBigInteger('car_image_id');
            $table->timestamps();

            $table->foreign('car_series_number')->references('series_number')->on('car')->onDelete('cascade');
            $table->foreign('car_image_id')->references('id')->on('car_images')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_car_image');
    }
};
