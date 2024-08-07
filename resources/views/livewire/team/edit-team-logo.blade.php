<div>
    <button class="processed" wire:click="refresh">Refresh</button>
    <div class="Competitionn-Page-Additional">
        @if(Auth::check())
        <span class="user-profile-imgTeam">
            <img src="{{url('frontend/logo/'.$logo->team_logo)}}" width="100%" class="img-fluid teamlogo" alt="profle-image">
        </span>
        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $logo->user_id))
            <a wire:click="open_editteam_logo" style="cursor:pointer;"><span class="Edit-Icon-white EditProfileOne"></span></a>
        @else
        @endif
    </div>
    <div class="modal fade" id="edit_teamlogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Team Logo</h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="">
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="file" id="file" placeholder=" " name="team_logo" wire:click="close_editteam_logo">
                                            <span class="highlight"></span>
                                            <label>Select Team Logo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editteam_logo">Close</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
@else
    <span class="user-profile-imgTeam">
        <img src="{{url('frontend/logo/'.$logo->team_logo)}}" width="100%" class="img-fluid teamlogo" alt="profle-image">
    </span>
@endif
<script>
  window.addEventListener('OpenteamlogoModal', event=> {
     $('#edit_teamlogo').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseteamlogoModal', event=> {
     $('#edit_teamlogo').modal('hide')
  })
</script>
<!-- <script>
	window.livewire.on('filechoosen', () => {
		let file = document.getElementById('file')
		console.log(file);
	})
 </script> -->
@once
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
	$('#file').ijaboCropTool({
		preview : '.teamlogo',
		setRatio:1,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl:'{{ url("edit_teamlogo/".$teamlogo_id) }}',
        withCSRF:['_token','{{ csrf_token() }}'],
	});
</script>
@endonce

</div>
