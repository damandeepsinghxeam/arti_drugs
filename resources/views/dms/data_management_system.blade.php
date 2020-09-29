@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ session()->get('error') }}
        </div>
      @endif

      <h1>

        Data Management System

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Data Management System</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">

          <!-- small box -->

          <div class="small-box bg-green">

            <div class="inner">

              <h3>IT / ITes</h3>

            </div>

            <div class="icon">

              <i class="ion ion-stats-bars"></i>

            </div>

            <a href="../dms/dms-list" class="small-box-footer">View Details <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

        

        <!-- ./col -->

      </div>

      <!-- /.row -->
    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  @endsection