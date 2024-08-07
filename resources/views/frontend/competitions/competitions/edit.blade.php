@include('frontend.includes.header')
<div class="header-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span>Edit a <strong>Competition</strong></h1>
			</div>
		</div>
	</div>
</div>
	

<main id="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-6 pe-0 ">
				   @if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						<br />
					@endif

				<form method="post" id="edit_comp" action="{{ route('competition.update', $competition->id) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="PUT">
					<input type="hidden" class="grey-form-control input-sm" value="{{$competition->id}}" id="competition_id" >
					<input type="hidden" class="grey-form-control input-sm" value="{{$competition->sport_id}}" id="sport_id" >
					<div class="competition-list mb-3">
						<h3>{{$competition->sport->name}}</h3>
					</div>
					<div class="soccer-form-data pe-2 selectt" id="soccer-form">
						<!-- One "tab" for each step in the form: -->
						<div class="tab">
							<div class="row mb-3">
								<div class="col-md-6">
								   <label class="visually-hidden" for="league_name">Korean Premier Leauge</label>
								   <input type="text" class="grey-form-control input-sm" placeholder="Competition Name" id="competition_name" name="name" value="{{$competition->name}}"> 
								</div>
								   <!-- <div class=" col-md-6">
								   <label class="visually-hidden" for="browse_image">Drag and Drop or Browse</label><input type="file" class="grey-form-control browse-control input-sm" placeholder="Drag and Drop or Browse" id="comp_logo" name="comp_logo">
								   </div> -->
								<div class=" col-md-6">
									<div class="input-group ">	
										<input type="text" class="form-control grey-bg input-sm" placeholder="South Corea" id="location" name="location" value="{{$competition->location}}">
										<span class="input-group-text apicon"><i class="icon-map-marker"></i></span>		
									</div>
								</div>
							</div>
							<div class="row mb-3">
								<div class=" col-md-6">
								   <?php 
									$start_date = date ('Y-m-d\TH:i:s', strtotime($competition->start_datetime));
								   ?>
									<div class="input-group">			
										<input type="datetime-local" class="grey-form-control input-sm" placeholder="Start date" id="start_date" name="start_datetime" value="<?php echo $start_date?>">  							
									</div>
								</div>
								<div class=" col-md-6"> 
									<?php 
										$end_date = date ('Y-m-d\TH:i:s', strtotime($competition->end_datetime));
									   ?>
									<label class="visually-hidden" for="c_date">End Date</label>
									<input type="datetime-local" class="grey-form-control input-sm" placeholder="End date" id="end_date" name="end_datetime" value="<?php echo $end_date ?>">  
								</div>
							</div>
							<div class="row mb-3">
								<div class=" col-md-12">
									<textarea class="form-control grey-form-control" id="" cols="30" rows="5" placeholder="Description" id="description" name="description">{{$competition->description}}</textarea>
								</div>
							</div>
							<div class="row mb-3">
								<div class=" col-sm-6 col-xs-6">
									<select class="grey-form-control input-sm" name="report_type" id="basic_report">
										<!-- <option value=""> ------ Select Report Type -----</option> -->
										<option value="1" {{$competition->report_type == 1 ? 'selected' : '' }}>Basic Report</option>
										<option value="2" {{$competition->report_type == 2 ? 'selected' : '' }}>Detailed Report</option>
									</select>
								</div>
								<div class=" col-sm-6 col-xs-6">
									<select class="grey-form-control input-sm" name="vote_mins" id="votemin">
										<!-- <option value="">------ Select Voting Mins -----</option> -->
										<option value="5" {{$competition->vote_mins == 5 ? 'selected' : '' }}>5</option>
										<option value="10" {{$competition->vote_mins == 10 ? 'selected' : '' }}>10</option>
										<option value="15" {{$competition->vote_mins == 15 ? 'selected' : '' }}>15</option>
										<option value="20" {{$competition->vote_mins == 20 ? 'selected' : '' }}>20</option>
									</select>
								</div>
							</div>
							<div class="row mb-3">
								<div class=" col-md-6">
									<label class="visually-hidden"for="adm_Pos1">Admin Position</label>
									<select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="member_id" id="adm_Pos">
										<option value="">Select Admin Position</option>
										@foreach($comp_admin as $cm)
										<option value="{{$cm->id}}">{{$cm->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6 multi-button d-flex" >
									<div class="col-10">
										<label for="admnstrtr" class="form-label select-label visually-hidden" >Invite Administrators to the team</label>
										<select class="grey-form-control typeahead_comp_member" name="admnstrtr[]"  multiple="multiple" id="admnstrtr"></select>
									</div>
									<div class="col-2">
										<button type="button" class="btn btn-default float-end btn-round-submit" id="add_adminPosition"><i class="icon-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-12">
								<label for="key_ranking"><span class="TopPlayer"> Team</span><span class="mechanism"> Ranking mechanism:</span></label>
							</div>
							<div class=" col-md-4 text-right">
								<span class="round"></span>
								<select class="form-control form-select-fancy-1" aria-label="form-select-lg example" name="team_ranking_main" id="team_main">
									@if($team_ranking_main)
										<option value="">Select Main</option>
										@foreach($team_stat as $stat)
										<option value="{{$stat->id}}" {{$team_ranking_main->stat_id == $stat->id ? 'selected' : '' }}>{{$stat->name}}</option>
										@endforeach
									@else
										<option value="" selected hidden>Select Main</option>
										@foreach($team_stat as $stat)
										<option value="{{$stat->id}}">{{$stat->name}}</option>
										@endforeach
									@endif
								</select>										
							</div>
							<div class=" col-md-4 text-right">
								<span class="round"></span>
								<select class="form-control form-select-fancy-1" aria-label="form-select-lg example" name="team_ranking_second" id="team_second_rank">
									@if($team_ranking_main)
										<option value="">Select 1st Tie Breaker</option>
										@foreach($team_stat as $stat)
										<option value="{{$stat->id}}" {{$team_ranking_second->stat_id == $stat->id ? 'selected' : '' }}>{{$stat->name}}</option>
										@endforeach
									@else
										<option value="" selected hidden>Select 1st Tie Breaker</option>
										@foreach($team_stat as $stat)
										<option value="{{$stat->id}}">{{$stat->name}}</option>
										@endforeach
									@endif
								</select>
							</div>
							<div class=" col-md-4 text-right">
								<span class="round"></span>
								<select class="form-control form-select-fancy-1" aria-label="form-select-lg example" name="team_ranking_third" id="team_third_rank">
									@if($team_ranking_main)
										<option value="">Select 2nd Tie Breaker</option>
										@foreach($team_stat as $stat)
										<option value="{{$stat->id}}" {{$team_ranking_third->stat_id == $stat->id ? 'selected' : '' }}>{{$stat->name}}</option>
										@endforeach
									@else
										<option value="" selected hidden>Select 2nd Tie Breaker</option>
										@foreach($team_stat as $stat)
										<option value="{{$stat->id}}">{{$stat->name}}</option>
										@endforeach
									@endif
								</select>										
							</div>
						</div>
						<div class="row mb-3"  id="invite_team">
							
						</div>
						<span id="result"></span>
						<button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel"   onclick="nextPrev(-1)">Pervious</button>
						<button type="button" id="nextBtn" class="btn col-5 btn-submit float-md-end nextBtn" onclick="nextPrev(1)">Save</button>
						<!-- <button class="btn btn-submit float-md-end" id="save_comp">Save & Invite Teams</button>  -->
					</div>
				</form> 
			</div>
			<div class="col-lg-5 col-md-6 ps-0 pe-0">
				<div class="show-content">
					<div class="show-content-header">
						<div class="d-flex align-items-center ">
							<div class="game-logo">
								<img src="{{url('frontend/logo')}}/{{$competition->comp_logo}}" alt="SportVote Logo" class="rounded-circle bg-white p-2" id="logo" style="max-height: 110px;">						
							</div>
							<div class="ms-auto text-end">
								<h2 class="header-name" id="comp_title">{{$competition->name}}</h2>
								<h5><span class="header_game" id="gametitle">{{$competition->sport->name}}</span></h5>
							</div>
						</div>
					</div>
					<div class="competition-detail pt-2">
						<h5>Competition <span id="comp_name">@if($competition->comp_type_id) {{$competition->comptype->name}} @else -- @endif</span></h5>
						<p>with <span id="num_team"> @if($competition->team_number) {{$competition->team_number}} @else 0 @endif teams </span>having <span id="num_squad">@if($competition->squad_players_num) {{$competition->squad_players_num}} @else 0 @endif players </span> each with <span id="num_lin"> @if($competition->lineup_players_num) {{$competition->lineup_players_num}} @else 0 @endif players </span>in starting linup</p>
					</div>
					<div class="report-deatil ">
						<span class="report" id="report_name">Report: Basic</span>
						<span class="voting-time" id="voting_min">Voting time: 5 mins</span>
						<div class="clearfix"></div>
						<p>
						A premier competition in the region wen you work or browse at home.
						You can use Chrome remote desktop, translate webpages, and switch
						between user profiles. Here are some resources to help you You can
						make the most of Chrome when you work or browse at home.</p>

						<p>You can use Chrome remote desktop, translate webpages, and switch
						between user profiles. 
						</p>
					</div>	

						@livewire('competition-members', ['comp_id' => $competition->id])
						@livewireScripts
						<!-- <div class="team-deatil row">
							<div class="col">
							<span class="badge n_plyr badge-round-pink"></span>

								<h5>Competition members</h5>
								<ul class="admin-list" id="admin_list">
									 
									  
								</ul>
							</div>
							
						</div>				 -->
				</div>
			</div>
		</div>
	</div>
</main>
    @include('frontend.includes.footer')

<script src="{{url('frontend/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{url('frontend/js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{url('frontend/js/jquery-ui.js')}}"></script>
<script src="{{url('frontend/js/popper.min.js')}}"></script>

<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{url('frontend/js/jquery.easing.1.3.js')}}"></script>
<script src="{{url('frontend/js/aos.js')}}"></script>
<script src="{{url('frontend/js/script.js')}}"></script>

<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{url('frontend/js/main.js')}}"></script>
<script> 

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
    
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Save";
  } else {
    document.getElementById("nextBtn").innerHTML = "next";
  }
   //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("edit_comp").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
