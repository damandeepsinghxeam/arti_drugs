@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        ESI Registrations List

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="{{ url('mastertables/companies') }}">Register Companies List</a></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="box">

            <div class="box-header">

              @can('create-company')

              <h3 class="box-title"><a class="btn btn-info" href='{{ url("mastertables/add-esi-registration/$company->id")}}'>Add</a></h3>

              @endcan

              <span class="pull-right">Company:  	<strong>{{@$company->name}}</strong></span>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <table id="listEsiRegistrations" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Location</th>

                  <th>ESI Address</th>

                  <th>ESI Subcode</th>

                  <th>ESI Local Office</th>

                  @can('create-company')

                  <th style="width: 65px;">Actions</th>

                  <th>Status</th>

                  @endcan

                </tr>

                </thead>

                <tbody>  

                @foreach($esi_registrations as $key =>$value)  

                <tr>

                  <td>{{@$loop->iteration}}</td>

                  <td>{{$value->location->name}}</td>

                  <td>{{@$value->address}}</td>

                  <td>{{@$value->esi_number}}</td>

                  <td>{{@$value->local_office}}</td>

                  @can('create-company')

                  <td><a class="btn btn-success" href='{{ url("mastertables/esi-registrations/edit/$value->id")}}' title="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                  <td>

                        <div class="dropdown">

                            @if($value->isactive)

                            <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">

                             {{"Active"}}

                            @else

                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">

                             {{"Inactive"}}

                            @endif  

                          <span class="caret"></span></button>

                          <ul class="dropdown-menu">

                            <li>

                                @if($value->isactive)

                                  <a href='{{ url("mastertables/esi-registrations/deactivate/$value->id")}}'>De-activate</a>

                                @else

                                  <a href='{{ url("mastertables/esi-registrations/activate/$value->id")}}'>Activate</a>

                                @endif

                            </li>

                            

                          </ul>

                        </div>

                  </td>

                  @endcan

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Location</th>

                  <th>ESI Address</th>

                  <th>ESI Number</th>

                  <th>ESI Local Office</th>

                  @can('create-company')

                  <th>Actions</th>

                  <th>Status</th>

                  @endcan

                </tr>

                </tfoot>

              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col --> 
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

      $(document).ready(function() {

          $('#listEsiRegistrations').DataTable({
          	scrollX: true,
            responsive: true
          });

      });

  </script>

  @endsection