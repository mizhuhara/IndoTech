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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->string('org_contact')->nullable();
            $table->string('org_phone')->nullable();
            $table->string('org_address')->nullable();
            $table->string('org_doc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'org_contact', 'org_phone', 'org_address', 'org_doc']);
        });
    }
};
