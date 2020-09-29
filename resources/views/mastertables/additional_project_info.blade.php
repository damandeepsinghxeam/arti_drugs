@if(!empty($data['project']->id))

  <table class="table table-striped table-bordered">

        <tr>

          <th style="width: 30%">Field</th>

          <th style="width: 70%">Value</th>

        </tr>

        

        <tr>

          <td><em>Project Name</em></td>

          <td>

            {{@$data['project']->name}}

          </td>

        </tr>



        <tr>

          <td><em>Project Address</em></td>

          <td>

            {{@$data['project']->address}}

          </td>

        </tr>



        <tr>

          <td><em>Salary Structure</em></td>

          <td>

            {{@$data['project']->salaryStructure->name}}

          </td>

        </tr>



        <tr>

          <td><em>Salary Cycle</em></td>

          <td>

            {{@$data['project']->salaryCycle->name}}

          </td>

        </tr>



        <tr>

          <td><em>Project Type</em></td>

          <td>

            @if(@$data['project']->type == 1)

              {{"Government"}}

            @elseif(@$data['project']->type == 2)

              {{"Corporate"}}

            @elseif(@$data['project']->type == 3)

              {{"International"}}

            @endif    

          </td>

        </tr>



        <tr>

          <td><em>Tenure (in years)</em></td>

          <td>

            {{@$data['project']->tenure_years}}

          </td>

        </tr>



        <tr>

          <td><em>Tenure (in months)</em></td>

          <td>

            {{@$data['project']->tenure_months}}

          </td>

        </tr>



        <tr>

          <td><em>Project Agreement</em></td>

          <td>

            @if(!empty($data['documents'][0]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][0]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>Agreement File</em></td>

          <td>

            @if(!empty($data['documents'][1]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][1]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>LOI File</em></td>

          <td>

            @if(!empty($data['documents'][2]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][2]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>Offer Letter File</em></td>

          <td>

            @if(!empty($data['documents'][3]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][3]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>Employee Contract File 1</em></td>

          <td>

            @if(!empty($data['documents'][4]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][4]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>Employee Contract File 2</em></td>

          <td>

            @if(!empty($data['documents'][5]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][5]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>Employee Contract File 3</em></td>

          <td>

            @if(!empty($data['documents'][6]->pivot->name))

              <a target="_blank" href="{{config('constants.uploadPaths.projectDocument').$data['documents'][6]->pivot->name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

            @else
            
              {{"None"}}  

            @endif  

          </td>

        </tr>

        <tr>

          <td><em>Number Of Resources</em></td>

          <td>

            {{@$data['project']->number_of_resources}}

          </td>

        </tr>



        <tr>

          <td><em>Company Name</em></td>

          <td>

            {{@$data['project']->company->name}}

          </td>

        </tr>



        <tr>

          <td><em>PF Account Number</em></td>

          <td>

            {{@$data['project']->company->pf_account_number}}

          </td>

        </tr>



        <tr>

          <td><em>State(s)</em></td>

          <td>

            <table class="table table-striped">

                <tr>
                  <th>Name</th>
                  <th>PT Certificate Number</th>
                </tr>

                @foreach($data['states'] as $key => $value)
                <tr>
                  <td>{{$value['state']->name}}</td>
                  <td>
                    @if(!$value['state']->has_pt)
                      {{'NA'}}
                    @elseif(!empty($value['pt_data']))
                      {{$value['pt_data']->certificate_number}}
                    @endif
                  </td>
                </tr>
                @endforeach

            </table>    

          </td>

        </tr>

        <tr>

          <td><em>Location(s)</em></td>

          <td>

            <table class="table table-striped">

                <tr>
                  <th>Name</th>
                  <th>ESI Number</th>
                </tr>

                @foreach($data['locations'] as $key => $value)
                <tr>
                  <td>{{$value['location']->name}}</td>
                  <td>
                    @if(!$value['location']->has_esi)
                      {{'NA'}}
                    @elseif(!empty($value['esi_data']))
                      {{$value['esi_data']->esi_number}}
                    @endif
                  </td>
                </tr>
                @endforeach

            </table>

          </td>

        </tr>

        <tr>

          <td><em>Responsible Person(s)</em></td>

          <td>

            @foreach(@$data['project']->projectResponsiblePersons as $person)

            <span class="label label-success">{{$person->user->employee->fullname}}</span>&nbsp;

            @endforeach

          </td>

        </tr>



        <tr>

          <td><em>Project Contact(s)</em></td>

          <td>

            @if(!@$data['project']->projectContacts->isEmpty())

              <table class="table table-striped">

                <tr>

                  <th>Name</th>

                  <th>Email</th>

                  <th>Mobile No.</th>

                  <th>Role</th>

                </tr>



                @foreach(@$data['project']->projectContacts as $contact)

                <tr>

                  <td>{{@$contact->name}}</td>

                  <td>{{@$contact->email}}</td>

                  <td>

                    {{@$contact->mobile_number}}

                  </td>

                  <td>{{@$contact->role}}</td>

                </tr>

                @endforeach

                

              </table>

              @else

                {{"None"}}

              @endif

          </td>

        </tr>    

        

      </table>

@else

    <span class="text-danger"><strong>No data.</strong></span>

@endif