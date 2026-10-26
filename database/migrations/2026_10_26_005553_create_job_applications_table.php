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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('internship_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name', 100);
            $table->string('email', 150);
            $table->string('phone', 30);
            $table->string('linkedin', 200)->nullable();
            $table->string('portfolio', 200)->nullable();
            $table->text('cover_letter');
            $table->string('resume_path');
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index(['job_listing_id', 'status']);
            $table->index(['internship_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
