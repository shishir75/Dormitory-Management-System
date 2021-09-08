@extends('layouts.backend.app')

@section('title', 'Allotted Students')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('hall_office.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Allotted Students</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ strtoupper('Students list of '.$hall->name ) }}
                                    <span class="float-right btn btn-sm btn-success">Session {{ $session->name}} </span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Dept Name</th>
                                        <th>Room No</th>
                                        <th>Room Allocation</th>
                                        <th>Balance</th>
                                        <th>Add Money</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Dept Name</th>
                                        <th>Room No</th>
                                        <th>Room Allocation</th>
                                        <th>Balance</th>
                                        <th>Add Money</th>
                                        <th>Details</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($students as $key => $student)
                                        <tr id="{{ $student->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->session->name }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>{{ $student->dept->short_name }}</td>
                                            <td>
                                                @if($student->room_no == null)
                                                    <p class="badge badge-warning">Not Allocated</p>
                                                @else
                                                    {{ $student->room_no }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($student->room_no == null)
                                                    <!-- Button trigger modal -->
                                                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-id="{{ $student->id }}" data-target="#showData-{{ $student->id}}">
                                                        <i class="fa fa-user-plus fa-lg"></i>
                                                    </a>
                                                @else
                                                    <p class="badge badge-success"><i class="fa fa-check-circle fa-lg"></i></p>
                                                @endif

                                                <!-- Allocation Modal -->
                                                <div class="modal fade" id="showData-{{ $student->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Room Allocation</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <form role="form" action="{{ route('hall_office.allotted-students.update', $student->id) }}" method="POST" id="updateForm">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group" id="user-data">
                                                                            <label for="exampleFormControlSelect1">Select Room for {{ $student->name }}</label>
                                                                            <select class="form-control" name="room_no" id="room_no">
                                                                              <option value="" selected disabled>Select One</option>
                                                                              @foreach ($available_hall_rooms as $available_hall_room)
                                                                                <option value="{{ $available_hall_room->room_no }}">Room No {{ $available_hall_room->room_no }} - (S : {{ $available_hall_room->seat_count }} - A : {{ $available_hall_room->available_seat }})</option>
                                                                              @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <th>
                                                @if ($student->balance == null)
                                                    <p class="badge badge-danger">0 BDT</p>
                                                @elseif ($student->balance->amount > 0)
                                                    <p class="badge badge-success">
                                                        {{ $student->balance->amount }} BDT
                                                    </p>
                                                @else
                                                    <p class="badge badge-danger">
                                                        {{ $student->balance->amount }} BDT
                                                    </p>
                                                @endif
                                            </th>
                                            <th>
                                                <a class="btn btn-sm btn-success" data-toggle="modal" data-id="{{ $student->id }}" data-target="#addBalance-{{ $student->id}}">
                                                    <i class="fa fa-plus-square fa-lg"></i>
                                                </a>

                                                 <!-- Add Balance Modal -->
                                                 <div class="modal fade" id="addBalance-{{ $student->id}}" tabindex="-1" role="dialog" aria-labelledby="addBalance" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Money</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <form role="form" action="{{ route('hall_office.allotted-students.add-money', $student->id) }}" method="POST" id="updateForm">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label for="exampleFormControlSelect2">Add Money for {{ $student->name }}</label>
                                                                        <div class="form-group row">
                                                                            <label for="inputPassword" class="col-sm-6 col-form-label">Add Money</label>
                                                                            <div class="col-sm-6">
                                                                              <input type="number" class="form-control" name="amount" placeholder="Enter Amount in BDT">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Add Balance</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>

                                            </th>
                                            <th>
                                                <a href="{{ route('hall_office.allotted-students.details', $student->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-question-circle fa-lg"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div> <!-- Content Wrapper end -->
@endsection




@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

    <!-- Sweet Alert Js -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script> --}}


    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>


    {{-- <script type="text/javascript">
        function deleteItem(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script> --}}

@endpush
