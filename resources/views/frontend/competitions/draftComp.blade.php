
@include('frontend.includes.header')
<Style>
@media (min-width: 576px){
	.modal-dialog {
    max-width: 1140px !important;
    margin: 1.75rem auto;
}
}

</style>
<div class="header-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span> Create a New <strong>Competition</strong></h1>
			</div>
		</div>
	</div>
</div>
<main id="main" class="CreateTeam">
	<div class="container ScrollFix">
    @livewire('edit-draft-comp', ['drftcomp_id' => $drftcomp_id])
       @livewireScripts
	</div>
</main>

</br></br></br></br></br></br>
    @include('frontend.includes.footer')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoUlY6Z_Bz7vDJ9pWbqlmORrDbJ8F0W9o&libraries=places"></script>

<script src="{{url('frontend/js/jquery-3.3.1.min.js')}}"></script>
 <script src="{{url('frontend/js/jquery-migrate-3.0.1.min.js')}}"></script>
 <script src="{{url('frontend/js/jquery.easing.1.3.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!--<script src="js/jquery-ui.js"></script>
 
  
    <script src="js/aos.js"></script>
   <script src="js/script.js"></script> <script src="js/popper.min.js"></script>  
   Vendor JS Files -->

  <script src="{{url('frontend/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{url('frontend/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>


   <script src="{{url('frontend/js/script.js')}}"></script>

<script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
  <script src="{{url('frontend/js/main.js')}}"></script>

@include('frontend.includes.searchScript')
</body>

</html>
