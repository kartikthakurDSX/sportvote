@include('backend.layouts.header')
@include('backend.layouts.sidebar')
<link rel="stylesheet" href="{{ asset('admin/detail/detail.css') }}">

    <h1 class="heading" style="">{{ $MemberPosition->name }}</h1>

<div class="back position-absolute  end-0" style="">
    <a href="{{ route('member-positions') }}">
        <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

        </i>
    </a>
</div>
<span><b style="font-size: 20px; padding:10px"> Name:</b>
{{$MemberPosition->name}}
</span>
<hr>

<span><b style="font-size: 20px; padding:10px">Description: </b>
{{$MemberPosition->description}}


</span>

<hr>
<span><b style="font-size: 20px; padding:10px">Sports Name: </b>
{{$MemberPosition->sport->name}}


</span>

<hr>

<span><b style="font-size: 20px; padding:10px">Member Type: </b>

 @if ($MemberPosition->member_type==1)
                                 {{'Player/Refree'}}

                                 @endif
                                 @if ($MemberPosition->member_type==2)
                                 {{'Team Admin'}}

                                 @endif
                                 @if ($MemberPosition->member_type==3)
                                 {{'Comp Admin'}}

                                 @endif




<hr>
</span>




@include('backend.layouts.footer')
