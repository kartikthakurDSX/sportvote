
<style>
.login_basicinfo_popup input.form-control:focus{
	background-color:white !important;
}
</style>
<!-- // Login Modal Start  -->
<div id="loginModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog shadow">
    	<div class="modal-content">
       		<span id="login_step_1">
				<div class="modal-header" style="padding-bottom:0px;">
            		<h4>Sign In</h4>
        		</div>
				<span class="WithoutPass">Login below with password</span>
				<!-- <span class="WithoutPass">Login below with or without password. </span> -->
			</span>
			<div class="modal-body">
				<section class="multi_step_form">
        			<form autocomplete="off">
						<input type="hidden" id="login_userid" value="{{old('login_userid')}}">
						<fieldset id="login_popup">
							<div class="row mb-3">
								<label class="visually-hidden" for="uemail">Enter Email</label><input autocomplete="off" type="text" class="form-control input-sm bb_textbox" placeholder="Enter Email" id="uemail" name="email" value="">
								<input type="hidden" id="is_password" value="1">
								<span id="email_login_error" class="sv_error" style="display:none;"> Enter Email Id </span>
							</div>
							<div class="row mb-3">
								<div class="form-check col">
								<input type="radio" class="form-check-input"  name="pass" value="1" checked> <label class="form-check-label"> With Password</label></div>
								<!-- <div class="col">
								<input type="radio" class="form-check-input"  name="pass" value="0"> <label class="form-check-label" for="withoutpassword"> Without Password</label></div> -->
							</div>
							<div id="inputpassword">
								<div class="row mb-3" >
									<label class="visually-hidden" for="pswrd">Enter Password</label><input type="password" class="form-control input-sm" placeholder="Enter Password" id="pswrd" name="password">
									<span id="login_popup_error" class="sv_error"> </span>
								</div>
								<button type="submit" id="userloginpass" class="btn  btn-submit">SUBMIT</button><span id="reset_password"><a class="custom_a" style="margin-left:35%;text-decoration:underline" id="reset_pass_click">Reset Password</a></span>
							</div>
							<span id="login_new_error" class="sv_error"></span>
							<div id="withoutpassword_submit" style="display:none;">
								<button type="submit" id="send_otp" class="btn  btn-submit">SUBMIT</button>
							</div>
						</fieldset>
						<fieldset id="reset_pass_popup" style="display:none;">
							<div class="modal-header" id="modal_2" style="padding:0px;">
								<h4>Reset Password</h4>
							</div>
							<span style="padding-left:0px;" class="WithoutPass">Enter Your email below to reset your password</span>
							<div class="row mb-3">
								<label class="visually-hidden" for="uemail">Enter Email</label><input type="text" class="form-control input-sm bb_textbox" placeholder="Enter Email" id="reset_email" value="" autocomplete="off">
								<span id="email_reset_error" class="sv_error"></span>
							</div>
							<button type="submit" id="reset_email_check" class="btn  btn-submit">SUBMIT</button> <a class="custom_a" style="margin-left:25%;text-decoration:underline;color:white;" id="create_user">Create new User?</a>
						</fieldset>
						<fieldset id="login_verification_popup">
							<div class="modal-header" id="modal_2" style="padding:0px;">
								<h4>Verification</h4>
							</div>
							<span style="padding-left:0px;" class="WithoutPass">Enter Your verification code you received on <span style="padding-left:0px;" class="WithoutPass" id="sender_email"></span>  </span>
							<div class="mb-3">
								<label class="visually-hidden" for="otp">Enter Verification Code</label><input type="text" class="form-control LettrSpcng input-sm" placeholder="------" id="otp" name="otp" maxlength="6"><span class="ClockAuto" id="lm_verification_timer"></span>
								<span id="login_popup_error1" class="sv_error"> </span>  <a class="custom_a" id="join_resend_verification_code" style="position:absolute;text-decoration:underline;color:white; display:none;">Resend Verification</a>
							</div>
							<div class="mb-3">
								<div class="form-check" id="create_check_pass">
									<input class="form-check-input" type="checkbox" id="reset_is_cr_pass">
									<label class="form-check-label">
									<span class="CRetPassW">Create Password</span> <em><span class="OptionStyle">(Optional)</span></em>
									</label>
								</div>
							</div>
							<span id="password_error1" class="sv_error"></span>
							<button type="submit" class="btn  btn-submit" id="userlogin">Complete Verification</button>
							<a class="custom_a go_back" href="{{url('/')}}">Cancel</a>
						</fieldset>
						<fieldset id="reset_create_password" style="display:none;">
							<div class="modal-header" id="modal_2" style="padding:0px;">
								<h4>Password</h4>
							</div>
							<span style="padding-left:0px;" class="WithoutPass">Create a secure password for your account</span>
							<div class="row mb-3">
								<label class="visually-hidden" for="c_pass_o">Create Password</label><input type="password" class="form-control input-sm" placeholder="Create Password" id="reset_password_input" name="password">
								<p class="password_strength" id="strength" ></p>
							</div>
							<div class="row mb-3">
								<label class="visually-hidden" for="cc_pass_o">Confirm Password</label><input type="password" class="form-control input-sm" placeholder="Repeat Password" id="reset_password_confirmation" name="password_confirmation">
								<span id="password_match_error" class="sv_error"></span>
							</div>
							<button type="submit" class="btn  btn-submit" id="reset_create_pass_sub">Create Password</button> <span id="go_back"><a style="margin-left:23%;text-decoration:underline;" href="">Skip for now</a></span>
						</fieldset>
						<fieldset id="login_basicinfo_popup">
							<div class="modal-header">
								<h4 class="fw-thin">Basic Info</h4>
							</div>
							<div class="row mb3">
								<div class="mb-3 col-md-6">
									<label class="visually-hidden" for="f_name">First Name *</label><input type="text" class="form-control input-sm bb_textbox" placeholder="First Name *" id="f_name" name="f_name"> </div>
								<div class="mb-3 col-md-6">
									<label class="visually-hidden" for="l_name">Last Name *</label><input type="text" class="form-control input-sm bb_textbox" placeholder="Last Name" id="l_name" name="l_name">
								</div>
							</div>
							<div class="row mb3">
								<div class="mb-3 col">
									<label class="visually-hidden" for="dob">Date of Birth</label> <input type="date" class="form-control input-sm bb_textbox" name="dob" placeholder="Date of Birth" id="dob" >
								</div>
							</div>
							<div class="mb-3">
								<label class="visually-hidden" for="p_location">Location</label> 
								<input type="text" class="form-control input-sm bb_textbox" name="p_location" placeholder="Location" id="p_location" >
							</div>
							<div class="row mb3">
								<div class="mb-3 col-md-4">
									<label class="visually-hidden" for="height">Your Height</label> <input type="number" step="any" class="form-control input-sm bb_textbox" name="height" placeholder="Height (cm)" id="height" min="1">
								</div>
								<div class="mb-3  col-md-4">
									<label class="visually-hidden" for="Weight">Your Weight</label> <input type="number" step="any" class="form-control input-sm bb_textbox" name="Weight" placeholder="Weight (kg)" id="Weight" min="1">
								</div>
								<div class="mb-3  col-md-4">
									<label class="visually-hidden" for="nation">Nationality</label>
									<!-- <input type="text" class="form-control input-sm bb_textbox" name="nationality" placeholder="Nationality" id="nation" > -->
									@if(!empty($country))
									<select class="form-control input-sm bb_textbox" name="nationality"  id="nation">
										<option class="form-control input-sm bb_textbox" value="" selected="selected">Nationality</option>
										@foreach($country as $upt)
										<option style="color:black;" value="{{$upt->name}}">{{$upt->name}}</option>
										@endforeach
									</select>
										@endif
								</div>
							</div>
							<div class="row mb3">
								<div class="mb-3 col">
									<label class="visually-hidden" for="bio">Your Bio</label><textarea class="form-control input-sm" placeholder="Your Bio" id="bio" name="bio" rows="3"></textarea>
								</div>
							</div>
							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="termsofuse" value="0">
									<label class="form-check-label" for="termsofuse">
										I accept Sportvote <a href="#terms" title="termofuse" class="terms_btn">Terms of Use</a>
									</label>
									<br><span id="terms_error1" class="sv_error"> </span>
								</div>
							</div>
							<button type="button" id="submit_login_profile" class="btn btn-submit">Choose Your Profile</button>
						</fieldset>
    					<fieldset id="login_profile_popup">
							<div class="form-header" id="modal_4" style="color:#fff;">
								<h4>Your Profile</h4>
								<p>Select the <strong><u>most appropriate role</u></strong> that describe your usage of SportVote!</p>
							</div>
							<div class="s-profile-wrap">
								<div class="form-check">
									<input class="fans" type="radio" name="selectprof" id="loginModalselectprof1" onclick="handleClicklogin(this);" value="1">
									<label class="form-check-label" for="loginModalselectprof1">
										I Love Sports
									</label>
								</div>
								<div class="form-check">
									<input class="player" type="radio" name="selectprof" onclick="handleClicklogin(this);" id="loginModalselectprof2"  value="2">
									<label class="form-check-label" for="loginModalselectprof2">
										I Play Sports
									</label>
								</div>
								<div class="form-check">
									<input class="manager" type="radio" name="selectprof" onclick="handleClicklogin(this);" id="loginModalselectprof3" value="3">
									<label class="form-check-label" for="loginModalselectprof3">
										I Manage Teams
									</label>
								</div>
								<div class="form-check">
									<input class="organizer" type="radio" name="selectprof" onclick="handleClicklogin(this);" id="loginModalselectprof4" value="4">
									<label class="form-check-label" for="loginModalselectprof4">
										I Organize Games
									</label>
								</div>
								<div class="form-check">
									<input class="scout" type="radio" name="selectprof" onclick="handleClicklogin(this);" id="loginModalselectprof5" value="5">
									<label class="form-check-label" for="loginModalselectprof5">
										I Officiate / Referee Sports
									</label>
								</div>
								<div class="form-check">
									<input class="other" type="radio" name="selectprof" id="loginModalselectprof6" value="6">
									<label class="form-check-label" for="loginModalselectprof6">
										Other/Support Staff
									</label>
								</div>
							</div>
						</fieldset>
        			</form>
				</select>
        	</div>
        </div>
	</div>
