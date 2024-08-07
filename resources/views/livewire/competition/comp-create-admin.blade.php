<div>
  <h5>Administered By</h5>
	<ul class="admin-list">
	@foreach($competition_member as $comp_mem)
		@if($comp_mem->member_position_id)
			@if($comp_mem->invitation_status == 0)
				<li class="pending-list"><i class="icon-angle-double-right"></i> {{$comp_mem->member->first_name}} {{$comp_mem->member->last_name}}<span class="pending-icon"></span><br>
				<span>({{$comp_mem->member_position->name}})</span>
				<a href="#" class="btn btn-cross" wire:click ="remove_member({{$comp_mem->id}})">×</a>
				</li> 
			@elseif($comp_mem->invitation_status == 1)
				<li><i class="icon-angle-double-right"></i> {{$comp_mem->member->first_name}} {{$comp_mem->member->last_name}}<br>
				<span>({{$comp_mem->member_position->name}})</span>
				</li>
			@else
			@endif
		@endif
	@endforeach
	</ul> 
</div>
