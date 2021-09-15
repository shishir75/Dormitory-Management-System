{{-- @php
    $code = explode('-', $session->name);
    $year_main = substr($code[0], 0, 4);
    $year = $year_main + $year->code;
@endphp --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Passed Students List for {{ $dept->short_name}} - {{ $session->name }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <link rel="icon" href="{{ asset('assets/backend/img/policymaker.ico') }}" type="image/x-icon" />

    @stack('css')

</head>


<body>
<!-- Main content -->
<section class="content">
    <div class="container-fluid px-5">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 mt-4">
                <div class="col-12 text-center mb-4">
                    <div class="row">
                        <div class="col-3 text-right">
                            <img width="50" height="50" src="{{ asset('assets/backend/img/logo.png') }}" alt="JU Logo">
                        </div>
                        <div class="col-6 text-center ">
                            <h4>{{ $dept->name }}</h4>
                            <h5>Jahangirnagar University</h5>
                            <h6>Savar, Dhaka - 1342</h6>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-6 offset-3">
                            <h5 class="text-center">
                                Passed Students List (According to Registration No)
                            </h5>
                        </div>
                        <div class="col-3">
                            <span class="btn btn-sm btn-outline-dark float-right">Date : {{ date('F d, Y') }}</span>
                        </div>
                    </div>
                    <h4>Session : {{ $session->name }}</h4>
                </div>

                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Student Name</th>
                        <th>Sex</th>
                        <th>Reg. No</th>
                        <th>Hall No</th>
                        <th>Room No</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $key => $student)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->sex === "M" ? 'Male' : 'Female' }}</td>
                                <td>{{ $student->reg_no }}</td>
                                <td>{{ $student->hall->name  }}</td>
                                <td>{{ $student->room_no === null ? 'N/A' : $student->room_no }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
            <!--/.col (left) -->

            <div class="col-6 offset-6 text-right" style="margin-top: 50px;">
                <p class="mt-4"> .......................... </p>
                <p>Chairman / Director</p>
                <p>{{ $dept->name }}</p>
                <p>Jahangirnagar University, Savar, Dhaka 1342</p>
            </div>

        </div>
        <!-- /.row -->
    </div>
</section>
<!-- /.content -->
<!-- /.content-wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
    <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('assets/backend/js/adminlte.js') }}"></script>

<script>
    window.print();
</script>


</body>
</html>
