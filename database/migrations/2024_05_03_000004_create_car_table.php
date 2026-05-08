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
            $table->string('name')->unique();
            $table->float('price', 10, 2);
            $table->string('type');
            $table->dateTime('year')->nullable();
            $table->string('status');
            $table->boolean('is_electric')->default(false);
            $table->foreignId('brand_id')->constrained('brand')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car');
    }
};
