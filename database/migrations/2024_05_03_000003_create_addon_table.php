<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addon', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price', 10, 2);
            $table->float('price_per_unit', 10, 2)->nullable();
            $table->float('price_per_day', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addon');
    }
};
