<span >
    {{-- wire:poll.750ms --}}

    <button class="processed" wire:click="refresh">Refresh</button>

    <span class="user-profile-img">
        <img src="{{url('frontend/profile_pic/'.$player_info->profile_pic)}}" width="100%" class="img-fluid teamlogo" alt="profle-image">
    </span>
   @if(Auth::check())
	@if(Auth::user()->id == $player_info->id)
    <a wire:click="open_editplayerprofile_logo" style="cursor:pointer;"><span class=" Edit-Icon-white EditProfileOne"></span></a>
	@else
	@endif

    <div class="modal fade" id="edit_playerlogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Profile Pic</h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="">
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="file" id="file" placeholder=" " name="playerlogo" wire:click="close_editplayerprofile_logo">
                                            <span class="highlight"></span>
                                            <label>Select Profile Pic</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editplayerprofile_logo">Close</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
    @else
    @endif
</span>
<script>
  window.addEventListener('OpenplayerprofilelogoModal', event=> {
     $('#edit_playerlogo').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseplayerprofilelogoModal', event=> {
     $('#edit_playerlogo').modal('hide')
  })
</script>
<script>
	window.livewire.on('filechoosen', () => {
		let file = document.getElementById('file')
		console.log(file);
	})
 </script>
 @once
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
	$('#file').ijaboCropTool({
		setRatio:1,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl:'{{ url("edit_playerlogo/".$player_info->id) }}',
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
