<div {{$match_fixture->fixture_type == 0 ? 'wire:poll.5s':''}}>
    <?php
    $current_date = date('Y-m-d');
    $finish_date = date('Y-m-d', strtotime($match_fixture->finishdate_time));
    ?>


    @if ($current_date == $finish_date)
        @if ($match_fixture->competition->vote_mins > $voting_minutes)
        <div wire:poll.850ms>

            @endif
    @endif


    @if ($match_fixture->startdate_time != null)
        @if ($match_fixture->finishdate_time == null)
            @if ($fixture_lapse_type->lapse_type == 6 || in_array($fixture_lapse_type->lapse_type, [2, 4, 6, 9]))
            {{-- 2,4,6,9 --}}
            {{-- 1=> start first half, 2=>finish second half, 3=> start second half, 4=>finish second half, 5=> playe first half, 6=>pause first half, 8=>play second half, 9=> pause second half --}}
                <div>
            @else
                <div wire:poll.850ms>
            @endif
        @else
            <div>
        @endif
    @else
        {{-- Call to first timer --}}
        <div>
    @endif

    {{-- <span > --}}
        {{-- wire:poll.850ms --}}
        @if (Auth::check())
            @if (in_array(Auth::user()->id, $admins) ||
                    Auth::user()->id == $competition->user_id ||
                    in_array(Auth::user()->id, $teamOne_admin_ids))
                @if (@$fixture_lapse_type->lapse_type == 4)
                    <button type="button" class="btn squardtxt bg-green float-md-start"
                        wire:click="openmodal({{ $match_fixture->teamOne_id }})"
                        style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">Lineup
                        :
                        {{ $teamOne_defender }}-{{ $teamOne_defensive }}-{{ $teamOne_midfielder }}-{{ $teamOne_attacking }}-{{ $teamOne_forward }}
                        <span class="Squard12"
                            style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">{{ $teamOneGoal }}</span>
                    </button>
                @else
                    <button type="button" class="btn squardtxt bg-green float-md-start teamOneDatetime"
                        data-time="{{ now() }}" data-bs-toggle="modal" data-bs-target="#squadModal_teamOne"
                        data-id="{{ $match_fixture->teamOne_id }}"
                        style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">Lineup
                        :
                        {{ $teamOne_defender }}-{{ $teamOne_defensive }}-{{ $teamOne_midfielder }}-{{ $teamOne_attacking }}-{{ $teamOne_forward }}
                        <span class="Squard12"
                            style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">{{ $teamOneGoal }}</span>
                    </button>
                @endif
            @else
                <button type="button" class="btn squardtxt bg-green float-md-start"
                    wire:click="openmodal({{ $match_fixture->teamOne_id }})"
                    style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">Lineup
                    :
                    {{ $teamOne_defender }}-{{ $teamOne_defensive }}-{{ $teamOne_midfielder }}-{{ $teamOne_attacking }}-{{ $teamOne_forward }}
                    <span class="Squard12"
                        style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">{{ $teamOneGoal }}</span>
                </button>
            @endif
        @else
            <button type="button" class="btn squardtxt bg-green float-md-start"
                wire:click="openmodal({{ $match_fixture->teamOne_id }})"
                style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important;">Lineup
                :
                {{ $teamOne_defender }}-{{ $teamOne_defensive }}-{{ $teamOne_midfielder }}-{{ $teamOne_attacking }}-{{ $teamOne_forward }}
                <span class="Squard12"
                    style="background:{{ $teamOne_color->team_color }} !important; color:{{ $teamOne_color->font_color }} !important; display:block !important;">{{ $teamOneGoal }}</span>
            </button>
        @endif

        <!-- Clock -->

        <div class="myDIVTime">
                {{-- <button class="processed" wire:click="refresh">Refresh</button> --}}
            @if ($match_fixture->finishdate_time == null)
                @if ($timer_content_first_half == 'Start')
                    <!-- Start First Half Btn -->
                    @if (Auth::check())
                        @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                            <?php
                            $fixture_squad_teamOne = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $match_fixture->teamOne_id)
                                ->get();
                            $fixture_squad_teamTwo = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                ->where('team_id', $match_fixture->teamTwo_id)
                                ->get();
                            ?>
                            <?php if($match_fixture->refree_id == ''){ ?>
                            <button class="StartTimebutton" id="checkRefreeBtn" onclick="refreeAlert()"
                                title = "Ready to start first half">
                                <div class="row">
                                    <div class="col-md-3 m-auto"><img src="{{ url('frontend/images/Start-Icon.png') }}">
                                    </div>
                                    <div class="col-md-6 p-1 m-auto">
                                        <span class="StartHalf">START</span>
                                    </div>
                                    <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">FIRST<p
                                                class="HalfTimeH">HALF</p></span> </div>
                                </div>
                            </button>
                            <?php }else{ ?>
                            <?php
                                if($fixture_squad_teamOne->IsEmpty() || $fixture_squad_teamTwo->IsEmpty()){
                            ?>
                            <button class="StartTimebutton" id="checkRefreeBtn" onclick="squadAlert()"
                                title = "Ready to start first half">
                                <div class="row">
                                    <div class="col-md-3 m-auto"><img src="{{ url('frontend/images/Start-Icon.png') }}">
                                    </div>
                                    <div class="col-md-6 p-1 m-auto">
                                        <span class="StartHalf">START</span>
                                    </div>
                                    <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">FIRST<p
                                                class="HalfTimeH">HALF</p></span> </div>
                                </div>
                            </button>
                            <?php } } ?>
                            <button class="StartTimebutton" id="startMatchBtn" <?php if($match_fixture->refree_id == '' || ($fixture_squad_teamOne->IsEmpty() || $fixture_squad_teamTwo->IsEmpty())  ){ ?>style="display:none;"
                                <?php } ?> wire:click="start_fixture" title = "Ready to start first half">
                            @else
                                <button class="StartTimebutton" wire:click= "stat_fixture_alert"
                                    title = "Only Comp admin can start match.">
                        @endif
                    @else
                        <button class="StartTimebutton" wire:click= "stat_fixture_alert"
                            title = "Only Comp admin can start match.">
                    @endif
                    <div class="row">
                        <div class="col-md-3 m-auto"><img src="{{ url('frontend/images/Start-Icon.png') }}"></div>
                        <div class="col-md-6 p-1 m-auto">
                            <span class="StartHalf">START</span>
                        </div>
                        <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">FIRST<p class="HalfTimeH">HALF</p>
                                </span> </div>
                    </div>
                    </button>
                    <!-- End Start first Half Btn -->
                @else
                    @if ($timer_content_second_half)
                        @if ($timer_content_second_half == 'Start')
                            <!-- Start First Half Btn -->
                            @if (Auth::check())
                                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                    <button class="StartTimebutton" wire:click="start_second_half"
                                        {{ $disable_secondHalf ? 'disabled' : '' }} title="Ready to Start second half">
                                    @else
                                        <button class="StartTimebutton" wire:click= "stat_fixture_alert"
                                            title="Only Comp Admin can start match.">
                                @endif
                            @else
                                <button class="StartTimebutton" wire:click= "stat_fixture_alert"
                                    title="Only Comp Admin can start match.">
                            @endif
                            <div class="row">
                                <div class="col-md-3 m-auto"><img src="{{ url('frontend/images/Start-Icon.png') }}"></div>
                                <div class="col-md-6 p-1 m-auto">
                                    <span class="StartHalf">START</span>
                                </div>
                                <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">SECOND<p
                                            class="HalfTimeH">HALF</p></span> </div>
                            </div>
                            </button>
                            <!-- End Start first Half Btn -->
                        @else
                            @if ($timer_content_second_half == 'COMPLETED')
                                <button class="StartTimebutton" title="second half Completed">
                                    <div class="row">
                                        <div class="col-md-9 p-1 m-auto">
                                            <span class="StartHalf">{{ $timer_content_second_half }}</span>
                                        </div>
                                        <!-- <span class="StartHalf">{{ $second_half_timer }}</span></div> -->
                                        <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">SECOND<p
                                                    class="HalfTimeH">HALF</p></span> </div>
                                    </div>
                                </button>
                            @else
                                <button class="StartTimebutton" title= "timer after start first half">
                                    <div class="row">
                                        <div class="col-md-3 m-auto"><img
                                                src="{{ url('frontend/images/Start-Icon.png') }}"></div>
                                        <div class="col-md-6 p-1 m-auto">
                                            <span class="StartHalf">{{ $timer_content_second_half }}</span>
                                        </div>
                                        <!-- <span class="StartHalf">{{ $second_half_timer }}</span></div> -->
                                        <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">SECOND<p
                                                    class="HalfTimeH">HALF</p></span> </div>
                                    </div>
                                </button>
                                @if (Auth::check())
                                    @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                        @if ($fixture_lapse_type->lapse_type == 9)
                                            <!-- Pause Btn -->
                                            <button class="StartTimebutton DisplayNonePause" title="pause second half"
                                                wire:click="play_second_half" {{ $disable_secondHalf ? 'disabled' : '' }}>
                                                <div class="row">
                                                    <div class="col-md-3 m-auto"><img
                                                            src="{{ url('frontend/images/PauseHover.png') }}"></div>
                                                    <div class="col-md-6 p-1 m-auto">
                                                        <span class="StartHalf">RESUME</span>
                                                    </div>
                                                    <div class="col-md-3 StartHlfTime "><span
                                                            class="FirstHalftStart">SECOND<p class="HalfTimeH">HALF</p>
                                                            </span> </div>
                                                </div>
                                            </button>
                                            <!-- End Pause Btn -->
                                        @else
                                            <!-- Resume Btn -->
                                            <button class="StartTimebutton DisplayNoneResume" title="replay second half"
                                                wire:click="pause_second_half"
                                                {{ $disable_secondHalf ? 'disabled' : '' }}>
                                                <div class="row">
                                                    <div class="col-md-3 m-auto"><img
                                                            src="{{ url('frontend/images/Start-Icon.png') }}"></div>
                                                    <div class="col-md-6 p-1 m-auto">
                                                        <span class="StartHalf">PAUSE</span>
                                                    </div>
                                                    <div class="col-md-3 StartHlfTime "><span
                                                            class="FirstHalftStart">SECOND<p class="HalfTimeH">HALF</p>
                                                            </span> </div>
                                                </div>
                                            </button>
                                        @endif
                                    @else
                                    @endif
                                @else
                                @endif
                            @endif
                        @endif
                    @else
                        <button class="StartTimebutton" title= "timer after start first half">
                            <div class="row">
                                <div class="col-md-3 m-auto"><img src="{{ url('frontend/images/Start-Icon.png') }}">
                                </div>
                                <div class="col-md-6 p-1 m-auto">
                                    <span class="StartHalf">{{ $timer_content_first_half }}</span>
                                </div>
                                <!-- <span class="StartHalf">{{ $first_half_timer }}</span></div> -->
                                <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">FIRST<p
                                            class="HalfTimeH">HALF</p></span> </div>
                            </div>
                        </button>
                        @if (Auth::check())
                            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                @if ($fixture_lapse_type->lapse_type == 6)
                                    <!-- Resume Btn -->
                                    <button class="StartTimebutton DisplayNoneResume" wire:click="play_first_half"
                                        {{ $disable_firstHalf ? 'disabled' : '' }}>
                                        <div class="row">
                                            <div class="col-md-3 m-auto"><img
                                                    src="{{ url('frontend/images/Start-Icon.png') }}"></div>
                                            <div class="col-md-6 p-1 m-auto">
                                                <span class="StartHalf">RESUME</span>
                                            </div>
                                            <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">FIRST<p
                                                        class="HalfTimeH">HALF</p></span> </div>
                                        </div>
                                    </button>
                                @else
                                    <!-- Pause Btn -->
                                    <button class="StartTimebutton DisplayNonePause" wire:click="pause_first_half"
                                        {{ $disable_firstHalf ? 'disabled' : '' }}>
                                        <div class="row">
                                            <div class="col-md-3 m-auto"><img
                                                    src="{{ url('frontend/images/PauseHover.png') }}"></div>
                                            <div class="col-md-6 p-1 m-auto">
                                                <span class="StartHalf">PAUSE</span>
                                            </div>
                                            <div class="col-md-3 StartHlfTime "><span class="FirstHalftStart">FIRST<p
                                                        class="HalfTimeH">HALF</p></span> </div>
                                        </div>
                                    </button>
                                    <!-- End Pause Btn -->
                                @endif
                            @else
                            @endif
                        @else
                        @endif
                    @endif
                @endif
            @else
                <?php
                $current_date = date('Y-m-d');
                $finish_date = date('Y-m-d', strtotime($match_fixture->finishdate_time));
                ?>
                @if ($current_date == $finish_date)
                    @if ($match_fixture->competition->vote_mins > $voting_minutes)
                        <?php
                        $start = $match_fixture->finishdate_time;
                        $end = now();

                        $dateTimeObject1 = date_create($start);
                        //  $dateTimeObject2 = date_create($end);

                        $difference = date_diff($dateTimeObject1, $end);
                        $hcount = $difference->h;
                        if ($hcount == 0 || $hcount == 1 || $hcount == 2 || $hcount == 3 || $hcount == 4 || $hcount == 5 || $hcount == 6 || $hcount == 7 || $hcount == 8 || $hcount == 9) {
                            $hval = 0;
                        } else {
                            $hval = '';
                        }
                        $mcount = $difference->i;
                        if ($mcount == 0 || $mcount == 1 || $mcount == 2 || $mcount == 3 || $mcount == 4 || $mcount == 5 || $mcount == 6 || $mcount == 7 || $mcount == 8 || $mcount == 9) {
                            $mval = 0;
                        } else {
                            $mval = '';
                        }
                        $scount = $difference->s;
                        if ($scount == 0 || $scount == 1 || $scount == 2 || $scount == 3 || $scount == 4 || $scount == 5 || $scount == 6 || $scount == 7 || $scount == 8 || $scount == 9) {
                            $sval = 0;
                        } else {
                            $sval = '';
                        }
                        $total_votetime = $mval . $difference->i . ':' . $sval . $difference->s;

                        ?>

                        <button class="StartTimebutton"
                            title="Voting start for {{ $match_fixture->competition->vote_mins }} mins">
                            <div class="row">
                                <div class="col-md-7 p-1 m-auto">
                                    <!-- <span class="StartHalf">{{ $total_votetime }}</span></div> -->
                                    <span class="StartHalf">{{ $voting_timer }}</span>
                                </div>
                                <div class="col-md-5 StartHlfTime "><span class="FirstHalftStart">Voting<p
                                            class="HalfTimeH">START</p></span> </div>
                            </div>
                        </button>
                    @else
                        <?php
                        function hoursandmins($time, $format = '%02d:%02d')
                        {
                            if ($time < 1) {
                                return;
                            }
                            $hours = floor($time / 60);
                            $minutes = $time % 60;
                            //return sprintf($format, $hours, $minutes);
                            return sprintf($format, $minutes);
                        }

                        $vote_time = hoursandmins($match_fixture->competition->vote_mins, '%02d') . ':00';

                        ?>
                        <button class="StartTimebutton" title="Match Finished ">
                            <div class="row">
                                <div class="col-md-12 p-1 m-auto">
                                    <span class="StartHalf">Match Finished</span>
                                </div>
                            </div>
                        </button>
                    @endif
                @else
                    <button class="StartTimebutton" title="Match Finished ">
                        <div class="row">
                            <div class="col-md-12 p-1 m-auto">
                                <span class="StartHalf">Match Finished</span>
                            </div>
                        </div>
                    </button>
                @endif
            @endif
        </div>
        <!-- End Second Half Button -->
        @if (Auth::check())
            @if (in_array(Auth::user()->id, $admins) ||
                    Auth::user()->id == $competition->user_id ||
                    in_array(Auth::user()->id, $teamTwo_admin_ids))
                @if (@$fixture_lapse_type->lapse_type == 4)
                    <button class="btn squardtxt float-md-end" wire:click="openmodal({{ $match_fixture->teamTwo_id }})"
                        style="background:{{ $teamTwo_color->team_color }} !important; color:{{ $teamTwo_color->font_color }} !important;">
                        <span class="Squard9"
                            style="background:{{ $teamTwo_color->team_color }} !important; color:{{ $teamTwo_color->font_color }} !important;">{{ $teamTwoGoal }}</span>
                        Lineup :
                        {{ $teamTwo_defender }}-{{ $teamTwo_defensive }}-{{ $teamTwo_midfielder }}-{{ $teamTwo_attacking }}-{{ $teamTwo_forward }}
                    </button>
                @else
                    <button class="btn squardtxt float-md-end teamTwoDatetime" data-bs-toggle="modal"
                        data-time="{{ now() }}" data-bs-target="#squadModal_teamTwo"
                        data-id="{{ $match_fixture->teamTwo_id }}"
                        style="background:{{ $teamTwo_color->team_color }} !important; color:{{ $teamTwo_color->font_color }} !important;"><span
                            class="Squard9"
                            style="background:{{ $teamTwo_color->team_color }} !important; color:{{ $teamTwo_color->font_color }} !important;">{{ $teamTwoGoal }}</span>
                        Lineup :
                        {{ $teamTwo_defender }}-{{ $teamTwo_defensive }}-{{ $teamTwo_midfielder }}-{{ $teamTwo_attacking }}-{{ $teamTwo_forward }}</button>
                @endif
            @else
                <button class="btn squardtxt float-md-end" wire:click="openmodal({{ $match_fixture->teamTwo_id }})"
                    style="background:{{ $teamTwo_color->team_color }} !important;color:{{ $teamTwo_color->font_color }} !important; "><span
                        class="Squard9"
                        style="background:{{ $teamTwo_color->team_color }} !important; color:{{ $teamTwo_color->font_color }} !important;">{{ $teamTwoGoal }}</span>
                    Lineup :
                    {{ $teamTwo_defender }}-{{ $teamTwo_defensive }}-{{ $teamTwo_midfielder }}-{{ $teamTwo_attacking }}-{{ $teamTwo_forward }}</button>
            @endif
        @else
            <button class="btn squardtxt float-md-end" wire:click="openmodal({{ $match_fixture->teamTwo_id }})"
                style="background:{{ $teamTwo_color->team_color }} !important;color:{{ $teamTwo_color->font_color }} !important; "><span
                    class="Squard9"
                    style="background:{{ $teamTwo_color->team_color }} !important; color:{{ $teamTwo_color->font_color }} !important;">{{ $teamTwoGoal }}</span>
                Lineup :
                {{ $teamTwo_defender }}-{{ $teamTwo_defensive }}-{{ $teamTwo_midfielder }}-{{ $teamTwo_attacking }}-{{ $teamTwo_forward }}</button>
        @endif

        <div class="modal fade" id="public_squadModal" wire:ignore.self>
            <div class="modal-dialog modalfootbal  modal-lg" role="document">
                <div class="modal-content ground-wrap">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="image-profile-icon">
                                        <img src="{{ url('frontend/logo') }}/{{ $modal_teamlogo }}" class="img-fluid"
                                            alt="">
                                    </div>
                                    <div class="drop-profile">
                                        <div class="dropdown ">
                                            <button class="btn btn-danger btn-lg dropdown-toggle kanoPillars">
                                                {{ $modal_teamName }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h3 class="float-md-start text-black"><span class="text-bolder">Lineup: </span>
                                        {{ $modal_defendercount }}-{{ $modal_defensivecount }}-{{ $modal_medfieldercount }}-{{ $modal_attackingcount }}-{{ $modal_forwardcount }}
                                    </h3>
                                    <button class="btn btn-success btn-lg subMitbtn float-md-end"
                                        wire:click="close_modal">close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="play-ground">
                            <div class="container">
                                <div class="row mb-5">
                                    @if ($modal_teamId == $match_fixture->teamOne_id)
                                        <?php $jersey_class = 'jersy1'; ?>
                                    @else
                                        <?php $jersey_class = 'jersy2'; ?>
                                    @endif
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 1)
                                            <div class="col-sm-3 mx-auto text-center position-relative">
                                                <?php $gk = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                    ->where('team_id', $modal_teamId)
                                                    ->where('sport_ground_positions_id', $gmp->id)
                                                    ->where('is_active', 1)
                                                    ->with('player:id,profile_pic,first_name,last_name')
                                                    ->first(); ?>
                                                @if (!empty($gk))
                                                    <?php $gk_jersey_number = App\Models\Team_member::where('team_id', $modal_teamId)
                                                        ->where('member_id', $gk->player->id)
                                                        ->value('jersey_number'); ?>
                                                    <span class="jersy-nooo team-jersy-left {{ $jersey_class }}">
                                                        {{ $gk_jersey_number }}</span>
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/profile_pic') }}/{{ $gk->player->profile_pic }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #fff;border-radius: 5px;color: #000;">
                                                        {{ $gk->player->first_name }} {{ $gk->player->last_name }}
                                                    </div>
                                                @else
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/images/player_copy.png') }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #8dd88d;border-radius: 5px;color: #000;">
                                                        {{ $gmp->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row mb-5">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 2)
                                            <div class="col  text-center position-relative">
                                                <?php $Defender = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                    ->where('team_id', $modal_teamId)
                                                    ->where('sport_ground_positions_id', $gmp->id)
                                                    ->where('is_active', 1)
                                                    ->with('player:id,profile_pic,first_name,last_name')
                                                    ->first(); ?>
                                                @if (!empty($Defender))
                                                    <?php $Defender_jersey_number = App\Models\Team_member::where('team_id', $modal_teamId)
                                                        ->where('member_id', $Defender->player->id)
                                                        ->value('jersey_number'); ?>
                                                    <span class="jersy-nooo team-jersy-left {{ $jersey_class }}">
                                                        {{ $Defender_jersey_number }} </span>
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/profile_pic') }}/{{ $Defender->player->profile_pic }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #fff;border-radius: 5px;color: #000;">
                                                        {{ $Defender->player->first_name }}
                                                        {{ $Defender->player->last_name }}
                                                    </div>
                                                @else
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/images/player_copy.png') }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #8dd88d;border-radius: 5px;color: #000;">
                                                        {{ $gmp->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row mb-5">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 3)
                                            <div class="col  text-center position-relative">
                                                <?php $Dmdf = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                    ->where('team_id', $modal_teamId)
                                                    ->where('sport_ground_positions_id', $gmp->id)
                                                    ->where('is_active', 1)
                                                    ->with('player:id,profile_pic,first_name,last_name')
                                                    ->first();
                                                ?>
                                                @if (!empty($Dmdf))
                                                    <?php $Dmdf_jersey_number = App\Models\Team_member::where('team_id', $modal_teamId)
                                                        ->where('member_id', $Dmdf->player->id)
                                                        ->value('jersey_number'); ?>
                                                    <span class="jersy-nooo team-jersy-left {{ $jersey_class }}">
                                                        {{ $Dmdf_jersey_number }} </span>
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/profile_pic') }}/{{ $Dmdf->player->profile_pic }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #fff;border-radius: 5px;color: #000;">
                                                        {{ $Dmdf->player->first_name }} {{ $Dmdf->player->last_name }}
                                                    </div>
                                                @else
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/images/player_copy.png') }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #8dd88d;border-radius: 5px;color: #000;">
                                                        {{ $gmp->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row mb-5">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 4)
                                            <div class="col  text-center position-relative">
                                                <?php $mdf = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                    ->where('team_id', $modal_teamId)
                                                    ->where('sport_ground_positions_id', $gmp->id)
                                                    ->where('is_active', 1)
                                                    ->with('player:id,profile_pic,first_name,last_name')
                                                    ->first();
                                                ?>
                                                @if (!empty($mdf))
                                                    <?php $mdf_jersey_number = App\Models\Team_member::where('team_id', $modal_teamId)
                                                        ->where('member_id', $mdf->player->id)
                                                        ->value('jersey_number'); ?>
                                                    <span class="jersy-nooo team-jersy-left {{ $jersey_class }}">
                                                        {{ $mdf_jersey_number }} </span>
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/profile_pic') }}/{{ $mdf->player->profile_pic }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #fff;border-radius: 5px;color: #000;">
                                                        {{ $mdf->player->first_name }} {{ $mdf->player->last_name }}
                                                    </div>
                                                @else
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/images/player_copy.png') }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #8dd88d;border-radius: 5px;color: #000;">
                                                        {{ $gmp->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row mb-5">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 5)
                                            <div class="col  text-center position-relative">
                                                <?php $Amdf = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                    ->where('team_id', $modal_teamId)
                                                    ->where('sport_ground_positions_id', $gmp->id)
                                                    ->where('is_active', 1)
                                                    ->with('player:id,profile_pic,first_name,last_name')
                                                    ->first();
                                                ?>
                                                @if (!empty($Amdf))
                                                    <?php $Amdf_jersey_number = App\Models\Team_member::where('team_id', $modal_teamId)
                                                        ->where('member_id', $Amdf->player->id)
                                                        ->value('jersey_number'); ?>
                                                    <span class="jersy-nooo team-jersy-left {{ $jersey_class }}">
                                                        {{ $Amdf_jersey_number }} </span>
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/profile_pic') }}/{{ $Amdf->player->profile_pic }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #fff;border-radius: 5px;color: #000;">
                                                        {{ $Amdf->player->first_name }} {{ $Amdf->player->last_name }}
                                                    </div>
                                                @else
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/images/player_copy.png') }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #8dd88d;border-radius: 5px;color: #000;">
                                                        {{ $gmp->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row mb-5">
                                    @foreach ($ground_map_position as $gmp)
                                        @if ($gmp->ground_coordinates == 6)
                                            <div class="col  text-center position-relative">
                                                <?php $forward = App\Models\Fixture_squad::where('match_fixture_id', $match_fixture->id)
                                                    ->where('team_id', $modal_teamId)
                                                    ->where('sport_ground_positions_id', $gmp->id)
                                                    ->where('is_active', 1)
                                                    ->with('player:id,profile_pic,first_name,last_name')
                                                    ->first();
                                                ?>
                                                @if (!empty($forward))
                                                    <?php $forward_jersey_number = App\Models\Team_member::where('team_id', $modal_teamId)
                                                        ->where('member_id', $forward->player->id)
                                                        ->value('jersey_number'); ?>
                                                    <span class="jersy-nooo team-jersy-left {{ $jersey_class }}">
                                                        {{ $forward_jersey_number }} </span>
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/profile_pic') }}/{{ $forward->player->profile_pic }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #fff;border-radius: 5px;color: #000;">
                                                        {{ $forward->player->first_name }}
                                                        {{ $forward->player->last_name }}
                                                    </div>
                                                @else
                                                    <div class="player-img"><img
                                                            src="{{ url('frontend/images/player_copy.png') }}"
                                                            class="img-fluid" alt="player"></div>
                                                    <div class="select-box"
                                                        style="margin-top: 50px;background-color: #8dd88d;border-radius: 5px;color: #000;">
                                                        {{ $gmp->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-content modal-contentBottom">
                    <div class=" bg-light-dark">
                        <div class="row text-center px-1">
                            <h2 class="text-bolder heading-dark-bg">Substitute Players</h2>
                        </div>
                        <div class="row">
                            @foreach ($subtitute_players as $players)
                                <div class="col col-4 col-md-2  text-center position-relative">
                                    <div class="substitute select-box substitute_players">
                                        {{ $players->player->first_name }} {{ $players->player->last_name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('Openpublic_squadModal', event => {
                $('#public_squadModal').modal('show');
            });
        </script>
        <script>
            window.addEventListener('Closepublic_squadModal', event => {
                $('#public_squadModal').modal('hide');
            });
        </script>
        <script type="text/javascript" src="{{ url('frontend/js/dist_sweetalert.min.js') }}"></script>
        <script>
            function refreeAlert() {
                swal({
                    title: "Please select Referee For the Match!",
                });
            }

            function squadAlert() {
                swal({
                    title: "Please select squad players!",
                });
            }
        </script>
    </div>
    </div>