</div>
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<!-- // Login Modal End  -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script src="{{url('frontend/js/typeahead.js')}}"></script>


	<script>
	$(document).ready(function(){
		$('#login_basicinfo_popup').hide();
		$('#login_profile_popup').hide();
		$('#login_verification_popup').hide();
		$('#reset_password').hide();
		$(document).on('click','#userloginpass',function(){
			event.preventDefault();
		var uemail = $('#uemail').val();
		var pswrd = $('#pswrd').val();

		$.ajax({
	headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('userloginpass')}}",
        			type:'post',
        			data:{uemail:uemail,pswrd:pswrd},
       			 error:function(response){
            	// alert(response);
        		},
				success:function(response)
				{
					// alert(response);

					if(response == 0)
					{
						// alert('Incorrect Email Or Password!!!');
						$('#login_popup').show();
						$('#login_popup_error').html('Your email or password is wrong');
						$('#reset_password').show();
					}

					if(response.popup == "popup_2")
					{
						$('#login_popup').hide();
						$('#login_otp_popup').hide();
						$('#login_verification_popup').hide();
						$('#login_basicinfo_popup').show();
						$('#login_step_1').hide();
						$('#login_profile_popup').hide();
						$('#login_userid').val(response.userid);
					}
					else if(response.popup == "popup_3")
					{
						$('#login_popup').hide();
						$('#login_otp_popup').hide();
						$('#login_verification_popup').hide();
						$('#login_basicinfo_popup').hide();
						$('#login_step_1').hide();
						$('#login_profile_popup').show();
						$('#login_userid').val(response.userid);

					}
					else if(response.popup == "popup_4")
					{
						location.href = "{{url('dashboard')}}";
					}

				}
		});
		});
	});
