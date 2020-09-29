<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use App\DmsDocument;
use App\DmsCategory;
use App\DmsKeyword;
use App\Employee;
use App\DmsHierarchy;
use App\DmsApprovals;
use App\DmsRequests;
use DB;
use App\User;
use Auth;

class DmsDocumentController extends Controller
{
    public function index(){

        $dmsDocuments = DmsDocument::with('dmsRequestUser')
                    ->with('dmsAuthEmployee')
                    ->with('category')
                    ->where(['isActive'=>'1','approve_status'=>'1'])->orderBy('id','DESC') 
                    ->get();

        //dd($dmsDocuments);            

        $dmsCategories =  DmsCategory::where('isActive','1')->get();
        $dmsKeywords   =  DmsKeyword::where('isActive','1')->get();
        $departments   =  Department::where('isActive','1')->get();

       /* 

        $get_emp_wise = DB::table('dms_document_employee as jlosl')
            ->where('jlosl.dms_document_id', 10)
            ->select('employee_id','view_doc','download_doc')
            ->get()->toArray(); 

        */

        return view('dms_document.index', compact('dmsDocuments', 'dmsCategories', 'dmsKeywords', 'departments'));
    }

    public function create(){
        $dmsCategories = DmsCategory::where('isActive','1')->get();
        $dmsKeywords = DmsKeyword::where('isActive','1')->get();
        $departments = Department::where('isActive','1')->get();
        return view('dms_document.create', compact('dmsCategories', 'dmsKeywords', 'departments'));
    }

    public function store(Request $request){

        $user = User::where(['id' => Auth::id()])->first();

        $count = DmsDocument::count();
        $count++;
        $date = date('Ymd');
        $string = substr($date,2);
        $stringA = substr($string, 0, -2);
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);
        $fnl_cnt = $stringA.$number;

