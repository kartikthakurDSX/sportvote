<?php
$start = microtime(true);
$centerIndex = null;
?>
@include('frontend.includes.header')
<style>
	.unsetOverflowComp {
		overflow:unset !important;
	}
</style>
	<div class="Competitionn-Page-Additional">
	<input type="hidden" value="{{$competition->id}}" id="comp_id">
	<?php
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
				$url = "https://";
			else
				$url = "http://";
			// Append the host(domain name, ip) to the URL.
			$url.= $_SERVER['HTTP_HOST'];

		if(!empty($competition->comp_banner)){
			$banerimage = $url."/public/frontend/banner/".$competition->comp_banner;
		}
		else{
			$banerimage = $url."/public/frontend/images/competition-bg.png";
		}
		?>
		<div class="header-bottom header-bottomTeamPub dashboard" id="CompPageBanner" style="background-image: url('{{$banerimage}}');">
			<div class="container-fluid bh-WhiteTsp">
				<div class="container-lg">
					<div class="row">
						<div class="col-sm-2 col-4"></div>
						<div class="col-sm-10 col-8 LineHSpace pt-3 pb-3" style="padding-left: 90px;" >
							<?php
							$competitionname = explode(" ", $competition->name);
							?>
							<span class="FCBarcelona"><strong class="FCStyle"><?php echo array_shift($competitionname); ?></strong>&nbsp;<?php echo implode(" ", $competitionname); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if(Auth::check())
			@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
				<a data-toggle="modal" data-target="#edit_banner" style="cursor:pointer;"><span class="Edit-Icon-Banner HeroImgEditTop"> </span></a>
			@else
			@endif
		@else
		@endif
		<div class="dashboard-profile">
			<div class="container-lg">
				<div class="row bg-white">
					<div class="col-md-12  position-relative">
						<div>
							<a href="" class="user-profile-imgTeam"><img src="{{asset('frontend/logo')}}/{{$competition->comp_logo}}" width="100%" id="CompPageLogo" class="img-fluid competitionlogo" alt="competition-logo"></a>
							@if(Auth::check())
								@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
								<a data-toggle="modal" data-target="#edit_complogo" style="cursor:pointer;"><span class="Edit-Icon-white EditProfileOne"> </span></a>
								@else
								@endif
							@else
							@endif
						</div>
						<div class="user-profile-detail-Team float-start w-auto">
						<h5 class="SocerLegSty"><span class="header_gameTeam">Soccer Competition</span> @if($competition->location) in {{$competition->location}} @else -- @endif<br><br><strong>Created By:</strong><a href="{{url('CompAdmin-profile/' .$competition->user_id.'/'.$competition->id)}}" target="_blank" class="comp_a">  {{$competition->user->first_name}} {{$competition->user->last_name}} </a></h5>
						</div>
						<div class="w-auto float-end P-TB">
							<span class="float-md-end FootRFix">
								@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
									<button class="btn btn-Blue" id="compEditInfo">Edit Info</button>
									<a class="btn-icon FollowIcoNN-Edit" wire:click="edit_info" style="cursor:pointer;"><span class="Edit-Icon-white"> </span></a>
								@else
									@if($user_profile)
										@if(!($comp_memeber))
											<button class="btn btn-Blue" data-toggle="modal" data-target="#joinCompModal" title="Join as Referee">Join Competition</button>
											<img src="{{url('frontend/images/Join-A-team-b.png')}}" alt="" class="btn-icon FollowIcoNN">
										@else
											<button class="btn btn-Blue">Joined</button>
											<img src="{{url('frontend/images/Join-A-team-b.png')}}" alt="" class="btn-icon FollowIcoNN">
										@endif
									@else
									@endif
									@if($is_follow == 0)
										<button class="btn btn-Blue" wire:click="follow_comp">Follow</button>
									@else
										<button class="btn btn-Blue" wire:click="unfollow_comp">Unfollow</button>
									@endif
									<!-- <a class="btn-icon FollowIcoNN-Edit" href=""><span class="Edit-Icon-white"> </span></a> -->
									<img src="{{asset('frontend/images')}}/Follow-Icon.png" alt="" class="btn-icon FollowIcoNN">
								@endif
							</span>
							<h1 class="social-count "><span class="FlowerFollow " style="text-align: right;"><small>{{$comp_follower->count()}} Followers</small></span></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- close div of site wrap i.e. on header page-->

