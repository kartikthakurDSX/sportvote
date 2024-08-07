@include('frontend.includes.header')
<div class="header-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong> Team List</strong></h1>
				</div>
			</div>
		</div>
	</div>
<main id="main">
	<div class="container">
        <div class="row">
           
		   <div class="col-lg-12 col-md-12">
		
				
					 <div class="d-flex align-items-center ">
					  <div class="game-logo">

						 <img src="{{asset('frontend/logo')}}/{{$team->team_logo}}" class="rounded-circle bg-white p-2" height="100" width="100">
					 
					  </div>
					
						
					</div>
					

				
					<div class="team-deatil row">
					<table class="">
						<tr><td><b>Team Name </b></td> <td>: </td><td>{{$team->name}}</td></tr>
						<tr><td><b>Location</b></td><td>: </td><td>{{$team->location}}</td></tr>
						<tr><td><b>Home Ground</b></td><td>: </td><td>{{$team->homeGround}}</td></tr>
						<tr><td><b>Home Ground Location</b></td><td>:</td><td>{{$team->homeGround_location}}</td></tr>
						<tr><td><b>Player request Acceptence from</b></td><td>:</td><td>@foreach(explode(',',$team->accept_player_invite) as $sbc) <?php $level_name = App\Models\Sport_level::where('id',$sbc)->value('name'); ?> {{$level_name}} Level Players, @endforeach</td></tr>
						<tr><td><b>Competition request acceptence from</b></td><td>:</td><td>@foreach(explode(',',$team->accept_comp_invite) as $cbc) <?php $complevel_name = App\Models\Sport_level::where('id',$cbc)->value('name'); ?> {{$complevel_name}} Level Players, @endforeach<td></tr>
						<tr><td><b>Team Sport level</b></td><td>:</td><?php $sport_level = App\Models\Sport_level::where('id',$team->sport_level_id)->value('name'); ?><td>{{$sport_level}} Level</td></tr>
						<tr><td><b>Description</b></td><td>:</td><td>{{$team->description}}</td></tr>
						<input type="hidden" value="{{$team->id}}" id="team_id">

					</table>
					
					</div>	
					
					<div class="row">
						<table class="table table-striped table-bordered table-sm" id="team_join_table">
						<thead class="">
							<tr>
                                <th>Admin Position</th>
                                <th>Name</th>
                                <th>Status</th>
                                <!-- <th>Action</th>				 -->
							</tr>
						</thead>
						<tbody>
					
					@foreach($team_members as $tm)
					@foreach($member_position as $mp)
					@if($mp->member_type == 2)
					@if($mp->id == $tm->member_position_id)
					<?php $team = App\Models\Team::find($tm->team_id); ?>
					
					<?php $member = App\Models\User::find($tm->member_id); ?>
                    <tr>
					<td>{{$mp->name}}</td>
					<td>{{$member->first_name}}</td>
					<td>@if($tm->invitation_status == 0) Pending 
						@elseif($tm->invitation_status == 1) <button class="btn btn-success btn-xs-nb">Accepted</button> @elseif($tm->invitation_status == 2) Rejected @endif</td>
					<!-- <td></td> -->
					</tr>
                	@endif
					@endif
					@endforeach
					@endforeach
					</tbody>
					</table>
					</div>
			
		   </div>
		</div>
					
			<div class="row">
			<div class="col-lg-12 col-md-12 ps-0 pe-0">
					<h1> Players List:</h1>
					@foreach($team_members as $tm)
					@foreach($member_position as $mp)
					@if($mp->member_type == 1)
					@if($mp->id == $tm->member_position_id)
					<?php $team = App\Models\Team::find($tm->team_id); ?>
					<?php $member = App\Models\User::find($tm->member_id); ?>

					<div class="player-jersy-list">
					<div class="jersy-img-wrap mb-2">
					@if($tm->invitation_status == 1) 
					
					<button class="jersy-no btn-success jersey_num" data-id="{{$member->id}}" data-bs-target="#plyrRecord" data-bs-toggle="modal">@if($tm->jersey_number)
					{{$tm->jersey_number}}
					@else + @endif</button>
					@endif
					
						<div class="jersy-img">
							@if($member->profile_pic)
							<img src="{{asset('frontend/profile_pic')}}/{{$member->profile_pic}}" alt="" width="110px">
						@else <img src="{{url('frontend/images/freddie.png')}}" alt=""> @endif
							
						</div>
						<span class="jersy-star"><i class="icon-star"></i></span>
					</div>
					<div class="jersy-plyr-title d-flex">
						<span class="score">@if($tm->invitation_status == 0) Pending 
						@elseif($tm->invitation_status == 1) Accepted @endif </span>
						{{$member->first_name}} {{$member->last_name}}
							[ {{$mp->name}} ]
					</div>
					</div>
				@endif
				@endif
				@endforeach
				@endforeach
			</div>
			</div>


			
	
	</main>


	

    @include('frontend.includes.footer')

	<div class="modal fade" id="plyrRecord" role="dialog" >
          <div class="modal-dialog">
              <!--    Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
				  
                     <div class="modal-title01">
						<div class="circle-refree">
							<img src="" width="100%" id="player_pic">
						</div>
						
						<div class="plyrname">
                             <img src="{{url('frontend/logo')}}/{{$team->team_logo}}" class="team-logo"> <span id="player_name"> Player Name </span>
							 <span id="player_id"></span> 
							 <span class="plyrname-subtitle"><span id="player_position"> Player Position </span></span>
                         </div>
						
					</div>	
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="numbr">
								 <input type="text" placeholder=" Enter Jersey Number" id="j_num" value="">
							   </div>
							   <div class="numbrcard">
								
								</div>
							</div>
							
						
						</div>
						 <div class="d-grid gap-2">
					  <button class="refr btn btn-success submit">Submit</button>
					  <button class="btn btn-default btn-lg tryagn" type="button" data-bs-dismiss="modal">Cancel & Try Again</button>
					</div>
					</div>
				</div>
                          
                </div>
            </div>
			
