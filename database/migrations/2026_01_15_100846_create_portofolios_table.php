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
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('portofolio_category_id')->constrained('portofolio_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug', 100);
            $table->text('description');
            $table->string('thumbnail');
            $table->boolean('is_featured', false);
            $table->string('url_github')->nullable();
            $table->string('url_linkedin')->nullable();
            $table->enum('status', ['Draft', 'Published']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolios');
    }
};
