<!-- join modal Start-->
<div id="joinModal" class="modal fade" role="dialog">
        <div class="modal-dialog shadow">
        <div class="modal-content">
		<span id="join_now_heading"> <div class="modal-header" id="modal_1" style="padding-bottom:0px;">
					<h4>Join Now</h4>
				</div>
				<span class="WithoutPass">Create user account to use SportVote</span> </span>

            <div class="modal-body">
			 <section class="multi_step_form">
				<form id="msform">

				<input type="hidden" id="userid" value="{{old('userid')}}">

			<fieldset id="popup_1">
				<div class="row mb-3">
				<label class="visually-hidden" for="email">Enter Email</label>
				<input type="text" class="form-control" placeholder="Enter Email" id="useremail" name="svemail" value="" autocomplete="off">
				<span class="sv_error" id="email_error"></span>
				</div>

				<div class="row mb-3">
					<div class="form-check col">
					<input type="radio" class="form-check-input"  name="joinnow_pass" value="1" checked> <label class="form-check-label" > With Password</label></div>
					<div class="form-check col">
					<input type="radio" class="form-check-input"  name="joinnow_pass" value="0"> <label class="form-check-label" for="withoutpassword"> Without password (OTP to email)</label></div>
				</div>
				<button type="submit" id="submitemail" class="btn  btn-submit">Submit</button>
			</fieldset>

			<fieldset id="popup_2">
			<div class="modal-header" id="modal_2" style="padding:0px;">
				<h4>Verification</h4>
			</div>
			<span style="padding-left:0px;" class="WithoutPass">Enter the verification code you received at <span style="padding-left:0px;" id="join_useremail"> </span></span> </span>
			<div class="mb-3">
				<label class="visually-hidden" for="verification_code">Enter Verification Code</label><input type="text" class="form-control LettrSpcng input-sm" placeholder="------" id="verification_code1" maxlength="6" style="letter-spacing: 1.2rem;"  autocomplete="off"><span class="ClockAuto" id="timer"></span>
				<span class="sv_error" id="errorotp"></span> <a class="custom_a" style="margin-left:60%;text-decoration:underline; color:white; display:none;"  id="resend_verification_code">Resend Verification</a>
			</div>
			<button type="submit" class="btn  btn-submit" id="verification">Complete Verification</button>
			<!-- <a class="custom_a" style="margin-left:23%;text-decoration:underline;color:white;" id="jm_goback_popup1">Go Back</a> -->
			</fieldset>

				<fieldset id="create_password_popup" style="display:none;">
					<div class="modal-header" style="padding:0px;">
						<h4>Password</h4>
					</div>
					<span style="padding-left:0px;" class="WithoutPass">Create a secure password for your account</span> </span>
						<div class="row mb-3">
						<label class="visually-hidden" for="c_pass_o">Create Password</label>
						<input type="password" class="form-control input-sm" placeholder="Create Password" id="password" name="password"  autocomplete="off">
						<span id="required_pass" class="text-danger" style="display:none;">Password is required </span>
						</div>
						<div class="row mb-3">
						<label class="visually-hidden" for="cc_pass_o">Confirm Password</label>
						<input type="password" class="form-control input-sm" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation"  autocomplete="off">
						<span id="password_error" class="sv_error"></span>
						<span id="required_cpass" class="text-danger" style="display:none;">Confirm Password is required </span>
						</div>
						<button type="submit" class="btn  btn-submit" id="create_pass_sub">Create Password</button> <span id="go_back"><a style="margin-left:23%;text-decoration:underline;color:white;" id="create_password_skip">Skip for now</a></span>

					</fieldset>

		<fieldset id="popup_3">
			<div class="modal-header" id="modal_3">
                <h4 class="fw-thin">Basic Info</h4>
            </div>
				   <div class="row mb3">
					<div class="mb-3 col-md-6">
                       <label class="visually-hidden" for="f_name"> First Name</label><input type="text" class="form-control input-sm bb_textbox" placeholder="First Name *" id="f_name1" name="f_name"> </div>
					   <div class="mb-3 col-md-6">
					   <label class="visually-hidden" for="l_name"> Last Name</label><input type="text" class="form-control input-sm bb_textbox" placeholder="Last Name *" id="l_name1" name="l_name">

					</div>
					<span id="required_name" class="sv_error" style="display:none;">* Name field is required </span>
					<span id="name_err" class="sv_error" style="display:none;">* Name should be contain alphabets </span>
                   </div>
                    <div class="row mb3">
						<div class="mb-3 col">
						   <label class="visually-hidden" for="dob">* Date of Birth</label>

                           {{-- <input type="date" class="form-control input-sm bb_textbox" name="dob" placeholder="Date of Birth" id="dob1" > --}}

                           <input type="text" onfocus="(this.type='date')" id="dob1" max="<?=date('Y-m-d', strtotime("-15 year", strtotime(date('Y-m-d'))));?>"
                                            class="grey-form-control browse-control input-sm border rounded p-2"
                                             name="dob" placeholder="Date of Birth *"/>
						</div>
						<span id="required_dob" class="sv_error" style="display:none;">* D.O.B field is required </span>
						<span id="required_dob2" class="sv_error" style="display:none;">* Your age must be 15 years or more than 15 years.</span>
					</div>

					<div class="mb-3">
					   <label class="visually-hidden" for="location">Location</label>
					   <input type="text" class="form-control input-sm bb_textbox" name="p_location" placeholder="Location *" id="p_location1" autocomplete="off">
					</div>
					<span id="required_location" class="sv_error" style="display:none;"> * Location field is required </span>

					<div class="row mb3">
						{{-- <div class="mb-3 col-md-4">
                           <label class="visually-hidden" for="height">* Your Height</label> <input type="number" step="any" class="form-control input-sm bb_textbox" name="height" placeholder="Height(cm) *" id="height1" >
						   <span id="required_height" class="sv_error" style="display:none;"> * Height field is required </span>
						</div>

						<div class="mb-3  col-md-4">
                           <label class="visually-hidden" for="Weight">* Your Weight</label> <input type="number" step="any" class="form-control input-sm bb_textbox" name="Weight" placeholder="Weight(kg) *" id="Weight1" >
						   <span id="required_weight" class="sv_error" style="display:none;"> * Weight field is required </span>
						</div> --}}

						<div class="mb-3  col-md-12">
                           <label class="visually-hidden" for="nation">Nationality</label>
						   <!-- <input type="text" class="form-control input-sm bb_textbox" name="nationality" placeholder="Nationality" id="nation" > -->
						   @if(!empty($country))
						   <select class="form-control input-sm bb_textbox" name="nationality"  id="nation1">
					  		<option class="form-control input-sm bb_textbox" value="" selected="selected">Nationality *</option>
					  		@foreach($country as $upt)
					   		<option style="color:black;" value="{{$upt->name}}">{{$upt->name}}</option>
					  		 @endforeach
							</select>
							@endif
							<span id="required_national" class="sv_error" style="display:none;">* Nationality field is required </span>
						</div>

					</div>
					<div class="row mb3">
					<div class="mb-3 col">
                       <label class="" for="bio">Your Bio *</label>
					   <textarea class="form-control input-sm" placeholder="Sport, preferred position, level, future aspirations" id="bio1" name="bio" rows="3"></textarea>
                    </div>
                    <span id="required_biol" class="sv_error" style="display:none;">* Bio field is required </span>
                    <span id="required_bio2" class="sv_error" style="display:none;">* Bio must not be greater than 250 characters.</span>
					</div>
				<div class="mb-3">
					<div class="form-check">
					  <input class="form-check-input" type="checkbox" id="termsofuse1" value="0">
					  <label class="form-check-label" for="termsofuse1">
						I accept Sportvote <a href="{{url('terms')}}" title="termofuse" class="terms_btn">Terms of Use</a>
					  </label>
						<br><span id="terms_error" class="sv_error"> </span>
					</div>
				  </div>

                       <button type="button" id="profile" class="btn btn-submit">Choose Your Profile</button>

    </fieldset>

    <fieldset id="popup_4">
				<div class="form-header" id="modal_4">
					<h4>Your Profile</h4>
					<p>Select the <strong><u>most appropriate role</u></strong> that describes your usage on SportVote.</p>
				</div>
			<div class="s-profile-wrap">
			<div class="form-check">
				 <input class="fans" type="radio" name="selectprof" id="joinModalselectprof1" onclick="handleClick(this);" value="1">
				  <label class="form-check-label" for="joinModalselectprof1">
				  I Love Sports
				  </label>
				</div>
				<div class="form-check">
				  <input class="player" type="radio" name="selectprof" onclick="handleClick(this);" id="joinModalselectprof2"  value="2">
				  <label class="form-check-label" for="joinModalselectprof2">
					I Play Sports
				  </label>
				</div>
				<div class="form-check">
				  <input class="manager" type="radio" name="selectprof" onclick="handleClick(this);" id="joinModalselectprof3" value="3">
				  <label class="form-check-label" for="joinModalselectprof3">
					I Manage Teams
				  </label>
				</div>
				<div class="form-check">
				  <input class="organizer" type="radio" name="selectprof" onclick="handleClick(this);" id="joinModalselectprof4" value="4">
				  <label class="form-check-label" for="joinModalselectprof4">
					I Organize Games
				  </label>
				</div>
				<div class="form-check">
				  <input class="scout" type="radio" name="selectprof" onclick="handleClick(this);" id="joinModalselectprof5" value="5">
				  <label class="form-check-label" for="joinModalselectprof5">
				  	I Officiate / Referee Sports
				  </label>
				</div>
				<div class="form-check">
				  <input class="other" type="radio" name="selectprof" id="joinModalselectprof6" value="6">
				  <label class="form-check-label" for="joinModalselectprof6">
					Other / Support Staff
				  </label>
				</div>
			</div>
			</fieldset>
                    </form>
			</section>
            </div>
        </div>
        </div>
    </div>
	<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
	<script src="{{url('frontend/js/typeahead.js')}}"></script>
