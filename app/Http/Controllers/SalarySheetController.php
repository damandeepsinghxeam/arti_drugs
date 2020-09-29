<?php


namespace App\Http\Controllers;

use App\Attendance;
use App\Department;
use App\Esi;
use App\Exports\SalarySheetExport;
use App\Pf;
use App\Project;
use App\PtRate;
use App\SalaryHead;
use App\SalarySheetBreakdown;
use App\SalaryStructure;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\SalarySheet;
use App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Imports\SalarySheetImport;
use Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
use Carbon\Carbon;
use Spatie\Permis4sion\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;
class SalarySheetController extends Controller
{

    public function index(){
        $years = range(date("Y"), 2020);
        $projects = Project::where('isactive', 1)->get();
        $departments = Department::where('isactive', 1)->get();
        $employees = Employee::where('isactive', 1)->get();

        $year = '';
        $month = '';
        $project = '';
        $department = '';
        return view('salary_sheet.index', compact('years', 'projects', 'departments', 'employees', 'year', 'month', 'project', 'department'));
    }

    public function report(){
        $years = range(date("Y"), 2020);
        $projects = Project::where('isactive', 1)->get();
        $departments = Department::where('isactive', 1)->get();
        $employees = Employee::where('isactive', 1)->get();

        $year = '';
        $month = '';
        $project = '';
        $department = '';
        return view('salary_sheet.report', compact('years', 'projects', 'departments', 'employees', 'year', 'month', 'project', 'department'));
    }

    /*
     * Create Salary Sheet
     */
    public function create(){
        $employeeCodes = Employee::where('isactive',1)->where('cover_amount','!=','')->get()->pluck('employee_id');
        $years = range( date("Y") , 2020 );
        $months = array();
        for ($i = 0; $i < 12; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $months[date('n', $timestamp)] = [date('m', $timestamp), date('F', $timestamp)];
        }

        $projects = Project::where('isactive', 1)->get();
        $departments = Department::where('isactive', 1)->get();
        return view('salary_sheet.create', compact('employeeCodes', 'years', 'months', 'projects', 'departments'));
    }

