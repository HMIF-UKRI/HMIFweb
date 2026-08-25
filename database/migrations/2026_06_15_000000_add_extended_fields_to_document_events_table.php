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
            if (!Schema::hasColumn('document_events', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('period_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('document_events', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('document_events', 'access_level')) {
                $table->string('access_level', 20)->default('internal')->after('description');
            }
            if (!Schema::hasColumn('document_events', 'file_extension')) {
                $table->string('file_extension', 10)->nullable()->after('access_level');
            }
            if (!Schema::hasColumn('document_events', 'file_size')) {
                $table->unsignedBigInteger('file_size')->nullable()->after('file_extension');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_events', function (Blueprint $table) {
            if (Schema::hasColumn('document_events', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            $columnsToDrop = array_filter(['description', 'access_level', 'file_extension', 'file_size'], function ($col) {
                return Schema::hasColumn('document_events', $col);
            });
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
