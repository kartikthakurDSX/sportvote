<?php
// app/Events/ScoreUpdated.php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fixtureId;

    public function __construct($fixtureId)
    {
        $this->fixtureId = $fixtureId;
    }
}
