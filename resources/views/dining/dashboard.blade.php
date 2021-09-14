@extends('layouts.backend.app')

@section('title', 'Dining Dashboard')

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
                            <li class="breadcrumb-item active">Dining Dashboard</li>
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
                                <span class="info-box-text">Total Coupons Sold</span>
                                <span class="info-box-number">{{ $coupon_count }}</span>
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
                                <span class="info-box-text">Total Dining Events</span>
                                <span class="info-box-number">{{ $events_count }}</span>
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
                                @if ($balance !== null)
                                    <span class="info-box-text">{{ $balance->amount > 0 ? 'Advanced Balance' : 'Owing Balance' }}</span>
                                    <span class="info-box-number text-{{ $balance->amount > 0 ? 'danger' : 'success' }}">
                                        {{ abs(number_format($balance->amount, 2)) }} BDT
                                    </span>
                                @else
                                    <span class="info-box-text">Available Balance</span>
                                    <span class="info-box-number badge badge-danger">0.00 BDT</span>
                                @endif

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
                                <h3 class="card-title">Latest Sold Food Coupons</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped table-bordered table-valign-middle text-center">
                                    @if ($latest_coupons->count() > 0)
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Coupon Date</th>
                                                <th>L/D</th>
                                                <th>Unit Price</th>
                                                <th>Max Quantity</th>
                                                <th>Sold</th>
                                                <th>Available</th>
                                            </tr>
                                        </thead>
                                    @endif

                                    <tbody>
                                        @if ($latest_coupons->count() > 0)
                                            @foreach($latest_coupons as $key => $coupon)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $coupon->coupon_date }}</td>
                                                    <td>
                                                        @if ($coupon->type === "L")
                                                            <span class="badge badge-success">Lunch</span>
                                                        @else
                                                            <span class="badge badge-info">Dinner</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ number_format($coupon->unit_price, 2) }} BDT</td>
                                                    <td>{{ $coupon->max_count }}</td>
                                                    <td><span class="badge badge-{{ $coupon->sold_coupon  < 20 ? 'warning' : 'success' }}">{{ $coupon->sold_coupon }} UNITS</span></td>
                                                    <td><span class="badge badge-{{ $coupon->max_count - $coupon->sold_coupon  < 20 ? 'warning' : 'success' }}">{{ $coupon->max_count - $coupon->sold_coupon }} UNITS</span></td>
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
