<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'event',
        'email',
        'role',
        'full_name',
        'ip_address',
        'user_agent',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ────────────────────────────────────────────────

    /**
     * Record a login/logout/login_failed event.
     */
    public static function record(
        string $event,
        ?User  $user   = null,
        string $email  = '',
        string $ip     = '',
        string $ua     = ''
    ): void {
        static::create([
            'user_id'    => $user?->id,
            'event'      => $event,
            'email'      => $user?->email ?? $email,
            'role'       => $user?->role,
            'full_name'  => $user?->full_name,
            'ip_address' => $ip,
            'user_agent' => $ua,
            'logged_at'  => now(),
        ]);
    }
}