        $next_approver = DmsHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'ASC')->first();   

        if (empty($next_approver)) {
            $manager_id = 0;
        } else {
            $manager_id = 13;
            $user_data  = User::where('id', $manager_id)->first();
        }

      
        $request->validate([
            'document_name' => 'required|max:50|unique:dms_documents,name,NULL,id,deleted_at,NULL',
        ]);

        $files = $request->file('document_files');
        if($request->hasFile('document_files'))
        {
            foreach ($files as $documentFile) {
                $fileContents = $documentFile;
                $documentName = time() .rand('10', '100') .'.' . $documentFile->extension();
                $documentFile->move(public_path('uploads/document'), $documentName);
                $documents[] = $documentName;
            }
        }
        $dmsDocument = DmsDocument::create([
            'name' => $request->document_name,
            'dms_category_id' => $request->document_category,
            'privacy_status' =>  $request->privacy_status,
            'user_id'        =>  $user->id,
            'dms_token'      =>  $fnl_cnt,
            'document' => json_encode($documents)
        ]);

        $dms_id  = DB::table('dms_documents')
                ->where(['dms_documents.dms_token'=>$fnl_cnt])
                ->select('id')
                ->first();

        $next_approver_present = DmsApprovals::where('dms_document_id',$dms_id->id)->first();

        $next_appr_name = User::where(['id' => $user->id])
                    ->with('employee')
                    ->first();

        if (empty($next_approver_present)) {
            //Approved on previous level

            $next_approval_data = [
                'user_id'       => $user->id,
                'dms_document_id' => $dms_id->id,
                'supervisor_id' => $manager_id,
                'priority'      => 2,
                'jrf_status'    => '0',
            ];

            $notification_data = [
                'sender_id'   => $user->id,
                'receiver_id' => $manager_id,
                'label'       => 'Dms Document',
                'message'     => $next_appr_name->employee->fullname . " sent request Dms Document approval.",
                'read_status' => '0',
            ];


            $get_mobile_user_data = User::where(['id' => 13])
            ->with('employee')
            ->first();

            $notificationMessage = $next_appr_name->employee->fullname." Created a Document Please Approved it, Document Name is  ".$request->document_name."";


            if ($next_approval_data['priority'] == '2') {
                // MD
                $jrf_approval_insert_id = DmsApprovals::create($next_approval_data);
                
                sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

            }

        }

        foreach ($request->document_keywords as $keyword){
            $dmsDocument->keywords()->attach([$keyword]);
        }

        if(!empty($request->departments)){
            foreach ($request->departments as $department){
                $dep = $dmsDocument->departments()->attach([$department]);
            }
        }else{
                $dep ="";
        }

        // This One
        if(!empty($request->employees)){   
            foreach ($request->employees as $key => $employee){

                $viewDoc = $downloadDoc = 0;
                if(isset($request->view_doc) && isset($request->view_doc[$employee])) {
                    $viewDoc = $request->view_doc[$employee];
                }

                if(isset($request->download_doc) && isset($request->download_doc[$employee])){
                    $downloadDoc = $request->download_doc[$employee];
                }

                $emp_doc =  $dmsDocument->employees()->attach([$employee], ['view_doc' => $viewDoc, 'download_doc' => $downloadDoc]);
            }
        }else{
                $emp_doc ="";
        }

        // Add Multiple Employees

        if(!empty($request->chk_doc)){
            foreach ($request->chk_doc as $key =>$chk_doc){
                if($key != '') {
                    $data = DB::table('employees as e')
                        ->join('employee_profiles as ep', 'e.user_id', '=', 'ep.user_id')
                        ->whereIn('ep.department_id', [$key])
                        ->where(['e.approval_status' => '1', 'e.isactive' => 1])
                        ->select('e.id')
                        ->get();
                }
            }

            foreach ($data as $key => $value) {
                if(!empty($request->chk_doc_downl)){
                    $dataAA = [
                        'dms_document_id' => $dms_id->id,
                        'employee_id'     => $value->id,
                        'view_doc'        => 1,
                        'download_doc'    => 1
                    ];
                }else{
                     $dataAA = [
                        'dms_document_id' => $dms_id->id,
                        'employee_id'     => $value->id,
                        'view_doc'        => 1
                    ];
                }

                $insert_data = DB::table('dms_document_employee')->insert($dataAA);      
            }
        }


        return redirect('dms-documents/my-documents')->with('success','Dms Document created successfully!');
    }

    public function show(){
        return view('dms_document.show');
    }

    public function edit(DmsDocument $dmsDocument){

        $dmsCategories = DmsCategory::where('isActive','1')->get();
        $dmsKeywords = DmsKeyword::where('isActive','1')->get();
        $departments = Department::where('isActive','1')->get();
        $employees = $dmsDocument->employees;
        $dms_approvals = DmsApprovals::where('dms_document_id',$dmsDocument->id)->get();

        $select_empl_chkbox = DB::table('dms_document_employee as jlosl')
            ->join('employees as emp', 'jlosl.employee_id','=','emp.user_id')
            ->join('employee_profiles as emp_prf','emp.user_id','=','emp_prf.user_id')
            ->join('departments as dep','emp_prf.department_id','=','dep.id')
            ->where('jlosl.dms_document_id', $dmsDocument->id)
            ->select('jlosl.*','emp.fullname as emp_name','dep.name as dep_name')
            ->get()->toArray();  

        $emp_doc  =  DB::table('dms_document_employee')->where('dms_document_id', $dmsDocument->id)->pluck('employee_id')->toArray();

        return view('dms_document.edit', compact('employees', 'dmsDocument', 'dmsCategories', 'dmsKeywords', 'departments','dms_approvals','select_empl_chkbox','emp_doc'));
    }

    public function update(Request $request, DmsDocument $dmsDocument){

        $dms_approvals = DmsApprovals::where('dms_document_id',$dmsDocument->id)->select('jrf_status')->first();

        if($dms_approvals->jrf_status == '0'){

            $dms_approvals = DB::table('dms_document_employee')->where('dms_document_id',$dmsDocument->id)->select('dms_document_id')->get();

            if($request->privacy_status == 'private' || $request->privacy_status == 'public'){
                if(!empty($dms_approvals)){
                    DB::table('dms_document_employee')->where(['dms_document_id'=>$dmsDocument->id])->update(['status'=>'0']);
                }
            }

        }

        $request->validate([
            'document_name' => 'required|max:50|unique:dms_documents,name,'.$dmsDocument->id.',id,deleted_at,NULL',
        ]);



        $dmsDocuments = json_decode($dmsDocument->document);
        foreach ($dmsDocuments as $documentDms) {
            $documents[] = $documentDms;
        }

        $files = $request->file('document_files');
        if($request->hasFile('document_files'))
        {
            foreach ($files as $documentFile) {
                $fileContents = $documentFile;
                $documentName = time() .rand('10', '100') .'.' . $documentFile->extension();
                $documentFile->move(public_path('uploads/document'), $documentName);
                $documents[] = $documentName;
            }

        }


        DmsDocument::where('id', $dmsDocument->id)->update([
            'name' => $request->document_name,
            'dms_category_id' => $request->document_category,
            'privacy_status'  => $request->privacy_status,
            'document' => json_encode($documents)
        ]);

        // When Document Not Approved..

       $dms_approvals = DmsApprovals::where('dms_document_id',$dmsDocument->id)->select('jrf_status')->first();

        if($dms_approvals->jrf_status == '0'){

            DB::table('dms_approvals')->where(['dms_document_id'=>$dmsDocument->id])->update(['jrf_status'=>'1']);

            DmsDocument::where(['id'=>$dmsDocument->id])->update(['approve_status'=>'1']);

        }

        foreach ($request->document_keywords as $keyword){
            $dmsDocument->keywords()->sync([$keyword], false);
        }

        if($request->departments !=""){
            foreach ($request->departments as $department){
                $dms_dep = $dmsDocument->departments()->sync([$department],false);
            }
        }else{
                $dms_dep = "";   
        }

       /* if($request->employees !=""){
            foreach ($request->employees as $employee){
                $dms_emp = $dmsDocument->employees()->sync([$employee], false);
            }
        }else{
            $dms_emp = "";
        }

        */

        // This One

      /*  if(!empty($request->employees)){   
            foreach ($request->employees as $key => $employee){
                    
                if(isset($request->view_doc) && isset($request->view_doc[$employee])) {
                    $viewDoc = $request->view_doc[$employee];
                }else{
                    $viewDoc = "";
                    
                }

                if(isset($request->download_doc) && isset($request->download_doc[$employee])){
                    $downloadDoc = $request->download_doc[$employee];
                }else{
                    $downloadDoc = "";
                }


                $emp_doc = $dmsDocument->employees()->sync([$employee],false,['view_doc' => $viewDoc, 'download_doc' => $downloadDoc]);
            }
        }else{
                $emp_doc ="";
        }  */

        if($request->privacy_status == 'shared'){

            // chk on that case...

            if (!empty($request->employees)) {
                $dmsDocument->employees()->sync($request->employees);
            } 


            $post_array   = $request->all();

            $language_check_boxes = [];
            if(!empty($request->employees)){
                foreach ($request->employees as $key => $value) {
                    
                    $key2 = 'download_doc'.$value;
                    if (!empty($post_array[$key2])) {
                        $language_check_boxes[$value] = $post_array[$key2];
                    } else {
                        $language_check_boxes[$value] = array();
                    }

                    if (in_array('1', $language_check_boxes[$value])) {
                        $check_box_data['download_doc'] = true;
                    } else {
                        $check_box_data['download_doc'] = false;
                    }

                    $find_language = DB::table('dms_document_employee')
                        ->where(['employee_id' => $value,'dms_document_id'=>$dmsDocument->id])
                        ->update($check_box_data);
                    
                    $updt_status =   DB::table('dms_document_employee')
                        ->where(['employee_id' => $value])
                        ->update(['status'=>'1']); 
                    
                } 
            }
        }   

        //return redirect()->route('dms.document.index')->with('success','Dms Document updated successfully!');

    if($dms_approvals->jrf_status == '0'){
        return redirect()->back()->with('success','Dms Document updated & approved successfully!');
        
    }else{
        return redirect()->back()->with('success','Dms Document updated successfully!');
    }

    }
    
    /*
    public function destroy(DmsDocument $dmsDocument){
        $dmsDocument->delete();
        return redirect()->route('dms.document.index')->with('success','Dms Document deleted successfully!');
    }
    */


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function download($document){
        $file= public_path(). "/uploads/document/". $document;
        if(file_exists($file)){
            return Response::download($file);
        }else {
            return redirect()->route('dms.document.index')->with('error','Document Not Exist!');
        }
    }

    public function viewDoc($document){
        
       /* $url = public_path(). "/uploads/document/". $document;
        $img = $document;
        $file_get = file_get_contents($url);
        $rr = file_put_contents($img, $file_get);         
        if (file_exists($img)) {
            return view('dms_document.embed', compact('rr'));

        } else {
            abort(404, 'File not found!');
        }
        */



        $filename= public_path(). "/uploads/document/". $document;
        
        if (file_exists($filename)) {
            return view('dms_document.embed', compact('document'));
        } else {
            abort(404, 'File not found!');
        }

    }