    public function store(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $project = Project::where('id', $request->project_id)->first();
//        if($request->department_id != 'all') {
//            $department = Department::where('id', $request->department_id)->first();
//            if (SalarySheet::where('year', $year)->where('month', $month)->where('project', $project->name)->where('department', $department->name)->exists()) {
//                return back()->with('error', 'Salary Sheet Already Added');
//            }
//        }

        $employeeUserIds = $this->getEmployeesDepartmentWise($project, $request->department_id);

        foreach($employeeUserIds as $employeeUserId) {
            $user = User::where('id', $employeeUserId->user_id)->first();

            /*
             * Get Employee Department
             */
            $department = $this->employeeDepartment($user);

            /*
             * Get Employee Designation
             */
           $designation = $this->employeeDesignation($user);

            /*
             * Employee Salary Structure
             */
            $employeeEarningSalaryStructure = DB::table('employee_salary_structures')->where('user_id', $user->id)->where('calculation_type', 'earning')->get();
            $employeeEarning = DB::table('employee_salary_structures')->where('user_id', $user->id)->where('calculation_type', 'earning')->sum('value');

            $employeeDeductionSalaryStructure = DB::table('employee_salary_structures')->where('user_id', $user->id)->where('calculation_type', 'deduction')->get();
            $employeeDeductions = DB::table('employee_salary_structures')->where('user_id', $user->id)->where('calculation_type', 'deduction')->sum('value');

            if(isset($employeeEarningSalaryStructure[0])) {

                /*
                 * Calculate PF
                 */
                $pf = $this->calculatePF($project, $user, $employeeEarningSalaryStructure);

                /*
                 * Calculate ESI
                 */
                $esi = $this->calculateESI($employeeEarning);


                /*
                 * Calculate PT-RATE
                 */
                if(DB::table('salary_structures')->where('project_id', $project->id)->first()->pt_rate_applicable == 1) {
                    $pt = $this->calculatePT($user, $employeeEarning);
                }
                else {
                    $pt = 0;
                }

     $totalDeduction = $employeeDeductions + $pf + $esi + $pt;

                $employeeMonthlySalary = $employeeEarning - $totalDeduction;
                $totalSalaryMonthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $salaryPerDay = $this->employeeSalaryPerDay($user, $employeeMonthlySalary, $totalSalaryMonthDays);

                $employeeAttendance = DB::table('attendance_results')->where('user_id', $user->id)->whereYear('on_date', $year)->whereMonth('on_date', $month)->first();
                if ($employeeAttendance != '') {
                    $salarySheet = '';
                    if(SalarySheet::where('year', $year)->where('month', $month)->where('user_id', $user->id)->count() == 0) {
                        $employeePresentDays = $employeeAttendance->total_present_days;
                        $salarySheet = SalarySheet::create([
                            'year' => $year,
                            'month' => $month,
                            'user_id' => $user->id,
                            'employee_code' => $user->employee_code,
                            'project' => $project->name,
                            'designation' => $designation[0],
                            'department' => $department,
                            'total_month_days' => $totalSalaryMonthDays,
                            'paid_days' => $employeePresentDays,
                            'unpaid_days' => $totalSalaryMonthDays - $employeePresentDays,
                            'salary' => round($salaryPerDay * $employeePresentDays),
                            'gross_salary' => round($employeeMonthlySalary),
                            'esi' => round($esi),
                            'pf' => round($pf),
                            'pt' => round($pt),
                            'total_earning' => round($employeeEarning),
                            'total_deduction' => round($totalDeduction)
                        ]);

                        foreach ($employeeEarningSalaryStructure as $earningHeads) {
                            $salaryHeadName = SalaryHead::where('id', $earningHeads->salary_head_id)->first()->name;
                            DB::table('salary_sheet_breakdowns')->insert([
                                'salary_sheet_id' => $salarySheet->id,
                                'salary_head_id' => $earningHeads->salary_head_id,
                                'salary_head_name' => $salaryHeadName,
                                'salary_head_type' => $earningHeads->calculation_type,
                                'value' => $earningHeads->value
                            ]);
                        }

                        foreach ($employeeDeductionSalaryStructure as $deductionHeads) {
                            $salaryHeadName = SalaryHead::where('id', $deductionHeads->salary_head_id)->first()->name;
                            DB::table('salary_sheet_breakdowns')->insert([
                                'salary_sheet_id' => $salarySheet->id,
                                'salary_head_id' => $deductionHeads->salary_head_id,
                                'salary_head_name' => $salaryHeadName,
                                'salary_head_type' => $deductionHeads->calculation_type,
                                'value' => $deductionHeads->value
                            ]);
                        }
                    }

                } else {
                    $employeeNotHavingAttendances[] = $user->employee_code;
                }
            }else{
                $employeeNotHavingSalaryStructures[] = $user->employee_code;
            }
        }

        if(isset($employeeNotHavingSalaryStructures) AND !isset($employeeNotHavingAttendances)){
            return redirect()->route('payroll.salary.sheet.index')->with('employee_not_having_salary_structure', $employeeNotHavingSalaryStructures)->with('success', 'Salary Sheet created successfully!');
        }elseif(!isset($employeeNotHavingSalaryStructures) AND isset($employeeNotHavingAttendances)){
            return redirect()->route('payroll.salary.sheet.index')->with('employee_not_having_attendance', $employeeNotHavingAttendances)->with('success', 'Salary Sheet created successfully!');
        }elseif(isset($employeeNotHavingSalaryStructures) AND isset($employeeNotHavingAttendances)){
            return redirect()->route('payroll.salary.sheet.index')->with('employee_not_having_salary_structure', $employeeNotHavingSalaryStructures)->with('employee_not_having_attendance', $employeeNotHavingAttendances)->with('success', 'Salary Sheet created successfully!');
        }
        return redirect()->route('payroll.salary.sheet.index')->with('success', 'Salary Sheet created successfully!');
    }

    /*
     * Employees List according to department
     */
    public function getEmployeesDepartmentWise($project, $department){
        if ($department == 'all') {
            $employeeUserIds = $project->users->pluck('pivot');
        }
        else{
            $employeeUserIds =  DB::table('employees')
                ->join('employee_profiles', 'employee_profiles.user_id', 'employees.user_id')
                ->join('project_user', 'project_user.user_id', 'employees.user_id')
                ->where('employee_profiles.department_id', $department)
                ->where('project_user.project_id', $project->id)
                ->where('employees.isactive', 1)
                ->select('employees.user_id')->get();
        }
        return $employeeUserIds;
    }

