<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture_squad extends Model
{
    use HasFactory;

    public function position()
    {
        return $this->hasOne(SportGroundPosition::class, 'id', 'sport_ground_positions_id');
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function player()
    {
        return $this->hasOne(User::class, 'id', 'player_id');
    }
}
