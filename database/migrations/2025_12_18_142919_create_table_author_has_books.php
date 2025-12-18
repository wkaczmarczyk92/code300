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
        Schema::create('author_has_books', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books', 'id')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('authors', 'id')->cascadeOnDelete();
            $table->primary(['author_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_has_books');
    }
};
