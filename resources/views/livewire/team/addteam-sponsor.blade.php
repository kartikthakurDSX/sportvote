<div class="col-md-3 pl-0 owlone">
    <button class="processed" wire:click="refresh">Refresh</button>
    @if(Auth::check())
        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $team->user_id))
            @if(count($teamsponsers) != 0)
                <a wire:click="open_editteam_sponsor" style="cursor:pointer;"><span class="Edit-Icon"></span></a>
            @else
                <a wire:click="open_add_sponsor" style="cursor:pointer;"><span class="fa-plus"> </span></a>
            @endif
        @else
        @endif

        <div class="text-Middle">
            <div class="container">
                <div class=" owl_2 owl-carousel" wire:ignore>
                    <?php
                        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                            $url = "https://";
                        else
                            $url = "http://";
                        // Append the host(domain name, ip) to the URL.
                        $url .= $_SERVER['HTTP_HOST'];
                        if($teamsponsers->isNotEmpty())
                        {
                            foreach ($teamsponsers as $team_sponser)
                             {
                                if (!empty($team_sponser->sponsor_image)) {
                                    $sponserimage = $url . "/storage/app/public/image/" . $team_sponser->sponsor_image;

                                }
                                else
                                {
                                    $sponserimage = $url ."/public/frontend/images/team-spon-logo.png";
                                }
                                ?>

                                <div class="slides"><img src="{{$sponserimage}}" class="img-fluidD "
                                alt="" /></div>
                        <?php }
                        }
                        else{
                            ?>
                             <div class="slides"><img src="{{url('frontend/images/team-spon-logo.png')}}" class="img-fluidD "
                                alt="" /></div>
                        <?php } ?>
                </div>
            </div>
            <span class="TeamSponSorsComp">OFFICIAL SPONSORS </span>
        </div>


        <div class="modal fade" id="addsponsorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <form wire:submit.prevent="add_sponsor_info" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Sponsor</h5>
                        </div><br>
                        <?php
                        if($sponsor_image ){
                        $valid_image = array();
                            foreach ($sponsor_image as $image)
                            {
                                    $ext = ['jpg','jpeg','png'];
                                    if (!in_array( $image->guessExtension() ,  $ext ) ) {
                                        $load = 1;
                                        array_push($valid_image, $load);
                                    }
                            }} ?>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class=" col-md-12 mb-4 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <input class="floating-input" type="file" accept="image/*" id="image" placeholder=" " wire:model="sponsor_image" multiple>
                                                <div wire:loading wire:target="sponsor_image" wire.ignore>Uploading...</div>
                                                <span class="highlight"></span>
                                                <label>Select Sponsor image</label>
                                            </div>
                                            @error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
                                            @error('sponsor_image.*') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                @if($sponsor_image)
                                    @if(count($valid_image) == 0)
                                        Photo Preview:
                                        <div class="row">
                                            @foreach($sponsor_image as $images)
                                                <div class="col-3 card me-1 mb-1">
                                                    <img src="{{ $images->temporaryUrl() }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                    <span class="text-danger">The sponsor image must be a file of type: jpeg, png, jpg.</span>
                                    @endif
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_add_sponsor">Close</button>
                            @if($sponsor_image)
                            <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;">Save </button>
                            <div wire:loading wire:target="save" wire:ignore>process...</div>
                            @else
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="editteamsponsor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Official Sponsors</h5>
                        <a class="modal-title" style="cursor:pointer;" wire:click="open_add_sponsor">ADD</a>
                    </div>
                    <div class="modal-body offical_community_images" >
                        <div class="">
                            <div class="row">
                                <div class="col-md-12 mb-4 mt-2 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <table>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Image</th>
                                                    <th colspan="2">Delete</th>
                                                </tr>
                                                @foreach($teamsponsers as $team_sponser)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="<?php echo $url . "/storage/app/public/image/" .$team_sponser->sponsor_image;?>" width="100px" class="img-fluid"></td>

                                                    <td>
                                                        <a style="cursor:pointer;" wire:click="deletecompetition_sponsor({{ $team_sponser->id }})" onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i class="icon-trash "></i></a>
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
                                <div class="row">
                                    <div class=" col-md-12 mb-4 FlotingLabelUp">
                                        <div class="floating-form ">
                                            <div class="floating-label form-select-fancy-1">
                                                <input class="floating-input" type="file" id="image" placeholder=" " accept="image/*" wire:model="sponsor_image">
                                                <span class="highlight"></span>
                                                <label>Select Sponsor image</label>
                                            </div>
                                            @error('sponsor_image') <span class="text-danger">{{ $message }}</span> @enderror
                                            @error('sponsor_image.*') <span class="text-danger">{{ $message }}</span> @enderror
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_edit_sponsor">Close</button>
                            <button type="submit" class="btn " style="background-color:#003b5f; color:#fff;">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
    <div class="text-Middle">
            <div class="container">
                <div class=" owl_2 owl-carousel" wire:ignore>
                    <?php
                        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                            $url = "https://";
                        else
                            $url = "http://";
                        // Append the host(domain name, ip) to the URL.
                        $url .= $_SERVER['HTTP_HOST'];
                        if($teamsponsers->isNotEmpty())
                        {
                            foreach ($teamsponsers as $team_sponser)
                             {
                                if (!empty($team_sponser->sponsor_image)) {
                                    $sponserimage = $url . "/storage/app/public/image/" . $team_sponser->sponsor_image;

                                }
                                else
                                {
                                    $sponserimage = $url ."/public/frontend/images/team-spon-logo.png";
                                }
                                ?>

                                <div class="slides"><img src="{{$sponserimage}}" class="img-fluidD "
                                alt="" /></div>
                        <?php }
                        }
                        else{
                            ?>
                             <div class="slides"><img src="{{url('frontend/images/team-spon-logo.png')}}" class="img-fluidD "
                                alt="" /></div>
                        <?php } ?>
                </div>
            </div>
            <span class="TeamSponSorsComp">OFFICIAL SPONSOR </span>
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
        window.addEventListener('OpeneditteamsponsorModal', event => {
            $('#editteamsponsor').modal('show')
        })
    </script>
    <script>
        window.addEventListener('CloseeditteamsponsorModal', event => {
            $('#editteamsponsor').modal('hide')
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
    </div>
