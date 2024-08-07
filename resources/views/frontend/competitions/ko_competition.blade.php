@include('frontend.includes.header')
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
<div class="Competitionn-Page-Additional">
		@livewire('competition.edit-banner',['comp_id' => $competition->id])
	<div class="dashboard-profile">
	   	<div class="container-lg">
		  	<div class="row bg-white">
			 	<div class="col-md-12  position-relative">
				 @livewire('competition.edit-logo',['comp_id' => $competition->id])
					<div class="user-profile-detail-Team float-start w-auto">
					<h5 class="SocerLegSty"><span class="header_gameTeam">Soccer Competition</span> @if($competition->location) in {{$competition->location}} @else -- @endif<br><br><strong>Created By:</strong> <a href="{{url('CompAdmin-profile/' .$competition->user_id.'/'.$competition->id)}}" target="_blank">  {{$competition->user->first_name}} {{$competition->user->last_name}} </a></h5>
					</div>
					<div class="w-auto float-end P-TB">
						@livewire('competition.edit-info', ['competition' => $competition->id])
					</div>
			 	</div>
		  	</div>
	   	</div>
	</div>
</div>
</div> <!-- close div of site wrap i.e. on header page-->
	<main id="main" class="dashboard-wrap Team-Public-Profil Competitionn-Page Competitionn-Page-Additional KoAdminView">
		<div class="container-fluid bg-GraySquad">
			<div class="container-lg">
			   <div class="row AboutMe">
				  <div class="col-md-2 col-12 resMob pr-0">
					 <div class="boxSuad">
						<span class="SquadCS"><span class="seasionBold">SEASON:</span></span>
						<br><span class="btn-secondaryNew">{{$comp_season}}</span>
						<!-- <select class="form-select btn-secondaryNew" aria-label="Default select example">
						  <option selected>2021-22</option>
						</select> -->
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
						<p class="fitIn"><span class="FiveFtComp">{{$matches_played}}</span><span class="SlePer">/{{$total_fixture}}</span></p>
					 </div>
				  </div>
				  <div class="col-md-3 mobCompetition">
                        <div class="row">
                            <div class="col-md-5 col-5 mobCopm ">
                                <div class="NAtionPLAyerTotal">
									<div class="">
										<span class="SquadCS ">TOTAL GOALS </span>
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
                                            <span class="SquadCS ">GOALS PER MATCH</span>
                                        </div>
                                        <div class=" fitIn">
                                            <span class="FiveFtComp">@if($avg_goal > 0) {{number_format((float)$avg_goal, 2, '.', '')}} @else {{$avg_goal}}.00 @endif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
				  @livewire('competition.add-sponsor', ['competition' => $competition->id])

			   </div>
			</div>
		</div>
		<div class="container-lg">
			@livewire('competition.addcompetition-news', ['competition' => $competition->id])
		</div>
		<div class="container-lg">
			<div class="row M-topSpace">
				<div class="col-md-8 col-lg-8">
					<div class="box-outer-lightpink MyTeamm">
						@livewire('comp-team-participate', ['competition' => $competition->id])
					</div>
					@livewire('competition.comp-ko-fixture-table', ['comp' => $competition->id])
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
												<?php $teamids = array(); ?>
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
																$team = App\Models\Team::select('name','id','location','team_logo')->find($teamid);

																 ?>
																<a href="{{ URL::to('team/' . $teamid) }}">
																	<li class="list-group-item d-flex justify-content-between align-items-start" title="{{$team->name}},[{{$team->location}}]">
																	<img class="img-fluid rounded-circle rounded-circle padd-RL" src="{{url('frontend/logo')}}/{{$team->team_logo}}"
																	  width="25%">
																	<div class="ms-2 me-auto EngCity">
																		<div class=" ManCity">
																			@php echo str::of($team->name)->limit(13); @endphp
																		</div>
																		 @php echo str::of($team->location)->limit(13); @endphp
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
								<div class="col-md-4 w-100-768 ">
									<div class="box-outer-lightpink">
										<ol class="list-group list-group-numbered">
											<div class="list-group-item d-flex justify-content-between align-items-start bgDark">
												<span class="btn-secondaryTable">TOP 5 PLAYERS:</span>
												<select class="form-select KoAdminViewDrop" aria-label="Default select example" id="change_player_stat">
													@foreach($team_stat as $stat)
														<option value="{{$stat->id}}" style="text-align:left;">{{$stat->name}}</option>
													@endforeach
												</select>
											</div>
											<span id="display_top_players">
												<?php $playerids = array();
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
												<select class="form-select KoAdminViewDrop" aria-label="Default select example" id="change_mvp" style="width: 76%;">
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

				</div>
				@livewire('competition.includes-league', ['competition' => $competition->id])
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

	<!-- The Modal View full ranking of top teams-->
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

	<!-- The Modal View full ranking of top 5 Players-->
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

	<!-- The Modal View ALL MVP winners Model-->
	<div class="modal fade" id="view_all_winners_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bgDark">
					<h5 class="modal-title btn-secondaryTable" id="exampleModalLabel">ALL MVP WINNERS</h5>
				</div>
				<div class="modal-body">
					@if(count($recent_winner) >0 )
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

