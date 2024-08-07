@include('backend.includes.loginheader')
@include('backend.includes.nav')
@include('backend.includes.sidebar')
<link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" />

<a href="{{ url()->previous() }}" class="h4 text-primary" style="margin-left: 20%;"><i class="fa-solid fa-circle-left text-info"></i></a>

<div class="content-wrapper">

    <div class="page-wrapper   p-b-100 font-robo " style="margin-top:50px;">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading2"></div>
                <div class="card-body">
                    <h2 class="title">Update Competition Report Type</h2>
                    <form method="POST" action="{{ url('admin/comp-report-type/'.$CompReportType->id.'/update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">

                            <label for="" class="mb-2">Comp Report Type Name</label>
                            <input name="name" class="effect-10 rounded border border-secondary form-control-lg p-1" type="text"
                                placeholder="Competition Report type" value="{{ $CompReportType->name }}">
                            <span class="focus-bg"></span>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                        <div class="col-12 mt-3">

                            <label for="" class="mb-2">Select Sport</label>

                            <div class="select">
                                <select name="sport_id" class="rounded" id="standard-select">

                                    @foreach ($sports as $sport)
                                        <option value="{{ $sport->id }}"
                                            @if ($CompReportType->sport_id == $sport->id) {{ 'selected' }} @endif>
                                            {{ $sport->name }}</option>
                                    @endforeach


                                </select>
                            </div>
                        </div>
                        @if ($errors->has('sport_id'))
                            <span class="text-danger text-left">{{ $errors->first('sport_id') }}</span>
                        @endif


                         @php
                                $value = explode(',', $CompReportType->sport_stat_id);
                            @endphp
                        <div class="col-12 mt-3">
                        <div class="select-league-table round-check-box bg-light">
								<label for="">Select Sport Stats</label>
								<div class="scrollchakmartList">
									<div class="row">
										@foreach($sportStats as $stat)
											<div class=" col-6">
												<div class="form-check">

														<input class="round-check-box" type="checkbox" value="{{$stat->id}}" id="Played.{{$stat->id}}" name="sport_stats_id[]"
                                                        @foreach ($value as $values)


                                        @if ($values == $stat->id)
                                        {{ 'checked' }}

                                        @endif @endforeach/>

													<label class="form-check-label" for="Played">
														{{$stat->name}}
													</label>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							</div>
							</div>
                        @if ($errors->has('sport_stat_id'))
                            <span class="text-danger text-left">{{ $errors->first('sport_stat_id') }}</span>
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

<script>
    /*Dropdown Menu*/
    $('.dropdown').click(function() {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);
    });
    $('.dropdown').focusout(function() {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });
    $('.dropdown .dropdown-menu li').click(function() {
        $(this).parents('.dropdown').find('span').text($(this).text());
        $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
    });
    /*End Dropdown Menu*/


    $('.dropdown-menu li').click(function() {
        var input = '<strong>' + $(this).parents('.dropdown').find('input').val() + '</strong>',
            msg = '<span class="msg">Hidden input value: ';
        $('.msg').html(msg + input + '</span>');
    });
</script>
