<table class="table table-striped table-responsive table-bordered"  id="tablexportData">
    <thead class="table-heading-style">
    <tr style="">
        <th>S No.</th>
        <th>Employee Code</th>
        <th>Employee Name</th>
        <th>Father's Name</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Location</th>
        <th>Project</th>
        @foreach($projectEarningHeads as $projectEarningHead)
            <th>{{ ucwords($projectEarningHead->name) }}</th>
        @endforeach
        <th>Arrear</th>
        <th>Total Earning</th>
        @foreach($projectDeductionHeads as $projectDeductionHead)
            <th>{{ ucwords($projectDeductionHead->name) }}</th>
        @endforeach
        <th>PF</th>
        <th>ESI</th>
        <th>PT</th>
        <th>Deduction</th>
        <th>Total Deduction</th>
        <th>Month Days</th>
        <th>Paid Days</th>
        <th>Net Amount</th>
        <th>Salary Status</th>
    </tr>
    </thead>
    <tbody class="kra_tbody">
    <?php $serialNumber = 1; ?>

    @foreach($salarySheets as $salarySheet)
        <tr>
            <td>{{ $serialNumber }}</td>
            <td>{{ $salarySheet->employee_code }}</td>
            @if($salarySheet->status == 'new')
                <td style="font-size: medium; font-weight: bold; height: 30px;letter-spacing: 1px;">{{ \App\Employee::where('user_id',$salarySheet->user->id)->first()->fullname }}</td>
            @elseif($salarySheet->status == 'process_salary')
                <td style="background-color: #e08e0b; color: #ffffff;font-size: medium; font-weight: bold; height: 30px;letter-spacing: 1px;">{{ \App\Employee::where('user_id',$salarySheet->user->id)->first()->fullname }}</td>
            @elseif($salarySheet->status == 'on_hold')
                <td style="background-color: #ff0000; color: #ffffff;font-size: medium; font-weight: bold; height: 30px;letter-spacing: 1px;">{{ \App\Employee::where('user_id',$salarySheet->user->id)->first()->fullname }}</td>
            @elseif($salarySheet->status == 'approved')
                <td style="background-color: #008d4c; color: #ffffff;font-size: medium; font-weight: bold; height: 30px;letter-spacing: 1px;">{{ \App\Employee::where('user_id',$salarySheet->user->id)->first()->fullname }}</td>
            @elseif($salarySheet->status == 'paid')
                <td style="background-color: #367fa9; color: #ffffff;font-size: medium; font-weight: bold; height: 30px;letter-spacing: 1px;">{{ \App\Employee::where('user_id',$salarySheet->user->id)->first()->fullname }}</td>
            @endif
            {{--            style="background-color: #ff0000; color: #ffffff; font-size: medium; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif"--}}
            <td>{{ \App\Employee::where('user_id',$salarySheet->user->id)->first()->father_name }}</td>
            <td>{{ $salarySheet->designation }}</td>
            <td>{{ $salarySheet->department }}</td>
            <td>Mohali</td>
            <td>{{ $salarySheet->project }}</td>
            @foreach(\Illuminate\Support\Facades\DB::table('salary_sheet_breakdowns')->where('salary_sheet_id',$salarySheet->id)->where('salary_head_type', 'earning')->get() as $salaryBreakdown)
                <td>{{ $salaryBreakdown->value }}</td>
            @endforeach
            <td>
                <?php
                $arrear = \Illuminate\Support\Facades\DB::table('arrears')->where('year', $year)->where('month', $month)->where('project', $salarySheet->project)
                    ->where('user_id', $salarySheet->user->id)->first()
                ?>
                @if($arrear != '')
                    {{ $arrear = $arrear->amount }}
                @else
                    {{ $arrear = 0.00 }}
                @endif
            </td>
            <td>{{ $salarySheet->total_earning + $arrear }}</td>
            @foreach(\Illuminate\Support\Facades\DB::table('salary_sheet_breakdowns')->where('salary_sheet_id',$salarySheet->id)->where('salary_head_type', 'deduction')->get() as $salaryBreakdown)
                <td>{{ $salaryBreakdown->value }}</td>
            @endforeach
            <td>{{ $salarySheet->pf }}</td>
            <td>{{ $salarySheet->esi }}</td>
            <td>{{ $salarySheet->pt }}</td>
            <td>
                <?php
                $deduction = \Illuminate\Support\Facades\DB::table('deductions')->where('year', $year)->where('month', $month)->where('project', $salarySheet->project)
                    ->where('user_id', $salarySheet->user->id)->first()
                ?>
                @if($deduction != '')
                    {{ $deduction = $deduction->amount }}
                @else
                    {{ $deduction = 0.00 }}
                @endif
            </td>
            <td>{{ $salarySheet->total_deduction + $deduction }}</td>
            <td>{{ $salarySheet->total_month_days }}</td>
            <td>{{ $salarySheet->paid_days }}</td>
            <td>{{ $salarySheet->salary }}</td>
            <td>{{ $salarySheet->status }}</td>

        </tr>

        <?php $serialNumber++ ?>
    @endforeach
    </tbody>
</table>


