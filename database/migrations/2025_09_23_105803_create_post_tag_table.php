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
        Schema::create('post_tag', function (Blueprint $table) {
            // Kolom foreign key untuk post
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            // Kolom foreign key untuk tag
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');

            // Set primary key gabungan untuk mencegah duplikasi
            $table->primary(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
