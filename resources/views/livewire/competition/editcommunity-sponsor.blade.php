<div>
	<span class="float-md-end FootRFix">
			<a class="btn-icon FollowIcoNN-Edit" wire:click="open_editcommunity_sponsor" style="cursor:pointer;"><span class="Edit-Icon"> </span></a>			
	</span>
	<div class="modal fade" id="editcommunitysponsorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <form wire:submit.prevent="editcommunity_sponsor" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Community Sponsor </h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
                                    <div class="floating-form ">
                                    @error('sponsor_name') <span class="text-danger">{{ $message }}</span> @enderror
                                        <div class="floating-label form-select-fancy-1"> 
                                             
                                            <input class="floating-input" type="text" placeholder="" wire:model="sponsor_name">
                                            <span class="highlight"></span>
                                            <label>Community Sponsor Name</label>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                    @error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="file" id="image" placeholder=" " wire:model="sponsor_image">
                                            <span class="highlight"></span>
                                            <label>Select Community Sponsor image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($sponsor_image)
                            Photo Preview:
                                <div class="row">
                                    <div class="col-md-12 card me-1 mb-1">
                                        <img src="{{ $sponsor_image->temporaryUrl() }}">
                                    </div>
                                </div>
                            @else
                            Photo :
                                <div class="row">
                                    <div class="col-md-12 card me-1 mb-1">
                                        <img src="{{asset('storage/app/public/image/'.$sponsorimage)}}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editcommunity_sponsor">Close</button>
                        <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;" >Save changes</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
    <script>
    window.addEventListener('OpeneditcommunitysponserModal', event=> {
        $('#editcommunitysponsorModal').modal('show')
    })
    </script>
    <script>
    window.addEventListener('CloseeditcommunitysponserModal', event=> {
        $('#editcommunitysponsorModal').modal('hide')
    })
    </script>

</div> 