@include('frontend.includes.footer')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
<script type="text/javascript" src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js')}}"></script>


<script type="text/javascript" src="{{url('frontend/js/jquery2.min.js')}}"></script>
<script type="text/javascript" src="{{url('frontend/js/popper.min.js')}}"></script>
<script src="{{url('frontend/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{url('frontend/js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{url('frontend/js/jquery-ui.js')}}"></script>
<script src="{{url('frontend/js/popper.min.js')}}"></script>
<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('frontend/js/script.js')}}"></script>
<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
<!-- <script type="text/javascript" src="{{url('frontend/assets/js/bootstrap-multiselect.js')}}"></script> -->

<style>
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

     <script type="text/javascript">
         $('.responsive-tabs i.fa').click(function() {
  $(this).parent().toggleClass('open');
});

$('.responsive-tabs > li a').click(function() {
  $('.responsive-tabs > li').removeClass('active');
  $(this).parent().addClass('active');
  $('.responsive-tabs').toggleClass('open');
});
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
			location.reload();
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
			location.reload();
		}
	});
})
</script>
<script>
$(document).on('change','#change_team_stat',function(){
	var sport_id = $(this).val();
	var comp_id = $('#comp_id').val();
	//alert(comp_id);
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
 <script type="text/javascript">
        $(function () {
            var owl = $('.offical_sponsor');
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
$(document).on('change','#full_ranking_player',function(){
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
				$('#display_full_top_players').html(html);
			}
			else
			{
				html = ''
				$.each(response.top_players_data, function(index, value)
				{
					html += value;

				});

				$('#display_full_top_players').html(html);
				//alert(response.top_teams_data);
			}
		},
		error:function(){
			alert('something went wrong');
		}

	});
})
</script>
<script type="text/javascript">
        $('.owlWinners').owlCarousel({
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


<script>
$(document).on('change','#full_ranking_team',function(){
	var sport_id = $(this).val();
	var comp_id = $('#comp_id').val();
	//alert(comp_id);
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
				$('#display_full_top_teams').html(html);
			}
			else
			{
				html = ''
				$.each(response.top_teams_data, function(index, value)
				{
					html += value;

				});

				$('#display_full_top_teams').html(html);
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
	$(document).on('click','#move_create_fixture', function(){
		var comp_id = $('#comp_id').val();
		$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		url:'{{url("create_fixture")}}',
		type:'post',
		data:{comp_id:comp_id},
		error:function(){
			alert('something went wrong');
		},
		success:function(response)
		{
			if(response == 0)
			{
				alert('referee is not ready');
			}
			else
			{
				$('#create_fixture').modal('show');
			}
		}

	});
	})
</script>

<script>
$(document).on('click','#contact_us',function(){
	 $('#contact_us_modal').modal('show');
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
<script>
$(document).on('click','#close_contact_us',function(){
		$('#contact_us_modal').modal('hide');
})
</script>

<script>
	$(document).on('click','#save_comp_contact',function(){
		var x = 0;
		var comp_id = $('#comp_id').val();
		var comp_email = $('#comp_email').val();
		var comp_phonenumber = $('#comp_phonenumber').val();
		var comp_address = $('#comp_address').val();
		var phoneNum = comp_phonenumber.replace(/[^\d]/g, '');
		//alert(comp_email+','+comp_phonenumber+','+comp_address);
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
<script type="text/javascript">
        $('.owlVotesInt-KO').owlCarousel({
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
@include('frontend.includes.searchScript')
