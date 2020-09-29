@extends('admins.layouts.app')

@section('content')

<style>
.radio { margin: 6px 0 0 0; }
.radio label input { position: relative; top: -2px; }
.important-links a {  }
</style>

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">

  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1>Insurance Approval Form</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Content Header Ends here -->
  
  <!-- Main content Starts here -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">

          <!-- Form Starts here -->
           @php
			if(isset($data['insurance_values']) AND ($data['insurance_values']!="")){
				if(isset($data['insurance_values']['tender_name']) AND ($data['insurance_values']['tender_name']!="")){
					$tender_name = $data['insurance_values']['tender_name'];
				}else{
					$tender_name ="";
				}
				
				if(isset($data['insurance_values']['insurance_type']) AND ($data['insurance_values']['insurance_type']!="")){
					$insurance_type = $data['insurance_values']['insurance_type'];
				}else{
					$insurance_type ="";
				}
				
				if(isset($data['insurance_values']['insurance_text']) AND ($data['insurance_values']['insurance_text']!="")){
					$insurance_text = $data['insurance_values']['insurance_text'];
				}else{
					$insurance_text ="";
				}
				
				if(isset($data['insurance_values']['insurance_plan']) AND ($data['insurance_values']['insurance_plan']!="")){
					$insurance_plan = $data['insurance_values']['insurance_plan'];
				}else{
					$insurance_plan ="";
				}
				
				if(isset($data['insurance_values']['total_premium_amount']) AND ($data['insurance_values']['total_premium_amount']!="")){
					$total_premium_amount = $data['insurance_values']['total_premium_amount'];
				}else{
					$total_premium_amount ="";
				}
				
				if(isset($data['insurance_values']['in_favour_of']) AND ($data['insurance_values']['in_favour_of']!="")){
					$in_favour_of = $data['insurance_values']['in_favour_of'];
				}else{
					$in_favour_of ="";
				}
				
				if(isset($data['insurance_values']['required_date']) AND ($data['insurance_values']['required_date']!="")){
					$required_date = $data['insurance_values']['required_date'];
				}else{
					$required_date ="";
				}
				
				if(isset($data['insurance_values']['number_of_peers_or_lives']) AND ($data['insurance_values']['number_of_peers_or_lives']!="")){
					$number_of_peers_or_lives = $data['insurance_values']['number_of_peers_or_lives'];
				}else{
					$number_of_peers_or_lives ="";
				}
				
				if(isset($data['insurance_values']['extra_note']) AND ($data['insurance_values']['extra_note']!="")){
					$extra_note = $data['insurance_values']['extra_note'];
				}else{
					$extra_note ="";
				}
				
				if(isset($data['insurance_values']['expense_borne']) AND ($data['insurance_values']['expense_borne']!="")){
					$expense_borne = $data['insurance_values']['expense_borne'];
				}else{
					$expense_borne ="";
				}
				
				if(isset($data['insurance_values']['project_margin_percentage']) AND ($data['insurance_values']['project_margin_percentage']!="")){
					$project_margin_percentage = $data['insurance_values']['project_margin_percentage'];
				}else{
					$project_margin_percentage ="";
				}
				
				if(isset($data['insurance_values']['project_margin_amount']) AND ($data['insurance_values']['project_margin_amount']!="")){
					$project_margin_amount = $data['insurance_values']['project_margin_amount'];
				}else{
					$project_margin_amount ="";
				}
				
				if(isset($data['insurance_values']['project_tenure_year']) AND ($data['insurance_values']['project_tenure_year']!="")){
					$project_tenure_year = $data['insurance_values']['project_tenure_year'];
				}else{
					$project_tenure_year ="";
				}
				
				if(isset($data['insurance_values']['project_tenure_month']) AND ($data['insurance_values']['project_tenure_month']!="")){
					$project_tenure_month = $data['insurance_values']['project_tenure_month'];
				}else{
					$project_tenure_month ="";
				}
				
				if(isset($data['insurance_values']['invoice_number']) AND ($data['insurance_values']['invoice_number']!="")){
					$invoice_number = $data['insurance_values']['invoice_number'];
				}else{
					$invoice_number ="";
				}
				
				if(isset($data['insurance_values']['person']) AND ($data['insurance_values']['person']!="")){
					$i=1;
					foreach($data['insurance_values']['person'] as $ins_per_value){
						$person[$i] = $ins_per_value;
						$i++;
					}
					
				}else{
					$person[] ="";
				}
				if(isset($data['insurance_values']['amount']) AND ($data['insurance_values']['amount']!="")){
					
					$i=1;
					foreach($data['insurance_values']['amount'] as $ins_amt_value){
						$amount[$i] = $ins_amt_value;
						$i++;
					}
				}else{
					$amount[] ="";
				}
				if(isset($data['insurance_values']['remark']) AND ($data['insurance_values']['remark']!="")){
					
					$i=1;
					foreach($data['insurance_values']['remark'] as $ins_rem_value){
						$remark[$i] = $ins_rem_value;
						$i++;
					}
				}else{
					$remark[] ="";
				}
				
				
			}else{
				$tender_name ="";
				$insurance_type ="";
				$insurance_text ="";
				$insurance_plan ="";
				$total_premium_amount ="";
				$in_favour_of ="";
				$required_date ="";
				$number_of_peers_or_lives ="";
				$extra_note ="";
				$expense_borne ="";
				$project_margin_percentage ="";
				$project_margin_amount ="";
				$project_tenure_year ="";
				$project_tenure_month ="";
				$invoice_number ="";
				$person[1] ="";
				$person[2]="";
				$person[3] ="";
				$amount[1] ="";
				$amount[2] ="";
				$amount[3] ="";
				$remark[1] ="";
				$remark[2] ="";
				$remark[3] ="";
				
			}
		  @endphp
		  <form id="insurance_approval" action="{{ url('mastertables/save-project') }}" method="POST" enctype="multipart/form-data">		  
		   {{ csrf_field() }}
            <div class="box-body jrf-form-body">
              <!-- Row starts here -->
              <div class="row">
                <!-- Left column starts here -->
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="tender_name" class="apply-leave-label">Tender Name</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            						<input type="text" name="tender_name" id="tender_name" class="form-control input-sm basic-detail-input-style" value="{{$tender_name}}">
            							
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">Insurance Type</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-4 input-l">
                            <select name="insurance_type" id="" class="form-control input-sm basic-detail-input-style">
                              <option value="" selected disabled>Select Type</option>
                              <option value="GHI" @if($insurance_type == "GHI"){{'selected'}} @endif>GHI</option>
                              <option value="GPA" @if($insurance_type == "GPA"){{'selected'}} @endif>GPA</option>
                            </select>
                          </div>
                          <div class="col-xs-8 input-r">
                            <input type="text" name="insurance_text" id="insurance_text" class="form-control input-sm basic-detail-input-style" placeholder="Enter text" value="{{$insurance_text}}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="insurance_plan" class="apply-leave-label">Insurance Plan</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="text" class="form-control input-sm basic-detail-input-style" name="insurance_plan" id="insurance_plan" placeholder="Enter insurance Plan" value="{{$insurance_plan}}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="total_premium_amount" class="apply-leave-label">Total Premium Amount</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="number" name="total_premium_amount" id="total_premium_amount" class="form-control input-sm basic-detail-input-style" placeholder="Enter Amount" value="{{$total_premium_amount}}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="in_favour_of" class="apply-leave-label">In favor of</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="text" class="form-control input-sm basic-detail-input-style" name="in_favour_of" id="in_favour_of" placeholder="Enter favor of" value="{{$in_favour_of}}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="required_date" class="apply-leave-label">Date when required</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="text" class="form-control input-sm basic-detail-input-style datepicker" name="required_date" id="required_date" placeholder="06/05/2020" value="{{$required_date}}">
                      </div>
                    </div>
                  </div>

                </div>
                <!-- Left column Ends here -->

                <!-- Right column Starts here -->
                <div class="col-md-6">

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">No. of Peers/Lives</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-6 input-l">
                            <input type="number" class="form-control input-sm basic-detail-input-style" name="number_of_peers_or_lives" id="number_of_peers_or_lives" placeholder="Enter peer/lives" value="{{$number_of_peers_or_lives}}">
                          </div>
                          <div class="col-xs-6 input-r">
                            <input type="text" name="extra_note" id="extra_note" class="form-control input-sm basic-detail-input-style" placeholder="Enter note" value="{{$extra_note}}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="expense_borne" class="apply-leave-label">Expense to be Borne By</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <select name="expense_borne" id="expense_borne" class="form-control input-sm basic-detail-input-style">
                          <option value="" selected disabled>Select Borne By</option>
                          <option value="self" @if($expense_borne == "self"){{'selected'}} @endif>Self</option>
                          <option value="client" @if($expense_borne == "client"){{'selected'}} @endif>Client</option>
                          
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="project_margin_percentage" class="apply-leave-label">Project Margin (%age)</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="number" name="project_margin_percentage" id="project_margin_percentage" class="form-control input-sm basic-detail-input-style" placeholder="Enter Number here" value="{{$project_margin_percentage}}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="project_margin_amount" class="apply-leave-label">Project Margin Amount</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="number" name="project_margin_amount" id="project_margin_amount" class="form-control input-sm basic-detail-input-style" placeholder="Enter Number here" value="{{$project_margin_amount}}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">Project Tenure</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-6 input-l">
                            <select name="project_tenure_year" id="project_tenure_year" class="form-control input-sm basic-detail-input-style">
                              <option value="" selected disabled>Select Year</option>
							@for($i=2018; $i<=2020; $i++)
								<option value="{{$i}}" @if($project_tenure_year == $i){{'selected'}} @endif>{{$i}}</option>
							@endfor
                              
                            </select>
                          </div>
                          <div class="col-xs-6 input-r">
                            <select name="project_tenure_month" id="project_tenure_month" class="form-control input-sm basic-detail-input-style">
                              <option value="" selected disabled>Select Month</option>
              							  @for($i=1;$i<=12;$i++)
              								<option value="{{$i}}" @if($project_tenure_month == $i){{'selected'}} @endif>{{$i}}</option>
              							@endfor
                             
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">

					  <label for="invoice_number">Invoice no.<br>(if borne by Client)</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <input type="number" name="invoice_number" id="invoice_number" class="form-control input-sm basic-detail-input-style" placeholder="Enter Number here" value="{{$invoice_number}}">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Right column Ends here -->
              </div>
              <!-- Row Ends here -->
              <hr>

              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <table class="table table-bordered table-striped">
                    <tr>
                      <th></th>
                      <th>Person Name</th>
                      <th>Amount</th>
                      <th>Remarks</th>
                    </tr>
					
						
					<tr>
                      <th>Quote 1</th>
                      <td>
                        <input type="text" name="person[1]" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Person Name" value="{{@$person[1]}}">
                      </td>
                      <td>
                        <input type="number" name="amount[1]" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Amount" value="{{@$amount[1]}}">
                      </td>
                      <td>
                        <textarea name="remark[1]" id="" rows="2" style="width: 100%;">{{@$remark[1]}}</textarea>
                      </td>
                    </tr>
					
					     <tr>
                      <th>Quote 2</th>
                      <td>
                        <input type="text" name="person[2]" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Person Name" value="{{@$person[2]}}">
                      </td>
                      <td>
                        <input type="number" name="amount[2]" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Amount" value="{{@$amount[2]}}">
                      </td>
                      <td>
                        <textarea name="remark[2]" id="" rows="2" style="width: 100%;">{{@$remark[2]}}</textarea>
                      </td>
                    </tr>
					
					<tr>
                      <th>Quote 3</th>
                      <td>
                        <input type="text" name="person[3]" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Person Name" value="{{@$person[3]}}">
                      </td>
                      <td>
                        <input type="number" name="amount[3]" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Amount" value="{{@$amount[3]}}">
                      </td>
                      <td>
                        <textarea name="remark[3]" id="" rows="2" style="width: 100%;">{{@$remark[3]}}</textarea>
                        @php
                            if(request('project_id')){
                              $project_id = @request('project_id');
                          }else{
                              $project_id = "";
                          }            
                           
                          @endphp 

                        <input type="hidden" name="project_id" value="{{@$project_id}}">
                      </td>
                    </tr>
					                   
                    
                    
                  </table>
                </div>
              </div>

            </div>

            <div class="text-center">
              <input type="submit" class="btn btn-primary" id="submit" value="Submit" name="save_as_draft_insurance">
            </div>
			     <br>

          </form>
          <!-- Form Ends here -->


        </div>
      </div>
    </div>
  </section>
  <!-- Main content Ends Here-->

