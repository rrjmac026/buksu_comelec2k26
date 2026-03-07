<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'acronym', 'college_id'];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'organization_id', 'id');
    }
}