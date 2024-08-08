@include('frontend.includes.header')
<div class="header-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span>Edit a <strong> New Team</strong></h1>
				</div>
			</div>
		</div>
	</div>


<main id="main">
	<div class="container">
        <div class="row">
           <div class="col-lg-7 col-md-6 pe-0">
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
		   <form method="post" id="edit_team" action="{{ route('my_team.update', $team->id) }}" enctype="multipart/form-data">
           @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="user_id" value="{{$team->user_id}}">
				<div class="competition-list mb-3">
					<ul class="games-list">
						<li class="item"><input type="radio" name="sport_id" value="1" checked id="soccer" onclick="divshowhide()"><label for="competition"><span> Soccer </span><i class="icon-check checked-badge"></i></label></li>
						<li class="item"><input type="radio" name="sport_id" value="Basketball" id="Basketball" onclick="divshowhide()"><label for="competition"><span> Basketball </span><i class="icon-check checked-badge"></i></label></li>
						<li class="item"><input type="radio" name="sport_id" value="Cricket" id="Cricket" onclick="divshowhide()" ><label for="competition"><span> Cricket </span><i class="icon-check checked-badge"></i></label></li>
						<li class="item"><input type="radio" name="sport_id" value="Volleyball" id="Volleyball" onclick="divshowhide()"><label for="competition"><span> Volleyball </span><i class="icon-check checked-badge"></i></label></li>
						<li class="item"><input type="radio" name="sport_id" value="Rugby" id="Rugby" onclick="divshowhide()"><label for="competition"><span> Rugby </span><i class="icon-check checked-badge"></i></label></li>
						<li class="item"><input type="radio" name="sport_id" value="Hockey" id="Hockey" onclick="divshowhide()"><label for="competition"><span> Hockey </span><i class="icon-check checked-badge"></i></label></li>
					</ul>
				</div>
				<div class="soccer-form-data pe-2 selectt" id="soccer-form">
					<div class="tab">
						<div class="row mb-3">
							<div class=" col-md-6">
								<label class="visually-hidden" for="team_m_name">Team Name</label><input type="text" class="grey-form-control input-sm" placeholder="Team Name" id="team_name" name="name" value="{{$team->name}}" autocomplete="off"> </div>
							<div class=" col-lg-6">
								<div class="input-group">							
									<input type="text" class="grey-form-control input-sm" placeholder="Montreal, QC Canada" id="location" name="location" value="{{$team->location}}" style="width: 86%;">
									<span class="input-group-text apicon"><i class="icon-map-marker"></i></span>
								</div>
							</div> 
						</div>
				   <div class="row mb-3">
						<div class=" col-md-6">
							<label class="visually-hidden" for="team_m_name">Home Ground</label><input type="text" class="grey-form-control input-sm" placeholder="Home Ground Name" id="home_ground" name="homeGround" value="{{$team->homeGround}}">
						</div>
						<div class=" col-lg-6">
							<div class="input-group">							
								<input type="text" class="grey-form-control input-sm" placeholder="Home Ground Location" id="homeGround_location" name="homeGround_location" value="{{$team->homeGround_location}}" style="width: 86%;">
								<span class="input-group-text apicon"><i class="icon-map-marker"></i></span>
							</div>
						</div> 
                   </div>
				    <div class="row mb-3">
						<div class=" col-md-6">
						   <label class="visually-hidden" for="browse_image">Drag and Drop or Browse</label>
							<span class="Copmetition-Placeholder" id="team_logo_name">{{$team->team_logo}}</span>
							<input type="file" class="grey-form-control browse-control input-sm" name="team_logo" id="team_logo" style="color: rgba(0, 0, 0, 0);"> 
							<span id="team_logo_error" class="sv_error"></span>
						</div>
						<div class=" col-md-6">
						   <label class="visually-hidden" for="browse_image">Team Color</label>
						   <input id="color" type="color" class="grey-form-control input-sm" value="{{$team->team_color}}" name="team_color"/>
						</div>
					</div>
					<div class="row mb-3">
                        <div class=" col-lg-12">
                            <label class="visually-hidden" for="description">Description</label><textarea rows="5" class="grey-form-textarea  input-sm" placeholder="Team Description" id="description" name="description">{{$team->description}}</textarea>
                        </div>
                    </div>

					<input type="hidden" value="{{$team->id}}" id="team_id" name="team_id">
					<div class="row mb-3">
						<div class=" col-md-4">
							<label class="visually-hidden"for="adm_Pos1">Admin Position</label>
								<select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="member_id" id="adm_Pos">
									<option value="">Select Admin Position</option>
									@foreach($admin_position as $mp)
									<option value="{{$mp->id}}" style="text-transform: capitalize;">{{$mp->name}}</option> 
									@endforeach
								</select>
						</div>
					   <div class="col-md-8 multi-button d-flex" >
							<div class="col-10">
								<label for="admnstrtr" class="form-label select-label visually-hidden" >Invite Administrators to the team</label>
								<select class="typeahead grey-form-control" name="admnstrtr[]"  multiple="multiple" id="admin_user"></select>
							</div>
							<div class="col-2">
								<button type="button" class="btn btn-default float-end btn-round-submit" id="add_adminPosition"><i class="icon-plus"></i></button>
							</div>
						</div>
					</div>
					<div class="row mb-3" >
						<div class=" col-md-4">
							<label class="visually-hidden"for="adm_Pos">Player Position</label>
								<select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="player" id="player_Pos">
								<option value="">Select Player Position</option>
									@foreach($player_position as $mp)
									<option value="{{$mp->id}}">{{$mp->name}}</option> 
									@endforeach
								</select>
                       </div>
					   <div class="col-md-8 multi-button d-flex" >
					   		<div class="col-10">
								<label for="plyr" class="form-label select-label visually-hidden" >Invite Player to the team</label>
								<select class="typeahead_player grey-form-control" name="plyr[]"  multiple="multiple" id="plyr_list"></select>
							</div>
							<div class="col-2">
								<button type="button" class="btn btn-default float-end btn-round-submit" id="add_payerposition"><i class="icon-plus"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="tab">	
					<div class="row mb-3">
						<div class="col-md-6  multi-button">
							<label for="player" class="form-label select-label ">Who can send you Request for join a team</label>
								<select class="select  grey-form-control " multiple id="example-getting-started2" name="accept_player_invite[]">	
								@foreach($sport_level as $spl)
								    <option value="{{$spl->id}}"  @if ($team->accept_player_invite != "")
                                     @foreach(explode(',', $team->accept_player_invite) as $player_level) {{$player_level == $spl->id ? 'selected' : '' }} @endforeach
                                    @endif>{{$spl->name}} Level Player</option> 
								
                                @endforeach
								</select>
                        </div>
                        <div class="col-md-6 multi-button">
							<label for="player" class="form-label select-label">Who can send you Request for join a competition</label>
								<select class="select  grey-form-control " multiple id="example-getting-started3" name="accept_comp_invite[]">	
								@foreach($sport_level as $spl)
								<option value="{{$spl->id}}" @if ($team->accept_comp_invite != "")
                                     @foreach(explode(',', $team->accept_comp_invite) as $player_level) {{$player_level == $spl->id ? 'selected' : '' }} @endforeach
                                    @endif>{{$spl->name}} Level Competition</option> 
								@endforeach
								</select>
						</div>	
                    </div>
					<div class="row mb-3">
                        <div class="col-md-6  multi-button">
							<!-- <label for="player" class="form-label select-label ">In Which Level Your team Play</label> -->
							<select class="select  grey-form-control " name="sport_level_id">	
								<option value="" selected hidden> Team Level</option>
								@foreach($sport_level as $spl)
								<option value="{{$spl->id}}" {{$team->sport_level_id == $spl->id ? 'selected' : '' }}>{{$spl->name}} Level Team</option> 
								@endforeach
							</select>
                        </div>
                        <div class="col-md-6 multi-button">
							@if($team->sport_levels_proof)<label for="player" class="form-label select-label">Level proof</label></br> <img src ="{{url('frontend/level_proof')}}/{{$team->sport_levels_proof}}" height="150"> @else 
							<!-- <label for="player" class="form-label select-label">Upload level proof</label>  -->
							<input type="file" class="grey-form-control browse-control input-sm" placeholder="Drag and Drop or Browse" id="proof" name="sport_levels_proof">@endif
						</div>		
                    </div>
					<div class="row mb-3">
                        	<div class="col-md-12">
								
                        	</div>	
                    </div>

						<div class="row mb-3">
							<div class="col-md-12">
								<label for="key_ranking">
								<span class="TopPlayer"> Team</span><span class="mechanism"> Ranking mechanism:</span></label>
							</div>
                        	<div class="col-md-4 ">
								<select class="select grey-form-control ranking" name="stat_id[]" id="player_main">
									<option value="" selected hidden>Main</option>
									@foreach($sport_stat as $spt)
                                    <?php $stat = App\Models\StatDecisionMaker::where('decision_stat_for',1)->where('type_id',$team->id)->where('stat_order',1)->first()?> 
									
                                    <option value="{{$spt->id}}" @if(!empty($stat)) {{$stat->stat_id == $spt->id ? 'selected' : '' }} @else @endif>{{$spt->name}}</option> 
									@endforeach
								</select>
                        	</div>	
							<div class="col-md-4">
							<select class="select grey-form-control ranking" name="stat_id[]" id="player_second_rank">
									<option value="" selected hidden>1st Tie Breaker</option>
									@foreach($sport_stat as $spt)
									<?php $stat = App\Models\StatDecisionMaker::where('decision_stat_for',1)->where('type_id',$team->id)->where('stat_order',2)->first()?> 
									
                                    <option value="{{$spt->id}}" @if(!empty($stat)) {{$stat->stat_id == $spt->id ? 'selected' : '' }} @else @endif>{{$spt->name}}</option> 
									@endforeach
								</select>
                        	</div>
							<div class="col-md-4">
							<select class="select grey-form-control ranking" name="stat_id[]" id="player_third_rank">
									<option value="" selected hidden>2nd Tie Breaker</option>
									@foreach($sport_stat as $spt)
									<?php $stat = App\Models\StatDecisionMaker::where('decision_stat_for',1)->where('type_id',$team->id)->where('stat_order',3)->first()?> 
									
                                    <option value="{{$spt->id}}" @if(!empty($stat)) {{$stat->stat_id == $spt->id ? 'selected' : '' }} @else @endif>{{$spt->name}}</option> 
									@endforeach
								</select>
                        	</div>
                        </div>
                    
					</div>
						<div class="d-grid gap-2 d-md-block mt-3">
						<!-- <button type="submit" id="submit_form" class="btn  btn-submit float-md-end" >Save</button>	 -->
						<button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel"   onclick="nextPrev(-1)">Pervious</button>
						<button type="button" id="nextBtn" class="btn col-5 btn-submit float-md-end" onclick="nextPrev(1)">Save</button>
						</div>
					</div>
				  </form>
			</div>
			
		  
		   <div class="col-lg-5 col-md-6 ps-0 pe-0">
			<div class="show-content">
				<div class="show-content-header">
					 <div class="d-flex align-items-center ">
					  <div class="game-logo">
						 <img src="{{url('frontend/logo')}}/{{$team->team_logo}}" alt="SportVote Logo" class="rounded-circle bg-white p-2" id="logo" style="max-height: 110px;">						
					  </div>
						<div class="ms-auto text-end">
						<h2 class="header-name team_name" id="teamname">{{$team->name}}</h2>
						<h5><span class="header_game" id="game_title">Soccer</span><span id="locationname"> in {{$team->location}}</span></h5>
						
						</div>
						
					</div>
					
				</div>
             
                @livewire('team-members', ['team_id' => $team->id])
                @livewireScripts

					<!-- <div class="team-deatil row">
						<div class="col">
						<span class="badge n_plyr badge-round-pink"></span>

							<h5>Administered By</h5>
							<ul class="admin-list" id="admin_list">
								 
								  
							</ul>
						</div>
						<div class="col"><h5>
							<span class="badge n_plyr badge-round-pink"></span>
							Players</h5>
							<ul class="player-list" id="player_list">
							</ul>
						</div>
					</div>		 -->
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
    document.getElementById("edit_team").submit();
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
		$('#admin').hide();
		$('#players').hide();
        $('#example-getting-started').multiselect({
		
		buttonWidth: '100%'});
		
		$('#example-getting-started1').multiselect({
		
		buttonWidth: '100%'});
		$('#example-getting-started2').multiselect({
		
		buttonWidth: '100%',
		nonSelectedText: 'Select Player Level',});

		$('#example-getting-started3').multiselect({
		
		buttonWidth: '100%',
		nonSelectedText: 'Select competition Level',});
		$('#example-getting-started4').multiselect({
		
		buttonWidth: '100%',
		nonSelectedText: 'Select competition Level',});
		$('#example-getting-started5').multiselect({
		
		buttonWidth: '100%',
		nonSelectedText: 'Select competition Level',});
    });
