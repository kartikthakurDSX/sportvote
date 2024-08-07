@include('frontend.includes.header')
<div class="header-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong>Competitions I Follow</strong></h1>
			</div>
		</div>
	</div>
</div>

<main id="main">
	<div class="container">
        <div class="row iFollow">
            @if($all_comp->isNotEmpty())
                  <!-- Table K.O Data Fixture -->
                @if($comp_follow->IsNotempty())
                <div class="col-md-12">
                    <div class="CompetitionListScroll ">
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
                                                <td>
                                                    @if($tm->comp_start == 1)
                                                        <?php $compFixturecount = count($tm->comp_fixture);
                                                        $finishfixture = array();
                                                        foreach ($tm->comp_fixture as $fixtureData) {
                                                            if($fixtureData->startdate_time != "" && $fixtureData->finishdate_time != ""){
                                                                array_push($finishfixture, $fixtureData->id);
                                                            }
                                                        }
                                                            ?>
                                                        @if($compFixturecount > count($finishfixture))
                                                            <img class="iconSpacingLR" src="{{ url('frontend/images') }}/In-Progress.png" title="On Going" >
                                                        @else
                                                            @if($compFixturecount == count($finishfixture))
                                                            <img class="iconSpacingLR" src="{{ url('frontend/images') }}/Completed.png" title="Finished" >
                                                            @else
                                                            @endif
                                                        @endif
                                                    @else
                                                    <img class="iconSpacingLR" src="{{ url('frontend/images') }}/Not-Started.png" title="Not-Started" >
                                                    @endif
                                                </td>
                                            </tr>
                                            @else
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="col-md-12">
				<div class="CompetitionListScroll ">
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
                <!-- End K.O Data Fixture -->
			@endif
        </div>
	</div>
</main>
@include('frontend.includes.footer')
@include('frontend.includes.searchScript')
<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{url('frontend/js/script.js')}}"></script>
	<script src="{{url('frontend/js/main.js')}}"></script>

    <script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
