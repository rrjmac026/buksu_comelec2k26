<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CastedVote extends Model
{
    protected $primaryKey = 'casted_vote_id';

    protected $fillable = [
        'transaction_number', 'voter_id', 'position_id',
        'candidate_id', 'vote_hash', 'voted_at',
        'ip_address', 'user_agent',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'candidate_id');
    }
}