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
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('portofolio_category_id')->nullable()->constrained('portofolio_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug', 150)->unique();
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('url_github')->nullable();
            $table->string('url_linkedin')->nullable();
            $table->enum('status', ['Draft', 'Published'])->default('Draft');
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
