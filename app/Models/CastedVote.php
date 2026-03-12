<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CastedVote extends Model
{
    protected $primaryKey = 'casted_vote_id';

    protected $fillable = [
        'transaction_number',
        'voter_id',
        'position_id',
        'candidate_id',
        'vote_hash',
        'voted_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────

    /**
     * The voter (User) who cast this vote.
     * users.id ← casted_votes.voter_id
     */
    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id', 'id');
    }

    /**
     * The position this vote was cast for.
     * positions.position_id ← casted_votes.position_id
     *
     * NOTE: Position model uses $primaryKey = 'id' (standard),
     * but the FK column on this table is position_id — so we must
     * specify both the FK and the owner key explicitly.
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    /**
     * The candidate this vote was cast for.
     * candidates.candidate_id ← casted_votes.candidate_id
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'candidate_id');
    }
}