<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Youtube_video extends Model
{
    use HasFactory;
    public $fillable = [
        'type',
        'type_id',
        'video_link',
        'video_title',
    ];
}
