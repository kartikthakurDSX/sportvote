@include('frontend.includes.header')
<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong>All Teams</strong></h1>
            </div>
        </div>
    </div>
</div>
<main id="main">
    <div class="container">
        <div class="row">
            @if ($all_teams->isNotEmpty())
                <div class="col-md-12">
                    <div class="CompetitionListScroll">
                        <div class="grid">
                            <div class="grid-container AllCompetitions" id="ScrollRightBlue">
                                <table>
                                    <thead>
                                        <tr class="header">
                                            <th style="width: 20%;">Sport<div>Sport</div>
                                            </th>
                                            <th style="width: 20%;">Team Name<div>Team Name</div>
                                            </th>
                                            <th style="width: 20%;">Team Admin<div>Team Admin</div>
                                            </th>
                                            <th style="width: 30%;">Location<div>Location</div>
                                            </th>
                                            <th style="width: 10%;">Action<div>Action</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $d = 1; ?>
                                        @foreach ($all_teams as $tm)
                                            {{-- @if ($tm->user_id != Auth::user()->id) --}}
                                            <?php $user = App\Models\User::find($tm->user_id);
                                            $d++; ?>
                                            <tr>
                                                <td>{{ $tm->sport_team->name }}</td>
                                                <td>{{ $tm->name }} </td>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $tm->location }}</td>
                                                <td><a href="{{ url('team/' . $tm->id) }}"
                                                        class="btn btn-success btn-xs-nb">View</a></td>
                                            </tr>
                                            <?php $d++; ?>
                                            {{-- @endif --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h2></h2>
            @endif
        </div>
    </div>
    </div>
</main>

@include('frontend.includes.footer')
@include('frontend.includes.searchScript')

<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
