<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cost Estimation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="{{asset('public/admin_assets/static_assets/xeam-favicon.png')}}">
  <!-- Bootstrap 3.3.7 -->
  <link href="{{asset('public/admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{asset('public/admin_assets/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <!--my main css-->
  <link href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}" rel="stylesheet">
  <link href="{!! asset('public/admin_assets/dist/css/cost_estimation_sheet.css') !!}" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/AdminLTE.css')}}">
  <!-- <link rel="stylesheet" href="css/mystyle.css"> -->
  <!--google fonts link-->
  <link href="https://fonts.googleapis.com/css?family=Be+Vietnam&display=swap" rel="stylesheet">
  <!--jquery script-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{asset('public/admin_assets/bower_components/moment/min/moment.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('public/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
</head>
<body>
<!--Main outer container starts here-->
<div class="wrapper">
  <h1>Cost Estimation Sheet</h1>
  <hr>
  @include('admins.validation_errors')

  <h2 class="sub-heading">Project Financial Scope</h2>
  <!-- /.box-header -->
  <form id="cost_form" action="{!! route('leads-management.save-cost-estimation') !!}" method="POST" class="form-horizontal" enctype="multipart/form-data">

    {!! csrf_field() !!}
    <input type="hidden" name="til_draft_id" value="{!! $tilDraft->id !!}">
    <input type="hidden" name="is_complete" value="0">
    <!--Project Financial Scope Starts Here-->
    <section class="section_project_scope">
      <div class="flex-container flex_container_to_append">
        <div class="flex-item">
            <h3 class="main-flex-heading">Heads</h3>
            <span class="strip-bg cell-padding">Number of Resources</span>
            <span class="cell-padding">Min. wages</span>
            <span class="strip-bg cell-padding">Allowances EPF</span>
            <span class="cell-padding">EPF Wages/ month</span>
            <span class="strip-bg cell-padding">Non EPF Allownaces/ month</span>
            <span class="cell-padding">Gross</span>
            <span class="strip-bg cell-padding">EPF @13%</span>
            <span class="cell-padding">ESIC @ 3.25% if gross 21k</span>
            <span class="strip-bg cell-padding">Bonus @ 8.33%</span>
            <span class="cell-padding">Others</span>
            <span class="strip-bg cell-padding">CTC</span>
            <span class="cell-padding">Total</span>
        </div>
        <div class="flex-item">
            <h3 class="main-flex-heading">Formula</h3>
            <span class="strip-bg formula-text">A</span>
            <span class=" formula-text">B</span>
            <span class="strip-bg formula-text">C</span>
            <span class="formula-text">D = B + C</span>
            <span class="strip-bg formula-text">E</span>
            <span class="formula-text">F = D + E</span>
            <span class="strip-bg formula-text">G = D * 13%</span>
            <span class="formula-text">H = F * 3.25%</span>
            <span class="strip-bg formula-text">I = B * 8.33% or 7000 * 8.33% (if B < 7000)</span>
            <span class="formula-text">J = Label + value in rs.</span>
            <span class="strip-bg formula-text">K = F + G + H + I + J</span>
            <span class="formula-text">L = A * K</span>
        </div>

        @if(!empty($noOfDesignations) && $noOfDesignations > 0)
          @for($i = 0; $i < $noOfDesignations; $i++)
            <div class="flex-item item-container @if($i == 0)itemToBeCloned @endif">
              <div class="input-heading-box">
                <input type="text" name="project_scope[resource_name][]" class="input-heading required_inputs" id="" placeholder="Resource" required>
              </div>
              <div class="input-strip">
                <input type="number" name="project_scope[no_of_resources][]" id="" class="no-of-resources cell-padding required_inputs" onkeyup="calculateSep1($(this))" min="0" required>
              </div>
              <div>
                <input type="number" name="project_scope[min_wages][]" id="" class="min-wages cell-padding required_inputs" onkeyup="calculateSep1($(this))" min="0" required>
              </div>
              <div class="input-strip">
                <input type="number" name="project_scope[allowance_epf][]" id="" class="epf required_inputs" onkeyup="calculateSep1($(this))" min="0" required>
              </div>
              <div>
                <input type="number" name="project_scope[epf_wages_per_month][]" id="" class="epf-wages cell-padding r-inputs" onkeyup="calculateSep1($(this))" min="0" readonly>
              </div>
              <div class="input-strip">
                <input type="number" name="project_scope[non_epf_allowance][]" id="" class="non-epf required_inputs" onkeyup="calculateSep1($(this))" min="0" required>
              </div>
              <div>
                <input type="number" name="project_scope[gross][]" id="" class="gross cell-padding r-inputs" onkeyup="calculateSep1($(this), 'gross')" min="0" readonly>
              </div>
              <div class="input-strip">
                <input type="number" name="project_scope[epf_13][]" id="" class="epf-13 r-inputs" onkeyup="calculateSep1($(this), 'epf')" min="0" readonly>
              </div>
              <div>
                <input type="number" name="project_scope[esic_325][]" id="" class="esic cell-padding r-inputs" onkeyup="calculateSep1($(this), 'esic')" min="0" readonly>
              </div>
              <div class="input-strip">
                <input type="number" name="project_scope[bonus_833][]" id="" class="bonus833 r-inputs" onkeyup="calculateSep1($(this), 'bonus833')" min="0" readonly>
              </div>
              <div>
                <input type="number" name="project_scope[others][]" id="" class="otherss cell-padding required_inputs" onkeyup="calculateSep1($(this), 'others')" min="0" required>
              </div>
              <div class="input-strip">
                <input type="number" name="project_scope[ctc][]" id="" class="ctc r-inputs" onkeyup="calculateSep1($(this), 'ctc')" min="0" readonly>
              </div>
              <div>
                <input type="number" name="project_scope[total][]" id="" class="total-1 cell-padding r-inputs" onkeyup="calculateSep1($(this), 'total')" min="0" readonly>
              </div>
            </div>
          @endfor
        @endif
      </div>
      <div class="add-remove-box">
        <button type="button" class="btn btn-primary add-flex-item action-btn">Add</button>
        <button type="button" class="btn btn-danger delete-flex-item action-btn">Delete</button>
      </div>
    </section>
    <!--Project Financial Scope Ends Here-->
    <!--Results Section Starts Here-->
    <section class="section_results">
      <div class="flex-container">
        <div class="flex-item">
            <h3 class="main-flex-heading">Results</h3>
            <span class="strip-bg cell-padding">Total number of HRs</span>
            <span class="cell-padding">Monthly turnover</span>
            <span class="strip-bg cell-padding">Anuual Gross Wages (Tenure = 12 Months)</span>
            <span class="cell-padding">Tenure in Months</span>
            <span class="strip-bg cell-padding">Tenure Gross Wages (Tenure = 24 Months)</span>
        </div>
        <div class="flex-item">
            <h3 class="main-flex-heading">Formula</h3>
            <span class="strip-bg formula-text">M=A1+A2+A3+A4+....</span>
            <span class="formula-text">N=L1+L2+L3+L4+....</span>
            <span class="strip-bg formula-text">O=N*12</span>
            <span class="formula-text">P</span>
            <span class="strip-bg formula-text">Q=N*P</span>
        </div>
        <div class="flex-item">
          <h3 class="main-flex-heading">Values</h3>
          <div class="input-strip">
            <input type="number" name="cost_estimation[total_number_of_hr]" id="total-number-of-resources" class="total-no-of-resources cell-padding r-inputs" onkeyup="calculateSep1($(this))" min="0" readonly>
          </div>
          <div>
            <input type="number" name="cost_estimation[monthly_turnover]" id="" class="monthly_turnover cell-padding r-inputs" onkeyup="calculateSep1($(this))" min="0" readonly>
          </div>
          <div class="input-strip">
            <input type="number" name="cost_estimation[annual_gross]" id="annual-gross" class="r-inputs" onkeyup="calculateSep1($(this))" min="0" readonly>
          </div>
          <div>
            <input type="number" name="cost_estimation[tenure_in_month]" id="tenure-in-month" class="cell-padding required_inputs" onkeyup="calculateSep1($(this))" min="0" required>
          </div>
          <div>
            <input type="number" name="cost_estimation[tenure_gross_wages]" id="tenure-gross-wages" class="cell-padding r-inputs" onkeyup="calculateSep1($(this))" min="0" readonly>
          </div>
        </div>
      </div>
    </section>
    <!--Results Section Ends Here-->
    <!--Cost Factors Starts Here-->
    <hr>
    <section>
      <h2 class="sub-heading">Cost Factors</h2>
      <div style="padding: 10px;">
        <table>
          <thead>
            <tr>
              <th>Select</th>
              <th>Costs</th>
              <th>Value(R)</th>
              <th>Multiplier(S)</th>
              <th>Total <br/> (T = R * S)</th>
              <th>MI / Tenure  <br/> (T / P)</th>
              <th>CI per Unit</th>
              <th>Cap / Op</th>
              <th>Attach Excel</th>
              <th>Comments</th>
            </tr>
          </thead>
          <tbody class="cost-factor-tbody">
            @if(!empty($costFactorOptions))
              @foreach($costFactorOptions as $key => $option)
                <tr class="factors-tr">
                  <td style="text-align: center;">
                    <input type="checkbox" name="cost_factor_details[record][]" class="cost-factor-check cost_option_id" value="{!! $key !!}">
                    <input type="hidden" name="cost_factor_details[option_id][]" class="option_id">
                  </td>
                  <td>
                    @if($key != 30)
                      <span class="formula-text cf-long-text">{!! $option !!}</span>
                    @else
                      <input type="text" name="cost_factor_details[operational_costs][]" id="" class="td-inputs cost_inputs" value="{!! $option !!}">
                    @endif
                  </td>
                  <td>
                    <input type="number" name="cost_factor_details[cost_factor_value][]" id="" class="cf-value td-inputsss cost_inputs" onkeyup="costFactorCal($(this))" min="0">
                  </td>
                  <td>
                    <input type="number" name="cost_factor_details[cost_factor_multiplier][]" id="" class="cf-multiplier td-inputsss cost_inputs" onkeyup="costFactorCal($(this))" min="0">
                  </td>
                  <td>
                    <input type="number" name="cost_factor_details[cost_factor_total][]" id="" class="cf-row-total td-inputsss total_input r-inputs" min="0" readonly>
                  </td>
                  <td>
                    <input type="number" name="cost_factor_details[monthly_impact_by_tenure][]" id="" class="cf-row-total td-inputsss mi-by-t r-inputs" min="0" readonly>
                  </td>
                  <td>
                    <input type="number" name="cost_factor_details[cost_impact_per_unit][]" id="" class="cf-row-total td-inputsss ci-per-unit r-inputs" min="0" readonly>
                  </td>
                  <td>
                    <select name="cost_factor_details[capital_operational_expense][]" class="expense-type-style cost_inputs" id="">
                      @if(!empty($costFactorTypeOptions))
                        @foreach($costFactorTypeOptions as $typeIdkey => $costFactorType)
                          <option value="{!! $typeIdkey !!}">{!! $costFactorType !!}</option>
                        @endforeach
                      @endif
                    </select>
                  </td>
                  <td>
                    <input type="file" name="cost_factor_details[cost_factor_file][]" class="choose-file-style cost_inputs" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                  </td>
                  <td>
                    <textarea name="cost_factor_details[cost_factor_comment][]" id="" cols="15" rows="2" class="cf-comments cost_inputs"></textarea>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4" style="text-align: center">Total Amount</th>
              <th style="padding: 0px;">
                <input type="number" name="cost_factors[total_cost_factor_amount]" id="total-sum-amount" class="cf-row-total td-inputsss r-inputs subTotal1" min="0" readonly>
              </th>
              <th style="padding: 0px;">
                <input type="number" name="cost_factors[total_cost_factor_monthly_tenure]" id="total-mi-tenure" class="cf-row-total td-inputsss r-inputs subTotal1" min="0" readonly>
              </th>
              <th style="padding: 0px;">
                <input type="number" name="cost_factors[total_cost_impact_per_unit]" id="total-ci-per-unit" class="cf-row-total td-inputsss r-inputs subTotal1" min="0" readonly>
              </th>
              <th colspan="3"></th>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="add-remove-box">
        <button type="button" class="btn btn-primary add-row action-btn">Add Row</button>
        <button type="button" class="btn btn-danger delete-row action-btn">Delete Row</button>
      </div>
    </section>
    <!--Cost Factors Ends Here-->
    <!--Revenue Starts Here-->
    <hr>
    <section>
      <h2 class="sub-heading">Revenue</h2>
      <div class="flex-container col-revenue">
        <div class="flex-item">
          <h3 class="main-flex-heading">Revenue Heads</h3>
          <span class="strip-bg cell-padding">Service Charge</span>
          <span class="cell-padding">Recruitment fee</span>
          <span class="strip-bg cell-padding">Income from Refundable Security deposit</span>
          <span class="cell-padding">Application fees</span>
          <span class="strip-bg cell-padding">Other</span>
          <span class="cell-padding">Total</span>
        </div>
        <div class="flex-item">
          <h3 class="main-flex-heading">Rate (% / Value)(R)</h3>
          <div class="input-strip text-center">
            <input type="number" name="revenue[service_charge_rate]" id="" class="cell-padding rev1 rev-rate" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="text-center">
            <input type="number" name="revenue[recruitment_fee_rate]" id="" class="cell-padding rev2 rev-rate" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="input-strip text-center">
            <input type="number" name="revenue[refundable_security_deposit_rate]" id="" class="rev3 rev-rate" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="text-center">
            <input type="number" name="revenue[application_fees_rate]" id="" class="cell-padding rev4 rev-rate" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="input-strip text-center">
            <input type="number" name="revenue[other_revenue_rate]" id="" class="cell-padding rev5 rev-rate" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="text-center">
            <input type="number" name="revenue[total_revenue_rate]" id="" class="cell-padding r-inputs rev6 rev-rate-total" onkeyup="revenue($(this))" min="0" readonly>
          </div>
        </div>
        <div class="flex-item">
          <h3 class="main-flex-heading">Multiplier(S)</h3>
          <div class="input-strip">
            <input type="number" name="revenue[service_charge_multiplier]" id="" class="cell-padding rev7 rev-multiplier" onkeyup="revenue($(this))" min="0">
          </div>
          <div>
            <input type="number" name="revenue[recruitment_fee_multiplier]" id="" class="cell-padding rev8 rev-multiplier" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="input-strip">
            <input type="number" name="revenue[refundable_security_deposit_multiplier]" id="" class="rev9 rev-multiplier" onkeyup="revenue($(this))" min="0">
          </div>
          <div>
            <input type="number" name="revenue[application_fees_multiplier]" id="" class="cell-padding rev10 rev-multiplier" onkeyup="revenue($(this))" min="0">
          </div>
          <div>
            <input type="number" name="revenue[other_revenue_multiplier]" id="" class="cell-padding rev11 rev-multiplier" onkeyup="revenue($(this))" min="0">
          </div>
          <div>
            <input type="number" name="revenue[total_revenue_multiplier]" id="" class="cell-padding r-inputs rev12 rev-multiplier-total" onkeyup="revenue($(this))" min="0" readonly>
          </div>
        </div>
        <div class="flex-item">
          <h3 class="main-flex-heading">Monthly Revenue(R*S)</h3>
          <div class="input-strip text-center">
            <input type="number" name="revenue[service_charge_monthly_revenue]" id="" class="cell-padding r-inputs rev13 monthly-revenue" onkeyup="revenue($(this))" min="0" readonly>
          </div>
          <div class="text-center">
            <input type="number" name="revenue[recruitment_fee_monthly_revenue]" id="" class="cell-padding r-inputs rev14 monthly-revenue" onkeyup="revenue($(this))" min="0" readonly>
          </div>
          <div class="input-strip text-center">
            <input type="number" name="revenue[refundable_security_deposit_monthly_revenue]" id="annual-gross" class="r-inputs rev15 monthly-revenue" onkeyup="revenue($(this))" min="0" readonly>
          </div>
          <div class="text-center">
            <input type="number" name="revenue[application_fees_monthly_revenue]" id="" class="cell-padding r-inputs rev16 monthly-revenue" onkeyup="revenue($(this))" min="0">
          </div>
          <div class="input-strip text-center">
            <input type="number" name="revenue[other_monthly_revenue]" id="" class="cell-padding r-inputs rev17 monthly-revenue" onkeyup="revenue($(this))" min="0" readonly>
          </div>
          <div class="text-center">
            <input type="number" name="revenue[total_monthly_revenue]" id="" class="cell-padding r-inputs rev18 total-monthly-revenue" onkeyup="revenue($(this))" min="0" readonly>
          </div>
        </div>
      </div>
    </section>
    <!--Revenue Ends Here-->
    <!--Capital Expenses Starts Here-->
    <hr>
    <section>
      <!-- <h2 class="sub-heading">Capital Expenses</h2> -->
      <div class="col-md-6">
        <div class="form-group">
          <h2 class="sub-heading">Capital Expenses</h2>
          <div class="flex-container">
            <div class="flex-item"> <h3 class="main-flex-heading">Total Capital Expenses</h3> </div>
            <div class="flex-item">
              <div class="text-center">
                <input type="number" name="total_capital_expense" id="total-capital-expense" class="input-heading cell-padding r-inputs" min="0" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <h2 class="sub-heading">Operational Investment</h2>
          <div class="flex-container">
            <div class="flex-item"> <h3 class="main-flex-heading">Total Operational Investment</h3> </div>
            <div class="flex-item">
              <div class="text-center">
                <input type="number" name="total_operational_expense" id="total-operational-expense" class="input-heading cell-padding r-inputs" min="0" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </section>
    <!--Capital Expenses Ends Here-->
    <!--Operational Investment Starts Here-->
    <hr>
    <section>
      <h2 class="sub-heading">Total Expense</h2>
      <div class="flex-container">
        <div class="flex-item"> <h3 class="main-flex-heading">(Q + Capital Expenses + Operational Investment)</h3> </div>
        <div class="flex-item">
          <div class="text-center">
            <input type="number" name="total_expense" id="total_expense" class="input-heading cell-padding r-inputs" min="0" readonly>
          </div>
        </div>
      </div>
    </section>
    <!--  ---------------------------------------------------- -->
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="form-group">
              <div class="col-md-12">
                <label for="comments" class="control-label">Comments:</label>

                <div class="comments_div">
                  @php
                    $comments = old('comments');
                  @endphp
                  <textarea name="comments" id="comments" cols="30" rows="3" class="form-control">{{$comments}}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!--  ---------------------------------------------------- -->
    <!-- <section>
      <h2 class="sub-heading">Operational Investment</h2>
      <div class="flex-container">
        <div class="flex-item"> <h3 class="main-flex-heading">Total Operational Investment</h3> </div>
        <div class="flex-item">
          <div class="input-strip text-center">
            <input type="number" name="total_operational_expense" id="total-operational-expense" class="input-heading cell-padding r-inputs" min="0" readonly>
          </div>
        </div>
      </div>
    </section> -->
    <!--Operational Investment Ends Here-->
    <div class="add-remove-box">
      <button type="submit" class="btn btn-warning form-draft-btn" id="save_as_draft">Save As Draft</button>
      <button type="submit" class="btn btn-success action-btn" id="save">Final Submit</button>
    </div>
  </form>
</div>

<div class="loading hide">Loading&#8230;</div>

<!--Main outer container ends here-->
<script src="{!! asset('public/admin_assets/plugins/validations/jquery.validate.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/validations/additional-methods.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>

<script>
$(document).ready(function() {
  $("div.alert-dismissible").fadeOut(6000);

  $(document).on('click', '.add-row', function() {
    var table_row = '<tr class="factors-tr"><td style="text-align: center;"><input type="checkbox" name="cost_factor_details[record][]" class="cost-factor-check cost_option_id" value="{!! array_key_last($costFactorOptions) !!}"><input type="hidden" name="cost_factor_details[option_id][]" class="option_id"></td><td><input type="text" name="cost_factor_details[operational_costs][]" id="" class="td-inputs cost_inputs" value="{!! end($costFactorOptions) !!}"></td><td><input type="number" name="cost_factor_details[cost_factor_value][]" id="" class="cf-value td-inputsss" onkeyup="costFactorCal($(this))" min="0"></td><td><input type="number" name="cost_factor_details[cost_factor_multiplier][]" id="" class="cf-multiplier td-inputsss" onkeyup="costFactorCal($(this))" min="0"></td><td><input type="number" name="cost_factor_details[cost_factor_total][]" id="" class="cf-row-total td-inputsss total_input r-inputs qty1" min="0" readonly></td><td><input type="number" name="cost_factor_details[monthly_impact_by_tenure][]" id="" class="cf-row-total td-inputsss mi-by-t r-inputs" min="0" readonly></td><td><input type="number" name="cost_factor_details[cost_impact_per_unit][]" id="" class="cf-row-total td-inputsss total_input r-inputs" min="0" readonly></td><td>'+ '<select name="cost_factor_details[capital_operational_expense][]" class="expense-type-style" id="">'+ '<?php foreach($costFactorTypeOptions as $typeIdkey => $costFactorType) {?>'+ '<option value="{!! $typeIdkey !!}">{!! $costFactorType !!}</option>'+ '<?php } ?>'+ '</select></td><td><input type="file" class="choose-file-style" name="cost_factor_details[cost_factor_file][]" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"></td><td><textarea name="cost_factor_details[cost_factor_comment][]" id="" class="cf-comments" cols="15" rows="2"></textarea></td></tr>';

    $("table tbody.cost-factor-tbody").append(table_row);
  });

  // Find and remove selected table rows
  $(document).on('click', '.delete-row', function() {
    $("table tbody").find('input.cost_option_id').each(function(){
      if($(this).is(":checked")){
        $(this).parents("tr").remove();
      }
    });
  });

  $(document).on("change", ".expense-type-style", function() {
    calculateExpense();
  });

  $(document).on("click", ".cost-factor-check", function() {

    var parent_tr = $(this).parents(".factors-tr");
    var input_type_number = parent_tr.find(':input[type="number"]');
    var dropdown = parent_tr.find(".expense-type-style");
    var costFactorVal = $(this).val();

    if($(this).is(":checked")) {

      /*if(input_type_number.length > 0) {
        input_type_number.each(function() {
          $(this).prop("required", true);
        });
      }
      dropdown.prop("required", true);*/
      $(this).next('.option_id').val(costFactorVal);
    }
    else {

      /*if(input_type_number.length > 0) {
        input_type_number.each(function() {
          $(this).prop("required", false);
        });
      }
      dropdown.removeAttr("required");*/
      $(this).next('.option_id').val('');
    }

    calculateExpense();
    validateInputs();
  });

  $(document).on('click', '.add-flex-item', function() {
    var clonedHtml = $(".itemToBeCloned").clone();
    clonedHtml.find('input').val('');
    clonedHtml.find('span.error').remove();
    clonedHtml     = $(clonedHtml).removeClass('itemToBeCloned');
    $('.flex_container_to_append').append(clonedHtml);
  });

  $(document).on('click', '.delete-flex-item', function() {
    var containerLength = $(".item-container").length;

    if(containerLength != 'undefined' && containerLength > 1) {
      $('.flex_container_to_append').find('.item-container').last().remove();
    } else {
      $.toast({
        heading: 'Error',
        text: 'You have reached the minimum limit, Can\'t delete the last node.',
        showHideTransition: 'plain',
        icon: 'error',
        hideAfter: 3000,
        position: 'top-right',
        stack: 3,
        loader: true,
        loaderBg: '#b50505',
      });
      return false;
    }
  });

  $(document).on('click', '#save_as_draft', function(event) {
    event.preventDefault(); event.stopPropagation();
    saveAsDraft();
  });

  $.validator.prototype.checkForm = function() {
    //overriden in a specific page
    this.prepareForm();
    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
      if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
        for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
          this.check(this.findByName(elements[i].name)[cnt]);
        }
      } else {
        this.check(elements[i]);
      }
    }
    return this.valid();
  };

  var validator = $('#cost_form').validate({
    ignore: ':hidden,input[type=hidden],.select2-search__field', //  [type="search"]
    errorElement: 'span',
    // debug: true,
    errorPlacement: function(error, element) { // the errorPlacement has to take the table layout into account
      // $(element).attr('name')
      if (element.parent().attr('class') == 'input-group') {
        error.appendTo(element.parent().parent());
      }
      else {
        error.appendTo(element.parent()); // element.parent().next()
      }
    },
  });

  validateInputs();

  $(document).on('click', 'button#save', function(event) {
    event.preventDefault(); event.stopPropagation();

    if($('#cost_form').valid()) {
      saveCostForm();
    } else {
      validator.focusInvalid();
    }
  });

});

