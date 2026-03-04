<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_es');
            $table->text('summary_en')->nullable();
            $table->text('summary_es')->nullable();
            $table->longText('body_en')->nullable();
            $table->longText('body_es')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained()->nullOnDelete();
            $table->string('author')->nullable();
            $table->date('date')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