<main id="main" class="dashboard-wrap Team-Public-Profil Competitionn-Page Competitionn-Page-Additional  KoAdminView League-page">
  <div class="container-fluid bg-GraySquad">
    <div class="container-lg">
      <div class="row AboutMe">
        <div class="col-md-2 col-12 resMob pr-0">
            <div class="boxSuad">
              <span class="SquadCS"><span class="seasionBold">SEASON:</span></span>
                <br><span class="btn-secondaryNew">{{$comp_season}}</span>
            </div>
          </div>
          <div class="col-md-1 p-0 seventyNine">
              <div class="NAtionPLAyer">
                  <span class="SquadCS">TEAMS</span>
                  <p class="fitIn"><span class="FiveFtComp">{{$competition->team_number}}</span><span class="SlePer"></span></p>
              </div>
          </div>
          <div class="col-md-2 p-0">
            <div class="ForeginPlayer">
				<span class="SquadCS">MATCHES PLAYED</span>
				<?php $total_matches = $total_rounds * $round_fixtures;
				if($competition->comp_subtype_id == 4)
				{
					$t_matches = $total_matches * 1;
				}
				elseif($competition->comp_subtype_id == 5)
				{
					$t_matches = $total_matches * 2;
				}
				elseif($competition->comp_subtype_id == 6)
				{
					$t_matches = $total_matches * 3;
				}
				$completed_fixture = App\Models\Match_fixture::where('competition_id',$competition->id)->where('finishdate_time','!=',null)->count();?>
				<p class="fitIn"><span class="FiveFtComp">{{$completed_fixture}}</span><span class="SlePer">/{{$t_matches}}</span></p>
            </div>
          </div>
          <div class="col-md-3 mobCompetition">
            <div class="row">
              <div class="col-md-5 col-5 mobCopm">
                <div class="NAtionPLAyerTotal">
                  <div class="">
                    <span class="SquadCS">TOTAL GOALS </span>
                  </div>
                  <div class="fitIn">
                    <span class="FiveFtComp "> {{$total_goals}}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-7 col-7 mobCopm">
                <span class="slesss"></span>
                <div class="NAtionPLAyer">
                  <div class="">
                    <span class="SquadCS">GOALS PER MATCH</span>
                  </div>
                  <div class="fitIn">
                    <span class="FiveFtComp">@if($avg_goal > 0) {{number_format((float)$avg_goal, 2, '.', '')}} @else {{$avg_goal}}.00 @endif</span>
                  </div>
                </div>
              </div>
            </div>
			</div>
			<div class="col-md-4 pl-0 ">
				@if(Auth::check())
					@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
						@if(count($comp_sponsers) != 0)
						<a wire:click="open_editteam_sponsor" style="cursor:pointer;"><span class="Edit-Icon"></span></a>
						@else
							<a wire:click="open_add_sponsor" style="cursor:pointer;"><span class="fa-plus"> </span></a>
						@endif
					@else
					@endif
				@else
				@endif
				<div class="bg-heinken">
					<div class="text-Middle">
						<?php
						if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
							$url = "https://";
						else
							$url = "http://";
						// Append the host(domain name, ip) to the URL.
						$url .= $_SERVER['HTTP_HOST'];
						?>
						<div class="container">
							<div class="owl-carousel offical_sponsor" wire:ignore>
								@if($comp_sponsers->isNotEmpty())
									@foreach ($comp_sponsers as $comp_sponser)
										<?php
											$sponserimage = $url . "/storage/app/public/image/" . $comp_sponser->sponsor_image;
										?>
										<div class="slides"><img src="{{$sponserimage}}" class="img-fluidD" alt="" /></div>
									@endforeach
								@else
									<div class="slides"><img src="{{url('frontend/images/team-spon-logo.png')}}" class="img-fluidD" alt="" /></div>
								@endif
							</div>
						</div>

						<span class="TeamSponSorsComp">OFFICIAL SPONSOR</span>
					</div>
				</div>
			</div>
           @livewire('competition.add-sponsor', ['competition' => $competition->id])
        </div>
      </div>
    </div>
    <div class="container-lg NewSAni">
		@livewire('competition.addcompetition-news', ['competition' => $competition->id])
	</div>
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
			  				@if($stat->id != 54)
                            <option value="{{$stat->id}}" style="text-align:left;">{{$stat->name}}</option>
							@else
							@endif
                          @endforeach
                        </select>
                      </div>
                      <span id="display_top_teams">
						          <?php $teamids = array();
                        $team_goals = App\Models\Match_fixture_stat::where('competition_id',$competition->id)->whereIn('sport_stats_id', [1,54])->get();
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
		                        <select class="form-select KoAdminViewDrop mvp" aria-label="Default select example" id="change_mvp" style="width: 76%;">
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
														<div class="ManCity" >
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
								</div>
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
	                	</ol>
                  	</div>
                </div>
              </div>
            </div>
          </div>
          <!-- Fixture Calendar -->
          <!-- <h1 class="Poppins-Fs30">Fixture Calendar <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1> -->
          @if($competition->team_number == $accepted_comp_team)
            <div class="row">
              <div class="col-md-6 col-8">
                <h1 class="Poppins-Fs30">Fixture Calendar</h1>
              </div>
              @livewire('competition.league-create-fixture', ['competition' => $competition->id])
            </div>
            <div class="box-outer-lightpink Team-Fixture">
				<?php
					$fixtures_date = App\Models\Match_fixture::where('competition_id',$competition->id)->pluck('fixture_date');
					$fix_date_array = $fixtures_date->toArray();
					if(count($fix_date_array) > 0)
					{
						$mindate = min(array_map('strtotime', $fix_date_array));
						$minYear = date('Y', $mindate);
						$min_year_month = date('m', $mindate);
						if($min_year_month != ""){
							$min_year = $minYear - 1;
						}else{
							$min_year = $minYear;
						}
						$maxdate = max(array_map('strtotime', $fix_date_array));
						$max_year = date('Y', $maxdate);
					}
					else
					{
						$min_year = date('Y');
						$min_year_month = date('m');
						$max_year = date('Y');
					}
				?>
              	<ul class="nav nav-tabs">
			  		<div class="owl_fixtureLeague owl-carousel owl-theme">
                    <?php
						$index = 0;
							if($min_year_month != ""){
								$min_year = $min_year - 1;
							}
						for($start_year = $min_year; $start_year <= $max_year; $start_year++)
						{
							if($start_year == $min_year)
							{
								$startmonth = $min_year_month ;
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
									$class= "";
									$link = date("M", mktime(0, 0, 0, $start_month,1,$start_year)).$i;
								}
								$index++;
								?>
								<div class="item">
									<li class="{{$class}}" id="{{$link}}" onclick="return getFixtures('{{$link}}');" data-compId="{{$competition->id}}" data-year="{{$start_year}}" data-month="{{$start_month}}" data-toggle="tab"><a >{{date("M", mktime(0, 0, 0, $start_month, 1))}}<p>{{$start_year}}</p></a></li>
								</div>
								<?php
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
										<li class="" data-toggle="tab" href="#{{date('M', mktime(0, 0, 0, $m)).$next_year}}"><a >{{date("M", mktime(0, 0, 0, $m, 1))}}<p>{{$next_year}}</p></a></li>
									</div>
								<?php
								}
							}
						}
                    ?>
               	 	</div>
              	</ul>
              	<div class="tab-content" id="fixturDiv">
					<div class="tab-pane fade active" id="activefixtab">
						<?php
						$current_year = date('Y');
						$default_search = $start_year."-".str_pad($start_month,2,'0',STR_PAD_LEFT);
						$check_fixtures = App\Models\Match_fixture::where('competition_id',$competition->id)->where('fixture_date', 'like', '%'.$default_search.'%')->with('teamOne:id,name,team_logo','teamTwo:id,name,team_logo')->orderBy('fixture_date', 'ASC')->get();
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
															<span class="comp_start0" data-toggle="tooltip" data-placement="bottom" data-original-title="" title="Competiiton not start yet!"> <span class="OnSun">{{ date('D', strtotime($fixture->fixture_date)) }}</span> <span class="Dec-DateFix">{{ date('M d', strtotime($fixture->fixture_date)) }}</span> </span>
														@endif
													</td>
													<td class="RightPosiText ">
														<a href="{{ URL::TO('team/' . $fixture->teamOne_id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamOne->name}}" data-original-title=""> <b class="WolVerWand">@php echo Str::of($fixture->teamOne->name)->limit(13); @endphp</b> </a>&nbsp;
														<div class="pp-pageHW"><a href="{{ URL::TO('team/' . $fixture->teamOne_id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamOne->name}}" data-original-title=""> <img class="img-fluid rounded-circle" src="{{url('frontend/logo')}}/{{$fixture->teamOne->team_logo}}"></a>
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
														$teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$fixture->id)->where('team_id',$fixture->teamOne_id)->whereIn('sport_stats_id',[1,54])->count();
														$teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$fixture->id)->where('team_id',$fixture->teamTwo_id)->whereIn('sport_stats_id',[1,54])->count();

														?>
														<a href="{{ URL::TO('match-fixture/' . $fixture->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$competition->name}}, Competition Type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}">
															<span class=" btn-greenFXL " target="_blank"><?php echo str_pad($teamOneGoal, 2, 0,STR_PAD_LEFT); ?></span>
															<span class=" btn-greenFXR "><?php echo str_pad($teamTwoGoal, 2, 0,STR_PAD_LEFT); ?></span> </a>
													@endif
													</td>
													<td class="LeftPosiText ">
														<div class="pp-pageHW"><a href="{{ URL::TO('team/' . $fixture->teamTwo_id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamTwo->name}}" data-original-title=""> <img class="img-fluid " src="{{url('frontend/logo')}}/{{$fixture->teamTwo->team_logo}}"></a></div>&nbsp;
														<a href="{{ URL::TO('team/' . $fixture->teamTwo_id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamTwo->name}}" data-original-title=""> <b class="WolVerWand">@php echo Str::of($fixture->teamTwo->name)->limit(13); @endphp</b></a>
													</td>
													<td>
														<span class="row teamFixutreView">
															<span class="col-md-2">
																@if($fixture->startdate_time == NULL)
																<span class="IconPLR"><a onclick="return ics_file('{{$fixture->id}}');"  style="cursor:pointer;"><i class="fa-solid fa-calendar-plus"></i></a></span>
																@else
																	@if($fixture->finishdate_time != NULL)
																		@if($fixture->fixture_type == 1)
																			<div class="Drawmatch" data-toggle="tooltip" data-placement="bottom" data-original-title="" title="Match draw"></div>
																		@else
																			@if($fixture->winner_team_id != NULL)
																			<?php $winner_team_logo = App\Models\Team::select('id','team_logo','name')->find($fixture->winner_team_id); ?>
																			<span class="tableViewFixture pp-pageHW ">
																				<a href="{{url('team/'. $winner_team_logo->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="" title="Match won">
																					<img class="rounded-circle img-fluid" src="{{url('frontend/logo')}}/{{$winner_team_logo->team_logo}}" height="30px">
																				</a>
																			</span>
																			@else
																				<div class="VotingOpenClor"></div>
																			@endif
																		@endif
																	@else
																		<div class="VotingOpenClor"></div>
																	@endif
																@endif
															</span>
															<span class="col-md-10">
																@if($fixture->startdate_time == NULL)
																	<a class="text-decoration AndyMcg" onclick="return ics_file('{{$fixture->id}}');" style="cursor:pointer"> Add to calendar <i class="fa-solid fa-angles-right"></i></a>
																@else
																<a class="text-decoration AndyMcg" href="{{ URL::TO('match-fixture/' . $fixture->id)}}" target="_blank"> VIEW FIXTURE <i class="fa-solid fa-angles-right"></i></a>
																@endif
															</span>
														</span>
													</td>
												</tr>
											@endforeach
										</table>
									</div>
								@endforeach
							</div>
						@else
						<p class="text-center"> No Data Found!!</p>
						@endif
					</div>
              	</div>
            </div>
          @else
          @endif
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
												if($secondcircle > $thirdcircle){
													$var_setL = 'max';
												}else{
													$var_setL = 'unset';
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
														--third-check: <?php echo $var_setL;?>(calc(var(--third-start) - .5), 0);
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
											if($rtf <= 5){
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
												<span class="R-Tean-form" style="background-color:#003b5f !important;"> NA</span>
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
														if($Rsecondcircle > $Rthirdcircle){
															$var_setR = 'max';
														}else{
															$var_setR = 'unset';
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
																--third-check: <?php echo $var_setR;?>(calc(var(--third-start) - .5), 0);
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
														if($rtf <= 5){
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
															<span class="R-Tean-form" style="background-color:#003b5f !important;"> NA</span>
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
				@livewire('competition.includes-league', ['competition' => $competition->id])
                </div>

	<!-- Modal fixtureModal01-->
		<!-- <div class="modal fade" id="fixtureModal01" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen-sm-down">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">View Fixture</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="create_fixtures">
						@csrf
						<input type="hidden" name="comp_id" value="{{$competition->id}}">
						<div class="modal-body" id="ScrollRight">
							<div class="row row-cols-1 row-cols-md-3 g-4">

							<?php
								if($competition->comp_subtype_id == 4)
								{
									$t_round = $total_rounds * 1;
								}
								elseif($competition->comp_subtype_id == 5)
								{
									$t_round = $total_rounds * 2;
								}
								else
								{
									$t_round = $total_rounds * 3;
								}
								for($x = 1; $x <= $t_round; $x++)
								{
									$fixtures = App\Models\Match_fixture::where('competition_id',$competition->id)->where('fixture_round', $x)->get();
									$get_fixtures = $fixtures->count();
									$blank_fix = $round_fixtures - $get_fixtures;
									?>
									<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
										<div class="card h-100">
											<div class="card-header">
												<h5 class="card-title text-center">Round-{{$x}}</h5>
											</div>
											<div class="card-body ">
												@if(Auth::check())
													@if(($competition->comp_start != 1) && (in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id)) )
														<div class="Scrollbar-card">
															<?php for($i = 0; $i < $get_fixtures; $i++)
																{ ?>
																	<div class="row mb-2">
																		<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																			<div class="floating-form ">
																				<div class="floating-label form-select-fancy-Popup">
																					<input type="hidden" name="updateround{{$x}}_fixid_{{$i}}" value="{{$fixtures[$i]['id']}}">
																					<input class="DateTimePicker" type="datetime-local"  onclick="(this.type='datetime-local')" placeholder=" " name="updateround{{$x}}_date_{{$i}}" value = "<?php $fixtures[$i]['fixture_date'] = preg_replace("/\s/",'T',$fixtures[$i]['fixture_date']); echo $fixtures[$i]['fixture_date'] ?>" >
																					<span class="highlight"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-9 text-center">
																			<div class="BgBlueVS-pop">
																				<div class="row">
																					<div class="col-md-6 col-6 ">
																						<div class="row">
																							<div class="col-md-2 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<?php $teamTL_logo = App\Models\Team::select('id','name','team_logo')->find($fixtures[$i]['teamOne_id']);?>
																										<img src="{{url('frontend/logo')}}/{{$teamTL_logo->team_logo}}" alt="SportVote Logo" class=" img-fluid" id="team_logoTL_{{$x}}_{{$i}}">
																									</div>
																								</div>
																							</div>
																							<div class="col-md-10 m-auto text-Mob-Center pr-30">
																								<select class="form-select select_team select_round_{{$x}}" aria-label="Default select example" name="updateround{{$x}}_TL_{{$i}}" id="updateround{{$x}}_TL_{{$i}}" data-round="{{$x}}" data-position="TL" data-fixture="{{$i}}">
																									<option value="0">Select Team</option>
																										@foreach($comp_teams as $key=> $teams)
																											@if($key != $x-1 && $team_type == "Odd")
																												<option value="{{$teams->team->id}}" <?php if($fixtures[$i]['teamOne_id'] == $teams->team->id){ echo "selected"; } else {}?> >@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																											@elseif($team_type == "Even")
																												<option value="{{$teams->team->id}}" <?php if($fixtures[$i]['teamOne_id'] == $teams->team->id){ echo "selected"; } else {}?> >@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																											@else
																											@endif
																										@endforeach
																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6 col-6 borLL">
																						<div class="row">
																							<div class="col-md-10 m-auto Texright pl-30 ">
																								<select class="form-select select_team" aria-label="Default select example" data-round="{{$x}}" data-position="TR" data-fixture="{{$i}}" id="updateround{{$x}}_TR_{{$i}}" name="updateround{{$x}}_TR_{{$i}}">
																									<option value="0">Select Team</option>
																									@foreach($comp_teams as $key=> $teams)
																										@if($key != $x-1 && $team_type == "Odd")
																											<option value="{{$teams->team->id}}" <?php if($fixtures[$i]['teamTwo_id'] == $teams->team->id){ echo "selected"; } else {}?> >@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																										@elseif($team_type == "Even")
																											<option value="{{$teams->team->id}}" <?php if($fixtures[$i]['teamTwo_id'] == $teams->team->id){ echo "selected"; } else {}?> >@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																										@else

																										@endif
																									@endforeach
																								</select>
																							</div>
																							<div class="col-md-2 pl-0 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<?php $teamTR_logo = App\Models\Team::select('id','name','team_logo')->find($fixtures[$i]['teamTwo_id']);?>
																										<img src="{{url('frontend/logo')}}/{{$teamTR_logo->team_logo}}" alt="SportVote Logo" class=" img-fluid " id="team_logoTR_{{$x}}_{{$i}}">
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="VsBgPopup">V/S</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																<?php }
																for($b = 0; $b< $blank_fix; $b++)
																{ ?>
																	<div class="row mb-2">
																		<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																			<div class="floating-form ">
																				<div class="floating-label form-select-fancy-Popup">
																					<input class="DateTimePicker" type="datetime-local" onclick="(this.type='datetime-local')" placeholder=" " name="round{{$x}}_date_{{$b}}">
																					<span class="highlight"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-9 text-center">
																			<div class="BgBlueVS-pop">
																				<div class="row">
																					<div class="col-md-6 col-6 ">
																						<div class="row">
																							<div class="col-md-2 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/images/TeamMore-Add.png')}}" alt="SportVote Logo" class=" img-fluid" id="team_logoTL_{{$x}}_{{$b}}">
																									</div>
																								</div>
																							</div>
																							<div class="col-md-10 m-auto text-Mob-Center pr-30">
																								<select class="form-select  select_team" aria-label="Default select example" name="round{{$x}}_TL_{{$b}}" id="round{{$x}}_TL_{{$b}}" data-round="{{$x}}" data-position="TL" data-fixture="{{$b}}">
																									<option value="">Select Team</option>
																									@foreach($comp_teams as $key=> $teams)
																									@if($key != $x-1 && $team_type == "Odd")
																										<option value="{{$teams->team->id}}">@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																									@elseif($team_type == "Even")
																										<option value="{{$teams->team->id}}">@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																									@else

																									@endif
																									@endforeach
																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6 col-6 borLL">
																						<div class="row">
																							<div class="col-md-10 m-auto Texright pl-30 ">
																								<select class="form-select select_team" aria-label="Default select example" id="round{{$x}}_TR_{{$b}}" name="round{{$x}}_TR_{{$b}}" data-round="{{$x}}" data-position="TR" data-fixture="{{$b}}">
																									<option value="">Select Team</option>
																									@foreach($comp_teams as $key=> $teams)
																									@if($key != $x-1 && $team_type == "Odd")
																										<option value="{{$teams->team->id}}">@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																									@elseif($team_type == "Even")
																										<option value="{{$teams->team->id}}">@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																									@else

																									@endif
																									@endforeach
																								</select>
																							</div>
																							<div class="col-md-2 pl-0 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/images/TeamMore-Add.png')}}" alt="SportVote Logo" class=" img-fluid " id="team_logoTR_{{$x}}_{{$b}}">
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="VsBgPopup">V/S</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
															<?php }?>
														</div>
													@else
														@if($fixtures->count() > 0)
															<div class="Scrollbar-card">
																@foreach($fixtures as $fix)
																	<?php
																		$teamOne = App\Models\Team::select('id','name','team_logo')->find($fix->teamOne_id);
																		$teamTwo = App\Models\Team::select('id','name','team_logo')->find($fix->teamTwo_id);
																	?>
																	<div class="row mb-2">
																		<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																			<div class="floating-form ">
																				<div class="floating-label form-select-fancy-Popup">
																					<input class="floating-input" type="date" onclick="(this.type='date')" placeholder=" " value = "{{ date('Y-m-d', strtotime($fix['fixture_date'])) }}" readonly>
																					<span class="highlight"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-9 text-center">
																			<div class="BgBlueVS-pop">
																				<div class="row">
																					<div class="col-md-6 col-6 ">
																						<div class="row">
																							<div class="col-md-2 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/logo')}}/{{$teamOne->team_logo}}" alt="SportVote Logo" class=" img-fluid">
																									</div>
																								</div>
																							</div>
																							<div class="col-md-10 m-auto text-Mob-Center pr-30">
																								<label title="{{$teamOne->name}}">@php echo Str::of($teamOne->name)->limit(12); @endphp</label>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6 col-6 borLL">
																						<div class="row">
																							<div class="col-md-10 m-auto Texright pl-30 ">
																								<label title="{{$teamTwo->name}}">
																								@php echo Str::of($teamTwo->name)->limit(12); @endphp
																								</label>
																							</div>
																							<div class="col-md-2 pl-0 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/logo')}}/{{$teamTwo->team_logo}}" alt="SportVote Logo" class=" img-fluid ">
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="VsBgPopup">V/S</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																@endforeach
															</div>
														@else
															<p class="text-center"> No Data Found</p>
														@endif
													@endif
												@else
												@endif
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							@if(Auth::check())
								@if(($competition->comp_start != 1) && (in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id)) )
								<button type="submit" class="btn btn-primary" id="save_fixture">Submit</button>
								@else
								@endif
							@else
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	End K.O Fixture -->

	<!-- Modal create fixtureModal01-->
		<div class="modal fade" id="fixtureModal01" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen-sm-down">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Create League Fixtures</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="create_fixtures">
						@csrf
						<input type="hidden" name="comp_id" value="{{$competition->id}}">
						<div class="modal-body" id="ScrollRight">
							<div class="row row-cols-1 row-cols-md-3 g-4">

							<?php
								if($competition->comp_subtype_id == 4)
								{
									$t_round = $total_rounds * 1;
								}
								elseif($competition->comp_subtype_id == 5)
								{
									$t_round = $total_rounds * 2;
								}
								else
								{
									$t_round = $total_rounds * 3;
								}
								for($x = 1; $x <= $t_round; $x++)
								{
									$fixtures = App\Models\Match_fixture::where('competition_id',$competition->id)->where('fixture_round', $x)->get();
									$get_fixtures = $fixtures->count();
									$blank_fix = $round_fixtures - $get_fixtures;
									$mindate = date("Y-m-d");
									$mintime = date("h:i");
									$min_Date = $mindate."T".$mintime;
									?>
									<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
										<div class="card h-100">
											<div class="card-header position-relative ">
												<h5 class="card-title text-center">Round-{{$x}}</h5>
												<div class="inputtcla position-absolute">
													<input class="DateTimePicker" type="datetime-local" onclick="(this.type='datetime-local')" min="<?php echo $min_Date; ?>" placeholder=" " id="roundDefaultDate{{$x}}" onchange="roundDefaultdate({{$x}},{{$blank_fix}});" name="roundDefaultDate{{$x}}">
												</div>
											</div>
											<div class="card-body ">
												@if(Auth::check())
													@if(($competition->comp_start != 1) && (in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id)) )
														<div class="Scrollbar-card">
																<?php
																for($b = 0; $b< $blank_fix; $b++)
																{ ?>
																	<div class="row mb-2">
																		<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																			<div class="floating-form ">
																				<div class="floating-label form-select-fancy-Popup">
																					<input class="DateTimePicker" type="datetime-local" onclick="(this.type='datetime-local')" min="<?php echo $min_Date; ?>" placeholder=" " id="round{{$x}}_date_{{$b}}" name="round{{$x}}_date_{{$b}}">
																					<span class="highlight"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-9 text-center">
																			<div class="BgBlueVS-pop">
																				<div class="row">
																					<div class="col-md-6 col-6 ">
																						<div class="row">
																							<div class="col-md-2 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/images/TeamMore-Add.png')}}" alt="SportVote Logo" class=" img-fluid" id="team_logoTL_{{$x}}_{{$b}}">
																									</div>
																								</div>
																							</div>
																							<div class="col-md-10 m-auto text-Mob-Center pr-30">
																								<select class="form-select  select_team" aria-label="Default select example" name="round{{$x}}_TL_{{$b}}" id="round{{$x}}_TL_{{$b}}" data-round="{{$x}}" data-position="TL" data-fixture="{{$b}}">
																									<option value="">Select Team</option>
																									@foreach($comp_teams as $key=> $teams)
																										<option value="{{$teams->team->id}}">@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																									@endforeach
																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6 col-6 borLL">
																						<div class="row">
																							<div class="col-md-10 m-auto Texright pl-30 ">
																								<select class="form-select select_team" aria-label="Default select example" id="round{{$x}}_TR_{{$b}}" name="round{{$x}}_TR_{{$b}}" data-round="{{$x}}" data-position="TR" data-fixture="{{$b}}">
																									<option value="">Select Team</option>
																										@foreach($comp_teams as $key=> $teams)
																												<option value="{{$teams->team->id}}">@php echo Str::of($teams->team->name)->limit(12); @endphp</option>

																										@endforeach
																								</select>
																							</div>
																							<div class="col-md-2 pl-0 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/images/TeamMore-Add.png')}}" alt="SportVote Logo" class=" img-fluid "  id="team_logoTR_{{$x}}_{{$b}}">
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="VsBgPopup">V/S</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
															<?php }?>
														</div>
													@else
														@if($fixtures->count() > 0)
															<div class="Scrollbar-card">
																@foreach($fixtures as $fix)
																	<?php
																		$teamOne = App\Models\Team::select('id','name','team_logo')->find($fix->teamOne_id);
																		$teamTwo = App\Models\Team::select('id','name','team_logo')->find($fix->teamTwo_id);
																	?>
																	<div class="row mb-2">
																		<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																			<div class="floating-form ">
																				<div class="floating-label form-select-fancy-Popup">
																					<input class="floating-input" type="date" onclick="(this.type='date')" placeholder=" "  min="<?=date('Y-m-d', strtotime(date('Y-m-d ')));?>" value = "{{ date('Y-m-d', strtotime($fix['fixture_date'])) }}" readonly>
																					<span class="highlight"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-9 text-center">
																			<div class="BgBlueVS-pop">
																				<div class="row">
																					<div class="col-md-6 col-6 ">
																						<div class="row">
																							<div class="col-md-2 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/logo')}}/{{$teamOne->team_logo}}" alt="SportVote Logo" class=" img-fluid">
																									</div>
																								</div>
																							</div>
																							<div class="col-md-10 m-auto text-Mob-Center pr-30">
																								<label title="{{$teamOne->name}}">@php echo Str::of($teamOne->name)->limit(12); @endphp</label>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6 col-6 borLL">
																						<div class="row">
																							<div class="col-md-10 m-auto Texright pl-30 ">
																								<label title="{{$teamTwo->name}}">
																								@php echo Str::of($teamTwo->name)->limit(12); @endphp
																								</label>
																							</div>
																							<div class="col-md-2 pl-0 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/logo')}}/{{$teamTwo->team_logo}}" alt="SportVote Logo" class=" img-fluid ">
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="VsBgPopup">V/S</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																@endforeach
															</div>
														@else
															<p class="text-center"> No Data Found</p>
														@endif
													@endif
												@else
												@endif
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							@if(Auth::check())
								@if(($competition->comp_start != 1) && (in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id)) )
								<button type="submit" class="btn btn-primary" id="save_fixture">Submit</button>
								@else
								@endif
							@else
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	<!-- End create fixtureModal01 -->

	<!-- Modal Edit fixtureModal01-->
		<div class="modal fade" id="editfixtureModal01" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen-sm-down">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">All League Fixtures</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="edit_fixtures">
						@csrf
						<input type="hidden" name="comp_id" value="{{$competition->id}}">
						<div class="modal-body" id="ScrollRight">
							<div class="row row-cols-1 row-cols-md-3 g-4">
							<?php
								if($competition->comp_subtype_id == 4)
								{
									$t_round = $total_rounds * 1;
								}
								elseif($competition->comp_subtype_id == 5)
								{
									$t_round = $total_rounds * 2;
								}
								else
								{
									$t_round = $total_rounds * 3;
								}
								for($x = 1; $x <= $t_round; $x++)
								{
									$fixtures = App\Models\Match_fixture::where('competition_id',$competition->id)->where('fixture_round', $x)->get();
									$get_fixtures = $fixtures->count();
									$blank_fix = $round_fixtures - $get_fixtures;
									?>
									<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
										<div class="card h-100">
											<div class="card-header">
												<h5 class="card-title text-center">Round-{{$x}}</h5>
											</div>
											<div class="card-body ">
												@if(Auth::check())
													@if(($competition->comp_start != 1) && (in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id)) )
														<div class="Scrollbar-card">
															<?php for($i = 0; $i < $get_fixtures; $i++)
															{ ?>
																<div class="row mb-2">
																	<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																		<div class="floating-form ">
																			<div class="floating-label form-select-fancy-Popup">
																				<input type="hidden" name="updateround{{$x}}_fixid_{{$i}}" value="{{$fixtures[$i]['id']}}" data-form="1">
																				<input class="DateTimePicker" type="datetime-local"  onclick="(this.type='datetime-local')" placeholder=" " min="<?php echo $min_Date; ?>" name="updateround{{$x}}_date_{{$i}}" value = "<?php $fixtures[$i]['fixture_date'] = preg_replace("/\s/",'T',$fixtures[$i]['fixture_date']); echo $fixtures[$i]['fixture_date'] ?>" >
																				<span class="highlight"></span>
																			</div>
																		</div>
																	</div>
																	<div class="col-9 text-center">
																		<div class="BgBlueVS-pop">
																			<div class="row">
																				<div class="col-md-6 col-6 ">
																					<div class="row">
																						<div class="col-md-2 m-auto text-center">
																							<div class="bgBlueVs">
																								<div class="game-logoPopup m-auto">
																									<?php $teamTL_logo = App\Models\Team::select('id','name','team_logo')->find($fixtures[$i]['teamOne_id']);?>
																									<img src="{{url('frontend/logo')}}/{{$teamTL_logo->team_logo}}" alt="SportVote Logo" class=" img-fluid" id="edit_team_logoTL_{{$x}}_{{$i}}">
																								</div>
																							</div>
																						</div>
																						<div class="col-md-10 m-auto text-Mob-Center pr-30">
																							<select class="form-select select_edit_team select_round_{{$x}}" aria-label="Default select example" name="updateround{{$x}}_TL_{{$i}}" id="updateround{{$x}}_TL_{{$i}}" data-round="{{$x}}" data-position="TL" data-fixture="{{$i}}">
																								<option value="">Select Team</option>
																									@foreach($comp_teams as $key=> $teams)
																											<option value="{{$teams->team->id}}" <?php if($fixtures[$i]['teamOne_id'] == $teams->team->id){ echo "selected"; } else {}?>>@php echo Str::of($teams->team->name)->limit(12); @endphp</option>

																									@endforeach
																							</select>
																						</div>
																					</div>
																				</div>
																				<div class="col-md-6 col-6 borLL">
																					<div class="row">
																						<div class="col-md-10 m-auto Texright pl-30 ">
																							<select class="form-select select_edit_team" aria-label="Default select example" data-round="{{$x}}" data-position="TR" data-fixture="{{$i}}" id="updateround{{$x}}_TR_{{$i}}" name="updateround{{$x}}_TR_{{$i}}">
																								<option value="">Select Team</option>
																									@foreach($comp_teams as $key=> $teams)
																										<option value="{{$teams->team->id}}" <?php if($fixtures[$i]['teamTwo_id'] == $teams->team->id){ echo "selected"; } else {}?>>@php echo Str::of($teams->team->name)->limit(12); @endphp</option>
																									@endforeach
																							</select>
																						</div>
																						<div class="col-md-2 pl-0 m-auto text-center">
																							<div class="bgBlueVs">
																								<div class="game-logoPopup m-auto">
																									<?php $teamTR_logo = App\Models\Team::select('id','name','team_logo')->find($fixtures[$i]['teamTwo_id']);?>
																									<img src="{{url('frontend/logo')}}/{{$teamTR_logo->team_logo}}" alt="SportVote Logo" class=" img-fluid " id="edit_team_logoTR_{{$x}}_{{$i}}">
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="VsBgPopup">V/S</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															<?php }?>
														</div>
													@else
														@if($fixtures->count() > 0)
															<div class="Scrollbar-card">
																@foreach($fixtures as $fix)
																	<?php
																		$teamOne = App\Models\Team::select('id','name','team_logo')->find($fix->teamOne_id);
																		$teamTwo = App\Models\Team::select('id','name','team_logo')->find($fix->teamTwo_id);
																	?>
																	<div class="row mb-2">
																		<div class="col-3 FlotingLabelUp pr-0 pr-0 ">
																			<div class="floating-form ">
																				<div class="floating-label form-select-fancy-Popup">
																					<input class="floating-input" type="date" onclick="(this.type='date')" placeholder=" " value = "{{ date('Y-m-d', strtotime($fix['fixture_date'])) }}" readonly>
																					<span class="highlight"></span>
																				</div>
																			</div>
																		</div>
																		<div class="col-9 text-center">
																			<div class="BgBlueVS-pop">
																				<div class="row">
																					<div class="col-md-6 col-6 ">
																						<div class="row">
																							<div class="col-md-2 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/logo')}}/{{$teamOne->team_logo}}" alt="SportVote Logo" class=" img-fluid">
																									</div>
																								</div>
																							</div>
																							<div class="col-md-10 m-auto text-Mob-Center pr-30">
																								<label title="{{$teamOne->name}}">@php echo Str::of($teamOne->name)->limit(12); @endphp</label>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6 col-6 borLL">
																						<div class="row">
																							<div class="col-md-10 m-auto Texright pl-30 ">
																								<label title="{{$teamTwo->name}}">
																								@php echo Str::of($teamTwo->name)->limit(12); @endphp
																								</label>
																							</div>
																							<div class="col-md-2 pl-0 m-auto text-center">
																								<div class="bgBlueVs">
																									<div class="game-logoPopup m-auto">
																										<img src="{{url('frontend/logo')}}/{{$teamTwo->team_logo}}" alt="SportVote Logo" class=" img-fluid ">
																									</div>
																								</div>
																							</div>
																						</div>
																						<div class="VsBgPopup">V/S</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																@endforeach
															</div>
														@else
															<p class="text-center"> No Data Found</p>
														@endif
													@endif
												@else
												@endif
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							@if(Auth::check())
								@if(($competition->comp_start != 1) && (in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id)) )
								<button type="submit" class="btn btn-primary" id="save_fixture">Submit</button>
								@else
								@endif
							@else
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	<!-- End edit fixtureModal01 -->

<!-- Modal top 5 player -->
<div class="modal fade" id="top_teams_view_full_ranking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Full Rankings Table (Teams)</h5>
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



<!-- Modal top 5 player -->
<div class="modal fade" id="top_player_view_full_ranking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Full Rankings Table (Players)</h5>
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

<input type="hidden" id="comp_id" value="{{$competition->id}}">
<!-- The Modal Add Admin-->
<div class="modal fade" id="add_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>

	  </div>
	  <div class="modal-body">
			<select class="typeahead grey-form-control" multiple="multiple" id="users_ids" width="100%"></select>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal">Close</button>
		<button type="button" class="btn btn-primary" id="send_admin_request">Send Request</button>
	  </div>
	</div>
  </div>
</div>
<!-- The Modal View ALL MVP winners Model-->
<div class="modal fade" id="view_all_winners_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bgDark">
          <h5 class="modal-title btn-secondaryTable" id="exampleModalLabel">ALL MVP WINNERS</h5>
        </div>
        <div class="modal-body">
          @if(count($recent_winner) > 0)
            <?php $mvp_winner = array(); ?>
            @foreach($recent_winner as $mvp)
              <?php $mvp_winner[$mvp['player_id']] = $mvp['total'] ?>
            @endforeach
            <?php
              arsort($mvp_winner);
              $winner_data = array_chunk($mvp_winner,5, true);
            ?>
            <div class="owlToper owl-carousel owl-theme owlWinners">
              @foreach($winner_data as $data)
                <div class="item">
                  @foreach($data as $player_id => $votes)
                    <?php $player_info = App\Models\User::select('id','first_name','last_name','profile_pic')->find($player_id);
                    $playerteam_id = App\Models\Match_fixture_stat::where('competition_id',$competition->id)->where('player_id',$player_id)->value('team_id');
                    $playerteam = App\Models\Team::select('name','id')->find($playerteam_id);
                    $player_jersey_num = App\Models\Team_member::where('team_id',$playerteam_id)->where('member_id',$player_id)->value('jersey_number');?>
                    <div class=" W-100">
                      <li class="list-group-item d-flex justify-content-between align-items-start">
                      <style>
                          .mvpplayer<?php echo $playerteam_id; ?>:after {
                          color:<?php echo @$playerteam->team_color;?>;
                        }
                      </style>
                        <span class="jersy-noTopFIve team-jersy-TopPlayer mvpplayer{{$playerteam_id}}">{{$player_jersey_num}}</span>
                        <img class="img-fluid rounded-circle rounded-circle padd-RL" src="{{url('frontend/profile_pic')}}/{{$player_info->profile_pic}}" style="width:25% !important;">
                        <div class="ms-2 me-auto EngCity">
                          <div class=" ManCity">
                            <a href="{{ URL::to('player_profile/' . $player_id) }}" target="_blank"> {{$player_info->first_name}} {{$player_info->last_name}} </a>
                          </div>
                          <a href="{{ URL::to('team/' . $playerteam_id) }}" target="_blank"> @php echo str::of(@$playerteam->name)->limit(13); @endphp </a>
                        </div>
                        <span class="badge">{{$votes}}</span>
                      </li>
                    </div>
                  @endforeach
                </div>
              @endforeach
            </div>
          @else
          @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_view_all_winners">Close</button>
        </div>
      </div>
    </div>
  </div>

	<!-- Competition Banner Model Start-->
	<div class="modal fade" id="edit_banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Competition banner</h5>
				</div>
				<div class="modal-body"><br>
					<div class="">
						<div class="row">
							<div class=" col-md-12 mb-4 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="file" id="comp_banner" placeholder=" " name="comp_banner">
										<span class="highlight"></span>
										<label>Select Competition banner</label>
									</div>
								</div>
							</div>
							Photo Preview:
							<div class="row">
								<div class="col-md-12 card me-1 mb-1">
									<img src="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="bannerModelClose" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Competition Banner Model End-->

	<!-- Competition Logo Model Start-->
	<div class="modal fade" id="edit_complogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Competition Logo</h5>
					</div>
					<div class="modal-body">
						<div class="">
							<div class="row">
								<div class=" col-md-12 mb-4 FlotingLabelUp">
									<div class="floating-form "></br>
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="file" id="compLogo" placeholder=" " name="file">
											<span class="highlight"></span>
											<label>Select Competition Logo</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Competition Logo Model End-->
	<!-- Competiton info edit Model -->
	<div class="modal fade" id="editCompInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Info</h5>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form">
									<div class="floating-label form-select-fancy-1">
										<input name="comp_name" id="comp_name" class="floating-input" type="text" placeholder=" " value="">
										<span class="highlight"></span>
										<label>Competition Name</label>
									</div>
								</div>
								@error('comp_name') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="text" name="complocation" id="complocation" placeholder=" " value="">
										<span class="highlight"></span>
										<label>Location</label>
									</div>
								</div>
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
								<span class="round01"></span>
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" id="compReport_type" >
											<option value="" @if($competition->comp_start == 1) disabled @else @endif ></option>
											@foreach($com_report_type as $comp_report)
											<option value="{{$comp_report->id}}" @if($competition->comp_start == 1) disabled @else @endif>{{$comp_report->name}}</option>
											@endforeach
										</select>
										<span class="highlight"></span>
										<label>Select Report Type</label>
									</div>
								</div>
                                @error('report_type') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<span class="round01"></span>
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" id="compVote_mins">
											<option value="" @if($competition->comp_start == 1) disabled @else @endif ></option>
											<option value="2" @if($competition->comp_start == 1) disabled @else @endif >2</option>
											<option value="4" @if($competition->comp_start == 1) disabled @else @endif >4</option>
											<option value="5" @if($competition->comp_start == 1) disabled @else @endif >5</option>
											<option value="10" @if($competition->comp_start == 1) disabled @else @endif >10</option>
											<option value="15" @if($competition->comp_start == 1) disabled @else @endif >15</option>
											<option value="20" @if($competition->comp_start == 1) disabled @else @endif >20</option>
											<option value="25" @if($competition->comp_start == 1) disabled @else @endif >25</option>
											<option value="30" @if($competition->comp_start == 1) disabled @else @endif >30</option>
										</select>
										<span class="highlight"></span>
										<label>Vote Timer Length</label>
									</div>
								</div>
                                @error('vote_mins') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-6 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="number" value="" min="" name="squad_players_num" id="squad_players_num" @if($competition->comp_start == 1) disabled @else @endif>
										<span class="highlight"></span>
										<label># Squad Players</label>
									</div>
								</div>
                                @error('squad_players_num') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
							<div class=" col-md-6 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="number" value="" min="1" id="lineup_players_num" name="lineup_players_num" @if($competition->comp_start == 1) disabled @else @endif>
										<span class="highlight"></span>
										<label># Starting Players</label>
									</div>
								</div>
                                @error('lineup_players_num') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						@if($competition->comp_type_id != 1)
							<div class="row mb-4 mt-4">
								<div class=" col-md-6 FlotingLabelUp mb-20">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="month" min="2023-01" value="" name="seasonStart" id="seasonStart">
											<span class="highlight"></span>
											<label># Season Start</label>
										</div>
									</div>
									@error('seasonStart') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
								<div class=" col-md-6 FlotingLabelUp mb-20">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="month" min="2023-01" value="" name="seasonEnd" id="seasonEnd">
											<span class="highlight"></span>
											<label># Season End</label>
										</div>
									</div>
									@error('seasonEnd') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						@endif
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="closeCompinfoModel">Close</button>
					<button type="button" class="btn" style="background-color:#003b5f; color:#fff;" id="save_info">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Competiton info edit Model -->
	<!-- Join Competition Model -->
	<div class="modal fade" id="joinCompModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Join A Competiton</h5>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" wire:model="join_member_position">
											<option value=""></option>
											<option value="">Select Position</option>
                                            <option value="1">Head Referee</option>
                                            <option value="2">Assistant Referee</option>
                                            <option value="3">Video Assistant Referee</option>
										</select>
										<span class="highlight"></span>
										<label>Preferred Position*</label>
									</div>
									@error('join_member_position') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label ">
										<textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30" rows="3"  placeholder=" " wire:model = "join_reason"></textarea>
										<span class="highlight"></span>
										<label class="TeamDescrForm">Cover letter*</label>
									</div>
									@error('join_reason') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" wire:model="join_member_position1">
											<option value=""></option>
											<option value="">Select Position</option>
                                            <option value="1">Head Referee</option>
                                            <option value="2">Assistant Referee</option>
                                            <option value="3">Video Assistant Referee</option>
										</select>
										<span class="highlight"></span>
										<label>Alternative Position 1</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" wire:model="join_member_position2">
											<option value=""></option>
											<option value="">Select Position</option>
                                            <option value="1">Head Referee</option>
                                            <option value="2">Assistant Referee</option>
                                            <option value="3">Video Assistant Referee</option>
										</select>
										<span class="highlight"></span>
										<label>Alternative Position 2</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_join_modal">Close</button>
				<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="join_competition">Join</button>
			  </div>
			</div>
		</div>
	</div>
	<!-- Join Competition Model -->

<!-- The Modal Add Referee-->
<div class="modal fade" id="add_referee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Add Referee</h5>
	  </div>
	  <div class="modal-body">
			<select class="typeahead_referee grey-form-control" multiple="multiple" id="referee_ids" width="100%"></select>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal_add_referee">Close</button>
		<button type="button" class="btn btn-primary" id="send_referee_request">Send Request</button>
	  </div>
	</div>
  </div>
</div>
<!-- contact us modal -->
<div class="modal fade" id="contact_us_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row mb-4 mt-4">
						<div class=" col-md-12 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">
									<input class="floating-input" type="email" placeholder=" " id= "comp_email" value="{{$competition->comp_email}}">
									<span class="highlight"></span>
									<label>Email:</label>
								</div>
							</div>
							<span class="sv_error" id="comp_email_error"></span>
						</div>
					</div>
					<div class="row mb-4 mt-4">
						<div class=" col-md-12 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">
									<input class="floating-input" type="number" placeholder=" " id="comp_phonenumber" value="{{$competition->comp_phone_number}}" min="1" max="15">
									<span class="highlight"></span>
									<label>Phone number:</label>
								</div>
							</div>
							<span class="sv_error" id="comp_phoneno_error"></span>
						</div>
					</div>
					<div class="row mb-4 mt-4">
						<div class=" col-md-12 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">
									<textarea class="floating-input" type="address" placeholder=" " value="{{$competition->comp_address}}" id="comp_address">{{$competition->comp_address}}</textarea>
									<span class="highlight"></span>
									<label>Address:</label>
								</div>
							</div>
							<span class="sv_error" id="comp_addressh_error"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_contact_us">Close</button>
				<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" id="save_comp_contact">Save changes</button>
			</div>
		</div>
	</div>
</div>
 </main>
<style>
	.swal-modal .swal-text{
		font-size: 32px;
    	text-align: center;
	}


</style>
@include('frontend.includes.footer')
<script type="text/javascript" src="{{url('frontend/js/jquery2.min.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>
<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
	var comp_id = <?php echo $competition->id; ?>;
	$('#comp_banner').on("change", function(){
		$("#edit_banner").hide();
		$(".modal-backdrop.fade.show").hide();
		$("body").addClass("unsetOverflowComp");
	});
	$('#compLogo').on("change", function(){
		$("#edit_complogo").hide();
		$(".modal-backdrop.fade.show").hide();
		$("body").addClass("unsetOverflowComp");
	});
	$('#comp_banner').ijaboCropTool({
		preview : '',
		setRatio:3,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl:'{{ url("edit_compbanner/")}}/'+comp_id,
        withCSRF:['_token','{{ csrf_token() }}'],
		onSuccess:function(message, element, status){
			//location.reload();
			if(status == 1){
				var bannerUrl = "<?php echo $url;?>/public/frontend/banner/"+message;
				$("#CompPageBanner").css("background-image", "url(" + bannerUrl + ")");
			}
		},
		onError:function(message, element, status){
		    //alert(message);
		}
	});

	$('#compLogo').ijaboCropTool({
		preview : '.competitionlogo',
		setRatio:1,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl:'{{ url("edit_complogo/")}}/'+comp_id,
        withCSRF:['_token','{{ csrf_token() }}'],
		onSuccess:function(message, element, status){
			$("#CompPageLogo").attr('src', '{{url("frontend/logo/")}}/'+message);
			//location.reload();
		},
		onError:function(message, element, status){
		    alert(message);
		}
	});
</script>
    <script type="text/javascript">
		$("#closeCompinfoModel").on("click", function(){
			$("#editCompInfo").hide();
			$(".modal-backdrop.fade.show").hide();
			$("body").addClass("unsetOverflowComp");
		});
</script>
    <script type="text/javascript">
		$("#compEditInfo").on("click", function(){
			var compeId = <?php echo $competition->id; ?>;
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				url:'{{url("comp-info")}}',
				type:'get',
				data:{compeId:compeId},
				success:function(data)
				{
					var info = data.comp_info;
					$("#comp_name").val(info.name);
					$("#complocation").val(info.location);
					$("#compReport_type option[value="+info.report_type+"]").attr('selected', 'selected');
					$("#compVote_mins option[value="+info.vote_mins+"]").attr('selected', 'selected');
					$("#squad_players_num").val(info.squad_players_num);
					$("#lineup_players_num").val(info.lineup_players_num);
					if(info.comp_season_start != "" || info.comp_season_start != null){
						let date = info.comp_season_start.slice("-");
						let month = date[1];
						let year = date[0];
						$("#seasonStart").val(year+'-'+month);
					}else{
						var current = "<?php echo date('YY-m'); ?>";
						$("#seasonStart").val(current);
					}
					if(info.comp_season_end != "" || info.comp_season_end != null){
						$("#seasonEnd").val(info.comp_season_end);
					}else{
						var current1 = "<?php echo date('YY-m'); ?>";
						$("#seasonEnd").val(current1);
					}
					new bootstrap.Modal(document.querySelector("#editCompInfo")).show();
				}
			});
		});

		$("#save_info").on("click", function(){
			var compeId = <?php echo $competition->id; ?>;
			var comp_name = $("#comp_name").val();
			var location = $("#complocation").val();
			var report_type = $("#compReport_type").find(":selected").val();
			var vote_mins = $("#compVote_mins").find(":selected").val();
			var squad_players_num = $("#squad_players_num").val();
			var lineup_players_num = $("#lineup_players_num").val();
			var seasonStart = $("#seasonStart").val();
			var seasonEnd = $("#seasonEnd").val();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				url:'{{url("save_info")}}',
				type:'get',
				data:{
					compeId:compeId,
					comp_name: comp_name,
					location:location,
					report_type:report_type,
					vote_mins:vote_mins,
					squad_players_num:squad_players_num,
					lineup_players_num:lineup_players_num,
					seasonStart:seasonStart,
					seasonEnd:seasonEnd,
				},
				success:function(data)
				{
					console.log(data);
					if(data.status == 1)
					{

					}
				}
			});
		});