<script type="text/javascript" src="{{url('frontend/assets/js/bootstrap-multiselect.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {

		$('#example-getting-started3').multiselect({
		buttonWidth: '100%',
		});

		$('#example-getting-started').multiselect({
		buttonWidth: '100%',
		});

    });
</script>

<script>
	  $(document).on('keyup','#competition_name', function(){
		var comptitle = $('#competition_name').val();
		$('#comp_title').html(comptitle);
	  });
</script>

<script>
	$(document).on('change','#basic_report',function(){
		var reportname = $('select[name="report_type"] option:selected').val();
		if(reportname == 1)
		{
				$('#report_name').html("Report: Basic");
		}
		if(reportname == 2)
		{
			$('#report_name').html("Report: Detailed");
		}
	});
</script>

<script>
	$(document).on('change','#votemin', function(){
		var mins = $('select[name="vote_mins"] option:selected').val();
		$('#voting_min').html("Voting time: "+ mins + " mins");
	});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.typeahead_comp_member').select2({
        placeholder: 'Select Players',
        ajax: {
            url: "{{ url('autosearch_player_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
           

            cache: true
        }
    });
</script>

<script type="text/javascript">
    $('.typeahead_request_team').select2({
        placeholder: 'Select Players',
        ajax: {
            url: "{{ url('autosearch_team') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
           

            cache: true
        }
    });
