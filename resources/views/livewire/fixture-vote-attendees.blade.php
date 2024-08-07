<div class="row mt-3 mtopNew" wire:poll.3000ms >
    {{-- <button class="processed" wire:click="refresh">Refresh</button> --}}
    {{-- wire:poll.950ms --}}
    @if ($match_fixture->startdate_time == null)
        <div class="col-md-5 col-6 position-relative">
            @if ($fixture_squad_teamOne->isEmpty())
                @foreach ($teamOne_attendees as $tm1)
                    <?php $team_member = App\Models\Team_member::where('member_id', $tm1->attendee_id)
                        ->where('team_id', $teamOne->id)
                        ->first(); ?>
                    <div class="player-jersy-list">
                        <div class="jersy-img-wrap mb-2">
                            <style>
                                .jersy1::after {
                                    color: <?php echo $teamOne->team_color; ?>;
                                }

                                .jersy1 {
                                    color: <?php echo $teamOne->font_color; ?>;
                                }
                            </style>
                            <span class="jersy-no team-jersy-left jersy1">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid" src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}" height="100">
                            </div>
                        </div>
                        <div class="jersy-plyr-title d-flex">
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="overlay-hide"></div>
                <div class="overlay-button"><button class="btn btn-green"
                        style="background-color:{{ $teamOne->team_color }};">Coming Soon..</button></div>
            @else
                @foreach ($fixture_squad_teamOne as $tm1)
                    <?php $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                        ->where('team_id', $teamOne->id)
                        ->first(); ?>
                    <div class="player-jersy-list" data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                        <div class="jersy-img-wrap mb-2">
                            <style>
                                .jersy1::after {
                                    color: <?php echo $teamOne->team_color; ?>;
                                }

                                .jersy1 {
                                    color: <?php echo $teamOne->font_color; ?>;
                                }
                            </style>
                            <span class="jersy-no team-jersy-left jersy1">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    height="100">
                            </div>

                        </div>
                        <div class="jersy-plyr-title d-flex">
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif
            {{-- For Substitute players --}}
            @if($subplyr1->isEmpty())
            @else
            <hr>
            <span>Substitutes</span>
                <div class="row mb-4 p-3">

                    <div class="col-md-12 col-12 ">

                        @foreach ($subplyr1 as $tm1)
                            <?php $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                                ->where('team_id', $teamOne->id)
                                ->first(); ?>
                            <div class="player-jersy-list "
                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                <div class="jersy-img-wrap mb-2">
                                    <style>
                                        .jersy1::after {
                                            color: <?php echo $teamOne->team_color; ?>;
                                        }

                                        .jersy1 {
                                            color: <?php echo $teamOne->font_color; ?>;
                                        }
                                    </style>
                                    <span class="jersy-no team-jersy-left jersy1">
                                        {{-- @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif --}}
                                    </span>
                                    <div class="jersy-img">
                                        <img class="img-fluid"
                                            src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                            height="100">
                                    </div>
                                </div>
                                <div class="jersy-plyr-title d-flex">
                                    <div class="playerNme">
                                        {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
                @endif
                {{-- End substitute players --}}
            </div>



        <div class="col-md-2 Border-RightLeft2">
            @if (!empty($scorerofthematch))
                <?php $user = App\Models\User::find($scorerofthematch['player_id']); ?>
                <a href="{{ url('player_profile/' . $user->id) }}" target="a_blank">
                    <div class=" MAn-of-The-Match">
                        <div class="text-center">
                            <p class="text-center mb-0">Recent Scorer</p>
                            <p class="John-Barinyima text-center">{{ $user->first_name }} {{ $user->last_name }}</p>
                        </div>
                    </div>
                    <div class="player-of-match">
                        <div class="photo-frame">
                            <div class="crop-img"><img
                                    src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}" class="">
                            </div>
                        </div>
                    </div>
                </a>
            @else
            @endif

            @if($match_fixture->refree_id != "")
                <?php $refree = App\Models\User::find($match_fixture->refree_id); ?>
                <a href="{{ url('player_profile/' . $refree->id) }}" target="a_blank">
                    <div class="player-refer-bottom text-center">
                        <div class="crop-circle">
                            <img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}" alt=""
                                class="img-fluid">
                        </div>
                        <h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }} {{ $refree->last_name }}</h3>
                        <!-- <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i
                                class="icon-star"></i><i class="icon-star"></i></span> -->
                    </div>
                </a>
            @else
                <a href="#" target="a_blank">
                    <div class="player-refer-bottom text-center">
                        <div class="crop-circle">
                            <img src="{{ asset('frontend/profile_pic/default_profile_pic.png') }}" alt=""
                                class="img-fluid">
                        </div>
                        <h3 class="ref-player" style="bottom:0px">REFEREE</h3>
                    </div>
                </a>
            @endif
        </div>
        @if ($fixture_squad_teamTwo->isEmpty())
            <div class="col-md-5 col-6 position-relative BorderMobil">
                @foreach ($teamTwo_attendees as $tm1)
                    <?php $team_member = App\Models\Team_member::where('member_id', $tm1->attendee_id)
                        ->where('team_id', $teamTwo->id)
                        ->first(); ?>
                    <style>
                        .jersy2::after {
                            color: <?php echo $teamTwo->team_color; ?>;
                        }

                        .jersy2 {
                            color: <?php echo $teamTwo->font_color; ?>;
                        }
                    </style>
                    <div class="player-jersy-list " data-id="{{ $tm1->player_id }},{{ $teamTwo->id }}">
                        <div class="jersy-img-wrap mb-2">
                            <span class="jersy-no team-jersy-right jersy2">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    height="100">
                            </div>

                        </div>
                        <div class="jersy-plyr-title d-flex">
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="overlay-hide"></div>
                <div class="overlay-button"><button class="btn btn-green"
                        style="background-color:{{ $teamTwo->team_color }}; ">Coming Soon...</button></div>
            </div>
        @else
            <div class="col-md-5 col-6 position-relative BorderMobil">
                @foreach ($fixture_squad_teamTwo as $tm1)
                    <?php $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                        ->where('team_id', $teamTwo->id)
                        ->first(); ?>
                    <style>
                        .jersy2::after {
                            color: <?php echo $teamTwo->team_color; ?>;
                        }

                        .jersy2 {
                            color: <?php echo $teamTwo->font_color; ?>;
                        }
                    </style>
                    <div class="player-jersy-list " data-id="{{ $tm1->player_id }},{{ $teamTwo->id }}">
                        <div class="jersy-img-wrap mb-2">
                            <span class="jersy-no team-jersy-right jersy2">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    height="100">
                            </div>

                        </div>
                        <div class="jersy-plyr-title d-flex">
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- For Substitute players --}}
                @if($subplyr2->isEmpty())
                @else
                <hr>
                <span>Substitutes</span>
                    <div class="row mb-4 p-3">

                        <div class="col-md-12 col-12 ">

                            @foreach ($subplyr2 as $tm1)
                                <?php $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                                    ->where('team_id', $teamTwo->id)
                                    ->first(); ?>
                                <div class="player-jersy-list "
                                    data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                            .jersy2::after {
                                                color: <?php echo $teamTwo->team_color; ?>;
                                            }

                                            .jersy2 {
                                                color: <?php echo $teamTwo->font_color; ?>;
                                            }
                                        </style>
                                        <span class="jersy-no team-jersy-left jersy2">
                                            {{-- @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif --}}
                                        </span>
                                        <div class="jersy-img">
                                            <img class="img-fluid"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                height="100">
                                        </div>

                                    </div>
                                    <div class="jersy-plyr-title d-flex">
                                        <div class="playerNme">
                                            {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                    {{-- End substitute players --}}
            </div>
        @endif
    @else
        @if ($match_fixture->finishdate_time == null)
            <div class="col-md-5 col-6 position-relative">
                @foreach ($fixture_squad_teamOne as $tm1)
                    <?php $goal1t = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamOne->id)
                        ->where('player_id', $tm1->player_id)
                        ->where('sport_stats_id', 1)
                        ->get(); ?>
                    <?php $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                        ->where('team_id', $teamOne->id)
                        ->first(); ?>
                    <!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
                    <style>
                        .jersy1::after {
                            color: <?php echo $teamOne->team_color; ?>;
                        }

                        .jersy1 {
                            color: <?php echo $teamOne->font_color; ?>;
                        }
                    </style>
                    <span class="player-jersy-list" data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                        <div class="jersy-img-wrap mb-2">
                            <span class="jersy-no team-jersy-left jersy1">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    height="100">
                            </div>
                        </div>
                        <div class="jersy-plyr-title d-flex">
                            @if ($goal1t->count() != 0)
                                <span class="score"><?php echo str_pad($goal1t->count(), 2, 0, STR_PAD_LEFT); ?></span>
                            @else
                                <span class="score01">00</span>
                            @endif
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                    </span>
                @endforeach
                <div class="player-jersy-list">
        <?php $ownGoalCount = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                ->where('team_id', $teamOne->id)
                ->where('player_id', 16)
                ->where('sport_stats_id', 54)
                ->get(); ?>
            <div class="jersy-img-wrap mb-2">
                <style>
                </style>
                <div class="jersy-img">
                    <img class="img-fluid"
                        src="{{ url('frontend/images/football.png') }}" alt=""
                        height="100">
                </div>
            </div>
            <div class="jersy-plyr-title d-flex">
                @if ($ownGoalCount->count() != 0)
                    <span class="score"><?php echo str_pad($ownGoalCount->count(), 2, 0, STR_PAD_LEFT); ?></span>
                @else
                    <span class="score01">00</span>
                @endif
                <div class="playerNme">
                    Own Goal
                </div>
            </div>
        </div>
            {{-- For Substitute players --}}
        @if($subplyr1->isEmpty())
        @else
            <hr>
            <span>Substitutes</span>
                <div class="row mb-4 p-3">
                    <div class="col-md-12 col-12 ">
                        @foreach ($subplyr1 as $tm1)
                            <?php
                            $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $teamOne->id)
                                ->where('player_id', $tm1->player->id)
                                ->where('sport_stats_id', 1)
                                ->get();
                            $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                                ->where('team_id', $teamOne->id)
                                ->first(); ?>
                            <div class="player-jersy-list "
                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                <div class="jersy-img-wrap mb-2">
                                    <style>
                                        .jersy1::after {
                                            color: <?php echo $teamOne->team_color; ?>;
                                        }

                                        .jersy1 {
                                            color: <?php echo $teamOne->font_color; ?>;
                                        }
                                    </style>
                                    <span class="jersy-no team-jersy-left jersy1">
                                        {{-- @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif --}}
                                    </span>
                                    <div class="jersy-img">
                                        <img class="img-fluid"
                                            src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                            height="100">
                                    </div>

                                </div>
                                <div class="jersy-plyr-title d-flex">
                                    @if($goal1->count() != 0)
                                        <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
                                    @else
                                        <span class="score01">00</span>
                                    @endif
                                    <div class="playerNme">
                                        {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif
                {{-- End substitute players --}}
            </div>
            <div class="col-md-2 Border-RightLeft2">
                @if (!empty($scorerofthematch))
                    <?php $user = App\Models\User::find($scorerofthematch['player_id']); ?>
                    <a href="{{ url('player_profile/' . $user->id) }}" target="a_blank">
                        <div class=" MAn-of-The-Match">
                            <div class="text-center">
                                <p class="text-center mb-0">Recent Scorer</p>
                                <p class="John-Barinyima text-center">{{ $user->first_name }} {{ $user->last_name }}
                                </p>
                            </div>
                        </div>
                        <div class="player-of-match">
                            <div class="photo-frame">
                                <div class="crop-img"><img
                                        src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}"
                                        class=""></div>
                            </div>
                        </div>
                    </a>
                @else
                @endif
                @if($match_fixture->refree_id != "")
                    <?php $refree = App\Models\User::find($match_fixture->refree_id); ?>
                    <a href="{{ url('player_profile/' . $refree->id) }}" target="a_blank">
                        <div class="player-refer-bottom text-center">
                            <div class="crop-circle">
                                <img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}" alt=""
                                    class="img-fluid">
                            </div>
                            <h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }} {{ $refree->last_name }}</h3>
                            <!-- <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i
                                    class="icon-star"></i><i class="icon-star"></i></span> -->
                        </div>
                    </a>
                @else
                    <a href="#" target="a_blank">
                        <div class="player-refer-bottom text-center">
                            <div class="crop-circle">
                                <img src="{{ asset('frontend/profile_pic/default_profile_pic.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <h3 class="ref-player" style="bottom:0px">REFEREE</h3>
                        </div>
                    </a>
                @endif
            </div>
            <div class="col-md-5 col-6 position-relative BorderMobil">
                @foreach ($fixture_squad_teamTwo as $tm1)
                    <?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamTwo->id)
                        ->where('player_id', $tm1->player->id)
                        ->where('sport_stats_id', 1)
                        ->get(); ?>
                    <?php $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                        ->where('team_id', $teamTwo->id)
                        ->first(); ?>
                    <!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
                    <style>
                        .jersy2::after {
                            color: <?php echo $teamTwo->team_color; ?>;
                        }

                        .jersy2 {
                            color: <?php echo $teamTwo->font_color; ?>;
                        }
                    </style>
                    <span class="player-jersy-list"
                        data-id="{{ $tm1->player_id }},{{ $teamTwo->id }}">
                        <div class="jersy-img-wrap mb-2">
                            <span class="jersy-no team-jersy-right jersy2">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    height="100">
                            </div>
                        </div>
                        <div class="jersy-plyr-title d-flex">
                            @if ($goal1->count() != 0)
                                <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
                            @else
                                <span class="score01">00</span>
                            @endif
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                    </span>
                @endforeach
                <?php $ownGoalCount2 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                    ->where('team_id', $teamTwo->id)
                    ->where('player_id', 16)
                    ->where('sport_stats_id', 54)
                    ->get(); ?>
                    <div class="player-jersy-list">
                        <div class="jersy-img-wrap mb-2">
                            <style>
                            </style>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/images/football.png') }}" alt=""
                                    height="100">
                            </div>
                        </div>
                        <div class="jersy-plyr-title d-flex">
                            @if ($ownGoalCount2->count() != 0)
                                <span class="score"><?php echo str_pad($ownGoalCount2->count(), 2, 0, STR_PAD_LEFT); ?></span>
                            @else
                                <span class="score01">00</span>
                            @endif
                            <div class="playerNme">
                                Own Goal
                            </div>
                        </div>
                    </div>
                    {{-- For Substitute players --}}
                @if($subplyr2->isEmpty())
                @else
                <hr>
                <span>Substitutes</span>
                    <div class="row mb-4 p-3">

                        <div class="col-md-12 col-12 ">

                            @foreach ($subplyr2 as $tm1)
                                <?php
                                $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                                    ->where('team_id', $teamTwo->id)
                                    ->where('player_id', $tm1->player->id)
                                    ->where('sport_stats_id', 1)
                                    ->get();
                                $team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                                    ->where('team_id', $teamTwo->id)
                                    ->first(); ?>
                                <div class="player-jersy-list "
                                    data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                            .jersy2::after {
                                                color: <?php echo $teamTwo->team_color; ?>;
                                            }

                                            .jersy2 {
                                                color: <?php echo $teamTwo->font_color; ?>;
                                            }
                                        </style>
                                        <span class="jersy-no team-jersy-left jersy2">
                                            {{-- @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif --}}
                                        </span>
                                        <div class="jersy-img">
                                            <img class="img-fluid"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                height="100">
                                        </div>

                                    </div>
                                    <div class="jersy-plyr-title d-flex">
                                        @if($goal1->count() != 0)
                                            <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
                                        @else
                                            <span class="score01">00</span>
                                        @endif
                                        <div class="playerNme">
                                            {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                    {{-- End substitute players --}}
            </div>
        @else
            @if ($competition->vote_mins > $voting_minutes)
                <div class="col-md-5 col-6 position-relative">
                    @foreach ($teamOne_attendees as $tm1)
                        <?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                            ->where('team_id', $teamOne->id)
                            ->where('player_id', $tm1->player->id)
                            ->where('sport_stats_id', 1)
                            ->get(); ?>
                        <?php $team_member = App\Models\Team_member::where('member_id', $tm1->attendee_id)
                            ->where('team_id', $teamOne->id)
                            ->first(); ?>
                        <!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
                        @if (Auth::check())
                            @if ($tm1->attendee_id == Auth::user()->id)
                                <div class="player-jersy-list"
                                    onclick="return confirm('Player cant vote for itself')">
                                @else
                                    @if ($voting == null)
                                        <div class="player-jersy-list"
                                            onclick="return confirm('Are you sure you want to submit vote for?') || event.stopImmediatePropagation()"
                                            wire:click="vote({{ $tm1->attendee_id }}, {{ $teamOne->id }})">
                                        @else
                                            @if ($tm1->attendee_id == $voting->player_id)
                                                <div class="player-jersy-list myvoting"
                                                    onclick="return confirm('You already vote to this player')">
                                                @else
                                                    <div class="player-jersy-list"
                                                        onclick="return confirm('Are you sure you want to change vote for the player?') || event.stopImmediatePropagation()"
                                                        wire:click="vote({{ $tm1->attendee_id }} , {{ $teamOne->id }})">
                                            @endif
                                    @endif
                            @endif
                        @else
                            <div class="player-jersy-list" onclick="return confirm('Please Sign In first')">
                        @endif
                        <div class="jersy-img-wrap mb-2">
                            <style>
                                .jersy1::after {
                                    color: <?php echo $teamOne->team_color; ?>;
                                }

                                .jersy1 {
                                    color: <?php echo $teamOne->font_color; ?>;
                                }
                            </style>
                            <span class="jersy-no team-jersy-left jersy1">
                                @if ($team_member->jersey_number != null)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    height="100">
                            </div>
                            <span class="jersy-star"><i class="icon-star"></i></span>
                        </div>
                        <div class="jersy-plyr-title d-flex">
                            @if ($goal1->count() != 0)
                                <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
                            @else
                                <span class="score01">00</span>
                            @endif
                            <div class="playerNme">
                                {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                            </div>
                        </div>
                </div>
            @endforeach
</div>
<div class="col-md-2  Border-RightLeft2">
    @if (!empty($playerofthematch))
        <?php $user = App\Models\User::find($playerofthematch['player_id']); ?>
        <div class=" MAn-of-The-Match player_of_the_match">
            <div class="text-center">
                <p class="text-center mb-0">Player of the Match</p>
                <p class="John-Barinyima text-center">{{ $user->first_name }} {{ $user->last_name }}</p>
            </div>
        </div>
        <div class="player-of-match">
            <div class="photo-frame">
                <div class="crop-img"><img src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}"
                        class=""></div>
            </div>
        </div>
    @else
        <!-- @if (!empty($scorerofthematch))
            <?php $user = App\Models\User::find($scorerofthematch['player_id']); ?>
            <a href="{{ url('player_profile/' . $user->id) }}" target="a_blank">
                <div class=" MAn-of-The-Match">
                    <div class="text-center">
                        <p class="text-center mb-0">Recent Scorer</p>
                        <p class="John-Barinyima text-center">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                </div>
                <div class="player-of-match">
                    <div class="photo-frame">
                        <div class="crop-img"><img src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}"
                                class=""></div>
                    </div>
                </div>
            </a>
        @else
        @endif -->
        <div class=" MAn-of-The-Match player_of_the_match">
            <div class="text-center">
                <p class="text-center mb-0">Player of the Match</p>
                <p class="John-Barinyima text-center">Player Name</p>
            </div>
        </div>
        <div class="player-of-match">
            <div class="photo-frame">
                <div class="crop-img"><img src="{{ url('frontend/profile_pic/default_profile_pic.png') }}" class=""></div>
            </div>
        </div>
    @endif
    @if($match_fixture->refree_id != "")
        <div class="player-refer-bottom text-center">
            <?php $refree = App\Models\User::find($match_fixture->refree_id); ?>
            <div class="crop-circle">
                <img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}" class="img-fluid">
            </div>
            <h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }} {{ $refree->last_name }}</h3>
            <!-- <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i
                    class="icon-star"></i><i class="icon-star"></i></span> -->
        </div>
    @else
        <div class="player-refer-bottom text-center">
            <div class="crop-circle">
                <img src="{{ asset('frontend/profile_pic/default_profile_pic.png') }}" class="img-fluid">
            </div>
            <h3 class="ref-player" style="bottom:0px">REFEREE</h3>
            <!-- <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i
                    class="icon-star"></i><i class="icon-star"></i></span> -->
        </div>
    @endif
