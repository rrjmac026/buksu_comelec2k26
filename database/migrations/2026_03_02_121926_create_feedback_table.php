<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('feedback');
            $table->unsignedTinyInteger('rating')->default(5); // 1-5
            $table->timestamps();
            // FK added in 2026_03_02_130000_add_foreign_keys migration
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};