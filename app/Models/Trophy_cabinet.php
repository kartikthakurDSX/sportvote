<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trophy_cabinet extends Model
{
    use HasFactory;

    public $fillable = [
        'type',
        'type_id',
        'title',
        'year',
        'comp',
        'trophy_image'
        
    ];
}
