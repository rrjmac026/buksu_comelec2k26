<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // e.g. 'status', 'election_name'
            $table->string('value')->nullable();
            $table->timestamps();
        });

        // Seed defaults
        DB::table('election_settings')->insert([
            ['key' => 'status',        'value' => 'upcoming', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'election_name', 'value' => 'Student Council Election', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Status values:
        //  'upcoming'  → Election Soon  (gold)
        //  'ongoing'   → Election Live  (green, pulsing)
        //  'ended'     → Election Ended (muted)
    }

    public function down(): void
    {
        Schema::dropIfExists('election_settings');
    }
};