<div wire:poll.5s>
    {{-- wire:poll.2s --}}
    {{-- wire:poll.850ms --}}
    Hello
    <button class="processed" wire:click="$refresh">Refresh</button>
    @if (Auth::check())
        @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $match_fixture->competition->user_id)
            @if (@$fixture_lapse_type->lapse_type == 4)
                @if ($match_fixture->finishdate_time == null)
                    <button class="btn btn-green" data-bs-target="#recordStats" data-bs-toggle="modal">
                        <img src="{{ asset('frontend/images') }}/noun_stats.png" alt="" class="btn-icon">
                        Edit Match Stats</button>
                @else
                @endif
            @endif

            <!-- Submit details modal -->
            <div class="modal fade" id="recordStats" role="dialog" wire:ignore.self>
                <div class="modal-dialog ">
                    <div class="modal-content ground-wrap">
                        <div class="modal-header">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="image-profile-icon">
                                            <img src="{{ url('frontend/logo') }}/{{ $team_image->team_logo }}"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="drop-profile">
                                            <div class="dropdown">
                                                <select class="btn btn-danger btn-lg dropdown-toggle kanoPillars"
                                                    wire:model="team_id" wire:change="select_team">
                                                    <option value="{{ $match_fixture->teamOne_id }}">
                                                        {{ $match_fixture->teamOne->name }} </option>
                                                    <option value="{{ $match_fixture->teamTwo_id }}">
                                                        {{ $match_fixture->teamTwo->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-7">
                                        <div class="plyer-profile-group plyer-profile-group02">
                                            <div class="icon-plyr">
                                                <?php
                                                $f_player_pic = App\Models\User::select('profile_pic')->find($lineup_player_id); ?>
                                                <img src="{{ url('frontend/profile_pic') }}/{{ @$f_player_pic->profile_pic }}"
                                                    alt="image" class="img-fluid rounded-circle">
                                            </div>
                                            <div class="">
                                                <div class="drop-profile">
                                                    <div class="dropdown">
                                                        <select class="btn btn-grey btn-lg dropdown-toggle kanoPillars"
                                                            wire:model="player_id" wire:change="select_player">
                                                            @foreach ($player as $p)
                                                                <option value="{{ $p->player->id }}">
                                                                    {{ $p->player->first_name }}
                                                                    {{ $p->player->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-5">
                                        <button class="btn btn-successGreen btn-lg" style="width: 100%;"
                                            wire:click="update_player_stat">UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <h3 class="mb-3 text-center"> First Half Stats</h3>
                                @foreach ($stat as $stats)
                                    <div class="row">
                                        <div class="col-md-2 col-4 pe-0 left-side">
                                            <div class="stat-item">{{ $stats->description }}
                                                @if ($first_red_card_player == 1 || $first_yellow_card_player == 2)
                                                    <button class="plusadd btn"
                                                        wire:click="red_yellow_card_player()">+</button>
                                                @else
                                                    <button class="plusadd btn"
                                                        wire:click="add_first_half_stat({{ $stats->id }})">+</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-8 right-side-stat">
                                            <?php $x = 0; ?>
                                            @foreach ($first_half_fixture_player_stat as $fixture_stats)
                                                @if ($fixture_stats->sport_stats_id == $stats->id)
                                                    <span class="TimeInputStyle">
                                                        @php
                                                            $value1 = explode(':', $fixture_stats->stat_time_record);
                                                            $value_count = count($value1);
                                                            if ($value_count == 3) {
                                                                $sec1 = $value1[1] * 60 + $value1[2];
                                                            } else {
                                                                $sec1 = $value1[0] * 60 + $value1[1];
                                                            }
                                                            $value2 = explode(':', $fixture_stats->stat_diff);

                                                            $sec2 = $value2[0] * 60 + $value2[1];

                                                            $cal_time = $sec1 - $sec2;

                                                            $hours = floor($cal_time / (60 * 60)); //hour
                                                            $cal_time %= 60 * 60;
                                                            $mins = floor($cal_time / 60); //min
                                                            $cal_time %= 60;
                                                            $secs = $cal_time;

                                                        @endphp
                                                        <?php $explode_stat_time = explode(':', $fixture_stats->stat_time_record); ?>
                                                        <input type="number" placeholder="{{ $mins }}"
                                                            class="time-min" value="{{ $mins }}"
                                                            wire:model="save_player_stat_input.{{ $fixture_stats->id }}"
                                                            min="00" max="60">:</input>
                                                        <input type="number" placeholder="{{ $secs }}"
                                                            class="time-min" value="{{ $secs }}"
                                                            wire:model="save_player_stat_input2.{{ $fixture_stats->id }}"
                                                            min="00" max="60">min</input>
                                                        <button class="time-minClose close-btn"
                                                            wire:click="delete_stat({{ $fixture_stats->id }})">&times;</button>
                                                    </span>
                                                @elseif($fixture_stats->sport_stats_id != $stats->id)
                                                @else
                                                @endif
                                            @endforeach

                                            <?php $i = 100; ?>
                                            @foreach ($add_stat as $record_time)
                                                <?php $explode_stat_time = explode(':', $record_time);
                                                $stat_id = $explode_stat_time[4];
                                                $playerId = $explode_stat_time[2];
                                                $teamID = $explode_stat_time[3];
                                                $first_half = 1;
                                                $i++;
                                                ?>
                                                @if ($playerId == $lineup_player_id)
                                                    @if ($stat_id == $stats->id)
                                                        <?php for($s= 0; $s < count($span_class); $s++)
                                                        {
                                                            ?>
                                                        <style>
                                                            .hide<?php echo $span_class[$s]; ?> {
                                                                display: none !important;
                                                            }
                                                        </style>
                                                        <?php
                                                        }
                                                            ?>
                                                        <span class="TimeInputStyle hide{{ $i }}">
                                                            <input type="number"
                                                                placeholder="{{ $explode_stat_time[0] }}"
                                                                class="time-min" max="60" min="00"
                                                                wire:model="player_stat_input.{{ $teamID }}.{{ $teamID }}.{{ $first_half }}.{{ $playerId }}.{{ $stat_id }}.{{ $i }}">:</input>
                                                            <input type="number"
                                                                placeholder="{{ $explode_stat_time[1] }}"
                                                                class="time-min" max="60" min="00"
                                                                wire:model="player_stat_input2.{{ $teamID }}.{{ $teamID }}.{{ $first_half }}.{{ $playerId }}.{{ $stat_id }}.{{ $i }}">min</input>
                                                            <button class="time-minClose close-btn"
                                                                wire:click="remove_stat({{ $i }})">&times;
                                                            </button>
                                                        </span>
                                                    @else
                                                    @endif
                                                @else
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                @if ($second_half_stats > 0)
                                    <h3 class="mb-3 text-center"> Second Half Stats </h3>
                                    @foreach ($stat as $stats)
                                        <div class="row ">
                                            <div class="col-md-2 col-4 pe-0 left-side">
                                                <div class="stat-item">{{ $stats->description }}
                                                    @if ($first_red_card_player == 1 || $first_yellow_card_player == 2)
                                                        <button class="plusadd btn"
                                                            wire:click="red_yellow_card_player()">+</button>
                                                    @else
                                                        <button class="plusadd btn"
                                                            wire:click="add_second_half_stat({{ $stats->id }})">+</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-10 col-8 right-side-stat">
                                                <?php $x = 0; ?>
                                                @foreach ($second_half_fixture_player_stat as $fixture_stats)
                                                    @if ($fixture_stats->sport_stats_id == $stats->id)
                                                        <span class="TimeInputStyle">
                                                            @php
                                                                $value1 = explode(
                                                                    ':',
                                                                    $fixture_stats->stat_time_record,
                                                                );
                                                                $value_count = count($value1);
                                                                if ($value_count == 3) {
                                                                    $sec1 = $value1[1] * 60 + $value1[2];
                                                                } else {
                                                                    $sec1 = $value1[0] * 60 + $value1[1];
                                                                }
                                                                $value2 = explode(':', $fixture_stats->stat_diff);

                                                                $sec2 = $value2[0] * 60 + $value2[1];

                                                                $cal_time = $sec1 - $sec2;

                                                                $hours = floor($cal_time / (60 * 60)); //hour
                                                                $cal_time %= 60 * 60;
                                                                $mins = floor($cal_time / 60); //min
                                                                $cal_time %= 60;
                                                                $secs = $cal_time;
                                                            @endphp

                                                            <?php $explode_stat_time = explode(':', $fixture_stats->stat_time_record); ?>
                                                            <input placeholder="{{ $mins }}" class="time-min"
                                                                type="number"
                                                                wire:model="save_player_stat_input.{{ $fixture_stats->id }}"
                                                                max="60" min="00">:</input>
                                                            <input placeholder="{{ $secs }}" class="time-min"
                                                                type="number"
                                                                wire:model="save_player_stat_input2.{{ $fixture_stats->id }}"
                                                                max="60" min="00">min</input>
                                                            <button class="time-minClose close-btn"
                                                                wire:click="delete_stat({{ $fixture_stats->id }})">&times;</button>
                                                        </span>
                                                    @elseif($fixture_stats->sport_stats_id != $stats->id)
                                                    @else
                                                    @endif
                                                @endforeach

                                                <?php $i = 2100; ?>
                                                @foreach ($second_half_add_stat as $record_time)
                                                    <?php $explode_stat_time = explode(':', $record_time);
                                                    $stat_id = $explode_stat_time[4];
                                                    $playerId = $explode_stat_time[2];
                                                    $teamID = $explode_stat_time[3];
                                                    $first_half = 2;
                                                    $i++;
                                                    ?>
                                                    @if ($playerId == $lineup_player_id)
                                                        @if ($stat_id == $stats->id)
                                                            <?php
                                                            for($s= 0; $s < count($span_class); $s++)
                                                            {
                                                                ?>
                                                            <style>
                                                                .hide<?php echo $span_class[$s]; ?> {
                                                                    display: none !important;
                                                                }
                                                            </style>
                                                            <?php
                                                            }
                                                                ?>

                                                            <span class="TimeInputStyle hide{{ $i }}">
                                                                <input type="number"
                                                                    placeholder="{{ $explode_stat_time[0] }}"
                                                                    class="time-min" max="60" min="00"
                                                                    wire:model="player_stat_input.{{ $teamID }}.{{ $teamID }}.{{ $first_half }}.{{ $playerId }}.{{ $stat_id }}.{{ $i }}">:</input>
                                                                <input type="number"
                                                                    placeholder="{{ $explode_stat_time[1] }}"
                                                                    class="time-min" max="60" min="00"
                                                                    wire:model="player_stat_input2.{{ $teamID }}.{{ $teamID }}.{{ $first_half }}.{{ $playerId }}.{{ $stat_id }}.{{ $i }}">min</input>
                                                                <button class="time-minClose close-btn"
                                                                    wire:click="remove_stat({{ $i }})">&times;
                                                                </button>
                                                            </span>
                                                        @else
                                                        @endif
                                                    @else
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="bg-light-dark01">
                        <table class="table table-responsive table-dark show-stats">
                            <thead>
                                <tr>
                                    <th scope="col ">Player Name</th>
                                    @foreach ($stat as $stats)
                                        <th scope="col">{{ $stats->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($player as $p)
                                    <tr>
                                        <th scope="row">{{ $p->player->first_name }} {{ $p->player->last_name }}
                                        </th>
                                        @foreach ($stat as $stats)
                                            <td>
                                                <?php $i = 0; ?>
                                                @foreach ($match_fixture_stats as $fixture_stats)
                                                    @if ($fixture_stats->sport_stats_id == $stats->id && $p->attendee_id == $fixture_stats->player_id)
                                                        <?php $i++; ?>
                                                    @else
                                                    @endif
                                                @endforeach
                                                {{ $i }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Submit details modal -->

            @if (@$fixture_lapse_type->lapse_type == 4)
                @if ($match_fixture->finishdate_time == null)
                    <button class="btn btn-submit"
                        style="border-radius:.25rem; padding: 0.375rem 0.75rem; margin-top:unset;"
                        onclick="return confirm('Are you sure you want to Finsh the match?') || event.stopImmediatePropagation()"
                        wire:click="finish_match( {{ $match_fixture->id }} )">
                        <img src="{{ asset('frontend/images') }}/noun_finish.png" alt="" class="btn-icon">
                        Finish Match</button>
                @else
                @endif

                <div wire:ignore.self class="modal fade" id="exampleModal" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                                <button class="btn btn-default btn-lg tryagn" type="button" data-bs-dismiss="modal">
                                    <span aria-hidden="true close-btn">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure want to Finish Match? </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close-btn"
                                    data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger close-modal" data-dismiss="modal"
                                    wire:click="finish_match( {{ $match_fixture->id }} )">Yes, Finish</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
        @else
        @endif
        <div class="modal fade" id="select_winner" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Match Tie</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="mt-4 mb-4 row">
                                <div class=" col-md-12 FlotingLabelUp">
                                    <div class="floating-form ">
                                        <div class="floating-label form-select-fancy-1">
                                            <select class="floating-select"
                                                onclick="this.setAttribute('value', this.value);" value=" "
                                                wire:model="tie_winner_teamId">
                                                <option value=""> </option>
                                                <option value="{{ $match_fixture->teamOne->id }}">
                                                    {{ $match_fixture->teamOne->name }}</option>
                                                <option value="{{ $match_fixture->teamTwo->id }}">
                                                    {{ $match_fixture->teamTwo->name }}</option>
                                            </select>
                                            <span class="highlight"></span>
                                            <label>Select Team to Migrate to next round</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            wire:click="closeSelect_winner">Close</button>
                        <button type="button" class="btn " style="background-color:#003b5f; color:#fff;"
                            wire:click="match_tie_winner">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @else
    @endif
    <script>
        window.addEventListener('closeModal', event => {
            $('#recordStats').modal('hide')
        });
    </script>
    <script>
        window.addEventListener('openselectwinner', event => {
            $('#select_winner').modal('show')
        });
    </script>
    <script>
        window.addEventListener('closeselectwinner', event => {
            $('#select_winner').modal('hide')
        });
    </script>
    <script type="text/javascript" src="{{ url('frontend/js/dist_sweetalert.min.js') }}"></script>
    <script>
        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });
        window.addEventListener('swal:confirm', event => {
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.livewire.emit('remove');
                }
            });
        });
    </script>
</div>
