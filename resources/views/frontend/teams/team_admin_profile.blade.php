@include('frontend.includes.header')
        <div class="Competitionn-Page-Additional">
            @livewire('playerprofile.edit-player-banner',['player' => $user_info->id])
        <div class="dashboard-profile ">
            <div class="container-lg">
                <div class="row bg-white">
                    <div class="col-sm-12 position-relative">
                            @livewire('playerprofile.edit-player-logo', ['player' => $user_info->id])
                        <div class="user-profile-detail float-start w-auto">
                            <h1><strong>{{$user_info->first_name}}</strong> {{$user_info->last_name}}</h1>
                            <div class="d-flexCT">
                                <p class="Font-weight ">
                                    <span><i class="fa-flag"> <span class="CountryStat "> COUNTRY</span></i><br><span
                                            class="Player-Profile">{{$user_info->nationality}}</span> </span>

                                </p>
                                <p class="LeftSpace Font-weight ">
                                    <span><i class="fa-users">
                                        <span class="CountryStat"> TEAM</span></i><br>
                                        <span class="Player-Profile">{{$team->name}}</span> </span>
                                </p>
                            </div>
                        </div>
                        @livewire('player-addfriend-follow', ['user' => $user_info])
                    </div>
                </div>
            </div>
        </div>

		</div>
    <main id="main" class="dashboard-wrap Player-public-pro">
        <div class="container-lg">
            <div class="row AboutMe">
                <div class="col-md-2  pr-0 pMob">
                    <div class="box1">
                    <span class="Height">HEIGHT</span>
                        <p class="fitIn"><span class="FiveFt">@if($user_info->height == Null) -- @else {{$d_feet}}</span>ft<span class="FiveFt">{{$d_in}} </span>in @endif</p>
                        <span class="meterH">/@if($user_info->height == Null) -- @else{{$user_info->height}} cms @endif</span>
                    </div>
                </div>
                <div class="col-md-2 p-0 pMob">
                    <div class="box2">
                        <span class="Height">WEIGHT</span>
                        <p class="fitIn"><span class="FiveFt">@if($user_info->weight == Null) -- @else {{$weight_lbs}} @endif</span>lbs</p>
                        <span class="meterH">/@if($user_info->weight == Null) -- @else{{$user_info->weight}}Kg @endif</span>
                    </div>
                </div>
                <div class="col-md-2 p-0 pMob Res-600">
                    <div class="box3">
                        <span class="Height">AGE / D.O.B</span>
                        <p class="fitIn"><span class="FiveFt">@if($user_info->dob == Null) -- @else {{$age}} @endif</span>yrs</p>
                        @if($user_info->dob == Null) -- @else {{date('d M Y', strtotime($user_info->dob))}} @endif
                    </div>
                </div>
                <div class="col-md-6 pl-0 plMob-12">
                    <div class="box4">
                        <div class="LeoMessi">{!! $user_info->bio !!}</div>
                        <div class="AboutME">ABOUT&nbsp;&nbsp;ME</div>
                    </div>
                </div>

            </div>

            <div class="row M-topSpace">
                <div class="col-md-8 col-lg-8">
                    
                    <div class="col-md-12 col-lg-12">
                        @if(Auth::user()->id == $user_info->id) 
                            <span> <a data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor:pointer;"><span class="fa-plus"> </span></a> </span> 
                            @if(count($trophy_cabinets) == 0)
                                <h1 class="Poppins-Fs30">Trophy Cabinet <button class="btn fs1 float-end"></button></h1>
                            @else
                            @endif
                        @else
                        @endif
                        @if(count($trophy_cabinets) != 0)
                            <h1 class="Poppins-Fs30">Trophy Cabinet <button class="btn fs1 float-end"></button></h1>
                            <div class="box-outer-lightpink">
                                <div class="row">
                                    @foreach($trophy_cabinets as $trophy_cabinet)
                                        <div class="col-md-6 w-100-768 ">
                                            <div class="row InsideSpace">
                                                <div class="col-md-3 col-3 ">
                                                    <div class="BestFifa">
                                                        <?php
                                                            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                                                                    $url = "https://";   
                                                                else  
                                                                    $url = "http://";   
                                                                // Append the host(domain name, ip) to the URL.   
                                                                $url.= $_SERVER['HTTP_HOST']; 
                                                                
                                                            $trophyimage = $url."/storage/app/public/image/".$trophy_cabinet->trophy_image;
                                                        ?>
                                                        <img class="img-fluid" src="{{$trophyimage}}" width="">
                                                    </div>
                                                </div>
                                                <?php $years = explode(',', $trophy_cabinet->year);
                                                    $count = count($years); ?>
                                                <div class="col-md-9 col-9 BestFifaStyle" >
                                                
                                                    <p class="BestMenFifa">{{$trophy_cabinet->title}}</p>
                                                    <p ><div class="multiply">×{{$count}}</div> <span class="NATeam">Year {{$trophy_cabinet->year}}</span></p>
                                                    <p class="NATeam">Team: {{$trophy_cabinet->team}}</p>
                                                    <p class="NATeam">Comp: {{$trophy_cabinet->comp}}</p>
                                                    @if(Auth::user()->id == $user_info->id) 
                                                        <a style="cursor:pointer;" href="{{url('deleteplayertrophycabinet/'.$trophy_cabinet->id)}}" onclick="return confirm('Are you sure you want to delete this Record?')"><i class="icon-trash "></i></a>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                        @endif
                    </div>
                </div>
                @livewire('playerprofile.add-edit-youtubevideo',['player' => $user_info->id])
                @livewireScripts
            </div>
        </div>
    </main>

