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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('category')->default('Technology');
            $table->json('tags')->nullable();
            $table->string('author_name')->default('Admin IndoTech');
            $table->string('author_avatar')->nullable();
            $table->string('author_role')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['published', 'draft', 'archived'])->default('draft');
            $table->string('read_time')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

