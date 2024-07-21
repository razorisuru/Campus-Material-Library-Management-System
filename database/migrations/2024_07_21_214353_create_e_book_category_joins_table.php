<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('e_book_category_joins', function (Blueprint $table) {
            $table->unsignedBigInteger('ebook_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->primary(['ebook_id', 'category_id']);

            $table->foreign('ebook_id')->references('id')->on('e_books')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('e_book_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_book_category_joins');
    }
};
