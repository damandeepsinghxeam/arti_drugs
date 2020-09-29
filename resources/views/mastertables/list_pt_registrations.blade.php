@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        PT Registrations List

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('mastertables/companies') }}">Companies List</a></li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="box">

            <div class="box-header">

              @can('create-company')

              <h3 class="box-title"><a class="btn btn-info" href='{{ url("mastertables/add-pt-registration/$company->id")}}'>Add</a></h3>

              @endcan

              <span class="pull-right">Company:   <strong>{{@$company->name}}</strong></span>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <table id="listPtRegistrations" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>State</th>

                  <th>Certificate No</th>

                  <th>PTO Circle No</th>

                  <th>Address</th>

                  <th>Return Period</th>

                  @can('create-company')

                  <th style="width: 65px;">Actions</th>

                  <th>Status</th>

                  @endcan

                </tr>

                </thead>

                <tbody>

                @foreach($pt_registrations as $key =>$value)  

                <tr>

                  <td>{{$loop->iteration}}</td>

                  <td>{{@$value->state->name}}</td>

                  <td>{{@$value->certificate_number}}</td>
                  
                  <td>{{@$value->pto_circle_number}}</td>

                  <td>{{@$value->address}}</td>

                  <td>{{@$value->return_period}}</td>

                  @can('create-company')

                  <td><a class="btn btn-success" href='{{ url("mastertables/pt-registrations/edit/$value->id")}}' title="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>

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

                                  <a href='{{ url("/mastertables/pt-registrations/deactivate/$value->id")}}'>De-activate</a>

                                @else

                                  <a href='{{ url("/mastertables/pt-registrations/activate/$value->id")}}'>Activate</a>

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

                  <th>State</th>

                  <th>Certificate No</th>

                  <th>PTO Circle No</th>

                  <th>Address</th>

                  <th>Return Period</th>

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

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

      $(document).ready(function() {

          $('#listPtRegistrations').DataTable({
            scrollX: true,
            responsive: true
          });

      });

  </script>

  @endsection