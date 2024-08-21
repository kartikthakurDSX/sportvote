<style>
    .owlTableMatchGoal.matchPointTable.owl-carousel.owl-theme {
        display: block !important;
    }
</style>

<div wire:poll.5s>
    <div class="owlTableMatchGoal matchPointTable owl-carousel owl-theme">
        @php
        function customSort($a, $b) {
            if ($a["points"] > $b["points"]) {
                return -1;
            } elseif ($a["points"] < $b["points"]) {
                return 1;
            } else {
                if ($a["second_priority"] > $b["second_priority"]) {
                    return -1;
                } elseif ($a["second_priority"] < $b["second_priority"]) {
                    return 1;
                } else {
                    if ($a["third_priority"] > $b["third_priority"]) {
                        return -1;
                    } elseif ($a["third_priority"] < $b["third_priority"]) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
        }

        usort($table_data, "customSort");
        $table_data_chunks = array_chunk($table_data, 5, true);
        $i = 1;
        @endphp

        @foreach($table_data_chunks as $data)
        <div class="item">
            <div class="TableBox d-flex">
                <table style="width:25%">
                    <tr class="tableHeader">
                        <th colspan="2">
                            <p class="mb-0 SlectTableGroup">
                                @php
                                $competition = App\Models\Competition::find($comp_id);
                                $comp_type = App\Models\CompSubType::find($competition->comp_subtype_id);
                                @endphp
                                {{$comp_type->name}}
                            </p>
                        </th>
                    </tr>
                    @foreach($data as $key => $team_info)
                    <?php
                    $update_rank = App\Models\Competition_team_request::where('competition_id', $comp_id)->where('team_id', $team_info["team_id"])->limit(1)->update(['rank' => $i]);
                    ?>
                    <tr>
                        <td>
                            <div class="text-left list-group list-group-numbered">
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <span>{{$i}} &nbsp;</span>
                                    <a href="{{url('team')}}/{{$team_info['team_id']}}" target="_blank">  <img class="img-fluid rounded-circle padd-RL" src="{{url('frontend/logo')}}/{{$team_info['team_logo']}}" width="25%"> </a>
                                    <div class="ms-2 me-auto EngCity">
                                        <div class=" ManCity"><a href="{{url('team')}}/{{$team_info['team_id']}}" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="" title="{{$team_info['team_name']}}"> @php echo Str::of($team_info['team_name'])->limit(6); @endphp </a></div>
                                        <?php $team_info = App\Models\Team::select('country_id')->find($team_info['team_id']);
                                        $country_code = App\Models\Country::select('iso3', 'name')->find($team_info->country_id); ?>
                                        {{$country_code->iso3}}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </table>

                <table class="tableCol2" style="width:25%">
                    <tbody>
                        <tr class="matchStatsTable">
                            <th colspan="4">MATCH STATS</th>
                        </tr>
                        <tr class="tableHeader tableHeader01">
                            <th>
                                PLAYED
                            </th>
                            <th>
                                WON
                            </th>
                            <th>
                                DRAW
                            </th>
                            <th>
                                LOST
                            </th>
                        </tr>
                        @foreach($data as $team_info)
                        <tr>
                            <td>{{$team_info['played']}}</td>
                            <td>{{$team_info['won']}}</td>
                            <td>{{$team_info['draw']}}</td>
                            <td>{{$team_info['lost']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="tableCol3" style="width:25%">
                    <tbody class="borderleft">
                        <tr class="matchStatsTable matchStatsTable02">
                            <th colspan="4">ALL GOAL STATS</th>
                        </tr>
                        <tr class="tableHeader tableHeader02 ">
                            <th>
                                FOR
                            </th>
                            <th>
                                AGAINST
                            </th>
                            <th>
                                DIFFER
                            </th>
                        </tr>
                        @foreach($data as $team_info)
                        <tr>
                            <td>{{$team_info['goals_for']}} </td>
                            <td>{{$team_info['againts_goals']}} </td>
                            <td>{{$team_info['goal_differ']}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="" style="width:25%">
                    <tr class="tableHeader">
                        <th class="PointsFormsTable">
                            <span class="Points">POINTS & FORMS</span>
                        </th>
                    </tr>
                    @foreach($data as $team_info)
                    <?php
                    $points = $team_info['points'];
                    $team_id = $team_info['team_id'];
                    $fixtures = App\Models\Match_fixture::select('winner_team_id')->where(function ($query) use ($team_id) {
                        $query->where('teamOne_id', '=', $team_id)
                            ->orWhere('teamTwo_id', '=', $team_id);
                    })->where('competition_id', $comp_id)->where('finishdate_time', '!=', Null)->limit(5)->orderBy('finishdate_time', 'ASC')->get();

                    ?>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between">
                                <div class="avatar-group">
                                    @foreach($fixtures as $fixture)
                                    @if($fixture->winner_team_id == $team_id)
                                    <div class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="">
                                        <a class="d-inline-block js-contract-edit-icon">
                                            <div class="PointForm3"></div>
                                        </a>
                                    </div>
                                    @elseif($fixture->winner_team_id == 0)
                                    <div class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="">
                                        <a class="d-inline-block js-contract-edit-icon" data-url="">
                                            <div class="PointForm4"></div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="">
                                        <a class="d-inline-block js-contract-edit-icon">
                                            <div class="PointForm2"></div>
                                        </a>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="avatar-group-item" data-toggle="tooltip" data-placement="top" title="">
                                        <div class="PointForm">{{$points}}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
