@if(!empty($data))

  <table class="table table-striped table-bordered">

        <tr>

          <th style="width: 30%">Field</th>

          <th style="width: 70%">Value</th>

        </tr>

        

        <tr>

          <td><em>Name</em></td>

          <td>

            {{@$data->name}}

          </td>

        </tr>



        <tr>

          <td><em>Email</em></td>

          <td>

            {{@$data->email}}

          </td>

        </tr>



        <tr>

          <td><em>Responsible Person</em></td>

          <td>

            {{@$data->responsible_person}}

          </td>

        </tr>



        <tr>

          <td><em>PF Account Number</em></td>

          <td>

            {{@$data->pf_account_number}}

          </td>

        </tr>



        <tr>

          <td><em>Extension</em></td>

          <td>

            {{@$data->extension}}

          </td>

        </tr>



        <tr>

          <td><em>Phone Extension</em></td>

          <td>

            {{@$data->phone_extension}}

          </td>

        </tr>



        <tr>

          <td><em>Phone Number</em></td>

          <td>

            {{@$data->phone_number}}

          </td>

        </tr>



        <tr>

          <td><em>TAN Number</em></td>

          <td>

            {{@$data->tan_number}}

          </td>

        </tr>



        <tr>

          <td><em>Website</em></td>

          <td>

            {{@$data->website}}

          </td>

        </tr> 



        <tr>

          <td><em>Address</em></td>

          <td>

            {{@$data->address}}

          </td>

        </tr>     

        

      </table>

@else

    <span class="text-danger"><strong>No data.</strong></span>

@endif