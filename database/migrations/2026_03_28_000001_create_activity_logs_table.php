<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('event');          // 'login' | 'logout' | 'login_failed'
            $table->string('email')->nullable();
            $table->string('role')->nullable();
            $table->string('full_name')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('logged_at')->useCurrent();
            $table->timestamps();

            $table->index(['logged_at']);
            $table->index(['user_id']);
            $table->index(['event']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};