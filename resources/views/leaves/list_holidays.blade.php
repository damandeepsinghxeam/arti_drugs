@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Holidays List

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="box">

            <div class="box-header">


            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <table id="listHolidays" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>From Date</th>
                  <th>To Date</th>

                </tr>

                </thead>

                <tbody>

                @foreach($holidays as $key =>$value)  

                <tr>

                  <td>{{$loop->iteration}}</td>
                  <td>{{@$value->name}}</td>
                  <td title="{{@$value->description}}">
                    @if(strlen($value->description) <= 30)
                      {{@$value->description}}
                    @else
                      {{substr($value->description, 30)}}...
                    @endif
                  </td>
                  <td>{{date("d/m/Y",strtotime($value->holiday_from))}}</td>
                  <td>{{date("d/m/Y",strtotime($value->holiday_to))}}</td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>From Date</th>
                  <th>To Date</th>

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

          $('#listHolidays').DataTable({
            scrollX: true,
            responsive: true
          });

      });

  </script>

  @endsection