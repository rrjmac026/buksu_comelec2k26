<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $primaryKey = 'candidate_id';

    protected $fillable = [
        'first_name', 'last_name', 'middle_name',
        'partylist_id', 'organization_id', 'position_id',
        'college_id', 'course', 'photo', 'platform',
    ];

    public function partylist()
    {
        return $this->belongsTo(Partylist::class, 'partylist_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(CastedVote::class, 'candidate_id', 'candidate_id');
    }

    public function getFullNameAttribute(): string
    {
        $middle = $this->middle_name ? ' ' . $this->middle_name[0] . '.' : '';
        return "{$this->first_name}{$middle} {$this->last_name}";
    }
}