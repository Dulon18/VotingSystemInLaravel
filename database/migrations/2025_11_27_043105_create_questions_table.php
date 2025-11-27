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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['single_choice', 'multiple_choice', 'rating', 'text']);
            $table->boolean('is_required')->default(true);
            $table->integer('order')->default(0);
            $table->json('settings')->nullable(); // For rating ranges, text limits, etc.
            $table->timestamps();

            $table->index('poll_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
