@include('frontend.includes.header')
<style>
    .processed {
        display: none;
    }
</style>

{{-- <input type="button" class="refresh-btn" > --}}
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
<?php $centerIndex = null; ?>
<div class="Competitionn-Page-Additional">
    @livewire('playerprofile.edit-player-banner', ['player' => $user_info->id])
    <div class="dashboard-profile ">
        <div class="container-lg">
            <div class="bg-white row">
                <div class="col-sm-12 position-relative">
                    @livewire('playerprofile.edit-player-logo', ['player' => $user_info->id])
                    <div class="w-auto user-profile-detail float-start">
                        <h1><strong>{{ $user_info->first_name }}</strong> {{ $user_info->last_name }}</h1>
                        <div class="d-flexCT">
                            <p>
                                <span><i class="fa-flag"> <span class="CountryStat "> COUNTRY</span></i><br>
                                    <span class="Player-Profile">{{ $user_info->nationality }}</span> </span>
                            </p>
                            <p class="LeftSpace">
                                <span><i class="fa-users"><span class="CountryStat"> TEAM(S)</span></i><br><span
                                        class="Player-Profile">
                                        @if ($team_member)
                                            <?php $team1 = App\Models\Team::find($team_member->team_id); ?>
                                            <a href="{{ URL::to('team/' . $team1->id) }}" target="_blank">
                                                {{ $team1->name }} </a>
                                        @else
                                            --
                                            @endif @if ($all_team_member->count() > 0)
                                                <span data-toggle="tooltip" data-placement="bottom" title=""
                                                    data-original-title="@foreach ($all_team_member as $teams) <?php $team_info = App\Models\Team::select('id', 'name')->find($teams->team_id); ?> {{ $team_info->name }}, @endforeach">
                                                    +{{ $all_team_member->count() }}more </span>
                                            @else
                                            @endif
                                    </span>
                                </span>
                            </p>
                        </div>
                    </div>
                    @livewire('player-addfriend-follow', ['user' => $user_info])
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!-- close div of site wrap i.e. on header page-->

<main id="main" class="dashboard-wrap Player-public-pro ">
    <div class="container-lg">
        <div class="row AboutMe">
            <div class="pr-0 col-md-2">
                <div class="box1">
                    <span class="Height">HEIGHT</span>
                    <p class="fitIn"><span class="FiveFt">
                            @if ($user_info->height == null)
                                --
                            @else
                                {{ $d_feet }}
                        </span>ft<span class="FiveFt">{{ $d_in }} </span>in
                        @endif
                    </p>
                    <span class="meterH">
                        @if ($user_info->height == null)
                            -- @else{{ $user_info->height }} cm
                        @endif
                    </span>
                </div>
            </div>
            <div class="p-0 col-md-2">
                <div class="box2">
                    <span class="Height">WEIGHT</span>
                    <p class="fitIn"><span class="FiveFt">
                            @if ($user_info->weight == null)
                                --
                            @else
                                {{ $weight_lbs }}
                            @endif
                        </span>lbs</p>
                    <span class="meterH">
                        @if ($user_info->weight == null)
                            -- @else{{ $user_info->weight }} Kg
                        @endif
                    </span>
                </div>
            </div>
            <div class="p-0 col-md-2">
                <div class="box3">
                    <span class="Height">AGE / D.O.B</span>
                    <p class="fitIn"><span class="FiveFt">
                            @if ($user_info->dob == null)
                                --
                            @else
                                {{ $age }}
                            @endif
                        </span>yrs</p>
                    <span class="meterH">
                        @if ($user_info->dob == null)
                            --
                        @else
                            {{ date('d M Y', strtotime($user_info->dob)) }}
                        @endif
                    </span>
                </div>
            </div>
            <div class="pl-0 col-md-6 plMob-12 custom_playeraboutus">
                <div class="box4">
                    <div class="LeoMessi">{!! $user_info->bio !!}</div>
                    <div class="AboutME">ABOUT&nbsp;&nbsp;ME</div>
                </div>
            </div>
        </div>
        @if ($player_stats->IsnotEmpty())
            <div class="row statsTable">
                <div class="col-md-12">
                    <h1>
                        <button class="btn fs1 float-end">
                            <!-- <i class="icon-more_horiz"></i> -->
                        </button>
                    </h1>
                </div>
                <input type="hidden" id="player_id" value="{{ $user_info->id }}">
                <div class="col-md-4 PR-0">
                    <div class="box-outer-Left">
                        <!-- <div id="carouselExampleControls01" class="carousel slide teamcarousel" data-bs-ride="carousel"
                    data-bs-interval="false">
                    <div class="text-center carousel-inner carousel-inner01">
                        <?php $i = 0; ?>
                        @foreach ($player_stats->groupBy('competition_id') as $comp => $stat)
<?php
if ($i == 0) {
    $class = 'active';
} else {
    $class = '';
}
$comp_info = App\Models\Competition::find($comp); ?>
                            <div class="carousel-item carousel-item01 CP {{ $class }}"
                                data-compid="{{ $comp_info->id }}">
                                <a href="{{ URL::to('competition/' . $comp_info->id) }}" target="_blank"> <img
                                        class="rounded-circle "
                                        src="{{ url('frontend/logo') }}/{{ $comp_info->comp_logo }}" width="20%"
                                        alt="First slide"> </a>
                                <span class="TotallText" title="{{ $comp_info->name }}"><a
                                        href="{{ URL::to('competition/' . $comp_info->id) }}" target="_blank">
                                        @php echo Str::of($comp_info->name)->limit(12); @endphp </a></span>
                            </div>
                            <?php $i++; ?>
@endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls01"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls01"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div> -->
                        <div class="ThamnailWithSelect">
                            <div class="f-group">
                                <select class="f-control f-dropdown" id="teamComp1" name="teamComp1">
                                    @foreach ($player_stats->groupBy('competition_id') as $comp => $stat)
                                        <?php $comp_info = App\Models\Competition::find($comp); ?>
                                        <option value="{{ $comp_info->id }}" title="{{ $comp_info->name }}"
                                            data-name="{{ $comp_info->name }}" data-compid="{{ $comp_info->id }}"
                                            data-image="{{ url('frontend/logo') }}/{{ $comp_info->comp_logo }}">
                                            @php echo Str::of($comp_info->name)->limit(25); @endphp</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 PL-0">
                    <div class="box-outer-Right">
                        <div class="W-50 ">
                            <div class="d-flex D-flexUnset">
                                <div class="m-auto">
                                    <p class="mb-0 ContractStared">JOINED TEAM</p>
                                    <span class="AugJun" id="contract"><?php echo strtoupper(date('M', strtotime($contract_jerseynum->created_at))); ?>
                                        {{ date('d, Y', strtotime($contract_jerseynum->created_at)) }}</span>
                                </div>
                                <span class="m-auto">
                                    <!-- <img src="{{ url('frontend/images/shape-playr-pub.png') }}"></span>
                           <div class="m-auto" >
                              <p class="mb-0 ContractStared">LEFT TEAM</p>
                              <span class="AugJun"> {{ date('d, Y', strtotime(now())) }}</span>
                           </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="stat_data">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="LeftBoxOuter W-auto-Scroll" id="ScrollBottom">
                                <div class="WidthMin768">
                                    <div class="row StatPaddingTB" id="MyStat2of1">
                                        <div class="col-md-3 col-6 LineHeight ">
                                            <div class="D-inlineFlx">
                                                <div class="RedCr"></div>
                                                <p class="mb-0T">Team Stats</p>
                                            </div>
                                            <div class="D-inlineFlx">
                                                <div class="BlueCr"></div>
                                                <p class="mb-0T">My Stats </p>

                                            </div>

                                        </div>
                                        @if (!empty($check_next_fixture))
                                            <?php if ($check_next_fixture->teamOne_id == $team->id) {
                                                $next_match_opp_team = App\Models\Team::find($check_next_fixture->teamTwo_id);
                                            } else {
                                                $next_match_opp_team = App\Models\Team::find($check_next_fixture->teamOne_id);
                                            }
                                            $next_macth_content = strtoupper(date('d M Y', strtotime($check_next_fixture->fixture_date)));
                                            ?>
                                            <div class="col-md-3 col-6 txtCenterMob WithDate LineHeight">Next Match
                                                <span class="stageReimsSize">
                                                    <img src="{{ url('frontend/logo') }}/{{ $next_match_opp_team->team_logo }}"
                                                        class="img-fluid stageReims">
                                                </span>
                                                <a href="{{ URL::to('match-fixture/' . $check_next_fixture->id) }}"
                                                    target="_blank">
                                                    <p class="MatchDate">{{ $next_macth_content }}</p>
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-md-3 col-6 txtCenterMob withoutDate LineHeight">
                                                Next<br>Match
                                                <span class="NAPlayerDas">N/A</span>
                                            </div>
                                        @endif


                                        <div class="col-md-4 col-6 LineHeight">
                                            <div class="row">
                                                <div class="pr-4 col-md-4">
                                                    <span class="SQUAD">SQUAD</span>
                                                    <p class="PositionSquad">POSITION</p>
                                                </div>
                                                <div class="pl-0 col-md-8">
                                                    <span class="StrickerTxt" id="squad_position">
                                                        {{ $contract_jerseynum->member_position->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center col-md-2 col-6 LineHeight">
                                            <div class="row">
                                                <div class="pr-4 col-md-6">
                                                    <span class="SQUAD">JERSEY</span>
                                                    <p class="PositionSquad">NUMBER</p>
                                                </div>

                                                <div class="pl-0 col-md-6">
                                                    <span class="JersyNo" id="jersy_num"
                                                        style="background-color:{{ $team->team_color }};"><?php
                                                        if (!empty($contract_jerseynum['jersey_number'])) {
                                                            echo $contract_jerseynum = str_pad($contract_jerseynum['jersey_number'], 2, '0', STR_PAD_LEFT);
                                                        } else {
                                                            echo 'NA';
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row " id="MyStat2of2">
                                        <div class="col-md-1 width-7">
                                        </div>
                                        <?php
                                        $team_id = $team->id;
                                        $total_played = App\Models\Match_fixture::select('id')
                                            ->where(function ($query) use ($team_id) {
                                                $query->where('teamOne_id', '=', $team_id)->orWhere('teamTwo_id', '=', $team_id);
                                            })
                                            ->where('competition_id', $first_comp_id)
                                            ->where('finishdate_time', '!=', null)
                                            ->get();
                                        $fixture_ids = [];
                                        foreach ($total_played as $fixture) {
                                            $fixture_ids[] = $fixture->id;
                                        }
                                        $player_played = App\Models\Fixture_squad::whereIn('match_fixture_id', $fixture_ids)
                                            ->where('team_id', $team->id)
                                            ->where('player_id', $user_info->id)
                                            ->count();
                                        if ($total_played->count() > 0) {
                                            $played_precs = ($player_played / $total_played->count()) * 100;
                                            $played_prec = number_format($played_precs, 2);
                                        } else {
                                            $played_prec = '00.00';
                                        }
                                        ?>
                                        <div class="text-center col-md-2 col-6 mobMrgRL">
                                            <div class="SpacingLine ">
                                                <div class="FiftyTwoPer">
                                                    <div class="PlayedStyle"><?php echo str_pad($total_played->count(), 2, '0', STR_PAD_LEFT); ?></div><strong
                                                        class="Payed23"><?php echo str_pad($player_played, 2, '0', STR_PAD_LEFT); ?></strong><span
                                                        class="PlayedUnderText">{{ $played_prec }}%
                                                    </span>
                                                </div>
                                                <p class="Playedcolor">Played</p>
                                            </div>
                                        </div>
                                        @foreach ($basic_stat as $stat_id)
                                            @if ($stat_id == 1)
                                                <?php $stat = App\Models\Sport_stat::find($stat_id);
                                                $total_stats = App\Models\Match_fixture_stat::where('competition_id', $first_comp_id)
                                                    ->whereIn('sport_stats_id', [1, 54])
                                                    ->where('team_id', $team->id)
                                                    ->count();
                                                $count_player_stats = App\Models\Match_fixture_stat::where('competition_id', $first_comp_id)
                                                    ->where('sport_stats_id', $stat->id)
                                                    ->where('team_id', $team->id)
                                                    ->where('player_id', $user_info->id)
                                                    ->count();
                                                if ($total_stats > 0) {
                                                    $stat_precs = ($count_player_stats / $total_stats) * 100;
                                                    $stat_prec = number_format($stat_precs, 2);
                                                } else {
                                                    $stat_prec = '00.00';
                                                }
                                                ?>
                                                <div class="text-center col-md-2 col-6 mobMrgRL">
                                                    <div class="SpacingLine ">
                                                        <div class="FiftyTwoPer">
                                                            <div class="PlayedStyle"><?php echo str_pad($total_stats, 2, '0', STR_PAD_LEFT); ?></div><strong
                                                                class="Payed23"><?php echo str_pad($count_player_stats, 2, '0', STR_PAD_LEFT); ?></strong><span
                                                                class="PlayedUnderText"> {{ $stat_prec }}%
                                                            </span>
                                                        </div>
                                                        <p class="Playedcolor">{{ $stat->description }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <?php $stat = App\Models\Sport_stat::find($stat_id);
                                                $total_stats = App\Models\Match_fixture_stat::where('competition_id', $first_comp_id)
                                                    ->where('sport_stats_id', $stat->id)
                                                    ->where('team_id', $team->id)
                                                    ->count();
                                                $count_player_stats = App\Models\Match_fixture_stat::where('competition_id', $first_comp_id)
                                                    ->where('sport_stats_id', $stat->id)
                                                    ->where('team_id', $team->id)
                                                    ->where('player_id', $user_info->id)
                                                    ->count();
                                                if ($total_stats > 0) {
                                                    $stat_precs = ($count_player_stats / $total_stats) * 100;
                                                    $stat_prec = number_format($stat_precs, 2);
                                                } else {
                                                    $stat_prec = '00.00';
                                                }
                                                ?>
                                                <div class="text-center col-md-2 col-6 mobMrgRL">
                                                    <div class="SpacingLine ">
                                                        <div class="FiftyTwoPer">
                                                            <div class="PlayedStyle"><?php echo str_pad($total_stats, 2, '0', STR_PAD_LEFT); ?></div><strong
                                                                class="Payed23"><?php echo str_pad($count_player_stats, 2, '0', STR_PAD_LEFT); ?></strong><span
                                                                class="PlayedUnderText"> {{ $stat_prec }}%
                                                            </span>
                                                        </div>
                                                        <p class="Playedcolor">{{ $stat->description }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach


                                        <div class="col-md-2 width-7">
                                        </div>
                                    </div>
                                    <div class="text-right col-md-12 statviewComp ">
                                        <a class="FullStat" href="{{ URL::to('competition/' . $first_comp_id) }}"
                                            target="_blank">
                                            View Competition </a>&nbsp;|&nbsp;<a class="FullStat"
                                            data-bs-toggle="modal" data-bs-target="#FullStatTable">~Full Stat
                                            Table</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="FootbalClubCircl heightAddRespon">
                                <a href="{{ URL::to('team/' . $team->id) }}" target="_blank"> <img
                                        class="rounded-circle" id="team_logo"
                                        src="{{ url('frontend/logo') }}/{{ $team->team_logo }}" width="80%"
                                        alt="..."> </a>
                                <p class="LogoBottomText" id="team_name"> <a
                                        href="{{ URL::to('team/' . $team->id) }}" target="_blank">
                                        {{ $team->name }} </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
        @endif

        <div class="row M-topSpace">
            <div class="col-md-8 col-lg-8">
                @if ($fixtures->isNotEmpty())
                    <h1 class="Poppins-Fs30">Fixture Calendar <button class="btn fs1 float-end"><i
                                class="icon-more_horiz"></i></button></h1>
                    <div class="box-outer-lightpink Team-Fixture Competitionn-Page-Additional">
                        <ul class="nav nav-tabs">
                            <div class="owl_1 owl-carousel owl-theme">
                                <?php
								$index = 0;
								for($start_year = $min_year; $start_year <= $max_year; $start_year++)
								{
									if($start_year == $min_year)
									{
										$startmonth = $min_year_month;
									}
									else
									{
										$startmonth = 1;
									}
									for($start_month=$startmonth; $start_month <= 12; $start_month++)
									{
										$i = $start_year;
										$current_month = date('m');
										$current_year = date('Y');
										if($current_month == $start_month && $current_year == $start_year)
										{
											$centerIndex = $index - 6;
											$class = "active";
											$link = date("M", mktime(0, 0, 0, $start_month,1,$start_year)).$i;
										}
										else
										{
											$centerIndex = $index - 10;
											$class = "";
											$link = date("M", mktime(0, 0, 0, $start_month,1,$max_year)).$i;
										}
										?>

                                <div class="item">
                                    <li class="{{ $class }}" data-toggle="tab" href="#{{ $link }}">
                                        <a>{{ date('M', mktime(0, 0, 0, $start_month, 1)) }}<p>{{ $start_year }}</p>
                                        </a>
                                    </li>
                                </div>
                                <?php
									$index++;
									}
									if($start_year == $max_year)
									{
										$count_month = 12 - $min_year_month;
										$month_add = $count_month + 1;
										$next_months = 12 - $month_add;
										$next_year = $start_year + 1;
										for($m = 1; $m <= $next_months; $m++)
										{
											?>
                                <div class="item">
                                    <li class="" data-toggle="tab"
                                        href="#{{ date('M', mktime(0, 0, 0, $m)) . $next_year }}">
                                        <a>{{ date('M', mktime(0, 0, 0, $m, 1)) }}<p>{{ $next_year }}</p></a>
                                    </li>
                                </div>
                                <?php
										}

									}
								}
							?>
                            </div>
                        </ul>
                        <div class="tab-content">
                            <?php for($start_year = $min_year; $start_year <= $max_year; $start_year++)
							{
								if($start_year == $min_year)
								{
									$startmonth = $min_year_month;
								}
								else
								{
									$startmonth = 1;
								}
								for($start_month=$startmonth; $start_month <= 12; $start_month++)
								{
									$i = $start_year;
									$current_month = date('m');
									$current_year = date('Y');
									$contentlink = date("M", mktime(0, 0, 0, $start_month,1,$start_year)).$i;
									if($current_month == $start_month && $current_year == $start_year)
									{
										$div_class = "tab-pane fade active";
									}
									else
									{
										$div_class = "tab-pane fade in";
									}
									?>
                            <div id="{{ $contentlink }}" class="{{ $div_class }}">
                                <?php
                                $msgarray = [];
                                for ($t = 0; $t < count($team_ids); $t++) {
                                    //echo $team_ids[$t]."<br/>";
                                
                                    // $check_month = array_search ($month, $month_array);
                                    // $get_month = $check_month + 1;
                                    // $tab_month = str_pad($get_month,2,'0',STR_PAD_LEFT);
                                    // //$current_month = date('m');
                                    // $current_year = date('Y');
                                    // $default_search = $current_year."-".$tab_month;
                                    $current_year = date('Y');
                                    $default_search = $start_year . '-' . str_pad($start_month, 2, '0', STR_PAD_LEFT);
                                    //echo $default_search;
                                    $team_id = $team_ids[$t];
                                
                                    $check_fixtures = App\Models\Match_fixture::where(function ($query) use ($team_id) {
                                        $query->where('teamOne_id', '=', $team_id)->orWhere('teamTwo_id', '=', $team_id);
                                    })
                                        ->where('fixture_date', 'like', '%' . $default_search . '%')
                                        ->with('competition', 'teamOne', 'teamTwo')
                                        ->where('fixture_type', '!=', 9)
                                        ->get();
                                }
                                
                                ?>
                                @if (count($check_fixtures) > 0)
                                    <?php
                                    
                                    $c_fixtures = [];
                                    foreach ($check_fixtures as $fix) {
                                        $c_fixtures[] = $fix;
                                    }
                                    $fixture_chunks = array_chunk($c_fixtures, 10);
                                    
                                    ?>
                                    <div class="owlfixturetable owl-carousel owl-theme">
                                        @foreach ($fixture_chunks as $chunks)
                                            <table class="table TableFixtureCalndr item">
                                                @foreach ($chunks as $fixture)
                                                    <?php $Comp_type = App\Models\competition_type::find($fixture->competition->comp_type_id);
                                                    ?>
                                                    <tr>
                                                        <td class="FaCupClor">
                                                            <a href="{{ URL::to('competition/' . $fixture->competition->id) }}"
                                                                target="_blank" data-toggle="tooltip"
                                                                data-placement="bottom" title=""
                                                                data-original-title="{{ $fixture->competition->name }}">
                                                                @php echo Str::of($fixture->competition->name)->limit(7); @endphp</a>
                                                        </td>
                                                        <td class="RightPosiText ">
                                                            <b class="WolVerWand"><a
                                                                    href="{{ URL::to('team/' . $fixture->teamOne->id) }}"
                                                                    target="_blank" data-toggle="tooltip"
                                                                    data-placement="bottom" title=""
                                                                    data-original-title="{{ $fixture->teamOne->name }}">
                                                                    @php echo Str::of($fixture->teamOne->name)->limit(7); @endphp </a></b>&nbsp;
                                                            <div class="pp-pageHW"> <a
                                                                    href="{{ URL::to('team/' . $fixture->teamOne->id) }}"
                                                                    target="_blank" data-toggle="tooltip"
                                                                    data-placement="bottom" title=""
                                                                    data-original-title="{{ $fixture->teamOne->name }}"><img
                                                                        class="img-fluid"
                                                                        src="{{ asset('frontend/logo') }}/{{ $fixture->teamOne->team_logo }}">
                                                                </a></div>
                                                        </td>
                                                        <td class="BtnCentr">
                                                            @if ($fixture->startdate_time == null)
                                                                <button class="text-center btn btn-gray btn-xs-nb"
                                                                    wire:click="check_start_comp({{ $fixture->id }})"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Competition Name: {{ $fixture->competition->name }}, Competition type: {{ $Comp_type->name }}, TeamOne: {{ $fixture->teamOne->name }}, TeamTwo: {{ $fixture->teamTwo->name }}">
                                                                    {{ date('H:i', strtotime($fixture->fixture_date)) }}</button>
                                                            @else
                                                                <?php $teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                                                    ->where('team_id', $fixture->teamOne_id)
                                                                    ->whereIn('sport_stats_id', [1, 54])
                                                                    ->get();
                                                                $teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                                                    ->where('team_id', $fixture->teamTwo_id)
                                                                    ->whereIn('sport_stats_id', [1, 54])
                                                                    ->get(); ?>
                                                                <a data-toggle="tooltip" data-placement="bottom"
                                                                    title="Competition Name: {{ $fixture->competition->name }}, Competition type: {{ $Comp_type->name }}, TeamOne: {{ $fixture->teamOne->name }}, TeamTwo: {{ $fixture->teamTwo->name }}">
                                                                    <span
                                                                        class=" btn-greenFXL"><?php echo str_pad($teamOneGoal->count(), 2, 0, STR_PAD_LEFT); ?></span>
                                                                    <span
                                                                        class=" btn-greenFXR"><?php echo str_pad($teamTwoGoal->count(), 2, 0, STR_PAD_LEFT); ?></span>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td class="LeftPosiText ">
                                                            <div class="pp-pageHW"><a
                                                                    href="{{ URL::to('team/' . $fixture->teamTwo->id) }}"
                                                                    target="_blank" data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title="{{ $fixture->teamTwo->name }}"
                                                                    data-original-title="{{ $fixture->teamTwo->name }}"><img
                                                                        class="img-fluid"
                                                                        src="{{ asset('frontend/logo') }}/{{ $fixture->teamTwo->team_logo }}"></a>
                                                            </div>&nbsp;
                                                            <b class="WolVerWand"><a
                                                                    href="{{ URL::to('team/' . $fixture->teamTwo->id) }}"
                                                                    target="_blank" data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title="{{ $fixture->teamTwo->name }}"
                                                                    data-original-title="{{ $fixture->teamTwo->name }}">@php echo Str::of($fixture->teamTwo->name)->limit(7); @endphp</a></b>
                                                        </td>
                                                        <td>
                                                            <a href="{{ URL::to('match-fixture/' . $fixture->id) }}"
                                                                target="_blank"> <span class="OnSun">
                                                                    {{ date('D', strtotime($fixture->fixture_date)) }}
                                                                </span><span class="Dec-DateFix">
                                                                    {{ date('M d', strtotime($fixture->fixture_date)) }}</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-center"> No Data Found !</p>
                                @endif

                            </div>
                            <?php }
							}?>
                        </div>
                    </div>
                @else
                @endif


                <div class="col-md-12 col-lg-12">
                    @if (Auth::check())
                        @if (Auth::user()->id == $user_info->id)
                            <span> <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    style="cursor:pointer;"><span class="fa-plus"> </span></a> </span>
                            @if (count($trophy_cabinets) == 0)
                                <h1 class="Poppins-Fs30">Trophy Cabinet <button class="btn fs1 float-end"></button>
                                </h1>
                            @else
                            @endif
                        @else
                        @endif
                    @else
                    @endif
                    @if (count($trophy_cabinets) != 0)
                        <h1 class="Poppins-Fs30">Trophy Cabinet <button class="btn fs1 float-end"></button></h1>
                        <div class="box-outer-lightpink">
                            <div class="row">
                                @foreach ($trophy_cabinets as $trophy_cabinet)
                                    <div class="col-md-6 w-100-768 ">
                                        <div class="row InsideSpace">
                                            <div class="col-md-3 col-3 ">
                                                <div class="BestFifa">
                                                    <?php
                                                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                                                        $url = 'https://';
                                                    } else {
                                                        $url = 'http://';
                                                    }
                                                    // Append the host(domain name, ip) to the URL.
                                                    $url .= $_SERVER['HTTP_HOST'];
                                                    
                                                    $trophyimage = $url . '/storage/app/public/image/' . $trophy_cabinet->trophy_image;
                                                    ?>
                                                    <img class="img-fluid" src="{{ $trophyimage }}" width="">
                                                </div>
                                            </div>
                                            <?php $years = explode(',', $trophy_cabinet->year);
                                            $count = count($years); ?>
                                            <div class="col-md-9 col-9 BestFifaStyle">

                                                <p class="BestMenFifa">{{ $trophy_cabinet->title }}</p>
                                                <p>
                                                <div class="multiply">×{{ $count }}</div> <span
                                                    class="NATeam">YEAR:
                                                    {{ $trophy_cabinet->year }}</span></p>
                                                <p class="NATeam">Team: {{ $trophy_cabinet->team }}</p>
                                                <p class="NATeam">Comp: {{ $trophy_cabinet->comp }}</p>
                                                @if (Auth::check())
                                                    @if (Auth::user()->id == $user_info->id)
                                                        <a style="cursor:pointer;"
                                                            href="{{ url('deleteplayertrophycabinet/' . $trophy_cabinet->id) }}"
                                                            onclick="return confirm('Are you sure you want to delete this Record?')"><i
                                                                class="icon-trash "></i></a>
                                                        <span class="Edit-Team-player-jerseyno edit_tophy"
                                                            style="color:#000;cursor:pointer"
                                                            data-id="{{ $trophy_cabinet->id }}"></span>
                                                    @else
                                                    @endif
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                    @endif

                </div>
            </div>

            @livewire('playerprofile.add-edit-youtubevideo', ['player' => $user_info->id])
            @livewireScripts
        </div>
    </div>
</main>
<!-- The  Add Trophy cabinate model-->
<div class="modal fade myModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a Trophy / Award</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add_trophy_cabinet" method="POST" action="{{ url('addtrophycabinet') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <input type="hidden" name="type_id" value="{{ $user_info->id }}">
                                <input type="hidden" name="trophy_type" value="1">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="text" id="title" name="title"
                                        value="">
                                    <span class="highlight"></span>
                                    <label>Title of Trophy / Award</label>
                                </div>
                                <div class="text-danger" id="title_validate"></div>
                            </div>
                        </div>
                        <?php $currentyear = date('Y'); ?>
                        <div class="mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <select class="form-control" id="mySelect2" name="years[]" multiple="multiple">
                                        @for ($i = 1985; $i <= $currentyear; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="text-danger" id="mySelect2_validate"></div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="text" id="team" name="team">
                                    <span class="highlight"></span>
                                    <label>Team</label>
                                </div>
                                <div class="text-danger" id="team_validate"></div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="text" id="competition"
                                        name="competition">
                                    <span class="highlight"></span>
                                    <label>Competition Name</label>
                                </div>
                                <div class="text-danger" id="competition_validate"></div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="file" id="imgInp" name="trophy_image"
                                        accept="image/*">
                                    <span class="highlight"></span>
                                    <label>Trophy / Award Image</label>
                                </div>
                                <div class="text-danger" id="imgInp_validate"></div>
                            </div>
                            <img style="visibility:hidden" id="prview" src="" width=100 height=100 />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addTrophy_form">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The  Edit Trophy cabinate model-->
<div class="modal fade editModal" id="edit_trophy_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit a Trophy / Award</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('edittrophycabinet') }}" enctype="multipart/form-data"
                    id="second_form">
                    @csrf
                    <div class="row">
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <input type="hidden" name="cabinet_id" id="cabinet_id" value="">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="text" id="edit_title" name="title"
                                        value="">
                                    <span class="highlight"></span>
                                    <label>Title of Trophy / Award</label>
                                </div>
                                <div class="text-danger" id="edit_title_validate"></div>
                            </div>
                        </div>
                        <?php $currentyear = date('Y'); ?>
                        <div class="mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <select class="form-control" id="editselect2" name="years[]"
                                        multiple="multiple">
                                        @for ($i = 1985; $i <= $currentyear; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="text-danger" id="editselect2_validate"></div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="text" id="edit_team" name="team">
                                    <span class="highlight"></span>
                                    <label>Team Name</label>
                                </div>
                                <div class="text-danger" id="edit_team_validate"></div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="text" id="edit_competition"
                                        name="competition">
                                    <span class="highlight"></span>
                                    <label>Competition Name</label>
                                </div>
                                <div class="text-danger" id="edit_competition_validate"></div>
                            </div>
                        </div>
                        <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="file" id="oldimg" name="trophy_image"
                                        value="" accept="image/*">
                                    <span class="highlight"></span>
                                    <label>Trophy / Award Image</label>
                                </div>
                                <div class="text-danger" id="oldimg_validate"></div>
                            </div>
                            <img class="old_img" src="" id="prview1" width=100 height=100 />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="editTrophy_form">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- start Full stat table model -->
<div class="modal fade" id="FullStatTable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Full Stat Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body " id="ScrollRight">
                <div class="">
                    <div class="col-md-12 bootstrap snippets bootdeys">
                        <div class="x_panel">
                            <div class="x_content">
                                <div class="row">
                                    @foreach ($player_stats->groupBy('team_id') as $team => $stat)
                                        <?php $player_team = App\Models\Team::select('id', 'name', 'team_logo')->find($team); ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12 animated fadeInDown">
                                            <div class="well profile_view">
                                                <div class="col-sm-12">
                                                    <div class="left col-xs-7">
                                                        <div class="row">
                                                            <div class="pr-0 mb-2 col-md-1 col-2 ">
                                                                <span class="championLeagueRounde ">
                                                                    <a href="{{ URL::to('team/' . $team) }}"
                                                                        target="_blank"> <img
                                                                            class="rounded-circle img-fluid"
                                                                            src="{{ url('frontend/logo') }}/{{ $player_team->team_logo }}">
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="p-0 mt-2 col-md-6 col-9 ">
                                                                <a href="{{ URL::to('team/' . $team) }}"
                                                                    target="_blank"> {{ $player_team->name }} </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center right col-xs-5">
                                                        {{ $user_info->first_name }} {{ $user_info->last_name }}
                                                    </div>
                                                </div>
                                                <div class="text-center col-xs-12 bottom" style="overflow-x:auto;"
                                                    id="ScrollBottom">
                                                    <?php $player_matches = App\Models\Match_fixture_stat::where('team_id', $team)
                                                        ->where('player_id', $user_info->id)
                                                        ->latest()
                                                        ->get(); ?>
                                                    <table class="playerFullStatTable">
                                                        <?php $comp_stat = App\Models\Sport_stat::where('stat_type_id', 0)
                                                            ->where('is_calculated', 0)
                                                            ->whereIn('stat_type', [0, 2])
                                                            ->where('is_active', 1)
                                                            ->orderBy('must_track', 'DESC')
                                                            ->get(); ?>
                                                        <tr style="background-color:#003b5f; color: #ffffff;">
                                                            <td><a href="" target="_blank"
                                                                    style="color: #ffffff;"> Comp Name </a></td>
                                                            <td>Report type</td>
                                                            @foreach ($comp_stat as $stat_d)
                                                                <td> {{ $stat_d->name }} </td>
                                                            @endforeach
                                                        </tr>
                                                        @foreach ($player_matches->groupBy('competition_id') as $comp => $player_comp_stat)
                                                            <?php $player_comp = App\Models\Competition::find($comp); ?>
                                                            <tr>
                                                                <td class="FullStatCompCol"><a
                                                                        href="{{ URL::to('competition/' . $player_comp->id) }}"
                                                                        target="_blank"
                                                                        title="{{ $player_comp->name }}">
                                                                        @php echo Str::of($player_comp->name)->limit(7); @endphp <a /> </td>
                                                                <td style="background-color:#ddd;">
                                                                    @if ($player_comp->report_type == 1)
                                                                        Basic
                                                                    @else
                                                                        Detail
                                                                    @endif
                                                                </td>
                                                                @foreach ($comp_stat as $stat_d)
                                                                    <?php $player_stat_count = App\Models\Match_fixture_stat::where('player_id', $user_info->id)
                                                                        ->where('sport_stats_id', $stat_d->id)
                                                                        ->where('competition_id', $comp)
                                                                        ->count(); ?>
                                                                    @if ($player_stat_count > 0)
                                                                        <td
                                                                            style="background-color:#c0bdbd; color: #ffffff;">
                                                                            {{ $player_stat_count }} </td>
                                                                    @else
                                                                        <td> {{ $player_stat_count }} </td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        @endforeach

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@include('frontend.includes.footer')

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
<script type="text/javascript" src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js') }}"></script>
<script type="text/javascript" src="{{ url('frontend/js/jquery2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('frontend/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('frontend/js/script.js') }}"></script>
<script src="{{ url('frontend/js/owl.carousel.min.js') }}"></script>

<script src="{{ url('frontend/js/typeahead.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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


<style>
    .error {
        color: red;
    }

    .pac-container {
        z-index: 10000 !important;
    }
</style>
<script type="text/javascript">
    let items = document.querySelectorAll('.teamcarousel .carousel-item')
    items.forEach((el) => {
        const minPerSlide = 1
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                // wrap carousel by using first child
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })
</script>

<script type="text/javascript">
    $(' .owl_1').owlCarousel({
        loop: true,
        margin: 2,
        responsiveClass: true,
        autoplayHoverPause: true,
        autoplay: false,
        slideSpeed: 100,
        paginationSpeed: 400,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 5,
                nav: true,
                loop: false
            },
            600: {
                items: 8,
                nav: true,
                loop: false
            },
            1000: {
                items: 12,
                nav: true,
                loop: false
            }
        }
    }).trigger('to.owl.carousel', [parseInt(parseInt("{{ $centerIndex }}")), 50, true])
    $(document).ready(function() {
        var li = $(".owl-item li ");
        $(".owl-item li").click(function() {
            li.removeClass('active');
        });
    });
</script>
<script>
    $(document).on('click', '.carousel-control-prev', function() {
        var totalItems = $('.teamcarousel .carousel-item').length;
        var currentIndex = $('div.active').index() - 1;
        //$('.num').html('ssss' + currentIndex + '/' + totalItems + '');
        let compid1 = null;
        let firstIndexVal = null;
        let temp = $('.teamcarousel .carousel-item').map((index, el) => {
            if (index == 0) {
                firstIndexVal = el
            };
            if (index == parseInt(currentIndex)) {
                compid1 = $(el).attr('data-compid')
            };
            if (!compid1) {
                compid1 = $(firstIndexVal).attr('data-compid')
            };
        })
        var player_id = $('#player_id').val();
        var comp_id = compid1;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('player_p_my_stat') }}",
            method: "POST",
            data: {
                comp_id: comp_id,
                player_id: player_id
            },
            success: function(data) {
                $('#stat_data').html(data);

            },
            error: function() {
                alert('something went wrong');
            }
        });
    })
