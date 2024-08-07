<div>
	@if(Auth::check())
		<div class="">
			<span><img src="{{asset('frontend/images')}}/aboutStar-icon.png"></span> <span class="AboutStyleUs"> ABOUT US</span>
			@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
				<a wire:click="edit_comp_desc" style="cursor:pointer;"><span class="Edit-Icon"> </span></a>
			@else
			@endif
			<div class="about_us_height">
				<div class="TextSocalInner">@if($competition->description) {!! $competition->description !!} @else -- @endif</div>
			</div>
		</div>
		<div class="modal fade" id="editdescModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit Description</h5>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row mb-4 mt-4">
								<div wire:ignore>
									<livewire:trix :value="$body">
								</div>
								@if($is_save == 0)
								<span class="sv_error"> {{$msg}} </span>
								@else
								@endif
							</div>
						</div>
					</div>
				<div class="modal-footer">
					@if($is_save == 1)
						<button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="save">Save </button>
					@else
						<span type="button" class="btn" style="background-color:#c7e2f3; color:#fff;"> Save </span>
					@endif

					<button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closemodal">Close</button>

				</div>
				</div>
			</div>
		</div>
	@else
	<div class="">
		<span><img src="{{asset('frontend/images')}}/aboutStar-icon.png"></span> <span class="AboutStyleUs"> ABOUT US</span>
		<div class="about_us_height">
			<div class="TextSocalInner">@if($competition->description) {!! $competition->description !!} @else -- @endif</div>
		</div>
	</div>
	@endif

<script>
  window.addEventListener('OpendescModal', event=> {
     $('#editdescModal').modal('show')
  })
</script>
<script>
  window.addEventListener('ClosedescModal', event=> {
     $('#editdescModal').modal('hide')
  })
</script>

</div>
