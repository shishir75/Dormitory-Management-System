@extends('layouts.backend.app')

@section('title', 'Rooms Students')

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
                            <li class="breadcrumb-item active">Rooms Students</li>
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
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Students of {{ $hall->name }} <span class="float-right btn btn-success">Room No {{ $room->room_no }}</span></h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->


                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Sex</th>
                                        <th>Dept Name</th>
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Room No</th>
                                        <th>Student Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($students as $key => $student)
                                        <tr id="sid{{$student->id}}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->sex }}</td>
                                            <td>{{ $student->dept->name }}</td>
                                            <td>{{ $student->session->name }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>
                                                @if($student->room_no == null)
                                                    <p class="badge badge-warning">Room not allocated yet</p>
                                                @else
                                                    {{ $student->room_no }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($student->status == 1)
                                                    <i class="fa fa-check-circle fa-lg text-success"></i>
                                                @elseif ($student->status == 2)
                                                    <i class="fa fa-exclamation-circle fa-lg text-warning"></i>
                                                @else
                                                    <i class="fa fa-times-circle fa-lg text-danger"></i>
                                                @endif
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
  <!-- DataTables -->
  <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

  <!-- Sweet Alert Js -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>


  {{-- <script>
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
  </script> --}}


  <script type="text/javascript">
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
              confirmButtonText: 'Yes, Change it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
          }).then((result) => {
              if (result.value) {
                  event.preventDefault();
                  document.getElementById('change-batch-form-'+id).submit();
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
  </script>

  <script>
      $(function(e){
        $("#checkAll").click(function(){
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });

        $("#changeAllSelectedRecords").click(function(e){
            e.preventDefault();
            var all_ids = [];
            $("input:checkbox[name=ids]:checked").each(function(){
                all_ids.push($(this).val());
            })

            $.ajax({
                url: "{{ route('dept_office.student.change_status_selected') }}",
                type: 'PUT',
                data: {
                    ids: all_ids,
                    _token: $("input[name=_token]").val()
                },
                success: function(response) {
                    $.each(all_ids, function(key, val){
                        $('#sid'+val).remove();
                    });
                    location.reload();
                }
            });
        });


      });
  </script>

@endpush
