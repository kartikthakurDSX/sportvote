@include('frontend.includes.header')
<!-- calendar css -->
<style type="text/css">
	.page-item:last-child .page-link {
     border-top-right-radius: 0px; 
     border-bottom-right-radius: 0px; 
}
.page-item:first-child .page-link {
     border-top-left-radius: 0px; 
     border-bottom-left-radius: 0px; 
}
.bg-Crou {
    background-color: #979797;
    margin: 0;
    width: 2%;
}
.p-TBLR {
    padding: 0px 2px;
    line-height: normal;
}
.owl-nav {
    display: none;
}
.owl-theme .owl-dots, .owl-theme .owl-nav {
    text-align: left;
    -webkit-tap-highlight-color: transparent;
}
.owl-theme .owl-dots .owl-dot span {
   position: relative;
    border-radius: 100%;
    display: block;
    text-decoration: none;
    background-color: #397fac;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    padding: 5px;
    width: 7px;
    height: 7px;
    margin-right: 5px;
    border: 7px solid rgba(253,250,250,0);
    box-shadow: 0 0 0 0 #397fac;
    transform: scale(0.3);
}
.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
    position: relative;
    border-radius: 100%;
    display: block;
    text-decoration: none;
    background-color: #397fac;
    transform: scale(1);
    padding: 5px;
    width: 7px;
    height: 7px;
    border: 7px solid #fff;
    position: relative;
    border-radius: 100%;
    display: block;
    box-shadow: 0 0 0 1px #397fac;
}
.player-jersy-list:hover{
    background: unset;
}
.FootRFix{
	position: relative;
	left: 36px;
}
.triangle{
	width: 100%;
   	width: 0;
    height: 0;
    border-width: 0 100px 100px 100px;
    border-color: transparent transparent #FF0000 transparent;
    border-style: solid;
}
.nav-pills .triangle.active, .nav-pills .show>.triangle
{
   
   /*width: 0;
    height: 0;
    border-width: 0 100px 100px 100px;
    border-color: transparent transparent #FF0000 transparent;
    border-style: solid;*/
}
#pills-tabContent1 .active {
	position: relative;
	
}
#pills-tabContent1 .active:after, #pills-tabContent .active:before {
	bottom: 100%;
	left: 60%;
	border: 1px solid #f00;
	content: " ";
	height: 0;
	width: 0;
	top: 30%;
	position: absolute;
	pointer-events: none;
}

#pills-tabContent1 .active:after {
	border-color: rgba(241, 241, 241, 0);
	border-bottom-color: #fdfafa;
	border-width: 20px;
	margin-left: -20px;
}
#pills-tabContent1 .active:before {
	border-color: #fdfafa;
	border-bottom-color: #fdfafa;
	border-width: 27px;
	margin-left: -27px;
}
/*Second*/
#pills-tabContent2 .active {
	position: relative;
	
}
#pills-tabContent2 .active:after, #pills-tabContent .active:before {
	bottom: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	top: 30%;
	position: absolute;
	pointer-events: none;
}

#pills-tabContent2 .active:after {
	border-color: rgba(241, 241, 241, 0);
	border-bottom-color: #fdfafa;
	border-width: 20px;
	margin-left: -20px;
}
#pills-tabContent2 .active:before {
	border-color: #fdfafa;
	border-bottom-color: #fdfafa;
	border-width: 27px;
	margin-left: -27px;
}
/*Third*/
#pills-tabContent3 .active {
	position: relative;
	
}
#pills-tabContent3 .active:after, #pills-tabContent .active:before {
	bottom: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	top: 30%;
	position: absolute;
	pointer-events: none;
}

#pills-tabContent3 .active:after {
	border-color: rgba(241, 241, 241, 0);
	border-bottom-color: #fdfafa;
	border-width: 20px;
	margin-left: -20px;
}
#pills-tabContent3 .active:before {
	border-color: #fdfafa;
	border-bottom-color: #fdfafa;
	border-width: 27px;
	margin-left: -27px;
}
/*Fourth*/
#pills-tabContent4 .active {
	position: relative;
	
}
#pills-tabContent4 .active:after, #pills-tabContent .active:before {
	bottom: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	top: 30%;
	position: absolute;
	pointer-events: none;
}

