<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match_fixture extends Model
{
    use HasFactory;
    public function competition()
    {
        return $this->hasOne(Competition::class, 'id', 'competition_id');
    }
    public function teamOne()
    {
        return $this->hasOne(Team::class, 'id', 'teamOne_id');
    }
    public function teamTwo()
    {
        return $this->hasOne(Team::class, 'id', 'teamTwo_id');
    }

    

    public function fixtureSquadTeamOne()
    {
        return $this->hasMany(Fixture_squad::class, 'match_fixture_id')->where('team_id', $this->teamOne->id)->where('is_active', 1);
    }

    public function fixtureSquadTeamTwo()
    {
        return $this->hasMany(Fixture_squad::class, 'match_fixture_id')->where('team_id', $this->teamTwo->id)->where('is_active', 1);
    }

}
