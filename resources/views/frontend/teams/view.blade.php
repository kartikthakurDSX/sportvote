@include('frontend.includes.header')
<?php $centerIndex = null; ?>
<input type="hidden" value="{{$team->id}}" id="team_id">
<style>
    .processed {
        display: none;
    }
</style>

	<button id="triggerAll" class="RefreshButtonTop btn btn-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
            <path d="M15.8591 9.625H21.2662C21.5577 9.625 21.7169 9.96492 21.5303 10.1888L18.8267 13.4331C18.6893 13.598 18.436 13.598 18.2986 13.4331L15.595 10.1888C15.4084 9.96492 15.5676 9.625 15.8591 9.625Z" fill="white"/>
            <path d="M0.734056 12.375H6.14121C6.43266 12.375 6.59187 12.0351 6.40529 11.8112L3.70171 8.56689C3.56428 8.40198 3.31099 8.40198 3.17356 8.56689L0.469979 11.8112C0.283401 12.0351 0.442612 12.375 0.734056 12.375Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0001 4.125C8.86546 4.125 6.95841 5.09708 5.69633 6.62528C5.45455 6.91805 5.02121 6.95938 4.72845 6.7176C4.43569 6.47581 4.39436 6.04248 4.63614 5.74972C6.14823 3.91879 8.43799 2.75 11.0001 2.75C15.045 2.75 18.4087 5.66019 19.1141 9.50079C19.1217 9.54209 19.129 9.5835 19.136 9.625H17.7377C17.1011 6.48695 14.3258 4.125 11.0001 4.125ZM4.26252 12.375C4.89916 15.5131 7.67452 17.875 11.0001 17.875C13.1348 17.875 15.0419 16.9029 16.3039 15.3747C16.5457 15.082 16.9791 15.0406 17.2718 15.2824C17.5646 15.5242 17.6059 15.9575 17.3641 16.2503C15.852 18.0812 13.5623 19.25 11.0001 19.25C6.95529 19.25 3.59161 16.3398 2.88614 12.4992C2.87856 12.4579 2.87128 12.4165 2.86431 12.375H4.26252Z" fill="white"/>
        </svg>
    </button>
	<div class="Competitionn-Page-Additional" >
		@livewire('team.edit-team-banner', ['team' => $team->id])
		<div class="dashboard-profile ">
			<div class="container-lg">
				<div class="row bg-white">
					<div class="col-md-12  position-relative">
						@livewire('team.edit-team-logo', ['team' => $team->id])
						<div class="user-profile-detail-Team float-start w-auto">
							<h5 class="SocerLegSty" ><span class="header_gameTeam" style="background-color:{{$team->team_color}}; color:{{$team->font_color}};">
							<?php $sport = App\Models\Sport::find($team->sport_id); ?>  {{$sport->name}} Team</span> in
							@if($team->country_id) <?php $country_name = App\Models\Country::find($team->country_id);?>
							 {{$country_name->name}} @else -- @endif<br><br><strong>Created By: </strong><a href="{{url('TeamAdmin-profile/' .$team_owner->id.'/'.$team->id)}}" target="_blank"> {{$team_owner->first_name}} {{$team_owner->last_name}} </a></h5>
						</div>
						@livewire('team-follow', ['team' => $team])
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
        <main id="main" class="dashboard-wrap Team-pub-pro Team-Public-Profile Team-Public-ProfileParent">
            <div class="container-fluid bg-GraySquad">
				<div class="container-lg">
					<div class="row AboutMe">
						<div class="col-md-1 col-12 resMob pr-0">
							<div class="boxSuad">
								<span class="SquadCS">SQUAD</span>
								<p class="fitIn"><span class="FiveFt">{{$team_members->count()}}</span></p>
								
							</div>
						</div>
						<div class="col-md-2 p-0">
							<div class="NAtionPLAyer">
								<span class="SquadCS">NATIONAL PLAYERS</span>
								<p class="fitIn"><span class="FiveFt">{{$national_player}}</span><span class="SlePer">/<?php  echo round($national_player_per,0);?>%</span></p>
								
							</div>
						</div>
						<div class="col-md-2 p-0">
							<div class="ForeginPlayer">
								<span class="SquadCS">FOREIGN PLAYERS</span>
								<p class="fitIn"><span class="FiveFt">{{$foreign_player}}</span><span class="SlePer">/<?php  echo round($foreign_player_per,0);?>%</span></p>
								
							</div>
						</div>
						<div class="col-md-1 p-0">
						<?php 
							$players = App\Models\Team_member::where('team_id',$team->id)->where('member_position_id','!=',4)->where('invitation_status',1)->where('is_active',1)->with('members')->get(); 
							$players_age = array();
							foreach($players as $player)
							{
								$players_age[] = Carbon\Carbon::parse($player->members->dob)->age;
							}
							$total_age = array_sum($players_age);
							$total_players = $players->count();
							if($total_players > 0)
							{
							$cal_avg_age = $total_age / $total_players;
							$avg_age =  intval($cal_avg_age);
							}
							else
							{
								$avg_age = "N/A";
							}
						?>
							<div class="NAtionPLAyer">
								<span class="SquadCS">AVERAGE AGE</span>
								<p class="fitIn"><span class="FiveFt">{{$avg_age}}</span></p>
								
							</div>
						</div>
						<style>
							.jersy1::after{
								color: <?php echo $team->team_color; ?>;
								}
								.jersy1 {
								color: <?php echo $team->font_color; ?> !important;
								}
					   </style>
						@if(!(empty($top_player)))
							<?php $user = App\Models\User::find($top_player['player_id']);
								$most_goal_team_member = App\Models\Team_member::where('member_id',$user->id)->where('team_id',$team->id)->where('is_active',1)->first();
								$goal_count = App\Models\Match_fixture_stat::where('player_id',$user->id)->where('stat_type',1)->where('sport_stats_id',1)->where('is_active',1)->count();
								$most_goal_jersey_number = $most_goal_team_member->jersey_number;?>
							<div class="col-md-3 pl-0">
							
								<span class="jersy-noTeam team-jersyTeam-right jersy1" id="most_player_jersey_number">
								<?php if($most_goal_jersey_number) 
									{
									echo str_pad($most_goal_jersey_number,2,'0',STR_PAD_LEFT);
									}
									else
									{
										echo "N/A";
									}?></span>
								<div class="TimmyImg">
									<a href="{{url('player_profile/' .$user->id)}}" target="a_blank"> <img src="{{url('frontend/profile_pic')}}/{{$user->profile_pic}}" id="most_player_profile_pic" width="100%" class="img-fluid RadiousBorder" alt="profle-image"> </a>
								</div>
								<div class="PSpacng ">
									<div class="dropdown ">
										<button class="btn btn-secondaryNeW Most-Team-scorer" type="button" style="width:90%;">
											Most Goals [{{$goal_count}}]
										</button>
										<!-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
											@foreach($sport_stat as $stat)
												<li>
													<a class="dropdown-item Most-stat-team" data-value="{{$stat->id}}"> MOST @php echo Str::of($stat->name)->limit(9); @endphp</a>
												</li>
											@endforeach
										</ul>  -->
									</div>
									<span class="TimmJone"><span id="most_stat_player_name"> {{$user->first_name}} {{$user->last_name}} </span>
										<p class="Spanish"><?php $age = Carbon\Carbon::parse($user->dob)->age; ?> <span id="most_stat_player_age"> {{$age}}</span>  yrs | <span id="most_player_height">{{$user->height}}</span> cm<br><span id="most_player_location"> {{$user->location}} </span></p>
									</span>
								</div>
							</div>
						@else
						<div class="col-md-3 pl-0" id="na_player_stat_div">
							<span class="jersy-noTeam team-jersyTeam-right jersy1" >N/A</span>
							<div class="TimmyImg">
								<img src="{{url('frontend/profile_pic/default_profile_pic.png')}}" id="most_player_profile_pic" width="100%" class="img-fluid RadiousBorder" alt="profle-image">
							</div>
							<div class="PSpacng ">
								<div class="dropdown most_team_stat">
									<button class="btn btn-secondaryNeW Most-Team-scorer" type="button" >
										Most Goals
									</button>
								</div>
								<span class="TimmJone"><span id="most_stat_player_name"> N/A </span>
									<p class="Spanish"><span id="most_stat_player_age"> N/A</span>  yrs | <span id="most_player_location"> N/A </span>| <span id="most_player_height"> N/A </span></p>
								</span>
							</div>
						</div>
						@endif
						@livewire('team.addteam-sponsor', ['team' => $team->id])
					</div>
				</div>
			</div>

            <div class="container-lg">
                @livewire('team.team-news', ['team' => $team->id])
            </div>


            <div class="container-lg">
                <div class="row M-topSpace">
                    <div class="col-md-8 col-lg-8">
							<!-- Team Players -->
							@livewire('team-player', ['team' => $team])
                        
							<!-- Fixture Calendar -->
							@if($fixtures->isNotEmpty())
							<?php
								$id = $team->id;
								$fixtures_date = App\Models\Match_fixture::where(function ($query) use ($id) {
									$query->where('teamOne_id', '=', $id)
									->orWhere('teamTwo_id', '=', $id);
									})->pluck('fixture_date');
								$fix_date_array = $fixtures_date->toArray();
								if(count($fix_date_array) > 0)
								{
									$mindate = min(array_map('strtotime', $fix_date_array));
									$min_year = date('Y', $mindate);
									$min_year_month = date('m', $mindate);
									$maxdate = max(array_map('strtotime', $fix_date_array));
									$max_year = date('Y',$maxdate) + 1; 
								}
								else
								{
									$min_year = date('Y');
									$min_year_month = date('m');
									$max_year = date('Y');
								}
							?>
							<!-- {{$min_year_month}} -->
							<h1 class="Poppins-Fs30">Fixture Calendar <button class="btn fs1 float-end"></button></h1>
							<div class="box-outer-lightpink Team-Fixture">
								<ul class="nav nav-tabs">
									<div class="owl_1 owl-carousel owl-theme">
									<?php 
										if($min_year_month < 11){
											if($min_year_month <= 9){
												if ($min_year_month % 2 == 0 && $min_year_month > 3) {
													$index = 1 - $min_year_month;
												}else{
													$index = -1 - $min_year_month;
												}
											}else{
												if($min_year_month == 10){
													$index = 4 - $min_year_month;
												}else{
													$index = 2 - $min_year_month;
												}
											}
										}else{
											$index = 0 - $min_year_month;
										}
										for($start_year = $min_year; $start_year <= $max_year; $start_year++)
										{
											$startmonth = 1;
											
											for($start_month = $startmonth; $start_month <= 12; $start_month++)
											{
												$i = $start_year;
												$current_month = date('m');
												$current_year = date('Y');
												if($start_year == $current_year && $current_month == $start_month)
												{
													$centerIndex = $index - 4;
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
													<li class="{{$class}}" data-toggle="tab" href="#{{$link}}"><a >{{date("M", mktime(0, 0, 0, $start_month, 1))}}<p>{{$start_year}}</p></a></li>
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
														<li class="" data-toggle="tab" href="#{{date('M', mktime(0, 0, 0, $m)).$next_year}}"><a >{{date("M", mktime(0, 0, 0, $m,1))}}<p>{{$next_year}}</p></a></li>
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
											$startmonth = 1;
										}
										else
										{
											$startmonth = 1;
										}
										for($start_month = $startmonth; $start_month <= 12; $start_month++)
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
											<div id="{{$contentlink}}" class="{{$div_class}}">
											<?php 
											$current_year = date('Y');
											$default_search = $start_year."-".str_pad($start_month,2,'0',STR_PAD_LEFT);
											$team_id = $team->id; 
										
											$check_fixtures = App\Models\Match_fixture::where(function ($query) use ($team_id) {
												$query->where('teamOne_id', '=', $team_id)
												->orWhere('teamTwo_id', '=', $team_id);
												})->where('fixture_date', 'like', '%'.$default_search.'%')->with('competition','teamOne','teamTwo')->orderBy('fixture_date', 'ASC')->get();
											?>
											@if($check_fixtures->IsNotEmpty())
												<?php
												$c_fixtures = array();
												foreach($check_fixtures as $fixture)
												{
													$c_fixtures[] = $fixture;
												}
													$fixture_chunks = array_chunk($c_fixtures,5);
												?>
												<div class="owlfixturetable owl-carousel owl-theme">
													@foreach($fixture_chunks as $chunks)
														<table class="table TableFixtureCalndr item">
															@foreach($chunks as $fixture)
																<tr>
																	<?php $Comp_type = App\Models\competition_type::find($fixture->competition->comp_type_id);
																	?>
																	<td>
																	<a href="{{URL::to('match-fixture/' .$fixture->id)}}" target="_blank"> <span class="OnSun">{{ date('D', strtotime($fixture->fixture_date)) }} </span><span class="Dec-DateFix"> {{ date('M d', strtotime($fixture->fixture_date)) }}</span> </a>
																	</td>
																	<td class="FaCupClor">
																		<a href="{{URL::to('competition/' . $fixture->competition->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->competition->name}}" data-original-title="">@php echo Str::of($fixture->competition->name)->limit(8); @endphp</a>
																	</td>
																	<td class="RightPosiText ">
																		<a href="{{URL::to('team/' .$fixture->teamOne->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamOne->name}}" data-original-title=""><b class="WolVerWand">@php echo Str::of($fixture->teamOne->name)->limit(7); @endphp</b> </a>&nbsp;
																		<a href="{{URL::to('team/' .$fixture->teamOne->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamOne->name}}" data-original-title=""> <div class="pp-pageHW"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$fixture->teamOne->team_logo}}"></div> </a>
																	</td>
																	<td class="BtnCentr">
																		@if($fixture->startdate_time == NULL)
																			@if($fixture->competition->comp_start == 1)
																				<button class="btn btn-gray text-center btn-xs-nb"><a href="{{ URL::TO('match-fixture/' . $fixture->id)}}" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$fixture->competition->name}}, Competition type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}"> {{ date('H:i', strtotime($fixture->fixture_date)) }}</a></button>
																			@else
																				<button class="btn btn-gray text-center btn-xs-nb" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$fixture->competition->name}}, Competition type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}"> {{ date('H:i', strtotime($fixture->fixture_date)) }}</button>
																			@endif
																			
																		@else
																			<?php $teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$fixture->id)->where('team_id',$fixture->teamOne_id)->where('sport_stats_id',1)->get();
																				$teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$fixture->id)->where('team_id',$fixture->teamTwo_id)->where('sport_stats_id',1)->get();
																			?>
																			<a href="{{ URL::TO('match-fixture/' . $fixture->id)}}" data-toggle="tooltip" data-placement="bottom" title="Competition Name: {{$fixture->competition->name}}, Competition type: {{$Comp_type->name}}, TeamOne: {{$fixture->teamOne->name}}, TeamTwo: {{$fixture->teamTwo->name}}"> 
																				<span class=" btn-greenFXL "><?php echo str_pad($teamOneGoal->count(), 2, 0,STR_PAD_LEFT); ?></span> 
																				<span class=" btn-greenFXR "><?php echo str_pad($teamTwoGoal->count(), 2, 0,STR_PAD_LEFT); ?></span> 
																			</a>
																		@endif
																	</td>
																	<td class="LeftPosiText ">
																		<a href="{{URL::to('team/' .$fixture->teamTwo->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamTwo->name}}" data-original-title=""> <div class="pp-pageHW"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$fixture->teamTwo->team_logo}}"></div> </a>&nbsp;
																		<a href="{{URL::to('team/' .$fixture->teamTwo->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{$fixture->teamTwo->name}}" data-original-title=""><b class="WolVerWand">@php echo Str::of($fixture->teamTwo->name)->limit(7); @endphp</b></a>
																	</td>
																	<td class="viewTeamFixtures">
																		{{-- @livewire('competition.leauge-ics-file',['fixture_id' => $fixture->id]) --}}
																	</td>
																</tr>
															@endforeach
														</table>
													@endforeach
												</div>
											@else
												<p style="text-align:center; font-weight:bold;"> Data Not Found</p>
											@endif
										</div>
									<?php } 
										if($start_year == $max_year)
										{
											$i = 1;
											$count_month = 12 - $min_year_month;
											$month_add = $count_month + 1;
											$next_months = 12 - $month_add;
											$next_year = $start_year + 1;
											for($m = 1; $m <= $next_months; $m++)
											{
												?>
												<div id="{{date('M', mktime(0, 0, 0, $m)).$next_year}}" class="">
													
												</div>
											<?php
											}

										}
									}?>
								</div>
							</div>
						@else
						@endif
                        

						@if($match_fixture_competition->isNotEmpty())
							<div class="Team-Public-Profile Team-Public-ProfileParent">
								<div class="row">
									<div class="col-md-3 mAuto0 pr-0 stattitle"> <h1 class="Poppins-Fs30">Team Stats </h1></div>
									<div class="col-md-9 SelectboxStyle pl-0">
										<div class="demo-Select ">
										<select class="Dropdown-Icon w-100" id="select_comp">
										  @foreach($match_fixture_competition as $comp => $stat)
											<?php 
												$competition_name  = App\Models\Competition::find($comp);
											?>
											<option value="{{$competition_name->id}}" {{ $loop->first ? 'selected="selected"' : '' }} > {{$competition_name->name}}</option>
										@endforeach
										</select>
										</div>
									</div>
								</div>
								<div class="box-outer-lightpink QuickCompare">
									
									<div class="row">
										<div class="col-md-7  col-6  ">
											<div class="row">
												<div class="col-md-8 BorR-1 col-12  tabFull">
													<div class="d-flex justi_centr-tab">
														<div class="BlueTxt">
															<div class="YellInnerTxt"><span id="goal_d">{{$goal_d}}</span><p class="GoalsD"> GD</p>
															</div>
														</div>
														<div class="cards-det">
															<span class="Green"><span id="t_goal"><?php echo str_pad(count($goals),2,"0",STR_PAD_LEFT); ?> </span><span class="GFORLightClor"> GF</span> </span>
															<p class="RedD mb-2"><span id="a_goal"><?php echo str_pad($againts_goals,2,"0",STR_PAD_LEFT); ?></span> <span class="AGSTLightClor"> GA</span> </p>
														</div>
													</div>
												</div>
												<div class="col-md-4  col-12 W-50tab p-12">
													<div class="RankedSec RankedSecUnderline">
														<span class="RankedText">RANK<br>
														</span>
														<p class="RankedNo mb-0" id="rank">{{$rank}}</p>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-8 BorR-1">
													<div class="row">
													<div class="col-md-6 spiclRight col-12 New-on-Tab p-12">
														<div class="d-flex">
														<div class="yelTxt">
															<span class="YellInnerTxt" id="y_card"><?php echo str_pad($yellow_card->count(),2,"0",STR_PAD_LEFT); ?> </span>
														</div>
														<div class="cards-det01">
															<span class="YellCard">YELLOW</span>
															<p class="YellCard mb-2">CARDS</p>
														</div>
														</div>
													</div>
													<div class="col-md-6   col-12 New-on-Tab p-12">
														<div class="d-flex">
														<div class="RedTxt">
															<span class="YellInnerTxt" id="r_card"><?php echo str_pad($red_card->count(),2,"0",STR_PAD_LEFT); ?></span>
														</div>
														<div class="cards-det01">
															<span class="RedCard">RED</span>
															<p class="RedCard mb-2 ">CARDS</p>
														</div>
														</div>
													</div>
													</div>
												</div>
												<div class="col-md-4 col-12 W-50tab p-12">
													<div class="RankedSec">
														<?php
															 
															$win_point = $won * 3; 
														    $draw_point = $draw * 1; $points = $win_point + $draw_point; 
														?>
														<p class="RankedNo mb-0" id="Tpoints"><?php echo str_pad($points,2,"0",STR_PAD_LEFT); ?></p>
														<span class="RankedText">POINTS<br>
														</span>
														
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-5 m-auto col-6 pl-0 BorL-1">
											<div class="text-right">
												<a href="{{URL::to('competition/' . $team_stat_comp_id)}}" id="statcomplink" target="_blank">
													<span class="statviewComp">View Competition</span>
												</a>
											</div>
											<div class="row">
								
												<div class="col-md-6 col-12 webkitCenter">
													<div class="Donut-Chart mb-2" id="donutcircle">
													<?php
													
													?>
													@if($won == 0 && $draw == 0 && $lost == 0)

													@elseif($won == 0 && $draw == 0 && $lost != 0)
														<?php 	$multiplyer = (int)(90/$played);
																$thirdcircle = $lost * $multiplyer; ?>
															<style>
															.Team-Public-ProfileParent .donut__slice__third {
																--third-start: calc(var(--first) + var(--second));
																 --third-check: unset((var(--third-start) - .5), 0); 
																-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
															}
														</style>	
														<div class="donut" style="--first: .0; --second: .0; --third: .{{$thirdcircle}}; --donut-spacing: 0;">
															<!-- <div class="donut__slice donut__slice__first"></div>
															<div class="donut__slice donut__slice__second"></div> -->
															<div class="donut__slice donut__slice__third"></div>
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@elseif($won == 0 && $draw != 0 && $lost == 0)
														<?php 	$multiplyer = (int)(90/$played);
																$secondcircle = $draw * $multiplyer; ?>
															<style>
															.Team-Public-ProfileParent .donut__slice__second {
															--second-start: calc(var(--first));
															--second-check: unset(((--second-start) - .5), 0); 
															-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
															clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
														}</style>
														<div class="donut" style="--first: .0; --second: .{{$secondcircle}}; --third: .0;  --donut-spacing: 0;">
															<!-- <div class="donut__slice donut__slice__first"></div> -->
															<div class="donut__slice donut__slice__second"></div> 
															<!-- <div class="donut__slice donut__slice__third"></div> -->
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@elseif($won == 0 && $draw != 0 && $lost != 0)
														<?php 	$multiplyer = (int)(100/$played);
																$secondcircle = $draw * $multiplyer; 
																$thirdcircle = $lost * $multiplyer;?>
														<div class="donut" style="--first: .0; --second: .{{$secondcircle}}; --third: .{{$thirdcircle}}; --donut-spacing: 0;">
															<!-- <div class="donut__slice donut__slice__first"></div> -->
															<div class="donut__slice donut__slice__second"></div> 
															<div class="donut__slice donut__slice__third"></div> 
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@elseif($won != 0 && $draw == 0 && $lost == 0)
														<?php 	$multiplyer = (int)(90/$played);
															$firstcircle = $won * $multiplyer; ?>
														<div class="donut" style="--first: .{{$firstcircle}}; --donut-spacing: 0;">
															<div class="donut__slice donut__slice__first"></div> 
															<!-- <div class="donut__slice donut__slice__second"></div> 
															<div class="donut__slice donut__slice__third"></div>  -->
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@elseif($won != 0 && $draw == 0 && $lost != 0)
													<?php 	$multiplyer = (int)(100/$played);
																$firstcircle = $won * $multiplyer; 
																$thirdcircle = $lost * $multiplyer;?>
														<style>
															.Team-Public-ProfileParent .donut__slice__third {
																--third-start: calc(var(--first) + var(--second));
																 --third-check: unset((var(--third-start) - .5), 0); 
																-webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
																clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0);
															}
														</style>
														<div class="donut" style="--first: .{{$firstcircle}}; --second: .0; --third: .{{$thirdcircle}}; --donut-spacing: 0;">
															<div class="donut__slice donut__slice__first"></div> 
															<!-- <div class="donut__slice donut__slice__second"></div>  -->
															<div class="donut__slice donut__slice__third"></div> 
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@elseif($won != 0 && $draw != 0 && $lost == 0)
													<?php 	$multiplyer = (int)(100/$played);
																$firstcircle = $won * $multiplyer; 
																$secondcircle = $draw * $multiplyer;?>
														<style>
														.Team-Public-ProfileParent .donut__slice__second {
															--second-start: calc(var(--first));
															--second-check: unset(((--second-start) - .5), 0); 
															-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
															clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
														} </style>
														<div class="donut" style="--first: .{{$firstcircle}}; --second: .{{$secondcircle}}; --donut-spacing: 0;">
															<div class="donut__slice donut__slice__first"></div> 
															<div class="donut__slice donut__slice__second"></div>
															<!-- <div class="donut__slice donut__slice__third"></div>  -->
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@elseif($won != 0 && $draw != 0 && $lost != 0)
														<?php 	$multiplyer = (int)(100/$played);
																$firstcircle = $won * $multiplyer; 
																$secondcircle = $draw * $multiplyer;
																$thirdcircle = $lost * $multiplyer; ?>
																<style>
														.Team-Public-ProfileParent .donut__slice__second {
															--second-start: calc(var(--first));
															--second-check: unset(((--second-start) - .5), 0); 
															-webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
															clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);
														} </style>
														<div class="donut" style="--first: .{{$firstcircle}}; --second: .{{$secondcircle}}; --third: .{{$thirdcircle}}; --donut-spacing: 0;">
															<div class="donut__slice donut__slice__first"></div> 
															<div class="donut__slice donut__slice__second"></div>
															<div class="donut__slice donut__slice__third"></div>
															<div class="donut__label">
																<div class="donut__label__heading" id="played">
																<?php echo str_pad($played,2,"0",STR_PAD_LEFT); ?>
																</div>
																<div class="donut__label__sub">
																  PLAYED
																</div>
															</div>
														</div>
													@endif
														
													</div>
												</div>
												<div class="col-md-6 m-auto col-12 TabView">
												
													<div class="DonutLP">
														<div class="d-flex ">
															
															<div class="box-grenn">
																
															</div>
															<div class="cards-det">
																<span class="Box-grenn-txt"><span id="won"><?php echo str_pad($won,2,"0",STR_PAD_LEFT); ?></span> WON</span>
																
															</div>
													
														</div>
														<div class="d-flex ">
															
															<div class="box-gray">
																
															</div>
															<div class="cards-det">
																<span class="Box-grenn-txt"><span id="draw"><?php echo str_pad($draw,2,"0",STR_PAD_LEFT); ?></span> DRAW</span>
																
															</div>
													
														</div>
														<div class="d-flex ">
															
															<div class="box-Reddd">
																
															</div>
															<div class="cards-det">
																<span class="Box-grenn-txt"><span id="lost"><?php echo str_pad($lost,2,"0",STR_PAD_LEFT); ?></span> LOST</span>
															</div>
													
														</div>
														<span class="Box-grenn-txt">TEAM FORM</span>
														<p class="line-height-Team-form" id="display_dwl">
															<?php
															
															$rtf = 0;
															foreach($against_team as $a_team){ $rtf++; 
															if($rtf < 5){
															?>
																@if($a_team->fixture_type == 1 || $a_team->fixture_type == 3)
																	<span class="D-Tean-form"> D</span>
																@elseif($a_team->fixture_type == 2)
																	@if($a_team->winner_team_id == $team->id)
																		<span class="G-Tean-form"> W</span>
																	@else
																		<span class="R-Tean-form"> L</span>
																	@endif
																@endif
																
															<?php } else{ } } ?>
															<?php 
															$restofteamform = 5 - $against_team->count();
															for($r = 1; $r<=$restofteamform; $r++){ ?>
																<span class="R-Tean-form" style="background-color:#003b5f !important;"> N/A</span>
															<?php } ?>
															
															
															<!-- <span class="D-Tean-form"> D</span>
															<span class="G-Tean-form"> W</span>
															<span class="G-Tean-form"> W</span>
															<span class="R-Tean-form"> L</span>
															<span class="G-Tean-form"> W</span> -->
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>	
							</div>
						@else
						@endif
						<div class="col-md-12 col-lg-12">
							@if(Auth::check())
								@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $team->user_id)) 
									<span> <a data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor:pointer;"><span class="fa-plus"> </span></a> </span> 
									@if(count($trophy_cabinets) == 0)
										<h1 class="Poppins-Fs30">Trophy Cabinet <button class="btn fs1 float-end"></button></h1>
									@else
									@endif
								@else
								@endif
							@else
							@endif
						
							@if(count($trophy_cabinets) != 0)
								<h1 class="Poppins-Fs30">Trophy Cabinet <button class="btn fs1 float-end"></button></h1>
								<div class="box-outer-lightpink">
									<div class="row">
										@foreach($trophy_cabinets as $trophy_cabinet)
											<div class="col-md-6 w-100-768 ">
												<div class="row InsideSpace">
													<div class="col-md-3 col-3 ">
														<div class="BestFifa">
															<?php
																if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
																		 $url = "https://";   
																	else  
																		 $url = "http://";   
																	// Append the host(domain name, ip) to the URL.   
																	$url.= $_SERVER['HTTP_HOST']; 
																	
																  $trophyimage = $url."/storage/app/public/image/".$trophy_cabinet->trophy_image;
															?>
															<img class="img-fluid" src="{{$trophyimage}}" width="">
														</div>
													</div>
													<?php $years = explode(',', $trophy_cabinet->year);
														$count = count($years); ?>
													<div class="col-md-9 col-9 BestFifaStyle" >
													
														<p class="BestMenFifa">{{$trophy_cabinet->title}}</p>
														<p ><div class="multiply">×{{$count}}</div> <span class="NATeam">YEAR: {{$trophy_cabinet->year}}</span></p>
														<p class="NATeam">Team: {{$trophy_cabinet->team}}</p>
														<p class="NATeam">Comp: {{$trophy_cabinet->comp}}</p>
														@if(Auth::check())
															@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $team->user_id)) 
																<a style="cursor:pointer;" href="{{url('delete/'.$trophy_cabinet->id)}}" onclick="return confirm('Are you sure you want to delete this Record?')"><i class="icon-trash "></i></a>
																<span class="Edit-Team-player-jerseyno edit_tophy" style="color:#000;cursor:pointer" data-id="{{$trophy_cabinet->id}}"></span>
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

                    <div class="col-md-4">
						@livewire('team.rightside-bar', ['id' => $team->id])						
                	</div>
				</div>
				
				@livewireScripts
        </main>
		<!-- The Modal Add Admin-->
			<div class="modal fade" id="add_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>	
						</div>
						<div class="modal-body">
							<div class="container teamPagePopup">
								<div class="row">
									Select Admin
								</div>
								<div class="row">
									<select class="typeahead grey-form-control" multiple="multiple" id="users_ids" width="100%"></select>
								</div>
								<div class="row">
									Select Admin Position
								</div>
								<div class="row">
									<select class="grey-form-control" name="admin_position_id">
										@foreach($admin_positions as $admin_position)
											<option value="{{$admin_position->id}}"> {{$admin_position->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal">Close</button>
							<button type="button" class="btn btn-primary" id="send_admin_request">Send Request</button>
						</div>
					</div>
				</div>
			</div>
			<!-- The Modal Add Player-->
			<div class="modal fade" id="add_player_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Player</h5>
						</div>
						<div class="modal-body">
							<div class="container teamPagePopup">
								<div class="row">
									Select Player
								</div>
								<div class="row">
									<select class="typeahead_players grey-form-control" multiple="multiple" id="player_ids" width="100%"></select>
								</div>
								<div class="row">
									Select Player Position
								</div>
								<div class="row">
									<select class="grey-form-control" name="player_position_id">
									@foreach($player_positions as $player_position)
										<option value="{{$player_position->id}}"> {{$player_position->name}}</option>
									@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal_player">Close</button>
							<button type="button" class="btn btn-primary" id="send_player_request">Send Request</button>
						</div>
					</div>
				</div>
			</div>
			<!-- The  Add Trophy cabinate model-->
			<div class="modal fade myModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add a Trophy / Award </h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form method="POST" action="{{url('addtrophycabinet')}}" enctype="multipart/form-data" id="first_form">
								@csrf
									@if (count($errors) > 0)
									<div class="alert alert-danger">
										<strong>Whoops!</strong>Something went wrong.<br><br>
										<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
										</ul>
									</div>
									@endif
								<div class="row">
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<input type="hidden" name="type_id" value="{{$team->id}}">
											<input type="hidden" name="trophy_type" value="2">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="text" id="title" name="title" value="">
												<span class="highlight"></span>
												<label>Title of Trophy / Award</label>
											</div>
											<div class="text-danger" id="title_validate"></div>
										</div>	
									</div>
									<?php $currentyear = date('Y'); ?>
									<div class=" col-md-12 mb-4 FlotingLabelUp">
										<div class="floating-form">
											<div class="floating-label form-select-fancy-1">
											<select class="form-control" id="mySelect2" name="years[]" multiple="multiple">
												@for($i=1985; $i <= $currentyear; $i++)
													<option value="{{ $i }}">{{ $i }}</option>
												@endfor
											</select>
											</div>
											<div class="text-danger" id="mySelect2_validate"></div>
										</div>
									</div>
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="text" id="team" name="team">
												<span class="highlight"></span>
												<label>Team Name</label>
											</div>
											<div class="text-danger" id="team_validate"></div>
										</div>	
									</div>
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="text" id="competition" name="competition">
												<span class="highlight"></span>
												<label>Competition Name</label>
											</div>
											<div class="text-danger" id="competition_validate"></div>
										</div>	
									</div>
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="file" id="imgInp" name="trophy_image" accept="image/*">
												<span class="highlight"></span>
												<label>Trophy / Award Image</label>
											</div>
											<div class="text-danger" id="imgInp_validate"></div>
										</div>
										<img style="visibility:hidden"  id="prview" src=""  width=100 height=100 />
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
			<div class="modal fade editModal" id="edit_trophy_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit a Trophy / Award</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form method="POST" action="{{url('edittrophycabinet')}}" enctype="multipart/form-data" id="second_form">
								@csrf
								<div class="row">
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<input type="hidden" name="cabinet_id" id="cabinet_id" value="">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="text" id="edit_title" name="title" value="">
												<span class="highlight"></span>
												<label>Title of Trophy / Award</label>
											</div>
											<div class="text-danger" id="edit_title_validate"></div>
										</div>	
									</div>
									<?php $currentyear = date('Y'); ?>
									<div class=" col-md-12 mb-4 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">
											<select class="form-control" id="editselect2" name="years[]" multiple="multiple">
												@for($i=1985; $i <= $currentyear; $i++)
													<option value="{{ $i }}">{{ $i }}</option>
												@endfor
											</select>
											</div>
											<div class="text-danger" id="editselect2_validate"></div>
										</div>
									</div>
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="text" id="edit_team" name="team">
												<span class="highlight"></span>
												<label>Team Name</label>
											</div>
											<div class="text-danger" id="edit_team_validate"></div>
										</div>	
									</div>
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="text" id="edit_competition" name="competition">
												<span class="highlight"></span>
												<label>Competition Name</label>
											</div>
											<div class="text-danger" id="edit_competition_validate"></div>
										</div>	
									</div>
									<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
										<div class="floating-form ">
											<div class="floating-label form-select-fancy-1">      
												<input class="floating-input" type="file" id="oldimg" name="trophy_image" accept="image/*">
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
														<input class="floating-input" type="email" placeholder=" " id= "team_email" value="{{$team->team_email}}">
														<span class="highlight"></span>
														<label>Email:</label>
													</div>
												</div>	
												<span class="sv_error" id="team_email_error"></span>
											</div>
										</div>
										<div class="row mb-4 mt-4">
											<div class=" col-md-12 FlotingLabelUp">
												<div class="floating-form ">
													<div class="floating-label form-select-fancy-1">      
														<input class="floating-input" type="number" placeholder=" " id="team_phonenumber" value="{{$team->team_phone_number}}">
														<span class="highlight"></span>
														<label>Phone number:</label>
													</div>
												</div>
												<span class="sv_error" id="team_phoneno_error"></span>	
											</div>
										</div>
										<div class="row mb-4 mt-4">
											<div class=" col-md-12 FlotingLabelUp">
												<div class="floating-form ">
													<div class="floating-label form-select-fancy-1">      
														<textarea class="floating-input" type="address" placeholder=" " value="{{$team->team_address}}" id="team_address">{{$team->team_address}}</textarea>
														<span class="highlight"></span>
														<label>Address:</label>
													</div>
												</div>
												<span class="sv_error" id="team_address_error"></span>	
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_contact_us">Close</button>
									<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" id="save_team_contact">Save </button>
								</div>
							</div>
						</div>
					</div>
	@include('frontend.includes.footer')

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
	<script type="text/javascript" src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js')}}"></script>
    <script type="text/javascript" src="{{url('frontend/js/jquery2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('frontend/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js')}}"></script>
    <script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('frontend/js/script.js')}}"></script>
    <script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
	 <style>
		.error{
			color:red;
		}
		.pac-container {
			z-index: 10000 !important;
		}
	</style> 
	<script>
		$('#triggerAll').on('click',function(){
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
	
	<script>
		$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
    <script type="text/javascript">
        $(' .owl_1').owlCarousel({
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
                },
				1400: {
                    items: 13,
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
        $('.owlsp').owlCarousel({
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
        $('.owlSPONSORS').owlCarousel({
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

    <script type="text/javascript">
        $(function () {
            var owl = $('.owl_2');
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

<script>
$(document).on('change', '#select_comp', function(){
	var comp_id = $(this).val();
	var team_id = $('#team_id').val();
	//alert(comp_id + team_id);
	$.ajax({
		headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 },
		url:"{{url('team_stat_graphic')}}",
		method:"POST",
		data:{comp_id:comp_id,team_id:team_id},
		success:function(data)
		{
			var comp_url = "{{url('competition')}}/"+comp_id;
			$("#statcomplink").removeAttr("href");
			$('#statcomplink').attr('href', comp_url);
			
			//alert(data.total_goal);
			$('#t_goal').html(data.total_goal);
			$('#played').html(data.played);
			$('#goal_d').html(data.goal_d);
			$('#y_card').html(data.yellow_card);
			$('#r_card').html(data.red_card);
			$('#won').html(data.won);
			$('#Tpoints').html(data.points);
			$('#lost').html(data.lost);
			$('#draw').html(data.draw);
			$('#a_goal').html(data.a_goal);
			$('#rank').html(data.rank);

			totalplayed = data.won + data.draw + data.lost;
			/* multiplyer = Math.round(100/data.played);
			firstcircle = data.won * multiplyer;
			secondcircle = data.draw * multiplyer;
			thirdcircle = data.lost * multiplyer; */
			
			donutcircle = "";
			
			if(data.won != 0 && data.draw == 0 && data.lost == 0){ 
				multiplyer = Math.round(90/data.played);
				firstcircle = data.won * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div><style> .Team-Public-ProfileParent .donut__slice__first::after { border-top-color: #64b102 ; border-right-color: #64b102; border-bottom-color: #64b102; border-left-color: #64b102; }</style>';
			}
			 else if(data.won == 0 && data.draw != 0 && data.lost == 0){
				multiplyer = Math.round(90/data.played);
				firstcircle = data.draw * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div><style> .Team-Public-ProfileParent .donut__slice__first::after { border-top-color: #5a5a5a ; border-right-color: #5a5a5a; border-bottom-color: #5a5a5a; border-left-color: #5a5a5a; }</style>';
			}
			else if(data.won == 0 && data.draw == 0 && data.lost != 0){ 
				multiplyer = Math.round(90/data.played);
				firstcircle = data.lost * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div><style> .Team-Public-ProfileParent .donut__slice__first::after { border-top-color: #dd0a00 ; border-right-color: #dd0a00; border-bottom-color: #dd0a00; border-left-color: #dd0a00; }</style>';
			} 
			else if(data.won != 0 && data.draw != 0 && data.lost == 0){ 
				multiplyer = Math.round(100/data.played);
				firstcircle = data.won * multiplyer;
				secondcircle = data.draw * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --second: .'+secondcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__slice donut__slice__second"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div><style>.Team-Public-ProfileParent .donut__slice__second { --second-start: calc(var(--first));--second-check: unset(((--second-start) - .5), 0); -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);} </style>';
			}
			else if(data.won != 0 && data.draw == 0 && data.lost != 0){
				multiplyer = Math.round(100/data.played);
				firstcircle = data.won * multiplyer;
				secondcircle = data.lost * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --second: .0; --third: .'+secondcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__slice donut__slice__third"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div><style> .Team-Public-ProfileParent .donut__slice__second::after {  border-top-color: #dd0a00; border-right-color: #dd0a00;} .Team-Public-ProfileParent .donut__slice__third { --third-start: calc(var(--first) + var(--second)); --third-check: unset((var(--third-start) - .5), 0); -webkit-clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0); clip-path: inset(0 calc(50% * (var(--third-check) / var(--third-check))) 0 0); } </style>';
			}
			else if(data.won == 0 && data.draw != 0 && data.lost != 0){
				multiplyer = Math.round(100/data.played);
				firstcircle = data.draw * multiplyer;
				secondcircle = data.lost * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --second: .'+secondcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__slice donut__slice__second"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div><style> .Team-Public-ProfileParent .donut__slice__first::after {  border-bottom-color: #64b102;} .Team-Public-ProfileParent .donut__slice__second{ --second-check: none;}</style>';
			}
			else if(data.won != 0 && data.draw != 0 && data.lost != 0){
				multiplyer = Math.round(100/data.played);
				firstcircle = data.won * multiplyer;
				secondcircle = data.draw * multiplyer;
				thirdcircle = data.lost * multiplyer;
				donutcircle += '<div class="donut" style="--first: .'+firstcircle+'; --second: .'+secondcircle+'; --third: .'+thirdcircle+'; --donut-spacing: 0;"><div class="donut__slice donut__slice__first"></div><div class="donut__slice donut__slice__second"></div><div class="donut__slice donut__slice__third"></div><div class="donut__label"><div class="donut__label__heading" id="played">'+data.played+'</div><div class="donut__label__sub">PLAYED</div></div></div> <style>.Team-Public-ProfileParent .donut__slice__second { --second-start: calc(var(--first));--second-check: unset(((--second-start) - .5), 0); -webkit-clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);clip-path: inset(0 calc(50% * (var(--second-check) / var(--second-check))) 0 0);} </style>';
			} 
			else if(data.won == 0 && data.draw == 0 && data.lost == 0){
				donutcircle += '';
			}
			else{
				donutcircle += '';
			}
				
			$('#donutcircle').html(donutcircle);
			
			
			html = '' 
			$.each(data.against_team, function(k, v){
				//alert(v.winner_team_id);
				if(v.fixture_type == 1 || v.fixture_type == 3)
				{
					html += '<span class="D-Tean-form"> D</span>&nbsp;';
				}
				else if(v.fixture_type == 2)
				{
					if(v.winner_team_id == team_id)
					{
						html += '<span class="G-Tean-form"> W</span>&nbsp;';
					}
					else
					{
						html += '<span class="R-Tean-form"> L</span>&nbsp;';
					}
				}
			})
			var restofteamform = 5 - data.against_team.length;
			//alert(restofteamform);
			for(var r = 0;  r < restofteamform; r++)
			{
				html += ('<span class="R-Tean-form" style="background-color:#003b5f !important;"> N/A</span>&nbsp;');
			} 
			$('#display_dwl').html(html);
		},
		error:function()
		{
			alert('something went wrong');
		}
	});
})
</script>

<script>
	$(document).on('click','.open_team_admin_popup',function(){
		$('#add_admin').modal('show');

	});

	$('body').on('click','#close_modal',function(){
		$('#add_admin').modal('hide');
	});

</script>

<script src="{{url('frontend/js/typeahead.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
	var team_id = $('#team_id').val();
    $('.typeahead').select2({
        placeholder: 'Select Admin',
        ajax: {
            url: "{{ url('autosearch_member_name') }}/"+team_id,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name+' ' +item.l_name,
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
var team_id = $('#team_id').val();
    $('.typeahead_players').select2({
        placeholder: 'Select Player',
        ajax: {
            url: "{{ url('autosearch_team_player') }}/"+team_id,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name+' ' +item.l_name,
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
	var team_id = $('#team_id').val();
	var admin_pos_id = $('select[name="admin_position_id"] option:selected').val();
	//alert();
	if(admins_ids != '')
	{
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("send_invitation_team_admins")}}',
			type:'post',
			data:{admins_ids:admins_ids,team_id:team_id,admin_pos_id:admin_pos_id},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				if(response == 1)
				{
					alert('Player already exist.');
				}
				location.reload();
			}
		});
	}
	else
	{
		alert('Select Admin and Admin Position.');
	}
})
</script>
<script>
$(document).on('click','#send_player_request',function(){

	var admins_ids = $('#player_ids').val();
	var team_id = $('#team_id').val();
	var position_id = $('select[name="player_position_id"] option:selected').val();
	//alert();
	 $('#add_admin').modal('hide');
	if(admins_ids != '')
	{
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("send_invitation_team_player")}}',
			type:'post',
			data:{admins_ids:admins_ids,team_id:team_id,position_id:position_id},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				if(response == 1)
				{
					alert('Player already exist.');
				}
				if(response == 3)
				{
					alert('Player already invited.');
				}
				if(response == 2)
				{
					$('#add_player_modal').modal('hide');
				}
				//location.reload();
			}
		});
	}
	else
	{
		alert('select Player and Player Position');
	}
})
</script>
<script>
$(document).on('click','#add_player',function(){
	 $('#add_player_modal').modal('show');
})
</script>
<script>
$(document).on('click','#close_modal_player',function(){
		$('#add_player_modal').modal('hide');
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript">
	$("#addTrophy_form").on("click", function(){
		var title = $("#title").val();
		var team = $("#team").val();
		var yearselect = $('#mySelect2 > option:selected');
		var competition = $("#competition").val();
		var fileName = $("#imgInp").val();
		var at = 0;
		if(fileName == ""){
			at++;
			$("#imgInp_validate").html("Trophy / Award Image is required.");
		}else{
			var extFile = fileName.split('.').pop().toLowerCase();
			if (extFile == "jpg" || extFile == "jpeg" || extFile == "png"){
				$("#imgInp_validate").html("");
			}else{
				at++;
				$("#imgInp_validate").html("Only jpg,jpeg,png type images are accepted.");
			}
		}
		if(yearselect.length == 0){
			$("#mySelect2_validate").html("Year is required.");
		}else{
			$("#mySelect2_validate").html("");
		}
		if(title == ""){
			at++;
			$("#title_validate").html("Trophy title is required.");
		}else{
			if(title.length > 250){
				at++;
				$("#title_validate").html("Trophy title must not be greater than 250 characters.");
			}else{
				$("#title_validate").html("");
			}
		}
		if(team == ""){
			at++;
			$("#team_validate").html("Team Name is required.");
		}else{
			if(team.length > 250){
				at++;
				$("#team_validate").html("Team name must not be greater than 250 characters.");
			}else{
				$("#team_validate").html("");
			}
		}
		if(competition == ""){
			at++;
			$("#competition_validate").html("Competition Name is required.");
		}else{
			if(competition.length > 250){
				at++;
				$("#competition_validate").html("Competition name must not be greater than 250 characters.");
			}else{
				$("#competition_validate").html("");
			}
		}
		if(at == 0){
			$('#first_form').submit();
		}
	});

	$("#editTrophy_form").on("click", function(){
		var edit_title = $("#edit_title").val();
		var edityear = $('#editselect2 > option:selected');
		var edit_team = $("#edit_team").val();
		var edit_competition = $("#edit_competition").val();
		var fileimgName = $("#oldimg").val();
		var oldimage = $("prview1").attr('src');
		var et = 0;
		if(oldimage != ""){
			if(fileimgName != ""){
				var extFile = fileimgName.split('.').pop().toLowerCase();
				if (extFile == "jpg" || extFile == "jpeg" || extFile == "png"){
					$("#oldimg_validate").html("");
				}else{
					et++;
					$("#oldimg_validate").html("Only jpg,jpeg,png type images are accepted.");
				}
			}
		}
		if(edityear.length == 0){
			et++;
			$("#editselect2_validate").html("Year is required.");
		}else{
			$("#editselect2_validate").html("");
		}
		if(edit_title == ""){
			et++;
			$("#edit_title_validate").html("Trophy title is required.");
		}else{
			if(edit_title.length > 250){
				et++;
				$("#edit_title_validate").html("Trophy title must not be greater than 250 characters.");
			}else{
				$("#edit_title_validate").html("");
			}
		}
		if(edit_team == ""){
			et++;
			$("#edit_team_validate").html("Team Name is required.");
		}else{
			if(edit_team.length > 250){
				et++;
				$("#edit_team_validate").html("Team name must not be greater than 250 characters.");
			}else{
				$("#edit_team_validate").html("");
			}
		}
		if(edit_competition == ""){
			et++;
			$("#edit_competition_validate").html("Competition Name is required.");
		}else{
			if(edit_competition.length > 250){
				et++;
				$("#edit_competition_validate").html("Competition name must not be greater than 250 characters.");
			}else{
				$("#edit_competition_validate").html("");
			}
		}
		if(et == 0){
			$('#second_form').submit();
		}
	});
</script>
 <script type="text/javascript">
    $('#mySelect2').select2({
        dropdownParent: $('.myModal'),
		placeholder: 'Select year(s)',
    });

	$('#editselect2').select2({
        dropdownParent: $('.editModal'),
		placeholder: "Select",
    });

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
<script>
	$(document).on('click','.edit_tophy',function(){
		var tophy_id = $(this).attr('data-id');
		//alert(tophy_id);
		$.ajax({
			type:'GET',
			url:'{{url("edittrophy_cabinet")}}/'+tophy_id,
			error:function()
			{
				alert('Something went wrong');
			},
			success:function(data) {
				$('#edit_trophy_modal').modal('show');
				$('#cabinet_id').val(data.editcabinet.id);
				$('#edit_title').val(data.editcabinet.title);
				$('#editselect2').val(data.select).trigger('change');
				$('#edit_team').val(data.editcabinet.team);
				$('#edit_competition').val(data.editcabinet.comp);
				<?php
				if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
							$url = "https://";   
					else  
							$url = "http://";
					// Append the host(domain name, ip) to the URL.   
					$url .= $_SERVER['HTTP_HOST'];
				?>
				var trophyimage = "<?php echo $url;?>/storage/app/public/image/"+data.editcabinet.trophy_image;		
				$('.old_img').attr("src", trophyimage);
			}
		});
	})
</script>
<script>
$(document).on('click','.Most-stat-team',function(){
	var stat_id = $(this).data('value');
	var team_id = $('#team_id').val();
	$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("most_stat_player")}}',
			type:'post',
			data:{stat_id:stat_id,team_id:team_id},
			error:function(){
				alert('something went wrong');
			},
			success:function(response)
			{
				//alert('ok');
				if(response.top_player_data == 0)
				{
					let s_name = response.stat_name.substring(0, 7) + "..." ;
					$('#dropdownMenuButton1').html('MOST '+s_name);
					var profile_pic = "{{url('frontend/profile_pic/default_profile_pic.png')}}";
					$('#most_player_profile_pic').attr('src',profile_pic);
					$('#most_player_jersey_number').html('N/A');
					$('#most_stat_player_age').html('N/A');
					$('#most_stat_player_name').html('N/A');
					$('#most_player_location').html('N/A');
					$('#most_player_height').html('N/A');
				}
				else
				{
					$('#dropdownMenuButton1').html('MOST '+response.stat_name+'S');
					var profile_pic = '{{url("frontend/profile_pic")}}/'+response.top_stat_player.profile_pic;
					$('#most_player_profile_pic').attr('src',profile_pic);
					$('#most_player_jersey_number').html(response.most_stat_jersey_number);
					$('#most_stat_player_age').html(response.most_stat_player_age);
					$('#most_stat_player_name').html(response.top_stat_player.first_name+' '+response.top_stat_player.last_name);
					$('#most_player_location').html(response.top_stat_player.location);
					$('#most_player_height').html(response.top_stat_player.height);
				}
			}
		});
	
})
</script>
<script>
	$(document).on('click','#save_team_contact',function(){
		var x = 0;
		var team_id = $('#team_id').val();
		var team_email = $('#team_email').val();
		var team_phonenumber = $('#team_phonenumber').val();
		var team_address = $('#team_address').val();
		var phoneNum = team_phonenumber.replace(/[^\d]/g, '');
		if(phoneNum != ''){
			if(phoneNum.length >15){
				$('#team_phoneno_error').html("Phone number must not be greater than 15 digits.");
				x++;
			}else{
				$('#team_phoneno_error').html('');
			}
		}
		if(team_address != ''){
			if(team_address.length > 250){
				$('#team_address_error').html("Address must not be greater than 250 characters.");
				x++;
			}else{
				$('#team_address_error').html('');
			}
		}
		//alert(team_email+','+team_phonenumber+','+team_address);
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(team_email.match(mailformat))
		{
			if( x == 0){
				$('#team_email_error').html("");
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
					url:'{{url("save_team_contact")}}',
					type:'post',
					data:{team_id:team_id,team_email:team_email,team_phonenumber:team_phonenumber,team_address:team_address},
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
			$('#team_email_error').html("Enter valid email");
		}
	})
</script>
<!-- <script type="text/javascript">
const select = document.querySelector('#select_comp')

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
</script> -->
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

</html>

