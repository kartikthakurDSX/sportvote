<div class="w-auto float-end">
    <button class="processed" wire:click="refresh">Refresh</button>
    <h1 class="social-count Poppins">
        <span type="button" class="" data-bs-toggle="modal" data-bs-target="#AddFriendModal">{{ $friend->count() }}
            <small class="FriendDash">Friends </small></span>
        <span class="wl-1">/</span> <span type="button" class="" data-bs-toggle="modal"
            data-bs-target="#FollowerModal">{{ $follower->count() }} <small class="FriendDash"> Followers </small><span>
    </h1>


    <!-- Start Friend list popup -->
    <!-- Modal -->
    <div class="modal fade" id="AddFriendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Friend List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="FollowersSection">
                        <div class="col-md-12 bootstrap snippets bootdeys">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="row">
                                        <div class="clearfix"></div>
                                        @foreach ($friend_ids as $friend_id)
                                            <?php $friend_detail = App\Models\User::select('id', 'profile_pic', 'first_name', 'last_name', 'phonenumber', 'email', 'location')->find($friend_id); ?>
                                            <!-- <div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown">
                                                <div class="well profile_view">
                                                    <div class="col-sm-12">
                                                        <h4 class="brief"><i></i></h4>
                                                        <div class="left col-xs-7">
                                                            <h2>{{ $friend_detail->first_name }}
                                                                {{ $friend_detail->last_name }}</h2>
                                                            <p><strong><i class="fa fa-envelope" aria-hidden="true"></i>
                                                                    </strong> &nbsp; {{ $friend_detail->email }}</p>
                                                            <p><strong><i class="fa fa-map-marker"
                                                                        aria-hidden="true"></i></strong>
                                                                        &nbsp; {{ $friend_detail->location }} </p>
                                                            <p><strong><i class="fa fa-phone" aria-hidden="true"></i>
                                                                    </strong>
                                                                @if ($friend_detail->phonenumber)
