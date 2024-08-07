<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\competition_type;

class CompSubType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'competition_subtypes';

    public function CompTypes()
    {
        return $this->hasOne(competition_type::class, 'id', 'competition_type_id');
    }
}
