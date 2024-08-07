@php
    $fixture = \App\Models\Match_fixture::find($fixtureId);
    $teamOneGoal = \App\Models\Match_fixture_stat::where('match_fixture_id', $fixtureId)
        ->where('team_id', $fixture->teamOne_id)
        ->whereIn('sport_stats_id', [1, 54])
        ->count();

    $teamTwoGoal = \App\Models\Match_fixture_stat::where('match_fixture_id', $fixtureId)
        ->where('team_id', $fixture->teamTwo_id)
        ->whereIn('sport_stats_id', [1, 54])
        ->count();
@endphp

<div wire:poll.5s >
    <span class="btn-greenFXL">{{ $teamOneGoal }}</span>
    <span class="btn-greenFXR">{{ $teamTwoGoal }}</span>
</div>