</script>
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
        }).trigger('to.owl.carousel', [parseInt(parseInt("{{$centerIndex}}")), 50, true])
        $(document).ready(function () {
            var li = $(".owl-item li ");
            $(".owl-item li").click(function () {
                li.removeClass('active');
            });
        });
    </script>
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
<script>
  $(document).on('click','#wait_for_referee',function(){
    alert('Competiton referee is required for competition');
  })
</script>
<script>
 $(document).on('click','#view_all_winners',function(){
	 $('#view_all_winners_modal').modal('show');
})
</script>
<script>
$(document).on('click','#close_view_all_winners',function(){
	 $('#view_all_winners_modal').modal('hide');
})
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
	$(document).on('click','#close_modal_top_player_ranking',function(){
		$('#top_player_view_full_ranking').modal('hide');
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
$(document).on('click','#close_modal_top_team_ranking',function(){
	 $('#top_teams_view_full_ranking').modal('hide');
})
</script>
<script>
  // let roundData = [];
  // let tempTeam = [];
  // let tempRound = [];
  // let comp_teams = @json($comp_teams);
  // $('#create_fixtures select').on('change',function(e){
  //   let selVal = $(this).val();
  //   let selRound = $(this).attr('data-round');


  //   let json = {
  //     value:selVal,
  //     round:selRound
  //   }
  //   if(tempTeam.include(selVal) && tempRound.include(selRound)){

  //     if(roundData.length == 0){
  //       roundData.push(json)
  //     }else{
  //       if(comp_teams.length){
  //         $(`effectedSelect${}`).
  //       }
  //     }
  //   }else{
  //     if(!tempTeam.include(selVal)){
  //       tempTeam.push(selVal)
  //     }
  //     if(!tempRound.include(selRound)){
  //       tempRound.push(selRound)
  //     }
  //     roundData.push(json)
  //   }
  //   //createing default value for select
  // })
</script>
<script>
$('body').on('click','.open_admin_popup',function(e){
    e.preventDefault();
    $('#add_admin').modal('show');

})
</script>
<script>
$('body').on('click','.open_referee_popup',function(e){
    e.preventDefault();
    $('#add_referee').modal('show');

})
</script>
<script>
$('body').on('click','#close_modal',function(){
	 $('#add_admin').modal('hide');
})
</script>
<script>
$('body').on('click','#close_modal_add_referee',function(){
	 $('#add_referee').modal('hide');
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('.typeahead').select2({
        placeholder: 'Select Admin',
        ajax: {
            url: "{{ url('autosearch_user_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name+' '+item.l_name,
                            id: item.id
                        }
                    })
                };
            },


            cache: true
        }
    });
