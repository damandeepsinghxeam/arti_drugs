@extends('admins.layouts.app')

@section('content')

<style>
  .select2-container .select2-selection--single {
    height: 30px;
    border: 1px solid #d2d6de;
    box-shadow: 0px 1px 2px lightgrey;
    font-size: 12px;
    padding: 5px 0px;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<!-- Bootstrap time Picker -->
<link href="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="text-center">
      Travel Approval Form
    </h1>
    <ol class="breadcrumb breadcrumb-leave-change">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        @include('admins.validation_errors')
        <div class="box box-primary">
          <div class="box-header with-border leave-form-title-bg">
            <h3 class="box-title">Approval Form</h3>
            <span class="pull-right"></span>
          </div>

          <form id="travelApprovalForm" action="" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body form-sidechange form-decor">
              <!-- Time input section stasts here -->
              <legend>Travel Request Form</legend>
                <!-- Travel type section stasts here -->
              <div class="travelTypeBox hide">
                <div class="btn-group apply-leave-btn-all">
                  <button type="button" id="local_travel" class="btn btn-primary select_local select_travel_type">Local</button>
                  <button type="button" class="btn btn-primary select_national select_travel_type">National</button>
                </div>
                <input type="hidden" name="travel_type" value="2">
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                    <label class="apply-leave-label">Purpose<span style="color: red">*</span></label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" name="purpose_pre" class="form-control" value="{{ $travel->travel_purpose }}" required autocomplete="off" placeholder="Enter your purpose for travel">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                    <label class="apply-leave-label">Travel Categories<span style="color: red">*</span></label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <select name="category_id" id="category_id" class="form-control select2 input-sm basic-d0etail-input-style categories" required>
                        <option value="">Select Categories</option>
                        @if($data['categories']->count())
                          @foreach($data['categories'] as $category)
                            @php
                              $categorySelect = ($travel->category_id == $category->id)? 'selected':null;
                            @endphp
                            <option value="{{$category->id}}" {{$categorySelect}}>{{$category->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
              </div>
              @php
                $travelForDivHide = 'hide';
                if(in_array($travel->travel_category->name, ['BD', 'SD'])) {
                  $travelForDivHide = null;
                }
              @endphp
              <div class="form-group travel_for_div {{$travelForDivHide}}">
                <div class="row">
                  <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                    <label class="apply-leave-label">Travel for<span style="color: red">*</span></label>
                  </div>

                  <div class="col-md-6 leave-input-box travel-input-box-client">
                    <label class="radio-inline">
                      <input type="radio" name="isclient" class="customer_type_selection" value="1" required @if($travel->travel_for == 1) checked @endif> Existing Client
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="isclient" class="customer_type_selection" value="2" required @if($travel->travel_for == 2) checked @endif> Prospect
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="isclient" class="customer_type_selection" value="3" required @if($travel->travel_for == 3) checked @endif> Others
                    </label>
                  </div>

                  <div class="col-md-4 leave-input-box travel_customerss">
                    <div class="for_existing_customer @if($travel->travel_for != 1) hide @endif">
                      <select name="existing_customer" id="existing_customer" class="form-control select2 input-sm basic-detail-input-style"><!-- data-placeholder="Existing Client" -->
                        <option value="">Select Existing Client</option>
                        @if($data['projects']->count())
                          @foreach($data['projects'] as $project)
                            @php
                              $pSelected = (@$travel->project->id == $project->id)? 'selected' : null;
                            @endphp
                            <option value="{{$project->id}}" {{$pSelected}}>{{$project->name}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="for_future_customer @if($travel->travel_for != 2) hide @endif">
                      <select name="future_customer" id="future_customer" class="form-control select2 input-sm basic-detail-input-style"><!-- data-placeholder="Prospect" -->
                        <option value="">Select Prospect</option>
                        @if($data['new_projects']->count())
                          @foreach($data['new_projects'] as $newProject)
                            @php
                              $project = $newProject->lead->name_of_prospect;
                              $prospectLength = strlen($project);
                              if($prospectLength > 20) {
                                $project = substr($project, 0, 20).'....'.$newProject->til_code;
                              }

                              $tSelected = (@$travel->tils->id == $newProject->id)? 'selected' : null;
                            @endphp
                            <option value="{{$newProject->id}}" {{$tSelected}}>{{ $project }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>

                    <div class="other_customers @if($travel->travel_for != 3) hide @endif">
                      <input type="text" name="local_others" id="local_others" class="form-control input-sm basic-detail-input-style" value="{{$travel->others}}" placeholder="Enter your other Purpose">
                      <!-- <textarea class="form-control other_purpose_description" name="" id="" placeholder="Enter your other Purpose"></textarea> -->
                    </div>
                  </div>
                </div>
              </div>

              <!-- local section starts here -->
              <div class="local_travel_section hide">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-4 travel-label-box">
                          <label for="approval_duration">Approval Duration<span style="color: red">*</span></label>
                        </div>
                        <div class="col-md-8">
                          <select required="" class="form-control select2 city_select input-sm basic-detail-input-style" name="approval_duration" id="approval_duration">
                            <option value="">Select Duration</option>
                            @php
                              $localDurSel = (@$travel->travelLocal->approval_duration == 'one time')? 'selected':null;
                              $localDuSel = (@$travel->travelLocal->approval_duration == 'monthly')? 'selected':null;
                            @endphp
                            <option value="one time" {{$localDurSel}}>One Time</option>
                            <option value="monthly" {{$localDuSel}}>Monthly</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-4 travel-label-box">
                          <label for="">City<span style="color: red">*</span></label>
                        </div>
                        <div class="col-md-8">
                          <select name="city_id_to_local" id="cityId2" class="form-control select2 city_select input-sm basic-detail-input-style city_id_to_local" required>
                          <option value="">Select City</option>
                          @if($data['cities']->count())
                            @foreach($data['cities'] as $dataCity)
                              @php
                                $localCitySel = (@$travel->travelLocal->city_id == $dataCity->id)? 'selected':null;
                              @endphp
                              <option value="{{$dataCity->id}}" {{$localCitySel}}>{{$dataCity->name}}</option>
                            @endforeach
                          @endif
                        </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-4 travel-label-box">
                          <label for="local_conveyance">Conveyance<span style="color: red">*</span></label>
                        </div>
                        <div class="col-md-8">
                          <select required="" class="form-control select2 city_select input-sm basic-detail-input-style" name="local_conveyance" id="local_conveyance">
                            <option value="">Select Conveyance</option>
                            @if($data['conveyances_local']->count())
                              @foreach($data['conveyances_local'] as $conveyance)
                                @php
                                  $localConSel = (@$travel->travelLocal->conveyance_id == $conveyance->id)? 'selected':null;
                                @endphp
                                <option value="{{$conveyance->id}}" {{$localConSel}}>{{$conveyance->name}}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-4 travel-label-box">
                          <label for="">Expected Cost <br/>(pre approval)</label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-8">
                          <input type="number" name="local_travel_amount" id="local_travel_amount" class="form-control input-sm basic-detail-input-style amount_to_be include_cal cal_value" min="0" value="{{@$travel->travelLocal->travel_amount}}" placeholder="Amount"  autocomplete="" required>

                          @if(isset($travel->travelLocal->id) && !empty($travel->travelLocal->id))
                            <input type="hidden" name="travel_local_id" value="{{$travel->travelLocal->id}}">
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- national section starts here -->
              <div class="national_travel_section">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Date<span style="color: red">*</span></th>
                      <th>City (from)<span style="color: red">*</span></th>
                      <th>City (to)<span style="color: red">*</span></th>
                      <th>Conveyance<span style="color: red">*</span></th>
                      <th>Distance (in k.m)<span style="color: red">*</span></th>
                      <th>Expected Cost (pre approval)<span style="color: red">*</span></th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyNational">
                    @if($travel->travelNational->isEmpty())
                      <tr class="city_tr">
                        <td>
                          <!-- selectDate id="travel_date_range" -->
                          <input type="text" name="travel_date[]" class="form-control travel_date datepicker input-sm basic-detail-input-style" placeholder="MM/DD/YYYY" value="" readonly required autocomplete="off">
                        </td>
                        <td>
                          <!-- id="cityId11" -->
                          <select name="city_id_from_pre[]" class="form-control select2 city_select input-sm basic-detail-input-style city_id_from_pre" required>
                            <option value="">Select City</option>
                            @if($data['cities']->count())
                              @foreach($data['cities'] as $dataCity)
                                <option value="{{ $dataCity->id }}">{{ $dataCity->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </td>
                        <td>
                          <!-- id="cityId12" -->
                          <select name="city_id_to_pre[]" class="form-control select2 city_select input-sm basic-detail-input-style city_id_to_pre" required>
                            <option value="">Select City</option>
                            @if($data['cities']->count())
                              @foreach($data['cities'] as $dataCity)
                                <option value="{{ $dataCity->id }}">{{ $dataCity->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </td>
                        <td>
                          <!-- id="conveyance_id" -->
                          <select name="conveyance_id[]" class="form-control select2 input-sm basic-detail-input-style conveyance_id" required> <!-- placeholder="Please select conveyance" -->
                            <option value="">Select Conveyance</option>
                            @if(!$data['user']->designation->isEmpty() && $data['user']->designation[0]->band->travel_conveyances->count())
                              @foreach($data['user']->designation[0]->band->travel_conveyances as $conveyance)
                                <option value="{{$conveyance->id}}" data-islocal="{{ $conveyance->islocal }}" data-price_per_km="{{ $conveyance->price_per_km }}">
                                  {{$conveyance->name}}
                                  @if($conveyance->price_per_km > 0)
                                    [{{ moneyFormat($conveyance->price_per_km) }}/k.m]
                                  @endif
                                </option>
                              @endforeach
                            @endif
                          </select>
                        </td>
                        <td>
                          <!-- distance_in_km -->
                          <input type="number" name="distance_in_km[]" class="form-control input-sm basic-detail-input-style distance_in_km" value="0" min="0" required readonly autocomplete placeholder="Distance(k.m)">
                        </td>
                        <td>
                          <!-- expected_amount -->
                          <input type="number" name="amount[]" class="form-control input-sm basic-detail-input-style amount_to_be include_cal travel_amount cal_value" min="0" value="" required autocomplete placeholder="Amount">
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                    @else
                      @foreach($travel->travelNational as $nk => $natioal)
                        <tr class="city_tr">
                          <td>
                            <!-- selectDate id="travel_date_range" -->
                            <input type="text" name="travel_date[]" class="form-control travel_date datepicker input-sm basic-detail-input-style" placeholder="MM/DD/YYYY" value="{{date('m/d/Y', strtotime($natioal->travel_date))}}" readonly required autocomplete="off">

                            <input type="hidden" name="travel_national[id][]" value="{{$natioal->id}}">
                          </td>
                          <td>
                            <!-- id="cityId11" -->
                            <select name="city_id_from_pre[]" class="form-control select2 city_select input-sm basic-detail-input-style city_id_from_pre" required>
                              <option value="">Select City</option>
                              @if($data['cities']->count())
                                @foreach($data['cities'] as $dataCity)
                                  @php
                                    $selectFrmCity = ($natioal->from_city_id == $dataCity->id)? 'selected':null;
                                  @endphp
                                  <option value="{{ $dataCity->id }}" {{$selectFrmCity}}>{{ $dataCity->name }}</option>
                                @endforeach
                              @endif
                            </select>
                          </td>
                          <td>
                            <!-- id="cityId12" -->
                            <select name="city_id_to_pre[]" class="form-control select2 city_select input-sm basic-detail-input-style city_id_to_pre" required>
                              <option value="">Select City</option>
                              @if($data['cities']->count())
                                @foreach($data['cities'] as $dataCity)
                                  @php
                                    $selectToCity = ($natioal->to_city_id == $dataCity->id)? 'selected':null;
                                  @endphp
                                  <option value="{{$dataCity->id}}" {{$selectToCity}}>{{ $dataCity->name }}</option>
                                @endforeach
                              @endif
                            </select>
                          </td>
                          <td>
                            <!-- id="conveyance_id" -->
                            <select name="conveyance_id[]" class="form-control select2 input-sm basic-detail-input-style conveyance_id" required> <!-- placeholder="Please select conveyance" -->
                              <option value="">Select Conveyance</option>
                              @if(!$data['user']->designation->isEmpty() && $data['user']->designation[0]->band->travel_conveyances->count())
                                @foreach($data['user']->designation[0]->band->travel_conveyances as $conveyance)
                                  @php
                                    $selectConveyance = ($natioal->conveyance_id == $conveyance->id)? 'selected':null;
                                  @endphp
                                  <option value="{{$conveyance->id}}" data-islocal="{{ $conveyance->islocal }}" data-price_per_km="{{ $conveyance->price_per_km }}" {{$selectConveyance}}>
                                    {{$conveyance->name}}
                                    @if($conveyance->price_per_km > 0)
                                      [{{ moneyFormat($conveyance->price_per_km) }}/k.m]
                                    @endif
                                  </option>
                                @endforeach
                              @endif
                            </select>
                          </td>
                          <td>
                            <!-- distance_in_km -->
                            @php
                              $distanceAttributes = 'readonly';
                              if($natioal->conveyance->islocal == 1 && $natioal->conveyance->price_per_km > 0) {
                                $distanceAttributes = null;
                              }
                            @endphp
                            <input type="number" name="distance_in_km[]" class="form-control input-sm basic-detail-input-style distance_in_km" value="{{ $natioal->distance_in_km }}" min="0" required autocomplete placeholder="Distance(k.m)" {{$distanceAttributes}}>
                          </td>
                          <td>
                            <!-- expected_amount -->
                            @php
                              $amountAttributes = null;
                              if($natioal->conveyance->islocal == 1 && $natioal->conveyance->price_per_km > 0) {
                                $amountAttributes = 'readonly';
                              }
                            @endphp
                            <input type="number" name="amount[]" class="form-control input-sm basic-detail-input-style amount_to_be include_cal travel_amount cal_value" min="0" value="{{ $natioal->travel_amount }}" required autocomplete placeholder="Amount" {{$amountAttributes}}>
                          </td>
                          <td>
                            @if($loop->iteration > 1)
                              <a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="removeTr($(this))" data-type="national" data-travel_id="{!! $natioal->travel_id !!}" data-id="{!! $natioal->id !!}">Remove</a>
                            @else
                              &nbsp;
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
                <div class="form-group">
                  <div class="row text-center">
                    <a href="javascript:void(0);" class="btn btn-success" onclick="addMoreNatoinal()">Add More</a>
                  </div>
                </div>
              </div>
              <!-- national section ends here -->
              <!-- Date input section ends here -->

              <div class="form-group hide">
                <div class="row">
                  <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                    <label class="apply-leave-label">Opportunities<span style="color: red">*</span></label>
                  </div>
                  <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                    <select name="opportunities[]" class="form-control select2" multiple="multiple" required style="width:100%;">
                      <option>Please select project</option>
                      @if($data['projects']->count())
                        @foreach($data['projects'] as $project)
                          <option value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="col-md-7">
                    <input type="text" name="purpose_opportunity" class="form-control" value="" required placeholder="Enter your purpose for travel" autocomplete="off">
                  </div>
                </div>
              </div>

              <div class="onlyAlowedForNational">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                      <label class="apply-leave-label">Covered under policy<span style="color: red">*</span></label>
                    </div>
                    <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                      <label class="radio-inline">
                        <input type="radio" name="cover_under_policy" class="cover_under_policy" value="1" required @if($travel->cover_under_policy == 1) checked @endif> Yes
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="cover_under_policy" class="cover_under_policy" value="0"  @if($travel->cover_under_policy == 0) checked @endif required> No
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                      <label class="apply-leave-label">Stay<span style="color: red">*</span></label>
                    </div>
                    <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                      <label class="radio-inline">
                        <input type="radio" name="stay" class="stay" value="1" required onclick="CheckStay(1);" @if($travel->stay == 1) checked @endif> Yes
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="stay" class="stay" value="0" required onclick="CheckStay(0);" @if($travel->stay == 0) checked @endif> No
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row1 @if($travel->stay == 0) hide @endif" id="stay_block">
                  @php
                    $bandId = $data['user']->designation[0]->band->id;
                  @endphp
                  <legend>Stay Form</legend>
                  <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Dates</th>
                          <th>State</th>
                          <th>City</th>
                          <th>Rate stay/night (incl taxes)</th>
                          <th>Food Expense ( DA )</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        @if($travel->travelStay->isEmpty())
                          <tr class="city_tr">
                            <td>
                              <input type="text" name="stay_date_range[]" class="form-control selectDate stay_date_range" placeholder="MM/DD/YYYY" value="" readonly autocomplete="off" style="width: 200px;">
                            </td>
                            <td>
                              <select name="state_id_stay[]" class="form-control state_id_stay state" onchange="displayCity($(this), 3);" required style="width: 120px">
                                <option value="">Select state</option>
                                @if(!$data['states']->isEmpty())
                                  @foreach($data['states'] as $state)
                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                  @endforeach
                                @endif
                              </select>
                            </td>
                            <td>
                              <select name="city_id_stay[]" class="form-control city_select city_id_stay" onchange="GetCityDetails($(this))" required style="width: 120px">
                                <option value="">Select City</option>
                              </select>
                            </td>
                            <td>
                              <input type="number" name="rate_per_night[]" class="form-control stayda amount_to_be rate_per_night cal_value" min="0" value="" placeholder="Rate per night" required>
                            </td>
                            <td>
                              <input type="number" name="da[]" class="form-control amount_to_be stayda da_class da cal_value" min="0" value="0" placeholder="DA" required autocomplete="off">
                            </td>
                            <td>&nbsp;</td>
                          </tr>
                        @else
                          @foreach($travel->travelStay as $sk => $stay)
                            @php
                              $fromDate = date('m/d/Y', strtotime($stay->from_date));
                              $toDate   = date('m/d/Y', strtotime($stay->to_date));
                              $stayDate = $fromDate .' - '. $toDate;

                              $band = getBandCity($bandId, $stay->city->city_class_id);
                            @endphp
                            <tr class="city_tr">
                              <td>
                                <input type="text" name="stay_date_range[]" class="form-control selectDate stay_date_range" placeholder="MM/DD/YYYY" value="{{$stayDate}}" readonly autocomplete="off" style="width: 200px;">

                                <input type="hidden" name="travel_stay[id][]" value="{{$stay->id}}">
                              </td>
                              <td>
                                <select name="state_id_stay[]" class="form-control state_id_stay state" onchange="displayCity($(this), 3);" required style="width: 120px">
                                  <option value="">Select state</option>
                                  @if(!$data['states']->isEmpty())
                                    @foreach($data['states'] as $state)
                                      @php
                                        $selectState = ($stay->city->state_id == $state->id)? 'selected':null;
                                      @endphp
                                      <option value="{{$state->id}}" {{$selectState}}>{{$state->name}}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </td>
                              <td>
                                <select name="city_id_stay[]" class="form-control city_select city_id_stay" onchange="GetCityDetails($(this))" required style="width: 120px">
                                  <option value="">Select City</option>
                                  @if($data['cities']->count())
                                    @foreach($data['cities'] as $dataCity)
                                      @php
                                        $selectCity = ($stay->city_id == $dataCity->id)? 'selected':null;
                                      @endphp
                                      <option value="{{$dataCity->id}}" {{$selectCity}}>{{ $dataCity->name }}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </td>
                              <td>
                                <input type="number" name="rate_per_night[]" class="form-control stayda amount_to_be rate_per_night cal_value" min="0" value="{{$stay->rate_per_night}}" placeholder="Rate/might max {{@$band->city_class[0]->pivot->price}}" max="{{@$band->city_class[0]->pivot->price}}" required>
                              </td>
                              <td>
                                <input type="number" name="da[]" class="form-control amount_to_be stayda da_class da cal_value" min="0" value="{{$stay->da}}" placeholder="DA max {{@$band->food_allowance}}" max="{{@$band->food_allowance}}" required autocomplete="off">
                              </td>
                              <td>
                                @if($loop->iteration > 1)
                                  <a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="removeTr($(this))" data-type="stay" data-travel_id="{!! $stay->travel_id !!}" data-id="{!! $stay->id !!}">Remove</a>
                                @else
                                  &nbsp;
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <div class="form-group">
                    <div class="row text-center">
                      <a href="javascript:void(0);" class="btn btn-success" onclick="addMoreRows()">Add More</a>
                    </div>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                      <label class="apply-leave-label">Other financial approvals<span style="color: red">*</span></label>
                    </div>
                    <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                      <label class="radio-inline">
                        <input type="radio" name="other_financial_approval" class="other_financial_approval" onclick="CheckOther(1);" value="1" required @ if($travel->other_financial_approval == 1) checked @ endif> Yes
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="other_financial_approval" class="other_financial_approval" onclick="CheckOther(0);" value="0" required @ if($travel->other_financial_approval == 0) checked @ endif> No
                      </label>
                    </div>
                  </div>
                </div> -->
                <!-- <div class="row1 @ if($travel->other_financial_approval == 0) hide @ endif" id="other_financial_block">
                  <legend>Other Financial Approvals Form</legend>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                        <label class="apply-leave-label">Location<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                        <select name="country_id_other" class="form-control country_id_other" required>
                          @ if(!$data['countries']->isEmpty())
                            @ foreach($data['countries'] as $country)
                              @ php
                                $countrySel = null;
                                if(!empty($travel->otherApproval) && $travel->otherApproval->country_id == $country->id) {
                                  $countrySel = 'selected';
                                } elseif($country->name == "India") {
                                  $countrySel = 'selected';
                                }
                              @ endphp
                              <option value="{ {$country->id}}" { {$countrySel}}>{ {$country->name}}</option>
                            @ endforeach
                          @ endif
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-2 col-xs-2 leave-input-box">
                        <select name="state_id_other" class="form-control state state_id_other" onchange="displayCity($(this), 4);" required="">
                          <option value="">Please select state</option>
                          @ if(!$data['states']->isEmpty())
                            @ foreach($data['states'] as $state)
                              @ php
                                $stateSel = null;
                                if(!empty($travel->otherApproval) && $travel->otherApproval->state_id == $state->id) {
                                  $stateSel = 'selected';
                                }
                              @ endphp
                              <option value="{ {$state->id}}" { {$stateSel}}>{ {$state->name}}</option>
                            @ endforeach
                          @ endif
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                        <select name="city_id_other" class="form-control city_select" id="cityId4" required>
                          <option value="">Select City</option>
                          @ if($data['cities']->count())
                            @ foreach($data['cities'] as $dataCity)
                              @ php
                                $citySel = null;
                                if(!empty($travel->otherApproval) && $travel->otherApproval->city_id == $dataCity->id) {
                                  $citySel = 'selected';
                                }
                              @ endphp
                              <option value="{ {$dataCity->id}}" { {$citySel}}>{ { $dataCity->name }}</option>
                            @ endforeach
                          @ endif
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                        <label class="apply-leave-label">Project & Purpose<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                        <select name="project_id_other" id="project_id_other" class="form-control" placeholder="Please select project" required>
                          <option value="">Please select project</option>
                          @ if($data['projects']->count())
                            @ foreach($data['projects'] as $project)
                              @ php
                                $projectSel = null;
                                if(!empty($travel->otherApproval) && $travel->otherApproval->project[0]->id == $project->id) {
                                  $projectSel = 'selected';
                                }
                              @ endphp
                              <option value="{ {$project->id}}" { {$projectSel}}>{ {$project->name}}</option>
                            @ endforeach
                          @ endif
                        </select>
                
                        @ if(isset($travel->otherApproval->id) && !empty($travel->otherApproval->id))
                          <input type="hidden" name="other_approval_id" value="{ {$travel->otherApproval->id}}">
                        @ endif
                      </div>
                      <div class="col-md-7">
                        @ php
                          $projectPurpose = null;
                          if(!empty($travel->otherApproval) && !empty($travel->otherApproval->purpose)) {
                            $projectPurpose = $travel->otherApproval->purpose;
                          }
                        @ endphp
                        <input type="text" name="purpose_other" class="form-control" value="{ {$projectPurpose}}" autocomplete="off" placeholder="Enter your purpose">
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                        <label class="apply-leave-label">Amount<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                        @ php
                          $projectAmount = null;
                          if(!empty($travel->otherApproval) && !empty($travel->otherApproval->amount)) {
                            $projectAmount = $travel->otherApproval->amount;
                          }
                        @ endphp
                        <input type="number" name="amount_other" class="form-control amount_to_be include_cal" min="0" value="{ {$projectAmount}}" placeholder="Amount">
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="form-group">
                  <input type="hidden" name="other_financial_approval" value="0">
                  <div class="row">
                    <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                      <label class="apply-leave-label">Imprest Request<span style="color: red">*</span></label>
                    </div>
                    <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                      <label class="radio-inline">
                        <input type="radio" name="imprest_request" class="imprest_request" onclick="CheckImprest(1);" value="1" required @if($travel->imprest_request == 1) checked @endif> Yes
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="imprest_request" class="imprest_request" onclick="CheckImprest(0);" value="0"  @if($travel->imprest_request == 0) checked @endif required> No
                      </label>

                      <input type="hidden" name="total_travel_amount" class="total_travel_amount" value="{{ $travel->total_amount }}">
                    </div>
                  </div>
                </div>
                <div class="row1  @if($travel->imprest_request == 0) hide @endif" id="imprest_block">
                  <legend>Imprest Request Form</legend>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                        <label class="apply-leave-label">Project & Remarks<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                        <select name="project_id_imprest" id="project_id_imprest" class="form-control" placeholder="Please select project" required>
                          <option value="">Please select project</option>
                          @if($data['projects']->count())
                            @foreach($data['projects'] as $project)
                              @php
                                $impProjetSel = null;
                                if(!empty($travel->imprest) && $travel->imprest->project[0]->id == $project->id) {
                                  $impProjetSel = 'selected';
                                }
                              @endphp
                              <option value="{{$project->id}}" {{$impProjetSel}}>{{$project->name}}</option>
                            @endforeach
                          @endif
                        </select>

                        @if(isset($travel->imprest->id) && !empty($travel->imprest->id))
                          <input type="hidden" name="imperest_id" value="{{$travel->imprest->id}}">
                        @endif

                      </div>
                      <div class="col-md-7">
                        @php
                          $imprestRemarks = null;
                          if(!empty($travel->imprest) && !empty($travel->imprest->remarks_by_applicant)) {
                            $imprestRemarks = $travel->imprest->remarks_by_applicant;
                          }
                        @endphp
                        <input type="text" name="remarks" class="form-control" value="{{$imprestRemarks}}" placeholder="Enter your remarks" autocomplete="off" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group hide">
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                        <label class="apply-leave-label">Total Amount</label>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2"> <!-- leave-input-box -->
                        <input type="text" name="total_amount" id="total_amount"class="form-control" value="" disabled placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                        <label class="apply-leave-label">Amount for imprest<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-3 col-sm-2 col-xs-2 leave-input-box">
                        @php
                          $imprestAmount = null;
                          if(!empty($travel->imprest) && !empty($travel->imprest->amount)) {
                            $imprestAmount = $travel->imprest->amount;
                          }
                        @endphp
                        <input type="number" class="form-control" id="amount_imprest" name="amount_imprest" min="0" value="{{$imprestAmount}}" placeholder="Amount">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" name="btn_submit" value="submit" id="">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
  </section>
  <!-- /.content -->
  <!-- /.modal -->
</div>
<!-- Appended rows for national starts here-->
<div class="hide" id="clonenational"> <!--------------------------------------------------->
  <table>
    <tr class="removetr city_tr" id="city_tr">
      <td>
        <!-- id="travel_date_range" -->
        <input type="text" name="travel_date[]" class="form-control travel_date datepicker input-sm basic-detail-input-style" placeholder="MM/DD/YYYY" value="" readonly required autocomplete="off">
      </td>
      <td>
        <!-- id="cityId11" -->
        <select name="city_id_from_pre[]" class="form-control city_select input-sm basic-detail-input-style city_id_from_pre" required>
          <option value="">Select City</option>
          @if($data['cities']->count())
            @foreach($data['cities'] as $dataCity)
              <option value="{{ $dataCity->id }}">{{ $dataCity->name }}</option>
            @endforeach
          @endif
        </select>
      </td>
      <td>
        <!-- id="cityId12" -->
        <select name="city_id_to_pre[]" class="form-control city_select input-sm basic-detail-input-style city_id_to_pre" required>
          <option value="">Select City</option>
          @if($data['cities']->count())
            @foreach($data['cities'] as $dataCity)
              <option value="{{ $dataCity->id }}">{{ $dataCity->name }}</option>
            @endforeach
          @endif
        </select>
      </td>
      <td>
        <!-- id="conveyance_id" -->
        <select name="conveyance_id[]" class="form-control input-sm basic-detail-input-style conveyance_cloned conveyance_id" required> <!-- placeholder="Please select conveyance" -->
          <option value="">Select Conveyance</option>
          @if(!$data['user']->designation->isEmpty() && $data['user']->designation[0]->band->travel_conveyances->count())
            @foreach($data['user']->designation[0]->band->travel_conveyances as $conveyance)
              <option value="{{$conveyance->id}}" data-islocal="{{ $conveyance->islocal }}" data-price_per_km="{{ $conveyance->price_per_km }}">
                {{$conveyance->name}}
                @if($conveyance->price_per_km > 0)
                  [{{ moneyFormat($conveyance->price_per_km) }}/k.m]
                @endif
              </option>
            @endforeach
          @endif
        </select>
      </td>
      <td>
        <!-- distance_in_km -->
        <input type="number" name="distance_in_km[]" class="form-control input-sm basic-detail-input-style distance_in_km" value="0" min="0" required readonly autocomplete placeholder="Distance(k.m)">
      </td>
      <td>
        <!-- expected_amount -->
        <input type="number" name="amount[]" class="form-control input-sm basic-detail-input-style amount_to_be include_cal travel_amount cal_value" min="0" value="" required autocomplete placeholder="Amount">
      </td>
      <td>
        <a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="removeTr($(this))">Remove</a>
      </td>
    </tr>
  </table>
</div>
<!-- Appended rows for national ends here -->
<div class="hide" id="cloneit"> <!--------------------------------------------------->
  <table>
    <tr id="city_tr" class="removetr city_tr">
      <td>
        <input type="text" name="stay_date_range[]" class="form-control selectDate stay_date_range" placeholder="MM/DD/YYYY" value="" readonly autocomplete="off" style="width: 200px;">
      </td>
      <td>
        <select name="state_id_stay[]" class="form-control state_id_stay state" onchange="displayCity($(this), 3);" required style="width: 120px">
          <option value="">Select state</option>
          @if(!$data['states']->isEmpty())
            @foreach($data['states'] as $state)
              <option value="{{$state->id}}">{{$state->name}}</option>
            @endforeach
          @endif
        </select>
      </td>
      <td>
        <select name="city_id_stay[]" id="cityId3" class="form-control city_select city_id_stay" onchange="GetCityDetails($(this))" required style="width: 120px">
          <option value="">Select City</option>
        </select>
      </td>
      <td>
        <input type="number" name="rate_per_night[]" class="form-control stayda amount_to_be rate_per_night cal_value" min="0" value="" placeholder="Rate per night" required>
      </td>
      <td>
        <input type="number" name="da[]" class="form-control amount_to_be stayda da_class da cal_value" min="0" value="0" placeholder="DA" required autocomplete="off">
      </td>
      <td>
        <a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="removeTr($(this))">Remove</a>
      </td>
    </tr>
  </table>
</div>
<!-- /.content-wrapper -->
<!-- bootstrap time picker -->
<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script>
$(document).ready(function() {

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

  $("#travelApprovalForm").validate({
    ignore: ':hidden,input[type=hidden],.select2-search__field', //  [type="search"]
    errorElement: 'span',
    errorPlacement: function(error, element) {
      if (element.attr("name") == "isclient") {
        error.appendTo(".travel-input-box-client");
      }
      else if (element.hasClass('select2')) {
        error.insertAfter(element.next('span.select2'));
      }
      else if (element.is(":radio")) {
        error.insertAfter(element.parent().next());
      }
      else {
        error.appendTo(element.parent()); // error.insertAfter(element);
      }
    },
    rules :{
      "category_id" : {
        required : true,
      },
      "isclient" : {
        required : true,
      },
      "existing_customer" : {
        required: function(element) {
          return ($('.customer_type_selection:checked').val() == 1)? true: false;
        }
      },
      "future_customer" : {
        required: function(element) {
          return ($('.customer_type_selection:checked').val() == 2)? true: false;
        }
      },
      "local_others" : {
        required: function(element) {
          return ($('.customer_type_selection:checked').val() == 3)? true: false;
        }
      },
      "approval_duration" : {
        required : true,
      },
      "city_id_to_local" : {
        required : true,
      },
      "local_travel_amount" : {
        required : true,
      },
      "travel_date[]" : {
        required : true,
      },
      "city_id_from_pre[]" : {
        required : true,
      },
      "city_id_to_pre[]" : {
        required : true,
      },
      "conveyance_id[]" : {
        required : true,
      },
      "amount[]" : {
        required : true,
      },
      "local_conveyance" : {
        required : true,
      },
      "stay_date_range[]" : {
        required: function(element) {
          return ($('.stay:checked').val() == 1)? true: false;
        }
      },
      "state_id_stay[]" : {
        required: function(element) {
          return ($('.stay:checked').val() == 1)? true: false;
        }
      },
      "city_id_stay[]" : {
        required: function(element) {
          return ($('.stay:checked').val() == 1)? true: false;
        }
      },
      "rate_per_night[]" : {
        required: function(element) {
          return ($('.stay:checked').val() == 1)? true: false;
        }
      },
      "da[]" : {
        required: function(element) {
          return ($('.stay:checked').val() == 1)? true: false;
        }
      }
    },
    messages :{
      "isclient" : {
        required : 'Please select Customer Type.'
      },
      "approval_duration" : {
        required : 'Please select time duration.'
      },
      "city_id_to_local" : {
        required : 'Please select your city.'
      },
      "local_travel_amount" : {
        required : 'Please enter local travel amount.'
      },
      "travel_date[]" : {
        required : 'Please select Date.'
      },
      "city_id_from_pre[]" : {
        required : 'Please select City.'
      },
      "city_id_to_pre[]" : {
        required : 'Please select city.'
      },
      "conveyance_id[]" : {
        required : 'Please choose conveyance.'
      },
      "amount[]" : {
        required : 'Please enter the amount.'
      },
      "local_conveyance" : {
        required : 'Please choose conveyance.'
      },
      "stay_date_range[]" : {
        required : 'Please select Date Range.'
      },
      "state_id_stay[]" : {
        required : 'Please select state.'
      },
      "city_id_stay[]" : {
        required : 'Please select city.'
      },
      "rate_per_night[]" : {
        required : 'Please enter rate per night.'
      },
      "da[]" : {
        required : 'Please enter da.'
      }
    }
  });

  /*
  $(".for_future_customer").addClass('hide'); // hide();
  $(".other_customers").addClass('hide'); // hide();
  $(".for_existing_customer").addClass('hide'); // hide();
  */

  $(document).on('click', '.customer_type_selection', function() {

    var customerTypeSelection = $(this).val();

    if (customerTypeSelection == 1) {
      $(".for_future_customer").addClass('hide'); // hide();
      $(".other_customers").addClass('hide'); // hide();
      $(".for_existing_customer").removeClass('hide'); // show();
    }
    else if (customerTypeSelection == 2) {
      $(".other_customers").addClass('hide'); // hide();
      $(".for_existing_customer").addClass('hide'); // hide();
      $(".for_future_customer").removeClass('hide'); // show();
    }
    else {
      $(".other_customers").removeClass('hide'); // show();
      $(".for_existing_customer").addClass('hide'); // hide();
      $(".for_future_customer").addClass('hide'); // hide();
    }
  });

  // $(".onlyAlowedForNational").hide();
  $(document).on('click', '.select_local', function() {
    $('.national_travel_section').addClass('hide'); // hide();
    $('.local_travel_section').removeClass('hide'); // show();
    $('.onlyAlowedForNational').addClass('hide'); // hide();
    $('input[name="travel_type"]').val(1);
  });

  $(document).on('click', '.select_national', function() {
    $('.national_travel_section').removeClass('hide'); // show();
    $('.local_travel_section').addClass('hide'); // hide();
    $('.onlyAlowedForNational').removeClass('hide'); // show();
    $('input[name="travel_type"]').val(2);
  });

  initDaterangepickers();

  $(".stayda").keyup(function() {
    calculateTotalAmountToRequest();
  });

  $(".amount_to_be").keyup(function() {
    v=0;
    $(".amount_to_be").each(function() {
      //console.log($(this).val());
      if($(this).hasClass('include_cal') && parseFloat($(this).val()) == $(this).val())
        v+=parseFloat($(this).val());
    });
    //$("#total_amount").val(v.toFixed(2));
    //$("#amount_imprest").attr("max", v.toFixed(2));
  });

  // $("#local_travel").addClass("active");

  $(".select_travel_type").on('click', function() {
    $(".select_travel_type").removeClass("active");
    $(this).addClass("active");
  });

  $(document).on('change', '.conveyance_id', function() {
    var _val         = $(this).val();
    var _option      = $(this).find('option:selected');
    var islocal      = _option.data('islocal');
    var price_per_km = parseFloat(_option.data('price_per_km'));

    $(this).parents('tr').find('input.distance_in_km').val(0);
    $(this).parents('tr').find('input.amount_to_be').val(0);
    if(islocal == 1 && price_per_km > 0) {
      $(this).parents('tr').find('input.distance_in_km').removeAttr('readonly');
      $(this).parents('tr').find('input.amount_to_be').attr('readonly', true);
    } else {
      $(this).parents('tr').find('input.distance_in_km').attr('readonly', true);
      $(this).parents('tr').find('input.amount_to_be').removeAttr('readonly');
    }
  });

  $(document).on('change', '.distance_in_km', function() {
    var _val       = $(this).val();
    var conveyance = $(this).parents('tr').find('select.conveyance_id').find('option:selected');
    var price_per_km = parseFloat(conveyance.data('price_per_km'));
    var new_val    = parseFloat(_val * price_per_km);
    $(this).parents('tr').find('input.amount_to_be').val(new_val);

    calculateTotalAmount();
  });

  $(document).on('change', '.amount_to_be', function() {
    var val = 0;
    $('.amount_to_be').each(function() {
      if($(this).hasClass('cal_value') && parseFloat($(this).val()) == $(this).val()) {
        val += parseFloat($(this).val());
      }
    });
    $('input.total_travel_amount').val(val.toFixed(2));
  });

  $(document).on('change', '.categories', function() {
    var _val         = $(this).val();
    var _option      = $(this).find('option:selected');
    var text         = _option.text();

    if(text == 'BD' || text == 'SD') {
      $('.travel_for_div').removeClass('hide');
    } else {
      $('.travel_for_div').addClass('hide');
    }
  });

});

function initDaterangepickers() {
  var minimumDate = '{{ date('m/d/Y', strtotime('previous month')) }}';
  var maximumDate = '{{ date('m/d/Y') }}';
  //Date picker
  $(".datepicker").datepicker({
    /*format: "MM/DD/YYYY",*/
    // startDate: '-1m',
    // minDate: minimumDate,
    // endDate: maximumDate,
    autoclose: true,
    orientation: "bottom"
  });

  $('.selectDate').daterangepicker({
    //startDate: 'date("m/d/Y", strtotime($date_from))}}',
    //endDate  : 'date("m/d/Y", strtotime($date_to))}}',
    autoUpdateInput: false,
    locale: {
      cancelLabel: 'Clear'
    }
  }, function (start, end) {}).on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  }).on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });
}

function addMoreNatoinal() {
  if($('#tbodyNational input, #tbodyNational select').valid()) {

    $("#clonenational table .removetr").clone().appendTo('#tbodyNational');
    // $('#tbodyNational').last('tr').children().find('.datepicker').datepicker();
    initDaterangepickers();
    $('#tbodyNational').last('tr').children().find('.city_select').select2();
    $('#tbodyNational').last('tr').children().find('.conveyance_cloned').select2();
  }
}

function calculateTotalAmount()
{
  var val = 0;
  $('.amount_to_be').each(function(k, v) {
    if($(v).hasClass('cal_value') && parseFloat($(v).val()) >= 0) {
      val += parseFloat($(v).val());
    }
  });
  $('input.total_travel_amount').val(val.toFixed(2));
}

function addMoreRows() {
  if($('#tbody input, #tbody select').valid()) {
    $("#cloneit table .removetr").clone().appendTo('#tbody');
    // $('#tbody').last('tr').children().find('.selectDate').daterangepicker();
    initDaterangepickers();
  }
}

function CheckStay(s) {
  //Show Hide Stay block
  initDaterangepickers();
  if(s==1){
    $('#stay_block').removeClass('hide');
    $('#stay_block').children().find('input, select').prop('required', true);
  }
  else{
    $('#stay_block').addClass('hide');
    $('#stay_block').children().find('input, select').prop('required', false);
  }
}

function CheckImprest(s) {
  //Show Hide Imprest block
  if(s==1) {
    $('#imprest_block').removeClass('hide');
    $('#imprest_block').children().find('input, select').prop('required', true);
  }
  else {
    $('#imprest_block').addClass('hide');
    $('#imprest_block').children().find('input, select').prop('required', false);
  }
}

function CheckOther(s) {
  //Show Hide Other Financial Approval  block
  if(s==1) {
    $('#other_financial_block').removeClass('hide');
    $('#other_financial_block').children().find('input, select').prop('required', true);
  }
  else {
    $('#other_financial_block').addClass('hide');
    $('#other_financial_block').children().find('input, select').prop('required', false);
  }
}

function CalculateDifference() {
  //calculate difference between two dates and add one day as stay per night is to be calculated
  var date1 = new Date($("#date_from_stay").val());
  var date2 = new Date($("#date_to_stay").val());
  var Difference_In_Time = date2.getTime() - date1.getTime();
  Difference_In_Days = (Difference_In_Time / (1000 * 3600 * 24))+1;
  $("#stay_days").val(Difference_In_Days + " Days");
  $("#no_of_days_to_stay").val(Difference_In_Days);
  calculateTotalAmountToRequest();
}

function calculateTotalAmountToRequest() {
  //sum all the amount entered and siplay in one text field and set max value for imprest field
  $(".city_tr").each(function(){
    st_days=parseInt($(this).find('.no_of_days_to_stay').val());
    v=0;
    $(this).find(".stayda").each(function(){
      if(parseFloat($(this).val()) == $(this).val())
        v+=parseFloat($(this).val());
    });
    v=v*st_days;
    $(this).find(".total_stayda").val(v.toFixed(2));
  });
  return ;
  st_days=parseInt($("#no_of_days_to_stay").val());
  v=0;
  $(".stayda").each(function(){
    if(parseFloat($(this).val()) == $(this).val())
      v+=parseFloat($(this).val());
  });
  v=v*st_days;
  $("#total_stayda").val(v.toFixed(2));
}

function GetCityDetails(obj) {
  var cityId  = obj.val();
  var _bandId = '{{ $bandId }}';

  if(cityId != '') {
    $.ajax({
      type: 'POST',
      url: "{{ url('employees/band-city') }}",
      data: {city: obj.val(), band: _bandId},
      success: function(result){
        //$("#rate_per_night").attr('max',result.city_class[0].pivot.price);
        //$("#da").attr('max',result.food_allowance);
        console.log(result);

        obj.parents('.city_tr').find('.rate_per_night').attr({'max':result.city_class[0].pivot.price, 'placeholder':"Rate/might max "+result.city_class[0].pivot.price});
        obj.parents('.city_tr').find('.da_class').attr({'placeholder':" DA max "+result.food_allowance, "max": result.food_allowance});
      }
    });
  }
}

function displayCity(obj, no)
{
  var stateId = obj.val();
  var displayString = '<option value="">Select city</option>';

  if(stateId != '') {
    var stateIds = [];
    stateIds.push(stateId);
    obj.parents('.form-group, .city_tr').children().find(".city_select").empty();

    $.ajax({
      type: 'POST',
      url: "{{ url('employees/states-wise-cities') }} ",
      data: {stateIds: stateIds},
      success: function(result){
        if(result.length != 0) {
          result.forEach(function(city){
            displayString += '<option value="'+city.id+'">'+city.name+'</option>';
          });
        }else{
          displayString += '<option value="" selected disabled>None</option>';
        }
        //$('#cityId'+no).append(displayString);
        obj.parents('.form-group, .city_tr').children().find(".city_select").html(displayString);
      }
    });
  } else {
    obj.parents('.form-group, .city_tr').children()
    .find(".city_select").html(displayString);
  }
}

function removeTr(obj)
{
  if(typeof $(obj).data('type') != 'undefined')
  {
    var type      = $(obj).data('type'); // national, stay
    var travel_id = $(obj).data('travel_id');
    var data_id   = $(obj).data('id');
    var _token    = '{!! csrf_token() !!}';

    var objdata = {
      '_token': _token, 'type': type, 'travel_id': travel_id, 'data_id': data_id,
    };

    swal({
      title: "Are you sure?",
      text: "You want to delete this, You will not be able to recover this record!",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {

      if (isConfirm) {

        $.ajax({
          url: "{!! url('travel/delete/approval-details') !!}",
          type: "POST",
          data: objdata,
          dataType: 'json',
          success: function (res) {

            if(res.status == 1) {
              swal("Done!", res.msg, "success");

              obj.parents('tr').remove();

              calculateTotalAmount();
            } else {
              swal("Error:", res.msg, "error");
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var xhrRes = xhr.responseJSON;

            if(xhrRes.status == 401) {
              swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
            } else {
              swal("Error deleting!", "Please try again", "error");
            }
          }
        });
      }
    });
  } else {
    obj.parents('tr').remove();
    calculateTotalAmount();
  }
}
</script>
@endsection