<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Akun yang sudah aktif sebelum fitur verifikasi email tidak boleh terkunci.
        DB::table('users')
            ->whereIn('status', ['active', 'Active'])
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        //
    }
};
