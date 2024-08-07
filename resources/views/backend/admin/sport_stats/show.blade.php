@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">

    <h1 class="heading" style="">{{ $sportStat->name }}</h1>

<div class="back position-absolute  end-0" style="">
    <a href="{{ route('sport.stats') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px"> Name:</b>
{{$sportStat->name}}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Description: </b>
{{$sportStat->description}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Sport Name: </b>
{{$sportStat->sport->name}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Stat Type: </b>
@if ($sportStat->stat_type == 0)
                                    {{ 'Both' }}
                                @elseif ($sportStat->stat_type == 1)
                                    {{ 'Basic' }}
                                @else
                                    {{ 'Detailed' }}
                                @endif


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Is Calculated: </b>
@if($sportStat->is_calc==0)

{{'No'}}

@else

{{'Yes'}}

@endif


</span>

<hr>

@include('backend.layouts.footer')
