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
                        @elseif ($student->status === 2)
                            <div class="alert alert-danger text-center"  role="alert">
                                Your Student Validity is Expired! Plz Pay All Dues & Leave Seat. Thanks!!
                            </div>
                        @else
                            <div class="alert alert-info text-center"  role="alert">
                                Thanks For Being with Us. You are now our Ex Student. You are now on view mode only.
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
                                    @if ($student->room_no !== null)
                                        <span class="text-success">{{ $student->room_no }}</span>
                                    @else
                                        @if ($student->status === 3)
                                            <span class="text-danger">Leave</span>
                                        @else
                                            <span class="text-danger">Room Not Allotted</span>
                                        @endif
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
                                @if ($balance !== null)
                                    <span class="info-box-text">{{ $balance->amount > 0 ? 'Available Balance' : 'Owing Balance' }}</span>
                                    <span class="info-box-number text-{{ $balance->amount > 0 ? 'success' : 'danger' }}">
                                        {{ abs(number_format($balance->amount, 2)) }} BDT
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
                            <span class="info-box-icon bg-info"><i class="fa fa-coffee"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Food Taken</span>
                                <span class="info-box-number">{{ $coupon_count }} UNITS</span>
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
                                <span class="info-box-text">{{ $due_bill_sign === false ? "Advanced Paid Hall Bill" : "Due Hall Bill" }}</span>
                                <span class="info-box-number text-{{ $due_bill_sign === false ? 'success' : 'danger' }}">{{ number_format($due_bill, 2)}} BDT</span>
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
									@if ($latest_transactions->count() > 0)
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
                                        @if ($latest_transactions->count() > 0)
                                            @foreach($latest_transactions as $key => $latest_transaction)
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

					<div class="col-md-6">

                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat direct-chat-warning">
                            <div class="card-header">
                                <h3 class="card-title">Latest Bought Food Coupons</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped table-bordered table-valign-middle text-center">
                                    @if ($coupon_count > 0)
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
                                    @endif

                                    <tbody>
                                        @if ($coupon_count > 0)
                                            @foreach($coupons as $key => $coupon)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $coupon->coupon_no }}</td>
                                                    <td>{{ $coupon->coupon->coupon_date->format('d-M-Y') }}</td>
                                                    <td>
                                                        @if ($coupon->coupon->type === "L")
                                                            <span class="badge badge-success">Lunch</span>
                                                        @else
                                                            <span class="badge badge-info">Dinner</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ number_format($coupon->coupon->unit_price, 2) }} BDT</td>
                                                    <td>
                                                        @if ($coupon->is_valid == 'unused')

                                                            @php
                                                                $coupon_date =(int) $coupon->coupon->coupon_date->format('Ymd');
                                                                $current_date =(int) date('Ymd');
                                                            @endphp

                                                            @if ($current_date > $coupon_date )
                                                                <span class="badge badge-danger">Expired</span>
                                                            @else
                                                                <span class="badge badge-success">Unused</span>
                                                            @endif

                                                        @elseif ($coupon->is_valid == 'used')
                                                            <span class="badge badge-danger">Used</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $coupon->created_at->diffInMinutes() <= 1440 ?  $coupon->created_at->diffForHumans() : $coupon->created_at->format('jS F Y') }}</td>
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
