<div >
	{{-- wire:poll.750ms --}}
	<button class="processed" wire:click="refresh">Refresh</button>
@if(Auth::check())
		<?php
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
				$url = "https://";
			else
				$url = "http://";
			// Append the host(domain name, ip) to the URL.
			$url.= $_SERVER['HTTP_HOST'];

		if(!empty($competition->comp_banner)){
			$banerimage = $url."/public/frontend/banner/".$competition->comp_banner;
		}
		else{
			$banerimage = $url."/public/frontend/images/competition-bg.png";
		}
		?>
		<div class="header-bottom header-bottomTeamPub dashboard" style="background-image: url('{{$banerimage}}');">
			<div class="container-fluid bh-WhiteTsp">
				<div class="container-lg">
					<div class="row">
						<div class="col-sm-2 col-4">
						</div>
						<div class="col-sm-10 col-8 LineHSpace pt-3 pb-3" style="padding-left: 90px;" >
							<?php
							$competitionname = explode(" ", $competition->name);
							?>
							<span class="FCBarcelona"><strong class="FCStyle"><?php echo array_shift($competitionname); ?></strong>&nbsp;<?php echo implode(" ", $competitionname); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	@if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
	<a wire:click="open_edit_banner" style="cursor:pointer;"><span class="Edit-Icon-Banner HeroImgEditTop"> </span></a>
	@else
	@endif
	<div class="modal fade" id="edit_banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Competition banner</h5>
				</div>
				<div class="modal-body"><br>
					<div class="">
						<div class="row">
							<div class=" col-md-12 mb-4 FlotingLabelUp">
								<div class="floating-form ">
									<div class="floating-label form-select-fancy-1">
										<input class="floating-input" type="file" id="comp_banner" placeholder=" " name="comp_banner" wire:click="close_edit_banner">
											<span class="highlight"></span>
											<label>Select Competition banner</label>
									</div>
								</div>
							</div>
							@if($banner)
								Photo Preview:
								<div class="row">
									<div class="col-md-12 card me-1 mb-1">
										<img src="{{ $banner->temporaryUrl() }}">
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close_edit_banner">Close</button>
					@if($banner)
						<button type="submit" class="btn " style="background-color:#003b5f; color:#fff;">Save changes</button>
					@else
					@endif
				</div>
			</div>
		</div>
	</div>
@else
<?php
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
			$url = "https://";
		}else{
			$url = "http://";
		}
			// Append the host(domain name, ip) to the URL.
			$url.= $_SERVER['HTTP_HOST'];
		if(!empty($competition->comp_banner)){
			$banerimage = $url."/frontend/banner/".$competition->comp_banner;

		}
		else{
			$banerimage = $url."/frontend/images/competition-bg.png";

		}
		?>
		<div class="header-bottom header-bottomTeamPub dashboard" style="background-image: url('{{$banerimage}}');">
			<div class="container-fluid bh-WhiteTsp">
				<div class="container-lg">
					<div class="row">
						<div class="col-sm-2 col-4">
						</div>
						<div class="col-sm-10 col-8 LineHSpace pt-3 pb-3">
							<?php
							$competitionname = explode(" ", $competition->name);
							?>
							<span class="FCBarcelona"><strong class="FCStyle"><?php echo array_shift($competitionname); ?></strong>&nbsp;<?php echo implode(" ", $competitionname); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
@endif
<script>
  window.addEventListener('OpenbannerModal', event=> {
     $('#edit_banner').modal('show');
  });
</script>
<script>
  window.addEventListener('ClosebannerModal', event=> {
     $('#edit_banner').modal('hide');
  });
</script>
<script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
<script>
	$('#comp_banner').ijaboCropTool({
		preview : '',
		setRatio:3,
		allowedExtensions: ['jpg', 'jpeg','png'],
		buttonsText:['CROP & SAVE','QUIT'],
		buttonsColor:['#30bf7d','#ee5155', -15],
		processUrl:'{{ url("edit_compbanner/".$competition_id) }}',
        withCSRF:['_token','{{ csrf_token() }}'],
		 onSuccess:function(message, element, status){
			//location.reload();
		},
		onError:function(message, element, status){
		    //alert(message);
		}
	});
</script>

</div>