</script>
<script>
$(document).ready(function(){
	$("#soccer").prop("checked", true);

$(document).on('click','#Hockey',function(){
	alert('Coming Soon.....');
	$("#soccer").prop("checked", true);

});
});
</script>

<script>
$(document).ready(function(){
$(document).on('click','#Rugby',function(){
	alert('Coming Soon.....');
	$("#soccer").prop("checked", true);
});
});
</script>

<script>
	$(document).on('keyup','#team_name',function(){
		var teamname = $('#team_name').val();
		$('#teamname').html(teamname);
	});
</script>

<script>
	$(document).on('keyup','#location',function(){
			var locationanme = $('#location').val();
			$('#locationname').html(locationanme);
	});
</script>


<script>
$(document).ready(function(){
$(document).on('click','#Volleyball',function(){
	alert('Coming Soon.....');
	$("#soccer").prop("checked", true);
});
});
</script>

<script>
$(document).ready(function(){
$(document).on('click','#Cricket',function(){
	alert('Coming Soon.....');
	$("#soccer").prop("checked", true);
});
});
</script>

<script>
$(document).ready(function(){
$(document).on('click','#Basketball',function(){
	alert('Coming Soon.....');
	$("#soccer").prop("checked", true);
});
});
</script>

<script>
$('#team_logo').bind('change', function() {
  //this.files[0].size gets the size of your file.
  var file_size = this.files[0].size;
//   alert(file_size);
	if(file_size >= 200000)
	{
		$('#team_logo_error').html("Maximum File size is 2MB.");
		$("#team_logo").css("border-color","#FF0000");
	}
  else
  {
	  $('#team_logo_error').html("");
	  $("#team_logo").css("border-color","#c1c1c1");
	  let reader = new FileReader();
    reader.onload = (e) => { 
      $('#logo').attr('src', e.target.result); 
	//   $('#pic_name').html("");
    }
    reader.readAsDataURL(this.files[0]); 
   
  }
});
</script>


