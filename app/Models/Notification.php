<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $fillable = [
        'notify_module_id',
        'type_id',
        'sender_id',
        'reciver_id',
    ];

    public function notify()
    {
        return $this->hasMany(Notify_module::class, 'id', 'notify_module_id');
    }

    public function sender()
    {
        return $this->hasMany(User::class,'id','sender_id');
    }
    public function reciver()
    {
        return $this->hasMany(User::class,'id','reciver_id');
    }
    
    public function user_friend()
    {
        return $this->hasMany(User_friend::class,'id','type_id');
    }
    public function team_member()
    {
        return $this->hasMany(Team_member::class,'id','type_id');
    }
    
     
    
}