</script>
<script type="text/javascript">
    $('.typeahead_referee').select2({
        placeholder: 'Select Referee',
        ajax: {
            url: "{{ url('autosearch_user_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name+' '+item.l_name,
                            id: item.id
                        }
                    })
                };
            },
        cache: true
        }
    });
</script>
<script>
$(document).on('click','#send_admin_request',function(){
	var admins_ids = $('#users_ids').val();
	var comp_id = $('#comp_id').val();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("send_invitation_comp_admins")}}',
		type:'post',
		data:{admins_ids:admins_ids,comp_id:comp_id},
		error:function(){

		},
		success:function(response)
		{
			$("#add_admin").hide();
			$(".modal-backdrop.fade.show").hide();
			$("body").addClass("unsetOverflowComp");
			// location.reload();
		}
	});
})
</script>
<script>
$(document).on('click','#send_referee_request',function(){
	var admins_ids = $('#referee_ids').val();
	var comp_id = $('#comp_id').val();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("send_invitation_referee_admins")}}',
		type:'post',
		data:{admins_ids:admins_ids,comp_id:comp_id},
		error:function(){

		},
		success:function(response)
		{
			$("#add_referee").hide();
			$(".modal-backdrop.fade.show").hide();
			$("body").addClass("unsetOverflowComp");
			// location.reload();
		}
	});
})
</script>

 <script>
