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
      <h1><i class="fa fa-user"></i> Candidates after HOD Feedback</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section> 

   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-sm-12">
            <div class="box box-primary">
               <div class="box-body">
                  <table id="listHolidays" class="table table-bordered table-striped text-center">
                     <thead class="table-heading-style">
                        <tr>
                           <th>S.No.</th>
                           <th>Recruiter Name</th>
                           <th>Candidate Name</th>
                           <th>Total Experience</th>
                           <th>Hired CTC</th>
                           <th>Hired CIH</th>
                           <th>joining Letter</th>
                        </tr>
                     </thead>

                     <tbody>
                        @php $counter = 1; @endphp 

                        @foreach($jrfs_approval as $key =>$jrf)

                        <tr> 
                           <td>{{@$counter++}}</td>
                           <td>{{@$jrf->fullname}}</td>
                           <td><a href='{{url("jrf/view-jrf/$jrf->jrf_id")}}' target="_blank">{{@$jrf->cand_name}}</a></td>
                           <td>{{@$jrf->total_experience}}</td>
                           <td>{{@$jrf->ctc}}</td>
                           <td>{{@$jrf->cih}}</td> 
                           <td><a href='{{url("public/uploads/jrf_joining_letter/$jrf->joining_letter")}}' target="_blank">View</a></td>
         
                        </tr>

                        @endforeach
                     </tbody>

                     <tfoot class="table-heading-style">
                        <tr>
                           <th>S.No.</th>
                           <th>Recruiter Name</th>
                           <th>Candidate Name</th>
                           <th>Total Experience</th>
                           <th>Hired CTC</th>
                           <th>Hired CIH</th>     
                           <th>joining Letter</th>
                        </tr>
                     </tfoot>
                  </table>
               </div><!-- /.box-body -->
            </div>
         </div>
      </div>

          </div><!-- /.box -->

        </div><!-- /.row -->

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