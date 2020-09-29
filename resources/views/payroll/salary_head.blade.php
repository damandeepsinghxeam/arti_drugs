@extends('admins.layouts.app')



@section('content')


<style>
  .heading2_form {
    font-size: 20px;
    text-decoration: underline;
    text-align: center;
  }
  .basic-detail-label {
    padding-right: 0px;
    padding-top: 4px;
  }
</style>
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Salary Heads</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="col-sm-12">
           <div class="box box-primary">
              <!-- form start -->
              @include('admins.validation_errors')
              <form id="salary_heads" method="POST" class="form-horizontal">
                <div class="box-body jrf-form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row field-changes-below">
                        <div class="col-md-4 text-right">
                          <label for="name" class="basic-detail-label">Name<span style="color: red">*</span></label>
                        </div>
                        {{ csrf_field() }}
                        <div class="col-md-4">
                          <input type="text" name="name" id="name" class="form-control input-sm basic-detail-input-style" required="" value="@if($edit){{$rec->name}}@endif" placeholder="Enter Salary Head Name">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6"></div>
                  </div>

                  <div class="box-footer create-footer text-center">
                    @if($edit)
                      <input type="submit" class="btn btn-primary" id="submit3" value="Update" name="submit">
                      <a href="/payroll/salary-head" class="btn btn-info">Add New</a>
                    @else
                      <input type="submit" class="btn btn-primary" id="submit3" value="Add" name="submit">
                    @endif
                    
                  </div>

                  <h2 class="heading2_form">Salary Heads List:</h2>
                  <!--KRA Table Starts here-->
                   <table class="table table-striped table-responsive table-bordered" id="salary_heads_table">
                       <thead class="table-heading-style">
                           <tr>
                               <th>S No.</th>
                               <th>Employee Name</th>
                               <th>Edit</th>
                               <th class="hide">Delete</th>
                           </tr>
                       </thead>
                       <tbody class="kra_tbody">
                        @foreach($records as $r)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>
                            <span>{{$r->name}}</span>
                          </td>
                          <td>
                            <a class="btn btn-primary" href="/payroll/salary-head/{{$r->id}}">
                              <i class="fa fa-edit"></i>
                            </a>
                          </td>
                          <td class="hide">
                            <button class="btn btn-danger">
                              <i class="fa fa-trash bg"></i>
                            </button>
                          </td>
                        </tr>
                        @endforeach
                       </tbody>
                       <tfoot class="table-heading-style">
                         <th>S No.</th>
                         <th>Employee Name</th>
                         <th>Edit</th>
                         <th class="hide">Delete</th>
                       </tfoot>
                   </table>
                  <!--KRA Table Ends here-->
                </div>
              </form>
          </div>
      </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_assets/validations/additional-methods.js')}}"></script>
<script type="text/javascript">
  $('#salary_heads_table').DataTable({
  "scrollX": true,
  responsive: true
});
</script>
  @endsection







