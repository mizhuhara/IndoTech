<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * NOTE: user_id untuk universities sudah ditambahkan oleh versi awal
     * migration ini (yang sempat jalan sebagian & gagal di companies).
     * Kolom user_id untuk companies sudah ada di create_companies_table.
     * Migration ini sengaja no-op agar tidak duplicate column.
     */
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            if (! Schema::hasColumn('universities', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};