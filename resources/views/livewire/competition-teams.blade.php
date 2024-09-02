<div >
	{{-- wire:poll.750ms --}}
	<button class="processed" wire:click="refresh">Refresh</button>
    @if($competition_teams->isNotEmpty())
		<div class="M-topSpace">
			<div class="row">

			</div>
			@if(Auth::check())
				@if(Auth::user()->id == $comp->user_id)
					@if($comp->comp_start != 1)
						@if($importteamrequest == "1 and 1")
						<div class="col-md-12 text-right">
							<button type="button" class="btn bg-blue start_competition_btn" wire:click="start_competition">Start Competition</button>
						</div>

						@else
						@endif
					@else
					@endif
				@else
				@endif
			@else
			@endif
		</div>
@endif

	<br/>
	@if(!empty($match_fixture_teams))
	<div class="col-md-12">
		<div class="row">
			<h1 class="Poppins-Fs30">Fixture Detail</h1>
			<div class="col-md-12 w-100-768 ">
				<div class="box-outer-lightpink">
					<ol class="list-group list-group-numbered">
						<div class="list-group-item d-flex justify-content-between align-items-start bgDark">
								<?php $team1 = App\Models\Team::find($match_fixture_teams->teamOne_id); ?>
								<?php $team2 = App\Models\Team::find($match_fixture_teams->teamTwo_id); ?>
								<p class="EngCity"><span class="btn">Start Date Time:</span> <span class="btn" style="font-weight:normal;">{{$match_fixture_teams->fixture_date}}</span>&nbsp;&nbsp;|&nbsp;<span class="btn">Venue:</span> <span class="btn" style="font-weight:normal;">{{$match_fixture_teams->venue}}</span></p>
								<!-- <a class="btn btn-success btn-lg" href="{{ URL::to('match-fixture/' . $match_fixture_teams->id) }}" >View</a> -->
								<a class="btn btn-success btn-lg" style="color:white;" wire:click="check_start_comp">View</a>
						</div>
					</ol>
				</div>
			</div>
		</div>
	</div>
	@endif
	<br/>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

window.addEventListener('swal:modal', event => {
    swal({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
    });
});

window.addEventListener('swal:confirm', event => {
    swal({
      title: event.detail.message,
      text: event.detail.text,
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


</div>
