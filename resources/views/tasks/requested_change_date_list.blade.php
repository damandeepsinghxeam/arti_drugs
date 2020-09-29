@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Requested date extension List
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">
            <!-- /.box-header -->
            @include('admins.validation_errors')

            @if(session()->has('cannot_cancel_error'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session()->get('cannot_cancel_error') }}
              </div>
            @endif
            <div class="box-body">
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                    {{ucfirst(@$status)}}  
                    <span class="caret"></span></button>

                    <ul class="dropdown-menu">
                      <li><a href='{{url("tasks/requested-change-date/approved")}}'>Approved</a></li>
                      <li><a href='{{url("tasks/requested-change-date/not-approved")}}'>Not-Approved</a></li>
                      <li><a href='{{url("tasks/requested-change-date/rejected")}}'>Rejected</a></li>
                    </ul>
                </div>

              
              <table id="listRequestedChanges" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Applied At</th>
                  <th>Assigned Date</th>
                  <th>Required Date</th>
                  <th>Alloted date</th>
                  <th>Remarks</th>
                  <th>Comments</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  
                @foreach($changes as $key =>$value)  
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{date("d/m/Y h:i:s A",strtotime($value->created_at))}}</td>
                  <td>{{date("d/m/Y",strtotime($value->assigned_date))}}</td>
                  <td>{{date("d/m/Y",strtotime($value->required_date))}}</td>
                  <td>
                    @php
                    if($status =="approved"){
                      $alloted = $value->alloted ;
                    }else{
                      $alloted = "N/A";
                    }
                    @endphp
                    {{$alloted}}

                  </td>                 
                  <td title="{{$value->remarks}}">{{$value->remarks}}</td>

                  <td><a href="javascript:void(0)" class="commentsModal" data-datechangeid="{{$value->id}}"><i class="fa fa-envelope fa-2x"></i></a></td>
                  <td>
                    @if($value->is_rejected)
                      <span class="label" style="background-color: #f01a1a;">Rejected</span>
                  	@elseif($value->status == 0 && $value->isactive == 1)
                  		<span class="label label-danger">Not Approved</span>
                  	@elseif($value->status == 1 && $value->isactive == 1)
                  		<span class="label label-success">Approved</span>
                    @elseif($value->isactive == 0)
                      <span class="label" style="background-color: #001f3f;">Cancelled</span>  
                  	@endif
                  </td>
                  
                  <td>
                    @if($value->isactive == 1 && $value->status == '0')
                      <a href='{{url("tasks/cancel-requested-change/$value->id")}}'><span class="label label-danger bg-maroon cancelAppliedLeave">Cancel</span></a>
                    @else
                      <span class="label label-default">None</span>
                    @endif  
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Applied At</th>
                  <th>Date</th>
                  <th>In-Time</th>
                  <th>Out-Time</th>
                  <th>Remarks</th>
                  <th>Comments</th>
                  <th>Final Status</th>
                  <th>Action</th>
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

    </section>
    <!-- /.content -->

    <div class="modal fade" id="commentsModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Comments List</h4>
            </div>
            <div class="modal-body commentsModalBody">
                
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
      $(document).ready(function() {
          $(".cancelAppliedLeave").on('click', function(){
            if (!confirm("Are you sure you want to cancel this change request?")) {
              return false; 
            }
          });

          $(".commentsModal").on('click',function(){
            var Datechange_id = $(this).data("datechangeid");
              
            $.ajax({
              type: 'POST',
              url: "{{ url('tasks/list-task-change-comments') }}",
              data: {id: Datechange_id},
              success: function (result) {
                $(".commentsModalBody").html(result);
                $('#commentsModal').modal('show');
              }
            });
          });

          $('#listRequestedChanges').DataTable({
          	"scrollX": true,
            responsive: true
          });
          
      });

      
  </script>

  @endsection