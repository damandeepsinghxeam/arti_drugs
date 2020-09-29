@if(!empty($data))
  <table class="table table-striped table-bordered">
        <tr>
          <th style="width: 30%">Field</th>
          <th style="width: 70%">Value</th>
        </tr>

        @if(!empty(@$data->secondary_leave_type))
        <tr>
          <td><em>Secondary Leave Type</em></td>
          <td>
            {{@$data->secondary_leave_type}}
          </td>
        </tr>
        @endif

        @if(!empty(@$data->leave_half))
        <tr>
          <td><em>Leave Half</em></td>
          <td>
            {{@$data->leave_half}}
          </td>
        </tr>
        @endif

        @if(!empty(@$data->excluded_dates))
        <tr>
          <td><em>Excluded dates</em></td>
          <td>
            {{@$data->excluded_dates}}
          </td>
        </tr>
        @endif
        
        <tr>
          <td><em>Country</em></td>
          <td>
            {{@$data->country_name}}
          </td>
        </tr>

        <tr>
          <td><em>State</em></td>
          <td>
            {{@$data->state_name}}
          </td>
        </tr>

        <tr>
          <td><em>City</em></td>
          <td>
            {{@$data->city_name}}
          </td>
        </tr>

        <tr>
          <td><em>Documents</em></td>
          <td>
            @if(!$documents->isEmpty())
              @foreach($documents as $key => $value)
                <a href='{{ url("leaves/applied-leave/doc/$value->id") }}' target="_blank"><span><i class="fa fa-download" aria-hidden="true"></i></span></a>&nbsp;&nbsp;
              @endforeach
            @else
              {{"None"}}
            @endif
          </td>
        </tr>

        <tr>
          <td><em>Mobile Number</em></td>
          <td>
           ({{@$data->phone_code}}) {{@$data->mobile_number}}
          </td>
        </tr>

        <tr>
          <td><em>Reason For Leave</em></td>
          <td>
            {{@$data->reason}}
          </td>
        </tr>

        @if(!empty(@$data->tasks))
        <tr>
          <td><em>Handover Tasks</em></td>
          <td>
            @php
              echo @$data->tasks;
            @endphp
          </td>
        </tr>
        @endif    
        
      </table>
@else
    <span class="text-danger"><strong>No data.</strong></span>
@endif