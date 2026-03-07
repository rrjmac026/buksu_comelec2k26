<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'acronym'];

    public function voters()
    {
        return $this->hasMany(User::class, 'college_id', 'id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'college_id', 'id');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'college_id', 'id');
    }
}