function validateInputs()
{
  $('input.required_inputs').each(function(k, v) {
    $(this).rules('add', {
      required: true,
    });
  });

  $('.cost_inputs').each(function(key, input) {
    if($(input).parents().eq(1).find('.cost-factor-check').is(':checked')) {
      $(input).not('.has_file').attr('required', true);
    } else {
      $(input).removeAttr('required').removeClass('error');
    }
  });
}

function saveCostForm()
{
  swal({
    title: "Are you sure?",
    text: "You want to save this record, you will not be able to edit this.",
    icon: "info",
    buttons: {
      cancel: {
        text: "Cancel",
        value: null,
        visible: true,
        className: "btn btn-default",
        closeModal: true,
      },
      confirm: {
        text: "Yes",
        value: true,
        visible: true,
        className: "btn btn-success",
        closeModal: true
      }
    },
  }).then(function(isConfirm) {
    if (isConfirm) {
      $('#comments').attr('required', true);
      $('input[name="is_complete"]').val(1);
      $('#cost_form').submit();
    } else {
      $('#comments').removeAttr('required');
      $('input[name="is_complete"]').val(0);
    }
  });
}

function saveAsDraft()
{
  $('#comments').removeAttr('required');
  if($('input.required_inputs').valid())
  {
    var form_data = new FormData($('#cost_form')[0]);
    form_data.append("skip_validation", 1);

    $.ajax({
      url: $('#cost_form').attr('action'),
      type: "POST",
      data: form_data,
      dataType: 'json',
      contentType: false,
      processData: false,
      beforeSend: function() {
        // setting a timeout
        $('div.loading').removeClass('hide');
      },
      success: function (res) {

        console.log(res);
        if(res.status == 1) {

          swal({
            title: "Success",
            text: res.msg,
            icon: "success",
            buttons: [ 'Cancel', 'OK' ],
            closeOnClickOutside: false,
            closeOnEsc: false,
          }).then(function(isConfirm) {
            if (isConfirm) {
              window.location.reload();
            }
          });
        } else {
          swal("Error:", res.msg, "error");
        }

        $('div.loading').addClass('hide');
      },
      error: function (xhr, ajaxOptions, thrownError) {
        var xhrRes = xhr.responseJSON;

        if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
          swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
        } else {
          swal("Error creating cost estimation!", "Please try again", "error");
        }
        $('div.loading').addClass('hide');
      }
    });
  } else {
    if(!$('.section_project_scope input.required_inputs').valid()) {
      $('html, body').animate({scrollTop:$('.section_project_scope').offset().top - 70}, 'slow');
    } else if(!$('.section_results input.required_inputs').valid()) {
      $('html, body').animate({scrollTop:$('.section_results').offset().top - 70}, 'slow');
    }
  }
}

