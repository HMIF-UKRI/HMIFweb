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
            $table->string('participant_category', 50)->nullable()->after('institution');
        });

        DB::table('event_registrations')
            ->whereNull('participant_category')
            ->where(function ($query) {
                $query->where('institution', 'like', '%universitas%')
                    ->orWhere('institution', 'like', '%university%')
                    ->orWhere('institution', 'like', '%kampus%')
                    ->orWhere('institution', 'like', '%institut%')
                    ->orWhere('institution', 'like', '%politeknik%')
                    ->orWhere('institution', 'like', '%ukri%');
            })
            ->update(['participant_category' => 'Mahasiswa']);

        DB::table('event_registrations')
            ->whereNull('participant_category')
            ->where(function ($query) {
                $query->where('institution', 'like', '%sma%')
                    ->orWhere('institution', 'like', '%smk%')
                    ->orWhere('institution', 'like', '%ma %')
                    ->orWhere('institution', 'like', '%sekolah%');
            })
            ->update(['participant_category' => 'Pelajar']);

        DB::table('event_registrations')
            ->whereNull('participant_category')
            ->update(['participant_category' => 'Lainnya']);
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn('participant_category');
        });
    }
};
