<div class="col-md-4" >
    @if(Auth::check())
        @if(!empty($user))

        <div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">
            <div class=""><span><img src="{{url('frontend/images/Contact-us.png')}}"></span>
                <span class="AboutStyleUs"> Contact Info</span>
                    @if(!empty($team_member))
                    <?php $team_contact = App\Models\Team::select('id','user_id','name','team_email','team_phone_number','team_address')->find($team_member->team_id);
                        $team_admins = App\Models\Team_member::where('team_id',$team_member->team_id)->where('member_position_id',4)->pluck('member_id');
                        $team_admin_ids = $team_admins->toArray();
                      array_push($team_admin_ids,@$team_contact->user_id);
                    ?>
                        @if(in_array(Auth::user()->id , $team_admin_ids) || Auth::user()->id == $player_id)
                            @if(Auth::user()->id == $player_id)
                                <a style="cursor:pointer;" wire:click="open_contact_us_modal"><span class="fa-plus"> </span></a>
                            @endif
                            <p class="TextSocalInner"><b>Email:</b>  {{$user_email}}  </p>
                            <p class="TextSocalInner"><b>Mobile:</b> {{$user_phone_number}} </p>
                            <p class="TextSocalInner "><b>Address:</b> {{$user_address}} </p>
                        @else
                            <p class="TextSocalInner"><b>Email:</b>  {{$team_contact->team_email}}  </p>
                            <p class="TextSocalInner"><b>Mobile:</b> {{$team_contact->team_phone_number}} </p>
                            <p class="TextSocalInner "><b>Address:</b> {{$team_contact->team_address}} </p>
                        @endif
                    @else
                        @if(Auth::user()->id == $player_id)
                            <a style="cursor:pointer;" wire:click="open_contact_us_modal"><span class="fa-plus"> </span></a>
                        @else
                        @endif
                        @if($user->user_email)
                            <p class="TextSocalInner"><b>Email:</b>  {{$user->user_email}}  </p>
                        @else
                            <p class="TextSocalInner DefaultClorText"><b>Email:</b> example@gmail.com </p>
                        @endif
                        @if($user->user_phone_number)
                            <p class="TextSocalInner"><b>Mobile:</b> {{$user->user_phone_number}} </p>
                        @else
                            <p class="TextSocalInner DefaultClorText"><b>Mobile:</b> XXXXXXXXXX </p>
                        @endif
                        @if($user->user_address)
                            <p class="TextSocalInner "><b>Address:</b> {{$user->user_address}} </p>
                        @else
                            <p class="TextSocalInner DefaultClorText"><b>Address:</b> Plot No. XXX Near abc office, Country. </p>
                        @endif
                    @endif

            </div>
            <hr>
        @else
        @endif
        @if(Auth::user()->id == $player_id)
            @if(count($playeryoutubevideos)!= 0)
                <a class="modal-title" style="cursor:pointer;" wire:click="open_listplayer_youtubevideo"><span class="Edit-Icon"></span></a>
            @else
                <a class="modal-title" style="cursor:pointer;" wire:click="open_addplayer_youtubevideo"><span class="fa-plus"> </span></a>
            @endif
        @else
        @endif
        <span><img src="{{url('frontend/images/Youtube-icon.png')}}"></span><span class="AboutStyleUs"> News & Media </span>
        <?php
            if(count($playeryoutubevideos) == 0)
            {
                $height = 50;
            }
            elseif(count($playeryoutubevideos) == 1)
            {
                $height = 240;
            }
            elseif(count($playeryoutubevideos) == 2)
            {
                $height = 240 *2;
            }
            else
            {
                $height = 240 * 3;
            }
        ?>

        <div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">

            <div class=" socialHeight " id="style-1" style="height:{{$height}}px !important;">
                @if(count($playeryoutubevideos)!= 0)
                    @foreach($playeryoutubevideos as $video)
                    <?php
                        $word = "watch?v=";
                        // Check if the string contains the word
                        if(strpos($video->video_link, $word) !== false){
                            $video_link = explode("watch?v=",$video->video_link);
                            $video_id = $video_link[1];

                        } else{
                            $video_link = explode("/",$video->video_link);
                            $video_id = end($video_link);
                        }
                        //echo $video_id;

                        ?>
                    <div class="d-flex">
                        <iframe width="1280" height="220" src="https://www.youtube.com/embed/{{$video_id}}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    @endforeach
                @else
                    <div class="SocalMatchImg">
                        No Data found
                    </div>
                @endif
            </div>
        </div>


        <div class="modal fade" id="addplayeryoutubevideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Video</h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="">

                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="textarea" placeholder=" " wire:model="addvideo_link">
                                            <span class="highlight"></span>
                                            <label>Video link</label>
                                        </div>
                                        <small style="font-size: 12px;">Video url example:(https://www.youtube.com/embed/bd84Vo7OEDw)</small>
                                        @error('addvideo_link') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_addplayer_youtubevideo">Close</button>
                        <button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="add_playervideo" >Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="listplayeryoutubevideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Youtube Video List</h5>
                        <a class="modal-title" style="cursor:pointer;" wire:click="open_addplayer_youtubevideo">ADD</a>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12 mb-4 mt-2 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <table>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Video Link</th>
                                                    <th colspan="2">Action</th>
                                                </tr>
                                                    @foreach($playeryoutubevideos as $playervideo)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>@php echo Str::of($playervideo->video_link)->limit(14); @endphp</td>
                                                        <td><a style="cursor:pointer;" wire:click="open_editplayer_youtubevideo({{ $playervideo->id }})"><i class="icon-edit "></i></a></td>
                                                        <td><a style="cursor:pointer;" wire:click="deleteplayer_video({{ $playervideo->id }})" onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i class="icon-trash "></i></a></td>
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
                        <button type="button" class="btn btn-secondary" style="cursor:pointer;" data-dismiss="modal" wire:click="close_listplayer_youtubevideo">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editplayeryoutubevideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
                    </div>
                    <div class="modal-body">
                        <div class="">

                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="textarea" placeholder=" " wire:model="editvideo_link">
                                            <span class="highlight"></span>
                                            <label>Video link</label>
                                        </div>
                                        @error('editvideo_link') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editplayer_youtubevideo">Close</button>
                        <button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="editplayer_youtubevideo" >Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact us modal -->
            <div class="modal fade" id="contact_us_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="row mb-4 mt-4">
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <input class="floating-input" type="email" placeholder=" " wire:model= "user_email" value="{{$user_email}}">
                                                <span class="highlight"></span>
                                                <label>Email:</label>
                                            </div>
                                        </div>
                                        @error('user_email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row mb-4 mt-4">
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <input class="floating-input" type="number" placeholder=" " wire:model="user_phone_number" value="{{$user_phone_number}}" min="1">
                                                <span class="highlight"></span>
                                                <label>Phone number:</label>
                                            </div>
                                        </div>
                                        @error('user_phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row mb-4 mt-4" wire:ignore>
                                    <div class=" col-md-12 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <textarea class="floating-input" type="address" placeholder=" " value="{{$user_address}}" wire:model="user_address">{{$user_address}}</textarea>
                                                <span class="highlight"></span>
                                                <label>Address:</label>
                                            </div>
                                        </div>
                                        @error('user_address') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_contact_us_modal">Close</button>
                            <button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="save_comp_contact({{$userid}})">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
    @else
    <div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">
        <div class=""><span><img src="{{url('frontend/images/Contact-us.png')}}"></span>
            <span class="AboutStyleUs"> Contact Info</span>
                @if(!empty($team_member))
                    <?php $team_contact = App\Models\Team::select('id','user_id','name','team_email','team_phone_number','team_address')->find($team_member->team_id);
                        $team_admins = App\Models\Team_member::where('team_id',$team_member->team_id)->where('member_position_id',4)->pluck('member_id');
                        $team_admin_ids = $team_admins->toArray();
                    array_push($team_admin_ids,@$team_contact->user_id);
                    ?>
                    <p class="TextSocalInner"><b>Email:</b>  {{$team_contact->team_email}}  </p>
                    <p class="TextSocalInner"><b>Mobile:</b> {{$team_contact->team_phone_number}} </p>
                    <p class="TextSocalInner "><b>Address:</b> {{$team_contact->team_address}} </p>
                @else
                    <p class="TextSocalInner"><b>Email:</b>  -  </p>
                    <p class="TextSocalInner"><b>Mobile:</b> - </p>
                    <p class="TextSocalInner "><b>Address:</b> - </p>
                @endif
        </div>
        <hr>
        <h1 class="Poppins-Fs30">News & Media  </h1>
        <?php
            if(count($playeryoutubevideos) == 0)
            {
                $height = 50;
            }
            elseif(count($playeryoutubevideos) == 1)
            {
                $height = 240;
            }
            elseif(count($playeryoutubevideos) == 2)
            {
                $height = 240 *2;
            }
            else
            {
                $height = 240 * 3;
            }
        ?>

        <div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">

            <div class=" socialHeight " id="style-1" style="height:{{$height}}px !important;">
                @if(count($playeryoutubevideos)!= 0)
                    @foreach($playeryoutubevideos as $video)
                    <?php
                        $word = "watch?v=";
                        // Check if the string contains the word
                        if(strpos($video->video_link, $word) !== false){
                            $video_link = explode("watch?v=",$video->video_link);
                            $video_id = $video_link[1];

                        } else{
                            $video_link = explode("/",$video->video_link);
                            $video_id = end($video_link);
                        }
                        //echo $video_id;

                        ?>
                    <div class="d-flex">
                        <iframe width="1280" height="220" src="https://www.youtube.com/embed/{{$video_id}}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
    </div>

    <script>
      window.addEventListener('OpenaddplayeryoutubevideoModal', event=> {
         $('#addplayeryoutubevideo').modal('show')
      })
    </script>
    <script>
      window.addEventListener('CloseaddplayeryoutubevideoModal', event=> {
         $('#addplayeryoutubevideo').modal('hide')
      })
    </script>
    <script>
      window.addEventListener('OpenlistplayeryoutubevideoModal', event=> {
         $('#listplayeryoutubevideo').modal('show')
      })
    </script>
    <script>
      window.addEventListener('CloselistplayeryoutubevideoModal', event=> {
         $('#listplayeryoutubevideo').modal('hide')
      })
    </script>
    <script>
      window.addEventListener('OpeneditplayeryoutubevideoModal', event=> {
         $('#editplayeryoutubevideo').modal('show')
      })
    </script>
    <script>
      window.addEventListener('CloseeditplayeryoutubevideoModal', event=> {
         $('#editplayeryoutubevideo').modal('hide')
      })
    </script>
    <script>
         window.addEventListener('open_contact_us', event=> {
         $('#contact_us_modal').modal('show')
      })
    </script>
    <script>
         window.addEventListener('close_contact_us', event=> {
         $('#contact_us_modal').modal('hide')
      })
    </script>

