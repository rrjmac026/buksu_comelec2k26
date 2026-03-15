<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'feedback',
        'rating',
    ];

    // ── Rating label helper ───────────────────────────────────────
    private static array $ratingLabels = [
        1 => 'Poor',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Great',
        5 => 'Excellent',
    ];

    /**
     * Human-readable label for the numeric rating.
     */
    public function getRatingLabelAttribute(): string
    {
        return self::$ratingLabels[$this->rating] ?? 'Unknown';
    }

    // ── Relationships ─────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}