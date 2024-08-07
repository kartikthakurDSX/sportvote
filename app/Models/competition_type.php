<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CompSubType;

class competition_type extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function CompSubTypes()
    {
        return $this->belongsTo(CompSubType::class);
    }
}