#pills-tabContent4 .active:after {
	border-color: rgba(241, 241, 241, 0);
	border-bottom-color: #fdfafa;
	border-width: 20px;
	margin-left: -20px;
}
#pills-tabContent4 .active:before {
	border-color: #fdfafa;
	border-bottom-color: #fdfafa;
	border-width: 27px;
	margin-left: -27px;
}
/*Fifth*/
#pills-tabContent5 .active {
	position: relative;
	
}
#pills-tabContent5 .active:after, #pills-tabContent .active:before {
	bottom: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	top: 30%;
	position: absolute;
	pointer-events: none;
}

#pills-tabContent5 .active:after {
	border-color: rgba(241, 241, 241, 0);
	border-bottom-color: #fdfafa;
	border-width: 20px;
	margin-left: -20px;
}
#pills-tabContent5 .active:before {
	border-color: #fdfafa;
	border-bottom-color: #fdfafa;
	border-width: 27px;
	margin-left: -27px;
}



/*Fixture css*/
      .Team-Fixture .owl-nav {
      display: block;
      }
      .Team-Fixture .owl-prev {
      position: absolute;
      left: 0;
      top: 0;
      }
      .Team-Fixture .owl-next {
      position: absolute;
      right:  0;
      top: 0;
      }
      .Team-Fixture .owl-dots {
      display: none;
      }
      .Team-Fixture .nav-tabs {
      border-bottom: 0px solid #dee2e6;
      width: 100%;
      }
      .Team-Fixture .owl-carousel.owl-drag .owl-item {
      margin-right:  0px !important;
      text-align: center;
      }
      .Team-Fixture .item li a {
      color: #003b5f;
      font-size: 16px;
      font-weight: 600;
      font-size: 16px;
      font-weight: 600;
      }
      .Team-Fixture .item li.active  {
      background-color: #ee314e;
      border-color: #ee314e;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      }
      
      .Team-Fixture .item .active a{
      color: #fff;
      }
      .Team-Fixture .item li  {
      background: #e2e4e7;
      color: #003b5f;
      font-size: 16px;
      font-weight: 600;
      }
      .Team-Fixture .owl-theme .owl-nav  .owl-prev::before {
      content: " \f104";
      font-size:20px;
      font-family: 'icomoon' !important;
      }
      .Team-Fixture .owl-theme .owl-nav  .owl-next::before {
      content: " \f105 ";
      font-family: 'icomoon' !important;
      font-size:20px;
      }
      .Team-Fixture .owl-theme .owl-nav  .owl-prev, .owl-theme .owl-nav  .owl-next{
      font-size:0px !important;
      padding: 6px 5px;
      margin: 0;
      background: #979797;
      }
      .Team-Fixture .tab-content>.active {
      display: contents;
      }
	  .team-jersyTeam-right:after, .team-jersy-right:after{
		color:<?php echo $team->team_color; ?> !important;

	  }
</style>
	@livewire('team.edit-team-banner', ['team' => $team->id])
	<div class="dashboard-profile ">
		<div class="container-lg">
			<div class="row bg-white">
				<div class="col-md-12  position-relative">
				@livewire('team.edit-team-logo', ['team' => $team->sport_id])
					<div class="user-profile-detail-Team float-start w-auto">
					
					<h5 class="SocerLegSty" ><span class="header_gameTeam" style="background-color:<?php echo $team->team_color; ?>">@if($team->sport_level_id)
						<?php $level = App\Models\Sport_level::find($team->sport_level_id); ?>
						<?php $sport = App\Models\Sport::find($team->sport_id); ?> {{$level->name}} {{$sport->name}} Team @else --  @endif </span> in @if($team->location) {{$team->location}} @else -- @endif<br><strong>Managed by: </strong>{{$team_owner->first_name}}</h5>
						
						

						
					</div>
					
					@livewire('team-follow', ['team' => $team])
				</div>
				
			</div>
		</div>
	</div>


<main id="main" class="dashboard-wrap">
	<div class="container-fluid bg-GraySquad">
		<div class="container-lg">
			<div class="row AboutMe">
			<div class="col-md-1 col-12 resMob pr-0">
				<div class="boxSuad">
					<span class="SquadCS">SQUAD</span>
					<p class="fitIn"><span class="FiveFt">0</span></p>
					
				</div>
			</div>
			<div class="col-md-2 p-0">
				<div class="NAtionPLAyer">
					<span class="SquadCS">NATIONAL PLAYERS</span>
					<p class="fitIn"><span class="FiveFt">0</span><span class="SlePer">/0%</span></p>
					
				</div>
			</div>
			<div class="col-md-2 p-0">
				<div class="ForeginPlayer">
					<span class="SquadCS">FOREIGN PLAYERS</span>
					<p class="fitIn"><span class="FiveFt">0</span><span class="SlePer">/0%</span></p>
					
				</div>
			</div>
			<div class="col-md-1 p-0">
				<div class="NAtionPLAyer">
					<span class="SquadCS">AVERAGE AGE</span>
					<p class="fitIn"><span class="FiveFt">0.0</span></p>
					
				</div>
			</div>
			<div class="col-md-3 pl-0" >
				<span class="jersy-noTeam team-jersyTeam-right">0</span>

				<div class="TimmyImg">

					<img src="{{url('frontend/profile_pic/default_profile_pic.png')}}" width="100%" class="img-fluid RadiousBorder" alt="profle-image">
					
				</div>
				<div class="PSpacng ">
					<div class="dropdown ">
						  <button class="btn btn-secondaryNeW dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						    TOP SCORER
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						    <li><a class="dropdown-item" href="#">Action</a></li>
						    <li><a class="dropdown-item" href="#">Another action</a></li>
						    <li><a class="dropdown-item" href="#">Something else here</a></li>
						  </ul>
					</div>
					<span class="TimmJone">Player Name
						<p class="Spanish">Age | Location | Ht</p>
					</span>
				</div>
				
			</div>
			@livewire('team.addteam-sponsor')
			
		</div>
		</div>
		
	</div>

	<!-- <div class="container-lg">
		<div class="bottom-arrow">
 
 
</div>
	</div> -->
	<div class="container-lg">


		<div class="row M-topSpace">
			<div class="col-md-8 col-lg-8">

					@livewire('team-player', ['team' => $team])

				<h1>Fixture Calendar <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
				
				
				<div class="box-outer-lightpink">
					<table class="table TableFixtureCalndr ">
						<thead class="">
						
							<div class="">
								<div class=" text-center ">
									<div class=" text-center ">
							   
							    <div class="row mx-auto my-auto justify-content-center">
							        <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
							            <div class="carousel-inner" role="listbox">
							                <div class="carousel-item p-TBLR active">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                            
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 1</a></li>
													 </ul>


							                        </div>
							                    </div>
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                            
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 2</a></li>
													 </ul>
													
							                        </div>
							                    </div>
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                            
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 3</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                            
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 4</a></li>
													 </ul>
													
							                        </div>
							                    </div>
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 5</a></li>
													 </ul>
													
							                        </div>
							                    </div>
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 6</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 7</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                   
							                    
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 8</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                   
							                    
							                </div>
							                <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 9</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                   
							                    
							                </div>
							                 <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 1</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                   
							                    
							                </div>
							                 <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 1</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                   
							                    
							                </div>
							                 <div class="carousel-item p-TBLR">
							                    <div class="col-md-1">
							                        <div class="">
							                            
							                           
							                            	<ul class="pagination  ">
														    <li class="page-item"><a class="page-link" href="#">AUG 12</a></li>
													 </ul>
												
							                        </div>
							                    </div>
							                   
							                    
							                </div>
							            </div>
							            <a class="carousel-control-prev bg-Crou w-aut" href="#recipeCarousel" role="button" data-bs-slide="prev">
							                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
							            </a>
							            <a class="carousel-control-next bg-Crou w-aut" href="#recipeCarousel" role="button" data-bs-slide="next">
							                <span class="carousel-control-next-icon" aria-hidden="true"></span>
							            </a>
							        </div>
							    </div>
							   
							</div>
							   
							    
							   
							</div>
								
							</div>
					</thead>
					<tbody >
						<tr >
							<td class="FaCupClor">
								- -
							</td>
							<td class="RightPosiText">
								<b class="WolVerWand">- - ...</b><span class=""><img src="{{url('frontend/images/icon.png')}}" ></span>
							</td>
							<td class="BtnCentr">
								<button class="btn btn-gray text-center btn-xs-nb">00:00</button>
							</td>
							<td>
								<span class=""><img src="{{url('frontend/images/kanno-icon.png')}}"class="me-2"></span><b class="WolVerWand">--</b>
							</td>
							<td>
								<span class="OnSun">On - </span><span class="Dec-DateFix">- -</span>
							</td>
							<td>
								<!-- <button class="btn btn-Mvp btn-xs-nb"><i class="fa-star"></i> MVP</button>  -->
								
							</td>
						</tr>
						<tr>
							<td class="FaCupClor">
								THE FA CUP
							</td>
							<td class="RightPosiText">
								<b class="WolVerWand">liveroll </b><span class=""><img src="{{url('frontend/images/icon.png')}}" ></span>
							</td>
							<td class="BtnCentr">
								<button class="btn btn-gray text-center btn-xs-nb">19:15</button>
							</td>
							<td>
								<span class=""><img src="{{url('frontend/images/kanno-icon.png')}}"class="me-2"></span><b class="WolVerWand">Arsenal</b>
							</td>
							<td>
								<span class="OnSun">On SUN </span><span class="Dec-DateFix">20rd JAN</span>
							</td>
							<td>
								<!-- <button class="btn btn-Mvp btn-xs-nb"><i class="fa-star"></i> MVP</button>  -->
								
							</td>
						</tr>
						<tr>
							<td class="FaCupClor">
								EFL CUP
							</td>
							<td class="RightPosiText">
								<b class="WolVerWand">Brentford </b><span class=""><img src="{{url('frontend/images/kanno-icon.png')}}" ></span>
							</td>
							<td class="BtnCentr">
								<span class=" btn-greenFXL ">3</span> 
								<span class=" btn-greenFXR ">5</span>  
							</td>
							<td>
								<span class=""><img src="{{url('frontend/images/kanno-icon.png')}}"class="me-2"></span><b class="WolVerWand">Arsenal</b>
							</td>
							<td>
								<span class="OnSun">On SUN </span><span class="Dec-DateFix">16rd JAN</span>
							</td>
							<td>
								<button class="btn btn-Mvp btn-xs-nb"><i class="fa-star"></i> MVP</button> 
								
							</td>
						</tr>
						<tr>
							<td class="FaCupClor">
								PREMIER LEAGUE
							</td>
							<td class="RightPosiText">
								<b class="WolVerWand">Arsenal </b><span class=""><img src="{{url('frontend/images/kanno-icon.png')}}" ></span>
							</td>
							<td class="BtnCentr">
								<span class=" btn-RedFXL ">2</span> 
								<span class=" btn-RedFXR ">3</span>  
							</td>
							<td>
								<span class=""><img src="{{url('frontend/images/kanno-icon.png')}}"class="me-2"></span><b class="WolVerWand">Arsenal</b>
							</td>
							<td>
								<span class="OnSun">On SUN </span><span class="Dec-DateFix">19rd JAN</span>
							</td>
							<td>
								<!-- <button class="btn btn-Mvp btn-xs-nb"><i class="fa-star"></i> MVP</button> --> 
								
							</td>
						</tr>
						<tr>
							<td class="FaCupClor">
								EFL CUP
							</td>
							<td class="RightPosiText">
								<b class="WolVerWand">Burney </b><span class=""><img src="{{url('frontend/images/kanno-icon.png')}}" ></span>
							</td>
							<td class="BtnCentr">
								<span class=" btn-GrayFXL ">2</span> 
								<span class=" btn-GrayFXR ">2</span>  
							</td>
							<td>
								<span class=""><img src="{{url('frontend/images/kanno-icon.png')}}"class="me-2"></span><b class="WolVerWand">Arsenal</b>
							</td>
							<td>
								<span class="OnSun">On SUN </span><span class="Dec-DateFix">05rd JAN</span>
							</td>
							<td>
								<button class="btn btn-Mvp btn-xs-nb"><i class="fa-star"></i> MVP</button> 
								
							</td>
						</tr>
						
					</tbody>
					</table>
					<nav aria-label="Page navigation" class="dots-paging">
					  <ul class="pagination">
						
						<li class="page-item"><a class="page-link" href="#"></a></li>
						<li class="page-item"><a class="page-link" href="#"></a></li>
						<li class="page-item"><a class="page-link active-dot" href="#"></a></li>
						<li class="page-item"><a class="page-link" href="#"></a></li>
						<li class="page-item"><a class="page-link" href="#"></a></li>
						<li class="page-item"><a class="page-link" href="#"></a></li>
					  </ul>
					</nav>  
				</div>
				<div class="col-md-12 col-lg-12">
					<h1>Trophy Cabinet <button class="btn fs1 float-end"></button></h1>
				
				
					<div class="box-outer-lightpink">
						<div class="row">
							<div class="col-md-6 col-6">
								<div class="row InsideSpace">
									<div class="col-md-3 ">
										<div class="BestFifa">
											<img src="{{url('frontend/images/best-fifa.png')}}" width="">
										</div>
									</div>
									<div class="col-md-9  BestFifaStyle" >
										<p class="BestMenFifa">The BEST FIFA MEN'S PLAYER</p>
										<p ><div class="multiply">×1</div> <span class="NATeam">Year 2019</span></p>
										<p class="NATeam">Team: N/A</p>
										<p class="NATeam">Comp: N/A</p>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-6">
								<div class="row InsideSpace">
									<div class="col-md-3 ">
										<div class="BestFifa">
											<img src="{{url('frontend/images/Winner.png')}}" width="">
										</div>
									</div>
									<div class="col-md-9  BestFifaStyle" >
										<p class="BestMenFifa">Winner Ballon d'Or</p>
										<p ><div class="multiply">×7</div> <span class="NATeam">Year 2017, 2018, 2019, 2020, 2021...</span></p>
										<p class="NATeam">Team: N/A</p>
										<p class="NATeam">Comp: N/A</p>
									</div>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6 col-6">
								<div class="row InsideSpace">
									<div class="col-md-3 ">
										<div class="BestFifa">
											<img src="{{url('frontend/images/UFA-Best.png')}}" width="">
										</div>
									</div>
									<div class="col-md-9  BestFifaStyle" >
										<p class="BestMenFifa">UFA BEST PLAYER IN EUROPE</p>
										<p ><div class="multiply">×3</div> <span class="NATeam">Year 2015, 2018, 2019</span></p>
										<p class="NATeam">Team: N/A</p>
										<p class="NATeam">Comp: N/A</p>
									</div>
								</div>
							</div>
							<!-- <div class="col-md-6 col-6">
								<div class="row InsideSpace">
									<div class="col-md-3 ">
										<div class="BestFifa">
											<img src="{{url('frontend/images/best-fifa.png')}}" width="">
										</div>
									</div>
									<div class="col-md-9  BestFifaStyle" >
										<p class="BestMenFifa">Winner Ballon d'Or</p>
										<p ><div class="multiply">×7</div> <span class="NATeam">Year 2017, 2018, 2019, 2020, 2021...</span></p>
										<p class="NATeam">Team: N/A</p>
										<p class="NATeam">Comp: N/A</p>
									</div>
								</div>
							</div> -->
						</div>
						
						  
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
			<!-- <h1>Top Performers <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1> -->
			<div class="box-outer-lightpink SocialList AboutSocalSec">
			@livewire('team.edit-about-us')
					
				</div>
				<hr>
				<div class=""><span><img src="{{url('frontend/images/AdminStar-icon.png')}}"></span> <span class="AboutStyleUs"> ADMINISTRATION</span>
					
				@livewire('team-adminstration', ['team' => $team])
				@livewireScripts
				
					
				</div>
				<hr>
				@livewire('team.addcommunity-sponsor')
				<hr>
				<div class=""><span><img src="{{url('frontend/images/twittter.png')}}"></span> <span class="AboutStyleUs"> @FC BARCELONA</span>
				 
					<p class="TextSocalInner">Barcelona manager Xavi: “Ousmane Dembélé will turn whistles into applause here at Camp Nou, I’m sure”. #FCB</p>
					<p class="TextSocalInner">“We have to trust Ferrán Torres - it's a matter of giving him time and confidence”.</p>
					<div class="SocalMatchImg">
						
						<img src="{{url('frontend/images/aft_match.png')}}" width="100%">
					</div>
					<a href="#" class="TwitterTxtBtm">12:00 PM · Feb 18, 2022</a>
					


				</div>
				<hr>
				@livewire('team.addyoutube-video')
				<div class="top-performer-box w-100 d-flex">
					<div class="performer-goal green-bg-a position-relative col-md-3 pt-2 pe-4">
						<h2>15<span>Goals</span></h2>
						<a href="#" class="ic-logo"><img src="{{url('frontend/images/kanno-icon.png')}}"></a>
					</div>
					<div class="performer-detail green-bg col-md-5 py-2">
						<div class="content-pos">
						<h5><a href="#">Samon Knight</a></h5>
						<ul class="list-unstyled">
							<li>22 Games Played</li>
							<li>23 Games Started</li>
							<li>12 Assist</li>
							<li>3 Foul</li>
							<li>2 Yellow Cards</li>
							<li>0 Red Card</li>
						</ul>
						</div>
					</div>
					<div class="performer-player-img green-bg-a position-relative col-md-4 ">
						<div class="w-100 overflow-hidden br-right-0"><img src="{{url('frontend/images/freddie.png')}}" alt="player" class=""></div>
					</div>
				</div>
				<div class="top-performer-box w-100 d-flex">
					<div class="performer-goal lb-bg-a position-relative col-md-3 pt-2 pe-4">
						<h2>15<span>Goals</span></h2>
						<a href="#" class="ic-logo"><img src="{{url('frontend/images/kanno-icon.png')}}"></a>
					</div>
					<div class="performer-detail lb-bg col-md-5 py-2">
						<div class="content-pos">
						<h5><a href="#">Samon Knight</a></h5>
						<ul class="list-unstyled">
							<li>22 Games Played</li>
							<li>23 Games Started</li>
							<li>12 Assist</li>
							<li>3 Foul</li>
							<li>2 Yellow Cards</li>
							<li>0 Red Card</li>
						</ul>
						</div>
					</div>
					<div class="performer-player-img lb-bg-a position-relative col-md-4 ">
						<div class="w-100 overflow-hidden br-right-0"><img src="{{url('frontend/images/freddie.png')}}" alt="player" class=""></div>
					</div>
				</div>
				<div class="top-performer-box w-100 d-flex">
					<div class="performer-goal red-bg-a position-relative col-md-3 pt-2 pe-4">
						<h2>15<span>Goals</span></h2>
						<a href="#" class="ic-logo"><img src="{{url('frontend/images/kanno-icon.png')}}"></a>
					</div>
					<div class="performer-detail red-bg col-md-5 py-2">
						<div class="content-pos">
						<h5><a href="#">Samon Knight</a></h5>
						<ul class="list-unstyled">
							<li>22 Games Played</li>
							<li>23 Games Started</li>
							<li>12 Assist</li>
							<li>3 Foul</li>
							<li>2 Yellow Cards</li>
							<li>0 Red Card</li>
						</ul>
						</div>
					</div>
					<div class="performer-player-img red-bg-a position-relative col-md-4 ">
						<div class="w-100 overflow-hidden br-right-0"><img src="{{url('frontend/images/freddie.png')}}" alt="player" class=""></div>
					</div>
				</div>
				</div>
		</div>
		
		
		</div>
	</main>
<footer class="footer-section">
 <div class="container-lg">
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
           <div><form class="FooterForm">
			   <div class="input-group">
					  <input type="email" class="form-control" placeholder="Email or Phone Number" name="email">
					  <div class="input-group-btn ">
						<button class="btn btn-submit-group B-Radios" type="submit">Join Now</button>
					  </div>
					</div>
		   </form>
            </div>
			<div class="social-chat mrgntop">
				<span class="letschat">Lets Chat: <a href="" alt="" title="letschat">hi@sportvote.org</a>     </span>
				<ul class="social_icons"><li>Follow Us:</li><li><a href="#" title="facebook"><i class="icons icon-fb"></i></a></li><li><a href="#" title="twitter"><i class="icons icon-tw"></i></a></li><li><a href="#" title="linkedin"><i class="icons icon-li"></i></a></li><li><a href="#" title="Instagram"><i class="icons icon-insta"></i></a></li></ul>
				<div class="clearfix"></div>
			</div>
          </div>
		  </div>
		  <div class="row ">
			<div class="col-lg-12 text-center copyright">
				Copyright 2022. All rights for Sportvote logo, marketing content & marketing graphics are reserved to Sportvote Inc.
			</div>
		  </div>
		  </div>
	
</footer>



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
  <script type="text/javascript" src="{{url('frontend/assets/js/bootstrap-multiselect.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
        $('#example-getting-started').multiselect({
		
		buttonWidth: '100%'});
		$('#fvt_team').multiselect({
		
		buttonWidth: '100%'});
		$('#select_competition').multiselect({
		
		buttonWidth: '100%'});
    });
