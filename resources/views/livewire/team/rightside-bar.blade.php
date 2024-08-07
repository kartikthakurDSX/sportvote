<div class="box-outer-lightpink SocialList AboutSocalSec">
    <button class="processed" wire:click="refresh">Refresh</button>
    {{-- wire:poll.750ms --}}
    <div class="">
        @if (Auth::check())
            <span><img src="{{ url('frontend/images/aboutStar-icon.png') }}"></span> <span class="AboutStyleUs"> ABOUT
                US</span>
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
                <a wire:click="edit_team_desc" style="cursor:pointer;"><span class="Edit-Icon"> </span></a>
            @else
            @endif
            <div class="about_us_height">
                <div class="TextSocalInner">
                    @if ($team->description)
                        {!! $team->description !!}
                    @else
                        --
                    @endif
                </div>
            </div>

            <div class="modal fade" id="editdescModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Description</h5>
                        </div>
                        <div class="modal-body ">
                            <div class="container ">
                                <div class="mt-4 mb-4 row">
                                    <div wire:ignore.self>
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
            <span><img src="{{ url('frontend/images/aboutStar-icon.png') }}"></span> <span class="AboutStyleUs"> ABOUT
                US</span>
            <div class="about_us_height">
                <div class="TextSocalInner">
                    @if ($team->description)
                        {!! $team->description !!}
                    @else
                        --
                    @endif
                </div>
            </div>
        @endif
        <script>
            window.addEventListener('OpendescModal', event => {
                $('#editdescModal').modal('show')
            })
            window.addEventListener('ClosedescModal', event => {
                $('#editdescModal').modal('hide')
            })
        </script>
    </div>

    <hr>
    <div class="">
        <span><img src="{{ url('frontend/images/Contact-us.png') }}"></span> <span class="AboutStyleUs"> contact
            US</span>
        @if (Auth::check())
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
                <span> <a style="cursor:pointer;" id="contact_us"><span class="fa-plus"> </span></a> </span>
            @else
            @endif
        @else
        @endif
        <p class="TextSocalInner"><b>Email:</b> {{ $team->team_email }} </p>
        <p class="TextSocalInner"><b>Mobile:</b> {{ $team->team_phone_number }} </p>
        <p class="TextSocalInner"><b>Address:</b> {{ $team->team_address }} </p>
    </div>

    <hr>
    <div class="">
        <span><img src="{{ url('frontend/images/AdminStar-icon.png') }}"></span> <span class="AboutStyleUs">
            ADMINISTRATION</span>
        @if (Auth::check())
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
                <span> <a style="cursor:pointer;" class="open_team_admin_popup"><span class="fa-plus"> </span></a>
                </span>
            @else
            @endif
        @else
        @endif
        <div class="D-FSpacng">
            <div class="AdmIcon">
                <img src="{{ url('frontend/profile_pic') }}/{{ $team_owner->profile_pic }}" width="100%"
                    alt="">
            </div>
            <span class="SergiTeam">
                {{ $team_owner->first_name }} {{ $team_owner->last_name }},
                <span class="SpanishTeam">
                    Team Creator
                </span>
            </span>
        </div>
        @if (Auth::check())
            @if (!empty($team_member))
                @foreach ($team_member as $team_mem)
                    <div class="D-FSpacng">
                        <div class="AdmIcon">
                            <img src="{{ url('frontend/profile_pic') }}/{{ $team_mem->members->profile_pic }}"
                                width="100%" alt="">
                        </div>
                        <span class="SergiTeam">
                            {{ $team_mem->members->first_name }} {{ $team_mem->members->last_name }},
                            <span class="SpanishTeam">
                                {{ $team_mem->member_position->name }}
                            </span>
                            @if ($team_mem->invitation_status == 0)
                                [ Pending ]
                                <!-- @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
<a class="btn btn-crossSocial" wire:click ="cancel_request({{ $team_mem->id }})" style="cursor:pointer;">×</a>
@else
@endif -->
                            @else
                                @if (Auth::user()->id == $team->user_id)
                                    @if ($team_mem->invitation_status == 2)
                                        [ Decline your request ]
                                    @endif
                                @else
                                @endif
                                <!-- @if (Auth::user()->id == $team->user_id && $team_mem->invitation_status == 1)
