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
                    <h2 class="title">Update Sport Stats</h2>
                    <form method="POST" action="{{ url('admin/sport-stats/'.$sportStat->id.'/update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">

                            <label for="" class="mb-2">Sport Stat Name</label>
                            <input name="name" class="effect-10 rounded" type="text" placeholder="sport stat name"
                                value="{{ $sportStat->name }}">
                            <span class="focus-bg"></span>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif

                        <div class="col-12">
                            <div class="input-groups">
                                <label for="" class="mb-2 mt-2">Description</label>
                                <textarea name="description" placeholder="Description..">{{ $sportStat->description }}</textarea>

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
                                        <option value="{{ $sport->id }}"
                                            @if ($sportStat->sport_id == $sport->id) {{ 'selected' }} @endif>
                                            {{ $sport->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                        </div>
                        @if ($errors->has('sport_id'))
                            <span class="text-danger text-left">{{ $errors->first('sport_id') }}</span>
                        @endif
                        <div class="col-12 mt-3">

                            <div class="select">
                                <label for="" class="mb-2">Stat Type</label>
                                <select name="stat_type" class="rounded" id="standard-select">

                                    <option value="0" @if ($sportStat->stat_type == 0) {{ 'selected' }} @endif>
                                        Both</option>
                                    <option value="1"
                                        @if ($sportStat->stat_type == 1) {{ 'selected' }} @endif>Basic</option>
                                    <option value="2"
                                        @if ($sportStat->stat_type == 2) {{ 'selected' }} @endif>Detailed</option>



                                </select>

                            </div>
                        </div>
                        @if ($errors->has('stat_type'))
                            <span class="text-danger text-left">{{ $errors->first('stat_type') }}</span>
                        @endif
                        <div class="col-12 mt-3">

                            <div class="select">
                                <label for="" class="mb-2">Is Calculated</label>
                                <select name="is_calc" class="rounded" id="standard-select">

                                    <option value="0"@if ($sportStat->is_calculated == 0) {{ 'selected' }} @endif>
                                        No</option>
                                    <option value="1"
                                        @if ($sportStat->is_calculated == 1) {{ 'selected' }} @endif>Yes</option>




                                </select>

                            </div>
                        </div>
                        @if ($errors->has('is_calc'))
                            <span class="text-danger text-left">{{ $errors->first('is_calc') }}</span>
                        @endif

                        <div class="col-12 mt-3">

                            <div class="select">
                                <label for="" class="mb-2">Calculation type</label>
                                <select name="calc_type" class="rounded" id="standard-select">

                                    <option value="1"
                                        @if ($sportStat->calc_type == 1) {{ 'selected' }} @endif>Positive</option>
                                    <option value="2"
                                        @if ($sportStat->calc_type == 2) {{ 'selected' }} @endif>Negative</option>
                                    <option value="3"
                                        @if ($sportStat->calc_type == 3) {{ 'selected' }} @endif>Percentage
                                    </option>




                                </select>

                            </div>
                        </div>
                        @if ($errors->has('calc_type'))
                            <span class="text-danger text-left">{{ $errors->first('calc_type') }}</span>
                        @endif
                        <div class="col-12 mt-3">

                            <div class="select">
                                <label for="" class="mb-2">Must Track</label>
                                <select name="must_track" class="rounded" id="standard-select">

                                    <option value="0"
                                        @if ($sportStat->must_track == 0) {{ 'selected' }} @endif>No</option>
                                    <option value="1"
                                        @if ($sportStat->must_track == 1) {{ 'selected' }} @endif>Yes</option>




                                </select>

                            </div>
                        </div>
                        @if ($errors->has('must_track'))
                            <span class="text-danger text-left">{{ $errors->first('must_track') }}</span>
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




{{--               --}}
