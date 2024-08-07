<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp_member extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'comp_id',
        'member_id',
        'member_position_id',
    ];

    public function competition()
    {
        return $this->hasOne(Competition::class, 'id', 'comp_id');
    }
    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }
    public function member_position()
    {
        return $this->hasOne(Member_position::class,'id','member_position_id');
    }
}
