@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">




<h1 class="heading" style="">{{ $CompReportType->name }}</h1>


<div class="back position-absolute  end-0" style="">
    <a href="{{ route('com-report-type') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px">Sport Name:</b>
    {{ $CompReportType->sport->name }}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Sport Stats: </b>

    @php
        $values = explode(',', $CompReportType->sport_stats_id);

    @endphp

    @foreach ($values as $value)
        @foreach ($sportstats as $sportStat)
            @if ($value == $sportStat->id)
                {{ $sportStat->name . ',' }}
            @endif
        @endforeach
    @endforeach

</span>

<hr>




@include('backend.layouts.footer')
