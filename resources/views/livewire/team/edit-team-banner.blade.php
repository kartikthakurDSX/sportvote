<span  >
    <button class="processed" wire:click="refresh">Refresh</button>

    {{-- wire:poll.750ms --}}
    @if(Auth::check())
    <div class="header-bottom header-bottomTeamPub dashboard"
        style="background-image: url('{{url('frontend/images/team_banner/'.$team->team_banner)}}');" >
        <div class="container-fluid bh-WhiteTsp">
            <div class="container-lg">
                <div class="row">
                    <div class="col-sm-2">

                        </div>
                        <div class="col-sm-5 col-8 LineHSpace">
                            <span class="FCBarcelona"><strong class="FCStyle"><?php $team_name = explode(" ",$team->name) ?>
                            @foreach($team_name as $teams) @if($loop->first) {{$teams}}</strong> @else {{$teams}}
                            @endif @endforeach</span>
                            <p class="p-3 ClubMore"data-toggle="tooltip" data-placement="bottom" data-bs-original-title="{{$team->team_slogan}}" title="">@if($team->team_slogan) {{ substr($team->team_slogan, 0, 40).'...' }}
                                @else - @endif</p>

                        </div>
                        <div class="col-sm-5 col-4 TextRght">
                            <span class="HomeGround">HOMEGROUND</span>
                            <p class="CampNou">@if($team->homeGround) {{$team->homeGround}} @else - @endif</p>
                            <p class="HomeGround">TEAM COLOR</p>
                            <div class="TeamColorSelect" style="background-color:<?php echo $team->team_color; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $team->user_id))
        <a wire:click="open_editteam_banner" style="cursor:pointer;"><span class="Edit-Icon-Banner HeroImgEditTop"></span></a>
        @else
        @endif
    </div>
    <div class="modal opacityPop fade" id="edit_teambanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel "
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Team Banner</h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="">
                            <div class="row">
                                <div class="mb-4 col-md-12 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="file" id="team_banner" placeholder=" "
                                                name="team_banner" wire:click="close_editteam_banner">
                                            <span class="highlight"></span>
                                            <label>Select Team Banner</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="close_editteam_banner">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @else
    <div class="header-bottom header-bottomTeamPub dashboard"
        style="background-image: url('{{url('frontend/images/team_banner/'.$team->team_banner)}}');">
        <div class="container-fluid bh-WhiteTsp">
            <div class="container-lg">
                <div class="row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-5 col-8 LineHSpace">
                        <span class="FCBarcelona"><strong class="FCStyle"><?php $team_name = explode(" ",$team->name) ?>
                                @foreach($team_name as $teams) @if($loop->first) {{$teams}}</strong> @else {{$teams}}
                            @endif @endforeach</span>
                        <p class="ClubMore">@if($team->team_slogan) {{ substr($team->team_slogan, 0, 40).'...' }} @else
                            - @endif</p>
                    </div>
                    <div class="col-sm-5 col-4 TextRght">
                        <span class="HomeGround">HOMEGROUND</span>
                        <p class="CampNou">@if($team->homeGround) {{$team->homeGround}} @else - @endif</p>
                        <p class="HomeGround">TEAM COLOR</p>
                        <div class="TeamColorSelect" style="background-color:<?php echo $team->team_color; ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
    window.addEventListener('OpenteambannerModal', event => {
        $('#edit_teambanner').modal('show')
    })
    </script>
    <script>
    window.addEventListener('CloseteambannerModal', event => {
        $('#edit_teambanner').modal('hide')
    })
    </script>
    <!-- <script>
	window.livewire.on('filechoosen', () => {
		let file = document.getElementById('file')
		console.log(file);
	})
 </script> -->

    <script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
    <script>
    $('#team_banner').ijaboCropTool({
        preview: '.teambanner',
        setRatio: 3,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        buttonsText: ['CROP & SAVE', 'QUIT'],
        buttonsColor: ['#30bf7d', '#ee5155', -15],
        processUrl: '{{ url("edit_teambanner/".$team->id) }}',
        withCSRF: ['_token', '{{ csrf_token() }}'],
         onSuccess:function(message, element, status){
            location.reload();
        	//alert(message);
        	//  $('#sv_comp_logo').attr('src','{{url("frontend/logo")}}/'+message);
        	// $('#file').html(message);
        },
        onError:function(message, element, status){
            alert(message);
        }
    });
    </script>

</span>
