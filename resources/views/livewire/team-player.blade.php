<div>
	<button class="processed" wire:click="refresh">Refresh</button>
   @if(Auth::check())
	<div class="box-outer-lightpink MyTeamm TeamPlayersSlider">
		<ul class="nav nav-pills  mb-3" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation" id="pills-tabContent1">
				<div class="nav-link active " id="pills-home-tab" data-bs-toggle="pill"
					data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
					aria-selected="true">
					<span class="Allthr"><?php echo str_pad($total_player, 2, 0, STR_PAD_LEFT); ?></span><span class="AllUnderr"> All</span>
				</div>
			</li>
			@foreach($player_member_position as $player_position)
				<?php
					$count = 0;
					foreach($team_member as $tm)
					{
						if($tm->member_position_id == $player_position->id)
							{
							$count++;
							}
					}
				?>
				<li class="nav-item" role="presentation" id="pills-tabContent_{{$player_position->id}}">
					<div class="nav-link " id="pills-profile-tab_{{$player_position->id}}" data-bs-toggle="pill"
						data-bs-target="#pills-profile_{{$player_position->id}}" type="button" role="tab"
						aria-controls="pills-profile_{{$player_position->id}}" aria-selected="false" data-id="{{$player_position->id}}"><span
							class="Allthr"><?php echo str_pad($count, 2, 0,STR_PAD_LEFT);  ?></span><span class="AllUnderr"> {{$player_position->name}}s</span>
					</div>
				</li>
			@endforeach
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" >
				@if($team_member->isNotEmpty())
					<?php $tm_data = array(); ?>
						@foreach($team_member as $team_data)
							<?php $tm_data[] = $team_data;?>
						@endforeach
						<?php $players_data = array_chunk($tm_data,12);
					?>
					<div class="owlsp owl-carousel owl-theme">
						@foreach($players_data as $p_data)
							<div class="item">
								<div class="row">
									@foreach($p_data as $tm)
										<div class="col-md-3">
											<div class="player-jersy-list W-100">
												<div class="jersy-img-wrap mb-2">
													<span class="jersy-no team-jersy-right jersy1">@if($tm->jersey_number) {{$tm->jersey_number}} @else NA @endif</span>
													<div class="jersy-img">
														<a href="{{url('player_profile/'.$tm->members->id)}}"><img src="{{url('frontend/profile_pic')}}/{{$tm->members->profile_pic}}" width="100%" alt="">  </a>
													</div>
												</div>
												<div class="jersy-plyr-title ">
													<span class="GoalKK">{{$tm->members->first_name}} {{$tm->members->last_name}}</span>
													<p class="SpanishTeam">@if($tm->members->dob) <?php $age = Carbon\Carbon::parse($tm->members->dob)->age; ?> {{$age}} yrs @else NAN  yrs @endif | @if($tm->members->location) {{$tm->members->location}} @else NAN @endif | @if($tm->members->height)  {{$tm->members->height}} Cm @else NAN @endif</p>
													<p class="GoalKK">{{$tm->member_position->name}}</p>
													@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $tm->team->user_id))
														<span>
															<a style="cursor:pointer;" href="" class="remove_players_teampage" onclick="return confirm('Are you sure you want to remove Player from Team?')|| event.stopImmediatePropagation()" wire:click="remove_player({{$tm->id}})"> <i class="icon-trash " style="font-size:large !important;"></i></a>
															<span class="Edit-Team-player-jerseyno" wire:click="edit_player_info({{$tm->id}})" style="cursor:pointer;"></span>
														</span>
													@else
													@endif
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endforeach
					</div>
				@else
					<p style="text-align:center; font-weight:bold;"> No Data Found </p>
				@endif
			</div>
			@foreach($player_member_position as $player_position)
				<div class="tab-pane fade" id="pills-profile_{{$player_position->id}}" role="tabpanel" aria-labelledby="pills-profile-tab_{{$player_position->id}}">
					<?php $memberdata = 0;
					$position_players = App\Models\Team_member::select('id','jersey_number','member_position_id','member_id','team_id','invitation_status')->where('member_position_id',$player_position->id)->where('team_id',$team->id)->where('invitation_status',1)->with('members:id,first_name,last_name,dob,height,location,profile_pic,email','member_position:id,name','team:id,team_color,user_id')->where('is_active',1)->get();
					//echo "<pre>";
					//print_r($position_players);
					?>
					@if($position_players->isNotEmpty())
						<?php $ptm_data = array(); ?>
						@foreach($position_players as $pteam_data)
							<?php $ptm_data[] = $pteam_data;?>
						@endforeach
						<?php $pplayers_data = array_chunk($ptm_data,12);?>
						<div class="owlsp owl-carousel owl-theme">
							@foreach($pplayers_data as $p_data)
								<div class="item">
									<div class="row">
										@foreach($p_data as $tm)
											<div class="col-md-3">
												<div class="player-jersy-list W-100">
													<div class="jersy-img-wrap mb-2">
														<span class="jersy-no team-jersy-right jersy1">@if($tm->jersey_number) {{$tm->jersey_number}} @else NA @endif</span>
														<div class="jersy-img">
															<a href="{{url('player_profile/'.$tm->members->id)}}"><img src="{{url('frontend/profile_pic')}}/{{$tm->members->profile_pic}}" width="100%" alt="">  </a>
														</div>
													</div>
													<div class="jersy-plyr-title ">
														<span class="GoalKK">{{$tm->members->first_name}} {{$tm->members->last_name}}</span>
														<p class="SpanishTeam">@if($tm->members->dob) <?php $age = Carbon\Carbon::parse($tm->members->dob)->age; ?> {{$age}} yrs @else NAN  yrs @endif | @if($tm->members->location) {{$tm->members->location}} @else NAN @endif | @if($tm->members->height)  {{$tm->members->height}} Cm @else NAN @endif</p>
														<p class="GoalKK">{{$tm->member_position->name}}</p>
														@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $tm->team->user_id))
															<span>
																<a style="cursor:pointer;" href="" class="remove_players_teampage" onclick="return confirm('Are you sure you want to remove Player from Team?')|| event.stopImmediatePropagation()" wire:click="remove_player({{$tm->id}})"> <i class="icon-trash " style="font-size:large !important;"></i></a>
																<span class="Edit-Team-player-jerseyno" wire:click="edit_player_info({{$tm->id}})" style="cursor:pointer;"></span>
															</span>
														@else
														@endif
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							@endforeach
						</div>
					@else
						<p style="text-align:center; font-weight:bold;"> No Data Found </p>
					@endif
				</div>
			@endforeach
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal fade" id="edit_playerinfo" wire:ignore.self>
		<div class="modal-dialog modal-xl">
			<div class="modal-content" >
				<!-- Modal Header -->
				<div class="modal-header">
				  <h1><span class="modal-title">Edit Jersey Number</span></h1>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div class="container">
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="number" placeholder=" " min="0" max="99" wire:model="player_jersey_number">
										<span class="highlight"></span>
										<label>Jersey Number</label>
									</div>
									@error('player_jersey_number') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$player_position_id}}" wire:model="player_position_id">
											<option value=""></option>
											@foreach($player_member_position as $player_psoition)
										  		<option value="{{$player_psoition->id}}">{{$player_psoition->name}}</option>
											@endforeach
										</select>
										<span class="highlight"></span>
										<label>Player Position</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
				  <button type="button" class="btn" wire:click="closeeditModal" style="color:#fff; background-color:#003b5f;">Close</button>
				  <button type="button" class="btn" wire:click="save_info({{$tm_id}})" style="color:#fff; background-color:#003b5f;">Save</button>
				</div>
		  </div>
		</div>
	</div>
