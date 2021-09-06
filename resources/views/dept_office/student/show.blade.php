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
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Show Students for Session {{ $students[0]->session->name}}
                                    <button type="button" onclick="deleteItem({{ $students[0]->session->id }})" class="btn btn-sm btn-danger text-white float-right">Change Status For All Students</button>
                                </h3>
                                <form id="change-batch-form-{{ $students[0]->session->id }}" action="{{ route('dept_office.student.change_all_status', $students[0]->session->id) }}" method="post"
                                    style="display:none;">
                                  @csrf
                                  @method('PUT')
                              </form>

                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->


                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <button type="button" class="btn btn-warning float-right mb-3" id="changeAllSelectedRecords">Change Status for Selected</button>
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        {{-- <th>Dept Name</th> --}}
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Hall Name</th>
                                        <th>Room No</th>
                                        <th>Student Status</th>
                                        <th>
                                            <input type="checkbox" id="checkAll"  class="mr-3" >
                                            Select All
                                        </th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        {{-- <th>Dept Name</th> --}}
                                        <th>Session</th>
                                        <th>Reg No</th>
                                        <th>Hall Name</th>
                                        <th>Room No</th>
                                        <th>Student Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($students as $key => $student)
                                        <tr id="sid{{$student->id}}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $student->name }}</td>
                                            {{-- <td>{{ $student->dept->name }}</td> --}}
                                            <td>{{ $student->session->name }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>
                                                @if($student->hall == null)
                                                    <p class="badge badge-warning">Hall not allocated yet</p>
                                                @else
                                                    {{ $student->hall }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($student->room_no == null)
                                                    <p class="badge badge-warning">Room not allocated yet</p>
                                                @else
                                                    {{ $student->room_no }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($student->status == true)
                                                    <p class="badge badge-success"><i class="fa fa-check-circle"></i></p>
                                                @else
                                                <p class="badge badge-warning"><i class="fa fa-times-circle" aria-hidden="true"></i></p>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="ids" class="checkBoxClass" value="{{$student->id}}">
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
