<div class="col-md-6 w-100-768">
    <button class="processed" wire:click="refresh">Refresh</button>
    @if ($uservoteintraction->isNotEmpty())

        <h1 class="Poppins-Fs30">Votes &amp; Interactions <button class="btn fs1 float-end"><i
                    class="icon-more_horiz"></i></button></h1>
        <div class="p-2 box-outer-lightpink w-100 ">
            <div class="row w-100 circle">
                @foreach ($uservoteintraction as $vdata)
                    <?php
                    $player_goals = App\Models\Match_fixture_stat::where(['match_fixture_id' => $vdata->match_fixture_id, 'team_id' => $vdata->team_id, 'player_id' => $vdata->player_id, 'sport_stats_id' => 1])->count();
                    if ($vdata->matchFixture->teamOne_id == $vdata->team_id) {
                        $opposte_teamid = $vdata->matchFixture->teamTwo_id;
                    } else {
                        $opposte_teamid = $vdata->matchFixture->teamOne_id;
                    }
                    $opposte_teamname = App\Models\Team::where('id', $opposte_teamid)->value('name');
                    $totalteamvote = App\Models\Voting::where('match_fixture_id', $vdata->match_fixture_id)->count();
                    $circlepercentage = intval(($player_goals / $totalteamvote) * 100);

                    $totalteamplayervote = App\Models\Voting::where('match_fixture_id', $vdata->match_fixture_id)->get();
                    $total_teamplayervote = $totalteamplayervote->groupby('player_id');
                    $playerids = [];
                    foreach ($total_teamplayervote as $player => $votes) {
                        $playerids[$votes->count()] = $player;
                    }
                    krsort($playerids);
                    $vote_count_key = array_keys($playerids);
                    $playervote = $vote_count_key[0];
                    $maxvoterplayerid = $playerids[$playervote];

                    $match_fixture_data = App\Models\Match_fixture::select('competition_id', 'finishdate_time')->find($vdata->match_fixture_id);
                    $comp_voting_time = App\Models\Competition::select('vote_mins')->find($match_fixture_data->competition_id);
                    $dateTimeObject1 = date_create($match_fixture_data->finishdate_time);
                    $dateTimeObject2 = now();
                    $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                    $voting_minutes = $difference->format('%I');

                    $current_date = date('Y-m-d');
                    $finish_date = date('y-m-d', strtotime($match_fixture_data->finishdate_time));
                    if ($current_date == $finish_date) {
                        if ($comp_voting_time->vote_mins > $voting_minutes) {
                            $votediv_class = 'demo2';
                            $votecolor_class = 'lb-bg';
                            $votecolor_icon = 'hourglass-half';
                        } else {
                            if ($maxvoterplayerid == $vdata->player_id) {
                                $votediv_class = 'demo1';
                                $votecolor_class = 'green-bg';
                                $votecolor_icon = 'check';
                            } else {
                                $votediv_class = 'demo3';
                                $votecolor_class = 'red-bg';
                                $votecolor_icon = 'close';
                            }
                        }
                    } else {
                        if ($maxvoterplayerid == $vdata->player_id) {
                            $votediv_class = 'demo1';
                            $votecolor_class = 'green-bg';
                            $votecolor_icon = 'check';
                        } else {
                            $votediv_class = 'demo3';
                            $votecolor_class = 'red-bg';
                            $votecolor_icon = 'close';
                        }
                    }

                    ?>

                    <div class="col-md-4 position-relative col-sm-6 col-xs-12">
                        <div class="all-wrap-process ms-auto position-relative">
                            <div wire:ignore>
                                <div class="{{ $votediv_class }}" data-percent="{{ $circlepercentage }}"></div>
                            </div>
                            <div class="circle-process-wrap">
                                <a href="{{ url('player_profile') }}/{{ $vdata->player->id }}" target="a_blank">
                                    <img src="{{ url('frontend/profile_pic') }}/{{ $vdata->player->profile_pic }}">
                                </a><i
                                    class="icon-{{ $votecolor_icon }} icon-process-chart {{ $votecolor_class }} "></i>
                            </div>
                        </div>
                        <div class="detail-process">
                            <h5>
                                <a href="{{ url('team') }}/{{ $vdata->team->id }}" target="a_blank">
                                    <img class="rounded-circle me-2 heightWidth30"
                                        src="{{ url('frontend/logo') }}/{{ $vdata->team->team_logo }}">
                                </a>
                                <a href="{{ url('player_profile') }}/{{ $vdata->player->id }}" target="a_blank">
                                    {{ $vdata->player->first_name }} </a>
                                <h5>
                                    <p class="blue-text">{{ $player_goals }} Goals for <a
                                            href="{{ url('team') }}/{{ $vdata->team->id }}" target="a_blank">
                                            {{ $vdata->team->name }} </a></p>
                                    <p class="italic grey-text">Vs <a href="{{ url('team') }}/{{ $opposte_teamid }}"
                                            target="a_blank"> {{ $opposte_teamname }} </a></p>
                                    <a href="{{ url('match-fixture') }}/{{ $vdata->matchFixture->id }}"
                                        target="a_blank">
                                        <p class="grey-text">on
                                            {{ date('d M y', strtotime($vdata->matchFixture->startdate_time)) }} in
                                            <span
                                                class="blue-text">{{ $vdata->matchFixture->location = Str::of($vdata->matchFixture->location)->limit(25) }}</span>
                                        </p>
                                    </a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $uservoteintraction->links('cpag.custom') }}

        </div>
    @else
    @endif
</div>
