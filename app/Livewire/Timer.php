<?php

namespace App\Livewire;

use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\Match_fixture;
use App\Models\Match_fixture_lapse;
use App\Models\Match_fixture_stat;
use Livewire\Component;
use Carbon\Carbon;

class Timer extends Component
{
    public $elapsedTime = 0;
    public $isActive = false;
    public $isPaused = false;
    public $startTime;
    public $pauseTime;
    public $durationInMinutes;
    public $totalTime;
    public $fixture_id, $match_fixture;
    public $matchFixture_latestStat;
    public $update_match_fixture, $match_fixture_lapse;
    public $firstHalfComplete = 0;

    protected $listeners = ['startTimer', 'pauseTimer', 'resumeTimer', 'updateTimer', 'startSecondTimer', 'pauseSecondTimer', 'resumeSecondTimer'];

    public function mount($match_fixture_id)
    {
        $this->fixture_id = $match_fixture_id;
        $this->match_fixture = Match_fixture::find($this->fixture_id);
        $competition = Competition::find($this->match_fixture->competition_id);
        $this->durationInMinutes = $competition->competition_half_time;
        $this->totalTime = $this->durationInMinutes * 60;
        $this->resetTimer();
    }

    public function render()
    {
        $this->updateTimer();
        // dd($this->firstHalfComplete);

        // This is to check for what condition the timer is in the first half
        if ($this->elapsedTime == $this->totalTime) {
            $check_first_half = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->where('lapse_type', 2)->get();
            if (count($check_first_half) < 1) {
                $player_team_id = Match_fixture_stat::where('match_fixture_id', $this->match_fixture->id)->latest()->first();

                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
                $match_fixture_lapse->lapse_type = 2;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->team_id = $player_team_id->team_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $player_team_id->player_id;
                $match_fixture_stat->sport_stats_id = 13;
                $match_fixture_stat->half_type = 1;
                $match_fixture_stat->stat_time = now();
                $match_fixture_stat->stat_time_record = "60:00";
                $match_fixture_stat->save();
            }
        } else {
            $check_first_half = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')
                ->first();
            if ($check_first_half) {
                if ($check_first_half->lapse_type == 5) {
                    $get_last_timer = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->where('lapse_type', 5)->orderBy('id', 'desc')->first();
                    // dd($get_last_timer->lapse_diff);
                } elseif ($check_first_half->lapse_type == 6) {
                    // dd("paused");
                }
            }
        }
        return view('livewire.timer');
    }

    // For First half functionalities
    public function startTimer()
    {
        if (!$this->isActive) {
            $this->startTime = Carbon::now();
            $this->isActive = true;
            $this->isPaused = false;
            $is_start = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->get();

            // It will create a new record as the match starts only one time because match only starts one time
            if (count($is_start) == 0) {
                // Record match start lapse
                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->fixture_id;
                $match_fixture_lapse->lapse_type = 1;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                // Update start date and time
                $time = now();
                $match_fixture = Match_fixture::find($this->fixture_id);
                $match_fixture->startdate_time = $time;
                $match_fixture->save();

                // Record match fixture stat for the first half
                $team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
                    ->where('team_id', $this->match_fixture->teamOne_id)
                    ->first();

                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $team_player->attendee_id;
                $match_fixture_stat->sport_stats_id = 12;
                $match_fixture_stat->stat_time = now();
                $match_fixture_stat->half_type = 1;
                $match_fixture_stat->save();
            }
            $this->dispatch('start-timer');
        }
    }