<!-- // Join now Modal Ajax end  -->

    <script>
		$(document).ready(function() {
			$('#popup_2').hide();
			$('#popup_3').hide();
			$('#popup_4').hide();
        $(document).on('click', '#submitemail', function(){
			event.preventDefault();
        var email = $('#useremail').val();
		var is_pass = $('input:radio[name="joinnow_pass"]:checked').val();
		// alert(is_pass);
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if(email.match(mailformat))
				{
					$.ajax({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
						url:"{{url('SaveUserMail')}}",
						type:'post',
						data:{email:email},
						error:function(){

						},
						success:function(response)
						{
							if(response == 0)
							{
								$('#email_error').html('Email ID is already exists, Please Sign In');

								// alert('Email already exists');
							}
							else{
							$('#popup_1').hide();
							$('#join_now_heading').hide();
							timer(120);
							$('#popup_2').show();
							$('#join_useremail').html(email);
							$('#userid').val(response);
							}
						}
					});
			}
			else
			{

				$('#email_error').html("Enter valid email");
			}

        });
	});
</script>

<!-- without password -->
<script>
	$(document).on('click','#verification',function(){
		event.preventDefault();
		var userid = $('#userid').val();
		var verification_code = $('#verification_code1').val();
		var is_pass = $('input:radio[name="joinnow_pass"]:checked').val();
		var useremail = $('#useremail').val();
		$.ajax({
			headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
        url:"{{url('updateverification')}}",
        type:'post',
        data:{userid:userid,verification_code:verification_code,useremail:useremail},
        error:function(){
        alert('Something is Wrong');

        },
        success:function(response)
        {
			if(response == '0')
		{
			$('#popup_2').show();

			$('#errorotp').html('Wrong verification code');

		}
		else
		   {
			   if(is_pass == 1)
			   {
				$('#popup_2').hide();
				$('#popup_1').hide();
				$('#create_password_popup').show();
			   }
			   else
			   {
					$('#popup_2').hide();
					$('#popup_3').show();
					$('#required_name').hide();
			   }
		   }
		}
		});
	});
