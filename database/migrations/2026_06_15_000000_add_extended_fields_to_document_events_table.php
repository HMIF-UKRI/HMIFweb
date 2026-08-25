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
        Schema::table('document_events', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->after('period_id')->constrained('users')->nullOnDelete();
            $table->text('description')->nullable()->after('name');
            $table->string('access_level', 20)->default('internal')->after('description');
            $table->string('file_extension', 10)->nullable()->after('access_level');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_extension');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'description',
                'access_level',
                'file_extension',
                'file_size',
            ]);
        });
    }
};
