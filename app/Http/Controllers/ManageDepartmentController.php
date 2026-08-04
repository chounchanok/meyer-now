<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PercentDepartmentAction;
use App\Models\PercentDepartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ManageDepartmentController extends Controller
{
    public function index()
    {
        return view('pages.setting.manageDepartment.index');
    }

    public function show(Request $request, $test ,$id)
    {
        $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
        // $approve_pa_score_by = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.approve_pa_score_by',
        //         'tb_employee.employee_local_name_th',
        //         'tb_employee.employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.approve_pa_score_by')
        // ->groupBy('tb_employee_evaluator.approve_pa_score_by')
        // ->orderBy('tb_employee_evaluator.approve_pa_score_by', 'ASC')->get();

        $arroffice = ['105','106','103','114'];
        $approve_pa_score_by = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->whereIn('tb_employee_evaluator.position_code',$arroffice)
        ->orderBy('tb_employee_evaluator.employee_no', 'ASC')->get();

        $section = DB::table('tb_section')->orderBy('id', 'ASC')->get();

        // $top = array("employee_no"=>"000002","employee_name_en"=>"KOMKRIT VONGKAVIVATHANAKUL");
        // array_push($top,array("employee_no"=>"000002","employee_name_en"=>"KOMKRIT VONGKAVIVATHANAKUL"));
        // array_push($top,array("employee_no"=>"000026","employee_name_en"=>"Joseph Lo."));
        // dd($top);
        // exit;

        return view('pages.setting.manageDepartment.show',[
            'id'=>$id,
            "division" => $division,
            "department" => $department,
            "approve_pa_score_by" => $approve_pa_score_by,
            "section" => $section,
        ]);
    }

    public function managepage_department()
    {
        return view('pages/setting/manageDepartment/managepage');
    }

    public function table_alldepartment_getdata(Request $request)
    {
        $PercentDepartment = PercentDepartment::select('id',
            'title',
            'date',
            'active'
        );
        if($request->search_name != 0){
            if(!empty($request->search_name)){
                $PercentDepartment->where('tb_percent_department.title', 'LIKE' ,'%'.$request->search_name.'%');
            }
        }
        if($request->search_date != 0){
            if(!empty($request->search_date)){
                $PercentDepartment->where('tb_percent_department.date', $request->search_date);
            }
        }
        $PercentDepartment = $PercentDepartment->orderby('created', 'asc')->get();
        if (count($PercentDepartment)>0) {
            for ($i = 0; $i < count($PercentDepartment); $i++) {
                $title = $PercentDepartment[$i]->title;
                $date = date('Y-m-d', strtotime($PercentDepartment[$i]->date));
                if (Auth::user()->can('edit set increase')) {
                $button = '<a href="manageDepartment/'.$PercentDepartment[$i]->id.'/show">
                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="ki-solid ki-pencil fs-5"></i>
                                </button>
                            </a>';
                }
                // if($PercentDepartment[$i]->active == '1'){
                //     $status_active = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$PercentDepartment[$i]->id.'" onchange="change_active(this,'.$PercentDepartment[$i]->id.');" value="'.$PercentDepartment[$i]->id.'" data-id="'.$PercentDepartment[$i]->id.'" checked>';
                // }else{
                //     $status_active = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$PercentDepartment[$i]->id.'" onchange="change_active(this,'.$PercentDepartment[$i]->id.');" value="'.$PercentDepartment[$i]->id.'" data-id="'.$PercentDepartment[$i]->id.'">';
                // }
                $data[] = array(
                    "no" =>  $i + 1,
                    "title" => $title,
                    "date" => $date,
                    // "status_active" => '<div class="form-check form-switch">'.$status_active.'</div>',
                    "button" =>  $button,
                );
            }
            $result = [
                'recordsTotal'    => count($PercentDepartment),
                'recordsFiltered' => count($PercentDepartment),
                'data'            => $data ,
            ];
            echo json_encode($result);
        }
        else{
            $data = [];
            $result = [
                'recordsTotal'    => count($PercentDepartment),
                'recordsFiltered' => count($PercentDepartment),
                'data'            => $data ,
            ];
            echo json_encode($result);
        }

    }

    public function table_department_getdata(Request $request,$test,$id)
    {
        $action = PercentDepartmentAction::where('percent_department_id',$id)->get();
        if(count($action) == 0){
            $data = [];
        }else{
            for ($i = 0; $i < count($action); $i++) {
                if($action[$i]->active == '1'){
                    $status_active = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$action[$i]->id.'" onchange="change_active(this,'.$action[$i]->id.');" value="'.$action[$i]->id.'" data-id="'.$action[$i]->id.'" checked>';
                }else{
                    $status_active = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$action[$i]->id.'" onchange="change_active(this,'.$action[$i]->id.');" value="'.$action[$i]->id.'" data-id="'.$action[$i]->id.'">';
                }
                $evaluator_name1 = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_name_th','tb_employee_evaluator.employee_name_en')
                ->where('tb_employee_evaluator.employee_no', $action[$i]->approve_by1)->first();
                // $approve2 = DB::table('tb_employee')
                // ->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')
                // ->where('tb_employee.orisoft_no', $action[$i]->approve_by2)->first();
                if(trans(request()->segment(1)) == 'manager'){
                    if($action[$i]->approve_by2 == "000002"){
                        $approve2 = "KAI CHIU JOSEPH LO";
                    }else if($action[$i]->approve_by2 == "000042"){
                        $approve2 = "VINCENT CHI SENG CHENG";
                    }else{
                        $tb_users = DB::table('users')->where('orisoft_code', $action[$i]->approve_by2)->count();
                        if($tb_users > 0){
                            $tb_usersx = DB::table('users')->where('orisoft_code', $action[$i]->approve_by2)->first();
                            $approve2 = $tb_usersx->name;
                        }else{
                            $approve2 = "";
                        }
                    }
                }else{
                    if($action[$i]->approve_by2 == "000002"){
                        $approve2 = "KAI CHIU JOSEPH LO";
                    }else if($action[$i]->approve_by2 == "000026"){
                        $approve2 = "KOMKRIT VONGKAVIVATHANAKUL";
                    }else if($action[$i]->approve_by2 == "013591"){
                        $approve2 = "TANAWAT ATICHAT";
                    }else{
                        $tb_users = DB::table('users')->where('orisoft_code', $action[$i]->approve_by2)->count();
                        if($tb_users > 0){
                            $tb_usersx = DB::table('users')->where('orisoft_code', $action[$i]->approve_by2)->first();
                            $approve2 = $tb_usersx->name;
                        }else{
                            $approve2 = "";
                        }
                    }
                }
                if(trans(request()->segment(1)) == 'manager'){
                    if($action[$i]->approve_by3 == "000002"){
                        $approve3 = "KAI CHIU JOSEPH LO";
                    }else if($action[$i]->approve_by3 == "000042"){
                        $approve3 = "VINCENT CHI SENG CHENG";
                    }else{
                        $approve3 = "";
                    }
                }else{
                    if($action[$i]->approve_by3 == "000002"){
                        $approve3 = "KAI CHIU JOSEPH LO";
                    }else if($action[$i]->approve_by3 == "000026"){
                        $approve3 = "KOMKRIT VONGKAVIVATHANAKUL";
                    }else{
                        $approve3 = "";
                    }
                }
                $data[] = array(
                    "id" => $action[$i]->id,
                    "no" =>  $i+1,
                    "div" => $action[$i]->division_code,
                    "dept" => $action[$i]->department_code,
                    "sec" => $action[$i]->section_code,
                    "percent_daily" => $action[$i]->percent_daily.'%',
                    "percent_monthly" => $action[$i]->percent_monthly.'%',
                    "approve" => ($action[$i]->approve_by1=='000023'?'SIU KAI KWOK':($evaluator_name1?$evaluator_name1->employee_name_en:'')),
                    "approve2" => ($approve2?$approve2:''),
                    "approve3" => ($approve3?$approve3:''),
                    // "status_active" => '<div class="form-check form-switch">'.$status_active.'</div>',
                    "button" =>  '',
                );
            }
        }

        $result = [
            'recordsTotal'    => count($action),
            'recordsFiltered' => count($action),
            'data'            => $data,
        ];
        echo json_encode($result);
    }

    public function add_action(Request $request)
    {
        try {

            $date = date('Y-m-d');
            // if(date('Y-m') <= (date('Y').'-2')){
            //     $year = date('Y', strtotime('-1 year'));
            // }else{
                $year = date('Y');
            // }
            // $year = date('Y');
            $PercentDepartment = PercentDepartment::where('year',$year)->get();

            if (count($PercentDepartment) > 0) {
                DB::rollback();
                $status = 409;
                $message = "มีข้อมูลของปีนี้แล้ว";
            } else {
                $data = new PercentDepartment();
                $data->title = $request->title;
                $data->date = $date;
                $data->year = $year;
                $data->save();
                if ($data->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function fetch_config($test,$id)
    {
        $row = DB::table('tb_percent_department_action')
        ->select(
            'tb_percent_department_action.*',
            'tb_division.division_description',
            'tb_department.department_description',
            'tb_section.section_description',
            'tb_employee.employee_local_name_en'
        )
        ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_percent_department_action.approve_by1')
        ->where('tb_percent_department_action.id',$id)->first();


        if(!empty($row)){
            if($row->approve_by1){
                $info = DB::table('tb_employee_evaluator')
                ->select(
                    'tb_employee_evaluator.employee_name_en'
                )
                ->where('tb_employee_evaluator.employee_no',$row->approve_by1)
                ->first();
                if($info){
                    $row->employee_local_name_en = $info->employee_name_en;
                }else{
                    $row->employee_local_name_en = '';
                }
            }
            if($row->approve_by2){
                $info = DB::table('tb_employee_evaluator')
                ->select(
                    'tb_employee_evaluator.employee_name_en'
                )
                ->where('tb_employee_evaluator.employee_no',$row->approve_by2)
                ->first();
                if($info){
                    $row->employee_local_name_en2 = $info->employee_name_en;
                }else{
                    $row->employee_local_name_en2 = '';
                }
            }
            if($row->approve_by3){
                $info = DB::table('tb_employee_evaluator')
                ->select(
                    'tb_employee_evaluator.employee_name_en'
                )
                ->where('tb_employee_evaluator.employee_no',$row->approve_by3)
                ->first();
                if($info){
                    $row->employee_local_name_en3 = $info->employee_name_en;
                }else{
                    $row->employee_local_name_en3 = '';
                }
            }
        }
        echo json_encode($row);
        // $action = PercentDepartmentAction::find($id);
        // return $action;
    }
    public function addedit_action(Request $request)
    {
        try {
            if($request->id_action > 0){
                $action = PercentDepartmentAction::find($request->id_action);
                $action->division_code = $request->division_code;
                $action->department_code = $request->department_code;
                $action->section_code = $request->section_code;
                $action->percent_daily = $request->percent_daily;
                $action->percent_monthly = $request->percent_monthly;
                $action->approve_by1 = $request->approve_by1;
                $action->approve_by2 = $request->approve_by2;
                $action->approve_by3 = $request->approve_by3;
                $action->save();
                if ($action->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }else{
                $action = new PercentDepartmentAction();
                $action->percent_department_id = $request->edit_id;
                $action->division_code = $request->division_code;
                $action->department_code = $request->department_code;
                $action->section_code = $request->section_code;
                $action->percent_daily = $request->percent_daily;
                $action->percent_monthly = $request->percent_monthly;
                $action->approve_by1 = $request->approve_by1;
                $action->approve_by2 = $request->approve_by2;
                $action->approve_by3 = $request->approve_by3;
                $action->save();
                if ($action->save()) {
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function department_change_active(Request $request)
    {
        $id             = $request->input('id');
        $status_active             = $request->input('status_active');
        DB::table('tb_percent_department')->where('id', $id )->update([
            'active' => $status_active
        ]);
        $result = [
            'status'                => 200
        ];
        echo json_encode($result);
    }

    public function department_action_change_active(Request $request)
    {
        $id             = $request->input('id');
        $status_active             = $request->input('status_active');
        DB::table('tb_percent_department_action')->where('id', $id )->update([
            'active' => $status_active
        ]);
        $result = [
            'status'                => 200
        ];
        echo json_encode($result);
    }
}