</script>
<script>
	$(document).on('click','#reset_pass_click',function(){
		var uemail = $('uemail').val();
		// $('#reset_is_cr_pass').prop("checked");
		$("#reset_is_cr_pass").attr("checked","true");
		$('#login_popup').hide();
		$('#login_step_1').hide();
		$('#reset_pass_popup').show();
			document.getElementById("reset_email").value = document.getElementById("uemail").value;
			var useremail = $('#uemail').val();
			$('input[id="reset_email"][data-type-text]').val(useremail).focus();
	});
</script>

<script>
	$(document).on('click','#create_user',function(){
        $('#loginModal').modal("hide");
		$("#joinModal").modal("show");
	});
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
<script>
$(document).on('click','#reset_email_check',function(){

	var uemail = $('#reset_email').val();
	event.preventDefault();
	$.ajax({
				headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 },
			url:"{{url('check_existing_email')}}",
			type:'POST',
			data:{uemail:uemail},
		 error:function(){
		// alert('Please Sign Up First');
		},
		success:function(response)
		{
			if(response == 0)
			{
				// swal("Email Id is not registred!", "...Please create account first!")
				// location.href = "{{url('/')}}";
				$('#email_reset_error').html("We could not find a user with above detail");
			}
			if(response == 1)
			{
				$('#reset_pass_popup').hide();
				$('#login_verification_popup').show();
				$('#create_check_pass').hide();
				$('#sender_email').html(uemail);
				lm_verification_timer(120);



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
					// alert('Please Check Your mail for OTP.');
				}
				});

			}

		}
		});
});
</script>

