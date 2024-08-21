<span>
    <div class="row">
        <div class="col-lg-7 col-md-6 pe-0 content ">
            <form class="" enctype="multipart/form-data">
                <div class="competition-list mb-3">
                    <ul class="games-list owl-4-slider owl-carousel owl-loaded owl-drag">
                        <li class="item"><input type="radio" name="sport_id" value="1" checked id="soccer"
                                wire:model="game_id"><label for="competition"><span> Soccer </span><i
                                    class="icon-check checked-badge"></i></label></li>
                        <li class="item" wire:click="notready_game"><input type="radio" name="sport_id"
                                value="2" id="Basketball" wire:model="game_id"><label
                                for="competition"><span>Basketball </span><i
                                    class="icon-check checked-badge"></i></label></li>
                        <li class="item" wire:click="notready_game"><input type="radio" name="sport_id"
                                value="3" id="Cricket" wire:model="game_id"><label for="competition"><span>
                                    Cricket </span><i class="icon-check checked-badge"></i></label></li>
                        <li class="item" wire:click="notready_game"><input type="radio" name="sport_id"
                                value="4" id="Volleyball" wire:model="game_id"><label for="competition"><span>
                                    Volleyball </span><i class="icon-check checked-badge"></i></label></li>
                        <li class="item" wire:click="notready_game"><input type="radio" name="sport_id"
                                value="5" id="Rugby" wire:model="game_id"><label for="competition"><span> Rugby
                                </span><i class="icon-check checked-badge"></i></label></li>
                        <li class="item" wire:click="notready_game"><input type="radio" name="sport_id"
                                value="6" id="Hockey" wire:model="game_id"><label for="competition"><span>
                                    Hockey </span><i class="icon-check checked-badge"></i></label></li>
                    </ul>
                </div>
                <div class="soccer-form-data  pe-2 selectt" id="soccer-form">
                    @if ($current_step)
                        <!-- One "tab" for each step in the form: -->
                        <div class="row setup-content">
                            <p class="Step1-Comp mb-3"><span class="StepOne">Step 1:</span> Define Competition type &
                                basic Details </p>
                            <div class="row mb-3">
                                <div class=" col-md-12 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="text" placeholder=" "
                                                wire:model="comp_name" wire:blur="create_comp">
                                            <span class="highlight"></span>
                                            <label>Competition Name *</label>
                                        </div>
                                    </div>
                                    @error('comp_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class=" col-md-6 FlotingLabelUp ">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="text" placeholder=" " id="location"
                                                value="{{ $comp_location }}" wire:model.debounce.120s="comp_location"
                                                autocomplete="off">
                                            <span class="highlight"></span>
                                            <label>Location *</label>
                                            <span class="input-group-text apicon"><i class="icon-map-marker"></i></span>
                                        </div>
                                    </div>
                                    @error('comp_location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class=" col-md-6 FlotingLabelUp ">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <select class="floating-select"
                                                onclick="this.setAttribute('value', this.value);"
                                                value="{{ $comp_half_time }}" wire:model.lazy="comp_half_time"
                                                wire:change="linup_player">
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                                <option value="30">30</option>
                                                <option value="35">35</option>
                                                <option value="40">40</option>
                                                <option value="45">45</option>

                                            </select>
                                            <span class="highlight"></span>
                                            <label>Match time per half (in mins)*</label>
                                        </div>
                                    </div>
                                    @error('comp_half_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                @foreach ($com_type as $com)
                                    <div class=" col-sm-4 col-xs-4">
                                        <div class="form-check radio-competion-type">
                                            <label for="one_off_game"><img
                                                    src="{{ asset('frontend/images/') . '/' . $com->icon }}"
                                                    alt="trophy">
                                                <span>{{ $com->name }}</span></label>
                                            <input type="radio" name="comp_type_id" class="form-check-input radio-fancy" wire:change="comp_type({{$com->id}})" {{$loop->first ? 'checked' : ''}} {{$comp_typeid == $com->id ? 'checked' : ''}} >
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($comp_type)
                                <div class="row mb-3">
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);"
                                                    value="{{ $comp_sub_type_id }}"
                                                    wire:model.lazy="comp_sub_type_id" wire:change="team_number">
                                                    <option value=""></option>
                                                    @foreach ($comp_sub_type as $comp_sub)
                                                        <option value="{{ $comp_sub->id }}">{{ $comp_sub->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="highlight"></span>
                                                <label>Select Comp Sub Type</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);"
                                                    value="{{ $team_num }}" wire:model.lazy="team_num"
                                                    wire:click = "select_team_number">
                                                    {{ $team_num }}
                                                    <option value=""></option>

                                                    @for ($i = $team_min; $i <= $team_max; $i++)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @endfor
                                                    @if ($comp_sub_type_id == 3)
                                                        <option value = "64">64</option>
                                                        <option value = "128">128</option>
                                                    @else
                                                    @endif
                                                </select>
                                                <span class="highlight"></span>
                                                <label>Number of Teams to Play</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row mb-3">
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1" id="datepickerfield">
                                                <input class="floating-input" type="text"
                                                    onclick="(this.type='date')" placeholder=" "
                                                    value="{{ $comp_start_datetime }}"
                                                    wire:model.debounce.120s="comp_start_datetime">
                                                <span class="highlight"></span>
                                                <label>Start Date *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class=" col-md-6 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <span class="round01"></span>
                                        <div class="floating-label form-select-fancy-1">
                                            <select class="floating-select"
                                                onclick="this.setAttribute('value', this.value);"
                                                value="{{ $squad_player }}" wire:model.lazy="squad_player"
                                                wire:change="linup_player">
                                                <option value=""></option>
                                                @for ($i = 1; $i <= 20; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <span class="highlight"></span>
                                            <label>Players per Team</label>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <span class="round01"></span>
                                        <div class="floating-label form-select-fancy-1">
                                            <select class="floating-select"
                                                onclick="this.setAttribute('value', this.value);"
                                                value="{{ $linup_player }}" wire:model.lazy="linup_player"
                                                wire:change="select_linup">
                                                <option value=""></option>
                                                @for ($i = 1; $i <= $start_linup_player; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <span class="highlight"></span>
                                            <label>Players in Starting Linup</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" col-md-6 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <span class="round01"></span>
                                        <div class="floating-label form-select-fancy-1">
                                            <select class="floating-select"
                                                onclick="this.setAttribute('value', this.value);"
                                                value="{{ $comp_report_type }}" wire:model.lazy="comp_report_type"
                                                wire:change="report_name">
                                                <option value=""></option>
                                                @foreach ($com_report_type as $comp_report)
                                                    <option value="{{ $comp_report->id }}">{{ $comp_report->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <label>Select Match Report Type</label>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <span class="round01"></span>
                                        <div class="floating-label form-select-fancy-1">
                                            <select class="floating-select"
                                                onclick="this.setAttribute('value', this.value);"
                                                value="{{ $vote_min }}" wire:model.lazy="vote_min">
                                                <option value=""></option>
                                                <option value="2">2</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                                <option value="30">30</option>
                                            </select>
                                            <span class="highlight"></span>
                                            <label>Fan MVP Vote Timer Length</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-control form-select-fancy-1"
                                        aria-label=".form-select-lg example">
                                        Competition Admin
                                    </label>
                                </div>
                                <div class="col-lg-8 multi-button mb-3 d-flex">
                                    <div class="col-10">
                                        <select id="select_admin" class="form-control form-select-fancy-1"
                                            aria-label=".form-select-lg example" multiple wire:model.lazy="member_id">
                                            @foreach ($admin as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }}
                                                    {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-default float-end btn-round-submit"
                                            wire:click="send_request_admin"><i class="icon-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-control form-select-fancy-1"
                                        aria-label=".form-select-lg example">
                                        Competition Referee *
                                    </label>
                                </div>
                                <div class="col-lg-8 multi-button mb-3 d-flex ">
                                    <div class="col-10">
                                        <select id="select_referee" class="form-control form-select-fancy-1"
                                            aria-label=".form-select-lg example" multiple
                                            wire:model.lazy="referee_id">
                                            @foreach ($referees as $referee)
                                                <option value="{{ $referee->user->id }}">
                                                    {{ $referee->user->first_name }} {{ $referee->user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-default float-end btn-round-submit"
                                            wire:click="send_request_referee">
                                            <i class="icon-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('referee_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class=" col-md-12 FlotingLabelUp ">
                                    <div class="floating-form  ">
                                        <div class="floating-label ">
                                            <textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30"
                                                rows="5" value="{{ $comp_desc }}" wire:model.lazy="comp_desc" placeholder=" "></textarea>
                                            <span class="highlight"></span>
                                            <label class="TeamDescrForm">About Us</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-block mt-3">
                                <button type="button" class="btn col-5 btn-default btn-cancel"
                                    wire:click="reset_step_one">Cancel</button>
                                <button type="button" class="btn col-5 btn-submit float-md-end"
                                    wire:click="next_step">Save & Continue</button>
                            </div>
                        </div>
                    @elseif($next_step)
                        <div class="row setup-content">
                            @if ($comp_report_type == 2)
                                <h4>
                                    <p class="Step1-Comp mb-3"><span class="StepOne">Step 2: Select Stats & Ranking
                                            Mechanism</span> </p>
                                </h4>
                                <div class="select-league-table round-check-box" wire:ignore>
                                    <h5>Select Player Stats you would like to track</h5>
                                    <div class="scrollchakmartList">
                                        <div class="row">
                                            @foreach ($team_stats as $stat)
                                                <div class=" col-6">
                                                    <div class="form-check">
                                                        @if (in_array($stat->id, $comp_team_stat))
                                                            <input class="round-check-box" type="checkbox"
                                                                value="{{ $stat->id }}"
                                                                id="Played.{{ $stat->id }}"
                                                                wire:model= "comp_team_stat.{{ $loop->index }}"
                                                                disabled>
                                                        @else
                                                            <input class="round-check-box" type="checkbox"
                                                                value="{{ $stat->id }}"
                                                                id="Played.{{ $stat->id }}"
                                                                wire:model= "comp_team_stat.{{ $loop->index }}">
                                                        @endif
                                                        <label class="form-check-label" for="Played">
                                                            {{ $stat->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <br>
                            @else
                            @endif
                            @if (!$comp_type)
                                <div class="row m-4">
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);"
                                                    value="{{ $teamOne }}" wire:model="teamOne"
                                                    wire:change="team1">
                                                    <option value=""></option>
                                                    @if ($teams)
                                                        @foreach ($teams as $team)
                                                            <option value="{{ $team->id }}">{{ $team->name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option disabled>Select Competition Level</option>
                                                    @endif
                                                </select>
                                                <span class="highlight"></span>
                                                <label>Search & Select Team 1 </label>
                                            </div>
                                        </div>
                                        @error('teamOne')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);"
                                                    value="{{ $teamTwo }}" wire:model="teamTwo"
                                                    wire:change="team2">
                                                    <option value=""></option>
                                                    @if ($teams)
                                                        @foreach ($teams as $team)
                                                            @if ($teamOne != $team->id)
                                                                <option value="{{ $team->id }}">
                                                                    {{ $team->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option disabled>Select Competition Level</option>
                                                    @endif
                                                </select>
                                                <span class="highlight"></span>
                                                <label>Search & Select team 2 </label>
                                            </div>
                                        </div>
                                        @error('teamTwo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="BgBlueVS">
                                    <div class="row">
                                        <div class="col-md-6 col-6 borR">
                                            <div class="row">
                                                <div class="col-md-5 m-auto text-center">
                                                    <div class="bgBlueVs">
                                                        <div class="game-logo m-auto">
                                                            @if (!empty($team_detail))
                                                                <a href="{{ url('team/' . $team_detail->id) }}"
                                                                    target="a_blank">
                                                                    <img src="{{ url('frontend/logo') }}/{{ $team_detail->team_logo }}"
                                                                        alt="SportVote Logo" class="img-fluid">
                                                                </a>
                                                            @else
                                                                <img src="{{ url('frontend/logo/competitions-icon-128.png') }}"
                                                                    alt="SportVote Logo" class="img-fluid">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 m-auto text-Mob-Center">

                                                    @if (!empty($team_detail))
                                                        <span class="ArsenalTxt" title="{{ $team_detail->name }}">
                                                            @php echo Str::of($team_detail->name)->limit(8); @endphp
                                                        </span>
                                                    @else
                                                        <span class="ArsenalTxt">
                                                            Team One
                                                        </span>
                                                    @endif

                                                    @if (!empty($team_detail))
                                                        <p class="LonKingdom" title="{{ $team_detail->location }}">
                                                            @php echo Str::of($team_detail->location)->limit(12); @endphp
                                                            <br>
                                                        </p>
                                                    @else
                                                        <p class="LonKingdom">
                                                            Team Location
                                                            <br>
                                                        </p>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 borL">
                                            <div class="row">
                                                <div class="col-md-7 m-auto Texright">
                                                    @if (!empty($team2_detail))
                                                        <span class="ArsenalTxt" title="{{ $team2_detail->name }}">
                                                            @php echo Str::of($team2_detail->name)->limit(8); @endphp
                                                        </span>
                                                    @else
                                                        <span class="ArsenalTxt">
                                                            Team Two
                                                        </span>
                                                    @endif
                                                    @if (!empty($team2_detail))
                                                        <p class="LonKingdom" title="{{ $team2_detail->location }}">
                                                            @php echo Str::of($team2_detail->location)->limit(12); @endphp
                                                            <br>
                                                        </p>
                                                    @else
                                                        <p class="LonKingdom">
                                                            Team Location
                                                            <br>
                                                        </p>
                                                    @endif

                                                </div>
                                                <div class="col-md-5 m-auto text-center">
                                                    <div class="bgBlueVs">
                                                        <div class="game-logo m-auto">
                                                            @if (!empty($team2_detail))
                                                                <a href="{{ url('team/' . $team2_detail->id) }}"
                                                                    target="a_blank">
                                                                    <img src="{{ url('frontend/logo') }}/{{ $team2_detail->team_logo }}"
                                                                        alt="SportVote Logo" class="img-fluid">
                                                                </a>
                                                            @else
                                                                <img src="{{ url('frontend/logo/competitions-icon-128.png') }}"
                                                                    alt="SportVote Logo" class="img-fluid">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="VsBg">VS</div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            @else
                            @endif

                            @if ($comp_type_id == 3)
                                <hr>
                                <h5>Choose your League Table Ranking Mechanism</h5>
                                <!-- <h4>
        <p class="Step1-Comp mb-3"><span class="StepOne">Choose your League Table Ranking Mechanism</span> </p>
       </h4> -->
                                <!-- <p class="note"> 1st Key ranking determined by points always. Select 2nd and 3rd ranking</p> -->
                                <div class="select_key_rank mt-2">
                                    <br>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="key_ranking">
                                                <span class="mechanismFix"> 1st Key Ranking Determined
                                                    by:</span></label>
                                        </div>
                                        <div class=" col-md-6 FlotingLabelUp">
                                            <div class="floating-form ">
                                                <!-- <span class="round01"></span>  -->
                                                <div class="floating-label form-select-fancy-1">
                                                    Points
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="key_ranking">
                                                <span class="mechanismFix"> 2nd Key Ranking Determined
                                                    by:</span></label>
                                        </div>
                                        <div class=" col-md-6 FlotingLabelUp">
                                            <div class="floating-form ">
                                                <span class="round01"></span>
                                                <div class="floating-label form-select-fancy-1">
                                                    <select class="floating-select"
                                                        onclick="this.setAttribute('value', this.value);"
                                                        value="{{ $secondkeyranking }}"
                                                        wire:model="secondkeyranking">
                                                        <option value=""></option>
                                                        @foreach ($team_ranking_stats as $stat)
                                                            <option value="{{ $stat->id }}">
                                                                {{ $stat->description }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <label>Select 2nd Key Ranking</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="key_ranking"><span class="mechanismFix">3rd key Ranking
                                                    Determined by:</span></label>
                                        </div>
                                        <div class=" col-md-6 FlotingLabelUp">
                                            <div class="floating-form ">
                                                <span class="round01"></span>
                                                <div class="floating-label form-select-fancy-1">
                                                    <select class="floating-select"
                                                        onclick="this.setAttribute('value', this.value);"
                                                        value="{{ $thirdkeyranking }}" wire:model="thirdkeyranking">
                                                        <option value=""></option>
                                                        @foreach ($team_ranking_stats as $stat)
                                                            @if ($secondkeyranking != $stat->id)
                                                                <option value="{{ $stat->id }}">
                                                                    {{ $stat->description }}</option>
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <label>Select 3rd Key Ranking </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <hr>
        <p class="note">* Stats cannot be changed once chosen. Please choose carefully</p> -->
                                </div>
                            @else
                            @endif
                        </div>
                        <div class="d-grid gap-2 d-md-block mt-5 mb-5">
                            <button type="button" class="btn col-5 btn-default btn-cancel"
                                wire:click="first_step">GO TO PREVIOUS STEP</button>
                            <button type="button" class="btn col-5 btn-submit float-md-end"
                                wire:click="save_competition">FINALIZE COMPETITION</button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
        <!--<div class="col-lg-5 col-md-6 ps-0 pe-0 fixme"> -->
        <div class="col-lg-5 col-md-6 ps-0 pe-0  h-screen sticky" style="top: 0px;" id="ScrollRight">
            <div class="show-content">
                <div class="show-content-header">
                    <div class="d-flex align-items-center ">
                        <div class="game-logo">
                            <span><img src="{{ url('frontend/logo') }}/{{ $competition_logo }}" alt="SportVote Logo"
                                    class="img-fluid" id="sv_comp_logo"></span>
                        </div>
                        <style>
                            .image-upload #file {
                                display: none;
                            }
                        </style>
                        <div class="image-upload CreateTeam">
                            <label for="file">
                                <span class="Edit-Icon-white EditProfileOneSticky"> </span>
                                <input id="file" type="file" name="file" />
                            </label>
                        </div>
                        <div class="ms-auto text-end" style="width:75%;">
                            <h2 class="header-name">
                                @if ($comp_name)
                                    {{ $comp_name }}
                                @else
                                    Competition Name
                                @endif
                                <br>
                            </h2>
                            <h5><span class="header_game">Soccer </span> in @if ($comp_location)
                                    {{ $comp_location }}
                                @else
                                    Location
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="competition-detail pt-2">
                    <h5>Competition: <span>
                            @if ($comp_type_name)
                                {{ $comp_type_name }}
                            @else
                                One Off Game
                            @endif
                        </span></h5>
                    <p>
                        @if ($team_num)
                            {{ $team_num }} teams
                        @else
                            0 teams
                        @endif,
                        @if ($squad_player)
                            {{ $squad_player }} registered players
                        @else
                            0 registered players
                        @endif ,
                        @if ($linup_player)
                            {{ $linup_player }} players
                        @else
                            0 players
                        @endif
                        in starting linup
                    </p>
                </div>
                <div class="report-deatil ">
                    <span class="report"><b>Report:</b>
                        @if ($report_name)
                            {{ $report_name }}
                        @else
                        @endif
                    </span>
                    <span class="voting-time"><b>Voting time: </b>
                        @if ($vote_min)
                            {{ $vote_min }}
                        @else
                        @endif mins
                    </span>
                    <div class="clearfix"></div>
                    <p> {{ $comp_desc }}</p>
                </div>
                <div class="competition-detail pt-2">
                    <div class="row">
                        <span class="col-md-10">
                            <h5 class="RuleSet">Administration Rule Set</h5>
                        </span>
                        <span class="col-md-2">
                            <p><span> <a class="ViewMore Addrule" type="button" data-bs-toggle="modal"
                                        data-bs-target="#addrule"> Add Rule</a> </span></p>
                        </span>
                    </div>
                    <div class="row word-wrap">
                        <ol class="list-group list-group-numbered">
                            @if ($comp_rules)
                                @foreach ($comp_rules as $rule)
                                    <li class="Administraion-rule">{{ $rule->description }}</li>
                                @endforeach
                            @endif
                            <!-- <p><span> <a class="ViewMore" href="">~View More </a> </span></p> -->
                        </ol>
                    </div>
                </div>
                <!-- <div class="competition-detail pt-2">
   <h5 class="RuleSet">Administration by</h5>

  </div> -->
                <div class="team-deatil row">
                    <div class="col">
                        <h5>Competition Administrators</h5>
                        <ul class="admin-list">
                            @foreach ($competition_member as $comp_mem)
                                @if ($comp_mem->member_position_id)
                                    @if ($comp_mem->invitation_status == 0)
                                        <li class="pending-list"><i class="icon-angle-double-right"></i>
                                            {{ $comp_mem->member->first_name }}
                                            {{ $comp_mem->member->last_name }}<span class="pending-icon"></span><br>
                                            <span>({{ $comp_mem->member_position->name }})</span>
                                            <!-- <a href="#" class="btn btn-cross" wire:click ="remove_member({{ $comp_mem->id }})">×</a> -->
                                        </li>
                                    @elseif($comp_mem->invitation_status == 1)
                                        <li><i class="icon-angle-double-right"></i>
                                            {{ $comp_mem->member->first_name }} {{ $comp_mem->member->last_name }}<br>
                                            <span>({{ $comp_mem->member_position->name }})</span>
                                        </li>
                                    @else
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner preview model -->
        <!-- The Modal -->
        <div class="modal fade" id="banner_preview" wire:ignore.self>
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <span class="modal-title">Banner Preview</span>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        @if ($bannerpreview)
                            <img src="{{ $bannerpreview }}" width="100%">
                        @else
                            No preview
                        @endif
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="closebannerperivew">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addrule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Rules</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="app">
                        <div class="wrapper pt-1">
                            <div class="input-box"><br>
                                <div class="row mb-3">
                                    <div class=" col-md-12 FlotingLabelUp ">
                                        <div class="floating-form  ">
                                            <div class="floating-label ">
                                                <textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30"
                                                    rows="5" wire:model="rule_desc" placeholder=" "></textarea>
                                                <span class="highlight"></span>
                                                <label class="TeamDescrForm">Add Rule</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <div class="content">
                                        @if ($is_add_rule == 1)
                                            <button class="active" wire:click="add_rule">Add</button>
                                        @else
                                            <span class="post_span">Add</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="PostDetail rule-set">

                            <div class="infoContainer">
                                <div class="nameContainer">
                                    Administration Rule Set
                                </div>
                                <div class="message word-wrap">
                                    @if ($comp_rules)
                                        <ol>
                                            @foreach ($comp_rules as $rule)
                                                <li>{{ $rule->description }} <a class="btn"
                                                        onclick="return confirm('You were not be able to revert this again!') || event.stopImmediatePropagation()"
                                                        wire:click="delete_comp_rule({{ $rule->id }})"
                                                        style="cursor:pointer;">×</a> </li>
                                            @endforeach
                                        </ol>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

</span>

<script>
    window.addEventListener('openModalbannerpreview', event => {
        $('#banner_preview').modal('show')
    })
</script>
<script>
    window.addEventListener('closeModalbannerpreview', event => {
        $('#banner_preview').modal('hide')
    })
</script>
<script type="text/javascript">
    document.addEventListener('livewire:load', function() {
        $(document).ready(function() {
            var autocomplete;
            var id = 'location';
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
                type: ['geocode'],
            })

        });
    })
</script>
<script>
    window.onload = function() {
        $('#select_admin').select2({
            placeholder: 'Select Admins then click + '
        });
        $('#select_referee').select2({
            placeholder: 'Select Players then click + '
        });
        Livewire.on('addadmin', () => {
            $('#select_admin').select2();
            $('#select_referee').select2();
            $('#select_admin').select2({
                placeholder: 'Select Admins then click + '
            });
            $('#select_referee').select2({
                placeholder: 'Select Players then click + '
            });
            $('#select_admin').on('change', function(e) {
                let data = $(this).val();
                @this.set('member_id', data);
            });
            $('#select_referee').on('change', function(e) {
                let data = $(this).val();
                @this.set('referee_id', data);
            });
            window.livewire.on('addadmin', () => {
                $('#select_admin').select2();
                $('#select_admin').select2({
                    placeholder: 'Select Admins then click + '
                });
                $('#select_referee').select2({
                    placeholder: 'Select Players then click + '
                });
            });
        })
    }
</script>


<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
    $('#file').ijaboCropTool({
        preview: '.image-previewer',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        buttonsText: ['CROP & SAVE', 'QUIT'],
        buttonsColor: ['#30bf7d', '#ee5155', -15],
        processUrl: '{{ route('comp_logo_crop') }}',
        withCSRF: ['_token', '{{ csrf_token() }}'],
        onSuccess: function(message, element, status) {
            //  alert(message);
            $('#sv_comp_logo').attr('src', '{{ url('frontend/logo') }}/' + message);
            //$('#file').html(message);
        },
        onError: function(message, element, status) {
            alert(message);
        }
    });
</script>
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
    //console.log(window);
    window.livewire.on('filechoosen', () => {
        let file = document.getElementById('image')
        console.log(file);
    })
</script>
