@include('frontend.includes.header')
<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><span class="icon-noun-s icon-noun-circle noun_Trophy"></span><strong>Teams I Created</strong></h1>
            </div>
        </div>
    </div>
</div>
<main id="main">
    <div class="container">
        <div class="row">
            @if($my_team->isNotEmpty())
            <div class="col-md-12">
                <div class="CompetitionListScroll">
                    <div class="grid">
                        <div class="grid-container AllCompetitions" id="ScrollRightBlue">
                            <table>
                                <thead>
                                    <tr class="header">
                                        <th>Sport<div>Sport</div>
                                        </th>
                                        <th>Team Name<div>Team Name</div>
                                        </th>
                                        <th>Team Admin<div>Team Admin</div>
                                        </th>
                                        <th>Location<div>Location</div>
                                        </th>
                                        <th>Action<div>Action</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($my_team as $tm)
                                    <tr>
                                        <?php $user = App\Models\User::find($tm->user_id); ?>
                                        <td>{{$tm->sport_team->name}}</td>
                                        <td>{{$tm->name}}</td>
                                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                                        <td>{{$tm->location}}</td>
                                        <td><a href="{{ URL::to('team/' . $tm->id) }}" class="btn btn-success btn-xs-nb" target="_blank">View</a>
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-12">
                    <div class="CompetitionListScroll">
                        <div class="grid">
                            <div class="grid-container AllCompetitions" id="ScrollRightBlue">
                                <table>
                                    <thead>
                                        <tr class="header">
                                            <th>Sport<div>Sport</div>
                                            </th>
                                            <th>Team Name<div>Team Name</div>
                                            </th>
                                            <th>Team Admin<div>Team Admin</div>
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
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
@include('frontend.includes.footer')
@include('frontend.includes.searchScript')

<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer async></script>
