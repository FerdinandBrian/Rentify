<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car', function (Blueprint $table) {
            $table->string('series_number')->primary();
            $table->string('name');
            $table->float('price');
            $table->string('type');
            $table->dateTime('year')->nullable();
            $table->string('status');
            $table->integer('Brand_id');

            $table->foreign('Brand_id')->references('id')->on('brand')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car');
    }
};