$(document).on('click','#contact_us',function(){
	 $('#contact_us_modal').modal('show');
})
</script>
<script>
$(document).on('click','#close_contact_us',function(){
		$('#contact_us_modal').modal('hide');
})
</script>
<script>
	function roundDefaultdate(round,fixtures)
	{
		var roundno = round;
		var fixturesno = fixtures;
		var defaultDate = $("#roundDefaultDate"+roundno).val();
		for(var i = 0; i < fixturesno; i++)
		{
			$("#round"+roundno+"_date_"+i).val(defaultDate);
		}
	}
</script>

<script>
	$(document).on('click','#save_comp_contact',function(){
		var x = 0;
		var comp_id = $('#comp_id').val();
		var comp_email = $('#comp_email').val();
		var comp_phonenumber = $('#comp_phonenumber').val();
		var comp_address = $('#comp_address').val();
		var phoneNum = comp_phonenumber.replace(/[^\d]/g, '');
		if(phoneNum != ''){
			if(phoneNum.length >15){
				$('#comp_phoneno_error').html("Phone number must not be greater than 15 digits.");
				x++;
			}else{
				$('#comp_phoneno_error').html('');
			}
		}
		if(comp_address != ''){
			if(comp_address.length > 250){
				$('#comp_addressh_error').html("Address must not be greater than 250 characters.");
				x++;
			}else{
				$('#comp_addressh_error').html('');
			}
		}
		//alert(comp_email+','+comp_phonenumber+','+comp_address);
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(comp_email.match(mailformat))
		{
			if(x == 0){
				$('#comp_email_error').html("");
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
					url:'{{url("save_comp_contact")}}',
					type:'post',
					data:{comp_id:comp_id,comp_email:comp_email,comp_phonenumber:comp_phonenumber,comp_address:comp_address},
					error:function(){
						alert('something went wrong');
					},
					success:function(response)
					{
						$('#contact_us_modal').modal('hide');
					}
				});
			}
		}
		else
		{
			$('#comp_email_error').html("Enter valid email");
		}
	})

