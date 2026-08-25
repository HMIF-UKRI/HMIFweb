<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'whatsapp_group_link')) {
                $table->string('whatsapp_group_link', 500)->nullable()->after('location');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'whatsapp_group_link')) {
                $table->dropColumn('whatsapp_group_link');
            }
        });
    }
};
