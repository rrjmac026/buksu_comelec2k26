<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionSetting extends Model
{
    protected $fillable = ['key', 'value'];

    // ── Static helpers ──────────────────────────────────────────

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, string $default = ''): string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Set a setting value by key (upsert).
     */
    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get the current election status.
     * Returns: 'upcoming' | 'ongoing' | 'ended'
     */
    public static function status(): string
    {
        return static::get('status', 'upcoming');
    }

    /**
     * Human-readable label for the current status.
     */
    public static function statusLabel(): string
    {
        return match(static::status()) {
            'ongoing' => 'Election Live',
            'ended'   => 'Election Ended',
            default   => 'Election Soon',
        };
    }
}