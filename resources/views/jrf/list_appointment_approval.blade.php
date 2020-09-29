@extends('admins.layouts.app')
@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th, table tr td { vertical-align: middle !important; }
</style>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

   <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-list"></i> Approval Appointment listing</h1>
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
          <!-- <div class="box-header"></div> -->
          <!-- /.box-header -->
          <div class="box-body">
            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Candidate Name</th>
                  <th>Hired Annual CTC (INR Lakhs)</th>
                  <th>Hired Annual CIH (INR Lakhs)</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>

              @php $counter = 1; @endphp 

              @foreach($jrfs_approval as $key =>$jrf)  

                <tr>
                  <td>{{@$counter++}}</td>
                  <td>{{@$jrf->jrf_no}}</td>
                  <td>{{@$jrf->cand_name}}</td>
                  <td>{{@$jrf->ctc}}</td>
                  <td>{{@$jrf->cih}}</td>
                  <td>{{@$jrf->designation}}</td>
                  <td>{{@$jrf->department}}</td>
                  <td>{{@$jrf->created_at}}</td>
                  <td>
                    <a class="btn btn-info btn-xs" target="_blank" href='{{url("jrf/edit-appointment-approval/$jrf->id")}}'>
                      <i class="fa fa-edit"></i>
                    </a>&nbsp;
                    <a class="btn bg-purple btn-xs" target="_blank" href='{{url("jrf/view-appointment-approval/$jrf->id")}}'>
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
                </tr>

                @endforeach

              </tbody>
              <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Candidate Name</th>
                  <th>Hired Annual CTC (INR Lakhs)</th>
                  <th>Hired Annual CIH (INR Lakhs)</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
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
