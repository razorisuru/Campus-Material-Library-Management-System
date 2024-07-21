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
        Schema::create('e_book_category_join', function (Blueprint $table) {
            $table->unsignedBigInteger('ebook_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->primary(['ebook_id', 'category_id']);

            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('ebook_categories')->onDelete('cascade');
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