</script>
<script>
	function getFixtures(clas){
		var comp_id = $("#"+clas).attr('data-compId');
		var fistureMonth = $("#"+clas).attr('data-month');
		var fixtureYear = $("#"+clas).attr('data-year');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("get-fixtures")}}',
			type:'get',
			data:{comp_id:comp_id,fistureMonth:fistureMonth,fixtureYear:fixtureYear,},
			success:function(response)
			{
				console.log('Get fixtures',response);
				$("#activefixtab").html(response);
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
				});
			}
		});
	};
	function ics_file(fixId){
		var fixtureId = fixId;
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("ics_file")}}/'+fixtureId,
			type:'get',
			data:{},
			success:function(response)
			{
				console.log('Get fixtures',response);
			}
		});
	};
</script>
<!-- <script>
	$(".select_team").change(function(e){
    var $s = $(e.target);
    console.log($s);
    $(".select_team").not($s).find("option[value="+$s.val()+"]").remove();
});
</script> -->
 <script>
	var exist_val;
	var round;
	var comp_id;
	var fixture;
	var position;
  	$(document).on('click','.select_team',function(e){
		comp_id = $('#comp_id').val();
		round = $(this).attr('data-round');
		fixture = $(this).attr('data-fixture');
		position = $(this).attr('data-position');
		exist_opp_id = "#round"+round+"_"+position+"_"+fixture;
		exist_val = $(exist_opp_id).val();
	}).change(function(){
		set_opp_id = "#round"+round+"_"+position+"_"+fixture;
		var team_id = $(set_opp_id).val();
		var t_fixture = '<?php echo $blank_fix; ?>';
			const hide_position = ['TL','TR'];
			$.each(hide_position, function( index, value ) {
				opp_id = "#round"+round+"_"+value+"_"+fixture;
				if(exist_val != ''){
					$(opp_id+" option[value=" + exist_val + "]").show();
					$("#team_logo"+position+'_'+round+'_'+fixture).attr("src", '{{url("frontend/images/TeamMore-Add.png")}}');

					if(team_id != ''){
						$(opp_id+" option[value=" + team_id + "]").hide();
						$.ajax({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
							url:'{{url("temp_league_team")}}',
							type:'post',
							data:{team_id:team_id},
							error:function(){
								alert('something went wrong');
							},
							success:function(response)
							{
								//alert(response.teamlogo.team_logo);
								$("#team_logo"+position+'_'+round+'_'+fixture).attr("src", '{{url("frontend/logo")}}/'+response.teamlogo.team_logo);
							}
						});
					}

				}else{
					if(team_id != '')
					{
						$(opp_id+" option[value=" + team_id + "]").hide();
						var team_pos = position;
						var selected_id = $(set_opp_id+" option:selected").val();
						console.log(set_opp_id, team_pos, 'selected id ', selected_id);
						$.ajax({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
							url:'{{url("temp_league_team")}}',
							type:'post',
							data:{team_id:selected_id, logo_position:position, logo_fixture:fixture, logo_round:round},
							error:function(){
								alert('something went wrong');
							},
							success:function(responce)
							{
								var t_position = responce.t_position;
								var t_fixture = responce.t_fixture;
								var t_round = responce.t_round;
								var id = "#team_logo"+t_position+'_'+t_round+'_'+t_fixture;
								console.log('responce', id);
								$(id).attr("src", '{{url("frontend/logo")}}/'+responce.teamlogo.team_logo);
							}
						});
					}
				}
			});
	});
