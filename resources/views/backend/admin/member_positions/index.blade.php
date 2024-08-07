@include('backend.includes.loginheader')
@include('backend.includes.nav')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
@include('backend.includes.sidebar')


<!-- With actions -->
<div class="content-wrapper mt-2">
    <div class="container">
        @if ($message = Session::get('message'))
            <div class="alert alert-success">
                <p align="center">{{ $message }} <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true" class="display6">&times;</span>
                    </button> </p>

            </div>
        @endif

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th colspan="9">

                                <h4 class="text-lg font-semibold text-light-600 dark:text-light-300 heading">
                                    Member Positions
                                </h4>
                            </th>
                        </tr>


                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Member Position Name</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Sport Name</th>
                            <th class="px-4 py-3">Member Type</th>
                            {{-- <th class="px-4 py-3">Status</th> --}}
                            <th class="px-4 py-3">Actions</th>
                            <th class="px-4 py-3">
                                <a href="{{ url('admin-add-member-position') }}"><button class="add-attitude-btn"
                                        role="button">Create
                                        +</button>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($MemberPositions as $MemberPosition)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $MemberPosition->name }}</p>


                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm description">



                                    {{ $MemberPosition->description }}



                                </td>


                                <td class="px-4 py-3 text-sm">

                                    {{ $MemberPosition->sport->name }}


                                </td>
                                <td class="px-4 py-3 text-sm">

                                    @if ($MemberPosition->member_type == 1)
                                        {{ 'Player/Refree' }}
                                    @endif
                                    @if ($MemberPosition->member_type == 2)
                                        {{ 'Team Admin' }}
                                    @endif
                                    @if ($MemberPosition->member_type == 3)
                                        {{ 'Comp Admin' }}
                                    @endif

                                </td>


                                {{-- <td>
                                    <div class="checkbox-wrapper-56">
                                        <label class="container">
                                            <input type="checkbox" data-id="{{ $MemberPosition->id }}"
                                                class="toggle-class" data-toggle="toggle" data-on="Active"
                                                data-off="InActive" {{ $MemberPosition->is_active ? 'checked' : '' }}>
                                            <div class="checkmark"></div>
                                        </label>
                                    </div>
                                </td> --}}

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">

                                        <a href="{{url('admin/member-position/'.$MemberPosition->id.'/edit')}}">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-info rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </a>
                                        <form action="{{url('admin/member-position/'.$MemberPosition->id.'/delete')}}"
                                            method="POST" onsubmit="return confirm('Are you sure ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeMemberPositionStatus',
                data: {
                    'status': status,
                    'id': id
                },
                success: function(data) {
                    console.log(data.success)
                }
            });
        })
    })
</script>

@include('backend.includes.footer')
