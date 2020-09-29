@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Create B.D Team </h1>
      <ol class="breadcrumb">
        <li>
          <a href="{{ url('employees/dashboard') }}">
            <i class="fa fa-dashboard"></i> Home
          </a>
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">
           <div class="box box-primary">
             
             <!-- form start -->
              <form id="bd-team-form" class="form-vertical" action="{{ route('bd-team.store') }}" method="POST" enctype="multipart/form-data">
                @include('admins.validation_errors')

                {{ csrf_field() }}

                <div class="box-body">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-sm-3 form-group">
                        <label class="control-label text-left">Team Name: </label>
                        <div class="">
                          <input type="text" name="name" id="name" class="form-control name" value="" required="required">
                          @php
                            $departmentId = $userDetails->department_id;
                            $teamTypeText = 'corp';
                            if($departmentId == 3) {
                              $teamTypeText = 'govt';
                            }
                          @endphp
                          <input type="hidden" name="team_type" id="team_type" value="{!! $teamTypeText !!}">
                        </div>
                      </div>
                      <!-- <div class="col-sm-3 form-group">
                        <label class="control-label text-left">Team Type: </label>
                        <div class="">
                          <select name="team_type" class="form-control team_type" required="required">
                            <option value="">-Select-</option>
                            <option value="govt">Government</option>
                            <option value="corp">Corporate</option>
                          </select>
                        </div>
                      </div> -->
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="table-responsive col-md-12">
                          <table id="leads-table" class="table table-bordered table-striped table-condensed table-responsive">
                            <thead class="table-heading-style">
                              <tr>
                                <th class="no-sort">
                                  <label for="user_id_all">
                                    <input type="checkbox" class="user_id_all" name="user_id_all" id="user_id_all" value="1"> S.No.
                                  </label>
                                </th>
                                <th>Name</th>
                                <th>Team Role</th>                                                 
                              </tr>
                            </thead>
                            <tbody>
                              @if(!empty($users) && count($users) > 0)
                                @foreach($users as $key => $user)
                                  <tr>
                                    <td>
                                      <label for="user[id][{!! $user->id !!}]" class="font-normal">
                                        <input type="checkbox" class="user_id" name="user[id][]" id="user[id][{!! $user->id !!}]" value="{!! $user->id !!}"> 
                                        {!! $loop->iteration !!}
                                      </label>
                                    </td>
                                    <td> {!! $user->employee->fullname !!}</td>
                                    <td>
                                      <label for="user[role][{!! $user->id !!}][1]" class="font-normal">
                                        <input type="radio" class="user_role" name="user[role][{!! $user->id !!}]" id="user[role][{!! $user->id !!}][1]" value="1"> 
                                        Executive &nbsp;
                                      </label>

                                      <label for="user[role][{!! $user->id !!}][2]" class="font-normal">
                                        <input type="radio" class="user_role" name="user[role][{!! $user->id !!}]" id="user[role][{!! $user->id !!}][2]" value="2"> 
                                        Manager &nbsp;
                                      </label>
                                    </td>
                                  </tr>
                                @endforeach
                              @endif
                            </tbody>
                            <tfoot class="table-heading-style">
                              <tr>
                                <th>S.No.</th>
                                <th>Name</th>                 
                                <th>Team Role</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary submit_btn">Save</button>
                        <a href="{!! route('bd-team.index') !!}" class="btn btn-default m-l-10">Back</a>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
                <!-- Main row -->
           </div>
         </div>
      </div>
    </section>

  </div>
@endsection

@section('script')
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('click', '.user_id_all', function (event) {   
      if($(this).is(':checked')) {
        $('.user_id').prop('checked', true);
      } else {
        $('.user_id').prop('checked', false);
      }
    });

    $(document).on('click', '.user_id', function (event) {
      if(!$(this).is(':checked')) {
        $('.user_id_all').prop('checked', false);
      }
    });

    $('#bd-team-form').validate({
          ignore: ':hidden, input[type=hidden], .select2-search__field',
          errorElement: 'div',
          // the errorPlacement has to take the table layout into account
          errorPlacement: function(error, element) {

            if (element.is(":radio"))
              // error.appendTo(element.parent()); // element.parent().next().next()
              error.appendTo(element.parent().parent());
              
            else if (element.is(":checkbox"))
              error.appendTo(element.parent().parent());

            else
              error.appendTo(element.parent()); // element.parent().next()
          },
          rules: {
            name: { required: true, },
            'user[id][]': { 
              required: true,
              minlength: 2,
            },
          },
          messages: {
            'user[id][]': {
              required : 'Please select users to create a team.',
              minlength : 'Please select at least 2 users.',
            }
          }
      });

      $('input.user_role').each(function(k, v) {
          $(this).rules('add', {
            required: function(element) {
              return $(element).parent().parent().siblings(":first").find('.user_id').is(':checked');
            }
          });
      });

      $(document).on('click', '.submit_btn', function(event) {
        
        if($('#bd-team-form').valid()) {
          var isManagerSelected = false; var isExecutiveSelected = false;
          $('input.user_role:checked').each(function (k, v) {
              var selectedValue = $(v).val();

              if(selectedValue == 1) {
                isExecutiveSelected = true;
              }
              if(selectedValue == 2) {
                isManagerSelected = true;                
              }
          });

          var message = '';
          if(isExecutiveSelected == false) {
            message = 'Please Select at least one team executive.';
          }
          if(isManagerSelected ==  false) {
            message = 'Please Select at least one team manager.';
          }

          if(message != '') {
              event.preventDefault(); event.stopPropagation();

              $.toast({
                heading: 'Error',
                text: message,
                showHideTransition: 'plain',
                icon: 'error',
                hideAfter: 3000,
                position: 'top-right', 
                stack: 3, 
                loader: true,
                loaderBg: '#b50505',
            });
            return false;
          }
        }
      });
  });
</script>
@endsection