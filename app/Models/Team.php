<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'location',
        'description',
        'sport_id',
        'team_logo',
        'user_id',
        'team_color',
        'team_slogan',
        'homeGround_location',
        'homeGround',
        'country_id',
    ];
    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }
    public function sport_team()
    {
        return $this->hasOne(Sport::class,'id','sport_id');
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    // public function notifications()
    // {
    //     return $this->hasOneThrough(
    //     Notification::class, Team_join::class,
    //     'team_id',
    //     'type_id',
    //     'id',
    //     'id'
    // );
    // }
}
