@include('frontend.includes.header')
<Style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 1140px !important;
            margin: 1.75rem auto;
        }
    }

    .select-comp-admin .select2-selection__choice {
        padding-left: unset !important;
    }

    .createMain_div {
        position: relative;
        z-index: -0;
    }

    .create_span_underlineNone {
        text-decoration: none !important;
    }
</style>
<?php
$ko_cup_compSubTypes = App\Models\CompSubType::where('competition_type_id', 2)->get();
$league_compSubTypes = App\Models\CompSubType::where('competition_type_id', 3)->get();
?>
<div class="header-bottom">
    <button id="triggerAll" class="RefreshButtonTop btn btn-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
            <path
                d="M15.8591 9.625H21.2662C21.5577 9.625 21.7169 9.96492 21.5303 10.1888L18.8267 13.4331C18.6893 13.598 18.436 13.598 18.2986 13.4331L15.595 10.1888C15.4084 9.96492 15.5676 9.625 15.8591 9.625Z"
                fill="white" />
            <path
                d="M0.734056 12.375H6.14121C6.43266 12.375 6.59187 12.0351 6.40529 11.8112L3.70171 8.56689C3.56428 8.40198 3.31099 8.40198 3.17356 8.56689L0.469979 11.8112C0.283401 12.0351 0.442612 12.375 0.734056 12.375Z"
                fill="white" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11.0001 4.125C8.86546 4.125 6.95841 5.09708 5.69633 6.62528C5.45455 6.91805 5.02121 6.95938 4.72845 6.7176C4.43569 6.47581 4.39436 6.04248 4.63614 5.74972C6.14823 3.91879 8.43799 2.75 11.0001 2.75C15.045 2.75 18.4087 5.66019 19.1141 9.50079C19.1217 9.54209 19.129 9.5835 19.136 9.625H17.7377C17.1011 6.48695 14.3258 4.125 11.0001 4.125ZM4.26252 12.375C4.89916 15.5131 7.67452 17.875 11.0001 17.875C13.1348 17.875 15.0419 16.9029 16.3039 15.3747C16.5457 15.082 16.9791 15.0406 17.2718 15.2824C17.5646 15.5242 17.6059 15.9575 17.3641 16.2503C15.852 18.0812 13.5623 19.25 11.0001 19.25C6.95529 19.25 3.59161 16.3398 2.88614 12.4992C2.87856 12.4579 2.87128 12.4165 2.86431 12.375H4.26252Z"
                fill="white" />
        </svg>
    </button>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span> Create a New
                    <strong>Competition</strong>
                </h1>
            </div>
        </div>
    </div>
</div>
<main id="main" class="CreateTeam">
    <div class="container ScrollFix">
        <div class="row">
            <div class="col-lg-7 col-md-6 pe-0 content createMain_div">
                <form class="" enctype="multipart/form-data" id="create_comp">
                    <input type="hidden" name="comp_id" id="comp_id" value="">
                    <div class="mb-3 competition-list comp_sport_list">
                        <ul class="games-list owl-4-slider owl-carousel owl-loaded owl-drag">
                            <li class="item"><input type="radio" name="sport_id" value="1" checked
                                    id="soccer"><label for="competition"><span> Soccer </span><i
                                        class="icon-check checked-badge"></i></label></li>
                            <li class="item"><input type="radio" name="sport_id" value="2"
                                    id="Basketball"><label for="competition"><span>Basketball </span><i
                                        class="icon-check checked-badge"></i></label></li>
                            <li class="item"><input type="radio" name="sport_id" value="3"
                                    id="Cricket"><label for="competition"><span> Cricket </span><i
                                        class="icon-check checked-badge"></i></label></li>
                            <li class="item"><input type="radio" name="sport_id" value="4"
                                    id="Volleyball"><label for="competition"><span> Volleyball </span><i
                                        class="icon-check checked-badge"></i></label></li>
                            <li class="item"><input type="radio" name="sport_id" value="5"
                                    id="Rugby"><label for="competition"><span> Rugby </span><i
                                        class="icon-check checked-badge"></i></label></li>
                            <li class="item"><input type="radio" name="sport_id" value="6"
                                    id="Hockey"><label for="competition"><span> Hockey </span><i
                                        class="icon-check checked-badge"></i></label></li>
                        </ul>
                    </div>
                    <div class="soccer-form-data pe-2 selectt" id="soccer-form">
                        <div class="current_step" id="current_step">
                            <!-- One "tab" for each step in the form: -->
                            <div class="row setup-content">
                                <p class="mb-3 Step1-Comp"><span class="StepOne">Step 1:</span> Define Competition Type
                                </p>
                                <div class="mb-3 row">
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <input class="floating-input" type="text" placeholder=" "
                                                    name="comp_name" id="comp_name">
                                                <span class="highlight"></span>
                                                <label>Competition Name *</label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="comp_name_error"></span>
                                </div>
                                <div class="mb-3 row">
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <input class="floating-input" type="text" placeholder=" "
                                                    id="location" value="" name="comp_location"
                                                    autocomplete="off">
                                                <span class="highlight"></span>
                                                <label>Location *</label>
                                                <span class="input-group-text apicon"><i
                                                        class="icon-map-marker"></i></span>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="comp_location_error"></span>
                                    </div>
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);" value=""
                                                    name="comp_half_time" id="comp_half_time">
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
                                        <span class="text-danger" id="comp_half_time_error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    @foreach ($com_type as $com)
                                        <div class=" col-sm-4 col-xs-4">
                                            <div class="form-check radio-competion-type">
                                                <label for="one_off_game"><img
                                                        src="{{ asset('frontend/images/') . '/' . $com->icon }}"
                                                        alt="trophy">
                                                    <span>{{ $com->name }}</span></label><input type="radio"
                                                    name="comp_type_id" id="comp_type_id"
                                                    class="form-check-input radio-fancy"
                                                    onchange="comp_type({{ $com->id }})"
                                                    {{ $loop->first ? 'checked' : '' }} class="radio-fancy">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="comp_type" class="mb-3 row" style="display:none;">
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select" name="comp_sub_type_id"
                                                    onclick="this.setAttribute('value', this.value);" value=""
                                                    id="comp_sub_type_id">
                                                    <option value=""></option>

                                                </select>
                                                <span class="highlight"></span>
                                                <label>Select Competition Sub Type *</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="comp_sub_type_id_error"></span>
                                    </div>
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);" value=""
                                                    id="select_team_number">
                                                    <option value=""></option>

                                                </select>
                                                <span class="highlight"></span>
                                                <label>Number of Teams to Play *</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="select_team_number_error"></span>
                                    </div>
                                </div>
                                <div id="comp_type_else" class="mb-3 row">
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <?php
                                            $mindate = date('Y-m-d');
                                            $min_Date = $mindate; ?>
                                            <div class="floating-label form-select-fancy-1" id="datepickerfield">
                                                <input class="floating-input" type="text"
                                                    onclick="(this.type='date')" min="<?php echo $min_Date; ?>"
                                                    max="9999-01-01" placeholder=" " value=""
                                                    name="comp_start_datetime" id="comp_start_datetime">
                                                <span class="highlight"></span>
                                                <label>Start Date *</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="comp_start_datetime_error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <!-- <span class="round01"></span> -->
                                            <div class="floating-label form-select-fancy-1">
                                                <!-- <select class="floating-select" onclick="this.setAttribute('value', this.value);" value=""  id="team_squad_player">
                          <option value=""></option>
                          @for ($i = 1; $i <= 20; $i++)