</script>


<!-- // resend verification code  -->
<script>
$('#resend_verification_code').on('click', function () {
	$('#errorotp').html('');
$('#resend_verification_code').hide();
  timer(120);
  var uemail = $('#useremail').val();

$.ajax({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
				url:"{{url('create_login_otp')}}",
				type:'POST',
				data:{uemail:uemail},
			error:function(){
			// alert('Please Sign Up First');
			},
			success:function(response)
			{
			}
		});

    });
</script>



<script>
	let timerOn_1 = true;

function timer(remaining_1) {
  var m = Math.floor(remaining_1 / 60);
  var s = remaining_1 % 60;

  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML = m + ':' + s;
  remaining_1 -= 1;

  if(remaining_1 >= 0 && timerOn_1) {
    setTimeout(function() {
        timer(remaining_1);
    }, 1000);
    return;
  }

  if(!timerOn_1) {
    // Do validate stuff here
    return;
  }

  // Do timeout stuff here
//   alert('Timeout for otp');
  $('#errorotp').html('Time to enter code expired-');
  $('#resend_verification_code').show();

  user_id = $('#userid').val();
  $.ajax({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	url:"{{url('vanish_otp')}}",
		type:'post',
		data:	{user_id:user_id},
	error:function(){
	alert('Something is Wrong');
	},
	success:function(response)
	{

	}

});

}
</script>

<script>
    $(document).on('click','#jm_goback_popup1',function(){
        $('#popup_2').hide();
		$('#popup_1').show();
        $('#join_now_heading').show();
    });
</script>

<script>
$(document).on('click','#create_password_skip',function(){

	$('#popup_3').show();
	$('#create_password_popup').hide();
	$('#popup_4').hide();
});
</script>

