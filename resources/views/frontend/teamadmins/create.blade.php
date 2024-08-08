@include('frontend.includes.header')

	<div class="header-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span> Create  <strong> Your Profile</strong></h1>
				</div>
			</div>
		</div>
	</div>

<main id="main">
	<div class="container">
        <div class="row">
           <div class="col-lg-7 col-md-6 pe-0 py-5 col-sm-3 mx-auto ">
		  <form method="POST" action="{{url('teamadmin_store')}}" enctype="multipart/form-data">
            @csrf
                <input type="hidden" value="{{$data->id}}" name="id">
			<div class="create-profile shadow px-4 py-4" id="player-profile">


				<div class="row mb-3">
                                    <!-- <div class="col-md-12"><label class="" for="profile_type">Profile Type</label>
                                        <select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="profile_type" id="profile_type">
                                            <option value="0" selected="selected">Profile-Type</option>
                                            @foreach($uprofiletype as $upt)
                                            <option value="{{$upt->id}}">{{$upt->name}}</option>
                                            @endforeach
                                        </select>

                                    </div> -->
                                </div>

				  <div class="row mb-3">
					<div class="col-md-6">
							<label class="" for="first_name">Your Name</label>
							<input type="text" class="grey-form-control  input-sm" placeholder="Name" id="first_name" name="first_name" value="{{$data['first_name']}}">
					</div>
					<div class="col-md-6">

						 <label class="" for="browse_image">Profile Picture</label><input type="file" class="grey-form-control browse-control input-sm" placeholder="Profile Picture" id="profile_pic" name="profile_pic">

					</div>
					</div>

					 <div class="row mb-3">
					<div class=" col-lg-12">
                                        <label class="" for="bio">Your Bio</label><textarea rows="5" type="text" class="grey-form-textarea  input-sm" placeholder="Bio" id="bio" name="bio">{{$data['bio']}}</textarea>
                                    </div>

					</div>
					 <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="" for="height">Height</label>
                                        <input type="text" class="grey-form-control  input-sm" placeholder="Your Height" id="height" name="height" value="{{$data['height']}}">


                                    </div>
                                    <div class="col-md-6">

                                        <label class="" for="weight">Weight</label>
                                        <input type="text" class="grey-form-control  input-sm" placeholder="Your Weight" id="weight" name="weight" value="{{$data['weight']}}">


                                    </div>
                                </div>
					<div class="row mb-3">
					<div class="row mb-3">
                                    <div class="col-md-6"><label class="" for="nationality">Nationality</label>
                                         <select class="form-control" name="nationality"  id="nationality" type="text" class="block mt-1 w-full" value="{{$data['nationality']}}">
					                        <option value="" selected="selected">Select Nationality</option>
					                                   @foreach($countries as $c)
					                        <option value="{{$c->name}}">{{$c->name}}</option>
					                                     @endforeach
					                      </select>

                                        {{-- <input type="text" class="grey-form-control  input-sm" placeholder="Nationality" id="nationality" name="nationality" value="{{$data['nationality']}}"> --}}

                                    </div>
                                    <div class="col-md-6"><label class="" for="location">Location/City</label>
                                        <div class="input-group">

                                            <input type="text" class="form-control grey-bg  input-sm" placeholder="Your Location/City" id="location" name="location" value="{{$data['location']}}">
                                            <span class="input-group-text apicon"><i class="icon-map-marker"></i></span>
                                        </div>

                                    </div>
                    </div>
			<div class="row">
				<div class="col-lg-12 heading-grey">
					<h4>Team creation</h4>
				</div>
			</div>
            <div class="row mb-3">
                                    <div class="col-md-12"><label class="" for="nationality">Sports</label>
                                         <select class="form-control" name="sport"  id="sports" type="text" class="block mt-1 w-full">
					                        <option value="0" selected="selected">Select Sports</option>
					                                 @foreach($sports as $s)
					                        <option value="{{$s->id}}">{{$s->name}}</option>
					                                 @endforeach
					                      </select>

                                    </div>
                    </div>
			{{-- <div class="competition-list mb-3">
				<ul class="games-list owl-4-slider owl-carousel">
					<li class="item"><input type="radio" name="competition" value="soccer" checked id="soccer" onclick="divshowhide()"> <label for="competition">Soccer</label><i class="icon-check checked-badge"></i></li>
					<li class="item"><input type="radio" name="competition" value="Basketball" id="Basketball" onclick="divshowhide()"> <label for="competition">Basketball</label><i class="icon-check checked-badge"></i></li>
					<li class="item"><input type="radio" name="competition" value="Cricket" id="Cricket" onclick="divshowhide()"> <label for="competition">Cricket</label><i class="icon-check checked-badge"></i></li>
					<li class="item"><input type="radio" name="competition" value="Volleyball" id="Volleyball" onclick="divshowhide()"> <label for="competition">Volleyball</label><i class="icon-check checked-badge"></i></li>
					<li class="item"><input type="radio" name="competition" value="Rugby" id="Rugby" onclick="divshowhide()"> <label for="competition">Rugby</label><i class="icon-check checked-badge"></i></li>
					<li class="item"><input type="radio" name="competition" value="Hockey" id="Hockey" onclick="divshowhide()"> <label for="competition">Hockey</label><i class="icon-check checked-badge"></i></li>
				</ul>
			</div> --}}
			<div class="soccer-form-data me-0 selectt" id="soccer-form1">
					<div class="row mb-3">
					<div class=" col-md-6">
                       <label class="visually-hidden" for="name">Team Name</label><input type="text" class="grey-form-control input-sm" placeholder="Team Name" id="name" name="name"> </div>
					   <div class=" col-md-6">
					   <label class="visually-hidden" for="image">Drag and Drop or Browse</label><input type="file" class="grey-form-control browse-control input-sm" placeholder="Drag and Drop or Browse" id="image" name="image">
                       </div>
                   </div>
				    <div class="row mb-3">
					<div class=" col-lg-12">
					<div class="input-group">
							<input type="text" class="form-control grey-bg  input-sm" placeholder="Montreal, QC Canada" id="location" name="location">
							<span class="input-group-text apicon"><i class="icon-map-marker"></i></span>
                       </div>
					</div>

					</div>
					<div class="row mb-3">
					<!-- {{-- <div class=" col-lg-12">
					   <label class="visually-hidden" for="a_teamadmin">Assign Team Admins</label><input type="text" class="grey-form-control  input-sm" placeholder="Assign Team Admins" id="a_teamadmin" name="a_teamadmin">
					   <i class="circle-badge">6</i>
                       </div>


					</div> --}} -->
					 <div class="row mb-3">
					<!-- {{-- <div class=" col-lg-12">
					   <label class="visually-hidden" for="invite_players">Invite Players To Team</label><input type="text" class="grey-form-control  input-sm" placeholder="Invite Players To Team" id="players" name="players">
					   <i class="circle-badge">12</i>
                       </div>

					</div> --}} -->
                    <div class=" col-lg-12">
					   <label for="invite_players" class="form-label select-label">Invite Players To Team</label>
                      <select class="select  " name="member_id[]"  id="players" multiple="multiple" class="block mt-1 w-full">
					         <option value="0" selected="selected">Select Player</option>
					               @foreach($fv_player as $p)
					         <option value="{{$p->id}}">{{$p->first_name}}</option>
					               @endforeach
					 </select>

					</div>
					<hr/>
			      </div>

					<div class="row mb-3" id="multi-select-boxes">
						<div class="col-md-6" >
							<label for="fvt_plyr" class="form-label select-label">Select Favourite Player</label>
							<select class="select  " multiple name="fav_player[]" id="example-getting-started" >
							   <option value="0" selected="selected">Select Fav Player</option>
					               @foreach($fv_player as $ufp)
					           <option value="{{$ufp->id}}">{{$ufp->first_name}}</option>
					               @endforeach
							</select>

						</div>
						<div class="col-md-6">
							<label class="form-label select-label" for="fvt_team">Select Favourite Team</label>
							<select class="select  " multiple name="fav_team[]" id="fvt_team" >
							  <option value="" selected="selected">Select Fav Team</option>
					                @foreach($teams as $ft)
					          <option value="{{$ft->id}}">{{$ft->name}}</option>
					                 @endforeach
							</select>
						</div>
					</div>
					<div class="row mb-3" id="multi-select-boxes">
						<div class="col-md-6" >
							<label for="select_competition" class="form-label select-label">Select Competittions</label>
							<select class="select  " multiple name="fav_comp[]" id="select_competition" >
							  <option value="" selected="selected">Select Fav Comp</option>
					                @foreach($competitions as $ufc)
					          <option value="{{$ufc->id}}">{{$ufc->name}}</option>
					                @endforeach
							</select>

						</div>
                        <div class="col-md-6" >
							<label for="select_friend" class="form-label select-label">Add Friends</label>
							<select class="select  " multiple name="friend[]" id="select_friend" >
							  <option value="" selected="selected">Add Friend</option>
					                @foreach($fv_player as $fr)
					          <option value="{{$fr->id}}">{{$fr->first_name}}</option>
					                @endforeach
							</select>

						</div>

 						<!-- <div class="col-md-6">
							<label for="fvt_plyr" class="form-label select-label">Add Friends</label>
							<span class="multiselect-native-select">
								<select class="select  " multiple="" name="friend[]" id="example-getting-started">
							   <option value="0" selected="selected">Add Friend</option>
						               					           @foreach($fv_player as $fr)
					          <option value="{{$fr->id}}">{{$fr->first_name}}</option>
					                @endforeach
						        </select></span>

						</div> -->
					</div>
					{{-- <div class=" gap-2 mt-3 text-end">

					  <button type="button" id="nextBtn" class="btn btn-submit input-lg" >Save</button>

				  </div> --}}
                  <div class="flex items-center justify-end mt-4">

                                    <x-button class="btn btn-submit input-lg">
                                        {{ __('Submit') }}
                                    </x-button>
                                </div>
			</div>
			</form>
		   </div>

		</div>
	</main>
