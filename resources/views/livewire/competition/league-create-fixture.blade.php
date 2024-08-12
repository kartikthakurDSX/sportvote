<div class="col-md-6 col-4 text-right" >
    {{-- wire:poll.750ms --}}
    <button class="processed" wire:click="refresh">Refresh</button>
    @if(Auth::check())
        <!-- Button trigger modal -->

        @if(in_array(Auth::user()->id, $admins) || (Auth::user()->id == $competition->user_id))
            @if($competition->comp_start != 1)
                <button type="button" class="btn  btn-submit" style="background-color:#023a5d; margin-top: 0px;" wire:click="start_competition"> Start Comp </button>
            @else
                <button class="btn fs1 " wire:click="all_ics_file"><i class="fa-solid fa-calendar-plusFixture"></i></button>
            @endif

            @if($comp_referee > 0)
                @if($fixtures > 0)
                    <button class="btn esd" data-bs-toggle="modal" data-bs-target="#editfixtureModal01" ><i class="fa-solid fa-eye ViewfixtureIcon"></i></button>
                @else
                    <button type="button" class="btn btn-submit" data-bs-toggle="modal" data-bs-target="#fixtureModal01" style="background-color:#023a5d; margin-top: 0px;"> create fixture </button>
                @endif
            @else
                @if($fixtures > 0)
                    <button class="btn esd" id="wait_for_referee" ><i class="fa-solid fa-eye ViewfixtureIcon"></i></button>
                @else
                    <button type="button" class="btn btn-submit" id="wait_for_referee" style="background-color:#023a5d;">create fixture</button>
                @endif
            @endif
        @else
            @if($competition->comp_start == 1)
            <button class="btn fs1 " wire:click="all_ics_file"><i class="fa-solid fa-calendar-plusFixture"></i></button>
            @else
            @endif
            <button class="btn " data-bs-toggle="modal" data-bs-target="#editfixtureModal01" ><i class="fa-solid fa-eye ViewfixtureIcon"></i> </button>
        @endif
    @else
    @endif
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

    window.addEventListener('swal:modal', event => {
        console.log('swal:modal event detail:', event.detail[0].message);
        swal({
        title: event.detail[0].message,
        text: event.detail.message,
        icon: event.detail.type,
        });
    });

    window.addEventListener('swal:confirm', event => {
        swal({
        title: event.detail[0].message,
        text: event.detail.message,
        icon: event.detail.type,
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            window.livewire.emit('remove');
        }
        });
    });
    </script>
</div>
