<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<header class="py-4 shadow site-navbar" role="banner">

    <div class="container">
        <div class="d-flex align-items-center">
            <div class="site-logo">
                <a href="{{ url('/') }}">
                    <img class="site-img" src="{{ url('frontend/images/logo.png') }}" alt="SportVote Logo">
                </a>
            </div>
            <div class="widthSpiclSearch">
                <nav class="nav-extended white pushpin z-depth-3">
                    <div class="container nav-wrapper">
                        <form action="" class="browser-default right" id="searchForm">
                            <input id="search" placeholder="Search" type="text"
                                class="browser-default search-field" name="search" value="" autocomplete="off"
                                aria-label="Search box">
                            <label for="search-input">
                                <i class="material-icons search-icon">search</i>
                            </label>
                            <i class="material-icons search-close-icon">cancel</i>
                            <div class="search-content content-list SearchScroll" id="ResultHolderDiv">

                            </div>
                        </form>
                    </div>
                </nav>
            </div>
            <div class="ms-auto me-auto h-b-lr">
                <nav class="text-right site-navigation position-relative" role="navigation">
                    <ul class="site-menu js-clone-nav me-auto d-none d-lg-block">
                        {{-- <ul class="navdropdown d-flex main-menu"> --}}
                        <li class="active"><a href="{{ url('dashboard') }}" class="nav-link"><img
                                    src="{{ url('frontend/images/home01-icon.png') }}" class="icon-np">Home</a></li>
                        <!-- <li class="active"><a href="#" class="nav-link"><img src="{{ url('frontend/images/team-icon-128.png') }}" class="icon-np">Locate</a></li> -->
                        <li class="dropdown" id="compdropdown">
                            <a class="nav-link dropdown"><img
                                    src="{{ url('frontend/images/competitions-icon-128.png') }}" class="icon-np "
                                    id="comp">Competitions</a>
                            <ul class="dropdown-menu navdropdown compdropdownlist" id="comps">
                                <!-- <li> <a href="{{ url('follow_competitions') }}" class="dropdown-item ">I Follow</a></li> -->
                                <li> <a href="{{ url('all_competitions') }}" class="dropdown-item ">All Competitions</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown" id="teamdropdown"><a class=""><img
                                    src="{{ url('frontend/images/team-icon-128.png') }}" class="icon-np">Teams</a>
                            <ul class="dropdown-menu navdropdown">
                                <li> <a href="{{ url('all_teams') }}" class="dropdown-item ">All Teams</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="nav-link dropdown-toggle round-icon" href="#"
                                data-bs-toggle="dropdown"><i class="icon-plus "></i></a>
                            <span id="profiles">
                                {{-- <ul class="dropdown-menu fade-down c-profile-nav"> --}}
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"
                                    style=" transform:none; overflow:unset; background: #f4f6fa;">
                                    <li><a class="dropdown-item " href="#"><span class="create">
                                                Create</span><i class="icon-plus round-circle"></i></a>

                                    </li>

                                    <li><a href="{{ url('competition/create') }}" class="dropdown-item"><img
                                                src="{{ url('frontend/images/competitions-icon-128.png') }}"
                                                class="icon-np">A Competition </a></li>
                                    <li><a href="{{ url('team/create') }}" class="dropdown-item"><img
                                                src="{{ url('frontend/images/team-icon-128.png') }}" class="icon-np">A
                                            Team </a></li>
                                </ul>
                            </span>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="ms-auto">
                <nav class="notification-icons text-end" role="navigation">
                    <ul class="navdropdown">
                        <li><a href="{{ url('user_profile') }}/{{ Auth::user()->id }}" title="Profile">
                                @if (Auth::user()->profile_pic)
                                    <img
                                        src="{{ URL::asset('frontend/profile_pic') }}/{{ Auth::user()->profile_pic }}">
                                @else<img src="frontend/images/person_5.jpg">
                                @endif
                            </a><span class="p_name">{{ Auth::user()->first_name }}</span></li>
                        <!-- <li><a href="" title="notification"><i class="icon-bell"></i><span class="badge">12</span></a></li> -->
                        @php
                            // for localhost
                            $dynamicValue = request()->segment(2); // Get the value from the third segment of the URL
                            //    for dev server
                            // $dynamicValue = request()->segment(3);
                        @endphp
                        {{-- @if (request()->path() != "match-fixture/$dynamicValue")
                        <li><a href="{{ url('notifications') }}" title="Notifications">@livewire('notification-count')</a></li>
                        @endif --}}
                        {{-- <li><a href="{{ url('notifications') }}" title="Notifications">@livewire('notification-count')</a></li> --}}

                        <li class="dropdown" style="list-style: none;"><a class="dropdown-toggle" href="#"
                                role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"
                                onMouseOver="this.style.color='#065596'" onMouseOut="this.style.color='#065596'"><i
                                    class="icon-angle-down "></i></a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"
                                style=" transform:none; overflow:unset; background: #f4f6fa;">
                                <li class="text-center"><a href="{{ url('setting') }}" class="dropdown-item"
                                        style="border-bottom: 1px ridge #eee;"> Settings </a></li>


                                <li><a href="{{ url('user_profile') }}/{{ Auth::user()->id }}" class="dropdown-item"
                                        style="border-bottom: 1px ridge #eee;">
                                        Edit Profile </a></li>



                                <li><a href="{{ url('features') }}" class="dropdown-item"
                                        style="border-bottom: 1px ridge #eee;"> Features </a></li>

                                <li><a href="{{ url('pricing') }}" class="dropdown-item"
                                        style="border-bottom: 1px ridge #eee;"> Pricing </a></li>

                                <li><a href="{{ url('terms') }}" class="dropdown-item"
                                        style="border-bottom: 1px ridge #eee;"> Terms of Use </a></li>

                                <li><a href="{{ url('logout') }}" class="dropdown-item"
                                        style="border-bottom: 1px ridge #eee;"> Logout </a></li>

                            </ul>

                        </li>

                    </ul>



                </nav>


            </div>

        </div>
    </div>
