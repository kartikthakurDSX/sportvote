<span class="row teamFixutreView"  wire:poll.5s >
    <button class="processed" wire:click="refresh">Refresh</button>
    <span class="col-md-2">
        @if($fixture->startdate_time == NULL)
        <span class="IconPLR"><a wire:click="ics_file({{$fixture->id}})"  style="cursor:pointer;"><i class="fa-solid fa-calendar-plus"></i></a></span>
        @else
            @if($fixture->finishdate_time != NULL)
                @if($fixture->fixture_type == 1)
                    <div class="Drawmatch" data-toggle="tooltip" data-placement="bottom" data-original-title="" title="Match draw"></div>
                @else
                    @if($fixture->winner_team_id != NULL)
                    <?php $winner_team_logo = App\Models\Team::select('id','team_logo','name')->find($fixture->winner_team_id); ?>
                    <span class="tableViewFixture pp-pageHW ">
                        <a href="{{url('team/'. $winner_team_logo->id)}}" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="" title="Match won">
                        <img class="rounded-circle img-fluid" src="{{url('frontend/logo')}}/{{$winner_team_logo->team_logo}}" height="30px">
                        </a>
                    </span>
                    @else
                        <div class="VotingOpenClor"></div>
                    @endif
                @endif
            @else
                <div class="VotingOpenClor"></div>
            @endif
        @endif
    </span>
    <span class="col-md-10">
        @if($fixture->startdate_time == NULL)
            <a class="text-decoration AndyMcg" wire:click="ics_file({{$fixture->id}})" style="cursor:pointer"> Add to calendar <i class="fa-solid fa-angles-right"></i></a>
        @else

        <a class="text-decoration AndyMcg" href="{{ URL::TO('match-fixture/' . $fixture->id)}}" target="_blank"> VIEW FIXTURE <i class="fa-solid fa-angles-right"></i></a>
        @endif
    </span>
</span>
