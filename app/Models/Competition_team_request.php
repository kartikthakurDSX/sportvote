<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition_team_request extends Model
{
    use HasFactory;

    public function competition()
    {
        return $this->hasOne(Competition::class, 'id', 'competition_id');
    }
    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function comp_fixture()
    {
        return $this->hasMany(Match_fixture::class, 'competition_id', 'competition_id');
    }
}
