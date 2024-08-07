<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{url('frontend/header/css/Headerstyle.css')}}">

<header class="MegaMenuHeader">
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">
            <div class="site-logo">
                <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{url('frontend/header/images/logo.png')}}" alt="logo.png">
                </a>    
            </div>
            <div class="widthSpiclSearch">
            <nav class="nav-extended white pushpin z-depth-3">
                <div class="nav-wrapper container">
                    <form action="" class="browser-default right" id="searchForm">
                        <input id="search" placeholder="Search" type="text" class="browser-default search-field" name="search" value="" autocomplete="off" aria-label="Search box">
                        <label for="search-input">
                            <i class="material-icons search-icon">search</i>
                        </label>
                        <i class="material-icons search-close-icon">cancel</i>
                            <div class="search-content content-list SearchScroll" id="ResultHolderDiv"></div>
                    </form>
                </div>
            </nav>
        </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item no-sub">
                        <a class="nav-link active" aria-current="page" href="{{url('pricing')}}"><img
                                src="{{url('frontend/header/images/nav_icon_1.png')}}" alt="nav_icon_1.png"> Pricing</a>
                    </li>
                    <li class="nav-item no-sub">
                        <a class="nav-link" href="#"><img src="{{url('frontend/header/images/nav_icon_2.png')}}"
                                alt="nav_icon_2.png">
                            competitions</a>
                    </li>
                    <li class="nav-item no-sub">
                        <a class="nav-link " href="#"><img
                                src="{{url('frontend/header/images/nav_icon_1.png')}}" alt="">
                            Teams
                        </a>

                    </li>
                    <li class="nav-item sub">
                        <a class="nav-link " href="{{url('features')}}"><img
                                src="{{url('frontend/header/images/nav_icon_1.png')}}" alt="">
                            Features
                        </a>
                    </li>

                </ul>

                <button class="btn_2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                <button class="btn_1 " data-bs-toggle="modal" data-bs-target="#joinModal">Signup</button>

				@include('frontend.includes.loginModal')
				@include('frontend.includes.joinModal')
            </div>
        </div>
    </nav>

    <section class="Features_hover second menu">
        <div class="container">
            <div class="row border-bottom">
                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-8  border-end  pe-0">
                    <h4>Choose User Type</h4>
                    <div class="featu_control_1">

                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">

                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img
                                                src="{{url('frontend/header/images/Competition Admins.png')}}" alt="">
                                        </div>
                                        <div class="fea_2">
                                            <h3>Competition Admins</h3>
                                            <p>Players may have different roles or objectives depending on the game.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/team admin.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Team Admins</h3>
                                            <p>In a game refers to the process of effectively leading.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img
                                                src="{{url('frontend/header/images/Association Admins.png')}}" alt="">
                                        </div>
                                        <div class="fea_2">
                                            <h3>Association Admins</h3>
                                            <p>Is a character or tool that is used to gather information.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img
                                                src="{{url('frontend/header/images/Competition Staff Member.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Competition Staff Member</h3>
                                            <p>Is a character or tool that is used to gather information.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img
                                                src="{{url('frontend/header/images/Competition Staff Member.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Team Staff Member</h3>
                                            <p>Is a character or tool that is used to gather information.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/Club Admins.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Club Admins</h3>
                                            <p>In a game refers to the process of effectively leading.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/scouts.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Scouts / Agents</h3>
                                            <p>Is a character or tool that is used to gather information.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>


                    </div>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4">
                    <div class="featu_control_2">

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/fans.png')}}" alt="">
                                        </div>
                                        <div class="fea_2">
                                            <h3>Fans</h3>
                                            <p>Can help to create a sense of belonging and loyalty.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/players.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Players</h3>
                                            <p>Players may have different roles or objectives depending on the game.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/media.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Media Personnel</h3>
                                            <p>Is an important part of game development and marketing.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <a href="">
                                    <div class="fea_control">
                                        <div class="fea_1"><img src="{{url('frontend/header/images/Referees.png')}}"
                                                alt=""></div>
                                        <div class="fea_2">
                                            <h3>Officials /Referees</h3>
                                            <p>Is essential in ensuring that games are played safely or fairly.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="">
                <div class="fea_control">
                    <div class="fea_1"><img src="{{url('frontend/header/images/Phone-Icon.png')}}" alt=""></div>
                    <div class="fea_2">
                        <h3>Contact Us</h3>
                        <p>Get in touch with our support team: SportVoteOfficial@gmail.com</p>
                    </div>
                </div>
            </a>

        </div>
    </section>

</header>