<footer class="footer-section">
 <div class="container">
        <div class="row">

           <div class="col-lg-2 col-md-6 footer-links">
            <h4>Host Your Sport</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Soccer</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Cricket</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Hockey</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Basketball</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Rugby</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Volleyball</a></li>
			  <hr>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Suggest a Sport</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Manage</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Your Sports Profile</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Your Team</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">The Competitions</a></li>
			</ul>
			<br>
			<h4>Find</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">The right team</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">The Prime Players</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>About us</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Our Story</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">The Team</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Why Sports</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Partnerships</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Our Support</a></li>
			  <hr>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Our Investors</a></li>
            </ul>
          </div>

          <div class="col-lg-6 col-md-6 widgets">
           <div><form>
			   <div class="input-group">
					  <input type="email" class="form-control" placeholder="Email or Phone Number" name="email">
					  <div class="input-group-btn ">
						<button class="btn btn-submit-group" type="submit">Join Now</button>
					  </div>
					</div>
		   </form>
            </div>
			<div class="social-chat">
				<span class="letschat">Lets Chat: <a href="" alt="" title="letschat">hi@sportvote.org</a>     </span>
				<ul class="social_icons"><li>Follow Us:</li><li><a href="#" title="facebook"><i class="icons icon-fb"></i></a></li><li><a href="#" title="twitter"><i class="icons icon-tw"></i></a></li><li><a href="#" title="linkedin"><i class="icons icon-li"></i></a></li><li><a href="#" title="Instagram"><i class="icons icon-insta"></i></a></li></ul>
				<div class="clearfix"></div>
			</div>
          </div>
		  </div>
		  <div class="row ">
			<div class="col-lg-12 text-center copyright">
				Copyright 2021. All rights for Sportvote logo, marketing content & marketing graphics are reserved to Sportvote Inc.
			</div>
		  </div>
		  </div>

