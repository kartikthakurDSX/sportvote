<div class="" >
@if(Auth::check())
	<span><img src="{{url('frontend/images/hrt-icon.png')}}"></span>
    <span class="AboutStyleUs"> {{$SponsorHeading}}</span>
	@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $comp->user_id))
        @if(count($comp_sponsers) !=0 )
        <a class="btn-icon" wire:click="open_edit_sponsor" style="cursor:pointer;"><span class="Edit-Icon"> </span></a>
        @else
			<a wire:click="open_addcommunity_sponsor" style="cursor:pointer;"><span class="fa-plus"> </span></a>
        @endif
	@else
	@endif
    <div class="owlSPONSORS owl-carousel owl-theme CommunitySPONSORS">
        @if($comp_sponsers->isNotEmpty())
            @foreach($comp_sponsers as $comp_spo)
                <?php
                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $url = "https://";
                else
                    $url = "http://";
                // Append the host(domain name, ip) to the URL.
                $url .= $_SERVER['HTTP_HOST'];
                $sponserimage[] = $url . "/storage/app/public/image/" . $comp_spo->sponsor_image;
                ?>
            @endforeach
            <?php $community_sponsors = array_chunk($sponserimage,6);?>
            @foreach($community_sponsors as $comp_spons)
                <div class="item">
                    <div class="CommunitySponsors logosCommunuty">
                        <div class="width-Logo100">
                            <div class="row  mt-1">
                                @foreach($comp_spons as $images)
                                    <div class="w-33   VerticalCenter  text-center ">
                                        <div class="LogoHeight70  p-1 ">
                                        <img src="{{$images}}" class="img-fluid img-fludeLogo " alt="Community Sponsors">
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



	<div class="modal fade" id="addcommunitySponsor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <form wire:submit.prevent="add_communitysponsor_info" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Community Sponsor</h5>
                    </div>
                    <div class="modal-body"><br>
                        <div class="container">
                            <!-- <div class="row">
                                <div class=" col-md-12 mb-4 mt-2 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="text" placeholder=" " wire:model="sponsor_name">
                                            <span class="highlight"></span>
                                            <label>Sponsor Name</label>
                                        </div>
										@error('sponsor_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                        <input class="floating-input" type="file" id="image" placeholder=" " wire:model="sponsor_image" multiple>
                                        <div wire:loading wire:target="sponsor_image" wire.ignore>Uploading...</div>
                                            <span class="highlight"></span>
                                            <label>Select Sponsor image</label>
                                        </div>
										@error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
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
                    @if ($sponsor_image)
                        <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;" >Save</button>
                        <div wire:loading wire:target="save" wire:ignore>process...</div>
                    @else
                    @endif
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_addcommunity_sponsor">Close</button>

                    </div>
                </div>
            </form>
		</div>
	</div>
    <div class="modal fade" id="editcommunitysponsor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Community Sponsors</h5>
                    <a class="modal-title" style="cursor:pointer;" wire:click="open_addcommunity_sponsor">ADD</a>
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
                                                    <td>
                                                        <img src="<?php echo $url . "/storage/app/public/image/" .$comp_sponser->sponsor_image;?>" width="100px" class="img-fluid">
                                                    </td>
                                                    <td>
                                                        <a style="cursor:pointer;" wire:click="deletecommunity_sponsor({{ $comp_sponser->id }})" onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i class="icon-trash "></i></a>
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
                    <button type="button" class="btn btn-secondary" style="cursor:pointer;" data-dismiss="modal" wire:click="close_edit_sponsor">Close</button>
                </div>
            </div>
		</div>
	</div>
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
                                <div class=" col-md-12 mb-4 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <input class="floating-input" type="file" id="image" placeholder=" " wire:model="sponsor_image">
                                            <span class="highlight"></span>
                                            <label>Select Sponsor image</label>
                                        </div>
										@error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;" >Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editcommunity_sponsor">Close</button>

                    </div>
                </div>
            </form>
		</div>
	</div>
@else
<span><img src="{{url('frontend/images/hrt-icon.png')}}"></span>
    <span class="AboutStyleUs"> {{$SponsorHeading}}</span>
    <div class="owlSPONSORS owl-carousel owl-theme CommunitySPONSORS" wire:ignore>
        @if($comp_sponsers->isNotEmpty())
            @foreach($comp_sponsers as $comp_spo)
                <?php
                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $url = "https://";
                else
                    $url = "http://";
                // Append the host(domain name, ip) to the URL.
                $url .= $_SERVER['HTTP_HOST'];
                $sponserimage[] = $url . "/storage/app/public/image/" . $comp_spo->sponsor_image;
                ?>
            @endforeach
            <?php $community_sponsors = array_chunk($sponserimage,6);?>
            @foreach($community_sponsors as $comp_spons)
                <div class="item">
                    <div class="CommunitySponsors logosCommunuty">
                        <div class="width-Logo100">
                            <div class="row  mt-1">
                                @foreach($comp_spons as $images)
                                    <div class="w-33   VerticalCenter  text-center ">
                                        <div class="LogoHeight70  p-1 ">
                                        <img src="{{$images}}" class="img-fluid img-fludeLogo " alt="Community Sponsors">
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
  window.addEventListener('OpenaddcommunitysponserModal', event=> {
     $('#addcommunitySponsor').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseaddcommunitysponserModal', event=> {
     $('#addcommunitySponsor').modal('hide')
  })
</script>
<script>
  window.addEventListener('OpeneditcommunitysponsorModal', event=> {
     $('#editcommunitysponsor').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseeditcommunitysponsorModal', event=> {
     $('#editcommunitysponsor').modal('hide')
  })
</script>
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
<!-- <script>
	window.livewire.on('filechoosen', () => {
		let file = document.getElementById('image')
		console.log(file);
	})
 </script> -->

 </div>