<a class="btn btn-crossSocial" wire:click ="cancel_request({{ $team_mem->id }})" style="cursor:pointer;">×</a>
@else
@endif -->
                            @endif
                            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
                                @if (Auth::user()->id != $team_mem->members->id)
                                    <a class="btn btn-crossSocial" wire:click ="cancel_request({{ $team_mem->id }})"
                                        style="cursor:pointer;">×</a>
                                @else
                                @endif
                            @else
                            @endif
                        </span>
                    </div>
                @endforeach
                {{ $team_member->links('cpag.custom') }}
            @else
                <div class="D-FSpacng">
                    N/A
                </div>
            @endif
        @else
        @endif
    </div>


    @if (Auth::check())
        @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
            <hr>
            <div class=""><span><img src="{{ url('frontend/images/PlayerStar-icon.png') }}"></span> <span
                    class="AboutStyleUs"> Invite PLAYERS </span>
                <span> <a style="cursor:pointer;" id="add_player"><span class="fa-plus"> </span></a> </span>
            </div>
            @livewire('team-requested-player', ['team' => $team])
        @else
        @endif
        <hr>
    @else
    @endif


    <div class="">
        @if (Auth::check())
            <span><img src="{{ asset('frontend/images') }}/hrt-icon.png"></span>
            <span class="AboutStyleUs">
                COMMUNITY SPONSORS
            </span>
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
                @if (count($com_sponsers) != 0)
                    <a class="btn-icon" wire:click="open_edit_sponsor" style="cursor:pointer;"><span class="Edit-Icon">
                        </span></a>
                @else
                    <a wire:click="open_addcommunity_sponsor" style="cursor:pointer;"><span class="fa-plus"> </span></a>
                @endif
            @else
            @endif
            <div class="owlSPONSORS owl-carousel owl-theme CommunitySPONSORS" wire:ignore.self>
                @if ($com_sponsers->isNotEmpty())
                    @foreach ($com_sponsers as $comp_spo)
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
                                                    <img src="{{ $images }}" class="img-fluid img-fludeLogo "
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
                            </div><br>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="mb-4 col-md-12 FlotingLabelUp">
                                            <div class="floating-form ">
                                                <div class="floating-label form-select-fancy-1">
                                                    <input class="floating-input" type="file" id="image"
                                                        placeholder=" " wire:model="sponsor_image" multiple>
                                                    <div wire:loading wire:target="sponsor_image" wire.ignore>
                                                        Uploading...</div>
                                                    <span class="highlight"></span>
                                                    <label>Select Sponsor image</label>
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    wire:click="close_addcommunity_sponsor">Close</button>
                                @if ($sponsor_image)
                                    <button type="submit" class="btn "
                                        style="background-color:#003b5f; color:#fff;">Save </button>
                                    <div wire:loading wire:target="save" wire:ignore.self>process...</div>
                                @else
                                @endif
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Community Sponsors</h5>
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
                                                        <th>No.</th>
                                                        <th>Image</th>
                                                        <th colspan="2">Delete</th>
                                                    </tr>
                                                    @foreach ($com_sponsers_view as $comp_sponser)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <img src="<?php echo $url . '/storage/app/public/image/' . $comp_sponser->sponsor_image; ?>" width="80px"
                                                                    class="img-fluid">
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
        @else
            <span><img src="{{ asset('frontend/images') }}/hrt-icon.png"></span>
            <span class="AboutStyleUs">
                COMMUNITY SPONSORS
            </span>
            <div class="owlSPONSORS owl-carousel owl-theme CommunitySPONSORS" wire:ignore.self>
                @if ($com_sponsers->isNotEmpty())
                    @foreach ($com_sponsers as $comp_spo)
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
                                                    <img src="{{ $images }}" class="img-fluid img-fludeLogo "
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
    </div>
    <!-- <hr>
    <div class="">
        <span><img src="{{ url('frontend/images/twittter.png') }}"></span> <span class="AboutStyleUs"> @FC BARCELONA</span>
        <p class="TextSocalInner">Barcelona manager Xavi: “Ousmane Dembélé will turn whistles into applause here at Camp Nou, I’m sure”. #FCB</p>
        <p class="TextSocalInner">“We have to trust Ferrán Torres - it's a matter of giving him time and confidence”.</p>
        <div class="SocalMatchImg">

            <img src="{{ url('frontend/images/aft_match.png') }}" width="100%">
        </div>
        <a href="#" class="TwitterTxtBtm">12:00 PM · Feb 18, 2022</a>
    </div> -->
    <hr>
    <div class="">
        @if (Auth::check())
            <span><img src="{{ asset('frontend/images') }}/Youtube-icon.png"></span>
            <span class="AboutStyleUs">News & Media</span>
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $team->user_id)
                @if (!empty($video))
                    <a wire:click="open_edityoutube_video" style="cursor:pointer;"><span
                            class="Edit-Icon"></span></a>
                @else
                    <a wire:click="open_compyoutube_video" style="cursor:pointer;"><span class="fa-plus"></span></a>
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
                                            <small style="font-size: 12px;">Video url
                                                example:(https://www.youtube.com/embed/bd84Vo7OEDw)</small>
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
                            <button type="button" class="btn " style="background-color:#003b5f; color:#fff;"
                                wire:click="addcomp_video">Save </button>
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
                                                        <th>Video Link</th>
                                                        <th colspan="2">Action</th>
                                                    </tr>
                                                    @foreach ($youtubevideo as $video)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td><a href="{{ $video->video_link }}"> Watch </a></td>
                                                            <td><a style="cursor:pointer;"
                                                                    wire:click="open_editcompyoutube_video({{ $video->id }})"><i
                                                                        class="icon-edit "></i></a></td>
                                                            <td><a style="cursor:pointer;"
                                                                    wire:click="deletecomp_video({{ $video->id }})"
                                                                    onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Team Video</h5>
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
                            <button type="button" class="btn " style="background-color:#003b5f; color:#fff;"
                                wire:click="editcomp_video">Save </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <span><img src="{{ asset('frontend/images') }}/Youtube-icon.png"></span>
            <span class="AboutStyleUs"> LATEST YOUTUBE VIDEOS</span>
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
</div>
