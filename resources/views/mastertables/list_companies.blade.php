@extends('admins.layouts.app')

@section('content')


<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">


<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Registered Companies List

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

              @can('create-company')

              <h3 class="box-title"><a class="btn btn-info" href='{{ url("mastertables/companies/add")}}'>Add</a></h3>

              @endcan

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <table id="listRegisterCompanies" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Name</th>

                  <th>Created By</th>

                  <th>Approval By</th>

                  <th>Approval Status</th>

                  <th>ESI Registrations</th>

                  <th>PT Registrations</th>

                  @if(auth()->user()->can('edit-company') || auth()->user()->can('approve-company'))

                  <th style="width: 70px;">Action</th>

                  @endif

                  @can('create-company') 

                  <th>Status</th>

                  @endcan

                </tr>

                </thead>

                <tbody>

                @foreach($companies as $key =>$value)  

                <tr>

                  <td>{{@$loop->iteration}}</td>

                  <td><a href="javascript:void(0)" class="additionalCompanyInfo" title="more details" data-companyid="{{$value->id}}">{{$value->name}}</a></td>

                  <td>{{@$value->creator->employee->fullname}}</td>

                  <td>{{@$value->approval->approver->employee->fullname}}</td>

                  <td>

                    @if($value->approval_status == '0')

                      <span class="label label-danger">Not Approved</span>

                    @else

                      <span class="label label-success">Approved</span>

                    @endif

                  </td>

                  <td><a href='{{ url("mastertables/company-esi-registrations/$value->id") }}' class="label label-primary">Details</a></td>

                  <td><a href='{{ url("mastertables/company-pt-registrations/$value->id") }}' class="label label-primary">Details</a></td>

                  @if(auth()->user()->can('edit-company') || auth()->user()->can('approve-company'))

                  <td>

                    @if(auth()->user()->can('edit-company'))

                    <a class="btn bg-purple" href='{{ url("mastertables/companies/edit/$value->id")}}' title="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;

                    @endif 

                    @if(auth()->user()->can('approve-company') && $value->approval_status == 
                    '0')<a class="btn bg-navy approveBtn" href='{{ url("mastertables/companies/approve/$value->id")}}' title="approve"><i class="fa fa-check" aria-hidden="true"></i></a>

                    @endif

                  </td>

                  @endif

                  

                  @can('create-company')

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

                                  <a href='{{ url("mastertables/companies/deactivate/$value->id")}}'>De-activate</a>

                                @else

                                  <a href='{{ url("mastertables/companies/activate/$value->id")}}'>Activate</a>

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

                  <th>Name</th>

                  <th>Created By</th>

                  <th>Approval By</th>

                  <th>Approval Status</th>

                  <th>ESI Registrations</th>

                  <th>PT Registrations</th>

                  @if(auth()->user()->can('edit-company') || auth()->user()->can('approve-company'))

                  <th>Action</th>

                  @endif

                  @can('create-company')

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

    <div class="modal fade" id="companyInfoModal">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Additional Information</h4>

          </div>

          <div class="modal-body companyInfoModalBody">

              

          </div>

          

        </div>

        <!-- /.modal-content -->

      </div>

    <!-- /.modal-dialog -->

    </div>

      <!-- /.modal -->



  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">
      $(".approveBtn").on('click',function(){
        if (!confirm("Are you sure you want to approve this company?")) {
            return false; 
        }
      });

      $(".additionalCompanyInfo").on('click',function(){
        var companyId = $(this).data('companyid');

        $.ajax({
          type: "POST",
          url: "{{ url('mastertables/additional-company-info') }}",
          data: {company_id: companyId},
          success: function (result){
            $(".companyInfoModalBody").html(result);
            $('#companyInfoModal').modal('show');

          }
        });
      });

      $(document).ready(function() {

          $('#listRegisterCompanies').DataTable({
            scrollX: true,
            responsive: true
          });

      });

  </script>

  @endsection