<script>
$(document).on('click','#back_reset_pass_popup',function(){

	$('#login_popup').show();
	$('#login_step_1').show();
	$('#reset_pass_popup').hide();
	$('#login_verification_popup').hide();
	$('#create_check_pass').hide();

	// location.href = "{{url('/')}}";

});
</script>

<script>
	let timerOn = true;

function lm_verification_timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;

  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('lm_verification_timer').innerHTML = m + ':' + s;
  remaining -= 1;

  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        lm_verification_timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }

  // Do timeout stuff here
//   alert('Timeout for otp');
  $('#login_popup_error1').html('Time to enter code expired-');
  $('#join_resend_verification_code').show();

  uemail = $('#uemail').val();
  $.ajax({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	url:"{{url('vanish_otp')}}",
		type:'post',
		data:	{uemail:uemail},
	error:function(){
	alert('Something is Wrong');
	},
	success:function(response)
	{

	}

});
}
</script>

<script type="text/javascript">
    $(document).on('click','#p_location',function(){
		var autocomplete;
		var id = 'p_location';
		autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
			type:['geocode'],
		})
	});
</script>
<!-- <script>
  $(document).on('click','#p_location',function(){
    var input = document.getElementById('p_location');
    var autocomplete = new google.maps.places.Autocomplete(input);
  });
  google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script> -->
<script>
	$(document).ready(function(){
		$('#login_basicinfo_popup').hide();
		$('#login_profile_popup').hide();
		$('#login_verification_popup').hide();

		$(document).on('click','#userlogin',function(){
			event.preventDefault();
		var uemail = $('#uemail').val();
		var otp = $('#otp').val();
		if($('#reset_is_cr_pass').is(':checked')) {
					// alert('1');
					 var is_pass = 1;
    			}
		else
		{
			var is_pass = 0;
		}
		$.ajax({
	headers: {
   				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				},
				  url:"{{url('userlogin')}}",
        			type:'post',
        			data:{uemail:uemail,is_pass:is_pass,otp:otp},
       			 error:function(response){
            	// alert(response);
        		},
				success:function(response)
				{
					// alert(response);


					if(response == 0)
					{
						// alert('Incorrect Email Or Password!!!');
						$('#login_popup').hide();
                        $('#login_verification_popup').show();
                        $('#login_popup_error1').html('Wrong Verification code');
						// $('#join_resend_verification_code').show();
						$('#go_back').show();
					}
					else
					{
						if(is_pass == 1)
						{
							$('#login_popup').hide();
							$('#login_verification_popup').hide();
							$('#reset_create_password').show();
						// location.href = "{{url('dashboard')}}";
						}
						else
						{
							// location.href = "{{url('dashboard')}}";

							if(response.popup == "popup_2")
							{
								$('#login_popup').hide();
								$('#login_otp_popup').hide();
								$('#login_verification_popup').hide();
								$('#login_basicinfo_popup').show();
								$('#login_userid').val(response.userid);
							}
							else if(response.popup == "popup_3")
							{
								$('#login_popup').hide();
								$('#login_otp_popup').hide();
								$('#login_verification_popup').hide();
								$('#login_basicinfo_popup').hide();
								$('#login_profile_popup').show();
								$('#login_userid').val(response.userid);

							}
							else if(response.popup == "popup_4")
							{
								location.href = "{{url('dashboard')}}";
							}
						}

					}
				}
		});
		});
	});
</script>

<script>
$('#join_resend_verification_code').on('click', function () {

	lm_verification_timer(120);
  	$('#login_popup_error1').html('');
	$('#join_resend_verification_code').hide();
  var uemail = $('#uemail').val();

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
$(document).ready(function(){


$(document).on('click','#send_otp',function(){
	event.preventDefault();
	var uemail = $('#uemail').val();

	$.ajax({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
					url:"{{url('check_existing_email')}}",
					type:'POST',
					data:{uemail:uemail},
				error:function(){
				// alert('Please Sign Up First');
				},
				success:function(response)
				{
					if(response == 0)
					{


						$('#login_step_1').show();
						$('#login_popup').show();
						$('#login_new_error').html("New User");
					}

					else
					{
						$('#login_step_1').hide();
						$('#login_popup').hide();
						$('#login_verification_popup').show();
						lm_verification_timer(120);
						$('#go_back').hide();
						$('#sender_email').html(uemail);
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
								// alert('Please Check Your mail for OTP.');

							}
							});
					}
				}
				});
});
});
</script>


