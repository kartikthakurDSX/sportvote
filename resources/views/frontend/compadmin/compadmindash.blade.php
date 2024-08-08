@include('frontend.includes.header')
<div class="header-bottom dashboard">
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <div class="float-end">
                    <button class="btn " type="button"><i class="icon-cog fs1"></i></button>
                    <button class="btn btn-outline ms-auto br-5" type="button"><i class="green-text icon-edit"></i> Edit
                        profile </button>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="dashboard-profile">
    <div class="container-lg">
        <div class="bg-white row">
            <div class="col-sm-12 position-relative">
                <a href="" class="user-profile-img"><img src="frontend/images/person_5.jpg" class="img-fluid"
                        alt="profle-image"></a>
                <div class="w-auto user-profile-detail float-start">
                    <h1><strong>{{ Auth::user()->first_name }}</strong> {{ Auth::user()->last_name }}</h1>
                    <p><span><i class="icon-map-marker"></i> {{ Auth::user()->location }} </span> <span><i
                                class="icon-calendar"></i> Joined in {{ Auth::user()->created_at }}</span></p>
                </div>
                <div class="w-auto float-end">
                    <h1 class="social-count"><span>132 <small>friends</small></span><span class="wl-1">/</span>
                        <span>222 <small>Followers</small><span></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<main id="main" class="dashboard-wrap">
    <div class="container-lg">
        <div class="my-1 row">
            <div class="my-1 col-md-4 ">
                <div class="bg-green br-10 create-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="text-bolder"><small>Create</small>Player Profile</h3>
                            <p>Profile for the sport you play to</p>
                            <ul class="list-unstyled">
                                <li><a href="">- Join Teams</a></li>
                                <li><a href="">- Showcase Career</a></li>
                                <li><a href="">- Get Recognition</a></li>

                            </ul>
                        </div>
                        <div class="col-sm-4 ">
                            <button class="text-white btn float-end fs1 close btn-sm">&times;</button>
                            <img src="frontend/images/player_w.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-1 col-md-4">
                <div class="bg-pink br-10 create-box">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="text-bolder"><small>Create</small>Sports Team</h3>
                            <p>Profile for the sport you play to</p>
                            <ul class="list-unstyled">
                                <li><a href="">- Join Teams</a></li>
                                <li><a href="">- Showcase Career</a></li>
                                <li><a href="">- Get Recognition</a></li>

                            </ul>
                        </div>
                        <div class="col-4 ">
                            <button class="text-white btn float-end fs1 close btn-sm">&times;</button>
                            <img src="frontend/images/noun_team_w.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-1 col-md-4">
                <div class="bg-blue br-10 create-box">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="text-bolder"><small>Create</small>Competition </h3>
                            <p>Profile for the sport you play to</p>
                            <ul class="list-unstyled">
                                <li><a href="">- Join Teams</a></li>
                                <li><a href="">- Showcase Career</a></li>
                                <li><a href="">- Get Recognition</a></li>
                            </ul>
                        </div>
                        <div class="col-4 ">
                            <button class="text-white btn float-end fs1 close btn-sm circle">&times;</button>
                            <img src="frontend/images/noun_fans_w.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="px-3 py-3 my-3 box-outer-lightpink">
                    <h2><strong>Compitions,</strong> I follow <i class="icon-angle-down"></i> <button
                            class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h2>
                    <ul class="comp-follow-slider owl-carousel">
                        <li><img src="frontend/images/logo1.png">
                            <h5>Confederation of Africon Football</h5>
                        </li>
                        <li><img src="frontend/images/1200px-Premier_Soccer_League_logo.png">
                            <h5>south african premier division</h5>
                        </li>
                        <li><img src="frontend/images/1200px-Nigerian_Professional_Football_League_Logo.svg-NPFL.png">
                            <h5>Nigerian Professional Football League</h5>
                        </li>
                        <li><img src="frontend/images/logo1.png">
                            <h5>Confederation of Africon Football</h5>
                        </li>
                        <li><img src="frontend/images/1200px-Premier_Soccer_League_logo.png">
                            <h5>south african premier division</h5>
                        </li>
                        <li><img src="frontend/images/1200px-Nigerian_Professional_Football_League_Logo.svg-NPFL.png">
                            <h5>Nigerian Professional Football League</h5>
                        </li>
                        <li><img src="frontend/images/logo1.png">
                            <h5>Confederation of Africon Football</h5>
                        </li>
                        <li><img src="frontend/images/1200px-Premier_Soccer_League_logo.png">
                            <h5>south african premier division</h5>
                        </li>
                        <li><img src="frontend/images/logo1.png">
                            <h5>Confederation of Africon Football</h5>
                        </li>
                        <li><img src="frontend/images/1200px-Premier_Soccer_League_logo.png">
                            <h5>south african premier division</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="my-2 row request-status">
            <div class="col-md-6">
                <h1>Requests Status <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
                <div class="box-outer-lightpink">
                    <table class="table ">
                        <thead class="">
                            <tr>
                                <th>Request For</th>
                                <th>Request By</th>
                                <th>Action / Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Join Team
                                </td>
                                <td>
                                    Me: Toto Farriya (12 Dec 2021)
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-xs-nb">RFTRFAT</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Friend
                                </td>
                                <td>
                                    John Smith (3 Dec 2021)
                                </td>
                                <td>
                                    <button class="btn btn-green btn-xs-nb">Accept</button>
                                    <button class="btn btn-danger btn-xs-nb">Reject</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Join Team
                                </td>
                                <td>
                                    Me: Toto Farriya (12 Dec 2021)
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-xs-nb">RFTRFAT</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Join as Admin
                                </td>
                                <td>
                                    Me: Jamamia Afrin (15 Dec 2021)
                                </td>
                                <td>
                                    <img src="frontend/images/accept-icon.png" alt="icon"> Accepted
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation" class="dots-paging">
                        <ul class="pagination">

                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link active-dot" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-md-6">

                <h1>Votes &amp; Interactions <button class="btn fs1 float-end"><i
                            class="icon-more_horiz"></i></button></h1>
                <div class="p-2 box-outer-lightpink w-100 ">
                    <div class="row w-100 circle">

                        <div class="col-md-4 position-relative col-sm-6 col-xs-12">
                            <div class="demo1" data-percent="80"></div>
                            <div class="circle-process-wrap">

                                <img src="frontend/images/54299.png">
                                <i class="icon-check icon-process-chart"></i>
                            </div>
                            <div class="detail-process">
                                <h5><img src="frontend/images/icon.png">Timmy Jones<h5>
                                        <p class="blue-text">5 Goals for imperial Tree</p>
                                        <p class="italic grey-text">Vs Manchester United</p>
                                        <p class="grey-text">on 13 Sep 21 in <span class="blue-text">London</span></p>
                            </div>
                        </div>
                        <div class="col-md-4 position-relative col-sm-6 col-xs-12">
                            <div class="demo2" data-percent="50"></div>
                            <div class="circle-process-wrap">

                                <img src="images/54299.png">
                                <i class="icon-hourglass-half icon-process-chart"></i>
                            </div>
                            <div class="detail-process">
                                <h5><img src="frontend/images/icon.png">Timmy Jones<h5>
                                        <p class="blue-text">5 Goals for imperial Tree</p>
                                        <p class="italic grey-text">Vs Manchester United</p>
                                        <p class="grey-text">on 13 Sep 21 in <span class="blue-text">London</span></p>
                            </div>
                        </div>

                        <div class="col-md-4 position-relative col-sm-6 col-xs-12">
                            <div class="demo3" data-percent="30"></div>
                            <div class="circle-process-wrap">

                                <img src="frontend/images/54299.png">
                                <i class="icon-close icon-process-chart"></i>
                            </div>
                            <div class="detail-process">
                                <h5><img src="frontend/images/icon.png">Timmy Jones<h5>
                                        <p class="blue-text">5 Goals for imperial Tree</p>
                                        <p class="italic grey-text">Vs Manchester United</p>
                                        <p class="grey-text">on 13 Sep 21 in <span class="blue-text">London</span></p>
                            </div>
                        </div>



                    </div>
                    <nav aria-label="Page navigation" class="dots-paging">
                        <ul class="pagination">

                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link active-dot" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                            <li class="page-item"><a class="page-link" href="#"></a></li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span>Nigerian Premier League <button
                        class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
                <div class="py-4 box-outer-lightpink row ">
                    <div class="col-md-4 teams-box bl-n">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>

                    <div class="col-md-4 teams-box">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box bl-n">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box bl-n">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box bb-n bl-n">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box bb-n">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>
                    <div class="col-md-4 teams-box bb-n">
                        <p class="win"><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Abia Warriors
                            <span class="score">1</span></p>
                        <p><img class="icon-thumb" src="frontend/images/kanno-icon.png"> Kwara United <span
                                class="score">1</span></p>
                    </div>


                </div>
            </div>
            <div class="col-md-4">
                <h1>Top Performers <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1>
                <div class="top-performer-box w-100 d-flex">
                    <div class="pt-2 performer-goal green-bg-a position-relative col-md-3 pe-4">
                        <h2>15<span>Goals</span></h2>
                        <a href="#" class="ic-logo"><img src="frontend/images/kanno-icon.png"></a>
                    </div>
                    <div class="py-2 performer-detail green-bg col-md-5">
                        <div class="content-pos">
                            <h5><a href="#">Samon Knight</a></h5>
                            <ul class="list-unstyled">
                                <li>22 Games Played</li>
                                <li>23 Games Started</li>
                                <li>12 Assist</li>
                                <li>3 Foul</li>
                                <li>2 Yellow Cards</li>
                                <li>0 Red Card</li>
                            </ul>
                        </div>
                    </div>
                    <div class="performer-player-img green-bg-a position-relative col-md-4 ">
                        <div class="overflow-hidden w-100 br-right-0"><img src="frontend/images/freddie.png"
                                alt="player" class=""></div>
                    </div>
                </div>
                <div class="top-performer-box w-100 d-flex">
                    <div class="pt-2 performer-goal lb-bg-a position-relative col-md-3 pe-4">
                        <h2>15<span>Goals</span></h2>
                        <a href="#" class="ic-logo"><img src="frontend/images/kanno-icon.png"></a>
                    </div>
                    <div class="py-2 performer-detail lb-bg col-md-5">
                        <div class="content-pos">
                            <h5><a href="#">Samon Knight</a></h5>
                            <ul class="list-unstyled">
                                <li>22 Games Played</li>
                                <li>23 Games Started</li>
                                <li>12 Assist</li>
                                <li>3 Foul</li>
                                <li>2 Yellow Cards</li>
                                <li>0 Red Card</li>
                            </ul>
                        </div>
                    </div>
                    <div class="performer-player-img lb-bg-a position-relative col-md-4 ">
                        <div class="overflow-hidden w-100 br-right-0"><img src="frontend/images/freddie.png"
                                alt="player" class=""></div>
                    </div>
                </div>
                <div class="top-performer-box w-100 d-flex">
                    <div class="pt-2 performer-goal red-bg-a position-relative col-md-3 pe-4">
                        <h2>15<span>Goals</span></h2>
                        <a href="#" class="ic-logo"><img src="frontend/images/kanno-icon.png"></a>
                    </div>
                    <div class="py-2 performer-detail red-bg col-md-5">
                        <div class="content-pos">
                            <h5><a href="#">Samon Knight</a></h5>
                            <ul class="list-unstyled">
                                <li>22 Games Played</li>
                                <li>23 Games Started</li>
                                <li>12 Assist</li>
                                <li>3 Foul</li>
                                <li>2 Yellow Cards</li>
                                <li>0 Red Card</li>
                            </ul>
                        </div>
                    </div>
                    <div class="performer-player-img red-bg-a position-relative col-md-4 ">
                        <div class="overflow-hidden w-100 br-right-0"><img src="frontend/images/freddie.png"
                                alt="player" class=""></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<footer class="footer-section">
    <div class="container-lg">
        <div class="row">

            <div class="col-lg-2 col-md-6 footer-links">
                <h4>Host Your Sport</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Soccer</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Cricket</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Hockey</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Basketball</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Rugby</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Volleyball</a></li>
                    <hr>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Suggest a Sport</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
                <h4>Manage</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Your Sports Profile</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Your Team</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">The Competitions</a></li>
                </ul>
                <br>
                <h4>Find</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">The right team</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">The Prime Players</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
                <h4>About us</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Our Story</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">The Team</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Why Sports</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Partnerships</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Our Support</a></li>
                    <hr>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Our Investors</a></li>
                </ul>
            </div>

            <div class="col-lg-6 col-md-6 widgets">
                <div>
                    <form>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email or Phone Number"
                                name="email">
                            <div class="input-group-btn ">
                                <button class="btn btn-submit-group" type="submit">Join Now</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="social-chat">
                    <span class="letschat">Lets Chat: <a href="" alt=""
                            title="letschat">hi@sportvote.org</a> </span>
                    <ul class="social_icons">
                        <li>Follow Us:</li>
                        <li><a href="#" title="facebook"><i class="icons icon-fb"></i></a></li>
                        <li><a href="#" title="twitter"><i class="icons icon-tw"></i></a></li>
                        <li><a href="#" title="linkedin"><i class="icons icon-li"></i></a></li>
                        <li><a href="#" title="Instagram"><i class="icons icon-insta"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="text-center col-lg-12 copyright">
                Copyright 2021. All rights for Sportvote logo, marketing content & marketing graphics are reserved to
                Sportvote Inc.
            </div>
        </div>
    </div>

