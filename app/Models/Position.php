<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'position_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(CastedVote::class, 'position_id', 'id');
    }
}