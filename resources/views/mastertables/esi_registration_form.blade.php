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

        {{"ESI Registration"}}

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="{{ url('mastertables/company-esi-registrations/').'/'.$data['company_id'] }}">ESI Registrations List</a></li> 

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="col-sm-12">

           <div class="box box-primary">

              @include('admins.validation_errors')

              @if(session()->has('save_error'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  {{ session()->get('save_error') }}
                </div>
              @endif

            <div class="box-header with-border leave-form-title-bg">

              <h3 class="box-title">Form</h3>

            </div>

            <!-- /.box-header -->

            <!-- form start -->

            <form id="esiRegistrationForm" action="{{ url('mastertables/save-esi-registration') }}" method="POST">
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

                  <label>States</label>

                  <select class="form-control select2" name="state_id" id="state_id">
                      <option value="" selected disabled>None</option>
                  @if(!$data['states']->isEmpty())  

                    @foreach($data['states'] as $state)  

                      <option value="{{$state->id}}" @if(@$data['esi_registration']->location->state->id == $state->id){{'selected'}}@else{{""}} @endif>{{$state->name}}</option>

                    @endforeach

                  @endif

                  </select>

                </div>

                <div class="form-group">

                  <label>Location</label>

                  <select class="form-control select2" name="location_id" id="location_id">
                  
                  </select>

                </div>

                <div class="form-group">

                  <label for="esiAddress">ESI Address</label>

                  <input type="text" class="form-control" id="esiAddress" name="esi_address" placeholder="ESI Address" value="{{@$data['esi_registration']->address}}">

                </div>

                <div class="form-group">

                  <label for="esiNumber">ESI Subcode</label>

                  <input type="text" class="form-control" id="esiNumber" name="esi_number" placeholder="ESI Subcode" value="{{@$data['esi_registration']->esi_number}}">

                </div>

                <div class="form-group">

                  <label for="esiLocalOffice">ESI Local Office</label>

                  <input type="text" class="form-control" id="esiLocalOffice" name="esi_local_office" placeholder="ESI Local Office" value="{{@$data['esi_registration']->local_office}}">

                </div>

                <input type="hidden" name="action" value="{{$data['action']}}">

                @if(!empty(@$data['esi_registration']))

                  <input type="hidden" name="esi_registration_id" value="{{$data['esi_registration']->id}}">

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

    $("#esiRegistrationForm").validate({
      rules :{
          "esi_number" : {

              required : true,

              digits : true

          },
          "location_id" : {
            required : true
          },
          "esi_address" : {

              required : true,

          },
          "state_id" : {
            required : true
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

          "esi_number" : {

              required : 'Please enter esi number.',

          },

          "location_id" : {
            required : 'Please select a location.'
          },

          "esi_address" : {

              required : 'Please enter esi address.'

          },
          "state_id" : {
            required : 'Please select a state.'
          }

      }

    });

    $.validator.addMethod("alphanumeric", function(value, element) {

    return this.optional(element) || /^[A-Za-z][A-Za-z\d]*$/i.test(value);

    }, "Please enter only alphanumeric value.");

  </script>

  <script type="text/javascript">

    var action = "{{@$data['action']}}";
    var def_location_id = "{{@$data['esi_registration']->location_id}}";
    
    $("#state_id").on('change',function(){
       var state_id = $(this).val();

       var state_ids = [];

       if(state_id){
           state_ids.push(state_id);

           $.ajax({
              type: 'POST',
              url: '{{ url("mastertables/states-wise-locations") }}',
              data: {state_ids: state_ids},
              success: function(result){
                var display_string = '<option value="" selected disabled></option>';
                $("#location_id").empty();

                if(result.locations.length != 0){
                  result.locations.forEach(function(location){
                    if(action == 'edit' && def_location_id == location.id){
                      display_string += '<option value="'+location.id+'" selected>'+location.name+'</option>';
                    }else{
                      display_string += '<option value="'+location.id+'">'+location.name+'</option>';
                    }
                    
                  });  
                }

                $("#location_id").append(display_string);
              }
           });
       } 
    }).change();

  </script>

  @endsection