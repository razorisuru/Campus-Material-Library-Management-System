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
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade')->index();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade')->index();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->index();
            $table->enum('status', ['pending', 'approved', 'rejected'])->index();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_materials');
    }
};
