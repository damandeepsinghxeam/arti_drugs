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
img.profile-user-img.img-responsive.candidate_picture {
    margin-left: inherit;
    /*height: 150px;
    width: 150px;*/
}
</style>
<div class="content-wrapper">  
   <section class="content-header">
      <h1><center>Candidate Detail</center> 
         <span class="label label-success" id="created_check"></span>
      </h1>     

      <div class="alert alert-success" role="alert" style="font-size:16px;text-align: center;">
         <strong>Candidate Name</strong><b> : 
         {{@$detail['basic']->name}}</b>
      </div>

      <ol class="breadcrumb">
         <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
   </section>
   <!-- Main content --> 

    <section class="content">
      <div class="row">
         <!-- <div class="col-md-3"></div> -->
         <div class="col-md-2"></div>  
         <!-- /.col --> 

         <?php //dd($detail);die;?>

         <div class="col-md-8">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs edit-nav-styling">
                  <li id="levelOneDetailsTab" class="active"><a href="#tab_levelOneDetailsTab" data-toggle="tab">Level One Screening</a></li>
                  <li id="levelTwobasicDetailsTab" class=""><a href="#tab_levelTwobasicDetailsTab" data-toggle="tab">Level Two Screening</a></li>

                  <li id="appointmentDetailsTab" class=""><a href="#tab_appointmentcDetailsTab" data-toggle="tab">Appointment</a></li>

               </ul>
         <div class="tab-content">
            <div class="active tab-pane" id="tab_levelOneDetailsTab">
               <div class="box-body no-padding">
               <table class="table table-striped table-bordered">
                  <tr>
                     <th style="width: 30%"></th>
                     <th style="width: 70%"></th>
                  </tr>

                  @php
                  if($detail['basic']->image){
                    $candidate_picture = url('public/uploads/level_one_candidate_profile/'.$detail['basic']->image);
                  }else{
                    $candidate_picture = config('constants.static.profilePic');
                  }
                  @endphp

                  <tr>
                     <td><em>Candidate Photograph</em></td>
                     <td>
                        <div class="box-body box-profile">      
                           <img class="profile-user-img img-responsive candidate_picture" src="{{@$candidate_picture}}" alt="user profile picture" id="candidate_picture">
                        </div>
                     </td>
                  </tr>

                  <tr>
                     <td><em>Current Designation</em></td>
                     <td>{{@$detail['basic']->current_designation}}</td>
                  </tr>

                  <tr>
                     <td><em>Skill</em></td>
                     <td>{{@$detail['skills']}}</td>
                  </tr> 

                  <tr>
                     <td><em>Qualification</em></td>
                     <td>{{@$detail['qualification']}}</td>
                  </tr>

                  <tr>
                     <td><em>Languages</em></td>
                     <td>
                        <table class="table table-bordered table-striped text-center">
                           <thead class="mypf-table-head">
                              <tr>
                              <th class="mypf-table-head-value">Language name</th>
                              <th class="mypf-table-head-value">Read</th>
                              <th class="mypf-table-head-value">Write</th>
                              <th class="mypf-table-head-value">Speak</th>
                              </tr>
                           </thead>
                           @foreach(@$detail['languages'] as $lan)
                           <tbody>
                              <tr>
                              <td>{{@$lan->name}}</td>
                                 <?php if(!empty($lan->read_language == '0')){?>
                              <td>No</td>
                                 <?php } if(!empty($lan->read_language == '1')){?>
                              <td>Yes</td>
                                 <?php } if(!empty($lan->write_language == '0')){?>
                              <td>No</td>
                                 <?php } if(!empty($lan->write_language == '1')){?>
                              <td>Yes</td>
                                 <?php } if(!empty($lan->speak_language == '0')){?>
                              <td>No</td>
                                 <?php } if(!empty($lan->speak_language == '1')){?>
                              <td>Yes</td>
                                 <?php }?>
                              </tr>                   
                           </tbody>
                           @endforeach
                        </table>
                     </td>
                  </tr>

                  <tr>
                     <td><em>Contact</em></td>
                     <td>{{@$detail['basic']->contact}}</td>
                  </tr>
                  <tr>
                     <td><em>Age</em></td>
                     <td>{{@$detail['basic']->age}}</td>
                  </tr>
                  <tr>
                     <td><em>City</em></td>
                     <td>{{@$detail['basic']->city_name}}</td>
                  </tr>
                  <tr>
                     <td><em>Native Place </em></td>
                     <td>{{@$detail['basic']->native_place}}</td>
                  </tr>
                  <tr>
                     <td><em>Total Experience </em></td>
                     <td>{{@$detail['basic']->total_experience}}</td>
                  </tr>
                  <tr>
                     <td><em>Relevant Experience </em></td>
                     <td>{{@$detail['basic']->relevant_experience }}</td>
                  </tr>
                  <tr>
                     <td><em>Current CIH(Annualy)</em></td>
                     <td>{{@$detail['basic']->current_cih}}</td>
                  </tr>
                  <tr>
                     <td><em>Current CTC(Annualy)</em></td>
                     <td>{{@$detail['basic']->current_ctc}}</td>
                  </tr>
                  <tr>
                     <td><em>Expected CTC</em></td>
                     <td>{{@$detail['basic']->exp_ctc}}</td>
                  </tr>
                  <tr>
                     <td><em>Interview Date </em></td>
                     <td>{{@$detail['basic']->interview_date}}</td>
                  </tr>
                  <tr>
                     <td><em>Tnterview Time </em></td>
                     <td>{{@$detail['basic']->interview_time}}</td>
                  </tr>
                  <tr>
                     <td><em>Interview Type </em></td>
                     <td>{{@$detail['basic']->interview_type }}</td>
                  </tr>
                  <tr>
                     <td><em>Reason For Job Change </em></td>
                     <td>{{@$detail['basic']->reason_for_job_change }}</td>
                  </tr>

                  <tr>
                     <td><em>Current Company Profile </em></td>
                     <td>{{@$detail['basic']->current_company_profile }}</td>
                  </tr>
                  <tr>
                     <td><em>Can Travel within the region & to HO: </em></td>
                     <td>{{@$detail['basic']->travel }}</td>
                  </tr>
                  <tr>
                     <td><em>Commitment for 1 Year: </em></td>
                     <td>{{@$detail['basic']->contract }}</td>
                  </tr>

                  <tr>
                     <td><em>Notice Period : </em></td>
                     <td>{{@$detail['basic']->notice_period }}</td>
                  </tr>

                  @if(!empty($detail['basic']->notice_period_duration))
                  <tr>
                     <td><em>Notice Period  duration :</em></td>
                     <td>{{@$detail['basic']->notice_period_duration }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->final_candidate_status))
                  <tr>
                     <td><em>Final Status :</em></td>
                     <td>{{@$detail['basic']->final_candidate_status }}</td>
                  </tr>
                  @endif 

                  @if(!empty($detail['basic']->candidate_status))
                  <tr>
                     <td><em>Candidate Status :</em></td>
                     <td>{{@$detail['basic']->candidate_status }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->other_backoff_reason))
                  <tr>
                     <td><em>Candidate Status :</em></td>
                     <td>{{@$detail['basic']->other_backoff_reason }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->other_rejected_reason))
                  <tr>
                     <td><em>Candidate Status :</em></td>
                     <td>{{@$detail['basic']->other_rejected_reason }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->created_at))
                  <tr>
                     <td><em>Created Date:</em></td>
                     <td>{{@$detail['basic']->created_at }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->assigned_by))
                  <tr>
                     <td><em>Assigned By:</em></td>
                     <td>{{@$detail['basic']->assigned_by }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->fullname))
                  <tr>
                     <td><em>Assigned To:</em></td>
                     <td>{{@$detail['basic']->fullname }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->joining_date))
                  <tr>
                     <td><em>Date of joining:</em></td>
                     <td>{{@$detail['basic']->joining_date }}</td>
                  </tr>
                  @endif
               </table>
            </div>
         </div>    

         <!-- Level 2 Start -->
         <div class="tab-pane" id="tab_levelTwobasicDetailsTab">
            <div class="box-body no-padding">
               <table class="table table-striped table-bordered">
                  <tr>
                     <th style="width: 30%"></th>
                     <th style="width: 70%"></th>
                  </tr>

                  @if(!empty($detail['basic']->video_recording_seen))
                  <tr>
                     <td><em>Video Recording Seen</em></td>
                     <td>{{@$detail['basic']->video_recording_seen }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->qualify))
                  <tr>
                     <td><em>Qualify for Next Round?</em></td>
                     <td>{{@$detail['basic']->qualify }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->level))
                  <tr>
                     <td><em>Next level on phone or F2F?</em></td>
                     <td>{{@$detail['basic']->level }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->interaction_date))
                  <tr>
                     <td><em>Date of Interaction with Management</em></td>
                     <td>{{@$detail['basic']->interaction_date }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->final_result))
                  <tr>
                     <td><em>Final Result: </em></td>
                     <td>{{@$detail['basic']->final_result }}</td>
                  </tr>
                  @endif


                  @if(!empty($detail['basic']->interview_remarks))
                  <tr>
                     <td><em>Interview remarks by HOD : </em></td>
                     <td>{{@$detail['basic']->interview_remarks }}</td>
                  </tr>
                  @endif


                  @if(!empty($detail['basic']->created_at))
                  <tr>
                     <td><em>Created date: </em></td>
                     <td>{{@$detail['basic']->created_at }}</td>
                  </tr>
                  @endif
               </table>
                   </div>
                  </div> 
               <!-- end level 2 -->

            <!-- Candidate Appointment Start -->
         <div class="tab-pane" id="tab_appointmentcDetailsTab">
            <div class="box-body no-padding">
               <table class="table table-striped table-bordered">
                  <tr>
                     <th style="width: 30%"></th>
                     <th style="width: 70%"></th>
                  </tr>

                  @if(!empty($detail['basic']->ctc))
                  <tr>
                     <td><em>Hired Annual CTC (INR Lakhs)</em></td>
                     <td>{{@$detail['basic']->ctc }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->cih))
                  <tr>
                     <td><em>Hired Annual CIH (INR Lakhs)</em></td>
                     <td>{{@$detail['basic']->cih }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->incentives))
                  <tr>
                     <td><em>Incentives</em></td>
                     <td>{{@$detail['basic']->incentives }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->offer_letter))
                  <tr>
                     <td><em>OFFER LETTER</em></td>
                     <td>{{@$detail['basic']->offer_letter }}</td>
                  </tr>
                  @endif


                  @if(!empty($detail['basic']->id_card))
                  <tr>
                     <td><em>ID CARD</em></td>
                     <td>{{@$detail['basic']->id_card }}</td>
                  </tr>
                  @endif


                  @if(!empty($detail['basic']->esi_gpa_ghi))
                  <tr>
                     <td><em>ESI / GPA (immediate)/GHI (After 2 months)</em></td>
                     <td>{{@$detail['basic']->esi_gpa_ghi }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->epf))
                  <tr>
                     <td><em>EPF</em></td>
                     <td>{{@$detail['basic']->epf }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->erp_login))
                  <tr>
                     <td><em>ERP LOGIN</em></td>
                     <td>{{@$detail['basic']->erp_login }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->addition_in_company_group))
                  <tr>
                     <td><em>ADDITION IN COMPANY GROUPS</em></td>
                     <td>{{@$detail['basic']->addition_in_company_group }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->training_period))
                  <tr>
                     <td><em>TRAINING PERIOD(IN MONTHS)(IF HIRED AS TRAINEE)</em></td>
                     <td>{{@$detail['basic']->training_period }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->probation_period))
                  <tr>
                     <td><em>PROBATION PERIOD</em></td>
                     <td>{{@$detail['basic']->probation_period }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->security))
                  <tr>
                     <td><em>SECURITY</em></td>
                     <td>{{@$detail['basic']->security }}</td>
                  </tr>
                  @endif

                   @if(!empty($detail['basic']->security_cheque))
                  <tr>
                     <td><em>SECURITY CHEQUE</em></td>
                     <td>{{@$detail['basic']->security_cheque }}</td>
                  </tr>
                  @endif

                   @if(!empty($detail['basic']->sim_card))
                  <tr>
                     <td><em>SIM CARD</em></td>
                     <td>{{@$detail['basic']->sim_card }}</td>
                  </tr>
                  @endif

                   @if(!empty($detail['basic']->laptop_or_pc))
                  <tr>
                     <td><em>LAPTOP / PC</em></td>
                     <td>{{@$detail['basic']->laptop_or_pc }}</td>
                  </tr>
                  @endif

                   @if(!empty($detail['basic']->mail_id))
                  <tr>
                     <td><em>MAIL ID</em></td>
                     <td>{{@$detail['basic']->mail_id }}</td>
                  </tr>
                  @endif

                   @if(!empty($detail['basic']->visiting_card))
                  <tr>
                     <td><em>VISITING CARD</em></td>
                     <td>{{@$detail['basic']->visiting_card }}</td>
                  </tr>
                  @endif

                  @if(!empty($detail['basic']->uniform))
                  <tr>
                     <td><em>UNIFORM</em></td>
                     <td>{{@$detail['basic']->uniform }}</td>
                  </tr>
                  @endif
               </table>
                   </div>
                  </div> 

               </div>  <!-- end of recuirtment tasks --><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->        
         </div><!-- /.col --> 
      <div class="col-md-2"></div>     
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