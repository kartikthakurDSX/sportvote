@include('frontend.includes.header')
<div class="Competitionn-Page-Additional">
  <input type="hidden" value="{{$competition->id}}" id="comp_id">
		@livewire('competition.edit-banner',['comp_id' => $competition->id])
	<div class="dashboard-profile">
	   	<div class="container-lg">
		  	<div class="row bg-white">
			 	<div class="col-md-12  position-relative">
				 @livewire('competition.edit-logo',['comp_id' => $competition->id])
					<div class="user-profile-detail-Team float-start w-auto">
					<h5 class="SocerLegSty"><span class="header_gameTeam">
                        Soccer Team</span> @if($competition->location) {{$competition->location}} @else -- @endif<br><strong>Created By:</strong><a href="{{url('CompAdmin-profile/' .$competition->user_id.'/'.$competition->id)}}" target="_blank" class="comp_a">  {{$competition->user->first_name}} {{$competition->user->last_name}} </a>
                    </h5>
					</div>
					<div class="w-auto float-end P-TB">
						@livewire('competition.edit-info', ['competition' => $competition->id])
					</div>
			 	</div>
		  	</div>
	   	</div>
	</div>
</div>
</div>
<main id="main" class="dashboard-wrap Team-Public-Profil Competitionn-Page Competitionn-Page-Additional  KoAdminView League-page">
    <div class="container-fluid bg-GraySquad">
        <div class="container-lg">
            <div class="row AboutMe">
                <div class="col-md-2 col-12 resMob pr-0">
                    <div class="boxSuad">
                        <span class="SquadCS"><span class="seasionBold">SEASON:</span></span>
                        <br><span class="btn-secondaryNew">2022 </span>
                    </div>
                </div>
                <div class="col-md-1 p-0 seventyNine">
                    <div class="NAtionPLAyer">
                        <span class="SquadCS">TEAM</span>
                        <p class="fitIn"><span class="FiveFtComp">{{$competition->team_number}}</span><span class="SlePer"></span></p>
                    </div>
                </div>
                <div class="col-md-2 p-0">
                    <div class="ForeginPlayer">
                        <span class="SquadCS">MATCHES PLAYED</span>
                        <?php $total_matches = $total_rounds * $round_fixtures;
                        $completed_fixture = App\Models\Match_fixture::where('competition_id',$competition->id)->where('finishdate_time','!=',null)->count();?>
                        <p class="fitIn"><span class="FiveFtComp">{{$completed_fixture}}</span><span class="SlePer">/{{$total_matches}}</span></p>
                    </div>
                </div>
                <div class="col-md-3 mobCompetition">
                    <div class="row">
                        <div class="col-md-5 col-5 mobCopm ">
                            <div class="NAtionPLAyerTotal">
                                <div class="">
                                    <span class="SquadCS ">TOTALS GOALS </span>
                                </div>
                                <div class=" fitIn">
                                    <span class="FiveFtComp "> {{$total_goals->count()}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-7 mobCopm ">
                            <span class="slesss"></span>
                            <div class="NAtionPLAyer">
                                <div class="">
                                    <span class="SquadCS ">GOALS PER MATCH </span>
                                </div>
                                <div class=" fitIn">
                                    <span class="FiveFtComp "> {{$avg_goal}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @livewire('competition.add-sponsor', ['competition' => $competition->id])
            </div>
            <div class="container-lg NewSAni">
                @livewire('competition.addcompetition-news', ['competition' => $competition->id])
            </div>
            <!-- Post and News  -->
            <div class="container-lg">
                <div class="row M-topSpace">
                    <div class="col-md-8 col-lg-8">
                        <div class="box-outer-lightpink MyTeamm">
                            @livewire('comp-team-participate', ['competition' => $competition->id])
                        </div>
                        <div class="box-outer-lightpink MyTeamm">
                            @livewire('competition.league-point-table', ['competition' => $competition->id])
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="M-topSpace">
                                <div class="row">
                                    <div class="col-md-4 w-100-768 ">
                                        <div class="box-outer-lightpink">
                                            <ol class="list-group list-group-numbered">
                                                <div class="list-group-item d-flex justify-content-between align-items-start bgDark">
                                                    <span class="btn-secondaryTable">TOP 5 TEAMS:</span>
                                                    <select class="form-select KoAdminViewDrop" aria-label="Default select example" id="change_team_stat">
                                                        @foreach($team_stat as $stat)
                                                            <option value="{{$stat->id}}" style="text-align:left;">{{$stat->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span id="display_top_teams">
                                                <?php $teamids = array();
                                                    $team_goals = App\Models\Match_fixture_stat::where('competition_id',$competition->id)->where('sport_stats_id',$team_stat[0]['id'])->get();
                                                    $top_team_goal = $team_goals->groupBy('team_id');
                                                ?>
                                                @if($top_team_goal->IsNotEmpty())
                                                    @foreach($top_team_goal  as $top_team => $stat)
                                                        <?php  $teamids[$top_team] = $stat->count(); ?>
                                                    @endforeach
                                                <?php
                                                    arsort($teamids);
                                                    $team_stat_count_key = array_keys($teamids);
                                                    for($tp = 0; $tp<count($team_stat_count_key); $tp++)
                                                    {
                                                        if($tp < 5)
                                                        {
                                                            $teamid = $team_stat_count_key[$tp];
                                                            $teamgoal = $teamids[$teamid];
                                                            $team = App\Models\Team::select('name','id','location','team_logo','country_id')->find($teamid);
                                                            $location_code = App\Models\Country::select('iso3')->find($team->country_id);
                                                            ?>
                                                            <a href="{{ URL::to('team/' . $teamid) }}">
                                                                <li class="list-group-item d-flex justify-content-between align-items-start" title="{{$team->name}},[{{$team->location}}]">
                                                                <img class="img-fluid rounded-circle rounded-circle padd-RL" src="{{url('frontend/logo')}}/{{$team->team_logo}}"
                                                                width="25%">
                                                                <div class="ms-2 me-auto EngCity">
                                                                    <div class=" ManCity">
                                                                        @php echo str::of($team->name)->limit(13); @endphp
                                                                    </div>
                                                                    {{$location_code->iso3}}
                                                                </div>
                                                            <span class="badge">{{$teamgoal}}</span>
                                                            </li> </a>
                                                            <?php
                                                        }
                                                    }?>
                                                    <div class="list-group-item  justify-content-between align-items-start">
                                                        <div class=" EngCity">
                                                            <div class=" AndyMcg text-decoration">
                                                            <a class="text-decoration AndyMcg"  id="view_top_teams" style="cursor:pointer;"> View Full Rankings Table <i class="fa-solid fa-angles-right"></i> </a>
                                                            </div>
                                                            <!-- <a class="text-decoration AndyMcg" href="" id="view_top_teams"> View Full Rankings Table <i class="fa-solid fa-angles-right"></i> </a> -->
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                                        <p style="text-align:center; font-weight:bold;">No Data Found</p>
                                                    </div>
                                                @endif
                                                </span>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="col-md-4 w-100-768  NumberCounters">
                                        <div class="box-outer-lightpink">
                                            <ol class="list-group list-group-numbered">
                                                <div class="list-group-item d-flex justify-content-between align-items-start bgDark">
                                                    <span class="btn-secondaryTable">TOP 5 PLAYERS:</span>
                                                    <select class="form-select KoAdminViewDrop" aria-label="Default select example" id="change_player_stat">
                                                        @foreach($player_stat as $stat)
                                                            <option value="{{$stat->id}}" style="text-align:left;">{{$stat->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span id="display_top_players">
												<?php $playerids = array();
                                                    $player_goals = App\Models\Match_fixture_stat::where('competition_id',$competition->id)->where('sport_stats_id',$player_stat[0]['id'])->get();
                                                    $top_player_goal = $player_goals->groupBy('player_id');
												?>
												@if($top_player_goal->IsNotEmpty())
													@foreach($top_player_goal  as $top_player => $stat)
														<?php  $playerids[$top_player] = $stat->count(); ?>
													@endforeach
													<?php
													arsort($playerids);
                                                    $stat_count_key = array_keys($playerids);
                                                    for($tp = 0; $tp<count($stat_count_key); $tp++)
                                                    {
                                                        if($tp < 5)
                                                        {
                                                            $playerid = $stat_count_key[$tp];
                                                            $playergoal = $playerids[$playerid];
                                                            $player = App\Models\user::find($playerid);
                                                            $player_team_id = App\Models\Match_fixture_stat::where('competition_id',$competition->id)->where('player_id',$playerid)->value('team_id');
                                                            $player_team = App\Models\Team::select('name','id','team_color')->find($player_team_id);
                                                            $player_jersey_num = App\Models\Team_member::where('team_id',$player_team_id)->where('member_id',$playerid)->value('jersey_number');
                                                            ?>
                                                            <li class="list-group-item d-flex justify-content-between align-items-start" title="{{$player->first_name}} {{$player->last_name}}, {{$player_team->name}}">
                                                                <style>
                                                                    .tpjersey<?php echo $player_team->id; ?>:after {
                                                                        color:<?php echo $player_team->team_color;?>;
                                                                    }
                                                                </style>
                                                                <span class="jersy-noTopFIve team-jersy-TopPlayer tpjersey{{$player_team->id}}">{{$player_jersey_num}}</span>
                                                                <img class="img-fluid rounded-circle rounded-circle padd-RL"
                                                                    src="{{url('frontend/profile_pic')}}/{{$player->profile_pic}}" width="25%">
                                                                <div class="ms-2 me-auto EngCity">
                                                                    <a href="{{ URL::to('player_profile/' . $playerid) }}" target="_blank">
                                                                        <div class=" ManCity"  >
                                                                            {{$player->first_name}} {{$player->last_name}}
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ URL::to('team/' . $player_team->id) }}" target="_blank"> @php echo str::of($player_team->name)->limit(13); @endphp </a>
                                                                </div>
                                                                <span class="badge">{{$playergoal}}</span>
                                                            </li>
                                                        <?php
                                                        }
                                                    } ?>
                                                    <div class="list-group-item  justify-content-between align-items-start">
                                                        <div class=" EngCity">
                                                            <div class=" AndyMcg text-decoration">
                                                                <a class="text-decoration AndyMcg" id="view_top_players" style="cursor:pointer;"> View Full Rankings Table <i class="fa-solid fa-angles-right"></i> </a>
                                                                </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                                        <p style="text-align:center; font-weight:bold;">No Data Found</p>
                                                    </div>
                                                @endif
						                    </span>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-md-4 w-100-768 ">
                                    <div class="box-outer-lightpink">
                                        <ol class="list-group list-group-numbered">
                                            <div class="list-group-item d-flex justify-content-between align-items-start bgDark">
                                                <span class="btn-secondaryTable">MVP</span>
                                                    <select class="form-select KoAdminViewDrop mvp" aria-label="Default select example" id="change_mvp">
                                                        <option value="1" style="text-align:left;">Most Winners</option>
                                                        <option value="2" style="text-align:left;">Recent Winners</option>
                                                    </select>
                                            </div>
	                                        <div id="mvp_winners">
		                    	                @if(count($recent_winner) > 0)
                                                    <?php $mvp_winner =array();?>
                                                    @foreach($recent_winner as $mvp)
                                                        <?php $mvp_winner[$mvp['player_id']] = $mvp['total']; ?>
                                                    @endforeach
                                                    <?php
                                                    arsort($mvp_winner);
                                                    $vote_count_key = array_keys($mvp_winner);
                                                    for($tp = 0; $tp<count($vote_count_key); $tp++)
                                                    {
                                                        if($tp < 5)
                                                        {
                                                            $mvpplayerid = $vote_count_key[$tp];
                                                            $playervote = $mvp_winner[$mvpplayerid];

                                                            $mvpplayer = App\Models\user::select('id','first_name','last_name','profile_pic')->find($mvpplayerid);
                                                            $mvpplayer_team_id = App\Models\voting::whereIn('match_fixture_id',$fixture_ids)->where('player_id',$mvpplayerid)->value('team_id');
                                                            $mvpplayer_team = App\Models\Team::select('name','id','team_color')->find($mvpplayer_team_id);
                                                            $mvpplayer_jersey_num = App\Models\Team_member::where('team_id',$mvpplayer_team_id)->where('member_id',$mvpplayerid)->value('jersey_number');
                                                                ?>
                                                            <li class="list-group-item d-flex justify-content-between align-items-start" title="{{$mvpplayer->first_name}} {{$mvpplayer->last_name}}, {{$mvpplayer->name}}">
                                                                <style>
                                                                    .mvpplayer<?php echo $mvpplayer_team->id; ?>:after {
                                                                        color:<?php echo $mvpplayer_team->team_color;?>;
                                                                    }
                                                                </style>
                                                                <span class="jersy-noTopFIve team-jersy-TopPlayer mvpplayer{{$mvpplayer_team->id}}">{{$mvpplayer_jersey_num}}</span>
                                                                <img class="img-fluid rounded-circle rounded-circle padd-RL"
                                                                    src="{{url('frontend/profile_pic')}}/{{$mvpplayer->profile_pic}}" width="25%">
                                                                <div class="ms-2 me-auto EngCity">
                                                                    <a href="{{ URL::to('player_profile/' . $mvpplayerid) }}" target="_blank">
                                                                        <div class=" ManCity"  >
                                                                            {{$mvpplayer->first_name}} {{$mvpplayer->last_name}}
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ URL::to('team/' . $mvpplayer_team->id) }}" target="_blank"> @php echo str::of($mvpplayer_team->name)->limit(13); @endphp </a>
                                                                </div>
                                                                <span class="badge">{{$playervote}}</span>
                                                            </li>
		        									    <?php
		        								        }
                                                    } ?>
                                                    <div class="list-group-item  justify-content-between align-items-start">
                                                        <div class=" EngCity">
                                                            <div class=" AndyMcg text-decoration">
                                                                <a class="text-decoration AndyMcg" id="view_all_winners" style="cursor:pointer;"> View Full Rankings Table <i class="fa-solid fa-angles-right"></i> </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="list-group-item d-flex justify-content-between align-items-start">
                                                        <p style="text-align:center; font-weight:bold;">No Data Found</p>
                                                    </div>
                                                @endif
											</div>
	                                    </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-8">
                            <h1 class="Poppins-Fs30">Fixture Calendar </h1>
                        </div>
                    </div>
                    <div class="box-outer-lightpink Team-Fixture">
                        <ul class="nav nav-tabs">
                            <div class="owl_fixtureLeague owl-carousel owl-theme">
                                @foreach($month_array as $month)
                                    <?php
                                    $i = 1;
                                    $current_month = date('M');

                                    if(strtoupper($current_month) == $month)
                                    {
                                        $class = "active";
                                        $link = $month.$i;
                                        $div_class = "tab-pane fade in active";
                                    }
                                    else
                                    {
                                        $class= "";
                                        $div_class = "tab-pane fade";
                                        $link = $month.$i;
                                    }
                                    ?>
                                    <div class="item">
                                    <li class="{{$class}}" data-toggle="tab" href="#{{$link}}"><a >{{$month}}<p>{{$lastest_fixture_year}}</p></a></li>
                                    </div>
                                @endforeach
                                <div class="item">
                                    <li class="{{$class}}" data-toggle="tab" href="{{$link}}"><a >Jan<p>2022</p>
                                    </a></li>
                                </div>
                            </div>
                        </ul>
                        <div class="tab-content">
                            @foreach($month_array as $month)
                                <?php
                                    $i = 1;
                                    $current_month = date('M');
                                    if(strtoupper($current_month) == $month)
                                    {
                                    $class = "active";
                                    $link = $month.$i;
                                    $div_class = "tab-pane fade active";
                                    }
                                    else
                                    {
                                    $class= "";
                                    $div_class = "tab-pane fade in";
                                    $link = $month.$i;
                                    }
                                ?>
                                <div id="{{$link}}" class="{{$div_class}}">
                                    <?php
                                    $check_month = array_search ($month, $month_array);
                                    $get_month = $check_month + 1;
                                    $tab_month = str_pad($get_month,2,'0',STR_PAD_LEFT);
                                    //$current_month = date('m');
                                    $current_year = date('Y');
                                    $default_search = $current_year."-".$tab_month;
                                    $check_fixtures = App\Models\Match_fixture::where('competition_id',$competition->id)->where('fixture_date', 'like', '%'.$default_search.'%')->with('teamOne:id,name,team_logo','teamTwo:id,name,team_logo')->get();
                                    ?>
                                    @if($check_fixtures->IsNotEmpty())
                                        <?php $c_fixtures = array();
                                        foreach($check_fixtures as $fixture)
                                        {
                                            $c_fixtures[] = $fixture;
                                        }
                                            $fixture_chunks = array_chunk($c_fixtures,5);
                                        ?>
                                        <div class="owlfixtureCal owl-carousel owl-theme">
                                            @foreach($fixture_chunks as $chunks)
                                                <div class="item">
                                                    <table class="table TableFixtureCalndr ">
                                                        @foreach($chunks as $fixture)
														<?php $Comp_type = App\Models\competition_type::find($competition->comp_type_id); ?>
                                                        <tr>
                                                            <td>
                                                                @if($competition->comp_start == 1)
                                                                    <a href="{{URL::to('match-fixture/' .$fixture->id)}}" target="_blank"> <span class="OnSun">{{ date('D', strtotime($fixture->fixture_date)) }}</span> <span class="Dec-DateFix">{{ date('M d', strtotime($fixture->fixture_date)) }}</span>
                                                                    </a>
                                                                @else
                                                                    <span class="comp_start0" title="Competiiton not start yet!"> <span class="OnSun">{{ date('D', strtotime($fixture->fixture_date)) }}</span> <span class="Dec-DateFix">{{ date('M d', strtotime($fixture->fixture_date)) }}</span> </span>
                                                                @endif
                                                            </td>
                                                            <td class="RightPosiText ">
                                                                <a href="{{ URL::TO('team/' . $fixture->teamOne_id)}}" target="_blank"> <b class="WolVerWand">@php echo Str::of($fixture->teamOne->name)->limit(12); @endphp</b> </a>&nbsp;
                                                                <div class="pp-pageHW"><a href="{{ URL::TO('team/' . $fixture->teamOne_id)}}" target="_blank"> <img class="img-fluid rounded-circle" src="{{url('frontend/logo')}}/{{$fixture->teamOne->team_logo}}"></a>
                                                                </div>
                                                            </td>
                                                            <td class="BtnCentr">
                                                            @if($fixture->startdate_time == NULL)
                                                                @if($competition->comp_start == 1)
                                                                    <a href="{{ URL::TO('match-fixture/' . $fixture->id)}}" class="btn btn-gray text-center btn-xs-nb" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$fixture->competition->name}}, Competition type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}">{{ date('H:i', strtotime($fixture->fixture_date)) }}</a>
                                                                @else
                                                                    <a title="Competition not start yet!" class="btn btn-gray text-center btn-xs-nb comp_start0"  target="_blank" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$fixture->competition->name}}, Competition type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}">{{ date('H:i', strtotime($fixture->fixture_date)) }}</a>
                                                                @endif
                                                            @else
                                                                <?php
                                                                $teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$fixture->id)->where('team_id',$fixture->teamOne_id)->where('sport_stats_id',1)->count();
                                                                $teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$fixture->id)->where('team_id',$fixture->teamTwo_id)->where('sport_stats_id',1)->count();

                                                                ?>
                                                                <a href="{{ URL::TO('match-fixture/' . $fixture->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$fixture->competition->name}}, Competition type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}">
																	<span class=" btn-greenFXL " target="_blank">{{$teamOneGoal}}</span>
																	<span class=" btn-greenFXR ">{{$teamTwoGoal}}</span>
																</a>
                                                            @endif
                                                            </td>
                                                            <td class="LeftPosiText ">
                                                                <div class="pp-pageHW"><a href="{{ URL::TO('team/' . $fixture->teamTwo_id)}}" target="_blank"> <img class="img-fluid " src="{{url('frontend/logo')}}/{{$fixture->teamTwo->team_logo}}"></a></div>&nbsp;
                                                                <a href="{{ URL::TO('team/' . $fixture->teamTwo_id)}}" target="_blank"> <b class="WolVerWand">@php echo Str::of($fixture->teamTwo->name)->limit(12); @endphp</b></a>
                                                            </td>

                                                                @livewire('competition.leauge-ics-file',['fixture_id' => $fixture->id])
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                        <!-- Quick Compare -->
                        @if(!empty($first_fixtures))
           		<h1 class="Poppins-Fs30">Quick Compare </h1>
               <div class="box-outer-lightpink QuickCompare league-quickCompare">
                <!-- Testing Css curve -->
                    <div class="row">
                    	<div class="col-md-6 col-6 pr-0 ">
                        	<div class="container-New" id="left_team_bg" style="background-color:<?php echo $first_fixtures->teamOne->team_color; ?>">
                         	</div>
                         	<div class="ArsenalVS">
                            	<div class="row padding-12 Reverse-Mob">
                                	<div class="col-md-2  ">
	                                    <div class="DropDownImg">
	                                        <img src="{{url('frontend/logo')}}/{{$first_fixtures->teamOne->team_logo}}" class="img-fluid" width="100%" id="left_team_logo">
	                                    </div>
                                	</div>
                                	<div class="col-md-10 pl-0 m-auto">
                                    	<div class="dropdown left-tab20">
                                    		<select class="form-select form-select-White form-select-lg ArsenalDropDwn custom_select_width Quick_teamchange" id="left_team_id">
                                    			@foreach($team_ids as $team_id)
                                    				<?php $team_info = App\Models\Team::select('id','name')->find($team_id); ?>
				                                	<option value="{{$team_info->id}}" <?php if($team_info->id == $first_fixtures->teamOne->id) {echo "selected";} else {} ?>>{{$team_info->name}}</option>
				                                @endforeach
			                              	</select>
                                    	</div>
                               		</div>
                            	</div>
                        	</div>
                    	</div>
                    	<div class="col-md-6 col-6 pl-0">
                        	<div class="VsBg-Competion">VS</div>
                        		<div class="BurnleyVS" id="right_team_bg" style="background-color:<?php echo $first_fixtures->teamTwo->team_color; ?>">
                            		<div class="row padding-12">
                                		<div class="col-md-10 text-align-rightVs m-auto">
                                    		<div class="dropdown ">
                                       			<select class="form-select form-select-White form-select-lg ArsenalDropDwn custom_select_width BurnelayDropDwn Quick_teamchange1" id="opp_team">
					                               	@foreach($team_ids as $team_id)
					                               		<?php $team_info = App\Models\Team::select('id','name')->find($team_id); ?>
				                                		<option value="{{$team_info->id}}" <?php if($team_info->id == $first_fixtures->teamTwo->id) {echo "selected";} else {} ?>>{{$team_info->name}}</option>
				                               		@endforeach
				                              	</select>
                                    		</div>
                                		</div>
		                                <div class="col-md-2 pl-0 ">
		                                    <div class="DropDownImg">
		                                        <img src="{{url('frontend/logo')}}/{{$first_fixtures->teamTwo->team_logo}}" class="img-fluid" width="100%" id="right_team_logo">
		                                    </div>
		                                </div>
                            		</div>
                        		</div>
                    		</div>
                		</div>
                		<div class="row" id="graph_data">
                    		<div class="col-md-6 col-6 pr-0 ">
                        		<div class="row">
                            		<div class="col-md-4 col-12 W-50tab p-12">
                                		<div class="RankedSec">
		                                    <span class="RankedText">RANKED<br>
		                                    </span>
                                    		<p class="RankedNo"><?php echo str_pad($firstL_team_rank->rank, 2, 0,STR_PAD_LEFT);  ?> </p>
                                		</div>
                            		</div>
		                            <div class="col-md-4 col-12 W-50tab p-12">
		                                <div class=" borderPoint">
		                                    <span class="RankedText">POINTS<br>
		                                    </span>
		                                    <p class="RankedNo"><?php echo str_pad($firstL_team_points, 2, 0,STR_PAD_LEFT);  ?></p>
		                                </div>
		                            </div>
		                            <div class="col-md-4 col-12 New-on-Tab p-12">
		                                <div class="d-flex">
			                                <div class="yelTxt">
			                                    <span class="YellInnerTxt"><?php echo str_pad($firstL_yellowcards, 2, 0,STR_PAD_LEFT);  ?></span>
			                                </div>
			                                <div class="cards-det">
			                                    <span class="YellCard">YELLOW</span>
			                                    <p class="YellCard mb-2">CARDS</p>
			                                </div>
		                                </div>
		                                <div class="d-flex">
			                                <div class="RedTxt">
			                                    <span class="YellInnerTxt"><?php echo str_pad($firstL_redcards, 2, 0,STR_PAD_LEFT);  ?></span>
			                                </div>
			                                <div class="cards-det">
			                                    <span class="RedCard">RED</span>
			                                    <p class="RedCard mb-2 ">CARDS</p>
			                                </div>
		                                </div>
		                            </div>
                        		</div>
                    			<hr>
                        		<div class="row">
                            		<div class="col-md-4 col-12 webkitCenter">
                                      	<div class="Donut-Chart mb-2">
										  <?php
											if($firstL_won == 0 && $firstL_draw == 0 && $firstL_lost == 0)
											{


											}
											elseif($firstL_won == 0 && $firstL_draw == 0 && $firstL_lost != 0)
											{
												$multiplyer = (int)(90/count($firstL_played));
												$thirdcircle = $firstL_lost * $multiplyer;
											?>
                                    		<div class="donut" style="--third: .{{$thirdcircle}};  --donut-spacing: 0;">
	                                          	<!-- <div class="donut__slice donut__slice__first"></div>
	                                      		<div class="donut__slice donut__slice__second"></div> -->
	                                 			<div class="donut__slice donut__slice__third"></div>
	                              				<div class="donut__label">
		                                            <div class="donut__label__heading">
		                                              	 <?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
		                                            </div>
		                                            <div class="donut__label__sub">
		                                              PLAYED
		                                            </div>
	                              				</div>
	                            			</div>
											<?php
											}
											elseif($firstL_won == 0 && $firstL_draw != 0 && $firstL_lost == 0)
											{
												$multiplyer = (int)(90/count($firstL_played));
												$secondcircle = $firstL_draw * $multiplyer;
												?>
												<div class="donut" style=" --second: .{{$secondcircle}}; --donut-spacing: 0;">
													<!-- <div class="donut__slice donut__slice__first"></div> -->
													<div class="donut__slice donut__slice__second"></div>
													<!-- <div class="donut__slice donut__slice__third"></div> -->
													<div class="donut__label">
														<div class="donut__label__heading">
															<?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
														</div>
														<div class="donut__label__sub">
														PLAYED
														</div>
													</div>
												</div>
												<?php
	                                    	}
											elseif($firstL_won != 0 && $firstL_draw == 0 && $firstL_lost == 0)
											{
												$multiplyer = (int)(90/count($firstL_played));
												$firstcircle = $firstL_won * $multiplyer;
											?>
												<div class="donut" style="--first: .{{$firstcircle}};  --donut-spacing: 0;">
													<div class="donut__slice donut__slice__first"></div>
													<!-- <div class="donut__slice donut__slice__second"></div>
													<div class="donut__slice donut__slice__third"></div> -->
													<div class="donut__label">
														<div class="donut__label__heading">
															<?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
														</div>
														<div class="donut__label__sub">
														PLAYED
														</div>
													</div>
												</div>
											<?php
											}
											elseif($firstL_won == 0 && $firstL_draw != 0 && $firstL_lost != 0)
											{
												$multiplyer = (int)(100/count($firstL_played));
												$secondcircle = $firstL_draw * $multiplyer;
												$thirdcircle = $firstL_lost * $multiplyer;
												?>
												<style>

													.Competitionn-Page-Additional .leftdonut.donut__slice__second {
														--second-start: calc(var(--first));
														--second-check: unset(calc(var(--second-start) - .5), 0);
														-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
														clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
													}
													.Competitionn-Page-Additional .leftdonut.donut__slice__third {
														--third-start: calc(var(--first) + var(--second));
														--third-check: unset(calc(var(--third-start) - .5), 0);
														-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
													}
												</style>
												<div class="donut" style="--first: .0; --second: .{{$secondcircle}}; --third: .{{$thirdcircle}};  --donut-spacing: 0;">
													<div class="donut__slice donut__slice__first"></div>
													<div class="donut__slice leftdonut donut__slice__second"></div>
													<div class="donut__slice leftdonut donut__slice__third"></div>
													<div class="donut__label">
														<div class="donut__label__heading">
															<?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
														</div>
														<div class="donut__label__sub">
														PLAYED
														</div>
													</div>
												</div> <?php
											}
											elseif($firstL_won != 0 && $firstL_draw == 0 && $firstL_lost != 0)
											{
												$multiplyer = (int)(100/count($firstL_played));
												$firstcircle = $firstL_won * $multiplyer;
												$thirdcircle = $firstL_lost * $multiplyer;

												if($firstL_won > $firstL_lost){
													$lvar_set = 'max';
												}else{
													$lvar_set = 'unset';
												}
												?>
												<style>
													.Competitionn-Page-Additional .leftdonut.donut__slice__third {
														--third-start: calc(var(--first) + var(--second));
														--third-check: <?php echo $lvar_set;?>(calc(var(--third-start) - .5), 0);
														-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
													}
												</style>

												<div class="donut" style="--first: .{{$firstcircle}}; --second: .0; --third: .{{$thirdcircle}};  --donut-spacing: 0;">
													<div class="donut__slice donut__slice__first"></div>
													<div class="donut__slice leftdonut donut__slice__third"></div>
													<div class="donut__label">
														<div class="donut__label__heading">
															<?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
														</div>
														<div class="donut__label__sub">
														PLAYED
														</div>
													</div>
												</div>
											<?php }
											elseif($firstL_won != 0 && $firstL_draw != 0 && $firstL_lost == 0)
											{
												$multiplyer = (int)(100/count($firstL_played));
													$firstcircle = $firstL_won * $multiplyer;
													$secondcircle = $firstL_draw * $multiplyer;

													if($firstL_won > $firstL_draw){
														$lvar_set = 'max';
													}else{
														$lvar_set = 'unset';
													}
												?>
												<style>

													.Competitionn-Page-Additional .leftdonut.donut__slice__second {
														--second-start: calc(var(--first));
														--second-check: <?php echo $lvar_set;?>(calc(var(--second-start) - .5), 0);
														-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
													}
												</style>
												<div class="donut" style="--first: .{{$firstcircle}}; --second: .{{$secondcircle}};  --donut-spacing: 0;">
													<div class="donut__slice leftdonut donut__slice__first"></div>
													<div class="donut__slice leftdonut donut__slice__second"></div>
													<!-- <div class="donut__slice donut__slice__third"></div> -->
													<div class="donut__label">
														<div class="donut__label__heading">
															<?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
														</div>
														<div class="donut__label__sub">
														PLAYED
														</div>
													</div>
												</div>
											<?php }
	                                    elseif($firstL_won != 0 && $firstL_draw != 0 && $firstL_lost != 0)
	                                    {
	                                    	$multiplyer = (int)(100/count($firstL_played));
											$firstcircle = $firstL_won * $multiplyer;
											$secondcircle = $firstL_draw * $multiplyer;
											$thirdcircle = $firstL_lost * $multiplyer;

											if($firstL_won < $firstL_lost && $firstL_draw < $firstL_lost){
												$varl_set = 'unset';
											}else{
												$varl_set = 'max';
											}
										    ?>
											<style>
												.Competitionn-Page-Additional .leftdonut.donut__slice__second {
														--second-start: calc(var(--first));
														--second-check: unset(calc(var(--second-start) - .5), 0);
														-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
													}
												.Competitionn-Page-Additional .leftdonut.donut__slice__third {
														--third-start: calc(var(--first) + var(--second));
														--third-check: <?php echo $varl_set;?>(calc(var(--third-start) - .5), 0);
														-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
													}
											</style>
											<div class="donut" style="--first: .{{$firstcircle}}; --second: .{{$secondcircle}}; --third: .{{$thirdcircle}};  --donut-spacing: 0;">
		                                      	<div class="donut__slice leftdonut donut__slice__first"></div>
		                                      	<div class="donut__slice leftdonut donut__slice__second"></div>
												<div class="donut__slice leftdonut donut__slice__third"></div>
												<div class="donut__label">
													<div class="donut__label__heading">
														<?php echo str_pad(count($firstL_played), 2, 0,STR_PAD_LEFT);  ?>
													</div>
													<div class="donut__label__sub">
													PLAYED
													</div>
												</div>
											</div> <?php
										}
                                      	?>
                    				</div>
               					</div>
								<div class="col-md-4 col-12 TabView ">
									<div class=" borderPoint">
										<div class="d-flex ">
											<div class="box-grenn">

											</div>
											<div class="cards-det">
												<span class="Box-grenn-txt"><?php echo str_pad($firstL_won, 2, 0,STR_PAD_LEFT);  ?> WON</span>
											</div>
										</div>
										<div class="d-flex ">
											<div class="box-gray">

											</div>
											<div class="cards-det">
												<span class="Box-grenn-txt"><?php echo str_pad($firstL_draw, 2, 0,STR_PAD_LEFT);  ?> DRAW</span>
											</div>
										</div>
										<div class="d-flex ">
											<div class="box-Reddd">

											</div>
											<div class="cards-det">
												<span class="Box-grenn-txt"><?php echo str_pad($firstL_lost, 2, 0,STR_PAD_LEFT);  ?> LOST</span>
											</div>
										</div>
										<span class="Box-grenn-txt">TEAM FORM</span>
										<p class="line-height-Team-form">
											<?php
											$rtf = 0;
											foreach($firstL_played as $a_team){ $rtf++;
											if($rtf < 5){
											?>
												@if($a_team->winner_team_id == $first_fixtures->teamOne->id)
													<span class="G-Tean-form"> W</span>
												@elseif($a_team->winner_team_id == 0)
													<span class="D-Tean-form"> D</span>
												@else
													<span class="R-Tean-form"> L</span>
												@endif
											<?php } else{ } } ?>
											<?php
											$restofteamform = 5 - $firstL_played->count();
											for($r = 1; $r<=$restofteamform; $r++){ ?>
												<span class="R-Tean-form" style="background-color:#003b5f !important;"> N/A</span>
											<?php } ?>

										</p>
									</div>
								</div>
								<div class="col-md-4 col-12 pl-0 tabFull">
									<div class="d-flex justi_centr-tab">
										<div class="BlueTxt">
											<div class="YellInnerTxt"><?php echo str_pad($firstL_goal_differ, 2, 0,STR_PAD_LEFT);  ?><p class="GoalsD"> GOAL D.</p>
											</div>
										</div>
										<div class="cards-det">
											<span class="Green"><?php echo str_pad($firstL_goal_for, 2, 0,STR_PAD_LEFT);  ?></span>
											<p class="RedD mb-2"><?php echo str_pad($firstL_againts_goals, 2, 0,STR_PAD_LEFT);  ?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
				                    <div class="col-md-6 col-6 pl-0 BorL-1">
				                        <div class="row">
				                            <div class="col-md-4 col-12 W-50tab p-12">
				                                <div class="RankedSec">
				                                    <span class="RankedText">RANKED<br>
				                                    </span>
				                                    <p class="RankedNo"><?php echo str_pad($firstR_team_rank->rank, 2, 0,STR_PAD_LEFT);  ?></p>
				                                </div>
				                            </div>
				                            <div class="col-md-4 col-12 W-50tab  p-12">
				                                <div class=" borderPoint">
				                                    <span class="RankedText">POINTS<br>
				                                    </span>
				                                    <p class="RankedNo"><?php echo str_pad($firstR_team_points, 2, 0,STR_PAD_LEFT);  ?></p>
				                                </div>
				                            </div>
				                            <div class="col-md-4 col-12 New-on-Tab p-12">
				                                <div class="d-flex">
					                                <div class="yelTxt">
					                                    <span class="YellInnerTxt"><?php echo str_pad($firstR_yellowcards, 2, 0,STR_PAD_LEFT);  ?></span>
					                                </div>
					                                <div class="cards-det">
					                                    <span class="YellCard">YELLOW</span>
					                                    <p class="YellCard mb-2">CARDS</p>
					                                </div>
				                                </div>
				                                <div class="d-flex">
					                                <div class="RedTxt">
					                                    <span class="YellInnerTxt"><?php echo str_pad($firstR_redcards, 2, 0,STR_PAD_LEFT);  ?></span>
					                                </div>
					                                <div class="cards-det">
					                                    <span class="RedCard">RED</span>
					                                    <p class="RedCard mb-2 ">CARDS</p>
					                                </div>
				                                </div>
				                            </div>
				                        </div>
                        				<hr>
                       					<div class="row">
                            				<div class="col-md-4 col-12 webkitCenter">
                                      			<div class="Donut-Chart mb-2">
                                        			<?php
			                                      	if($firstR_won == 0 && $firstR_draw == 0 && $firstR_lost == 0)
			                                      	{

			                                      	}
				                                    elseif($firstR_won == 0 && $firstR_draw == 0 && $firstR_lost != 0)
				                                    {
				                                    	$Rmultiplyer = (int)(90/count($firstR_played));
														$Rthirdcircle = $firstR_lost * $Rmultiplyer;
			                                    	?>
			                                    		<div class="donut" style="--third: .{{$Rthirdcircle}};  --donut-spacing: 0;">
				                                          	<!-- <div class="donut__slice donut__slice__first"></div>
				                                      		<div class="donut__slice donut__slice__second"></div> -->
				                                 			<div class="donut__slice donut__slice__third"></div>
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div>
			                            			<?php
				                                    }
				                                    elseif($firstR_won == 0 && $firstR_draw != 0 && $firstR_lost == 0)
				                                    {
														$Rmultiplyer = (int)(90/count($firstR_played));
														$Rsecondcircle = $firstR_draw * $Rmultiplyer;
				                                    	?>
														    <div class="donut" style="--second: .{{$Rsecondcircle}};   --donut-spacing: 0;">
				                                          	<!-- <div class="donut__slice donut__slice__first"></div> -->
				                                      		<div class="donut__slice donut__slice__second"></div>
				                                 			<!-- <div class="donut__slice donut__slice__third"></div> -->
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div> <?php
				                                    }
													elseif($firstR_won != 0 && $firstR_draw == 0 && $firstR_lost == 0)
				                                    {
				                                    	$Rmultiplyer = (int)(90/count($firstR_played));
														$Rfirstcircle = $firstR_won * $Rmultiplyer;
														?>
														<div class="donut" style="--first: .{{$Rfirstcircle}}; --donut-spacing: 0;">
				                                          	<div class="donut__slice donut__slice__first"></div>
				                                      		<!-- <div class="donut__slice donut__slice__second"></div>
				                                 			<div class="donut__slice donut__slice__third"></div> -->
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div>
			                            			<?php
				                                    }
				                                    elseif($firstR_won == 0 && $firstR_draw != 0 && $firstR_lost != 0)
				                                    {
				                                    	$Rmultiplyer = (int)(100/count($firstR_played));
														$Rsecondcircle = $firstR_draw * $Rmultiplyer;
														$Rthirdcircle = $firstR_lost * $Rmultiplyer;

				                                    	?>
														<style>
															.Competitionn-Page-Additional .rightdonut.donut__slice__second {
																--second-start: calc(var(--first));
																--second-check: unset(calc(var(--second-start) - .5), 0);
																-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
																		clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
															}
															.Competitionn-Page-Additional .rightdonut.donut__slice__third {
																--third-start: calc(var(--first) + var(--second));
																--third-check: unset(calc(var(--third-start) - .5), 0);
																-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																		clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
															}
														</style>
														    <div class="donut" style="--first: .0; --second: .{{$Rsecondcircle}}; --third: .{{$Rthirdcircle}};  --donut-spacing: 0;">
				                                          	<div class="donut__slice donut__slice__first"></div>
				                                      		<div class="donut__slice rightdonut donut__slice__second"></div>
				                                 			<div class="donut__slice rightdonut donut__slice__third"></div>
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div> <?php
				                                    }
				                                    elseif($firstR_won != 0 && $firstR_draw == 0 && $firstR_lost != 0)
				                                    {
														$Rmultiplyer = (int)(100/count($firstR_played));
														$Rfirstcircle = $firstR_won * $Rmultiplyer;
														$Rthirdcircle = $firstR_lost * $Rmultiplyer;

														if($firstR_won > $firstR_lost){
															$var_set = 'max';
														}else{
															$var_set = 'unset';
														}
														?>
														<style>
														.Competitionn-Page-Additional .rightdonut.donut__slice__third {
															--third-start: calc(var(--first) + var(--second));
															--third-check: <?php echo $var_set;?>(calc(var(--third-start) - .5), 0);
															-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																	clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
														}
													</style>
														<div class="donut" style="--first: .{{$Rfirstcircle}}; --second:  .0; --third: .{{$Rthirdcircle}};  --donut-spacing: 0;">
															<div class="donut__slice rightdonut donut__slice__first"></div>
															<div class="donut__slice rightdonut donut__slice__second"></div>
				                                 			<div class="donut__slice rightdonut donut__slice__third"></div>
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div>
				                                    <?php }
				                                    elseif($firstR_won != 0 && $firstR_draw != 0 && $firstR_lost == 0)
				                                    {
														$Rmultiplyer = (int)(100/count($firstR_played));
														$Rfirstcircle = $firstR_won * $Rmultiplyer;
														$Rsecondcircle = $firstR_draw * $Rmultiplyer;

														if($firstR_won > $firstR_draw){
															$rvar_set = 'max';
														}else{
															$rvar_set = 'unset';
														}
														?>
														<style>
															.Competitionn-Page-Additional .rightdonut.donut__slice__second {
																--second-start: calc(var(--first));
																--second-check: <?php echo $rvar_set; ?>(calc(var(--second-start) - .5), 0);
																-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
																		clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
															}
														</style>
                											<div class="donut" style="--first: .{{$Rfirstcircle}}; --second: .{{$Rsecondcircle}}; --donut-spacing: 0;">
				                                          	<div class="donut__slice donut__slice__first"></div>
				                                      		<div class="donut__slice rightdonut donut__slice__second"></div>
				                                 			<!-- <div class="donut__slice donut__slice__third"></div> -->
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div>
				                                    <?php
													}elseif($firstR_won != 0 && $firstR_draw != 0 && $firstR_lost != 0)
													{
														$Rmultiplyer = (int)(100/count($firstR_played));
														$Rfirstcircle = $firstR_won * $Rmultiplyer;
														$Rsecondcircle = $firstR_draw * $Rmultiplyer;
														$Rthirdcircle = $firstR_lost * $Rmultiplyer;

														if($firstR_won < $firstR_lost && $firstR_draw < $firstR_lost){
															$var_r_set = 'unset';
														}else{
															$var_r_set = 'max';
														}
													?>
                  				                   <style>
														.Competitionn-Page-Additional .rightdonut.donut__slice__second {
															--second-start: calc(var(--first));
															--second-check: unset(calc(var(--second-start) - .5), 0);
															-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
																	clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
														}
														.Competitionn-Page-Additional .rightdonut.donut__slice__third {
															--third-start: calc(var(--first) + var(--second));
															--third-check: <?php echo $var_r_set;?>(calc(var(--third-start) - .5), 0);
															-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																	clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
														}
													</style>
                  										<div class="donut" style="--first: .{{$Rfirstcircle}}; --second: .{{$Rsecondcircle}}; --third: .{{$Rthirdcircle}};  --donut-spacing: 0;">
															<div class="donut__slice rightdonut donut__slice__first"></div>
															<div class="donut__slice rightdonut donut__slice__second"></div>
				                                 			<div class="donut__slice rightdonut donut__slice__third"></div>
				                              				<div class="donut__label">
					                                            <div class="donut__label__heading">
					                                              	 <?php echo str_pad(count($firstR_played), 2, 0,STR_PAD_LEFT);  ?>
					                                            </div>
					                                            <div class="donut__label__sub">
					                                              PLAYED
					                                            </div>
				                              				</div>
				                            			</div>
													<?php
														}
													?>
                                				</div>
                            				</div>
                            				<div class="col-md-4 col-12 TabView">
                                				<div class=" borderPoint">
                                   					<div class="d-flex ">
				                                        <div class="box-grenn">

				                                        </div>
				                                        <div class="cards-det">
				                                            <span class="Box-grenn-txt"><?php echo str_pad($firstR_won, 2, 0,STR_PAD_LEFT);  ?> WON</span>
				                                        </div>
                                    				</div>
				                                    <div class="d-flex ">
				                                        <div class="box-gray">

				                                        </div>
				                                        <div class="cards-det">
				                                            <span class="Box-grenn-txt"><?php echo str_pad($firstR_draw, 2, 0,STR_PAD_LEFT);  ?> DRAW</span>
				                                        </div>
				                                    </div>
				                                    <div class="d-flex ">
				                                        <div class="box-Reddd">
				                                        </div>
				                                        <div class="cards-det">
				                                            <span class="Box-grenn-txt"><?php echo str_pad($firstR_lost, 2, 0,STR_PAD_LEFT);  ?> LOST</span>
				                                        </div>
				                                    </div>
				                                    <span class="Box-grenn-txt">TEAM FORM</span>
				                                    <p class="line-height-Team-form">
				                                        <?php
														$rtf = 0;
														foreach($firstR_played as $a_team){ $rtf++;
														if($rtf < 5){
														?>
															@if($a_team->winner_team_id == $first_fixtures->teamTwo->id)
																<span class="G-Tean-form"> W</span>
															@elseif($a_team->winner_team_id == 0)
																<span class="D-Tean-form"> D</span>
															@else
																<span class="R-Tean-form"> L</span>
															@endif
														<?php } else{ } } ?>
														<?php
														$restofteamform = 5 - $firstR_played->count();
														for($r = 1; $r<=$restofteamform; $r++){ ?>
															<span class="R-Tean-form" style="background-color:#003b5f !important;"> N/A</span>
														<?php } ?>
				                                    </p>
                                				</div>
                            				</div>
	                            			<div class="col-md-4 col-12  pl-0 tabFull">
	                               				<div class="d-flex justi_centr-tab ">
				                                <div class="BlueTxt">
				                                    <div class="YellInnerTxt"><?php echo str_pad($firstR_goal_differ, 2, 0,STR_PAD_LEFT);  ?><p class="GoalsD"> GOAL D.</p>
				                                    </div>
				                                </div>
				                                <div class="cards-det">
				                                    <span class="Green"><?php echo str_pad($firstR_goal_for, 2, 0,STR_PAD_LEFT);  ?></span>
				                                    <p class="RedD mb-2"><?php echo str_pad($firstR_againts_goals, 2, 0,STR_PAD_LEFT);  ?></p>
				                                </div>
	                                		</div>
	                            		</div>
	                        		</div>
	                    		</div>
	               			 </div>
	               		</div>
                   @else
                   @endif
                    </div>
                    <div class="col-md-4">
                        <!-- <h1>Top Performers <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1> -->
                        <div class="box-outer-lightpink SocialList AboutSocalSec">
                            @livewire('competition.edit-about-us',['competition' => $competition->id])
                            <hr>
                            <div class=""><span><img src="{{url('frontend/images/Contact-us.png')}}"></span> <span class="AboutStyleUs">
                                    contact  US</span>
                                @livewire('competition.comp-contact-us',['comp_id' => $competition->id])
                            </div>
                            <hr>
                            <div class="">
                                <span><img src="{{url('frontend/images/AdminStar-icon.png')}}"></span> <span class="AboutStyleUs">
                                    ADMINISTRATION</span>
                                    @livewire('competition-adminstration', ['competition' => $competition])
                            </div>
                            <hr>
                            <div class="">
                                <span><img src="{{url('frontend/images/Desi-Refree-icon.png')}}"></span> <span class="AboutStyleUs">
                                    DESIGNATED REFREES</span>
                                    @livewire('competition.add-comp-referee', ['competition' => $competition])
                            </div>
                            <hr>
                                @livewire('competition.addcommunity-sponsor', ['competition' => $competition->id, 'SponsorHeading' => 'LEAGUE SPONSORS'])
                            <hr>
                            <div class="">
                                <span><img src="{{url('frontend/images/twittter.png')}}"></span> <span class="AboutStyleUs"> @FC
                                    BARCELONA</span>
                                <p class="TextSocalInner">Barcelona manager Xavi: “Ousmane Dembélé will turn whistles
                                    into
                                    applause here at Camp Nou, I’m sure”. #FCB</p>
                                <p class="TextSocalInner">“We have to trust Ferrán Torres - it's a matter of giving him
                                    time
                                    and
                                    confidence”.</p>
                                <div class="SocalMatchImg">
                                    <img src="{{url('frontend/images/aft_match.png')}}" width="100%">
                                </div>
                                <a href="#" class="TwitterTxtBtm">12:00 PM · Feb 18, 2022</a>
                            </div>
                            <hr>
                            @livewire('competition.addcomp-youtube-video', ['competition'=> $competition->id])
							@livewireScripts



                        </div>
                    </div>
                </div>
