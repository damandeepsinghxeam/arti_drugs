<?php
$usser = Auth::user();
$userBasic = [
    'pic' => config('constants.static.profilePic'),
    "fullName" => ""
];

if(!empty($usser)) {
    $user = getEmployeeProfileData($usser->id);

    if(!empty($user)) {
        $userBasic['fullName'] = $user->fullname;

        if(!empty($user->profile_picture)) {
            $userBasic['pic'] = config('constants.uploadPaths.profilePic').$user->profile_picture;
        }
    }
}
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{@$userBasic['pic']}}" class="img-circle" alt="User Image">
            </div>

            <div class="pull-left info">
                <p>{{@$userBasic['fullName']}}</p>
                <a href="javascript:void(0)"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ url('employees/dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Employees Management</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    @can('create-employee')
                        <li class=""><a href="{{ url('employees/create') }}"><i class="fa fa-circle-o text-red"></i>New Registration</a></li>
                    @endcan
                    <li class=""><a href="{{ url('employees/list') }}"><i class="fa fa-circle-o text-aqua"></i>Employees List</a></li>

                    @can('replace-authority')
                        <li class=""><a href="{{ url('employees/replace-authority') }}"><i class="fa fa-circle-o text-yellow"></i>Replace Authority</a></li>
                    @endcan
                     </ul>
            </li>

{{--            @if(auth()->user()->can('create-company') || auth()->user()->can('edit-company') || auth()->user()->can('approve-company'))--}}
{{--                <li>--}}
{{--                    <a href="{{ url('mastertables/companies') }}">--}}
{{--                        <i class="fa fa-industry"></i> <span>Companies Management</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            @if(auth()->user()->can('create-project') || auth()->user()->can('edit-project') || auth()->user()->can('approve-project'))--}}

{{--                <li class="treeview">--}}
{{--                    <a href="#">--}}
{{--                        <i class="fa fa-sitemap"></i> <span>Project Management</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--              <i class="fa fa-angle-left pull-right"></i>--}}
{{--            </span>--}}
{{--                    </a>--}}

{{--                    <ul class="treeview-menu">--}}
{{--                        @if((auth()->user()->can('create-project')) AND !auth()->user()->can('approve-project'))--}}
{{--                            <li class=""><a href="{{ url('mastertables/projects/add') }}"><i class="fa fa-circle-o text-red"></i>Add Projects</a></li>--}}
{{--                        @endif--}}

{{--                        @if(auth()->user()->can('approve-project'))--}}
{{--                            <li class=""><a href="{{ url('mastertables/approval-projects') }}"><i class="fa fa-circle-o text-red"></i>Projects for approval</a></li>--}}
{{--                        @endif--}}
{{--                        @if((auth()->user()->can('create-project')) AND !auth()->user()->can('approve-project'))--}}
{{--                            <li class=""><a href="{{ url('mastertables/projects') }}"><i class="fa fa-circle-o text-red"></i>My Projects</a></li>--}}
{{--                        @endif--}}

{{--                        <li class=""><a href="{{ url('mastertables/approved-projects') }}"><i class="fa fa-circle-o text-red"></i>All Projects</a></li>--}}

{{--                    </ul>--}}

{{--                </li>--}}

{{--            @endif--}}

{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-sitemap"></i> <span>Master Management</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                      <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--                <ul class="treeview-menu">--}}

{{--                    <li class=""><a href="{{ url('mastertables/designation') }}"><i class="fa fa-circle-o text-red"></i>Manage Designation</a></li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('dms.category.index') }}">--}}
{{--                            <i class="fa fa-th fa-lg"></i> <span>ADD DMS Categories</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('dms.keyword.index') }}">--}}
{{--                            <i class="fa fa-tags fa-lg"></i> <span>ADD DMS Keywords</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class=""><a href="{{ url('mastertables/role') }}"><i class="fa fa-circle-o text-red"></i>Manage Role</a></li>--}}
{{--                    <li><a href="{{ route('conveyance.index') }}"><i class="fa fa-circle-o text-red"></i>Manage Conveyances</a></li>--}}

{{--                </ul>--}}




{{--            </li>--}}

{{--            @can('approve-probation')--}}
{{--                <li>--}}
{{--                    <a href="{{ url('employees/probation-approvals') }}">--}}
{{--                        <i class="fa fa-check-square-o"></i> <span>Probation Management</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}

{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-plane fa-lg"></i> <span>Leaves Management</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                    <i class="fa fa-angle-left pull-right"></i>--}}
{{--                  </span>--}}
{{--                </a>--}}
{{--                <ul class="treeview-menu">--}}
{{--                    <li class=""><a title="Apply for leave" href="{{ url('leaves/apply-leave') }}"><i class="fa fa-circle-o text-red"></i>Apply for leave</a></li>--}}

{{--                    <li class=""><a title="List of applied leave" href="{{ url('leaves/applied-leaves') }}"><i class="fa fa-circle-o text-aqua"></i>Applied Leaves</a></li>--}}

{{--                    @can('approve-leave')--}}
{{--                        <li class=""><a title="list of Approval Employee's leave" href="{{ url('leaves/approve-leaves') }}"><i class="fa fa-circle-o text-success"></i>Approve Leaves</a></li>--}}

{{--                        <li class=""><a title="View leave report" href="{{ url('leaves/leave-report-form') }}"><i class="fa fa-circle-o text-red"></i>Leave Report</a></li>--}}
{{--                @endcan--}}
{{--                <!-- <li class=""><a href="{{ url('leaves/policies') }}"><i class="fa fa-circle-o text-warning"></i>Leave Policies</a></li> -->--}}
{{--                    <!-- <li class=""><a href="javascript:void(0)"><i class="fa fa-circle-o text-primary"></i>Leave Allotment</a></li> -->--}}
{{--                    <li class=""><a href="{{ url('leaves/holidays') }}"><i class="fa fa-circle-o text-secondary"></i>Holidays List</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i> <span>Attendance Management</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a title="View your own attendance" href="{{ url('attendances/my-attendance') }}"><i class="fa fa-circle-o text-red"></i>My Attendance</a></li>
                    <li class=""><a title="Send missed punch request" href="{{ url('attendances/request-change') }}"><i class="fa fa-circle-o text-green"></i>Request Change</a></li>
                    <li class=""><a title="List of sent punch requests" href="{{ url('attendances/requested-changes') }}"><i class="fa fa-circle-o text-yellow"></i>Requested Changes</a></li>
                    @can('view-attendance')
                        <li class=""><a title="View department wise attendance" href="{{ url('attendances/consolidated-attendance-sheets') }}"><i class="fa fa-circle-o text-aqua"></i>Attendance Sheets</a></li>
                        <li class=""><a title="List of attendances to be verified by you" href="{{ url('attendances/verify-attendance-list') }}"><i class="fa fa-circle-o text-purple"></i>Verify Attendance</a></li>
                    @endcan

                    @if(auth()->user()->can('change-attendance') || auth()->user()->can('it-attendance-approver'))
                        <li class=""><a  title="Approve change attendance requests" href="{{ url('attendances/change-approvals') }}"><i class="fa fa-circle-o text-orange"></i>Change Approvals</a></li>
                    @endif
                </ul>
            </li>

{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-clock-o"></i> <span>Task Management</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                    <i class="fa fa-angle-left pull-right"></i>--}}
{{--                  </span>--}}
{{--                </a>--}}
{{--                <ul class="treeview-menu">--}}
{{--                    @can('create-task')--}}
{{--                        <li class=""><a href="{{ url('tasks/create') }}"><i class="fa fa-circle-o text-red"></i>Add Task</a></li>--}}
{{--                        <li class=""><a href="{{ url('tasks/view-tasks') }}"><i class="fa fa-circle-o text-aqua"></i>Created Tasks</a></li>--}}
{{--                    @endcan--}}
{{--                    <li class=""><a title="Send Task Date extend request" href="{{ url('tasks/request-change-date') }}"><i class="fa fa-circle-o text-green"></i>Request date extension</a></li>--}}
{{--                    <li class=""><a title="List of task date change requests" href="{{ url('tasks/requested-change-date') }}"><i class="fa fa-circle-o text-yellow"></i>Requested Date extensions</a></li>--}}

{{--                    @can('create-task')--}}
{{--                        <li class=""><a  title="Approve change task date requests" href="{{ url('tasks/change-task-date-approvals') }}"><i class="fa fa-circle-o text-orange"></i>Approve Date extensions</a></li>--}}
{{--                    @endif--}}
{{--                    <li class=""><a href="{{ url('tasks/my-tasks?task_type=all&my_status=None&task_status=None') }}"><i class="fa fa-circle-o text-success"></i>My Tasks</a></li>--}}
{{--                    <li class=""><a href="{{ url('tasks/task-points') }}"><i class="fa fa-circle-o text-warning"></i>Points System</a></li>--}}
{{--                    @can('task-report')--}}
{{--                        <li class=""><a href="{{ url('tasks/report') }}"><i class="fa fa-circle-o text-secondary"></i>Task Report</a></li>--}}
{{--                    @endcan--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            @if(auth()->user()->can('bd-team.create') || auth()->user()->can('bd-team.index'))--}}
{{--                <li class="treeview">--}}
{{--                    <a href="#">--}}
{{--                        <i class="fa fa-briefcase"></i> <span>B.D Team Management</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                      <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                    </a>--}}

{{--                    <ul class="treeview-menu">--}}
{{--                        @can('bd-team.create')--}}
{{--                            <li class="">--}}
{{--                                <a href="{{ route('bd-team.create') }}">--}}
{{--                                    <i class="fa fa-circle-o text-red"></i>Create B.D Team--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
{{--                        @can('bd-team.index')--}}
{{--                            <li class="">--}}
{{--                                <a href="{{ route('bd-team.index') }}">--}}
{{--                                    <i class="fa fa-circle-o text-aqua"></i>List B.D Team--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            @php--}}
{{--                $listRoute    = route('leads-management.index');--}}
{{--                $tilListRoute = route('leads-management.list-til');--}}
{{--                $listCreatedLeads = url('leads-management?lead_type=created&lead_status=all');--}}
{{--                if(in_array($usser->id, [1, 13])) {--}}
{{--                    $listRoute    = route('leads-management.get-leads');--}}
{{--                    $tilListRoute = route('leads-management.get-list-til');--}}
{{--                    $listCreatedLeads=url('leads-management/get-leads?lead_type=created&lead_status=all');--}}
{{--                }--}}

{{--                $routeName = Route::currentRouteName();--}}
{{--                $reqType = request()->segment(2);--}}
{{--                $routeArr = ['leads-management.index', 'leads-management.get-leads'];--}}
{{--                // @if(in_array($reqType, [1, 2]) && $routeName == 'leads-management.index') active @endif--}}
{{--                $ulRouteArr  = $routeArr;--}}
{{--                $ulRouteArr[] ='leads-management.approve-lead';--}}
{{--            @endphp--}}

{{--            <li class="treeview @if(in_array($routeName, $ulRouteArr)) active @endif">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-briefcase"></i> <span>Lead Management</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                        <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                </a>--}}

{{--                <ul class="treeview-menu">--}}
{{--                    <li class="">--}}
{{--                        <a href="{{ route('leads-management.create') }}">--}}
{{--                            <i class="fa fa-circle-o text-red"></i>Create New Lead--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class=""> <!-- @ if(in_array($routeName, $routeArr)) active @ endif -->--}}
{{--                        <a href="{{ $listRoute }}">--}}
{{--                            <i class="fa fa-circle-o text-aqua"></i>Leads List--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="">--}}
{{--                        <a href="{{ $listCreatedLeads }}">--}}
{{--                            <i class="fa fa-circle-o text-green"></i>Created Leads--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @if($usser->id != 13)--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ url('leads-management?lead_type=assigned&lead_status=all') }}">--}}
{{--                                <i class="fa fa-circle-o text-green"></i>Assigned Leads--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                    <li class="@if($routeName == 'leads-management.approve-lead') active @endif">--}}
{{--                        <a href="{{ route('leads-management.approve-lead') }}">--}}
{{--                            <i class="fa fa-circle-o text-green"></i>Recommended Lead--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @if(auth()->user()->can('leads-management.view-til'))--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ $tilListRoute }}">--}}
{{--                                <i class="fa fa-circle-o text-warning"></i>TIL List--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endif--}}

{{--                    @can('leads-management.til-remarks-list')--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ route('leads-management.til-remarks-list') }}">--}}
{{--                                <i class="fa fa-circle-o text-warning"></i>TIL List--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                @endcan--}}
{{--                <!-- <li class="">--}}
{{--                        <a href="{ { route('leads-management.opportunity-progress-status') }}">--}}
{{--                          <i class="fa fa-circle-o text-success"></i>Opportunity Progress Status--}}
{{--                        </a>--}}
{{--                      </li>--}}
{{--                      <li class="">--}}
{{--                        <a href="{ { route('leads-management.follow-up') }}">--}}
{{--                          <i class="fa fa-circle-o text-success"></i>FollowUp--}}
{{--                        </a>--}}
{{--                    </li> -->--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            @if(auth()->user()->can('tender-processing') || auth()->user()->can('assigned-costestimation'))--}}
{{--                <li class="treeview @if(in_array($routeName, $ulRouteArr)) active @endif">--}}
{{--                    <a href="#">--}}
{{--                        <i class="fa fa-briefcase"></i> <span>Tender Processing</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                            <i class="fa fa-angle-left pull-right"></i>--}}
{{--                        </span>--}}
{{--                    </a>--}}

{{--                    <ul class="treeview-menu">--}}
{{--                        @if(auth()->user()->can('tender-processing'))--}}
{{--                            <li class="">--}}
{{--                                <a href="{!! route('leads-management.tender-processing') !!}">--}}
{{--                                    <i class="fa fa-circle-o text-red"></i> Processing TILS--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                        @if(auth()->user()->can('assigned-costestimation'))--}}
{{--                            <li class="">--}}
{{--                                <a href="{!! route('leads-management.assigned-costestimation') !!}">--}}
{{--                                    <i class="fa fa-circle-o text-red"></i> Assigned CostEstimation--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            <li>--}}
{{--                <a href="{{ url('mastertables/kra') }}">--}}
{{--                    <i class="fa fa-cogs"></i> <span>KRA Management</span>--}}
{{--                </a>--}}
{{--            </li>--}}


{{--            --}}{{--            @can('manage-masterTable')--}}
{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-money" aria-hidden="true"></i><span>Payroll Management</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                        <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                </a>--}}

{{--                <ul class="treeview-menu">--}}

{{--                    @can('index-salary-head')--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('payroll.salary.head.index') }}">--}}
{{--                                <i class="fa fa-money fa-lg"></i> <span>Salary Heads</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('index-salary-cycle')--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('payroll.salary.cycle.index') }}">--}}
{{--                                <i class="fa fa-money fa-lg"></i> <span>Salary Cycles</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('index-salary-structure')--}}
{{--                        <li class="treeview">--}}
{{--                            <a href="#">--}}
{{--                                <i class="fa fa-file-text fa-lg"></i> <span>Salary Structures</span>--}}
{{--                                <span class="pull-right-container">--}}
{{--                                    <i class="fa fa-angle-left pull-right"></i>--}}
{{--                                </span>--}}
{{--                            </a>--}}
{{--                            <ul class="treeview-menu">--}}
{{--                                <li class=""><a title="All Pt Rates" href="{{ route('payroll.salary.structure.index') }}"><i class="fa fa-circle-o text-red"></i>All Salary Structures</a></li>--}}
{{--                                @can('create-salary-structure')--}}
{{--                                    <li class=""><a title="Add New Pt Rates" href="{{ route('payroll.salary.structure.create') }}"><i class="fa fa-circle-o text-aqua"></i>Add Salary Structure</a></li>--}}
{{--                                @endcan--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endcan--}}



{{--                    <li class="treeview">--}}
{{--                        <a href="#">--}}
{{--                            <i class="fa fa-file-text fa-lg"></i> <span>Salary Sheets</span>--}}
{{--                            <span class="pull-right-container">--}}
{{--                                    <i class="fa fa-angle-left pull-right"></i>--}}
{{--                                </span>--}}
{{--                        </a>--}}
{{--                        <ul class="treeview-menu">--}}
{{--                            <li class="">--}}
{{--                                <a href="{{ route('payroll.salary.sheet.report') }}">--}}
{{--                                    <i class="fa fa-circle-o text-warning"></i>Salary Sheet Reports--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            @can('index-salary-sheet')--}}
{{--                                <li class="">--}}
{{--                                    <a href="{{ route('payroll.salary.sheet.index') }}">--}}
{{--                                        <i class="fa fa-circle-o text-warning"></i>All Salary Sheets--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endcan--}}

{{--                            @can('create-salary-sheet')--}}
{{--                                <li class="">--}}
{{--                                    <a href="{{ route('payroll.salary.sheet.create') }}">--}}
{{--                                        <i class="fa fa-circle-o text-warning"></i>New Salary Sheet--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endcan--}}
{{--                        </ul>--}}
{{--                    </li>--}}

{{--                    @can('index-pt-rate')--}}
{{--                        <li class="treeview">--}}
{{--                            <a href="#">--}}
{{--                                <i class="fa fa-file-text fa-lg"></i> <span>PT Rates</span>--}}
{{--                                <span class="pull-right-container">--}}
{{--                                    <i class="fa fa-angle-left pull-right"></i>--}}
{{--                                </span>--}}
{{--                            </a>--}}
{{--                            <ul class="treeview-menu">--}}
{{--                                <li class=""><a title="All Pt Rates" href="{{ route('payroll.pt.rate.index') }}"><i class="fa fa-circle-o text-red"></i>All PT Rates</a></li>--}}
{{--                                @can('create-pt-rate')--}}
{{--                                    <li class=""><a title="Add New Pt Rates" href="{{ route('payroll.pt.rate.create') }}"><i class="fa fa-circle-o text-aqua"></i>Add PT Rate</a></li>--}}
{{--                                @endcan--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('index-pf')--}}
{{--                        <li class="treeview">--}}
{{--                            <a href="#">--}}
{{--                                <i class="fa fa-money fa-lg"></i> <span>PF's</span>--}}
{{--                                <span class="pull-right-container">--}}
{{--                        <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                            </a>--}}
{{--                            <ul class="treeview-menu">--}}
{{--                                <li class=""><a title="All Pf's" href="{{ route('payroll.pf.index') }}"><i class="fa fa-circle-o text-red"></i>All PF's</a></li>--}}
{{--                                @can('create-pf')--}}
{{--                                    <li class=""><a title="Add New Pf" href="{{ route('payroll.pf.create') }}"><i class="fa fa-circle-o text-aqua"></i>Add New PF</a></li>--}}
{{--                                @endcan--}}
{{--                                <li class=""><a title="All Pf Rates" href="{{ route('payroll.pf.calculate.form') }}"><i class="fa fa-circle-o text-red"></i>Calculate PF</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endcan--}}


{{--                    @can('index-esi')--}}
{{--                        <li class="treeview">--}}
{{--                            <a href="#">--}}
{{--                                <i class="fa fa-money fa-lg"></i> <span>ESI's</span>--}}
{{--                                <span class="pull-right-container">--}}
{{--                                            <i class="fa fa-angle-left pull-right"></i>--}}
{{--                                        </span>--}}
{{--                            </a>--}}
{{--                            <ul class="treeview-menu">--}}
{{--                                <li class=""><a title="All ESI's" href="{{ route('payroll.esi.index') }}"><i class="fa fa-circle-o text-red"></i>All ESI's</a></li>--}}
{{--                                @can('create-esi')--}}
{{--                                    <li class=""><a title="Add New ESI" href="{{ route('payroll.esi.create') }}"><i class="fa fa-circle-o text-aqua"></i>Add New ESI</a></li>--}}
{{--                                @endcan--}}
{{--                                <li class=""><a title="All Pf Rates" href="{{ route('payroll.esi.calculate.form') }}"><i class="fa fa-circle-o text-red"></i>Calculate ESI</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endcan--}}
{{--                    <li class="treeview">--}}
{{--                        <a href="#">--}}
{{--                            <i class="fa fa-file-text fa-lg"></i> <span>Lwf Management</span>--}}
{{--                            <span class="pull-right-container">--}}
{{--                                    <i class="fa fa-angle-left pull-right"></i>--}}
{{--                                </span>--}}
{{--                        </a>--}}
{{--                        <ul class="treeview-menu">--}}
{{--                            <li class=""><a title="All Lwf's" href="{{ route('payroll.lwf.index') }}"><i class="fa fa-circle-o text-red"></i>All Lwf's</a></li>--}}
{{--                            <li class=""><a title="Add New Lwf" href="{{ route('payroll.lwf.create') }}"><i class="fa fa-circle-o text-aqua"></i>Add Lwf</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            --}}{{--            @endcan--}}



            {{--            <li class="treeview">--}}
            {{--                <a href="#">--}}
            {{--                    <i class="fa fa-file-text fa-lg"></i> <span>Payroll</span>--}}

{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-suitcase"></i> <span>Travel & Expense<br> Management</span>--}}
{{--                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>--}}
{{--                </a>--}}
{{--                <ul class="treeview-menu">--}}
{{--                    <li class="">--}}
{{--                        <a href="{{ url('travel/approval-form') }}">--}}
{{--                            <i class="fa fa-circle-o text-red"></i>Pre Approval Form--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="">--}}
{{--                        <a href="{{ url('travel/approval-requests') }}">--}}
{{--                            <i class="fa fa-circle-o text-red"></i>Travel Approvals--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="">--}}
{{--                        <a href="{{ url('travel/claim-requests') }}">--}}
{{--                            <i class="fa fa-circle-o text-aqua"></i>Claim Requests--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-briefcase"></i> <span>JRF Management </span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                      <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                </a>--}}

{{--                <ul class="treeview-menu">--}}

{{--                    @can('create-jrf')--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/create') }}"  data-toggle="tooltip" data-placement="right" title="JRF CREATES ONLY RECRUITERS">--}}
{{--                                <i class="fa fa-circle-o text-red"></i>Create JRF--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/list-jrf') }}">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>JRF Listing--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a title="list of Approval Employee's leave" href="{{ url('jrf/approve-jrf') }}" data-toggle="tooltip" data-placement="right" title="JRF FOR APPROVAL">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Approve JRF--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a title="list of Approval Employee's leave" href="{{ url('jrf/approve-jrf/assigned') }}" data-toggle="tooltip" data-placement="right" title="JRF FOR APPROVAL">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Reassigned JRF--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/sendback-jrf') }}" data-toggle="tooltip" data-placement="right" >--}}
{{--                                <i class="fa fa-circle-o text-red"></i>Send Back JRF--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/recruitment-tasks-assigned-jrf-list') }}" data-toggle="tooltip" data-placement="right" title="LEVEL 1 SCREENING FOR RECRUITERS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Level 1 Screening(Recruiter)--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/recruitment-tasks-extend-date') }}">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Closure Date Extend--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/discussion-jrf-date') }}" data-toggle="tooltip" data-placement="right" >--}}
{{--                                <i class="fa fa-circle-o text-red"></i>Discussion Extended Date.--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/interview-list') }}" data-toggle="tooltip" data-placement="right" title="LEVEL 2 CANDIDATES INTERVIEW LIST">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Level 2 Screening(Interviewer)--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/mgmt-assign-date') }}" data-toggle="tooltip" data-placement="right" title="RECRUITERS ASSIGNE DATE TO MGMT INTERACTION CANDIDATES">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Mgmt Interaction Candidates--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/appointment-approval') }}" data-toggle="tooltip" data-placement="right" title="APPOINTMENT FORM FILLED BY RECRUITERS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Candidate Appointment</a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/list-appointment-approval') }}" data-toggle="tooltip" data-placement="right" title="APPOINTMENT FORM lISTING">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Approval Apointment Listing--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a  href="{{ url('jrf/approve-appointed-candidate') }}" data-toggle="tooltip" data-placement="right" title="AFTER APPOINTMENT CANDIDATES SHOWS FOR APPROVAL">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Approve Appointed Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/list-selected-candidate') }}" data-toggle="tooltip" data-placement="right" title="SELECTED CANDIDATES SHOWS AFTER APPROVALS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Selected Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/create-closure') }}" data-toggle="tooltip" data-placement="right" title="FEEDBACK FORM FILLED BY THE APPROVER">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Feedback--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/level-first-interview-list') }}" data-toggle="tooltip" data-placement="right" title="LEVEL 1 CANDIDATES MIS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Level First Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/level-second-interview-list') }}" data-toggle="tooltip" data-placement="right" title="LEVEL 2 CANDIDATES MIS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Level Second Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('jrf-assigned')--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/recruitment-tasks-assigned-jrf-list') }}">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Level 1 Screening(Recruiter)--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/appointment-approval') }}" data-toggle="tooltip" data-placement="right" title="APPOINTMENT FORM FILLED BY RECRUITERS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Candidate Appointment</a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/list-appointment-approval') }}" data-toggle="tooltip" data-placement="right" title="APPOINTMENT FORM lISTING">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Approval Apointment Listing--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/list-selected-candidate') }}" data-toggle="tooltip" data-placement="right" title="SELECTED CANDIDATES SHOWS AFTER APPROVALS">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Selected Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('approve-jrf')--}}
{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/interview-list') }}" data-toggle="tooltip" data-placement="right" title="LEVEL 2 CANDIDATES INTERVIEW LIST">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Level 2 Screening(Interviewer)--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a title="list of Approval Employee's leave" href="{{ url('jrf/approve-appointed-candidate') }}" data-toggle="tooltip" data-placement="right" title="AFTER APPOINTMENT CANDIDATES SHOWS FOR APPROVAL">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Approve Appointed Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/create-closure') }}" data-toggle="tooltip" data-placement="right" title="FEEDBACK FORM FILLED BY THE APPROVER">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Feedback--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('approve-arf')--}}
{{--                        <li class="">--}}
{{--                            <a title="list of Approval Employee's leave" href="{{ url('jrf/approve-arf') }}" data-toggle="tooltip" data-placement="right" title="HR HOD ARF APPROVAL">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Approve ARF--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endcan--}}

{{--                    @can('mgmt-approvals')--}}
{{--                        <li class="">--}}
{{--                            <a title="list of Approval Employee's leave" href="{{ url('jrf/approve-jrf') }}" data-toggle="tooltip" data-placement="right" title="JRF FOR APPROVAL">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Approve JRF--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/recruitment-tasks-extend-date') }}">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>Closure Date Extend--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/approval-mgmt') }}" data-toggle="tooltip" data-placement="right" title="MANAGEMENT INTERACTION CANDIDATES SHOW">--}}
{{--                                <i class="fa fa-circle-o text-aqua" ></i>Management Approvals--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a title="list of Approval Employee's leave" href="{{ url('jrf/approve-appointed-candidate') }}" data-toggle="tooltip" data-placement="right" title="APPROVED APPOINTED CANDIDATES">--}}
{{--                                <i class="fa fa-circle-o text-success"></i>Approve Appointed Candidate--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a href="{{ url('/jrf/management-closure') }}" data-toggle="tooltip" data-placement="right" title="JRF CLOSED">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i>JRF Closure--}}
{{--                            </a>--}}

{{--                        </li>--}}
{{--                    @endcan--}}
{{--                </ul>--}}
{{--            </li>--}}


{{--        <!--  <li class=""><a title="All Dms Documents" href="{{ route('dms.document.my.documents') }}"><i class="fa fa-files-o fa-lg"></i>My Documents</a></li>-->--}}

{{--            <li class="treeview">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-file-text fa-lg"></i> <span>DMS Document</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--                        <i class="fa fa-angle-left pull-right"></i>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--                <ul class="treeview-menu">--}}
{{--                    @can('dms-approved')--}}

{{--                        <li>--}}
{{--                            <a href="{{ url('approve-dms') }}" data-toggle="tooltip" data-placement="right">--}}
{{--                                <i class="fa fa-circle-o text-red"></i> <span>Approve Document</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="{{ url('document-requests') }}"  data-placement="right" data-toggle="tooltip" data-placement="right" title="Requests Sent By Employess">--}}
{{--                                <i class="fa fa-circle-o text-aqua"></i> <span>Document Requests</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="">--}}
{{--                            <a title="All Dms Documents" href="{{ url('revoke-requested-documents') }}" data-toggle="tooltip" data-placement="right" title="Revoke Approved Requested Documents"><i class="fa fa-circle-o text-red"></i>Revoke Documents</a>--}}
{{--                        </li>--}}

{{--                    @endcan--}}
{{--                    <li class=""><a title="Add New Dms Document" href="{{ route('dms.document.create') }}"><i class="fa fa-circle-o text-aqua"></i>Add New Document</a></li>--}}
{{--                    @if($usser->id != 13)--}}
{{--                        <li class=""><a title="All Dms Documents" href="{{ route('dms.document.index') }}"><i class="fa fa-circle-o text-red"></i>All Documents</a></li>--}}
{{--                    @endif--}}

{{--                    <li class=""><a title="All Dms Documents" href="{{ route('dms.document.my.documents') }}"><i class="fa fa-circle-o text-aqua"></i>Created Documents</a></li>--}}

{{--                    @if($usser->id != 13)--}}
{{--                        <li class=""><a title="All Dms Documents" href="{{ url('requested-documents') }}"><i class="fa fa-circle-o text-red"></i>Requested Documents</a></li>--}}
{{--                    @endif--}}

{{--                    <li class=""><a title="All Dms Documents" href="{{ url('my-documents-received') }}"><i class="fa fa-circle-o text-red"></i>My Documents</a></li>--}}

{{--                </ul>--}}
{{--            </li>--}}

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<script type="text/javascript">
    /** add active class and stay opened when selected */
    var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');
    // for treeview
    $('ul.treeview-menu a').filter(function() {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
</script>
