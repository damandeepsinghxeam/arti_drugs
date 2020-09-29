@extends('admins.layouts.app')



@section('content')



<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">



<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Leave Report List

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="{{ url('leaves/leave-report-form') }}">Back</a></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="box">

            <div class="box-header">

              <h3 class="box-title">{{date("d M Y",strtotime($report_data['from_date']))}} - {{date("d M Y",strtotime($report_data['to_date']))}}</h3>

              <!-- <button class="btn btn-info pull-right filterReport"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button> -->

            </div>

            <!-- /.box-header -->



            <!-- leave report total starts here -->

            <div class="leave-report-total">

    		      <div class="row leave-type1"> 

    		        <div class="col-sm-4 col-xs-4 leaves1">

    		          <div class="panel panel-danger leave-type-sectn-report">

    		            <div class="panel-heading leave-heading">Total Days:

    		              <span class="label label-danger">{{$report_data['no_days']}}</span>

    		            </div>

    		            <!-- <div class="panel-body leave-content"> -->

    		              

    		            <!-- </div> -->

    		          </div>

    		        </div>

    		        <div class="col-sm-4 col-xs-4 leaves2">

    		          <div class="panel panel-success leave-type-sectn-report">

    		            <div class="panel-heading leave-heading">Weekends:

    		              <span class="label label-success">{{$report_data['weekends']}}</span>

    		            </div>

    		            <!-- <div class="panel-body leave-content"> -->

    		              

    		            <!-- </div> -->

    		          </div>

    		        </div>

    		        <div class="col-sm-4 col-xs-4 leaves3">

    		          <div class="panel panel-warning leave-type-sectn-report">

    		            <div class="panel-heading leave-heading">Holidays:

    		              <span class="label label-warning">{{$report_data['holidays']}}</span>

    		            </div>

    		            <!-- <div class="panel-body leave-content">

    		              

    		            </div> -->

    		          </div>

    		        </div>

    		      </div>





              <div class="row leave-type1"> 

                <div class="col-sm-4 col-xs-4 leaves1">

                  <div class="panel panel-danger leave-type-sectn">

                    <div class="panel-heading leave-heading">Total Paid Leaves:

                      <span class="label label-danger totalPaidLeaves">0</span>

                    </div>

                    

                  </div>

                </div>

                <div class="col-sm-4 col-xs-4 leaves2">

                  <div class="panel panel-success leave-type-sectn">

                    <div class="panel-heading leave-heading">Total Unpaid Leaves:

                      <span class="label label-success totalUnpaidLeaves">0</span>

                    </div>

                    

                  </div>

                </div>

                <div class="col-sm-4 col-xs-4 leaves3">

                  <div class="panel panel-warning leave-type-sectn">

                    <div class="panel-heading leave-heading">Total Compensatory Leaves:

                      <span class="label label-warning totalCompensatoryLeaves">0</span>

                    </div>

                    

                  </div>

                </div>

              </div>



              @include('admins.validation_errors')

            

              <div class="callout callout-danger apply-lv-alert" style="margin-bottom: 0;background-color: #bd1d0a !important;">

                <strong>Note: </strong> <em>Please do not refresh this page. You can go back and submit the form again.</em>

              </div>





            </div>

            <!-- leave report total ends here -->



            @php

              $totalPaidLeaves = 0;

              $totalUnpaidLeaves = 0;

              $totalCompensatoryLeaves = 0;

            @endphp

            

            

            <div class="box-body">

              <table id="listLeaveReport" class="table table-bordered table-striped" style="height:150px;">

                <thead class="table-heading-style">

                <tr>

                  <th style="width:5%;">S.No.</th>

                  <th style="width:10%;">Xeam Code</th>

                  <th style="width:20%;">Employee Name</th>

                  <th style="width:5%;">Paid Leaves</th>

                  <th style="width:10%;">Unpaid Leaves</th>

                  <th style="width:10%;">Compensatory Leaves</th>

                  <th style="width:10%;">Payable Days</th>

                </tr>

                </thead>

                <tbody>

                  

                @foreach($data as $key =>$value) 



                  @php

                    if($value->unpaid_count == ""){

                      $value->unpaid_count = 0;  

                    }

                    

                    $payableDays = $report_data['no_days'] - ($value->unpaid_count);



                    if(!empty($value->paid_count)){

                      $paidLeavesCount = $value->paid_count;

                    }else{

                      $paidLeavesCount = 0;

                    } 



                    $unpaidLeavesCount = $value->unpaid_count;



                    if(!empty($value->compensatory_count)){

                      $compensatoryLeavesCount = $value->compensatory_count;

                    }else{

                      $compensatoryLeavesCount = 0;

                    } 



                    $totalPaidLeaves += $paidLeavesCount;

                    $totalUnpaidLeaves += $unpaidLeavesCount;

                    $totalCompensatoryLeaves += $compensatoryLeavesCount;

                  @endphp 

                <tr>

                  <td>{{$loop->iteration}}</td>

                  <td>{{$value->employee_code}}</td>

                  <td><img src="{{$value->profile_picture}}" class="user-image img-circle" width="30px" height="30px" alt="User Image"><a target="_blank" title="More Information" href="{{ url('leaves/additional-leave-report-info') }}{{'?from_date='.$report_data['from_date'].'&to_date='.$report_data['to_date'].'&id='.$value->user_id}}"><em> {{$value->fullname}}</em></a></td>

                  <td>

                    {{$paidLeavesCount}}  

                  </td>

                  <td>

                    {{$unpaidLeavesCount}}

                  </td>

                  <td>

                    {{$compensatoryLeavesCount}}

                  </td>

                  <td>{{$payableDays}}</td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Xeam Code</th>

                  <th>Employee Name</th>

                  <th>Paid Leaves</th>

                  <th>Unpaid Leaves</th>

                  <th>Compensatory Leaves</th>

                  <th>Payable Days</th>

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



     <div class="modal fade" id="filterReportModal">

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Filter Parameters</h4>

            </div>

            

            <div class="modal-body filterReportModalBody">

              <form id="filterReportForm" action="{{ url('leaves/create-leave-report') }}" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                  <div class="box-body">

                    

                    <div class="form-group">

                      <label>Project</label>

                      <select class="form-control" name="projectId">

                          <option value="">All</option>

                          

                      </select>

                    </div>



                    <div class="form-group">

                      <label>Department</label>

                      <select class="form-control" name="departmentId">

                          <option value="">All</option>

                          

                      </select>

                    </div>



                    <div class="form-group">

                      <label>Location</label>

                      <select class="form-control" name="locationId">

                          <option value="">All</option>

                          

                      </select>

                    </div>



                    <input type="hidden" name="noDays" id="noDays" value="">

                    <input type="hidden" name="weekends" id="weekends" value="">

                    <input type="hidden" name="holidays" id="holidays" value="">

                    <input type="hidden" name="fromDate" id="fromDate" value="">

                    <input type="hidden" name="toDate" id="toDate" value="">

                                 

                  </div>

                  <!-- /.box-body -->

                  <br>



                  <div class="box-footer">

                    <button type="submit" class="btn btn-primary" id="filterReportFormSubmit">Submit</button>

                  </div>

              </form>

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



      $(function () {  

          $(document).keydown(function (e) {  

              return (e.which || e.keyCode) != 116;  

          });  

      });



      // $(".filterReport").on('click',function(){

      //   $("#filterReportModal").modal('show');

      // });



      var totalPaidLeaves = "{{@$totalPaidLeaves}}";

      var totalUnpaidLeaves = "{{@$totalUnpaidLeaves}}";

      var totalCompensatoryLeaves = "{{@$totalCompensatoryLeaves}}";



      

      $(".totalPaidLeaves").text(totalPaidLeaves);

          

      $(".totalUnpaidLeaves").text(totalUnpaidLeaves);

           

      $(".totalCompensatoryLeaves").text(totalCompensatoryLeaves);

      

      



      $('#listLeaveReport').DataTable({

        "scrollX": true,

        responsive: true

      });

          



      

  </script>



  @endsection