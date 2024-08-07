<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatDecisionMaker extends Model
{
    use HasFactory;
	public $fillable = [
        'type_id',
        'stat_id',
        'stat_order',
    ];


    public function sport_stat()
    {
        return $this->hasOne(Sport_stat::class, 'id', 'stat_id');
    }
}
