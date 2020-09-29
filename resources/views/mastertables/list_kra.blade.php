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

      <h1>

        KRA Template list

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

              

              <h3 class="box-title"><a class="btn btn-info" href='{{ url("mastertables/kra/add")}}'>Add</a></h3>

             

            </div>

            <!-- /.box-header -->

            <div class="box-body">
				<form id="filterForm">
					<div class="form-group col-sm-3">
					  <label>Department</label>
					  <select class="form-control" name="department_id">
						<option value="" selected disabled>Select Department</option>
						<option value="">None</option>
					  @foreach($departments as $key => $value)
						<option value="{{$value->id}}" @if($req['department_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
					  @endforeach  
					  </select>
					</div>

				  <button type="submit" class="btn btn-info" id="filterFormSubmit">Submit</button>
				</form>

              <table id="listRegisterkra_templates" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>
				  
				  <th>Department</th>

                  <th>KRA Template Name</th>

                  <th>Indicator count</th>
				  
				  <th>Action</th>                 

                </tr>

                </thead>

                <tbody>

                
              @foreach($kra_templates as $kra_template) 
			  
                <tr>

                  <td>{{@$loop->iteration}}</td>
				  
				  <td>{{@$kra_template->department->name}}</td>

                  <td>{{$kra_template->name}}</td>

                  <td>
                  @php
                    $count=0;
                    foreach($kra_template->kraTemplates as $indicator){                    
                    $count++;                    
                    }
                    echo $count;
					
                  @endphp
                
              </td>
				
				<td>
					<a  href = "{{ url('mastertables/kra_indicators') }}/{{$kra_template->id}}" class="btn btn-info btn-sm" id="edit_kra">
						Edit
					</a>
				  <a  href = "{{ url('mastertables/kra/delete') }}/{{$kra_template->id}}" class="btn btn-info btn-sm" id="delete_kra">
					Delete
				  </a>
				</td>				  

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>
				  
				  <th>Department</th>

                  <th>KRA Template Name</th>

                  <th>Indicator count</th>
				  
				  <th>Action</th>                        

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


          $('#listRegisterkra_templates').DataTable({
            scrollX: true,
            responsive: true
          });

      });

  </script>

  @endsection