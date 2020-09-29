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

        {{"ESI Circles/Locations"}}

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="">Circles List</a></li> 

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="col-sm-12">

           <div class="box box-primary">

                @include('admins.validation_errors')

                @if(@$data['save_success'])
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ @$data['save_success'] }}
                  </div>
                @endif

            <div class="box-header with-border mastertables-heading">

              <h3 class="box-title">Form</h3>

            </div>

            <!-- /.box-header -->

            <!-- form start -->

            <form id="stateForm" action="" method="POST">

              {{ csrf_field() }}

              <div class="box-body">



                <div class="form-group add-department-form">
                  <div class="mastertbl-department-lbl">
                    <label>Country</label>
                  </div>
                  <div class="mastertbl-department-input">
                    <select class="form-control basic-detail-input-style" name="countryId">
                    @if($data['countries']->count())
                       @foreach($data['countries'] as $country)  
                        <option value="{{$country->id}}" @if(@$data['state']->country_id == $country->id){{"selected"}}@else{{''}}@endif>{{$country->name}}</option>
                      @endforeach
                    @endif  
                    </select>
                  </div>
                </div>
                <div class="form-group add-department-form">
                  <div class="mastertbl-department-lbl">
                    <label>State</label>

                  </div>
                  <div class="mastertbl-department-input">
                    <select onchange='window.location.href="{{Request::url()}}/?state_id="+this.value' class="form-control basic-detail-input-style" name="">
                    @if($data['states']->count())
                        <option value="0">Select State</option>
                       @foreach($data['states'] as $st)  
                        <option value="{{$st->id}}" @if($data['state_id']==$st->id) selected @endif>{{$st->name}}</option>
                      @endforeach
                    @endif  
                    </select>
                  </div>
                </div>
                <div class="form-group add-department-form">
                  <div class="mastertbl-department-lbl">
                    <label for="stateName">ESI circle name</label>
                  </div>
                  <div class="mastertbl-department-input">
                    <input type="text" class="form-control basic-detail-input-style" id="cityName" name="name" placeholder="ESI circle name" value="{{@$data['location']->name}}">
                  </div>
                </div>
              </div>

              <!-- /.box-body -->



              <div class="box-footer">
                @if(!empty(@$data['location']))
                <button type="submit" value="Update" name="btn_submit" class="btn btn-primary">Update</button>
                @else
                <button type="submit" value="Add" name="btn_submit" class="btn btn-primary">Add</button>
                @endif
              </div>

            </form>

          </div>
          @if(isset($data["locations"]))
          <div class="row">
            <table id="listStates" class="table table-bordered table-striped">

                <thead class="table-heading-style">
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>City Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                
                @foreach($data["locations"] as $value)  

                <tr>

                  <td>{{$loop->iteration}}</td>

                  <td>{{$value->name}}</td>
                  <td>{{$value->name}}</td>
                  <td><a class="btn bg-purple" href='{{ route("employees.locations") }}/{{$value->id}}?state_id={{$value->state_id}}' title="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;<!-- <a class="btn btn-danger deleteBtn" href='{{ url("/masterTables/states/delete/$value->s_id")}}'>Delete</a> --></td>
                </tr>
                @endforeach
                
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Name</th>
                  <th>City</th>
                  <th>Actions</th>
                </tr>

                </tfoot>

              </table>
          </div>
          @endif
      </div>

          <!-- /.box -->

      </div>

      <div class="row">


      </div>

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>

    $("#stateForm").validate({
      rules :{

          "stateName" : {
              required : true,
              maxlength: 40,
          }
      },

      messages :{

          "stateName" : {

              required : 'Please enter city name.',

              maxlength: 'Maximum 40 characters are allowed.'

          }
          }

      }

    });



    $.validator.addMethod("exactlength", function(value, element, param) {

       return this.optional(element) || value.length == param;

    }, $.validator.format("Please enter exactly {0} characters."));



    $(".upperCase").on("keyup",function(){

      var value = $(this).val();

      value = value.toUpperCase();

      $(this).val(value);

    });

  </script>

  @endsection