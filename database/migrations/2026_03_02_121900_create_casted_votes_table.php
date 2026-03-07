<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casted_votes', function (Blueprint $table) {
            $table->id('casted_vote_id');
            $table->string('transaction_number')->unique()->nullable();
            $table->unsignedBigInteger('voter_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('candidate_id');
            $table->string('vote_hash')->nullable();
            $table->timestamp('voted_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            // FKs added in 2026_03_02_130000_add_foreign_keys migration
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casted_votes');
    }
};