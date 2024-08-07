<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_rank extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'rank_id',
    ];
}