<!-- Modal top 5 player -->
<div class="modal fade" id="top_player_view_full_ranking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Top Players Ranking Table</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="view_full_top_player">

			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal top 5 player -->
<div class="modal fade" id="top_teams_view_full_ranking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Top Team Ranking Table</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="view_full_top_team">

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        </main>







        @include('frontend.includes.footer')

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
 <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
 <script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <script src="{{url('frontend/js/script.js')}}"></script>
 <script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
 <script src="{{url('frontend/js/main.js')}}"></script>
    <script type="text/javascript">
        $('.responsive-tabs i.fa').click(function () {
            $(this).parent().toggleClass('open');
        });

        $('.responsive-tabs > li a').click(function () {
            $('.responsive-tabs > li').removeClass('active');
            $(this).parent().addClass('active');
            $('.responsive-tabs').toggleClass('open');
        });
    </script>

    <script type="text/javascript">
        $(function () {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                autoplay: 1000,
                items: 1,
                loop: true,
                onInitialized: counter, //When the plugin has initialized.
                onTranslated: counter //When the translation of the stage has finished.
            });

            function counter(event) {
                var element = event.target;         // DOM element, in this example .owl-carousel
                var items = event.item.count;     // Number of items
                var item = event.item.index + 1;     // Position of the current item

                // it loop is true then reset counter from 1
                if (item > items) {
                    item = item - items
                }
                $('#counter').html("item " + item + " of " + items)
            }
        });
    </script>


    <script type="text/javascript">
        $('.owlToper').owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            // items: 1,
            responsive: {
                0: {
                    items: 1
                },
                // 600: {
                //     items: 3
                // },
                // 1000: {
                //     items: 4
                // }
            }
        })
    </script>

    <!-- 06-09-22 add script for community sponsr  -->


  <script type="text/javascript">
        $('.owlSponsrKO').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: 800,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    </script>