    public function pauseTimer()
    {
        if ($this->isActive && !$this->isPaused) {
            $matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();
            if ($matchFixture_latestStat->lapse_type == 5 || $matchFixture_latestStat->lapse_type == 1) {
                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->fixture_id;
                $match_fixture_lapse->lapse_type = 6;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                $get_pause_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 6])->orderBy('id', 'desc')->get();
                $count_pause_lapse_time = $get_pause_lapse_time->count();

                if ($count_pause_lapse_time <= 1) {
                    $start = $this->match_fixture->startdate_time;
                    $dateTimeObject1 = date_create($start);
                    $dateTimeObject2 = now();
                    $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                    $lapse_diff = $difference->format('%H:%I:%S');
                } else {
                    $get_play_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 5])->orderBy('id', 'desc')->first();
                    $last_dateTimeObject1 = date_create($match_fixture_lapse->lapse_time);
                    $last_dateTimeObject2 = date_create($get_play_lapse_time->created_at);
                    $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                    $lapse_diff = $difference->format('%H:%I:%S');
                }

                $team_player = Competition_attendee::select('attendee_id')->where('Competition_id', $this->match_fixture->competition_id)
                    ->where('team_id', $this->match_fixture->teamOne_id)->first();

                // Record match fixture stat for pause
                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $team_player->attendee_id;
                $match_fixture_stat->sport_stats_id = 16;
                $match_fixture_stat->stat_time = now();
                $match_fixture_stat->half_type = 1;
                $match_fixture_stat->save();

                // Update lapse time difference
                $update_match_fixture = Match_fixture_lapse::find($match_fixture_lapse->id);
                $update_match_fixture->lapse_diff = $lapse_diff;
                $update_match_fixture->save();
            }

            $this->isPaused = true;
            $this->pauseTime = Carbon::now();
            $this->dispatch('pause-timer');
        }
    }

    public function resumeTimer()
    {
        if ($this->isActive && $this->isPaused) {
            $matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();

            if ($matchFixture_latestStat->lapse_type == 6) {
                // Record lapse time for pause
                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
                $match_fixture_lapse->lapse_type = 5;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                // Record lapse time difference
                $frist_half_pause = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)
                    ->where('lapse_type', 6)
                    ->orderBy('id', 'desc')
                    ->latest()
                    ->first();

                $last_dateTimeObject1 = date_create($frist_half_pause->lapse_time);
                $last_dateTimeObject2 = date_create($match_fixture_lapse->lapse_time);
                $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                $lapse_diff = $difference->format('%H:%I:%S');

                // Fetch team player information
                $team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
                    ->where('team_id', $this->match_fixture->teamOne_id)
                    ->first();

                // Record match fixture stat for the first half
                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $team_player->attendee_id;
                $match_fixture_stat->sport_stats_id = 17;
                $match_fixture_stat->stat_diff = "00:00:00";
                $match_fixture_stat->stat_time = now();
                $match_fixture_stat->half_type = 1;
                $match_fixture_stat->save();

                $update_lapse = Match_fixture_lapse::find($match_fixture_lapse->id);
                $update_lapse->lapse_diff = $lapse_diff;
                $update_lapse->save();
            }
            $elapsedDuringPause = Carbon::now()->diffInSeconds($this->pauseTime);
            $this->startTime = $this->startTime->addSeconds($elapsedDuringPause);
            $this->isPaused = false;
            $this->dispatch('resume-timer');
        }
    }

    // // For Second half functionalities
    public function startSecondTimer()
    {
        if (!$this->isActive) {
            $this->startTime = Carbon::now();
            $this->isActive = true;
            $this->isPaused = false;
            $is_start = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)
                ->where('lapse_type', 3)
                ->get();
            // dd($is_start);

            // It will create a new record as the match starts only one time because match only starts one time
            if (count($is_start) == 0) {
                // Record second half start lapse
                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
                $match_fixture_lapse->lapse_type = 3;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                // Record match fixture stat for the second half
                $team_player = Competition_attendee::select('attendee_id')
                    ->where('Competition_id', $this->match_fixture->competition_id)
                    ->where('team_id', $this->match_fixture->teamOne_id)
                    ->first();

                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $team_player->attendee_id;
                $match_fixture_stat->sport_stats_id = 14;
                $match_fixture_stat->stat_time = now();
                // $match_fixture_stat->stat_time_record = $stat_time_record;
                $match_fixture_stat->half_type = 2;
                $match_fixture_stat->save();
            }
            $this->dispatch('start-timer');
        }
    }

    public function pauseSecondTimer()
    {
        if ($this->isActive && !$this->isPaused) {
            $matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();
            if ($matchFixture_latestStat->lapse_type == 8 || $matchFixture_latestStat->lapse_type == 3) {
                // Record lapse time for second half pause
                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
                $match_fixture_lapse->lapse_type = 9;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                // Fetch pause lapse times
                $get_pause_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 9])->orderBy('id', 'desc')->get();
                $count_pause_lapse_time = $get_pause_lapse_time->count();

                if ($count_pause_lapse_time <= 1) {
                    // Calculate lapse time difference for the first pause
                    $get_second_half_start_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 3])->orderBy('id', 'desc')->latest()->first();
                    $start = $get_second_half_start_time->lapse_time;
                    $dateTimeObject1 = date_create($start);
                    $dateTimeObject2 = date_create($match_fixture_lapse->lapse_time);
                    $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                    $lapse_diff = $difference->format('%H:%I:%S');
                } else {
                    // Calculate lapse time difference for subsequent pauses
                    $get_play_lapse_time = Match_fixture_lapse::where(['match_fixture_id' => $this->fixture_id, 'lapse_type' => 8])->orderBy('id', 'desc')->latest()->first();
                    $last_dateTimeObject1 = date_create($match_fixture_lapse->lapse_time);
                    $last_dateTimeObject2 = date_create($get_play_lapse_time->lapse_time);
                    $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                    $lapse_diff = $difference->format('%H:%I:%S');
                }

                // Update lapse time difference
                $update_match_fixture = Match_fixture_lapse::find($match_fixture_lapse->id);
                $update_match_fixture->lapse_diff = $lapse_diff;
                $update_match_fixture->save();

                // Fetch team player information
                $team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
                    ->where('team_id', $this->match_fixture->teamOne_id)
                    ->first();

                // Record match fixture stat for the second half
                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $team_player->attendee_id;
                $match_fixture_stat->sport_stats_id = 18;
                $match_fixture_stat->stat_time = now();
                $match_fixture_stat->half_type = 2;
                $match_fixture_stat->save();
            }

            $this->isPaused = true;
            $this->pauseTime = Carbon::now();
            $this->dispatch('pause-timer');
        }
    }

    public function resumeSecondTimer()
    {
        if ($this->isActive && $this->isPaused) {
            $matchFixture_latestStat = Match_fixture_lapse::where('match_fixture_id', $this->fixture_id)->orderBy('id', 'desc')->first();

            if ($matchFixture_latestStat->lapse_type == 9) {
                // Record lapse time for second half pause
                $match_fixture_lapse = new Match_fixture_lapse();
                $match_fixture_lapse->match_fixture_id = $this->match_fixture->id;
                $match_fixture_lapse->lapse_type = 8;
                $match_fixture_lapse->lapse_time = now();
                $match_fixture_lapse->save();

                // Fetch team player information
                $team_player = Competition_attendee::where('Competition_id', $this->match_fixture->competition_id)
                    ->where('team_id', $this->match_fixture->teamOne_id)
                    ->first();

                // Fetch the latest pause time for second half
                $pause_second_half = Match_fixture_lapse::where('match_fixture_id', $this->match_fixture->id)
                    ->where('lapse_type', 9)
                    ->orderBy('id', 'desc')
                    ->latest()
                    ->first();

                // Calculate lapse time difference
                $last_dateTimeObject1 = date_create($pause_second_half->lapse_time);
                $last_dateTimeObject2 = date_create($match_fixture_lapse->lapse_time);
                $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                $lapse_diff = $difference->format('%H:%I:%S');
                $stat_time_record = $difference->format('%H:%I:%S');

                // Update lapse time difference
                $update_lapse = Match_fixture_lapse::find($match_fixture_lapse->id);
                $update_lapse->lapse_diff = $lapse_diff;
                $update_lapse->save();

                // Record match fixture stat for the second half
                $match_fixture_stat = new Match_fixture_stat();
                $match_fixture_stat->match_fixture_id = $this->match_fixture->id;
                $match_fixture_stat->competition_id = $this->match_fixture->competition_id;
                $match_fixture_stat->team_id = $this->match_fixture->teamOne_id;
                $match_fixture_stat->stat_type = 2;
                $match_fixture_stat->player_id = $team_player->attendee_id;
                $match_fixture_stat->sport_stats_id = 19;
                $match_fixture_stat->stat_time = now();
                $match_fixture_stat->half_type = 2;
                $match_fixture_stat->save();

                // Update sport detail for the second half
                $latest_fixture_stat = Match_fixture_stat::select('stat_time')
                    ->where('match_fixture_id', $this->match_fixture->id)
                    ->where('sport_stats_id', 14)
                    ->latest()
                    ->first();

                $last_dateTimeObject1 = date_create($latest_fixture_stat->stat_time);
                $last_dateTimeObject2 = date_create($match_fixture_stat->stat_time);
                $difference = date_diff($last_dateTimeObject1, $last_dateTimeObject2);
                $stat_diff = $difference->format('%H:%I:%S');
                $stat_time_record = $difference->format('%H:%I:%S');

                // Update stat information
                $update_stat = Match_fixture_stat::find($match_fixture_stat->id);
                $update_stat->stat_diff = $stat_diff;
                $update_stat->stat_time_record = $stat_time_record;
                $update_stat->save();
            }
            $elapsedDuringPause = Carbon::now()->diffInSeconds($this->pauseTime);
            $this->startTime = $this->startTime->addSeconds($elapsedDuringPause);
            $this->isPaused = false;
            $this->dispatch('resume-timer');
        }
    }

    public function updateTimer()
    {
        if ($this->isActive && !$this->isPaused) {
            $elapsed = Carbon::now()->diffInSeconds($this->startTime);
            $this->elapsedTime = min($this->totalTime, $elapsed);

            if ($this->elapsedTime >= $this->totalTime) {
                $this->isActive = false;
                $this->elapsedTime = $this->totalTime;
                $this->dispatch('timer-ended');
                // dd("timer end");
                // dd($this->elapsedTime);
            }
        }
    }

    private function resetTimer()
    {
        $this->isPaused = false;
        $this->isActive = false;
        $this->elapsedTime = 0; // Start from 00:00
    }
}
