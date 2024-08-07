@include('frontend.includes.header')
</div> <!-- div close of site wrap i.e. start on header page-->
    <div class="header-bottom">
		<style>
			.processed {
				display: none;
			}
		</style>
		
		<button id="triggerAll" class="RefreshButtonTop btn btn-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
            <path d="M15.8591 9.625H21.2662C21.5577 9.625 21.7169 9.96492 21.5303 10.1888L18.8267 13.4331C18.6893 13.598 18.436 13.598 18.2986 13.4331L15.595 10.1888C15.4084 9.96492 15.5676 9.625 15.8591 9.625Z" fill="white"/>
            <path d="M0.734056 12.375H6.14121C6.43266 12.375 6.59187 12.0351 6.40529 11.8112L3.70171 8.56689C3.56428 8.40198 3.31099 8.40198 3.17356 8.56689L0.469979 11.8112C0.283401 12.0351 0.442612 12.375 0.734056 12.375Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0001 4.125C8.86546 4.125 6.95841 5.09708 5.69633 6.62528C5.45455 6.91805 5.02121 6.95938 4.72845 6.7176C4.43569 6.47581 4.39436 6.04248 4.63614 5.74972C6.14823 3.91879 8.43799 2.75 11.0001 2.75C15.045 2.75 18.4087 5.66019 19.1141 9.50079C19.1217 9.54209 19.129 9.5835 19.136 9.625H17.7377C17.1011 6.48695 14.3258 4.125 11.0001 4.125ZM4.26252 12.375C4.89916 15.5131 7.67452 17.875 11.0001 17.875C13.1348 17.875 15.0419 16.9029 16.3039 15.3747C16.5457 15.082 16.9791 15.0406 17.2718 15.2824C17.5646 15.5242 17.6059 15.9575 17.3641 16.2503C15.852 18.0812 13.5623 19.25 11.0001 19.25C6.95529 19.25 3.59161 16.3398 2.88614 12.4992C2.87856 12.4579 2.87128 12.4165 2.86431 12.375H4.26252Z" fill="white"/>
        </svg>
    </button>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="FontStyle"><span class="icon-noun-s icon-noun-circle noun_TrophyTeam"></span> Create a
                        <strong class="NEWw">New Team</strong>
                    </h1>
                </div>
            </div>
        </div>
    </div>

 <main id="main" class="CreateTeam">
    <div class="container ScrollFix ">
		<div class="row">
			<div class="col-lg-7 col-md-6 pe-0 content ">
				<form class="" >
					<input type="hidden" value="" id="team_id">
					<div class="competition-list mb-3">
						<ul class="games-list owl-4-slider owl-carousel owl-loaded owl-drag">
							<li class="item"><input type="radio" name="sport_id" value="1" checked
									id="soccer" ><label for="competition"><span> Soccer
									</span><i class="icon-check checked-badge"></i></label></li>
							<li class="item"><input type="radio" name="sport_id" value="2"
									id="Basketball" class="coming_soon_sports" ><label for="competition"><span>
										Basketball </span><i class="icon-check checked-badge"></i></label></li>
							<li class="item "><input type="radio" name="sport_id" value="3" id="Cricket"
									class="coming_soon_sports" ><label for="competition"><span> Cricket </span><i
										class="icon-check checked-badge"></i></label></li>
							<li class="item "><input type="radio" name="sport_id" value="4"
									id="Volleyball" class="coming_soon_sports" ><label for="competition"><span>
										Volleyball </span><i class="icon-check checked-badge"></i></label></li>
							<li class="item "><input type="radio" name="sport_id" value="5" id="Rugby"
									class="coming_soon_sports"><label for="competition"><span> Rugby </span><i
										class="icon-check checked-badge"></i></label></li>
							<li class="item"><input type="radio" name="sport_id" value="6" id="Hockey"
									class="coming_soon_sports"><label for="competition"><span> Hockey </span><i
										class="icon-check checked-badge"></i></label></li>
						</ul>
					</div>
					<span class="text-danger" id="sports_error" style="display: none;">* Sports is required</span>
