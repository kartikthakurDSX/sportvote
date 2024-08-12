@include('frontend.includes.header')
<div>
    <style>
        .processed {
            display: none;
        }
    </style>
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
    {{-- wire:poll.750ms --}}
    <div class="Competitionn-Page-Additional">
        @livewire('competition.edit-banner', ['comp_id' => $competition->id])
        <div class="dashboard-profile">
            <div class="container-lg">
                <div class="bg-white row">
                    <div class="col-md-12 position-relative">
                        @livewire('competition.edit-logo', ['comp_id' => $competition->id])
                        <div class="w-auto user-profile-detail-Team float-start">
                            <h5 class="SocerLegSty"><span class="header_gameTeam">Soccer Competition</span>
                                @if ($competition->location)
                                    in {{ $competition->location }}
                                @else
                                    --
                                @endif
                                <br><br><strong>Created By:</strong><a
                                    href="{{ url('CompAdmin-profile/' . $competition->user_id . '/' . $competition->id) }}"
                                    target="_blank"> {{ $competition->user->first_name }}
                                    {{ $competition->user->last_name }} </a>
                            </h5>
                        </div>
                        <div class="w-auto float-end P-TB">
                            @livewire('competition.edit-info', ['competition' => $competition->id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- close div of site wrap i.e. on header page-->
<main id="main" class="Team-Public-Profil Competitionn-Page Competitionn-Page-Additional KoAdminView">
    <div class="container-fluid bg-GraySquad">
        <div class="container-lg">
            <div class="row AboutMe">
                <div class="pr-0 col-md-2 col-12 resMob">
                    <div class="boxSuad">
                        <span class="SquadCS">REPORT TYPE</span>
                        <p class="fitIn"><span class="FiveFtComp">
                                @if ($competition->report_type == 1)
                                    Basic
                                @elseif($competition->report_type == 2)
                                    Detailed
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
                <div class="p-0 col-md-2 seventyNine">
                    <div class="NAtionPLAyer">
                        <span class="SquadCS">TEAMS</span>
                        <p class="fitIn"><span class="FiveFtComp">
                                @if ($competition->team_number)
                                    {{ $competition->team_number }}
                                @else
                                    2
                                @endif
                            </span><span class="SlePer"></span></p>
                    </div>
                </div>
                <div class="p-0 col-md-2">
                    <div class="ForeginPlayer">
                        <span class="SquadCS">SQUAD PLAYERS</span>
                        <p class="fitIn"><span class="FiveFtComp">
                                @if ($competition->squad_players_num)
                                    {{ $competition->squad_players_num }}
                                @else
                                    --
                                @endif
                            </span></p>
                    </div>
                </div>
                <div class="p-0 col-md-2">
                    <div class="NAtionPLAyerTotal" style="text-align:center;">
                        <span class="SquadCS">LINEUP PLAYERS</span>
                        <p class="fitIn"><span class="FiveFtComp">
                                @if ($competition->lineup_players_num)
                                    {{ $competition->lineup_players_num }}
                                @else
                                    --
                                @endif
                            </span></p>
                    </div>
                </div>
                @livewire('competition.add-sponsor', ['competition' => $competition->id])
            </div>

        </div>
    </div>
    <div class="container-lg">
        @livewire('competition.addcompetition-news', ['competition' => $competition->id])
    </div>
    <div class="container-lg">
        <div class="row M-topSpace">
            <div class="col-md-8 col-lg-8">
                <div class="col-md-12 col-lg-12">
                    <div class="M-topSpace">
                        <div class="row">
                            @livewire('comp-team-participate', ['competition' => $competition->id])
                            @livewire('competition-teams', ['competition' => $competition->id])
                        </div>
                    </div>
                </div>

            </div>
            @livewire('competition.includes-league', ['competition' => $competition->id])
        </div>
    </div>
</main>

<input type="hidden" id="comp_id" value="{{ $competition->id }}">
<!-- The Modal Add Referee-->
<div class="modal fade" id="add_referee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Referee</h5>
            </div>
            <div class="modal-body">
                <select class="typeahead_compreferee grey-form-control" multiple="multiple" id="compreferee_ids"
                    width="100%"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="close_modal_add_referee">Close</button>
                <button type="button" class="btn btn-primary" id="send_compreferee_request">Send Request</button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Add Admin-->
<div class="modal fade" id="add_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>

            </div>
            <div class="modal-body">
                <select class="comptypeahead grey-form-control" multiple="multiple" id="compusers_ids"
                    width="100%"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="close_modal">Close</button>
                <button type="button" class="btn btn-primary" id="send_compadmin_request">Send Request</button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- contact us modal -->
<div class="modal fade" id="contact_us_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="mt-4 mb-4 row">
                        <div class=" col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="email" placeholder=" " id= "comp_email"
                                        value="{{ $competition->comp_email }}">
                                    <span class="highlight"></span>
                                    <label>Email:</label>
                                </div>
                            </div>
                            <span class="sv_error" id="comp_email_error"></span>
                        </div>
                    </div>
                    <div class="mt-4 mb-4 row">
                        <div class=" col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="number" placeholder=" "
                                        id="comp_phonenumber" value="{{ $competition->comp_phone_number }}"
                                        min="1">
                                    <span class="highlight"></span>
                                    <label>Phone number:</label>
                                </div>
                            </div>
                            <span class="sv_error" id="comp_phoneno_error"></span>
                        </div>
                    </div>
                    <div class="mt-4 mb-4 row">
                        <div class=" col-md-12 FlotingLabelUp">
                            <div class="floating-form ">
                                <div class="floating-label form-select-fancy-1">
                                    <textarea class="floating-input" type="address" placeholder=" " value="{{ $competition->comp_address }}"
                                        id="comp_address">{{ $competition->comp_address }}</textarea>
                                    <span class="highlight"></span>
                                    <label>Address:</label>
                                </div>
                            </div>
                            <span class="sv_error" id="comp_addressh_error"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="close_contact_us">Close</button>
                <button type="button" class="btn " style="background-color:#003b5f; color:#fff;"
                    id="save_comp_contact">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>

@include('frontend.includes.footer')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('frontend/js/owl.carousel.min.js') }}"></script>

