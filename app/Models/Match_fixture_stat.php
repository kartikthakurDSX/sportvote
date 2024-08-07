<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match_fixture_stat extends Model
{
    use HasFactory;
	 public $fillable = [
		'match_fixture_id',
		'competition_id',
		'stat_diff',
		'stat_time',
		'team_id',
		'player_id',
		'sport_stats_id',
		'stat_time_record',
		'half_type',
    ];
    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
    public function player()
    {
        return $this->hasOne(User::class, 'id', 'player_id');
    }
    public function sport_stat()
    {
        return $this->hasOne(Sport_stat::class, 'id', 'sport_stats_id');
    }
	
	public function top_players_goal()
	{
		return $this->hasMany(User::class,'id','player_id');
	}
	public function top_teams()
	{
		return $this->hasMany(Team::class,'id','team_id');
	}
	public function competition()
	{
		return $this->hasOne(Competition::class,'id','competition_id');
	}
	
}
