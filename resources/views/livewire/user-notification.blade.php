@if ($notification->isNotEmpty())

    <div class="col-md-6 w-100-768">
        <button class="processed" wire:click="refresh">Refresh</button>
        <style>
            .tooltip.bs-tooltip-bottom .arrow::before {

                border-bottom-color: black;
            }

            .tooltip.bs-tooltip-bottom .tooltip-inner {
                background-color: black;
            }

            .TootTipCustom span {
                color: #0a3c5f;

                white-space: nowrap;
            }

            .TootTipCustom span:after {
                font-family: Arial, sans-serif;
                text-align: left;
                white-space: normal;
            }

            .TootTipCustom span:focus {
                outline: none;
            }

            .TootTipCustom .wrap {
                background: #ECF0F1;
                color: #607D8B;
                height: 100%;
                padding: 1em 2.5em;
                text-align: center;


            }



            @media (min-width: 1075px) {

                .TootTipCustom pre {
                    background: #fff;
                    display: inline-block;
                    font-size: .55em;
                    margin-top: 2em;
                    padding: 1em;
                }
            }

            @media (min-width: 360px) {
                .TootTipCustom pre {
                    font-size: .7em;
                }
            }

            @media (min-width: 500px) {
                .TootTipCustom pre {
                    font-size: 1em;
                }
            }


            /*== start of code for tooltips ==*/
            .TootTipCustom .tool {
                cursor: pointer;
                position: relative;
            }

            a.tool:not([href]):not([tabindex]) {
                color: #003b5f;
                text-decoration: none;
            }

            /*== common styles for both parts of tool tip ==*/
            .TootTipCustom .tool::before,
            .TootTipCustom .tool::after {
                left: 50%;
                opacity: 0;
                position: absolute;
                z-index: -100;
            }

            .TootTipCustom .tool:hover::before,
            .TootTipCustom .tool:focus::before,
            .TootTipCustom .tool:hover::after,
            .TootTipCustom .tool:focus::after {
                opacity: 1;
                transform: scale(1) translateY(0);
                z-index: 100;
            }


            /*== pointer tip ==*/
            .TootTipCustom .tool::before {
                border-style: solid;
                border-width: 1em 0.75em 0 0.75em;
                border-color: #000000 transparent transparent transparent;
                bottom: 100%;
                content: "";
                margin-left: -0.5em;
                transition: all .2s cubic-bezier(.84, -0.18, .31, 1.26), opacity .65s .5s;
                transform: scale(.2) translateY(-90%);
            }

            .TootTipCustom .tool:hover::before,
            .TootTipCustom .tool:focus::before {
                transition: all .2s cubic-bezier(.84, -0.18, .31, 1.26) .2s;
            }


            /*== speech bubble ==*/
            .TootTipCustom .tool::after {
                background: #000;
                border-radius: .25em;
                bottom: 180%;
                color: #fff;
                content: attr(data-tip);
                margin-left: -8.75em;
                padding: 1em;
                transition: all .2s cubic-bezier(.84, -0.18, .31, 1.26) .2s;
                transform: scale(.2) translateY(50%);
                width: 17.5em;
                text-align: center;
            }

            .TootTipCustom .tool:hover::after,
            .TootTipCustom .tool:focus::after {
                transition: all .2s cubic-bezier(.84, -0.18, .31, 1.26);
            }

            .mt-5 {
                margin-top: 50px;
            }

            @media (max-width: 760px) {
                .tool::after {
                    font-size: .75em;
                    margin-left: -5em;
                    width: 10em;
                }
            }
        </style>
        @if (Auth::check())
            <h1 class="Poppins-Fs30">Requests / Status <button class="btn fs1 float-end"><i
                        class="icon-more_horiz"></i></button></h1>
            <div class="box-outer-lightpink TootTipCustom">
                <table class="table ">
                    <thead class="">
                        <tr>
                            <th>Request For</th>
                            <th>Request By</th>
                            <th>Action / Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notification as $noti)
                            <?php $reciver = App\Models\User::find($noti->reciver_id); ?>
                            <?php $sender = App\Models\User::find($noti->sender_id); ?>
                            <!-- Friend request notification -->
                            @if ($noti->notify_module_id == 1)
                                <?php $friends = App\Models\User_friend::find($noti->type_id); ?>
                                @if ($sender->id == Auth::user()->id)
                                    <tr>
                                        <td><a class="tool" data-bs-toggle="tooltip" data-placement="bottom"
                                                data-tip="You send a friend request to {{ $reciver->first_name }} ">
                                                Add as Friend </a>
                                        </td>
                                        <td>
                                            <b class="MeStyle">ME:</b><a href="#" class="tool"
                                                data-bs-toggle="tooltip" data-placement="bottom"
                                                data-tip="You send a friend request to {{ $reciver->first_name }} ">
                                                {{ $reciver->first_name }} {{ $reciver->last_name }}</a> <span
                                                class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                        </td>
                                        <td>
                                            @if ($friends->request_status == 0)
                                                <button class="btn btn-danger btn-xs-nb"
                                                    wire:click="friend_remove({{ $friends->id }} , {{ $noti->id }})">RETREAT</button>
                                            @elseif($friends->request_status == 1)
                                                <img src="{{ url('frontend/images/accept-icon.png') }}" alt="icon">
                                                Accepted
                                            @elseif($friends->request_status == 2)
                                                <img src="{{ url('frontend/images/delete.jpg') }}" alt="icon">
                                                Rejected
                                            @elseif($friends->request_status == 3)
                                                <button class="btn btn-green btn-xs-nb"
                                                    wire:click="friend_send_request({{ $friends->id }})">SEND
                                                    REQUEST</button>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @if ($friends->request_status != 3)
                                        <tr>
                                            <td><a data-bs-toggle="tooltip" class="tool" data-placement="bottom"
                                                    data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, send you friend request">
                                                    Add as Friend</a>
                                            </td>
                                            <td><a data-bs-toggle="tooltip" class="tool" data-placement="bottom"
                                                    data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, send you friend request">
                                                    {{ $sender->first_name }} {{ $sender->last_name }}</a> <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            </td>
                                            <td>
                                                @if ($friends->request_status == 0)
                                                    <button class="btn btn-green btn-xs-nb"
                                                        wire:click="friend_accept({{ $friends->id }}, {{ $noti->id }})">Accept</button>
                                                    <button class="btn btn-danger btn-xs-nb"
                                                        wire:click="friend_reject({{ $friends->id }}, {{ $noti->id }})">Reject</button>
                                                @elseif($friends->request_status == 1)
                                                    <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                        alt="icon"> Accepted
                                                @elseif($friends->request_status == 2)
                                                    <img src="{{ url('frontend/images/delete.jpg') }}" alt="icon">
                                                    Rejected
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                    @endif
                                @endif

                                <!-- Team member join a team and add team member  -->
                            @elseif($noti->notify_module_id == 2)
                                <?php $team_member = App\Models\Team_member::find($noti->type_id); ?>
                                <?php $team = App\Models\Team::find($team_member->team_id); ?>
                                @if ($sender->id == Auth::user()->id)
                                    <?php $member = App\Models\User::find($team_member->member_id); ?>
                                    <?php $member_position = App\Models\Member_position::find($team_member->member_position_id); ?>
                                    @if ($team_member->member_position_id)
                                        <?php $member_position = App\Models\Member_position::find($team_member->member_position_id); ?>
                                    @else
                                        <?php $member_position = ''; ?>
                                    @endif
                                    <tr>



                                        <td>
                                            <a href="{{ url('team') }}/{{ $team->id }}" class="tool"
                                                target="_blank" data-bs-toggle="tooltip" data-placement="bottom"
                                                data-tip="You sent request to join '{{ $team->name }}' as a {{ $member_position->name }}">
                                                @if ($member_position)
                                                    Join as {{ $member_position->name }}
                                                @else
                                                    Join Team
                                                @endif
                                            </a>
                                        </td>

                                        <td>
                                            <b class="MeStyle">ME:</b>
                                            @if ($member_position)
                                                <a href="{{ url('player_profile') }}/{{ $member->id }}"
                                                    class="tool" target="_blank" data-bs-toggle="tooltip"
                                                    data-placement="bottom"
                                                    data-tip="You sent a request to  join '{{ $team->name }}' as a {{ $member_position->name }}">
                                                    {{ $member->first_name }} {{ $member->last_name }} </a><span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            @else
                                                {{ $team->name }} <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($team_member->invitation_status == 0)
                                                <button class="btn btn-danger btn-xs-nb"
                                                    wire:click="team_member_remove({{ $team_member->id }})">RETREAT</button>
                                            @elseif($team_member->invitation_status == 1)
                                                <img src="{{ url('frontend/images/accept-icon.png') }}" alt="icon">
                                                Accepted
                                            @elseif($team_member->invitation_status == 2)
                                                <img src="{{ url('frontend/images/delete.jpg') }}" alt="icon">
                                                Rejected
                                            @elseif($team_member->invitation_status == 3)
                                                <button class="btn btn-green btn-xs-nb"
                                                    wire:click="team_member_send({{ $team_member->id }})">SEND
                                                    REQUEST</button>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @if ($team_member->invitation_status != 3)
                                        <?php $member = App\Models\User::find($team_member->member_id); ?>
                                        @if ($team_member->member_position_id)
                                            <?php $member_position = App\Models\Member_position::find($team_member->member_position_id); ?>
                                        @else
                                            <?php $member_position = ''; ?>
                                        @endif
                                        <tr>
                                            <td>
                                                <a href="{{ url('team') }}/{{ $team->id }}" target="a_blank"
                                                    data-bs-toggle="tooltip" class="tool" data-placement="bottom"
                                                    data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join '{{ $team->name }}' as a {{ $member_position->name }}">
                                                    Join Team as {{ $member_position->name }} </a>
                                            </td>
                                            <td>
                                                @if ($member_position)
                                                    <a href="{{ URL::to('team/' . $team->id) }}" target="a_blank"
                                                        class="tool" data-bs-toggle="tooltip" data-placement="bottom"
                                                        data-tip="{{ $sender->first_name }} {{ $sender->last_name }},  would like you to join '{{ $team->name }}' as a {{ $member_position->name }}">{{ $sender->first_name }}
                                                        {{ $sender->last_name }} </a>
                                                @else
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                @endif <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            </td>
                                            <td>
                                                @if ($team_member->invitation_status == 0)
                                                    <button class="btn btn-green btn-xs-nb"
                                                        wire:click="team_member_accept({{ $team_member->id }} , {{ $noti->id }})">Accept</button>
                                                    <button class="btn btn-danger btn-xs-nb"
                                                        wire:click="team_member_reject({{ $team_member->id }} , {{ $noti->id }})">Reject</button>
                                                @elseif($team_member->invitation_status == 1)
                                                    <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                        alt="icon"> Accepted
                                                @elseif($team_member->invitation_status == 2)
                                                    <img src="{{ url('frontend/images/delete.jpg') }}" alt="icon">
                                                    Rejected
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                    @endif
                                @endif
                                <!--  notification for Competition join      -->
                            @elseif($noti->notify_module_id == 3)
                                <?php $competition_request = App\Models\Competition_team_request::find($noti->type_id); ?>
                                <?php $team = App\Models\Team::find($competition_request->team_id); ?>
                                <?php $competition = App\Models\Competition::find($competition_request->competition_id); ?>
                                @if ($sender->id != $reciver->id)
                                    @if ($sender->id == Auth::user()->id)
                                        <tr>
                                            <td>
                                                <a href="{{ URL::to('competition/' . $competition->id) }}"
                                                    target="_blank" data-bs-toggle="tooltip" data-placement="bottom"
                                                    class="tool"
                                                    data-tip="You send a request to {{ $reciver->first_name }} Admin of {{ $team->name }}, to join {{ $competition->name }} competition">
                                                    Join Competition: </a>
                                            </td>
                                            <td>
                                                <b class="MeStyle">ME:</b><a
                                                    href="{{ url('/team') }}/{{ $team->id }}" target ="_blank"
                                                    data-bs-toggle="tooltip" data-placement="bottom" class="tool"
                                                    data-tip="You send a request to {{ $reciver->first_name }} Admin of {{ $team->name }}, to join {{ $competition->name }} competition">
                                                    {{ $team->name }} </a> <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            </td>
                                            <td>
                                                @if ($competition_request->request_status == 0)
                                                    <button class="btn btn-danger btn-xs-nb"
                                                        onclick="return confirm('Are you sure you want to cancel request?') || event.stopImmediatePropagation()"
                                                        wire:click="retreat_compjoin({{ $competition_request->id }})">RETREAT</button>
                                                @elseif($competition_request->request_status == 1)
                                                    <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                        alt="icon"> Accepted
                                                @elseif($competition_request->request_status == 2)
                                                    <img src="{{ url('frontend/images/delete.jpg') }}"
                                                        alt="icon"> Rejected
                                                @elseif($competition_request->request_status == 3)
                                                    <button class="btn btn-green btn-xs-nb"
                                                        wire:click="send_comp_request_again({{ $competition_request->id }})">SEND
                                                        REQUEST</button>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @if ($competition_request->request_status != 3)
                                            <tr>
                                                <td>
                                                    <a href="{{ URL::to('competition/' . $competition->id) }}"
                                                        target="a_blank" data-bs-toggle="tooltip"
                                                        data-placement="bottom" class="tool"
                                                        data-tip="{{ $sender->first_name }}, Admin of {{ $competition->name }} would like your team {{ $team->name }} to join their competition">
                                                        Join Competition: </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/competition') }}/{{ $competition->id }}"
                                                        data-bs-toggle="tooltip" data-placement="bottom"
                                                        class="tool"
                                                        data-tip="{{ $sender->first_name }}, Admin of {{ $competition->name }} would like your team {{ $team->name }} to join their competition">
                                                        {{ $competition->name }} </a> <span
                                                        class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                                </td>
                                                <td>
                                                    @if ($competition_request->request_status == 0)
                                                        <a class="btn btn-green btn-xs-nb"
                                                            wire:click ="select_player({{ $competition_request->id }} , {{ $noti->id }})"
                                                            style="color:white;">Accept</a>
                                                        <button class="btn btn-danger btn-xs-nb"
                                                            onclick="return confirm('Are you sure you want to cancel competition request?') || event.stopImmediatePropagation()"
                                                            wire:click="reject_compjoin({{ $competition_request->id }} , {{ $noti->id }})">Reject</button>
                                                        <!-- <button class="btn btn-danger btn-xs-nb" wire:click="competition_request_reject({{ $competition_request->id }})">Reject</button>  -->
                                                    @elseif($competition_request->request_status == 1)
                                                        <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                            alt="icon"> Accepted .
                                                    @elseif($competition_request->request_status == 2)
                                                        <img src="{{ url('frontend/images/delete.jpg') }}"
                                                            alt="icon"> Rejected.
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                        @endif
                                    @endif
                                @endif
                                <!-- Notification for competition member -->
                            @elseif($noti->notify_module_id == 4)
                                <?php $competition_member = App\Models\Comp_member::find($noti->type_id); ?>
                                <?php $competition = App\Models\Competition::find($competition_member->comp_id); ?>
                                <?php $member = App\Models\User::find($competition_member->member_id); ?>
                                <?php $position = App\Models\Member_position::find($competition_member->member_position_id); ?>
                                @if ($sender->id != $reciver->id)
                                    @if ($sender->id == Auth::user()->id)
                                        <tr>
                                            <td>
                                                <a href="{{ URL::to('competition/' . $competition->id) }}"
                                                    class="tool" target="_blank" data-bs-toggle="tooltip"
                                                    data-placement="bottom"
                                                    data-tip=" You sent a request to join '{{ $competition->name }}' as a {{ $position->name }}">Join
                                                    as {{ $position->name }} </a>
                                            </td>
                                            <td>
                                                <b class="MeStyle">ME:</b> <a
                                                    href="{{ URL::to('competition/' . $competition->id) }}"
                                                    target="_blank" class="tool" data-bs-toggle="tooltip"
                                                    data-placement="bottom"
                                                    data-tip=" You sent a request to join '{{ $competition->name }}' as a {{ $position->name }}">
                                                    {{ $member->first_name }} {{ $member->last_name }} </a> <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            </td>
                                            <td>
                                                @if ($competition_member->invitation_status == 0)
                                                    <button class="btn btn-danger btn-xs-nb"
                                                        wire:click="remove_compmember_request({{ $competition_member->id }})">RETREAT</button>
                                                @elseif($competition_member->invitation_status == 1)
                                                    <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                        alt="icon">Accepted
                                                @elseif($competition_member->invitation_status == 2)
                                                    <img src="{{ url('frontend/images/delete.jpg') }}"
                                                        alt="icon">Rejected
                                                @elseif($competition_member->invitation_status == 3)
                                                    <button class="btn btn-green btn-xs-nb"
                                                        wire:click = "send_compmember_request({{ $competition_member->id }})">SEND
                                                        REQUEST</button>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @if ($competition_member->invitation_status != 3)
                                            <tr>
                                                <td>
                                                    <a href="{{ URL::to('competition/' . $competition->id) }}"
                                                        target="a_blank" data-bs-toggle="tooltip" class="tool"
                                                        data-placement="bottom"
                                                        data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join '{{ $competition->name }}' as a {{ $position->name }}">
                                                        Join as {{ $position->name }} </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/competition') }}/{{ $competition->id }}"
                                                        data-bs-toggle="tooltip" data-placement="bottom"
                                                        class="tool"
                                                        data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join '{{ $competition->name }}' as a {{ $position->name }}">
                                                        {{ $sender->first_name }} </a><span
                                                        class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                                </td>
                                                <td>
                                                    @if ($competition_member->invitation_status == 0)
                                                        <!-- <a class="btn btn-green btn-xs-nb" href="" >View Competition</a>  -->
                                                        <button class="btn btn-green btn-xs-nb"
                                                            wire:click="accept_competitionmember_request({{ $competition_member->id }} , {{ $noti->id }})">Accept</button>
                                                        <button class="btn btn-danger btn-xs-nb"
                                                            wire:click="reject_competitionmember_request({{ $competition_member->id }}, {{ $noti->id }})">Reject</button>
                                                    @elseif($competition_member->invitation_status == 1)
                                                        <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                            alt="icon"> Accepted
                                                    @elseif($competition_member->invitation_status == 2)
                                                        <img src="{{ url('frontend/images/delete.jpg') }}"
                                                            alt="icon"> Rejected
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                        @endif
                                    @endif
                                @endif
                                <!-- Notification for request to comp admin for Join Competition -->
                            @elseif($noti->notify_module_id == 11)
                                <?php $competition_member = App\Models\Comp_member::find($noti->type_id); ?>
                                <?php $competition = App\Models\Competition::find($competition_member->comp_id); ?>
                                <?php $member = App\Models\User::find($competition_member->member_id); ?>
                                <?php $position = App\Models\Member_position::find($competition_member->member_position_id); ?>
                                @if ($sender->id != $reciver->id)
                                    @if ($sender->id == Auth::user()->id)
                                        <tr>
                                            <td>
                                                <a href="{{ URL::to('competition/' . $competition->id) }}"
                                                    class="tool" target="_blank" data-bs-toggle="tooltip"
                                                    data-placement="bottom"
                                                    data-tip=" You sent a request to join '{{ $competition->name }}' as a {{ $position->name }}">Join
                                                    as {{ $position->name }} </a>
                                            </td>
                                            <td>
                                                <b class="MeStyle">ME:</b> <a
                                                    href="{{ URL::to('competition/' . $competition->id) }}"
                                                    target="_blank" class="tool" data-bs-toggle="tooltip"
                                                    data-placement="bottom"
                                                    data-tip=" You sent a request to join '{{ $competition->name }}' as a  {{ $position->name }}">
                                                    {{ $competition->name }} </a> <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            </td>
                                            <td>
                                                @if ($competition_member->invitation_status == 0)
                                                    <button class="btn btn-danger btn-xs-nb"
                                                        wire:click="remove_compmember_request({{ $competition_member->id }})">RETREAT</button>
                                                @elseif($competition_member->invitation_status == 1)
                                                    <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                        alt="icon">Accepted
                                                @elseif($competition_member->invitation_status == 2)
                                                    <img src="{{ url('frontend/images/delete.jpg') }}"
                                                        alt="icon">Rejected
                                                @elseif($competition_member->invitation_status == 3)
                                                    <button class="btn btn-green btn-xs-nb"
                                                        wire:click = "send_compmember_request({{ $competition_member->id }})">SEND
                                                        REQUEST</button>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @if ($competition_member->invitation_status != 3)
                                            <tr>
                                                <td>
                                                    <a href="{{ URL::to('competition/' . $competition->id) }}"
                                                        class="tool" target="a_blank" data-bs-toggle="tooltip"
                                                        data-placement="bottom"
                                                        data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join  '{{ $competition->name }}' as a {{ $position->name }}">
                                                        Join as {{ $position->name }} </a>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/competition') }}/{{ $competition->id }}"
                                                        data-bs-toggle="tooltip" data-placement="bottom"
                                                        class="tool"
                                                        data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join  '{{ $competition->name }}' as a {{ $position->name }}">
                                                        {{ $sender->first_name }} {{ $sender->last_name }} </a><span
                                                        class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                                </td>
                                                <td>
                                                    @if ($competition_member->invitation_status == 0)
                                                        <!-- <a class="btn btn-green btn-xs-nb" href="" >View Competition</a>  -->
                                                        <button class="btn btn-green btn-xs-nb"
                                                            wire:click="accept_competitionmember_request({{ $competition_member->id }} , {{ $noti->id }})">Accept</button>
                                                        <button class="btn btn-danger btn-xs-nb"
                                                            wire:click="reject_competitionmember_request({{ $competition_member->id }}, {{ $noti->id }})">Reject</button>
                                                    @elseif($competition_member->invitation_status == 1)
                                                        <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                            alt="icon"> Accepted
                                                    @elseif($competition_member->invitation_status == 2)
                                                        <img src="{{ url('frontend/images/delete.jpg') }}"
                                                            alt="icon"> Rejected
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                        @endif
                                    @endif
                                @endif
                                <!-- End  Notification for request to comp admin for Join Competition -->
                                <!--   Notification for request to team admin for Join team -->
                            @elseif($noti->notify_module_id == 12)
                                <?php $team_member = App\Models\Team_member::find($noti->type_id); ?>
                                <?php $team = App\Models\Team::find($team_member->team_id); ?>
                                @if ($sender->id == Auth::user()->id)
                                    <?php $member = App\Models\User::find($team_member->member_id); ?>
                                    <?php $member_position = App\Models\Member_position::find($team_member->member_position_id); ?>
                                    @if ($team_member->member_position_id)
                                        <?php $member_position = App\Models\Member_position::find($team_member->member_position_id); ?>
                                    @else
                                        <?php $member_position = ''; ?>
                                    @endif
                                    <tr>
                                        <td>
                                            <a href="{{ url('team') }}/{{ $team->id }}" class="tool"
                                                target="_blank" data-bs-toggle="tooltip" data-placement="bottom"
                                                data-tip="You sent a request to join '{{ $team->name }}' as a {{ $member_position->name }}">
                                                @if ($member_position)
                                                    Join as {{ $member_position->name }}
                                                @else
                                                    Join Team
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <b class="MeStyle">ME:</b>
                                            @if ($member_position)
                                                <a href="{{ url('player_profile') }}/{{ $member->id }}"
                                                    target="_blank" data-bs-toggle="tooltip" data-placement="bottom"
                                                    class="tool"
                                                    data-tip="You sent a request to join '{{ $team->name }}' as a {{ $member_position->name }}">
                                                    {{ $team->name }} </a><span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            @else
                                                {{ $team->name }} <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($team_member->invitation_status == 0)
                                                <button class="btn btn-danger btn-xs-nb"
                                                    wire:click="team_member_remove({{ $team_member->id }})">RETREAT</button>
                                            @elseif($team_member->invitation_status == 1)
                                                <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                    alt="icon"> Accepted
                                            @elseif($team_member->invitation_status == 2)
                                                <img src="{{ url('frontend/images/delete.jpg') }}" alt="icon">
                                                Rejected
                                            @elseif($team_member->invitation_status == 3)
                                                <button class="btn btn-green btn-xs-nb"
                                                    wire:click="team_member_send({{ $team_member->id }})">SEND
                                                    REQUEST</button>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @if ($team_member->invitation_status != 3)
                                        <?php $member = App\Models\User::find($team_member->member_id); ?>
                                        @if ($team_member->member_position_id)
                                            <?php $member_position = App\Models\Member_position::find($team_member->member_position_id); ?>
                                        @else
                                            <?php $member_position = ''; ?>
                                        @endif
                                        <tr>
                                            <td>
                                                <a href="{{ url('team') }}/{{ $team->id }}" target="_blank"
                                                    data-bs-toggle="tooltip" data-placement="bottom" class="tool"
                                                    data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join '{{ $team->name }}' as a {{ $member_position->name }}">
                                                    Join Team as {{ $member_position->name }} </a>
                                            </td>
                                            <td>
                                                @if ($member_position)
                                                    <a href="{{ URL::to('team/' . $team->id) }}" target="a_blank"
                                                        data-bs-toggle="tooltip" data-placement="bottom"
                                                        class="tool"
                                                        data-tip="{{ $sender->first_name }} {{ $sender->last_name }}, would like you to join '{{ $team->name }}' as a  {{ $member_position->name }}">
                                                        {{ $team->name }} </a>
                                                @else
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                @endif <span
                                                    class="Dec-Date">({{ $noti->created_at->format('d M Y') }})</span>
                                            </td>
                                            <td>
                                                @if ($team_member->invitation_status == 0)
                                                    <button class="btn btn-green btn-xs-nb"
                                                        wire:click="team_member_accept({{ $team_member->id }} , {{ $noti->id }})">Accept</button>
                                                    <button class="btn btn-danger btn-xs-nb"
                                                        wire:click="team_member_reject({{ $team_member->id }} , {{ $noti->id }})">Reject</button>
                                                @elseif($team_member->invitation_status == 1)
                                                    <img src="{{ url('frontend/images/accept-icon.png') }}"
                                                        alt="icon"> Accepted
                                                @elseif($team_member->invitation_status == 2)
                                                    <img src="{{ url('frontend/images/delete.jpg') }}"
                                                        alt="icon"> Rejected
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                    @endif
                                @endif
                                <!-- End of joi team request -->
                            @else
                                else condition
                                <br />
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{ $notification->links('cpag.custom') }}
                {{-- {{ $notification->links('[pagination::bootstrap-4,cpag.custom]') }} --}}

            </div>

        @endif
    @else
