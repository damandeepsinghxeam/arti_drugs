@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->  

<div class="content-wrapper">    

	<!-- Content Header (Page header) -->    

	<section class="content-header">      

		<h1>        

			My Profile        

			<!-- <small>Control panel</small> -->      

		</h1>      

		<ol class="breadcrumb">        

			<li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>        

			<!-- <li class="active">Dashboard</li> -->      

		</ol>    

	</section>    



	@php

		if($user->employee->profile_picture){

			$profile_picture = config('constants.uploadPaths.profilePic').$user->employee->profile_picture;

		}else{

			$profile_picture = config('constants.static.profilePic');

		}

		 

	@endphp

	<!-- Main content -->    

	<section class="content">      

		<div class="row">        

			<div class="col-md-3">          

				<!-- Profile Image -->          

				<div class="box box-primary">            

					<div class="box-body box-profile">              

						<img class="profile-user-img img-responsive img-circle" src="{{@$profile_picture}}" alt="User profile picture">              

						<h3 class="profile-username text-center">{{@$user->employee->fullname}}</h3>              

						<p class="text-muted text-center">
						@if(@$user->roles[0]->name != 'MD')
							{{@$user->roles[0]->name}}
						@else
							Managing Director		
						@endif	
						</p>              

						<!-- <ul class="list-group list-group-unbordered">                

						<li class="list-group-item">                  

						<b>Followers</b> <a class="pull-right">1,322</a>                

						</li>                

						<li class="list-group-item">                  

						<b>Following</b> <a class="pull-right">543</a>                

						</li>                

						<li class="list-group-item">                  

						<b>Friends</b> <a class="pull-right">13,287</a>                

						</li>              

						</ul> -->              

						<a href="{{ url('employees/change-password') }}" class="btn btn-primary btn-block"><b>Change Password</b></a>              

						<a href="javascript:void(0)" class="btn btn-success btn-block changeProfilePicture"><b>Change Profile Picture</b></a>            

					</div>            

					<!-- /.box-body -->          

				</div>          

				<!-- /.box -->          

				<!-- About Me Box -->          

				<div class="box box-primary">            

					<div class="box-header with-border">              

						<h3 class="box-title">About Me</h3>            

					</div>            

					<!-- /.box-header -->            

					<div class="box-body">              

						<strong><i class="fa fa-book margin-r-5"></i> Languages</strong>              

						<p class="text-muted">               

						 @if(!$user->languages->isEmpty())                 

						  @foreach($user->languages as $language)                    

						  <span class="label label-warning">{{$language->name}}</span>            

						  @endforeach               

						 @endif              

						</p>              

						<hr>              

						<strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>              

						<p>                

						 @if(!$user->skills->isEmpty())                 

						  @foreach($user->skills as $skill)                    

						  <span class="label label-success">{{$skill->name}}</span>            

						  @endforeach               

						 @endif              

						</p>              

						<hr>              

						<strong><i class="fa fa-graduation-cap margin-r-5"></i> Qualifications</strong>              

						<p>                

						 @if(!$user->qualifications->isEmpty())                 

						  @foreach($user->qualifications as $qualification)                    

						  <span class="label label-primary">{{$qualification->name}}</span>            

						  @endforeach               

						 @endif              

						</p>              

						<hr>              

						            

					</div>            

					<!-- /.box-body -->          

				</div>          

				<!-- /.box -->        

			</div>        <!-- /.col -->        

			<div class="col-md-9">          

				<div class="nav-tabs-custom">            

					<ul class="nav nav-tabs edit-nav-styling">              

						<li id="basicDetailsTab" class="active"><a href="#tab_basicDetailsTab" data-toggle="tab">Basic Details</a></li>             

						<li id="profileDetailsTab"><a href="#tab_profileDetailsTab" data-toggle="tab">Project Details</a></li>



						<li id="documentDetailsTab"><a href="#tab_documentDetailsTab" data-toggle="tab">Document Details</a></li>              

						<li id="accountDetailsTab"><a href="#tab_accountDetailsTab" data-toggle="tab">HR Details</a></li>              



						<li id="addressDetailsTab"><a href="#tab_addressDetailsTab" data-toggle="tab">Contact Details</a></li> 



						<li id="referenceDetailsTab"><a href="#tab_referenceDetailsTab" data-toggle="tab">Reference Details</a></li> 

						<li id="kraDetailsTab"><a href="#tab_kraDetailsTab" data-toggle="tab">KRA</a></li>           

					</ul>            

					<div class="tab-content">              

						<div class="active tab-pane" id="tab_basicDetailsTab">                                          

							<div class="box-body no-padding">                        

								<table class="table table-striped table-bordered">                          

									<tr>                            

										<th style="width: 30%">Field</th>                            

										<th style="width: 70%">Value</th>

									</tr>                                                    

									<tr><td><em>Employee Name</em></td>                            

										<td>{{@$user->employee->fullname}}</td>                          

									</tr>

									<tr><td><em>Father's Name</em></td>

										<td>{{@$user->employee->father_name}}</td>

									</tr>                          

									<tr><td><em>Mother's Name</em></td>

										<td>{{@$user->employee->mother_name}}</td>

									</tr>

									<tr>

										<td><em>Employee Xeam Code</em></td>

										<td>{{@$user->employee_code}}

										</td>

									</tr>                          

									<tr>

										<td><em>Email</em></td>

										<td>{{@$user->email}}</td>

									</tr>                          

									<tr>                            

										<td><em>Personal Email</em></td>  

										<td>{{@$user->employee->personal_email}}</td>                          

									</tr>  

									<tr>                            
										<td><em>Attendance Type</em></td>  
										<td>{{@$user->employee->attendance_type}}</td>                
									</tr>                         

									<tr>                            

										<td><em>Mobile Number</em></td>

										<td>{{@$user->employee->mobile_number}}</td>                          

									</tr>                          

									<tr>                            

										<td><em>Alternative Mobile Number</em></td>  

										<td>{{@$user->employee->alternative_mobile_number}}</td>

									</tr> 

									<tr>

										<td><em>Referral Code</em></td>

										<td>{{@$user->employee->referral_code}}</td>                        

									</tr>                          

									<tr>                            

										<td><em>Marital Status</em></td>

										<td>{{@$user->employee->marital_status}}</td>

									</tr>



							        @if(@$user->employee->marital_status != "Unmarried")                          

									<tr>                            

										<td><em>Spouse Name</em></td> 

										<td>{{@$user->employee->spouse_name}}</td>                          

									</tr>                          

									<tr>   

										<td><em>Marriage Date</em></td>  

										<td> 

											@if(!empty(@$user->employee->marriage_date) && @$user->employee->marriage_date != '0000-00-00' )                                

												{{date("d/m/Y",strtotime(@$user->employee->marriage_date))}}

											@else                              

												{{"None"}}                            

											@endif                              

										</td>                          

									</tr>                              

									@if(@$data['basic']->marital_status == "Married") 

									<tr>                                    

										<td><em>Spouse Working Status</em></td>

										<td>@if(@$user->employee->spouse_working_status == "No")                                      {{"Non-Working"}}                                      	@else                                      			{{"Working"}}                                      		

										@endif                                    

										</td>                        

									</tr>                              

									@endif                         

								@endif                          



								@if(@$user->employee->spouse_working_status == "Yes")

									<tr>                              

										<td><em>Spouse Company Name</em></td>                              

										<td>{{@$user->employee->spouse_company_name}}</td>                            

									</tr>                            

									<tr>                              

										<td><em>Spouse Designation</em></td>                              

										<td>{{@$user->employee->spouse_designation}}</td>                            

									</tr>                            

									<tr>                              

										<td><em>Spouse Contact Number</em></td>                              

										<td>{{@$user->employee->spouse_contact_number}}</td> 

									</tr>                          

								@endif                          

								<tr>                            

									<td><em>Birth Date</em></td>                            

									<td>

										@if(!empty(@$user->employee->birth_date) && @$user->employee->birth_date != '0000-00-00' )                                

											{{date("d/m/Y",strtotime(@$user->employee->birth_date))}}

										@else                              

											{{"None"}}                            

										@endif

									</td>

								</tr>

								<tr>                            

									<td><em>Joining Date</em></td>                            

									<td>

										@if(!empty(@$user->employee->joining_date) && @$user->employee->joining_date != '0000-00-00' )                                

											{{date("d/m/Y",strtotime(@$user->employee->joining_date))}}

										@else                              

											{{"None"}}                            

										@endif

									</td>

								</tr>                          

								<tr>                            

									<td><em>Gender</em></td>                            

									<td>{{@$user->employee->gender}}</td>                          

								</tr>                          

								<tr>                            

									<td><em>Experience(Years-Months)</em></td>

									<td>{{@$user->employee->experience_year_month}}</td>

								</tr>                                                   

								<tr>                            

									<td><em>Nominee Type</em></td>                            

									<td>{{@$user->employee->nominee_type}}</td>

								</tr>                          

							@if(@$user->employee->nominee_type != "NA")                           

							 	<tr>                            

							 		<td><em>Nominee Name</em></td>                            

							 		<td>{{@$user->employee->nominee_name}}</td>

							 	</tr>                          

							 	<tr>                            

							 		<td><em>Relation</em></td>                            

							 		<td>{{@$user->employee->relation}}</td>

							 	</tr>                          

							@endif                            



							@if(@$user->employee->nominee_type == "Insurance")                              

							<tr>                                

								<td><em>Insurance Company Name</em></td>                                

								<td>{{@$user->employee->insurance_company_name}}</td>                              

							</tr>                              

							<tr>                                

								<td><em>Premium & Cover Amount</em></td>

								<td>{{@$user->employee->cover_amount}}</td>

							</tr>                              

							<tr>                                

								<td><em>Type Of Insurance</em></td>                                

								<td>{{@$user->employee->type_of_insurance}}</td>

							</tr>                              

							<tr>                                

								<td><em>Insurance Expiry Date</em></td>                                

								<td>

									@if(!empty(@$user->employee->insurance_expiry_date) && @$user->employee->insurance_expiry_date != '0000-00-00' )                                

										{{date("d/m/Y",strtotime(@$user->employee->insurance_expiry_date))}}

									@else                              

										{{"None"}}                            

									@endif                                  

								</td>                              

							</tr>                          

							@endif                          

							<tr>                            

								<td><em>Registration Fees</em></td>                            

								<td>{{@$user->employee->registration_fees}}</td>                          

							</tr>                          

							<tr>                            

								<td><em>Application Number</em></td>                            

								<td>{{@$user->employee->application_number}}</td>

							</tr>                                                  

						</table>                      

					</div>                                    

				</div>              

				<!-- /.tab-pane -->              

				<div class="tab-pane" id="tab_profileDetailsTab">                

					<div class="box-body no-padding">                        

						<table class="table table-striped table-bordered">                          

							<tr>                            

								<th style="width: 30%">Field</th>                            

								<th style="width: 70%">Value</th>

							</tr>                                                    

							<tr>                            

								<td><em>Department</em></td>                            

								<td>{{@$user->employeeProfile->department->name}}</td>                          

							</tr>                          

							<tr>                            

								<td><em>Role</em></td>                            

								<td>
								@if(@$user->roles[0]->name != 'MD')
									{{@$user->roles[0]->name}}
								@else
									Managing Director
								@endif		
								</td>                          

							</tr>                          

							<tr>                            

								<td><em>Permissions</em></td>                            

								<td>

							@if(!$user->permissions->isEmpty())                             

								@foreach($user->permissions as $key => $permission)                                  

									<span class="label label-info">{{$permission->name}}</span>

								@endforeach                              

							@endif                            

								</td>                          

							</tr>                          

							<tr>                            

								<td><em>Perks</em></td>                            

								<td>                              @if(!$user->perks->isEmpty())                             

								@foreach($user->perks as $key => $perk)                                  

									<span class="label label-info bg-maroon">{{$perk->name}}</span>

									@endforeach                              

								@endif                            

								</td>                          

							</tr>                          

							<tr>                            

								<td><em>Location</em></td>

								<td></td>                          

							</tr>                          

							<tr>                            

								<td><em>Projects</em></td>                            

								<td>

								@if(!$user->projects->isEmpty())                             

									@foreach($user->projects as $key => $project)                                  

										<span class="label label-default">{{$project->name}}</span>

									@endforeach                              

								@endif

								</td>

							</tr>                          

							<tr>                            

								<td><em>Sanction Officer 1</em></td>                            

								<td>

									{{@$user->userManager->manager->employee->fullname}}                            

		                       </td>                          

		                   </tr> 



		                   @if(!@$user->leaveAuthorities->isEmpty())

		                   	@foreach($user->leaveAuthorities as $authority)

	                   		<tr>                            

								<td><em>Sanction Officer {{$authority->priority}}</em></td>                      

								<td>

									{{@$authority->manager->employee->fullname}}                            

		                        </td>                          

	                   		</tr>

		                   	@endforeach

		                   @endif      



		                   <tr>                            

		                   	<td><em>Shift Timing</em></td>                            

		                   	<td>{{@$user->employeeProfile->shift->name}}</td>                          

		                   </tr>                          

		                   

		                   <tr>                            

		                   	<td><em>Probation Period</em></td>                            

		                   	<td>{{@$user->employeeProfile->probationPeriod->name}}</td>

		               	   </tr>                          

		                

		                <tr>                            

		               	<td><em>Probation End Date</em></td>                            

		               	<td>                            

		               	@if(!empty(@$user->employeeProfile->probation_period_id))                         

						   @php
						    $probation_period = $user->employeeProfile->probationPeriod;

							$end_date = Carbon\Carbon::parse($user->employee->joining_date)->addDays($probation_period->no_of_days)->toDateString();
						   @endphp                         
		               		{{date("d/m/Y",strtotime($end_date))}}                              
		               		@if(strtotime(date("Y-m-d")) > strtotime($end_date))&nbsp;<span class="label label-success">{{"Completed"}}</span>                              
		               		@else&nbsp;
		               			<span class="label label-danger">{{"Not Completed"}}</span>
		               		@endif



		               	@else

		               		{{"Not Specified"}}

		               	@endif                              

		               		</td>                          

		               	</tr>                          

		               	<tr>                            

		               		<td><em>Probation Status</em></td>                            

		               		<td>                            

		               			@if(@$user->employeeProfile->probation_approval_status == '1')                                

		               				{{"Approved"}}                            

		               			@else

		               				{{"Not Approved"}}

		               			@endif            

		               		</td>                         

		                </tr>                                                                            

		           </table>                      

		       </div>              

		   </div>              <!-- /.tab-pane -->              

		   <div class="tab-pane" id="tab_documentDetailsTab">                

		   	<div class="box-body no-padding">                        

		   		<table class="table table-striped table-bordered">                          

		   			<tr>                            

		   				<th style="width: 10%">#</th>                            

		   				<th style="width: 30%">Type</th>                            

		   				<th style="width: 30%">Uploaded</th>                            

		   				<th style="width: 30%">File</th>                          

		   			</tr>                            

		   			    @foreach($documents as $document)

		   			        <tr>  

		   			        	<td>{{$loop->iteration}}</td>                              

		   			        	<td><em>{{$document->document_name}}</em></td>                              

		   			        	<td>

		   			        		@if(empty($document->name))                                  

		   			        		<span class="badge bg-red">No</span>                                

		   			        		@else

		   			        		<span class="badge bg-green">Yes</span>                                @endif                              

		   			        	</td>                              

		   			        	<td>                                

		   			        		@if(!empty($document->name))                                  

		   			        		<span><a target="_blank" href="{{config('constants.uploadPaths.document').$document->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></span>@endif                              

		   			        	</td>                            

		   			        	</tr>                            

		   			        @endforeach                                                  

		   			    </table>                      

		   			</div>              

		   		</div>              <!-- /.tab-pane -->              

		   		<div class="tab-pane" id="tab_addressDetailsTab">                

		   			<div class="box-body no-padding">                        

		   				<table class="table table-striped table-bordered">                          

		   					<tr>                            

		   						<th style="width: 30%">Present Address :-</th>                            

		   						<th style="width: 70%"></th>                          

		   					</tr>                                                    

		   					<tr>                            

		   						<td><em>House Number</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->house_number}}</td>

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Road/Street</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->road_street}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Locality/Area</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->locality_area}}</td>

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Pincode</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->pincode}}</td>                          

		   					</tr> 

		   					<tr>                            

		   						<td><em>Emergency Number</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->emergency_number}}</td>                          

		   					</tr>                         

		   					<tr>                            

		   						<td><em>Country</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->country->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>State</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->state->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>City</em></td>                            

		   						<td>{{@$user->employeeAddresses[0]->city->name}}</td>                         

		   					</tr>                                                  

		   				</table>                      

		   			</div>                      

		   			<br>                      

		   			<div class="box-body no-padding">                        

		   				<table class="table table-striped table-bordered">                          

		   					<tr>                            

		   						<th style="width: 30%">Permanent Address :-</th>                            

		   						<th style="width: 70%"></th>                          

		   					</tr>                                                    

		   					<tr>                            

		   						<td><em>House Number</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->house_number}}</td>

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Road/Street</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->road_street}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Locality/Area</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->locality_area}}</td>

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Pincode</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->pincode}}</td>                          

		   					</tr> 

		   					<tr>                            

		   						<td><em>Emergency Number</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->emergency_number}}</td>                          

		   					</tr>                         

		   					<tr>                            

		   						<td><em>Country</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->country->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>State</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->state->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>City</em></td>                            

		   						<td>{{@$user->employeeAddresses[1]->city->name}}</td>                         

		   					</tr>                                                  

		   				</table>                      

		   			</div>              

		   		</div>              <!-- /.tab-pane -->              

		   		<div class="tab-pane" id="tab_accountDetailsTab">                

		   			<div class="box-body no-padding">                        

		   				<table class="table table-striped table-bordered">                          

		   					<tr>                            

		   						<th style="width: 30%">Field</th>                            

		   						<th style="width: 70%">Value</th>                          

		   					</tr>                                                    

		   					<tr>                            

		   						<td><em>Adhaar Number</em></td>                            

		   						<td>{{@$user->employeeAccount->adhaar}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>PAN Number</em></td>                            

		   						<td>{{@$user->employeeAccount->pan_number}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Employee ESI Number</em></td>                            

		   						<td>{{@$user->employeeAccount->esi_number}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Employee Dispensary</em></td>                            

		   						<td>{{@$user->employeeAccount->dispensary}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>PF Number for department file</em></td>                            

		   						<td>{{@$user->employeeAccount->pf_number_department}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>UAN Number</em></td>                            

		   						<td>{{@$user->employeeAccount->uan_number}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Bank Name</em></td>                            

		   						<td>{{@$user->employeeAccount->bank->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Account Holder Name</em></td>                            

		   						<td>{{@$user->employeeAccount->account_holder_name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Bank Account Number</em></td>                            

		   						<td>{{@$user->employeeAccount->bank_account_number}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>IFSC Code</em></td>                            

		   						<td>{{@$user->employeeAccount->ifsc_code}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Contract Signed</em></td>                            

		   						<td>

		   						@if(@$user->employeeAccount->contract_signed == '1')                              	

		   							{{"Yes"}} 

		   						@else                              

		   							{{"No"}}                              

		   						@endif                            

		   						</td>                          

		   					</tr>                          

		   					@if(@$user->employeeAccount->contract_signed == '1')                            

		   					<tr>                              

		   						<td><em>Contract Signed Date</em></td>                              

		   						<td>{{date("d/m/Y",strtotime(@$user->employeeAccount->contract_signed_date))}}</td>                            

		   					</tr>                          

		   					@endif 

		   					<tr>                            

		   						<td><em>Employment Verification</em></td>                            

		   						<td>

		   						@if(@$user->employeeAccount->employment_verification == '1')                              	

		   							{{"Yes"}} 

		   						@else                              

		   							{{"No"}}                              

		   						@endif

		   						</td>                          

		   					</tr>  

		   					<tr>                            

		   						<td><em>Address Verification</em></td>                            

		   						<td>

		   						@if(@$user->employeeAccount->address_verification == '1')                              	

		   							{{"Yes"}} 

		   						@else                              

		   							{{"No"}}                              

		   						@endif

		   						</td>                          

		   					</tr> 

		   					<tr>                            

		   						<td><em>Police Verification</em></td>                            

		   						<td>

		   						@if(@$user->employeeAccount->police_verification == '1')                              	

		   							{{"Yes"}} 

		   						@else                              

		   							{{"No"}}                              

		   						@endif

		   						</td>                          

		   					</tr>                                              

		   				</table>                      

		   			</div>              

		   		</div>              <!-- /.tab-pane -->              

		   		<div class="tab-pane" id="tab_referenceDetailsTab">                

		   			<div class="box-body no-padding">                        

		   				<table class="table table-striped table-bordered">                          

		   					<tr>                            

		   						<th style="width: 30%">Reference 1 :-</th>                            

		   						<th style="width: 70%"></th>                          

		   					</tr>                                                    

		   					<tr>                            

		   						<td><em>Name</em></td>                            

		   						<td>{{@$user->employeeReferences[0]->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Address</em></td>                            

		   						<td>{{@$user->employeeReferences[0]->address}}</td>                          

		   					</tr>                         

		   					 <tr>                            

		   					 	<td><em>Phone Number</em></td>                            

		   					 	<td>{{@$user->employeeReferences[0]->phone}}</td>                          

		   					 </tr>                          

		   					 <tr>                            

		   					 	<td><em>Email</em></td>                            

		   					 	<td>{{@$user->employeeReferences[0]->email}}</td>                          

		   					 </tr>                                                  

		   				</table>                  

		   			</div>                  

		   			<br>                  

		   			<div class="box-body no-padding">                        

		   				<table class="table table-striped table-bordered">                          

		   					<tr>                            

		   						<th style="width: 30%">Reference 2 :-</th>                            

		   						<th style="width: 70%"></th>                          

		   					</tr>                                                    

		   					<tr>                            

		   						<td><em>Name</em></td>                            

		   						<td>{{@$user->employeeReferences[1]->name}}</td>                          

		   					</tr>                          

		   					<tr>                            

		   						<td><em>Address</em></td>                            

		   						<td>{{@$user->employeeReferences[1]->address}}</td>                          

		   					</tr>                         

		   					 <tr>                            

		   					 	<td><em>Phone Number</em></td>                            

		   					 	<td>{{@$user->employeeReferences[1]->phone}}</td>                          

		   					 </tr>                          

		   					 <tr>                            

		   					 	<td><em>Email</em></td>                            

		   					 	<td>{{@$user->employeeReferences[1]->email}}</td>                          

		   					 </tr>                                                  

		   				</table>                  

		   			</div>              

		   		</div>              <!-- /.tab-pane -->   


		   		 	<!--kra tab stsrts here-->
		   	<div class="tab-pane" id="tab_kraDetailsTab">                
		   			<div class="box-body no-padding">
		   				<div class="row">
		   					<div class="col-md-6">
			   			        <div class="input-group d_o_r">
					                <div class="input-group-btn">
					                  <button type="button" class="btn btn-info">KRA Template:</button>
					                </div>
					                <!-- /btn-group -->
					               <input type="text" class="form-control" placeholder="@if($emp_kra_template!=""){{$emp_kra_template->name}} @endif" disabled>
				              	</div>
		   					</div>
		   					<div class="col-md-6">
				            </div>
		   				</div>
		   				<h2 style="font-size: 20px;">KRA Indicators:</h2>

		   				<table class="table table-striped table-bordered">                    
		   					   <tr>
		   					   	<th>Sr. No.</th>
		   					   	<th>KRA Indicator Name</th>
		   					   	<th>Frequency</th>
		   					   	<th>Deadline</th>
		   					   	<th>Activation date</th>
		   					   	<th>Priority</th>
		   					   </tr>                      
		   					  
		   					   	@foreach($user->EmployeeKra as $emp_kra)
		   					   	 <tr>
	   								<td>{{$loop->iteration}}</td>
	   								<td>{{@$emp_kra->name}}</td>
	   								<td>{{@$emp_kra->frequency}}</td>
	   								<td>{{@$emp_kra->deadline_date}}</td>
	   								<td>{{@$emp_kra->activation_date}}</td>
	   								<td>{{@$emp_kra->priority}}</td>
	   							</tr>	
		   						@endforeach	   					   
		   					                                                
		   				</table>                  
		   			</div>                  
		   			<br>                  
		   		             
		   		</div>
		   	<!--kra tab ended here-->         

		   	</div>            <!-- /.tab-content -->          

		   </div>          <!-- /.nav-tabs-custom -->        

		</div>        <!-- /.col -->      

	</div>      <!-- /.row -->    

</section>    <!-- /.content -->    

<div class="modal fade" id="changeProfilePictureModal">        

	<div class="modal-dialog">          

		<div class="modal-content">            

			<div class="modal-header">              

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">                

					<span aria-hidden="true">&times;</span></button>              

					<h4 class="modal-title">Change Profile Picture</h4>            

			</div>            

			<div class="modal-body">              

				<form id="profilePictureForm" action="{{ url('employees/profile-picture') }}" method="POST" enctype="multipart/form-data">

					{{ csrf_field() }}                  

					<div class="box-body">                                        

						<div class="form-group">                      

							<label for="profilePic" class="">Select Picture</label>                      

							<input type="file" class="form-control" id="profilePic" name="profilePic">                    

						</div>                                                   

					</div>                  <!-- /.box-body -->                  

					<br>                  

					<div class="box-footer">                    

						<button type="submit" class="btn btn-primary" id="profilePictureFormSubmit">Submit</button>                  

					</div>            

				</form>            

			</div>                      

		</div>          <!-- /.modal-content -->        

	</div>      <!-- /.modal-dialog -->      

</div>        <!-- /.modal -->  

</div>  <!-- /.content-wrapper -->  

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