</div>



	<script src="{{url('frontend/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>

<script src="{{url('frontend/js/script.js')}}"></script>
  <script src="{{url('frontend/js/main.js')}}"></script>
  
  <script>
$(document).ready(function(){
    function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");
        
        // Applying the top margin on modal to align it vertically center
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
    }
    // Align modal when it is displayed
    $(".modal").on("shown.bs.modal", alignModal);
    
    // Align modal when user resize the window
    $(window).on("resize", function(){
        $(".modal:visible").each(alignModal);
    });   
});
</script>
<script>
var closebtns = document.getElementsByClassName("close-btn");
var i;

for (i = 0; i < closebtns.length; i++) {
  closebtns[i].addEventListener("click", function() {
    this.parentElement.style.display = 'none';
  });
}
</script>


<script>
	$(document).on('click','.jersey_num', function(){
		var id = $(this).data('id');
		var team_id = $('#team_id').val();
		$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				 	url:"{{url('player_info')}}",
        			type:'post',
        			data:{id:id,team_id:team_id},
					error:function(){
						alert('Something is Wrong');
					},
					success:function(response)
					{
						
							$('#player_name').html(response.player_info.first_name + ' '+ response.player_info.last_name);
							$('#player_pic').attr("src", "{{url('frontend/profile_pic')}}/"+response.player_info.profile_pic);
							$('#player_id').html('<input type="hidden" id="p_id" value="'+response.player_info.id+'">');
						
						
							
							$.each(response.team_member, function(key, value){
									$.each(value.member_positions, function(k,v){
										$('#player_position').html(v.name);

									});
							});
									
					}
				});
	});
</script>


<script>
var closebtns = document.getElementsByClassName("submit");
var i;

for (i = 0; i < closebtns.length; i++) {
  closebtns[i].addEventListener("click", function() {
    var j_num = $('#j_num').val();
	var player_id = $('#p_id').val();
	var team_id = $('#team_id').val();

	// alert(team_id);
	$.ajax({
				headers: {
   				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				 },
				 	url:"{{url('player_jersey_number')}}",
        			type:'post',
        			data:{j_num:j_num,team_id:team_id,player_id:player_id},
					error:function(){
						alert('Something is Wrong');
					},
					success:function(response)
					{
							if(response == 1)
							{
								location.reload(true); 
							}
							if(response == 0)
							{
								alert('This Jersey number has already been assigned to the player in this team...');
							}		
					}
				});
  });
}
</script>
@include('frontend.includes.searchScript')