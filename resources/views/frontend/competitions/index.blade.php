@include('frontend.includes.header')
<div class="header-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong> Competition List</strong></h1>
			</div>
		</div>
	</div>
</div>

<main id="main">
	<div class="container">
        <div class="row">
			@livewire('competition-requests')
			@livewireScripts
			@if($my_comp->isNotEmpty())
				<div class="col-md-6">
					<br/>
					<h1 class="Poppins-Fs30"> My Competition <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
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
										<?php $i = 1; ?>
										@foreach($my_comp as $tm)
											@if($tm->is_active == 1)
											<tr>
												<td>@php echo Str::of($tm->name)->limit(14); @endphp</td>
												<td>@if($tm->comp_type_id && $tm->comp_subtype_id) {{$tm->comptype->description}}  @else -- @endif</td>
												<td>@if($tm->start_datetime != NULL) {{ date('d-M-y', strtotime($tm->start_datetime))}} @else @endif </td>
												<td>@if($tm->location) @php echo Str::of($tm->location)->limit(10); @endphp @else -- @endif</td>
												<td>
													<a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a>
													@if($tm->user_id == Auth::user()->id)
														@if($tm->comp_start != 1)
														<a class="btn" href="{{ url('block_competition', $tm->id)}}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
														@else
														@endif
													@else
													@endif
												</td>
											</tr>
											<?php $i++; ?>
											@else
											@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
			@endif
			@if($my_draft_comp->isNotEmpty())
            <div class="col-md-6">
				<br/>
				<h1 class="Poppins-Fs30"> Draft Competition <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
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
									<?php $d = 1; ?>
									@foreach($my_draft_comp as $tm)
										<tr>
											<td>{{$tm->name}}</td>
											<td></td>
											<td></td>
											<td></td>
											<td>
												<a class="btn btn-success btn-xs-nb" href="{{ URL::to('draft_competition/' . $tm->id) }}" target="_blank">View</a>
												<a class="btn" href="{{ url('block_comp', $tm->id)}}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td>
										</tr>
										<?php $d++; ?>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			@endif
			@if($all_comp->isNotEmpty())
			<br/>
			<div class="row">
				<div class="col-md-6 col-8">
					<h1 class="Poppins-Fs30">Competition I Followed</h1>
				</div>
			</div>
			<div class="responsive-tabsOnMObile responsive-tabsOnMObileNew">
				<ul class="  nav nav-tabs responsive-tabs " id="myTab" role="tablist">
					<li class="nav-item Round-Tab active">
						<a class="nav-link nav-link-padding active" id="comp-tab" data-toggle="tab"
							href="#comp" role="tab" aria-controls="comp" aria-selected="true"> Competition
							<p class="currentRounded"></p>
						</a>
					</li>
					<li class="nav-item Round-Tab">
						<a class="nav-link nav-link-paddingUnactive" id="team-tab" data-toggle="tab"
							href="#team" role="tab" aria-controls="team" aria-selected="false"> Team
							<p class="currentRounded"></p>
						</a>
					</li>
					<li class="nav-item Round-Tab">
						<a class="nav-link nav-link-paddingUnactive" id="player-tab" data-toggle="tab"
							href="#player" role="tab" aria-controls="player" aria-selected="false"> Player
							<p class="currentRounded"></p>
						</a>
					</li>
					<i class="fa fa-caret-up"></i>
					<i class="fa fa-caret-down"></i>
				</ul>
			</div>
			<div class="tab-content mb-4 p-0" id="myTabContent">
				<div class="tab-pane fade show active" id="comp" role="tabpanel" aria-labelledby="comp-tab">
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-comp" role="tabpanel"
							aria-labelledby="nav-comp-tab">
							<!-- Table K.O Data Fixture -->
							@if($comp_follow->IsNotempty())
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
												@foreach($comp_follow as $tm)
													@if($tm->is_active == 1)
													<tr>
														<td>{{$tm->name}}</td>
														<td>@if($tm->comp_type_id && $tm->comp_subtype_id) {{$tm->comptype->description}}  @else -- @endif</td>
														<td>@if($tm->start_datetime) {{$tm->start_datetime}} @else -- @endif</td>
														<td>@if($tm->location) {{$tm->location}} @else -- @endif</td>
														@if($tm->comp_type_id == 1)
															<?php $team_request_status = App\Models\Competition_team_request::where('competition_id',$tm->id)->get();
																$request_status = array();
																foreach($team_request_status as $tm_request)
																{
																	$request_status[] = $tm_request->request_status;
																}
																$status = implode('and',$request_status)
																?> <td><a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a></td>

														@else
															<td><a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a></td>
														@endif
													</tr>
													@else
													@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							@else
								No Data Found!!
							@endif
							<!-- End K.O Data Fixture -->
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
					@if($team_follow->IsNotempty())
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
										@foreach($team_follow as $tm)
										@if($tm->is_active == 1)
										<tr>
											<td>{{$tm->name}}</td>
											<td>@if($tm->comp_type_id && $tm->comp_subtype_id) {{$tm->comptype->description}}  @else -- @endif</td>
											<td>@if($tm->start_datetime) {{$tm->start_datetime}} @else -- @endif</td>
											<td>@if($tm->location) {{$tm->location}} @else -- @endif</td>
											@if($tm->comp_type_id == 1)
												<?php $team_request_status = App\Models\Competition_team_request::where('competition_id',$tm->id)->get();
													$request_status = array();
													foreach($team_request_status as $tm_request)
													{
														$request_status[] = $tm_request->request_status;
													}
													$status = implode('and',$request_status)
													?> <td><a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a></td>

											@else
												<td><a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a></td>
											@endif
										</tr>
										@else
										@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					@else
						No Data Found!!
					@endif
				</div>
				<div class="tab-pane fade" id="player" role="tabpanel" aria-labelledby="player-tab">
					@if($player_follow->IsNotempty())
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
										@foreach($player_follow as $tm)
										@if($tm->is_active == 1)
										<tr>
											<td>{{$tm->name}}</td>
											<td>@if($tm->comp_type_id && $tm->comp_subtype_id) {{$tm->comptype->description}}  @else -- @endif</td>
											<td>@if($tm->start_datetime) {{$tm->start_datetime}} @else -- @endif</td>
											<td>@if($tm->location) {{$tm->location}} @else -- @endif</td>
											@if($tm->comp_type_id == 1)
												<?php $team_request_status = App\Models\Competition_team_request::where('competition_id',$tm->id)->get();
													$request_status = array();
													foreach($team_request_status as $tm_request)
													{
														$request_status[] = $tm_request->request_status;
													}
													$status = implode('and',$request_status)
													?> <td><a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a></td>

											@else
												<td><a class="btn btn-success btn-xs-nb" href="{{ URL::to('competition/' . $tm->id) }}" target="_blank">View</a></td>
											@endif
										</tr>
										@else
										@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					@else
						No Data Found!!
					@endif
				</div>
			</div>

			@endif


			@stack('scripts')
			<div class="col-md-6">
				<span id="player"></span>
			</div>
		</div>
	</div>
