<div class="row paddngSpcng">
	{{--  wire:poll.750ms --}}
	<button class="processed" wire:click="refresh">Refresh</button>
	@foreach($comp_team_request as $ke => $comp_tr)
		<?php
		$selected_player = App\Models\Competition_attendee::select('id')->where('competition_id',$competition->id)->where('team_id',$comp_tr->team->id)->count();
		?>
		<div class="col-md-20 text-center team-cross-hover" wire:key="comp_tr-{{$ke}}">
			<div class="text-center">
				<?php
					$team_admin = App\Models\Team::select('user_id')->find($comp_tr->team->id);
					$team_owner = $team_admin->user_id;
					$team_admins = App\Models\Team_member::where('team_id',$comp_tr->team->id)->where('member_position_id',4)->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
					$team_admin_ids = $team_admins->ToArray();
					array_push($team_admin_ids, $team_owner);
                    // dd($comp_tr->team->id);
				?>
				@if(Auth::check())
					@if(in_array(Auth::user()->id, $team_admin_ids))
						<a wire:click="select_player({{$comp_tr->team->id}})" style="cursor:pointer;">
							<img src="{{asset('frontend/logo')}}/{{$comp_tr->team->team_logo}}" class="img-fluid team-Participate rounded-circle "
							width="100%">
						</a>
					@else
						<a wire:click="openModalteamattendees({{$comp_tr->team->id}})" style="cursor:pointer;">
							<img src="{{asset('frontend/logo')}}/{{$comp_tr->team->team_logo}}" class="img-fluid team-Participate rounded-circle "
							width="100%">
						</a>
					@endif
				@else
				@endif
			</div>
			<p class="ArsenalParticpt" title="{{$comp_tr->team->name}} ">
				@php echo Str::of($comp_tr->team->name)->limit(7); @endphp
			</p>
			@if(in_array($comp_tr->team->id, $comp_admin_team_ids))
				<span>
					@if($comp_tr->request_status == 0)
						@if(Auth::check())
							@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
								<p style="cursor:pointer;" class="Squad-particpt" title="you are the team owner" wire:click="select_player({{$comp_tr->team->id}})"> SELECT PLAYERS </p>
							@else
								<p class="Squad-particpt"> PENDING </p>
							@endif
						@else
						@endif
					@else
						@if($selected_player == $competition->squad_players_num)
							<p class="Squad-particpt-selected"> SQUAD SELECTED </p>
						@else
							@if($selected_player == 0)
								<p style="cursor:pointer;" class="Squad-particpt" title="i.e. your own team" wire:click="select_player({{$comp_tr->team->id}})"> SELECT PLAYERS </p>
							@else
								<p style="cursor:pointer;" class="Squad-particpt" title="i.e. your own team" wire:click="select_player({{$comp_tr->team->id}})"> SQUAD {{$selected_player}}/{{$competition->squad_players_num}}</p>
							@endif
						@endif
					@endif
				</span>
				<span>
					@if(Auth::check())
						@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
							@if($competition->comp_start != 1)
								@if($selected_player < $competition->squad_players_num)
								<span>
									<a style="cursor:pointer;" onclick="return confirm('Are you sure you want to remove team?')" wire:click="remove_team_comp({{$comp_tr->id}})"><i class="icon-trash "></i></a>
									<i class="icon-alaram  " style="font-size:large !important;"></i>
								</span>
								<i class="icon-bell " style="font-size:large !important; cursor:pointer;" title="Resend notification to Team Admin" wire:click="resend_notification({{$comp_tr->id}})"></i>
								@else
								@endif
							@else
							@endif
						@else
						@endif
					@else
					@endif
				</span>
			@else
				<span>
					@if($comp_tr->request_status == 0)
						<p class="Squad-particpt"> PENDING </p>
						@if(Auth::check())
							@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
								@if($competition->comp_start != 1)
									<span>
										<a style="cursor:pointer;" onclick="return confirm('Are you sure you want to remove team?')" wire:click="remove_team_comp({{$comp_tr->id}})"><i class="icon-trash "></i></a>
											<i class="icon-alaram  " style="font-size:large !important;"></i>
									</span>
									<i class="icon-bell " style="font-size:large !important; cursor:pointer;" title="Resend notification to Team Admin" wire:click="resend_notification({{$comp_tr->id}})"></i>
								@else
								@endif
							@else
							@endif
						@else
						@endif
					@else
						@if($selected_player == $competition->squad_players_num)
							<p class="Squad-particpt-selected"> SQUAD SELECTED </p>
						@else
							<p class="Squad-particpt"> SQUAD {{$selected_player}}/{{$competition->squad_players_num}}</p>
							@if(Auth::check())
								@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
									@if($selected_player <= $competition->squad_players_num)
									<span>
											<a style="cursor:pointer;" onclick="return confirm('Are you sure you want to remove team?')" wire:click="remove_team_comp({{$comp_tr->id}})"><i class="icon-trash "></i></a>
												<i class="icon-alaram  " style="font-size:large !important;"></i>
									</span>
									<i class="icon-bell " style="font-size:large !important; cursor:pointer;" title="Resend notification to Team Admin" wire:click="resend_notification({{$comp_tr->id}})"></i>
									@else
									@endif
								@else
								@endif
							@else
							@endif
						@endif
					@endif
				</span>
			@endif
		</div>
	@endforeach
	<!-- The Modal -->
	<div class="modal fade" id="teamattendees" wire:ignore.self>
		<div class="modal-dialog modal-xl">
			<div class="modal-content" >
				<!-- Modal Header -->
				<div class="modal-header">
				  <h1><span class="modal-title">Team Members</span></h1>
					<?php $team_admins = App\Models\Team_member::where('team_id',$selected_team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
						$team_admin_ids = $team_admins->toArray();
						$team_squad_player = App\Models\Competition_attendee::where('competition_id',$competition->id)->where('team_id',$selected_team_id)->count();?>
					@if(Auth::check())
						@if((Auth::user()->id == $team_user_id) || in_array(Auth::user()->id, $team_admin_ids))
							@if($competition->comp_start != 1)
								@if($competition->squad_players_num > $team_squad_player)
									<span style="cursor:pointer;" class="comp_team_add_player" wire:click="select_player({{$selected_team_id}})">Add Player</span>
								@else
								@endif
							@else
							@endif
						@else
						@endif
					@else
					@endif
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					@if($team_attendees)
						@if($team_attendees->count() > 0)
							<ul style="list-style: none;" class="table table-hover Player-li-hover">
								@foreach($team_attendees as $k => $team_a)
								<?php $team_member_position = App\Models\Team_member::where('team_id',$team_a->team->id)->where('member_id',$team_a->player->id)->with('member_position')->first();
									?>
									<li wire:key="team_a-{{$k}}">
										<div class="row mb-4">
											<div class="col-2">
												<h6>{{$loop->iteration}}</h6>
											</div>
											<div class="col-4">
												<a href="{{url('player_profile/' .$team_a->player->id)}}" target="a_blank"> <img src="{{url('frontend/profile_pic')}}/{{$team_a->player->profile_pic}}" class="img-fluid rounded-circle" width="40% !important"></a>
											</div>
											 <div class="col-4">
												<a href="{{url('player_profile/' .$team_a->player->id)}}" target="a_blank"><h5>{{$team_a->player->first_name}} {{$team_a->player->last_name}} </h5></a><small>[{{$team_member_position->member_position->name}}]</small>

											</div>
											<div class="col-2">
											<?php $team_admins = App\Models\Team_member::where('team_id',$team_a->team->id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
													$admins = $team_admins->toArray();?>
												@if(Auth::check())
													@if((Auth::user()->id == $team_a->team->user_id) || in_array(Auth::user()->id, $admins))
														@if($competition->comp_start != 1)
															<a style="cursor:pointer; color:#000;" class="btn Player-btn-cross" onclick="return confirm('Are you sure you want to remove Player?')|| event.stopImmediatePropagation()" wire:click="remove_player({{$team_a->id}})">×</a>

														@else
														@endif
													@else
													@endif
												@else
												@endif
											</div>

										</div>
									</li>

								@endforeach
							</ul>
						@else
							<h5>Players not selected by team admin</h5>
						@endif
					@else
						<h5>Players not selected by team admin</h5>
					@endif
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
				  <button type="button" class="btn" wire:click="closeteamattendees" style="color:#fff; background-color:#003b5f;">Close</button>
				</div>
		  </div>
		</div>
	</div>
    <!-- player list model-->
	<div class="modal fade" id="accept_request" role="dialog" wire:ignore.self>
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<div class="container" style="background-color:#fff;height:auto;">
						<div class="row">
							<h1 class="Poppins-Fs30">Select between {{$competition->lineup_players_num}} and {{$competition->squad_players_num}} players for the Competition</h1>
						</div>
						<div class="row mRemoveSelectPlayer">
							@foreach($comp_attendee_ids as $key1 => $attendee)
								<?php $player = App\Models\User::select('id','first_name','last_name','profile_pic')->find($attendee);
									$full_name = $player->first_name." ".$player->last_name;?>
								<div wire:key="attend-{{$key1}}" class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 select_player" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{$full_name}}">
									<b> @php echo Str::of($full_name)->limit(12); @endphp </b>
									<button class="select_player_btn" style="float:right;" onclick="return confirm('Are you sure you want to remove Player?')|| event.stopImmediatePropagation()" wire:click="remove_player({{$attendee}})">&times;</button>
								</div>
							@endforeach
							@foreach($attendee_ids as $key2 => $attendee1)
								<?php $player1 = App\Models\User::select('id','first_name','last_name','profile_pic')->find(@$attendee1);
									$full_name1 = @$player1->first_name." ".@$player1->last_name;?>
								@if(!empty($player1))
									<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 select_player" wire:key="atten1-{{$key2}}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{$full_name1}}">
										<b> @php echo Str::of($full_name1)->limit(12); @endphp </b>
										<button class="select_player_btn" style="float:right;" wire:click="removeselected__player({{$key2}}	)">&times;</button>
									</div>
								@else
								@endif
							@endforeach
							@php
								if(count($attendee_ids) > 0){
									$comp_attendee_count = count($comp_attendee_ids) + count($attendee_ids);
								}else{
									$comp_attendee_count = count($comp_attendee_ids);
								}
							@endphp
							@if(count($comp_attendee_ids) < $competition->lineup_players_num)
								<span class="text-danger" id="location_error">* Select at least {{$competition->lineup_players_num}} Players For the Competition.</span>
							@else
							@endif
						</div>
					</div>
				</div>
				@if($team_members)
					<div class="modal-body">

						<table class='table'>
							<thead>
								<tr>
									<th>Select</th>
									<th>Player </th>
									<th>Player Position</th>
									<th>Jersey Number</th>
								</tr>
							</thead>
								<tr>
									<td>
										<input type='checkbox' value="" wire:model="selectAll">
									</td>
									<td>Select All</td>
								</tr>
								@foreach($team_members as $key3 => $tm)
									@if($tm->member_position->member_type == 1)
										<tr wire:key="tm-{{$key3}}">
											<td>
												{{-- <input type='checkbox' wire:loading.attr="disabled" value="{{$tm->members->id}}" wire:model="attendee_ids.{{$loop->index}}" > --}}
												<input type='checkbox' wire:loading.attr="disabled" value="{{$tm->members->id}}" wire:model="attendee_ids" id="checkbox-{{$key3}}">
											</td>
											<td><img style="border-radius: 50%; width:30px; height:30px; border:1px double #fff;" src = "{{url('frontend/profile_pic')}}/{{$tm->members->profile_pic}}"> {{$tm->members->first_name}} {{$tm->members->last_name}}</td>
											<td> {{$tm->member_position->name}}</td>
											<td>@if($tm->jersey_number) {{$tm->jersey_number}} @else -- @endif</td>
										</tr>
									@endif
								@endforeach
						</table>
					</div>
				@else
				@endif
				<div class="modal-footer">
					<?php $comp_players = App\Models\Competition_attendee::select('id')->where('competition_id',$competition->id)->where('team_id',$selected_team_id)->count();?>
					@if($comp_players < $competition->squad_players_num)
					<button class='btn btn-success float-md-end' type="button" wire:click='submit_player({{$selected_team_id}})'>Submit</button>
					@else
					@endif
				</div>
			</div>
		</div>
	</div>
	<script>
		window.addEventListener('openModalteamattendees', event=> {
			$('#teamattendees').modal('show');
		});
	</script>
	<script>
		window.addEventListener('closeModalteamattendees', event=> {
			$('#teamattendees').modal('hide');
		});
	</script>
	<script>
		window.addEventListener('openModalteamplayerlist', event=> {
			$('#accept_request').modal('show');
		});
	</script>
	<script>
		window.addEventListener('closeModalteamplayerlist', event=> {
			$('#accept_request').modal('hide');
		});
	</script>
</div>
