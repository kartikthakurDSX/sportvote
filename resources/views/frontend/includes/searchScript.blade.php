<script>
// console.log("boo");
$('form input[name="search"]').on('keyup', function (e) {
    let value = $(this).val();
    $('input.search-field').focus();
    let data = {"_token": "{{ csrf_token() }}", key:value}
    let url = "{{route('search.index')}}";
    if(value){

        $.ajax({
            url: url,
            method: "POST",
            data: data,
            type: 'json',
            success: function(data) {
                if(data.status == 200){
                    let html = '<ul class="drop-list" >';
                    data.result.forEach(element => {
                        // console.log({element});
                        html += '<li><a href="'+element.url+'" target="_blank"><span class="item"><span class="icon people"><img class="img-fluid rounded-circle" src="'+element.profile+'" alt=""></span><span class="text">'+element.name+'<p class="identityTextSearch">'+element.type+'</p></span></span></a></li>'
                    });
                    html += '</ul>';
                    $('#ResultHolderDiv').html(html).removeClass('d-none');
                }else if(data.status == 201){
                    $('#ResultHolderDiv').html('<p><b>No Result Found..</b></p>').removeClass('d-none');
                }else if(data.status != 200){
                    alert(data.message)
                }
                else{
                    alert(JSON.stringify(data))
                }
            }
        });
    }else{
        $('#ResultHolderDiv').html(null).addClass('d-none');
    }
})
</script>
<script type="text/javascript">
  $('#search').click( function(event){

        event.stopPropagation();


        $("#ResultHolderDiv").fadeIn("fast");

      });

      $(document).click( function(){

        $('#ResultHolderDiv').hide();

      });
</script>
<!-- Add script 27-Dec-2022 -->
<script>
    $("#search").focus(function() {
      $('#search').css('width','410px');
      $('#newsearchResult').removeClass('d-none').css('width','400px')
	  $('.site-img').addClass('d-none');
    });
    $("#search").focusout(function() {
      $('#search').css('width','410px');
      setTimeout(hide,500)
	  $('.site-img').removeClass('d-none');
    });
    function hide(){
      $('#search').css('width','200px');
          $('#newsearchResult').addClass('d-none').css('width','0px')
        }
  </script>
  @livewireScripts
