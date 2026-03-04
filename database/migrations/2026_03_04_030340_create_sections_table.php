<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_es');
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();
            $table->enum('section_layout', ['hero', 'grid', 'list', 'sidebar'])->default('list');
            $table->json('categories')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
