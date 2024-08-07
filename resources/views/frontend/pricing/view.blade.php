
@include('frontend.includes.header')

<div class="header-bottom">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><span></span> <strong>Coming Soon...</strong></h1>
			</div>
		</div>
	</div>
</div>
<main id="main">

</main>

</br></br></br></br></br></br>
    @include('frontend.includes.footer')

     <script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
        <script src="{{ url('frontend/js/typeahead.js') }}" defer async></script>

        <script>
            $(document).on('click', '#top_comp', function() {
                var comp_id = $(this).data('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('public_top_performer') }}",
                    type: 'post',
                    data: {
                        comp_id: comp_id
                    },
                    error: function() {
                        alert('Something is Wrong');
                    },
                    success: function(data) {

                        $('.comp_top_performer_list').html(data);

                    }
                });
            })
        </script>
        @include('frontend.includes.searchScript')
</body>


</html>



