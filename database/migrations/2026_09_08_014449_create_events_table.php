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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('organizer');
            $table->string('organizer_type')->default('Company');
            $table->string('category')->default('General');
            $table->string('mode')->default('In-Person');
            $table->string('price')->default('Free');
            $table->string('date')->nullable();
            $table->string('short_date')->nullable();
            $table->string('full_date')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->string('quota')->nullable();
            $table->integer('total_quota')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('description')->nullable();
            $table->json('what_you_will_learn')->nullable();
            $table->json('speakers')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
