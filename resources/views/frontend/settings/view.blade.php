
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
				<h1><span></span> <strong>Coming Soon..</strong></h1>
			</div>
		</div>
	</div>
</div>
<main id="main">

</main>

</br></br></br></br></br></br>
    @include('frontend.includes.footer')

       <script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	   @include('frontend.includes.searchScript')
</body>

</html>


