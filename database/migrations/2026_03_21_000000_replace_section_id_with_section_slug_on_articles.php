<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('section')->nullable()->after('category_id');
        });

        // Migrate existing FK data to slug string
        DB::statement('UPDATE articles SET section = (SELECT slug FROM sections WHERE sections.id = articles.section_id) WHERE section_id IS NOT NULL');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('section_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });

        DB::statement('UPDATE articles SET section_id = (SELECT id FROM sections WHERE sections.slug = articles.section) WHERE section IS NOT NULL');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }
};
