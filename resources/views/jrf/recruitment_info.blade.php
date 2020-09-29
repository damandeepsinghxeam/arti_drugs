@if(!empty(@$data))
    <table class="table table-striped table-bordered">
        <tr>
          <th style="width: 30%">Field</th>
          <th style="width: 70%">Value</th>
        </tr>

        <tr>
          <td><em>Department</em></td>
          <td>
             {{@$data->department_name}}
          </td>
        </tr>
        <tr>
          <td><em>Candidate Name</em></td>
          <td>
            {{@$data->candidate_name}}
          </td>
        </tr>

        <tr>
          <td><em>Interview Status</em></td>
          <td>
              @if(!empty(@$data->interview_status))
                 
                 {{@$data->interview_status}}
             @else
                   N/A
             @endif
          </td>
        </tr>

        <tr>
          <td><em>Interview type</em></td>
          <td>
             {{@$data->interview_type}}
          </td>
        </tr>
        
        <tr>
          <td><em>Interview Date</em></td>
          <td>
             {{@$data->interview_date}}
          </td>
        </tr>

        @if(!empty(@$data->other_backoff_reason))
        <tr>
          <td><em>Back off reasons</em></td>
          <td>
             {{@$data->other_backoff_reason}}
          </td>
        </tr>
        @endif

        @if(!empty(@$data->other_rejected_reason))
        <tr>
          <td><em>Rejection reason</em></td>
          <td>
             {{@$data->other_rejected_reason}}
          </td>
        </tr>
        @endif

        @if(!empty(@$data->final_status))
        <tr>
          <td><em>Status</em></td>
          <td>
             {{@$data->final_status}}
          </td>
        </tr>
        @endif

        @if(!empty(@$data->interview_time))
        <tr>
          <td><em>Interview Time</em></td>
          <td>
             {{@$data->interview_time}}
          </td>
        </tr>
        @endif
      </table>
@else
    <span class="text-danger"><strong>No data.</strong></span>
@endif