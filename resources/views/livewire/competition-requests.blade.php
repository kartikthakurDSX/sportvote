<div class="row">
    @if($competition_request->isNotEmpty())
        <div class="col-md-6" >
			<h1 class="Poppins-Fs30">Requested Competition <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
			<div class="CompetitionListScroll">
				<div class="grid">
					<div class="grid-container" id="ScrollRightBlue">
						<table>
							<thead>
								<tr class="header">
									<th>Competition Name<div>Competition Name</div></th>
									<th>Type<div>Type</div></th>
									<th>Start Date<div>Start Date</div></th>
									<th>Location<div>Location</div></th>
									<th>Action<div>Action</div></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; ?>
								@if($pending_competition_request->isNotEmpty())
									@foreach($pending_competition_request as $cr)
										<?php $sport = App\Models\Sport::find($cr->competition->sport_id);
										$competition_type = App\Models\competition_type::find($cr->competition->comp_type_id);
										$i++; ?>
										<tr>
											<input type="hidden" id="comp_request_id" value="{{$cr->id}}">
											<td><a href="{{ URL::to('competition/' . $cr->competition->id) }}" target="_blank"> @php echo Str::of($cr->competition->name)->limit(10); @endphp </a></td>
											<td>{{$competition_type->description}}</td>
											<td>@if($cr->competition->start_datetime != NULL) {{ date('d-M-y', strtotime($cr->competition->start_datetime))}} @else @endif</td>
											<td>@php echo Str::of($cr->competition->location)->limit(10); @endphp</td>
											<td>
											@if($cr->competition->user_id == Auth::user()->id)
												<button class="btn btn-green btn-xs-nb" data-bs-target="#accept_request" data-bs-toggle="modal" wire:click ="select_player({{$cr->id}})">Select Player</button>
											@else
												<button class="btn btn-green btn-xs-nb modal_teamOne" data-bs-target="#accept_request" data-bs-toggle="modal" wire:click ="select_player({{$cr->id}})">ACCEPT</button>
												<a class="btn btn-danger btn-xs-nb" href="" onclick="return confirm('Are you sure you want to cancel competition request?') || event.stopImmediatePropagation()" wire:click="reject_compjoin({{$cr->id}})">Reject</a>
											@endif
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td>
											No Data Found!!
										</td>
									<tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="accept_request" role="dialog" wire:ignore.self>
			<div class="modal-dialog modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<div class="container" style="background-color:#fff;height:auto;">
							<div class="row">
								<h1 class="Poppins-Fs30">Select @if($selected_comp) {{$selected_comp->squad_players_num}} @else @endif Players for the Competition</h1>
							</div>
							<div class="row">
								@foreach($attendee_ids as $key1 => $attendee1)
									<?php $player1 = App\Models\User::select('id','first_name','last_name','profile_pic')->find(@$attendee1);
										$full_name1 = @$player1->first_name." ".@$player1->last_name;?>
									@if(!empty($player1))
										<div class="col-3 select_player" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{$full_name1}}">
											<b> @php echo Str::of($full_name1)->limit(12); @endphp </b>
											<button class="select_player_btn" style="float:right;" wire:click="removeselected__player({{$key1}}	)">&times;</button>
										</div>
									@else
									@endif
								@endforeach
							</div>
						</div>
					</div>
					@if($team_member)
					<div class="modal-body">
						<table class='table'>
							<form id='selectplayerform'>
								<thead>
									<tr>
										<th>Select</th>
										<th>Player </th>
										<th>Player Position</th>
										<th>Jersey Number</th>
									</tr>
								</thead>
								@foreach($team_member as $tm)
									@if($tm->member_position)
										@if($tm->member_position->member_type == 1)
											<tr>
												<td>
													<input type='checkbox' wire:loading.attr="disabled" value="{{$tm->members->id}}" wire:model="attendee_ids.{{$loop->index}}" >
												</td>
												<td><img style="border-radius: 50%; width:30px; height:30px; border:1px double #fff;" src = "{{url('frontend/profile_pic')}}/{{$tm->members->profile_pic}}"> {{$tm->members->first_name}} {{$tm->members->last_name}}</td>
												<td>{{$tm->member_position->name}} {{$tm->member_position->name}}</td>
												<td>@if($tm->jersey_number) {{$tm->jersey_number}} @else -- @endif</td>
											</tr>
										@endif
										@endif
								@endforeach
								<input type="hidden" value="{{$comp_request_id}}" id='comp_req_id' name='comp_req_id'>

							</form>
						</table>
					</div>
					@else
					@endif
					<div class="modal-footer">
					<button class='btn btn-success float-md-end' wire:click="submit_player({{$comp_request_id}})">Submit</buton>
					</div>

				</div>
			</div>
		</div>
	@endif
	@if($competition_request->isNotEmpty())
		<div class="col-md-6" >
			<h1 class="Poppins-Fs30"> Accepted Competition  <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
			<div class="CompetitionListScroll">
				<div class="grid">
					<div class="grid-container" id="ScrollRightBlue">
						<table>
							<thead>
								<tr class="header">
									<th>Competition Name<div>Competition Name</div></th>
									<th>Type<div>Type</div></th>
									<th>Start Date<div>Start Date</div></th>
									<th>Location<div>Location</div></th>
									<th>Action<div>Action</div></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; ?>
								@foreach($competition_request as $cr)
									@if($cr->request_status == 1)
										<?php $sport = App\Models\Sport::find($cr->competition->sport_id);
											$competition_type = App\Models\competition_type::find($cr->competition->comp_type_id);
											$i++; ?>
										<tr>
											<input type="hidden" id="comp_request_id" value="{{$cr->id}}">
											<td>@php echo Str::of($cr->competition->name)->limit(10); @endphp</td>
											<td>{{$competition_type->description}}</td>
											<td>@if($cr->competition->start_datetime != NULL) {{ date('d-M-y', strtotime($cr->competition->start_datetime))}} @else @endif</td>
											<td>@php echo Str::of($cr->competition->location)->limit(10); @endphp</td>
											<td>
												<a class="btn btn-success btn-xs-nb reject" href="{{ URL::to('competition/' . $cr->competition->id) }}" target="_blank">VIEW</a>
											</td>
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
</div>

<!-- <script>
    $(document).on('click','.accept', function(){
        var comp_request = $(this).val();
        alert(comp_request);
        $('#comp_req_id').val(comp_request);
    });
</script> -->