</footer>
<script src="frontend/js/jquery-3.3.1.min.js"></script>
<script src="frontend/js/jquery-migrate-3.0.1.min.js"></script>
<script src="frontend/js/jquery-ui.js"></script>
<script src="frontend/js/popper.min.js"></script>
<script src="frontend/js/bootstrap.min.js"></script>

<script src="frontend/js/jquery.easing.1.3.js"></script>
<script src="frontend/js/aos.js"></script>
<script src="frontend/js/script.js"></script>

<script src="frontend/js/owl.carousel.min.js"></script>
<script src="frontend/js/main.js"></script>
<script type="frontend/text/javascript" src="assets/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example-getting-started').multiselect({

            buttonWidth: '100%'
        });
        $('#fvt_team').multiselect({

            buttonWidth: '100%'
        });
        $('#select_competition').multiselect({

            buttonWidth: '100%'
        });
    });
</script>
<script type="text/javascript">
    // add row
    $(".addRow").click(function() {
        var html = '';
        html += '<div class="mb-3 row user_data">';
        html +=
            '<div class="mb-3 col-md-12"><label class="" for="search_sport">SEARCH based on SPORTs in PROFILE</label><input type="text" class="grey-form-control input-sm" id="search_sport" name="search_sport"></div><div class="col-md-12"><label class="" for="join_reason">Reason why you want to join</label><textarea rows="2" maxlength="200" class="grey-form-textarea input-sm" placeholder="Enter here..."  id="join_reason" name="join_reason"></textarea></div>';

        html +=
            '<div class="col-md-12"><button  type="button" class="removeRow float-start btn btn-danger ">&times;</button></div>';
        html += '</div>';

        $('.newRow').append(html);
    });

    // remove row
    $(document).on('click', '.removeRow', function() {
        $(this).closest('.user_data').remove();
    });
