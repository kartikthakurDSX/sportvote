<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp_rule_set extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comp_id',
        'description',
    ];
}