    /*
     * Employee Department
     */
    public function employeeDepartment($user){
        $employeeDepartmentId = DB::table('employee_profiles')->where('user_id', $user->id)->first()->department_id;
        $department = Department::where('id', $employeeDepartmentId)->first()->name;

        return $department;
    }

    /*
     * Employee Designation
     */
    public function employeeDesignation($user){
        $designation[] = '';
        $designation = $user->designation->pluck('name');

        if(!isset($designation[0])){
            $designation[] = '--';
        }
        return $designation;
    }

    /*\     * Calculate Employee PF
     */
    public function calculatePF($project, $user, $employeeEarningSalaryStructure){
        $pfSalaryHeads = SalaryStructure::where('project_id', $project->id)->where('salary_cycle_id', $employeeEarningSalaryStructure[0]->salary_cycle_id)->where('pf_applicable', 1)->get()->pluck('salary_head_id')->toArray();
        $employeePfSalaryHeadsValue = DB::table('employee_salary_structures')->where('user_id', $user->id)->whereIn('salary_head_id', $pfSalaryHeads)->sum('value');

        $employeeBirthDate = DB::table('employees')->where('user_id', $user->id)->first()->birth_date;
        $employeeAge = Carbon::parse($employeeBirthDate)->age;
        if ($employeeAge <= 60) {
            if ($employeePfSalaryHeadsValue <= 15000) {
                $activePfPercent = Pf::where('is_active', 1)->first()->total_pf;
                $pf = ($employeePfSalaryHeadsValue / 100) * $activePfPercent;
            } elseif (DB::table('employee_salary_structures')->where('user_id', $user->id)->first()->restrict_pf == 1) {
                $activePfPercent = Pf::where('is_active', 1)->first()->total_pf;
                $pf = (15000 / 100) * $activePfPercent;
            }else {
                $pf = 0;
            }
        } else {
            $pf = 0;
        }

        return $pf;
    }

    /*
     * Calculate Employee ESI
     */
    public function calculateESI($employeeEarning){
        $activeEsi = Esi::where('is_active', 1)->first();
        $totalEsiPercent = $activeEsi->employee_percent;
        if ($employeeEarning < $activeEsi->cutoff) {
            $esi = ($employeeEarning / 100) * $totalEsiPercent;
            $esi = round($esi);
        } else {
            $esi = 0;
        }
        return $esi;
    }

    /*
     * Calculate Employee PT-Rate
     */
    public function calculatePT($user, $employeeEarning){
        if (DB::table('employee_salary_structures')->where('user_id', $user->id)->first()->pt_rate_applied == 1) {
            $employeeState = DB::table('employee_profiles')->where('user_id', $user->id)->first()->state_id;
            $ptRate = PtRate::where('state_id', $employeeState)->first();
            if (isset($ptRate)) {
                $ptRateRanges = DB::table('pt_rate_salary_ranges')->where('pt_rate_id', $ptRate->id)->where('min_salary', '<=', $employeeEarning)->where('max_salary', '>=', $employeeEarning)->first();
                if (isset($ptRateRanges)) {
                    $pt = $ptRateRanges->pt_rate;
                } else {
                    $pt = 0;
                }
            } else {
                $pt = 0;
            }
        } else {
            $pt = 0;
        }

        return $pt;
    }

    /*
     * Get Employee Per Day Salary
     */
    public function employeeSalaryPerDay($user, $employeeMonthlySalary, $totalSalaryMonthDays){
        $employee = Employee::where('user_id', $user->id)->first();
        $salaryPerDay = ($employeeMonthlySalary / $totalSalaryMonthDays);
        return $salaryPerDay;
    }

