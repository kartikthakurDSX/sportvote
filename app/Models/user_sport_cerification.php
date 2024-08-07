<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_sport_cerification extends Model
{
    use HasFactory;
    public $fillable = [

        'user_id',
        'name',
        'description',
        'email',
        'certificate',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function sports()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }
}