</script>
<script type="text/javascript">
        // add row
        $(".addRow").click(function () {
            var html = '';
            html += '<div class="row mb-3 user_data">';
            html += '<div class="col-md-12 mb-3"><label class="" for="search_sport">SEARCH based on SPORTs in PROFILE</label><input type="text" class="grey-form-control  input-sm" id="search_sport" name="search_sport"></div><div class="col-md-12"><label class="" for="join_reason">Reason why you want to join</label><textarea rows="2" maxlength="200" class="grey-form-textarea  input-sm" placeholder="Enter here..."  id="join_reason" name="join_reason"></textarea></div>';
            
            html += '<div class="col-md-12"><button  type="button" class="removeRow float-start btn btn-danger ">&times;</button></div>';
            html += '</div>';
            
            $('.newRow').append(html);
        });

        // remove row
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.user_data').remove();
        });
    </script>
	<script type="text/javascript" src="js/circliful.js"></script>
<script>
    var circle1 = circliful.newCircle({
            percent: 80,
            id: 'circle1',
            type: 'simple',
            icon: 'f179',
            text: 'TP Wins',
            noPercentageSign: true,
            backgroundCircleWidth: 12,
            foregroundCircleWidth: 20,
            progressColors: [
                {percent: 1, color: 'red'},
                {percent: 30, color: 'orange'},
                {percent: 60, color: 'green'}
            ]
        });

        setTimeout(() => {
            circle1.update([
                {type: 'percent', value: 95},
                {type: 'text', value: 'TP has won'},
            ]);
        }, 3000);
 </script>
<script src="js/jquery.circlechart.js"></script>
<script type="text/javascript">
	$('.demo1').percentcircle({

animate : true,
diameter : 130,
guage: 2,
coverBg: '#fff',
bgColor: '#efefef',
fillColor: '#0e9247',
percentSize: '15px',
percentWeight: 'normal'

});
$('.demo2').percentcircle({

animate : true,
diameter : 130,
guage: 2,
coverBg: '#fff',
bgColor: '#efefef',
fillColor: '#025e99',
percentSize: '15px',
percentWeight: 'normal'

});

$('.demo3').percentcircle({

animate : true,
diameter : 130,
guage: 2,
coverBg: '#fff',
bgColor: '#efefef',
fillColor: '#FF2052',
percentSize: '15px',
percentWeight: 'normal'

});

</script>
<script type="text/javascript">
	let items = document.querySelectorAll('.carousel .carousel-item')

items.forEach((el) => {
    const minPerSlide = 12
    let next = el.nextElementSibling
    for (var i=1; i<minPerSlide; i++) {
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
	$('.owl-carousel').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})
</script>



</body>

</html>