&nbsp; {{ $friend_detail->phonenumber }}
@else
&nbsp; {{ '98xx02xx09' }}
@endif
                                                            </p>

                                                        </div>
                                                        <div class="right col-xs-5 text-center">
                                                            <img src="{{ url('frontend/profile_pic') }}/{{ $friend_detail->profile_pic }}"
                                                                alt="" class="img-circle img-responsive" >
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 bottom text-center">
                                                        <div class="col-xs-12 col-sm-6 emphasis">

                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 emphasis">
                                                            <!-- <button type="button" class="btn btn-success btn-xs">
                                                        <i class="fa fa-user"></i>
                                                        <i class="fa fa-comments-o"></i>
                                                    </button>
                                                            <a href="{{ URL::to('player_profile/' . $friend_detail->id) }}"
                                                                target="_blank">
                                                                <button type="button" class="btn btn-primary btn-xs">
                                                                    <i class="fa fa-user"></i> &nbsp; View Profile
                                                                </button> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown ">
                                                <div class="well profile_view">
                                                    <div class="col-sm-12">
                                                        <div class="row pLR-15">

                                                            <div class="col-md-3 imgCenter">
                                                                <div class="WH-80">
                                                                    <img src="{{ url('frontend/profile_pic') }}/{{ $friend_detail->profile_pic }}"
                                                                        alt="" class="img-circle img-responsive"
                                                                        height="100%" width="100%">
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9 alighCenter">
                                                                <h2>{{ $friend_detail->first_name }}
                                                                    {{ $friend_detail->last_name }}</h2>
                                                            </div>
                                                        </div>
                                                        <h4 class="brief"><i></i></h4>

                                                        <div class="left col-md-9" style="width: auto;">

                                                            <p><strong><i class="fa fa-envelope text-primary p-2"
                                                                        aria-hidden="true"></i>
                                                                </strong>
                                                                {{ $friend_detail->email }}</p>
                                                            <p><strong><i class="fa fa-map-marker text-primary p-2"
                                                                        aria-hidden="true"></i>
                                                                </strong>
                                                                {{ $friend_detail->location }} </p>
                                                            <p><strong><i class="fa fa-phone text-primary p-2"
                                                                        aria-hidden="true"></i>
                                                                </strong>
                                                                @if ($friend_detail->phonenumber)
                                                                    {{ $friend_detail->phonenumber }}
                                                                @else
                                                                    {{ '98xx02xx09' }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 bottom text-center">
                                                        <div class="col-md-12 col-sm-6 emphasis">
                                                            <a href="{{ URL::to('player_profile/' . $friend_detail->id) }}"
                                                                target="_blank">
                                                                <button type="button" class="btn btn-primary btn-xs">
                                                                    <i class="fa fa-user"></i> &nbsp; View Profile
                                                                </button> </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end Friend list popup -->
    <!-- Start Follower list popup -->
    <div class="modal fade" id="FollowerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Follower List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="FollowersSection">
                        <div class="col-md-12 bootstrap snippets bootdeys">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="row">
                                        <div class="clearfix"></div>
                                        @foreach ($follower as $follower_id)
                                            <?php $follower_detail = App\Models\User::select('id', 'profile_pic', 'first_name', 'last_name', 'phonenumber', 'email', 'location')->find($follower_id->user_id); ?>

@if ($follower_detail->phonenumber)
&nbsp; {{ $follower_detail->phonenumber }}
@else
&nbsp; {{ '98xx34xx07' }}
@endif
</p>
                                                        
                                            <div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown ">
                                                <div class="well profile_view">
                                                    <div class="col-sm-12">
                                                        <div class="row pLR-15">

                                                            <div class="col-md-3 imgCenter">
                                                                <div class="WH-80">
                                                                    <img src="{{ url('frontend/profile_pic') }}/{{ $follower_detail->profile_pic }}"
                                                                        alt=""
                                                                        class="img-circle img-responsive"
                                                                        height="100%" width="100%">
                                                                </div>

                                                            </div>
                                                            <div class="col-xl-9 col-lg-9 col-md-9 alighCenter">
                                                                <h2>{{ $follower_detail->first_name }}
                                                                    {{ $follower_detail->last_name }}</h2>
                                                            </div>
                                                        </div>
                                                        <h4 class="brief"><i></i></h4>

                                                        <div class="left col-md-9" style="width: auto;">

                                                            <p><strong><i class="fa fa-envelope text-primary p-2"
                                                                        aria-hidden="true"></i>
                                                                </strong>
                                                                {{ $follower_detail->email }}</p>
                                                            <p><strong><i class="fa fa-map-marker text-primary p-2"
                                                                        aria-hidden="true"></i>
                                                                </strong>
                                                                {{ $follower_detail->location }}</p>
                                                            <p><strong><i class="fa fa-phone text-primary p-2"
                                                                        aria-hidden="true"></i>
                                                                </strong>
                                                                @if ($follower_detail->phonenumber)
                                                                    {{ $follower_detail->phonenumber }}
                                                                @else
                                                                    {{ '98xx34xx07' }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 bottom text-center">
                                                        <div class="col-md-12 col-sm-6 emphasis">
                                                            <a href="{{ URL::to('player_profile/' . $follower_detail->id) }}"
                                                                target="_blank"> <button type="button"
                                                                    class="btn btn-primary btn-xs">
                                                                    <i class="fa fa-user"></i> &nbsp; View Profile
                                                                </button> </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="openFollowerList" role="dialog" wire:ignore.self>
        <div class="modal-dialog ">
            <div class="modal-content ground-wrap">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            {{ $follower->count() }} @if ($follower->count() > 1)
                                Followers
                            @else
                                Follower
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <table>
                        @foreach ($follower as $follower_id)
                            <?php $follower_detail = App\Models\User::select('id', 'profile_pic', 'first_name', 'last_name')->find($follower_id->user_id); ?>
                            <tr>
                                <td class="game-logo">
                                    <a href="{{ URL::to('player_profile/' . $follower_detail->id) }}"
                                        target="_blank">
                                        <img src="{{ url('frontend/profile_pic') }}/{{ $follower_detail->profile_pic }}"
                                            class="img-fluid rounded-circle"
                                            title="{{ $follower_detail->first_name }} {{ $follower_detail->last_name }}">
                                    </a>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="{{ URL::to('player_profile/' . $follower_detail->id) }}"
                                        target="_blank"> <b class="MeStyle"> {{ $follower_detail->first_name }}
                                            {{ $follower_detail->last_name }}</b> </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <br>
            </div>
            <div class="bg-light-dark01">

            </div>
        </div>
    </div>
    <!-- end Follower list popup -->
</div>
