<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partylist extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'partylist_id', 'id');
    }
}