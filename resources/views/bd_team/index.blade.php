@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List B.D Team </h1>
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
      <div class="box">
        <!-- /.box-header -->
        <div class="col-md-12">
           @include('admins.validation_errors')
        </div>

        <div class="box-title">
          <div class="row">
            <div class="col-md-12">
                <div class="col-md-2 pull-right text-right">
                  @can('bd-team.create')
                    <h3 class="box-title">
                      <a class="btn btn-info" href="{!! route('bd-team.create') !!}">Add</a>
                    </h3>
                  @endcan
                </div>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table id="team1-table" class="table table-bordered table-striped table-condensed table-responsive">
                <thead class="table-heading-style">
                  <tr>
                    <th class="no-sort"> S.No. </th>
                    <th>Department Name</th>
                    <th>Team Name</th>
                    <th>Team Type</th>
                    @if(auth()->user()->can('bd-team.show') || auth()->user()->can('bd-team.edit'))
                      <th class="no-sort">Actions</th>
                    @endif

                    @can('bd-team.change-status')
                      <th class="no-sort">Status</th>
                    @endcan
                  </tr>
                </thead>
                <tbody>
                  @php
                    $teamTypeArr = ['govt' => 'Government', 'corp' => 'Corporate'];
                  @endphp
                  @if(!empty($teamList) && count($teamList) > 0)
                    @foreach($teamList as $key => $list)
                      <tr>
                        <td> {!! $loop->iteration !!} </td>
                        <td> {!! $list->department->name !!} </td>
                        <td> {!! $list->name !!} </td>
                        <td> {!! $teamTypeArr[$list->team_type] ?? '--' !!} </td>

                        @if(auth()->user()->can('bd-team.show') || auth()->user()->can('bd-team.edit'))
                          <td>
                          @can('bd-team.show')
                            <a href="{{ route('bd-team.show', $list->id)}}" class="btn btn-primary btn-xs">
                              <i class="fa fa-eye"></i>
                            </a>
                          @endcan

                          @can('bd-team.edit')
                            <a href="{!! route('bd-team.edit', $list->id) !!}" class="btn btn-success btn-xs">
                              <i class="fa fa-edit"></i>
                            </a>
                          @endcan
                          </td>
                        @endif

                        @can('bd-team.change-status')
                          <td>
                            <div class="dropdown">
                              @php
                                $statusClass = $statusText = null;
                                if($list->isactive == 1) {
                                  $statusClass = 'btn-success';
                                  $statusText  = 'Active';
                                } else {
                                  $statusClass = 'btn-warning';
                                  $statusText  = 'Inactive';
                                }
                              @endphp
                              <button class="btn {!! $statusClass !!} dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                {!! $statusText !!}
                              </button>
                              <ul class="dropdown-menu">
                              <li>
                                @if($list->isactive)
                                  <a href="{!! route('bd-team.change-status', $list->id) !!}" class="dropdown-item">
                                    Inactive
                                  </a>
                                @else
                                  <a href="{!! route('bd-team.change-status', $list->id) !!}" class="dropdown-item">
                                    Active
                                  </a>
                                @endif
                              </li>
                              </ul>
                            </div>
                          </td>
                        @endcan
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td class="text-center p-15" colspan="5"> No Records Found. </td>
                    </tr>
                  @endif
                </tbody>
                <tfoot class="table-heading-style">
                  <tr>
                    <th>S.No.</th>
                    <th>Department Name</th>
                    <th>Team Name</th>
                    <th>Team Type</th>
                    @if(auth()->user()->can('bd-team.show') || auth()->user()->can('bd-team.edit'))
                      <th>Actions</th>
                    @endif

                    @can('bd-team.change-status')
                      <th>Status</th>
                    @endcan
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('script')
  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function () {

        $('#team-table').DataTable({
          processing: true,
          lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
          pageLength: -1,
          columnDefs: [
            {
              targets: 'no-sort',
              orderable: false,
            }
          ],
          aaSorting: []
        });
    });
  </script>
@endsection