<option value="{{ $i }}">{{ $i }}</option>
@endfor
                        </select> -->
                                                <input class="floating-input" type="number" placeholder=" "
                                                    max="99" min="1" name="team_squad_player"
                                                    id="team_squad_player">
                                                <span class="highlight"></span>
                                                <label># Players in Squad</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="squad_player_error"></span>
                                    </div>
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);" value=""
                                                    id="select_linup_player">
                                                    <option value=""></option>
                                                </select>
                                                <span class="highlight"></span>
                                                <label># Players in Starting Lineup</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="select_linup_player_error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);" value=""
                                                    id="comp_report_type">
                                                    <option value=""></option>
                                                    @foreach ($com_report_type as $comp_report)
                                                        <option value="{{ $comp_report->id }}">{{ $comp_report->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="highlight"></span>
                                                <label>Select Match Report Type *</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="comp_report_type_error"></span>
                                    </div>
                                    <div class=" col-md-6 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <span class="round01"></span>
                                            <div class="floating-label form-select-fancy-1">
                                                <select class="floating-select"
                                                    onclick="this.setAttribute('value', this.value);" value=""
                                                    id="match_vote_min">
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
                                                <label>MVP Vote Timer Length *</label>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="vote_min_error"></span>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="mb-3 col-lg-6 select_label_padding">
                                        <label class="form-control form-select-fancy-1 label_padding"
                                            aria-label=".form-select-lg example">
                                            Add Competition Admin(s) →
                                        </label>
                                    </div>
                                    <div class="mb-3 col-lg-6 multi-button d-flex">
                                        <div class="col-10 select-comp-admin">
                                            <select id="select_admin"
                                                class="form-control form-select-fancy-1 typeahead"
                                                aria-label=".form-select-lg example" multiple="multiple"
                                                name="member_id">
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-default float-end btn-round-submit"
                                                id="send_request_admin"><i class="icon-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="mb-3 col-lg-6 select_label_padding">
                                        <label class="form-control form-select-fancy-1 label_padding"
                                            aria-label=".form-select-lg example">
                                            Add Competition Referee(s) →
                                        </label>
                                    </div>
                                    <div class="mb-3 col-lg-6 multi-button d-flex ">
                                        <div class="col-10 select-comp-admin">
                                            <select id="select_referee"
                                                class="form-control form-select-fancy-1 comp_typeahead"
                                                aria-label=".form-select-lg example" multiple="multiple"
                                                name="referee_id">
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-default float-end btn-round-submit"
                                                id="send_request_referee">
                                                <i class="icon-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="referee_id_error"></span>
                                </div>
                                <div class="mb-3 row">
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label ">
                                                <textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30"
                                                    rows="5" value="" name="comp_desc" id="comp_desc" placeholder=" "></textarea>
                                                <span class="highlight"></span>
                                                <label class="TeamDescrForm">About Us - This info will be displayed on
                                                    your competition page.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gap-2 mt-3 d-grid d-md-block">
                                    <button type="button" class="btn col-5 btn-default btn-cancel"
                                        id="reset_step_one">Cancel</button>
                                    <button type="button" class="btn col-5 btn-submit float-md-end"
                                        id="saveNext_step">Save & Continue</button>
                                </div>
                            </div>
                        </div>
                        <div id="next_step" style="display:none;">
                            <div class="row setup-content">
                                <div id="comp_report_type2" style="display:none;">
                                    <h4>
                                        <p class="mb-3 Step1-Comp"><span class="StepOne">Step 2: Select Stats &
                                                Ranking Mechanism</span></p>
                                    </h4>
                                    <?php
                                    $team_stats = App\Models\Sport_stat::where('stat_type_id', 0)
                                        ->where('is_calculated', 0)
                                        ->whereIn('stat_type', [0, 2])
                                        ->orderBy('stat_type', 'ASC')
                                        ->get();
                                    $player_stats = App\Models\Sport_stat::whereIn('stat_type_id', [0, 1])
                                        ->where('is_calculated', 0)
                                        ->whereIn('is_active', [0, 1])
                                        ->orderBy('must_track', 'DESC')
                                        ->get();
                                    ?>
                                    <div class="select-league-table round-check-box">
                                        <h5>Select Player Stats you would like to track</h5>
                                        <div class="scrollchakmartList">
                                            <div class="row">
                                                @foreach ($team_stats as $stat)
                                                    <div class=" col-6">
                                                        <div class="form-check">
                                                            <?php $comp_team_stat = [1, 2, 3, 5, 47]; ?>
                                                            @if (in_array($stat->id, $comp_team_stat))
                                                                <input class="round-check-box comp_team_statCheckbox"
                                                                    type="checkbox" value="{{ $stat->id }}"
                                                                    id="Played.{{ $stat->id }}"
                                                                    name="comp_team_stat" checked disabled>
                                                            @else
                                                                <input class="round-check-box comp_team_statCheckbox"
                                                                    type="checkbox" value="{{ $stat->id }}"
                                                                    id="Played.{{ $stat->id }}"
                                                                    name="comp_team_stat">
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
                                </div>
                                <div id="notcomp_type" style="display:none;">
                                    <div class="m-auto mt-4 mb-4 row createCompPage">
                                        <div class=" col-md-6 FlotingLabelUp">
                                            <div class="floating-form ">
                                                <span class="round01"></span>
                                                <div class="floating-label form-select-fancy-1">
                                                    <select class="floating-select"
                                                        onclick="this.setAttribute('value', this.value);"
                                                        value="" id="teamOne" name="team1">
                                                        <option value=""></option>
                                                        @if ($teams)
                                                            @foreach ($teams as $team)
                                                                <option value="{{ $team->id }}">
                                                                    {{ $team->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option disabled>Select Competition Level</option>
                                                        @endif
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <!-- <label>Search & Select Team 1 </label> -->
                                                </div>
                                            </div>
                                            <span class="text-danger" id="selectTeamOne_error"></span>
                                        </div>
                                        <div class="col-md-6 FlotingLabelUp">
                                            <div class="floating-form ">
                                                <span class="round01"></span>
                                                <div class="floating-label form-select-fancy-1">
                                                    <select class="floating-select"
                                                        onclick="this.setAttribute('value', this.value);"
                                                        value="" id="teamTwo" name="team2">
                                                        <option value=""></option>
                                                        @if ($teams)
                                                            @foreach ($teams as $team)
                                                                <option value="{{ $team->id }}">
                                                                    {{ $team->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option disabled>Select Competition Level</option>
                                                        @endif
                                                    </select>
                                                    <span class="highlight"></span>
                                                    <!-- <label>Search & Select Team 2 </label> -->
                                                </div>
                                            </div>
                                            <span class="text-danger" id="selectTeamTwo_error"></span>
                                        </div>
                                    </div>
                                    <div class="BgBlueVS">
                                        <div class="row">
                                            <div class="col-md-6 col-6 borR">
                                                <div class="row">
                                                    <div class="m-auto text-center col-md-5">
                                                        <div class="bgBlueVs">
                                                            <div class="m-auto game-logo">
                                                                <a href="#" id="selectedTeamLink"
                                                                    target="a_blank">
                                                                    <img src="{{ url('frontend/logo/competitions-icon-128.png') }}"
                                                                        id="selectedTeamLogo" alt="SportVote Logo"
                                                                        class="img-fluid">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-auto col-md-7 text-Mob-Center">
                                                        <span class="ArsenalTxt" id="selectedTeamName">
                                                            Team One
                                                        </span>
                                                        <p class="LonKingdom" id="selectedTeamLocation">
                                                            Team Location
                                                            <br>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6 borL">
                                                <div class="row">
                                                    <div class="m-auto col-md-7 Texright">
                                                        <span class="ArsenalTxt" id="selectedTeamName2">
                                                            Team Two
                                                        </span>
                                                        <p class="LonKingdom" id="selectedTeamLocation2">
                                                            Team Location
                                                            <br>
                                                        </p>
                                                    </div>
                                                    <div class="m-auto text-center col-md-5">
                                                        <div class="bgBlueVs">
                                                            <div class="m-auto game-logo">
                                                                <a href="#" id="selectedTeamLink2"
                                                                    target="a_blank">
                                                                    <img src="{{ url('frontend/logo/competitions-icon-128.png') }}"
                                                                        id="selectedTeamLogo2" alt="SportVote Logo"
                                                                        class="img-fluid">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="VsBg">VS</div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div id="comp_type_id3" style="display:none">
                                    <hr>
                                    <h5>Choose your League Table Ranking Mechanism</h5>
                                    <!-- <h4>
                    <p class="mb-3 Step1-Comp"><span class="StepOne">Choose your League Table Ranking Mechanism</span> </p>
                  </h4> -->
                                    <!-- <p class="note"> 1st Key ranking determined by points always. Select 2nd and 3rd ranking</p> -->
                                    <div class="mt-2 select_key_rank">
                                        <br>
                                        <div class="mb-4 row">
                                            <div class="col-md-6">
                                                <label for="key_ranking"><span class="mechanismFix"> 1st Key Ranking
                                                        Determined by:</span></label>
                                            </div>
                                            <div class=" col-md-6 FlotingLabelUp">
                                                <div class="floating-form ">
                                                    <!-- <span class="round01"></span>  -->
                                                    <div class="floating-label form-select-fancy-1">Points</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 row">
                                            <div class="col-md-6">
                                                <label for="key_ranking"><span class="mechanismFix"> 2nd Key Ranking
                                                        Determined by:</span></label>
                                            </div>
                                            <div class=" col-md-6 FlotingLabelUp">
                                                <div class="floating-form ">
                                                    <span class="round01"></span>
                                                    <div class="floating-label form-select-fancy-1">
                                                        <select class="floating-select"
                                                            onclick="this.setAttribute('value', this.value);"
                                                            value="" id="secondkeyranking">
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
                                        <div class="mb-4 row">
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
                                                            value="" id="thirdkeyranking">
                                                            <option value=""></option>
                                                            @foreach ($team_ranking_stats as $stat)
                                                                <option value="{{ $stat->id }}">
                                                                    {{ $stat->description }}</option>
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
                                </div>
                            </div>
                            <div class="gap-2 mt-5 mb-5 d-grid d-md-block">
                                <button type="button" class="btn col-5 btn-default btn-cancel" id="first_step">GO TO
                                    PREVIOUS STEP</button>
                                <button type="button" class="btn col-5 btn-submit float-md-end"
                                    id="save_competition">FINALIZE COMPETITION</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="sticky h-screen col-lg-5 col-md-6 ps-0 pe-0" style="top: 0px;" id="ScrollRight">
                <div class="show-content">
                    <div class="show-content-header">
                        <div class="d-flex align-items-center ">
                            <div class="game-logo">
                                <span><img src="{{ url('frontend/logo') }}/{{ $competition_logo }}"
                                        alt="SportVote Logo" class="img-fluid" id="sv_comp_logo"></span>
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
                                <h2 class="header-name" id="show_comp_name">Competition Name<br></h2>
                                <h5><span class="header_game">Soccer </span>In <span id="locationname">Location</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 competition-detail">
                        <h5>Competition: <span id="comp_type_name">One Off Game</span></h5>
                        <p>
                            <span class="create_span_underlineNone" id="total_teams" style="display:none;"> 0 teams,
                            </span>
                            <span class="create_span_underlineNone" id="squad_player"> 0</span> players in squad,
                            <span class="create_span_underlineNone" id="linup_player"> 0</span> players in starting
                            lineup
                        </p>
                    </div>
                    <div class="report-deatil ">
                        <span class="report"><b>Report:</b>
                            <span id="report_name"></span>
                        </span>
                        <span class="voting-time"><b>MVP Voting Time: </b>
                            <span id="vote_min"></span> mins
                        </span>
                        <div class="clearfix"></div>
                        <p id="compe_desc"></p>
                    </div>
                    @livewire('create-competition')
                </div>
            </div>
        </div>
    </div>
</main>
</br></br></br></br></br></br>
@livewireScripts
@include('frontend.includes.footer')
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>

<script src="{{ url('frontend/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ url('frontend/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ url('frontend/js/jquery.easing.1.3.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!--<script src="js/jquery-ui.js"></script>


    <script src="js/aos.js"></script>
   <script src="js/script.js"></script> <script src="js/popper.min.js"></script>
   Vendor JS Files -->

<script src="{{ url('frontend/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ url('frontend/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
<script src="{{ url('frontend/js/script.js') }}"></script>
<script src="{{ url('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('frontend/js/main.js') }}"></script>
<script>
    $(document).on('blur', '#comp_name', function() {
        var t = 0;
        var comp_name = $('#comp_name').val();
        var comp_id = $('#comp_id').val();
        if (comp_name == '') {
            t++;
            $('#comp_name_error').html("Competiton Name is required");
        } else {
            if (comp_name.length > 30) {
                t++;
                $('#comp_name_error').html("Competition Name must not be greater than 30 characters.");
            } else {
                $('#comp_name_error').html("");
            }
        }
        if (t == 0) {
            if (comp_name != "") {
                var sport_id = $('input:radio[name="sport_id"]:checked').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('competition.store') }}",
                    method: "POST",
                    data: {
                        comp_name: comp_name,
                        sport_id: sport_id,
                        comp_id: comp_id
                    },
                    error: function() {
                        alert('Something is Wrong');
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            $('#comp_id').val(response.compe_id);
                        }
                    }
                });
            }
        }
    });
</script>
<script>
    $(document).on('keyup', '#comp_name', function() {
        var competition_name = $('#comp_name').val();
        $('#show_comp_name').html(competition_name);
    });

    $(document).on('click', '#location', function() {
        var autocomplete;
        var id = 'location';
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
            type: ['geocode'],
        })
    });

    $(document).on('click', '.content', function() {
        var locationanme = $('#location').val();
        $('#locationname').html(locationanme);
    });
    var competition_type = "";

    function comp_type(comp_type_id) {
        var comp_type = comp_type_id;
        competition_type = comp_type_id;
        if (comp_type == 1) {
            var comp_name = "One off Game";
            $('#comp_type_name').html(comp_name);
            $('#comp_type').hide();
            $('#total_teams').hide();
            $('#comp_type_else').show();
        }
        if (comp_type == 2) {
            var comp_name = "Knockout Cup";
            $('#comp_type_name').html(comp_name);
            $('#comp_type_else').hide();
            $('#total_teams').show();
            $('#comp_type').show();
            $('#comp_start_datetime').empty();
            comp_type2(comp_type);
        }
        if (comp_type == 3) {
            var comp_name = "League";
            $('#comp_type_name').html(comp_name);
            $('#comp_type_else').hide();
            $('#total_teams').show();
            $('#comp_type').show();
            $('#comp_start_datetime').empty();
            comp_tupe3(comp_type);
        }
    }

    function comp_type2(comp_type) {
        var compType = comp_type;
        if (compType == 2) {
            $('#comp_sub_type_id').find('option').not(':first').remove();
            $('#select_team_number').find('option').not(':first').remove();
            var comp_sub_type_name = @json($ko_cup_compSubTypes);
            var length = comp_sub_type_name.length;
            for (x = 0; x < length; x++) {
                $('#comp_sub_type_id').append($("<option></option>")
                    .attr("value", comp_sub_type_name[x].id).text(comp_sub_type_name[x].name));
            }
        }
    }

    function comp_tupe3(comp_type) {
        var compType = comp_type;
        if (compType == 3) {
            $('#comp_sub_type_id').find('option').not(':first').remove();
            $('#select_team_number').find('option').not(':first').remove();
            var comp_sub_type_name1 = @json($league_compSubTypes);
            var length1 = comp_sub_type_name1.length;
            for (b = 0; b < length1; b++) {
                $('#comp_sub_type_id').append($("<option></option>")
                    .attr("value", comp_sub_type_name1[b].id).text(comp_sub_type_name1[b].name));
            }
        }
    }

    $("#secondkeyranking").on("change", function() {
        var secondkeyrankingVal = $("#secondkeyranking").val();
        if (secondkeyrankingVal != "") {
            $("#thirdkeyranking").children('option').show();
            $("#thirdkeyranking option[value=" + secondkeyrankingVal + "]").hide();
        } else {
            $("#thirdkeyranking").children('option').show();
        }
    });

    $("#thirdkeyranking").on("change", function() {
        var thirdkeyrankingVal = $("#thirdkeyranking").val();
        if (thirdkeyrankingVal != "") {
            $("#secondkeyranking").children('option').show();
            $("#secondkeyranking option[value=" + thirdkeyrankingVal + "]").hide();
        } else {
            $("#secondkeyranking").children('option').show();
        }
    });

    $("#comp_sub_type_id").on("change", function() {
        var comp_sub_type_id = $("#comp_sub_type_id").val();
        var team_num_data;
        if (competition_type != 1) {
            if (competition_type == 2) {
                team_num_data = @json($ko_cup_compSubTypes);
            } else {
                if (competition_type == 3) {
                    team_num_data = @json($league_compSubTypes);
                }
            }
            var team_numLength = team_num_data.length;
            $('#select_team_number').find('option').not(':first').remove();
            for (y = 0; y < team_numLength; y++) {
                if (comp_sub_type_id == team_num_data[y].id) {
                    var optionData = team_num_data[y].team_number.split('-');
                    for (z = parseInt(optionData[0]); z <= parseInt(optionData[1]); z++) {
                        $('#select_team_number').append($("<option></option>")
                            .attr("value", z).text(z));
                    }
                    if (comp_sub_type_id == 3) {
                        $('#select_team_number').append($("<option></option>")
                            .attr("value", 64).text(64));
                        $('#select_team_number').append($("<option></option>")
                            .attr("value", 128).text(128));
                    }
                }
            }
        }
    });

    $("#team_squad_player").on("change", function() {
        var selected_squad_player = $("#team_squad_player").val();
        if (selected_squad_player == "") {
            $("#squad_player").html("0");
            $('#select_linup_player').find('option').not(':first').remove();
        } else {
            $("#squad_player").html(selected_squad_player);
            if (selected_squad_player > 0 && selected_squad_player < 100) {
                $('#select_linup_player').find('option').not(':first').remove();
                for (i = 1; i <= selected_squad_player; i++) {
                    $('#select_linup_player').append($("<option></option>")
                        .attr("value", i).text(i));
                }
            } else {
                $('#squad_player_error').html("Please enter number of players between 0 to 100.");
                $('#select_linup_player').find('option').not(':first').remove();
            }
        }
    });

    $('#select_team_number').on("change", function() {
        var select_team_number = $('#select_team_number').val();
        if (select_team_number == "") {
            $("#total_teams").html("0 teams, ");
        } else {
            $("#total_teams").html(select_team_number + " teams, ");
        }
    });

    $("#select_linup_player").on("change", function() {
        var select_linup_player = $("#select_linup_player").val();
        if (select_linup_player == "") {
            $("#linup_player").html("0");
        } else {
            $("#linup_player").html(select_linup_player);
        }
    });

    $("#match_vote_min").on("change", function() {
        var match_vote_min = $("#match_vote_min").val();
        if (match_vote_min == "") {
            $("#vote_min").html("");
        } else {
            $("#vote_min").html(match_vote_min);
        }
    });

    $("#comp_report_type").on("change", function() {
        var report_type_id = $("#comp_report_type").val();
        if (report_type_id == "") {
            $("#report_name").html("");
        } else {
            var report_type_name
            if (report_type_id == 1) {
                report_type_name = "Basic";
            }
            if (report_type_id == 2) {
                report_type_name = "Detailed";
            }
            $("#report_name").html(report_type_name);
        }
    });

    $(document).on('keyup', '#comp_desc', function() {
        var comp_desc = $('#comp_desc').val();
        $('#compe_desc').html(comp_desc);
    });

    $(document).on('click', '#reset_step_one', function() {
        location.href = "{{ url('dashboard') }}";
    });

    $(document).on('click', '#first_step', function() {
        $("#next_step").hide();
        $("#current_step").show();
    });

    // Current( First step ) step......
    $("#saveNext_step").on("click", function() {
        var x = 0;
        var comp_name = $('#comp_name').val();
        if (comp_name == "") {
            x++;
            $('#comp_name_error').html("Competiton Name is required");
        } else {
            if (comp_name.length > 30) {
                x++;
                $('#comp_name_error').html("Competition Name must not be greater than 30 characters.");
            } else {
                $('#comp_name_error').html("");
            }
        }
        var comp_id = $('#comp_id').val();
        var complocation = $('#location').val();
        if (complocation == "") {
            x++;
            $("#comp_location_error").html("Location is required");
        } else {
            $("#comp_location_error").html("");
        }
        var comp_half_time = $('#comp_half_time').val();
        if (comp_half_time == "") {
            x++;
            $("#comp_half_time_error").html("Match Time per half is required.");
        } else {
            $("#comp_half_time_error").html("");
        }
        if (competition_type == "") {
            var comp_type_id = 1;
            var comp_start_datetime = $('#comp_start_datetime').val();
        } else {
            var comp_type_id = competition_type;
            var comp_start_datetime = "";
        }

        var comp_sub_type_id = $('#comp_sub_type_id').val();
        var select_team_number = $('#select_team_number').val();

        if (comp_type_id == 1) {
            if (comp_start_datetime == "") {
                x++;
                $("#comp_start_datetime_error").html("Start Date is required");
            } else {
                var currentDate = new Date().toISOString().split("T")[0];
                if (comp_start_datetime < currentDate) {
                    x++;
                    $("#comp_start_datetime_error").html("Start Date is not a valid date.");
                } else {
                    $("#comp_start_datetime_error").html("");
                }
            }
        } else {
            if (comp_type_id == 2 || comp_type_id == 3) {
                if (comp_sub_type_id == "") {
                    x++;
                    $('#comp_sub_type_id_error').html("Competition Sub Type is required");
                } else {
                    $('#comp_sub_type_id_error').html("");
                }

                if (select_team_number == "") {
                    x++;
                    $('#select_team_number_error').html("Number of Teams is required");
                } else {
                    $('#select_team_number_error').html("");
                }
            }
        }
        var team_squad_player = $('#team_squad_player').val();
        if (team_squad_player == "") {
            x++;
            $('#squad_player_error').html("Players in squad is required");
        } else {
            if (team_squad_player < 1) {
                x++;
                $('#squad_player_error').html("Please enter number of players between 0 to 100.");
            } else {
                if (team_squad_player > 100) {
                    x++;
                    $('#squad_player_error').html("Please enter number of players between 0 to 100.");
                } else {
                    $('#squad_player_error').html("");
                }
            }
        }
        var select_linup_player = $('#select_linup_player').val();
        if (select_linup_player == "") {
            x++;
            $('#select_linup_player_error').html("Players in Starting Lineup is required");
        } else {
            $('#select_linup_player_error').html("");
        }
        var comp_report_type = $('#comp_report_type').val();
        if (comp_report_type == "") {
            x++;
            $('#comp_report_type_error').html("Match Report Type is required");
        } else {
            $('#comp_report_type_error').html("");
        }
        var match_vote_min = $('#match_vote_min').val();
        if (match_vote_min == "") {
            x++;
            $('#vote_min_error').html("MVP Voting Time is required");
        } else {
            $('#vote_min_error').html("");
        }
        var comp_desc = $('#comp_desc').val();

        console.log(comp_name, comp_id, complocation, comp_half_time, comp_type_id, comp_start_datetime,
            comp_sub_type_id, select_team_number, team_squad_player,
            select_linup_player, comp_report_type, match_vote_min, comp_desc);
        if (comp_id != "" && x == 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('createComp') }}',
                type: 'POST',
                data: {
                    comp_id: comp_id,
                    comp_name: comp_name,
                    complocation: complocation,
                    comp_half_time: comp_half_time,
                    comp_type_id: comp_type_id,
                    comp_start_datetime: comp_start_datetime,
                    comp_sub_type_id: comp_sub_type_id,
                    select_team_number: select_team_number,
                    team_squad_player: team_squad_player,
                    select_linup_player: select_linup_player,
                    comp_report_type: comp_report_type,
                    match_vote_min: match_vote_min,
                    comp_desc: comp_desc,
                },
                error: function() {
                    alert('something went wrong');
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 2) {
                        $('#current_step').hide();

                        if (response.report_type == 2) {
                            $('#next_step').show();
                            $('#comp_report_type2').show();
                        } else {
                            $('#comp_report_type2').hide();
                            if (response.comp_type == 2) {
                                $('#next_step').hide();
                                $('#current_step').show();
                                window.location.href = "{{ url('competition') }}/" + response
                                    .compe_id;
                            }
                        }
                        if (response.comp_type == 1) {
                            $('#next_step').show();
                            $('#notcomp_type').show();
                        } else {
                            $('#notcomp_type').hide();
                        }
                        if (response.comp_type == 3) {
                            $('#next_step').show();
                            $('#comp_type_id3').show();
                        } else {
                            $('#comp_type_id3').hide();
                        }
                    }
                }
            });
        }
    });

    $('#teamOne').select2({
        placeholder: "Search & Select Team 1",
    });
    $('#teamTwo').select2({
        placeholder: "Search & Select Team 2",
    });
    $("#teamOne").on("change", function() {
        var selectedTeamOne = $("#teamOne").val();
        var selectedTeamTwo = $("#teamTwo").val();
        if (selectedTeamOne != "") {
            $("#teamOne").children('option').removeAttr('disabled');
            $("#teamTwo").children('option').removeAttr('disabled');
            if (selectedTeamTwo != "") {
                $("#teamOne option[value=" + selectedTeamTwo + "]").prop('disabled', true);
            }
            $("#teamTwo option[value=" + selectedTeamOne + "]").prop('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('search_team') }}',
                type: 'Get',
                data: {
                    team_id: selectedTeamOne,
                },
                error: function() {
                    alert('something went wrong');
                },
                success: function(response) {
                    console.log("search_team", response);
                    if (response.status == 1) {
                        var teamOnedata = response.data;
                        var teamOneName;
                        if (teamOnedata.name.length > 8) {
                            teamOneName = teamOnedata.name.substring(0, 8) + "...";
                        } else {
                            teamOneName = teamOnedata.name;
                        }
                        var teamOneLocation;
                        if (teamOnedata.location.length > 12) {
                            teamOneLocation = teamOnedata.location.substring(0, 12) + "...";
                        } else {
                            teamOneLocation = teamOnedata.location;
                        }
                        $("#selectedTeamName").html(teamOneName);
                        $("#selectedTeamLocation").html(teamOneLocation);
                        var team_url = "{{ url('team') }}/" + teamOnedata.id;
                        $("#selectedTeamLink").removeAttr("href");
                        $('#selectedTeamLink').attr('href', team_url);
                        if (teamOnedata.team_logo != "") {
                            $("#selectedTeamLogo").attr("src", '{{ url('frontend/logo') }}/' +
                                teamOnedata.team_logo);
                        } else {
                            $("#selectedTeamLogo").attr("src",
                                '{{ url('frontend/logo/competitions-icon-128.png') }}');
                        }
                    }
                }
            });
        } else {
            $("#teamOne").children('option').removeAttr('disabled')
            $("#selectedTeamName").html("Team One");
            $("#selectedTeamLocation").html("Team Location");
            $("#selectedTeamLink").removeAttr("href");
            $('#selectedTeamLink').attr('href', "#");
            $("#selectedTeamLogo").attr("src", '{{ url('frontend/logo/competitions-icon-128.png') }}');
        }
    });

    $("#teamTwo").on("change", function() {
        var selectedTeamOne = $("#teamOne").val();
        var selectedTeamTwo = $("#teamTwo").val();
        if (selectedTeamTwo != "") {
            $("#teamOne").children('option').removeAttr('disabled');
            $("#teamTwo").children('option').removeAttr('disabled');
            if (selectedTeamOne != "") {
                $("#teamTwo option[value=" + selectedTeamOne + "]").prop('disabled', true);
            }
            $("#teamOne option[value=" + selectedTeamTwo + "]").prop('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('search_team') }}',
                type: 'Get',
                data: {
                    team_id: selectedTeamTwo,
                },
                error: function() {
                    alert('something went wrong');
                },
                success: function(response) {
                    console.log("search_team", response);
                    if (response.status == 1) {
                        var teamTwodata = response.data;
                        var teamTwoName;
                        if (teamTwodata.name.length > 8) {
                            teamTwoName = teamTwodata.name.substring(0, 8) + "...";
                        } else {
                            teamTwoName = teamTwodata.name;
                        }
                        var teamTwoLocation;
                        if (teamTwodata.location.length > 12) {
                            teamTwoLocation = teamTwodata.location.substring(0, 12) + "...";
                        } else {
                            teamTwoLocation = teamTwodata.location;
                        }
                        $("#selectedTeamName2").html(teamTwoName);
                        $("#selectedTeamLocation2").html(teamTwoLocation);
                        var team_url = "{{ url('team') }}/" + teamTwodata.id;
                        $("#selectedTeamLink2").removeAttr("href");
                        $('#selectedTeamLink2').attr('href', team_url);
                        if (teamTwodata.team_logo != "") {
                            $("#selectedTeamLogo2").attr("src", '{{ url('frontend/logo') }}/' +
                                teamTwodata.team_logo);
                        } else {
                            $("#selectedTeamLogo2").attr("src",
                                '{{ url('frontend/logo/competitions-icon-128.png') }}');
                        }
                    }
                }
            });
        } else {
            $("#teamTwo").children('option').removeAttr('disabled');
            $("#selectedTeamName2").html("Team Two");
            $("#selectedTeamLocation2").html("Team Location");
            $("#selectedTeamLink2").removeAttr("href");
            $('#selectedTeamLink2').attr('href', "#");
            $("#selectedTeamLogo2").attr("src", '{{ url('frontend/logo/competitions-icon-128.png') }}');
        }
    });

    $("#save_competition").on("click", function() {
        var comp_id = $('#comp_id').val();
        var b = 0;
        var checkboxesChecked = [];
        $("input:checkbox[name=comp_team_stat]:checked").each(function() {
            checkboxesChecked.push($(this).val());
        });
        if (competition_type == "") {
            var comp_type_id = 1;
        } else {
            var comp_type_id = competition_type;
        }
        var teamOne = $("#teamOne").val();
        if (comp_type_id == 1 && teamOne == "") {
            $('#selectTeamOne_error').html("Select team for competition");
            b++;
        } else {
            $('#selectTeamOne_error').html("");
        }
        var teamTwo = $("#teamTwo").val();
        if (comp_type_id == 1 && teamTwo == "") {
            $('#selectTeamTwo_error').html("Select team for competition");
            b++;
        } else {
            $('#selectTeamTwo_error').html("");
        }
        var secondkeyranking = $('#secondkeyranking').val();
        var thirdkeyranking = $('#thirdkeyranking').val();
        var player_ranking = "";

        console.log(comp_id, checkboxesChecked, comp_type_id, teamOne, teamTwo, secondkeyranking,
            thirdkeyranking, );
        if (comp_id != "" && b == 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('save_competition') }}',
                type: 'POST',
                data: {
                    comp_id: comp_id,
                    comp_type_id: comp_type_id,
                    comp_team_stat: checkboxesChecked,
                    teamOne: teamOne,
                    teamTwo: teamTwo,
                    secondkeyranking: secondkeyranking,
                    thirdkeyranking: thirdkeyranking,
                    player_ranking: player_ranking,
                },
                error: function() {
                    alert('something went wrong');
                },
                success: function(response) {
                    // console.log("save_competition", response);
                    if (response.status == 1) {
                        location.href = '{{ url('competition') }}/' + response.compe_id;
                    }
                }
            });
        }
    });
