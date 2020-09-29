@extends('admins.layouts.app')

@section('content')

<style>
#document_form_3_table tr th, #document_form_3_table tr td { vertical-align: middle;}
h2 { font-size: 18px; margin-top: 0; }
ul { padding-left: 20px; }
h3.table-heading { font-size: 15px; font-weight: 600; text-decoration: underline;}
</style>

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">

   @if(session()->has('prebidSaveSuccess'))

    <div class="alert alert-success alert-dismissible">

      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

      {{ session()->get('prebidSaveSuccess') }}

    </div>

  @endif

  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1>Prebid Form 1</h1>
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
         
            <!-- Box Body Starts here -->
            <div class="box-body">
        <h2><span class="label label-info">Standard Instruction for Pre-bid</span></h2>
        <ul>
          <li>Keep a print or soft copy of the RFP and Queries for the pre-bid for any refrences.</li>
          <li>Study all queries in details and refer to the RFP also.</li>
        </ul>
        
        <form id="document_form_3" name="prebidform" class="form-vertical" action="{{ url('leads-management/store-pre-bid') }}" method="POST" >
          @include('admins.validation_errors')
          {{ csrf_field() }}
          <h3 class="table-heading">Agency Participant Details</h3>
          <table class="table table-striped text-center table-bordered" id="table_participant">
            <thead class="table-heading-style">
              <tr>
                <th>S. No</th>
                <th>Person Name</th>
                <th>Contact Number</th>
                <th>Remarks</th>
                <th>Add / Remove</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                  <input type="text" class="form-control input-sm basic-detail-input-style participant_name" name="participant_name[]" id="" placeholder="Enter Name here">
                </td>
                <td>
                  <input type="number" class="form-control input-sm basic-detail-input-style" name="participant_contact[]" id="" placeholder="Enter contact here">
                </td>
                <td>
                  <input type="text" class="form-control input-sm basic-detail-input-style" name="participant_remark[]" id="" placeholder="Enter Reamrks here">
                </td>
                <td>
                  <a href="javascript:void(0)" id="add_participants">
                    <i class="fa fa-plus a_r_style a_r_style_green"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>

          <hr>

          <h3 class="table-heading">Members / Officials from Client side</h3>
          <table class="table table-striped text-center table-bordered" id="table_client">
            <thead class="table-heading-style">
              <tr>
                <th>S. No</th>
                <th>Person Name</th>
                <th>Contact Number</th>
                <th>Remarks</th>
                <th>Add / Remove</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                  <input type="text" class="form-control input-sm basic-detail-input-style" name="client_name[]" id="" placeholder="Enter Name here">
                </td>
                <td>
                  <input type="number" class="form-control input-sm basic-detail-input-style" name="client_contact[]" id="" placeholder="Enter Number here">
                </td>
                <td>
                  <input type="text" class="form-control input-sm basic-detail-input-style" name="client_remark[]" id="" placeholder="Enter Reamrks here">
                </td>
                <td>
                  <a href="javascript:void(0)" id="add_clients">
                              <i class="fa fa-plus a_r_style a_r_style_green"></i>
                            </a>
                </td>
              </tr>
            </tbody>
          </table>

          <hr>

          <h3 class="table-heading">Clause Details</h3>
          <table class="table table-striped text-center table-bordered" id="table_clause">
            <thead class="table-heading-style">
              <tr>
                <th>S. No</th>
                <th>Clause</th>
                <th>Clatification / Amendment requested</th>
                <th>Remarks</th>
                <th>Add / Remove</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                 <textarea name="clause_name[]" class="form-control input-sm basic-detail-input-style" placeholder="Enter clause here"></textarea>
                </td>
                <td>
                  
                   <textarea name="clause_clarification[]" class="form-control input-sm basic-detail-input-style" placeholder="Enter Clatification here"></textarea>
                </td>
                <td>
                 
                  <textarea name="clause_remark[]" class="form-control input-sm basic-detail-input-style" placeholder="Enter Reamrks here"></textarea>
                </td>
                <td>
                  <a href="javascript:void(0)" id="add_clause">
                    <i class="fa fa-plus a_r_style a_r_style_green"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>

        
            </div>
            <!-- Box Body Ends here -->
            <!-- Box Footer Starts here -->
            <div class="box-footer text-center">
                <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Save" name="submit">
            </div>
             <!-- Box Footer Ends here -->
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
  //Validation Starts here
