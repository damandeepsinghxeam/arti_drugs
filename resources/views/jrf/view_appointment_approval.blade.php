@extends('admins.layouts.app')
@section('content') 
<style type="text/css">
#status_check {
   background-color : #ec1b1b !important;
}
#created_check {
    background-color: #297b12 !important;
    font-size: x-small;
}
.rejection_reason {
    margin-top: 6px;
}
span.change_request {
    float: right;
}
</style>
<div class="content-wrapper">  
   <section class="content-header">
      <h1> Approval Appointment Detail 
         <span class="label label-success" id="created_check">
            @if(@$detail['basic']->created_at)
               Created {{date("Y-m-d",strtotime(@$detail['basic']->created_at))}}
            @endif
         </span>
      </h1>
      <ol class="breadcrumb">
         <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
   </section>
   <!-- Main content --> 

    <section class="content">
      <div class="row">
         <div class="col-md-3">  
            <!-- About Me Box -->          
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Created By</h3>
               </div>
               <!-- /.box-header -->            
               <div class="box-body">
                  <p class="text-muted"><span>Name          :</span>{{ @$detail['recruiter']->employee->fullname}}</p>
                  <p class="text-muted"><span>Mobile No :</span>{{ @$detail['recruiter']->employee->mobile_number}}</p>
                  <p class="text-muted"><span>Email:</span>{{ @$detail['recruiter']->employee->personal_email}}</p>
               <hr>
               </div><!-- /.box-body -->  
            </div>  
         </div>
         <!-- /.col -->
         <div class="col-md-9">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs edit-nav-styling">
                  <li id="basicDetailsTab" class="active"><a href="#tab_basicDetailsTab" data-toggle="tab">Approval Appointment Detail</a></li>
                  
               </ul>
               <div class="tab-content">
                  <div class="active tab-pane" id="tab_basicDetailsTab">
                     <div class="box-body no-padding">
                        <table class="table table-striped table-bordered">
                           <tr>
                              <th style="width: 30%">Field</th>
                              <th style="width: 70%">Value</th>
                           </tr>
                           <tr>
                              <td><em>CTC</em></td>
                              <td>{{@$detail['basic']->ctc}}</td>
                           </tr> 
                           <tr>
                              <td><em>CIH</em></td>
                              <td>{{@$detail['basic']->cih}}</td>
                           </tr> 
                           <tr>
                              <td><em>Incentives</em></td>
                              <td>{{@$detail['basic']->incentives}}</td>
                           </tr> 
                           <tr>
                              <td><em>Offer Letter</em></td>
                              <td>{{@$detail['basic']->offer_letter}}</td>
                           </tr>
                           <tr>
                              <td><em>Id Card</em></td>
                              <td>{{@$detail['basic']->id_card}}</td>
                           </tr>
                           <tr>
                              <td><em>ESI / GPA</em></td>
                              <td>{{@$detail['basic']->esi_gpa_ghi}}</td>
                           </tr>
                           <tr>
                              <td><em>EPF</em></td>
                              <td>{{@$detail['basic']->epf}}</td>
                           </tr>
                           <tr>
                              <td><em>EPF Login </em></td>
                              <td>{{@$detail['basic']->erp_login}}</td>
                           </tr>
                           <tr>
                              <td><em>Training Period</em></td>
                              <td>{{@$detail['basic']->training_period}}</td>
                           </tr>
                           <tr>
                              <td><em>Security </em></td>
                              <td>{{@$detail['basic']->security}}</td>
                           </tr>
                           @if(@$detail['basic']->security == 'Yes')
                           <tr>
                              <td><em>Security amount </em></td>
                              <td>{{@$detail['basic']->security_amount }}</td>
                           </tr>
                           @endif
                           <tr>
                              <td><em>Security Cheque</em></td>
                              <td>{{@$detail['basic']->security_cheque}}</td>
                           </tr>
                           @if(@$detail['basic']->security_cheque == 'Yes')
                           <tr>
                              <td><em>Security Cheque Number </em></td>
                              <td>{{@$detail['basic']->security_cheque_number}}</td>
                           </tr>
                           <tr>
                              <td><em>Bank Name </em></td>
                              <td>{{@$detail['basic']->bank_name }}</td>
                           </tr>
                           @endif
                           <tr>
                              <td><em>Sim Card</em></td>
                              <td>{{@$detail['basic']->sim_card}}</td>
                           </tr>
                           <tr>
                              <td><em>Laptop or Pc </em></td>
                              <td>{{@$detail['basic']->laptop_or_pc}}</td>
                           </tr>
                           <tr>
                              <td><em>Mail Id </em></td>
                              <td>{{@$detail['basic']->mail_id}}</td>
                           </tr>
                           <tr>
                              <td><em>Visiting Card </em></td>
                              <td>{{@$detail['basic']->visiting_card}}</td>
                           </tr>
                           <tr>
                              <td><em>Uniform </em></td>
                              <td>{{@$detail['basic']->uniform}}</td>
                           </tr>

                           <tr>
                              <td><em>Department </em></td>
                              <td>{{@$detail['basic']->department}}</td>
                           </tr>
                           <tr>
                              <td><em>Designation </em></td>
                              <td>{{@$detail['basic']->designation}}</td>
                           </tr>
                        </table>
                        </div>
                     </div>        
         </div>  <!-- end of recuirtment tasks --><!-- /.tab-content -->          
      </div><!-- /.nav-tabs-custom -->        
   </div><!-- /.col -->      
</div><!-- /.row -->    
</section><!-- /.modal -->  
</div>
<!-- /.content-wrapper -->  
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>  
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>  
<script> 
   $(".changeProfilePicture").on('click',function(){        
   	$("#changeProfilePictureModal").modal('show');    
   });    
   
   $("#profilePictureForm").validate({      
   	rules :{          
   		"profilePic" : {              
   			required: true,              
   			accept: "image/*",              
   			filesize: 1048576    //1 MB          
   		}      
   	},      
   
   	messages :{          
   		"profilePic" : {              
   			required : 'Please select an image.',
   			accept : 'Please select a valid image format.',              
   			filesize: 'Filesize should be less than 1 MB.'          
   		}      
   	}    
   });    
   $.validator.addMethod('filesize', function(value, element, param) {        
   	return this.optional(element) || (element.files[0].size <= param)     
   });  
</script>  
@endsection