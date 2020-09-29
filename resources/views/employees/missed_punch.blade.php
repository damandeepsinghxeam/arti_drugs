@extends('admins.layouts.app')

@section('content')


<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
  #filterFormSubmit {
    margin-top: 2%;
  }
</style>

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

    <h1>Employees absent punches of date {{$punch_date}}</h1>

    <ol class="breadcrumb">

    <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

    </ol>

    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">
          <div class="box">

         <!-- /.box-header -->
            <div class="box-body">
             <table id="employee_absent_punches" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                  <th>Sr. no.</th>
                  <th>Name</th>
                  <th>Department</th>
                   <th>Designation</th>
                </thead>
                <tbody>
                  @php $id=1; $empty=True; @endphp
                  @foreach($data as $info)
                  @php
                
                  @endphp
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$info['attendance_info']->fullname}}</td>
                  
                       <td>  @if($info['dep'] AND $info['dep']!=""){{$info['dep']->department->name}}@endif</td>          
                  
                       <td>  @if(isset($info['designation']->designation[0])){{$info['designation']->designation[0]->name}}@endif  </td>                                    
                    
                   
                  </tr>
                  @php $id++; @endphp
                  @endforeach
                  
                </tbody>
                <tfoot class="table-heading-style">

                  <th>Sr. no.</th>
                  <th>Name</th>
                  <th>department</th>
                   <th>designation</th>
                </tfoot>
              </table>   
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->   

      <!-- /.row (main row) -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
 
 
 <script src="{{asset('public/admin_assets/plugins/dataTables/dataTables.buttons.min.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/buttons.flash.min.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/jszip.min.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/pdfmake.min.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/vfs_fonts.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/buttons.html5.min.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/dataTables.buttons.min.js')}}"></script>
 <script src="{{asset('public/admin_assets/plugins/dataTables/buttons.print.min.js')}}"></script>
 

  <script type="text/javascript">




 $(document).ready(function() {

          $('#employee_absent_punches').DataTable({
            scrollX: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
              'csv', 'pdf', 'print'
            ]

          });

      });
   


  </script>

  @endsection