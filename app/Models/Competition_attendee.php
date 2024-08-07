<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition_attendee extends Model
{
    use HasFactory;

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
    public function competition()
    {
        return $this->hasOne(Competition::class, 'id', 'competition_id');
    }
    public function player()
    {
        return $this->hasOne(User::class, 'id', 'attendee_id');
    }
}
