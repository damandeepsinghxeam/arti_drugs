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
        {{"Designation"}}
      </h1>
      <ol class="breadcrumb">
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box1ss) -->
      <div class="row">
          <div class="col-sm-12">
           <div class="box box-primary">
                @if ($errors->any())
                    <br>
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <!-- form start -->
          <form id="cityFormA" action="{{ url('mastertables/save-designation') }}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="ProjectId">Projects</label>
                  <select class="form-control regis-input-field" name="project_Id" id="project_Id">
                  @if(!$data['project']->isEmpty())
                    @foreach($data['project'] as $project)  
                      <option value="{{$project->id}}"@if(@$data['designation']->project_id ==$project->id){{"selected"}}@else{{''}}@endif>{{$project->name}}</option>
                    @endforeach
                  @endif  
                  </select>
                </div>

                <div class="form-group">
                  <label for="DesignationName">Designation Name</label>
                  <input type="text" class="form-control regis-input-field" id="designation_name" name="designation_name" placeholder="Designation Name" value="{{@$data['designation']->short_name}}">
                </div>

                <input type="hidden" name="action" value="{{$data['action']}}">
                @if(!empty(@$data['designation']->id))
                <input type="hidden" name="designationId" value="{{$data['designation']->id}}">
                @endif
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-btn-style">Submit</button>
              </div>
            </form>
          </div>
      </div>
      </div>
      <div class="row"></div>
    </section>
  </div>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
  <script>
    $(document).ready(function(){

    $("#cityFormA").validate({
        rules :{
            "designation_name" : {
              required : true,
            }
        },
        messages :{
            "designation_name" : {
                required : "Please Fill Designation.",
            }
        }
    });
 });
    jQuery.validator.addMethod("exactlength", function(value, element, param) {
        return this.optional(element) || value.length == param;
    }, $.validator.format("Please enter exactly {0} characters."));
    $(".upperCase").on("keyup",function(){
        var value = $(this).val();
        value = value.toUpperCase();
        $(this).val(value);
    });
  </script>
  @endsection