/*    public function  viewTestDoc($document){

       $tt =  file_get_contents($document);
       dd($rr);
   
    }
*/

    public function departmentEmployee(Request $request){

        $user = User::where(['id' => Auth::id()])->first();
        $data = "Select Employee";
        if($request->department_ids != '') {
            $data = DB::table('employees as e')
                ->join('employee_profiles as ep', 'e.user_id', '=', 'ep.user_id')
                ->whereIn('ep.department_id', $request->department_ids)
                ->where(['e.approval_status' => '1', 'e.isactive' => 1, 'ep.isactive' => 1])
                ->whereNotIn('e.user_id',[$user->id])
                ->select('e.id', 'e.fullname')
                ->get();  
        }
        return Response::json(['success'=>true,'data'=>$data]);
    }

    public function filter(Request $request){
        $category = $request->document_category;
        $keyword = $request->document_keyword;
        $department = $request->document_department;
        if($category != '' && $keyword == '' && $department == ''){
            $dmsDocuments = DmsDocument::where('dms_category_id', $category)->with('category')->with('keywords')->get();
        }
        elseif($category == '' && $keyword != '' && $department == ''){
            $keyword = DmsKeyword::findorfail($keyword);
            $allDmsDocuments  = $keyword->documents;
            if($allDmsDocuments != ''){
                foreach ($allDmsDocuments as $dmsDocument){
                    $dmsDocuments[] = DmsDocument::where('id', $dmsDocument['id'])->with('category')->with('keywords')->first();
                }
            }
        }
        elseif($category == '' && $keyword == '' && $department != ''){
            $department = Department::findorfail($department);
            $allDmsDocuments = $department->documents;
            foreach ($allDmsDocuments as $dmsDocument){
                $dmsDocuments[] = DmsDocument::where('id', $dmsDocument['id'])->with('category')->with('keywords')->first();
            }
        }
        elseif($category != '' || $keyword != '' || $department != '') {
            $categoryDmsdocuments = [];
            $keywordDmsdocuments = [];
            $departmentDmsdocuments = [];
            if ($category != '') {
                $categoryDmsdocuments = DmsDocument::where('dms_category_id', $category)->get()->toArray();
            }

            if ($keyword != '') {
                $keyword = DmsKeyword::findorfail($keyword);
                $keywordDmsdocuments = $keyword->documents->toArray();
            }

            if ($department != '') {
                $department = Department::findorfail($department);
                $departmentDmsdocuments = $department->documents->toArray();
            }

            $allDmsDocuments = array_unique(array_merge($categoryDmsdocuments, $keywordDmsdocuments), SORT_REGULAR);
            $allDmsDocuments = array_unique(array_merge($allDmsDocuments, $departmentDmsdocuments), SORT_REGULAR);

            $filterArray = array();

            foreach ($allDmsDocuments as $index => $t) {
                if (isset($filterArray[$t["id"]])) {
                    unset($allDmsDocuments[$index]);
                    continue;
                }
                $filterArray[$t["id"]] = true;
            }

            foreach ($allDmsDocuments as $dmsDocument){
                $dmsDocuments[] = DmsDocument::where('id', $dmsDocument['id'])->with('category')->with('keywords')->first();
            }
        }
        else{
            $dmsDocuments = DmsDocument::where('isActive','1')->get();
        }
        if(isset($dmsDocuments)) {
            return  $this->returnHtml($dmsDocuments);
        }else {
            return "";
        }
    }

    public function returnHtml($dmsDocuments){
        $output="";
        foreach ($dmsDocuments as $key => $dmsDocument) {

            $output .= '<tr>' .

                '<td>' . $dmsDocument->id . '</td>' .

                '<td>' . $dmsDocument->name . '</td>' .
                '<td>' . $dmsDocument['category']->name . '</td>' .
                '<td>' .$this->keywordHtml($dmsDocument['keywords']).'</td>' .
                '<td>' . '<a href="' . route('dms.document.edit', $dmsDocument->id) . '">
                        <button class="btn bg-purple">
                            <i class="fa fa-edit"></i>
                        </button></a>' .
                '</td>' .
                '<td>' . '<form method"post" action="'.route('dms.document.destroy', $dmsDocument->id).'" onclick="return confirm(\'Are you sure you want to delete this Document?\');">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <button class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button></form>' .
                '</td>' .
                '<td>' . '<form method"post" action="' . route('dms.document.download', $dmsDocument->id) . '">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <button class="btn btn-secondary">
                            <i class="fa fa-download"></i>
                        </button></form>' .
                '</td>' .
                '</tr>';

        }
        return Response($output);
    }

    public function keywordHtml($keywords){
        $output = '';
        foreach ($keywords as $keyword){
            $output .= $keyword->name.',';
        }
        return $output;
    }

    public function removeDocument(DmsDocument $dmsDocument, $document){
        unlink(public_path('uploads/document/'.$document));
        $dmsDocuments = json_decode($dmsDocument->document);
        foreach ($dmsDocuments as $documentDms) {
            $documents[] = $documentDms;
        }
        if (($key = array_search($document, $documents)) !== false) {
            unset($documents[$key]);
        }
        DmsDocument::where('id', $dmsDocument->id)->update([
            'document' => json_encode($documents)
        ]);
        return Redirect::back();
    }

    // Documents Sents For Approval

    public function myDocuments(){

        $user = User::where(['id' => Auth::id()])->first();
        $employee = Employee::where('user_id',Auth::user()->id)->first();
       // $dmsDocuments = $employee->documents;
        //$dmsDocuments = DmsDocument::where(['user_id'=>$user->id])->orderBy('id','DESC')->get();

        $dmsDocuments = DB::table('dms_documents as dms_doc')
            ->join('dms_approvals as dms_app', 'dms_doc.id', '=', 'dms_app.dms_document_id')
            ->join('dms_categories as dc','dms_doc.dms_category_id','=','dc.id')
            ->where(['dms_doc.user_id'=>$user->id])
            ->select('dms_doc.*','dms_app.jrf_status','dc.name as dms_category')
            ->get();

        return view('dms_document.myDocument', compact('dmsDocuments'));
    }

    // Cancel Document Recruiter

    function cancelDocument($document_id){

        $get_doc_id  = DmsDocument::where('id', $document_id)->select('isactive')->first();
        $rr = DmsDocument:: where(['id'=>$document_id])->update(['isactive' => '0']);
        return redirect('dms-documents/my-documents')->with('success','Document Cancel Successfully');
    }


    // Requests Sents For View or Downloade Documents

    public function RequestedDocuments(){
        $user = User::where(['id' => Auth::id()])->first();
        //$dmsDocuments = DmsRequests::where(['user_id'=>$user->id])->get();
        $doc = DB::table('dms_requests as ds')
                ->join('dms_documents as dd','ds.dms_document_id','=','dd.id')
                ->join('dms_categories as dc','dd.dms_category_id','=','dc.id')
                ->where(['ds.user_id'=>$user->id])
                ->select('ds.*','dd.name as doc_name','dd.document','dc.name as category_name')
                ->get();

        //dd($doc);        

        return view('dms_document.myRequestedDocument', compact('dmsDocuments','doc'));

    }

    public function approveDms($dms_status = null)
    {


        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();

        if (empty($dms_status) || $dms_status == 'pending') {
            $status     = '0';
            $dms_status = 'pending'; //pending as a inprogress //
        } elseif ($dms_status == 'assigned') {
            $status     = '1';
            $dms_status = 'Approved';
        } elseif ($dms_status == 'rejected') {
            $status     = '2';
            $dms_status = 'Rejected';
        }

     /* $data = DB::table('dms_approvals as dms_app')
            ->join('dms_documents as dms_doc', 'dms_app.dms_document_id', '=', 'dms_doc.id')
            ->join('department_dms_document as dms_doc_dep','dms_doc.id','=','dms_doc_dep.dms_document_id')
            ->join('dms_document_dms_keyword as dms_doc_keywd','dms_doc.id','=','dms_doc_keywd.dms_document_id')
            ->join('dms_document_employee as dms_doc_emp','dms_doc.id','=','dms_doc_emp.dms_document_id')
            ->get();
*/

        $data['basic'] = DB::table('dms_documents as dms_doc')
            ->join('dms_approvals as dms_app', 'dms_doc.id', '=', 'dms_app.dms_document_id')
            ->join('employees as emp', 'dms_doc.user_id','=','emp.user_id')
            ->join('dms_categories as dms_cat', 'dms_doc.dms_category_id','=','dms_cat.id')
            ->where(['dms_app.supervisor_id'=>13,'dms_doc.isactive'=>1])
            ->select('dms_doc.*','dms_app.*','emp.fullname as emp_name','dms_cat.name as dms_category')
            ->orderBy('dms_app.id','DESC')
            ->get();   

        $dms_doc_keyword  = DB::table('dms_document_dms_keyword')->where('dms_document_id', 1)->pluck('dms_keyword_id')->toArray();   

        $data['dms_keywords'] = DB::table('dms_keywords')->whereIn('id', $dms_doc_keyword)->select('name')->get();              


        if (!$data['basic']->isEmpty()) {
            foreach ($data['basic'] as $key => $value) {

                if ($value->jrf_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                }elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }

        return view('dms_document.list_dms_approvals')->with(['data' => $data, 'selected_status' => $dms_status]);
    }


    //  Save Dms Approval

    public function saveDmsApproval(Request $request)
    {
        
       //dd($request->all());

        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);

        $applied_jrf =  DmsApprovals::where('dms_document_id', $request->dms_document_id)->first();

        $applied_jrf->jrf_status = $request->final_status;
       
        if( $request->final_status == '1' ){

          $applied_jrf->save();   
       
        }
       
        $applier = $applied_jrf->user;

        // Send message to JRF Creator when JRF Request approved by HOD Level One//

        $message_data = [
            'sender_id'   => $request->userId, //$jrf->user_id
            'receiver_id' => $applier->id,
            'label'       => 'Document Approved',
            'message'     => $request->remark,
            'read_status' => '0',
        ];


        $applied_jrf->messages()->create($message_data);

         $user_detail = User::where(['id' => Auth::id()])
                ->with('employee')
                ->first();

        if ( $request->final_status == '1') {

                $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => $applier->id,
                    'label'       => 'Document Approved',
                    'message'     => $user_detail->employee->fullname . " Document Approved.",
                    'read_status' => '0',
                ];

                if (!empty( $notification_data )) {

                   DmsApprovals::where(['dms_document_id' => $request->dms_document_id,'supervisor_id' =>$request->userId,'user_id' => $request->u_id])->update(['jrf_status' => '1']);

                   DmsDocument:: where(['id' => $request->dms_document_id])->update(['approve_status' => '1']);
     
                    $applied_jrf->notifications()->create($notification_data);
                }

                return redirect('approve-dms')->with('success', "Document Approved Successfully!");

            }elseif ($request->final_status != '1') {

                    $get_jrf_approvded_status = DmsApprovals::where(['dms_document_id'=> $request->dms_document_id,'supervisor_id'=> $request->userId])->first();


                    $update_approval_status = ['jrf_status' => '2'];

                    $result = DmsApprovals::updateOrCreate(['supervisor_id' => $request->userId, 'dms_document_id' => $request->dms_document_id], $update_approval_status);

                    $reject_doc = DmsDocument:: where(['id' => $request->dms_document_id])->update(['approve_status' => '2']);

                    $notificationMessage = $user_detail->employee->fullname . " Reject the Document";

                    if (!empty($result)) {
                        //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                        $notification_data = [
                            'sender_id'   => $request->userId,
                            'receiver_id' => $request->u_id,
                            'label'       => 'Document Rejected',
                            'read_status' => '0',
                        ];

                        $notification_data['message'] = "Document Rejected by " . $user_detail->employee->fullname;
                        $applied_jrf->notifications()->create($notification_data);

                        return redirect('approve-dms')->with('success','Document Rejected Successfully');
                    }

            }

    }

    public function saveDmsRequest(Request $request)
    {
       // dd($request->all());

        $user = User::where(['id' => Auth::id()])->first();

        $chk_req_user_exists = DB::table('dms_requests')->where(['dms_document_id'=>$request->dms_document_id,'user_id'=>$user->id])->first();
       // dd($chk_req_user_exists);

        $request->validate([
            'remark' => 'required',
        ]);


        $next_approver = DmsHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'ASC')->first();   

        if (empty($next_approver)) {
            $manager_id = 0;
        } else {
            $manager_id = 13;
            $user_data  = User::where('id', $manager_id)->first();
        }


        $next_approver_present = DmsApprovals::where('id',$request->dms_document_id)->first();

        $next_appr_name = User::where(['id' => $user->id])
                    ->with('employee')
                    ->first();

        if (!empty($next_approver_present)) {
            //Approved on previous level

            if(!empty($chk_req_user_exists)){

               // dd("not empty");

                $next_approval_data = [
                    'user_id'           =>  $user->id,
                    'dms_document_id'   =>  $request->dms_document_id,
                    'supervisor_id'     =>  $manager_id,
                    'remarks'           =>  $request->remark,
                    'priority'          =>  3,
                    'jrf_status'        =>  '0',
                    'view_doc'          =>  $request->view_doc,
                    'download_doc'      =>  $request->download_doc
                ];
            }else{
               // dd("empty");
                $next_approval_data = [
                    'user_id'           =>  $user->id,
                    'dms_document_id'   =>  $request->dms_document_id,
                    'supervisor_id'     =>  $manager_id,
                    'remarks'           =>  $request->remark,
                    'priority'          =>  2,
                    'jrf_status'        =>  '0',
                    'view_doc'          =>  $request->view_doc,
                    'download_doc'      =>  $request->download_doc
                ];
            }

            //dd($next_approval_data);

            $notification_data = [
                'sender_id'   => $user->id,
                'receiver_id' => $manager_id,
                'label'       => 'Dms Document Request',
                'message'     => $next_appr_name->employee->fullname . " sent request Dms Document approval.",
                'read_status' => '0',
            ];


            $get_mobile_user_data = User::where(['id' => 13])
                ->with('employee')->first();

            $notificationMessage = $next_appr_name->employee->fullname." Send Request For Document Approval";


            if (!empty($next_approval_data)) {
                
                DmsDocument:: where(['id' => $request->dms_document_id])->update(['request_status' => '1']);

                if(empty($chk_req_user_exists)){
                    $insert_data = DB::table('dms_requests')->insert($next_approval_data);
                }else{
                    $insert_data = DB::table('dms_requests')->insert($next_approval_data);
                }

                sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

               
                //$jrf->notifications()->create($notification_data);
            }

        }

        return redirect()->back()->with('success','Document Request Sent Successfully');

    }


    // Get Document Requests


    public function DmsRequest($dms_status = null)
    {

       //dd($dms_status);

        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();

        if (empty($req_status) || $req_status == 'pending') {
            $status     = '0';
            $req_status = 'pending'; //pending as a inprogress //
        } elseif ($dms_status == 'assigned') {
            $status     = '1';
            $req_status = 'Approved';
        } elseif ($dms_status == 'rejected') {
            $status     = '2';
            $req_status = 'Rejected';
        }

        $data['basic'] = DB::table('dms_documents as dms_doc')
            ->join('dms_requests as dms_req', 'dms_doc.id', '=', 'dms_req.dms_document_id')
            ->leftjoin('employees as emp', 'dms_doc.user_id', '=', 'emp.user_id')
            ->leftjoin('employees as emp3', 'dms_req.user_id', '=', 'emp3.user_id')
            ->join('dms_categories as dms_cat', 'dms_doc.dms_category_id','=','dms_cat.id')
            ->select('dms_doc.*','dms_req.*','emp.fullname as emp_name','dms_cat.name as dms_category','emp3.fullname as req_emp_name')
            ->where(['dms_req.supervisor_id'=>13,'dms_req.jrf_status' => $status,'dms_req.revoke_requests'=>'No'])
            ->orderBy('dms_req.id','DESC')
            ->get();
        //dd($data['basic']);   
         
        foreach ($data['basic'] as $key => $value) {
            $dms_doc_employee  = DB::table('dms_document_employee')->where('dms_document_id', $value->dms_document_id)->pluck('employee_id')->toArray();

            $data['doc_employee'] = DB::table('employees')->whereIn('user_id', $dms_doc_employee)->select('fullname')->get();

        }
        
        /* 
        if (!$data['basic']->isEmpty()) {
            $data['doc_employee'] = DB::table('employees')->whereIn('user_id', $dms_doc_employee)->select('fullname')->get();
        }
        */

        if (!$data['basic']->isEmpty()) {
            foreach ($data['basic'] as $key => $value) {

                if ($value->jrf_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                }elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }

        return view('dms_document.list_request_approvals')->with(['data' => $data,'selected_status' => $req_status]);
    }


    //  Save Dms Approval

    public function saveDmsRequestApproval(Request $request)
    {

       // dd($request->all());

       $chk_dms_employee = DB::table('dms_document_employee')->where(['dms_document_id'=>$request->dms_document_id,'employee_id'=>$request->u_id])->first();
       //dd($chk_dms_employee);

           if($request->downl_doc == ''){
                $downl_doc = '0';
           }else{
                $downl_doc = '1';
           }

           if($request->view_doc == '') {
                $view_doc = '0';
           }else{
                $view_doc = '1';
           }

        
        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);

        $applied_jrf =  DmsRequests::where('dms_document_id', $request->dms_document_id)->first();

        $applied_jrf->jrf_status = $request->final_status;
       
        if( $request->final_status == '1' ){

          $applied_jrf->save();   
       
        }
       
        $applier = $applied_jrf->user;
        // Send message to JRF Creator when JRF Request approved by HOD Level One//

        $message_data = [
            'sender_id'   => $request->userId, //$jrf->user_id
            'receiver_id' => $request->u_id,
            'label'       => 'Document Request Approved',
            'message'     => $request->remark,
            'read_status' => '0',
        ];


        $applied_jrf->messages()->create($message_data);

         $user_detail = User::where(['id' => Auth::id()])
                ->with('employee')
                ->first();

        if ( $request->final_status == '1') {

                $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => $request->u_id,
                    'label'       => 'Document Request Approved',
                    'message'     => $user_detail->employee->fullname . " Document Request Approved.",
                    'read_status' => '0',
                ];

                if (!empty( $notification_data )) {

                   DmsRequests::where(['dms_document_id' => $request->dms_document_id,'supervisor_id' =>$request->userId,'user_id' => $request->u_id,'priority' => $request->priority])->update(['jrf_status' => '1']);

                   DmsDocument:: where(['id' => $request->dms_document_id])->update(['approve_status' => '1','request_status' => '0']);

                    if(empty($chk_dms_employee)){

                        $data = [

                            'dms_document_id' => $request->dms_document_id,
                            'employee_id' => $request->u_id,
                            'view_doc'   => $view_doc,
                            'download_doc'   => $downl_doc

                        ];

                        $insert_data = DB::table('dms_document_employee')->insert($data);

                    }else{

                        if($request->view_doc == '1'){
                            $view_doc = '1';
                        }else{
                            $view_doc = '1';
                        }
                        if($request->downl_doc == '1'){
                            $downl_doc = '1';
                        }else{
                            $downl_doc = '1';
                        }

                       $rr = DB::table('dms_document_employee')->where(['dms_document_id'=>$request->dms_document_id,'employee_id'=>$request->u_id])->update(['view_doc' => $view_doc,'download_doc'=>$downl_doc]);
                    }
     
                    $applied_jrf->notifications()->create($notification_data);
                }

                return redirect()->back()->with('success','Document Requests Approved Successfully');

            }elseif ($request->final_status != '1') {

                    $get_jrf_approvded_status = DmsRequests::where(['dms_document_id'=> $request->dms_document_id,'supervisor_id'=> $request->userId])->orderBy('id','DESC')->first();


                    $update_approval_status = ['jrf_status' => '2'];

                    $result = DmsRequests::where(['dms_document_id' => $request->dms_document_id,'supervisor_id' =>$request->userId,'user_id' => $request->u_id,'priority' => $request->priority])->update(['jrf_status' => '2']);


                    $notificationMessage = $user_detail->employee->fullname . " Reject the Document Requests";

                    if (!empty($result)) {
                        //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                        $notification_data = [
                            'sender_id'   => $request->userId,
                            'receiver_id' => $request->u_id,
                            'label'       => 'Document Requests Rejected',
                            'read_status' => '0',
                        ];

                        $notification_data['message'] = "Document Request Rejected by " . $user_detail->employee->fullname;
                        $applied_jrf->notifications()->create($notification_data);

                        return redirect()->back()->with('success','Document Requests Rejected Successfully');
                    }


            }

    }


    // My Documents Received

    public function MyDocumentsReceived(){

        $user = User::where(['id' => Auth::id()])->first();

        $employee = Employee::where('user_id',Auth::user()->id)->first();
           
        $data['dmsDocuments'] = DB::table('dms_documents as dd')
                ->join('dms_document_employee as dde','dd.id','=','dde.dms_document_id')
                ->join('employees as emp', 'dd.user_id', '=', 'emp.user_id')
                //->leftjoin('dms_requests as dr','dde.dms_document_id','=','dr.dms_document_id')
                ->leftjoin('dms_requests as dr', function($join) use($user) {
                    $join->on('dd.id', '=', 'dr.dms_document_id')
                    ->where(['dr.user_id'=>$user->id])
                    ->orderBy('dr.id','DESC');
                })
                ->join('dms_categories as dc','dd.dms_category_id','=','dc.id')
                ->where(['dde.employee_id'=>$user->id,'dde.status'=>'1','dd.approve_status'=>'1'])
                ->select('dde.*','dd.*','dc.name as category_name','emp.fullname as emp_name','dr.download_doc as req_downl_doc','dr.view_doc as req_view_doc','dr.jrf_status','dr.user_id as req_user_id')
                ->get();
                            
      //  dd($data['dmsDocuments']);        

        $data['dms_requests'] = DB::table('dms_requests as dr')
            ->where(['dr.user_id'=>$user->id,'dr.jrf_status'=>'1'])
            ->orderBy('id','DESC')
            ->get();
        //dd($data['dms_requests']);

        /* 
        $dmsDocuments = DmsDocument::with('dmsRequest')
                    ->with('dmsemployee')
                    ->where(['isActive'=>'1','approve_status'=>'1'])->orderBy('id','DESC') 
                    ->get(); 
        */
    

        return view('dms_document.MyDocumentsReceived', compact('data'));

    }


    // Revoke(Approval Back) Requested Documents

    public function RevokeDocuments(){

        $user = User::where(['id' => Auth::id()])->first();
        $employee = Employee::where('user_id',Auth::user()->id)->first();            
        $dmsDocuments = DB::table('dms_requests as dreq')
                    ->join('dms_documents as dd','dreq.dms_document_id','=','dd.id')
                    ->leftjoin('employees as emp', 'dreq.user_id', '=', 'emp.user_id')
                    ->join('dms_categories as dc','dd.dms_category_id','=','dc.id')
                    ->where(['dreq.jrf_status'=>'1'])
                    ->select('dreq.*','dd.name as doc_name','dc.name as category_name','emp.fullname as emp_name')
                    ->get();
                
        return view('dms_document.RevokeDocuments', compact('dmsDocuments'));

    }

    // Revoke Doc

   public function RevokeDocumentsCancel($document_id,$user_id){

        $get_doc_id  =  DmsRequests::where(['dms_document_id'=>$document_id,'user_id'=>$user_id])->first();
        $rr = DmsRequests:: where(['dms_document_id'=>$document_id,'user_id'=>$user_id])->update(['jrf_status' => '0','revoke_requests'=>'Yes']);
        return redirect(url('revoke-requested-documents'))->with('success','Document Revoke Successfully');
    }

    // Method For Document Security Purpose

    public  function documentSecurity(){



    } 


}