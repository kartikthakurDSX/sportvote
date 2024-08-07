<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team_member extends Model
{
    use HasFactory;
    protected $fillable = [
        'action_user',
        'action_type',
        'team_id',
        'member_id',
        'member_position_id',
        'reason',
        'jersey_number',
        'invitation_status',

    ];

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
    public function member_position()
    {
        return $this->hasOne(Member_position::class, 'id', 'member_position_id');
    }
    public function members()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }
    public function member_positions()
    {
        return $this->hasMany(Member_position::class, 'id', 'member_position_id');
    }

  
}