</main>

@include('frontend.includes.footer')
<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{url('frontend/js/script.js')}}"></script>
	<script src="{{url('frontend/js/main.js')}}"></script>
<script>
	$(document).on('click','#selectplayer',function(){
		var comp = $('#comp_req_id').val();
		var squad_player_length = 0;
		var players = [];
		$("input:checkbox[name='attendee_id']:checked").each(function(){
			players.push($(this).val());
			squad_player_length++;
		});

		selected_players = players.join(",");
		// alert("selected players are: "+ selected_players);
		// alert(i);
		if(selected_players)
		{
			$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				 	url:"{{url('selected_players')}}",
        			type:'post',
        			data:{comp:comp,selected_players:selected_players,squad_player_length:squad_player_length},
       			 error:function(){
            		alert('Something is Wrong');
        		},
				success:function(response)
				{
					if(response.squad)
					{
						alert('please select ' + response.squad + ' number of squad players');
					}
					if(response.competition_id)
					{
						
					}
				}
			   });
		}
		else
		{
			alert('Select players');
		}


	});
</script>
<script type="text/javascript">
        $('.responsive-tabs i.fa').click(function () {
            $(this).parent().toggleClass('open');
        });

        $('.responsive-tabs > li a').click(function () {
            $('.responsive-tabs > li').removeClass('active');
            $(this).parent().addClass('active');
            $('.responsive-tabs').toggleClass('open');
        });
    </script>
@include('frontend.includes.searchScript')
