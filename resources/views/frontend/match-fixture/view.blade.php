@include('frontend/includes/header')
<style>
    .select-box .select_player {
        text-align: center;
    }

    .select-box .teamTwoselect_player {
        text-align: center;
    }

    .unsetOverflow {
        overflow: unset !important;
    }
</style>
<style>
    .processed {
        display: none;
    }
</style>
<div class="header-bottom">
    <button id="triggerAll" class="RefreshButtonTop btn btn-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
            <path
                d="M15.8591 9.625H21.2662C21.5577 9.625 21.7169 9.96492 21.5303 10.1888L18.8267 13.4331C18.6893 13.598 18.436 13.598 18.2986 13.4331L15.595 10.1888C15.4084 9.96492 15.5676 9.625 15.8591 9.625Z"
                fill="white" />
            <path
                d="M0.734056 12.375H6.14121C6.43266 12.375 6.59187 12.0351 6.40529 11.8112L3.70171 8.56689C3.56428 8.40198 3.31099 8.40198 3.17356 8.56689L0.469979 11.8112C0.283401 12.0351 0.442612 12.375 0.734056 12.375Z"
                fill="white" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11.0001 4.125C8.86546 4.125 6.95841 5.09708 5.69633 6.62528C5.45455 6.91805 5.02121 6.95938 4.72845 6.7176C4.43569 6.47581 4.39436 6.04248 4.63614 5.74972C6.14823 3.91879 8.43799 2.75 11.0001 2.75C15.045 2.75 18.4087 5.66019 19.1141 9.50079C19.1217 9.54209 19.129 9.5835 19.136 9.625H17.7377C17.1011 6.48695 14.3258 4.125 11.0001 4.125ZM4.26252 12.375C4.89916 15.5131 7.67452 17.875 11.0001 17.875C13.1348 17.875 15.0419 16.9029 16.3039 15.3747C16.5457 15.082 16.9791 15.0406 17.2718 15.2824C17.5646 15.5242 17.6059 15.9575 17.3641 16.2503C15.852 18.0812 13.5623 19.25 11.0001 19.25C6.95529 19.25 3.59161 16.3398 2.88614 12.4992C2.87856 12.4579 2.87128 12.4165 2.86431 12.375H4.26252Z"
                fill="white" />
        </svg>
    </button>
    {{-- <button wire:click="refresh">Refresh</button> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
    </div>
</div>
<main id="main" class="vote-page">
    <div class="container mb-3">
        <div class="row header-page">
            <div class="col-lg-12">
                <?php $competitionname = explode(' ', $competition->name); ?>
                <a href="{{ URL::to('competition/' . $competition->id) }}">
                    <h2><?php echo array_shift($competitionname); ?> <strong><?php echo implode(' ', $competitionname); ?></strong></h2>
                </a>

                <span class="float-md-end" style="margin-top: -5.5%;">
                    @livewire('matchfixture-submit-detail-stat', ['match_fixture' => $match_fixture])
                </span>
            </div>
        </div>
        <div class="mt-3 row">
            <div class="col-lg-12">
                <div class="teamvs-outer ">
                    <div class="team-logo-vs-l"><a href="{{ url('team/' . $teamOne->id) }}" target="_blank"><img
                                src="{{ url('frontend/logo') }}/{{ $teamOne->team_logo }}" alt="Image"
                                class="img-fluid-Custom "></a></div>
                    <div class="team-logo-vs-r"><a href="{{ url('team/' . $teamTwo->id) }}" target="_blank"><img
                                src="{{ url('frontend/logo') }}/{{ $teamTwo->team_logo }}" alt="Image"
                                class="img-fluid-Custom "></a></div>

                    <div class="d-flex team-vs">
                        <div class="score">V<span>S</span></div>
                        <div class="team-1 w-50" style="background-color:{{ $teamOne->team_color }};">
                            <style>
                                .team-details-left h3 a:hover {
                                    color: <?php echo $teamOne->font_color; ?> !important;
                                }
                            </style>
                            <div class="team-details w-100 team-details-left">

                                <h3><a href="{{ url('team/' . $teamOne->id) }}" target="_blank"
                                        style="color:{{ $teamOne->font_color }};"> {{ $teamOne->name }}</a></h3>
                                <p class="text-white" style="color:{{ $teamOne->font_color }} !important;">
                                    {{ $teamOne->location }}
                                <p class="text-white">&nbsp;</p>
                                </p>
                            </div>
                        </div>
                        <div class="team-2 w-50">
                            <style>
                                .team-details-right h3 a:hover {
                                    color: <?php echo $teamTwo->font_color; ?> !important;
                                }
                            </style>
                            <div class="team-details w-100 team-details-right">
                                <h3><a href="{{ url('team/' . $teamTwo->id) }}" target="_blank"
                                        style="color:{{ $teamTwo->font_color }};">{{ $teamTwo->name }}</a></h3>
                                <p class="text-white" style="color:{{ $teamTwo->font_color }} !important;">
                                    {{ $teamTwo->location }}
                                <p class="text-white">&nbsp;</p>
                                </p>
                            </div>
                        </div>
                        <style>
                            .team-vs {
                                background-color: <?php echo $teamOne->team_color; ?>;
                            }

                            .team-vs .team-2::before {
                                background-color: <?php echo $teamTwo->team_color; ?>;

                            }
                        </style>
                    </div>
                    {{-- @livewire('matchfixture-edit-locationtime', ['match_fixture' => $match_fixture->id]) --}}

                    <input type="hidden" id="match_fixture_id" value="{{ $match_fixture->id }}">
                    <input type="hidden" id="teamOne_id" value="{{ $teamOne->id }}">
                    <input type="hidden" id="teamTwo_id" value="{{ $teamTwo->id }}">
                    <div class="text-center match-timer-out">
                        <!-- Start button livewire -->
                        {{-- @livewire('timer', ['match_fixture_id' => $match_fixture->id]) --}}
                        @livewire('start-timer-vpage', ['match_fixture_id' => $match_fixture->id])
                        <!-- End of Start button livewire -->
                    </div>
                </div>
            </div>
        </div>
        {{-- @if (Auth::check())
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                @livewire('fixture-compadmin-attendees', ['match_fixture_id' => $match_fixture->id])
            @elseif(in_array(Auth::user()->id, $team_admins_ids))
                @livewire('fixture-teamadmin-attendees', ['match_fixture_id' => $match_fixture->id])
            @else
                @livewire('fixture-vote-attendees', ['match_fixture_id' => $match_fixture->id])
            @endif
        @else
            @livewire('fixture-vote-attendees', ['match_fixture_id' => $match_fixture->id])
        @endif --}}

        @if (Auth::check())
            @php
                $userId = Auth::user()->id;
            @endphp

            @if (in_array($userId, $admins) || $userId == $competition->user_id)
                {{-- @livewire('fixture-compadmin-attendees', ['match_fixture_id' => $match_fixture->id]) --}}
                @livewire('attendees', ['match_fixture_id' => $match_fixture->id])
            @elseif(in_array($userId, $team_admins_ids))
                @livewire('fixture-teamadmin-attendees', ['match_fixture_id' => $match_fixture->id])
            @else
                @livewire('fixture-vote-attendees', ['match_fixture_id' => $match_fixture->id])
            @endif
            {{-- @else
			@livewire('fixture-vote-attendees', ['match_fixture_id' => $match_fixture->id]) --}}
        @endif


    </div>
    @livewire('detailed-match-report', ['match_fixture_id' => $match_fixture->id])
</main>
<!-- Modal team two -->
<div class="modal fade" id="squadModal_teamTwo">
    <div class="shadow modal-dialog modalfootbal modal-lg " role="document">
        <form method="post" id="submit_fixture_squad_t2" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $match_fixture->id }}" name="match_fixture_id">
            <input type="hidden" value="{{ $teamTwo->id }}" name="team_id">
            <input type="hidden" value="" id="stattimeTeamtwo" name="stattime">
            <div class="modal-content ground-wrap">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-5">
                                <div class="image-profile-icon">
                                    <img src="{{ url('frontend/logo') }}/{{ $teamTwo->team_logo }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="drop-profile">
                                    <div class="dropdown ">
                                        <button class="btn btn-danger btn-lg kanoPillars" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{ $teamTwo->name }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <h4 class="text-black float-md-start" style="font-size: 22px;"> <span
                                        class="text-bolder">Lineup Players:</span>
                                    {{ $competition->lineup_players_num }} </h4>
                            </div>
                            <div class="col-4">
                                <h4 class="text-black float-md-start" style="font-size: 22px;"><span
                                        class="text-bolder">Squad:</span>
                                    <span id="teamTwo-0">0</span>-
                                    <span id="teamTwo-1">0</span>-
                                    <span id="teamTwo-2">0</span>-
                                    <span id="teamTwo-3">0</span>-
                                    <span id="teamTwo-4">0</span>
                                </h4>
                                <button type="submit" class="btn btn-success btn-lg subMitbtn float-md-end"
                                    id="">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="play-ground">
                        <div class="container">
                            <div class="mb-5 row">
                                <div class="mx-auto text-center col-sm-3 position-relative">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 1)
                                            <?php $tt_goal_keeper = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                ->where('team_id', $teamTwo->id)
                                                ->where('sport_ground_positions_id', $gmp->id)
                                                ->where('is_active', 1)
                                                ->with('player:id,profile_pic,first_name,last_name')
                                                ->first();
                                            if (!empty($tt_goal_keeper)) {
                                                $tt_goal_keeper_pic = 'profile_pic/' . $tt_goal_keeper->player->profile_pic;
                                            } else {
                                                $tt_goal_keeper_pic = 'images/player_copy.png';
                                            }
                                            $teamTwo_goalkeeper_div_id = 'teamTwo_' . $gmp->id;

                                            ?>
                                            @if (!empty($tt_goal_keeper))
                                                <?php $tt_goal_keeper_jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                    ->where('member_id', $tt_goal_keeper->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy2">
                                                    {{ $tt_goal_keeper_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img">
                                                <img src="{{ url('frontend') }}/{{ $tt_goal_keeper_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="teamTwo_player_img{{ $gmp->id }}">
                                            </div>
                                            <div class="select-box">
                                                <select name="players[]"
                                                    class="teamTwogoal_keeper teamTwoselect_player"
                                                    id="{{ $teamTwo_goalkeeper_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamTwo_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id);
                                                        $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamTwo->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number');
                                                        ?>
                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 2)
                                        <?php $tt_defender = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamTwo->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($tt_defensive)) {
                                            $tt_defender_pic = 'profile_pic/' . $tt_defender->player->profile_pic;
                                        } else {
                                            $tt_defender_pic = 'images/player_copy.png';
                                        }
                                        $teamTwo_defender_div_id = 'teamTwo_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($tt_defender))
                                                <?php $tt_defender_jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                    ->where('member_id', $tt_defender->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy2">
                                                    {{ $tt_defender_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $tt_defender_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="teamTwo_player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]" class="teamTwo_defender teamTwoselect_player"
                                                    id="{{ $teamTwo_defender_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamTwo_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamTwo->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number');
                                                        ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 3)
                                        <?php $tt_defensive = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamTwo->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($tt_defensive)) {
                                            $tt_defensive_pic = 'profile_pic/' . $tt_defensive->player->profile_pic;
                                        } else {
                                            $tt_defensive_pic = 'images/player_copy.png';
                                        }
                                        $teamTwo_defensive_div_id = 'teamTwo_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($tt_defensive))
                                                <?php $tt_defensive_jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                    ->where('member_id', $tt_defensive->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy2">
                                                    {{ $tt_defensive_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $tt_defensive_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="teamTwo_player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]"
                                                    class="teamTwo_defensive_midfield teamTwoselect_player"
                                                    id="{{ $teamTwo_defensive_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamTwo_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamTwo->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number');
                                                        ?>
                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>

                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 4)
                                        <?php $tt_midfield = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamTwo->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->with('player')
                                            ->first();
                                        if (!empty($tt_midfield)) {
                                            $tt_midfield_pic = 'profile_pic/' . $tt_midfield->player->profile_pic;
                                        } else {
                                            $tt_midfield_pic = 'images/player_copy.png';
                                        }
                                        $teamTwo_nidfield_div_id = 'teamTwo_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($tt_midfield))
                                                <?php $tt_midfield_jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                    ->where('member_id', $tt_midfield->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy2">
                                                    {{ $tt_midfield_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $tt_midfield_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="teamTwo_player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]" class="teamTwo_midfield teamTwoselect_player"
                                                    id="{{ $teamTwo_nidfield_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamTwo_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamTwo->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number');
                                                        ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>

                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 5)
                                        <?php $tt_attacking = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamTwo->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->with('player')
                                            ->first();
                                        if (!empty($tt_attacking)) {
                                            $tt_attacking_pic = 'profile_pic/' . $tt_attacking->player->profile_pic;
                                        } else {
                                            $tt_attacking_pic = 'images/player_copy.png';
                                        }
                                        $teamTwo_attacking_div_id = 'teamTwo_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($tt_attacking))
                                                <?php $tt_attacking_jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                    ->where('member_id', $tt_attacking->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy2">
                                                    {{ $tt_attacking_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $tt_attacking_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="teamTwo_player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]"
                                                    class="teamTwo_attacking_midfield teamTwoselect_player"
                                                    id="{{ $teamTwo_attacking_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamTwo_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamTwo->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number');
                                                        ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 6)
                                        <?php $tt_striker = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamTwo->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($tt_striker)) {
                                            $ttstriker_pic = 'profile_pic/' . $tt_striker->player->profile_pic;
                                        } else {
                                            $ttstriker_pic = 'images/player_copy.png';
                                        }
                                        $teamTwo_striker_div_id = 'teamTwo_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($tt_striker))
                                                <?php $tt_striker_jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                    ->where('member_id', $tt_striker->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy2">
                                                    {{ $tt_striker_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $ttstriker_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="teamTwo_player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]" class="teamTwo_striker teamTwoselect_player"
                                                    id="{{ $teamTwo_striker_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamTwo_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamTwo->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamTwo->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number');
                                                        ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- 222 -->
            @if ($competition->squad_players_num != $competition->lineup_player_num)
                <div class="modal-content modal-contentBottom">
                    <div class=" bg-light-dark">
                        <div class="px-1 text-center row">
                            <h2 class="text-bolder heading-dark-bg">Substitute Players </h2>
                        </div>
                        <div class="row" id="benchTwoHolder">
                            @if (@$teamTwo_attendees && count($teamTwo_attendees) > 0)
                                @foreach ($teamTwo_attendees as $attendee)
                                    <div class="text-center col col-4 col-md-2 position-relative">
                                        <div class="substitute select-box substitute_players">
                                            {{ $attendee->player->first_name }} {{ $attendee->player->last_name }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
<!-- Modal team one -->
<div class="modal fade" id="squadModal_teamOne">
    <div class="modal-dialog modalfootbal modal-lg " role="document">
        <form method="post" id="submit_fixture_squad" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $match_fixture->id }}" name="match_fixture_id">
            <input type="hidden" value="{{ $teamOne->id }}" name="team_id">
            <input type="hidden" value="" id="stattimeTeamone" name="stattime">
            <div class="modal-content ground-wrap">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-5">
                                <div class="image-profile-icon">
                                    <img src="{{ url('frontend/logo') }}/{{ $teamOne->team_logo }}"
                                        class="img-fluid" alt="">
                                </div>
                                <div class="drop-profile">
                                    <div class="dropdown ">
                                        <button class="btn btn-danger btn-lg kanoPillars" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{ $teamOne->name }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <h4 class="text-black float-md-start" style="font-size: 22px;"> <span
                                        class="text-bolder">Lineup Players:</span>
                                    {{ $competition->lineup_players_num }} </h4>
                            </div>
                            <div class="col-4">
                                <h3 class="text-black float-md-start" style="font-size: 22px;"><span
                                        class="text-bolder">Squad:</span>
                                    <span id="teamOne-0">0</span>-
                                    <span id="teamOne-1">0</span>-
                                    <span id="teamOne-2">0</span>-
                                    <span id="teamOne-3">0</span>-
                                    <span id="teamOne-4">0</span>
                                </h3>
                                <button type="submit" class="btn btn-success btn-lg subMitbtn float-md-end"
                                    id="">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="play-ground">
                        <div class="container">
                            <div class="mb-5 row">
                                <div class="mx-auto text-center col-sm-3 position-relative">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 1)
                                            <?php $goal_keeper = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                ->where('team_id', $teamOne->id)
                                                ->where('sport_ground_positions_id', $gmp->id)
                                                ->with('player')
                                                ->where('is_active', 1)
                                                ->first();
                                            if (!empty($goal_keeper)) {
                                                $player_pic = 'profile_pic/' . $goal_keeper->player->profile_pic;
                                            } else {
                                                $player_pic = 'images/player_copy.png';
                                            }
                                            $goalkeeper_div_id = 'teamOne_' . $gmp->id;
                                            ?>
                                            @if (!empty($goal_keeper))
                                                <?php $goal_keeper_jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                    ->where('member_id', $goal_keeper->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy1">
                                                    {{ $goal_keeper_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img">
                                                <img src="{{ url('frontend') }}/{{ $player_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="player_img{{ $gmp->id }}">
                                            </div>
                                            <div class="select-box">
                                                <select name="players[]" class="teamOnegoal_keeper select_player"
                                                    id="{{ $goalkeeper_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamOne_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamOne->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number'); ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 2)
                                        <?php $defender = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamOne->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($defender)) {
                                            $defender_pic = 'profile_pic/' . $defender->player->profile_pic;
                                        } else {
                                            $defender_pic = 'images/player_copy.png';
                                        }
                                        $defender_div_id = 'teamOne_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($defender))
                                                <?php $defender_jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                    ->where('member_id', $defender->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy1">
                                                    {{ $defender_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $defender_pic }}"
                                                    class="img-fluid" alt="player" draggable="true"
                                                    id="player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]" class="teamOne_defender select_player"
                                                    id="{{ $defender_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamOne_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamOne->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number'); ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 3)
                                        <?php $defensive = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamOne->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player:id,profile_pic,first_name,last_name')
                                            ->first();
                                        if (!empty($defensive)) {
                                            $defensive_pic = 'profile_pic/' . $defensive->player->profile_pic;
                                        } else {
                                            $defensive_pic = 'images/player_copy.png';
                                        }
                                        $defensive_div_id = 'teamOne_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($defensive))
                                                <?php $defensive_jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                    ->where('member_id', $defensive->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy1">
                                                    {{ $defensive_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $defensive_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]"
                                                    class="teamOne_defensive_midfield select_player"
                                                    id="{{ $defensive_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    <?php $playerdata = []; ?>
                                                    @foreach ($teamOne_attendees as $tm1a)
                                                        <?php $playerdata[] = $user->id; ?>
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamOne->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number'); ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 4)
                                        <?php $midfielder = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamOne->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($midfielder)) {
                                            $midfielder_pic = 'profile_pic/' . $midfielder->player->profile_pic;
                                        } else {
                                            $midfielder_pic = 'images/player_copy.png';
                                        }
                                        $mdfielder_div_id = 'teamOne_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($midfielder))
                                                <?php $midfielder_jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                    ->where('member_id', $midfielder->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy1">
                                                    {{ $midfielder_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $midfielder_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]" class="teamOne_midfield select_player"
                                                    id="{{ $mdfielder_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamOne_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamOne->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number'); ?>
                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 5)
                                        <?php $attacking = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamOne->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($attacking)) {
                                            $attacking_pic = 'profile_pic/' . $attacking->player->profile_pic;
                                        } else {
                                            $attacking_pic = 'images/player_copy.png';
                                        }
                                        $attacking_div_id = 'teamOne_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($attacking))
                                                <?php $attacking_jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                    ->where('member_id', $attacking->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy1">
                                                    {{ $attacking_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $attacking_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]"
                                                    class="teamOne_attacking_midfield select_player"
                                                    id="{{ $attacking_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamOne_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamOne->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number'); ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mb-5 row">
                                @foreach ($ground_map_position as $gmp)
                                    @if ($gmp->ground_coordinates == 6)
                                        <?php $striker = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamOne->id)
                                            ->where('sport_ground_positions_id', $gmp->id)
                                            ->where('is_active', 1)
                                            ->with('player')
                                            ->first();
                                        if (!empty($striker)) {
                                            $striker_pic = 'profile_pic/' . $striker->player->profile_pic;
                                        } else {
                                            $striker_pic = 'images/player_copy.png';
                                        }
                                        $striker_div_id = 'teamOne_' . $gmp->id;
                                        ?>
                                        <div class="text-center col position-relative">
                                            @if (!empty($striker))
                                                <?php $striker_jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                    ->where('member_id', $striker->player->id)
                                                    ->value('jersey_number'); ?>
                                                <span class="jersy-nooo team-jersy-left jersy1">
                                                    {{ $striker_jersey_number }} </span>
                                            @else
                                            @endif
                                            <div class="player-img"><img
                                                    src="{{ url('frontend') }}/{{ $striker_pic }}"
                                                    class="img-fluid" alt="player"
                                                    id="player_img{{ $gmp->id }}"></div>
                                            <div class="select-box ">
                                                <select name="players[]" class="teamOne_striker select_player"
                                                    id="{{ $striker_div_id }}">
                                                    <option value="">{{ $gmp->name }}</option>
                                                    @foreach ($teamOne_attendees as $tm1a)
                                                        <?php $user = App\Models\User::select('id', 'first_name', 'last_name')->find($tm1a->attendee_id); ?>
                                                        <?php $check = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                            ->where('team_id', $teamOne->id)
                                                            ->where('player_id', $tm1a->attendee_id)
                                                            ->where('sport_ground_positions_id', $gmp->id)
                                                            ->value('player_id');
                                                        $jersey_number = App\Models\Team_member::where('team_id', $teamOne->id)
                                                            ->where('member_id', $tm1a->attendee_id)
                                                            ->value('jersey_number'); ?>

                                                        <option value="{{ $user->id }},{{ $gmp->id }}"
                                                            {{ $check == $tm1a->attendee_id ? 'selected' : '' }}>
                                                            [{{ $jersey_number }}] {{ $user->first_name }}
                                                            {{ $user->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 111 -->
            @if ($competition->squad_players_num != $competition->lineup_player_num)
                <div class="modal-content modal-contentBottom">
                    <div class=" bg-light-dark">
                        <div class="px-1 text-center row">
                            <h2 class="text-bolder heading-dark-bg">Substitute Players</h2>
                        </div>
                        <div class="row" id="benchOneHolder">
                            @if (@$teamOne_attendees && count($teamOne_attendees) > 0)
                                @foreach ($teamOne_attendees as $attendee)
                                    <div class="text-center col col-4 col-md-2 position-relative">
                                        <div class="substitute select-box substitute_players">
                                            {{ $attendee->player->first_name }} {{ $attendee->player->last_name }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @else
            @endif
        </form>
    </div>
</div>


<div class="modal fade" id="plyrRecord" role="dialog">
    <div class="modal-dialog">
        <!--    Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title01">
                    <div class="circle-refree">
                        <img src="" width="100%" id="player_pic">
                    </div>
                    <div class="plyrname">
                        <input type="hidden" name="basicStattime" id="basicStattime" value="">
                        <img src="" class="team-logo" id="team_logo"><span id="player_team_id"></span> <span
                            id="player_name"> Player Name </span>
                        <span class="plyrname-subtitle" id="player_position">Player Ground Position</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="mb-3 row">
                        @foreach ($player_stats as $stats)
                            <div class="col-md-4">
                                <div class="numbr">
                                    <span id="stat_number_{{ $stats->id }}" class="stat_number"> 0</span>
                                    <input type="hidden" id="input_stat_num_{{ $stats->id }}" value="">
                                </div>
                                <div class="numbrcard player_stat">
                                    @if (Auth::check())
                                        @if (in_array(Auth::user()->id, $all_admins))
                                            <input type="radio" name="player_stats" class="player_stats"
                                                value="{{ $stats->id }}" onclick="basic_stat_enter_num(this);">
                                        @else
                                        @endif
                                    @else
                                    @endif
                                    {{ $stats->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="gap-2 d-grid">
                        @if (Auth::check())
                            @if (in_array(Auth::user()->id, $all_admins))
                                <button class="refr btn btn-success" type="submit" id="player_stat_rating"
                                    value="">Submit</button>
                            @else
                            @endif
                        @else
                        @endif
                        <button class="btn btn-default btn-lg tryagn" type="button"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statsRecord" role="dialog">
    <div class="modal-dialog ">
        <div class="bg-transparent modal-content">
            <div class="container">
                <div class="row">
                    <div class="px-0 statsleftprofie col-md-3">
                        <div class="px-2 bg-white shadow w-100 br-5 position-relative">
                            <div class="circle-image">
                                <img src="" width="100%" id="deatil_player_pic">
                            </div>
                            <div class="plyr-prof-img">
                                <input type="hidden" name="detailedStattime" id="detailedStattime" value="">
                                <img src="" class="team-logo1" id="detail_team_logo"><span
                                    id="detail_player_name"> Player Name </span>
                                <span class="plyr-prof-img-subtitle" id="detail_player_position">Player
                                    Postition</span>
                                <span id="deatiled_player_team_id"></span>
                            </div>
                            <div class="mb-3 row timer-box">
                            </div>
                            <div class="gap-2 d-grid">
                                @if (Auth::check())
                                    @if (in_array(Auth::user()->id, $all_admins))
                                        <button class="refr btn btn-green" type="button"
                                            id="detailed_player_stat_rating" value="">Record Stats</button>
                                    @else
                                    @endif
                                @else
                                @endif
                                <button class="btn btn-default btn-lg tryagn" type="button"
                                    data-bs-dismiss="modal">Cancel & Try Again</button>
                            </div>
                        </div>
                    </div>
                    <div class="px-0 py-4 col-md-9 ">
                        <div class="container py-3 stats-right">
                            <div class="py-2 row">
                                @foreach ($player_detailed_stats as $stat)
                                    <div class="col stats-counter matchStatPlus">
                                        <label for="goals" title="{{ $stat->name }}">@php echo Str::of($stat->name)->limit(5); @endphp</label>
                                        <div class="w-100 d-flex">
                                            <div class="value-box">
                                                <input id="display_detail_stat_number_{{ $stat->id }}"
                                                    value="" readonly>
                                                <input type="hidden" id="detail_stat_number_{{ $stat->id }}"
                                                    value="" readonly>
                                            </div>
                                            @if (Auth::check())
                                                @if (in_array(Auth::user()->id, $all_admins))
                                                    <div class="updown-btns">
                                                        <input class="form-check-input Dplayer_stats" type="radio"
                                                            name="player_stats" value="{{ $stat->id }}"
                                                            onclick="stat_enter_num(this);"
                                                            id="player_d_stat_{{ $stat->id }}">
                                                        <i class="icon-plus"></i>
                                                    </div>
                                                @else
                                                @endif
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addOwnGoalRession" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 20px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-0 modal-body">
                <div>
                    <div class="pt-1 wrapper">
                        <div class="row ">
                            <div class=" col-md-12">
                                <label class="mb-2  ownGoalPup">Reason</label>
                                <div class="floating-form ">
                                    <input type="hidden" value="" id="goalTeam_id">
                                    <input type="hidden" value="" id="ownGoalTime">
                                    <div class="floating-label ">
                                        <textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30"
                                            rows="5" id="ownGoal_ression"></textarea>
                                        <span class="text-danger" id="ownGoal_ression_error1"
                                            style="display: none;">Reason is required.</span>
                                        <span class="text-danger" id="ownGoal_ression_error2"
                                            style="display: none;">Please enter less than 200 characters.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ButtonPop2">
                            <div class=" col-md-12">
                                <div class="bottom">
                                    <div class="text-right content">
                                        <button class="active" id="submitadd_ownGoal">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@livewireScripts
@include('frontend/includes/footer')
<script src="{{ url('frontend/js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ url('frontend/js/ajax_libs_bootstrap.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<script>
    $(document).on('click', '.add_d_stat', function() {
        var stat_id = $(this).data('id');
        alert(stat_id);
    })
</script>
<script>
    $(document).ready(function() {
        function alignModal() {
            var modalDialog = $(this).find(".modal-dialog");
            // Applying the top margin on modal to align it vertically center
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", alignModal);

        // Align modal when user resize the window
        $(window).on("resize", function() {
            $(".modal:visible").each(alignModal);
        });
    });
</script>
<script>
    var closebtns = document.getElementsByClassName("close-btn");
    var i;
    for (i = 0; i < closebtns.length; i++) {
        closebtns[i].addEventListener("click", function() {
            this.parentElement.style.display = 'none';
        });
    }
</script>
<script>
    $(document).on('click', ".team_ownGoal", function() {
        var ownGoalTeam_id = $(this).data('id');
        $('#goalTeam_id').val(ownGoalTeam_id);
        var time = "currenttime";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('ownGoal_statTime') }}',
            type: 'post',
            data: {
                time: time,
            },
            error: function() {},
            success: function(response) {
                if (response.status == 1) {
                    $('#ownGoalTime').val(response.nowtime);
                    $("#addOwnGoalRession").modal('show');
                }
            }
        });
    });

    $(document).on('click', '#submitadd_ownGoal', function() {
        var x = 0;
        var player_id = '16';
        var statdatetime = $('#ownGoalTime').val();
        var stat_id = '54';
        var ownGoal_ression = $('#ownGoal_ression').val();
        var match_fixture_id = $('#match_fixture_id').val();
        var team_id = $('#goalTeam_id').val();

        if (ownGoal_ression == "") {
            x++;
            $('#ownGoal_ression_error1').show();
        } else {
            $('#ownGoal_ression_error1').hide();
        }
        if (ownGoal_ression.length > 200) {
            x++;
            $('#ownGoal_ression_error2').show();
        } else {
            $('#ownGoal_ression_error2').hide();
        }
        if (x == 0) {
            $("#addOwnGoalRession").modal('hide');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('fixture_stat') }}',
                type: 'post',
                data: {
                    player_id: player_id,
                    match_fixture_id: match_fixture_id,
                    statdatetime: statdatetime,
                    ownGoal_ression: ownGoal_ression,
                    stat_id: stat_id,
                    team_id: team_id
                },
                error: function() {},
                success: function(response) {
                    if (response.status == 1) {
                        $('textarea#ownGoal_ression').val("");
                    }
                }
            });
        }
    });
</script>

<!-- Team Two functionality -->
<script>
    $('#submit_fixture_squad_t2').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{ url('submit_fixture_squad') }}",
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            error: function() {},
            success: function(data) {
                if (data.comp_lineUpnum) {
                    alert(data.comp_lineUpnum + ' lineup Player/s required for this competition');
                } else {
                    // location.reload();
                    $('.modal-backdrop.fade.show').hide();
                    $('#squadModal_teamTwo').modal("hide");
                    $('body').addClass("unsetOverflow");
                }
                //

            }
        })
    });
</script>

<script>
    $('#submit_fixture_squad').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('submit_fixture_squad') }}",
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            error: function() {},
            success: function(data) {
                if (data.comp_lineUpnum) {
                    alert(data.comp_lineUpnum + ' lineup Player/s required for this competition');
                } else {
                    // location.reload();

                    $('.modal-backdrop.fade.show').hide();
                    $('#squadModal_teamOne').modal("hide");
                    $('body').addClass("unsetOverflow");
                }
            }
        })
    });
