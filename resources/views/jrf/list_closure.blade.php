@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th { vertical-align: middle !important;}
</style>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1><i class="fa fa-list"></i> Feedback Listing</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>   

   <!-- Main content -->
   <section class="content">
    <!-- Main row starts here -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">

          <div class="alert-dismissible">
            @if(session()->has('success'))
              <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                {{ session()->get('success') }}
              </div>
            @endif
          </div>

          <!-- Box body starts here -->
          <div class="box-body">
            <form id="filterForm">
              <div class="row">
                <div class="col-sm-3 attendance-column1">
                   <label for="project_id">Project</label>
                   <select class="form-control input-sm basic-detail-input-style" name="project_id" id="project_id">
                      <option value="" selected disabled>Select Project</option>
                      <option value="All" @if($req['project_id'] == 'All'){{"selected"}}@endif>All</option>  
                      @foreach($projects as $key => $value)
                      <option value="{{$value->id}}" @if($req['project_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                      @endforeach  
                   </select>
                </div>

                <div class="col-sm-3 attendance-column2">
                   <label for="designation_id">Designations</label>
                   <select class="form-control input-sm basic-detail-input-style" name="designation_id" id="designation_id">
                      <option value="" selected disabled>Select Designation</option>
                      <option value="">None</option>
                      @foreach($designations as $key => $value)
                      <option value="{{$value->id}}" @if($req['designation_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                      @endforeach  
                   </select>
                </div>
                <div class="col-sm-2 attendance-column4">
                  <button type="submit" class="btn btn-primary searchbtn-attendance" id="filterFormSubmit">Submit</button>
                </div>
              </div> 
            </form>
            
            <hr>

            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Project Type</th>
                  <th>Candidate Name</th>
                  <th>CTC</th>
                  <th>CIH</th>
                  <th>Recruiter Name</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
                @php $counter = 1; @endphp  
                @foreach($jrfs_approval as $key =>$jrf)

                <tr> 
                  <td>{{@$counter++}}</td>
                  <td><a  href='{{url("jrf/view-jrf/$jrf->jrf_id")}}'>{{@$jrf->jrf_no}}</a></td>
                  <td>{{@$jrf->proj_name}}</td>
                  <td><a href='{{url("jrf/candidate-level-one-screening-detail/$jrf->jrf_level_one_screening_id")}}' target="_blank">{{@$jrf->name}}</a></td>
                  <td>{{@$jrf->ctc}}</td>
                  <td>{{@$jrf->cih}}</td>
                  <td>{{@$jrf->fullname}}</td>
                  <td>{{@$jrf->designation}}</td>
                  <td>{{@$jrf->department}}</td>
                  <td>{{@$jrf->created_at}}</td>

                  <td>
                    @if(@$jrf->closure_type == 'open')
                  @if(@$jrf->closed_id == 1)        
                      <button class="btn btn-primary btn-xs" disabled="disabled">CLOSED</button>
                  @else
                      <a class="btn btn-primary btn-xs" target="_blank" href='{{url("jrf/final-closure/$jrf->jrf_level_one_screening_id")}}'>FEEDBACK</a>                
                  @endif
                   @elseif(@$jrf->closure_type == 'hold')
                   <span class="label label-warning">JRF ON HOLD</span>
                  @else
                      <span class="label label-danger">JRF CLOSED</span>
                    @endif

                  </td>
                </tr>

                @endforeach
              </tbody>

              <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Project Type</th>
                  <th>Candidate Name</th>
                  <th>Recruiter Name</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- Box body Ends here -->
        </div><!-- /.box -->
      </div>
    </div>
    <!-- Main row Ends here -->
  </section>

<!-- /.content -->
</div>

  <!-- /.content-wrapper -->

  

  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  

  <script type="text/javascript">



    $(document).ready(function() {

       

       $('#listHolidays').DataTable({

         scrollX: true,

         responsive: true

       });



    });



  </script>



@endsection