</div>
<div class="col-md-5 col-6 position-relative BorderMobil">
    @foreach ($teamTwo_attendees as $tm2)
        <?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamTwo->id)
            ->where('player_id', $tm2->player->id)
            ->where('sport_stats_id', 1)
            ->get(); ?>
        <?php $team_member = App\Models\Team_member::where('member_id', $tm2->attendee_id)
            ->where('team_id', $teamTwo->id)
            ->first(); ?>
        <!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
        @if (Auth::check())
            @if ($tm2->attendee_id == Auth::user()->id)
                <div class="player-jersy-list" onclick="return confirm('Player cant vote for itself')">
            @else
                @if ($voting == null)
                    <div class="player-jersy-list"
                        onclick="return confirm('Are you sure you want to submit vote ? ') || event.stopImmediatePropagation()"
                        wire:click="vote({{ $tm2->attendee_id }}, {{ $teamTwo->id }})">
                @else
                    @if ($tm2->attendee_id == $voting->player_id)
                        <div class="player-jersy-list myvoting"
                            onclick="return confirm('You already vote to this player.')">
                    @else
                        <div class="player-jersy-list"
                            onclick="return confirm('Are you sure you want to change vote for the player?') || event.stopImmediatePropagation()"
                            wire:click="vote({{ $tm2->attendee_id }} , {{ $teamTwo->id }})">
                    @endif
                @endif
            @endif
        @else
            <div class="player-jersy-list" onclick="return confirm('Please Sign In first.')">
        @endif
        <div class="jersy-img-wrap mb-2">
            <style>
                .jersy2::after {
                    color: <?php echo $teamTwo->team_color; ?>;
                }

                .jersy2 {
                    color: <?php echo $teamTwo->font_color; ?>;
                }
            </style>
            <span class="jersy-no team-jersy-right jersy2">
                @if ($team_member->jersey_number)
                    {{ $team_member->jersey_number }}
                @else
                @endif
            </span>
            <div class="jersy-img">
                <img class="img-fluid" src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                    height="100">
            </div>
            <span class="jersy-star"><i class="icon-star"></i></span>
        </div>
        <div class="jersy-plyr-title d-flex">
            @if ($goal1->count() != 0)
                <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
            @else
                <span class="score01">00</span>
            @endif
            <div class="playerNme">
                {{ $tm2->player->first_name }} {{ $tm2->player->last_name }}
            </div>
        </div>