<script>
	$(document).on('change','#player_main', function(){
		var player_rank_id = $(this).val();
		// alert(player_rank_id);
		var player_2nd_rank = $('#player_second_rank').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("player_rank_determine")}}',
			type:'post',
			data:{player_rank_id:player_rank_id,player_2nd_rank:player_2nd_rank},
			error:function(){

			},
			success:function(response)
			{
				html = '<option value="" selected hidden>1st Tie Breaker</option> '
				html1 = '<option value="" selected hidden>2nd Tie Breaker</option> '
					$.each(response,function(key, asc){
						html += '<option value="'+asc.id+'">'+asc.name+'</option>' ;
						html1 += '<option value="'+asc.id+'">'+asc.name+'</option>' ;     
					}); 
					$('#player_second_rank').html(html);
					$('#player_third_rank').html(html1);
			}
		});
	});
</script>

<script>
	$(document).on('change','#player_second_rank', function(){
		var player_rank_id = $(this).val();
		// alert(player_rank_id);
		var player_2nd_rank = $('#player_main').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			url:'{{url("player_rank_determine")}}',
			type:'post',
			data:{player_rank_id:player_rank_id,player_2nd_rank:player_2nd_rank},
			error:function(){

			},
			success:function(response)
			{
				html = '<option value="" selected hidden>2nd Tie Breaker</option> '
					$.each(response,function(key, asc){
						html += '<option value="'+asc.id+'">'+asc.name+'</option>'       
					}); 
					$('#player_third_rank').html(html);
			}
		});
	});
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('.typeahead').select2({
        placeholder: 'Select Admin',
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
    $('.typeahead_player').select2({
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

<script>
    $(document).on('click','#add_adminPosition',function(){
            var memberid = $('#admin_user').val();
            var memberpositionid = $('select[name="member_id"] option:selected').val();
            var team_id = $('#team_id').val();
		    var userid = $('#user_id').val();
            var sport_id = $('input:radio[name="sport_id"]:checked').val();

            // alert(sport_id);
            if(sport_id && team_id)
			{
				
				$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('team_members')}}",
        			type:'post',
        			data:{sport_id:sport_id,memberid:memberid,memberpositionid:memberpositionid,team_id:team_id,userid:userid},
       			 	error:function(){
            		// alert('Something is Wrong');
					$("#example-getting-started").multiselect('clearSelection');
        		},
				success:function(response)
				{
					$('#admin_user').empty();
                    if(response == 0)
                    {
                        alert('The Player is already selected');
                    }	
						  
				}

			   });
			}	

    })
