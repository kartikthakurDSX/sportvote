
<div>
	<button class="processed" wire:click="refresh">Refresh</button>
@if(Auth::check())
    <div class="w-auto float-end P-TB"  >
		<span class="float-md-end FootRFix">
			@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $team_info->user_id))
				<button class="btn btn-Blue" wire:click="edit_info">Edit Info</button>
					<a class="btn-icon FollowIcoNN-Edit" wire:click="edit_info" style="cursor:pointer;"><span class="Edit-Icon-white"> </span></a>
			@else
				@if($user_profile)
					@if(!($team_memeber))
						<button class="btn btn-Blue" wire:click="open_join_modal">Join Team</button>
						<img src="{{url('frontend/images/Join-A-team-b.png')}}" alt="" class="btn-icon FollowIcoNN">
					@else
						<button class="btn btn-Blue">Joined</button>
						<img src="{{url('frontend/images/Join-A-team-b.png')}}" alt="" class="btn-icon FollowIcoNN">
					@endif
				@else
				@endif
				<!-- <button class="btn btn-black">Add Friend<img src="images/User_add_.png" alt="" class="btn-icon"></button>  -->
				@if($is_follow == 1)
					<button class="btn btn-Blue" wire:click ="team_unfollow({{ $team_id }})">Unfollow</button>
				@else
					<button class="btn btn-Blue" wire:click ="team_follow({{ $team_id }})">Follow</button>
				@endif
					<img src="{{url('frontend/images/Follow-Icon.png')}}" alt="" class="btn-icon FollowIcoNN">
			@endif
		</span>
		<h1 class="social-count " ><span class="FlowerFollow"><small>{{$follower->count()}} Followers</small></span></h1>
    </div>

	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Info</h5>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="text" placeholder=" " wire:model="team_name">
										<span class="highlight"></span>
										<label>Team Name</label>
									</div>
								</div>
                                @error('team_name') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="text" id="teamlocation" placeholder=" " wire:model.debounce.120s="team_location">
										<span class="highlight"></span>
										<label>Location</label>
									</div>
								</div>
                                @error('team_location') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="text" id="homeground_name" placeholder=" " wire:model="team_homeground_name">
										<span class="highlight"></span>
										<label>Home Ground Name</label>
									</div>
								</div>
                                @error('team_homeground_name') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="text" id="homeground_location" placeholder=" " wire:model.debounce.120s="team_homeground_location">
										<span class="highlight"></span>
										<label>Home Ground Location</label>
									</div>
								</div>

                                @error('team_homeground_location') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label ">
										<textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30" rows="3" wire:model="team_slogan" placeholder=" "></textarea>
										<span class="highlight"></span>
										<label class="TeamDescrForm">Team Slogan</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-6 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="color" placeholder=" " wire:model="team_color">
										<span class="highlight"></span>
										<label>Team Color</label>
									</div>
								</div>
							</div>
							<div class=" col-md-6 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="color" placeholder=" " wire:model="font_color">
										<span class="highlight"></span>
										<label>Font Color</label>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closemodal">Close</button>
				<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="save_info">Save changes</button>
			  </div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="joinTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Join a Team</h5>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp ">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$join_member_position}}" wire:model="join_member_position">
											<option value=""></option>
											@foreach($player_position as $position)
											<option value="{{$position->id}}">{{$position->name}}</option>
											@endforeach
										</select>
										<span class="highlight"></span>
										<label>Preferred Position*</label>
									</div>
									@error('join_member_position') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label ">
										<textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30" rows="3"  placeholder=" " wire:model="join_reason"></textarea>
										<span class="highlight"></span>
										<label class="TeamDescrForm">Cover letter*</label>
									</div>
									@error('join_reason') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp ">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$join_member_position1}}" wire:model="join_member_position1">
											<option value=""></option>
											@foreach($player_position as $position)
											<option value="{{$position->id}}">{{$position->name}}</option>
											@endforeach
										</select>
										<span class="highlight"></span>
										<label>Alternative Position 1</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp ">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$join_member_position2}}" wire:model="join_member_position2">
											<option value=""></option>
											@foreach($player_position as $position)
											<option value="{{$position->id}}">{{$position->name}}</option>
											@endforeach
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
				<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="join_team">Join</button>
			  </div>
			</div>
		</div>
	</div>

@else
<div class="w-auto float-end P-TB"  >
		<span class="float-md-end FootRFix">
			<button class="btn btn-Blue" data-bs-toggle="modal" data-bs-target="#join_login_modal">Follow</button>
			<img src="{{url('frontend/images/Follow-Icon.png')}}" alt="" class="btn-icon FollowIcoNN">
		</span>
		<h1 class="social-count " ><span class="FlowerFollow"><small>{{$follower->count()}} Followers</small></span></h1>
    </div>
@endif


<script>
  window.addEventListener('OpenModal', event=> {
     $('#editModal').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseModal', event=> {
     $('#editModal').modal('hide')
  })
</script>
<script>
  window.addEventListener('OpenJoinModal', event=> {
     $('#joinTeamModal').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseJoinModal', event=> {
     $('#joinTeamModal').modal('hide')
  })
</script>

<script type="text/javascript">
document.addEventListener('livewire:load', function () {
	$(document).ready(function(){
		var autocomplete;
		var id = 'teamlocation';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})

	});
})
</script>
<script>
	window.addEventListener('livewire:load', function () {
            $('#homeground_location').on('keyup', () => {
                var autocomplete ;
                autocomplete = new google.maps.places.Autocomplete((document.getElementById('homeground_location')),{
				type:['geocode'],
			    });
            });
            });
</script>

</div>
