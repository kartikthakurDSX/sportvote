<div>
    <a wire:click="open_editcompyoutube_video"><span class="Edit-Icon"></span></a>
    <div class="modal fade" id="editcompyoutube_video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Competition Video</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
                                <div class="floating-form ">
                                @error('video_title') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="text" placeholder=" " wire:model="video_title">
                                        <span class="highlight"></span>
                                        <label>Video Title</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12 mb-4 FlotingLabelUp">
                                <div class="floating-form ">
                                @error('video_description') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="textarea" placeholder=" " wire:model="video_description">
                                        <span class="highlight"></span>
                                        <label>Video Description</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12 mb-4 FlotingLabelUp">
                                <div class="floating-form ">
                                @error('video_link') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="textarea" placeholder=" " wire:model="video_link">
                                        <span class="highlight"></span>
                                        <label>Video link</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editcompyoutube_video">Close</button>
                    <button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="editcompyoutube_video" >Save changes</button>
                </div>
            </div>
		</div>
	</div>
    <script>
    window.addEventListener('Openeditcompyoutube_videoModal', event=> {
        $('#editcompyoutube_video').modal('show')
    })
    </script>
    <script>
    window.addEventListener('Closeeditcompyoutube_videoModal', event=> {
        $('#editcompyoutube_video').modal('hide')
    })
    </script>
</div>
