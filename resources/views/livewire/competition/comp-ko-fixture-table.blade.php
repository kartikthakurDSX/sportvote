<div>
    @if($competition->team_number == $accepted_comp_team)
        <div class="row">
            <div class="col-md-8 ">
                <h1 class="Poppins-Fs30">K.O. Cup Fixtures</h1>
            </div>
            @if($competition->team_number == count($squad_selected_teams))
                @if($competition->comp_start != 1)
                    @if(Auth::check())
                        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn bg-blue start_competition_btn" wire:click="start_competition">Start Competition</button>
                            </div>
                        @else
                        @endif
                    @else
                    @endif
                @else
                    <div class="col-md-4 text-right">
                        <button class="btn fs1 "  wire:click="all_ics_file"><i class="fa-solid fa-calendar-plusFixture"></i></button>
                    </div>
                @endif
            @else
            @endif
        </div>
        @if($SRmatch_fixture->count() == 0)
            <?php $tab_class = "show active";
            $content ="UPCOMING"; ?>
        @else
            @if($Sr_completed_round >= $SRmatch_fixture->count())
                <?php $tab_class = " "; $content ="COMPLETED"; ?>
            @else
                <?php $tab_class = "show active"; ?>
            @endif
        @endif
        <div class="responsive-tabsOnMObile">
            <ul class="  nav nav-tabs responsive-tabs " id="myTab" role="tablist">
                @if(!(in_array($competition->team_number,$valid_rounds)))
                    @if($SRmatch_fixture->count() == 0)
                        <li class="nav-item Round-Tab"  wire:ignore>
                            <a class="nav-link nav-link-paddingUnactive" id="home-tab" data-toggle="tab"
                                href="#home" role="tab" aria-controls="home" aria-selected="false"> Qualifying Round
                                <p class="currentRounded">UPCOMING</p>
                            </a>
                        </li>
                    @else
                        @if($Sr_completed_round >= $SRmatch_fixture->count())
                                <li class="nav-item Round-Tab" wire:ignore>
                                    <a class="nav-link nav-linkCompleted nav-link-paddingUnactive" id="home-tab"
                                        data-toggle="tab" href="#home" role="tab" aria-controls="home"
                                        aria-selected="false"> Qualifying Round
                                        <p class="currentRounded">COMPLETED  </p>
                                    </a>
                                </li>
                        @else
                            <li class="nav-item Round-Tab active"  wire:ignore>
                                <a class="nav-link nav-link-padding active" id="home-tab" data-toggle="tab"
                                    href="#home" role="tab" aria-controls="home" aria-selected="true"> Qualifying Round
                                    <p class="currentRounded">CURRENT</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @else
                    @if($SRmatch_fixture->count() == 0)
                        <li class="nav-item Round-Tab"  wire:ignore>
                            <a class="nav-link nav-link-paddingUnactive" id="home-tab" data-toggle="tab"
                                href="#home" role="tab" aria-controls="home" aria-selected="false"> Round 1
                                <p class="currentRounded">UPCOMING</p>
                            </a>
                        </li>
                    @else
                        @if($Sr_completed_round >= $SRmatch_fixture->count())
                            <li class="nav-item Round-Tab" wire:ignore>
                                <a class="nav-link nav-linkCompleted nav-link-paddingUnactive" id="home-tab"
                                    data-toggle="tab" href="#home" role="tab" aria-controls="home"
                                    aria-selected="false"> Round 1
                                    <p class="currentRounded">COMPLETED </p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item Round-Tab active"  wire:ignore>
                                <a class="nav-link nav-link-padding active" id="home-tab" data-toggle="tab"
                                    href="#home" role="tab" aria-controls="home" aria-selected="true"> Round 1
                                    <p class="currentRounded">CURRENT</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endif

                @foreach($groupBy_next_round_teams as $rounds => $teams)
                    @if($rounds == $total_rounds)

                    @else
                        <?php $round_num = $rounds + 1;
                        $completed_round = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$round_num)->where('finishdate_time','!=',null)->count();
                        $Rmatch_fixture = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$round_num)->count();
                        $current_round = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$round_num)->where('startdate_time','!=',null)->count();

                        ?>
                        @if($Rmatch_fixture == 0)
                            <li class="nav-item Round-Tab"  wire:ignore>
                                <a class="nav-link nav-link-paddingUnactive" id="contact-tab" data-toggle="tab"
                                    href="#contact_{{$rounds}}" role="tab" aria-controls="contact" aria-selected="false"> ROUND {{$round_num}}
                                    <p class="currentRounded">UPCOMING</p>
                                </a>
                            </li>
                        @else
                            @if($completed_round >= $Rmatch_fixture)
                                <li class="nav-item Round-Tab" wire:ignore>
                                    <a class="nav-link nav-linkCompleted nav-link-paddingUnactive" id="contact-tab"
                                        data-toggle="tab" href="#contact_{{$rounds}}" role="tab" aria-controls="contact"
                                        aria-selected="false">  ROUND {{$round_num}}
                                        <p class="currentRounded">COMPLETED  </p>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item Round-Tab active"  wire:ignore>
                                    <a class="nav-link nav-link-padding active" id="contact-tab" data-toggle="tab"
                                        href="#contact_{{$rounds}}" role="tab" aria-controls="contact" aria-selected="true"> ROUND {{$round_num}}
                                        <p class="currentRounded">CURRENT</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif
                @endforeach

                <i class="fa fa-caret-up"></i>
                <i class="fa fa-caret-down"></i>
            </ul>
        </div>

        <div class="tab-content mb-4" id="myTabContent">

            <div class="tab-pane fade {{$tab_class}}" id="home" role="tabpanel" aria-labelledby="home-tab"  wire:ignore.self>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                        aria-labelledby="nav-home-tab">
                        <!-- Table K.O Data Fixture -->
                        <div id="selecteQuotation">
                            <div class="card p-0 m-0">
                                <div class="table-responsive"
                                    style="overflow-x:auto;white-space: nowrap;">
                                    <table class="table m-0">
                                        <tbody>
                                            <tr>
                                                <th class="alert-info" style="width: 20%">
                                                    <ul class="m-0 p-0 ullist">
                                                        @foreach($comp_teams as $comp_team)
                                                    <?php $selected_player = App\Models\Competition_attendee::where('competition_id',$comp_id)->where('team_id',$comp_team->team->id)->count(); ?>
                                                            <li class="PaddingTBli">
                                                                <div class="d-flex">
                                                                    <span class="pp-pageHW ">
                                                                        <span class="hei-WigImg">
                                                                        <a href="{{ URL::to('team/' . $comp_team->team->id) }}" target="_blank">
                                                                            <img class="img-fluid rounded-circle"
                                                                                src="{{url('frontend\logo')}}\{{$comp_team->team->team_logo}}"
                                                                                width="100%">
                                                                        </a>
                                                                        </span>
                                                                    </span>
                                                                    <div class="min-WidthArsenalText">
                                                                    <a href="{{ URL::to('team/' . $comp_team->team->id) }}" target="_blank">
                                                                        <b class="WolVerWand"> @php echo Str::of($comp_team->team->name)->limit(7); @endphp</b>
                                                                    </a>
                                                                    </div>
                                                                    @if(Auth::check())
                                                                        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
                                                                            @if(in_array($comp_team->team->id,$fixtureteamids))
                                                                                <i class="icon-check icon-process-chart01 green-bgRightFirst "></i>
                                                                            @else
                                                                                @if($selected_player == $competition->squad_players_num)
                                                                                <?php $comp_requ = -1;?>
                                                                                <span class="PlusBtnFLot-Right"> <button class="RoundPlusBtn" wire:click="move_create_fixture( {{$comp_team->team->id}},{{$comp_requ}})">+</button></span>
                                                                                @else
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                        @endif
                                                                    @else
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </th>
                                                @if($SRmatch_fixture->isNotempty())
                                                <td class="FaCupClor">
                                                    <ul class="m-0 p-0 ullist">
                                                        @foreach($SRmatch_fixture as $mfx)
                                                            <li class="PaddingTBli"> <span class="OnSun">{{ date('D', strtotime($mfx->fixture_date)) }}</span> <span class="Dec-DateFix">{{ date('M d', strtotime($mfx->fixture_date)) }}</span>
                                                            @if($competition->comp_start == 0)
                                                                @if(Auth::check())
                                                                    @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
                                                                        @if($mfx->startdate_time == NULL)
                                                                            <span class="CloseDisNon"> <button class="RoundCloseBtn" onclick="return confirm('Are you sure you want to cancel this fixture?') || event.stopImmediatePropagation()" wire:click="delete_fixture({{$mfx->id}})">x</button></span>
                                                                        @else
                                                                        @endif
                                                                    @else
                                                                    @endif
                                                                @else
                                                                @endif
                                                            @else
                                                            @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="comptationbtn ">
                                                    <ul class="m-0 p-0 ullist">
                                                        @foreach($SRmatch_fixture as $mfx)
                                                            @if($mfx->teamOne_id == $mfx->teamTwo_id)
                                                                <li class="PaddingTBliPromoted">
                                                                    <div class="bg-LightTab d-flex ">
                                                                        <div class="text-left width50">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamTwo->id) }}" target="_blank">
                                                                            <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamTwo->team_logo}}"></span> <b class="WolVerWand">{{$mfx->teamTwo->name}}</b>&nbsp;
                                                                            </a>
                                                                        </div>
                                                                        <div class=" text-right width50">
                                                                            <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/images')}}/images/Promoted-icon.png"></span> <b class="PROMOTED">PROMOTED</b>&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @else
                                                                @if($mfx->startdate_time == NULL)
                                                                    <li class="PaddingTBli">
                                                                        <div class=" d-flex ">
                                                                            <div class="text-right width40">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamOne->id) }}" target="_blank">
                                                                            <b class="WolVerWand">
                                                                            {{$mfx->teamOne->name}}</b>&nbsp;
                                                                                <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamOne->team_logo}}"> </span>
                                                                                </a>
                                                                            </div>
                                                                            <div class=" text-center width20">
                                                                                <span class="BtnCentr"><button class="btn btn-gray text-center btn-xs-nb" wire:click="check_start_comp({{$mfx->id}})">{{ date('H:i', strtotime($mfx->fixture_date)) }}</button></span>
                                                                            </div>
                                                                            <div class=" text-left width40">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamTwo->id) }}" target="_blank">
                                                                                <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamTwo->team_logo}}"></span> <b class="WolVerWand">{{$mfx->teamTwo->name}}</b></a>&nbsp;
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @else
                                                                    <?php $teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$mfx->id)->where('team_id',$mfx->teamOne_id)->where('sport_stats_id',1)->get();
                                                                    $teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$mfx->id)->where('team_id',$mfx->teamTwo_id)->where('sport_stats_id',1)->get();?>
                                                                    <li class="PaddingTBli">
                                                                        <div class=" d-flex ">
                                                                            <div class="text-right width40">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamOne->id) }}" target="_blank">
                                                                                <b class="WolVerWand">{{$mfx->teamOne->name}}</b>&nbsp;
                                                                                <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamOne->team_logo}}"> </span>
                                                                                </a>
                                                                            </div>
                                                                            <div class=" text-center width20">
                                                                                <span class="BtnCentr"><span class=" btn-GrayFXL01 ">{{$teamOneGoal->count()}}</span> <span class=" btn-GrayFXR01 ">{{$teamTwoGoal->count()}}</span> </span>
                                                                            </div>
                                                                            <div class=" text-left width40">
                                                                                <a href="{{ URL::to('team/' . $mfx->teamTwo->id) }} " target="_blank"><span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamTwo->team_logo}}"></span>
                                                                                <b class="WolVerWand">{{$mfx->teamTwo->name}}</a></b>&nbsp;
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="FaCupClor">
                                                    <ul class="m-0 p-0 ullist">
                                                    @foreach($SRmatch_fixture as $mfx)
                                                        @if($mfx->startdate_time == NULL)
                                                            @if($mfx->teamOne_id == $mfx->teamTwo_id)
                                                                <?php $winner_team_logo = App\Models\Team::select('id','team_logo','name')->find($mfx->winner_team_id); ?>
                                                                <li class="PaddingTBli">
                                                                    <span class="pp-pageHW hei-WigImg">
                                                                        <a href="{{ URL::to('team/' . @$winner_team_logo->id) }}" target="_blank">
                                                                            <img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{@$winner_team_logo->team_logo}}" title="{{@$winner_team_logo->name}}">
                                                                        </a>
                                                                    </span>
                                                                    <span class="IconPLR"><i class="fa-solid fa-arrow-up-right-from-squareDis"></i></span>
                                                                </li>
                                                            @else
                                                                <li class="PaddingTBli">
                                                                    <span class="IconPLR"><a wire:click="ics_file({{$mfx->id}})" style="cursor:pointer;"><i class="fa-solid fa-calendar-plus"></i></a></span>
                                                                    <span class="IconPLR"> <a wire:click="check_start_comp({{$mfx->id}})" style="cursor:pointer;"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                                                </li>
                                                            @endif
                                                        @else
                                                            @if($mfx->finishdate_time == NULL)
                                                                <li class="PaddingTBli">
                                                                    <span class="IconPLR">
                                                                        <i class="icon-check icon-process-Green green-bgRight01 "></i>
                                                                    </span>
                                                                    <span class="IconPLR"> <a wire:click="check_start_comp({{$mfx->id}})" style="cursor:pointer;"> <i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                                                </li>
                                                            @else
                                                                <?php $winner_team_logo = App\Models\Team::select('id','team_logo','name')->find($mfx->winner_team_id); ?>
                                                                <li class="PaddingTBli">
                                                                    <span class="pp-pageHW hei-WigImg">
                                                                        <a href="{{ URL::to('team/' . @$winner_team_logo->id) }}" target="_blank">
                                                                            <img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{@$winner_team_logo->team_logo}}" title="{{@$winner_team_logo->name}}">
                                                                        </a>
                                                                    </span>
                                                                    <span class="IconPLR"> <a wire:click="check_start_comp({{$mfx->id}})" style="cursor:pointer;"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </ul>
                                                </td>
                                            @else
                                                <td colspan="3" class="text-center pt-4"> <b> No Data Found </b></td>
                                            @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End K.O Data Fixture -->
                    </div>
                </div>
            </div>


            @foreach($groupBy_next_round_teams as $rounds => $teams)
            <?php
                $next_round_num = $rounds + 1;
                $next_round_team_ids = App\Models\Match_fixture::where('competition_id',$comp_id)->where('finishdate_time','!=',null)->where('fixture_round',$rounds)->pluck('winner_team_id');
                $next_round_fixture = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$next_round_num)->count();
                $complted_nextR_fixture = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$next_round_num)->where('finishdate_time','!=',null)->count();

                $last_completed_fixture = App\Models\Match_fixture::where('competition_id',$comp_id)->where('finishdate_time','!=',null)->where('fixture_round',$rounds)->count();
                $last_total_fixture = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$rounds)->count();

                $last_round = App\Models\Match_fixture::select('fixture_round')->where('competition_id',$comp_id)->latest()->first();

                $next_fixtures = App\Models\Match_fixture::where('competition_id',$comp_id)->where('fixture_round',$next_round_num)->with('teamOne:id,name,team_logo','teamTwo:id,name,team_logo')->get();

                $nextfixtureteamoneids = array();
                $nextfixtureteamtwoids = array();
                foreach($next_fixtures as $fixtureteam){
                    $nextfixtureteamoneids[] = $fixtureteam['teamOne_id'];
                    $nextfixtureteamtwoids[] = $fixtureteam['teamTwo_id'];
                }
                $nextfixtureteamids = array_merge($nextfixtureteamoneids, $nextfixtureteamtwoids);
                $comp_team_info = App\Models\Team::select('id','name','team_logo')->whereIn('id',$next_round_team_ids)->get();
                $div_class1 = " ";

                if($rounds == $total_rounds)
                {
                    $div_class = " ";
                    // echo "rounds == total rounds";
                }
                else
                {
                    if($next_round_fixture == 0 )
                    {
                        //upcoming
                    if($last_completed_fixture >= $last_total_fixture)
                    {
                        // echo "last_fixture > 0";
                        $div_class = "show active";
                    }
                    else
                    {
                        // echo "last_fixture > 0 else";
                        $div_class = " ";
                    }

                    }
                    else
                    {
                        if($next_round_fixture < $complted_nextR_fixture)
                        {
                            // echo "next_round_fixture  complted_nextR_fixture";
                            // completed
                            if($next_round_fixture == $complted_nextR_fixture)
                            {
                                // echo "next_round_fixture == complted_nextR_fixture";
                                $div_class = "show active";
                            }
                            else
                            {
                                // echo "next_round_fixture == complted_nextR_fixture else";
                                $div_class = " ";
                            }

                        }
                        else
                        {
                            // current
                            // echo "last else";
                            $lm = $last_round->fixture_round;
                            $round = $lm - 1;
                            // echo $total_rounds;
                            if($round == $rounds)
                            {
                                // echo "true";
                                $div_class = "show active";
                            }
                            else
                            {
                                // echo "false";
                                $div_class = "";
                            }
                        }
                    }
                }

            //    echo $last_round->fixture_round.'== '. $rounds.'<br>';
            ?>


            <div class="tab-pane fade {{$div_class}}" id="contact_{{$rounds}}" role="tabpanel" aria-labelledby="contact-tab"  wire:ignore.self>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <!-- Table K.O Data Fixture -->
                        <div id="selecteQuotation">
                            <div class="card p-0 m-0">
                                <div class="table-responsive"
                                    style="overflow-x:auto;white-space: nowrap;">

                                    <table class="table m-0">
                                        <tbody>
                                            <tr>
                                                <th class="alert-info" style="width: 20%">
                                                    <ul class="m-0 p-0 ullist">
                                                        @foreach($comp_team_info as $team)
                                                            <li class="PaddingTBli">
                                                                <div class="d-flex">
                                                                    <span class="pp-pageHW ">
                                                                        <span class="hei-WigImg">
                                                                        <a href="{{ URL::to('team/' . $team->id) }}" target="_blank">
                                                                            <img class="img-fluid rounded-circle"
                                                                                src="{{url('frontend\logo')}}\{{$team->team_logo}}"
                                                                                width="100%">
                                                                        </a>
                                                                        </span>
                                                                    </span>
                                                                    <div class="min-WidthArsenalText">
                                                                    <a href="{{ URL::to('team/' . $team->id) }}" target="_blank">
                                                                        <b class="WolVerWand">@php echo Str::of($team->name)->limit(7); @endphp</b></a>
                                                                    </div>
                                                                    @if(Auth::check())
                                                                        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
                                                                            @if(in_array($team->id,$nextfixtureteamids))
                                                                                <i class="icon-check icon-process-chart01 green-bgRightFirst "></i>
                                                                            @else
                                                                            <span class="PlusBtnFLot-Right"> <button class="RoundPlusBtn" wire:click="move_create_fixture( {{$team->id}},{{$rounds}} )">+</button></span>
                                                                            @endif
                                                                        @else
                                                                        @endif
                                                                    @else
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </th>
                                                @if($next_fixtures->isNotempty())
                                                <td class="FaCupClor">
                                                    <ul class="m-0 p-0 ullist">
                                                        @foreach($next_fixtures as $mfx)
                                                            <li class="PaddingTBli"> <span class="OnSun">
                                                                {{ date('D', strtotime($mfx->fixture_date)) }}</span> <span class="Dec-DateFix">{{ date('M d', strtotime($mfx->fixture_date)) }}</span>
                                                                @if($competition->comp_start == 0)
                                                                    @if(Auth::check())
                                                                        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
                                                                            @if($mfx->startdate_time == NULL)
                                                                                <span class="CloseDisNon"> <button class="RoundCloseBtn" onclick="return confirm('Are you sure you want to cancel this fixture?') || event.stopImmediatePropagation()" wire:click="delete_fixture({{$mfx->id}})">x</button></span>
                                                                            @else
                                                                            @endif
                                                                        @else
                                                                        @endif
                                                                    @else
                                                                    @endif
                                                                @else
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="comptationbtn ">
                                                    <ul class="m-0 p-0 ullist">
                                                        @foreach($next_fixtures as $mfx)
                                                            @if($mfx->teamOne_id == $mfx->teamTwo_id)
                                                                <li class="PaddingTBliPromoted">
                                                                    <div class="bg-LightTab d-flex ">
                                                                        <div class="text-left width50">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamTwo->id) }}" target="_blank">
                                                                            <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamTwo->team_logo}}"></span> <b class="WolVerWand">{{$mfx->teamTwo->name}}</b>&nbsp;
                                                                            </a>
                                                                        </div>
                                                                        <div class=" text-right width50">
                                                                            <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/images')}}/images/Promoted-icon.png"></span> <b class="PROMOTED">PROMOTED</b>&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @else
                                                                @if($mfx->startdate_time == NULL)
                                                                    <li class="PaddingTBli">
                                                                        <div class=" d-flex ">
                                                                            <div class="text-right width40">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamOne->id) }}" target="_blank">
                                                                            <b class="WolVerWand">
                                                                            {{$mfx->teamOne->name}}</b>&nbsp;
                                                                                <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamOne->team_logo}}"> </span>
                                                                                </a>
                                                                            </div>
                                                                            <div class=" text-center width20">
                                                                                <span class="BtnCentr"><button class="btn btn-gray text-center btn-xs-nb" wire:click="check_start_comp({{$mfx->id}})">{{ date('H:i', strtotime($mfx->fixture_date)) }}</button></span>
                                                                            </div>
                                                                            <div class=" text-left width40">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamTwo->id) }}" target="_blank">
                                                                                <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamTwo->team_logo}}"></span> <b class="WolVerWand">{{$mfx->teamTwo->name}}</b></a>&nbsp;
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @else
                                                                    <?php $teamOneGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$mfx->id)->where('team_id',$mfx->		teamOne_id)->where('sport_stats_id',1)->get();
                                                                $teamTwoGoal = App\Models\Match_fixture_stat::where('match_fixture_id',$mfx->id)->where('team_id',$mfx->teamTwo_id)->where('sport_stats_id',1)->get();?>
                                                                    <li class="PaddingTBli">
                                                                        <div class=" d-flex ">
                                                                            <div class="text-right width40">
                                                                            <a href="{{ URL::to('team/' . $mfx->teamOne->id) }}" target="_blank">
                                                                                <b class="WolVerWand">{{$mfx->teamOne->name}}</b>&nbsp;
                                                                                <span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamOne->team_logo}}"> </span>
                                                                                </a>
                                                                            </div>
                                                                            <div class=" text-center width20">
                                                                                <span class="BtnCentr"><span class=" btn-GrayFXL01 ">{{$teamOneGoal->count()}}</span> <span class=" btn-GrayFXR01 ">{{$teamTwoGoal->count()}}</span> </span>
                                                                            </div>
                                                                            <div class=" text-left width40">
                                                                                <a href="{{ URL::to('team/' . $mfx->teamTwo->id) }} " target="_blank"><span class="pp-pageHW hei-WigImg"><img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{$mfx->teamTwo->team_logo}}"></span>
                                                                                <b class="WolVerWand">{{$mfx->teamTwo->name}}</a></b>&nbsp;
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="FaCupClor">
                                                    <ul class="m-0 p-0 ullist">
                                                    @foreach($next_fixtures as $mfx)
                                                        @if($mfx->startdate_time == NULL)
                                                            @if($mfx->teamOne_id == $mfx->teamTwo_id)
                                                                <?php $winner_team_logo = App\Models\Team::select('id','team_logo' ,'name')->find($mfx->winner_team_id); ?>
                                                                <li class="PaddingTBli">
                                                                    <span class="pp-pageHW hei-WigImg">
                                                                        <a href="{{ URL::to('team/' . @$winner_team_logo->id) }}" target="_blank">
                                                                            <img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{@$winner_team_logo->team_logo}}" title="{{@$winner_team_logo->name}}">
                                                                        </a>
                                                                    </span>
                                                                    <span class="IconPLR"><i class="fa-solid fa-arrow-up-right-from-squareDis"></i></span>
                                                                </li>
                                                            @else
                                                                <li class="PaddingTBli">
                                                                    <span class="IconPLR"><a wire:click="ics_file({{$mfx->id}})" style="cursor:pointer;"><i class="fa-solid fa-calendar-plus"></i></a></span>
                                                                    <span class="IconPLR"> <a wire:click="check_start_comp({{$mfx->id}})" style="cursor:pointer;"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                                                </li>
                                                            @endif
                                                        @else
                                                            @if($mfx->finishdate_time == NULL)
                                                                <li class="PaddingTBli">
                                                                    <span class="IconPLR">
                                                                            <i class="icon-check icon-process-Green green-bgRight01 "></i>
                                                                        </span>
                                                                    <span class="IconPLR"> <a wire:click="check_start_comp({{$mfx->id}})" style="cursor:pointer;"> <i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                                                </li>
                                                            @else
                                                                    <?php $winner_team_logo = App\Models\Team::select('id','team_logo','name')->find($mfx->winner_team_id); ?>
                                                                <li class="PaddingTBli">
                                                                    <span class="pp-pageHW hei-WigImg">
                                                                        <a href="{{ URL::to('team/' . @$winner_team_logo->id) }}" target="_blank">
                                                                            <img class="img-fluid rounded-circle" src="{{asset('frontend/logo')}}/{{@$winner_team_logo->team_logo}}" title="{{@$winner_team_logo->name}}">
                                                                        </a>
                                                                    </span>
                                                                    <span class="IconPLR"> <a wire:click="check_start_comp({{$mfx->id}})" style="cursor:pointer;"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></span>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </ul>
                                                </td>
                                            @else
                                                <td colspan="3" class="text-center pt-4"> <b> No Data Found </b></td>
                                            @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End K.O Data Fixture -->
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="modal fade" id="create_fixture" role="dialog" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1>Create Fixture </h1>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select class="select  grey-form-control" wire:model="selectteamOne_id">
                                    <option value="{{$selectteamOne_id}}">@if($selected_team_name) {{$selected_team_name->name}} @else @endif</option>
                                </select>
                                @error('selectteamOne_id') <span class="sv_error">{{ $message }}</span> @enderror
                            </div>
                            <div class=" col-md-6">
                                <select class="select  grey-form-control" wire:model="selectteamTwo_id">
                                    <option value="" selected hidden> Select Team Two </option>
                                    @if($first_comp_team)
                                        @foreach($comp_teams as $comp_team)
                                        <?php $selected_player_num = App\Models\Competition_attendee::where('competition_id',$comp_id)->where('team_id',$comp_team->team->id)->count();
                                        echo $selected_player_num;?>
                                            @if(in_array($comp_team->team->id,$fixtureteamids))

                                            @else
                                                @if($selected_player_num == $competition->squad_players_num)
                                                    @if($selectteamOne_id != $comp_team->team->id)
                                                        <option value="{{$comp_team->team->id}}"> {{$comp_team->team->name}}</option>
                                                    @else
                                                    @endif
                                                @else
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($next_comp_team as $comp_team)
                                            @if(in_array($comp_team->id,$matchfixtureteamids))

                                            @else
                                                @if($selectteamOne_id != $comp_team->id)
                                                    <option value="{{$comp_team->id}}"> {{$comp_team->name}}</option>
                                                @else
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('selectteamTwo_id') <span class="sv_error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3" >
                            <div class="col-md-6">
                            <input type="text" class="grey-form-control input-sm" style="padding: inherit;" placeholder="Fixture Venue*" wire:model="fixture_venue">
                            @error('fixture_venue') <span class="sv_error">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                            <input type="text" class="grey-form-control input-sm"  placeholder="Fixture Location*" style="padding: inherit;" id="fixturelocation" value="{{$fixture_location}}" wire:model.debounce.2s="fixture_location" autocomplete="off">
                            @error('fixture_location') <span class="sv_error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="datetime-local" class="grey-form-control input-sm" min="<?php echo date('Y-m-d'); ?>T00:00" placeholder="Fixture date & Time" wire:model="fixture_date">
                                @error('fixture_date') <span class="sv_error">{{ $message }}</span> @enderror
                            </div>
                            <!-- <div class="col-md-6">
                            <select class="select grey-form-control input-sm" wire:model="refree_id">
                                <option hidden selected>Select Refree *</option>
                                @if($refrees->isNotEmpty())
                                    @foreach($refrees as $refree)
                                    @if($refree->member->first_name != NULL)
                                        <option value="{{ $refree->member->id }}">{{ $refree->member->first_name }} {{ $refree->member->last_name }}</option>
                                    @endif
                                    @endforeach
                                @else
                                    <option disabled> Refree not ready </option>
                                @endif
                            </select>
                            @error('refree_id') <span class="sv_error">{{ $message }}</span> @enderror
                            </div> -->
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" wire:click="save_move_fixture">Create Fixture</button>
                            <button class="btn btn-default btn-lg tryagn" type="button" wire:click="cancel_button" data-bs-dismiss="modal">Cancel & Try Again</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    @endif


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
<script>
  window.addEventListener('closeModal', event=> {
	 $('#create_fixture').modal('hide')
  })
</script>
<script>
  window.addEventListener('openModal', event=> {
     $('#create_fixture').modal('show')
  })

</script>
<script>
	window.addEventListener('livewire:load', function () {
        $(document).ready(function(){
                var autocomplete ;
                var id = 'fixturelocation';
                autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
				type:['geocode'],
			    });
            });
            });
</script>

</div>