<script>
	$(document).on('click','#reset_create_pass_sub',function(){
		event.preventDefault();
		$('#login_popup').hide();
		var otp = $('#otp').val();
		var uemail = $('#uemail').val();
		var password = $('#reset_password_input').val();
		var cpassword = $('#reset_password_confirmation').val();
		$.ajax({
		headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('reset_password')}}",
        			type:'post',
        			data:{uemail:uemail,otp:otp,password:password,cpassword:cpassword},
       			 error:function(response){
            	// alert(response);
        		},
				success:function(response)
				{
						if(response == "password_error")
						{
							$('#password_match_error').html("Error: Password do not match");
						}


							if(response.popup == "popup_2")
							{
								$('#login_popup').hide();
								$('#login_otp_popup').hide();
								$('#login_verification_popup').hide();
								$('#reset_create_password').hide();
								$('#login_basicinfo_popup').show();
								$('#login_userid').val(response.userid);
							}
							else if(response.popup == "popup_3")
							{
								$('#login_popup').hide();
								$('#login_otp_popup').hide();
								$('#login_verification_popup').hide();
								$('#login_basicinfo_popup').hide();
								$('#reset_create_password').hide();
								$('#login_profile_popup').show();
								$('#login_userid').val(response.userid);

							}
							else if(response.popup == "popup_4")
							{
								location.href = "{{url('dashboard')}}";
							}

				}
		});

	});
</script>

<script>
	$(document).ready(function(){
	 $(document).on('click','#submit_login_profile', function(){
			   var f_name = $('#f_name').val();
			   var l_name = $('#l_name').val();
			   if(f_name == "" || l_name == "")
			   {
				   $('#required_name').show();
			   }
			   var dob = $('#dob').val();
			   var p_location = $('#p_location').val();
			   var height = $('#height').val();
			   var Weight = $('#Weight').val();
			   var nation = $('#nation').val();
			   var bio = $('#bio').val();
			   var termsofuse = $('#termsofuse').val();
			//    alert(termsofuse)
				if(termsofuse == '0')
			   {
				$('#terms_error1').html('Please Check Terms of Use');
			   }
			   var userid = $('#login_userid').val();
			   if(termsofuse == '1' && f_name != "" && l_name != "")
			   {
			   $.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				  url:"{{url('updatProfile')}}",
        			type:'post',
        			data:{userid:userid,f_name:f_name,l_name:l_name,dob:dob,p_location:p_location,height:height,Weight:Weight,nation:nation,bio:bio,termsofuse:termsofuse},
       			 error:function(){
            	alert('Something is Wrong');
        		},
				success:function(response)
				{
					if(response == 1)
					{
						$('#login_popup').hide();
					$('#login_basicinfo_popup').hide();
					$('#login_profile_popup').show();

					}
					else
					{
						$('#required_name').show();
					}

				}

			   });
			}
			});
		});
	</script>
<script>
function handleClicklogin(myRadio) {
var selectedValue = myRadio.value;
var userid = $('#login_userid').val();
// alert(selectedValue);
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
						location.href ="{{url('team')}}";

					}
					if(selectedValue==4)
					{
						location.href = "{{url('competition')}}";

					}
				}
});


};
</script>

<script>
	 $("#reset_password_input").keyup(function(){
	validatePassword();
  function validatePassword() {

 	var pass = $("#reset_password_input").val();
		if(pass != "") {

		if(pass.length <= 6) {
			$("#strength").html("Password Strength: Very Weak");
		}

		if(pass.length > 6 && (pass.match(/[a-z]/) || pass.match(/\d+/)
		|| pass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))){
			$("#strength").html("Password Strength: Weak");
		}

		if(pass.length > 6 && ((pass.match(/[a-z]/) && pass.match(/\d+/))
		|| (pass.match(/\d+/) && pass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (pass.match(/[a-z]/) && pass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))) {
			$("#strength").html("Password Strength:Good");
		}

		if(pass.length > 6 && pass.match(/[a-z]/) && pass.match(/\d+/)
		&& pass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) {
			$("#strength").html("Password Strength: Strong");
		}

		}
		}
	 });
</script>