<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
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
<script type="text/javascript">
    $('.responsive-tabs i.fa').click(function() {
        $(this).parent().toggleClass('open');
    });

    $('.responsive-tabs > li a').click(function() {
        $('.responsive-tabs > li').removeClass('active');
        $(this).parent().addClass('active');
        $('.responsive-tabs').toggleClass('open');
    });
</script>
<script>
    $('body').on('click', '.open_admin_popup', function(e) {
        e.preventDefault();
        $('#add_admin').modal('show');

    })
</script>
<script>
    $('body').on('click', '.open_referee_popup', function(e) {
        e.preventDefault();
        $('#add_referee').modal('show');

    })
</script>
<script>
    $('body').on('click', '#close_modal', function() {
        $('#add_admin').modal('hide');
    })
</script>
<script>
    $('body').on('click', '#close_modal_add_referee', function() {
        $('#add_referee').modal('hide');
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('.comptypeahead').select2({
        placeholder: 'Select Admin',
        ajax: {
            url: "{{ url('autosearch_user_name') }}",
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
</script>
<script type="text/javascript">
    $('.typeahead_compreferee').select2({
        placeholder: 'Select Referee',
        ajax: {
            url: "{{ url('autosearch_user_name') }}",
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
</script>
<script>
    $(document).on('click', '#send_compadmin_request', function() {
        var admins_ids = $('#compusers_ids').val();
        var comp_id = $('#comp_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('send_invitation_comp_admins') }}',
            type: 'post',
            data: {
                admins_ids: admins_ids,
                comp_id: comp_id
            },
            error: function() {

            },
            success: function(response) {
                //	$('#compusers_ids').val('ddd');
                //$('#add_admin').modal('hide');
                location.reload();
            }
        });
    })
</script>
<script>
    $(document).on('click', '#send_compreferee_request', function() {
        var admins_ids = $('#compreferee_ids').val();
        var comp_id = $('#comp_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url('send_invitation_referee_admins') }}',
            type: 'post',
            data: {
                admins_ids: admins_ids,
                comp_id: comp_id
            },
            error: function() {

            },
            success: function(response) {
                // alert('ddd');
                //console.log(response);
                $('#add_referee').modal('hide');
                location.reload();
            }
        });
    })
</script>
<script>
    $(document).on('click', '#contact_us', function() {
        $('#contact_us_modal').modal('show');
    })
</script>
<script>
    $(document).on('click', '#close_contact_us', function() {
        $('#contact_us_modal').modal('hide');
    });

    function ruleSetViewBtn(key) {
        $("#ruleSetView1" + key).hide();
        $("#ruleSetView2" + key).show();
    }

    function ruleSetViewBtns(key) {
        $("#ruleSetView2" + key).hide();
        $("#ruleSetView1" + key).show();
    }
</script>

<script>
    $(document).on('click', '#save_comp_contact', function() {
        var x = 0;
        var comp_id = $('#comp_id').val();
        var comp_email = $('#comp_email').val();
        var comp_phonenumber = $('#comp_phonenumber').val();
        var comp_address = $('#comp_address').val();
        console.log(comp_phonenumber);
        var phoneNum = comp_phonenumber.replace(/[^\d]/g, '');
        if (phoneNum != '') {
            if (phoneNum.length > 15) {
                $('#comp_phoneno_error').html("Phone number must not be greater than 15 digits.");
                x++;
            } else {
                $('#comp_phoneno_error').html('');
            }
        }
        if (comp_address != '') {
            if (comp_address.length > 250) {
                $('#comp_addressh_error').html("Address must not be greater than 250 characters.");
                x++;
            } else {
                $('#comp_addressh_error').html('');
            }
        }
        console.log(x);
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (comp_email.match(mailformat)) {
            if (x == 0) {
                $('#comp_email_error').html("");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('save_comp_contact') }}',
                    type: 'post',
                    data: {
                        comp_id: comp_id,
                        comp_email: comp_email,
                        comp_phonenumber: comp_phonenumber,
                        comp_address: comp_address
                    },
                    error: function() {
                        alert('something went wrong');
                    },
                    success: function(response) {
                        $('#contact_us_modal').modal('hide');
                    }
                });
            }
        } else {
            $('#comp_email_error').html("Enter valid email");
        }
    })
</script>

<script type="text/javascript">
    $(function() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            autoplay: 1000,
            items: 1,
            loop: true,
            onInitialized: counter, //When the plugin has initialized.
            onTranslated: counter //When the translation of the stage has finished.
        });

        function counter(event) {
            var element = event.target; // DOM element, in this example .owl-carousel
            var items = event.item.count; // Number of items
            var item = event.item.index + 1; // Position of the current item

            // it loop is true then reset counter from 1
            if (item > items) {
                item = item - items
            }
            $('#counter').html("item " + item + " of " + items)
        }
    });
</script>

<script type="text/javascript">
    let items = document.querySelectorAll('.carousel .carousel-item')

    items.forEach((el) => {
        const minPerSlide = 12
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                // wrap carousel by using first child
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })
</script>


<script type="text/javascript">
    $('.responsive-tabs i.fa').click(function() {
        $(this).parent().toggleClass('open');
    });

    $('.responsive-tabs > li a').click(function() {
        $('.responsive-tabs > li').removeClass('active');
        $(this).parent().addClass('active');
        $('.responsive-tabs').toggleClass('open');
    });
</script>

<script type="text/javascript">
    $(function() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            autoplay: 2000,
            items: 1,
            loop: true,
            onInitialized: counter, //When the plugin has initialized.
            onTranslated: counter //When the translation of the stage has finished.
        });

        function counter(event) {
            var element = event.target; // DOM element, in this example .owl-carousel
            var items = event.item.count; // Number of items
            var item = event.item.index + 1; // Position of the current item

            // it loop is true then reset counter from 1
            if (item > items) {
                item = item - items
            }
            $('#counter').html("item " + item + " of " + items)
        }
    });
</script>
@include('frontend.includes.searchScript')
