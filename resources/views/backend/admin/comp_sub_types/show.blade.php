@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">

    <h1 class="heading" style="">{{ $CompSubType->name }}</h1>

<div class="back position-absolute  end-0" style="">
    <a href="{{ route('admin.show.competition-sub-type') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px"> Name:</b>
{{$CompSubType->name}}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Description: </b>
{{$CompSubType->description}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Competition Type: </b>
{{$CompSubType->CompTypes->name}}


</span>

<hr>

<span><b style="font-size: 20px; padding:10px">Minimum Team: </b>
    @php
        $value   = explode('-', $CompSubType->team_number);

    @endphp
{{$value[0]}}

<b style="font-size: 20px; padding:10px">Maximum Team: </b>
{{$value[1]}}

<hr>
</span>




@include('backend.layouts.footer')
