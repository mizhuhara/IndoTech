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
        Schema::create('job_seekers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('job_title');                     // posisi yang dicari
            $table->json('skills')->nullable();              // keahlian
            $table->enum('experience_level', ['Entry', 'Mid', 'Senior'])->default('Entry');
            $table->string('expected_salary')->nullable();   // ekspektasi gaji
            $table->text('about')->nullable();               // deskripsi diri
            $table->string('portfolio_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('photo_url')->nullable();
            $table->enum('availability', ['Segera', 'Bulan Depan', '> 1 Bulan'])->default('Segera');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_seekers');
    }
};
