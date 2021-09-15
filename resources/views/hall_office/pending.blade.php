@extends('layouts.backend.app')

@section('title', 'Pending Students')

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
                            <li class="breadcrumb-item"><a href="{{ route('hall_office.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pending Students</li>
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
                                <h3 class="card-title">{{ strtoupper('Allotted Students list of '.$hall->name ) }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Student Name</th>
                                        <th>Session</th>
                                        <th>Due Hall Bill</th>
                                        <th>Approval</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Student Name</th>
                                        <th>Session</th>
                                        <th>Due Hall Bill</th>
                                        <th>Approval</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($students as $key => $student)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->session->name }}</td>
                                                <td>

                                                    @php
                                                    $student = App\Models\Student::findOrFail($student->id);

                                                    $hall_bill = App\Models\HallBill::where('student_id', $student->id)->latest()->first();

                                                    $student_start_date = $student->created_at;

                                                    if ($hall_bill != null) {
                                                        $student_start_date = $hall_bill->end_month;
                                                        $student_start_date_for_frontend = date('F-Y',strtotime('+1 month', strtotime($student_start_date)) );
                                                    } else {
                                                        $student_start_date_for_frontend = date('F-Y', strtotime( $student_start_date ) );
                                                    }

                                                    $current_month = date('F-Y');

                                                    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $student_start_date);
                                                    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
                                                    $diff_in_months = $from->diffInMonths($to);

                                                    $due_bill = number_format(($diff_in_months + 1) * 20, 2);

                                                    $end_date_as_integer = (int) date( 'Ym', strtotime( $student_start_date ) );
                                                    $current_date_as_integer = (int) date( 'Ym', strtotime( $current_month ) );

                                                    if ($end_date_as_integer > $current_date_as_integer) {
                                                        $due_bill_sign = false;
                                                    } else {
                                                        $due_bill_sign = true;
                                                    }

                                                @endphp

                                                @if ($due_bill_sign === true)
                                                    <span class="badge badge-danger">{{ $due_bill }} BDT</span>
                                                @else
                                                    <span class="badge badge-success">{{ $due_bill }} BDT</span>
                                                @endif

                                                </td>
                                                <td>

                                                    @if ($due_bill_sign === true)
                                                        <span class="badge badge-danger">Pay Due Bill First</span>
                                                    @else
                                                        <a href="{{ route('hall_office.allotted-students.show', $student->name) }}" class="btn btn-sm btn-warning">
                                                            Approval
                                                        </a>
                                                    @endif



                                                </td>
                                                <td>
                                                    <a href="{{ route('hall_office.allotted-students.details', $student->id) }}" class="btn btn-sm btn-info">
                                                        Details
                                                    </a>
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

@endpush
