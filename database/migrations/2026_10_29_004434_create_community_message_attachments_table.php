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
        Schema::create('community_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->nullable()->constrained('community_messages')->cascadeOnDelete();
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_name');
            $table->string('storage_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('file_type')->default('other'); // image, video, document, archive, other
            $table->string('folder_name')->nullable();
            $table->string('relative_path')->nullable();
            $table->timestamps();

            $table->index(['message_id']);
            $table->index(['community_id']);
            $table->index(['folder_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_message_attachments');
    }
};
