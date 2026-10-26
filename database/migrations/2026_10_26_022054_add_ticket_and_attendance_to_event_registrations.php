<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->string('ticket_code', 32)->nullable()->after('phone');
            $table->timestamp('checked_in_at')->nullable()->after('ticket_code');
        });

        DB::table('event_registrations')
            ->whereNull('ticket_code')
            ->orderBy('id')
            ->pluck('id')
            ->each(function (int $id) {
                DB::table('event_registrations')->where('id', $id)->update([
                    'ticket_code' => 'EVT-LEGACY-'.str_pad((string) $id, 6, '0', STR_PAD_LEFT),
                ]);
            });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->unique('ticket_code');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropUnique(['ticket_code']);
            $table->dropColumn(['ticket_code', 'checked_in_at']);
        });
    }
};
