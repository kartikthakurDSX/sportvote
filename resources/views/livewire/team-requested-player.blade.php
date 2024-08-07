<span >
	{{-- wire:poll.750ms --}}
	<button class="processed" wire:click="refresh">Refresh</button>
@if(!empty($team_member))
	@foreach($team_member as $team_mem)
		@if($loop->index < 10)
			<div class="D-FSpacng">
			<div class="AdmIcon"><img src="{{url('frontend/profile_pic')}}/{{$team_mem->members->profile_pic}}" width="100%" alt=""> </div>
			<span class="SergiTeam"> {{$team_mem->members->first_name}} {{$team_mem->members->last_name}} <span class="SpanishTeam">  {{$team_mem->member_position->name}} </span> @if($team_mem->invitation_status == 0) [ Pending ] <a class="btn btn-crossSocial" wire:click ="cancel_request({{$team_mem->id}})" style="cursor:pointer;">×</a>
			@elseif($team_mem->invitation_status == 2)  [decline]
			 @else @endif</span>
			</div>
		@else
		@endif
	@endforeach
	{{$team_member->links('cpag.custom')}}
@else
		<div class="D-FSpacng">
			NA
		</div>
@endif
</span>
