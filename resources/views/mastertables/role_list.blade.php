@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        Role List
        <!-- <small>Control panel</small> -->
      </h1>

      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><a class="btn btn-info" href='{{ url("mastertables/role/add") }}'>Add</a></h3>
            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <table id="listProjects" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Role Name</th>
                  <th>Guard Name</th>

              <!-- <th>Action</th>

                  <th>Status</th> -->

                </tr>

                </thead>

                <tbody>

                <?php $counter = 0; ?>  

                @foreach($role as $key =>$value)  

                <tr>

                  <td>{{$loop->iteration}}</td>

                  <td>{{$value->name}}</td>

                  <td>{{$value->guard_name}}</td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Role Name</th>
                  <th>Guard Name</th>
                 <!-- <th>Action</th>

                  <th>Status</th> -->

                </tr>

                </tfoot>

              </table>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

      </div>

      <!-- /.row -->

      <!-- Main row -->

      <div class="row">

        <!-- Left col -->

        

      </div>

      <!-- /.row (main row) -->



    </section>

    <!-- /.content -->



    <div class="modal fade" id="projectInfoModal">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Additional Information</h4>

          </div>

          <div class="modal-body projectInfoModalBody">

              

          </div>

          

        </div>

        <!-- /.modal-content -->

      </div>

    <!-- /.modal-dialog -->

    </div>

      <!-- /.modal -->

  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

      $(".approveBtn").on('click',function(){
        if (!confirm("Are you sure you want to approve this project?")) {
            return false; 
        }
      });

      $(".additionalProjectInfo").on('click',function(){
        var projectId = $(this).data('projectid');

        $.ajax({
          type: "POST",
          url: "{{ url('mastertables/additional-project-info') }}",
          data: {project_id: projectId},
          success: function (result){
            $(".projectInfoModalBody").html(result);
            $('#projectInfoModal').modal('show');
          }
        });
      });

      $(document).ready(function() {
          $('#listProjects').DataTable({
            scrollX: true,
            responsive: true
          });
      });

  </script>

  @endsection