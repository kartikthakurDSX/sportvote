<span >
    {{-- wire:poll.750ms --}}
    <button class="processed" wire:click="refresh">Refresh</button>


    <?php
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        // Append the host(domain name, ip) to the URL.
        $url.= $_SERVER['HTTP_HOST'];

    if(!empty($playerprofilebanner))
    {
        if($playerprofilebanner->banner != null){
            $playerbanner = $url."/dev/public/frontend/banner/".$playerprofilebanner->banner;

        }
        else{
            $playerbanner = $url ."/dev/public/frontend/images/Header-bg.png";

        }
    }
    else
    {
        $playerbanner = $url ."/dev/public/frontend/images/Header-bg.png";
    }

    ?>
    <div class="header-bottom header-bottomPlayer dashboard" style="background-image: url('{{$playerbanner}}');">
		<div class="container-lg">
			<div class="row">
				<div class="col-sm-6">
				</div>
				<!-- <div class="col-sm-6">
					<div class="float-end">
						<button class="btn " type="button"><i class="icon-cog fs1"></i></button>
						<button class="btn btn-outline ms-auto br-5" type="button"><i class="green-text icon-edit"></i> <span class="hide-xs">Edit profile</span> </button>
					</div>
				</div> -->
			</div>

		</div>
	</div>
    @if(Auth::check())
        @if(Auth::user()->id == $playerprofilebanner->id)
        <a wire:click="open_editplayer_banner" style="cursor:pointer;">
        <span class="Edit-Icon-Banner HeroImgEditTop"></span></a>
        @else
        @endif


    <div class="modal fade" id="edit_playerbanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Banner</h5>
                    </div>
                    <div class="modal-body">
                        <br>
                        <div class="">
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="file" id="playerbannerfile" placeholder=" " name="playerbanner" wire:click="close_editplayer_banner">
                                            <span class="highlight"></span>
                                            <label>Select Banner</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editplayer_banner">Close</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
    @else
    @endif
</span>
<script>
  window.addEventListener('OpenplayerbannerModal', event=> {
     $('#edit_playerbanner').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseplayerbannerModal', event=> {
     $('#edit_playerbanner').modal('hide')
  })
</script>
<script>
	window.livewire.on('filechoosen', () => {
		let file = document.getElementById('playerbannerfile')
		console.log(file);
	})
 </script>
 @once
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
	$('#playerbannerfile').ijaboCropTool({
		setRatio:3,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl:'{{ url("edit_playerbanner/".$playerprofilebanner->id) }}',
        withCSRF:['_token','{{ csrf_token() }}'],
		onSuccess:function(message, element, status){

			//location.reload();
		},
		onError:function(message, element, status){
		    alert(message);
		}
	});
</script>
@endonce
