@include('backend.includes.loginheader')
@include('backend.includes.nav')
@include('backend.includes.sidebar')

<a href="{{ url()->previous() }}" class="h4 text-primary" style="margin-left: 20%;"><i class="fa-solid fa-circle-left text-info"></i></a>
<div class="content-wrapper">

    <div class="page-wrapper   p-b-100 font-robo " style="margin-top:50px;">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading2"></div>
                <div class="card-body">
                    <h2 class="title">Update Ground Map</h2>
                    <form method="POST" action="{{url('admin/sport-ground-map/'.$SportGroundMap->id.'/update')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">

                            <label for="" class="mb-2 mt-2">Sport Ground Map Name</label>
                            <input name="name" class="effect-10 rounded" type="text"
                                placeholder="Competition type" value="{{$SportGroundMap->name}}">
                            <span class="focus-bg"></span>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif

                        <div class="col-12">

                            <div class="input-groups">

                                <label for="" class="mb-2 mt-2">Description</label>
                                <textarea name="description" placeholder="Description..">{{$SportGroundMap->description}}</textarea>

                                @if ($errors->has('description'))
                                    <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">

                            <div class="select">
                                <label for="" class="mb-2 mt-2">Select Sport</label>
                                <select name="sport_id" class="rounded" id="standard-select">

                                    @foreach ($sports as $sport)
                                        <option value="{{ $sport->id }}" @if ($SportGroundMap->sports_id==$sport->id)
                                            {{'selected'}}

                                        @endif>{{ $sport->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                        </div>
                        @if ($errors->has('sport_id'))
                            <span class="text-danger text-left">{{ $errors->first('sport_id') }}</span>
                        @endif
                        <div class="col-12 mt-3">


                            <label for="" class="mb-2 ">No. of Positions</label>
                            <input name="number_of_positions" class="effect-10 rounded" type="text"
                                placeholder="number of posititons" value="{{$SportGroundMap->number_of_positions}}">
                            <span class="focus-bg"></span>

                        @if ($errors->has('number_of_positions'))
                            <span class="text-danger text-left">{{ $errors->first('number_of_positions') }}</span>
                        @endif
                </div>
                @if ($errors->has('sport_id'))
                    <span class="text-danger text-left">{{ $errors->first('sport_id') }}</span>
                @endif






                <div class="mt-3">
                    <button class="btn btn--radius btn--green" type="submit" name="submit">Update</button>
                </div>


                </form>
            </div>
            </div>
        </div>
    </div>
</div>





<!-- Jquery JS-->
<script src="{{ asset('backend/sportsForm/vendor/jquery/jquery.min.js') }}"></script>
<!-- Vendor JS-->
<script src="{{ asset('backend/sportsForm/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/sportsForm/vendor/datepicker/moment.min.js') }}"></script>
<script src="{{ asset('backend/sportsForm/vendor/datepicker/daterangepicker.js') }}"></script>

<!-- Main JS-->
<script src="{{ asset('backend/sportsForm/js/global.js') }}"></script>

@include('backend.includes.footer')




{{-- --}}
