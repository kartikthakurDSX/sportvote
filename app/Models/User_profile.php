<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class User_profile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }

    public function sport_level()
    {
        return $this->hasOne(Sport_level::class, 'id', 'sport_level_id');
    }
	 public function level()
    {
        return $this->hasOne(Sport_level::class, 'id', 'level_id');
    }
    public function sport_attitude()
    {
        return $this->hasOne(Sport_attitude::class, 'id', 'sport_attitude_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function username()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