$.validator.prototype.checkForm = function() {
    //overriden in a specific page
    this.prepareForm();
    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
        if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                this.check(this.findByName(elements[i].name)[cnt]);
            }
        } else {
            this.check(elements[i]);
        }
    }
    return this.valid();
};

  $("#document_form_3").validate({
    rules: {
      "participant_name[]" : {
        required: true
      },
      "participant_contact[]" : {
        required: true
      },
      "participant_remark[]" : {
        required: true
      },
      "clause_name[]" : {
        required: true
      },
      "clause_clarification[]" : {
        required: true
      },
      "clause_remark[]" : {
        required: true
      },
      "client_name[]" : {
        required: true
      },
      "client_contact[]" : {
        required: true
      },
      "client_remark[]" : {
        required: true
      }
    },
    errorPlacement: function(error, element) {
    if (element.hasClass('select2')) {
     error.insertAfter(element.next('span.select2'));
    }else {
     error.insertAfter(element);
    }
   },
    messages: {
      "participant_name[]" : {
        required: "Please enter participant name"
      },
      "participant_contact[]" : {
        required: "Please enter participant contact"
      },
      "participant_remark[]" : {
        required: "Please enter participant remark"
      },
      "clause_name[]" : {
        required: "Please enter clause name"
      },
      "clause_clarification[]" : {
        required: "Please enter clause clarification"
      },
      "clause_remark[]" : {
        required: "Please enter clause remark"
      },
      "client_name[]" : {
        required: "Please enter client name"
      },
      "client_contact[]" : {
        required: "Please enter client contact"
      },
      "client_remark[]" : {
        required: "Please enter client remark"
      }
    }
  });

  //Validation Ends here


  //Agency Participant Details Append code
  $("#add_participants").on('click', function(){
    $("#table_participant tbody").append('<tr><td>1</td><td><input type="text" class="form-control input-sm basic-detail-input-style participant_name" name="participant_name[]" id="" placeholder="Enter Name here" required></td><td><input type="number" class="form-control input-sm basic-detail-input-style" name="participant_contact[]" id="" placeholder="Enter Number here"></td><td><input type="text" class="form-control input-sm basic-detail-input-style" name="participant_remark[]" id="" placeholder="Enter Reamrks here"></td><td><a href="javascript:void(0)" id="" class="remove_participant"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td></tr>');

      $(".remove_participant").on('click', function(){
        $(this).closest("tr").remove();
      });
  });

  //Members / Officials from Client side append code
  $("#add_clients").on('click', function(){
    $("#table_client tbody").append('<tr><td>1</td><td><input type="text" class="form-control input-sm basic-detail-input-style" name="client_name[]" id="" placeholder="Enter Name here"></td><td><input type="number" class="form-control input-sm basic-detail-input-style" name="client_contact[]" id="" placeholder="Enter Number here"></td><td><input type="text" class="form-control input-sm basic-detail-input-style" name="client_remark[]" id="" placeholder="Enter Reamrks here"></td><td><a href="javascript:void(0)" id="" class="remove_clients"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td></tr>');

      $(".remove_clients").on('click', function(){
        $(this).closest("tr").remove();
      });
  });

  //Clause Details Append code
  $("#add_clause").on('click', function(){
    $("#table_clause tbody").append('<tr><td>1</td><td><textarea class="form-control input-sm basic-detail-input-style" name="clause_name[]" id="" placeholder="Enter Name here"></textarea></td><td><textarea class="form-control input-sm basic-detail-input-style" name="clause_clarification[]" id="" placeholder="Enter Number here"></textarea></td><td><textarea class="form-control input-sm basic-detail-input-style" name="clause_remark[]" id="" placeholder="Enter Reamrks here"></textarea></td><td><a href="javascript:void(0)" id="" class="remove_clause"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td></tr>');

      $(".remove_clause").on('click', function(){
        $(this).closest("tr").remove();
      });
  });


</script>
<!-- Custom Script Ends here -->

@endsection
  
