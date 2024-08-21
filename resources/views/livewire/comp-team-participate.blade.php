<div>

	@if(Auth::check())
		@if(!$open_addteam)
		<button class="processed" wire:click="refresh">Refresh</button>
			<h1 class="Poppins-Fs30 bgDark">TEAMS PARTICIPATING </h1>
			<div class="row paddngSpcng">
				@if($comp_team_request->isNotEmpty())
					@livewire('competition.invite-team',['comp_id' => $competition->id], key('comp-inviteTeam'))
				@else
				@endif
				@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
					@if($competition->team_number > $accept_pending_compteam)
						<div class="col-md-20 text-center">
							<div class=" text-center">
								<a wire:click="add_team" style="cursor:pointer"><img src="{{url('frontend/images/invite-team-plus.png')}}" class="img-fluid team-Participate rounded-circle"
									width="100%"></a>
							</div>
							<p class="ArsenalParticpt">INVITE TEAM</p>
						</div>
					@elseif($comp_team_request->count() < 2)
						<div class="col-md-20 text-center">
							<div class=" text-center">
								<a wire:click="add_team" style="cursor:pointer"><img src="{{url('frontend/images/invite-team-plus.png')}}" class="img-fluid team-Participate rounded-circle"
									width="100%"></a>
							</div>
							<p class="ArsenalParticpt">INVITE TEAM</p>
						</div>
					@endif
				@else
					@if($comp_team_request->count() == 0)
						<p class="text-center"> No Data Found </p>
					@else
					@endif
				@endif
			</div>
		@else
		@endif
		<!-- display div on click add team -->
		@if($open_addteam)
			<div class="box-outer-lightpink MyTeamm" wire:ignore>
				<div class="row paddngSpcng">
					<h3 class="text-center">Select Teams</h3>
				</div>
				<div class="row paddngSpcng">
					<div class="col-12 mb-4">
						<div class="row mb-3 SendInvitationTeam" >
							<select id="category-dropdown" class="form-control" multiple wire:model="team_id">
								@foreach($teams as $keyt => $team)
									<option wire:key="t-{{$keyt}}" value="{{$team->id}}">{{$team->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="col-12 text-right mb-4">
					<button class="btn btn-success" wire:click="send_invitation">Send Invitation</button>
					<button class="btn btn-default btn-lg tryagn" wire:click="addteamcancel">Cancel</button>
				</div>
			</div>
		@else
		@endif
	@else
		<h1 class="Poppins-Fs30 bgDark">TEAMS PARTICIPATING </h1>
		<div class="owlTeamPart owlTeamPart-league owl-carousel owl-theme">
			@foreach($comp_teams_chunks as $key => $comp_teams)
				<div class="item" wire:key="item-{{$key}}">
					<div class="row paddngSpcng">
						@foreach($comp_teams as $key5 => $team)
						<div class="col-md-20 text-center" wire:key="team-{{$key5}}">
							<div class=" text-center">
								<img src="{{url('frontend/logo')}}/{{$team->team->team_logo}}" class="img-fluid team-Participate rounded-circle" width="100%">
							</div>
							<p class="ArsenalParticpt">@php echo Str::of($team->team->name)->limit(11); @endphp</p>
							<p class="Squad-particpt">SQUAD {{$competition->lineup_players_num}}/{{$competition->squad_players_num}}</p>
						</div>
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	@endif
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
	window.addEventListener('closeModal', event=> {
		$('#add_team').modal('hide');
		$('#create_fixture').modal('hide');
	});
	</script>
	<script>
	window.addEventListener('openModaladdteam', event=> {
		$('#add_team').modal('show');
	});
	</script>

	<script>
		window.onload = function() {
			$('#category-dropdown').select2();
			window.livewire.on('addteam', () => {
				$('#category-dropdown').select2();
				$('#category-dropdown').on('change', function (e) {
					let data = $(this).val();
						@this.set('team_id', data);
				});
			});
		};
	</script>
	<script type="text/javascript" src="{{url('frontend/js/dist_sweetalert.min.js')}}"></script>
	<script>
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
				window.livewire.dispatch('remove');
			}
			});
		});
	</script>
</div>
