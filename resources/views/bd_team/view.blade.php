@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1> View B.D Team </h1>
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
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-sm-6 form-group">
                  <label class="control-label text-left">Team Name: </label>
                  <div class="">
                    {!! $team->name !!}
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="table-responsive col-md-12">
                    <table id="leads-table" class="table table-bordered table-striped table-condensed table-responsive">
                      <thead class="table-heading-style">
                        <tr>
                          <th class="no-sort"> S.No. </th>
                          <th>Name</th>
                          <th>Team Role</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(!empty($team->bdTeamMembers) && count($team->bdTeamMembers) > 0)
                          @php
                            $teamRoleArr = [1 => 'Executive', 2 => 'Manager'];
                          @endphp
                          @foreach($team->bdTeamMembers as $key => $list)
                            <tr>
                              <td> {!! $loop->iteration !!} </td>
                              <td> {!! $list->user->employee->fullname !!} </td>
                              <td> {!! $teamRoleArr[$list->team_role_id] ?? '--' !!} </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td class="text-center" colspan="3"> No Records Found. </td>
                          </tr>
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
            <div class="col-md-12">
              <a href="{!! route('bd-team.edit', $team->id) !!}" class="btn btn-primary">Edit</a>
              <a href="{!! route('bd-team.index') !!}" class="btn btn-default m-l-10">Back</a>
            </div>
          </div>
          <!-- Main row -->
        </div>
      </div>
    </div>
  </section>

</div>
@endsection

@section('script')
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

<script>
  $(document).ready(function() {
    $('#leads-detail-form').validate({
      ignore: ':hidden, input[type=hidden]',
      errorElement: 'span',
      // the errorPlacement has to take the table layout into account
      errorPlacement: function(error, element) {
        error.appendTo(element.parent());
      },
      rules: {
        assign_to: { requird:true },
      },
      messages: {
        assign_to: {
          required: "Please select a assignee first."
        }
      }
    });
  });
</script>
@endsection