<!-- join modal Start-->
<div id="join_login_modal" class="modal fade" role="dialog">
    <div class="modal-dialog shadow">
        <div class="modal-content">
            <span id="join_now_heading">
                <div class="modal-header" id="modal_1" style="padding-bottom:0px;">
                    <h4>Sportvote</h4>
                </div>
                <span class="WithoutPass">See more on SportVote</span>
            </span>

            <div class="modal-body">
                <div class="container EmailSection">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="FormBG">

                                <form class="FooterForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-Clor" placeholder="Enter Email"
                                            value="" id="user_email1"
                                            style="border-bottom:1px solid;border-radius: 0; padding:10px; "
                                            autocomplete="off">

                                        <div class="input-group-btn ">
                                            <button type="submit" class="btn btn-submit-group B-Radios"
                                                id="join_now_home1" style="color:white">Join Now/ Login</button>
                                            <!-- <a class="btn btn-pink nav-link " data-bs-toggle="modal" data-bs-target="#joinModal"> Join Now</a> -->
                                        </div>

                                    </div>
                                    <div class="sv_error">
                                        <span id="user_email_home_error1"></span>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" defer async>
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" defer async></script>
<script src="{{url('frontend/js/typeahead.js')}}" defer async></script>
<!-- // JoinNow Ajax Start  -->

<script>
$(document).ready(function() {
    $(".sub").on({
        mouseenter: function(event) {
            $(".second.menu").addClass("show");
        }
    });
    $(".no-sub").on({
        mouseenter: function(event) {
            $(".second.menu").removeClass("show");
        }
    });
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
<!-- // Login Modal Ajax Start  -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<script>
$(document).on('click', '#join_now_home', function() {
    event.preventDefault();
    var uemail = $('#user_email').val();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    $("#join_login_modal").modal('hide');
    if (!(uemail.match(mailformat))) {

        // swal ( "Invalid email address" ,  "Please enter valid email!" ,  "error" )
        // $('#useremail').val("");
        $('#user_email_home_error').html('Please enter valid email');
    } else {
        $('#user_email_home_error').hide();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('check_existing_email')}}",
            type: 'POST',
            data: {
                uemail: uemail
            },
            error: function() {
                // alert('Please Sign Up First');
            },
            success: function(response) {
                if (response == 0) {
                    // swal("Email Id is not registred!", "...Please create account first!")
                    // location.href = "{{url('/')}}";
                    $("#joinModal").modal("show");
                    document.getElementById("useremail").value = document.getElementById(
                        "user_email").value;
                    var useremail = $('#useremail').val();
                    $('input[id="useremail"][data-type-text]').val(useremail).focus();

                } else {
                    $("#loginModal").modal("show");
                    document.getElementById("uemail").value = document.getElementById("user_email")
                        .value;
                    var useremail = $('#uemail').val();
                    $('input[id="uemail"][data-type-text]').val(useremail).focus();
                }

            }
        });
    }
});
</script>

<script>
$(document).on('click', '#join_now_home1', function() {
    event.preventDefault();
    var uemail = $('#user_email1').val();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (!(uemail.match(mailformat)) || uemail == "") {

        // swal ( "Invalid email address" ,  "Please enter valid email!" ,  "error" )
        // $('#useremail').val("");
        $('#user_email_home_error1').html('Please enter valid email');
    } else {
        $("#join_login_modal").modal('hide');
        $('#user_email_home_error1').hide();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('check_existing_email')}}",
            type: 'POST',
            data: {
                uemail: uemail
            },
            error: function() {
                // alert('Please Sign Up First');
            },
            success: function(response) {
                if (response == 0) {
                    // swal("Email Id is not registred!", "...Please create account first!")
                    // location.href = "{{url('/')}}";
                    $("#joinModal").modal("show");
                    document.getElementById("useremail").value = document.getElementById(
                        "user_email1").value;
                    var useremail = $('#useremail').val();
                    $('input[id="useremail"][data-type-text]').val(useremail).focus();

                } else {
                    $("#loginModal").modal("show");
                    document.getElementById("uemail").value = document.getElementById("user_email1")
                        .value;
                    var useremail = $('#uemail').val();
                    $('input[id="uemail"][data-type-text]').val(useremail).focus();
                }

            }
        });
    }
});
</script>

<script>
$(document).ready(function() {
    $("input[name='pass']").click(function() {
        var radioValue = $("input[name='pass']:checked").val();
        var uemail = $('#uemail').val();
        $('#is_password').val(radioValue);
        if (uemail == "") {
            $('#email_login_error').show();
        } else {
            $('#email_login_error').hide();
            if (radioValue == '1') {
                $('#login_popup').show();
                $('#inputpassword').show();
                $('#withoutpassword_submit').hide();
                $('#reset_pass_popup').hide();
            }
            if (radioValue == '0') {

                $('#inputpassword').hide();
                $('#withoutpassword_submit').show();
                $('#login_popup').show();
            }

        }
    });
});
</script>
<script>
$('#termsofuse1').change(function() {
    if ($(this).is(':checked')) {
        // alert('1');
        $('#termsofuse1').val('1');
    } else {
        $('#termsofuse1').val('0');
    }
});
</script>