</script>
<script>
    $(document).on('click', '.carousel-control-next', function() {

        var totalItems = $('.teamcarousel .carousel-item').length;
        var currentIndex = $('div.active').index() + 1;
        //var comp_id = $('.teamcarousel .carousel-item').attr('data-compid');
        //$('.num').html('ssss' + currentIndex + '/' + totalItems + '');
        var compid1 = null;
        let firstIndexVal = null;
        let temp = $('.teamcarousel .carousel-item').map((index, el) => {
            if (index == 0) {
                firstIndexVal = el
            };
            if (index == parseInt(currentIndex)) {
                compid1 = $(el).attr('data-compid')
            };
            if (!compid1) {
                compid1 = $(firstIndexVal).attr('data-compid')
            };
        })
        //alert(compid1)

        var player_id = $('#player_id').val();
        var comp_id = compid1;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('player_p_my_stat') }}",
            method: "POST",
            data: {
                comp_id: comp_id,
                player_id: player_id
            },
            success: function(data) {
                $('#stat_data').html(data);
            },
            error: function() {
                alert('something went wrong');
            }
        });
    })
</script>
<script type="text/javascript">
    $('#mySelect2').select2({
        dropdownParent: $('.myModal'),
        placeholder: 'Select year(s)',
    });
    $('#editselect2').select2({
        dropdownParent: $('.editModal'),
        placeholder: "Select year(s)",
    });