@endif


<!-- Modal For accept competition request from user dashboard -->
@if ($popup)
    <div class="modal fade" id="accept_request" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container" style="background-color:#fff;height:auto;">
                        <div class="row">
                            <h1 class="Poppins-Fs30">Select between @if ($team_members)
                                    {{ $select_competition->lineup_players_num }} and
                                    {{ $select_competition->squad_players_num }}
                                @else
                                @endif players for the Competition</h1>
                            <!-- <h1 class="Poppins-Fs30">Select @if ($team_members)
{{ $select_competition->squad_players_num }}
@else
@endif Players for the Competition</h1> -->
                        </div>
                        <!-- <div class="row">
      <div class="col-xl-3 select_player">01</div>
      <div class="col-xl-3">02</div>
      <div class="col-xl-3">03</div>
      <div class="col-xl-3">04</div>
     </div> -->
                        <div class="row mRemoveSelectPlayer">
                            @foreach ($attendee_ids as $key => $attendee)
                                <?php $player = App\Models\User::select('id', 'first_name', 'last_name', 'profile_pic')->find(@$attendee);
                                $full_name = @$player->first_name . ' ' . @$player->last_name; ?>
                                @if (!empty($player))
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 select_player"
                                        data-bs-toggle="tooltip" data-placement="bottom" class="tool"
                                        data-tip="{{ $full_name }}">

                                        <b> @php echo Str::of($full_name)->limit(10); @endphp </b>
                                        <button class="select_player_btn" style="float:right;"
                                            wire:click="remove_player({{ $key }}	)">&times;</button>

                                    </div>
                                @else
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                @if ($team_members)
                    <div class="modal-body">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Player </th>
                                    <th>Player Position</th>
                                    <th>Jersey Number</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>
                                    <input type='checkbox' value="" wire:model="selectAll">
                                </td>
                                <td>Select All</td>
                            </tr>
                            @foreach ($team_members as $tm)
                                <tr>
                                    <td>
                                        <input type='checkbox' value="{{ $tm->members->id }}"
                                            wire:model="attendee_ids.{{ $loop->index }}">
                                    </td>
                                    <td><img style="border-radius: 50%; width:30px; height:30px; border:1px double #fff;"
                                            src = "{{ url('frontend/profile_pic') }}/{{ $tm->members->profile_pic }}">
                                        {{ $tm->members->first_name }} {{ $tm->members->last_name }}</td>
                                    <td>{{ $tm->member_position->name }} </td>
                                    <td>
                                        @if ($tm->jersey_number)
                                            {{ $tm->jersey_number }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-success float-md-end'
                            wire:click="submit_player({{ $select_competition->id }})">Submit</button>
                    </div>


            </div>
        </div>
    </div>
@else
@endif
@endif
<script src="{{ url('frontend/assets/vendor/bootstrap/js/bootstrap1.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    window.addEventListener('swal:modal', event => {
        swal({
            title: event.detail[0].message,
            text: event.detail.message,
            icon: event.detail.type,
        });
    });
</script>
<script>
    window.addEventListener('openModal', event => {
        $('#accept_request').modal('show')
    })
</script>
<!-- Add script for tooltip 20-10-2022 -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

        Livewire.hook('message.processed', (message, component) => {
            $(function() {
                $('[data-bs-toggle="tooltip"]').tooltip()
            })
        })
    });
</script>
</div>
