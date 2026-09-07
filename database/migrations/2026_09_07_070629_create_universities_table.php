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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('npsn')->nullable();
            $table->string('type')->default('Negeri');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('Active');
            $table->string('logo_url')->nullable();
            $table->string('logo_name')->nullable();
            $table->string('logo_text')->nullable();
            $table->string('logo_bg')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->integer('total_students')->default(0);
            $table->integer('total_faculties')->default(0);
            $table->string('accreditation')->nullable();
            $table->integer('founded')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
