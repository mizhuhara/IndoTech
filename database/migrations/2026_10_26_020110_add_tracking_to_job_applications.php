<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('internship_id')
                ->constrained()
                ->nullOnDelete();
        });

        Schema::create('job_application_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->text('note')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_application_status_histories');

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