</script>

<script>
    $(document).on('click', '.player_score', function() {
        //$('.stat_number').html('0');
        var player_id = $(this).data('id');
        var match_fixture_id = $('#match_fixture_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('player_info_fixture') }}',
            type: 'post',
            data: {
                player_id: player_id,
                match_fixture_id: match_fixture_id,
            },
            error: function() {
                alert('error');
            },
            success: function(response) {
                if (response.comp_report_type.report_type == 1) {
                    $('#player_name').html(response.player_info.first_name + ' ' + response
                        .player_info.last_name);
                    $('#player_stat_rating').val(response.player_info.id);
                    $('#player_pic').attr("src", "{{ url('frontend/profile_pic') }}/" + response
                        .player_info.profile_pic);
                    $('#player_id').html('<input type="hidden" id="p_id" value="' + response
                        .player_info.id + '">');
                    $('#team_logo').attr("src", "{{ url('frontend/logo') }}/" + response.team
                        .team_logo);
                    $('#player_team_id').html('<input type="hidden" id="player_tID" value="' +
                        response.team.id + '"> ');
                    $('#basicStattime').val(response.currentdatetime);
                    //stat_number_
                    $.each(response.stat_data, function(key, value) {
                        $('#stat_number_' + key).html(value);
                        $('#input_stat_num_' + key).val(value);
                    });

                    $.each(response.fixture_position, function(key, value) {

                        $('#player_position').html(value.position.name);
                    });

                    $("#plyrRecord").modal('show');
                } else {
                    $('#detail_player_name').html(response.player_info.first_name + ' ' + response
                        .player_info.last_name);
                    $('#deatil_player_pic').attr("src", "{{ url('frontend/profile_pic') }}/" +
                        response.player_info.profile_pic);
                    $('#detail_team_logo').attr("src", "{{ url('frontend/logo') }}/" + response
                        .team.team_logo);
                    $('#detailed_player_stat_rating').val(response.player_info.id);
                    $('#deatiled_player_team_id').html(
                        '<input type="hidden" id="player_tID2" value="' + response.team.id +
                        '"> ');
                    $('#detailedStattime').val(response.currentdatetime);
                    $.each(response.stat_data, function(key, value) {
                        $('#detail_stat_number_' + key).val(value);
                        $('#display_detail_stat_number_' + key).val(value);
                    });
                    $.each(response.fixture_position, function(key, value) {
                        $('#detail_player_position').html(value.position.name);
                    });

                    $("#statsRecord").modal('show');
                }


            }
        });
    });
