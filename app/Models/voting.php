<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voting extends Model
{
    use HasFactory;
    public function player()
    {
        return $this->hasOne(User::class, 'id', 'player_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'fan_id');
    }
    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
    public function matchFixture()
    {
        return $this->hasOne(Match_fixture::class, 'id', 'match_fixture_id');
    }
}
