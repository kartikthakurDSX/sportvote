<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Laratrust\Traits\LaratrustUserTrait;
use App\Models\User_profile;

class User extends Authenticatable
{
    // use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Team()
    {
        return $this->hasOne(Team::class, 'id', 'teams_id');
    }
    public function notifications()
    {
        return $this->hasOneThrough(
        Notification::class, user_friend::class,
        'user_id',
        'type_id',
        'id',
        'id'
        );
    }
    public function userProfile()
    {
        return $this->hasOne(User_profile::class, 'user_id', 'id');
    }

}
