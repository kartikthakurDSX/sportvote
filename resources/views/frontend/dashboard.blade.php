@include('frontend.includes.header')
<style>
    .font-medium.text-gray-500.bg-white.border.border-gray-300 {

        display: inline-block !important;
    }
</style>
<style>
    .processed {
        display: none;
    }
</style>

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
<div class="header-bottom dashboard">
    <div class="container-lg"
        style="background-image: url('{{ url('frontend/images/Player-Dashboard-bg.png') }}'); background-repeat: no-repeat;height: 86px;">
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                @if (!empty($is_player))
                    <div class="float-end">
                        <!-- <button class="btn " type="button"><i class="icon-cog fs1"></i></button> -->
                        <button class="btn btn-outline ms-auto br-5" type="button"
                            onclick="window.location.href='{{ url('player_profile') }}/{{ Auth::user()->id }}';"><i
                                class="green-text icon-edit"></i> <span class="hide-xs">View Public Profile</span>
                        </button>
                    </div>
                @else
                @endif
            </div>
        </div>
    </div>
</div>
<div class="dashboard-profile">
    <div class="container-lg">
        <div class="bg-white row">
            <div class="col-sm-12 position-relative">
                <a href="" class="user-profile-img" style="display:inline-flex" target="_blank"><img
                        src="{{ url('frontend/profile_pic') }}/{{ Auth::user()->profile_pic }}" class="img-fluid"
                        alt="profle-image"></a>
                <div class="w-auto user-profile-detail float-start">
                    <h1 class="Poppins"><strong class="User_Name-Text">{{ Auth::user()->first_name }}</strong>
                        {{ Auth::user()->last_name }}</h1>
                    <p class="Font-weight fanDashColorChnge"><span><i class="icon-map-marker"></i>
                            {{ Auth::user()->location }} </span> <span><i class="icon-calendar"></i> Joined SportVote
                            {{ Auth::user()->created_at->format('F Y') }}</span></p>
                </div>
                @livewire('user-friend-follow')
            </div>
        </div>
    </div>
</div>
</div> <!-- close div of site wrap i.e. on header page-->

