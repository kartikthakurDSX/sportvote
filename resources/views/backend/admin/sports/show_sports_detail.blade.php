@include('backend.layouts.header')
        @include('backend.layouts.sidebar')
        <link rel="stylesheet" href="{{asset('admin/detail/detail.css')}}">
        <div>
          <h1  class="heading" style="">{{$sport->name}}</h1>
        </div>
        <div class="back" style="">
          <a href="{{route('admin.show.sports')}}">
            <i class="fa-solid fa-circle-arrow-left" style="font-size: 30px; color:aquamarine;background:none">

            </i>
          </a>
        </div>

          <div class="d-flex justify-content-center icon" style="">
            <img src="{{asset('admin/sports/images/'.$sport->icon)}}" alt="">

          </div>
          <div style="margin: auto; margin-top:10px;">
            <h3 class="heading" style="">{{$sport->name}}</h3>
          </div>

          <div class="desc" style="">
            <h2>Description</h2>
            <textarea name="" id="" cols="110" rows="10" disabled style="" class="textarea">{{$sport->description}}</textarea>
          </div>


            @include('backend.layouts.footer')
