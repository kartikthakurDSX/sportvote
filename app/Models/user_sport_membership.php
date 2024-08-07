<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_sport_membership extends Model
{

    protected $guarded = [];

    use HasFactory;
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function sports()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }
}