</script>

<script>
	$('#create_fixtures').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("create_league_fixture")}}',
			type:'post',
			data: $('#create_fixtures').serialize(),
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				console.log(response, 'result');
				if(response.status == 0)
				{
					swal(response.message);
				}
				if(response.status == 1)
				{
					window.location.reload();
				}
			}
		});
	});
</script>

<script>
	var exist_val;
	var round;
	var comp_id;
	var fixture;
	var position;
	var t_fixture;
  	$(document).on('click','.select_edit_team',function(e){
		comp_id = $('#comp_id').val();
		round = $(this).attr('data-round');
		fixture = $(this).attr('data-fixture');
		position = $(this).attr('data-position');
		exist_opp_id = "#updateround"+round+"_"+position+"_"+fixture;
		exist_val = $(exist_opp_id).val();
		t_fixture = '<?php echo $get_fixtures; ?>';
		const hide_position = ['TL','TR'];
		$.each(hide_position, function( index, value ) {
			opp_id = "#updateround"+round+"_"+value+"_"+fixture;
			var team_id1 = $(opp_id).val();
			if(team_id1 != ''){
			$(exist_opp_id+" option[value=" + team_id1 + "]").hide();
			}
		});

	}).change(function(){
		set_opp_id = "#updateround"+round+"_"+position+"_"+fixture;
		var team_id = $(set_opp_id).val();
		if(team_id == ''){
			const hide_position = ['TL','TR'];
			$.each(hide_position, function( i, v) {
				opp_id = "#updateround"+round+"_"+v+"_"+fixture;
				$(opp_id+" option[value=" + exist_val + "]").show();
			});

			$("#edit_team_logo"+position+'_'+round+'_'+fixture).attr("src", '{{url("frontend/images/TeamMore-Add.png")}}');
			// alert('change to empty value');
		}else{
			if(exist_val != "")
			{
				const hide_position = ['TL','TR'];
				$.each(hide_position, function( i1, v1) {
					var opp_id1 = "#updateround"+round+"_"+v1+"_"+fixture;
					$(opp_id1+" option[value=" + exist_val + "]").show();
					$(opp_id1+" option[value=" + team_id + "]").hide();
				});

				$("#edit_team_logo"+position+'_'+round+'_'+fixture).attr("src", '{{url("frontend/images/TeamMore-Add.png")}}');
				// alert('change exist value');
			}
			if(team_id != '')
			{
				$(opp_id+" option[value=" + team_id + "]").hide();
				var team_pos = position;
				var selected_id = $(set_opp_id+" option:selected").val();
				console.log(set_opp_id, team_pos, 'selected id ', selected_id);
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
					url:'{{url("temp_league_team")}}',
					type:'post',
					data:{team_id:selected_id, logo_position:position, logo_fixture:fixture, logo_round:round},
					error:function(){
						alert('something went wrong');
					},
					success:function(responce)
					{
						var t_position = responce.t_position;
						var t_fixture = responce.t_fixture;
						var t_round = responce.t_round;
						var id = "#edit_team_logo"+t_position+'_'+t_round+'_'+t_fixture;
						console.log('responce', id);
						$(id).attr("src", '{{url("frontend/logo")}}/'+responce.teamlogo.team_logo);
					}
				});
				// alert('change empty value');
			}
		}
	});
