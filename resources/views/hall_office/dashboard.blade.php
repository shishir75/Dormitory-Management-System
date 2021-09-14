@extends('layouts.backend.app')

@section('title', 'Dashboard')

@push('css')

@endpush

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-book"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Current Students</span>
                                <span class="info-box-number">{{ $current_students }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-clock-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Awaiting Approval</span>
                                <span class="info-box-number">{{ $pending_approval_students }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-user"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Ex-Students</span>
                                <span class="info-box-number">{{ $ex_students }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-gray"><i class="fa fa-user-plus"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Seats</span>
                                <span class="info-box-number">{{ $hall->total_seat }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Available Seats</span>
                                <span class="info-box-number">{{ $hall->available_seat}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-graduation-cap"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Students</span>
                                <span class="info-box-number">{{ $current_students + $pending_approval_students + $ex_students }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-bitcoin"></i></span>

                            <div class="info-box-content">
                                @if ($hall_office_balance !== null)
                                    <span class="info-box-text">{{ $hall_office_balance->amount > 0 ? 'Hall Available Balance' : 'Hall Owing Balance' }}</span>
                                    <span class="info-box-number text-{{ $hall_office_balance->amount > 0 ? 'success' : 'danger' }}">
                                        {{ abs(number_format($hall_office_balance->amount, 2)) }} BDT
                                    </span>
                                @else
                                    <span class="info-box-text">Available Balance</span>
                                    <span class="info-box-number text-danger">
                                        0.00 BDT
                                    </span>
                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-coffee"></i></span>

                            <div class="info-box-content">
                                @if ($dining_balance !== null)
                                    <span class="info-box-text">{{ $dining_balance->amount > 0 ? 'Dining Available Balance' : 'Dining Owing Balance' }}</span>
                                    <span class="info-box-number text-{{ $dining_balance->amount > 0 ? 'success' : 'danger' }}">
                                        {{ abs(number_format($dining_balance->amount, 2)) }} BDT
                                    </span>
                                @else
                                    <span class="info-box-text">Dining Available Balance</span>
                                    <span class="info-box-number text-danger">
                                        0.00 BDT
                                    </span>
                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-dollar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Pending Hall Bill to Register</span>
                                <span class="info-box-number">{{ number_format($hall->pending_bill, 2) }} BDT</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->


                 <!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<div class="col-md-5">
						<!-- DIRECT CHAT -->
						<div class="card direct-chat direct-chat-warning">
							<div class="card-header">
								<h3 class="card-title">Latest Transactions</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<table class="table table-striped table-bordered table-valign-middle text-center">
									@if ($transactions->count() > 0)
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                    @endif

									<tbody>
                                        @if ($transactions->count() > 0)
                                            @foreach($transactions as $key => $latest_transaction)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $latest_transaction->name }}</td>
                                                    <td><span class="badge badge-{{ $latest_transaction->type == 'Credit' ? 'success' : 'danger' }}">{{ $latest_transaction->type }}</span></td>
                                                    <td>{{ number_format($latest_transaction->amount, 2) }} BDT</td>
                                                    <td>{{ $latest_transaction->created_at->diffInMinutes() <= 1440 ?  $latest_transaction->created_at->diffForHumans() : $latest_transaction->created_at->format('jS F Y') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <h5 class="text-danger text-center my-3">No Transaction Found</h5>
                                        @endif
									</tbody>
								</table>
							</div>
						</div>
						<!--/.direct-chat -->
					</div>
					<!-- /.col -->

					<div class="col-md-7">

                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat direct-chat-warning">
                            <div class="card-header">
                                <h3 class="card-title">Latest Hall Bills by Students</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped table-bordered table-valign-middle text-center">
                                    @if ($hall_bills->count() > 0)
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Student Name</th>
                                                <th>Session</th>
                                                <th>From Month</th>
                                                <th>To Month</th>
                                                <th>Amount</th>
                                                <th>Bought Time</th>
                                            </tr>
                                        </thead>
                                    @endif

                                    <tbody>
                                        @if ($hall_bills->count() > 0)
                                            @foreach($hall_bills as $key => $hall_bill)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $hall_bill->student->name }}</td>
                                                    <td>{{ $hall_bill->student->session->name }}</td>
                                                    <td>{{ $hall_bill->start_month->format('M-Y') }}</td>
                                                    <td>{{ $hall_bill->end_month->format('M-Y') }}</td>
                                                    <td>{{ number_format($hall_bill->amount, 2) }} BDT</td>
                                                    <td>{{ $hall_bill->created_at->diffInMinutes() <= 1440 ?  $hall_bill->created_at->diffForHumans() : $hall_bill->created_at->format('jS F Y') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <h5 class="text-danger text-center my-3">No Coupon Found</h5>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/.direct-chat -->

					</div>
					<!-- /.col -->
				</div>







            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->





@endsection



@push('js')

@endpush
