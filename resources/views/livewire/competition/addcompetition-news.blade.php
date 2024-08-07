<div class="row M-topSpace">
    @if (Auth::check())
        <div class="pr-0 col-xl-1 col-lg-1 col-md-2 col-sm-3 col-3">
            <div class="news1">
                <span class="Newsheding">NEWS</span>
            </div>
        </div>
        <div class="p-0  col-xl-9 col-lg-9 col-md-7 col-sm-6 col-9">
            <div class="Postnews">
                <marquee class="newsfloting" behavior="scroll" direction="left">
                    @foreach ($competition_news_five as $news)
                        <?php
                        $time = $news->created_at->setTimezone($timezone);
                        ?>
                        <span style ="margin-right:800px;"><b>{{ $news->user->first_name }} {{ $news->user->last_name }}
                                on {{ date('d M Y', strtotime($news->created_at)) }} at
                                {{ date('H:i', strtotime($time)) }}</b> - {{ $news->description }} </span>
                    @endforeach
                </marquee>
            </div>
        </div>
        <div class="p-0 col-xl-2 col-lg-2 col-md-3 col-sm-3">
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $comp->user_id)
                <div class="newsPost" type="button" wire:click="open_addcompetition_news">
                    <span class="NewshedingPost">POST NEWS</span>
                </div>
            @else
                <div class="newsPost" type="button">
                    {{-- wire:click="open_addcompetition_news" --}}
                    <span class="NewshedingPost">VIEW NEWS</span>
                </div>
            @endif
        </div>
        <!-- Post and News  -->
        <div class="modal fade" id="PostNews" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">News</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="app">
                            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $comp->user_id)
                                <div class="header">
                                    <div class="left-info">
                                        <div class="thumbnail">
                                            <img src="{{ url('frontend/profile_pic') }}/{{ $auth_user->profile_pic }}"
                                                alt>
                                        </div>
                                        <div class="name-info">
                                            <div class="name">
                                                <a href="">{{ $auth_user->first_name }}
                                                    {{ $auth_user->last_name }}</a>
                                            </div>
                                            <div class="time">
                                                <?php
                                                $dt = now();
                                                $dt->setTimezone($timezone);
                                                echo $dt->format('H:i'); ?>
                                                <i class="global-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-1 wrapper">
                                    <div class="input-box">
                                        <div class="tweet-area">
                                            <!-- <span class="placeholder" >What's happening?</span> -->
                                            <textarea class="input editable custom_editable" wire:model="news_description" placeholder="What's happening?"
                                                wire:keyup="desc_length"></textarea>
                                            <!-- <div class="input editable" contenteditable="true" spellcheck="false"></div>
                      <div class="input readonly" contenteditable="true" spellcheck="false" wire:ignore.self></div> -->
                                        </div>
                                    </div>
                                    @if ($is_save == 0)
                                        <span class="sv_error"> {{ $msg }} </span>
                                    @else
                                    @endif
                                    <div class="bottom">
                                        <ul class="icons">
                                            <!-- <li>
                          <label for="formFile" class="form-label"><i class="far fa-file-image "></i></label>
                          <input class="form-control" type="file" id="formFile">
                      </li>
                      <li><i class="far fa-grin" ></i></li> -->
                                        </ul>
                                        <div class="content">
                                            <span class="custom_counter">{{ $char_count }}</span>
                                            @if ($is_save == 0)
                                                <span type="button" class="post_span">Post</span>
                                            @else
                                                <button type="button" wire:click="addcomp_news"
                                                    class="active">Post</button>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            @else
                            @endif
                            @if ($competition_news->count() > 0)
                                @foreach ($competition_news as $news)
                                    <div class="PostDetail">
                                        <?php $news_admin = App\models\User::find($news->user_id); ?>
                                        <a href="" class="avtar">
                                            <img src="{{ url('frontend/profile_pic') }}/{{ $news_admin->profile_pic }}"
                                                alt="">
                                        </a>
                                        <div class="infoContainer">
                                            <div class="header">
                                                <div class="nameContainer left-info">
                                                    <?php
                                                    $date_time = $news->created_at;
                                                    $date_time->setTimezone($timezone);
                                                    ?>
                                                    <a href="">
                                                        <span class="name">{{ $news_admin->first_name }}
                                                            {{ $news_admin->last_name }}</span>
                                                        <span class="atMe">{{ $news_admin->email }}</span>
                                                        <span class="time">{{ $news->created_at->diffForHumans() }}
                                                        </span>
                                                    </a>
                                                </div>
                                                @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $comp->user_id)
                                                    <div class="right-info deleteicon"
                                                        onclick="return confirm('Are you sure you want to delete this?') || event.stopImmediatePropagation()"
                                                        wire:click="delete_post( {{ $news->id }} )">
                                                        <i class="icon-trash "></i>
                                                    </div>
                                                @else
                                                @endif
                                            </div>
                                            <div class="message">
                                                <p>{{ $news->description }}</p>
                                                <!-- <img src="images/test-img.png" alt=""> -->
                                            </div>
                                            <div class="btns">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center"> No Data Found </p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row M-topSpace">
            <div class="pr-0 col-xl-1 col-lg-1 col-md-2 col-sm-3 col-3">
                <div class="news1">
                    <span class="Newsheding">NEWS</span>
                </div>
            </div>
            <div class="p-0  col-xl-9 col-lg-9 col-md-7 col-sm-6 col-9">
                <div class="Postnews">
                    <marquee class="newsfloting" behavior="scroll" direction="left">
                        @foreach ($competition_news_five as $news)
                            <?php
                            $time = $news->created_at->setTimezone($timezone);
                            ?>
                            <span style ="margin-right:800px;"><b>{{ $news->user->first_name }}
                                    {{ $news->user->last_name }} on {{ date('d M Y', strtotime($news->created_at)) }}
                                    at {{ date('H:i', strtotime($time)) }}</b> - {{ $news->description }} </span>
                        @endforeach
                    </marquee>
                </div>
            </div>
            <div class="p-0 col-xl-2 col-lg-2 col-md-3 col-sm-3">
                <div class="newsPost" type="button">
                    <span class="NewshedingPost" data-bs-toggle="modal" data-bs-target="#join_login_modal">VIEW
                        NEWS</span>
                </div>
            </div>
        </div>
    @endif
    <script>
        window.addEventListener('OpennewsModal', event => {
            $('#PostNews').modal('show')
        })
    </script>
</div>
