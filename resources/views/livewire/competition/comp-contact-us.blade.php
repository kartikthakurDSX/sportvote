<span>
@if($comp_email) <p class="TextSocalInner"><b>Email:</b>  {{$comp_email}} </p> @else <p class="TextSocalInner DefaultClorText"> <b>Email:</b> default@domain.com </p>@endif
@if($comp_phone_number)   <p class="TextSocalInner"><b>Mobile:</b>  {{$comp_phone_number}} </p> @else  <p class="TextSocalInner DefaultClorText"> <b>Mobile:</b> 76XX1XXX78 </p> @endif
@if($comp_address)  <p class="TextSocalInner "><b>Address:</b>  {{$comp_address}} </p> @else  <p class="TextSocalInner DefaultClorText"> <b>Address:</b>  Plot No. XXX Near abc office, Country. </p> @endif
</span>
