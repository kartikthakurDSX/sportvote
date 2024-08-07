<div class="col-md-4">

    {{-- wire:poll.750ms --}}
    <style>
        .read-more-target,
        .read-more-trigger_opened {
            display: none;
        }

        .read-more-state:checked~.read-more-wrap .read-more-target,
        .read-more-state:checked~.read-more-wrap .read-more-trigger_opened {
            display: block;
        }

        .read-more-state:checked~.read-more-wrap .read-less-target,
        .read-more-state:checked~.read-more-trigger_closed {
            display: none;
        }

        .ruleSetView .ruleFloatRight {
            float: right;
            color: #065596;
        }
    </style>
    <!-- <h1>Top Performers <button class="btn fs1 float-end"><i class="icon-more_horiz"></i></button></h1> -->
    <div class="box-outer-lightpink SocialList AboutSocalSec">
        {{-- @livewire('competition.edit-about-us', ['competition' => $competition->id]) --}}

        {{-- for competition.edit-about-us --}}


        @if (Auth::check())
            <button class="processed" wire:click="refresh">Refresh</button>
            <div class="">
                <span><img src="{{ asset('frontend/images') }}/aboutStar-icon.png"></span> <span class="AboutStyleUs">
                    ABOUT US</span>
                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                    <a wire:click="edit_comp_desc" style="cursor:pointer;"><span class="Edit-Icon"> </span></a>
                @else
                @endif
                <div class="about_us_height">
                    <div class="TextSocalInner">
                        @if ($competition->description)
                            {!! $competition->description !!}
                        @else
                            --
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editdescModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Description</h5>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="mt-4 mb-4 row">
                                    <div wire:ignore>
                                        <livewire:trix :value="$body">
                                    </div>
                                    @if ($is_save == 0)
                                        <span class="sv_error"> {{ $msg }} </span>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if ($is_save == 1)
                                <button type="button" class="btn " style="background-color:#003b5f; color:#fff;"
                                    wire:click="save">Save </button>
                            @else
                                <span type="button" class="btn" style="background-color:#c7e2f3; color:#fff;"> Save
                                </span>
                            @endif

                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                wire:click="closemodal">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="">
                <span><img src="{{ asset('frontend/images') }}/aboutStar-icon.png"></span> <span class="AboutStyleUs">
                    ABOUT US</span>
                <div class="about_us_height">
                    <div class="TextSocalInner">
                        @if ($competition->description)
                            {!! $competition->description !!}
                        @else
                            --
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <script>
            window.addEventListener('OpendescModal', event => {
                $('#editdescModal').modal('show')
            })
        </script>
        <script>
            window.addEventListener('ClosedescModal', event => {
                $('#editdescModal').modal('hide')
            })
        </script>
        <hr />
        <div class="">
            @if (Auth::check())
                <span><img src="{{ url('frontend/images/COMPETITION-RULE-SET.png') }}"></span> <span
                    class="AboutStyleUs">Competition Rule Set</span>
                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                    @if (!empty($comp_rules))
                        <a data-bs-toggle="modal" data-bs-target="#addcomprules" style="cursor:pointer;"><span
                                class="Edit-Icon"></span></a>
                    @else
                        <a data-bs-toggle="modal" data-bs-target="#addcomprules" wire:click="openaddcomprules"
                            style="cursor:pointer;"><span class="fa-plus"> </span></a>
                    @endif
                @else
                @endif
                <div class="box-outer-lightpink AboutSocalSec compRuleSetDisplay" id="wrapper" wire:ignore>
                    <div class=" socialHeight ruleSetView" id="style-1">
                        @if (count($comp_rules) != 0)
                            <div class="block-item-text">
                                <input type="checkbox" hidden class="read-more-state" id="read-more">
                                <div class="read-more-wrap">
                                    @if (strlen($comp_rules_paragraph) > 150)
                                        <p class="read-less-target">
                                            @php echo substr($comp_rules_paragraph, 0, 150); @endphp
                                            <label for="read-more" class="read-more-trigger_closed ruleFloatRight">Read
                                                More</label>
                                        </p>
                                        <p class="read-more-target">
                                            {!! $comp_rules_paragraph !!}
                                            <label for="read-more" class="read-more-trigger_opened ruleFloatRight">Read
                                                Less</label>
                                        </p>
                                    @else
                                        <p class="">
                                            {!! $comp_rules_paragraph !!}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="SocalMatchImg">
                                No Data found
                            </div>
                        @endif
                    </div>
                    <!-- <div class="block-item-text">
            <input type="checkbox" hidden class="read-more-state" id="read-more">
            <div class="read-more-wrap">
                <p>
                Build better Joomla website with essential Joomla components. We recommend useful components to make editing easier, website faster and SEO-friendly and always backed up.<br>
                <i>Note:</i> Installation of the template is not included into this service.
                </p>
                <p class="read-more-target">
                    1) Advanced content editor (similar to Word).<br>
                    2) Preview of the article before publishing.<br>
                    3) Backup component. – Quick search for backend.<br>
                    4) Plugin which helps to clean and resolve front and back end issues when using instances of jQuery.<br>
                    5) CSS, Javascript and Image Compression to increase speed of the website.<br>
                    6) SEO plugin which automatically generates description meta tags by pulling text from the content to help with SEO.
                </p>
            </div>
            <label for="read-more" class="read-more-trigger_closed">Read More</label>
            <label for="read-more" class="read-more-trigger_opened">Read Less</label>
        </div> -->
                </div>
                <div class="modal fade" id="addcomprules" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-lg comp_add_rule_model">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title addRule_modelTitle" id="exampleModalLabel">Add a rule for your
                                    team admins, players, and referees.</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="app">
                                    <div class="pt-1 wrapper">
                                        <div class="input-box"><br>
                                            <div class="mb-3 row">
                                                <div class=" col-md-12 FlotingLabelUp">
                                                    <div class="floating-form ">
                                                        <div class="floating-label ">
                                                            <textarea class="floating-input floating-textarea form-control Competiton grey-form-control" cols="30"
                                                                rows="5" wire:model="rule_desc"></textarea>
                                                            <span class="highlight"></span>
                                                            <label class="TeamDescrForm">Add a rule for your team
                                                                admins, players, and referees.</label>
                                                        </div>
                                                    </div>
                                                    @error('rule_desc')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="bottom">
                                                <div class="content">
                                                    <button class="active" wire:click="add_rule">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="PostDetail rule-set">
                                        <div class="infoContainer">
                                            <div class="nameContainer">
                                                Competition Rule Set
                                            </div>
                                            <div class="message word-wrap">
                                                @if ($comp_rules)
                                                    <ol>
                                                        @foreach ($comp_rules as $rule)
                                                            <li>{{ $rule->description }} <a class="btn"
                                                                    onclick="return confirm('Are you sure you want to delete this?') || event.stopImmediatePropagation()"
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <span></span> <span class="AboutStyleUs">Competition Rule Set</span>
                <div class="box-outer-lightpink AboutSocalSec " id="wrapper">
                    <div class=" socialHeight" id="style-1">
                        @if (count($comp_rules) != 0)
                            <div class="row word-wrap">
                                <ol class="list-group list-group-numbered">
                                    @if ($comp_rules)
                                        @foreach ($comp_rules as $rule)
                                            <li class="">{{ $rule->description }}</li>
                                        @endforeach
                                    @endif
                                </ol>
                            </div>
                        @else
                            <div class="SocalMatchImg">
                                No Data found
                            </div>
                        @endif
                    </div>
                </div>
            @endif



            {{-- for competition.edit-about-us ending --}}
            <hr>
            <div class=""><span><img src="{{ url('frontend/images/Contact-us.png') }}"></span> <span
                    class="AboutStyleUs"> contact US</span>
                @if (Auth::check())
                    @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                        <span> <a style="cursor:pointer;" id="contact_us"><span class="fa-plus"> </span></a> </span>
                    @else
                    @endif
                @else
                @endif

                {{-- @livewire('competition.comp-contact-us', ['comp_id' => $competition->id]) --}}
                {{-- for competition.comp-contact-us --}}
                <span>
                    @if ($competition->comp_email)
                        <p class="TextSocalInner"><b>Email:</b> {{ $competition->comp_email }} </p>
                    @else
                        <p class="TextSocalInner DefaultClorText"> <b>Email:</b> default@domain.com </p>
                    @endif
                    @if ($competition->comp_phone_number)
                        <p class="TextSocalInner"><b>Mobile:</b> {{ $competition->comp_phone_number }} </p>
                    @else
                        <p class="TextSocalInner DefaultClorText"> <b>Mobile:</b> 76XX1XXX78 </p>
                    @endif
                    @if ($competition->comp_address)
                        <p class="TextSocalInner "><b>Address:</b> {{ $competition->comp_address }} </p>
                    @else
                        <p class="TextSocalInner DefaultClorText"> <b>Address:</b> Plot No. XXX Near abc office,
                            Country. </p>
                    @endif
                </span>
                {{-- for competition.comp-contact-us ending --}}

            </div>
            <hr>
            <div class="">
                <div>
                    <span><img src="{{ asset('frontend/images') }}/AdminStar-icon.png"></span> <span
                        class="AboutStyleUs">
                        ADMINISTRATION</span>
                    @if (Auth::check())
                        @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                            <span> <a style="cursor:pointer;" class="open_admin_popup"><span class="fa-plus">
                                    </span></a>
                            </span>
                        @else
                        @endif
                    @else
                    @endif

                    {{-- @livewire('competition-adminstration', ['competition' => $competition]) --}}

                    {{-- for competition-adminstration --}}
                    <span>
                        @if (Auth::check())
                            @if (!empty($competition_member))
                                @foreach ($competition_member as $comp_mem)
                                    <div class="D-FSpacng">
                                        {{-- {{ asset('frontend/profile_pic') }}/{{ $comp_mem->member->profile_pic }} --}}
                                        <div class="AdmIcon">
                                            <img src="{{ asset('frontend/profile_pic') }}/{{ $comp_mem->member->profile_pic }}"
                                                width="100%" alt="">
                                        </div>
                                        <span class="SergiTeam"> {{ $comp_mem->member->first_name }}
                                            {{ $comp_mem->member->last_name }} <span class="SpanishTeam">
                                                {{ $comp_mem->member_position->name }} </span>
                                            @if ($comp_mem->invitation_status == 0)
                                                [ Pending ]
                                                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                                    <a class="btn btn-crossSocial"
                                                        wire:click ="cancel_request({{ $comp_mem->id }})"
                                                        style="cursor:pointer;">×</a>
                                                @else
                                                @endif
                                            @else
                                                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                                    @if ($comp_mem->invitation_status == 1 && $comp_mem->member->id != Auth::user()->id)
                                                        @if ($comp_mem->is_active == 1)
                                                            <a class="btn btn-crossSocial crossSocial_a"
                                                                wire:click ="inactive_refree({{ $comp_mem->id }})"
                                                                style="cursor:pointer;"><i
                                                                    class="fas fa-toggle-on"></i></a>
                                                        @else
                                                            @if ($comp_mem->is_active == 3)
                                                                <a class="btn btn-crossSocial crossSocial_a"
                                                                    wire:click ="active_refree({{ $comp_mem->id }})"
                                                                    style="cursor:pointer;"><i
                                                                        class="fas fa-toggle-off"></i></a>
                                                            @endif
                                                        @endif
                                                    @else
                                                    @endif
                                                @else
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                                {{ $competition_member->links('cpag.custom') }}
                            @else
                                <div class="D-FSpacng">
                                    NA
                                </div>
                            @endif
                        @else
                            @foreach ($competition_member as $comp_mem)
                                @if ($comp_mem->invitation_status == 1)
                                    <div class="D-FSpacng">
                                        <div class="AdmIcon">
                                            <img src="{{ asset('frontend/profile_pic') }}/{{ $comp_mem->member->profile_pic }}"
                                                width="100%" alt="">
                                        </div>
                                        <span class="SergiTeam"> {{ $comp_mem->member->first_name }}
                                            {{ $comp_mem->member->last_name }} <span class="SpanishTeam">
                                                {{ $comp_mem->member_position->name }} </span>
                                        </span>

                                    </div>
                                @else
                                @endif
                            @endforeach
                            {{ $competition_member->links('cpag.custom') }}
                        @endif
                    </span>
                    {{-- for competition-adminstration ending --}}
                </div>
            </div>
            <hr>
            <div class="">
                <span><img src="{{ url('frontend/images/Desi-Refree-icon.png') }}"></span> <span
                    class="AboutStyleUs">
                    DESIGNATED REFEREES</span>
                @if (Auth::check())
                    @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                        <a style="cursor:pointer;" class="open_referee_popup"><span class="fa-plus"> </span></a>
                    @else
                    @endif
                @else
                @endif
                {{-- @livewire('competition.add-comp-referee', ['competition' => $competition]) --}}

                {{-- for competition.add-comp-referee --}}
                <span>
                    @if (Auth::check())
                        @if (!empty($comp_referee))
                            @foreach ($comp_referee as $comp_mem)
                                <div class="D-FSpacng">
                                    <div class="AdmIcon"><img
                                            src="{{ asset('frontend/profile_pic') }}/{{ $comp_mem->member->profile_pic }}"
                                            width="100%" alt=""> </div>
                                    <span class="SergiTeam"> {{ $comp_mem->member->first_name }}
                                        {{ $comp_mem->member->last_name }} <span class="SpanishTeam">
                                            {{ $comp_mem->member_position->name }} </span>
                                        @if ($comp_mem->invitation_status == 0)
                                            [ Pending ]
                                            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                                <a class="btn btn-crossSocial"
                                                    wire:click ="cancel_request({{ $comp_mem->id }})"
                                                    style="cursor:pointer;">×</a>
                                            @else
                                            @endif
                                        @else
                                            @if ($comp_mem->member->id == Auth::user()->id)
                                            @else
                                                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                                                    @if ($comp_mem->invitation_status == 1 && count($comp_activeRefree) > 1)
                                                        @if ($comp_mem->is_active == 1)
                                                            <a class="btn btn-crossSocial crossSocial_a"
                                                                wire:click ="inactive_refree({{ $comp_mem->id }})"
                                                                style="cursor:pointer;"><i
                                                                    class="fas fa-toggle-on"></i></a>
                                                        @else
                                                            @if ($comp_mem->is_active == 3)
                                                                <a class="btn btn-crossSocial crossSocial_a"
                                                                    wire:click ="active_refree({{ $comp_mem->id }})"
                                                                    style="cursor:pointer;"><i
                                                                        class="fas fa-toggle-off"></i></a>
                                                            @endif
                                                        @endif
                                                    @else
                                                    @endif
                                                @else
                                                @endif
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                            {{ $comp_referee->links('cpag.custom') }}
                        @else
                            <div class="D-FSpacng">
                                NA
                            </div>
                        @endif
                    @else
                        @foreach ($comp_referee as $comp_mem)
                            @if ($comp_mem->invitation_status == 1)
                                <div class="D-FSpacng">
                                    <div class="AdmIcon"><img
                                            src="{{ asset('frontend/profile_pic') }}/{{ $comp_mem->member->profile_pic }}"
                                            width="100%" alt=""> </div>
                                    <span class="SergiTeam"> {{ $comp_mem->member->first_name }}
                                        {{ $comp_mem->member->last_name }} <span class="SpanishTeam">
                                            {{ $comp_mem->member_position->name }} </span>
                                    </span>

                                </div>
                            @else
                            @endif
                        @endforeach
                        {{ $comp_referee->links('cpag.custom') }}
                    @endif
                </span>

                {{-- for competition.add-comp-referee ending --}}
            </div>
            <hr>
            {{-- @livewire('competition.addcommunity-sponsor', ['competition' => $competition->id, 'SponsorHeading' => 'LEAGUE SPONSORS']) --}}

            {{-- for competition.addcommunity-sponsor --}}
            <div class="">
                @if (Auth::check())
                    <span><img src="{{ url('frontend/images/hrt-icon.png') }}"></span>
                    <span class="AboutStyleUs"> {{ 'Community Sponsors' }} </span>
                    @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                        @if (count($comp_sponsers) != 0)
                            <a class="btn-icon" wire:click="open_edit_sponsor" style="cursor:pointer;"><span
                                    class="Edit-Icon"> </span></a>
                        @else
                            <a wire:click="open_addcommunity_sponsor" style="cursor:pointer;"><span class="fa-plus">
                                </span></a>
                        @endif
                    @else
                    @endif
                    <div class="owlSPONSORS owl-carousel owl-theme CommunitySPONSORS owl-loaded">
                        @if ($comp_sponsers->isNotEmpty())
                            @foreach ($comp_sponsers as $comp_spo)
                                <?php
                                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                                    $url = 'https://';
                                } else {
                                    $url = 'http://';
                                }
                                // Append the host(domain name, ip) to the URL.
                                $url .= $_SERVER['HTTP_HOST'];
                                $sponserimage[] = $url . '/storage/app/public/image/' . $comp_spo->sponsor_image;
                                ?>
                            @endforeach
                            <?php $community_sponsors = array_chunk($sponserimage, 6); ?>
                            @foreach ($community_sponsors as $comp_spons)
                                <div class="item">
                                    <div class="CommunitySponsors logosCommunuty">
                                        <div class="width-Logo100">
                                            <div class="mt-1 row">
                                                @foreach ($comp_spons as $images)
                                                    <div class="text-center w-33 VerticalCenter ">
                                                        <div class="p-1 LogoHeight70 ">
                                                            <img src="{{ $images }}"
                                                                class="img-fluid img-fludeLogo "
                                                                alt="Community Sponsors">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p> No Data Found </p>
                        @endif
                    </div>



                    <div class="modal fade" id="addcommunitySponsor" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog" role="document">
                            <form wire:submit.prevent="add_communitysponsor_info" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Community Sponsor</h5>
                                    </div>
                                    <div class="modal-body"><br>
                                        <div class="container">
                                            <div class="row">
                                                <div class="mb-4 col-md-12 FlotingLabelUp">
                                                    <div class="floating-form ">
                                                        <div class="floating-label form-select-fancy-1">
                                                            <input class="floating-input" type="file"
                                                                id="image" placeholder=" "
                                                                wire:model="sponsor_image" multiple>
                                                            <div wire:loading wire:target="sponsor_image" wire.ignore>
                                                                Uploading...</div>
                                                            <span class="highlight"></span>
                                                            <label>Select Sponsor Image</label>
                                                        </div>
                                                        @error('sponsor_image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @error('sponsor_image.*')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($sponsor_image)
                                                Photo Preview:
                                                <div class="row">
                                                    @foreach ($sponsor_image as $images)
                                                        <div class="mb-1 col-3 card me-1">
                                                            <img src="{{ $images->temporaryUrl() }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        @if ($sponsor_image)
                                            <button type="submit" class="btn "
                                                style="background-color:#003b5f; color:#fff;">Save</button>
                                            <div wire:loading wire:target="save" wire:ignore>process...</div>
                                        @else
                                        @endif
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            wire:click="close_addcommunity_sponsor">Close</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="editcommunitysponsor" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Community Sponsors</h5>
                                    <a class="modal-title" style="cursor:pointer;"
                                        wire:click="open_addcommunity_sponsor">ADD</a>
                                </div>
                                <div class="modal-body offical_community_images">
                                    <div class="">
                                        <div class="row">
                                            <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                                                <div class="floating-form ">
                                                    <div class="floating-label form-select-fancy-1">
                                                        <table>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Sponsor Image</th>
                                                                <th colspan="2">Action</th>
                                                            </tr>
                                                            @foreach ($comp_sponsers as $comp_sponser)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>
                                                                        <img src="<?php echo $url . '/storage/app/public/image/' . $comp_sponser->sponsor_image; ?>" width="100px"
                                                                            class="mt-1 img-fluid">
                                                                    </td>
                                                                    <td>
                                                                        <a style="cursor:pointer;"
                                                                            wire:click="deletecommunity_sponsor({{ $comp_sponser->id }})"
                                                                            onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i
                                                                                class="icon-trash "></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" style="cursor:pointer;"
                                        data-dismiss="modal" wire:click="close_edit_sponsor">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editcommunitysponsorModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog" role="document">
                            <form wire:submit.prevent="editcommunity_sponsor" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Community Sponsor </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">

                                            <div class="row">
                                                <div class="mb-4 col-md-12 FlotingLabelUp">
                                                    <div class="floating-form ">
                                                        <div class="floating-label form-select-fancy-1">
                                                            <input class="floating-input" type="file"
                                                                id="image" placeholder=" "
                                                                wire:model="sponsor_image">
                                                            <span class="highlight"></span>
                                                            <label>Select Sponsor Image</label>
                                                        </div>
                                                        @error('sponsor_image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @error('sponsor_image.*')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn "
                                            style="background-color:#003b5f; color:#fff;">Save</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            wire:click="close_editcommunity_sponsor">Close</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <span><img src="{{ url('frontend/images/hrt-icon.png') }}"></span>
                    <span class="AboutStyleUs"> {{ $SponsorHeading }}</span>
                    <div class="owlSPONSORS owl-carousel owl-theme CommunitySPONSORS" wire:ignore>
                        @if ($comp_sponsers->isNotEmpty())
                            @foreach ($comp_sponsers as $comp_spo)
                                <?php
                                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                                    $url = 'https://';
                                } else {
                                    $url = 'http://';
                                }
                                // Append the host(domain name, ip) to the URL.
                                $url .= $_SERVER['HTTP_HOST'];
                                $sponserimage[] = $url . '/storage/app/public/image/' . $comp_spo->sponsor_image;
                                ?>
                            @endforeach
                            <?php $community_sponsors = array_chunk($sponserimage, 6); ?>
                            @foreach ($community_sponsors as $comp_spons)
                                <div class="item">
                                    <div class="CommunitySponsors logosCommunuty">
                                        <div class="width-Logo100">
                                            <div class="mt-1 row">
                                                @foreach ($comp_spons as $images)
                                                    <div class="text-center w-33 VerticalCenter ">
                                                        <div class="p-1 LogoHeight70 ">
                                                            <img src="{{ $images }}"
                                                                class="img-fluid img-fludeLogo "
                                                                alt="Community Sponsors">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p> No Data Found </p>
                        @endif
                    </div>
                @endif

                <script>
                    window.addEventListener('OpenaddcommunitysponserModal', event => {
                        $('#addcommunitySponsor').modal('show')
                    })
                </script>
                <script>
                    window.addEventListener('CloseaddcommunitysponserModal', event => {
                        $('#addcommunitySponsor').modal('hide')
                    })
                </script>
                <script>
                    window.addEventListener('OpeneditcommunitysponsorModal', event => {
                        $('#editcommunitysponsor').modal('show')
                    })
                </script>
                <script>
                    window.addEventListener('CloseeditcommunitysponsorModal', event => {
                        $('#editcommunitysponsor').modal('hide')
                    })
                </script>
                <script>
                    window.addEventListener('OpeneditcommunitysponserModal', event => {
                        $('#editcommunitysponsorModal').modal('show')
                    })
                </script>
                <script>
                    window.addEventListener('CloseeditcommunitysponserModal', event => {
                        $('#editcommunitysponsorModal').modal('hide')
                    })
                </script>
                <!-- <script>
                    window.livewire.on('filechoosen', () => {
                        let file = document.getElementById('image')
                        console.log(file);
                    })
                </script> -->

            </div>

            {{-- for competition.addcommunity-sponsor ending --}}
            <hr>


            <!-- <div class="">
            <span><img src="{{ asset('frontend/images') }}/twittter.png"></span> <span class="AboutStyleUs"> @FC
                BARCELONA</span>
            <p class="TextSocalInner">Barcelona manager Xavi: “Ousmane Dembélé will turn whistles
                into
                applause here at Camp Nou, I’m sure”. #FCB</p>
            <p class="TextSocalInner">“We have to trust Ferrán Torres - it's a matter of giving him
                time
                and
                confidence”.</p>
            <div class="SocalMatchImg">
                <img src="{{ asset('frontend/images') }}/aft_match.png" width="100%">
            </div>
            <a href="#" class="TwitterTxtBtm">12:00 PM · Feb 18, 2022</a>
        </div>
        <hr> -->
            {{-- @livewire('competition.addcomp-youtube-video', ['competition' => $competition->id]) --}}

            {{-- for competition.addcomp-youtube-video --}}
            <div class="">
                @if (Auth::check())
                    <span><img src="{{ url('frontend/images/Youtube-icon.png') }}"></span> <span
                        class="AboutStyleUs">News & Media</span>
                    @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                        @if (!empty($video))
                            <a wire:click="open_edityoutube_video" style="cursor:pointer;"><span
                                    class="Edit-Icon"></span></a>
                        @else
                            <a wire:click="open_compyoutube_video" style="cursor:pointer;"><span class="fa-plus">
                                </span></a>
                        @endif
                    @else
                    @endif
                    <p></p>
                    <?php
                    if (count($youtubevideo) == 0) {
                        $height = 50;
                    } elseif (count($youtubevideo) == 1) {
                        $height = 240;
                    } elseif (count($youtubevideo) == 2) {
                        $height = 240 * 2;
                    } else {
                        $height = 240 * 3;
                    }
                    ?>

                    <div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">
                        <div class=" socialHeight" id="style-1" style="height:{{ $height }}px !important;">
                            @if (count($youtubevideo) != 0)
                                @foreach ($youtubevideo as $video)
                                    <?php
                                    $word = 'watch?v=';
                                    // Check if the string contains the word
                                    if (strpos($video->video_link, $word) !== false) {
                                        $video_link = explode('watch?v=', $video->video_link);
                                        $video_id = $video_link[1];
                                    } else {
                                        $video_link = explode('/', $video->video_link);
                                        $video_id = end($video_link);
                                    }
                                    //echo $video_id;
                                    ?>
                                    <div class="d-flex">
                                        <iframe width="1280" height="220"
                                            src="https://www.youtube.com/embed/{{ $video_id }}" title=""
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </div>
                                @endforeach
                            @else
                                <div class="SocalMatchImg">
                                    No Data found
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal fade" id="compyoutube_video" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add YouTube Video</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container mt-3">

                                        <div class="row">
                                            <div class="mb-4 col-md-12 FlotingLabelUp">
                                                <div class="floating-form ">
                                                    <div class="floating-label form-select-fancy-1">
                                                        <input class="floating-input" type="textarea" placeholder=" "
                                                            wire:model="video_link">
                                                        <span class="highlight"></span>
                                                        <label>YouTube video or playlist link</label>
                                                    </div>

                                                    @error('video_link')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                        wire:click="close_compyoutube_video">Close</button>
                                    <button type="button" class="btn "
                                        style="background-color:#003b5f; color:#fff;"
                                        wire:click="addcomp_video">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editvideo" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Youtube Videos</h5>
                                    <a class="modal-title" style="cursor:pointer;"
                                        wire:click="open_compyoutube_video">ADD</a>
                                </div>
                                <div class="modal-body">
                                    <div class="">
                                        <div class="row">
                                            <div class="mt-2 mb-4 col-md-12 FlotingLabelUp">
                                                <div class="floating-form ">
                                                    <div class="floating-label form-select-fancy-1">
                                                        <table>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Video </th>
                                                                <th colspan="2">Action</th>
                                                            </tr>
                                                            @foreach ($youtubevideo as $comp_video)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td><a href="{{ $comp_video->video_link }}"> Watch
                                                                        </a></td>
                                                                    <td><a style="cursor:pointer;"
                                                                            wire:click="open_editcompyoutube_video({{ $comp_video->id }})"><i
                                                                                class="icon-edit "></i></a></td>
                                                                    <td><a style="cursor:pointer;"
                                                                            wire:click="deletecomp_video({{ $comp_video->id }})"
                                                                            onclick="return confirm('Are you sure you want to delete this Video?')|| event.stopImmediatePropagation()"><i
                                                                                class="icon-trash "></i></a></td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" style="cursor:pointer;"
                                        data-dismiss="modal" wire:click="close_edityoutube_video">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editcompyoutube_video" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Competition Video</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="mb-4 col-md-12 FlotingLabelUp">
                                                <div class="floating-form ">
                                                    <div class="floating-label form-select-fancy-1">
                                                        <input class="floating-input" type="textarea" placeholder=" "
                                                            wire:model="video_link">
                                                        <span class="highlight"></span>
                                                        <label>Video link</label>
                                                    </div>
                                                    @error('video_link')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                        wire:click="close_editcompyoutube_video">Close</button>
                                    <button type="button" class="btn "
                                        style="background-color:#003b5f; color:#fff;" wire:click="editcomp_video">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <span><img src="{{ url('frontend/images/Youtube-icon.png') }}"></span> <span
                        class="AboutStyleUs"> News & Media</span>
                    <?php
                    if (count($youtubevideo) == 0) {
                        $height = 50;
                    } elseif (count($youtubevideo) == 1) {
                        $height = 240;
                    } elseif (count($youtubevideo) == 2) {
                        $height = 240 * 2;
                    } else {
                        $height = 240 * 3;
                    }
                    ?>

                    <div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">
                        <div class=" socialHeight" id="style-1" style="height:{{ $height }}px !important;">
                            @if (count($youtubevideo) != 0)
                                @foreach ($youtubevideo as $video)
                                    <?php
                                    $word = 'watch?v=';
                                    // Check if the string contains the word
                                    if (strpos($video->video_link, $word) !== false) {
                                        $video_link = explode('watch?v=', $video->video_link);
                                        $video_id = $video_link[1];
                                    } else {
                                        $video_link = explode('/', $video->video_link);
                                        $video_id = end($video_link);
                                    }
                                    //echo $video_id;
                                    ?>
                                    <div class="d-flex">
                                        <iframe width="1280" height="220"
                                            src="https://www.youtube.com/embed/{{ $video_id }}" title=""
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </div>
                                @endforeach
                            @else
                                <div class="SocalMatchImg">
                                    No Data found
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <script>
                    window.addEventListener('Opencompyoutube_videoModal', event => {
                        $('#compyoutube_video').modal('show')
                    })
                </script>
                <script>
                    window.addEventListener('Closecompyoutube_videoModal', event => {
                        $('#compyoutube_video').modal('hide')
                    })
                </script>
                <script>
                    window.addEventListener('CloseaddcomprulesModal', event => {
                        $('#addcomprules').modal('hide')
                    })
                </script>
                <script>
                    window.addEventListener('OpeneditvideoModal', event => {
                        $('#editvideo').modal('show')
                    })
                </script>
                <script>
                    window.addEventListener('CloseeditvideoModal', event => {
                        $('#editvideo').modal('hide')
                    })
                </script>
                <script>
                    window.addEventListener('Openeditcompyoutube_videoModal', event => {
                        $('#editcompyoutube_video').modal('show')
                    })
                </script>
                <script>
                    window.addEventListener('Closeeditcompyoutube_videoModal', event => {
                        $('#editcompyoutube_video').modal('hide')
                    })
                </script>

            </div>
            {{-- for competition.addcomp-youtube-video ending --}}
            @livewireScripts
            <!-- <hr> -->

        </div>
    </div>