<script>
$(document).on('click','#profile', function(){
	var a = 0;
	var f_name = $('#f_name1').val();
	var l_name = $('#l_name1').val();

   var regex = new RegExp('^[A-z]+$');

            //Validate TextBox value against the Regex.
            var isValid = regex.test(f_name);
            var isValid2 = regex.test(l_name);

            if(!isValid)
            {
                if(f_name != ''){
                $('#name_err').show();
                a++;
                }
            }
            else
            {
                $('#name_err').hide();

            }
            if(!isValid2)
            {
                if(l_name != ''){
                $('#name_err').show();
                a++;
                }
            }
            else
            {
                $('#name_err').hide();

            }

	if(f_name == "" || l_name == "")
	{
		$('#required_name').show();
		a++;
	}else{
		$('#required_name').hide();

	}
	var dob = $('#dob1').val();
	if(dob == "")
	{
		$('#required_dob').show();
		a++;
	}else{
		$('#required_dob').hide();
		var result = dob.split('-');
        var currentYear = (new Date).getFullYear();
		if (currentYear - result[0] < 15) {
            $('#required_dob2').show();
            a++;
        } else {
            $('#required_dob2').hide();
        }
	}

	var p_location = $('#p_location1').val();
	if(p_location == "")
	{
		$('#required_location').show();
		a++;
	}else{
		$('#required_location').hide();
	}
	var nation = $('#nation1').val();
	if(nation == "")
	{
		$('#required_national').show();
		a++;
	}else{
		$('#required_national').hide();
	}
	var bio = $('#bio1').val();
	if(bio ==""){
		$('#required_biol').show();
		a++;
	}else{
		$('#required_biol').hide();
		if(bio.length > 250){
			$('#required_bio2').show();
			a++;
		}else{
			$('#required_bio2').hide();
		}
	}
	var termsofuse = $('#termsofuse1').val();
	if(termsofuse == '0')
	{
		$('#terms_error').html('Please Check Terms of Use');
	}
	if(termsofuse == '1')
	{
		$('#terms_error').html('');
	}
	//    alert(termsofuse);
	var userid = $('#userid').val();
	if (termsofuse == '1' && a == 0)
	{
		$.ajax({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:"{{url('updatProfile')}}",
				type:'post',
				data:{userid:userid,f_name:f_name,l_name:l_name,dob:dob,p_location:p_location,nation:nation,bio:bio,termsofuse:termsofuse},
			error:function(){
			alert('Something is Wrong');
			},
			success:function(response)
			{
				if(response == 1)
				{
					$('#popup_3').hide();
					$('#popup_4').show();
				}
				else
				{
					$('#required_name').show();
				}
				// alert('data saved');
			}
		});
	}
});
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
<script type="text/javascript">
    $(document).on('click','#p_location1',function(){
		var autocomplete;
		var id = 'p_location1';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})
	});
</script>

<script>
	$(document).on('click','#create_pass_sub',function(){
		event.preventDefault();
		var userid = $('#userid').val();
		var useremail = $('#useremail').val();
		var password = $('#password').val();
		var password_confirmation = $('#password_confirmation').val();
		var b = 0;
		if(password == ''){
			$('#required_pass').show();
			b++;
		}else{
			$('#required_pass').hide();
		}
		if(password_confirmation == ''){

			$('#required_cpass').show();
			b++;
		}else{
			$('#required_cpass').hide();
		}

		if(b == 0){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url:"{{url('create_password')}}",
				type:'post',
				data:{userid:userid,useremail:useremail,password:password,password_confirmation:password_confirmation},
				error:function(){
				alert('Something is Wrong');
				},
				success:function(response)
				{
					if(response == 2)
					{
						$('#password_error').html('Error: Password do not match');
					}
					else if(response == 1)
					{
						// alert("password created successfully");
						// swal("Pasword Created!", "successfully!", "success")
						$('#popup_2').hide();
						$('#create_password_popup').hide();
						$('#popup_3').show();
						$('#required_name').hide();
					}
				}
			});
		}

	});
</script>

<script>
function handleClick(myRadio) {
var selectedValue = myRadio.value;
var userid = $('#userid').val();
$.ajax({
	headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('userProfile')}}",
        			type:'post',
        			data:{selectedValue:selectedValue,userid:userid},
       			 error:function(){
            	alert('Something is Wrong');
        		},
				success:function(response)
				{
					if(response==1)
					{
						location.href = "{{url('fan')}}";
					}
					if(selectedValue==2)
					{
						location.href ="{{url('player_profile')}}";
					}
					if(selectedValue==5)
					{
						location.href = "{{url('referee')}}";
					}
					if(selectedValue==3)
					{
						location.href ="{{route('team.create')}}";

					}
					if(selectedValue==4)
					{
						location.href = "{{route('competition.create')}}";

					}
				}
});

};
</script>
