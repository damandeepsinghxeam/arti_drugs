@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        Projects List
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
           

            <!-- /.box-header -->

            <div class="box-body">

              <table id="listProjects" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>
				  
				          <th>Project Name</th>

                  <th>GST No.</th>

                  <th>Head Office Location</th>
				  
        				  <th>Project Owner</th>
        				  
        				  <th>Status</th>                  

                  @if(auth()->user()->can('edit-project') || auth()->user()->can('approve-project'))

                  <th style="width: 70px;">Actions</th>

                  @endif                 

                </tr>

                </thead>

                <tbody>

                <?php $counter = 0; 
				
			/* 	echo"<PRE>";
				print_r($projects);
				exit; */
				
				
				?>  
				@if(isset($projects) AND ($projects!=""))

                @foreach($projects as $key =>$value)  
			
                <tr>

            				<td>{{@$loop->iteration}}</td>

            				<td>{{@$value['name']}}</td>

            				<td>{{@$value['gst_number']}}</td>

            				<td>{{@$value['h_o_location']}}</td>

            				<td>{{@$value['project_owner']}}</td>				  

            				<td>@if($value['approval_status'] == '0')

            				<span class="label label-danger">Not Approved</span>

            				@elseif($value['approval_status'] == '1')

            				<span class="label label-success">Approved</span>
            				
            				@endif

            				</td>                 

            				@if(auth()->user()->can('edit-project') || auth()->user()->can('approve-project'))

            				<td>

            				@if(auth()->user()->can('edit-project') AND $value)

            				<a class="btn bg-purple" href='{{ url("mastertables/projects/show/".$value['id'])}}' title="show"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;

            				@endif

            			
            				
            				</td>

            				@endif                 

                </tr>

                @endforeach
				@endif
                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>
				  
				  <th>Project Name</th>

                  <th>GST No.</th>

                  <th>Head Office Location</th>
				  
        				  <th>Project Owner</th>
        				  
        				  <td>Status</td>

                   @if(auth()->user()->can('edit-project') || auth()->user()->can('approve-project'))

                  <th>Actions</th>

                  @endif



                 

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
alert(projectId);
exit;
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