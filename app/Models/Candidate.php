<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';
    protected $primaryKey = 'candidate_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'candidate_id',
        'first_name',
        'last_name',
        'middle_name',
        'partylist_id',   
        'organization_id', 
        'position_id',     
        'college_id', 
        'course',          
        'photo',           
        'platform'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partylist()
    {
        return $this->belongsTo(Partylist::class, 'partylist_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function castedVotes()
    {
        return $this->hasMany(CastedVote::class, 'candidate_id', 'candidate_id');
    }

    // Add this method for photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('images/candidates/' . $this->photo);
        }
        return asset('images/candidates/default-avatar.png');
    }

    public function getCastedVotesCountAttribute()
    {
        return DB::table('casted_votes')
            ->whereRaw("JSON_SEARCH(votes, 'one', ?)", [$this->candidate_id])
            ->count();
    }
}