</script>

<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script type="text/javascript">
    $("#addTrophy_form").on("click", function() {
        var title = $("#title").val();
        var team = $("#team").val();
        var yearselect = $('#mySelect2 > option:selected');
        var competition = $("#competition").val();
        var fileName = $("#imgInp").val();
        var at = 0;
        if (fileName == "") {
            at++;
            $("#imgInp_validate").html("Trophy / Award Image is required.");
        } else {
            var extFile = fileName.split('.').pop().toLowerCase();
            if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                $("#imgInp_validate").html("");
            } else {
                at++;
                $("#imgInp_validate").html("Only jpg,jpeg,png type images are accepted.");
            }
        }
        if (yearselect.length == 0) {
            $("#mySelect2_validate").html("Year is required.");
        } else {
            $("#mySelect2_validate").html("");
        }
        if (title == "") {
            at++;
            $("#title_validate").html("Trophy title is required.");
        } else {
            if (title.length > 250) {
                at++;
                $("#title_validate").html("Trophy title must not be greater than 250 characters.");
            } else {
                $("#title_validate").html("");
            }
        }
        if (team == "") {
            at++;
            $("#team_validate").html("Team Name is required.");
        } else {
            if (team.length > 250) {
                at++;
                $("#team_validate").html("Team name must not be greater than 250 characters.");
            } else {
                $("#team_validate").html("");
            }
        }
        if (competition == "") {
            at++;
            $("#competition_validate").html("Competition Name is required.");
        } else {
            if (competition.length > 250) {
                at++;
                $("#competition_validate").html("Competition name must not be greater than 250 characters.");
            } else {
                $("#competition_validate").html("");
            }
        }
        if (at == 0) {
            $('#add_trophy_cabinet').submit();
        }
    });

    $("#editTrophy_form").on("click", function() {
        var edit_title = $("#edit_title").val();
        var edityear = $('#editselect2 > option:selected');
        var edit_team = $("#edit_team").val();
        var edit_competition = $("#edit_competition").val();
        var fileimgName = $("#oldimg").val();
        var oldimage = $("prview1").attr('src');
        var et = 0;
        if (oldimage != "") {
            if (fileimgName != "") {
                var extFile = fileimgName.split('.').pop().toLowerCase();
                if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                    $("#oldimg_validate").html("");
                } else {
                    et++;
                    $("#oldimg_validate").html("Only jpg,jpeg,png type images are accepted.");
                }
            }
        }
        if (edityear.length == 0) {
            et++;
            $("#editselect2_validate").html("Year is required.");
        } else {
            $("#editselect2_validate").html("");
        }
        if (edit_title == "") {
            et++;
            $("#edit_title_validate").html("Trophy title is required.");
        } else {
            if (edit_title.length > 250) {
                et++;
                $("#edit_title_validate").html("Trophy title must not be greater than 250 characters.");
            } else {
                $("#edit_title_validate").html("");
            }
        }
        if (edit_team == "") {
            et++;
            $("#edit_team_validate").html("Team Name is required.");
        } else {
            if (edit_team.length > 250) {
                et++;
                $("#edit_team_validate").html("Team name must not be greater than 250 characters.");
            } else {
                $("#edit_team_validate").html("");
            }
        }
        if (edit_competition == "") {
            et++;
            $("#edit_competition_validate").html("Competition Name is required.");
        } else {
            if (edit_competition.length > 250) {
                et++;
                $("#edit_competition_validate").html(
                    "Competition name must not be greater than 250 characters.");
            } else {
                $("#edit_competition_validate").html("");
            }
        }
        if (et == 0) {
            $('#second_form').submit();
        }
    });
