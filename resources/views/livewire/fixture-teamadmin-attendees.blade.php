<div class="row mt-3 mtopNew" {{$match_fixture->fixture_type == 0 ? 'wire:poll.visible.5s':''}}>
	<button class="processed" wire:click="refresh">Refresh</button>
	{{-- wire:poll.750ms --}}
@if($match_fixture->finishdate_time == "")
	<div class="col-md-5 col-6 position-relative">
	@if($fixture_squad_teamOne->isEmpty())
		@foreach($teamOne_attendees as $tm1)
		<?php $team_member = App\Models\Team_member::where('member_id',$tm1->attendee_id)->where('team_id',$teamOne->id)->first(); ?>
		<div class="player-jersy-list">
			<div class="jersy-img-wrap mb-2">
				<style>
				  .jersy1::after{
				  color: <?php echo $teamOne->team_color; ?>;
				  }
			   </style>
				<span class="jersy-no team-jersy-left jersy1">@if($team_member->jersey_number) {{$team_member->jersey_number}} @else  @endif</span>
				<div class="jersy-img">
					<img class="img-fluid" src="{{url('frontend/profile_pic')}}/{{$tm1->player->profile_pic}}" alt="" height="100">
				</div>
			</div>
			<div class="jersy-plyr-title d-flex">
				<span class="score"></span>
				<div class="playerNme">
					{{$tm1->player->first_name}} {{$tm1->player->last_name}}
				</div>
			</div>
		</div>
		@endforeach
		<div class="overlay-hide"></div>
		@if(in_array(Auth::user()->id ,$teamOne_admins_ids))
		<div class="overlay-button"><button class="btn btn-green modal_teamOne" style="background-color:{{$teamOne->team_color}};" data-bs-toggle="modal" data-bs-target="#squadModal_teamOne" data-id="{{$teamOne->id}}">Select Starting Lineup</button></div>
		@else
		<div class="overlay-button"><button class="btn btn-green" style="background-color:{{$teamOne->team_color}};" data-bs-toggle="modal">Waiting for players selections</button></div>
		@endif
	@else
		@foreach($fixture_squad_teamOne as $tm1)
		<?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamOne->id)->where('player_id',$tm1->player->id)->where('sport_stats_id',1)->get();?>
		<?php $red_card = App\Models\Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamOne->id)->where('player_id',$tm1->player->id)->where('sport_stats_id',3)->get();?>
		<?php $yellow_card = App\Models\Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamOne->id)->where('player_id',$tm1->player->id)->where('sport_stats_id',2)->get();?>
		<?php $team_member = App\Models\Team_member::where('member_id',$tm1->player_id)->where('team_id',$teamOne->id)->first(); ?>
		<!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
		@if(Auth::user()->id == $teamOne->user_id)
			@if($match_fixture->startdate_time != NULL)
				@if(@$fixture_lapse_type->lapse_type == 1)
					@if($red_card->isNotEmpty())
						<!-- <div class="player-jersy-list" wire:click="alert_redcard_player"> -->
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<!-- <div class="player-jersy-list" wire:click="alert_yellowcard_player"> -->
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamOne->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 3)
					@if($red_card->isNotEmpty())
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamOne->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 5)
					@if($red_card->isNotEmpty())
						<!-- <div class="player-jersy-list" wire:click="alert_redcard_player">-->
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<!-- <div class="player-jersy-list" wire:click="alert_yellowcard_player">-->
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamOne->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 8)
					@if($red_card->isNotEmpty())
						<!-- <div class="player-jersy-list" wire:click="alert_redcard_player">-->
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<!-- <div class="player-jersy-list" wire:click="alert_yellowcard_player">-->
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamOne->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 2)
					<div class="player-jersy-list" wire:click="alertstopmatch">
				@else
					@if($match_fixture->finishdate_time == Null)
						<div class="player-jersy-list" wire:click="alertstopmatch">
					@else
						<div class="player-jersy-list">
					@endif
				@endif
			@else
				<div class="player-jersy-list">
			@endif
		@else
			<div class="player-jersy-list">
		@endif
				<div class="jersy-img-wrap mb-2">
					<style>
					  .jersy1::after{
					  color: <?php echo $teamOne->team_color; ?>;
					  }
				   </style>
					<span class="jersy-no team-jersy-left jersy1">@if($team_member->jersey_number) {{$team_member->jersey_number}} @else  @endif</span>
					<div class="jersy-img">
						<img class="img-fluid" src="{{url('frontend/profile_pic')}}/{{$tm1->player->profile_pic}}" alt="" height="100">
					</div>
				</div>
					 <div class="jersy-plyr-title d-flex">
						@if($goal1->count() != 0)
							<span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
						@else
							<span class="score01">00</span>
						@endif
						<div class="playerNme">
							{{$tm1->player->first_name}} {{$tm1->player->last_name}}
						</div>
					</div>
			</div>
		@endforeach
			@if(Auth::user()->id == $teamOne->user_id)
				@if ($match_fixture->startdate_time != null)
					@if (@$fixture_lapse_type->lapse_type == 1 || @$fixture_lapse_type->lapse_type == 3)
						<div class="player-jersy-list team_ownGoal" data-id="{{ $teamOne->id }}">
					@elseif(@$fixture_lapse_type->lapse_type == 5 || @$fixture_lapse_type->lapse_type == 8)
						<div class="player-jersy-list team_ownGoal" data-id="{{ $teamOne->id }}">
					@elseif(@$fixture_lapse_type->lapse_type == 6 || @$fixture_lapse_type->lapse_type == 9)
						<div class="player-jersy-list" wire:click="alertstopmatch">
					@else
						<div class="player-jersy-list">
					@endif
				@else
					<div class="player-jersy-list">
				@endif
			@else
				<div class="player-jersy-list">
			@endif
			<?php $ownGoalCount = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
					->where('team_id', $teamOne->id)
					->where('player_id', 16)
					->where('sport_stats_id', 54)
					->get(); ?>
			<div class="jersy-img-wrap mb-2">
				<style>
				</style>
				<div class="jersy-img">
					<img class="img-fluid"
						src="{{ url('frontend/images/football.png') }}" alt=""
						height="100">
				</div>
			</div>
			<div class="jersy-plyr-title d-flex">
				@if ($ownGoalCount->count() != 0)
					<span class="score"><?php echo str_pad($ownGoalCount->count(), 2, 0, STR_PAD_LEFT); ?></span>
				@else
					<span class="score01">00</span>
				@endif
				<div class="playerNme">
					Own Goal
				</div>
			</div>
		</div>
	@endif

	@if($subplyr1->isEmpty())
	@else
    {{-- For Substitute players --}}
            <hr>

			<span>Substitutes</span>
            <div class="row mb-4 p-3">

                <div class="col-md-12 col-12 ">

                        @foreach ($subplyr1 as $tm1)
                            <?php
							$goal1_sub = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
							->where('team_id', $teamOne->id)
							->where('player_id', $tm1->player->id )
							->where('sport_stats_id', 1)
							->get();
							$team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                                ->where('team_id', $teamOne->id)
                                ->first(); ?>
                            <div class="player-jersy-list player_score"
                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                <div class="jersy-img-wrap mb-2">
                                    <style>
                                        .jersy1::after {
                                            color: <?php echo $teamOne->team_color; ?>;
                                        }

                                        .jersy1 {
                                            color: <?php echo $teamOne->font_color; ?>;
                                        }
                                    </style>
                                    <span class="jersy-no team-jersy-left jersy1">
                                        {{-- @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif --}}
                                    </span>
                                    <div class="jersy-img">
                                        <img class="img-fluid"
                                            src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}"
                                            height="100">
                                    </div>

                                </div>
                                <div class="jersy-plyr-title d-flex">
								@if($goal1_sub->count() != 0)
									<span class="score"><?php echo str_pad($goal1_sub->count(), 2, 0, STR_PAD_LEFT); ?></span>
								@else
									<span class="score01">00</span>
								@endif
									<div class="playerNme">
										{{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
									</div>
                                </div>
                            </div>
                        @e ndforeach
                </div>

            </div>

	@endif
            {{-- End substitute players --}}

	</div>

	<div class="col-md-2 Border-RightLeft2">
		@if($match_fixture->startdate_time != NULL)
			@if(!(empty($scorerofthematch)))
				<?php $user = App\Models\User::find($scorerofthematch['player_id']);?>
				<a href="{{url('player_profile/' .$user->id)}}" target="a_blank">
					<div class="text-center MAn-of-The-Match Man_of_theMatch_teamPage">
						<span class="text-center">Recent Scorer</span>
						<p class="John-Barinyima">{{$user->first_name}} {{$user->last_name}}</p>
					</div>
					<div class="player-of-match">
						<div class="photo-frame">
							<div class="crop-img"><img src="{{url('frontend/profile_pic')}}/{{$user->profile_pic}}" alt="" class=""></div>
						</div>
					</div>
				</a>
			@else
			@endif
		@else
		@endif
		@if($match_fixture->refree_id != "")
			<?php $refree = App\Models\User::find($match_fixture->refree_id); ?>
			<a href="{{ url('player_profile/' . $refree->id) }}" target="a_blank">
				<div class="player-refer-bottom text-center">
					<div class="crop-circle">
						<img src="{{ asset('frontend/profile_pic') }}/{{ $refree->profile_pic }}" alt=""
							class="img-fluid">
					</div>
					<h3 class="ref-player" style="bottom:0px">Ref: {{ $refree->first_name }} {{ $refree->last_name }}</h3>
					<!-- <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i
							class="icon-star"></i><i class="icon-star"></i></span> -->
				</div>
			</a>
		@else
			<a href="#" target="a_blank">
				<div class="player-refer-bottom text-center">
					<div class="crop-circle">
						<img src="{{ asset('frontend/profile_pic/default_profile_pic.png') }}" alt=""
							class="img-fluid">
					</div>
					<h3 class="ref-player" style="bottom:0px">REFEREE</h3>
				</div>
			</a>
		@endif
		<div class="mt-4 text-center">
		<!-- <button class="btn btn-green " data-bs-toggle="modal" data-bs-target="#myModal">Select Refree</button> --> </div>
	</div>

	<div class="col-md-5 col-6 position-relative BorderMobil">
	@if($fixture_squad_teamTwo->isEmpty())
		@foreach($teamTwo_attendees as $tm1)
		<?php $team_member = App\Models\Team_member::where('member_id',$tm1->attendee_id)->where('team_id',$teamTwo->id)->first(); ?>
		<style>
		  .jersy2::after{
		  color: <?php echo $teamTwo->team_color; ?>;
		  }
	   </style>
		<div class="player-jersy-list" data-bs-target="#plyrRecord" data-bs-toggle="modal">
			<div class="jersy-img-wrap mb-2">
				<span class="jersy-no team-jersy-right jersy2">@if($team_member->jersey_number) {{$team_member->jersey_number}} @else  @endif</span>
				<div class="jersy-img">
					<img class="img-fluid" src="{{url('frontend/profile_pic')}}/{{$tm1->player->profile_pic}}" alt="" height="100">
				</div>
			</div>
			<div class="jersy-plyr-title d-flex">
				{{$tm1->player->first_name}} {{$tm1->player->last_name}}
			</div>
		</div>
		@endforeach
		<div class="overlay-hide"></div>
		@if(in_array(Auth::user()->id ,$teamTwo_admins_ids))
		 <div class="overlay-button"><button class="btn btn-green" style="background-color:{{$teamTwo->team_color}}; " data-bs-toggle="modal" data-bs-target="#squadModal_teamTwo" data-id="{{$teamTwo->id}}">Select Starting Lineup</button></div>
		@else
		<div class="overlay-button"><button class="btn btn-green" style="background-color:{{$teamTwo->team_color}};" data-bs-toggle="modal">Waiting for players selections</button></div>
		@endif
	@else
		@foreach($fixture_squad_teamTwo as $tm1)
		<?php $goal1 = App\Models\Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamTwo->id)->where('player_id',$tm1->player->id)->where('sport_stats_id',1)->get();?>
		<?php $red_card = App\Models\Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamTwo->id)->where('player_id',$tm1->player->id)->where('sport_stats_id',3)->get();?>
		<?php $yellow_card = App\Models\Match_fixture_stat::where('match_fixture_id',$match_fixture->id)->where('team_id',$teamTwo->id)->where('player_id',$tm1->player->id)->where('sport_stats_id',2)->get();?>
		<?php $team_member = App\Models\Team_member::where('member_id',$tm1->player_id)->where('team_id',$teamTwo->id)->first(); ?>
		<!-- Team admin can enter stats(goal, yellow and red) for their own team only -->
		@if(Auth::user()->id == $teamTwo->user_id)
			@if($match_fixture->startdate_time != NULL)
				@if(@$fixture_lapse_type->lapse_type == 1)
					@if($red_card->isNotEmpty())
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamTwo->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 3)
					@if($red_card->isNotEmpty())
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamTwo->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 5)
					@if($red_card->isNotEmpty())
						<!-- <div class="player-jersy-list" wire:click="alert_redcard_player">-->
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<!-- <div class="player-jersy-list" wire:click="alert_yellowcard_player">-->
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamTwo->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 8)
					@if($red_card->isNotEmpty())
						<!-- <div class="player-jersy-list" wire:click="alert_redcard_player">-->
						<div class="player-jersy-list" onclick="return confirm('This player has received a red card')">
					@else
						@if($yellow_card->count() >= 2)
							<!-- <div class="player-jersy-list" wire:click="alert_yellowcard_player">-->
							<div class="player-jersy-list" onclick="return confirm('This player has received a 2 yellow cards')">
						@else
							<div class="player-jersy-list player_score" data-id="{{$tm1->player_id}},{{$teamTwo->id}}">
						@endif
					@endif
				@elseif(@$fixture_lapse_type->lapse_type == 2)
					<div class="player-jersy-list" wire:click="alertstopmatch">
				@else
					@if($match_fixture->finishdate_time == Null)
						<div class="player-jersy-list" wire:click="alertstopmatch">
					@else
						<div class="player-jersy-list">
					@endif
				@endif
			@else
				<div class="player-jersy-list">
			@endif
		@else
			<div class="player-jersy-list">
		@endif
				<div class="jersy-img-wrap mb-2">
					<style>
					  .jersy2::after{
					  color: <?php echo $teamTwo->team_color; ?>;
					  }
				   </style>
					<span class="jersy-no team-jersy-right jersy2">@if($team_member->jersey_number) {{$team_member->jersey_number}} @else  @endif</span>
					<div class="jersy-img">
						<img class="img-fluid" src="{{url('frontend/profile_pic')}}/{{$tm1->player->profile_pic}}" alt="" height="100">
					</div>

				</div>
				<div class="jersy-plyr-title">
					@if($goal1->count() != 0)
						<span class="score"><?php echo str_pad($goal1->count(), 2, 0, STR_PAD_LEFT); ?></span>
					@else
						<span class="score01">00</span>
					@endif
						<p class="mb-0">{{$tm1->player->first_name}}
						{{$tm1->player->last_name}}</p>
				</div>
			</div>
		@endforeach
			<?php $ownGoalCount2 = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
						->where('team_id', $teamTwo->id)
						->where('player_id', 16)
						->where('sport_stats_id', 54)
						->get(); ?>
			@if(Auth::user()->id == $teamTwo->user_id)
				@if ($match_fixture->startdate_time != null)
					@if (@$fixture_lapse_type->lapse_type == 1 || @$fixture_lapse_type->lapse_type == 3)
						<div class="player-jersy-list team_ownGoal" data-id="{{ $teamTwo->id }}" data-time="{{now()}}">
					@elseif(@$fixture_lapse_type->lapse_type == 5 || @$fixture_lapse_type->lapse_type == 8)
						<div class="player-jersy-list team_ownGoal" data-id="{{ $teamTwo->id }}" data-time="{{now()}}">
					@elseif(@$fixture_lapse_type->lapse_type == 6 || @$fixture_lapse_type->lapse_type == 9)
						<div class="player-jersy-list" wire:click="alertstopmatch">
					@else
						<div class="player-jersy-list">
					@endif
				@else
					<div class="player-jersy-list">
				@endif
			@else
				<div class="player-jersy-list">
			@endif
				<div class="jersy-img-wrap mb-2">
					<style>
					</style>
					<div class="jersy-img">
						<img class="img-fluid"
							src="{{ url('frontend/images/football.png') }}" alt=""
							height="100">
					</div>
				</div>
				<div class="jersy-plyr-title d-flex">
					@if ($ownGoalCount2->count() != 0)
						<span class="score"><?php echo str_pad($ownGoalCount2->count(), 2, 0, STR_PAD_LEFT); ?></span>
					@else
						<span class="score01">00</span>
					@endif
					<div class="playerNme">
						Own Goal
					</div>
				</div>
			</div>
	@endif
    {{-- For Substitute players --}}
	@if($subplyr2->isEmpty())
	@else
            <hr>
			<span>Substitutes</span>
            <div class="row mb-4 p-3">

                <div class="col-md-12 col-12 ">

                        @foreach ($subplyr2 as $tm1)
                            <?php
							$goal2_sub = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
							->where('team_id', $teamTwo->id)
							->where('player_id', $tm1->player_id)
							->where('sport_stats_id', 1)
							->get();
							$team_member = App\Models\Team_member::where('member_id', $tm1->player_id)
                                ->where('team_id', $teamTwo->id)
                                ->first(); ?>
                             <div class="player-jersy-list player_score"
                                data-id="{{ $tm1->player_id }},{{ $teamOne->id }}">
                                <div class="jersy-img-wrap mb-2">
                                    <style>
                                        .jersy2::after {
                                            color: <?php echo $teamTwo->team_color; ?>;
                                        }

                                        .jersy2 {
                                            color: <?php echo $teamTwo->font_color; ?>;
                                        }
                                    </style>
                                    <span class="jersy-no team-jersy-left jersy2">
                                        {{-- @if ($team_member->jersey_number)
                                    {{ $team_member->jersey_number }}
                                @else
                                @endif --}}
                                    </span>
                                    <div class="jersy-img">
                                        <img class="img-fluid" src="{{ url('frontend/profile_pic') }}/{{ $tm1->player->profile_pic }}" height="100">
                                    </div>
                                </div>
                                <div class="jersy-plyr-title d-flex">
									@if($goal2_sub->count() != 0)
										<span class="score"><?php echo str_pad($goal2_sub->count(), 2, 0, STR_PAD_LEFT); ?></span>
									@else
										<span class="score01">00</span>
									@endif
									<div class="playerNme">
										{{ $tm1->player->first_name }} {{ $tm1->player->last_name }}
									</div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
	@endif
            {{-- End substitute players --}}
	</div>
@else
	@livewire('fixture-vote-attendees',['match_fixture_id' => $match_fixture->id])
@endif
<script type="text/javascript" src="{{url('frontend/js/dist_sweetalert.min.js')}}"></script>
<script>

window.addEventListener('swal:modal', event => {
    swal({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
    });
});

window.addEventListener('swal:confirm', event => {
    swal({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        window.livewire.emit('remove');
      }
    });
});
 </script>
</div>
