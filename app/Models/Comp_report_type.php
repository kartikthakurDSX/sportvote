<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sport;
use App\Models\Sport_stat;

class Comp_report_type extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }
    public function sportStat()
    {
        return $this->belongsTo(Sport_stat::class, 'sport_stat_id', 'id');
    }


}
