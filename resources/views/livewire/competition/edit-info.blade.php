<div>
@if(Auth::check())
	<span class="float-md-end FootRFix">
		@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
			<button class="btn btn-Blue" wire:click="edit_info">Edit Info</button>
			<a class="btn-icon FollowIcoNN-Edit" wire:click="edit_info" style="cursor:pointer;"><span class="Edit-Icon-white"> </span></a>
		@else
			@if($user_profile)
				@if(!($comp_memeber))
					<button class="btn btn-Blue" wire:click="open_join_modal" title="Join as Referee">Join Competition</button>
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

	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Info</h5>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-4 mt-4">
							<div class=" col-md-12 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input name="comp_name" class="floating-input" type="text" placeholder=" " wire:model="comp_name">
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
										<input class="floating-input" type="text" id="complocation" placeholder=" " wire:model.debounce.120s="location">
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
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" wire:model="report_type" >
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
										<select class="floating-select" onclick="this.setAttribute('value', this.value);"  wire:model="vote_mins">
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
										<input class="floating-input" type="number" placeholder=" " min="{{$squad_players_num}}"  wire:model.lazy="squad_players_num" @if($competition->comp_start == 1) disabled @else @endif>
										<span class="highlight"></span>
										<label># Squad Players</label>
									</div>
								</div>
                                @error('squad_players_num') <span class="text-danger">{{ $message }}</span> @enderror
							</div>
							<div class=" col-md-6 FlotingLabelUp mb-20">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="number" placeholder=" " min="1"  wire:model.lazy="lineup_players_num" @if($competition->comp_start == 1) disabled @else @endif>
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
											<input class="floating-input" type="month" min="2023-01" placeholder=" " wire:model="seasonStart">
											<span class="highlight"></span>
											<label># Season Start</label>
										</div>
									</div>
									@error('seasonStart') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
								<div class=" col-md-6 FlotingLabelUp mb-20">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="month" min="2023-01" placeholder=" " wire:model="seasonEnd">
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
					<button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closemodal">Close</button>
					<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="save_info">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	
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
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$join_member_position}}" wire:model="join_member_position">
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
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$join_member_position1}}" wire:model="join_member_position1">
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
										<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="{{$join_member_position2}}" wire:model="join_member_position2">
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
@else
	<span class="float-md-end FootRFix">
		<button class="btn btn-Blue" data-bs-toggle="modal" data-bs-target="#join_login_modal">Follow</button>
		<img src="{{asset('frontend/images')}}/Follow-Icon.png" alt="" class="btn-icon FollowIcoNN">
	</span>
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
		$('#joinCompModal').modal('show')
	})
	</script>
	<script>
	window.addEventListener('CloseJoinModal', event=> {
		$('#joinCompModal').modal('hide')
	})
	</script>
	<script>
		window.addEventListener('livewire:load', function () {
				$('#complocation').on('keyup', () => {
					var autocomplete ;
					autocomplete = new google.maps.places.Autocomplete((document.getElementById('complocation')),{
					type:['geocode'],
					})
				})
				});
	</script>
</div>
