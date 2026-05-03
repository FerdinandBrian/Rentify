<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'Role_id')) {
                $table->integer('Role_id')->nullable()->after('id');
                $table->foreign('Role_id')->references('id')->on('role')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['Role_id']);
            $table->dropColumn('Role_id');
        });
    }
};