<!-- Add script 13-09-2022 -->
    <script type="text/javascript">
        $('.owlTeamPart-league').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    </script>


    <script type="text/javascript">
        $(' .owl_fixtureLeague').owlCarousel({
            loop: true,
            margin: 2,
            responsiveClass: true, autoplayHoverPause: true,
            autoplay: false,
            slideSpeed: 400,
            paginationSpeed: 400,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 4,
                    nav: true,
                    loop: false
                },
                600: {
                    items: 3,
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

        $(document).ready(function () {
            var li = $(".owl-item li ");
            $(".owl-item li").click(function () {
                li.removeClass('active');
            });
        });
    </script>
    <!--  Add script 30-09-2022  -->
    <script type="text/javascript">
        $('.owlfixtureCal').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    </script>

    <script type="text/javascript">
        $('.owlTableMatchGoal').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    </script>
    <!-- 10-11-2022 post news script -->
    <script type="text/javascript">
        const wrapper = document.querySelector(".wrapper"),
editableInput = wrapper.querySelector(".editable"),
readonlyInput = wrapper.querySelector(".readonly"),
placeholder = wrapper.querySelector(".placeholder"),
counter = wrapper.querySelector(".counter"),
button = wrapper.querySelector("button");
editableInput.onfocus = ()=>{
  placeholder.style.color = "#c5ccd3";
}
editableInput.onblur = ()=>{
  placeholder.style.color = "#98a5b1";
}
editableInput.onkeyup = (e)=>{
  let element = e.target;
  validated(element);
}
editableInput.onkeypress = (e)=>{
  let element = e.target;
  validated(element);
  placeholder.style.display = "none";
}
function validated(element){
  let text;
  let maxLength = 500;
  let currentlength = element.innerText.length;
  if(currentlength <= 0){
    placeholder.style.display = "block";
    counter.style.display = "none";
    button.classList.remove("active");
  }else{
    placeholder.style.display = "none";
    counter.style.display = "block";
    button.classList.add("active");
  }
  counter.innerText = maxLength - currentlength;
  if(currentlength > maxLength){
    let overText = element.innerText.substr(maxLength); //extracting over texts
    overText = `<span class="highlight">${overText}</span>`; //creating new span and passing over texts
    text = element.innerText.substr(0, maxLength) + overText; //passing overText value in textTag variable
    readonlyInput.style.zIndex = "1";
    counter.style.color = "#e0245e";
    button.classList.remove("active");
  }else{
    readonlyInput.style.zIndex = "-1";
    counter.style.color = "#333";
  }
  readonlyInput.innerHTML = text; //replacing innerHTML of readonly div with textTag value
}
    </script>
<script>
$(document).on('change','#change_team_stat',function(){
	var sport_id = $(this).val();
	var comp_id = $('#comp_id').val();
//	alert(sport_id);
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("comp_top_fiveteam")}}',
		type:'post',
		data:{sport_id:sport_id,comp_id:comp_id},
		success:function(response)
		{

			if(response.data == 0)
			{
				html = '<div class="list-group-item d-flex justify-content-between align-items-start"><p style="text-align:center; font-weight:bold;">No Data Found</p></div>';
				$('#display_top_teams').html(html);
			}
			else
			{
				html = ''
				$.each(response.top_teams_data, function(index, value)
				{
					html += value;

				});
				html += '<div class="list-group-item  justify-content-between align-items-start"> <div class=" EngCity"><div class=" AndyMcg text-decoration"> <a class="text-decoration AndyMcg" id="view_top_teams" style="cursor:pointer;"> View Full Rankings Table <i class="fa-solid fa-angles-right"></i> </a></div></div></div>	';
				$('#display_top_teams').html(html);
				//alert(response.top_teams_data);
			}
		},
		error:function(){
			alert('something went wrong');
		}

	});
})
</script>
<script>
$(document).on('change','#change_player_stat',function(){
	var sport_id = $(this).val();
	var comp_id = $('#comp_id').val();
	//alert(comp_id);
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("comp_top_fiveplayer")}}',
		type:'post',
		data:{sport_id:sport_id,comp_id:comp_id},
		success:function(response)
		{

			if(response.data == 0)
			{
				html = '<div class="list-group-item d-flex justify-content-between align-items-start"><p style="text-align:center; font-weight:bold;">No Data Found</p></div>';
				$('#display_top_players').html(html);
			}
			else
			{
				html = ''
				$.each(response.top_players_data, function(index, value)
				{
					html += value;

				});
					html += '<div class="list-group-item  justify-content-between align-items-start"> <div class=" EngCity"><div class=" AndyMcg text-decoration"> <a class="text-decoration AndyMcg" id="view_top_players" style="cursor:pointer;"> View Full Rankings Table <i class="fa-solid fa-angles-right"></i> </a></div></div></div>	';
				$('#display_top_players').html(html);
				//alert(response.top_teams_data);
			}
		},
		error:function(){
			alert('something went wrong');
		}

	});
})
</script>
<script>
 $(document).on('click','#view_top_players',function(){
	var sport_id = $(this).val();
	var statId = $('#change_player_stat').val();
	var comp_id = $('#comp_id').val();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("top_players_sats_list")}}',
		type:'post',
		data:{statId:statId,comp_id:comp_id},
		success:function(response)
		{
			$('#view_full_top_player').html(response);

			$('#top_player_view_full_ranking').modal('show');
		},
		error:function(){
			alert('something went wrong');
		}

	});

})
</script>
<script>
$(document).on('click','#view_top_teams',function(){
	var sport_id = $(this).val();
	var statId = $('#change_team_stat').val();
	var comp_id = $('#comp_id').val();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("top_teams_sats_list")}}',
		type:'post',
		data:{statId:statId,comp_id:comp_id},
		success:function(response)
		{
			$('#view_full_top_team').html(response);

			$('#top_teams_view_full_ranking').modal('show');
		},
		error:function(){
			alert('something went wrong');
		}

	});

})
</script>
<script>
	$(document).on('change','.Quick_teamchange',function(){
		var team_id = $(this).val();
		var opp_team = $('#opp_team').val();
    	var comp_id = $('#comp_id').val();
    	//alert(comp_id);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("league_quick_compare")}}',
			type:'post',
			data:{team_id:team_id,opp_team:opp_team,comp_id:comp_id},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{

				$('#graph_data').html(response);

				//console.log(response);
			}
		});
	})
