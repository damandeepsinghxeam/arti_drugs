@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DMS Listing Approval

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
            <!-- /.box-header -->

            <div class="box-body">

              <table id="employeesList" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Department</th>

                  <th>Main Category</th>

                  <th>Sub Category</th>

                  <th>Project / Tender Name</th>

                  <th>File</th>

                  <th>Created By</th>

                  <th>Created Date</th>

                  <th>Remarks</th>

                  <th>Marks to Approve</th>

                  <th>Action</th>
                </tr>

                </thead>

                <tbody> 

                <tr>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
                  <td></td>
	                <td></td>
	                <td></td>
	                <td></td>
                  <td><input type="checkbox" name="markToApproved" id="markToApproved" class="markToApproved"></td>
                  <td></td>
                </tr>

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Department</th>

                  <th>Main Category</th>

                  <th>Sub Category</th>

                  <th>Project / Tender Name</th>

                  <th>File</th>

                  <th>Created By</th>

                  <th>Created Date</th>

                  <th>Remarks</th>

                  <th>Marks to Approve</th>

                  <th>Action</th>
                </tr>

                </tfoot>

              </table>

              <div class="box-footer">
                <button type="button" class="btn btn-primary">Approve DMS</button>
              </div>
            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

      </div>

      <!-- /.row -->

        <!-- /.modal -->

      <!-- /.row (main row) -->



    </section>

    <!-- /.content -->
    
  <!-- Modal -->
  

  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>


<script type="text/javascript">
  $(document).ready(function(){
     $("#registerPopUp").click(function(){
      $("#mySuitableJobModal").hide();
    });
  });
</script>



  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  @endsection