<main id="main" class="dashboard-wrap Team-pub-pro Player-Dash Player-public-pro">
    <div class="container-lg">
        @if (!empty($is_player))
            @if ($player_stats->isNotEmpty())
                <div class="my-2 row my-stats" id="mystatdiv">
                    <div class="col-md-12">
                        <h1 class="Poppins-Fs30">My Stats <button class="btn fs1 float-end">
                                <i class="icon-more_horiz"></i>
                            </button>
                        </h1>
                    </div>
                    <div class="col-md-4 PR-0">
                        <div class="box-outer-lightpinkNewLeft">
                            <div>
                                <input type="hidden" value="" id="team_id_val">
                                <select class="vodiapicker" id="team_change">
                                    <?php $x = 0; ?>
                                    @foreach ($player_stats->groupBy('team_id') as $team => $stat)
                                        <?php $team_info = App\Models\Team::find($team);
                                        if ($x == 0) {
                                            $team_class = 'test';
                                        } else {
                                            $team_class = '';
                                        }
                                        ?>
                                        <option value="{{ $team_info->id }}" class="{{ $team_class }} "
                                            data-thumbnail="{{ url('frontend/logo') }}/{{ $team_info->team_logo }}">
                                            {{ $team_info->name }}
                                        </option>
                                        <?php $x++; ?>
                                    @endforeach
                                </select>
                                <div class="lang-select">
                                    <button class="btn-select" value=""></button>
                                    <div class="b">

                                        <ul id="a"></ul>
                                    </div>
                                </div>
                                <i class="fa fa-chevron-down fa-chevronStyle"></i>
                            </div>
                            <div id="carouselExampleControls" class="carousel slide compcarousel"
                                data-bs-ride="carousel" data-bs-interval="false">
                                <div class="text-center carousel-inner carousel-inner02" id="competition_silder">
                                    <?php $i = 0; ?>
                                    @foreach ($player_stats->groupBy('competition_id') as $comp => $stat)
                                        <?php
                                        if ($i == 0) {
                                            $class = 'active';
                                        } else {
                                            $class = '';
                                        }
                                        $comp_info = App\Models\Competition::find($comp); ?>
                                        <div class="carousel-item carousel-item02 CP {{ $class }}"
                                            data-compid="{{ $comp_info->id }}">
                                            <img class="rounded-circle"
                                                src="{{ url('frontend/logo') }}/{{ $comp_info->comp_logo }}"
                                                width="28%" alt="...">
                                            <a href="{{ url('competition/' . $comp) }}" target="_blank">
                                                <span class="TotallText" data-toggle="tooltip" data-placement="bottom"
                                                    title=""
                                                    data-original-title="{{ $comp_info->name }}">@php echo Str::of($comp_info->name)->limit(12); @endphp</span>
                                            </a>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 pl-0-desktop ">
                        <div class="box-outer-lightpinkNewRight W-auto-Scroll" id="ScrollBottom">
                            <div class="WidthMin768">
                                <div class="row StatPaddingTB" id="MyStat2of1">
                                    <div class="col-md-3 col-6 LineHeight ">
                                        <div class="D-inlineFlx">
                                            <div class="RedCr"></div>
                                            <p class="mb-0T">Team Stats</p>
                                        </div>
                                        <div class="D-inlineFlx">
                                            <div class="BlueCr"></div>
                                            <p class="mb-0T">My Stats</p>
                                        </div>
                                    </div>

                                    @if ($next_fixture_date == 'N/A')
                                        <div class="col-md-3 col-6 txtCenterMob LineHeight">Next<br>Match
                                            <span class="NAPlayerDas">N/A</span>
                                        </div>
                                    @else
                                        <div class="col-md-3 col-6 txtCenterMob LineHeight">Next Match
                                            <span class="stageReimsSize">
                                                <img src="{{ url('frontend/logo') }}/{{ $next_match_opp_team->team_logo }}"
                                                    class="img-fluid stageReims">
                                            </span>
                                            <p class="MatchDate">{{ $next_fixture_date }}</p>
                                        </div>
                                    @endif



                                    <div class="col-md-4 col-6 LineHeight">
                                        <div class="row">
                                            <div class="pr-4 col-md-4">
                                                <span class="SQUAD">SQUAD</span>
                                                <p class="PositionSquad">POSITION</p>
                                            </div>
                                            <div class="pl-0 col-md-8">
                                                <span class="StrickerTxt"
                                                    id="m_position">{{ $contract_jerseynum->member_position->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center col-md-2 col-6 LineHeight">
                                        <div class="row">
                                            <div class="pr-4 col-md-6">
                                                <span class="SQUAD">JERSEY</span>
                                                <p class="PositionSquad">NUMBER</p>
                                            </div>
                                            <div class="pl-0 col-md-6 ">
                                                <span class="JersyNo" id="j_num"
                                                    style="background-color:{{ $teamcolor }};">
                                                    <?php if (!empty($contract_jerseynum['jersey_number'])) {
                                                        echo $contract_jerseynum = str_pad($contract_jerseynum['jersey_number'], 2, '0', STR_PAD_LEFT);
                                                    } else {
                                                        echo '##';
                                                    } ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row PlyrAssetBg" id="MyStat2of2">
                                    <div class="col-md-1 width-7">
                                        <!-- Blank Div -->
                                    </div>
                                    <div class="text-center col-md-2 col-6 mobMrgRL">
                                        <div class="SpacingLine ">
                                            <div class="FiftyTwoPer">
                                                <div class="PlayedStyle" id="my_played"><?php echo str_pad($total_played->count(), 2, '0', STR_PAD_LEFT); ?></div>
                                                <strong class="Payed23"
                                                    id="all_played"><?php echo str_pad($player_played, 2, '0', STR_PAD_LEFT); ?></strong><span
                                                    class="PlayedUnderText" id="played_prec">{{ $played_prec }}%
                                                </span>
                                            </div>
                                            <p class="Playedcolor">Played</p>
                                        </div>
                                    </div>
                                    @foreach ($basic_stats as $stat)
                                        @if ($stat->id == 1)
                                            <?php
                                            $team_stat = App\Models\Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                                                ->whereIn('sport_stats_id', [1, 54])
                                                ->where('team_id', $first_player_stat->team_id)
                                                ->count();
                                            
                                            $my_stat = App\Models\Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                                                ->where('sport_stats_id', $stat->id)
                                                ->where('team_id', $first_player_stat->team_id)
                                                ->where('player_id', Auth::user()->id)
                                                ->count();
                                            if ($team_stat > 0) {
                                                $stat_precs = ($my_stat / $team_stat) * 100;
                                                $stat_prec = number_format($stat_precs, 2);
                                            } else {
                                                $stat_prec = '00.00';
                                            }
                                            ?>

                                            <div class="text-center col-md-2 col-6 mobMrgRL">
                                                <div class="SpacingLine">
                                                    <div class="FiftyTwoPer">
                                                        <div class="PlayedStyle"><?php echo str_pad($team_stat, 2, '0', STR_PAD_LEFT); ?></div>
                                                        <strong class="Payed23"><?php echo str_pad($my_stat, 2, '0', STR_PAD_LEFT); ?></strong>
                                                        <span
                                                            class="PlayedUnderText"><span>{{ $stat_prec }}</span>%</span>
                                                    </div>
                                                    <p class="Playedcolor">{{ $stat->description }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <?php
                                            $team_stat = App\Models\Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                                                ->where('sport_stats_id', $stat->id)
                                                ->where('team_id', $first_player_stat->team_id)
                                                ->count();
                                            
                                            $my_stat = App\Models\Match_fixture_stat::where('competition_id', $first_player_stat->competition_id)
                                                ->where('sport_stats_id', $stat->id)
                                                ->where('team_id', $first_player_stat->team_id)
                                                ->where('player_id', Auth::user()->id)
                                                ->count();
                                            if ($team_stat > 0) {
                                                $stat_precs = ($my_stat / $team_stat) * 100;
                                                $stat_prec = number_format($stat_precs, 2);
                                            } else {
                                                $stat_prec = '00.00';
                                            }
                                            ?>

                                            <div class="text-center col-md-2 col-6 mobMrgRL">
                                                <div class="SpacingLine">
                                                    <div class="FiftyTwoPer">
                                                        <div class="PlayedStyle"><?php echo str_pad($team_stat, 2, '0', STR_PAD_LEFT); ?></div>
                                                        <strong class="Payed23"><?php echo str_pad($my_stat, 2, '0', STR_PAD_LEFT); ?></strong>
                                                        <span class="PlayedUnderText"><span>
                                                                {{ $stat_prec }}</span>%</span>
                                                    </div>
                                                    <p class="Playedcolor">{{ $stat->description }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="col-md-1 width-7">
                                        <!-- Blank Div -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
        @else
        @endif
        <div class="my-1 row">
            <?php
            if (empty($is_player) && $is_team_admin < 1 && $is_comp_admin < 1) {
                $colclasss = 4;
            } elseif (empty($is_player) && $is_team_admin >= 1 && $is_comp_admin < 1) {
                $colclasss = 6;
            } elseif (empty($is_player) && $is_team_admin < 1 && $is_comp_admin >= 1) {
                $colclasss = 6;
            } elseif (empty($is_player) && $is_team_admin >= 1 && $is_comp_admin >= 1) {
                $colclasss = 12;
            } elseif (!empty($is_player) && $is_team_admin < 1 && $is_comp_admin < 1) {
                $colclasss = 6;
            } elseif (!empty($is_player) && $is_team_admin >= 1 && $is_comp_admin < 1) {
                $colclasss = 12;
            } elseif (!empty($is_player) && $is_team_admin < 1 && $is_comp_admin >= 1) {
                $colclasss = 12;
            } else {
                $colclasss = 'else';
            }
            //echo $colclasss.' Player-'.$is_player.' Admin-'.$is_team_admin.' Comp-'.$is_comp_admin ;
            // echo Auth::user()->p_box_player;
            // echo "<hr>";
            // echo Auth::user()->p_box_team;
            // echo "<hr>";
            // echo Auth::user()->p_box_comp;
            // echo "<pre>";
            //     print_r(Auth::user());
            //     echo "</pre>";
            ?>
            @if (Auth::user()->p_box_player == 0 && Auth::user()->p_box_team == 0 && Auth::user()->p_box_comp == 0)
                <div class="my-1 col-md-4 " id="playerdiv">
                    <div class="bg-green br-10 create-box">
                        <div class="row">
                            <a href="{{ url('player_profile') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Player Profile</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type= "player">&times;</button>
                                    <img src="{{ url('frontend/images/player_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="my-1 col-md-4" id="teamdiv">
                    <div class="bg-pink br-10 create-box">
                        <div class="row">
                            <a href="{{ url('team') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Sports Team</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                            </a>
                            <div class="col-4 ">
                                <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                    data-type= "team" id="cancel_team_div">&times;</button>
                                <img src="{{ url('frontend/images/noun_team_w.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-1 col-md-4" id="compdiv">
                    <div class="bg-blue br-10 create-box">
                        <div class="row"> <a href="{{ route('competition.create') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Competition </h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="comp" id="cancel_comp_div">&times;</button>
                                    <img src="{{ url('frontend/images/noun_fans_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player == 0 && Auth::user()->p_box_team == 0 && Auth::user()->p_box_comp != 0)
                <div class="my-1 col-md-6 " id="playerdiv">
                    <div class="bg-green br-10 create-box">
                        <div class="row">
                            <a href="{{ url('player_profile') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Player Profile</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="player">&times;</button>
                                    <img src="{{ url('frontend/images/player_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="my-1 col-md-6" id="teamdiv">
                    <div class="bg-pink br-10 create-box">
                        <div class="row">
                            <a href="{{ url('team') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Sports Team</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                            </a>
                            <div class="col-4 ">
                                <button class="text-white btn float-end fs1 close btn-sm close_p_box" data-type="team"
                                    id="cancel_team_div">&times;</button>
                                <img src="{{ url('frontend/images/noun_team_w.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player == 0 && Auth::user()->p_box_team != 0 && Auth::user()->p_box_comp == 0)
                <div class="my-1 col-md-6 " id="playerdiv">
                    <div class="bg-green br-10 create-box">
                        <div class="row">
                            <a href="{{ url('player_profile') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Player Profile</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="player">&times;</button>
                                    <img src="{{ url('frontend/images/player_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="my-1 col-md-6" id="compdiv">
                    <div class="bg-blue br-10 create-box">
                        <div class="row"> <a href="{{ route('competition.create') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Competition </h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="comp" id="cancel_comp_div">&times;</button>
                                    <img src="{{ url('frontend/images/noun_fans_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player == 0 && Auth::user()->p_box_team != 0 && Auth::user()->p_box_comp != 0)
                <div class="my-1 col-md-12 " id="playerdiv">
                    <div class="bg-green br-10 create-box">
                        <div class="row">
                            <a href="{{ url('player_profile') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Player Profile</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="player">&times;</button>
                                    <img src="{{ url('frontend/images/player_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player != 0 && Auth::user()->p_box_team == 0 && Auth::user()->p_box_comp == 0)
                <div class="my-1 col-md-6" id="teamdiv">
                    <div class="bg-pink br-10 create-box">
                        <div class="row">
                            <a href="{{ url('team') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Sports Team</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                            </a>
                            <div class="col-4 ">
                                <button class="text-white btn float-end fs1 close btn-sm close_p_box" data-type="team"
                                    id="cancel_team_div">&times;</button>
                                <img src="{{ url('frontend/images/noun_team_w.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-1 col-md-6" id="compdiv">
                    <div class="bg-blue br-10 create-box">
                        <div class="row"> <a href="{{ route('competition.create') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Competition </h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="comp" id="cancel_comp_div">&times;</button>
                                    <img src="{{ url('frontend/images/noun_fans_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player != 0 && Auth::user()->p_box_team == 0 && Auth::user()->p_box_comp != 0)
                <div class="my-1 col-md-12" id="teamdiv">
                    <div class="bg-pink br-10 create-box">
                        <div class="row">
                            <a href="{{ url('team') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Sports Team</h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                            </a>
                            <div class="col-4 ">
                                <button class="text-white btn float-end fs1 close btn-sm close_p_box" data-type="team"
                                    id="cancel_team_div">&times;</button>
                                <img src="{{ url('frontend/images/noun_team_w.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player != 0 && Auth::user()->p_box_team != 0 && Auth::user()->p_box_comp == 0)
                <div class="my-1 col-md-12" id="compdiv">
                    <div class="bg-blue br-10 create-box">
                        <div class="row"> <a href="{{ route('competition.create') }}">
                                <div class="col-8">
                                    <h3 class="text-bolder"><small>Create</small>Competition </h3>
                                    <p class="font-Arial">Profile for the sport you play to</p>
                                    <ul class="list-unstyled font-Arial">
                                        <li><a href="">- Join Teams</a></li>
                                        <li><a href="">- Showcase Career</a></li>
                                        <li><a href="">- Get Recognition</a></li>

                                    </ul>
                                </div>
                                <div class="col-4 ">
                                    <button class="text-white btn float-end fs1 close btn-sm close_p_box"
                                        data-type="comp" id="cancel_comp_div">&times;</button>
                                    <img src="{{ url('frontend/images/noun_fans_w.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->p_box_player != 0 && Auth::user()->p_box_team != 0 && Auth::user()->p_box_comp != 0)
            @else
            @endif
        </div>
        <div class="my-2 row request-status">
            @livewire('user-notification')
            @livewire('user-vote-intraction')
            @livewireScripts
        </div>
        <!-- Competition and team followed by user -->
        @if ($comp_follow->IsNotEmpty())
            <div class="row">
                <div class="col-lg-12">
                    <div class="px-3 py-3 my-3 box-outer-lightpink">
                        <div class="row">
                            <div class="text-left col-md-4 col-10">
                                <div class="follow-list">
                                    <h4>
                                        <label for="f_opt">
                                            <i class="icon-angle-down"></i>
                                        </label>
                                        <select class="custom-select follow_comp_team" name="f_opt">
                                            @if ($comp_follow->IsNotEmpty())
                                                <option class="CompitionStyle" value="1">
                                                    Competitions I follow
                                                </option>
                                            @endif
                                            @if ($team_follow->IsNotEmpty())
                                                <option value="2">Teams I follow </option>
                                            @endif
                                            @if ($player_follow->IsNotEmpty())
                                                <option value="3">Players I follow </option>
                                            @endif
                                        </select>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-8 col-2">
                                <button class="btn fs1 float-end">
                                    <i class="icon-more_horiz"></i>
                                </button>
                            </div>
                        </div>
                        <span id="follow_comp_team_data">
                            <ul class="comp-follow-slider owl-carousel">
                                @foreach ($comp_follow as $comp)
                                    <?php $comp_name = App\Models\Competition::find($comp->type_id); ?>
                                    <li>
                                        <a href="{{ url('competition/' . $comp_name->id) }}" target="_blank"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="{{ $comp_name->name }}"
                                            data-original-title="{{ $comp_name->name }}">
                                            <img src="{{ url('frontend/logo') }}/{{ $comp_name->comp_logo }}"
                                                class="rounded-circle">
                                            <h5 data-toggle="tooltip" data-placement="bottom"
                                                title="{{ $comp_name->name }}"
                                                data-original-title="{{ $comp_name->name }}">@php echo Str::of($comp_name->name)->limit(7); @endphp</h5>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </span>
                    </div>
                </div>
            </div>
        @else
        @endif
        <!-- End of Competition and team followed by user -->
        @if (!empty($is_player))
            <?php
            $teams = App\Models\Competition_attendee::where('attendee_id', Auth::user()->id)->pluck('team_id');
            $team_ids = array_values(array_unique($teams->toarray()));
            ?>
            @if (!empty($team_ids))
                <?php
                $fixtures = App\Models\Match_fixture::whereIn('teamOne_id', $team_ids)->OrwhereIn('teamTwo_id', $team_ids)->with('competition', 'teamOne', 'teamTwo')->get();
                $month_array = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                $l_fixtures_date = App\Models\Match_fixture::whereIn('teamOne_id', $team_ids)->OrwhereIn('teamTwo_id', $team_ids)->with('competition', 'teamOne', 'teamTwo')->latest()->first();
                if (!empty($l_fixtures_date)) {
                    $lastest_fixture_month = date('M', strtotime($l_fixtures_date->fixture_date));
                } else {
                    $lastest_fixture_month = '';
                }
                if (!empty($l_fixtures_date)) {
                    $lastest_fixture_year = date('Y', strtotime($l_fixtures_date->fixture_date));
                } else {
                    $lastest_fixture_year = '';
                }
                ?>
                @if ($fixtures->isNotEmpty())
                    <div class="row M-topSpace">
                        <div class="col-md-8 col-lg-8">
                            <!-- Ficture Calendar -->
                            <h1 class="Poppins-Fs30">Fixture Calendar <button class="btn fs1 float-end"><i
                                        class="icon-more_horiz"></i></button></h1>
                            <div class="box-outer-lightpink Team-Fixture">
                                <ul class="nav nav-tabs">
                                    <div class="owl_1 owl-carousel owl-theme">
                                        @foreach ($month_array as $month)
                                            <?php
                                            $i = 1;
                                            if (strtoupper($lastest_fixture_month) == $month) {
                                                $class = 'active';
                                                $link = $month . $i;
                                                $div_class = 'tab-pane fade in active';
                                            } else {
                                                $class = '';
                                                $div_class = 'tab-pane fade';
                                                $link = $month . $i;
                                            }
                                            ?>
                                            <div class="item">
                                                <li class="{{ $class }}" data-toggle="tab"
                                                    href="#{{ $link }}"><a>{{ $month }}<p>
                                                            {{ $lastest_fixture_year }}</p></a></li>
                                            </div>
                                        @endforeach
                                        {{-- <div class="item">
                                            <li class="{{ $class }}" data-toggle="tab"
                                                href="{{ $link }}"><a>Jan<p>2022</p>
                                                </a></li>
                                        </div> --}}
                                    </div>
                                </ul>
                                <div class="tab-content">

                                    @foreach ($month_array as $month)
                                        <?php
                                        $i = 1;
                                        if (strtoupper($lastest_fixture_month) == $month) {
                                            $class = 'active';
                                            $link = $month . $i;
                                            $div_class = 'tab-pane fade in active';
                                        } else {
                                            $class = '';
                                            $div_class = 'tab-pane fade';
                                            $link = $month . $i;
                                        }
                                        ?>
                                        <div id="{{ $link }}" class="{{ $div_class }}">
                                            <?php
                                            $msgarray = [];
                                            for ($t = 0; $t < count($team_ids); $t++) {
                                                //echo $team_ids[$t]."<br/>";
                                            
                                                $check_month = array_search($month, $month_array);
                                                $get_month = $check_month + 1;
                                                $tab_month = str_pad($get_month, 2, '0', STR_PAD_LEFT);
                                                //$current_month = date('m');
                                                $current_year = date('Y');
                                                $default_search = $current_year . '-' . $tab_month;
                                                $team_id = $team_ids[$t];
                                            
                                                $check_fixtures = App\Models\Match_fixture::where(function ($query) use ($team_id) {
                                                    $query->where('teamOne_id', '=', $team_id)->orWhere('teamTwo_id', '=', $team_id);
                                                })
                                                    ->where('fixture_date', 'like', '%' . $default_search . '%')
                                                    ->with('competition', 'teamOne', 'teamTwo')
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
                                                                <?php $Comp_type = App\Models\competition_type::find($fixture->competition->comp_type_id); ?>
                                                                <tr>
                                                                    <td class="FaCupClor">
                                                                        <a href="{{ url('competition/' . $fixture->competition->id) }}"
                                                                            target="_blank" data-toggle="tooltip"
                                                                            data-placement="bottom" title=""
                                                                            data-original-title="{{ $fixture->competition->name }}">
                                                                            @php echo Str::of($fixture->competition->name)->limit(7); @endphp</a>
                                                                    </td>
                                                                    <td class="RightPosiText ">
                                                                        <b class="WolVerWand"><a
                                                                                href="{{ url('team/' . $fixture->teamOne->id) }}"
                                                                                target="_blank"> @php echo Str::of($fixture->teamOne->name)->limit(7); @endphp
                                                                            </a></b>&nbsp;
                                                                        <div class="pp-pageHW"> <a
                                                                                href="{{ url('team/' . $fixture->teamOne->id) }}"><img
                                                                                    class="img-fluid"
                                                                                    src="{{ asset('frontend/logo') }}/{{ $fixture->teamOne->team_logo }}">
                                                                            </a></div>
                                                                    </td>
                                                                    <td class="BtnCentr">
                                                                        @if ($fixture->startdate_time == null)
                                                                            <button
                                                                                class="text-center btn btn-gray btn-xs-nb"
                                                                                wire:click="check_start_comp({{ $fixture->id }})"
                                                                                data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Competition Name: {{ $fixture->competition->name }}, Competition type: {{ $Comp_type->name }}, TeamOne: {{ $fixture->teamOne->name }}, TeamTwo: {{ $fixture->teamTwo->name }}">
                                                                                {{ date('H:i', strtotime($fixture->fixture_date)) }}</a></button>
                                                                        @else
                                                                            <?php $teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                                                                ->where('team_id', $fixture->teamOne_id)
                                                                                ->whereIn('sport_stats_id', [1, 54])
                                                                                ->get();
                                                                            $teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                                                                ->where('team_id', $fixture->teamTwo_id)
                                                                                ->whereIn('sport_stats_id', [1, 54])
                                                                                ->get(); ?>
                                                                            <a data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Competition Name: {{ $fixture->competition->name }}, Competition type: {{ $Comp_type->name }}, TeamOne: {{ $fixture->teamOne->name }}, TeamTwo: {{ $fixture->teamTwo->name }}">
                                                                                <span
                                                                                    class=" btn-greenFXL"><?php echo str_pad($teamOneGoal->count(), 2, 0, STR_PAD_LEFT); ?></span>
                                                                                <span
                                                                                    class=" btn-greenFXR"><?php echo str_pad($teamTwoGoal->count(), 2, 0, STR_PAD_LEFT); ?></span>
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                    <td class="LeftPosiText ">
                                                                        <a href="{{ url('team/' . $fixture->teamTwo->id) }}"
                                                                            target="_blank">
                                                                            <div class="pp-pageHW"><img
                                                                                    class="img-fluid"
                                                                                    src="{{ asset('frontend/logo') }}/{{ $fixture->teamTwo->team_logo }}">
                                                                            </div>
                                                                        </a>&nbsp;
                                                                        <a href="{{ url('team/' . $fixture->teamTwo->id) }}"
                                                                            target="_blank"> <b
                                                                                class="WolVerWand">@php echo Str::of($fixture->teamTwo->name)->limit(7); @endphp</b>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ url('match-fixture/' . $fixture->id) }}"
                                                                            target="_blank"> <span class="OnSun">On
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
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                @endif
            @else
            @endif
        @else
        @endif
        @if ($get_competitions->IsNotEmpty())
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <!-- Ficture Calendar -->
                    <div class="row">
                        <div class="pr-0 m-auto col-md-1 col-2 ">
                            <span class="championLeagueRounde ">
                                <?php $complogo = App\Models\Competition::select('comp_logo')->find($first_comp); ?>
                                <a href="{{ url('competition/' . $first_comp) }}" target="_blank" id="comp_link">
                                    <img class="rounded-circle img-fluid"
                                        src="{{ url('frontend/logo') }}/{{ $complogo->comp_logo }}" id="comp_icon">
                                </a>
                            </span>
                            <!-- <span class="icon-noun-s icon-noun-circle noun_Trophy"></span>  -->
                        </div>
                        <div class="p-0 m-auto col-md-6 col-9 ">
                            <div class="demo-Select">
                                <select class="Dropdown-Icon select_comp" id="comp_top_performer">
                                    @foreach ($get_competitions as $competition)
                                        <option {{ $competition->id == $first_comp ? 'selected' : '' }}
                                            value="{{ $competition->id }}">{{ $competition->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-1">
                            <h1 class="Poppins-Fs30">
                                <button class="btn fs1 float-end">
                                    <i class="icon-more_horiz"></i>
                                </button>
                            </h1>
                        </div>
                    </div>
                    @if ($first_comp_match_fixture->IsNotEmpty())
                        <div class="py-4 box-outer-lightpink w-100 ms-1 row " id="comp_matches">
                            <?php if($first_comp_match_fixture->count() <= 3){ ?>
                            <style>
                                .teams-box {
                                    border-bottom: none;
                                }
                            </style>
                            <?php } ?>
                            @foreach ($first_comp_match_fixture as $fixture)
                                <?php
                                // $winner_team = App\Models\Team::find($fixture->winner_team_id);
                                // $winner_team_id = $fixture->winner_team_id;
                                
                                if ($fixture->winner_team_id == 0) {
                                    $winner_team = App\Models\Team::find($fixture->teamOne_id);
                                    $winner_team_id = $fixture->teamOne_id;
                                } else {
                                    $winner_team = App\Models\Team::find($fixture->winner_team_id);
                                    $winner_team_id = $fixture->winner_team_id;
                                }
                                ?>
                                <?php
                                $winner_team_info = App\Models\Team::find($winner_team_id);
                                $winner_team_goal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                    ->where('team_id', $winner_team_id)
                                    ->whereIn('sport_stats_id', [1, 54])
                                    ->count();
                                if ($fixture->teamOne_id == $winner_team_id) {
                                    $opp_team = App\Models\Team::find($fixture->teamTwo_id);
                                    $opp_team_goal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                        ->where('team_id', $fixture->teamTwo_id)
                                        ->whereIn('sport_stats_id', [1, 54])
                                        ->count();
                                } else {
                                    $opp_team = App\Models\Team::find($fixture->teamOne_id);
                                    $opp_team_goal = App\Models\Match_fixture_stat::where('match_fixture_id', $fixture->id)
                                        ->where('team_id', $fixture->teamOne_id)
                                        ->whereIn('sport_stats_id', [1, 54])
                                        ->count();
                                }
                                $last_div = $first_comp_match_fixture->count() % 3;
                                ?>
                                @if ($last_div == 0)
                                    @if (
                                        $loop->index == $first_comp_match_fixture->count() - 1 ||
                                            $loop->index == $first_comp_match_fixture->count() - 2 ||
                                            $loop->index == $first_comp_match_fixture->count() - 3)
                                        <?php $c = 'bb-n'; ?>
                                    @else
                                        <?php $c = ''; ?>
                                    @endif
                                @elseif($last_div == 1)
                                    @if ($loop->index == $first_comp_match_fixture->count() - 1)
                                        <?php $c = 'bb-n'; ?>
                                    @else
                                        <?php $c = ''; ?>
                                    @endif
                                @elseif($last_div == 2)
                                    @if ($loop->index == $first_comp_match_fixture->count() - 1 || $loop->index == $first_comp_match_fixture->count() - 2)
                                        <?php $c = 'bb-n'; ?>
                                    @else
                                        <?php $c = ''; ?>
                                    @endif
                                @endif
                                <div class="col-md-4 teams-box {{ $c }}">
                                    <p class="win">
                                        <a href="{{ url('team/' . $winner_team_info->id) }}" target="_blank"> <img
                                                class="icon-thumb rounded-circle img-fluid"
                                                src="{{ url('frontend/logo') }}/{{ $winner_team_info->team_logo }}"
                                                width="10%"> </a>
                                        <a href="{{ url('match-fixture/' . $fixture->id) }}" target="_blank"
                                            class="competion_selector">{{ $winner_team_info->name }} <span
                                                class="score">{{ $winner_team_goal }} </span></a>
                                    </p>
                                    <p>
                                        <a href="{{ url('team/' . $opp_team->id) }}" target="_blank"> <img
                                                class="icon-thumb rounded-circle img-fluid"
                                                src="{{ url('frontend/logo') }}/{{ $opp_team->team_logo }}"
                                                width="10%"> </a>
                                        <a href="{{ url('match-fixture/' . $fixture->id) }}" target="_blank"
                                            class="competion_selector">{{ $opp_team->name }} <span
                                                class="score">{{ $opp_team_goal }}</span></a>
                                    </p>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="py-4 box-outer-lightpink w-100 ms-1 row " id="comp_matches">
                            <p class="text-center"> No Data Found </p>
                        </div>
                    @endif
                </div>
                @if ($first_comp_match_fixture->IsNotEmpty())
                    <div class="col-md-4">
                        <h1 class="Poppins-Fs30">Top Performers <button class="btn fs1 float-end">
                                <i class="icon-more_horiz"></i>
                            </button>
                        </h1>
                        <div id="comp_top_performer_list">
                            <?php
							$player_stats = App\Models\Match_fixture_stat::where('competition_id',$first_comp)->whereIn('sport_stats_id',[0,1])->get();
							$top_player_goal = $player_stats->groupBy('player_id');
							$playerids = array();
							foreach($top_player_goal  as $top_player => $stat)
							{
								$playerids[$top_player] = $stat->count();
							}
							arsort($playerids);
							$stat_count_key = array_keys($playerids);
							if(count($stat_count_key) > 3)
							{
								$counter = 3;
							}
							else
							{
								$counter = count($stat_count_key);
							}
							for($tp = 0; $tp < $counter; $tp++){
								$playerid = $stat_count_key[$tp];
								$playergoal = $playerids[$playerid];
								$player = App\Models\user::find($playerid);
								$sport_stat = App\Models\Sport_stat::whereIn('stat_type_id',[0,1])->whereIn('stat_type',[0,1])->where('id','!=',1)->where('is_active',1)->get();
								$comp_attend = App\Models\Competition_attendee::where('attendee_id',$player->id)->get();
								$game_played = 0;
								foreach($comp_attend as $comp)
								{
									$team_id = $comp->team_id;
									$check_fixtures = App\Models\Match_fixture::where(function ($query) use ($team_id) {
										$query->where('teamOne_id', '=', $team_id)
										->orWhere('teamTwo_id', '=', $team_id);
										})->where('finishdate_time', '!=', NULL)->where('competition_id',$comp->Competition_id)->count();
									if($check_fixtures > 0)
									{
										$game_played++;
									}
								}
								$player_belong_team = App\Models\Competition_attendee::where('Competition_id',$first_comp)->where('attendee_id',$playerid)->first();
								$team = App\Models\Team::find($player_belong_team->team_id);
							?>
                            <style>
                                .performer-goal.green-bg-<?php echo $tp; ?>:after {
                                    background: <?php echo $team->team_color; ?>;
                                }

                                .performer-player-img.green-bg-<?php echo $tp; ?>:after {
                                    background: <?php echo $team->team_color; ?>;
                                }
                            </style>
                            <div class="top-performer-box w-100 d-flex">
                                <div
                                    class="performer-goal green-bg-{{ $tp }} position-relative col-md-3 pt-2 pe-4">
                                    <h2>{{ $playergoal }}<span>Goals</span>
                                    </h2>
                                    <a href="{{ url('team/' . $team->id) }}" target="_blank" class="ic-logo">
                                        <img class="rounded-circle"
                                            src="{{ url('frontend/logo') }}/{{ $team->team_logo }}"> </a>
                                </div>
                                <div class="performer-detail green-bg-{{ $tp }} col-md-5 py-2"
                                    style="background:{{ $team->team_color }}!important;">
                                    <div class="content-pos">
                                        <h5>
                                            <a href="{{ url('player_profile/' . $player->id) }}"
                                                target="_blank">{{ $player->first_name }}
                                                {{ $player->last_name }}</a>
                                        </h5>
                                        <ul class="list-unstyled">
                                            <?php
                                            $player_team = $team->id;
                                            $game_played = App\Models\Match_fixture::select('id')
                                                ->where(function ($query) use ($player_team) {
                                                    $query->where('teamOne_id', '=', $player_team)->orWhere('teamTwo_id', '=', $player_team);
                                                })
                                                ->where('competition_id', $first_comp)
                                                ->where('fixture_type', '!=', 9)
                                                ->where('finishdate_time', '!=', null)
                                                ->get();
                                            $fixture_ids = [];
                                            foreach ($game_played as $fixture) {
                                                $fixture_ids[] = $fixture->id;
                                            }
                                            $game_started = App\Models\Fixture_squad::whereIn('match_fixture_id', $fixture_ids)
                                                ->where('player_id', $player->id)
                                                ->count();
                                            ?>
                                            <li>{{ $game_played->count() }} Games Played</li>
                                            <li>{{ $game_started }} Games Started</li>
                                            @foreach ($sport_stat as $stat)
                                                <?php $stat_count = App\Models\Match_fixture_stat::where('player_id', $player->id)
                                                    ->where('competition_id', $first_comp)
                                                    ->where('sport_stats_id', $stat->id)
                                                    ->get(); ?>
                                                <li>{{ $stat_count->count() }} {{ $stat->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div
                                    class="performer-player-img green-bg-{{ $tp }} position-relative col-md-4 ">
                                    <div class="overflow-hidden w-100 br-right-0">
                                        <a href="{{ url('player_profile/' . $player->id) }}" target="_blank"> <img
                                                src="{{ url('frontend/profile_pic') }}/{{ $player->profile_pic }}"
                                                alt="player" class="img-fluid"> </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                @else
                    <div class="col-md-4">
                        <h1 class="Poppins-Fs30">Top Performers <button class="btn fs1 float-end">
                                <i class="icon-more_horiz"></i>
                            </button>
                        </h1>
                        <div id="comp_top_performer_list">
                            <p class="text-center">No data found</p>
                        </div>
                    </div>
                @endif
            </div>
        @else
        @endif
    </div>
</main>

@include('frontend.includes.footer')

<script src="{{ url('frontend/js/popper.min.js') }}"></script>
<script src="{{ url('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('frontend/js/jquery.circlechart.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap2.bundle.min.js') }}"></script>


<!-- Add script for tooltip 20-10-2022 -->
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
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

<script type="text/javascript">
    $('.demo1').percentcircle({
        animate: false,
        diameter: 130,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#37C501',
        percentSize: '15px',
        percentWeight: 'normal'

    });
    $('.demo2').percentcircle({

        animate: false,
        diameter: 130,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#025e99',
        percentSize: '15px',
        percentWeight: 'normal'

    });

    $('.demo3').percentcircle({

        animate: false,
        diameter: 130,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#FF2052',
        percentSize: '15px',
        percentWeight: 'normal'

    });
</script>
<!-- Fixture calendar -->

<script type="text/javascript">
    $(' .owl_1').owlCarousel({
        loop: false,
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
    })

    $(document).ready(function() {
        var li = $(".owl-item li ");
        $(".owl-item li").click(function() {
            li.removeClass('active');
        });
    });
</script>

<script type="text/javascript">
    var langArray = [];
    $('.vodiapicker option').each(function() {
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var team_id = $('#team_id_val').val(value);
        var item = '<li value="' + value + '"><img src="' + img + '" alt="" value="' + value + '"/><span>' +
            text + '</span></li>';
        langArray.push(item);
    })

    $('#a').html(langArray);

    //Set the button value to the first el of the array
    $('.btn-select').html(langArray[0]);
    $('.btn-select').attr('value', 'en');

    //change button stuff on click
    $('#a li').click(function() {
        var img = $(this).find('img').attr("src");
        var value = $(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
        $('.btn-select').html(item);
        $('.btn-select').attr('value', value);
        $(".b").toggle();
        //console.log(value);
    });

    $(".btn-select").click(function() {
        $(".b").toggle();
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem('lang');
    if (sessionLang) {
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $('.btn-select').html(langArray[langIndex]);
        $('.btn-select').attr('value', sessionLang);
    } else {
        var langIndex = langArray.indexOf('ch');

        $('.btn-select').html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).on('click', '.close_p_box', function() {
        var type = $(this).data('type');
        // alert(type);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('remove_p_boxes') }}',
            type: 'post',
            data: {
                type: type
            },
            error: function() {

            },
            success: function(response) {
                $('#' + type + 'div').remove();
            }
        });
    });
</script>
<script>
    $(document).on('click', '.carousel-control-next', function() {
        var totalItems = $('.compcarousel .carousel-item').length;
        var currentIndex = $('div.active').index() + 1;
        //alert(currentIndex);
        var compid1 = null;
        let firstIndexVal = null;
        let temp = $('.compcarousel .carousel-item').map((index, el) => {
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
        var comp_id = compid1;
        var team_id = $('#team_id_val').val();
        console.log({
            team_id: team_id,
            comp_id: comp_id,
            currentIndex: currentIndex
        })
        //alert(team_id);

        //alert(comp_id+'tema_id'+team_id );
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('get_comp_my_stat_pd') }}",
            method: "POST",
            data: {
                team_id: team_id,
                comp_id: comp_id
            },
            success: function(data) {
                $('#MyStat2of2').html(data);
            },
            error: function() {
                alert('something went wrong');
            }
        });
    })
</script>
<script>
    $(document).on('click', '.carousel-control-prev', function() {
        var totalItems = $('.compcarousel .carousel-item').length;
        if ($('div.active').index() == 0) {
            var currentIndex = totalItems - 1;
        } else {
            var currentIndex = $('div.active').index() - 1;
        }
        var compid1 = null;
        let firstIndexVal = null;
        let temp = $('.compcarousel .carousel-item').map((index, el) => {
            if (index == el.length) {
                firstIndexVal = el
            };
            if (index == parseInt(currentIndex)) {
                compid1 = $(el).attr('data-compid')
            };
            if (!compid1) {
                compid1 = $(firstIndexVal).attr('data-compid')
            };
        })
        var comp_id = compid1;
        var team_id = $('#team_id_val').val();
        console.log({
            team_id: team_id,
            comp_id: comp_id,
            currentIndex: currentIndex
        })
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('get_comp_my_stat_pd') }}",
            method: "POST",
            data: {
                team_id: team_id,
                comp_id: comp_id
            },
            success: function(data) {
                $('#MyStat2of2').html(data);
            },
            error: function() {
                alert('something went wrong');
            }
        });


    })
</script>
<script>
    $(document).on('change', '.follow_comp_team', function() {
        var val = $(this).val();
        //alert(val);
        $.ajax({
            url: "{{ url('team_comp_follow') }}",
            type: 'get',
            error: function() {
                //alert('Something is Wrong');
            },
            success: function(response) {
                if (val == 2) {

                    list = "<ul class='comp-follow-slider owl-carousel'>";
                    if (response.team_follow.length > 0) {
                        $.each(response.team_follow, function(i, item) {
                            var teamId = item.team.id;
                            var string = item.team.name;
                            let t_name = string.substring(0, 7) + "...";
                            list += '<li><a href="{{ URL('team') }}/' + teamId +
                                '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="' +
                                item.team.name +
                                '"><img src="{{ url('frontend/logo') }}/' + item.team
                                .team_logo +
                                '" class="rounded-circle" > <h5 data-toggle="tooltip" data-placement="bottom" title="' +
                                item.team.name + '" data-original-title="' + item.team
                                .name + '">' + t_name + '</a></h5 > </li>';
                        });
                        list += "</ul>";
                    } else {
                        list += "<h5 class='text-center'> No data found! </h5>";
                    }
                    $('#follow_comp_team_data').html(list);
                } else if (val == 3) {
                    list = "<ul class='comp-follow-slider owl-carousel'>";
                    if (response.player_follow.length > 0) {
                        $.each(response.player_follow, function(i, item) {
                            var teamId = item.player.id;
                            var string = item.player.first_name + ' ' + item.player
                                .last_name;
                            let t_name = string.substring(0, 7) + "...";
                            list += '<li><a href="{{ URL('player_profile') }}/' + teamId +
                                '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="' +
                                item.player.first_name + ' ' + item.player.last_name +
                                '"><img src="{{ url('frontend/profile_pic') }}/' + item
                                .player.profile_pic +
                                '" class="rounded-circle" > <h5 data-toggle="tooltip" data-placement="bottom" title="' +
                                item.player.first_name + ' ' + item.player.last_name +
                                '" data-original-title="' + item.player.first_name + ' ' +
                                item.player.last_name + '">' + t_name + '</a></h5 > </li>';
                        });
                        list += "</ul>";
                    } else {
                        list += "<h5 class='text-center'> No data found! </h5>";
                    }
                    $('#follow_comp_team_data').html(list);
                } else {
                    list = "<ul class='comp-follow-slider owl-carousel'>";
                    if (response.comp_follow.length > 0) {
                        $.each(response.comp_follow, function(i, item) {
                            var compId = item.comp.id;
                            var string = item.comp.name;
                            let c_name = string.substring(0, 7) + "...";
                            list += '<li><a href="{{ url('competition') }}/' + compId +
                                '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="' +
                                item.comp.name + '" data-original-title="' + item.comp
                                .name + '"><img src="{{ url('frontend/logo') }}/' + item
                                .comp.comp_logo +
                                '" class="rounded-circle"> <h5 data-toggle="tooltip" data-placement="bottom" title="' +
                                item.comp.name + '" data-original-title="' + item.comp
                                .name + '">' + c_name + '</a></h5></li>';

                        });
                        list += "</ul>"
                    } else {
                        list += "<h5 class='text-center'> No data found! </h5>";
                    }

                    $('#follow_comp_team_data').html(list);

                }
                $(' .comp-follow-slider').owlCarousel({
                    loop: false,
                    margin: 2,
                    responsiveClass: true,
                    autoplayHoverPause: true,
                    autoplay: false,
                    slideSpeed: 100,
                    paginationSpeed: 400,
                    autoplayTimeout: 3000,
                    responsive: {
                        0: {
                            items: 2
                        },
                        600: {
                            items: 6
                        },
                        1000: {
                            items: 9
                        }

                    }
                })
            }
        });
    });
</script>
<script>
    $(document).on('change', '#comp_top_performer', function() {
        var comp_id = $(this).val();
        //alert(comp_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('top_performaer') }}",
            method: "POST",
            data: {
                comp_id: comp_id
            },
            success: function(data) {

                if (data.matches_div.length > 0) {
                    html = '';
                    $.each(data.matches_div, function(item, itemdata) {
                        html += itemdata;
                    });
                    $('#comp_matches').html(html);
                    if (data.matches_div.length <= 3) {
                        $(".teams-box").css("border-bottom", "none");
                    }
                } else {
                    html = '<p class="text-center"> No data found </p>';
                    $('#comp_matches').html(html);
                }
                if (data.top_performer.length > 0) {
                    html1 = '';
                    $.each(data.top_performer, function(item, value) {
                        html1 += value;
                    });
                    $('#comp_top_performer_list').html(html1);
                } else {
                    html1 = '<p class="text-center"> No data found </p>';
                    $('#comp_top_performer_list').html(html1);

                }
            },
            error: function() {
                alert('something went wrong');
            }
        });
    })
</script>
<script>
    $(document).on('change', '.select_comp', function() {
        var comp_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('get_comp_logo') }}",
            method: "POST",
            data: {
                comp_id: comp_id
            },
            success: function(data) {
                $('#comp_icon').attr('src', data.comp_logo)
                $('#comp_link').attr('href', data.comp_link)
            },
            error: function() {
                alert('something went wrong');
            }
        });
    })
</script>
<script type="text/javascript">
    const select = document.querySelector('#comp_top_performer')
    select.addEventListener('change', (event) => {
        let tempSelect = document.createElement('select'),
            tempOption = document.createElement('option');

        tempOption.textContent = event.target.options[event.target.selectedIndex].text;
        tempSelect.style.cssText += `
		visibility: hidden;
		position: fixed;
		`;
        tempSelect.appendChild(tempOption);
        event.target.after(tempSelect);

        const tempSelectWidth = tempSelect.getBoundingClientRect().width;
        event.target.style.width = `${tempSelectWidth}px`;
        tempSelect.remove();
    });
    select.dispatchEvent(new Event('change'));
</script>
<script type="text/javascript">
    $(' .comp-follow-slider').owlCarousel({
        loop: false,
        margin: 2,
        responsiveClass: true,
        autoplayHoverPause: true,
        autoplay: false,
        slideSpeed: 100,
        paginationSpeed: 400,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 6
            },
            1000: {
                items: 9
            }

        }
    })
</script>



@include('frontend.includes.searchScript')
</body>

</html>
