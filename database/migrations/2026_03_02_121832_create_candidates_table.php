<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id('candidate_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->unsignedBigInteger('partylist_id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('college_id');
            $table->string('course', 100);
            $table->string('photo')->nullable();
            $table->text('platform')->nullable();
            $table->timestamps();
            // FKs added in 2026_03_02_130000_add_foreign_keys migration
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};