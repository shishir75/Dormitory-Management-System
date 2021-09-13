@extends('layouts.backend.app')

@section('title', 'Change Password')

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
                            <li class="breadcrumb-item active">Change Password</li>
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
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                              <h3 class="card-title">Change Password</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ route('student.change-password.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning float-right">Change Password</button>
                                </div>
                            </form>
                          </div>
                          <!-- /.card -->
                    </div>
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
