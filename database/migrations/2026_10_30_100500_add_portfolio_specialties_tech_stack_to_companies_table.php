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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('projects_completed')->nullable()->after('founded');
            $table->json('specialties')->nullable()->after('tags');
            $table->json('tech_stack')->nullable()->after('specialties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['projects_completed', 'specialties', 'tech_stack']);
        });
    }
};