</script>
<script type="text/javascript">
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            prview.style.visibility = 'visible';

            prview.src = URL.createObjectURL(file)
        }
    }

    oldimg.onchange = evt => {
        const [file] = oldimg.files
        if (file) {
            prview1.src = URL.createObjectURL(file)
        }
    }
</script>
<script type="text/javascript">
    $('.owlfixturetable').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
        }
    })
</script>
</script>
<!-- Add script for tooltip 20-10-2022 -->
<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<script>
    $(document).on('click', '.edit_tophy', function() {
        var tophy_id = $(this).attr('data-id');
        //alert(tophy_id);
        $.ajax({
            type: 'GET',
            url: '{{ url('edittrophy_cabinet') }}/' + tophy_id,
            error: function() {
                alert('Something went wrong');
            },
            success: function(data) {
                $('#edit_trophy_modal').modal('show');
                $('#cabinet_id').val(data.editcabinet.id);
                $('#edit_title').val(data.editcabinet.title);
                $('#editselect2').val(data.select).trigger('change');
                $('#edit_team').val(data.editcabinet.team);
                $('#edit_competition').val(data.editcabinet.comp);
                <?php
                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                    $url = 'https://';
                } else {
                    $url = 'http://';
                }
                // Append the host(domain name, ip) to the URL.
                $url .= $_SERVER['HTTP_HOST'];
                ?>
                var trophyimage = "<?php echo $url; ?>/storage/app/public/image/" + data
                    .editcabinet.trophy_image;

                $('#oldimg').attr("value", trophyimage);
                $('.old_img').attr("src", trophyimage);

            }

        });
    })