    /*
     * Filter Salary Sheets
     */
    public function filter(Request $request){
        if($request->department != 'all') {
            if($request->salary_sheet_status != 'all') {
                $salarySheets = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('project', $request->project)->where('department', $request->department)->where('status', $request->salary_sheet_status)->get();
            }else{
                $salarySheets = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('project', $request->project)->where('department', $request->department)->get();
            }
        }else{
            if($request->salary_sheet_status != 'all') {
                $salarySheets = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('project', $request->project)->where('status', $request->salary_sheet_status)->get();
            }else {
                $salarySheets = SalarySheet::where('year', $request->year)->where('month', $request->month)->where('project', $request->project)->get();
            }
        }

        if($salarySheets != '') {
            $updatedSalarySheets = [];
            if ($request->report == '') {
                foreach ($salarySheets as $salarySheet) {


                    if (Auth::user()->can('for-approve-salary-sheet') AND Auth::user()->can('hold-salary-sheet')) {
                        if ($salarySheet->status == 'new') {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                        if ($salarySheet->status == 'on_hold') {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                        if ($salarySheet->status == 'process_salary') {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                    }
                    if (Auth::user()->can('hold-salary-sheet') AND Auth::user()->can('approve-salary-sheet')) {
                        if ($salarySheet->status == 'on_hold' AND $salarySheet->send_for_approval == 1) {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                        if ($salarySheet->status == 'approved' AND $salarySheet->send_for_approval == 1) {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                        if ($salarySheet->status == 'process_salary' AND $salarySheet->send_for_approval == 1) {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                    }
                    if (Auth::user()->can('pay-salary-sheet')) {
                        if ($salarySheet->status == 'approved') {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                        if ($salarySheet->status == 'paid') {
                            $updatedSalarySheets[] = $salarySheet;
                        }
                    }
                }
                $salarySheets = $updatedSalarySheets;
            }


            $output = "";
            $serialNumber = 1;
            $redirect_url = '?id='.'&year='.'&month=';
            $extraIncome = "";
            $extraIncome = $this->extraIncomeDeductionButton() ;

            $salarySheetStatus = "";
            $salarySheetStatus = $this->salarySheetStatusButton();

            $allStatus[] = '';
            $salarySheetIds[] = '';
            foreach ($salarySheets as $key => $salarySheet) {
                $allStatus[] = $salarySheet->status;
                $salarySheetIds[] = $salarySheet->id;
                $output .= '<tr>' .
                    $this->salarySheetStatus($salarySheet, $serialNumber, $request->report).
                    '<td>' . $salarySheet->project . '</td>' .
                    '<td>' . $salarySheet->department . '</td>' .
                    '<td>' . $salarySheet->total_month_days . '</td>' .
                    '<td>' . $salarySheet->paid_days . '</td>' .
                    '<td>' . $salarySheet->gross_salary . '</td>' .
                    '<td>' . $salarySheet->total_earning . '</td>'.
                    '<td>' . $salarySheet->total_deduction . '</td>'.
                    '<td>' . $salarySheet->salary . '</td>' .
                    '<td>' .
                    '<span class="btn bg-purple" data-toggle="modal" data-target="' . '#salaryBreakdown' . $salarySheet->id . '">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </span>'.
                    '<div class="modal" id="' . 'salaryBreakdown' . $salarySheet->id . '">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->

                                                    <div class="modal-header">


                                                        <h4 class="modal-title">' .
                    Employee::where('user_id', $salarySheet->user->id)->first()->fullname
                    . ' Salary Breakdown</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                                                    <div class="row">
                                                                    <div class="col-md-6">
                                                                    <h4>Earning Heads</h4>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Heads</th>
                                                                               <th>Amount</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>'.
                    $this->earningHeads($salarySheet)
                    .'</tbody>
                                                                        </table>
                                                                        <h4>Other Earning</h4>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                            <th>Earning Name</th>

                                                                            <th>Value</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>'.
                    $this->arrear($salarySheet)
                    .'</tbody>
                                                                        </table>
                                                                        <h3>Total Earning</h3><h4>'. $salarySheet->total_earning .'</h4>'.'
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                    <h4>Deduction Heads</h4>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Heads</th>
                                                                                <th>Amount</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>'.
                    $this->deductionHeads($salarySheet)
                    .'</tbody>
                                                                        </table>
                                                                        <h4>Other Deductions</h4>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                            <th>Deduction Name</th>
                                                                            <th>Value</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>'.

                    '<tr><td>PF</td><td>'. $salarySheet->pf .'</td</tr>'.
                    '<tr><td>ESI</td><td>'. $salarySheet->esi .'</td</tr>'.
                    '<tr><td>PT</td><td>'. $salarySheet->pt .'</td</tr>'.
                    $this->deduction($salarySheet)
                    .'</tbody>
                                                                        </table>
                                                                        <h3>Total Deduction</h3><h4>'. $salarySheet->total_deduction .'</h4>'.'
                                                                    </div>
                                                                </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>'
                    . '</td>' .
                    '</tr>';    $serialNumber++;
            }

            if(in_array('new', $allStatus)){
                $sendForApprovalButton = '';
            }else{
                if (Auth::user()->can('for-approve-salary-sheet') AND Auth::user()->can('hold-salary-sheet')) {
                    $sendForApprovalButton = '<button type="submit" class="btn btn-primary" name="status" value="send_for_approval" id="send_for_approval">Send For Approval</button>';
                }else{
                    $sendForApprovalButton = '';
                }
            }

            $project = Project::where('name', $request->project)->first();
            if($request->department != 'all') {
                $department = Department::where('name', $request->department)->first();

                $employees = DB::table('employees')
                    ->join('employee_profiles', 'employee_profiles.user_id', 'employees.user_id')
                    ->join('project_user', 'project_user.user_id', 'employees.user_id')
                    ->where('employee_profiles.department_id', $department->id)
                    ->where('project_user.project_id', $project->id)
                    ->where('employees.isactive', 1)
                    ->select('employees.user_id', 'employees.fullname')->orderBy('employees.fullname', 'ASC')->get();
            }else{
                $employees = DB::table('employees')
                    ->join('employee_profiles', 'employee_profiles.user_id', 'employees.user_id')
                    ->join('project_user', 'project_user.user_id', 'employees.user_id')
                    ->where('project_user.project_id', $project->id)
                    ->where('employees.isactive', 1)
                    ->select('employees.user_id', 'employees.fullname')->orderBy('employees.fullname', 'ASC')->get();
            }
            return Response::json(['table_data' => $output, 'data' => $salarySheets, 'all_salary_sheet_id' => $salarySheetIds, 'extra_income' => $extraIncome, 'employees' =>  $employees, 'salary_sheet_status' => $salarySheetStatus, 'send_for_approval' => $sendForApprovalButton ]);
        }
    }

    /*
     * Extra Income/Deduction Button
     */
    public function extraIncomeDeductionButton(){
        $button = '';
        if (Auth::user()->can('add-arrear')) {
            $button .= '<a href = "#" data-toggle = "modal" data-target = "#add_arrear_modal" >
                         <button type = "button" class="btn btn-xs btn-primary" ><i class="fa fa-plus" ></i > Add Arrears </button >
                        </a >';
        }
        if (Auth::user()->can('add-deduction')) {
            $button .= '<a href="#" data-toggle="modal" data-target="#add_deduct_modal">
                        <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add Deductions</button>
                         </a>';
        }
        return $button;
    }

    /*
     * Salary Sheet Status Button
     */
    public function salarySheetStatusButton(){
        $buttton = '';
        if (Auth::user()->can('for-approve-salary-sheet')) {
            $buttton .= '<button type="submit" class="btn btn-warning" name="status" value="process_salary">Process Salary</button> ';
        }
        if (Auth::user()->can('hold-salary-sheet')) {
            $buttton .= '<button type="submit" class="btn btn-danger" name="status" value="on_hold">Hold Salary</button> ';
        }
        if (Auth::user()->can('approve-salary-sheet')) {
            $buttton .= '<button type="submit" class="btn btn-success" name="status" value="approved">Approve Salary</button> ';
        }
        if (Auth::user()->can('pay-salary-sheet')) {
            $buttton .= '<button type="submit" class="btn btn-primary " name="status" value="paid">Pay Salary</button>';
        }
        return $buttton;
    }

    /*
     * Employee Earning Heads
     */
    public function earningHeads($salarySheet){
        $earningBreakdownHeads =  '';
        $earningHeads = $salarySheet->salaryBreakdowns->where('salary_head_type', 'earning');
        foreach($earningHeads as $earningHead) {
            $earningBreakdownHeads .= '<tr><td>' . ucwords($earningHead->salary_head_name) . '</td>'.
                '<td>' . $earningHead->value . '</td></tr>';
        }
        return $earningBreakdownHeads;
    }

    /*
     * Employee Deduction Heads
     */
    public function deductionHeads($salarySheet){
        $deductionBreakdownHeads =  '';
        $deductionHeads = $salarySheet->salaryBreakdowns->where('salary_head_type', 'deduction');
        foreach($deductionHeads as $deductionHead) {
            $deductionBreakdownHeads .= '<tr><td>' . ucwords($deductionHead->salary_head_name) . '</td>'.
                '<td>' . $deductionHead->value . '</td></tr>';
        }
        return $deductionBreakdownHeads;
    }

    /*
     * Salary Sheet Status
     */
    public function salarySheetStatus($salarySheet, $serialNumber, $report){
        if($salarySheet->status == 'process_salary') {
            if (Auth::user()->can('for-approve-salary-sheet')) {
                return '<td class="status_checkbox">' . '<input type="checkbox" name="salary_sheet_id[]" value="' . $salarySheet->id . '" checked disabled>' . '</td>' .
                    '<td>' . $serialNumber . '</td>' .
                    '<td style="background: #e08e0b; color:white">' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
            }else{
                return '<td class="status_checkbox">' . '<input type="checkbox" name="salary_sheet_id[]" value="' . $salarySheet->id . '" >' . '</td>' .
                    '<td>' . $serialNumber . '</td>' .
                    '<td style="background: #e08e0b; color:white">' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
            }
        }elseif($salarySheet->status == 'on_hold'){
            return '<td class="status_checkbox">'.'<input type="checkbox" name="salary_sheet_id[]" value="'.$salarySheet->id.'">'.'</td>'.
                '<td>' . $serialNumber . '</td>' .
                '<td style="background: red; color:white">' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
        }elseif($salarySheet->status == 'approved'){
            if (Auth::user()->can('approve-salary-sheet')) {
                return '<td class="status_checkbox">' . '<input type="checkbox" name="salary_sheet_id[]" value="' . $salarySheet->id . '" checked disabled>' . '</td>' .
                    '<td>' . $serialNumber . '</td>' .
                    '<td style="background: green; color:white">' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
            }else{
                return '<td class="status_checkbox">' . '<input type="checkbox" name="salary_sheet_id[]" value="' . $salarySheet->id . '">' . '</td>' .
                    '<td>' . $serialNumber . '</td>' .
                    '<td style="background:green; color:white">' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
            }
        }elseif($salarySheet->status == 'paid'){
            return '<td class="status_checkbox">'.'<input type="checkbox" name="salary_sheet_id[]" value="'.$salarySheet->id.'" checked disabled>'.'</td>'.
                '<td>' . $serialNumber . '</td>' .
                '<td style="background: #3c8dbc; color:white">' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
        }else{
            return '<td class="status_checkbox">'.'<input type="checkbox" name="salary_sheet_id[]" value="'.$salarySheet->id.'">'.'</td>'.
                '<td>' . $serialNumber . '</td>' .
                '<td>' . Employee::where('user_id', $salarySheet->user->id)->first()->fullname . '</td>';
        }
    }

    /*
     * Get Arrear Of SalarySheet
     */
    public  function arrear($salarySheet){
        $arrear = \Illuminate\Support\Facades\DB::table('arrears')->where('year', $salarySheet->year)->where('month', $salarySheet->month)->where('project', $salarySheet->project)
            ->where('user_id', $salarySheet->user->id)->first();

        if(isset($arrear) != '')
            $arrear = $arrear->amount;
        else {
            $arrear = 0.00;
        }
        return '<tr><td>Arrear</td><td>'. $arrear .'</td</tr>';
    }

    /*
    * Get Deduction Of SalarySheet
    */
    public  function deduction($salarySheet){
        $deduction = \Illuminate\Support\Facades\DB::table('deductions')->where('year', $salarySheet->year)->where('month', $salarySheet->month)->where('project', $salarySheet->project)
            ->where('user_id', $salarySheet->user->id)->first();

        if(isset($deduction) != '')
            $deduction = $deduction->amount;
        else {
            $deduction = 0.00;
        }
        return '<tr><td>Deductions</td><td>'. $deduction .'</td</tr>';
    }

    /*
     * Export SalarySheets
     */
    public function export(Request $request){
        $year = $request->year;
        $month = $request->month;
        $project = $request->project;
        $department = $request->department;

        if($request->department != 'all') {
            if($request->salary_sheet_status != 'all') {
                $salarySheets = SalarySheet::where('year', $year)->where('month', $month)->where('project', $project)->where('department', $department)->where('status', $request->salary_sheet_status)->get();
            }else{
                $salarySheets = SalarySheet::where('year', $year)->where('month', $month)->where('project', $project)->where('department', $department)->get();
            }
        }else{
            if($request->salary_sheet_status != 'all') {
                $salarySheets = SalarySheet::where('year', $year)->where('month', $month)->where('project', $project)->where('status', $request->salary_sheet_status)->get();
            }else {
                $salarySheets = SalarySheet::where('year', $year)->where('month', $month)->where('project', $project)->get();
            }
        }

        $projectId = Project::where('name',$project)->first()->id;
        $projectEarningHeads = DB::table('salary_structures')->join('salary_heads', 'salary_structures.salary_head_id', '=', 'salary_heads.id')->where('project_id', $projectId)->where('calculation_type', 'earning')->select('name')->get();
        $projectDeductionHeads = DB::table('salary_structures')->join('salary_heads', 'salary_structures.salary_head_id', '=', 'salary_heads.id')->where('project_id', $projectId)->where('calculation_type', 'deduction')
            ->whereNull('salary_structures.deleted_at')->select('name')->get();

//        return view('salary_sheet.export', compact('salarySheets', 'projectEarningHeads', 'projectDeductionHeads', 'year', 'month'));

        return Excel::download(new SalarySheetExport($salarySheets, $projectEarningHeads, $projectDeductionHeads, $year, $month), 'salary-sheet.xlsx');
    }

    /*
     * Change SalarySheet Status
     */
    public function pay(Request $request){
        if($request->status == 'send_for_approval'){
            $salrySheetIds =  explode(",",$request->all_salary_sheet_id);
            foreach ($salrySheetIds as $salarySheetId){
                SalarySheet::where('id', $salarySheetId)->update([
                    'send_for_approval' => 1
                ]);
            }
        }else {

            if($request->salary_sheet_id == ''){
                return redirect()->route('payroll.salary.sheets', [$request->status_year, $request->status_month, $request->status_project, $request->status_department])->with('error', "Select atleast single employee to change status");

            }

            foreach ($request->salary_sheet_id as $salarySheetId) {
                SalarySheet::where('id', $salarySheetId)->update([
                    'status' => $request->status
                ]);
            }
        }

        return redirect()->route('payroll.salary.sheets', [$request->status_year, $request->status_month, $request->status_project, $request->status_department])->with('success', "Salary Sheet Status Updated Successfully");
    }

    /*
     * Add Arrear Or Deduction To SalarySheet
     */
    public function extraIncomeDeduction(Request $request){
        $years = range( date("Y") , 2020 );
        $projects = Project::where('isactive', 1)->get();
        $departments = Department::where('isactive', 1)->get();
        $employees = Employee::where('isactive', 1)->get();
        $year = $request->extra_income_year;
        $month = $request->extra_income_month;
        $project = $request->extra_income_project;
        $department = $request->extra_income_department;

        if($request->extra_income_type == 'arrear'){
            if(DB::table('arrears')->where('year', $request->extra_income_year)->where('month', $request->extra_income_month)
                ->where('user_id', $request->employee)->doesntExist()) {
                DB::table('arrears')->insert([
                    'year' => $request->extra_income_year,
                    'month' => $request->extra_income_month,
                    'project' => $request->extra_income_project,
                    'department' => $request->extra_income_department,
                    'user_id' => $request->employee,
                    'amount' => $request->add_arrear_amount,
                    'reason' => $request->add_arrear_reason,
                    'remark' => $request->add_arrear_remarks,
                ]);
                $employee = SalarySheet::where('user_id', $request->employee)->where('year', $request->extra_income_year)->where('month', $request->extra_income_month)->first();
                $employeeSalary = $employee->salary;
                $employeeTotalEarning = $employee->total_earning;
                SalarySheet::where('user_id', $request->employee)->where('year', $request->extra_income_year)->where('month', $request->extra_income_month)->update([
                    'salary' => $employeeSalary + $request->add_arrear_amount,
                    'total_earning' => $employeeTotalEarning + $request->add_arrear_amount
                ]);

                $employee = Employee::where('user_id', $request->employee)->first();
                return redirect()->route('payroll.salary.sheets', [$year, $month, $project, $department])->with('success', $employee->fullname." Arrear added successfully");
            }else{
                $employee = Employee::where('user_id', $request->employee)->first();
                return redirect()->route('payroll.salary.sheets', [$year, $month, $project, $department])->with('error', $employee->fullname." Arrear already added");
            }

        }elseif($request->extra_income_type == 'deduction'){
            if(DB::table('deductions')->where('year', $request->extra_income_year)->where('month', $request->extra_income_month)
                ->where('user_id', $request->employee)->doesntExist()) {
                DB::table('deductions')->insert([
                    'year' => $request->extra_income_year,
                    'month' => $request->extra_income_month,
                    'project' => $request->extra_income_project,
                    'department' => $request->extra_income_department,
                    'user_id' => $request->employee,
                    'amount' => $request->add_deduct_amount,
                    'reason' => $request->add_deduct_reason,
                    'remark' => $request->add_deduct_remarks,
                ]);
                $employee =  SalarySheet::where('user_id', $request->employee)->where('year', $request->extra_income_year)->where('month', $request->extra_income_month)->first();
                $employeeSalary = $employee->salary;
                $employeeTotalDeduction = $employee->total_deduction;
                SalarySheet::where('user_id', $request->employee)->where('year', $request->extra_income_year)->where('month', $request->extra_income_month)->update([
                    'salary' =>  $employeeSalary - $request->add_deduct_amount,
                    'total_deduction' => $employeeTotalDeduction + $request->add_deduct_amount
                ]);
                $employee = Employee::where('user_id', $request->employee)->first();
                return redirect()->route('payroll.salary.sheets', [$year, $month, $project, $department])->with('success', $employee->fullname." Deduction added successfully");

            }else{
                $employee = Employee::where('user_id', $request->employee)->first();
                return redirect()->route('payroll.salary.sheets', [$year, $month, $project, $department])->with('error', $employee->fullname." Deduction already added");
            }
        }
    }

    public function salarySheets($year, $month, $project, $department= ''){
        $years = range( date("Y") , 2020 );
        $projects = Project::where('isactive', 1)->get();
        $departments = Department::where('isactive', 1)->get();
        $employees = Employee::where('isactive', 1)->get();
        return view('salary_sheet.index', compact('years', 'projects', 'departments', 'employees', 'year', 'month', 'project', 'department'));
    }

    public function upload(Request $request){
        if($request->hasFile('file')){

            $data = Excel::toArray(new SalarySheetImport(), $request->file('file'));

            foreach ($data[0] as $key => $row) {
                if($key > 0) {

                    $user = User::where('employee_code', $row[0])->first();
                    if($user != '') {
                        $employee = Employee::where('user_id', $user->id)->first();
                        if ($employee->isactive == 1) {
                            $ctc = str_replace(',', '', $employee->cover_amount);
                            $monthlySalary = ($ctc / 12);
                            $salaryPerDay = ($monthlySalary / 30);

                            $time=strtotime($request->salary_of);
                            $month=date("m",$time);
                            $year=date("Y",$time);

                            $employeePresentDays = DB::table('attendance_results')->where('user_id', $employee->user_id)->whereYear('on_date', $year)->whereMonth('on_date', $month)->get()->count();
                            $totalCurrentMonthDays = date('t');

                            $arr[] = [
                                'employee_code' => $row[0],
                                'date' => $request->salary_of,
                                'total_month_days' => $totalCurrentMonthDays,
                                'year' => $year,
                                'month' => $month,
                                //'paid_days' => $request->paid_days,
                                'paid_days' => $employeePresentDays,
                                'unpaid_days' => $totalCurrentMonthDays - $employeePresentDays,
                                'salary' => $salaryPerDay * $employeePresentDays,
                                'gross_salary' => $monthlySalary
                            ];
                        } else {
                            $notActiveEmployees[] = $employee->employee_id;
                        }
                    }else{
                        $wrongEmployeeCode[] =  $row[0];
                    }
                }
            }
            if(!empty($arr)){
                \DB::table('salary_sheets')->insert($arr);
                if(isset($notActiveEmployees) AND $notActiveEmployees != '') {
                    return redirect()->route('payroll.salary.sheet.index')->with('success', 'Salary Sheet created successfully!')->withErrors([$notActiveEmployees, 'These are not active employees']);
                }elseif(isset($wrongEmployeeCode) AND $wrongEmployeeCode != ''){
                    return redirect()->route('payroll.salary.sheet.index')->with('success', 'Salary Sheet created successfully!')->withErrors([$wrongEmployeeCode, 'Incorrect Employee Ids']);
                }else{
                    return redirect()->route('payroll.salary.sheet.index')->with('success', 'Salary Sheet created successfully!');
                }
            }else{
                return redirect()->route('payroll.salary.sheet.index');
            }
        }

    }
}
