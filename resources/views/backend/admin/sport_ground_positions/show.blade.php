@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">

    <h1 class="heading" style="">{{ $SportGroundPosition->name }}</h1>

<div class="back position-absolute  end-0" style="">
    <a href="{{ route('sport-ground-positions') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px"> Name:</b>
{{$SportGroundPosition->name}}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Description: </b>
{{$SportGroundPosition->description}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Sport Ground Map Name: </b>
{{$SportGroundPosition->SportGroundMap->name}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Ground Coordinates: </b>


{{$SportGroundPosition->ground_coordinates}}
</span>

<hr>







@include('backend.layouts.footer')
