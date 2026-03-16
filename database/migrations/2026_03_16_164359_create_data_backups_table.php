<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_data_backups_table.php
        public function up(): void
        {
            Schema::create('data_backups', function (Blueprint $table) {
                $table->id();
                $table->string('backup_name');
                $table->enum('backup_type', ['database', 'full'])->default('database');
                $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
                $table->string('file_path')->nullable();
                $table->bigInteger('file_size')->nullable();
                $table->integer('progress')->default(0);
                $table->text('error_message')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('completed_at')->nullable();
                $table->timestamp('retention_until')->nullable();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_backups');
    }
};
