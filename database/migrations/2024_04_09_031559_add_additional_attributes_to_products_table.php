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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('author_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->string('publisher_name')->nullable()->after('author_id');
            $table->year('published_year')->nullable()->after('publisher_name');
            $table->string('isbn_number')->nullable()->after('published_year');
            $table->string('pages')->nullable()->after('isbn_number');
            $table->string('language')->nullable()->after('pages');
            $table->string('country')->nullable()->after('language');
            $table->string('edition')->nullable()->after('country');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->dropColumn('publisher_name');
            $table->dropColumn('published_year');
            $table->dropColumn('isbn_number');
            $table->dropColumn('pages');
            $table->dropColumn('language');
            $table->dropColumn('country');
            $table->dropColumn('edition');
        });
    }
};
