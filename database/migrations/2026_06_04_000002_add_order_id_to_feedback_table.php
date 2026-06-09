<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('Order_id')->nullable()->after('User_id');
            $table->foreign('Order_id')->references('id')->on('order')->cascadeOnDelete();
            $table->unique('Order_id');
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropUnique(['Order_id']);
            $table->dropForeign(['Order_id']);
            $table->dropColumn('Order_id');
        });
    }
};