</header>

<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<script type="text/javascript" src="{{ url('frontend/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('frontend/js/jquery.js') }}"></script>
<script src="{{ url('frontend/js/typeahead.js') }}"></script>
<script>
    $(window).on('load', function() {
        var popup = $('#popup').val();
        if (popup == 2) {
            $('#login_basicinfo_popup').show();
            $('#onload').modal('show');
        }
        if (popup == 3) {
            $('#login_profile_popup').show();
        }
    });
</script>

<script>
    $(document).on('click', '#submit_login_profile', function() {
        var f_name = $('#f_name').val();
        var l_name = $('#l_name').val();
        if (f_name == "" || l_name == "") {
            $('#required_name').show();
        }
        var dob = $('#dob').val();
        var p_location = $('#p_location').val();
        var nation = $('#nation').val();
        var bio = $('#bio').val();
        var dob = $('#dob1').val();
        if (dob == "") {
            $('#required_dob').show();
        }
        if (p_location == "") {
            $('#required_location').show();
        }
        if (nation == "") {
            $('#required_national').show();
        }
        var termsofuse = $('#termsofuse').val();
        //    alert(termsofuse)
        if (termsofuse == '0') {
            $('#terms_error1').html('Please Check Terms of Use');
        }
        var userid = $('#login_user').val();
        if (termsofuse == '1' && f_name != "" && l_name != "") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('updatProfile') }}",
                type: 'post',
                data: {
                    userid: userid,
                    f_name: f_name,
                    l_name: l_name,
                    dob: dob,
                    p_location: p_location,
                    nation: nation,
                    bio: bio,
                    termsofuse: termsofuse
                },
                error: function() {
                    alert('Something is Wrong');
                },
                success: function(response) {
                    console.log(response);
                    if (response == 1) {
                        $('#login_basicinfo_popup').hide();
                        $('#login_profile_popup').show();
                    }
                }

            });
        }
    });
