<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Match_fixture_stat;
use App\Models\Match_fixture;
use App\Events\ScoreUpdated;

class CompetitionScores extends Component
{
    public $fixtureId;
    public $teamOneGoal;
    public $teamTwoGoal;

    public function mount($fixtureId)
    {
        $this->fixtureId = $fixtureId;
        $this->updateScores();
    }

    public function render()
    {
        return view('livewire.competition-scores');
    }

    // Method to fetch and update scores
    public function updateScores()
    {
        $fixture = Match_fixture::find($this->fixtureId); // Fetch fixture data
        // Update scores based on fixture data
        $this->teamOneGoal = Match_fixture_stat::where('match_fixture_id', $this->fixtureId)
            ->where('team_id', $fixture->teamOne_id)
            ->whereIn('sport_stats_id', [1, 54])
            ->count();

        $this->teamTwoGoal = Match_fixture_stat::where('match_fixture_id', $this->fixtureId)
            ->where('team_id', $fixture->teamTwo_id)
            ->whereIn('sport_stats_id', [1, 54])
            ->count();

        // Emit event when scores are updated
        event(new ScoreUpdated($this->fixtureId));
    }

    public function refresh()
    {
        $this->updateScores();
    }
}
