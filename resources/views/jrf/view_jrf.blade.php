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
      <h1> JRF Detail 
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
         <div class="col-md-0">  
  
         </div>
         <!-- /.col -->
         <div class="col-md-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs edit-nav-styling">
                  <li id="basicDetailsTab" class="active"><a href="#tab_basicDetailsTab" data-toggle="tab">JRF DETAILS</a></li>
                  @if(@$detail['basic']->isactive == 1)
                  @if(!empty(@$detail['arf']))
                  <li id="arfDetailsTab"><a href="#tab_arfDetailsTab" data-toggle="tab">ARF DETAILS</a></li>@endif
                  <li id="approvalDetailsTab"><a href="#tab_approvalDetailsTab" data-toggle="tab">JRF STATUS</a></li>
                  <li id="appointmentDetailTab"><a href="#tab_appointmentDetailTab" data-toggle="tab">APPOINTMENT TEAM</a></li>
                  <li id="recruitmentDetailTab"><a href="#tab_recruitmentDetailTab" data-toggle="tab">RECRUITMENT TEAM</a></li>
                  <li id="closureDetailTab"><a href="#tab_closureDateDetailTab" data-toggle="tab">CLOSURE EXTEND DATE STATUS</a></li>
                  <li id="interviewDetailTab"><a href="#tab_interviewDetailTab" data-toggle="tab">INTERVIEW DETAILS</a></li>

                 <!-- <li id="candidateDetailTab"><a href="#tab_cand_approvalDetailsTab" data-toggle="tab">BEFORE APPOINTMENT CANDIDATE APPROVALS</a></li> -->
                  <li id="appointCandidateDetailTab"><a href="#tab_appointCandidateDetailTab" data-toggle="tab">APPOINTED CANDIDATE APPROVALS</a></li>
                  <li id="feedbackDetailTab"><a href="#tab_feedbackDetailTab" data-toggle="tab">FEEDBACK</a></li>
                  @endif
               </ul>
               <div class="tab-content">
                  <div class="active tab-pane" id="tab_basicDetailsTab">
                     <div class="box-body no-padding">
                        <table class="table table-striped table-bordered">
                           <tr>
                              <th style="width: 30%"></th>
                              <th style="width: 50%"></th>
                           </tr>

                           <tr>
                              <td><em>Project Type</em></td>
                              @if(@$detail['basic']->type == "Xeam") 
                                 <td>Internal-Hiring</td>
                              @elseif(@$detail['basic']->type == "Project")
                                 <td>Project-Hiring</td>
                              @endif
                           </tr>
                           <tr>
                              <td><em>Project</em></td>
                              <td>{{@$detail['basic']->project_name}}</td>
                           </tr> 
                           <tr>
                              <td><em>Request From Department</em></td>
                              <td>{{@$detail['basic']->name}}</td>
                           </tr>
                           <tr>
                              <td><em>Job Role</em></td>
                              <td>{{@$detail['basic']->role}}</td>
                           </tr>
                           <tr>
                              <td><em>Designation</em></td>
                              <td>{{@$detail['basic']->designation}}</td>
                           </tr>
                           <tr>
                              <td><em>No. of Positions</em></td>
                              <td>{{@$detail['basic']->number_of_positions}}</td>
                           </tr>
                           <tr>
                              <td><em>Relevant Experience( in years )</em></td>
                              <td>{{@$detail['basic']->experience}}</td>
                           </tr>
                           <tr>
                              <td><em>Salary Range(Annual)</em></td>
                              <td>{{@$detail['basic']->salary_range}}</td>
                           </tr>
                           <tr>
                              <td><em>Location </em></td>
                              <td>{{@$detail['location'] }}</td>
                           </tr>
                           <tr>
                              <td><em>Age </em></td>
                              <td>{{@$detail['basic']->age_group}}</td>
                           </tr>
                           <tr>
                              <td><em>Gender </em></td>
                              <td>{{@$detail['basic']->gender}}</td>
                           </tr>
                            <tr>
                              <td><em>Qualification </em></td>
                              <td>{{@$detail['qualification']}}</td>
                           </tr>
                           <tr>
                              <td><em>Skills </em></td>
                              <td>{{@$detail['skills'] }}</td>
                           </tr>

                           @if(!empty($detail['basic']->additional_requirement))
                           <tr>
                              <td><em>Additional Requirement </em></td>
                              <td>{{@$detail['basic']->additional_requirement}}</td>
                           </tr>
                           @endif
                           
                           <tr>
                              <td><em>Description </em></td>
                              <td>{{@$detail['basic']->description}}</td>
                           </tr>

                           <tr>
                              <td><em>Ad posting On other website </em></td>
                              <td>{{@$detail['basic']->job_posting_other_website}}</td>
                           </tr>

                           <!-- when JRF TYPE Project -->

                           @if(!empty($detail['basic']->type == "Project"))
                           <tr>
                              <td><em>Certification </em></td>
                              <td>{{@$detail['basic']->certification}}</td>
                           </tr>
                           <tr>
                              <td><em>Benefits Perks </em></td>
                              <td>
                                 <span class="label label-info">{{@$detail['benifit_perk'][0]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][1]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][2]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][3]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][4]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][5]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][6]}}</span>
                                 <span class="label label-info">{{@$detail['benifit_perk'][7]}}</span>
                              </td>
                           </tr>
                           <tr>
                              <td><em>Model</em></td>
                              
                              @if(@$detail['basic']->temp_or_perm == "perm") 
                                 <td>Permanent</td>
                              @elseif(@$detail['basic']->type == "temp")
                                 <td>Temporary</td>
                              @endif
                           </tr>

                           <tr>
                              <td><em>Service charges fee </em></td>
                              <td>{{@$detail['basic']->service_charges_fee}}</td>
                           </tr>
                           @endif
                           <!-- end of JRF TYPE -->


                           @if(!empty($detail['basic']->document))
                           <tr>
                              <td><em>Document</em></td>
                              <td>                                
                                 <span><a target="_blank" href="{{config('constants.uploadPaths.uploadJrfDocument').$detail['basic']->document}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></span>
                              </td>
                           </tr>
                           @endif
                        </table>
                        </div>

                        @if($detail['jrf_approvalsA'][0]->jrf_status == '0')

                           @if($user->id == '13')
                              <div class="box-footer">

                                 <button type="button" class="btn btn-default accountFormSubmit" id="accountFormSubmit"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{ $detail['jrf_can_app']->supervisor_id }}" data-jrf_id="{{ $detail['jrf_can_app']->jrf_id }}" data-statusname="Approved" data-final_status="1" data-u_id="{{ $detail['jrf_can_app']->user_id }}">Approve</a></button>
                                 
                                 <button type="button" class="btn btn-default accountFormSubmit" id="accountFormSubmitA" value=""><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{ $detail['jrf_can_app']->supervisor_id }}" data-jrf_id="{{ $detail['jrf_can_app']->jrf_id }}" data-statusname="Rejected" data-final_status="2" data-u_id="{{ $detail['jrf_can_app']->user_id }}">Reject</a></button>

                                 <button type="button" class="btn btn-default accountFormSubmit" id="accountFormSubmitAB" value=""><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{ $detail['jrf_can_app']->supervisor_id }}" data-jrf_id="{{ $detail['jrf_can_app']->jrf_id }}" data-statusname="Rejected" data-final_status="3" data-u_id="{{ $detail['jrf_can_app']->user_id }}">Send Back</a></button>
                                 
                                 <button type="button" class="btn btn-default accountFormSubmit" id="accountFormSubmit" value=""><a href="{{url('jrf/edit-jrf') .'/'.$detail["jrf_can_app"]->jrf_id}}" >Edit JRF</a></button>

                              </div>

                           @endif
                           @elseif($detail['jrf_approvalsA'][0]->jrf_status == '1')
                              <span class="label label-success">{{"JRF Approved"}} </span>
                           @elseif($detail['jrf_approvalsA'][0]->jrf_status == '2')
                              <span class="label label-danger">{{"JRF Rejected"}} </span>
                           @else($detail['jrf_approvalsA'][0]->jrf_status == '3')
                              <span class="label label-primary">{{"JRF Send Back"}} </span>      
                        @endif


                       <!-- <li><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{ $detail['jrf_can_app']->supervisor_id }}" data-jrf_id="{{ $detail['jrf_can_app']->jrf_id }}" data-statusname="Approved" data-final_status="1" data-u_id="{{ $detail['jrf_can_app']->user_id }}">Approve</a></li>
                        
                        <li><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{ $detail['jrf_can_app']->supervisor_id }}" data-jrf_id="{{ $detail['jrf_can_app']->jrf_id }}" data-statusname="Rejected" data-final_status="2" data-u_id="{{ $detail['jrf_can_app']->user_id }}">Reject</a></li>

                        <li><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{ $detail['jrf_can_app']->supervisor_id }}" data-jrf_id="{{ $detail['jrf_can_app']->jrf_id }}" data-statusname="SendBack" data-final_status="3" data-u_id="{{ $detail['jrf_can_app']->user_id }}">Send Back</a></li> -->

                     </div>

                        

                  <!-- start ARF-->
                  @if(!empty(@$detail['arf']))
                  <div class="tab-pane" id="tab_arfDetailsTab">                
                     <div class="box-body no-padding">                        
                        <table class="table table-striped table-bordered">                          
                           <tr>                            
                              <th style="width: 30%">Field</th>                            
                              <th style="width: 70%">Value</th>
                           </tr>

                           <tr>                            
                              <td><em>Department</em></td>                            
                              <td>{{@$detail['basic']->name}}</td> 
                           </tr>

                           <tr>                            
                              <td><em>Creator name</em></td>                            
                              <td>{{@$detail['arf']->fullname}}</td> 
                           </tr>

                           <tr>                            
                              <td><em>How many ads are required to be posted</em></td>
                              <td>{{@$detail['arf']->post_count}}</td>
                           </tr>

                           <tr>   
                              <td><em>What is the balance of Ad posting</em></td>
                              <td>{{@$detail['arf']->post_amount}}</td>         
                           </tr>  

                           <tr>                            
                              <td><em>Date of Request:</em></td>                            
                              <td>{{@$detail['arf']->request_date}}</td>   
                           </tr>

                           <tr>                            
                              <td><em>Ad Content:</em></td>                            
                              <td>{{@$detail['arf']->post_content}}</td>   
                           </tr>

                           <tr>                            
                              <td><em>Job Post</em></td>                            
                              <td>
                                 <span class="label label-info">{{@$detail['job_name'][0]}}</span>
                                 <span class="label label-info">{{@$detail['job_name'][1]}}</span>
                                 <span class="label label-info">{{@$detail['job_name'][2]}}</span>
                                 <span class="label label-info">{{@$detail['job_name'][3]}}</span>
                              </td>   
                           </tr>
                        </table> 
                     </div>    
                  </div>
               @endif
               <!-- end ARF -->

                <!-- start Approva-->
               
                  <div class="tab-pane" id="tab_approvalDetailsTab">                
                     <div class="box-body no-padding">                        
                        <table class="table table-striped table-bordered">

                     @if( !empty( $detail['basic'] ) )
                           
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                           </tr>

                           <tr>  
                              <td style="width: 35%"><em>JRF Created By</em></td>
                              <td>{{@$detail['basic']->fullname}} </td>
                           </tr>

                           <tr>  
                              <td><em>Creation Date</em></td>
                              <td>{!! date('yy-m-d', strtotime($detail['basic']->created_at)) !!}
                              </td>
                           </tr> 

                        @endif


                        @php $counter = 1; @endphp
                        @if(!empty(@$detail['jrf_approvalsA']))                 
                        @foreach(@$detail['jrf_approvalsA'] as  $approvals)  
                          
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                           </tr>

                           <tr>
                              @if($approvals->supervisor_id == '13')
                                 <td><em>JRF Approved By Approval Authority</em></td>
                              @else
                                 <td><em>JRF Assigned To Recruitment Head </em></td>
                              @endif                            
                              <td>{{@$approvals->fullname}} </td>
                           </tr>

                           <tr>  
                              <td><em>Approved  Date</em></td>
                              @if($approvals->jrf_status == 0)
                                 <td>------</td>
                              @else
                                 <td>{!! date('yy-m-d', strtotime($approvals->updated_at)) !!}</td>
                              @endif
                           </tr>

                           <tr>  
                              @if($approvals->jrf_status == '0' || $approvals->jrf_status == '2' || $approvals->jrf_status == '3')
                                 <td><em>JRF Status</em></td>
                              @endif
                              <td>
                                 @if($approvals->jrf_status == '0')
                                    <span class="label label-warning">{{"Pending"}} </span>
                                 @elseif($approvals->jrf_status == '2')
                                    <span class="label label-danger">{{"Rejected"}}</span> 
                                 @elseif($approvals->jrf_status == '3')
                                    <span class="label label-primary">{{"SendBack"}}</span> 
                                 @endif
                              </td>
                           </tr>
                        @endforeach
                        
                        @if(!@$detail['recruitment_detail']->isEmpty())                 
                         
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                            </tr>

                           <tr>                            
                              <td><em>Assigned To Recruiter</em></td>                            
                              <td><a href="#tab_recruitmentDetailTab" data-toggle="tab" id="recruitmentDetailTab">YES</a></td>
                           </tr>

                           <tr>                            
                              <td><em>JRF Status</em></td>                            
                              <td><span class="label label-success">{{"APPROVED"}} </span></td>
                           </tr>
                        @endif               
               

                        @if( !empty( $detail['arf_approvals'] ) )
                           
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                           </tr>

                           <tr>  
                              <td><em>Arf Approved By</em></td>
                              <td>{{@$detail['arf_approvals']->fullname}} </td>
                           </tr>

                           <tr>  
                              <td><em>Approved  Date</em></td>
                              <td>{{@$detail['arf_approvals']->created_at}} </td>
                           </tr>
                           <tr>  
                              <td><em>Arf Status</em></td>
                              <td>
                                 @if($detail['arf_approvals']->arf_status == '0')
                                    <span class="label label-warning">{{"Progress"}} </span>
                                 @elseif($detail['arf_approvals']->arf_status == '1')
                                    <span class="label label-success">{{"Approved"}} </span>
                                 @elseif($detail['arf_approvals']->arf_status == '2')
                                    <span class="label label-danger">{{"Rejected"}}</span> 
                                 @endif
                              </td>
                           </tr>      
                           @endif
                     @else 
                     <tr>  
                        <td><em>Current Status</em></td>                            
                        <td>Recruiter Not schedule any interview.</td>
                     </tr>          
                     @endif 

                        </table> 
                     </div>    
                  </div>

               <!-- end Approval -->

                <!-- for Appointment task -->
               <div class="tab-pane" id="tab_appointmentDetailTab">                
                  <div class="box-body no-padding">                     

                     <table class="table table-striped table-bordered">                          
                        <tr>
                           <th style="width: 10%;height:45px;">S.No</th> 
                           <th style="width: 30%;height:45px;">Appointment Department</th>
                           <th style="width: 30%;height:45px;">Appointment Head</th>

                        </tr>

                        @php $counter = 1; @endphp
                        @if(!empty(@$detail['dep_head']))                 
                            <tr style="">                            
                              <td>{{@$counter++}}</td>
                              <td>{{@$detail['dep_head']->dep_name}}</td> 
                              <td>{{@$detail['dep_head']->employee_name}}</td>
                           </tr>
                        @else 
                        <tr>  
                           <td><em>Current Status</em></td>                            
                           <td>JRF Not Appointed to Any Recruiter.</td>

                        </tr>       
                     @endif 
                  </table> 
               </div>    
            </div>  
                  
               <!-- for recuritment task -->
               <div class="tab-pane" id="tab_recruitmentDetailTab">                
                  <div class="box-body no-padding">                     

                     <table class="table table-striped table-bordered">                          
                        <tr>
                           <th style="width: 10%;height:45px;">S.No</th> 
                           <th style="width: 30%;height:45px;">Assigned By</th>
                           <th style="width: 30%;height:45px;">Assigned To</th>
                           <th style="width: 30%;height:45px;">Department</th>
                           <th style="width: 30%;height:45px;">Status</th>

                        </tr>

                        @php $counter = 1; @endphp
                        @if(!@$detail['recruitment_detail']->isEmpty())                 
                           @foreach(@$detail['recruitment_detail'] as  $recruitment)      
                            <tr style="">                            
                              <td>{{@$counter++}}</td>
                              <td>{{@$recruitment->assigned_by}}</td> 
                              <td>{{@$recruitment->fullname}}</td>
                              <td>{{@$recruitment->name}}</td>
                              <td>
                                 @if($recruitment->is_assigned == 1)
                                    <span class="label label-danger">Unassigned By HOD</span>
                                    
                                 @else
                                    <span class="label label-success">Assigned</span>
                                 @endif

                              </td> 
                           </tr>
                           @endforeach               
                        @else 
                        <tr>  
                           <td><em>Current Status</em></td>                            
                           <td>JRF Not assigned to Any Recruiter.</td>
                        </tr>       
                     @endif 
                  </table> 
               </div>    
            </div>  

             <!-- Closure Date Approval -->
               
                  <div class="tab-pane" id="tab_closureDateDetailTab">                
                     <div class="box-body no-padding">                        
                        <table class="table table-striped table-bordered">

                        @php $counter = 1; @endphp
                        @if(!empty(@$detail['jrf_closure_date_approvals']))                 
                        @foreach(@$detail['jrf_closure_date_approvals'] as  $closure_date_approvals)  
                          
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                           </tr>

                           <tr>
                              @if($closure_date_approvals->supervisor_id == 13)
                                 <td><em>Closure Date Approved By Approval Authority</em></td>
                              @else
                                 <td><em>Closure Date Approved By JRF Creater</em></td>
                              @endif                            
                              <td>{{@$closure_date_approvals->fullname}} </td>
                           </tr>

                           <tr>  
                              <td><em>Approved  On</em></td>
                              @if($closure_date_approvals->jrf_status == 0)
                                 <td>------</td>
                              @else
                                 <td>{!! date('yy-m-d', strtotime($closure_date_approvals->updated_at)) !!}</td>
                              @endif
                           </tr>

                           <tr>  
                              <td><em>Extended Date Status</em></td>
                              <td>
                                 @if($closure_date_approvals->jrf_status == '0')
                                    <span class="label label-warning">{{"Pending"}} </span>
                                 @elseif($closure_date_approvals->jrf_status == '1')
                                    <span class="label label-success">{{"Approved"}}</span> 
                                 @elseif($closure_date_approvals->jrf_status == '2')
                                    <span class="label label-danger">{{"Rejected"}}</span>
                                 @elseif($closure_date_approvals->jrf_status == '3')
                                    <span class="label label-primary">{{"Discussion"}}</span>  
                                 @endif
                              </td>
                           </tr>
                        @endforeach
                        


                        @if( !empty( $detail['arf_approvals'] ) )
                           
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                           </tr>

                           <tr>  
                              <td><em>Arf Approved By</em></td>
                              <td>{{@$detail['arf_approvals']->fullname}} </td>
                           </tr>

                           <tr>  
                              <td><em>Approved  Date</em></td>
                              <td>{{@$detail['arf_approvals']->created_at}} </td>
                           </tr>
                           <tr>  
                              <td><em>Arf Status</em></td>
                              <td>
                                 @if($detail['arf_approvals']->arf_status == '0')
                                    <span class="label label-warning">{{"Progress"}} </span>
                                 @elseif($detail['arf_approvals']->arf_status == '1')
                                    <span class="label label-success">{{"Approved"}} </span>
                                 @elseif($detail['arf_approvals']->arf_status == '2')
                                    <span class="label label-danger">{{"Rejected"}}</span> 
                                 @endif
                              </td>
                           </tr>      
                           @endif
                     @else 
                     <tr>  
                        <td><em>Current Status</em></td>                            
                        <td>Recruiter Not schedule any interview.</td>
                     </tr>          
                     @endif 

                        </table> 
                     </div>    
                  </div>

               <!-- Closure Date Approval -->    

            <div class="tab-pane" id="tab_interviewDetailTab">
               <div class="box-body no-padding">
                  <table class="table table-striped table-bordered">                          
                    <tr>
                        <th style="width: 10%;height:45px;">S.No</th> 
                        <th style="width: 10%;height:45px;">Candidate Name</th> 
                        <th style="width: 15%;height:45px;">Interview Date</th>
                        <th style="width: 15%;height:45px;">Interview Time</th>
                        <th style="width: 15%;height:45px;">Interviewer</th>
                        <th style="width: 15%;height:45px;">Level 1 Status</th>
                        <th style="width: 10%;height:45px;">Level 2 Status</th>
                        
                     </tr>
                        @php $counter = 1; @endphp
                        @if(!@$detail['interview_detail']->isEmpty())                 
                        @foreach(@$detail['interview_detail'] as  $interview)  
                          
                           @if($interview->candidate_status == 'Recommended-Level-2-interview')

                           <tr>
                              <td><em>{{@$counter++ }}</em></td>                          
                              <td><a href='{{url("jrf/candidate-level-one-screening-detail/$interview->jrf_level_one_screening_id")}}' target="_blank">{{@$interview->name}}</a></td>  
                              <td>{{@$interview->interview_date}}</td>
                              <td>{{@$interview->interview_time}}</td>                       
                              <td>{{@$interview->fullname}} </td>
                              <td>{{@$interview->candidate_status}} </td>

                              @if(!empty($interview->final_result))
                                 <td>{{@$interview->final_result}} </td>
                              @else
                                 <td>In Progress</td>
                              @endif

                           @endif

                        @endforeach
                     @else 
                    <!-- <tr>  
                        <td><em>Current Status</em></td>                            
                        <td>Recruiter Not schedule any interview.</td>
                     </tr> -->         
                     @endif 
                  </table>
               </div>
                  </div><!-- /.tab-pane -->            

                <!-- start Level First Approva-->

                  <div class="tab-pane" id="tab_cand_approvalDetailsTab">                
                     <div class="box-body no-padding">                        
                        <table class="table table-striped table-bordered">
                           <tr bgcolor="#3c8dbc">
                              <td><em></em></td>
                              <td><em></em></td>
                           </tr>

                        @php $counter = 1; @endphp
                        @if(!empty(@$detail['cand_lvl_approvals']))                 
                        @foreach(@$detail['cand_lvl_approvals'] as  $cand_approvals)  
                          
                           <tr bgcolor="#3c8dbc">
                              <td></td>
                              <td></td>
                           </tr>

                           <tr>  
                              <td><em>Candidate Name</em></td>
                              <td><a href='{{url("jrf/candidate-level-one-screening-detail/$cand_approvals->jrf_level_one_screening_id")}}' target="_blank">{{@$cand_approvals->name}} </td>
                           </tr>

                           <tr>  
                              <td><em>Total Experience</em></td>
                              <td>{{@$cand_approvals->total_experience}} </td>
                           </tr>

                           <tr>  
                              <td><em>Previous Company CTC</em></td>
                              <td>{{@$cand_approvals->current_ctc}} </td>
                           </tr>

                           <tr>  
                              <td><em>Previous Company CIH</em></td>
                              <td>{{@$cand_approvals->current_cih}} </td>
                           </tr>

                           <tr>  
                              <td><em>Interview  Date</em></td>
                              <td>{{@$cand_approvals->interview_date}} </td>
                           </tr>
                           
                           <tr>  
                              <td><em>Candidate  Status Level 1 Status</em></td>
                              <td>{{@$cand_approvals->candidate_status}} </td>
                           </tr>

                           @if(!empty($cand_approvals->final_result))
                              <tr>  
                                 <td><em>Candidate  Status Level 2 Status</em></td>

                                 @if($cand_approvals->final_result == 'Selected')
                                    <td><span class="label label-success">{{@$cand_approvals->final_result}}</span></td>
                                 @elseif ($cand_approvals->final_result == 'Rejected')
                                    <td><span class="label label-danger">{{@$cand_approvals->final_result}}</span></td>
                                 @else
                                    <td><span class="label label-primary">{{@$cand_approvals->final_result}}</span></td>
                                 @endif

                              </tr>
                              @else
                              <tr>  
                                 <td><em>Candidate  Status Level 2 Status</em></td>                            
                                 <td><span class="label label-warning">In Progress</span></td>
                              </tr>
                              @endif   
                              @if(!empty($cand_approvals->level))
                              <tr>  
                                 <td><em>Management Interaction</em></td>
                                 <td><span class="label label-primary">{{@$cand_approvals->level}}</span></td>
                              </tr>
                              @else
                               <tr>  
                                 <td><em>Management Interaction</em></td>
                                 <td><span class="label label-danger">NO</span></td>
                              </tr>
                              @endif
                              @if(!empty($cand_approvals->level))
                              <tr>  
                                 <td><em>Management Approval</em></td>
                                 <td>
                                    @if($cand_approvals->jrf_status == '0')
                                       <span class="label label-warning">{{"Progress"}} </span>
                                    @elseif($cand_approvals->jrf_status == '1')
                                       <span class="label label-success">{{"Approved"}} </span>
                                    @elseif($cand_approvals->jrf_status == '2')
                                       <span class="label label-danger">{{"Rejected"}}</span> 
                                    @endif
                                 </td>
                              </tr>
                              @endif

                        @endforeach
                     @else 
                     <tr>  
                        <td><em>Current Status</em></td>                            
                        <td>Recruiter No Candidate Shows Before Appointment.</td>
                     </tr>          
                     @endif 

                        </table> 
                     </div>    
                  </div>

               <!-- end Approval -->


               <!-- start Approva-->
               
                  <div class="tab-pane" id="tab_appointCandidateDetailTab">                
                     <div class="box-body no-padding">                        
                        <table class="table table-striped table-bordered">

                            <tr>                            
                        <th style="width: 30%">Field</th>                            
                        <th style="width: 70%">Value</th>
                     </tr>

                        @php $counter = 1; @endphp
                        @if(!empty(@$detail['jrf_cand_approvals']))                 
                        @foreach(@$detail['jrf_cand_approvals'] as  $cand_approvals)  
                          
                           <tr bgcolor="#3c8dbc">
                              <td><em>Sr.No. {{@$counter++ }}</em></td>
                              <td></td>
                           </tr>

                           <tr>  
                              <td><em>Candidate  Name</em></td>
                              <td><a href='{{url("jrf/candidate-level-one-screening-detail/$cand_approvals->jrf_level_one_screening_id")}}' target="_blank">{{@$cand_approvals->cand_name}} </td>
                           </tr>

                           <tr>  
                              <td><em>Candidate  Approved By</em></td>
                              <td>{{@$cand_approvals->fullname}} </td>
                           </tr>

                           <tr>  
                              <td><em>Approved  Date</em></td>
                              <td>{{@$cand_approvals->created_at}} </td>
                           </tr>
                         

                           <tr>  
                              <td><em>Final Status</em></td>
                              <td>
                                 @if($cand_approvals->jrf_status == '0')
                                    <span class="label label-warning">{{"Progress"}} </span>
                                 @elseif($cand_approvals->jrf_status == '1')
                                    <span class="label label-success">{{"Approved"}} </span>
                                 @elseif($cand_approvals->jrf_status == '2')
                                    <span class="label label-danger">{{"Rejected"}}</span> 
                                 @endif
                              </td>
                           </tr>

                        @endforeach
                     @else 
                     <tr>  
                        <td><em>Current Status</em></td>                            
                        <td>Recruiter No Candidate Shows After Appointment.</td>
                     </tr>          
                     @endif 

                        </table> 
                     </div>    
                  </div>

               <!-- end Approval -->

                              <!-- start Approva-->
               
                  <div class="tab-pane" id="tab_feedbackDetailTab">                
                     <div class="box-body no-padding">                        
                        <table class="table table-striped table-bordered">
                        <tr>
                           <th style="width: 10%;height:45px;">S.No</th> 
                           <th style="width: 10%;height:45px;">Feedback Received From</th> 
                           <th style="width: 15%;height:45px;">Candidate  Name</th>
                           <th style="width: 15%;height:45px;">Quick Learner</th>
                           <th style="width: 15%;height:45px;">Confidence Level</th>
                           <th style="width: 15%;height:45px;">Attitude</th>
                           <th style="width: 10%;height:45px;">Team Work</th>
                           <th style="width: 10%;height:45px;">Execution Skills</th>
                           <th style="width: 10%;height:45px;">Result Orientation</th>
                           <th style="width: 10%;height:45px;">Attendence</th>
                           <th style="width: 10%;height:45px;">Feedback  Date</th>
                           <th style="width: 10%;height:45px;">Final Status</th>    

                        </tr> 

                        @php $counter = 1; @endphp
                        @if(!empty(@$detail['jrf_cand_feedback']))                 
                        @foreach(@$detail['jrf_cand_feedback'] as  $cand_feedback)  
                          
                           <tr>
                              <td>{{@$counter++ }}</td>                            
                              <td>{{@$cand_feedback->fullname}} </td>
                              <td>{{@$cand_feedback->cand_name}} </td>
                              <td>{{@$cand_feedback->quick_learner}} </td>
                              <td>{{@$cand_feedback->confid_lvl}} </td>
                              <td>{{@$cand_feedback->attitude}} </td>
                              <td>{{@$cand_feedback->team_work}} </td>
                              <td>{{@$cand_feedback->exec_skill}} </td>
                              <td>{{@$cand_feedback->result_orient}} </td>
                              <td>{{@$cand_feedback->attendence}} </td>
                              <td>{{@$cand_feedback->created_at}} </td>
                              <td><span class="label label-success">{{ "Selected" }}</span></td>
                           </tr>

                        @endforeach
                     @else 
                     <tr>  
                        <td><em>Current Status</em></td>                            
                        <td>Recruiter No Feedback Received.</td>
                     </tr>          
                     @endif 

                        </table> 
                     </div>    
                  </div>

               <!-- end Approval -->


         </div>  <!-- end of recuirtment tasks --><!-- /.tab-content -->          
      </div><!-- /.nav-tabs-custom -->        
   </div><!-- /.col -->      
