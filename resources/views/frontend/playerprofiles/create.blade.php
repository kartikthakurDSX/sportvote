@include('frontend.includes.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span> Create <strong> Player
                        Profile</strong></h1>
            </div>
        </div>
    </div>
</div>
<main id="main">
    <div class="container">
        <div class="row md-6">
            <div class="col-lg-7 col-md-6 pe-0 pb-5 col-sm-3 mx-auto ">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
                @endif
                <div class="step-wizard">
                    <ul id="multi-progressbar" class="text-center ">
                        <li class="step">1</li>
                        <li class="step">2</li>
                        <li class="step">3</li>
                        <li class="step">4</li>
                        <li class="step">5</li>
                        <li class="step">6</li>

                    </ul>
                </div>
                <div class="create-profile px-4 py-4">

                    <form class="" action="{{ route('player_profile.store') }}" method="post" id="regForm1" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!-- Circles which indicates the steps of the form: -->
                        <div class="tab personal-info">
                            <div class="row">
                                <div class="col-lg-12 heading-navy">
                                    <h4>Verify Personal Info</h4>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 p-2">
                                    <img id="blah" src="{{ url('frontend/profile_pic') }}/{{ $data['profile_pic'] }}" alt="" width="100px" height="100px" class="rounded-circle" style="">
                                    <label for="profile_pic" style="position: absolute; margin-top:60px; width:30px; height:30px" title="Upload Profile Picture" class="rounded-lg rounded-circle bg-danger"><i class="fa-solid fa-pen-to-square text-light h5 p-1"></i>
                                    <input type="file" class="grey-form-control browse-control input-sm" id="profile_pic" name="profile_pic" hidden value="{{$data['profile_pic']}}" accept="image/*"/></label>
                                    <span class="text-danger" id="profile_pic_error" style="display: none;">Profile Image is required</span>
                                </div>
                                <div class="col-md-6 p-2">
                                    <label class="mb-2" for="plyr_fname">First Name *</label>
                                    <input type="text" class="grey-form-control  input-sm border rounded p-2" placeholder="Name" id="plyr_fname" name="first_name" value="  {{ $data['first_name'] }}">
                                    <span class="text-danger" id="fname" style="display: none;">* First Name is required</span>
                                    <span class="text-danger" id="fname_err" style="display: none;">* First Name Should be alphabet</span>
                                </div>
                                <div class="col-md-6 p-2">
                                    <label class="mb-2" for="plyr_lname">Last Name *</label>
                                    <input type="text" class="grey-form-control  input-sm border rounded p-2" placeholder="Name" id="plyr_lname" name="last_name" value=" {{ $data['last_name'] }}">
                                    <span class="text-danger" id="lname" style="display: none;">* Last Name is required</span>
                                    <span class="text-danger" id="lname_err" style="display: none;">* Last Name Should be alphabet</span>
                                </div>
                                <div class="col-md-6 p-2"><label class="mb-2" for="">Date of Birth *</label>
                                    <div class="input-group">
                                        <input type="text" onfocus="(this.type='date')" id="date" class="grey-form-control browse-control input-sm border rounded p-2" max="<?=date('Y-m-d', strtotime("-15 year", strtotime(date('Y-m-d'))));?>" name="dob" placeholder="Date of birth" value="{{ $data['dob'] }}" />
                                        <span class="text-danger" id="dob" style="display: none;">* Date of Birth is required</span>
                                        <span class="text-danger" id="dobv" style="display: none;">* Your age must be 15 or more than 15 years</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="mb-2 mt-2" for="plyr_height">Height (cm) *</label>
                                    <input type="number" step="anyMo" class="grey-form-control  input-sm border rounded p-2" min="1" max="999" placeholder="Your Height" id="plyr_height" name="height" value="{{ $data['height'] }}">

                                    <span class="text-danger" id="height_error" style="display: none;">* Height is required</span>
                                    <span class="text-danger" id="height_error2" style="display: none;">* Please enter correct Height in cm.</span>
                                    <span class="text-danger" id="height_error1" style="display: none;">* Please enter correct Height in cm.</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-2 mt-2" for="plyr_weight">Weight (kg) *</label>
                                    <input type="number" step="any" class="grey-form-control  input-sm border rounded p-2" min="1" max="999" placeholder="Your Weight" id="plyr_weight" name="weight" value="{{ $data['weight'] }}">

                                    <span class="text-danger" id="weight_error" style="display: none;">* Weight is required.</span>
                                    <span class="text-danger" id="weight_error2" style="display: none;">* Please enter correct Weight in kg.</span>
                                    <span class="text-danger" id="weight_error1" style="display: none;">* Please enter correct Weight in kg.</span>
                                </div>
                                <div class=" col-lg-12">
                                    <label class="mb-1 mt-2" for="plyr_bio">Your Bio *</label>
                                    <textarea rows="5" class="grey-form-textarea  input-sm rounded border" placeholder="Bio" id="textarea_bio" name="bio">{!! $data->bio !!}</textarea>
                                    <span class="text-danger" id="bio_error" style="display: none;">* Bio is required</span>
                                    <span class="text-danger" id="bio_error2" style="display: none;">* Bio must not be greater than 250 characters.</span>
                                </div>
                                <div class="col-md-6"><label class="mb-2" for="plyr_nationality">Nationality *</label>
                                    <select name="nationality" id="plyr_nationality" type="text" class="form-control form-select-fancy-1 border rounded " style="padding:5%;">
                                        <option value="">Choose...</option>
                                        <option value="{{ $data->nationality }}" {{ $data->nationality == $data->nationality ? 'selected' : '' }}>
                                            {{ $data->nationality }}
                                        </option>
                                        @foreach ($countries as $c)
                                        <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="nationality" style="display: none;">* Nationality is required</span>
                                </div>
                                <div class="col-md-6"><label class="mb-2" for="plyr_l/c">Location *</label>
                                    <div class="input-group">
                                        <input type="text" class=" grey-form-control input-sm rounded border p-2" placeholder="Your Location/City" wire:model.debounce.120s="comp_location" autocomplete="off" name="location" id="location" value="{{ $data['location'] }}">
                                    </div>
                                    <span class="highlight"></span>
                                    <span class="text-danger" id="location_error" style="display: none;">* Location is required</span>
                                </div>
                            </div>
                            <button type="button" id="step_one" class="btn col-5 btn-submit float-md-end">Next</button>
                        </div>

                        <div class="tab">
                            <div class="row">
                                <div class="col-lg-12 heading-navy">
                                    <h4>Sport Info</h4>
                                </div>
                            </div>
                            <label class="mb-2">Select the Sport you Play</label>
                            <div class="competition-list mb-3">
                                <ul class="games-list owl-4-slider owl-carousel owl-loaded owl-drag">
                                    <li class="item">
                                        <input type="radio" name="sport_id" value="1" id="soccer" checked />
                                        <label for="competition"><span> Soccer
                                            </span><i class="icon-check checked-badge" id="default_sport_icon"></i></label>
                                    </li>
                                    <li class="item"><input type="radio" name="sport_id" value="2" id="Basketball" class="coming_soon_sports">
                                    <label for="competition"><span>Basketball </span><i class="icon-check checked-badge"></i></label>
                                    </li>
                                    <li class="item "><input type="radio" name="sport_id" value="3" id="Cricket" class="coming_soon_sports"><label for="competition"><span>
                                                Cricket </span><i class="icon-check checked-badge"></i></label></li>
                                    <li class="item "><input type="radio" name="sport_id" value="4" id="Volleyball" class="coming_soon_sports"><label for="competition"><span>
                                                Volleyball </span><i class="icon-check checked-badge"></i></label>
                                    </li>
                                    <li class="item "><input type="radio" name="sport_id" value="5" id="Rugby" class="coming_soon_sports"><label for="competition"><span>
                                                Rugby </span><i class="icon-check checked-badge"></i></label></li>
                                    <li class="item"><input type="radio" name="sport_id" value="6" id="Hockey" class="coming_soon_sports"><label for="competition"><span>
                                                Hockey </span><i class="icon-check checked-badge"></i></label></li>
                                </ul>
                                <span class="text-danger" id="sport_error" style="display: none;">* Sports is required</span>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="">Preferred Position *</label>
                                <select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="preferred_position" id="preferred_position">
                                    <option value="">Select Position</option>
                                    @foreach ($player_position as $position)
                                    <option value="{{ $position->id }}" name="preferred_position">
                                        {{ $position->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="position_error" style="display: none;">* Preferred Position is required</span>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="" for="">Your Level in the Sport *</label>
                                    <select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="sport_level" id="sport_level">
                                        <option value="">Select Sport Level</option>
                                        @foreach ($usportlevel as $uslevel)
                                        <option value="{{ $uslevel->id }}">{{ $uslevel->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="sport_level_error" style="display: none;">* Sport Level is required</span>
                                </div>

                                <div class="col-md-6"><label class="" for="">Proof of Level (Upload
                                        File)</label>
                                    <div class="input-group">
                                        <input type="file" class="grey-form-control browse-control input-sm" id="" name="level_proof">

                                    </div>
                                    @if ($errors->has('level_proof'))
                                    <span class="text-danger text-left">{{ $errors->first('level_proof') }}*</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-block mt-3">
                                <button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel" onclick="nextPrev(-1)">Pervious</button>
                                <button type="button" id="step_two" class="btn col-5 btn-submit float-md-end">Next</button>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="row">
                                <div class="col-lg-12 heading-navy">
                                    <h4>Certificates <button type="button" class="addRow2 float-md-end btn btn-secondary btn-sm"><i class="icon-plus"></i>Add
                                            More</button></h4>
                                </div>
                            </div>
                            <div class="add-more-group user-details">
                                <div class="user_data position-relative px-2">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="" for="plyr_certi_n">Certificate Name</label>
                                            <input type="text" class="grey-form-control  input-sm p-1 border rounded" placeholder="Certificate Name" id="plyr_certi_n" name="certname[]">

                                            @if ($errors->has('certname'))
                                            <span class="text-danger text-left">{{ $errors->first('certname') }}*</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="" for="plyr_certi_file">Upload File</label>
                                            <input type="file" class="grey-form-control  input-sm" id="plyr_certi_file" name="certificate[]">

                                            @if ($errors->has('certificate'))
                                            <span class="text-danger text-left">{{ $errors->first('certificate') }}*</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="" for="plyr_certi_desc">Description</label>
                                            <textarea rows="3" class="grey-form-textarea  input-sm" placeholder="Description" id="plyr_certi_desc" name="certdescription[]"></textarea>

                                            @if ($errors->has('certdescription'))
                                            <span class="text-danger text-left">{{ $errors->first('certdescription') }}*</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="newRow2"></div>
                            <div class="d-grid gap-2 d-md-block mt-3">
                                <button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel" onclick="nextPrev(-1)">Pervious</button>
                                <button type="button" id="step_two" class="btn col-5 btn-submit float-md-end" onclick="nextPrev(1);">Next</button>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-lg-12 heading-navy">
                                    <h4>Memberships <button type="button" class="addRow1 float-md-end btn btn-secondary btn-sm"><i class="icon-plus"></i>Add
                                            More</button></h4>
                                </div>
                            </div>
                            <div class="add-more-group user-details">
                                <div class="user_data position-relative px-2">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="" for="plyr_mem_n">Membership Name</label>
                                            <input type="text" class="grey-form-control  input-sm border  rounded p-2" placeholder="Membership Name" id="plyr_mem_n" name="name[]">

                                            @if ($errors->has('name'))
                                            <span class="text-danger text-left">{{ $errors->first('name') }}*</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="" for="plyr_membr_file">Upload File</label>
                                            <input type="file" class="grey-form-control  input-sm" id="plyr_membr_file" name="logo[]">

                                            @if ($errors->has('logo'))
                                            <span class="text-danger text-left">{{ $errors->first('logo') }}*</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">

                                        <div class="col-md-12">
                                            <label class="" for="plyr_membr_desc">Description</label>
                                            <textarea rows="3" class="grey-form-textarea  input-sm" placeholder="Description" id="plyr_membr_desc" name="description[]"></textarea>

                                            @if ($errors->has('description'))
                                            <span class="text-danger text-left">{{ $errors->first('description') }}*</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="newRow1"></div>
                            <div class="d-grid gap-2 d-md-block mt-3">
                                <button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel" onclick="nextPrev(-1)">Pervious</button>
                                <button type="button" id="step_two" class="btn col-5 btn-submit float-md-end" onclick="nextPrev(1);">Next</button>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-lg-12 heading-navy">
                                    <h4>Request to Join a Team<button type="button" class="addRow float-md-end btn btn-secondary btn-sm"><i class="icon-plus"></i>Add
                                            More</button></h4>
                                </div>
                            </div>

                            <div class="add-more-group user-details">
                                <div class="row mb-3 user_data position-relative">

                                    <div class="col-md-12 mb-3">
                                        <label class="col-lg-12 py-2" for="search_team">Search for a Team
                                        </label>
                                        <input class="typeahead form-control border p-2 rounded" type="text" id="search_team">
                                        <span id="result"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="" for="join_reason">Cover Letter</label>
                                        <textarea rows="2" maxlength="200" class="grey-form-textarea  input-sm" placeholder="Cover Letter" id="join_reason" name="reason[]"></textarea>
                                        <span class="text-danger" id="join_reason_error" style="display: none;">* Cover Letter is required</span>
                                    </div>

                                     <div class="col-md-12 mb-2">
                                                    <label class="">Preferred Position</label>
                                                    <select class="form-control form-select-fancy-1"
                                                        aria-label=".form-select-lg example" name="plyrpreferred_position[]" id="plyrpreferred_position">
                                                        <option value="">Select Positiion</option>
                                                        @foreach ($player_position as $position)
                                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                        @endforeach
                                                    </select>
                                    <span class="text-danger" id="plyrposition_error" style="display: none;">* Preferred Position is required</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="">Alternative Position 1</label>
                                    <select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="plyr_alt_preferred_position1[]" id="sport">
                                        <option value="">Select Positiion</option>
                                        @foreach ($player_position as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="">Alternative Position 2</label>
                                    <select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="plyr_alt_preferred_position2[]" id="sport">
                                        <option value="">Select Positiion</option>
                                        @foreach ($player_position as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                            <div class="newRow"></div>
                            <div class="d-grid gap-2 d-md-block mt-3">
                                <button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel" onclick="nextPrev(-1)">Pervious</button>
                                <button type="button" id="step_five" class="btn col-5 btn-submit float-md-end">Next</button>
                            </div>


                        </div>
            <div class="row mb-3">

            </div>
        </div>


        <div class="tab">
            <div class="row">
                <div class="col-lg-12 heading-navy">
                    <h4>Settings</h4>
                </div>
            </div>
            <div class="row mb-3" id="multi-select-boxes">
                <div class="col-md-12">
                    <div class="row mb-3" id="multi-select-boxes">
                        <div class="col-md-6">
                            <label for="accept_teamlevel_invite" class="form-label select-label">Who
                                can send you invitations?</label>
                            <select class="multiselect rounded" name="accept_team_invite" id="accept_teamlevel_invite" style="width: 100%;">
                                <option value="0">No Teams</option>
                                <option value="1" selected><b style="color:black;">All Teams</b></option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="accept_userlevel_type" class="form-label select-label">Who
                                can send you friend requests?</label>
                            <select class="multiselect rounded" name="accept_user_invite" id="accept_userlevel_type" style="width: 100%;">
                                <option value="0"> <b style="color:black;">Nobody</b></option>
                                <option value="1"> <b style="color:black;">Freinds' Freind</b></option>
                                <option value="2" selected><b style="color:black;">Everybody</b></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-block mt-3">
                <button type="button" id="prevBtn" class="btn col-5 btn-default btn-cancel" onclick="nextPrev(-1)">Pervious</button>
                <button type="submit" id="step_six" class="btn col-5 btn-submit float-md-end" > Save</button>
            </div>
        </div>
        </form>
    </div>
    </div>
    </div>
    </div>
</main>


@include('frontend.includes.footer')
<script src="{{ url('frontend/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ url('frontend/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ url('frontend/js/jquery-ui.js') }}"></script>
<script src="{{ url('frontend/js/popper.min.js') }}"></script>

<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ url('frontend/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ url('frontend/js/aos.js') }}"></script>
<script src="{{ url('frontend/js/script.js') }}"></script>

<script src="{{ url('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('frontend/js/main.js') }}"></script>
<script src="{{ url('frontend/js/multi-step2.js') }}"></script>
<script type="text/javascript" src="{{ url('frontend/assets/js/bootstrap-multiselect.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example-getting-started').multiselect({

            buttonWidth: '100%'
        });
        $('.hide').hide();
        $('#add_friends').multiselect({

            buttonWidth: '100%'
        });
        $('#fvt_team').multiselect({

            buttonWidth: '100%'
        });
        $('#select_competition').multiselect({

            buttonWidth: '100%'
        });
        $('#follow_comp').multiselect({

            buttonWidth: '100%'
        });
        $('#follow_team').multiselect({

            buttonWidth: '100%'
        });
        $('#follow_player').multiselect({

            buttonWidth: '100%'
        });
        $('#accept_userlevel_type').multiselect({

            buttonWidth: '100%'
        });
        $('#accept_teamlevel_invite').multiselect({

            buttonWidth: '100%'
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var b = 0;
    $(".addRow").click(function() {
        b += 1;
        var player_positions = '<?php echo $player_position; ?>';
        console.log(JSON.parse(player_positions));
        var html = '';
        html += '<div class="row mb-3 user_data position-relative"><div class="col-md-12 "></div>';
        html +=
            '<div class="col-md-12 mb-3 "><label class="" for="search_sport ">Search for a Team <button  type="button" class="removeRow float-md-end btn btn-danger ">&times;</button></label><input class="typeahead form-control border p-2 rounded" type="text"id="search_team'+b+'"></div><div class="col-md-12"><label class="" for="join_reason">Cover Letter</label><textarea rows="2" maxlength="200" class="grey-form-textarea  input-sm" placeholder="Cover Letter"  id="join_reason'+b+'" name="reason[]"></textarea>';
        html += '<span class="text-danger" id="join_reason_error'+b+'" style="display: none;">* Cover Letter is required</span></div><div class="col-md-12 mb-2"><label class="">Preferred Position</label><select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="plyrpreferred_position[]" id="plyrpreferred_position'+b+'"><option value="">Select Positiion</option>';
        $.each(JSON.parse(player_positions), function (key, val) {
            html += '<option value="'+val.id+'">'+val.name+'</option>';
        });
        html += '</select><span class="text-danger" id="plyrposition_error'+b+'" style="display: none;">* Preferred Position is required</span></div><div class="row" style="width: 103%; max-width: 105%;"><div class="col-md-6 mb-2"><label class="">Alternative Position 1</label><select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="plyr_alt_preferred_position1[]" id="sport"><option value="">Select Positiion</option>';
        $.each(JSON.parse(player_positions), function (key, val) {
            html += '<option value="'+val.id+'">'+val.name+'</option>';
        });
        html += '</select></div><div class="col-md-6 mb-2"><label class="">Alternative Position 2</label><select class="form-control form-select-fancy-1" aria-label=".form-select-lg example" name="plyr_alt_preferred_position2[]" id="sport"><option value="">Select Positiion</option>';
        $.each(JSON.parse(player_positions), function (key, val) {
            html += '<option value="'+val.id+'">'+val.name+'</option>';
        });
        html += '</select></div></div></div>';
        $('.newRow').append(html);

        var path = "{{ url('autosearch_team') }}";

        $('input.typeahead').typeahead({

            afterSelect: function(item) {
                this.$element[0].value = item.name;
                var team_id = item.id;

                $("#result").append('<input type="hidden" name="search[]" value="' + team_id +
                    '" id="team_id">');
            },

            source: function(query, process) {
                return $.get(path, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    });

    function valid(){
        var c = 0;
        for(let y=1; y<=b; y++)
        {
            var competition = $("#search_team"+y).val().trim();
            var cover_letter = $("#join_reason"+y).val().trim();
            var pref_position = $("#plyrpreferred_position"+y).val().trim();

            if (competition != '') {
                if (cover_letter == '') {
                    $('#join_reason_error'+y).show();
                    c++;
                } else {
                    $('#join_reason_error'+y).hide();
                }
            }
            if (competition != '') {
                if (pref_position == '') {
                    $('#plyrposition_error'+y).show();
                    c++;
                } else {
                    $('#plyrposition_error'+y).hide();
                }
            }
        }

        if (c == 0) {
            nextPrev(1);
        }
    }

    $(".addRow1").click(function() {
        var html = '';

        html +=
            '<div class="user_data position-relative px-2"><div class="row mb-3"><div class="col-md-6"><label class="" for="plyr_mem_n">Membership Name</label><input type="text" class="grey-form-control  input-sm" placeholder="Membership Name" id="plyr_mem_n" name="name[]"></div><div class="col-md-6"><label class="" for="plyr_membr_file">Upload File</label><input type="file" class="grey-form-control  input-sm" id="plyr_membr_file" name="logo[]"></div></div><button  type="button" class="removeRow float-md-end btn btn-danger ">&times;</button><div class="row mb-3"><div class="col-md-12"><label class="" for="plyr_membr_desc">Description</label><textarea rows="3" class="grey-form-textarea  input-sm" placeholder="Description"  id="plyr_membr_desc" name="description[]"></textarea></div></div></div>';
        $('.newRow1').append(html);
    });

    $(".addRow2").click(function() {
        var html = '';

        html +=
            '<div class="user_data position-relative px-2"><div class="row mb-3"><div class="col-md-6"><label class="" for="plyr_certi_n">Certificate Name</label><input type="text" class="grey-form-control  input-sm" placeholder="Certificate Name" id="plyr_certi_n" name="certname[]"></div><div class="col-md-6"><label class="" for="plyr_certi_file">Upload File</label><input type="file" class="grey-form-control  input-sm" id="plyr_certi_file" name="certificate[]"></div></div><button  type="button" class="removeRow float-md-end btn btn-danger ">&times;</button><div class="row mb-3"><div class="col-md-12"><label class="" for="plyr_certi_desc">Description</label><textarea rows="3" class="grey-form-textarea  input-sm" placeholder="Description"  id="plyr_certi_desc" name="certdescription[]"></textarea></div></div></div>';

        $('.newRow2').append(html);
    });

    // remove row
    $(document).on('click', '.removeRow', function() {
        b -= 1;
        $(this).closest('.user_data').remove();
    });

    function addmore(){
        if(b > 0){
            valid();
        }
        if(b == 0){
            nextPrev(1);
        }
    }
</script>

<script>
    var path = "{{ url('autosearch_team') }}";
    $('input.typeahead').typeahead({

        afterSelect: function(item) {
            this.$element[0].value = item.name;
            var team_id = item.id;

            $("#result").append('<input type="hidden" name="search[]" value="' + team_id +
                '" id="team_id">');
        },

        source: function(query, process) {
            return $.get(path, {
                query: query
            }, function(data) {
                return process(data);
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#player_level').hide();

        $('#regForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('player_profile.store') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    alert('finish');
                },
                error: function(error) {
                    console.log({error:error.response});
                    alert('error');
                }
            });
        });
    });
</script>

<script>
    function handleClick(myRadio) {
        var selectedValue = myRadio.value;
        if (selectedValue == 2) {
            $('#player_level').show();
        } else {
            $('#player_level').hide();
        }
    };
</script>

{{-- script for profile pic --}}
<script>
    profile_pic.onchange = evt => {
        const [file] = profile_pic.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>
{{-- For Ck Editor --}}
{{-- <script src="{{url('frontend/js/ckeditor.js')}}"></script> --}}

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('.bio'), {
            toolbar: ['bold', 'italic', 'link', 'space']
        })
        .catch(error => {
            console.log(error);
        });
</script>

{{-- for inline validation  --}}

<script>
    $(document).on('click', 'input', function() {
        var f_name = $('#plyr_fname').val();

        if (f_name == "") {
            $('#required_fname').show();
        }
        if (f_name != "") {
            $('#required_fname').hide();
        }

    });
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>
<script type="text/javascript">
    document.addEventListener('click', function() {
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
    $('#preferred_position').on('change', function() {
        var position = $('#preferred_position option:selected').val();
        $('#plyrpreferred_position').val(position, 'option:selected');
    });
    function step1() {
        var exist_profile_pic = '<?php echo $data['profile_pic']; ?>';
        var profile_pic = $('#profile_pic').val();
        var plyr_fname = $("#plyr_fname").val().trim();
        var plyr_lname = $("#plyr_lname").val().trim();
        var date = $("#date").val().trim();
        var plyr_bios = $("#textarea_bio").val().trim();
        var plyr_height = $("#plyr_height").val();
        var plyr_weight = $("#plyr_weight").val();
        var plyr_nationality = $("#plyr_nationality").val().trim();
        var plyr_location = $("#location").val().trim();
        var x = 0;
        
        var result = date.split('-');
        var currentYear = (new Date).getFullYear();
        var regex = new RegExp('^[A-z]+$');

            //Validate TextBox value against the Regex.
            var isValid = regex.test(plyr_fname);
            var isValid2 = regex.test(plyr_lname);

        if(exist_profile_pic == '' || exist_profile_pic == 'default_profile_pic.png'){
            if (profile_pic == '') {
                $('#profile_pic_error').show();
                x++;
            } else {
                $('#profile_pic_error').hide();
            }
        }
        
        if (plyr_bios == '') {
            $('#bio_error').show();
            x++;
        } else {
            $('#bio_error').hide();

            if(plyr_bios.length > 250){
                $('#bio_error2').show();
                x++;
            }else{
                $('#bio_error2').hide();
            }
        }
        if (plyr_fname == '') {
            $('#fname').show();
            x++;
        } else {
            $('#fname').hide();
            if(!isValid)
            {
                $('#fname_err').show();
                x++;
            }
            else
            {
                $('#fname_err').hide();

            }
        }
        if (plyr_lname == '') {
            $('#lname').show();
            x++;
        } else {
            $('#lname').hide();
            if(!isValid2)
            {
                $('#lname_err').show();
                x++;
            }
            else
            {
                $('#lname_err').hide();

            }
        }
        if (plyr_height == '') {
            $('#height_error').show();
            x++;
        } else {
            $('#height_error').hide();

            if (plyr_height < 0) {
                $('#height_error1').show();
                x++;
            } else {
                $('#height_error1').hide();
            }
            if (plyr_height > 999) {
                $('#height_error2').show();
                x++;
            } else {
                $('#height_error2').hide();
            }
        }
        if (plyr_weight == '') {
            $('#weight_error').show();
            x++;
        } else {
            $('#weight_error').hide();

            if (plyr_weight < 0) {
                $('#weight_error1').show();
                x++;
            } else {
                $('#weight_error1').hide();
            }
            if (plyr_weight > 999) {
                $('#weight_error2').show();
                x++;
            } else {
                $('#weight_error2').hide();
            }
        }
        if (plyr_nationality == '') {
            $('#nationality').show();
            x++;
        } else {
            $('#nationality').hide();
        }
        if (plyr_location == '') {
            $('#location_error').show();
            x++;
        } else {
            $('#location_error').hide();
        }
        if (date == '') {
            $('#dob').show();
            x++;
        } else {
            // alert( currentYear );
            $('#dob').hide();
        }
        if (currentYear - result[0] < 15) {
            $('#dobv').show();
            x++;
        } else {
            $('#dobv').hide();
        }
        if (x == 0) {
            nextPrev(1);
        }
    };
    $('#step_one').on('click', function() {
        step1();
    });

    function step2(){
        var preferred_position = $("#preferred_position").val().trim();
        var sport_level = $("#sport_level").val().trim();
        var sport = $('input[name="sport_id"]:checked').length;
        var x = 0;
        if (sport == 0) {
            $('#sport_error').show();
            x++;
        } else {
            $('#sport_error').hide();
        }
        if (preferred_position == '') {
            $('#position_error').show();
            x++;
        } else {
            $('#position_error').hide();
        }
        if (sport_level == '') {
            $('#sport_level_error').show();
            x++;
        } else {
            $('#sport_level_error').hide();
        }
        if(x == 0){
            nextPrev(1);
        }
    }
    $('#step_two').on('click', function() {
        step2();
    });

    function step5(){
        var search_team = $("#search_team").val().trim();
        var join_reason = $("#join_reason").val().trim();
        var preferred_position = $("#plyrpreferred_position").val().trim();
        var x = 0;
        if (search_team != '') {
            if (join_reason == '') {

                $('#join_reason_error').show();
                x++;
            } else {
                $('#join_reason_error').hide();
            }
        }
        if (preferred_position == '') {
            $('#plyrposition_error').show();
            x++;
        } else {
            $('#plyrposition_error').hide();
        }
        if(x == 0){
            addmore();
        }
    }
    $('#step_five').on('click', function() {
        step5();
    });
</script>
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
    var user_id = '{{ url("edit_playerimg/")}}<?php echo '/'.$data->id;?>';
    console.log(user_id);
	$('#profile_pic').ijaboCropTool({
		setRatio:1,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl: user_id,
        withCSRF:['_token','{{ csrf_token() }}'],
		onSuccess:function(message, element, status){

			location.reload();
		},
		onError:function(message, element, status){
		    alert(message);
		}
	});
</script>

@include('frontend.includes.searchScript')
</body>

</html>
