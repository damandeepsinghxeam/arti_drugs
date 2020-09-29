@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1><i class="fa fa-cloud-upload"></i> Upload Attendance Sheet</h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Dashboard</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
              <form>
                  <div class="row select-detail-below">
                    <div class="All-form-content">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Attendance Type</label>
                            <select class="form-control input-sm basic-detail-input-style">
                                <option value="Attendance Type 1">Attendance Type 1</option>
                                <option value="Attendance Type 2">Attendance Type 2</option>
                                <option value="Attendance Type 3">Attendance Type 3</option>
                                <option value="Attendance Type 4">Attendance Type 4</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <input type="file" name="uploadSheet" class="upload-excel-sheet">
                        </div>
                        <div class="col-md-4">
                          <button type="button" class="btn submit-btn pull-right"><i class="fa fa-cloud-download"></i> Download Template</button>
                        </div>
                      </div>
                        <button type="submit" class="btn all-form-submit">Submit</button>
                    </div>
                  </div>
              </form>
          </div>
        </div>
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

  @endsection