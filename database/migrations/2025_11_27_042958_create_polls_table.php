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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_anonymous')->default(true);
            $table->boolean('allow_multiple_votes')->default(false);
            $table->boolean('require_email')->default(false);
            $table->boolean('show_results_before_vote')->default(false);
            $table->boolean('randomize_options')->default(false);
            $table->string('password')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['draft', 'active', 'closed', 'archived'])->default('active');
            $table->integer('max_votes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['slug', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
