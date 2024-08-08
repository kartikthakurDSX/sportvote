<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_friend extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'friend_id',
        'request_status',

    ];
    public function sender()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function reciver()
    {
        return $this->hasMany(User::class, 'id', 'friend_id');
    }

    public function notification()
    {
        return $this->belongsTo(User::class);
    }
}
