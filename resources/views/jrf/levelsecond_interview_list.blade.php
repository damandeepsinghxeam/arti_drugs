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
    <h1><i class="fa fa-list"></i> Second Level Screening Data Filter</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>

   <!-- Main content -->
   <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
            <!-- Box Body Starts here -->
            <div class="box-body">
              <form id="filterForm">
                <!-- <div class="form-group col-sm-3">
                   <label>Date From</label>
                   <input type="date" name="date_from" id="date_from" class="form-control" value="@if($req['date_from'] == 'date_from'){{"selected"}}@endif">
                </div>

                <div class="form-group col-sm-3">
                   <label>Date To</label>
                   <input type="date" name="date_to" id="date_to" class="form-control" value="@if($req['date_to'] == 'date_to'){{"selected"}}@endif">
                </div> -->
                <div class="row">
                  <div class="col-sm-2 attendance-column1">
                    <label for="jrf_no">Jrf No</label>
                    <select class="form-control input-sm basic-detail-input-style" name="jrf_no" id="jrf_no">
                      <option value="" selected disabled>Select Jrf</option>
                      <option value="">None</option>
                      @foreach($jrfs as $key => $value)
                      <option value="{{$value->jrf_no}}" @if($req['jrf_no'] == $value->jrf_no){{"selected"}}@endif>{{$value->jrf_no}}</option>
                      @endforeach  
                    </select>
                  </div>

                  <div class="col-sm-3 attendance-column2">
                     <label for="project_id">Project</label>
                     <select class="form-control input-sm basic-detail-input-style" name="project_id" id="project_id">
                        <option value="" selected disabled>Select Project</option>
                        <option value="All" @if($req['project_id'] == 'All'){{"selected"}}@endif>All</option>  
                        @foreach($projects as $key => $value)
                        <option value="{{$value->id}}" @if($req['project_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                        @endforeach  
                     </select>
                  </div>

                  <div class="col-sm-2 attendance-column3">
                     <label for="status">Candidate Status</label>
                     <select class="form-control input-sm basic-detail-input-style" name="status" id="status">
                        <option value="" selected disabled>Select Status</option>
                        <option value="Rejected"  @if($req['Rejected'] == 'Rejected'){{"selected"}}@endif>Rejected</option>
                        <option value="On-hold"  @if($req['On-hold'] == 'On-hold'){{"selected"}}@endif>On-hold</option>
                        <option value="Selected"  @if($req['Selected'] == 'Selected'){{"selected"}}@endif>Selected</option>
                     </select>
                  </div>

                  <div class="col-sm-2 attendance-column4">
                    <button type="submit" class="btn btn-primary searchbtn-attendance" id="filterFormSubmit">Submit</button>
                  </div>
                </div>
              </form>
              <hr>

              <!-- Table starts here -->
              <table id="listHolidays" class="table table-bordered table-striped text-center">
                <thead class="table-heading-style">
                  <tr>
                    <th>S.No.</th>
                    <th>JRF No</th>
                    <th>Project Type</th>
                    <th>Candidate name</th>
                    <th>Interview Conducted By</th>
                    <th>Candidate Status</th>
                    <th>Created Date</th>
                  </tr>
                </thead>
                @foreach($datas as $data)    
                <tbody>
                  <tr>
                    <td>{{@$loop->iteration}}</td>
                    <td>{{@$data->jrf_no}}</td>
                    <td>{{@$data->prj_name}}</td>
                    <td>{{@$data->name}}</td>
                    <td>{{@$data->fullname}}</td>
                    <td>{{@$data->final_result}}</td>
                    <td>{{@$data->created_at}}</td>
                  </tr>
                </tbody>
                @endforeach             
                <tfoot class="table-heading-style">
                  <tr>
                    <th>S.No.</th>
                    <th>JRF No</th>
                    <th>Project Type</th>
                    <th>Candidate name</th>
                    <th>Interview Conducted By</th>
                    <th>Candidate Status</th>
                    <th>Created Date</th>
                  </tr>
                </tfoot>
              </table>
              <!-- Table Ends here -->
            </div>
            <!-- Box Body Ends here -->

          </div><!-- /.box -->
      </div>

        </div><!-- /.row -->

    <!-- Main row -->

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