</div><!-- /.row -->    
</section><!-- /.modal -->  

</div>

      <div class="modal fade" id="jrfsStatusModal">
          <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">JRF Status Form</h4>
               </div>
               <div class="modal-body">
                  <form id="jrfStatusForm" action="{{url('jrf/save-jrf-approval') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                     <div class="form-row">
                         <div class="form-group">
                           <label for="statusName" class="docType">Selected Status</label>
                           <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                         </div>
                      </div>
                     
                     <div class="form-row" id="rec_head"> 
                        <div class="form-group">
                           <label for="statusName" class="docType">Recruitment Head</label>
                           <select class="form-control select2 input-sm basic-detail-input-style" name="rec_head" style="width: 100%;" id="rec_head" data-placeholder="Select Recruitment Head" onclick="javascript:yesnoCheck();">
                              <option value="">Please Select</option> 
                               @if(!$detail['reporting_manager']->isEmpty())
                               @foreach($detail['reporting_manager'] as $rep_mang) 
                               <option value="{{$rep_mang->user_id}}">{{$rep_mang->fullname}}</option>
                               @endforeach
                               @endif  
                           </select>
                         </div>
                     </div> 

                      <div class="row" id="int_dep"> 
                        <div class="form-group">
                           <div class="col-md-6">
                              <label for="statusName" class="docType">Appointment Department</label>
                              <select class="form-control select2 input-sm basic-detail-input-style" name="interviewer_department" style="width: 100%;" id="interviewer_department" data-placeholder="Select Recruitment Head">
                                 <option value="">Please Select</option> 
                                 @if(!$department->isEmpty())
                                 @foreach($department as $department) 
                                 <option value="{{$department->id}}">{{$department->name}}</option>
                                 @endforeach
                                 @endif  
                              </select>
                           </div>
                       
                        
                        <div class="col-md-6">
                           <label for="statusName" class="docType">Appointment Head</label>
                           <select class="form-control basic-detail-input-style regis-input-field" name="interviewer_employee" id="interviewer_employee"></select>

                        </div>
                     </div>
                     </div> 
                       
                      <input type="hidden" name="jrf_id" id="jrf_id">
                      <input type="hidden" name="userId" id="userId">
                      <input type="hidden" name="final_status" id="final_status">
                      <input type="hidden" name="u_id" id="u_id">
                      <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" rows="5" name="remark" id="remark"></textarea>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <br><div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="jrfStatusFormSubmit">Submit</button>
                    </div>
                </form>
              </div>
          </div>
        </div>
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
      <script type="text/javascript">
        $(document).ready(function() {
           $(".approvalStatus").on('click', function() {
               var jrf_id = $(this).data("jrf_id");
               var userId = $(this).data("user_id");
               var final_status = $(this).data("final_status");
               var statusname = $(this).data("statusname");
               var u_id = $(this).data("u_id");

               $("#jrf_id").val(jrf_id);
               $("#userId").val(userId);
               $("#final_status").val(final_status);
               $("#statusName").val(statusname);
               $("#u_id").val(u_id);
               $('#jrfsStatusModal').modal('show');
            });

            $("#jrfStatusForm").validate({
               rules: {
                   "remark": {
                       required: true,
                   },
                   "rec_head":{
                      required: true,
                   },
                   "interviewer_department":{
                     required: true,
                   }
               },
               messages: {
                   "remark": {
                       required: 'Please enter a remark.',
                   },
                   "rec_head": {
                       required: 'Please Select Recruitment Head',
                   },
                   "interviewer_department": {
                       required: 'Please Select Appointment Department',
                   }
               }

               

            });
        });
      </script>

      <script type="text/javascript">
      // for interviewer
    $('#interviewer_department').on('change', function(){
      var inter_department = $(this).val();
      var displayString = "";
      $("#interviewer_employee").empty();
      var inter_departments = [];
      inter_departments.push(inter_department);
      $.ajax({
        type: "POST",
        url: "{{url('employees/departments-wise-employees')}}",
        data: {department_ids: inter_departments},
        success: function(result){
          if(result.length == 0 || (result.length == 1 && result[0].user_id == userId)){
            displayString += '<option value="" disabled>None</option>';
          }else{
            result.forEach(function(employee){
              if(employee.user_id != 1){
                displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
              }
            });
          }
          $('#interviewer_employee').append(displayString);
        }
      });
    }).change();
    // end
</script>

<script type="text/javascript">

   $(function() {
      $('#accountFormSubmitA').on('click', function() {
         $("#rec_head").hide();
         $("#int_dep").hide();
      });

       $('#accountFormSubmitAB').on('click', function() {
         $("#rec_head").hide();
         $("#int_dep").hide();
      });
   });

</script>

@endsection