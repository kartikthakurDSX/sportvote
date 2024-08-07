<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport_level extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }

}
