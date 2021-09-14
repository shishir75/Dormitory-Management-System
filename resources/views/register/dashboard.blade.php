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
                                <span class="info-box-text">Total Halls</span>
                                <span class="info-box-number">{{ $halls_count }}</span>
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
                                <span class="info-box-text">Total Sessions</span>
                                <span class="info-box-number">{{ $sessions_count }}</span>
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
                                <span class="info-box-text">Total Departments</span>
                                <span class="info-box-number">{{ $dept_count }}</span>
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
                                <span class="info-box-text">Balance</span>
                                <span class="info-box-number">
                                    @if ($reg_balance !== null)
                                        {{ number_format($reg_balance->amount, 2) }} BDT
                                    @else
                                        0.00 BDT
                                    @endif

                                </span>

                                @if ($reg_balance !== null)
                                    <span class="info-box-text">{{ $reg_balance->amount >= 0 ? 'Hall Bill Advanced' : 'Hall Bill Owing' }}</span>
                                    <span class="info-box-number text-{{ $reg_balance->amount >= 0 ? 'success' : 'danger' }}">
                                        {{ abs(number_format($reg_balance->amount, 2)) }} BDT
                                    </span>
                                @else
                                    <span class="info-box-text">Hall Bill Advanced</span>
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
                            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Current Students</span>
                                <span class="info-box-number">{{ $active_students }}</span>
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
                                <span class="info-box-text">Available Seats</span>
                                <span class="info-box-number">{{ $available_seats }} of {{ $total_seats }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->





@endsection



@push('js')

@endpush
