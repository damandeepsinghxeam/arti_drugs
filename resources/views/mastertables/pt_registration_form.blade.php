@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        @if($data['action'] == "add")

        {{"Add"}}

        @else

        {{"Edit"}}

        @endif

        {{"PT Registration"}}

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="{{ url('mastertables/company-pt-registrations/').'/'.$data['company_id'] }}">PT Registrations List</a></li> 

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="col-sm-10">

           <div class="box box-primary">

                @include('admins.validation_errors')

                @if(session()->has('save_error'))
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('save_error') }}
                  </div>
                @endif

            <div class="box-header with-border">

              <h3 class="box-title">Form</h3>

            </div>

            <!-- /.box-header -->
            <!-- form start -->

            <form id="ptRegistrationForm" action="{{ url('mastertables/save-pt-registration') }}" method="POST">

              {{ csrf_field() }}

              <div class="box-body">

                <div class="form-group">

                  <label>Company</label>

                  <select class="form-control" name="company_id" disabled>

                  @if(!$data['companies']->isEmpty())  

                    @foreach($data['companies'] as $company)  

                      <option value="{{$company->id}}" @if(@$data['company_id'] == $company->id){{"selected"}} @else{{""}}@endif>{{$company->name}}</option>

                    @endforeach

                  @endif

                  </select>

                </div>

                <input type="hidden" name="company_id" value="{{$data['company_id']}}">

                <div class="form-group">

                  <label>State</label>

                  <select class="form-control select2" name="state_id">
                      <option value="" selected disabled>None</option>
                  @if(!$data['states']->isEmpty())  
                    @foreach($data['states'] as $state)  
                      <option value="{{$state->id}}" @if(@$data['pt_registration']->state_id == $state->id){{"selected"}} @else{{""}}@endif>{{$state->name}}</option>
                    @endforeach
                  @endif

                  </select>

                </div>

                <div class="form-group">

                  <label for="returnPeriod">Return Period</label>

                  <select class="form-control" name="return_period">

                    <option value="Monthly" @if(@$data['pt_registration']->return_period == 'Monthly'){{'selected'}}@endif>Monthly</option>

                    <option value="Half Yearly" @if(@$data['pt_registration']->return_period == 'Half Yearly'){{'selected'}}@endif>Half Yearly</option>

                    <option value="Yearly" @if(@$data['pt_registration']->return_period == 'Yearly'){{'selected'}}@endif>Yearly</option>

                  </select>

                </div>

                <div class="form-group">

                  <label for="certificateNo">Certificate Number</label>

                  <input type="text" class="form-control" id="certificateNo" name="certificate_number" placeholder="Certificate Number" value="{{@$data['pt_registration']->certificate_number}}">

                </div>

                <div class="form-group">

                  <label for="ptoCircleNo">PTO Circle Number</label>

                  <input type="text" class="form-control" id="ptoCircleNo" name="pto_circle_number" placeholder="PTO Circle Number" value="{{@$data['pt_registration']->pto_circle_number}}">

                </div>

                <div class="form-group">

                  <label for="address">Address</label>

                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{@$data['pt_registration']->address}}">

                </div>

                <input type="hidden" name="action" value="{{$data['action']}}">

                @if(!empty(@$data['pt_registration']))

                  <input type="hidden" name="pt_registration_id" value="{{$data['pt_registration']->id}}">

                @endif                  

              </div>

              <!-- /.box-body -->

              <div class="box-footer">

                <button type="submit" class="btn btn-primary">Submit</button>

              </div>

            </form>

          </div>

      </div>

          <!-- /.box -->

      </div>

      <!-- /.row -->

      <!-- Main row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>

    $("#ptRegistrationForm").validate({
      rules :{
          "certificate_number" : {
              digits : true,
              required : true
          },
          "state_id" : {
            required : true
          },
          "address" : {
              required : true,
          }
      },

      errorPlacement: function(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('span.select2'));
        } else {
          error.insertAfter(element);
        }
      },
      
      messages :{
          "certificate_number" : {
              required : 'Please enter certificate number.',
          },
          "address" : {
              required : 'Please enter address.',
          },
          "state_id" : {
              required : 'Please select state name.',
          }
      }
    });

    $.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z]+[-]+[0-9]+[-]+[a-zA-Z]+$/i.test(value);
    }, "Please enter only alphanumeric value and -.");

    $.validator.addMethod("numericalpha", function(value, element) {
    return this.optional(element) || /^[0-9a-zA-Z]+$/i.test(value);
    }, "Please enter only alphanumeric value.");

  </script>

  @endsection