</div>
@endforeach
</div>
@else
<!--  Winner Page-->
<div class="col-md-5 col-6 position-relative">
    @foreach ($teamOne_attendees as $tm1)
        <?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamOne->id)
            ->where('player_id', $tm1->player->id)
            ->where('sport_stats_id', 1)
            ->get(); ?>
        <?php $team_member = App\Models\Team_member::where('member_id', $tm1->attendee_id)
            ->where('team_id', $teamOne->id)
            ->first(); ?>
        <!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
        <a href="{{ url('player_profile/' . $tm1->player->id) }}" target="a_blank">
            <div class="player-jersy-list">
                <div class="jersy-img-wrap mb-2">
                    <style>
                        .jersy1::after {
                            color: <?php echo $teamOne->team_color; ?>;
                        }

                        .jersy1 {
                            color: <?php echo $teamOne->font_color; ?>;
                        }
                    </style>
                    <span class="jersy-no team-jersy-left jersy1">
                        @if ($team_member->jersey_number)
                            {{ $team_member->jersey_number }}
                        @else
                        @endif
                    </span>
                    <div class="jersy-img">
                        <img class="img-fluid"
                            src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                            height="100">
                    </div>

                </div>
                <div class="jersy-plyr-title d-flex">
                    @if ($goal1->count() != 0)
                        <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
                    @else
                        <span class="score01">00</span>
                    @endif
                    <div class="playerNme">
                        {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>

<div class="col-md-2  Border-RightLeft2">
    @if (!empty($playerofthematch))
        <?php $user = App\Models\User::find($playerofthematch['player_id']); ?>
        <div class=" MAn-of-The-Match player_of_the_match">
            <div class="text-center">
                <p class="text-center mb-0">Player of the Match</p>
                <p class="John-Barinyima text-center">{{ $user->first_name }} {{ $user->last_name }}</p>
            </div>
        </div>
        <div class="player-of-match">
            <div class="photo-frame">
                <div class="crop-img"><img src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}"
                        class=""></div>
            </div>
        </div>
    @else
        <!-- @if (!empty($scorerofthematch))
            <?php $user = App\Models\User::find($scorerofthematch['player_id']); ?>
            <a href="{{ url('player_profile/' . $user->id) }}" target="a_blank">
                <div class=" MAn-of-The-Match">
                    <div class="text-center">
                        <p class="text-center mb-0">Recent Scorer</p>
                        <p class="John-Barinyima text-center">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                </div>
                <div class="player-of-match">
                    <div class="photo-frame">
                        <div class="crop-img"><img
                                src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}" class="">
                        </div>
                    </div>
                </div>
            </a>
        @else
        @endif -->
        <div class=" MAn-of-The-Match player_of_the_match">
            <div class="text-center">
                <p class="text-center mb-0">Player of the Match</p>
                <p class="John-Barinyima text-center">Player Name</p>
            </div>
        </div>
        <div class="player-of-match">
            <div class="photo-frame">
                <div class="crop-img"><img src="{{ url('frontend/profile_pic/default_profile_pic.png') }}"
                        class=""></div>
            </div>
        </div>
    @endif

    @if($match_fixture->refree_id != "")
        <?php $refree = App\Models\User::find($match_fixture->refree_id); ?>
        <a href="{{ url('player_profile/' . $refree->id) }}" target="a_blank">
            <div class="player-refer-bottom text-center">
                <div class="crop-circle">
                    <img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}" alt=""
                        class="img-fluid">
                </div>
                <h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }} {{ $refree->last_name }}</h3>
                <!-- <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i
                        class="icon-star"></i><i class="icon-star"></i></span> -->
            </div>
        </a>
    @else
        <a href="#" target="a_blank">
            <div class="player-refer-bottom text-center">
                <div class="crop-circle">
                    <img src="{{ asset('frontend/profile_pic/default_profile_pic.png') }}" alt=""
                        class="img-fluid">
                </div>
                <h3 class="ref-player" style="bottom:0px">REFEREE</h3>
            </div>
        </a>
    @endif

