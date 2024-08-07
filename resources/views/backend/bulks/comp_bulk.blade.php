@include('backend.includes.loginheader')
@include('backend.includes.nav')
@include('backend.includes.sidebar')
<div class="content-wrapper mt-2">
    <div class="container">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <!-- Content Header (Page header) -->
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">All Competitions</h3>

                <div class="float-right">
                   <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#exampleModalLong"><i class="fa-solid fa-upload"></i> Import
                        </button>

                </div>
                <div class="float-right">
                     <a href="{{ url('comp-csv') }}">
                    <span  id="export" class="btn btn-success btn-sm"
                        > <i class="fa-solid fa-download"></i> Download Sample csv</span>
                         </a>
                </div>
            </div>
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Import competitions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('admin-Competition-import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-sm-12">
                                    <!-- select -->
                                    <div class="form-group">
                                        <label>Select Admin</label>
                                        <select class="form-control" name="admin_id">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }}
                                                    {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="file">
                                    <label for="inputTag">
                                        Select File<br />
                                        <i class="fa fa-2x fa-file"></i>
                                        <input id="inputTag" type="file" name="import" />
                                        <br />
                                        <span id="imageName"></span>
                                    </label>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body AllCompAdminpPnl">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Competition Name</th>
                            <th>Type</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i =1;
                        @endphp
                        @foreach ($competitions as $module)

                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $module->name }}</td>
                                <td>{{ $module->comptype->name }}</td>
                                <td>{{ $module->user->first_name }} {{ $module->user->last_name }}</td>
                                <td>
                                    <div class="row">

                                        <div class=" col-md-4">
                                            <a href="{{ url('competition/' . $module->id) }}" target="_blank"><i
                                                    class="fa-solid fa-eye fs-5 text-pink"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.content -->
    </div>
</div>



@include('backend.includes.footer')


<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/dist/js/demo.js') }}"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            //   "buttons": ["copy", "csv", "excel", "pdf",]
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    let input = document.getElementById("inputTag");
    let imageName = document.getElementById("imageName")

    input.addEventListener("change", () => {
        let inputImage = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage.name;
    })
</script>

{{-- For download Sample csv file  --}}