</script>
<script>
	$(document).on('change','.Quick_teamchange1',function(){
		var opp_team = $(this).val();
		var team_id = $('#left_team_id').val();
    	var comp_id = $('#comp_id').val();
    	//alert(comp_id);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("league_quick_compare")}}',
			type:'post',
			data:{team_id:team_id,opp_team:opp_team,comp_id:comp_id},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{

				$('#graph_data').html(response);

				//console.log(response);
			}
		});

	})
</script>
<script>
	$(document).on('change','#left_team_id',function(){
		var team_id = $(this).val();
		var team_id2 = $('#opp_team').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("on_change_get_team_logo")}}',
			type:'post',
			data:{team_id:team_id,team_id2:team_id2},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				//console.log(response);
      			$("#left_team_logo").attr("src", '{{url("frontend/logo")}}/'+response.team_info.team_logo);
				$('#left_team_bg').css('background-color',response.team_info.team_color);
      			$("#right_team_logo").attr("src", '{{url("frontend/logo")}}/'+response.opp_team_logo.team_logo);
			}
		});

	})
</script>
<script>
	$(document).on('change','#opp_team',function(){
		var team_id2 = $(this).val();
		var team_id = $('#left_team_id').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("on_change_get_team_logo")}}',
			type:'post',
			data:{team_id:team_id,team_id2:team_id2},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				//console.log(response);
      			$("#left_team_logo").attr("src", '{{url("frontend/logo")}}/'+response.team_info.team_logo);
      			$("#right_team_logo").attr("src", '{{url("frontend/logo")}}/'+response.opp_team.team_logo);
				  $('#right_team_bg').css('background-color',response.opp_team.team_color);
			}
		});

	})
</script>
<script>
	$(document).on('change','#change_mvp',function(){
			var comp_id = $('#comp_id').val();
			var winner_type = $(this).val();
			$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("on_change_mvp_winner")}}',
			type:'post',
			data:{comp_id:comp_id,winner_type:winner_type},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				//console.log(response);
      			$('#mvp_winners').html(response);
			}
		});

	})
</script>
<script>
	$(document).on('click','.comp_start0',function(){
		swal("Competition has not started yet!");
	})
</script>
</body>

</html>