</div>

<div class="col-md-5 col-6 position-relative  BorderMobil">
    @foreach ($teamTwo_attendees as $tm1)
        <?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
            ->where('team_id', $teamTwo->id)
            ->where('player_id', $tm1->player->id)
            ->where('sport_stats_id', 1)
            ->get(); ?>
        <?php $team_member = App\Models\Team_member::where('member_id', $tm1->attendee_id)
            ->where('team_id', $teamTwo->id)
            ->first(); ?>
        <!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
        <a href="{{ url('player_profile/' . $tm1->player->id) }}" target="a_blank">
            <div class="player-jersy-list">
                <div class="jersy-img-wrap mb-2">
                    <style>
                        .jersy2::after {
                            color: <?php echo $teamTwo->team_color; ?>;
                        }

                        .jersy2 {
                            color: <?php echo $teamTwo->font_color; ?>;
                        }
                    </style>
                    <span class="jersy-no team-jersy-right jersy2">
                        @if ($team_member->jersey_number)
                            {{ $team_member->jersey_number }}
                        @else
                        @endif
                    </span>
                    <div class="jersy-img">
                        <img class="img-fluid"
                            src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                            height="100">
                    </div>
                </div>
                <div class="jersy-plyr-title d-flex">
                    @if ($goal1->count() != 0)
                        <span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
                    @else
                        <span class="score01">00</span>
                    @endif
                    <div class="playerNme">
                        {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endif
@endif
@endif
</div>
