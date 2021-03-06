@extends('layouts.backend.app')

@section('title', 'Dining Coupons')

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
                            <li class="breadcrumb-item active">Dining Coupons</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target=".bd-example-modal-lg">
                            Add New Date for Dining Coupon
                        </button>

                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add New Date for Dining Coupon</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('dining.coupon.store') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="coupon_date">Coupon Date</label>
                                                    <input type="date" class="form-control" name="coupon_date" required>
                                                </div>
                                                <div class="col">
                                                    <label for="coupon_date">For Lunch / Dinner</label>
                                                    <select class="form-control" name="type" required aria-label="Default select example">
                                                        <option value="" disabled selected>Select a Meal</option>
                                                        <option value="L">Lunch</option>
                                                        <option value="D">Dinner</option>
                                                      </select>
                                                </div>
                                                <div class="col">
                                                    <label for="unit_price">Coupon Unit Price</label>
                                                    <input type="number" class="form-control" name="unit_price" required placeholder="Enter Unit Price">
                                                </div>
                                                <div class="col">
                                                    <label for="max_count">Coupon Max Quantity</label>
                                                  <input type="number" name="max_count" class="form-control" required placeholder="Max Quantity">
                                                </div>
                                              </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ strtoupper('Open Dates list of '.$dining->username ) }}</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Date</th>
                                        <th>L / D</th>
                                        <th>Unit Price</th>
                                        <th>Available Coupons</th>
                                        <th>Details</th>
                                        <th>Cancel</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Date</th>
                                            <th>L / D</th>
                                            <th>Unit Price</th>
                                            <th>Available Coupons</th>
                                            <th>Details</th>
                                            <th>Cancel</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($coupon_dates as $key => $coupon)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $coupon->coupon_date->format('d-M-Y') }}</td>
                                            <td>
                                                @if ($coupon->type === 'L')
                                                    <span class="badge badge-success">Lunch</span>
                                                @else
                                                    <span class="badge badge-info">Dinner</span>
                                                @endif
                                            </td>
                                            <td>{{ $coupon->unit_price }} BDT</td>
                                            <td>{{ $coupon->max_count - $coupon->sold_coupon }} UNITS</td>
                                            <td>
                                                <a href="{{ route('dining.coupon.show', $coupon->id) }}" class="btn btn-info">
                                                    View Details
                                                </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" type="button" onclick="deleteItem({{ $coupon->id }})">
                                                    Cancel
                                               </button>
                                               <form id="delete-form-{{ $coupon->id }}" action="{{ route('dining.coupon.destroy', $coupon->id) }}" method="post"
                                                     style="display:none;">
                                                   @csrf
                                                   @method('DELETE')
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