<br>
					<div class="soccer-form-data  pe-2 selectt" id="soccer-form">

						<!-- One "tab" for each step in the form: -->
						<div class="">
						   <!--  <p class="Step1-Comp mb-3"><span class="StepOne">Step 1:</span> Define Competition type
								&
								basic Details </p> -->
							<div class="row mb-3">
								<div class=" col-md-6 FlotingLabelUp">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="text" placeholder=" " value="" name="team_name" id="team_name">
											<span class="highlight"></span>
											<label>Team Name *</label>
										</div>
									</div>
									<span class="text-danger" id="team_name_error" style="display: none;">Team Name is required</span>
									<span class="text-danger" id="team_name_error2" style="display: none;">Team Name must not be greater than 30 characters.</span>
                                    @error('name')
										<span class="text-danger">{{ $message }}</span>
                                    @enderror
								</div>
								<div class=" col-md-6 FlotingLabelUp ">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="text" placeholder=" " value="" name="team_location" id="team_location" autocomplete="off">
											<span class="highlight"></span>

											<label>Location *</label>
											<span class="input-group-text apicon"><i
													class="icon-map-marker"></i></span>
										</div>
									</div>
									<span class="text-danger" id="team_location_error" style="display: none;">Location is required</span>
                                    @error('team_location')
										<span class="text-danger">{{ $message }}</span>
                                    @enderror
								</div>
							</div>
							<div class="row mb-3">
								<div class=" col-md-6 FlotingLabelUp">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="text" placeholder=" " value="" name="home_ground_name" id="homeground_name">
											<span class="highlight"></span>
											<label>Home Ground Name *</label>
										</div>
									</div>
									<span class="text-danger" id="homeground_name_error" style="display: none;">Home Ground Name is required</span>
								</div>
								<div class=" col-md-6 FlotingLabelUp ">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
											<input class="floating-input" type="text" placeholder=" " value="" id="homGround_location" name="homGround_location" autocomplete="off">
											<span class="highlight"></span>

											<label>Home Ground Location *</label>
											<span class="input-group-text apicon"><i
													class="icon-map-marker"></i></span>
										</div>
									</div>
									<span class="text-danger" id="homGround_location_error" style="display: none;">Home Ground Location is required</span>
								</div>
							</div>
							<div class="row mb-3">
								<div class=" col-md-6 FlotingLabelUp ">
									<div class="floating-form ">
										<span class="round01"></span>
										<div class="floating-label form-select-fancy-1">
											<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="team_country" name="team_country">
												<option value=""></option>
												@foreach($countries as $country)
												<option value="{{$country->id}}">{{$country->name}}</option>
												@endforeach
											</select>
											<span class="highlight"></span>
											<label>Country *</label>
										</div>
									</div>
									<span class="text-danger" id="team_country_error" style="display: none;">Country is required</span>
								</div>
								<div class=" col-md-6 FlotingLabelUp ">
									<div class="floating-form ">
										<div class="floating-label form-select-fancy-1">
										   <!--  <input class="floating-input" type="File" placeholder=" "> -->
										   <input type="color" class=" floating-input NEwColorPicker input-sm" value="" name="team_color" id="team_color">
											<span class="highlight"></span>
											<label>Team Color </label>
										</div>
									</div>
								</div>
							</div>

							<div class="row ">
								<div class=" col-md-6 FlotingLabelUp">
									<div class="floating-form ">
										<span class="round01"></span>
										<div class="floating-label form-select-fancy-1">
											<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" name="member_position" id="admin_position">
												<option value=""></option>
												@foreach($admin_position as $mp)
													<option value="{{$mp->id}}" style="text-transform: capitalize;">{{$mp->name}}</option>
												@endforeach
											</select>
											<span class="highlight"></span>
											<label>Select Admin Position</label>
										</div>
									</div>
								</div>
								<div class="col-lg-6 multi-button mb-3 d-flex">
									<div class="col-10">
										<select class="form-control form-select-fancy-1 typeahead"
											aria-label=".form-select-lg example" name="team_admins"
											id="team_admins" multiple="multiple">

										</select>
									</div>
									<div class="col-2">
										<button type="button" class="btn btn-default float-end btn-round-submit" id="add_adminPosition"><i
												class="icon-plus"></i></button>
									</div>
								</div>
							</div>

							<div class="row ">
								<div class=" col-md-6 FlotingLabelUp">
									<div class="floating-form ">
										<span class="round01"></span>
										<div class="floating-label form-select-fancy-1">
											<select class="floating-select" onclick="this.setAttribute('value', this.value);" value="" id="player_position" name="player_position">
												<option value=""></option>
													@foreach($player_position as $mp)
														<option value="{{$mp->id}}">{{$mp->name}}</option>
													@endforeach
											</select>
										  <span class="highlight"></span>
										  <label>Select Player Position </label>
										</div>
									</div>
								</div>
								<div class="col-lg-6 multi-button mb-3 d-flex">
									<div class="col-10">
										<select class="form-control form-select-fancy-1 typeahead_player"
											aria-label=".form-select-lg example" name="team_players"
											id="team_players" multiple>

										</select>
									</div>
									<div class="col-2">
										<button type="button" class="btn btn-default float-end btn-round-submit" id="add_player"><i
												class="icon-plus"></i></button>
									</div>
								</div>
							</div>

							<div class="row mb-3">
								<div class=" col-md-12 FlotingLabelUp ">
									<div class="floating-form  ">
										<div class="floating-label ">
											<textarea
												class="floating-input floating-textarea form-control Competiton grey-form-control"
												cols="30" rows="5" placeholder=" " id="team_desc" name="team_desc"></textarea>
											<span class="highlight"></span>
											<label class="TeamDescrForm">Team Description</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="d-grid gap-2 d-md-block mt-5 mb-5">
							<button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel"
								>Cancel</button>
							<button type="button" id="saveBtn" class="btn col-5 btn-submit float-md-end"
								>Save</button>
						</div>
						<!-- Circles which indicates the steps of the form: -->
						<div style="text-align:center;margin-top:40px;display:none;">
							<span class="step"></span>
							<span class="step"></span>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-5 col-md-6 ps-0 pe-0  h-screen sticky" style="top: 0px;" id="ScrollRight">
				<div class="show-content">
					<div class="show-content-header">
						<div class="d-flex align-items-center ">
							<style>
								.image-upload #file { display: none;}
							</style>
							<div class="image-upload">
								<label for="file">
									<span class="Edit-Icon-white EditProfileOneSticky"> </span>
									<input id="file" type="file"  name="team_logo"/>
								</label>
							</div>
							<div class="game-logo">
								<img src="{{url('frontend/images/TeamMore-Add.png')}}" alt="SportVote Logo" id="logo" class="img-fluid Logo8080">
							</div>
							<div class="ms-auto text-end">
								<h2 class="header-name" id="display_team_name">Team Name <br></h2>
								<h5><span class="header_game">Soccer</span> in <span id="locationname">Location</span></h5>
							</div>
						</div>
					</div>
						@livewire('team.create-team')
						@livewireScripts
				</div>
			</div>