</script>
<script type="text/javascript" src="js/circliful.js"></script>
<script>
    var circle1 = circliful.newCircle({
        percent: 80,
        id: 'circle1',
        type: 'simple',
        icon: 'f179',
        text: 'TP Wins',
        noPercentageSign: true,
        backgroundCircleWidth: 12,
        foregroundCircleWidth: 20,
        progressColors: [{
                percent: 1,
                color: 'red'
            },
            {
                percent: 30,
                color: 'orange'
            },
            {
                percent: 60,
                color: 'green'
            }
        ]
    });

    setTimeout(() => {
    circle1.update([{
            type: 'percent',
            value: 95
        },
        {
            type: 'text',
            value: 'TP has won'
        },
    ]);
    }, 3000);
    })();
</script>
<script src="js/jquery.circlechart.js"></script>
<script type="text/javascript">
    $('.demo1').percentcircle({

        animate: true,
        diameter: 160,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#0e9247',
        percentSize: '15px',
        percentWeight: 'normal'

    });
    $('.demo2').percentcircle({

        animate: true,
        diameter: 160,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#025e99',
        percentSize: '15px',
        percentWeight: 'normal'

    });

    $('.demo3').percentcircle({

        animate: true,
        diameter: 160,
        guage: 2,
        coverBg: '#fff',
        bgColor: '#efefef',
        fillColor: '#FF2052',
        percentSize: '15px',
        percentWeight: 'normal'

    });
</script>
</body>

</html>