</script>
<script>
    function stat_enter_num(myRadio) {
        var selected_stat_id = myRadio.value;
        var player_id = $('#detailed_player_stat_rating').val() + ',' + $('#player_tID2').val();
        var match_fixture_id = $('#match_fixture_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('player_info_fixture') }}',
            type: 'post',
            data: {
                player_id: player_id,
                match_fixture_id: match_fixture_id
            },
            error: function() {
                alert('error');
            },
            success: function(response) {
                $.each(response.stat_data, function(key, value) {
                    if (key == selected_stat_id) {
                        var stat_id = $('input:radio[name="player_stats"]:checked').val();
                        var stat_count = $("#detail_stat_number_" + stat_id).val();
                        var add_stat = Number(stat_count) + 1;
                        $('#display_detail_stat_number_' + key).val(add_stat);
                    } else {
                        $('#display_detail_stat_number_' + key).val(value);
                    }

                });
            }
        });
    };
</script>
<script>
    function basic_stat_enter_num(myRadio) {
        var selected_stat_id = myRadio.value;
        var player_id = $('#player_stat_rating').val() + ',' + $('#player_tID').val();
        var match_fixture_id = $('#match_fixture_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('player_info_fixture') }}',
            type: 'post',
            data: {
                player_id: player_id,
                match_fixture_id: match_fixture_id
            },
            error: function() {
                alert('error');
            },
            success: function(response) {
                $.each(response.stat_data, function(key, value) {
                    if (key == selected_stat_id) {
                        var stat_id = $('input:radio[name="player_stats"]:checked').val();
                        var stat_count = $("#input_stat_num_" + stat_id).val();
                        var add_stat = Number(stat_count) + 1;
                        $("#stat_number_" + stat_id).html(add_stat);

                    } else {
                        $('#stat_number_' + key).html(value);
                    }

                });
            }
        });
    };
