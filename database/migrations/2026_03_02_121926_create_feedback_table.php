<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the `feedback` table for voter feedback submissions.
     * Each voter may have exactly one feedback record (unique on user_id).
     * The record is updatable (voters can revise their feedback).
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            // Owner — one feedback record per registered voter
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // 1–5 star rating
            $table->unsignedTinyInteger('rating')
                  ->comment('1 = Poor, 2 = Fair, 3 = Good, 4 = Great, 5 = Excellent');

            // Free-text comment (10–1000 chars enforced at app level)
            $table->text('feedback');

            $table->timestamps();

            // Enforce one feedback record per voter at the DB level
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};