</script>


<script>
	$(document).on('click','#add_adminPosition',function(){

		var sport_id = $('#sport_id').val();
		var competition_id = $('#competition_id').val();
		var memberpositionid = $('select[name="member_id"] option:selected').val();
		var memberid = $('#admnstrtr').val();
        // alert(comp_member_id);
			if(sport_id && competition_id)
			{
				
				$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('competition_members')}}",
        			type:'post',
        			data:{sport_id:sport_id,memberid:memberid,memberpositionid:memberpositionid,competition_id:competition_id},
       			 	error:function(){
            		// alert('Something is Wrong');
					
        		},
				success:function(response)
				{
					$('#admnstrtr').empty();
                    if(response == 0)
                    {
                        alert('The Player is already selected');
                    }	
						  
				}

			   });
			}	
	});
</script>

<script>
	$(document).on('change','#team_main', function(){
		var team_rank_id = $(this).val();
		// alert(team_rank_id);
		var team_2nd_rank = $('#team_second_rank').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("team_rank_determine")}}',
			type:'post',
			data:{team_rank_id:team_rank_id,team_2nd_rank:team_2nd_rank},
			error:function(){

			},
			success:function(response)
			{
				html = '<option value="">1st Tie Breaker</option> '
				html1 = '<option value="">2nd Tie Breaker</option> '
					$.each(response,function(key, asc){
						html += '<option value="'+asc.id+'">'+asc.name+'</option>' ;
						html1 += '<option value="'+asc.id+'">'+asc.name+'</option>' ;     
					}); 
					$('#team_second_rank').html(html);
					$('#team_third_rank').html(html1);
			}
		});
	});
</script>

<script>
	$(document).on('change','#team_second_rank', function(){
		var team_rank_id = $(this).val();
		// alert(team_rank_id);
		var team_2nd_rank = $('#team_main').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("team_rank_determine")}}',
			type:'post',
			data:{team_rank_id:team_rank_id,team_2nd_rank:team_2nd_rank},
			error:function(){

			},
			success:function(response)
			{
				html = '<option value="">2nd Tie Breaker</option> '
					$.each(response,function(key, asc){
						html += '<option value="'+asc.id+'">'+asc.name+'</option>'       
					}); 
					$('#team_third_rank').html(html);
			}
		});
	});
</script>
<!-- <script>
	$(document).on('click','#send_request',function(){
		var competition_id = $('#competition_id').val();
		var team_id = $('#request_team').val();
		$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('send_comp_invitation1')}}",
        			type:'post',
        			data:{competition_id:competition_id,team_id:team_id},
       			 	error:function(){
            		// alert('Something is Wrong');
					
        		},
				success:function(response)
				{
					// $('#admnstrtr').empty();
                    // if(response == 0)
                    // {
                    //     alert('The Player is already selected');
                    // }	
						  
				}

			   });
	});
</script> -->