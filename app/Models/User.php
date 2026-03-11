<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id',
        'role', 'sex', 'student_number', 'college_id',
        'course', 'year_level', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ✅ KEY FIX — For Google OAuth voters who have no password.
     * Returns null so Laravel doesn't try to verify a password.
     */
    public function getAuthPassword()
    {
        return $this->password; // null for Google voters, hashed string for admins
    }

    // ── Relationships ──────────────────────────────────────────

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(CastedVote::class, 'voter_id', 'id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'id');
    }

    // ── Helper Methods ─────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isVoter(): bool
    {
        return $this->role === 'voter';
    }

    public function hasVoted(): bool
    {
        return $this->votes()->exists();
    }
}