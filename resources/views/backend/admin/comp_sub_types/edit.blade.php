@include('backend.includes.loginheader')
@include('backend.includes.nav')
@include('backend.includes.sidebar')

<a href="{{ url()->previous() }}" class="h4 text-primary" style="margin-left: 20%;"><i class="fa-solid fa-circle-left text-info"></i></a>

<div class="content-wrapper">

<div class="page-wrapper   p-b-100 font-robo " style="margin-top:50px;">
    <div class="wrapper wrapper--w680">
        <div class="card card-1">
            <div class="card-body">
                <h2 class="title">Update Competition Sub-Type</h2>
                <form method="POST" action="{{url('admin/comp-sub-type/'.$competitionSubType->id.'/update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <label for="" class="mb-2">Competition Sub Type</label>
                        <input name="name" class="effect-10 rounded" type="text" placeholder="Competition sub type" value="{{$competitionSubType->name}}">
                        <span class="focus-bg"></span>
                    </div>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                    <div class="col-12">
                        <div class="input-groups">
                        <label for="" class="mt-2">Description</label>
                        <textarea name="description" placeholder="Description..">{{$competitionSubType->description}}</textarea>

                        @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                    </div>
                    </div>

<div class="col-12">
     <label for="" class="mt-1">Select Competition Type</label>

                        <div class="select">
                            <select name="competition_type_id" class="rounded" id="standard-select">
                                <option>Select Comp Type</option>
                                @foreach ($compTypes as $compType)
                                    <option value="{{ $compType->id }}" @if ($competitionSubType->competition_type_id==$compType->id)
                                        {{'selected'}}

                                    @endif>{{ $compType->name }}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    @if ($errors->has('competition_type_id'))
                        <span class="text-danger text-left">{{ $errors->first('competition_type_id') }}</span>
                    @endif

                     @php
                            $team_number = explode('-', $competitionSubType->team_number);
                        @endphp

                    <div class="col-12 mt-3">
                        <label for="" class="mt-1">Minimum Team to Play</label>

                        <input name="min_number" class="effect-10 rounded" type="number" placeholder="Minimum Team" value="{{$team_number[0]}}">
                        <span class="focus-bg"></span>
                    </div>
                    @if ($errors->has('min_number'))
                        <span class="text-danger text-left">{{ $errors->first('min_number') }}</span>
                    @endif
                    <div class="col-12 mt-3">
                        <label for="" class="mt-1">Maximum Team to Play</label>
                        <input name="max_number" class="effect-10 rounded" type="number" placeholder="Maximum Team" value="{{$team_number[1]}}">
                        <span class="focus-bg"></span>
                    </div>
                    @if ($errors->has('max_number'))
                        <span class="text-danger text-left">{{ $errors->first('max_number') }}</span>
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

@include('backend.includes.footer')




{{--               --}}

<script>
    (function ($) {
    'use strict';
    /*==================================================================
        [ Daterangepicker ]*/
    try {
        $('.js-datepicker').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": false,
            locale: {
                format: 'DD/MM/YYYY'
            },
        });

        var myCalendar = $('.js-datepicker');
        var isClick = 0;

        $(window).on('click',function(){
            isClick = 0;
        });

        $(myCalendar).on('apply.daterangepicker',function(ev, picker){
            isClick = 0;
            $(this).val(picker.startDate.format('DD/MM/YYYY'));

        });

        $('.js-btn-calendar').on('click',function(e){
            e.stopPropagation();

            if(isClick === 1) isClick = 0;
            else if(isClick === 0) isClick = 1;

            if (isClick === 1) {
                myCalendar.focus();
            }
        });

        $(myCalendar).on('click',function(e){
            e.stopPropagation();
            isClick = 1;
        });

        $('.daterangepicker').on('click',function(e){
            e.stopPropagation();
        });


    } catch(er) {console.log(er);}
    /*[ Select 2 Config ]
        ===========================================================*/

    try {
        var selectSimple = $('.js-select-simple');

        selectSimple.each(function () {
            var that = $(this);
            var selectBox = that.find('select');
            var selectDropdown = that.find('.select-dropdown');
            selectBox.select2({
                dropdownParent: selectDropdown
            });
        });

    } catch (err) {
        console.log(err);
    }


})(jQuery);
</script>


