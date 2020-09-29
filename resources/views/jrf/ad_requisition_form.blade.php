@extends('admins.layouts.app')
@section('content') 
<style>
.add-kra-box {
    border: 1px solid #3c8dbc;
    border-radius: 8px;
    padding: 16px;
}
.table-styling {
    border: 1px solid #3c8dbc;
    padding: 10px;
    border-radius: 8px;
}
.d_o_r {
   margin-bottom: 20px;
}
.submit-btn-style {
    margin-bottom: 20px;
}
</style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
         <h1>Advertisement Requisition Form (ARF)</h1>
         <ol class="breadcrumb">
           <li><a href="{{url('/employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
           <li><a href="{{url('/jrf/list-jrf')}}">JRF List</a></li> 
         </ol>
      </section>

      <!-- Main content -->
      <section class="content">
      <!-- Small boxes (Stat box) -->
         <div class="row">
            <div class="col-sm-12">
               <div class="box box-primary">

                 @if ($errors->basic->any())
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <ul>
                        @foreach ($errors->basic->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                  </div>
                  @endif

                  <div class="alert-dismissible">
                    @if(session()->has('success'))
                      <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                        {{ session()->get('success') }}
                      </div>
                    @endif
                  </div>


               <!-- form start -->
                <form id="arfRequisitionForm" action="{{ url('jrf/save-ad-requisition-form') }}" method="POST">
                   {{ csrf_field() }}
                  <div class="box-body jrf-form-body">
                     <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                           <div class="table-styling">
                             
                              <table class="table table-striped table-responsive">
                               
                               <!-- <tr>
                                  <th>Date of Request<sup class="ast">*</sup></th>
                                  <td>
                                    <input type="text" class="form-control datepicker" name="date_of_request" id="date_of_request" placeholder="02/03/2020" readonly="">
                                   
                                  </td>
                                </tr> -->
 
                                <input type="hidden" name="jrf_id" value="{{@$jrf_id}}">
                                <input type="hidden" name="arf_id" value="{{@$data->arf_id}}">

                                <tr>
                                  <th>Project Name </th>
                                  <td>{{@$data->prj_name}}</td>
                                </tr>
                                <tr>
                                  <th>Job designation for which Ad is required </th>
                                  <td>{{@$data->designation}}</td>
                                </tr>
                                <tr>
                                  <th>How many ads are required to be posted<sup class="ast">*</sup></th>
                                  <td>
                                    <input type="number" name="post_count" id="post_count" placeholder="Please enter ads (in Number)" class="form-control valbasic-detail-input-style" value="{{@$data->post_count}}">
                                  </td>
                                </tr>
                                <tr>
                                  <th>Balance on Job Posting In Naukri.com<sup class="ast">*</sup></th>
                                  <td>
                                    <input type="number" name="post_amount" id="post_amount" placeholder="Enter ad Posting balance(in Number)" class="form-control basic-detail-input-style" value="{{@$data->post_amount}}">
                                  </td>
                                </tr>
                                <tr>
                                  <th>Content of Job Posting<sup class="ast">*</sup></th>
                                  <td>
                                    <textarea rows="4" cols="50" class="form-control" id="post_content" name="post_content" placeholder="Ad Content is here">{{@$data->post_content}}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Job Posting Sites<sup class="ast">*</sup></th>
                                  <td>
                                    <select class="form-control select2 input-sm basic-detail-input-style" name="job_posts[]" multiple="multiple" style="width: 100%;" id="job_posts" data-placeholder="Select Job Posting Sites">
                                      @if(!$jobs->isEmpty())
                                        @foreach($jobs as $job) 
                                           <option value="{{$job->id}}" @if(in_array($job->id,@$jobsA['saved_jobpost'])){{"selected"}} @else{{""}} @endif>{{$job->name}}</option>
                                        @endforeach
                                      @endif  
                                    </select>
                                  </td>
                                </tr> 
                           </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
                    <div class="box-footer text-center">
                      <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Submit" name="submit">
                    </div>
               </form>
            </div>
         </div><!-- /.box -->
      </div><!-- /.row -->
   </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- /.content-wrapper -->  
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>  
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script> 
<script>
  var request_date = "{{@$data->request_date}}";
  $("#date_of_request").val(request_date);

   $(function () {
      var dateToday = new Date();
       $('.datepicker').datepicker({ //Date picker
         autoclose: true,
         orientation: "bottom",
         format: 'dd-mm-yyyy',
         startDate : dateToday
       });
   });

   $("#arfRequisitionForm").validate({
     rules: {
       "post_count" : {
         required: true
       },
       "post_amount" : {
         required: true
       },

       "date_of_request" : {
         required: true
       },
       
       "post_content" : {
         required: true
       },

       "job_posts[]" :{
        required: true
       }

      },
      messages: {
         "post_count" : {
            required: 'Please enter Ads Required.'
         },
         "post_amount" : {
            required: 'Enter Balance of Ad posting available.'
         },
         "date_of_request" : {
            required: 'Please select date of request.'
         },
         "post_content" : {
            required: 'Enter Ad Content.'
          },
          "job_posts[]" : {
            required: 'Enter Job Posts.'
          }

      }
   });
</script>  
@endsection