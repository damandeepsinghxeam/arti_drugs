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
      <h1>Salary Cycle</h1>
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
              <form id="salary_cycle" method="POST">
                <div class="box-body jrf-form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row field-changes-below">
                          <div class="col-md-4 text-right">
                            <label for="name" class="basic-detail-label">Name<span style="color: red">*</span></label>
                          </div>
                          <div class="col-md-4">
                            <input type="text" name="name" id="name" class="form-control input-sm basic-detail-input-style"placeholder="Enter Salary Cycle Name" required="" value="@if($edit){{$rec->name}}@endif">
                          </div>
                      </div>
                      <div class="row field-changes-below">
                          <div class="col-md-4 text-right">
                            <label for="from" class="basic-detail-label">Day From<span style="color: red">*</span></label>
                          </div>
                          <div class="col-md-4">
                            <select name="salary_from" required=""  id="from" class="form-control input-sm basic-detail-input-style">
                                <option value="" selected disabled>Day From</option>
                                @for($i=1;$i<30;$i++)
                                <option @if($edit && $rec->salary_from==$i)selected @endif >{{$i}}</option>
                                @endfor 
                              </select>
                          </div>
                          {{ csrf_field() }}
                      </div>
                      <div class="row field-changes-below">
                          <div class="col-md-4 text-right">
                            <label for="salary_to" class="basic-detail-label">Day To<span style="color: red">*</span></label>
                          </div>
                          <div class="col-md-4">
                            <select name="salary_to" id="to" required="" class="form-control input-sm basic-detail-input-style">
                                <option value="" selected disabled>Day To</option>
                                @for($i=1;$i<=30;$i++)
                                <option @if($edit && $rec->salary_to==$i)selected @endif >{{$i}}</option>
                                @endfor
                              </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6"></div>
                  </div>
                  <div class="box-footer create-footer text-center">
                    @if($edit)
                      <input type="submit" class="btn btn-primary" id="submit3" value="Update" name="submit">
                      <a href="/payroll/salary-cycle" class="btn btn-info">Add New</a>
                    @else
                      <input type="submit" class="btn btn-primary" id="submit3" value="Add" name="submit">
                    @endif
                    
                  </div>
  
                  <h2 class="heading2_form">Salary Cycle List</h2>
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
                            <a class="btn btn-primary" href="/payroll/salary-cycle/{{$r->id}}">
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



