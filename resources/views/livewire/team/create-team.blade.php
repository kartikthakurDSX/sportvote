<span >
	<button class="processed" wire:click="refresh">Refresh</button>
	{{-- wire:poll.750ms --}}
<div class="team-deatil row" id="adminsandplayers">
	<div class="col" >
		<h5>Administrators / Coaches</h5>
		<ul class="admin-list">
			@if($team_members)
				@foreach($team_members as $tm_mem)
					@if($tm_mem->member_position->member_type == 2)
						<?php if($tm_mem->invitation_status == 0)
							{
								$div_class= "pending-list";
							}
						else
							{
								$div_class= "";
							}
						?>

					<li class="{{$div_class}}"><i class="icon-angle-double-right"></i>{{$tm_mem->members->first_name}} {{$tm_mem->members->last_name}}<br>
						<span class="{{$div_class}}">({{$tm_mem->member_position->name}})</span>
						<a style="cursor:pointer" wire:click="cancel_request({{$tm_mem->id}})" class="btn btn-cross">×</a>
					</li>

					@else
					@endif
			  @endforeach
			@else
			@endif
		</ul>
	</div>
	<div class="col"><h5><span class="badge n_plyr badge-round-pink"></span>Players</h5>
		<ul class="player-list">
			@if($team_members)
				@foreach($team_members as $tm_mem)
					@if($tm_mem->member_position->member_type == 1)
						<?php if($tm_mem->invitation_status == 0)
							{
								$div_class= "pending-list";
							}
						else
							{
								$div_class= "";
							}
						?>
					 <li class="{{$div_class}}"><i class="icon-angle-double-right"></i>{{$tm_mem->members->first_name}} {{$tm_mem->members->last_name}}<br>
						<span class="{{$div_class}}">({{$tm_mem->member_position->name}})</span>
						<a style="cursor:pointer" wire:click="cancel_request({{$tm_mem->id}})" class="btn btn-cross">×</a>
					  </li>
					@else
					@endif
			  @endforeach
			@else
			@endif
		</ul>

	</div>
</div>
</span>
