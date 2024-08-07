<span>
@if(Auth::check())
	@if(!empty($competition_member))
		@foreach($competition_member as $comp_mem)
			<div class="D-FSpacng">
			<div class="AdmIcon"><img src="{{asset('frontend/profile_pic')}}/{{$comp_mem->member->profile_pic}}" width="100%" alt=""> </div>
			<span class="SergiTeam"> {{$comp_mem->member->first_name}} {{$comp_mem->member->last_name}} <span class="SpanishTeam">  {{$comp_mem->member_position->name}} </span>
				@if($comp_mem->invitation_status == 0)
					[ Pending ]
					@if($competition->user_id == Auth::user()->id)
						<a class="btn btn-crossSocial" wire:click ="cancel_request({{$comp_mem->id}})" style="cursor:pointer;">×</a>
					@else
					@endif
				@else
				@endif

			</span>

			</div>
		@endforeach
		{{$competition_member->links()}}
	@else
			<div class="D-FSpacng">
				NA
			</div>
	@endif
@else
	@foreach($competition_member as $comp_mem)
	@if($comp_mem->invitation_status == 1)
		<div class="D-FSpacng">
		<div class="AdmIcon"><img src="{{asset('frontend/profile_pic')}}/{{$comp_mem->member->profile_pic}}" width="100%" alt=""> </div>
		<span class="SergiTeam"> {{$comp_mem->member->first_name}} {{$comp_mem->member->last_name}} <span class="SpanishTeam">  {{$comp_mem->member_position->name}} </span>
		</span>

		</div>
	@else
	@endif
	@endforeach
	{{$competition_member->links()}}
@endif
</span>
