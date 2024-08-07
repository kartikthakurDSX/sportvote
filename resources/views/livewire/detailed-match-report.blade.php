<div {{$match_fixture->fixture_type == 0 ? 'wire:poll.2500ms':''}}>

    {{--  wire:poll.2s --}}
    {{-- wire:poll.750ms --}}
    {{-- V/S Page Fixture stat detailed report. --}}
    <button class="processed" wire:click="refresh">Refresh</button>
    @if ($match_fixture->startdate_time == null)
    @else

        <div class="section-match-report">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-7 pe-0">

                        <div class="table-responsive detail-match-report">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <?php $competition = App\Models\Competition::select('id','competition_half_time','report_type')->find($match_fixture->competition_id); ?>
                                        <th colspan="4">
                                            @if ($competition->report_type == 1)
                                                Basic
                                            @else
                                                Detailed
                                            @endif Match Report
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($match_fixture->fixture_type == 3)
                                        <?php $winner_team = App\Models\Team::select('id', 'name', 'team_logo')->find($match_fixture->winner_team_id); ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="VS-pageHW">
                                                    <a href="{{ url('team/' . @$winner_team->id) }}" target="a_blank">
                                                        <img class="img-fluid rounded-circle"
                                                            src="{{ url('frontend/logo') }}/{{ @$winner_team->team_logo }}"
                                                            alt="">
                                                    </a>
                                                </div>
                                                <b class="text-center"> {{ @$winner_team->name }} promoted as Winner by
                                                    Competition Admin. </b>

                                            </td>
                                        </tr>
                                    @endif
                                    @if ($count_secondhalf_pause > 0)
                                        <tr>
                                            <td colspan="4" style="text-align:center;background-color:#062d56;">
                                                <mark> Total Pause in Second Half was
                                                    {{ $second_half_pp_time }} mins</mark>
                                            </td>
                                        </tr>
                                    @else
                                    @endif
                                    @foreach ($fixture_stat_record_second_half as $record)
                                        <?php $yellowCardCount = App\Models\Match_fixture_stat::where("match_fixture_id", $record->match_fixture_id)->where("player_id", $record->player_id)
                                            ->where("sport_stats_id", 2)->orderBy('id', 'DESC')->get();
                                        ?>
                                        @if ($record->stat_type == 1)
                                            <tr class="text-left">
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('team/' . $record->team->id) }}" target="a_blank">
                                                            <img class="img-fluid rounded-circle" src="{{ url('frontend/logo') }}/{{ $record->team->team_logo }}" alt="">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('player_profile/' . $record->player->id) }}"
                                                            target="a_blank">
                                                            <img src="{{ url('frontend/profile_pic') }}/{{ $record->player->profile_pic }}"
                                                                alt="" width="100%">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td style="width:30px;">
                                                    {{ $record->sport_stat->name }}
                                                </td>
                                                <td>
                                                @if($record->sport_stats_id == 1)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} scored a {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 2)
                                                <?php
                                                    if(count($yellowCardCount) == 2){
                                                        if($yellowCardCount[0]['id'] == $record->id){
                                                            $yellowCardWording = "received a second ".strtolower($record->sport_stat->name)." and was dismissed";
                                                        }else{
                                                            if($yellowCardCount[1]['id'] == $record->id){
                                                                $yellowCardWording = "received a ".strtolower($record->sport_stat->name);
                                                            }
                                                        }
                                                    }else{
                                                        if(count($yellowCardCount) == 1){
                                                            if($yellowCardCount[0]['id'] == $record->id){
                                                            $yellowCardWording = "received a ".strtolower($record->sport_stat->name);
                                                            }
                                                        }
                                                    }
                                                ?>
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ $yellowCardWording }} at minute

                                                @elseif($record->sport_stats_id == 3)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} received a straight {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 5)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} got an {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 47)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} committed a foul at minute

                                                @elseif($record->sport_stats_id == 52)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} conceded a penalty kick at minute

                                                @elseif($record->sport_stats_id == 49)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} conceded a corner kick at minute

                                                @elseif($record->sport_stats_id == 48)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} was {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 46)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 45)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} missed a penalty at minute

                                                @elseif($record->sport_stats_id == 44)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} had a goal disallowed at minute

                                                @elseif($record->sport_stats_id == 34)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} blocked a shot at minute

                                                @elseif($record->sport_stats_id == 33)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ strtolower($record->sport_stat->name) }}ed the ball away at minute

                                                @elseif($record->sport_stats_id == 32)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} caught the ball at minute

                                                @elseif($record->sport_stats_id == 31)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} made a {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 30)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} took a corner kick at minute

                                                @elseif($record->sport_stats_id == 29)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} won a corner kick at minute

                                                @elseif($record->sport_stats_id == 28)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} was fouled at minute

                                                @elseif($record->sport_stats_id == 27)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} stole the ball at minute

                                                @elseif($record->sport_stats_id == 26)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} intercepted the ball at minute

                                                @elseif($record->sport_stats_id == 25)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} won a penalty kick at minute

                                                @elseif($record->sport_stats_id == 24)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} missed a penalty kick at minute

                                                @elseif($record->sport_stats_id == 23)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} scored from a penalty at minute

                                                @elseif($record->sport_stats_id == 22)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 21)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} attempted a {{ strtolower($record->sport_stat->name) }} at minute
                                                @else
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} scored a {{ strtolower($record->sport_stat->name) }} at minute
                                                @endif
                                                    @if ($competition->competition_half_time > $record->stat_time_record)

                                                        @php
                                                            $value1 = explode(':', $record->stat_time_record);
                                                            $value_count = count($value1);
                                                            if($value_count == 3){
                                                            $sec1 = $value1[1] * 60 + $value1[2];
                                                            }else{
                                                            $sec1 = $value1[0] * 60 + $value1[1];
                                                            }
                                                             $value2 = explode(':', $record->stat_diff);

                                                             $sec2 = $value2[0] * 60 + $value2[1];

                                                             $cal_time = $sec1 - $sec2;

                                                            $hours = floor($cal_time / (60 * 60));//hour
                                                            $cal_time %= (60 * 60);
                                                            $mins = floor($cal_time / 60);//min
                                                            $cal_time %= 60;
                                                            $secs = $cal_time;

                                                        @endphp
                                                    @if ($secs < 10)

                                                    {{$mins.':0'.$secs}}
                                                    @else
                                                    {{ $mins.':'.$secs }}
                                                    @endif
                                                    @else
                                                        <?php
                                                        $time_split = explode(':', $record->stat_time_record);
                                                        $mins1 = $time_split[0];
                                                        $sec1 = $time_split[1];
                                                        if ($mins1 > $competition->competition_half_time) {
                                                            $half_time1 = (int) $mins1 - $competition->competition_half_time;
                                                            if ($half_time1 < 9) {
                                                                $min1 = '0' . $half_time1;
                                                            } else {
                                                                $min1 = $half_time1;
                                                            }
                                                        } else {
                                                            $half_time1 = '00';
                                                            $min1 = '00';
                                                        }
                                                        ?>
                                                        + {{ $min1 }}:{{ $sec1 }} second
                                                    @endif in second half
                                                </td>
                                            </tr>
                                        @elseif($record->stat_type == 3)
                                            <?php   $fixture_substituteData = App\Models\Fixture_substitute::find($record->fixture_substitute_id);
                                                $substitute_playerData = App\Models\User::find($fixture_substituteData->sub_player_id); ?>

                                            <tr class="text-left">
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('team/' . $record->team->id) }}"
                                                            target="a_blank">
                                                            <img class="img-fluid rounded-circle"
                                                                src="{{ url('frontend/logo') }}/{{ $record->team->team_logo }}"
                                                                alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('player_profile/' . $record->player->id) }}"
                                                            target="a_blank">
                                                            <img src="{{ url('frontend/profile_pic') }}/{{ $record->player->profile_pic }}"
                                                                alt="" width="100%">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td style="width:30px;">
                                                    {{ $record->sport_stat->name }}
                                                </td>
                                                <td>
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }}
                                                    was replaced by {{$substitute_playerData->first_name}} {{$substitute_playerData->last_name}} at minute
                                                    @if ($competition->competition_half_time > $record->stat_time_record)

                                                        @php
                                                            $value1 = explode(':', $record->stat_time_record);
                                                            $value_count = count($value1);
                                                            if($value_count == 3){
                                                            $sec1 = $value1[1] * 60 + $value1[2];
                                                            }else{
                                                            $sec1 = $value1[0] * 60 + $value1[1];
                                                            }
                                                             $value2 = explode(':', $record->stat_diff);

                                                             $sec2 = $value2[0] * 60 + $value2[1];

                                                             $cal_time = $sec1 - $sec2;

                                                            $hours = floor($cal_time / (60 * 60));//hour
                                                            $cal_time %= (60 * 60);
                                                            $mins = floor($cal_time / 60);//min
                                                            $cal_time %= 60;
                                                            $secs = $cal_time;

                                                        @endphp
                                                    @if ($secs < 10)

                                                    {{$mins.':0'.$secs}}
                                                    @else
                                                    {{ $mins.':'.$secs }}
                                                    @endif
                                                    @else
                                                        <?php
                                                        $time_split = explode(':', $record->stat_time_record);
                                                        $mins1 = $time_split[0];
                                                        $sec1 = $time_split[1];
                                                        if ($mins1 > $competition->competition_half_time) {
                                                            $half_time1 = (int) $mins1 - $competition->competition_half_time;
                                                            if ($half_time1 < 9) {
                                                                $min1 = '0' . $half_time1;
                                                            } else {
                                                                $min1 = $half_time1;
                                                            }
                                                        } else {
                                                            $half_time1 = '00';
                                                            $min1 = '00';
                                                        }
                                                        ?>
                                                        + {{ $min1 }}:{{ $sec1 }} second
                                                    @endif in second half
                                                </td>

                                            </tr>
                                        @elseif($record->stat_type == 4)
                                            <tr class="text-left">
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('team/' . $record->team->id) }}"
                                                            target="a_blank">
                                                            <img class="img-fluid rounded-circle"
                                                                src="{{ url('frontend/logo') }}/{{ $record->team->team_logo }}"
                                                                alt=""></a>
                                                    </div>
                                                </td>
                                                <td>

                                                </td>
                                                <td style="width:30px;">
                                                    {{ $record->sport_stat->name }}
                                                </td>
                                                <td>
                                                    {{ $record->team->name }} was awarded an {{ strtolower($record->sport_stat->name) }} at minute
                                                    @if ($competition->competition_half_time > $record->stat_time_record)

                                                        @php

                                                            $value1 = explode(':', $record->stat_time_record);
                                                            $value_count = count($value1);
                                                            if($value_count == 3){
                                                            $sec1 = $value1[1] * 60 + $value1[2];
                                                            }else{
                                                            $sec1 = $value1[0] * 60 + $value1[1];
                                                            }
                                                             $value2 = explode(':', $record->stat_diff);

                                                             $sec2 = $value2[0] * 60 + $value2[1];

                                                             $cal_time = $sec1 - $sec2;

                                                            $hours = floor($cal_time / (60 * 60));//hour
                                                            $cal_time %= (60 * 60);
                                                            $mins = floor($cal_time / 60);//min
                                                            $cal_time %= 60;
                                                            $secs = $cal_time;

                                                        @endphp
                                                    @if ($secs < 10)

                                                    {{$mins.':0'.$secs}}
                                                    @else
                                                    {{ $mins.':'.$secs }}
                                                    @endif
                                                    @else
                                                        <?php
                                                        $time_split = explode(':', $record->stat_time_record);
                                                        $mins1 = $time_split[0];
                                                        $sec1 = $time_split[1];
                                                        if ($mins1 > $competition->competition_half_time) {
                                                            $half_time1 = (int) $mins1 - $competition->competition_half_time;
                                                            if ($half_time1 < 9) {
                                                                $min1 = '0' . $half_time1;
                                                            } else {
                                                                $min1 = $half_time1;
                                                            }
                                                        } else {
                                                            $half_time1 = '00';
                                                            $min1 = '00';
                                                        }
                                                        ?>
                                                        + {{ $min1 }}:{{ $sec1 }} second
                                                    @endif in second half
                                                </td>

                                            </tr>
                                        @else
                                            <?php
                                            if ($record->sport_stat->id == 14) {
                                                $tr_class = 'table-danger';
                                            } elseif ($record->sport_stat->id == 13) {
                                                $tr_class = 'table-warning';
                                            } else {
                                                $tr_class = 'table-info';
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="4" style="text-align:center;">
                                                    Match {{ $record->sport_stat->name }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @if ($count_firsthalf_pause > 0)
                                        <tr>
                                            <td colspan="4" style="text-align:center;background-color:#062d56;">
                                                <mark> Total Pause in First Half was
                                                    {{ $first_half_pp_time }} mins </mark>
                                            </td>
                                        </tr>
                                    @else
                                    @endif

                                    @foreach ($fixture_stat_record as $record)
                                        <?php $yellowCardCount = App\Models\Match_fixture_stat::where("match_fixture_id", $record->match_fixture_id)->where("player_id", $record->player_id)
                                            ->where("sport_stats_id", 2)->orderBy('id', 'DESC')->get();
                                            ?>
                                        @if ($record->stat_type == 1)
                                            <tr class="text-left">
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('team/' . $record->team->id) }}"
                                                            target="a_blank">
                                                            <img class="img-fluid rounded-circle"
                                                                src="{{ url('frontend/logo') }}/{{ $record->team->team_logo }}"
                                                                alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('player_profile/' . $record->player->id) }}"
                                                            target="a_blank">
                                                            <img src="{{ url('frontend/profile_pic') }}/{{ $record->player->profile_pic }}"
                                                                alt="" width="100%">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td style="width:30px;">
                                                    {{ $record->sport_stat->name }}
                                                </td>

                                                <td>
                                                @if($record->sport_stats_id == 1)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} scored a {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 2)
                                                <?php
                                                    if(count($yellowCardCount) == 2){
                                                        if($yellowCardCount[0]['id'] == $record->id){
                                                            $yellowCardWording = "received a second ".strtolower($record->sport_stat->name)." and was dismissed";
                                                        }else{
                                                            if($yellowCardCount[1]['id'] == $record->id){
                                                                $yellowCardWording = "received a ".strtolower($record->sport_stat->name);
                                                            }
                                                        }
                                                    }else{
                                                        if(count($yellowCardCount) == 1){
                                                            if($yellowCardCount[0]['id'] == $record->id){
                                                            $yellowCardWording = "received a ".strtolower($record->sport_stat->name);
                                                            }
                                                        }
                                                    }
                                                ?>
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ $yellowCardWording }} at minute

                                                @elseif($record->sport_stats_id == 3)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} received a straight {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 5)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} got an {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 47)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} committed a foul at minute

                                                @elseif($record->sport_stats_id == 52)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} conceded a penalty kick at minute

                                                @elseif($record->sport_stats_id == 49)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} conceded a corner kick at minute

                                                @elseif($record->sport_stats_id == 48)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} was {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 46)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 45)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} missed a penalty at minute

                                                @elseif($record->sport_stats_id == 44)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} had a goal disallowed at minute

                                                @elseif($record->sport_stats_id == 34)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} blocked a shot at minute

                                                @elseif($record->sport_stats_id == 33)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ strtolower($record->sport_stat->name) }}ed the ball away at minute

                                                @elseif($record->sport_stats_id == 32)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} caught the ball at minute

                                                @elseif($record->sport_stats_id == 31)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} made a {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 30)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} took a corner kick at minute

                                                @elseif($record->sport_stats_id == 29)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} won a corner kick at minute

                                                @elseif($record->sport_stats_id == 28)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} was fouled at minute

                                                @elseif($record->sport_stats_id == 27)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} stole the ball at minute

                                                @elseif($record->sport_stats_id == 26)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} intercepted the ball at minute

                                                @elseif($record->sport_stats_id == 25)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} won a penalty kick at minute

                                                @elseif($record->sport_stats_id == 24)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} missed a penalty kick at minute

                                                @elseif($record->sport_stats_id == 23)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} scored from a penalty at minute

                                                @elseif($record->sport_stats_id == 22)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} {{ strtolower($record->sport_stat->name) }} at minute

                                                @elseif($record->sport_stats_id == 21)
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} attempted a {{ strtolower($record->sport_stat->name) }} at minute
                                                @else
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }} scored a {{ strtolower($record->sport_stat->name) }} at minute
                                                @endif
                                                    @if ($competition->competition_half_time > $record->stat_time_record)

                                                        @php

                                                            $value1 = explode(':', $record->stat_time_record);
                                                            $value_count = count($value1);
                                                            if($value_count == 3){
                                                            $sec1 = $value1[1] * 60 + $value1[2];
                                                            }else{
                                                            $sec1 = $value1[0] * 60 + $value1[1];
                                                            }

                                                             $value2 = explode(':', $record->stat_diff);

                                                             $sec2 = $value2[0] * 60 + $value2[1];

                                                             $cal_times = $sec1 - $sec2;



                                                            $hours = floor($cal_times / (60 * 60));
                                                            $cal_times %= (60 * 60);
                                                            $mins = floor($cal_times / 60);
                                                            $cal_times %= 60;
                                                            $secs = $cal_times;

                                                        @endphp
                                                    @if ($secs < 10)

                                                    {{$mins.':0'.$secs}}
                                                    @else
                                                    {{ $mins.':'.$secs }}
                                                    @endif


                                                    @else
                                                        <?php
                                                        $time_split = explode(':', $record->stat_time_record);
                                                        $mins = $time_split[0];
                                                        $sec = $time_split[1];
                                                        if ($mins > $competition->competition_half_time) {
                                                            $half_time = (int) $mins - $competition->competition_half_time;
                                                            if ($half_time < 9) {
                                                                $min = '0' . $half_time;
                                                            } else {
                                                                $min = $half_time;
                                                            }
                                                        } else {
                                                            $half_time = '00';
                                                            $min = '00';
                                                        }
                                                        ?>
                                                        + {{ $min }}:{{ $sec }}
                                                    @endif
                                                    in first half.
                                                </td>
                                            </tr>
                                        @elseif($record->stat_type == 3)
                                        <?php   $fixture_substituteData = App\Models\Fixture_substitute::find($record->fixture_substitute_id);
                                                $substitute_playerData = App\Models\User::find($fixture_substituteData->sub_player_id); ?>
                                            <tr class="text-left">
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('team/' . $record->team->id) }}"
                                                            target="a_blank">
                                                            <img class="img-fluid rounded-circle"
                                                                src="{{ url('frontend/logo') }}/{{ $record->team->team_logo }}"
                                                                alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('player_profile/' . $record->player->id) }}"
                                                            target="a_blank">
                                                            <img src="{{ url('frontend/profile_pic') }}/{{ $record->player->profile_pic }}"
                                                                alt="" width="100%">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td style="width:30px;">
                                                    {{ $record->sport_stat->name }}
                                                </td>

                                                <td>
                                                    {{ $record->player->first_name }} {{ $record->player->last_name }}
                                                    was replaced by {{$substitute_playerData->first_name}} {{$substitute_playerData->last_name}} at minute
                                                    @if ($competition->competition_half_time > $record->stat_time_record)

                                                        @php

                                                            $value1 = explode(':', $record->stat_time_record);
                                                            $value_count = count($value1);
                                                            if($value_count == 3){
                                                            $sec1 = $value1[1] * 60 + $value1[2];
                                                            }else{
                                                            $sec1 = $value1[0] * 60 + $value1[1];
                                                            }

                                                             $value2 = explode(':', $record->stat_diff);

                                                             $sec2 = $value2[0] * 60 + $value2[1];

                                                             $cal_times = $sec1 - $sec2;



                                                            $hours = floor($cal_times / (60 * 60));
                                                            $cal_times %= (60 * 60);
                                                            $mins = floor($cal_times / 60);
                                                            $cal_times %= 60;
                                                            $secs = $cal_times;

                                                        @endphp
                                                    @if ($secs < 10)

                                                    {{$mins.':0'.$secs}}
                                                    @else
                                                    {{ $mins.':'.$secs }}
                                                    @endif


                                                    @else
                                                        <?php
                                                        $time_split = explode(':', $record->stat_time_record);
                                                        $mins = $time_split[0];
                                                        $sec = $time_split[1];
                                                        if ($mins > $competition->competition_half_time) {
                                                            $half_time = (int) $mins - $competition->competition_half_time;
                                                            if ($half_time < 9) {
                                                                $min = '0' . $half_time;
                                                            } else {
                                                                $min = $half_time;
                                                            }
                                                        } else {
                                                            $half_time = '00';
                                                            $min = '00';
                                                        }
                                                        ?>
                                                        + {{ $min }}:{{ $sec }}
                                                    @endif
                                                    in first half.
                                                </td>
                                            </tr>
                                        @elseif($record->stat_type == 4)
                                            <tr class="text-left">
                                                <td>
                                                    <div class="VS-pageHW">
                                                        <a href="{{ url('team/' . $record->team->id) }}"
                                                            target="a_blank">
                                                            <img class="img-fluid rounded-circle"
                                                                src="{{ url('frontend/logo') }}/{{ $record->team->team_logo }}"
                                                                alt=""></a>
                                                    </div>
                                                </td>
                                                <td>
                                                </td>
                                                <td style="width:30px;">
                                                    {{ $record->sport_stat->name }}
                                                </td>

                                                <td>
                                                    {{ $record->team->name }} was awarded an {{ $record->sport_stat->name }} at minute
                                                    @if ($competition->competition_half_time > $record->stat_time_record)

                                                        @php

                                                            $value1 = explode(':', $record->stat_time_record);
                                                            $value_count = count($value1);
                                                            if($value_count == 3){
                                                            $sec1 = $value1[1] * 60 + $value1[2];
                                                            }else{
                                                            $sec1 = $value1[0] * 60 + $value1[1];
                                                            }

                                                             $value2 = explode(':', $record->stat_diff);

                                                             $sec2 = $value2[0] * 60 + $value2[1];

                                                             $cal_times = $sec1 - $sec2;



                                                            $hours = floor($cal_times / (60 * 60));
                                                            $cal_times %= (60 * 60);
                                                            $mins = floor($cal_times / 60);
                                                            $cal_times %= 60;
                                                            $secs = $cal_times;

                                                        @endphp
                                                    @if ($secs < 10)

                                                    {{$mins.':0'.$secs}}
                                                    @else
                                                    {{ $mins.':'.$secs }}
                                                    @endif


                                                    @else
                                                        <?php
                                                        $time_split = explode(':', $record->stat_time_record);
                                                        $mins = $time_split[0];
                                                        $sec = $time_split[1];
                                                        if ($mins > $competition->competition_half_time) {
                                                            $half_time = (int) $mins - $competition->competition_half_time;
                                                            if ($half_time < 9) {
                                                                $min = '0' . $half_time;
                                                            } else {
                                                                $min = $half_time;
                                                            }
                                                        } else {
                                                            $half_time = '00';
                                                            $min = '00';
                                                        }
                                                        ?>
                                                        + {{ $min }}:{{ $sec }}
                                                    @endif
                                                    in first half.
                                                </td>
                                            </tr>
                                        @else
                                            <?php
                                            if ($record->sport_stat->id == 14) {
                                                $tr_class = 'table-danger';
                                            } elseif ($record->sport_stat->id == 13) {
                                                $tr_class = 'table-warning';
                                            } else {
                                                $tr_class = 'table-info';
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="4" style="text-align:center;">
                                                    Match {{ $record->sport_stat->name }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-4 pe-0 ps-0">
                        <div class="table-responsive match-stats-report">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="4">Match Stats
                                            <!-- <span class="float-md-end"><button class="btn btn-green"><img src="images/noun_stats.png" alt="" class="btn-icon">Submit detailed Stats</button></span> -->
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td colspan="4">
                                            <div class="float-md-start">
                                                <a href="{{ url('team/' . $teamOne->id) }}" target="a_blank"
                                                    style="color:#fff;"><img class="VS-pageHW rounded-circle"
                                                        src="{{ url('frontend/logo') }}/{{ $teamOne->team_logo }}"
                                                        alt="" /> {{ $teamOne->name }}</a>
                                            </div>


                                            <div class="float-md-end">
                                                <a href="{{ url('team/' . $teamTwo->id) }}" target="a_blank"
                                                    style="color:#fff;">{{ $teamTwo->name }} <img
                                                        class="VS-pageHW rounded-circle"
                                                        src="{{ url('frontend/logo') }}/{{ $teamTwo->team_logo }}"
                                                        alt="" /></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($player_stats as $t_stat)
                                        @if($t_stat->id == 1)
                                        <tr>
                                            <td class="text-center" width="30">
                                                {{$totalTeam1Goal}}
                                            </td>
                                            <td colspan="2" class="text-center">{{ $t_stat->description }}</td>
                                            <td class="text-center" width="30">
                                                {{$totalTeam2Goal}}
                                            </td>
                                        </tr>
                                        @else
                                        @endif
                                        @if($t_stat->id != 53 && $t_stat->id != 1 && $t_stat->id != 54)
                                            <?php $stats_teamone = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                                                ->where('team_id', $teamOne->id)
                                                ->where('sport_stats_id', $t_stat->id)
                                                ->get(); ?>
                                            <?php $stats_teamtwo = App\Models\Match_fixture_stat::where('match_fixture_id', $match_fixture->id)
                                                ->where('team_id', $teamTwo->id)
                                                ->where('sport_stats_id', $t_stat->id)
                                                ->get();
                                            ?>
                                        <tr>
                                            <td class="text-center" width="30">
                                                @if ($stats_teamone)
                                                    {{ $stats_teamone->count() }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td colspan="2" class="text-center">{{ $t_stat->description }}</td>
                                            <td class="text-center" width="30">
                                                @if ($stats_teamtwo)
                                                    {{ $stats_teamtwo->count() }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        </tr>
                                        @else
                                        @endif
                                    @endforeach
                                    <tr>
                                        <?php
                                            $teamOne_substitue_player_count = App\Models\Fixture_substitute::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamOne->id)
                                            ->count();
                                            $teamTwo_substitue_player_count = App\Models\Fixture_substitute::where('match_fixture_id', $match_fixture->id)
                                            ->where('team_id', $teamTwo->id)
                                            ->count();
                                        ?>
                                        <td class="text-center" width="30">
                                            @if($teamOne_substitue_player_count)
                                                {{$teamOne_substitue_player_count}}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td colspan="2" class="text-center">Substitutions</td>
                                        <td class="text-center" width="30">
                                            @if($teamTwo_substitue_player_count)
                                                {{$teamTwo_substitue_player_count}}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