function calculateSep1(obj, str) {
  var bonus       = 0;

  var flexItemObj = obj.parents(".flex-item");
  var min_wages   = Number(flexItemObj.find('.min-wages').val()).toFixed(2);
  var epf         = Number(flexItemObj.find('.epf').val()).toFixed(2);
  var epf_wages   = (Number(min_wages) + Number(epf));
  epf_wages       = isNaN(epf_wages)? 0 : Number(epf_wages).toFixed(2);

  flexItemObj.find('.epf-wages').val(epf_wages);

  var non_epf     = Number(flexItemObj.find('.non-epf').val()).toFixed(2);
  var gross       = (Number(epf_wages) + Number(non_epf));
      gross       = isNaN(gross)? 0 : Number(gross).toFixed(2);

  flexItemObj.find('.gross').val(gross);

  var epf_13      = (Number(epf_wages)*Number(13)/100).toFixed(2);
      epf_13      = isNaN(epf_13)? 0 : Number(epf_13).toFixed(2);
  flexItemObj.find('.epf-13').val(epf_13);

  var esic        = (Number(gross) * Number(3.25)/100);

  flexItemObj.find('.esic').val(esic);

  if (min_wages < 7000) {
    bonus = (Number(7000) * Number(8.33)/100);
  }
  else {
    bonus = (Number(min_wages) * Number(8.33)/100);
  }

  bonus  = isNaN(bonus)? 0 : Number(bonus).toFixed(2);

  flexItemObj.find('.bonus833').val(bonus);

  var otherss   = Number(flexItemObj.find('.otherss').val());
  otherss       = isNaN(otherss)? 0 : Number(otherss).toFixed(2);

  var ctc       = (Number(gross) + Number(epf_13) + Number(esic) + Number(bonus) + Number(otherss));
  ctc           = isNaN(ctc)? 0 : Number(ctc);

  flexItemObj.find('.ctc').val(ctc.toFixed(2));

  var no_of_resources = Number(flexItemObj.find('.no-of-resources').val());
  var total_1         = Number(no_of_resources) * Number(ctc);
      total_1         = isNaN(total_1)? 0 : Number(total_1).toFixed(2);

  flexItemObj.find('.total-1').val(total_1);

  monthly_turnover = resources_count = 0;

  $(".item-container").each(function() {
    var this_count = Number($(this).children().find(".no-of-resources").val());
    if(this_count>0) {
      resources_count = Number(resources_count) + Number(this_count);
    }

    var sum_total_1 = Number($(this).children().find(".total-1").val());

    if(sum_total_1>0) {
      monthly_turnover = Number(monthly_turnover) + Number(sum_total_1);
    }
  });

  $(".monthly_turnover").val(monthly_turnover.toFixed(2));
  $(".total-no-of-resources").val(resources_count.toFixed(2));

  var annual_gross  =  Number(monthly_turnover) * Number(12);
  $('#annual-gross').val(annual_gross.toFixed(2));

  var tenure_in_month    = $("#tenure-in-month").val();
  var tenure_gross_wages = Number(tenure_in_month) * Number(monthly_turnover);
  $("#tenure-gross-wages").val(tenure_gross_wages.toFixed(2));


  $('.cost-factor-tbody input[type="checkbox"]').each(function() {
    if($(this).is(':checked')) {
      var _objR  = $(this).parents('.factors-tr').find('.cf-value');
      costFactorCal(_objR);
    }
  });
  calculateExpense();
}