</div>
</main>

@include('frontend.includes.footer')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/js/bootstrap.min.js"></script>
<!-- end date picker script  -->
<script src="{{url('frontend/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{url('frontend/js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{url('frontend/js/jquery.easing.1.3.js')}}"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

  <!-- Vendor JS Files -->
<script src="{{url('frontend/assets/vendor/aos/aos.js')}}"></script>
<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{url('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{url('frontend/assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{url('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{url('frontend/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
<script src="{{url('frontend/js/script.js')}}"></script>
<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{url('frontend/js/main.js')}}"></script>
<script src="{{url('frontend/js/multi-step.js')}}"></script>
<script>
	$('.form-control').on('focus blur change', function (e) {
		var $currEl = $(this);

		if ($currEl.is('select')) {
			if ($currEl.val() === $("option:first", $currEl).val()) {
				$('.control-label', $currEl.parent()).animate({ opacity: 0 }, 240);
				$currEl.parent().removeClass('focused');
			} else {
				$('.control-label', $currEl.parent()).css({ opacity: 1 });
				$currEl.parents('.form-group').toggleClass('focused', ((e.type === 'focus' || this.value.length > 0) && ($currEl.val() !== $("option:first", $currEl).val())));
			}
		} else {
			$currEl.parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
		}
	}).trigger('blur');
</script>
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
	$('#file').ijaboCropTool({
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
			//$('#file').html(message);
		},
		onError:function(message, element, status){
		alert(message);
		}
	});
</script>
<script>
    $('#triggerAll').on('click',function(){
		
        $('.processed').trigger('click');
		$(this).addClass('clicked');
        // Add your refresh logic here if needed
        setTimeout(function() {
          $('#triggerAll').removeClass('clicked');
        }, 1000);
    });
</script>


<script>
	$(document).on('blur','#team_name', function(){
		var t = 0;
		var name = $('#team_name').val();
		if(name == ''){
			t++;
			$('#team_name_error').show();
		}else{
			$('#team_name_error').hide();
			$('#team_name_error').hide();
			if(name.length > 30){
				t++;
				$('#team_name_error2').show();
			}else{
				$('#team_name_error2').hide();
			}
		}
		var team_id = $('#team_id').val();
		if(t == 0)
		{
			var sport_id = $('input:radio[name="sport_id"]:checked').val();
			if(name != "")
			{
				$.ajax({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url:"{{route('team.store')}}",
				method:"POST",
				data:{name:name,sport_id:sport_id,team_id:team_id},
				error:function(){
				// alert('Something is Wrong');
				},
				success:function(response)
				{
					$('#team_id').val(response);
				}

				});
			}
		}

});
</script>

<script type="text/javascript">
	$(document).on('click','#team_location',function(){
		var autocomplete;
		var id = 'team_location';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})
	});
  $(document).on('click','#homGround_location',function(){
    var autocomplete;
		var id = 'homGround_location';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('.typeahead').select2({
        placeholder: 'Select Admins then click + ',
        ajax: {
            url: "{{ url('autosearch_user_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name+' '+item.l_name,
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
        placeholder: 'Select Players then click + ',
        ajax: {
            url: "{{ url('autosearch_player_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name+' '+item.l_name,
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
$(document).ready(function(){
$(document).on('click','#Volleyball',function(){
	alert('Coming Soon.....');
	$("#soccer").prop("checked", true);
});
});
</script>
<script>
$(document).on('keyup','#team_name',function(){
	var team_name = $('#team_name').val();
	$('#display_team_name').html(team_name);
})

$(document).on('keyup','#team_location',function(){
	var locationanme = $('#team_location').val();
	$('#locationname').html(locationanme);
});
$(document).on('click','.content',function(){
	var locationanme = $('#team_location').val();
	$('#locationname').html(locationanme);
});
$(document).on('click','#prevBtn',function(){
	location.href = "{{url('dashboard')}}";
})

</script>
<script>
$(document).on('click','#saveBtn',function(){
	var team_id = $('#team_id').val();
	var x = 0;
		var sport_id = $('input:radio[name="sport_id"]:checked').val();
		var name = $('#team_name').val();
		var location = $('#team_location').val();
		var homGround = $('#homeground_name').val();
		var homGround_location = $('#homGround_location').val();
		var team_color = $('#team_color').val();
		var description = $('#team_desc').val();
		var team_country = $( "#team_country option:selected" ).val();
		if(sport_id == ''){
			$('#sports_error').show();
			x++;
		}else{
			$('#sports_error').hide();
		}
		if(name == ''){
			$('#team_name_error').show();
			x++;
		}else{
			$('#team_name_error').hide();
			if(name.length > 30){
				x++;
				$('#team_name_error2').show();
			}else{
				$('#team_name_error2').hide();
			}
		}
		if(location == ''){
			$('#team_location_error').show();
			x++;
		}else{
			$('#team_location_error').hide();
		}
		if(homGround == ''){
			$('#homeground_name_error').show();
			x++;
		}else{
			$('#homeground_name_error').hide();
		}
		if(homGround_location == ''){
			$('#homGround_location_error').show();
			x++;
		}else{
			$('#homGround_location_error').hide();
		}
		if(team_country == ''){
			$('#team_country_error').show();
			x++;
		}else{
			$('#team_country_error').hide();
		}
			//alert(team_country);
		if(team_id != '' && x == 0)
		{
		$.ajax({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:"{{route('team.save_team')}}",
			method:"POST",
			data:{name:name,sport_id:sport_id,team_id:team_id,team_country:team_country,location:location,homGround:homGround,homGround_location:homGround_location,team_color:team_color,description:description},
			error:function(){
			alert('Something is Wrong');
			},
			success:function(response)
			{
				//alert('data saved');
				window.location.href = "{{url('team')}}/"+response;


			}

			});
	}
})
</script>

<script>
    $(document).on('click','#add_adminPosition',function(){
            var memberid = $('#team_admins').val();
            var memberpositionid = $('#admin_position').val();
			//alert(memberpositionid);

            var team_id = $('#team_id').val();
            var sport_id = $('input:radio[name="sport_id"]:checked').val();
            if(sport_id && team_id)
			{
				if(memberpositionid == "")
				{
					alert('select Team admin position');
				}
				else
				{
					$.ajax({
					headers: {
					 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 },
					url:"{{url('team_members')}}",
					type:'post',
					data:{sport_id:sport_id,memberid:memberid,memberpositionid:memberpositionid,team_id:team_id},
					error:function(){
					// alert('Something is Wrong');
					},
					success:function(response)
					{
						$('#team_admins').empty();
					}

				   });
				}
			}
			else
			{
				alert('Create Team');
			}

    })
</script>

<script>
    $(document).on('click','#add_player',function(){
            var memberid = $('#team_players').val();
            var memberpositionid = $('#player_position').val();
			//alert(memberpositionid);

            var team_id = $('#team_id').val();
            var sport_id = $('input:radio[name="sport_id"]:checked').val();
            if(sport_id && team_id)
			{
				if(memberpositionid == "")
				{
					alert('select player position');
				}
				else
				{
					$.ajax({
					headers: {
					 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 },
					url:"{{url('team_members')}}",
					type:'post',
					data:{sport_id:sport_id,memberid:memberid,memberpositionid:memberpositionid,team_id:team_id},
					error:function(){
					// alert('Something is Wrong');
					},
					success:function(response)
					{
						$('#team_players').empty();
						//alert('ok');
					}

				   });
				}
			}
			else
			{
				alert('Create Team');
			}

    })
</script>
@include('frontend.includes.searchScript')
</body>

</html>