</script>
<script>
    $(document).on('click', '#send_request_admin', function() {

        var memberid = $('#select_admin').val();
        var comp_id = $('#comp_id').val();
        var s = 0;
        var comp_name = $('#comp_name').val();
        if (comp_name == '') {
            s++;
        } else {
            if (comp_name.length > 30) {
                s++;
            }
        }

        if (comp_id != "" && s == 0) {
            if (memberid == "") {
                alert('Select Competition admin ');
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('send_request_compadmin') }}",
                    type: 'post',
                    data: {
                        memberid: memberid,
                        comp_id: comp_id
                    },
                    error: function() {
                        // alert('Something is Wrong');
                    },
                    success: function(response) {
                        $('#select_admin').empty();
                    }

                });
            }
        } else {
            if (comp_id == "") {
                alert('Create Competition');
            }
        }
    });
</script>
<script>
    $(document).on('click', '#send_request_referee', function() {
        var refreeid = $('#select_referee').val();
        var comp_id = $('#comp_id').val();
        var u = 0;
        var comp_name = $('#comp_name').val();
        if (comp_name == '') {
            u++;
        } else {
            if (comp_name.length > 30) {
                u++;
            }
        }

        if (comp_id != "" && u == 0) {
            if (refreeid == "") {
                alert('Select Competition refree');
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('send_request_referee') }}",
                    type: 'post',
                    data: {
                        comp_id: comp_id,
                        refreeid: refreeid,
                    },
                    error: function() {
                        // alert('Something is Wrong');
                    },
                    success: function(response) {
                        console.log(response);
                        $('#select_referee').empty();
                    }
                });
            }
        } else {
            if (comp_id == "") {
                alert('Create Competition');
            }
        }
    });
</script>
<script type="text/javascript">
    $('.typeahead').select2({
        placeholder: 'Select Admins then click + ',
        ajax: {
            url: "{{ url('autosearch_compmember_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + ' ' + item.l_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.comp_typeahead').select2({
        placeholder: 'Select Referee then click +',
        ajax: {
            url: "{{ url('autosearch_comprefree_name') }}",
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log(data);
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + ' ' + item.l_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
<!-- <script>
    $(".removeclassRoundo1").on('click', function() {
        $(".round01").hide();
    });
</script> -->

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
<script>
    $('#triggerAll').on('click', function() {
        $('.processed').trigger('click');
    });
</script>
<script>
    $(document).ready(function() {
        $('#triggerAll').on('click', function() {
            $(this).addClass('clicked');
            // Add your refresh logic here if needed
            setTimeout(function() {
                $('#triggerAll').removeClass('clicked');
            }, 1000); // Adjust the time based on your animation duration
        });
    });
</script>
@include('frontend.includes.searchScript')
</body>

</html>
