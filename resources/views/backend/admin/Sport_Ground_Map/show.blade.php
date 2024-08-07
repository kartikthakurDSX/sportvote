@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">

    <h1 class="heading" style="">{{ $SportGroundMap->name }}</h1>

<div class="back position-absolute  end-0" style="">
    <a href="{{ route('sport-ground-map') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px"> Name:</b>
{{$SportGroundMap->name}}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Description: </b>
{{$SportGroundMap->description}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Sport Name: </b>
{{$SportGroundMap->sport->name}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Number of Positions: </b>


{{$SportGroundMap->number_of_positions}}
</span>

<hr>







@include('backend.layouts.footer')