@else
<div class="box-outer-lightpink MyTeamm TeamPlayersSlider">
		<ul class="nav nav-pills  mb-3" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation" id="pills-tabContent1">
				<div class="nav-link active " id="pills-home-tab" data-bs-toggle="pill"
					data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
					aria-selected="true">
					<span class="Allthr"><?php echo str_pad($total_player, 2, 0, STR_PAD_LEFT); ?></span><span class="AllUnderr"> All</span>
				</div>
			</li>
			@foreach($player_member_position as $player_position)
				<?php
					$count = 0;
					foreach($team_member as $tm)
					{
						if($tm->member_position_id == $player_position->id)
							{
							$count++;
							}
					}
				?>
				<li class="nav-item" role="presentation" id="pills-tabContent_{{$player_position->id}}">
					<div class="nav-link " id="pills-profile-tab_{{$player_position->id}}" data-bs-toggle="pill"
						data-bs-target="#pills-profile_{{$player_position->id}}" type="button" role="tab"
						aria-controls="pills-profile_{{$player_position->id}}" aria-selected="false" data-id="{{$player_position->id}}"><span
							class="Allthr"><?php echo str_pad($count, 2, 0,STR_PAD_LEFT);  ?></span><span class="AllUnderr"> {{$player_position->name}}</span>
					</div>
				</li>
			@endforeach
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
				@if($team_member->isNotEmpty())
					<?php $tm_data = array(); ?>
						@foreach($team_member as $team_data)
							<?php $tm_data[] = $team_data;?>
						@endforeach
						<?php $players_data = array_chunk($tm_data,12);
					?>
					<div class="owlsp owl-carousel owl-theme">
						@foreach($players_data as $p_data)
							<div class="item">
								<div class="row">
									@foreach($p_data as $tm)
										<div class="col-md-3">
											<div class="player-jersy-list W-100">
												<div class="jersy-img-wrap mb-2">
													<span class="jersy-no team-jersy-right jersy1">@if($tm->jersey_number) {{$tm->jersey_number}} @else  @endif</span>
													<div class="jersy-img">
														<a href="{{url('player_profile/'.$tm->members->id)}}"><img src="{{url('frontend/profile_pic')}}/{{$tm->members->profile_pic}}" width="100%" alt="">  </a>
													</div>
												</div>
												<div class="jersy-plyr-title ">
													<span class="GoalKK">{{$tm->members->first_name}} {{$tm->members->last_name}}</span>
													<p class="SpanishTeam">@if($tm->members->dob) <?php $age = Carbon\Carbon::parse($tm->members->dob)->age; ?> {{$age}} yrs @else NAN  yrs @endif | @if($tm->members->location) {{$tm->members->location}} @else NAN @endif | @if($tm->members->height)  {{$tm->members->height}} Cm @else NAN @endif</p>
													<p class="GoalKK">{{$tm->member_position->name}}</p>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endforeach
					</div>
				@else
					<p style="text-align:center; font-weight:bold;"> No Data Found </p>
				@endif
			</div>
			@foreach($player_member_position as $player_position)
				<div class="tab-pane fade" id="pills-profile_{{$player_position->id}}" role="tabpanel" aria-labelledby="pills-profile-tab_{{$player_position->id}}">
					<?php $memberdata = 0;
					$position_players = App\Models\Team_member::select('id','jersey_number','member_position_id','member_id','team_id','invitation_status')->where('member_position_id',$player_position->id)->where('team_id',$team->id)->where('invitation_status',1)->with('members:id,first_name,last_name,dob,height,location,profile_pic,email','member_position:id,name','team:id,team_color,user_id')->where('is_active',1)->get();
					//echo "<pre>";
					//print_r($position_players);
					?>
					@if($position_players->isNotEmpty())
						<?php $ptm_data = array(); ?>
						@foreach($position_players as $pteam_data)
							<?php $ptm_data[] = $pteam_data;?>
						@endforeach
						<?php $pplayers_data = array_chunk($ptm_data,12);?>
						<div class="owlsp owl-carousel owl-theme">
							@foreach($pplayers_data as $p_data)
								<div class="item">
									<div class="row">
										@foreach($p_data as $tm)
											<div class="col-md-3">
												<div class="player-jersy-list W-100">
													<div class="jersy-img-wrap mb-2">
														<span class="jersy-no team-jersy-right jersy1">@if($tm->jersey_number) {{$tm->jersey_number}} @else  @endif</span>
														<div class="jersy-img">
															<a href="{{url('player_profile/'.$tm->members->id)}}"><img src="{{url('frontend/profile_pic')}}/{{$tm->members->profile_pic}}" width="100%" alt="">  </a>
														</div>
													</div>
													<div class="jersy-plyr-title ">
														<span class="GoalKK">{{$tm->members->first_name}} {{$tm->members->last_name}}</span>
														<p class="SpanishTeam">@if($tm->members->dob) <?php $age = Carbon\Carbon::parse($tm->members->dob)->age; ?> {{$age}} yrs @else NAN  yrs @endif | @if($tm->members->location) {{$tm->members->location}} @else NAN @endif | @if($tm->members->height)  {{$tm->members->height}} Cm @else NAN @endif</p>
														<p class="GoalKK">{{$tm->member_position->name}}</p>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							@endforeach
						</div>
					@else
						<p style="text-align:center; font-weight:bold;"> No Data Found </p>
					@endif
				</div>
			@endforeach
		</div>
	</div>
@endif


<script>
  window.addEventListener('openeditModal', event=> {
     $('#edit_playerinfo').modal('show')
  })
</script>
<script>
  window.addEventListener('closeeditModal', event=> {
     $('#edit_playerinfo').modal('hide')
  })
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	window.livewire.on('added_player', () => {

       $('[href="#pills-home"]').tab('show');
    })

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
<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript">
window.onload = function()
{

		$('.owlsp').owlCarousel({
			loop: false,
			margin: 10,
			nav: true,
			responsive: {
				0: {
					items: 2
				},
				600: {
					items: 3
				},
				1000: {
					items: 4
				}
			}
		})

}
</script>

</div>