<!-- The  Add Trophy cabinate model-->
<div class="modal fade myModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Trophy Cabinet</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{url('addplayertrophycabinet')}}" enctype="multipart/form-data" id="first_form">
					@csrf
						@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong>Something went wrong.<br><br>
							<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
							</ul>
						</div>
						@endif
					<div class="row">
						<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
							<div class="floating-form ">
								<input type="hidden" name="player_id" value="{{$user_info->id}}">
								<div class="floating-label form-select-fancy-1">      
									<input class="floating-input" type="text" id="title" name="title" value="">
									<span class="highlight"></span>
									<label>Title</label>
								</div>
							</div>	
						</div>
						<?php $currentyear = date('Y'); ?>
						<div class=" col-md-12 mb-4 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">
								<select class="form-control" id="mySelect2" name="years[]" multiple="multiple">
									@for($i=1985; $i <= $currentyear; $i++)
										<option value="{{ $i }}">{{ $i }}</option>
									@endfor
								</select>
								</div>
							</div>
						</div>
						<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">      
									<input class="floating-input" type="text" id="team" name="team">
									<span class="highlight"></span>
									<label>Team</label>
								</div>
							</div>	
						</div>
						<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">      
									<input class="floating-input" type="text" id="competition" name="competition">
									<span class="highlight"></span>
									<label>Competition</label>
								</div>
							</div>	
						</div>
						<div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
							<div class="floating-form ">
								<div class="floating-label form-select-fancy-1">      
									<input class="floating-input" type="file" id="imgInp" name="trophy_image">
									<span class="highlight"></span>
									<label>Trophy Image</label>
								</div>
							</div>
							<img style="visibility:hidden"  id="prview" src=""  width=100 height=100 />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
        @include('frontend.includes.footer')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{url('frontend/js/script.js')}}"></script>
		<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
		<script src="{{url('frotnend/js/main.js')}}"></script>
        <script type="text/javascript">
            let items = document.querySelectorAll('.teamcarousel .carousel-item')
            items.forEach((el) => {
                const minPerSlide = 1
                let next = el.nextElementSibling
                for (var i = 1; i < minPerSlide; i++) {
                    if (!next) {
                        // wrap carousel by using first child
                        next = items[0]
                    }
                    let cloneChild = next.cloneNode(true)
                    el.appendChild(cloneChild.children[0])
                    next = next.nextElementSibling
                }
            })

        </script>

        <script type="text/javascript">
            $(' .owl_1').owlCarousel({
                loop: true,
                margin: 2,
                responsiveClass: true, autoplayHoverPause: true,
                autoplay: false,
                slideSpeed: 100,
                paginationSpeed: 400,
                autoplayTimeout: 3000,
                responsive: {
                    0: {
                        items: 5,
                        nav: true,
                        loop: false
                    },
                    600: {
                        items: 8,
                        nav: true,

                        loop: false
                    },
                    1000: {
                        items: 12,
                        nav: true,

                        loop: false
                    }

                }
            })

            $(document).ready(function () {
                var li = $(".owl-item li ");
                $(".owl-item li").click(function () {
                    li.removeClass('active');
                });
            });
        </script>
        <script type="text/javascript">
    $('#mySelect2').select2({
        dropdownParent: $('.myModal'),
		placeholder: 'Select year',
    });

 imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    prview.style.visibility = 'visible';

    prview.src = URL.createObjectURL(file)
  }
}

img.onchange = evt => {
  const [file] = img.files
  if (file) {
    prview1.style.visibility = 'visible';

    prview1.src = URL.createObjectURL(file)
  }
}
</script>
</body>

</html>