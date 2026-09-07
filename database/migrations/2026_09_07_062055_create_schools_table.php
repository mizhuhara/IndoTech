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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique();
            $table->string('name');
            $table->string('institution_type')->default('SMK IT');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('Active');
            $table->string('logo_url')->nullable();
            $table->string('logo_text')->nullable();
            $table->string('logo_bg')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->integer('total_students')->default(0);
            $table->integer('industry_partners')->default(0);
            $table->string('founded')->nullable();
            $table->string('accreditation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