</div>
<!-- Content Wrapper Ends here -->

<!-- Script Source Files Starts here -->
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<!-- Script Source Files Ends here -->

<!-- Custom Script Starts here -->
<script>
  //Datepicker Starts here
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      orientation: "bottom",
      format: 'dd/mm/yyyy'
    });
  }); 
  //Datepicker Ends here

  //Validation Starts here
  $("#insurance_approval").validate({
    rules: {
      "tender_name" : {
        required: true
      },
      "insurance_type" : {
        required: true
      },
       "insurance_text" : {
        required: true
      },
      "insurance_plan" : {
        required: true
      },
      "total_premium_amount" : {
        required: true
      },
      "in_favour_of" : {
        required: true
      },
      "required_date" : {
        required: true
      },
      "number_of_peers_or_lives" : {
        required: true
      },
      "extra_note" : {
        required: true
      },
      "expense_borne" : {
        required: true
      },
      "project_margin_percentage" : {
        required: true
      },
      "project_margin_amount" : {
        required: true
      },
      "project_tenure_year" : {
        required: true
      },
      "project_tenure_month" : {
        required: true
      },
      "invoice_number" : {
        required: true
      },
      "person[1]" : {
        required: true
      },
      "amount[1]" : {
        required: true
      },
      "remark[1]" : {
        required: true
      },
      "person[2]" : {
        required: true
      },
      "amount[2]" : {
        required: true
      },
      "remark[2]" : {
        required: true
      },
      "person[3]" : {
        required: true
      },
      "amount[3]" : {
        required: true
      },
      "remark[3]" : {
        required: true
      }
    },
    errorPlacement: function(error, element) {
    if (element.hasClass('select2')) {
     error.insertAfter(element.next('span.select2'));
    } else {
     error.insertAfter(element);
    }
   },
    messages: {
      "tender_name" : {
        required: 'Please select tender'
      },
      "insurance_type" : {
        required: 'Please select'
      },
      "insurance_text" : {
        required: 'Please Enter insurance text'
      },
      "insurance_plan" : {
        required: 'Please select'
      },
      "total_premium_amount" : {
        required: 'Please enter amount'
      },
      "in_favour_of" : {
        required: 'Please enter in favor of'
      },
      "required_date" : {
        required: 'Please select date'
      },
      "number_of_peers_or_lives" : {
        required: 'Enter No. of peers/lives'
      },
       "extra_note" : {
        required: 'Enter extra note'
      },
      "expense_borne" : {
        required: 'Please Enter Margin'
      },
      "project_margin_percentage" : {
        required: 'Enter Percentage'
      },
      "project_margin_amount" : {
        required: 'Enter Amount'
      },
      "project_tenure_year" : {
        required: 'Please Enter Margin'
      },
      "project_tenure_month" : {
        required: 'Please Enter Bg Charges'
      },
      "invoice_number" : {
        required: 'Enter Invoice Number'
      },
       "person[1]" : {
        required: 'Enter person name'
      },
       "amount[1]" : {
        required: 'Enter amount'
      },
       "remark[1]" : {
        required: 'Enter remark'
      },
       "person[2]" : {
        required: 'Enter person name'
      },
       "amount[2]" : {
        required: 'Enter amount'
      },
       "remark[2]" : {
        required: 'Enter remark'
      },
       "person[3]" : {
        required: 'Enter person name'
      },
       "amount[3]" : {
        required: 'Enter amount'
      },
       "remark[3]" : {
        required: 'Enter remark'
      }
    }
  });
  //Validation Ends here

</script>
<!-- Custom Script Ends here -->

@endsection
  
