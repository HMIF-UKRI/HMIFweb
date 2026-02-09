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
        Schema::create('merchandises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('merchandise_category_id')->constrained('merchandise_categories')->onDelete('cascade');
            $table->integer('price');
            $table->integer('original_price')->nullable();
            $table->text('description');
            $table->integer('stock')->default(0);
            $table->boolean('is_new')->default(false);
            $table->string('material')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchandises');
    }
};