</script>
@include('frontend.includes.searchScript')

<script>
    (function($) {
        $.fn.mySelectDropdown = function(options) {

            return this.each(function() {
                var $this = $(this);

                $this.each(function() {
                    var dropdown = $("<div />").addClass("f-dropdown selectDropdown");

                    if ($(this).is(':disabled'))
                        dropdown.addClass('disabled');

                    $(this).wrap(dropdown);

                    var label = $("<span />").append($("<span />")
                        .text($(this).attr("placeholder"))).insertAfter($(this));
                    var list = $("<ul />");

                    $(this)
                        .find("option")
                        .each(function() {
                            var compName = $(this).data('name');
                            var image = $(this).data('image');
                            if (image) {
                                list.append($("<li />").append(
                                    $("<a />").attr('data-val', $(this).val())
                                    .html(
                                        $("<span title='" + compName + "'/>")
                                        .append($(this).text())
                                    ).prepend('<img src="' + image + '" title="' +
                                        compName + '">')
                                ));
                            } else if ($(this).val() != '') {
                                list.append($("<li />").append(
                                    $("<a />").attr('data-val', $(this).val())
                                    .html(
                                        $("<span />").append($(this).text())
                                    )
                                ));
                            }
                        });

                    list.insertAfter($(this));

                    if ($(this).find("option:selected").length > 0 && $(this).find(
                            "option:selected").val() != '') {
                        list.find('li a[data-val="' + $(this).find("option:selected").val() +
                            '"]').parent().addClass("active");
                        $(this).parent().addClass("filled");
                        label.html(list.find("li.active a").html());
                    }
                });

                if (!$(this).is(':disabled')) {
                    $(this).parent().on("click", "ul li a", function(e) {
                        e.preventDefault();
                        var dropdown = $(this).parent().parent().parent();
                        var active = $(this).parent().hasClass("active");
                        var label = active ?
                            $('<span />').text(dropdown.find("select").attr("placeholder")) :
                            $(this).html();

                        dropdown.find("option").prop("selected", false);
                        dropdown.find("ul li").removeClass("active");

                        dropdown.toggleClass("filled", !active);
                        dropdown.children("span").html(label);

                        if (!active) {
                            dropdown
                                .find('option[value="' + $(this).attr('data-val') + '"]')
                                .prop("selected", true);
                            $(this).parent().addClass("active");
                            var player_id = $('#player_id').val();
                            var comp_id = dropdown.find(":selected").val();
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                url: "{{ url('player_p_my_stat') }}",
                                method: "POST",
                                data: {
                                    comp_id: comp_id,
                                    player_id: player_id
                                },
                                success: function(data) {
                                    $('#stat_data').html(data);
                                },
                                error: function() {
                                    alert('something went wrong');
                                }
                            });
                        }

                        dropdown.removeClass("open");
                    });

                    $this.parent().on("click", "> span", function(e) {
                        var self = $(this).parent();
                        self.toggleClass("open");
                    });

                    $(document).on("click touchstart", function(e) {
                        var dropdown = $this.parent();
                        if (dropdown !== e.target && !dropdown.has(e.target).length) {
                            dropdown.removeClass("open");
                        }
                    });
                }
            });
        };
    })(jQuery);

    $('select.f-dropdown').mySelectDropdown();
</script>
</body>

</html>