</script>

<script>
	$('#edit_fixtures').on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("edit_league_fixture")}}',
			type:'post',
			data: $('#edit_fixtures').serialize(),
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				console.log(response, 'result');
				if(response.status == 0)
				{
					swal(response.message);
				}
				if(response.status == 1)
				{
					window.location.reload();
				}
			}
		});
	});
</script>

<!-- <script>
  $(document).on('change','.select_team',function(e){
    var round = $(this).attr('data-round');
    var fixture = $(this).attr('data-fixture');
    var position = $(this).attr('data-position');
    var team_id = $(this).val();
    var comp_id = $('#comp_id').val();
	//   var $s = $(e.target);
	// $(".select_team").not($s).find("option[value="+$s.val()+"]").remove();
	//  	console.log($s);
	if(position == "TL")
	{
		hide_position = "TR";
	}
	else
	{
		hide_position = "TL";
	}
	select_id = "#round"+round+"_"+position+"_"+fixture;
	opp_id = "#round"+round+"_"+hide_position+"_"+fixture;
	if(team_id && team_id != 'Select Team')
	{
		$(opp_id+" option[value=" + team_id + "]").hide();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("temp_league_team")}}',
			type:'post',
			data:{team_id:team_id,round:round,fixture:fixture,position:position,comp_id:comp_id},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				//alert(response.teamlogo.team_logo);
				$("#team_logo"+position+'_'+round+'_'+fixture).attr("src", '{{url("frontend/logo")}}/'+response.teamlogo.team_logo);
			}
		});
	}
	else
	{
		$("#team_logo"+position+'_'+round+'_'+fixture).attr("src", '{{url("frontend/images/TeamMore-Add.png")}}');
		let selectopt = $(select_id + " option:selected").val();
		$(opp_id+" option").map((i,e)=> {
			console.log(e.attributes[0].value)
			if(parseInt(selectopt) != e.attributes[0].value){
				$(e).show();
			}
		});
	}
  })
</script> -->

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
			var winner_type = $('#change_mvp').val();
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
				// console.log(response);
      			$('#mvp_winners').html(response);
			}
		});
	})
</script>
<script>
	$(document).on('click','.comp_start0',function(){
		swal("Competition has not started yet!");
	});

	$(document).on('click','#ruleSetViewBtn1',function(){
		$("#ruleSetViewBtn1").hide();
		$("#ruleSetViewBtn2").show();
	});

	function ruleSetViewBtn(key)
	{
		$("#ruleSetView1"+key).hide();
		$("#ruleSetView2"+key).show();
	}
	function ruleSetViewBtns(key)
	{
		$("#ruleSetView2"+key).hide();
		$("#ruleSetView1"+key).show();
	}

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
	 </script>
<!-- Add script for tooltip 20-10-2022 -->
<script type="text/javascript">
 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
	@include('frontend.includes.searchScript')
</body>

<?php
	$end = microtime(true);
	$time = $end - $start;
?>
</html>
