@include('frontend.includes.header')
<div class="header-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong>Competitions I Participate In</strong></h1>
			</div>
		</div>
	</div>
</div>
<main id="main">
	<div class="container">
		<div class="row">
			@if($user_participateComp_data->isNotEmpty())
			<div class="col-md-12">
				<div class="CompetitionListScroll">
					<div class="grid" id="ScrollRightBlue">
						<div class="grid-container AllCompetitions" id="ScrollRightBlue">
							<table>
								<thead>
									<tr class="header">
										<th style="width: 20%;">Competition Name<div>Competition Name</div>
										</th>
										<th style="width: 15%;">Type<div>Type</div>
										</th>
										<th style="width: 15%;">Start Date<div>Start Date</div>
										</th>
										<th style="width: 30%;">Location<div>Location</div>
										</th>
										<th style="width: 10%;">Action<div>Action</div>
										</th>
										<th style="width: 10%;">Status<div>Status</div>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0; ?>
									@foreach($user_participateComp_data as $cr)
									<?php $sport = App\Models\Sport::find($cr->sport_id);
									$competition_type = App\Models\competition_type::find($cr->comp_type_id);
									$i++; ?>
									<tr>
										<input type="hidden" id="comp_request_id" value="{{$cr->id}}">
										<td title="{{$cr->name}}">@php echo Str::of($cr->name)->limit(10); @endphp</td>
										@if($cr->comp_type_id != "")
											<td>{{$competition_type->description}}</td>
										@else
											<td></td>
										@endif
										<td>@if($cr->start_datetime != NULL) {{ date('d-M-y', strtotime($cr->start_datetime))}} @else @endif</td>
										<td>@php echo Str::of($cr->location)->limit(10); @endphp</td>
										<td>
											<a class="btn btn-success btn-xs-nb reject" href="{{ URL::to('competition/' . $cr->id) }}" target="_blank">VIEW</a>
										</td>
											@if($cr->comp_start == 1)
												<?php $compFixturecount = count($cr->comp_fixture);
												$finishfixture = array();
												foreach ($cr->comp_fixture as $fixtureData) {
													if($fixtureData->startdate_time != "" && $fixtureData->finishdate_time != ""){
														array_push($finishfixture, $fixtureData->id);
													}
												}
													?>
												@if($compFixturecount > count($finishfixture))
													<td><img class="iconSpacingLR" src="{{ url('frontend/images') }}/In-Progress.png" title="On Going" ></td>
												@else
													@if($compFixturecount == count($finishfixture))
													<td><img class="iconSpacingLR" src="{{ url('frontend/images') }}/Completed.png" title="Finished" ></td>
													@else
													@endif
												@endif
											@else
											<td><img class="iconSpacingLR" src="{{ url('frontend/images') }}/Not-Started.png" title="Not-Started" ></td>
											@endif
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
            @else

            <div class="col-md-12">
				<div class="CompetitionListScroll">
					<div class="grid">
						<div class="grid-container AllCompetitions" id="ScrollRightBlue">
							<table>
								<thead>
									<tr class="header">
										<th>Competition Name<div>Competition Name</div>
										</th>
										<th>Type<div>Type</div>
										</th>
										<th>Start Date<div>Start Date</div>
										</th>
										<th>Location<div>Location</div>
										</th>
										<th>Action<div>Action</div>
										</th>
									</tr>
								</thead>
								<tbody>

									<tr>

										<td colspan="5" class="text-center">
                                            {{'No Data Found!!'}}

										</td>
									</tr>


								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			@endif


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

<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
@include('frontend.includes.searchScript')
