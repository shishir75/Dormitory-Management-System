@extends('layouts.backend.app')

@section('title', 'Show Student Coupon Details')

@push('css')

@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('hall_office.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Show Student Coupon Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="h4">Student Name : <span class="text-bold">{{ $student->name }}</span></p>
                        <p class="h4">Department Name : <span class="text-bold">{{ $student->dept->name }}</span></p>
                        <p class="h4">Available Balance :
                            @if ($balance == null)
                                <span class="text-bold my-2 badge badge-danger">0 BDT</span>
                            @elseif ($balance->amount > 0)
                                <span class="text-bold my-2 badge badge-success">{{ $balance->amount }} BDT</span>
                            @else
                                <span class="text-bold my-2 badge badge-danger">{{ $balance->amount }} BDT</span>
                            @endif
                        </p>
                    </div>
                </div>


                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Trasction Details <span class="float-right badge badge-success py3">Session {{ $student->session->name }}</span></h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Coupon ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($coupon_details as $key => $coupon_detail)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $coupon_detail->name }}</td>
                                            <td >{{ $coupon_detail->type }}</td>
                                            @if ($coupon_detail->is_valid === 'Valid')
                                                <td class="my-2 badge badge-success">+ {{ $coupon_detail->is_valid }}</td>
                                            @else
                                                <td class="my-2 badge badge-danger">- {{ $coupon_detail->is_valid }}</td>
                                            @endif

                                            <td>{{ $coupon_detail->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</td>
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
    </div>
    <!-- /.content-wrapper -->
@endsection



@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

    {{-- <!-- Sweet Alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script> --}}


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




@endpush
