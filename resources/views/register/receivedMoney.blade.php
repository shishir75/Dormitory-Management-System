@extends('layouts.backend.app')

@section('title', 'Halls Bills')

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
                            <li class="breadcrumb-item"><a href="{{ route('register.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Halls Bills</li>
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
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#makePayment">
                            Receive Payment
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="makePayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('register.received_money.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="hall_id" class="col-form-label">Hall Name - Pending Balance</label>
                                                <select class="custom-select" name="hall_id" required>
                                                    <option value="" selected disabled>Select a Hall</option>
                                                        @foreach ($halls as $hall)
                                                            <option class="text-{{ $hall->pending_bill <= 0 ? "success" : "danger" }}" value="{{ $hall->id }}">{{ $hall->name }} -
                                                                ({{ number_format($hall->pending_bill, 2) }} BDT)
                                                            </option>
                                                        @endforeach
                                                  </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="amount">Pay Amount</label>
                                                <input type="number" name="amount" class="form-control" required id="amount" placeholder="Enter Pay Amount">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Pay Bill</button>
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
                                <h3 class="card-title">{{ strtoupper('Transaction History') }}
                                    <span class="float-right">
                                        @if ($register_balance !== null)
                                            {{ $register_balance->amount >= 0 ? 'Advanced Balance : ' : 'Owing Balance : ' }}
                                            <span class="badge badge-{{ $register_balance->amount >= 0 ? 'success' : 'danger' }}">
                                                {{ abs(number_format($register_balance->amount, 2)) }} BDT
                                            </span>
                                        @else
                                           Available Balance 0 BDT
                                        @endif
                                    </span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Transaction Name</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Transaction Name</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($transactions as $key => $transaction)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $transaction->name }}</td>
                                                <td>
                                                    @if ($transaction->type == "Credit")
                                                        <span class="badge badge-sm badge-success">Credit</span>
                                                    @else
                                                        <span class="badge badge-sm badge-danger">Debit</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($transaction->type == "Credit")
                                                        <span class="badge badge-sm badge-success">+{{ number_format($transaction->amount, 2) }} BDT</span>
                                                    @else
                                                        <span class="badge badge-sm badge-danger">-{{ number_format($transaction->amount, 2) }} BDT</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->created_at->isoFormat('MMM Do YYYY, h:mm:ss A') }}</td>
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
