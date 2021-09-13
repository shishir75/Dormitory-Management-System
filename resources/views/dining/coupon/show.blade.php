@extends('layouts.backend.app')

@section('title', 'Dining Coupons Details')

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
                            <li class="breadcrumb-item"><a href="{{ route('dining.dashboard') }}">Dining Dashboard</a></li>
                            <li class="breadcrumb-item active">Dining Coupons Details</li>
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
                                <h3 class="card-title">Students list of <span class="badge badge-success">{{ $coupon_details[0]->coupon->coupon_date  }}</span>
                                    <span class="badge badge-info float-right">{{ $dining->name }}</span>
                                </h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Student Name</th>
                                        <th>Session</th>
                                        <th>Coupon ID</th>
                                        <th>Validity</th>
                                        <th>Change Validity</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Student Name</th>
                                            <th>Session</th>
                                            <th>Coupon ID</th>
                                            <th>Validity</th>
                                            <th>Change Validity</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($coupon_details as $key => $coupon_detail)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $coupon_detail->student->name }}</td>
                                            <td>{{ $coupon_detail->student->session->name }}</td>
                                            <td>{{ $coupon_detail->coupon_no }}</td>
                                            @if ($coupon_detail->is_valid === 'unused')
                                                <td class="my-2 badge badge-success">Unused</td>
                                            @else
                                                <td class="my-2 badge badge-danger">Used</td>
                                            @endif
                                            <td>
                                                <button class="btn btn-danger" type="button" onclick="deleteItem({{ $coupon_detail->id }})">
                                                     Change
                                                </button>
                                                <form id="delete-form-{{ $coupon_detail->id }}" action="{{ route('dining.coupon.update', $coupon_detail->id) }}" method="post"
                                                      style="display:none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            </td>
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
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>


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

    <script type="text/javascript">
        function deleteItem(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!',
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
    </script>

@endpush