function costFactorCal(obj) {
  var factors_tr    = obj.parents(".factors-tr");
  var cf_value      = Number(factors_tr.find('.cf-value').val()).toFixed(2);
  var cf_multiplier = Number(factors_tr.find('.cf-multiplier').val()).toFixed(2);
  var cf_row_total  = Number(cf_value * cf_multiplier).toFixed(2);
      cf_row_total  = isNaN(cf_row_total)? 0.00 : Number(cf_row_total).toFixed(2);

  obj.parent().parent().find('input.total_input').val(cf_row_total);

  var tenure_in_month = Number($("#tenure-in-month").val()).toFixed(2);
  var monthly_tenure_by_tenure = Number(cf_row_total / tenure_in_month).toFixed(2);

  obj.parent().parent().find('input.mi-by-t').val(monthly_tenure_by_tenure);

  var total_number_of_resources = Number($("#total-number-of-resources").val()).toFixed(2);
  var ci_per_unit = Number(cf_row_total / total_number_of_resources).toFixed(2);

  obj.parent().parent().find('input.ci-per-unit').val(ci_per_unit);

  var total_sum_amount = 0, total_mi_tenure = 0, total_ci_per_unit = 0;
  $(".total_input").each(function(index) {
    if($(this).val()) {
      total_sum_amount = Number(total_sum_amount) + Number($(this).val());
    }
  });

  $("#total-sum-amount").val(Number(total_sum_amount).toFixed(2));

  $(".mi-by-t").each(function(index) {
    if($(this).val()) {
      total_mi_tenure = Number(total_mi_tenure) + Number($(this).val());
    }
  });

  $("#total-mi-tenure").val(Number(total_mi_tenure).toFixed(2));

  $(".ci-per-unit").each(function(index) {
    if($(this).val()) {
      total_ci_per_unit = Number(total_ci_per_unit) + Number($(this).val());
    }
  });
  $("#total-ci-per-unit").val(Number(total_ci_per_unit).toFixed(2));
  calculateExpense();
}