</script>


<script>
    $(document).on('click','#add_payerposition',function(){
            var memberid = $('#plyr_list').val();
            var memberpositionid = $('select[name="player"] option:selected').val();
            var team_id = $('#team_id').val();
		    var userid = $('#user_id').val();
            var sport_id = $('input:radio[name="sport_id"]:checked').val();

            // alert(sport_id);
            if(sport_id && team_id)
			{
				
				$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('team_members')}}",
        			type:'post',
        			data:{sport_id:sport_id,memberid:memberid,memberpositionid:memberpositionid,team_id:team_id,userid:userid},
       			 	error:function(){
            		// alert('Something is Wrong');
					$("#example-getting-started").multiselect('clearSelection');
        		},
				success:function(response)
				{
					$('#plyr_list').empty();
                    if(response == 0)
                    {
                        alert('The Player is already selected');
                    }						  
				}

			   });
			}	

    })
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQTGWbf8Xa1tCjD0M1WBpD6IDtOJj6KWQ&libraries=places"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var autocomplete;
		var id = 'location';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})

	});	
  $(document).on('click','#homeGround_location',function(){
    var autocomplete;
		var id = 'homeGround_location';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})
  });
</script> 

<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script> 
<script>
  $(document).on('click','#team_logo',function(){
    var team_name = $('#team_name').val();
    if(team_name != "")
    {
          $('#team_logo').ijaboCropTool({
        preview : '.image-previewer',
        setRatio:1,
        allowedExtensions: ['jpg', 'jpeg','png'],
        buttonsText:['CROP & SAVE','QUIT'],
        buttonsColor:['#30bf7d','#ee5155', -15],
        processUrl:'{{ route("team_logo_crop") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){
        //  alert(message);
          $('#logo').attr('src','{{url("frontend/logo")}}/'+message);
          $('#team_logo_name').html(message);
        },
        onError:function(message, element, status){
        alert(message);
        }
      });
    }
    else
    {
      
    }
});
</script>
