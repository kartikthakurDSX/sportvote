@include('frontend.includes.header')
<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong>Competitions I Created</strong>
                </h1>
            </div>
        </div>
    </div>
</div>

<main id="main">
    <div class="container I-CreatedList">
        <div class="row">
            @if ($my_comp->isNotEmpty())
                <div class="col-md-6">
                    <h1 class="Poppins-Fs30"> My Active Competitions<button class="btn fs1 float-end"><i
                                class="icon-more_horiz"></i></button></h1>
                    <div class="CompetitionListScroll">
                        <div class="grid" id="ScrollRightBlue">
                            <div class="grid-container" id="ScrollRightBlue">
                                <table>
                                    <thead>
                                        <tr class="header">
                                            <th>Competition Name<div>Competition Name</div>
                                            </th>
                                            <th>Type<div>Type</div>
                                            </th>
                                            <th>Start Date<div>Start Date</div>
                                            </th>
                                            <th>Location<div>Location</div>
                                            </th>
                                            <th>Action<div>Action</div>
                                            </th>
                                            <th>Status<div>Status</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($my_comp as $tm)
                                            @if ($tm->is_active == 1)
                                                <tr>
                                                    <td>@php echo Str::of($tm->name)->limit(14); @endphp</td>
                                                    <td>
                                                        @if ($tm->comp_type_id && $tm->comp_subtype_id)
                                                            {{ $tm->comptype->description }}
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($tm->start_datetime != null)
                                                            {{ date('d-M-y', strtotime($tm->start_datetime)) }}
                                                        @else
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($tm->location)
                                                            @php echo Str::of($tm->location)->limit(10); @endphp
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-success btn-xs-nb"
                                                            href="{{ URL::to('competition/' . $tm->id) }}"
                                                            target="_blank">View</a>
                                                        @if ($tm->user_id == Auth::user()->id)
                                                            @if ($tm->comp_start != 1)
                                                                <a class="btn"
                                                                    href="{{ url('block_competition', $tm->id) }}"
                                                                    onclick="return confirm('Are you sure?')">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            @else
                                                            @endif
                                                        @else
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($tm->comp_start == 1)
                                                            <?php $compFixturecount = count($tm->comp_fixture);
                                                            $finishfixture = [];
                                                            foreach ($tm->comp_fixture as $fixtureData) {
                                                                if ($fixtureData->startdate_time != '' && $fixtureData->finishdate_time != '') {
                                                                    array_push($finishfixture, $fixtureData->id);
                                                                }
                                                            }
                                                            ?>
                                                            @if ($compFixturecount > count($finishfixture))
                                                                <img class="iconSpacingLR"
                                                                    src="{{ url('frontend/images') }}/In-Progress.png"
                                                                    title="On Going">
                                                            @else
                                                                @if ($compFixturecount == count($finishfixture))
                                                                    <img class="iconSpacingLR"
                                                                        src="{{ url('frontend/images') }}/Completed.png"
                                                                        title="Finished">
                                                                @else
                                                                @endif
                                                            @endif
                                                        @else
                                                            <img class="iconSpacingLR"
                                                                src="{{ url('frontend/images') }}/Not-Started.png"
                                                                title="Not-Started">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @else
                                            @endif
                                        @endforeach
                                    </tbody>

                                </table>
                                {{-- <div class="pagination">
                                    {{ $my_comp->appends(['active_page' => $my_comp->currentPage()])->links() }}

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <h1 class="Poppins-Fs30"> My Active Competitions<button class="btn fs1 float-end"><i
                                class="icon-more_horiz"></i></button></h1>
                    <div class="CompetitionListScroll">
                        <div class="grid">
                            <div class="grid-container" id="ScrollRightBlue">
                                <table>
                                    <thead>
                                        <tr class="header">
                                            <th>Competition Name<div>Competition Name</div>
                                            </th>
                                            <th>Type<div>Type</div>
                                            </th>
                                            <th>Start Date<div>Start Date</div>
                                            </th>
                                            <th>Location<div>Location</div>
                                            </th>
                                            <th>Action<div>Action</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                {{ 'No Data Found!!' }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <h1 class="Poppins-Fs30"> My Draft Competitions <button class="btn fs1 float-end"><i
                            class="icon-more_horiz"></i></button></h1>
                <div class="CompetitionListScroll">
                    <div class="grid" id="ScrollRightBlue">
                        <div class="grid-container" id="ScrollRightBlue">
                            @if ($my_draft_comp->isNotEmpty())
                                <table>
                                    <thead>
                                        <tr class="header">
                                            <th>Competition Name<div>Competition Name</div>
                                            </th>
                                            <th>Type<div>Type</div>
                                            </th>
                                            <th>Start Date<div>Start Date</div>
                                            </th>
                                            <th>Location<div>Location</div>
                                            </th>
                                            <th>Action<div>Action</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $d = 1; ?>
                                        @foreach ($my_draft_comp as $tm)
                                            <tr>
                                                <td>{{ $tm->name }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <a class="btn btn-success btn-xs-nb"
                                                        href="{{ URL::to('draft_competition/' . $tm->id) }}"
                                                        target="_blank">View</a>
                                                    <a class="btn" href="{{ url('block_competition', $tm->id) }}"
                                                        onclick="return confirm('Are you sure?')"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <?php $d++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table>
                                    <thead>
                                        <tr class="header">
                                            <th>Competition Name<div>Competition Name</div>
                                            </th>
                                            <th>Type<div>Type</div>
                                            </th>
                                            <th>Start Date<div>Start Date</div>
                                            </th>
                                            <th>Location<div>Location</div>
                                            </th>
                                            <th>Action<div>Action</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">{{ 'No Data Found!!' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('frontend.includes.footer')
@include('frontend.includes.searchScript')
{{-- </body>
</html> --}}
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('frontend/js/script.js') }}"></script>
<script src="{{ url('frontend/js/main.js') }}"></script>

<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
