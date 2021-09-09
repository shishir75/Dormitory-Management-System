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
                        <p class="h4">Dept. Name : <span class="text-bold">{{ $student->dept->name }}</span></p>
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
                    <div class="col-md-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#purchaseCoupon">
                            Purchase a Coupon
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="purchaseCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Purchase a Coupon</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form action="{{ route('student.coupon.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="coupon_date">Purchase a Coupon (Date - Unit Price - Available Unit)</label>
                                            <select class="form-control" name="coupon_id" id="coupon_date">
                                                <option value="" selected disabled>Select a Coupon</option>
                                                @foreach ($coupons as $coupon )
                                                    <option value="{{ $coupon->id }}">Date : {{ $coupon->coupon_date }} - BDT {{ $coupon->unit_price }} - {{ $coupon->max_count }} Unit</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Purchase</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>


                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Food Coupon Details <span class="float-right badge badge-success py3">{{ $dining->name }}</span></h3>
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
                                            <td>{{ $coupon_detail->coupon_no }}</td>
                                            <td >{{ $coupon_detail->coupon->coupon_date }}</td>
                                            <td>{{ $coupon_detail->coupon->unit_price }} BDT</td>
                                            @if ($coupon_detail->is_valid === 'unused')
                                                <td class="my-2 badge badge-success">Unused</td>
                                            @else
                                                <td class="my-2 badge badge-danger"></td>Used</td>
                                            @endif
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