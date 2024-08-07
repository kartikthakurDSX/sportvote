<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sport;

class SportGroundMap extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'sport_ground_maps';

    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sports_id');
    }
}