</script>
<script>
    $('#termsofuse').change(function() {
        if ($(this).is(':checked')) {
            // alert('1');
            $('#termsofuse').val('1');
            $('#terms_error').hide();
        } else {
            $('#termsofuse').val('0');

        }
    });
</script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>

<script type="text/javascript">
    $(document).on('click', '#p_location', function() {
        var autocomplete;
        var id = 'p_location';
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
            type: ['geocode'],
        })
    });
</script>
<script>
    function handleClicklogin(myRadio) {
        var selectedValue = myRadio.value;
        var userid = $('#login_user').val();
        // alert(selectedValue);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('userProfile') }}",
            type: 'post',
            data: {
                selectedValue: selectedValue,
                userid: userid
            },
            error: function() {
                alert('Something is Wrong');
            },
            success: function(response) {
                if (response == 1) {
                    location.href = "{{ url('fan') }}";
                }
                if (selectedValue == 2) {
                    location.href = "{{ url('player_profile') }}";
                }
                if (selectedValue == 5) {
                    location.href = "{{ url('referee') }}";
                }
                if (selectedValue == 3) {
                    location.href = "{{ url('team') }}";

                }
                if (selectedValue == 4) {
                    location.href = "{{ url('competition') }}";

                }
            }
        });

    };
</script>



<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('checkUserprofile') }}",
            type: 'get',

            error: function() {
                //alert('Something is Wrong');
            },
            success: function(response) {
                if (response == 0) {
                    $('#profiles ul').append(
                        '<li><a class="dropdown-item" href="{{ url('player_profile') }}"><img src="{{ url('frontend/images/team-icon-128.png') }}" class="icon-np"> A Player Profile</a></li>'
                    );
                }

            }

        });
    });
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('checkrefreeprofile') }}",
            type: 'get',

            error: function() {
                //alert('Something is Wrong');
            },
            success: function(response) {
                if (response == 0) {
                    $('#profiles ul').append(
                        '<li><a class="dropdown-item" href="{{ url('referee') }}"><img src="{{ url('frontend/images/team-icon-128.png') }}" class="icon-np">A Referee Profile</a></li>'
                    );
                }
            }

        });
    });
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('checkCompetitionMenus') }}",
            type: 'get',

            error: function() {
                //alert('Something is Wrong');
            },
            success: function(response) {
                if (response.mycomps == 1) {
                    $('#compdropdown ul').prepend(
                        '<li> <a href="{{ url('created_competitions') }}" class="dropdown-item ">I Created</a></li>'
                    );
                }
                if (response.comp_follows == 1) {
                    $('#compdropdown ul').prepend(
                        '<li> <a href="{{ url('follow_competitions') }}" class="dropdown-item ">I Follow</a></li>'
                    );
                }
                if (response.participatedcomp == 1) {
                    $('#compdropdown ul').prepend(
                        '<li> <a href="{{ url('participate_competitions') }}" class="dropdown-item ">I Participate in</a></li>'
                    );
                }

            }

        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('checkteamMenus') }}",
            type: 'get',

            error: function() {
                //alert('Something is Wrong');
            },
            success: function(response) {
                if (response.myteams == 1) {
                    $('#teamdropdown ul').prepend(
                        '<li> <a href="{{ url('created_teams') }}" class="dropdown-item ">I Created</a></li>'
                    );
                }
                if (response.team_follows == 1) {
                    $('#teamdropdown ul').prepend(
                        '<li> <a href="{{ url('following_teams') }}" class="dropdown-item ">I Follow</a></li>'
                    );
                }
                if (response.participatedteams == 1) {
                    $('#teamdropdown ul').prepend(
                        '<li> <a href="{{ url('participated_teams') }}" class="dropdown-item ">I Participate in</a></li>'
                    );
                }

            }

        });
    });
</script>