</script>
<script>
    $(document).on('click', '#player_stat_rating', function() {
        var player_id = $(this).val();
        var stat_id = $('input:radio[name="player_stats"]:checked').val();
        var statdatetime = $('#basicStattime').val();
        var match_fixture_id = $('#match_fixture_id').val();
        var team_id = $('#player_tID').val();
        $('#plyrRecord').modal('hide');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('fixture_stat') }}',
            type: 'post',
            data: {
                player_id: player_id,
                match_fixture_id: match_fixture_id,
                statdatetime: statdatetime,
                stat_id: stat_id,
                team_id: team_id
            },
            error: function() {},
            success: function(response) {
                $("input[type='radio']").prop("checked", false);
                if (response.red_card) {
                    alert('Red Card Player');
                }
                if (response.yellow_card) {
                    alert('Yellow Card Player');
                }
            }
        });
    });
</script>

<script>
    $(document).on('click', '#detailed_player_stat_rating', function() {
        var player_id = $(this).val();
        var stat_id = $('input:radio[name="player_stats"]:checked').val();
        var statdatetime = $('#detailedStattime').val();
        var match_fixture_id = $('#match_fixture_id').val();
        var team_id = $('#player_tID2').val();
        $("#statsRecord").modal('hide');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('fixture_stat') }}',
            type: 'post',
            data: {
                player_id: player_id,
                match_fixture_id: match_fixture_id,
                statdatetime: statdatetime,
                stat_id: stat_id,
                team_id: team_id
            },
            error: function() {

            },
            success: function(response) {
                $("input[type='radio']").prop("checked", false);
                if (response.red_card) {
                    alert('Red Card Player');
                }
                if (response.yellow_card) {
                    alert('Yellow Card Player');
                }
            }
        });
    });
