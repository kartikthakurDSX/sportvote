<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;
     protected $guarded = [];


    public function sport()
    {
        return $this->hasOne(Sport::class,'id','sport_id');
    }

    public function comptype()
    {
        return $this->hasOne(competition_type::class,'id','comp_type_id');
    }

    public function compsubtype()
    {
        return $this->hasOne(CompSubType::class,'id','comp_subtype_id');
    }


    public function sport_comp()
    {
        return $this->hasMany(Sport::class,'id','sport_id');
    }

    public function comptype_comp()
    {
        return $this->hasMany(competition_type::class,'id','comp_type_id');
    }

    public function compsubtype_comp()
    {
        return $this->hasMany(CompSubType::class,'id','comp_subtype_id');
    }
	public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function comp_fixture()
    {
        return $this->hasMany(Match_fixture::class, 'competition_id', 'id');
    }
}
