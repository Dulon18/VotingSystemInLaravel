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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained()->onDelete('cascade');
            $table->string('voter_email')->nullable();
            $table->string('voter_name')->nullable();
            $table->string('voter_ip');
            $table->text('user_agent')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->dateTime('voted_at');
            $table->timestamps();

            $table->index('poll_id');
            $table->index(['voter_ip', 'poll_id']);
            $table->index(['voter_email', 'poll_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
