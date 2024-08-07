<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture_notification extends Model
{
    use HasFactory;

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'teamadmin_sender_id');
    }
}
