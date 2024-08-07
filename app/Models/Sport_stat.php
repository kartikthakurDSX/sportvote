<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comp_report_type;
use App\Models\Sport;

class Sport_stat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function CompReportType()
    {
        return $this->hasMany(Comp_report_type::class, 'id', 'sport_stats_id');
    }
    public function sport()
    {
        return $this->hasOne(Sport::class, 'id', 'sport_id');
    }

}
