@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<style>
i.fa.fa-download {
    font-size: 19px;
    vertical-align: middle;
    margin-top: 5px;
}
i.fa.fa-calendar {
    font-size: 18px;
    vertical-align: middle;
}
strong {
  font-weight: 900;
}
</style>

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>Verify Attendance List</h1>

      <ol class="breadcrumb">
        <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
              <form id="filters" class="search-field-box" method="GET">
                  <div class="row select-detail-below">
                    <div class="col-md-4 attendance-column1">
                        <div class="form-group">
                            <label>Year<sup class="ast">*</sup></label>
                            <select class="form-control input-sm basic-detail-input-style" id="year" name="year">
                                <option value="" disabled>Please select Year</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 attendance-column2">
                        <div class="form-group">
                            <label>Month<sup class="ast">*</sup></label>
                            <select class="form-control input-sm basic-detail-input-style" id="month" name="month">
                                <option value="" disabled>Please select Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 attendance-column3">
                        <div class="form-group">
                          <label>Employee Status</label>
                          <select class="form-control input-sm basic-detail-input-style" name="employee_status" id="employee_status">
                              <option value="1">Active</option>
                              <option value="0">In-Active</option>
                          </select>
                        </div>
                    </div>
                    
                  </div>
                  
                  <div class="submit-btn-box">
                    <input type="submit" name="submit" value="search" class="btn submit-btn"><i class="fa fa search"></i>
                  </div>
              </form>

             
             @if(!empty($req['year']))
             <div class="constants-container">
                <div class="constants">
                  <div class="item alert alert-danger">Week-Offs: <strong>{{@$data['sundays']}}</strong></div>
                  <div class="item alert alert-warning">Holidays: <strong>{{@$data['holidays']}}</strong></div>
                  <div class="item alert alert-success">Workdays: <strong>{{@$data['workdays']}}</strong></div>
                </div>
             </div>
             @endif

              <div class="row">
                  <div class="col-md-12">
                    <!-- <p class="found-results">We Found Below <span><b>6</b></span> Results Related to your Search</p> -->
                      <table id="employeesList" class="table table-bordered table-striped hello">
                          <thead class="table-heading-style">
                              <tr>
                                <th class="text-center" rowspan="2">S.No.</th>
                                <th class="text-center" rowspan="2">Employee Code</th>
                                <th class="text-center" rowspan="2">Name</th>
                                <th class="text-center" colspan="7">Attendance</th>
                              </tr>
                              <tr>
                                <th class="text-center">Absent</th>
                                <th class="text-center">On Duty (Travel)</th>
                                <th class="text-center">Paid Leaves</th>
                                <th class="text-center">Unpaid Leaves</th>
                                <th class="text-center">Late Coming</th>
                                <th class="text-center">Total Present Days</th>
                                <th class="text-center">Action</th>
                              </tr>
                          </thead>
                          <tbody class="attendance-table-body">
                            @foreach($employees as $key => $value)
                              @php
                                $redirect_url = '?id='.$value->user_id.'&year='.$req['year'].'&month='.$req['month'];
                              @endphp
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td title="export punches"><a target="_blank" href="{{url('attendances/export-punches').$redirect_url}}">{{$value->employee_code}}</a></td>
                                <td title="view calendar"><a target="_blank" href="{{url('attendances/view').$redirect_url}}">{{$value->fullname}}</a></td>
                                <td><strong>@if($value->absent_days < 0){{'0'}}@else{{$value->absent_days}}@endif</strong></td>
                                <td>{{$value->travel_days}}</td>
                                <td>{{$value->paid_leaves}}</td>
                                <td><strong>{{$value->unpaid_leaves}}</strong></td>
                                <td>{{$value->late}}</td>
                                <td><strong>{{$value->total}}</strong></td>
                                <td><a title="Export Punches" target="_blank" href="{{url('attendances/export-punches').$redirect_url}}"><i class="fa fa-download" aria-hidden="true"></i></a> &nbsp;
                                <a title="View Attendance & Verify" target="_blank" href="{{url('attendances/view').$redirect_url}}"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                                <div>
                                  @if($value->isverified)
                                    <span class="label label-success">Verified</span>
                                  @else
                                    <span class="label label-danger">Unverified</span>  
                                  @endif
                                </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
      </div>

      <!-- /.row -->

      <!-- Main row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->
  

  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
  <script type="text/javascript">
    $("#filters").validate({
      rules :{
            "year" : {
                required : true,
            },
            "month" : {
                required : true,
            }
        },
        messages :{
            "year" : {
                required : 'Please select Year.'
            },
            "month" : {
                required : 'Please select Month.'
            }
        }
    });

    var defYear = "{{$req['year']}}";
    var defMonth = "{{$req['month']}}";
    var defEmployeeStatus = "{{$req['employee_status']}}";
    
    if(defYear != '0'){
      $('#year').val(defYear);
    }else{
      defYear = "{{date('Y')}}";
      $('#year').val(defYear);
    }

    if(defMonth != '0'){
      $('#month').val(defMonth);
    }else{
      defMonth = "{{date('n')}}";
      $('#month').val(defMonth);
    }

    $("#employee_status").val(defEmployeeStatus);
  </script>

  <script type="text/javascript">
    $('#employeesList').DataTable({
        "scrollX": true,
        responsive: true
      });
  </script>

  @endsection