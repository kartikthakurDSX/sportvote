@include('frontend.includes.header')

<body>

    <div class="site-wrap">

        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>


        <section class="" id="banner-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img src="{{ url('frontend/images/banner-Updated.jpg') }}" class="img-fluid">
                    </div>
                </div>
                <div class="container EmailSection">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="FormBG">

                                <form class="FooterForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-Clor" placeholder="Enter Email "
                                            value="" id="user_email"
                                            style="border-bottom:1px solid;border-radius: 0; " autocomplete="off">

                                        <div class="input-group-btn ">
                                            <button type="submit" class="btn btn-submit-group B-Radios"
                                                id="join_now_home" style="color:white">Join Now/ Login</button>
                                            <!-- <a class="btn btn-pink nav-link " data-bs-toggle="modal" data-bs-target="#joinModal"> Join Now</a> -->
                                        </div>

                                    </div>
                                    <div class="sv_error">
                                        <span id="user_email_home_error"></span>
                                    </div>
                                </form>

                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6"></div>
                    </div>
                </div>

            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 header-slider">
                        <h1>Top 10 Recent Competitions</h1>

                    </div>
                    <div class="col-lg-12">
                        <ul class="top-comp-tab nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach ($competitions as $comp)
                                <li>
                                   <a href="" class="tabLink" data-bs-toggle="tab" data-bs-target="#tab{{     $comp->id }}"
                                        type="button" role="tab" aria-controls="home" aria-selected="true"
                                        id="top_comp" data-id="{{ $comp->id }}">
                                        <img src="{{ url('frontend/logo') }}/{{ $comp->comp_logo }}"
                                            class="rounded-circle" loading="lazy">

                                        <h5>{{ $comp->name }}</h5>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @php $loopCount = 0; @endphp

                            @foreach ($competitions as $comp)
                                <?php $comp_info = App\Models\Competition::find($comp->id);
                                $matches = App\Models\Match_fixture::where('competition_id', $comp->id)
                                    ->where('fixture_type', 2)
                                    ->where('finishdate_time', '!=', null)
                                    ->get();
                                    if($loopCount == 0){
                                ?>
                                <div class="tab-pane fade show <?php if ($loop->first) {
                                    echo 'active';
                                } ?> " id="tab{{ $comp->id }}"
                                    role="tabpanel" aria-labelledby="tab1">
                                    <div class="">
                                        <div class="row my-3">
                                            <div class="col-md-8 col-lg-8">
                                                <div class="row">
                                                    <div class="col-md-1 m-auto col-2 pr-0 ">
                                                        <span class="championLeagueRounde ">
                                                            <a href="{{ url('competition') }}/{{ $comp->id }}"
                                                                target="_blank"> <img class="rounded-circle img-fluid"
                                                                    src="{{ url('frontend/logo') }}/{{ $comp_info->comp_logo }}"
                                                                    loading="lazy"> </a>
                                                        </span>
                                                        <!-- <span class="icon-noun-s icon-noun-circle noun_Trophy"></span>  -->
                                                    </div>
                                                    <div class="col-md-11 col-10 m-auto p-0 ">
                                                        <a href="{{ url('competition') }}/{{ $comp->id }}"
                                                                target="_blank" class="text-secondary">
                                                        <h1>
                                                            @php echo Str::of($comp_info->name)->limit(20); @endphp
                                                            <!-- <span class="float-end  date-com mt-4"><i class="icon-calendar"></i> Thursday, 15 July 2021</span> -->
                                                        </h1>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="box-outer-white  row  py-4 matchDetails">
                                                    <?php $i = 0; ?>
                                                    @if ($matches->isNotEmpty())
                                                        @foreach ($matches as $match)
                                                            <?php $winner_team = App\Models\Team::find($match->winner_team_id);
                                                            $winner_team_goals = App\Models\Match_fixture_stat::where('match_fixture_id', $match->id)
                                                                ->where('team_id', $winner_team->id)
                                                                ->where('sport_stats_id', 1)
                                                                ->count();
                                                            if ($winner_team->id == $match->teamOne_id) {
                                                                $opp_team = $match->teamTwo_id;
                                                            } else {
                                                                $opp_team = $match->teamOne_id;
                                                            }
                                                            $opp_team_info = App\Models\Team::find($opp_team);
                                                            $opp_team_goals = App\Models\Match_fixture_stat::where('match_fixture_id', $match->id)
                                                                ->where('team_id', $opp_team_info->id)
                                                                ->where('sport_stats_id', 1)
                                                                ->count();

                                                            $last_div = $matches->count() % 3;
                                                            if ($last_div == 0) {
                                                                if ($i == $matches->count() - 1 || $i == $matches->count() - 2 || $i == $matches->count() - 3) {
                                                                    $c = 'bb-n';
                                                                } else {
                                                                    $c = '';
                                                                }
                                                            } elseif ($last_div == 1) {
                                                                if ($i == $matches->count() - 1) {
                                                                    $c = 'bb-n';
                                                                } else {
                                                                    $c = '';
                                                                }
                                                            } elseif ($last_div == 2) {
                                                                if ($i == $matches->count() - 1 || $i == $matches->count() - 2) {
                                                                    $c = 'bb-n';
                                                                } else {
                                                                    $c = '';
                                                                }
                                                            }
                                                            ?>
                                                            <div class="col-md-4 teams-box {{ $c }}">
                                                                <p class="win"><a
                                                                        href="{{ url('team/' . $winner_team->id) }}"
                                                                        target="_blank"><img class="icon-thumb"
                                                                            src="{{ url('frontend\logo') }}\{{ $winner_team->team_logo }}"
                                                                            width="10%" loading="lazy">
                                                                        {{ $winner_team->name }} <span
                                                                            class="score">{{ $winner_team_goals }}</span></a>
                                                                </p>
                                                                <p><a href="{{ url('team/' . $opp_team_info->id) }}"
                                                                        target="_blank"><img class="icon-thumb"
                                                                            src="{{ url('frontend\logo') }}\{{ $opp_team_info->team_logo }}"
                                                                            width="10%" loading="lazy">
                                                                        {{ $opp_team_info->name }} <span
                                                                            class="score">{{ $opp_team_goals }}</span></a>
                                                                </p>
                                                            </div>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                    @else
                                                        <p> No Data Found!</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h1>Top Players <button class="btn fs1 float-end"><i
                                                            class="icon-more_horiz"></i></button></h1>

                                                @if ($matches->isNotEmpty())
                                                    <div class="comp_top_performer_list">
                                                        <?php
                                                            $player_stats = App\Models\Match_fixture_stat::where('competition_id',$first_competition->id)->where('sport_stats_id',1)->get();
                                                            $top_player_goal = $player_stats->groupBy('player_id');
                                                            $playerids = array();
                                                            foreach($top_player_goal  as $top_player => $stat)
                                                            {
                                                                // $playerids[$stat->count()] = $top_player;
                                                                $playerids[$top_player] = $stat->count();
                                                            }
                                                            // krsort($playerids);
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
                                                            for($tp = 0 ; $tp < $counter; $tp++)
                                                            {
                                                                $playerid = $stat_count_key[$tp];
                                                                $playergoal = $playerids[$playerid];

                                                                // $playergoal = $stat_count_key[$tp];
                                                                // $playerid = $playerids[$playergoal];
                                                                $player = App\Models\User::find($playerid);
                                                                $sport_stat = App\Models\Sport_stat::whereIn('stat_type_id',[0,1])->whereIn('stat_type',[0,1])->where('id','!=',1)->where('is_active',1)->get();

                                                                $comp_attend = App\Models\Competition_attendee::where('attendee_id',$player->id)->get();
                                                                $game_played = 0;
                                                                foreach($comp_attend as $comp)
                                                                {
                                                                    $team_id = $comp->team_id;
                                                                    $check_fixtures = App\Models\Match_fixture::where(function ($query) use ($team_id) {
                                                                        $query->where('teamOne_id', '=', $team_id)
                                                                        ->orWhere('teamTwo_id', '=', $team_id);
                                                                        })->where('finishdate_time', '!=', NULL)->where('competition_id',$first_competition->id)->count();
                                                                    if($check_fixtures > 0)
                                                                    {
                                                                        $game_played++;
                                                                    }
                                                                }
                                                                $player_belong_team = App\Models\Competition_attendee::where('Competition_id',$first_competition->id)->where('attendee_id',$playerid)->first();
                                                                $team = App\Models\Team::find($player_belong_team->team_id);

                                                                $player_stat_count = array();
                                                                foreach($sport_stat as $stat)
                                                                    {
                                                                        $stat_count = App\Models\Match_fixture_stat::where('competition_id',$first_competition->id)->where("player_id",$player->id)->where("sport_stats_id",$stat->id)->get();
                                                                        $player_stat_count[] = '<li>'.$stat_count->count().' '.$stat->description;

                                                                    }
                                                                    $player_team = $team->id;
                                                                    $game_played = App\Models\Match_fixture::select('id')->where(function ($query) use ($player_team) {
                                                                                            $query->where('teamOne_id', '=', $player_team)
                                                                                            ->orWhere('teamTwo_id', '=', $player_team);
                                                                                            })->where('competition_id',$first_competition->id)->where('fixture_type','!=',9)->where('finishdate_time','!=',Null)->get();
                                                                    $fixture_ids = array();
                                                                    $game_started_fixture = App\Models\Match_fixture::select('id')->where(function ($query) use ($player_team) {
                                                                        $query->where('teamOne_id', '=', $player_team)
                                                                        ->orWhere('teamTwo_id', '=', $player_team);
                                                                        })->where('competition_id',$first_competition->id)->where('fixture_type','!=',9)->where('startdate_time','!=',Null)->get();

                                                                    foreach($game_started_fixture as $fixture)
                                                                    {
                                                                        $fixture_ids[] = $fixture->id;
                                                                    }
                                                                    $game_started = App\Models\Fixture_squad::whereIn('match_fixture_id',$fixture_ids)->where('player_id',$player->id)->count();
                                                                $cal_stat = ['<li>'.$game_played->count().' Games Played','<li>'.$game_started.' Games Started'];
                                                                $array_merge = array_merge($cal_stat,$player_stat_count);

                                                                $imploadallstate = implode('</li>', $array_merge);

                                                                ?>

                                                                    <style>
                                                                        .performer-goal.green-bg-<?php echo $team->id; ?>:after {
                                                                            background: <?php echo $team->team_color; ?>;
                                                                        }

                                                                        .performer-player-img.green-bg-<?php echo $team->id; ?>:after {
                                                                            background: <?php echo $team->team_color; ?>;
                                                                        }
                                                                    </style>

                                                                    <div class="top-performer-box w-100 d-flex">
                                                                        <div
                                                                            class="performer-goal green-bg-<?php echo $team->id; ?> position-relative col-md-3 pt-2 pe-4">
                                                                            <h2><?php echo $playergoal; ?><span>Goals</span>
                                                                            </h2>
                                                                            <a href="<?php echo url('team'); ?>/<?php echo $team->id; ?>"
                                                                                class="ic-logo" target="_blank">
                                                                                <img class="rounded-circle"
                                                                                    src="<?php echo url('frontend/logo'); ?>/<?php echo $team->team_logo; ?>"
                                                                                    loading="lazy">
                                                                            </a>
                                                                        </div>
                                                                        <div class="performer-detail  col-md-5 py-2"
                                                                            style="background:<?php echo $team->team_color; ?> !important;">
                                                                            <div class="content-pos">
                                                                                <h5>
                                                                                    <a href="<?php echo url('player_profile'); ?>/<?php echo $player->id; ?>"
                                                                                        target="_blank"><?php echo $player->first_name; ?>
                                                                                        <?php echo $player->last_name; ?></a>
                                                                                </h5>
                                                                                <ul class="list-unstyled player_stat_count">
                                                                                    <?php echo $imploadallstate; ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="performer-player-img green-bg-<?php echo $team->id; ?> position-relative col-md-4 ">
                                                                            <div class="w-100 overflow-hidden br-right-0">
                                                                                <a href="<?php echo url('player_profile'); ?>/ <?php echo $player->id; ?>"
                                                                                    target="_blank"><img
                                                                                        src="<?php echo url('frontend/profile_pic'); ?>/<?php echo $player->profile_pic; ?>"
                                                                                        alt="player" class="img-fluid"
                                                                                        loading="lazy"> </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                            }?>
                                                    </div>
                                                @else
                                                    <p>No Data Found!!</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                    <div class="tab-pane fade show" id="tab{{ $comp->id }}"  role="tabpanel" aria-labelledby="tab1">
                                        <div class="">
                                            <div class="row my-3">
                                                <div class="col-md-8 col-lg-8">
                                                    <div class="row">
                                                        <div class="col-md-1 m-auto col-2 pr-0 ">
                                                            <span class="championLeagueRounde ">
                                                                <a href="{{ url('competition') }}/{{ $comp->id }}"
                                                                    target="_blank"> <img class="rounded-circle img-fluid"
                                                                        src="{{ url('frontend/logo') }}/{{ $comp_info->comp_logo }}"
                                                                        loading="lazy"> </a>
                                                            </span>
                                                            <!-- <span class="icon-noun-s icon-noun-circle noun_Trophy"></span>  -->
                                                        </div>
                                                        <div class="col-md-11 col-10 m-auto p-0 ">
                                                            <a href="{{ url('competition') }}/{{ $comp->id }}"
                                                                    target="_blank" class="text-secondary">
                                                            <h1>
                                                                @php echo Str::of($comp_info->name)->limit(20); @endphp
                                                                <!-- <span class="float-end  date-com mt-4"><i class="icon-calendar"></i> Thursday, 15 July 2021</span> -->
                                                            </h1>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="box-outer-white  row  py-4 matchDetails">
                                                    </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h1>Top Players <button class="btn fs1 float-end"><i
                                                            class="icon-more_horiz"></i></button></h1>

                                                    @if ($matches->isNotEmpty())
                                                    <div class="comp_top_performer_list"></div>
                                                    @else
                                                        <p>No Data Found!!</p>
                                                    @endif

                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                <?php } ?>
                                @php $loopCount++ @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main id="main">
        </main>
        @include('frontend.includes.footer')
        <script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
        <script src="{{ url('frontend/js/typeahead.js') }}" defer async></script>

        <script>
              $(document).on('click', '.tabLink', function() {
                var comp_id = $(this).data('id');
                $.ajax({

                    url: "{{ url('match_Details') }}",
                    type: 'post',
                    data: {
                        comp_id: comp_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#tab'+comp_id).find('.matchDetails').html(data);
                    }
                });
            });
            $(document).on('click', '#top_comp', function() {
                var comp_id = $(this).data('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('public_top_performer') }}",
                    type: 'get',
                    data: {
                        comp_id: comp_id
                    },
                    error: function(error) {
                        console.log('errors',error);
                        alert('Something is Wrong');
                    },
                    success: function(data) {
                        $('.comp_top_performer_list').html(data);
                    }
                });
            })



        </script>
        @include('frontend.includes.searchScript')
</body>


</html>
