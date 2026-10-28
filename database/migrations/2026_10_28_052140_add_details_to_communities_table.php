<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('type')->default('public')->after('category');
            $table->string('location')->nullable()->after('type');
            $table->string('language')->default('Bahasa Indonesia')->after('location');
            $table->text('rules')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn(['type', 'location', 'language', 'rules']);
        });
    }
};
