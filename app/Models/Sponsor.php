<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sponsor_name',
        'sponsor_image',
        'type',
		'type_id',
        'module_type',
    ];
}
