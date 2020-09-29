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
    <h1>Bank Guarantee Approval Form</h1>
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
          @include('admins.validation_errors')

          <!-- Form Starts here -->
		  @php
			
			if(isset($data['bg_values']) AND ($data['bg_values']!="")){
				if(isset($data['bg_values']['tender_name']) AND ($data['bg_values']['tender_name']!="")){
					$tender_name = $data['bg_values']['tender_name'];
				}else{
					$tender_name ="";
				}
				
				if(isset($data['bg_values']['form_type']) AND ($data['bg_values']['form_type']!="")){
					$form_type = $data['bg_values']['form_type'];
				}else{
					$form_type ="";
				}
				
				if(isset($data['bg_values']['amount']) AND ($data['bg_values']['amount']!="")){
					$amount = $data['bg_values']['amount'];
				}else{
					$amount ="";
				}
				
				if(isset($data['bg_values']['in_favour_of']) AND ($data['bg_values']['in_favour_of']!="")){
					$in_favour_of = $data['bg_values']['in_favour_of'];
				}else{
					$in_favour_of ="";
				}
				
				if(isset($data['bg_values']['required_date']) AND ($data['bg_values']['required_date']!="")){
					$required_date = $data['bg_values']['required_date'];
				}else{
					$required_date ="";
				}
				
				if(isset($data['bg_values']['validity_date']) AND ($data['bg_values']['validity_date']!="")){
					$validity_date = $data['bg_values']['validity_date'];
				}else{
					$validity_date ="";
				}
				
				if(isset($data['bg_values']['margin_value']) AND ($data['bg_values']['margin_value']!="")){
					$margin_value = $data['bg_values']['margin_value'];
				}else{
					$margin_value ="";
				}
				
				if(isset($data['bg_values']['margin']) AND ($data['bg_values']['margin']!="")){
					$margin = $data['bg_values']['margin'];
				}else{
					$margin ="";
				}
				
				if(isset($data['bg_values']['bg_charges_value']) AND ($data['bg_values']['bg_charges_value']!="")){
					$bg_charges_value = $data['bg_values']['bg_charges_value'];
				}else{
					$bg_charges_value ="";
				}
				
				if(isset($data['bg_values']['bg_charges']) AND ($data['bg_values']['bg_charges']!="")){
					$bg_charges = $data['bg_values']['bg_charges'];
				}else{
					$bg_charges ="";
				}
				
				if(isset($data['bg_values']['gst_value']) AND ($data['bg_values']['gst_value']!="")){
					$gst_value = $data['bg_values']['gst_value'];
				}else{
					$gst_value ="";
				}
				
				if(isset($data['bg_values']['gst']) AND ($data['bg_values']['gst']!="")){
					$gst = $data['bg_values']['gst'];
				}else{
					$gst ="";
				}
				
				if(isset($data['bg_values']['total_charges']) AND ($data['bg_values']['total_charges']!="")){
					$total_charges = $data['bg_values']['total_charges'];
				}else{
					$total_charges ="";
				}
			}else{
				$tender_name = "";
				$form_type = "";
				$amount = "";
				$in_favour_of = "";
				$required_date = "";
				$validity_date = "";
				$margin_value = "";
				$margin = "";
				$bg_charges_value = "";
				$bg_charges = "";
				$gst_value = "";
				$gst = "";
				$total_charges = "";
				
			}
			
			//print_r($data['bg_values']);
			
		@endphp
          <form id="bg_approval" action="{{ url('mastertables/save-project') }}" method="POST" enctype="multipart/form-data">
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
                          <label for="form_type" class="apply-leave-label">Form</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
								<input type="text" name="form_type" id="form_type" class="form-control input-sm basic-detail-input-style" value="{{$form_type}}">
									
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="amount" class="apply-leave-label">Amount</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <input type="number" name="amount" id="amount" class="form-control input-sm basic-detail-input-style" placeholder="Enter Amount" value="{{$amount}}">
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

	                <div class="form-group">
	                    <div class="row">
	                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                          <label for="validity_date" class="apply-leave-label">Validity Date of BG</label>
	                        </div>
	                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
								            <input type="text" class="form-control input-sm basic-detail-input-style datepicker" name="validity_date" id="validity_date" placeholder="06/05/2020" value="{{$validity_date}}">
	                        </div>
	                    </div>
	                </div>
				  
                </div>
                <!-- Right column Ends here -->
              </div>
              <!-- Row Ends here -->
              <hr>

              <h4 class="text-center" style="text-decoration: underline;">For Accounts Department</h4>
              <div class="row">
              	<div class="col-md-8 col-md-offset-2">
              		<table class="table table-bordered table-striped">
              			<tr>
              				<td>
              					<input type="number" name="margin_value" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter margin (%)" value="{{$margin_value}}">
              				</td>
              				<th>Margin</th>
              				<td>
              					<input type="text" name="margin" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter margin" value="{{$margin}}">
              				</td>
              		


					</tr>
              			<tr>
              				<td>
              					<input type="number" name="bg_charges_value" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter Bg Charges (%)" value="{{$bg_charges_value}}">
              				</td>
              				<th>BG Charges</th>
              				<td>
              					<input type="text" name="bg_charges" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter BG Charges" value="{{$bg_charges}}">
              				</td>
              			</tr>
              			<tr>
              				<td>
              					<input type="number" name="gst_value" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter GST (%)" value="{{$gst_value}}">
              				</td>
              				<th>GST</th>
              				<td>
              					<input type="text" name="gst" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter GST" value="{{$gst}}">
              				</td>
              			</tr>
              			<tr>
              				<td>-</td>
              				<th>Total Charges</th>
                      @php
                          if(request('project_id')){
                            $project_id = @request('project_id');
                        }else{
                            $project_id = "";
                        }            
                         
                        @endphp
              				<td>
              					<input type="text" name="total_charges" id="" class="form-control input-sm basic-detail-input-style" placeholder="Total Charges" value="{{$total_charges}}">
                        <input type="hidden" name="project_id" value="{{@$project_id}}">
              				</td>
              			</tr>
              		</table>
              	</div>
              </div>

              <hr>

            </div>

            <div class="text-center">
              <input type="submit" class="btn btn-primary" id="submit" value="Submit" name="save_as_draft_bg">
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
  $("#bg_approval").validate({
    rules: {
      "tender_name" : {
        required: true
      },
      "form_type" : {
        required: true
      },
      "amount" : {
        required: true
      },
      "in_favour_of" : {
        required: true
      },
      "required_date" : {
        required: true
      },
      "validity_date" : {
        required: true
      },
      "margin_value" : {
        required: true
      },
      "margin" : {
        required: true
      },
      "bg_charges_value" : {
        required: true
      },
      "bg_charges" : {
        required: true
      },
      "gst_value" : {
        required: true
      },
      "gst" : {
        required: true
      },
      "total_charges" : {
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
      "form_type" : {
        required: 'Please select form'
      },
      "amount" : {
        required: 'Please enter amount'
      },
      "in_favour_of" : {
        required: 'Please enter in favor of'
      },
      "required_date" : {
        required: 'Please select date'
      },
      "validity_date" : {
        required: 'Please select date'
      },
      "margin_value" : {
        required: 'Please Enter Margin'
      },
      "margin" : {
        required: 'Please Enter Margin'
      },
      "bg_charges_value" : {
        required: 'Please Enter Bg Charges'
      },
      "bg_charges" : {
        required: 'Please Enter Bg Charges'
      },
      "gst_value" : {
        required: 'Please Enter GST Value'
      },
      "gst" : {
        required: 'Please Enter GST'
      },
       "total_charges" : {
        required: 'Please Enter Total charges'
      }
    }
  });
  //Validation Ends here

</script>
<!-- Custom Script Ends here -->

@endsection
  
