@include('frontend.includes.header')

<div class="header-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span>Invite <strong>Team</strong></h1>
				</div>
			</div>
		</div>
	</div>
	

  <main id="main">
  <form method="post" id="upload_form" enctype="multipart/form-data"> 
    <input type="hidden" id="team_number" value="{{$competition->team_number}}">
    <input type="hidden" id="competition_id" value="{{$competition->id}}">
      <div class="container">
        <div class="row"  id="invite_team">
        
            
        </div>
      </div>
      </form>
	</main>

	@include('frontend.includes.footer')

</body>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- <script>
  $(document).ready(function(){
    var team_number = $('#team_number').val();
    var competition_id = $('#competition_id').val();
    html = '<div class="col-sm-12"><h1>Add Team</h1></div><hr>';
	  for(i=1; i<=team_number; i++)
	 	{
		html += ('<div class=" col-sm-6 col-xs-6"><div class="radio-competion-type"> <input class="typeahead form-control" type="text" placeholder="Team '+i+'" name="team_id[]"></div></div>');
		}
		
		$('#invite_team').html(html+'<div class="col-sm-12 p-3"><span id="result"></span><button class="btn col-2 btn-submit float-md-end" type="submit" id="send_invitation">Send</button></div>');
		
			var path = "{{ url('autosearch_team') }}";
			$('input.typeahead').typeahead({
				
			// 	afterSelect: function(item) {
			// 	// this.$element[0].name = item.name;
			// 	// this.$element[0].value = item.id;
			// 	// var team_id =  item.id;
				
			// 	// $("#result").append('<input type="hidden" name="team_id[]" value="'+team_id+'" id="team_id"> <input type="hidden" name="competition_id" value="'+competition_id+'">');
			// },

			// 	source:  function (query, process) {
			// 	return $.get(path, { query: query }, function (data) {
			// 			// return process(data);
			// 			return {
            //                 name: data.name,
            //                 id: data.id
            //             }
			// 		});
			// 	}
		
			
			});	
		
  });

</script> -->


<script>
  $(document).ready(function(){
    var team_number = $('#team_number').val();
    var competition_id = $('#competition_id').val();
    html = '<div class="col-sm-12"><h1>Add Team</h1></div><hr>';
	  for(i=1; i<=team_number; i++)
	 	{
		html += ('<div class=" col-sm-6 col-xs-6"><div class="radio-competion-type"> <select class="grey-form-control typeahead_team" name="team_id[]" ></select> </div></div>');
		}
		
		$('#invite_team').html(html+'<div class="col-sm-12 p-3"><input type="hidden" name="competition_id" value="'+competition_id+'"><button class="btn col-2 btn-submit float-md-end" type="submit" id="send_invitation">Send</button></div>');
		
		$('.typeahead_team').select2({
        placeholder: 'Select Players',
        ajax: {
            url: "{{ url('autosearch_team') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
           

            cache: true
        }
    });
		
  });

</script>



<script>
 $(document).on('click','#send_invitation', function(event){
        event.preventDefault();
        var data = $('#upload_form').serialize();
		var team_number = $('#team_number').val();
        // alert(data);
        $.ajax({
          headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
          url:"{{ url('send_comp_invitation') }}",
          method:"POST",
          data:data,
         
          success:function(data)
          {
			  if(data == 1)
			  {
				location.href ="{{url('my_competition')}}";
			  }
			  else if(data == 0)
			  {
				  alert('Please select other team');
			  }
			  else if(data == "already")
			  {
				  alert('The Player is already selected');
			  }
            
          }
        });
});
</script>
@include('frontend.includes.searchScript')
</html>