function revenue(rev) {
  var col_revenue = rev.parents(".col-revenue");
  var rev1  = Number(col_revenue.find(".rev1").val()).toFixed(2);
  var rev2  = Number(col_revenue.find(".rev2").val()).toFixed(2);
  var rev3  = Number(col_revenue.find(".rev3").val()).toFixed(2);
  var rev4  = Number(col_revenue.find(".rev4").val()).toFixed(2);
  var rev5  = Number(col_revenue.find(".rev5").val()).toFixed(2);
  //var rev6 = Number(col_revenue.find(".rev6").val()).toFixed(2);
  var rev7  = Number(col_revenue.find(".rev7").val()).toFixed(2);
  var rev8  = Number(col_revenue.find(".rev8").val()).toFixed(2);
  var rev9  = Number(col_revenue.find(".rev9").val()).toFixed(2);
  var rev10 = Number(col_revenue.find(".rev10").val()).toFixed(2);
  var rev11 = Number(col_revenue.find(".rev11").val()).toFixed(2);
  //var rev12 = Number(col_revenue.find(".rev12").val().toFixed(2));

  var rev13 = Number(rev1 * rev7).toFixed(2);
  var rev14 = Number(rev2 * rev8).toFixed(2);
  var rev15 = Number(rev3 * rev9).toFixed(2);
  var rev16 = Number(rev4 * rev10).toFixed(2);
  var rev17 = Number(rev5 * rev11).toFixed(2);
  //var rev18 = Number(rev6 * rev12).toFixed(2);

  rev13 = isNaN(rev13)? 0.00 : Number(rev13).toFixed(2);
  rev14 = isNaN(rev14)? 0.00 : Number(rev14).toFixed(2);
  rev15 = isNaN(rev15)? 0.00 : Number(rev15).toFixed(2);
  rev16 = isNaN(rev16)? 0.00 : Number(rev16).toFixed(2);
  rev17 = isNaN(rev17)? 0.00 : Number(rev17).toFixed(2);
  //rev18 = isNaN(rev18)? 0.00 : Number(rev18).toFixed(2);

  $(".rev13").val(rev13);
  $(".rev14").val(rev14);
  $(".rev15").val(rev15);
  $(".rev16").val(rev16);
  $(".rev17").val(rev17);
  //$(".rev18").val(rev18);

  var rev_rate_total = 0, rev_multiplier_total = 0, total_monthly_revenue = 0;
  $(".rev-rate").each(function() {
    if($(this).val()) {
      rev_rate_total = Number(rev_rate_total) + Number($(this).val());
    }
  });
  rev_rate_total = isNaN(rev_rate_total)? 0.00 : Number(rev_rate_total).toFixed(2);
  $(".rev-rate-total").val(rev_rate_total);

  $(".rev-multiplier").each(function() {
    if($(this).val()) {
      rev_multiplier_total = Number(rev_multiplier_total) + Number($(this).val());
    }
  });
  rev_multiplier_total = isNaN(rev_multiplier_total)? 0.00 : rev_multiplier_total;
  $(".rev-multiplier-total").val(Number(rev_multiplier_total).toFixed(2));

  $(".monthly-revenue").each(function() {
    if($(this).val()) {
      total_monthly_revenue = Number(total_monthly_revenue) + Number($(this).val());
    }
  });
  total_monthly_revenue = isNaN(total_monthly_revenue)? 0.00 : total_monthly_revenue;
  $(".total-monthly-revenue").val(Number(total_monthly_revenue).toFixed(2));
}

function calculateExpense() {
  var capx = 0, opx = 0;
  $(".expense-type-style").each(function(k, v) {

    if($(v).parents().eq(1).find('.cost-factor-check').is(':checked')) {

      if($(this).val() == 1) {
        capx = Number(capx) + Number($(this).parents(".factors-tr").find(".total_input").val());
      } else if ($(this).val() == 2) {
        opx = Number(opx) + Number($(this).parents(".factors-tr").find(".total_input").val());
      }
    }
  });
  $("#total-capital-expense").val(capx);
  $("#total-operational-expense").val(opx);
  var tenure_gross_wages = $('#tenure-gross-wages').val();
  var total_expense = Number(tenure_gross_wages) + Number(capx) + Number(opx);
  $("#total_expense").val(total_expense.toFixed(2));
}
</script>
</body>
</html>