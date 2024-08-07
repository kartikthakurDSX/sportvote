<div class="">
@if(Auth::check())
	<span><img src="{{url('frontend/images/Youtube-icon.png')}}"></span> <span class="AboutStyleUs"> LATEST YOUTUBE
	VIDEOS</span>
	@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
        @if(!empty($video))
        <a wire:click="open_edityoutube_video" style="cursor:pointer;"><span class="Edit-Icon"></span></a>
        @else
		<a wire:click="open_compyoutube_video" style="cursor:pointer;"><span class="fa-plus"> </span></a>
        @endif
	@else 
    @endif
	<p></p>
    <?php 
        if(count($youtubevideo) == 0)
        {
            $height = 50;
        }
        elseif(count($youtubevideo) == 1)
        {
            $height = 240;
        }
        elseif(count($youtubevideo) == 2)
        {
            $height = 240 *2;
        }
        else
        {
            $height = 240 * 3;
        }
    ?>

<div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">
        <div class=" socialHeight " id="style-1" style="height:{{$height}}px !important;">
            @if(count($youtubevideo)!= 0)
                @foreach($youtubevideo as $video)
                <?php
                    $word = "watch?v=";
                    // Check if the string contains the word
                    if(strpos($video->video_link, $word) !== false){
                        $video_link = explode("watch?v=",$video->video_link);
                        $video_id = $video_link[1];
                    
                    } else{
                        $video_link = explode("/",$video->video_link);
                        $video_id = end($video_link);
                    }
                    //echo $video_id;
                
                    ?>
                <div class="d-flex">
                    <iframe width="1280" height="220" src="https://www.youtube.com/embed/{{$video_id}}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @endforeach
            @else 
            <div class="SocalMatchImg">
                No Data found
            </div>
            @endif
        </div>
    </div>
	
	 <div class="modal fade" id="compyoutube_video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Competition Video</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        
                        <div class="row">
                            <div class=" col-md-12 mb-4 FlotingLabelUp">
                                <div class="floating-form ">
                                    <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="textarea" placeholder=" " wire:model="video_link">
                                        <span class="highlight"></span>
                                        <label>Video link</label>
                                    </div>
                                    
                                    @error('video_link') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_compyoutube_video">Close</button>
                    <button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="addcomp_video" >Save</button>
                </div>
            </div>
		</div>
	</div>
    <div class="modal fade" id="editvideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Youtube Videos</h5>
                    <a class="modal-title" style="cursor:pointer;" wire:click="open_compyoutube_video">ADD</a>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12 mb-4 mt-2 FlotingLabelUp">
                                <div class="floating-form ">
                                    <div class="floating-label form-select-fancy-1">
                                        <table>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Video </th>
                                                <th colspan="2">Action</th>
                                            </tr>
                                                @foreach($youtubevideo as $comp_video)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="{{$comp_video->video_link}}"> Watch </a></td>
                                                    <td><a style="cursor:pointer;" wire:click="open_editcompyoutube_video({{ $comp_video->id }})"><i class="icon-edit "></i></a></td>
                                                    <td><a style="cursor:pointer;" wire:click="deletecomp_video({{ $comp_video->id }})" onclick="return confirm('Are you sure you want to delete this Sponsor?')|| event.stopImmediatePropagation()"><i class="icon-trash "></i></a></td>
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
                    <button type="button" class="btn btn-secondary" style="cursor:pointer;" data-dismiss="modal" wire:click="close_edityoutube_video">Close</button>
                </div>
            </div>
		</div>
	</div>
    <div class="modal fade" id="editcompyoutube_video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Competition Video</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class=" col-md-12 mb-4 FlotingLabelUp">
                                <div class="floating-form ">
                                    <div class="floating-label form-select-fancy-1">
                                    <input class="floating-input" type="textarea" placeholder=" " wire:model="video_link">
                                        <span class="highlight"></span>
                                        <label>Video link</label>
                                    </div>
                                    @error('video_link') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_editcompyoutube_video">Close</button>
                    <button type="button" class="btn " style="background-color:#003b5f; color:#fff;" wire:click="editcomp_video" >Save changes</button>
                </div>
            </div>
		</div>
	</div>
@else
<span><img src="{{url('frontend/images/Youtube-icon.png')}}"></span> <span class="AboutStyleUs"> LATEST YOUTUBE
	VIDEOS</span>
    <?php 
        if(count($youtubevideo) == 0)
        {
            $height = 50;
        }
        elseif(count($youtubevideo) == 1)
        {
            $height = 240;
        }
        elseif(count($youtubevideo) == 2)
        {
            $height = 240 *2;
        }
        else
        {
            $height = 240 * 3;
        }
    ?>

<div class="box-outer-lightpink AboutSocalSec Iframe-Radious" id="wrapper">
        <div class=" socialHeight " id="style-1" style="height:{{$height}}px !important;">
            @if(count($youtubevideo)!= 0)
                @foreach($youtubevideo as $video)
                <?php
                    $word = "watch?v=";
                    // Check if the string contains the word
                    if(strpos($video->video_link, $word) !== false){
                        $video_link = explode("watch?v=",$video->video_link);
                        $video_id = $video_link[1];
                    
                    } else{
                        $video_link = explode("/",$video->video_link);
                        $video_id = end($video_link);
                    }
                    //echo $video_id;
                
                    ?>
                <div class="d-flex">
                    <iframe width="1280" height="220" src="https://www.youtube.com/embed/{{$video_id}}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @endforeach
            @else 
            <div class="SocalMatchImg">
                No Data found
            </div>
            @endif
        </div>
    </div>
@endif

<script>
  window.addEventListener('Opencompyoutube_videoModal', event=> {
     $('#compyoutube_video').modal('show')
  })
</script>
<script>
  window.addEventListener('Closecompyoutube_videoModal', event=> {
     $('#compyoutube_video').modal('hide')
  })
</script>
<script>
  window.addEventListener('OpeneditvideoModal', event=> {
     $('#editvideo').modal('show')
  })
</script>
<script>
  window.addEventListener('CloseeditvideoModal', event=> {
     $('#editvideo').modal('hide')
  })
</script>
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