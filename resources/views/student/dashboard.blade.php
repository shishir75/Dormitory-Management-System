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
                    <div class="col-12">
                        @if ($student->status === 1)
                            <div class="alert alert-success alert-dismissible fade show text-center"  role="alert">
                                Welcome! Dear <span class="text-bold">{{ $student->name }}</span>, You are our Current Student. Keep Studying. Break a Leg!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @else
                            <div class="alert alert-danger text-center"  role="alert">
                                Your Student Validty is Expired! Plz Pay All Dues & Leave Seat. Thanks!!
                            </div>
                        @endif

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-home"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Hall Name</span>
                                <span class="info-box-number">{{ $student->hall->name }}</span>
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
                                <span class="info-box-text">Session</span>
                                <span class="info-box-number">{{ $student->session->name }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-odnoklassniki"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Allotted Room No</span>
                                <span class="info-box-number">
                                    @if ($student->room_no === null)
                                        {{ $student->room_no }}
                                    @else
                                        <span class="text-danger">Room Not Allotted</span>
                                    @endif

                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-bitcoin"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Available Balance</span>
                                <span class="info-box-number">{{ number_format($balance->amount, 2) }} BDT</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-coffee"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Food Taken</span>
                                <span class="info-box-number">{{ $coupons->count() }} UNITS</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-gray"><i class="fa fa-btc"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $due_bill >= 0 ? "Holding Hall Bill" : "Due Hall Bill" }}</span>
                                <span class="info-box-number">{{ number_format($due_bill, 2)}} BDT</span>
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
					<div class="col-md-6">
						<!-- DIRECT CHAT -->
						<div class="card direct-chat direct-chat-warning">
							<div class="card-header">
								<h3 class="card-title">Latest Transactions</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<table class="table table-striped table-bordered table-valign-middle text-center">
									<thead>
									<tr>
										<th>S.N</th>
										<th>Title</th>
										<th>Type</th>
										<th>Amount</th>
										<th>Time</th>
									</tr>
									</thead>
									<tbody>
                                        @foreach($latest_transactions as $key => $latest_transaction)
											<tr>
												<td>{{ $key + 1 }}</td>
												<td>{{ $latest_transaction->name }}</td>
												<td><span class="badge badge-{{ $latest_transaction->type == 'Credit' ? 'success' : 'danger' }}">{{ $latest_transaction->type }}</span></td>
												<td>{{ number_format($latest_transaction->amount, 2) }} BDT</td>
												<td>{{ $latest_transaction->created_at->diffInMinutes() <= 1440 ?  $latest_transaction->created_at->diffForHumans() : $latest_transaction->created_at->format('jS F Y') }}</td>
											</tr>

											@if($key > 8)
												@break;
											@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<!--/.direct-chat -->
					</div>
					<!-- /.col -->

					<div class="col-md-6">

                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat direct-chat-warning">
                            <div class="card-header">
                                <h3 class="card-title">Latest Bought Food Coupons</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped table-bordered table-valign-middle text-center">
                                    <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Coupon ID</th>
                                        <th>Coupon Date</th>
                                        <th>L/D</th>
                                        <th>Unit Price</th>
                                        <th>Status</th>
                                        <th>Bought Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coupons as $key => $coupon)
											<tr>
												<td>{{ $key + 1 }}</td>
												<td>{{ $coupon->coupon_no }}</td>
                                                <td>{{ $coupon->coupon->coupon_date }}</td>
                                                <td><span class="badge badge-success">Lunch</span></td>
                                                <td>{{ number_format($coupon->coupon->unit_price, 2) }} BDT</td>
												<td><span class="badge badge-{{ $coupon->is_valid == 'unused' ? 'success' : 'danger' }}">{{ ucwords($coupon->is_valid) }}</span></td>
												<td>{{ $coupon->created_at->diffInMinutes() <= 1440 ?  $coupon->created_at->diffForHumans() : $coupon->created_at->format('jS F Y') }}</td>
											</tr>

											@if($key > 8)
												@break;
											@endif
										@endforeach
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
