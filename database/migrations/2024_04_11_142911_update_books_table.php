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
            $table->string('ebook')->nullable()->after('book_type_id');
            $table->decimal('ebook_price', 10, 2)->nullable();
            $table->string('ebook_compare_price', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('ebook_price');
            $table->dropColumn('ebook_compare_price');
            $table->dropColumn('ebook');
        });
    }
};
