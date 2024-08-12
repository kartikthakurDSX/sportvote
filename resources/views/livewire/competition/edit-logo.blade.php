<span>
    @if (Auth::check())
        <div>
            <a href="" class="user-profile-imgTeam"><img
                    src="{{ asset('frontend/logo') }}/{{ $competition->comp_logo }}" width="100%"
                    class="img-fluid competitionlogo" alt="competition-logo"></a>
            @if (in_array(Auth::user()->id, $admins) || Auth::user()->id == $competition->user_id)
                <a wire:click="open_editcomp_logo" style="cursor:pointer;"><span class="Edit-Icon-white EditProfileOne">
                    </span></a>
            @else
            @endif

            <div class="modal fade" id="edit_complogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Competition Logo</h5>
                            </div>
                            <div class="modal-body">
                                <div class="">
                                    <div class="row">
                                        <div class=" col-md-12 mb-4 FlotingLabelUp">
                                            <div class="floating-form "></br>
                                                <div class="floating-label form-select-fancy-1">
                                                    <input class="floating-input" type="file" id="file"
                                                        placeholder=" " name="file" wire:click="close_comp_logo">
                                                    <span class="highlight"></span>
                                                    <label>Select Competition Logo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    wire:click="close_comp_logo">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <a href="" class="user-profile-imgTeam"><img
                src="{{ asset('frontend/logo') }}/{{ $competition->comp_logo }}" width="100%"
                class="img-fluid competitionlogo" alt="competition-logo"></a>
    @endif
    <script>
        window.addEventListener('OpencomplogoModal', event => {
            $('#edit_complogo').modal('show')
        })
    </script>
    <script>
        window.addEventListener('ClosecomplogoModal', event => {
            $('#edit_complogo').modal('hide')
        })
    </script>
    @once
        <script src="{{ asset('frontend/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
        <script>
            $('#file').ijaboCropTool({
                preview: '.competitionlogo',
                setRatio: 1,
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                buttonsText: ['CROP & SAVE', 'QUIT'],
                buttonsColor: ['#30bf7d', '#ee5155', -15],
                processUrl: '{{ url('edit_complogo/' . $complogo_id) }}',
                withCSRF: ['_token', '{{ csrf_token() }}'],
                onSuccess: function(message, element, status) {

                    //location.reload();
                },
                onError: function(message, element, status) {
                    alert(message);
                }
            });
        </script>
    @endonce

</span>
