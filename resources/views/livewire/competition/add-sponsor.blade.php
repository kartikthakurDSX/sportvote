<div class="col-md-4 pl-0 ">
@if(Auth::check())
    @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
        @if(count($comp_sponsers) != 0)
        <a wire:click="open_editteam_sponsor" style="cursor:pointer;"><span class="Edit-Icon"></span></a>
        @else
            <a wire:click="open_add_sponsor" style="cursor:pointer;"><span class="fa-plus"> </span></a>
        @endif
    @else
    @endif
    <div class="bg-heinken">
        <div class="text-Middle">
            <?php
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
            else
                $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url .= $_SERVER['HTTP_HOST'];
            ?>
			<div class="container">
				<div class="owl-carousel offical_sponsor" wire:ignore>
					@if($comp_sponsers->isNotEmpty())
						@foreach ($comp_sponsers as $comp_sponser)
							<?php
								$sponserimage = $url . "/storage/app/public/image/" . $comp_sponser->sponsor_image;
							?>
							<div class="slides"><img src="{{$sponserimage}}" class="img-fluidD" alt="" /></div>
						@endforeach
					@else
						<div class="slides"><img src="{{url('frontend/images/team-spon-logo.png')}}" class="img-fluidD" alt="" /></div>
					@endif
				</div>
			</div>

            <span class="TeamSponSorsComp">OFFICIAL SPONSOR</span>
        </div>
    </div>

    <div class="modal fade" id="addsponsorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="add_sponsor_info" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Offical Sponsor</h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="container">
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="file" id="image" placeholder=" " wire:model="sponsor_image" onchange="showPreview(event)" multiple accept="image/*">
                                            <div wire:loading wire:target="sponsor_image" wire.ignore>Uploading...</div>
                                            <span class="highlight"></span>
                                            <label>Select Sponsor image</label>
                                        </div>
										@error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
										@error('sponsor_image.*') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <img id="pre_image" >
                            @if($sponsor_image)
                            Photo Preview:
                                <div class="row">
                                    @foreach ($sponsor_image as $images)
                                        <div class="col-3 card me-1 mb-1">
                                            <img src="{{ $images->temporaryUrl() }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                    @if($sponsor_image)
                        <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;">Save</button>
                    @else
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_add_sponsor">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="editcompponsor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Offical Sponsors</h5>
                    <a class="modal-title" style="cursor:pointer;" wire:click="open_add_sponsor">ADD</a>
                </div>
                <div class="modal-body offical_community_images">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12 mb-4 mt-2 FlotingLabelUp">
                                <div class="floating-form ">
                                    <div class="floating-label form-select-fancy-1">
                                        <table>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Sponsor Image</th>
                                                <th colspan="2">Action</th>
                                            </tr>
                                            @foreach($comp_sponsers as $comp_sponser)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="<?php echo $url . "/storage/app/public/image/" .$comp_sponser->sponsor_image;?>" width="100px" class="img-fluid"></td>
                                                <td>
                                                    <a style="cursor:pointer;" wire:click="deletecompetition_sponsor({{ $comp_sponser->id }})" onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i class="icon-trash "></i></a>
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
                    <button type="button" class="btn btn-secondary" style="cursor:pointer;" data-dismiss="modal" wire:click="close_editteam_sponsor">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editsponsorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="edit_sponsor" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Sponsor </h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="container">
                            <!-- <div class="row">
                                <div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
                                    <div class="floating-form ">
                                        @error('sponsorname') <span class="text-danger">{{ $message }}</span> @enderror
                                        <div class="floating-label form-select-fancy-1">

                                            <input class="floating-input" type="text" placeholder="" wire:model="sponsorname">
                                            <span class="highlight"></span>
                                            <label>Sponsor Name</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        @error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        @error('sponsor_image.*') <span class="text-danger">{{ $message }}</span> @enderror
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="file" id="image" placeholder=" " wire:model="sponsor_image" accept="image/*">
                                            <span class="highlight"></span>
                                            <label>Select Sponsor image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_edit_sponsor">Close</button>
                        <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="bg-heinken">
        <div class="text-Middle">
            <?php
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
            else
                $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url .= $_SERVER['HTTP_HOST'];
            ?>
			<div class="container">
				<div class="owl-carousel offical_sponsor" wire:ignore>
					@if($comp_sponsers->isNotEmpty())
						@foreach ($comp_sponsers as $comp_sponser)
							<?php
								$sponserimage = $url . "/storage/app/public/image/" . $comp_sponser->sponsor_image;
							?>
							<div class="slides"><img src="{{$sponserimage}}" class="img-fluidD" alt="" /></div>
						@endforeach
					@else
						<div class="slides"><img src="{{url('frontend/images/team-spon-logo.png')}}" class="img-fluidD" alt="" /></div>
					@endif
				</div>
			</div>

            <span class="TeamSponSorsComp">OFFICIAL SPONSOR</span>
        </div>
    </div>
@endif


<script>
    window.addEventListener('OpenaddsponserModal', event => {
        $('#addsponsorModal').modal('show')
    })
</script>
<script>
    window.addEventListener('CloseaddsponserModal', event => {
        $('#addsponsorModal').modal('hide')
    })
</script>
<script>
    window.addEventListener('OpeneditcompponsorModal', event => {
        $('#editcompponsor').modal('show')
    })
</script>
<script>
    window.addEventListener('CloseeditcompponsorModal', event => {
        $('#editcompponsor').modal('hide')
    })
</script>
<script>
    window.addEventListener('OpeneditsponserModal', event => {
        $('#editsponsorModal').modal('show')
    })
</script>
<script>
    window.addEventListener('CloseeditsponserModal', event => {
        $('#editsponsorModal').modal('hide')
    })
</script>
<!-- <script>
    window.livewire.on('filechoosen', () => {
        let file = document.getElementById('image')
        console.log(file);
    })
</script> -->
    <script>
        function showImage() {
            return {
                showPreview(event) {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        var preview = document.getElementById("pre_image");
                        preview.src = src;
                        preview.style.display = "block";
                    }
                }
            }
        }
    </script>
</div>
