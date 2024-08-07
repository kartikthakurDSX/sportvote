@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">

    <h1 class="heading" style="">{{ $SportLevel->name }}</h1>

<div class="back position-absolute  end-0" style="">
    <a href="{{ route('sports.level') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px"> Name:</b>
{{$SportLevel->name}}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Sports Name: </b>
{{$SportLevel->sport->name}}


</span>

<hr>

<span><b style="font-size: 20px; padding:10px">Description: </b>
{{$SportLevel->description}}


</span>

<hr>









@include('backend.layouts.footer')
