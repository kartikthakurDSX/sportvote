<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_fav_follow extends Model
{
    use HasFactory;

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'type_id');
    }
    public function comp()
    {
        return $this->hasOne(Competition::class, 'id', 'type_id');
    }
    public function user()
    {
        return $this->hasOne(User_profile::class, 'user_id', 'type_id');
    }
    public function player()
    {
        return $this->hasOne(User::class, 'id', 'type_id');
    }
}
