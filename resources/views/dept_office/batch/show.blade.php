@extends('layouts.backend.app')

@section('title', 'Show Batch Students')

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
                            <li class="breadcrumb-item"><a href="{{ route('dept_office.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Show Batch Students</li>
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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Show Batch Students</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->


                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Hall Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Hall Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($students as $key => $student)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->session->name }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>
                                                @if($student->hall == null)
                                                    <p class="badge badge-warning">Hall not allocated yet</p>
                                                @else
                                                    {{ $student->hall }}
                                                @endif
                                            </td>
                                            <td></td>
                                            <td>
                                                <a href="{{ route('dept_office.student.edit', $student->id) }}" class="btn btn-info">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                                <button class="btn btn-danger" type="button" onclick="deleteItem({{ $student->id }})">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <form id="delete-form-{{ $student->id }}" action="{{ route('dept_office.student.destroy', $student->id) }}" method="post"
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
    </div>
    <!-- /.content-wrapper -->
@endsection



@push('js')

@endpush