</script>
<script type="text/javascript" src="{{ url('frontend/js/dist_sweetalert.min.js') }}"></script>
<script>
    window.addEventListener('swal:modal', event => {
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
    let LineUpData = [];
    let teamId1 = parseInt("{{ $teamOne->id }}");
    let teamId2 = parseInt("{{ $teamTwo->id }}");
    let teamOnePlayers = @json($teamOne_attendees);
    let teamTwoPlayers = @json($teamTwo_attendees);
    let ground_map_position = @json($ground_map_position);
    let topBarData = undefined;
    let tempArrayDataHelper = [];
    ground_map_position.forEach(element => {
        if (!tempArrayDataHelper.includes(parseInt(element.ground_coordinates))) {
            tempArrayDataHelper.push(parseInt(element.ground_coordinates))
        }
    });
    let tempPushdata1 = {
        teamId: teamId1,
        topsection: [0, 0, 0, 0, 0],
        data: []
    };
    let tempPushdata2 = {
        teamId: teamId2,
        topsection: [0, 0, 0, 0, 0],
        data: []
    };

    if (teamOnePlayers.length > 0) {
        teamOnePlayers.forEach(element1 => {
            let profilePic1 = '{{ asset('frontend/profile_pic/') }}/' + element1.player.profile_pic;
            let data1 = {
                CompetitionId: element1.Competition_id,
                formId: 'submit_fixture_squad',
                teamId: teamId1,
                playerId: element1.player.id,
                playerName: element1.player.first_name + ' ' + element1.player.last_name,
                playerPic: profilePic1,
                inLineUp: false,
                position: null,
                postiionValue: null,
                inBench: true,
                benchHolderID: 'benchOneHolder',
                benchId: 'benchForOne-' + element1.player.id,
                selectClass: 'select_player',
                selectId: 'teamOne_',
                imgId: 'player_img',
            }
            tempPushdata1.data.push(data1);
        });
    }
    if (teamTwoPlayers.length > 0) {
        teamTwoPlayers.forEach(element2 => {
            let profilePic2 = '{{ asset('frontend/profile_pic/') }}/' + element2.player.profile_pic;
            let data2 = {
                CompetitionId: element2.Competition_id,
                formId: 'submit_fixture_squad_t2',
                teamId: teamId2,
                playerId: element2.player.id,
                playerName: element2.player.first_name + ' ' + element2.player.last_name,
                playerPic: profilePic2,
                inLineUp: false,
                position: null,
                postiionValue: null,
                inBench: true,
                benchHolderID: 'benchTwoHolder',
                benchId: 'benchForTwo-' + element2.player.id,
                selectClass: 'teamTwoselect_player',
                selectId: 'teamTwo_',
                imgId: 'teamTwo_player_img'
            }
            tempPushdata2.data.push(data2);
        });
    }
    LineUpData[0] = tempPushdata1;
    LineUpData[1] = tempPushdata2;
    // edit function
    let fixtureSquadDbDetails = @json(\App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)->where('is_active', 1)->get());
    let PreselectedTOnePId = [];
    let PreselectedTTwoPId = [];
    if (fixtureSquadDbDetails.length > 0) {
        fixtureSquadDbDetails.forEach(z => {
            if (teamId2 == z.team_id) {
                PreselectedTOnePId.push(z.player_id)
            }
            if (teamId1 == z.team_id) {
                PreselectedTTwoPId.push(z.player_id)
            }
            LineUpData.forEach(a => {
                if (z.team_id == a.teamId) {
                    a.data.forEach(b => {
                        if (b.playerId == z.player_id) {
                            b.position = parseInt(z.sport_ground_positions_id);
                            b.inLineUp = true;
                            b.inBench = false;
                            b.postiionValue = z.player_id + ',' + z.sport_ground_positions_id;
                        }
                    })
                }
            })
        });
    }

    function generatreSelectOption(id, index) {
        let html = '';
        LineUpData[index].data.forEach(e => {
            if (!e.inBench && e.inLineUp) {
                html += `<option value="${e.postiionValue}">${e.playerName}</option>`;
            }
        })
        $(`.${id}`).select(html)
    }
    // end of
    benchUpdate();
    $('#submit_fixture_squad .select_player').on('change', function(e) {
        let val = $(this).val();
        if (val) {
            let splitVal = val.split(',');
            if (splitVal.length == 2) {
                selectResponse(splitVal, val, 0)
            } else {
                alert("Format not supported.")
            }
        } else {
            let id = $(this).attr('id');
            let splitId = id.split('_');
            if (splitId.length == 2) {
                let position = parseInt(splitId[1])
                LineUpData.forEach(a => {
                    a.data.forEach(element => {
                        if (element.position == position) {
                            element.inLineUp = false
                            element.position = null
                            element.postiionValue = null
                            element.inBench = true
                        }
                    });
                });
            } else {
                alert("Format not supported.")
            }
        }
        benchUpdate();
    })
    $('#submit_fixture_squad_t2 .teamTwoselect_player').on('change', function(e) {
        let val = $(this).val();
        if (val) {
            let splitVal = val.split(',');
            if (splitVal.length == 2) {
                selectResponse(splitVal, val, 1)
            } else {
                alert("Format not supported.")
            }
        } else {
            let id = $(this).attr('id');
            let splitId = id.split('_');
            if (splitId.length == 2) {
                let position = parseInt(splitId[1])
                LineUpData.forEach(a => {
                    a.data.forEach(element => {
                        if (element.position == position) {
                            element.inLineUp = false
                            element.position = null
                            element.postiionValue = null
                            element.inBench = true
                        }
                    });
                });
            } else {
                alert("Format not supported.")
            }
        }
        benchUpdate();
    })

    function selectResponse(array, val, index) {
        let effectedPlayerId = parseInt(array[0]);
        let effectedPostionId = parseInt(array[1]);
        let switchPlayerId = undefined;
        let switchPostionId = undefined;
        LineUpData[index].data.forEach(e1 => {
            if (e1.playerId == effectedPlayerId) {
                switchPostionId = e1.position;
            }
            if (e1.position == effectedPostionId) {
                switchPlayerId = e1.playerId;
            }
        })
        if (switchPlayerId && switchPostionId) {
            LineUpData[index].data.forEach(element2 => {
                if (element2.playerId == switchPlayerId) {
                    element2.position = parseInt(switchPostionId);
                    element2.postiionValue = "" + switchPlayerId + "," + switchPostionId + "";
                }
                if (element2.playerId == effectedPlayerId) {
                    element2.position = parseInt(effectedPostionId);
                    element2.postiionValue = "" + effectedPlayerId + "," + effectedPostionId + "";
                }
            });
        } else if (switchPlayerId && !switchPostionId) {
            LineUpData[index].data.forEach(element2 => {
                if (element2.playerId == switchPlayerId) {
                    element2.inLineUp = false
                    element2.position = null
                    element2.postiionValue = null
                    element2.inBench = true
                }
                if (element2.playerId == effectedPlayerId) {
                    element2.inLineUp = true;
                    element2.inBench = false;
                    element2.position = parseInt(effectedPostionId);
                    element2.postiionValue = "" + effectedPlayerId + "," + effectedPostionId + "";
                }
            });
        } else {
            LineUpData[index].data.forEach(element2 => {
                if (element2.playerId == effectedPlayerId) {
                    element2.position = parseInt(effectedPostionId);
                    element2.inLineUp = true;
                    element2.inBench = false;
                    element2.postiionValue = val;
                }
            });
        }
        benchUpdate();
    }

    function popUpToggle1(id) {

        let lineUpPlayers = [];
        LineUpData.forEach(a => {
            a.data.forEach(b => {
                if (!b.inBench && b.inLineUp) {
                    if (!lineUpPlayers.includes(b.playerId)) {
                        lineUpPlayers.push(b.playerId)
                    }
                }
            })
        });
        if (lineUpPlayers.length > 0) {
            $('#changeplayerOne #togglePlayer').val(id);
            $('#changeplayerOne').modal('toggle')
        } else {
            alert('Please add atleast one player in line up.')
        }
        changePlayerData = [];
        let html = '<option value=""></option>';
        teamOnePlayers.forEach(element => {
            if (lineUpPlayers.includes(element.attendee_id)) {
                changePlayerData.push(element);
                html += '<option value="' + element.attendee_id + '">' + element.player.first_name +
                    '</option>';
            }
        });
        $('#teamOneChangeSelect').html(html)
    }

    function popUpToggle2(id) {

        let lineUpPlayers = [];
        LineUpData.forEach(a => {
            a.data.forEach(b => {
                if (!b.inBench && b.inLineUp) {
                    if (!lineUpPlayers.includes(b.playerId)) {
                        lineUpPlayers.push(b.playerId)
                    }
                }
            })
        });
        if (lineUpPlayers.length > 0) {
            $('#changeplayerTwo').modal('toggle')
            $('#changeplayerTwo #togglePlayer').val(id);
        } else {
            alert('Please add atleast one player in line up.')
        }
        changePlayerData = [];
        let html = '<option value=""></option>';
        teamTwoPlayers.forEach(element => {
            if (lineUpPlayers.includes(element.attendee_id)) {
                changePlayerData.push(element);
                html += '<option value="' + element.attendee_id + '">' + element.player.first_name +
                    '</option>';
            }
        });
        $('#teamTwoChangeSelect').html(html)
    }

    function substitutePLayer(formId, selectId) {
        $(formId + ' ' + selectId + 'Error').addClass('d-none');
        $(formId + ' ' + selectId + 'DescError').addClass('d-none')
        let toSubstitute = $(formId + ' ' + selectId).val();
        let substitudeDesc = $(formId + ' #status_desc').val()
        let fromSubstitude = $(formId + ' #togglePlayer').val();
        let match_fixture_id = "{{ $match_fixture->id }}";
        let toSubstituteTeamId = undefined;
        let fromSubstitudeTeamId = undefined;
        let toSubstitutePositionId = undefined;
        let fromSubstitudePositionId = undefined;
        LineUpData.forEach(a => {
            a.data.forEach(b => {
                if (b.playerId == fromSubstitude) fromSubstitudeTeamId = a.teamId;
                if (b.playerId == toSubstitute) {
                    toSubstitutePositionId = b.position;
                    toSubstituteTeamId = a.teamId;
                }
            })
        });
        fromSubstitudePositionId = parseInt(toSubstitutePositionId)
        if (substitudeDesc != '' && toSubstitute != '' && fromSubstitude != '' && (toSubstitutePositionId !=
                undefined && toSubstituteTeamId != undefined && fromSubstitudePositionId != undefined &&
                fromSubstitudeTeamId != undefined)) {
            let data = {
                fromSubstitude,
                toSubstitute,
                substitudeDesc,
                toSubstitutePositionId,
                toSubstituteTeamId,
                fromSubstitudePositionId,
                fromSubstitudeTeamId,
                match_fixture_id,
                "_token": "{{ csrf_token() }}",
            }
            $.ajax({
                url: "{{ route('substitute.player') }}",
                type: 'POST',
                data: data,
                error: function() {
                    alert('Something is Wrong');
                },
                success: function(response) {
                    if (response.status == 200) $(formId).modal('toggle')
                    alert(response.message);
                }
            });
        } else {
            if (substitudeDesc == '') {
                $(formId + ' ' + selectId + 'Error').removeClass('d-none');
            }
            if (toSubstitute == '') {
                $(formId + ' ' + selectId + 'DescError').removeClass('d-none')
            }
            if (substitudeDesc != '' && substitudeDesc != '') {
                alert('Script fail.')
            }
        }
    }

    function benchUpdate() {
        let teamOnepostionArray = [];
        let teamTwopostionArray = [];
        let teamOneArray1 = [],
            teamOne1 = tempArrayDataHelper[1];
        let teamOneArray2 = [],
            teamOne2 = tempArrayDataHelper[2];
        let teamOneArray3 = [],
            teamOne3 = tempArrayDataHelper[3];
        let teamOneArray4 = [],
            teamOne4 = tempArrayDataHelper[4];
        let teamOneArray5 = [],
            teamOne5 = tempArrayDataHelper[5];
        //top Section
        ground_map_position.forEach(a => {
            if (a.ground_coordinates == teamOne1) {
                teamOneArray1.push(a.id)
            }
            if (a.ground_coordinates == teamOne2) {
                teamOneArray2.push(a.id)
            }
            if (a.ground_coordinates == teamOne3) {
                teamOneArray3.push(a.id)
            }
            if (a.ground_coordinates == teamOne4) {
                teamOneArray4.push(a.id)
            }
            if (a.ground_coordinates == teamOne5) {
                teamOneArray5.push(a.id)
            }
        });

        let temp1_1 = 0,
            temp1_2 = 0,
            temp1_3 = 0,
            temp1_4 = 0,
            temp1_5 = 0,
            temp2_1 = 0,
            temp2_2 = 0,
            temp2_3 = 0,
            temp2_4 = 0,
            temp2_5 = 0;

        //modal body change
        LineUpData.forEach((element1, i) => {
            let benchHolderData = '';
            element1.data.forEach(element2 => {
                let effectedBenchId = '#' + element2.formId + ' #' + element2.benchHolderID + ' #' +
                    element2.benchId + '';
                let effectedImgId = '#' + element2.formId + ' #' + element2.imgId + '' + element2
                    .position + '';
                let effectedSelectId = '#' + element2.formId + ' #' + element2.selectId + '' + element2
                    .position + '';
                if (!element2.inBench && element2.inLineUp) {
                    if (i == 0) {
                        teamOnepostionArray.push(parseInt(element2.position))
                    } else {
                        teamTwopostionArray.push(parseInt(element2.position))
                    }
                    $(effectedImgId).attr('src', element2.playerPic);
                    $(effectedSelectId).val(element2.postiionValue).attr('style', 'background:#fff;');
                    $(effectedSelectId).attr('value', element2.postiionValue);
                } else {
                    $(effectedBenchId).html(element2.playerName);
                    if (i == 0) {
                        benchHolderData += `<div class="text-center col col-4 col-md-2 position-relative">
							<div class="substitute select-box substitute_players">
								${element2.playerName}
							</div>
						</div>`;
                    } else {
                        benchHolderData += `<div class="text-center col col-4 col-md-2 position-relative">
							<div class="substitute select-box substitute_players">
								${element2.playerName}
							</div>
						</div>`;
                    }
                }
                if (i == 0) {
                    if (teamOneArray1.includes(element2.position)) {
                        temp1_1++;
                    }
                    if (teamOneArray2.includes(element2.position)) {
                        temp1_2++;
                    }
                    if (teamOneArray3.includes(element2.position)) {
                        temp1_3++;
                    }
                    if (teamOneArray4.includes(element2.position)) {
                        temp1_4++
                    }
                    if (teamOneArray5.includes(element2.position)) {
                        temp1_5++
                    }
                } else {

                    if (teamOneArray1.includes(element2.position)) {
                        temp2_1++;
                    }
                    if (teamOneArray2.includes(element2.position)) {
                        temp2_2++;
                    }
                    if (teamOneArray3.includes(element2.position)) {
                        temp2_3++;
                    }
                    if (teamOneArray4.includes(element2.position)) {
                        temp2_4++
                    }
                    if (teamOneArray5.includes(element2.position)) {
                        temp2_5++
                    }
                }
            });
            if (i == 0) {
                $('#benchOneHolder').html(benchHolderData)
            } else {
                $('#benchTwoHolder').html(benchHolderData)
            }
        });
        LineUpData[0].topsection[0] = temp1_1
        LineUpData[0].topsection[1] = temp1_2
        LineUpData[0].topsection[2] = temp1_3
        LineUpData[0].topsection[3] = temp1_4
        LineUpData[0].topsection[4] = temp1_5
        LineUpData[1].topsection[0] = temp2_1
        LineUpData[1].topsection[1] = temp2_2
        LineUpData[1].topsection[2] = temp2_3
        LineUpData[1].topsection[3] = temp2_4
        LineUpData[1].topsection[4] = temp2_5
        $('#teamOne-0').html(temp1_1)
        $('#teamOne-1').html(temp1_2)
        $('#teamOne-2').html(temp1_3)
        $('#teamOne-3').html(temp1_4)
        $('#teamOne-4').html(temp1_5)
        $('#teamTwo-0').html(temp2_1)
        $('#teamTwo-1').html(temp2_2)
        $('#teamTwo-2').html(temp2_3)
        $('#teamTwo-3').html(temp2_4)
        $('#teamTwo-4').html(temp2_5)
        for (let index = 1; index <= 25; index++) {
            if (!teamOnepostionArray.includes(index)) {
                $('#submit_fixture_squad #player_img' + index).attr('src',
                    '{{ asset('frontend/images/player_copy.png') }}')
                $('#submit_fixture_squad #teamOne_' + index).val(null).attr('style', 'background:#8dd88d;')
            }
        }
        for (let index = 1; index <= 25; index++) {
            if (!teamTwopostionArray.includes(index)) {
                $('#submit_fixture_squad_t2 #teamTwo_player_img' + index).attr('src',
                    '{{ asset('frontend/images/player_copy.png') }}')
                $('#submit_fixture_squad_t2 #teamTwo_' + index).val(null)
            }
        }
    }
</script>
<script>
    $('.teamOneDatetime').click(function() {
        var teamOnestattime = $(this).attr('data-time');
        $('#stattimeTeamone').val(teamOnestattime);
    });
</script>
<script>
    $('.teamTwoDatetime').click(function() {
        var teamTwostattime = $(this).attr('data-time');
        $('#stattimeTeamtwo').val(teamTwostattime);
    });

    // $('#triggerAll').on('click',function(){
    //     $('.processed').trigger('click');
    // });
</script>
<script>
    $('#triggerAll').on('click', function() {
        $('.processed').trigger('click');
    });
</script>
<script>
    $(document).ready(function() {
        $('#triggerAll').on('click', function() {
            $(this).addClass('clicked');
            // Add your refresh logic here if needed
            setTimeout(function() {
                $('#triggerAll').removeClass('clicked');
            }, 1000); // Adjust the time based on your animation duration
        });
    });
</script>


{{-- <script>
    document.addEventListener('livewire:load', function () {
        let intervalId;

        function startInterval() {
            if (intervalId) {
                clearInterval(intervalId);
            }
            intervalId = setInterval(() => {
                Livewire.emit('updateTimer');
            }, 1000);
        }

        Livewire.on('start-timer', function () {
            startInterval();
        });

        Livewire.on('pause-timer', function () {
            clearInterval(intervalId);
        });

        Livewire.on('resume-timer', function () {
            startInterval();
        });

        // Livewire.on('start-second-timer', function () {
        //     startInterval();
        // });

        // Livewire.on('pause-second-timer', function () {
        //     clearInterval(intervalId);
        // });

        // Livewire.on('resume-second-timer', function () {
        //     startInterval();
        // });

        Livewire.on('timer-ended', function () {
            clearInterval(intervalId);
        });
    });
</script> --}}
@include('frontend.includes.searchScript')
</body>

</html>
