<div class="row mt-4 mtopNew" wire:poll.1s>
    <button class="processed" wire:click="refresh">Refresh</button>
    @if ($match_fixture->finishdate_time == '')
        <div class="col-md-5 col-6 position-relative">
            @if ($fixture_squad_teamOne->isEmpty())
                @foreach ($teamOne_attendees as $tm1)
                    <?php $team_member = App\Models\Team_member::select('jersey_number')
                        ->where('member_id', $tm1->attendee_id)
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
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                    alt="" height="100">
                            </div>
                        </div>
                        <div class="jersy-plyr-title d-flex">
                            {{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
                        </div>
                    </div>
                @endforeach

                <div class="overlay-hide"></div>
                <div class="overlay-button">
                    <button class="btn btn-green modal_teamOne"
                        style="background-color:{{ $teamOne->team_color }}; color:{{ $teamOne->font_color }};"
                        data-bs-toggle="modal" data-bs-target="#squadModal_teamOne" data-id="{{ $teamOne->id }}">Select
                        Starting Lineup</button>
                </div>
            @else
                <div class="row">
                    @foreach ($fixture_squad_teamOne as $tm1)
                        <?php $goal1 = App\Models\Match_fixture_stat::select('id')
                            ->where('match_fixture_id', $match_fixture->id)
                            ->where('team_id', $teamOne->id)
                            ->where('player_id', $tm1->player->id)
                            ->where('sport_stats_id', 1)
                            ->get(); ?>
                        <?php $red_card = App\Models\Match_fixture_stat::select('id')
                            ->where('match_fixture_id', $match_fixture->id)
                            ->where('team_id', $teamOne->id)
                            ->where('player_id', $tm1->player->id)
                            ->where('sport_stats_id', 3)
                            ->get(); ?>
                        <?php $yellow_card = App\Models\Match_fixture_stat::select('id')
                            ->where('match_fixture_id', $match_fixture->id)
                            ->where('team_id', $teamOne->id)
                            ->where('player_id', $tm1->player->id)
                            ->where('sport_stats_id', 2)
                            ->get(); ?>
                        <?php $team_member = App\Models\Team_member::select('jersey_number')
                            ->where('member_id', $tm1->player_id)
                            ->where('team_id', $teamOne->id)
                            ->first(); ?>
                        <div class="col-md-4">

                            @if ($match_fixture->startdate_time != null)
                                @if (@$fixture_lapse_type->lapse_type == 1)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @elseif($fixture_lapse_type->lapse_type == 3)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @elseif(@$fixture_lapse_type->lapse_type == 4)
                                    <div class="player-jersy-list" style="width: 100%">
                                        <img class="rounded-circle"
                                            src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                            alt="" height="100" width="100">
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
                                @elseif(@$fixture_lapse_type->lapse_type == 5)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a red card')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @elseif(@$fixture_lapse_type->lapse_type == 8)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @else
                                    @if ($match_fixture->finishdate_time != null)
                                    @else
                                        <div class="player-jersy-list" style="width: 100%"
                                            wire:click="alertstopmatch">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @endif
                                @endif
                            @else
                                <div class="player-jersy-list" style="width: 100%">
                                    <img class="rounded-circle"
                                        src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                        alt="" height="100" width="100">
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
                            @endif
                        </div>
                    @endforeach
                    <div class="col-md-4">
                        <?php $ownGoalCount = App\Models\Match_fixture_stat::select('id')
                            ->where('match_fixture_id', $match_fixture->id)
                            ->where('team_id', $teamOne->id)
                            ->where('player_id', 16)
                            ->where('sport_stats_id', 54)
                            ->get(); ?>
                        @if ($match_fixture->startdate_time != null)
                            @if (@$fixture_lapse_type->lapse_type == 1 || @$fixture_lapse_type->lapse_type == 3)
                                <div class="player-jersy-list team_ownGoal" data-id="{{ $teamOne->id }}"
                                    style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @elseif(@$fixture_lapse_type->lapse_type == 5 || @$fixture_lapse_type->lapse_type == 8)
                                <div class="player-jersy-list team_ownGoal" data-id="{{ $teamOne->id }}"
                                    style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @elseif(@$fixture_lapse_type->lapse_type == 6 || @$fixture_lapse_type->lapse_type == 9)
                                <div class="player-jersy-list" wire:click="alertstopmatch" style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @else
                                <div class="player-jersy-list" style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @endif
                        @else
                            <div class="player-jersy-list" style="width:100%">
                                <div class="jersy-img-wrap mb-2">
                                    <style>
                                    </style>
                                    <div class="jersy-img">
                                        <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                            alt="" height="100">
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
                        @endif
                    </div>
                </div>
            @endif


            {{-- For Substitute players --}}
            @if (count($subplyr1) > 0)
                <hr>

                <span>Substitutes</span>
                <div class="row mb-4 p-3">
                    <div class="col-md-12 col-12 ">

                        @foreach ($subplyr1 as $tm1)
                            <?php
                            $team_member = App\Models\Team_member::select('jersey_number')
                                ->where('member_id', $tm1->player_id)
                                ->where('team_id', $teamOne->id)
                                ->first();

                            $goal1 = App\Models\Match_fixture_stat::select('id')
                                ->where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $teamOne->id)
                                ->where('player_id', $tm1->player->id)
                                ->where('sport_stats_id', 1)
                                ->get();
                            ?>
                            <div class="player-jersy-list player_score"
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
                                        @if (!empty($team_member->jersey_number))
                                            {{ $team_member->jersey_number }}
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
                        @endforeach

                    </div>

                </div>
            @else
            @endif


        </div>

        <div class="col-md-2 Border-RightLeft2">
            @if ($match_fixture->startdate_time != null)
                @if (!empty($scorerofthematch))
                    <?php $user = App\Models\User::select('id', 'first_name', 'last_name', 'profile_pic')->find($scorerofthematch['player_id']); ?>
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
                                        alt="" class=""></div>
                            </div>
                        </div>
                    </a>
                @else
                @endif
            @else
            @endif
            @if ($match_fixture->refree_id != '')
                <?php $refree = App\Models\User::select('id', 'first_name', 'last_name', 'profile_pic')->find($match_fixture->refree_id); ?>
                <a href="{{ url('player_profile/' . $refree->id) }}" target="a_blank">
                    <div class="player-refer-bottom text-center">
                        <div class="crop-circle">
                            <img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}" alt=""
                                class="img-fluid">
                        </div>
                        <h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }}
                            {{ $refree->last_name }}
                        </h3>
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
            <div class="mt-4 text-center">
                @if (count($comp_referees) > 0 && $match_fixture->startdate_time == null)
                    <button class="btn btn-green " data-bs-toggle="modal" data-bs-target="#select_refree">Select
                        Referee</button>
                @else
                @endif
            </div>
        </div>

        <div class="col-md-5 col-6 position-relative BorderMobil">
            @if ($fixture_squad_teamTwo->isEmpty())
                @foreach ($teamTwo_attendees as $tm2)
                    <?php $team_member = App\Models\Team_member::select('jersey_number')
                        ->where('member_id', $tm2->attendee_id)
                        ->where('team_id', $teamTwo->id)
                        ->first(); ?>
                    <style>
                        .jersy2::after {
                            color: <?php echo $teamTwo->team_color; ?>;
                        }
                    </style>
                    <div class="player-jersy-list" data-bs-target="#plyrRecord" data-bs-toggle="modal">
                        <div class="jersy-img-wrap mb-2">
                            <span class="jersy-no team-jersy-right jersy2">
                                @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif
                            </span>
                            <div class="jersy-img">
                                <img class="img-fluid"
                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                    alt="" height="100">
                            </div>

                        </div>
                        <div class="jersy-plyr-title d-flex">
                            <span class="score">50</span>
                            {{ $tm2->player->first_name }} {{ $tm2->player->last_name }}
                        </div>
                    </div>
                @endforeach
                <div class="overlay-hide"></div>
                <div class="overlay-button"><button class="btn btn-green"
                        style="background-color:{{ $teamTwo->team_color }}; color:{{ $teamTwo->font_color }};"
                        data-bs-toggle="modal" data-bs-target="#squadModal_teamTwo"
                        data-id="{{ $teamTwo->id }}">Select
                        Starting Lineup</button></div>
            @else
                <div class="row">
                    @foreach ($fixture_squad_teamTwo as $tm2)
                        <div class="col-md-4">
                            <?php $goal1 = App\Models\Match_fixture_stat::select('id')
                                ->where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $teamTwo->id)
                                ->where('player_id', $tm2->player->id)
                                ->where('sport_stats_id', 1)
                                ->get(); ?>
                            <?php $red_card = App\Models\Match_fixture_stat::select('id')
                                ->where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $teamTwo->id)
                                ->where('player_id', $tm2->player->id)
                                ->where('sport_stats_id', 3)
                                ->get(); ?>
                            <?php $yellow_card = App\Models\Match_fixture_stat::select('id')
                                ->where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $teamTwo->id)
                                ->where('player_id', $tm2->player->id)
                                ->where('sport_stats_id', 2)
                                ->get(); ?>
                            <?php $team_member = App\Models\Team_member::select('jersey_number')
                                ->where('member_id', $tm2->player_id)
                                ->where('team_id', $teamTwo->id)
                                ->first();
                            ?>

                            @if ($match_fixture->startdate_time != null)
                                @if (@$fixture_lapse_type->lapse_type == 1)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm2->player_id }},{{ $teamTwo->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @elseif(@$fixture_lapse_type->lapse_type == 3)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm2->player_id }},{{ $teamOne->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @elseif(@$fixture_lapse_type->lapse_type == 4)
                                    <div class="player-jersy-list" style="width: 100%">
                                        <img class="rounded-circle"
                                            src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                            alt="" height="100" width="100">
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
                                @elseif(@$fixture_lapse_type->lapse_type == 5)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                alt="" height="100" width="100">

                                        </div>
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm2->player_id }},{{ $teamTwo->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @elseif(@$fixture_lapse_type->lapse_type == 8)
                                    @if ($red_card->isNotEmpty())
                                        <div class="player-jersy-list" style="width: 100%"
                                            onclick="return confirm('This player has received a red card')">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @else
                                        @if ($yellow_card->count() >= 2)
                                            <div class="player-jersy-list" style="width: 100%"
                                                onclick="return confirm('This player has received a 2 yellow cards')">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @else
                                            <div class="player-jersy-list player_score" style="width: 100%"
                                                data-id="{{ $tm2->player_id }},{{ $teamTwo->id }}">
                                                <img class="rounded-circle"
                                                    src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                    alt="" height="100" width="100">
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
                                        @endif
                                    @endif
                                @else
                                    @if ($match_fixture->finishdate_time != null)
                                    @else
                                        <div class="player-jersy-list" style="width: 100%"
                                            wire:click="alertstopmatch">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                                alt="" height="100" width="100">
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
                                    @endif
                                @endif
                            @else
                                <div class="player-jersy-list" style="width: 100%">
                                    <img class="rounded-circle"
                                        src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                        alt="" height="100" width="100">
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
                            @endif
                        </div>
                    @endforeach
                    <div class="col-md-4">
                        <?php $ownGoalCount = App\Models\Match_fixture_stat::select('id')
                            ->where('match_fixture_id', $match_fixture->id)
                            ->where('team_id', $teamTwo->id)
                            ->where('player_id', 16)
                            ->where('sport_stats_id', 54)
                            ->get(); ?>
                        @if ($match_fixture->startdate_time != null)
                            @if (@$fixture_lapse_type->lapse_type == 1 || @$fixture_lapse_type->lapse_type == 3)
                                <div class="player-jersy-list team_ownGoal" data-id="{{ $teamTwo->id }}"
                                    style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @elseif(@$fixture_lapse_type->lapse_type == 5 || @$fixture_lapse_type->lapse_type == 8)
                                <div class="player-jersy-list team_ownGoal" data-id="{{ $teamTwo->id }}"
                                    style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @elseif(@$fixture_lapse_type->lapse_type == 6 || @$fixture_lapse_type->lapse_type == 9)
                                <div class="player-jersy-list" wire:click="alertstopmatch" style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @else
                                <div class="player-jersy-list" style="width:100%">
                                    <div class="jersy-img-wrap mb-2">
                                        <style>
                                        </style>
                                        <div class="jersy-img">
                                            <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                                alt="" height="100">
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
                            @endif
                        @else
                            <div class="player-jersy-list" style="width:100%">
                                <div class="jersy-img-wrap mb-2">
                                    <style>
                                    </style>
                                    <div class="jersy-img">
                                        <img class="img-fluid" src="{{ url('frontend/images/football.png') }}"
                                            alt="" height="100">
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
                        @endif
                    </div>
                </div>
            @endif

            {{-- For Substitute players --}}

            @if (count($subplyr2) > 0)
                <hr>

                <span>Substitutes</span>
                <div class="row mb-4 p-3">

                    <div class="col-md-12 col-12 ">

                        @foreach ($subplyr2 as $tm2)
                            <?php
                            $goal1 = App\Models\Match_fixture_stat::select('id')
                                ->where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $teamTwo->id)
                                ->where('player_id', $tm2->player->id)
                                ->where('sport_stats_id', 1)
                                ->get();
                            $team_member = App\Models\Team_member::select('jersey_number')
                                ->where('member_id', $tm2->player_id)
                                ->where('team_id', $teamTwo->id)
                                ->first(); ?>
                            <div class="player-jersy-list player_score"
                                data-id="{{ $tm2->player_id }},{{ $teamTwo->id }}">
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
                                        @if (isset($team_member->jersey_number))
                                            {{ $team_member->jersey_number }}
                                        @else
                                        @endif
                                    </span>
                                    <div class="jersy-img">
                                        <img class="img-fluid"
                                            src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
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
                                        {{ $tm2->player->first_name }} {{ $tm2->player->last_name }}
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            @else
            @endif
            {{-- End substitute players --}}

        </div>
    @else
        {{-- <div class="col-md-5 col-6 position-relative">
            <div class="row">

                @foreach ($fixture_squad_teamOne as $tm1)
                    <?php $goal1 = App\Models\Match_fixture_stat::select('id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamOne->id)
                        ->where('player_id', $tm1->player->id)
                        ->where('sport_stats_id', 1)
                        ->get(); ?>
                    <?php $red_card = App\Models\Match_fixture_stat::select('id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamOne->id)
                        ->where('player_id', $tm1->player->id)
                        ->where('sport_stats_id', 3)
                        ->get(); ?>
                    <?php $yellow_card = App\Models\Match_fixture_stat::select('id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamOne->id)
                        ->where('player_id', $tm1->player->id)
                        ->where('sport_stats_id', 2)
                        ->get(); ?>
                    <?php $team_member = App\Models\Team_member::select('jersey_number')
                        ->where('member_id', $tm1->player_id)
                        ->where('team_id', $teamOne->id)
                        ->first(); ?>
                    <div class="col-md-4 col-6">
                        <div class="player-jersy-list" style="width: 100%">
                            <img class="rounded-circle"
                                src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                alt="" height="100" width="100">
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
                    </div>
                @endforeach
            </div>

        </div>

        <div class="col-md-2 Border-RightLeft2">
            @if ($match_fixture->startdate_time != null)
                @if (!empty($scorerofthematch))
                    <?php $user = App\Models\User::select('id', 'first_name', 'last_name', 'profile_pic')->find($scorerofthematch['player_id']); ?>
                    <a href="{{ url('player_profile/' . $user->id) }}" target="a_blank">
                        <div class=" MAn-of-The-Match">
                            <div class="text-center">
                                <p class="text-center mb-0">Recent Scorer</p>
                                <p class="John-Barinyima text-center">{{ $user->first_name }}
                                    {{ $user->last_name }}
                                </p>
                            </div>
                        </div>
                        <div class="player-of-match">
                            <div class="photo-frame">
                                <div class="crop-img"><img
                                        src="{{ url('frontend/profile_pic') }}/{{ $user->profile_pic }}"
                                        alt="" class=""></div>
                            </div>
                        </div>
                    </a>
                @else
                @endif
            @else
            @endif
            @if ($match_fixture->refree_id != '')
                <?php $refree = App\Models\User::select('id', 'first_name', 'last_name', 'profile_pic')->find($match_fixture->refree_id); ?>
                <a href="{{ url('player_profile/' . $refree->id) }}" target="a_blank">
                    <div class="player-refer-bottom text-center">
                        <div class="crop-circle">
                            <img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}"
                                alt="" class="img-fluid">
                        </div>
                        <h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }}
                            {{ $refree->last_name }}
                        </h3>
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
            <div class="mt-4 text-center">
                @if (count($comp_referees) > 0 && $match_fixture->startdate_time == null)
                    <button class="btn btn-green " data-bs-toggle="modal" data-bs-target="#select_refree">Select
                        Referee</button>
                @else
                @endif
            </div>
        </div>

        <div class="col-md-5 col-6 position-relative">
            <div class="row">

                @foreach ($fixture_squad_teamTwo as $tm2)
                    <?php $goal1 = App\Models\Match_fixture_stat::select('id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamTwo->id)
                        ->where('player_id', $tm2->player->id)
                        ->where('sport_stats_id', 1)
                        ->get(); ?>
                    <?php $red_card = App\Models\Match_fixture_stat::select('id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamTwo->id)
                        ->where('player_id', $tm2->player->id)
                        ->where('sport_stats_id', 3)
                        ->get(); ?>
                    <?php $yellow_card = App\Models\Match_fixture_stat::select('id')
                        ->where('match_fixture_id', $match_fixture->id)
                        ->where('team_id', $teamTwo->id)
                        ->where('player_id', $tm2->player->id)
                        ->where('sport_stats_id', 2)
                        ->get(); ?>
                    <?php $team_member = App\Models\Team_member::select('jersey_number')
                        ->where('member_id', $tm2->player_id)
                        ->where('team_id', $teamTwo->id)
                        ->first(); ?>
                    <div class="col-md-4 col-6">
                        <div class="player-jersy-list" style="width: 100%">
                            <img class="rounded-circle"
                                src="{{ url('frontend/profile_pic') }}/{{ $tm2->player->profile_pic }}"
                                alt="" height="100" width="100">
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
                    </div>
                @endforeach
            </div>
        </div> --}}
        @livewire('fixture-vote-attendees', ['match_fixture_id' => $match_fixture->id])
    @endif

    <div class="modal fade" id="select_refree" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Referee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="select grey-form-control input-sm" wire:model="selectedReferee_id">
                        @if ($comp_referees->isNotEmpty())
                            <option value="" hidden>Select Referee</option>
                            @foreach ($comp_referees as $refree)
                                <option value="{{ $refree->member->id }}"
                                    @if ($refree->member->id == $match_fixture->refree_id) selected @else @endif>
                                    {{ $refree->member->first_name }} {{ $refree->member->last_name }}</option>
                            @endforeach
                        @else
                        @endif
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="selectReferee">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ url('frontend/js/dist_sweetalert.min.js') }}"></script>
    <script>
        window.addEventListener('swal:modal', event => {
            console.log(event.detail[0].message);
            swal({
                title: event.detail[0].message,
                text: event.detail.message,
                icon: event.detail.type,
            });
        });

        window.addEventListener('swal:confirm', event => {
            swal({
                    title: event.detail[0].message,
                    text: event.detail.message,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('remove');
                    }
                });
        });
    </script>
    <script>
        window.addEventListener('closeSelectRefereeModal', event => {
            $('.modal-backdrop.fade.show').hide();
            $('#select_refree').modal('hide');
            $('body').addClass("unsetOverflow");
        });
    </script>
</div>
