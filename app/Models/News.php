<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'type',
        'description',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
