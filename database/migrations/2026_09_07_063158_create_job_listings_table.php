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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->index();
            $table->string('title');
            $table->string('company');
            $table->string('company_industry')->nullable();
            $table->string('department')->nullable();
            $table->string('type')->default('Full-time');
            $table->string('category')->default('jobs')->index();
            $table->string('experience')->default('Mid');
            $table->string('salary_range')->nullable();
            $table->string('location');
            $table->string('location_full')->nullable();
            $table->string('company_size')->nullable();
            $table->json('skills')->nullable();
            $table->json('tags')->nullable();
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->string('status')->default('Active');
            $table->string('tab_status')->default('active')->index();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('applicants_count')->default(0);
            $table->text('logo_url')->nullable();
            $table->string('logo_color')->nullable()->default('#0b57d0');
            $table->string('logo_text')->nullable();
            $table->text('image')->nullable();
            $table->string('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