</footer>
  <script src="frontend/js/jquery-3.3.1.min.js"></script>
  <script src="frontend/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="frontend/js/jquery-ui.js"></script>
  <script src="frontend/js/popper.min.js"></script>
  <script src="frontend/js/bootstrap.min.js"></script>

  <script src="frontend/js/jquery.easing.1.3.js"></script>
  <script src="frontend/js/aos.js"></script>
   <script src="frontend/js/script.js"></script>

<script src="frontend/js/owl.carousel.min.js"></script>
  <script src="frontend/js/main.js"></script>
  <script type="text/javascript" src="frontend/assets/js/bootstrap-multiselect.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#example-getting-started').multiselect({

		buttonWidth: '100%'});
		$('#fvt_team').multiselect({

		buttonWidth: '100%'});
		$('#select_competition').multiselect({

		buttonWidth: '100%'});
		$('#select_friend').multiselect({

        buttonWidth: '100%'});
		$('#players').multiselect({


		buttonWidth: '100%'});
    });
</script>
<script type="text/javascript">
        // add row
        $(".addRow").click(function () {
            var html = '';
            html += '<div class="row mb-3 user_data">';
            html += '<div class="col-md-12 mb-3"><label class="" for="search_sport">SEARCH based on SPORTs in PROFILE</label><input type="text" class="grey-form-control  input-sm" id="search_sport" name="search_sport"></div><div class="col-md-12"><label class="" for="join_reason">Reason why you want to join</label><textarea rows="2" maxlength="200" class="grey-form-textarea  input-sm" placeholder="Enter here..."  id="join_reason" name="join_reason"></textarea></div>';

            html += '<div class="col-md-12"><button  type="button" class="removeRow float-md-start btn btn-danger ">&times;</button></div>';
            html += '</div>';

            $('.newRow').append(html);
        });

        // remove row
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.user_data').remove();
        });
</script>

</body>

</html>
