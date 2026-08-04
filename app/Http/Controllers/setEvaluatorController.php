<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\EvaluateLog;
use App\Models\EmployeeEvaluator;
use App\Models\EmployeeModel;
use App\Models\EmployeeFinalScore;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Division;
use App\Models\group\Department;
use App\Models\group\Grademaster;
use App\Models\Users;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Psy\Readline\Hoa\Console;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportReport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class setEvaluatorController extends Controller
{
    public function index()
    {

        // $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $orisoft_division_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code->orisoft_code)->first();

        // $position = DB::table('tb_position')->orderBy('id', 'ASC')->get();
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        // $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
        // $evaluator = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        // ->where('tb_employee_evaluator.division_code',$orisoft_division_code->division_code)
        // ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        // $evaluator2 = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        // ->where('tb_employee_evaluator.division_code',$orisoft_division_code->division_code)
        // ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        // $position = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.position_code',
        // 'tb_employee.position_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();

        // $division = DB::table('tb_employee_evaluator')
        // // ->select(
        // // 'tb_employee.division_code',
        // // 'tb_employee.division_description',
        // // )
        // // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_evaluator.division_code',$orisoft_division_code->division_code);
        // $division = $division->groupBy('tb_employee_evaluator.division_code')->orderBy('division_code', 'ASC')->get();

        // $department_count = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.department_code',
        // 'tb_employee.department_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $department_count = $department_count->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->count();
        // if($department_count == 0){
        //     $department = DB::table('tb_employee_evaluator')
        //     // ->select(
        //     // 'tb_employee.division_code',
        //     // 'tb_employee.division_description',
        //     // )
        //     // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_evaluator.department_code',$orisoft_division_code->department_code);
        //     $department = $department->groupBy('tb_employee_evaluator.department_code')->orderBy('department_code', 'ASC')->get();
        // }else{
        //     $department = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.department_code',
        //     'tb_employee.department_description',
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();
        // }

        // $new_department_code = [];
        // if(count($department)>0){
        //     foreach ($department as $value) {
        //         array_push($new_department_code,$value->department_code);
        //     }
        // }

        // $division_code = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        // $new_division_code = [];
        // if(count($division_code)>0){
        //     foreach ($division_code as $value) {
        //         array_push($new_division_code,$value->division_code);
        //     }
        // }
        // $section_count = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code',
        // 'tb_employee.section_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        // ->whereIn('tb_employee.division_code',$new_division_code)
        // ;
        // $section_count = $section_count->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->count();
        // if($section_count == 0){
        //     $section = DB::table('tb_employee')
        //     ->select('tb_employee.section_code',
        //     'tb_employee.section_description',
        //     )
        //     // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        //     ->whereIn('tb_employee.department_code',$new_department_code)
        //     ;
        //     $section = $section->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->get();
        // }else{
        //     $section = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.section_code',
        //     'tb_employee.section_description',
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        //     ->whereIn('tb_employee.division_code',$new_division_code)
        //     ;
        //     $section = $section->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->get();
        // }
        // // $section = DB::table('tb_section');
        // // $section = $section->orderBy('id', 'ASC')->get();

        // $department_code = [];
        // if(count($department)>0){
        //     foreach ($department as $value) {
        //         array_push($department_code,$value->department_code);
        //     }
        // }
        // $evaluator = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        // // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.evaluator_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        // ->whereIn('tb_employee_evaluator.division_code',$new_division_code)
        // ->where('tb_employee_evaluator.evaluator_active','1')
        // ->whereIn('tb_employee_evaluator.department_code',$department_code)
        // ;
        // $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        // $evaluator = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        // ->where('tb_employee_evaluator.division_code',$orisoft_division_code->division_code)
        // ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        $previousYear = date('Y');
        $position = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee.position_code',
        'tb_employee.position_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code == "000002" || $orisoft_code == "990002"){
            $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();
        }else{
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();
            $checka = -1;
            if(!empty($orisoft_all_code)){
                $checka = strpos($orisoft_all_code->division_code,',');
            }
            $arr_division_code = [];
            $arr_department_code = [];
            $arr_department_code2 = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->division_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        $sub = substr($value,0,1);
                        if($sub == 'G' || $sub == 'P'){
                            $checka = strpos($orisoft_all_code->department_code,',');
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value2) {
                                        array_push($arr_department_code,$value2);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_all_code->department_code);
                            }
                        }
                        array_push($arr_division_code,$value);
                    }
                }
            }else{
                if(!empty($orisoft_all_code)){
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
            }
            $position = $position->whereIn('tb_employee.division_code',$arr_division_code);
            $position = $position->whereIn('tb_employee.department_code',$arr_department_code);
            $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();
        }
        // dd($arr_division_code);
        // exit;
        $evaluator = DB::table('tb_employee_final_score')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee.orisoft_no')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee_evaluator.evaluator_active','1');

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }else{
            $evaluator->whereIn('tb_employee.department_code',$arr_department_code);
        }


        $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
        return view('pages.setEvaluator.index', [
            "year" => $year,
            "position" => $position,
            // "division" => $division,
            // "department" => $department,
            "evaluator" => $evaluator,
            // "evaluator2" => $evaluator2,
            // "section" => $section
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.setEvaluator.index');
    }

    public function table_setE_getdata_old(Request $request)
    {
        $search_data      = $request->input('search_data');
        $search_position      = $request->input('search_position');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_status      = $request->input('search_status');


        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.employee_local_name_en',
        'tb_position.position_description',
        'tb_division.division_description',
        'tb_department.department_description',
        'tb_section.section_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->leftJoin('tb_division','tb_division.division_code','=','tb_employee.division_code')
        ->leftJoin('tb_department','tb_department.department_code','=','tb_employee.department_code')
        ->leftJoin('tb_section','tb_section.section_code','=','tb_employee.section_code');

        if($search_data != "0"){
            $datarow->where(function ($query) use($search_data) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$search_data.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search_data.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search_data.'%');
            });
        }

        if($search_position != "0" && $search_position != "all"){
            $datarow = $datarow->where('tb_employee.position_code', $search_position);
        }
        if($search_division != "0" && $search_division != "all"){
            $datarow = $datarow->where('tb_employee.division_code', $search_division);
        }
        if($search_department != "0" && $search_department != "all"){
            $datarow = $datarow->where('tb_employee.department_code', $search_department);
        }
        if($search_section != "0" && $search_section != "all"){
            $datarow = $datarow->where('tb_employee.section_code', $search_section);
        }
        if($search_status != "0" && $search_status != "all"){
            $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        }
        $datarow = $datarow->orderBy('tb_employee_final_score.id','ASC')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">In progress</span>';
                }
                if($value->status_evaluation == '3'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                }
                // $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                $count_eva = DB::table('tb_employee_evaluator')->select('tb_employee_evaluator.id')->where('tb_employee_evaluator.employee_no', $value->employee_no)->count();
                // if($evaluator_name){
                //     $eva_name = $evaluator_name->employee_local_name_th;
                // }else{
                //     $eva_name = '';
                // }
                if($count_eva){
                    $eva = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$value->id.'" onchange="change_eva(this,'.$value->id.');" checked>';
                }else{
                    $eva = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$value->id.'" onchange="change_eva(this,'.$value->id.');">';
                }
                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">',
                    "code"=> $value->employee_no,
                    "name"=> $value->employee_local_name_en,
                    "position"=> $value->position_description,
                    "div"=> $value->division_description,
                    "dept"=> $value->department_description,
                    "sect"=> $value->section_description,
                    "eva"=> '<div class="form-check form-switch">'.$eva.'</div>',
                    "evaN"=> '',
                    "form"=> $value->form_import,
                    "status"=> $status_evaluation
                );
            }
        }
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result);

    }

    public function table_setE_getdata(Request $request)
    {
        // ****** ใช้ในกรณัี Query จาก Database ******
        $search     = $request->input('search')['value'];
        $start      = $request->input('start');
        $pagestart  = $request->input('start')+1;
        $length     = $request->input('length');
        $field      = $request->input('order')[0]['column'];
        $order      = $request->input('order')[0]['dir'];
        $fieldby    = 'tb_employee_final_score.id';

        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }

        // $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $division_count = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $division_count = $division_count->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->count();
        // if($division_count == 0){
        //     $division_code = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.division_code'
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->where('tb_employee_final_score.evaluator_no',$orisof t_code->orisoft_code)
        //     ;
        //     $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        // }else{
        //     $division_code = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.division_code'
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        // }
        // $new_division_code = [];
        // if(count($division_code)>0){
        //     foreach ($division_code as $value) {
        //         array_push($new_division_code,$value->division_code);
        //     }
        // }

        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_th',
        'tb_employee.employee_local_name_en',
        'tb_employee.position_description',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee_final_score.evaluator_name_th',
        'tb_employee_final_score.evaluator_name_en'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        $count_data = DB::table('tb_employee_final_score')
        ->select('tb_employee.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;


        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->first();

        // if($orisoft_all_code->position_code == '106'){
        //     $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        //     $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        //     $checka123 = strpos($orisoft_all_code->section_code,',');
        //     $arr_section_code123 = [];
        //     if($checka123 >= 0){
        //         $ex = explode(',',$orisoft_all_code->section_code);
        //         if(count($ex)>0){
        //             foreach ($ex as $value) {
        //                 array_push($arr_section_code123,$value);
        //             }
        //         }
        //     }else{
        //         array_push($arr_section_code123,$orisoft_all_code->section_code);
        //     }
        //     $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_code123);
        //     $count_data = $count_data->whereIn('tb_employee.section_code',$arr_section_code123);

        //     // $gatall->where('tb_employee.section_code',$orisoft_all_code->section_code);
        //     // $count_data->where('tb_employee.section_code',$orisoft_all_code->section_code);
        // }
        if($like['search_division'] == "all"){
            if($orisoft_code == "000002"){
                if(trans(request()->segment(1)) == 'manager'){

                }else if(trans(request()->segment(1)) == 'mtl'){
                    $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else{

                }
            }else if($orisoft_code == "990002"){

            }else{
                if($orisoft_code == "000060"){

                }else{
                    if(!empty($orisoft_all_code)){
                        $checka = strpos($orisoft_all_code->division_code,',');
                        $arr_division_code = [];
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->division_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_division_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_division_code,$orisoft_all_code->division_code);
                        }
                        $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                        $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);
                    }
                }

            }
        }

        if($like['search_department'] == "all"){
            $arr_department_code = [];
            if($orisoft_code == "000002"){
                if(trans(request()->segment(1)) == 'manager'){

                }else if(trans(request()->segment(1)) == 'mtl'){
                    $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else{

                }
            }else if($orisoft_code == "990002"){

            }else{
                if($orisoft_code == "000060"){

                }else{
                    if(!empty($orisoft_all_code)){
                        $checka = strpos($orisoft_all_code->department_code,',');
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_all_code->department_code);
                        }
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                        $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                    }
                }
            }
        }

        if($like['search_section'] == "all"){
            $arr_department_code = [];
            $arr_section_code = [];
            if($orisoft_code == "000002"){
                if(trans(request()->segment(1)) == 'manager'){

                }else if(trans(request()->segment(1)) == 'mtl'){
                    $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else{

                }
            }else if($orisoft_code == "990002"){

            }else{
                if($orisoft_code == "000060"){

                }else{
                    if(!empty($orisoft_all_code)){

                        $checka = strpos($orisoft_all_code->section_code,',');
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->section_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_section_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_section_code,$orisoft_all_code->section_code);
                        }

                        $gatall->where(function ($query) use($arr_section_code) {
                            foreach ($arr_section_code as $value) {
                                $sub = substr($value,0,1);
                                $query->orWhere('tb_employee.section_code','like', $sub . '%');
                            }
                        });
                        $count_data->where(function ($query) use($arr_section_code) {
                            foreach ($arr_section_code as $value) {
                                $sub = substr($value,0,1);
                                $query->orWhere('tb_employee.section_code','like', $sub . '%');
                            }
                        });

                    }
                }
            }
        }
        // dd($arr_department_code);
        // exit;

        if(@$like['searchText'] != ""){
            $searchText = @$like['searchText'];
            $gatall->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.position_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.division_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.department_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.section_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee_final_score.evaluator_name_en','like','%'.$searchText.'%');
            });
            $count_data->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.position_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.division_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.department_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.section_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee_final_score.evaluator_name_en','like','%'.$searchText.'%');
            });
        }
        if($like['search_position'] != "all"){
            $gatall->where('tb_employee.position_code', 'like','%'.$like['search_position'].'%');
            $count_data->where('tb_employee.position_code', 'like','%'.$like['search_position'].'%');
        }
        if($like['search_division'] != "all"){
            $gatall->where('tb_employee.division_code', 'like','%'.$like['search_division'].'%');
            $count_data->where('tb_employee.division_code', 'like','%'.$like['search_division'].'%');
        }
        if($like['search_department'] != "all"){
            $gatall->where('tb_employee.department_code', 'like','%'.$like['search_department'].'%');
            $count_data->where('tb_employee.department_code', 'like','%'.$like['search_department'].'%');
        }
        if($like['search_section'] != "all"){
            $gatall->where('tb_employee.section_code', 'like','%'.$like['search_section'].'%');
            $count_data->where('tb_employee.section_code', 'like','%'.$like['search_section'].'%');
            if(trans(request()->segment(1)) == 'manager'){

            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else{
                    $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                    $count_data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{

            }
        }
        if(isset($like['search_employee_no'])){
            if($like['search_employee_no'] != "all"){
                $gatall->where('tb_employee_final_score.evaluator_no', 'like','%'.$like['search_employee_no'].'%');
                $count_data->where('tb_employee_final_score.evaluator_no', 'like','%'.$like['search_employee_no'].'%');
            }
        }
        if($like['search_status'] != "all"){
            $gatall->where('tb_employee_final_score.status_evaluation', '=',$like['search_status']);
            $count_data->where('tb_employee_final_score.status_evaluation', '=',$like['search_status']);
        }

        if(!empty($search)){
            $gatall->where(function ($query) use($search) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
                $query->orWhere('tb_employee.position_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.division_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_description','like','%'.$search.'%');
                $query->orWhere('tb_employee_final_score.evaluator_name_en','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
                $query->orWhere('tb_employee.position_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.division_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.department_description','like','%'.$search.'%');
                $query->orWhere('tb_employee.section_description','like','%'.$search.'%');
                $query->orWhere('tb_employee_final_score.evaluator_name_en','like','%'.$search.'%');
            });
        }

        if(empty($field)){
            $fieldby = 'tb_employee.orisoft_no';
        }
        else{
            if($field == 1){
                $fieldby = 'tb_employee.orisoft_no';
            }else if($field == 2){
                $fieldby = 'tb_employee.employee_local_name_en';
            }else if($field == 3){
                $fieldby = 'tb_employee.position_description';
            }else if($field == 4){
                $fieldby = 'tb_employee.division_description';
            }else if($field == 5){
                $fieldby = 'tb_employee.department_description';
            }else if($field == 6){
                $fieldby = 'tb_employee.section_description';
            }
        }

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }
        $gatall->orderBy($fieldby,$order);
        $gatall = $gatall->skip($start)->take($length)->get();

        $count_data = $count_data->orderBy('tb_employee_final_score.id', 'ASC')->count();
        // dd($gatall);
        if(count($gatall)>0){
            foreach ($gatall as $value) {
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">In progress</span>';
                }
                if($value->status_evaluation == '3'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                }
                $edit_set_evaluators_pa_form = 'disabled';
                if (Auth::user()->can('edit set evaluators pa form')) {
                    $edit_set_evaluators_pa_form = '';
                }

                $evaluator_active = '';
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')
                ->select('evaluator_active')
                ->where('employee_no',$value->orisoft_no)
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->first();
                $checkboxdisabled = 'disabled';

                if($orisoft_code == "000060"){
                    $checkboxdisabled = '';
                }else{
                    if ($value->status_evaluation != '3') {
                        $checkboxdisabled = '';
                    }
                }
                if($tb_employee_evaluator){
                    if($tb_employee_evaluator->evaluator_active == '1'){
                        $eva = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$value->orisoft_no.'" onchange="change_eva(this,'.$value->orisoft_no.');" value="'.$value->orisoft_no.'" data-id="'.$value->id.'" checked '.$edit_set_evaluators_pa_form.' '.$checkboxdisabled.'>';
                    }else{
                        $eva = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$value->orisoft_no.'" onchange="change_eva(this,'.$value->orisoft_no.');" value="'.$value->orisoft_no.'" data-id="'.$value->id.'" '.$edit_set_evaluators_pa_form.' '.$checkboxdisabled.'>';
                    }
                    $evaluator_active = $tb_employee_evaluator->evaluator_active;
                }else{
                    if($value->evaluator_active == '1'){
                        $eva = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$value->orisoft_no.'" onchange="change_eva(this,'.$value->orisoft_no.');" value="'.$value->orisoft_no.'" data-id="'.$value->id.'" checked '.$edit_set_evaluators_pa_form.' '.$checkboxdisabled.'>';
                    }else{
                        $eva = '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault'.$value->orisoft_no.'" onchange="change_eva(this,'.$value->orisoft_no.');" value="'.$value->orisoft_no.'" data-id="'.$value->id.'" '.$edit_set_evaluators_pa_form.' '.$checkboxdisabled.'>';
                    }
                    $evaluator_active = $value->evaluator_active;
                }

                $checkbox = '';
                if ($value->status_evaluation != '3') {
                    $checkbox = '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->orisoft_no.'" id="checkbox-'.$value->orisoft_no.'" value="'.$value->orisoft_no.'" data-id="'.$value->id.'">';
                }
                $data[] = array(
                    "id" =>  $checkbox,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "div"=> $value->division_description,
                    "dept"=> $value->department_description,
                    "sect"=> $value->section_description,
                    "eva"=> '<div class="form-check form-switch">'.$eva.'</div>',
                    "evaN"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "form"=> $value->form_import,
                    "evaluator_active"=> $evaluator_active,
                    "status"=> $status_evaluation,
                    "fieldby" =>  $fieldby,
                    "orderby" =>  $order,
                );
                $pagestart++;
            }
        }else{
            $data = [];
        }

        $totalRecords = $totalDisplay = $count_data;

        $search_year       = $request->input('search_year');
        $checkYearABC = $search_year;
        // $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->where('rec_year','like','%'.$checkYearABC.'%')
        ->where('group_form_id','0')
        ->whereNull('evaluator_no')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 1 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }

        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $data,
        ];
        echo json_encode($result);
    }

    public function assign_evaluator(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');

        $orisoft_no             = $request->input('orisoft_no');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        //     $previousYearmonth = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            $previousYearmonth = $search_year;
            // $previousYear = date('Y');
            // $previousYearmonth = date('Y');
        // }
        if(!empty($orisoft_no)){
            foreach($orisoft_no AS $val){
                $countEmployeeFinalScore = EmployeeFinalScore::where('employee_no', $val)
                // ->whereNull('form_import')
                ->where('rec_year','like','%'.$previousYear.'%')
                ->count();
                if($countEmployeeFinalScore == 0){
                    $CreateEmployeeFinalScore = EmployeeFinalScore::create([
                        "rec_year" => $previousYearmonth,
                        "employee_no" => $val,
                        "evaluator_active" => '1',
                        "created_by" => Auth::user()->id,
                        "updated_by" => '0',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => null,
                    ]);
                }

                DB::table('tb_employee_final_score')->where('employee_no', $val )
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->update([
                    'evaluator_active' => '1'
                ]);

                $countEmployee_evaluator = DB::table('tb_employee_evaluator')
                ->where('employee_no', $val )
                ->where('rec_year',$previousYear)
                ->count();

                $row = DB::table('tb_employee')->where('orisoft_no',$val)->first();
                if($countEmployee_evaluator == 0){

                    // $row = EmployeeModel::where('orisoft_no', $val)->first();
                    $CreateEmployeeFinalScore = EmployeeEvaluator::create([
                        "rec_year" => $previousYear,
                        "employee_no" => $val,
                        "evaluator_active" => '1',
                        "employee_name_th" => $row->employee_local_name_th,
                        "employee_name_en" => $row->employee_local_name_en,

                        "grade_code" => $row->grade_code,
                        "division_code" => $row->division_code,
                        "division_description" => $row->division_description,
                        "department_code" => $row->department_code,
                        "department_description" => $row->department_description,
                        "section_code" => $row->section_code,
                        "section_description" => $row->section_description,
                        "position_description" => $row->position_description,
                        "position_code" => $row->position_code,

                        "created_by" => Auth::user()->id,
                        "updated_by" => '0',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => null,
                    ]);

                    // $countUser = Users::where('orisoft_code', $val)->count();
                    // if($countUser == 0){
                    //     $data = ['name' => $row->employee_local_name_en];
                    //     $data['orisoft_code'] = $val;
                    //     $data['profile_photo_path'] = NULL;
                    //     $data['password'] = Hash::make($val);
                    //     $data['section_code'] = $row->section_code;
                    //     $data['section_description'] = $row->section_description;
                    //     $user = Users::updateOrCreate(['email' => NULL], $data);

                    //     $rowusers = DB::table('users')->where('orisoft_code',$orisoft_no)->first();
                    //     $check_users_model_has_roles = DB::table('users_model_has_roles')
                    //     ->where('users_model_has_roles.model_id',$rowusers->id)
                    //     ->where('users_model_has_roles.role_id','8')
                    //     ->count();
                    //     if($check_users_model_has_roles == 0){
                    //         DB::table('users_model_has_roles')->insert([
                    //             'role_id' => '8',
                    //             'model_type' => 'App\Models\User',
                    //             'model_id' => $rowusers->id
                    //         ]);
                    //     }
                    // }
                }else{
                    DB::table('tb_employee_evaluator')
                    ->where('employee_no', $val )
                    ->where('rec_year',$previousYear)
                    ->update([
                        'evaluator_active' => '1'
                    ]);
                }

                $countUser = Users::where('orisoft_code', $val)->count();
                if($countUser == 0){
                    DB::table('users')->insert([
                        'name' => $row->employee_local_name_en,
                        'orisoft_code' => $val,
                        'profile_photo_path' => NULL,
                        'password' => Hash::make($val),
                        'section_code' => $row->section_code,
                        'section_description' => $row->section_description
                    ]);
                    // $user = Users::updateOrCreate(['email' => NUll], $data);

                    $rowusers = DB::table('users')->where('orisoft_code',$val)->first();
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','8')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '8',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
            }
        }












        // $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $orisoft_division_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code->orisoft_code)->first();

        // $department_count = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.department_code',
        // 'tb_employee.department_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $department_count = $department_count->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->count();
        // if($department_count == 0){
        //     $department = DB::table('tb_employee_evaluator')
        //     // ->select(
        //     // 'tb_employee.division_code',
        //     // 'tb_employee.division_description',
        //     // )
        //     // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_evaluator.department_code',$orisoft_division_code->department_code);
        //     $department = $department->groupBy('tb_employee_evaluator.department_code')->orderBy('department_code', 'ASC')->get();
        // }else{
        //     $department = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.department_code',
        //     'tb_employee.department_description',
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();
        // }

        // $new_department_code = [];
        // if(count($department)>0){
        //     foreach ($department as $value) {
        //         array_push($new_department_code,$value->department_code);
        //     }
        // }

        // $evaluator = DB::table('tb_employee_final_score')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee.orisoft_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        // // ->where('tb_employee.section_code',$section_codex)
        // ->where('tb_employee_evaluator.evaluator_active','1')
        // ;

        // // $evaluator->whereIn('tb_employee.department_code',$new_department_code);

        // $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_all_code = DB::table('tb_employee_evaluator')->where('employee_no',$orisoft_code)->first();
        // if($section_code != "all"){
        //     $evaluator->where('tb_employee.section_code', 'like','%'.$section_code.'%');
        // }else{
        //     if($search_division == "all"){
        //         $checka = strpos($orisoft_all_code->division_code,',');
        //         $arr_division_code = [];
        //         if($checka >= 0){
        //             $ex = explode(',',$orisoft_all_code->division_code);
        //             if(count($ex)>0){
        //                 foreach ($ex as $value) {
        //                     array_push($arr_division_code,$value);
        //                 }
        //             }
        //         }else{
        //             array_push($arr_division_code,$orisoft_all_code->division_code);
        //         }
        //         $evaluator = $evaluator->whereIn('tb_employee.division_code',$arr_division_code);
        //     }else{
        //         $evaluator = $evaluator->where('tb_employee.division_code',$search_division);
        //     }

        //     if($search_department == "all"){
        //         $arr_department_code = [];
        //         $checka = strpos($orisoft_all_code->department_code,',');
        //         if($checka >= 0){
        //             $ex = explode(',',$orisoft_all_code->department_code);
        //             if(count($ex)>0){
        //                 foreach ($ex as $value) {
        //                     array_push($arr_department_code,$value);
        //                 }
        //             }
        //         }else{
        //             array_push($arr_department_code,$orisoft_all_code->department_code);
        //         }
        //         $evaluator = $evaluator->whereIn('tb_employee.department_code',$arr_department_code);
        //     }else{
        //         $evaluator = $evaluator->where('tb_employee.department_code',$search_department);
        //     }

        // }

        // $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ;
        if($section_code != "all"){
            $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
        }else{
            if($search_division == "all"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $evaluator->where(function ($query) use($arr_division_code) {
                    foreach ($arr_division_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                    }
                });
                // $evaluator = $evaluator->whereIn('tb_employee_evaluator.division_code',$arr_division_code);
            }else{
                // dd('search_division');
                $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
            }

            if($search_department == "all"){
                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $evaluator->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                    }
                });
                // foreach ($arr_department_code as $valuexxx) {
                //     $evaluator = $evaluator->orwhere('tb_employee_evaluator.department_code', 'like','%'.$valuexxx.'%');
                // }
                // $evaluator = $evaluator->whereIn('tb_employee_evaluator.department_code',$arr_department_code);
            }else{
                // dd('search_department');
                $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
            }

            if($section_code == "all"){
                $arr_section_code = [];
                $checka = strpos($orisoft_all_code->section_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_all_code->section_code);
                }
                $evaluator->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                    }
                });
            }
        }
        $evaluator = $evaluator->where('tb_employee_evaluator.evaluator_active','1')->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $result = [
            'orisoft_no'                => $orisoft_no,
            'row'                => $row,
            'evaluator'                => $evaluator,
        ];
        echo json_encode($result);
    }

    public function change_eva(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');

        $orisoft_no             = $request->input('orisoft_no');
        $id             = $request->input('id');
        $evaluator_active             = $request->input('evaluator_active');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        //     $previousYearmonth = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            $previousYearmonth = $search_year;
            // $previousYear = date('Y');
            // $previousYearmonth = date('Y');
        // }
        // if($id == ""){
        //     $CreateEmployeeFinalScore = EmployeeFinalScore::create([
        //         "rec_year" => $previousYearmonth,
        //         "employee_no" => $orisoft_no,
        //         "evaluator_active" => $evaluator_active,
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
            DB::table('tb_employee_final_score')->where('id', $id )->update([
                'evaluator_active' => $evaluator_active
            ]);
        // }
        // $countEmployeeFinalScore = EmployeeFinalScore::where('employee_no', $orisoft_no)
        // ->whereNull('form_import')
        // ->count();
        // if($countEmployeeFinalScore == 0){

        // }

        // DB::table('tb_employee_final_score')->where('employee_no', $orisoft_no )->update([
        //     'evaluator_active' => $evaluator_active
        // ]);

        $countEmployee_evaluator = DB::table('tb_employee_evaluator')
        ->where('employee_no', $orisoft_no )
        ->where('rec_year',$previousYear)
        ->count();
        $row = DB::table('tb_employee')->where('orisoft_no',$orisoft_no)->first();
        if($countEmployee_evaluator == 0){

            // $row = EmployeeModel::where('orisoft_no', $orisoft_no)->first();
            $CreateEmployeeFinalScore = EmployeeEvaluator::create([
                "rec_year" => $previousYear,
                "employee_no" => $orisoft_no,
                "evaluator_active" => $evaluator_active,
                "employee_name_th" => $row->employee_local_name_th,
                "employee_name_en" => $row->employee_local_name_en,

                "grade_code" => $row->grade_code,
                "division_code" => $row->division_code,
                "division_description" => $row->division_description,
                "department_code" => $row->department_code,
                "department_description" => $row->department_description,
                "section_code" => $row->section_code,
                "section_description" => $row->section_description,
                "position_description" => $row->position_description,
                "position_code" => $row->position_code,

                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);


        }else{
            DB::table('tb_employee_evaluator')
            ->where('employee_no', $orisoft_no )
            ->where('rec_year',$previousYear)
            ->update([
                'evaluator_active' => $evaluator_active
            ]);
        }

        if($evaluator_active == 0){
            $usersrow = DB::table('users')->where('orisoft_code',$orisoft_no)->first();
            DB::table('users_model_has_roles')->where('model_id', $usersrow->id)->delete();
            DB::table('users')->where('orisoft_code', $orisoft_no)->delete();
            // dd($evaluator_active);
            // exit;
        }else{
            $countUser = Users::where('orisoft_code', $orisoft_no)->count();

            if($countUser == 0){
                // $data = ['name' => $row->employee_local_name_en];
                // $data['orisoft_code'] = $orisoft_no;
                // $data['profile_photo_path'] = NULL;
                // $data['password'] = Hash::make($orisoft_no);
                // $data['section_code'] = $row->section_code;
                // $data['section_description'] = $row->section_description;
                DB::table('users')->insert([
                    'name' => $row->employee_local_name_en,
                    'orisoft_code' => $orisoft_no,
                    'profile_photo_path' => NULL,
                    'password' => Hash::make($orisoft_no),
                    'section_code' => $row->section_code,
                    'section_description' => $row->section_description
                ]);
                // $user = Users::updateOrCreate(['email' => NUll], $data);

                $rowusers = DB::table('users')->where('orisoft_code',$orisoft_no)->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();
                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }
            }
        }


        $countusers = DB::table('users')->where('orisoft_code',$orisoft_no)->count();
        if($countusers > 0){
            DB::table('users')
            ->where('orisoft_code', $orisoft_no )
            ->update([
                'active' => $evaluator_active
            ]);
        }

        // $count_sec = [];
        // $counttb_employee_final_score = DB::table('tb_employee_final_score')->where('evaluator_no',$orisoft_no)->count();
        // if($counttb_employee_final_score > 0){
        //     $sec1 = DB::table('tb_employee_final_score')
        //     ->select('tb_employee.*')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_no)
        //     ->groupBy('tb_employee.section_code')->get();
        //     $count_sec = $sec1;
        //     $counttb_employee_final_score = DB::table('tb_employee_evaluator')
        //     ->where('evaluator_no', 'like','%'.$section_code.'%')
        //     ->count();
        // }







        // $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $orisoft_division_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code->orisoft_code)->first();

        // $department_count = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.department_code',
        // 'tb_employee.department_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $department_count = $department_count->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->count();
        // if($department_count == 0){
        //     $department = DB::table('tb_employee_evaluator')
        //     // ->select(
        //     // 'tb_employee.division_code',
        //     // 'tb_employee.division_description',
        //     // )
        //     // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_evaluator.department_code',$orisoft_division_code->department_code);
        //     $department = $department->groupBy('tb_employee_evaluator.department_code')->orderBy('department_code', 'ASC')->get();
        // }else{
        //     $department = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.department_code',
        //     'tb_employee.department_description',
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();
        // }

        // $new_department_code = [];
        // if(count($department)>0){
        //     foreach ($department as $value) {
        //         array_push($new_department_code,$value->department_code);
        //     }
        // }

        $evaluator = DB::table('tb_employee_final_score')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee.orisoft_no')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        // ->where('tb_employee.section_code',$section_codex)
        ->where('tb_employee_evaluator.evaluator_active','1')
        ;

        // $evaluator->whereIn('tb_employee.department_code',$new_department_code);














        // $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_all_code = DB::table('tb_employee_evaluator')->where('employee_no',$orisoft_code)->first();

        // $evaluator = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // ->where('tb_employee_evaluator.evaluator_active','1')
        // ;
        // if($section_code != "all"){
        //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
        // }else{
        //     if($search_division == "all"){
        //         $checka = strpos($orisoft_all_code->division_code,',');
        //         $arr_division_code = [];
        //         if($checka >= 0){
        //             $ex = explode(',',$orisoft_all_code->division_code);
        //             if(count($ex)>0){
        //                 foreach ($ex as $value) {
        //                     array_push($arr_division_code,$value);
        //                 }
        //             }
        //         }else{
        //             array_push($arr_division_code,$orisoft_all_code->division_code);
        //         }
        //         foreach ($arr_division_code as $valuexxx) {
        //             $evaluator = $evaluator->orwhere('tb_employee_evaluator.division_code', 'like','%'.$valuexxx.'%');
        //         }
        //         // $evaluator = $evaluator->whereIn('tb_employee_evaluator.division_code',$arr_division_code);
        //     }else{
        //         // dd('search_division');
        //         $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
        //     }

        //     if($search_department == "all"){
        //         $arr_department_code = [];
        //         $checka = strpos($orisoft_all_code->department_code,',');
        //         if($checka >= 0){
        //             $ex = explode(',',$orisoft_all_code->department_code);
        //             if(count($ex)>0){
        //                 foreach ($ex as $value) {
        //                     array_push($arr_department_code,$value);
        //                 }
        //             }
        //         }else{
        //             array_push($arr_department_code,$orisoft_all_code->department_code);
        //         }
        //         foreach ($arr_department_code as $valuexxx) {
        //             $evaluator = $evaluator->orwhere('tb_employee_evaluator.department_code', 'like','%'.$valuexxx.'%');
        //         }
        //         // $evaluator = $evaluator->whereIn('tb_employee_evaluator.department_code',$arr_department_code);
        //     }else{
        //         // dd('search_department');
        //         $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
        //     }

        // }
        // $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ;
        if($section_code != "all"){
            $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
        }else{
            if($search_division == "all"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $evaluator->where(function ($query) use($arr_division_code) {
                    foreach ($arr_division_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                    }
                });
                // $evaluator = $evaluator->whereIn('tb_employee_evaluator.division_code',$arr_division_code);
            }else{
                // dd('search_division');
                $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
            }

            if($search_department == "all"){
                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $evaluator->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                    }
                });
                // foreach ($arr_department_code as $valuexxx) {
                //     $evaluator = $evaluator->orwhere('tb_employee_evaluator.department_code', 'like','%'.$valuexxx.'%');
                // }
                // $evaluator = $evaluator->whereIn('tb_employee_evaluator.department_code',$arr_department_code);
            }else{
                // dd('search_department');
                $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
            }

            if($section_code == "all"){
                $arr_section_code = [];
                $checka = strpos($orisoft_all_code->section_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_all_code->section_code);
                }
                $evaluator->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                    }
                });
            }
        }
        $evaluator = $evaluator->where('tb_employee_evaluator.evaluator_active','1')->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();

        $result = [
            'orisoft_no'                => $orisoft_no,
            'evaluator'                => $evaluator,
            'row' => $row,
            // 'count_sec' => $count_sec
        ];
        echo json_encode($result);
    }

    public function specify_form(Request $request)
    {
        $orisoft_no             = $request->input('orisoft_no');
        $specify_form_select             = $request->input('specify_form_select');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYearmonth = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYearmonth = $search_year;
            // $previousYearmonth = date('Y');
        // }

        if(!empty($orisoft_no)){
            foreach ($orisoft_no as $key => $val) {
                $row = DB::table('group_form')->select('id')->where('group_form.form_year_use_start',$previousYearmonth)->where('form_ref', $specify_form_select)->first();
                $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $row->id)->get();

                $evaluation_criteria_id = '';
                $evaluation_criteria_id_comma = '';
                foreach ($row_group_form_topic as $key2 => $val2) {
                    $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
                    $evaluation_criteria_id_comma .= ',';
                }
                $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
                if($orisoft_no[$key]['id'] == ""){
                    $CreateEmployeeFinalScore = EmployeeFinalScore::create([
                        "rec_year" => $previousYearmonth,
                        "employee_no" => $orisoft_no[$key]['code'],
                        "form_import" => $specify_form_select,
                        "group_form_id" => $row->id,
                        "evaluation_criteria_id" => $evaluation_criteria_id,
                        "criteria_score_eva" => $evaluation_criteria_id_comma,
                        "criteria_score_old" => $evaluation_criteria_id_comma,
                        "criteria_score_new" => $evaluation_criteria_id_comma,
                        "created_by" => Auth::user()->id,
                        "updated_by" => '0',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => null,
                    ]);
                }else{
                    DB::table('tb_employee_final_score')
                    ->where('id', $orisoft_no[$key]['id'] )
                    ->update([
                        "form_import" => $specify_form_select,
                        "group_form_id" => $row->id,
                        "evaluation_criteria_id" => $evaluation_criteria_id,
                        "criteria_score_eva" => $evaluation_criteria_id_comma,
                        "criteria_score_old" => $evaluation_criteria_id_comma,
                        "criteria_score_new" => $evaluation_criteria_id_comma,
                        "status_pa" => '3',
                        "total_score" => '0.00',
                        "total_score_old" => '0.00',
                        "pa_grade" => NULL,
                        "pa_grade_edit" => '0',
                        "adjust_grade" => NULL,
                        "status_evaluation" => '0',
                        "company_suggested_per" => '0.00',
                        "company_suggestged_amount" => '0.00',
                        "company_suggestged_new_basic" => '0.00',
                        "grade_proposed_old" => NULL,
                        "grade_proposed" => NULL,
                        "percent_proposed_old" => '0.0000',
                        "percent_proposed" => '0.0000',
                        "amount_proposed" => '0.00',
                        "salary_new" => '0.00',
                        "salary_month_new" => '0.00',
                        "final_by_md_gm_amount" => '0.00',
                        "status_salary" => '0',
                        "freeze" => '0',
                        "freeze_to_pagrade" => '0',
                        "freeze_to_gmdm" => '0'
                    ]);
                }
                // $countEmployeeFinalScore = EmployeeFinalScore::where('employee_no', $val->code)->count();
                // if($countEmployeeFinalScore == 0){

                // }else{

                //     $countEmployeeFinalScore2 = EmployeeFinalScore::where('employee_no', $val->code)
                //     ->where('form_import',$specify_form_select)
                //     ->count();
                //     if($countEmployeeFinalScore2 > 0){
                //         DB::table('tb_employee_final_score')
                //         ->where('employee_no', $val->code )
                //         ->whereNull('form_import')
                //         ->update([
                //             "form_import" => $specify_form_select,
                //             "group_form_id" => $row->id,
                //         ]);
                //     }else{
                //         $countEmployeeFinalScore3 = EmployeeFinalScore::where('employee_no', $val->code)
                //         ->WhereNull('form_import')->count();
                //         if($countEmployeeFinalScore3 > 0){
                //             DB::table('tb_employee_final_score')
                //             ->where('employee_no', $val->code )
                //             ->whereNull('form_import')
                //             ->update([
                //                 "form_import" => $specify_form_select,
                //                 "group_form_id" => $row->id,
                //             ]);
                //         }
                //     }
                // }
            }
        }



        $result = [
            'orisoft_no'                => $orisoft_no,
            'row_group_form_topic'                => $row_group_form_topic,
            // 'row' => $row,
            // 'countEmployeeFinalScore' => $countEmployeeFinalScore
        ];
        echo json_encode($result);
    }

    public function specify_eva_name(Request $request)
    {
        $orisoft_no             = $request->input('orisoft_no');
        $specify_eva_code             = $request->input('specify_eva_code');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYearmonth = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYearmonth = $search_year;
            // $previousYearmonth = date('Y');
        // }

        if(!empty($orisoft_no)){
            foreach ($orisoft_no as $key => $val) {
                $row = DB::table('tb_employee_evaluator')->select('employee_name_th','employee_name_en')
                ->where('employee_no', $specify_eva_code)
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYearmonth.'%')
                ->first();
                if($orisoft_no[$key]['id'] == ""){
                    $CreateEmployeeFinalScore = EmployeeFinalScore::create([
                        "evaluator_no" => $specify_eva_code,
                        "evaluator_name_th" => $row->employee_name_th,
                        "evaluator_name_en" => $row->employee_name_en,
                        "created_by" => Auth::user()->id,
                        "updated_by" => '0',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => null,
                    ]);
                }else{
                    DB::table('tb_employee_final_score')
                    ->where('id', $orisoft_no[$key]['id'] )
                    ->update([
                        "evaluator_no" => $specify_eva_code,
                        "evaluator_name_th" => $row->employee_name_th,
                        "evaluator_name_en" => $row->employee_name_en,
                        "status_pa" => '3'
                    ]);
                }
            }
        }



        $result = [
            'orisoft_no'                => $orisoft_no,
            // 'row' => $row,
            // 'countEmployeeFinalScore' => $countEmployeeFinalScore
        ];
        echo json_encode($result);
    }

    public function get_eva_review(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');
        $search_month_day      = $request->input('search_month_day');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->first();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%');

        if($orisoft_code == "013591" || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
            $evaluator->where('tb_employee_evaluator.employee_no', $orisoft_code);
        }

        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $evaluator->where('tb_employee_evaluator.grade_code','L800');
            }
            if($search_month_day == "2"){
                $evaluator->where('tb_employee_evaluator.grade_code','!=','L800');
            }
        }
        if(!empty($section_code)){
            if($section_code != "all"){
                if(is_array($section_code)){
                    $evaluator->whereIn('tb_employee_evaluator.section_code',$section_code);
                }else{
                    $evaluator->where('tb_employee_evaluator.section_code','LIKE', '%'.$section_code.'%');
                }
            }else{
                if($search_division == "all"){
                    if($orisoft_code == "000002" || $orisoft_code == "990002"){

                    }else{
                        if(!empty($orisoft_all_code)){
                            $checka = strpos($orisoft_all_code->division_code,',');
                            $arr_division_code = [];
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->division_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_division_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_division_code,$orisoft_all_code->division_code);
                            }
                            $evaluator->where(function ($query) use($arr_division_code) {
                                foreach ($arr_division_code as $valuexxx) {
                                    $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                                }
                            });
                        }
                    }
                    // $evaluator = $evaluator->whereIn('tb_employee_evaluator.division_code',$arr_division_code);
                }else{
                    // dd('search_division');
                    $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
                }

                if($search_department == "all"){
                    if($orisoft_code == "000002" || $orisoft_code == "990002"){

                    }else{
                        $arr_department_code = [];
                        if(!empty($orisoft_all_code)){
                            $checka = strpos($orisoft_all_code->department_code,',');
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_all_code->department_code);
                            }
                            $evaluator->where(function ($query) use($arr_department_code) {
                                foreach ($arr_department_code as $valuexxx) {
                                    $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                                }
                            });
                        }
                    }
                    // foreach ($arr_department_code as $valuexxx) {
                    //     $evaluator = $evaluator->orwhere('tb_employee_evaluator.department_code', 'like','%'.$valuexxx.'%');
                    // }
                    // $evaluator = $evaluator->whereIn('tb_employee_evaluator.department_code',$arr_department_code);
                }else{
                    // dd('search_department');
                    $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
                }

                if($section_code == "all"){
                    if($orisoft_code != "990002"){
                        $arr_section_code = [];
                        if(!empty($orisoft_all_code)){
                            $checka = strpos($orisoft_all_code->section_code,',');
                            if($checka >= 0){
                                $ex = explode(',',$orisoft_all_code->section_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_section_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_section_code,$orisoft_all_code->section_code);
                            }
                            $evaluator->where(function ($query) use($arr_section_code) {
                                foreach ($arr_section_code as $value) {
                                    $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                }
            }
        }else{
            if(!empty($orisoft_all_code)){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $evaluator->where(function ($query) use($arr_division_code) {
                    foreach ($arr_division_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                    }
                });
            }
        }

        $raw_evaluator = $evaluator->where('tb_employee_evaluator.evaluator_active','1')->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->toRawSql();
        $evaluator = $evaluator->where('tb_employee_evaluator.evaluator_active','1')->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
        $result = [
            'data'                => $evaluator,
            'raw_evaluator'       => $raw_evaluator
        ];
        echo json_encode($result);

    }

    public function get_eva_salary(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');
        $search_year      = $request->input('search_year');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')->first();
        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "000002" || $orisoft_code == "000026"|| $orisoft_code == "013591"|| $orisoft_code == "990002"){
            // dd($orisoft_code);
            // exit;
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                    'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
            ->where('tb_employee_evaluator.evaluator_active','1');
            if(isset($section_code)){
                if(count($section_code) > 0){
                    $evaluator->where(function ($query) use($section_code) {
                        foreach ($section_code as $value) {
                            $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                        }
                    });
                }
            }
            // if($section_code != "all"){
            //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
            // }
            if(isset($search_division)){
                if(count($search_division) > 0){
                    $evaluator->whereIn('tb_employee_evaluator.division_code',$search_division);
                }
            }
            // if($search_division != "all"){
            //     $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
            // }
            if(isset($search_department)){
                if(count($search_department) > 0){
                    $evaluator->whereIn('tb_employee_evaluator.department_code',$search_department);
                }
            }
            // if($search_department != "all"){
            //     $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
            // }
            $evaluator = $evaluator->orderBy('tb_employee_evaluator.section_code', 'ASC')->get();
        }else{
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                    'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
            ->where('tb_employee_evaluator.evaluator_active','1')
            ;
            if($orisoft_code == "990354"){
                $evaluator->where('tb_employee_evaluator.employee_no', '990354');
            }
            if(isset($section_code)){
                if(count($section_code) > 0){
                    // dd($section_code);
                    $evaluator->where(function ($query) use($section_code) {
                        foreach ($section_code as $value) {
                            $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                        }
                    });
                }
                // $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
            }else{
                if(!isset($search_division)){
                    $checka = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_all_code->division_code);
                    }
                    // dd($arr_division_code);
                    $evaluator->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $valuexxx) {
                            $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                        }
                    });
                }else{
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $evaluator->where(function ($query) use($search_division) {
                                foreach ($search_division as $value) {
                                    $query->orWhere('tb_employee_evaluator.division_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                }

                if(!isset($search_department) && !isset($search_division)){
                    $arr_department_code = [];
                    $checka = strpos($orisoft_all_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_all_code->department_code);
                    }
                    // dd($arr_department_code);
                    $evaluator->Where(function ($query) use($arr_department_code) {
                        foreach ($arr_department_code as $valuexxx) {
                            $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                        }
                    });
                }else if(isset($search_department) && isset($search_division)){
                    $evaluator->where(function ($query) use($search_department) {
                        foreach ($search_department as $value) {
                            $query->orWhere('tb_employee_evaluator.department_code','like','%'.$value.'%');
                        }
                    });
                }else{
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $evaluator->where(function ($query) use($search_department) {
                                foreach ($search_department as $value) {
                                    $query->orWhere('tb_employee_evaluator.department_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                    // $evaluator = $evaluator->where('tb_employee_evaluator.department_code','like','%'.$search_department.'%');
                }

                if(!isset($search_section)){
                    $arr_section_code = [];
                    $checka = strpos($orisoft_all_code->section_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->section_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_section_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_code,$orisoft_all_code->section_code);
                    }
                    $evaluator->where(function ($query) use($arr_section_code) {
                        foreach ($arr_section_code as $value) {
                            $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                        }
                    });
                }
            }
            $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
        }


        $result = [
            'data'                => $evaluator,
        ];
        echo json_encode($result);

    }

    public function get_eva_salary_review(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');
        $search_year      = $request->input('search_year');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')->first();
        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "000002" || $orisoft_code == "000026"|| $orisoft_code == "990002"){
                if($orisoft_code == "000002" || $orisoft_code == "000026"){
                    $evaluator = DB::table('tb_employee_evaluator')
                    ->select('tb_employee_evaluator.employee_no',
                            'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                            'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
                    ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
                    ->where('tb_employee_evaluator.evaluator_active','1');
                    if(isset($section_code)){
                        if(count($section_code) > 0){
                            $evaluator->where(function ($query) use($section_code) {
                                foreach ($section_code as $value) {
                                    $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                    // if($section_code != "all"){
                    //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
                    // }
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $evaluator->whereIn('tb_employee_evaluator.division_code',$search_division);
                        }
                    }
                    // if($search_division != "all"){
                    //     $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
                    // }
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $evaluator->whereIn('tb_employee_evaluator.department_code',$search_department);
                        }
                    }
                    // if($search_department != "all"){
                    //     $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
                    // }
                    $evaluator = $evaluator->orderBy('tb_employee_evaluator.section_code', 'ASC')->get();
                }else{
                    // dd($orisoft_code);
                    // exit;
                    $evaluator = DB::table('tb_employee_evaluator')
                    ->select('tb_employee_evaluator.employee_no',
                            'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                            'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
                    ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
                    ->where('tb_employee_evaluator.evaluator_active','1');
                    if(isset($section_code)){
                        if(count($section_code) > 0){
                            $evaluator->where(function ($query) use($section_code) {
                                foreach ($section_code as $value) {
                                    $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                    // if($section_code != "all"){
                    //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
                    // }
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            foreach ($search_division as $value) {
                                $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$value.'%');
                            }
                        }
                    }
                    // if($search_division != "all"){
                    //     $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
                    // }
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            foreach ($search_department as $value) {
                                $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$value.'%');
                            }
                        }
                    }
                    // if($search_department != "all"){
                    //     $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
                    // }
                    $evaluator = $evaluator->orderBy('tb_employee_evaluator.section_code', 'ASC')->get();
                }
            // }else{
            //     // dd($orisoft_code);
            //     // exit;
            //     $evaluator = DB::table('tb_employee_evaluator')
            //     ->select('tb_employee_evaluator.employee_no',
            //             'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
            //             'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
            //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            //     ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
            //     ->where('tb_employee_evaluator.evaluator_active','1');
            //     if(isset($section_code)){
            //         if(count($section_code) > 0){
            //             $evaluator->where(function ($query) use($section_code) {
            //                 foreach ($section_code as $value) {
            //                     $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
            //                 }
            //             });
            //         }
            //     }
            //     // if($section_code != "all"){
            //     //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
            //     // }
            //     if(isset($search_division)){
            //         if(count($search_division) > 0){
            //             foreach ($search_division as $value) {
            //                 $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$value.'%');
            //             }
            //         }
            //     }
            //     // if($search_division != "all"){
            //     //     $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
            //     // }
            //     if(isset($search_department)){
            //         if(count($search_department) > 0){
            //             foreach ($search_department as $value) {
            //                 $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$value.'%');
            //             }
            //         }
            //     }
            //     // if($search_department != "all"){
            //     //     $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
            //     // }
            //     $evaluator = $evaluator->orderBy('tb_employee_evaluator.section_code', 'ASC')->get();
            // }
        }else{
            $percent_department_count = DB::table('tb_percent_department_action')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year','like','%'.$search_year.'%')
            ->where('tb_percent_department_action.approve_by2', $orisoft_code )
            ->count();
            $percent_department_count3 = DB::table('tb_percent_department_action')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year','like','%'.$search_year.'%')
            ->where('tb_percent_department_action.approve_by3', $orisoft_code )
            ->count();
            // dd($percent_department_count);
            // exit;
            if($percent_department_count > 0 && $percent_department_count3 == 0){
                $arr_section_code = [];
                $section1 = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$search_year.'%')
                ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                ->groupBy('tb_percent_department_action.section_code')
                ->orderBy('tb_section.section_code', 'ASC')->get();
                if(count($section1)>0){
                    foreach ($section1 as $value) {
                        array_push($arr_section_code,$value->section_code);
                    }
                }
                $evaluator = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                        'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
                ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
                ->where('tb_employee_evaluator.evaluator_active','1')
                ;
                $evaluator->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                    }
                });
                $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                // dd($arr_section_code);
                // exit;
            }else if($percent_department_count3 > 0){
                $arr_section_code = [];
                $section1 = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$search_year.'%')
                ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                ->groupBy('tb_percent_department_action.section_code')
                ->orderBy('tb_section.section_code', 'ASC')->get();
                if(count($section1)>0){
                    foreach ($section1 as $value) {
                        array_push($arr_section_code,$value->section_code);
                    }
                }
                $evaluator = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                        'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
                ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
                ->where('tb_employee_evaluator.evaluator_active','1')
                ;
                $evaluator->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                    }
                });
                $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
                // dd($arr_section_code);
                // exit;
            }else{
                $evaluator = DB::table('tb_employee_evaluator')
                ->select('tb_employee_evaluator.employee_no',
                        'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                        'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
                ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
                ->where('tb_employee_evaluator.evaluator_active','1')
                ;
                if(isset($section_code)){
                    if(count($section_code) > 0){
                        // dd($section_code);
                        $evaluator->where(function ($query) use($section_code) {
                            foreach ($section_code as $value) {
                                $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                            }
                        });
                    }
                    // $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
                }else{
                    if(!isset($search_division)){
                        $checka = strpos($orisoft_all_code->division_code,',');
                        $arr_division_code = [];
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->division_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_division_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_division_code,$orisoft_all_code->division_code);
                        }
                        // dd($arr_division_code);
                        $evaluator->where(function ($query) use($arr_division_code) {
                            foreach ($arr_division_code as $valuexxx) {
                                $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                            }
                        });
                    }else{
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $evaluator->where(function ($query) use($search_division) {
                                    foreach ($search_division as $value) {
                                        $query->orWhere('tb_employee_evaluator.division_code','like','%'.$value.'%');
                                    }
                                });
                            }
                        }
                    }

                    if(!isset($search_department) && !isset($search_division)){
                        $arr_department_code = [];
                        $checka = strpos($orisoft_all_code->department_code,',');
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_all_code->department_code);
                        }
                        // dd($arr_department_code);
                        $evaluator->Where(function ($query) use($arr_department_code) {
                            foreach ($arr_department_code as $valuexxx) {
                                $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                            }
                        });
                    }else if(isset($search_department) && isset($search_division)){
                        $evaluator->where(function ($query) use($search_department) {
                            foreach ($search_department as $value) {
                                $query->orWhere('tb_employee_evaluator.department_code','like','%'.$value.'%');
                            }
                        });
                    }else{
                        if(isset($search_department)){
                            if(count($search_department) > 0){
                                $evaluator->where(function ($query) use($search_department) {
                                    foreach ($search_department as $value) {
                                        $query->orWhere('tb_employee_evaluator.department_code','like','%'.$value.'%');
                                    }
                                });
                            }
                        }
                        // $evaluator = $evaluator->where('tb_employee_evaluator.department_code','like','%'.$search_department.'%');
                    }

                    if(!isset($search_section)){
                        $arr_section_code = [];
                        $checka = strpos($orisoft_all_code->section_code,',');
                        if($checka >= 0){
                            $ex = explode(',',$orisoft_all_code->section_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_section_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_section_code,$orisoft_all_code->section_code);
                        }
                        $evaluator->where(function ($query) use($arr_section_code) {
                            foreach ($arr_section_code as $value) {
                                $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                            }
                        });
                    }
                }
                $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
            }
        }


        $result = [
            'data'                => $evaluator,
        ];
        echo json_encode($result);

    }

    public function get_eva_pa_grade(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');
        $search_year       = $request->input('search_year');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();
        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "000002" || $orisoft_code == "000026" || $orisoft_code == "990002"){
            // dd($orisoft_code);
            // exit;
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                    'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
            // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
            ->where('tb_employee_evaluator.evaluator_active','1');

            if (!empty($search_division)) {
                $evaluator->where(function ($query) use ($search_division) {
                    foreach ($search_division as $division) {
                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee_evaluator.division_code)", [$division]);
                    }
                });
            }

            // 🔹 ค้นหา department_code ด้วย FIND_IN_SET()
            if (!empty($search_department)) {
                $evaluator->where(function ($query) use ($search_department) {
                    foreach ($search_department as $department) {
                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee_evaluator.department_code)", [$department]);
                    }
                });
            }

            // 🔹 ค้นหา section_code ด้วย FIND_IN_SET()
            if (!empty($section_code)) {
                $evaluator->where(function ($query) use ($section_code) {
                    foreach ($section_code as $section) {
                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee_evaluator.section_code)", [$section]);
                    }
                });
            }
            // if(isset($search_division)){
            //     if(count($search_division) > 0){
            //         $evaluator->whereIn('tb_employee_evaluator.division_code', $search_division);
            //     }
            // }
            // if(isset($search_department)){
            //     if(count($search_department) > 0){
            //         $evaluator->whereIn('tb_employee_evaluator.department_code', $search_department);
            //     }
            // }
            // if(isset($section_code)){
            //     if(count($section_code) > 0){
            //         $evaluator->whereIn('tb_employee_evaluator.section_code', $section_code);
            //     }
            // }
            // if($section_code != "all"){
            //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
            // }
            // if($search_division != "all"){
            //     $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
            // }
            // if($search_department != "all"){
            //     $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
            // }

            $evaluator_raw = $evaluator->toRawSql();
            $evaluator = $evaluator->orderBy('tb_employee_evaluator.section_code', 'ASC')->get();
            // dd($evaluator);
            // exit;
        }else{
            $evaluator = DB::table('tb_employee_evaluator')
            ->select('tb_employee_evaluator.employee_no',
                    'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                    'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
            ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
            ->where('tb_employee_evaluator.evaluator_active','1')
            ;
            if(isset($section_code)){
                if(count($section_code) > 0){
                    // dd($section_code);
                    $evaluator->where(function ($query) use($section_code) {
                        foreach ($section_code as $value) {
                            $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                        }
                    });
                }
                // $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
            }else{
                if(!isset($search_division)){
                    $checka = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_all_code->division_code);
                    }
                    // dd($arr_division_code);
                    $evaluator->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $valuexxx) {
                            $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                        }
                    });
                }else{
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $evaluator->where(function ($query) use($search_division) {
                                foreach ($search_division as $value) {
                                    $query->orWhere('tb_employee_evaluator.division_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                }

                if(!isset($search_department) && !isset($search_division)){
                    $arr_department_code = [];
                    $checka = strpos($orisoft_all_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_all_code->department_code);
                    }
                    // dd($arr_department_code);
                    $evaluator->Where(function ($query) use($arr_department_code) {
                        foreach ($arr_department_code as $valuexxx) {
                            $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                        }
                    });
                }else if(isset($search_department) && isset($search_division)){
                    $evaluator->where(function ($query) use($search_department) {
                        foreach ($search_department as $value) {
                            $query->orWhere('tb_employee_evaluator.department_code','like','%'.$value.'%');
                        }
                    });
                }else{
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $evaluator->where(function ($query) use($search_department) {
                                foreach ($search_department as $value) {
                                    $query->orWhere('tb_employee_evaluator.department_code','like','%'.$value.'%');
                                }
                            });
                        }
                    }
                    // $evaluator = $evaluator->where('tb_employee_evaluator.department_code','like','%'.$search_department.'%');
                }

                if(!isset($search_section)){
                    $arr_section_code = [];
                    $checka = strpos($orisoft_all_code->section_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_all_code->section_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_section_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_code,$orisoft_all_code->section_code);
                    }
                    $evaluator->where(function ($query) use($arr_section_code) {
                        foreach ($arr_section_code as $value) {
                            $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                        }
                    });
                }
            }
            // if($section_code != "all"){
            //     $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
            // }else{
            //     if($search_division == "all"){
            //         $checka = strpos($orisoft_all_code->division_code,',');
            //         $arr_division_code = [];
            //         if($checka >= 0){
            //             $ex = explode(',',$orisoft_all_code->division_code);
            //             if(count($ex)>0){
            //                 foreach ($ex as $value) {
            //                     array_push($arr_division_code,$value);
            //                 }
            //             }
            //         }else{
            //             array_push($arr_division_code,$orisoft_all_code->division_code);
            //         }
            //         foreach ($arr_division_code as $valuexxx) {
            //             $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$valuexxx.'%');
            //         }
            //         // $evaluator = $evaluator->whereIn('tb_employee_evaluator.division_code',$arr_division_code);
            //     }else{
            //         $evaluator = $evaluator->where('tb_employee_evaluator.division_code',$search_division);
            //     }

            //     if($search_department == "all"){
            //         $arr_department_code = [];
            //         $checka = strpos($orisoft_all_code->department_code,',');
            //         if($checka >= 0){
            //             $ex = explode(',',$orisoft_all_code->department_code);
            //             if(count($ex)>0){
            //                 foreach ($ex as $value) {
            //                     array_push($arr_department_code,$value);
            //                 }
            //             }
            //         }else{
            //             array_push($arr_department_code,$orisoft_all_code->department_code);
            //         }
            //         foreach ($arr_department_code as $valuexxx) {
            //             $evaluator = $evaluator->orwhere('tb_employee_evaluator.department_code', 'like','%'.$valuexxx.'%');
            //         }
            //         // $evaluator = $evaluator->whereIn('tb_employee_evaluator.department_code',$arr_department_code);
            //     }else{
            //         $evaluator = $evaluator->where('tb_employee_evaluator.department_code',$search_department);
            //     }

            // }
            $evaluator_raw = $evaluator->toRawSql();
            $evaluator = $evaluator->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
        }


        $result = [
            'data'                => $evaluator,
            'dataraw'                => $evaluator_raw,
        ];
        echo json_encode($result);

    }

    public function get_eva_pagrade(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $section_code      = $request->input('section_code');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')->where('employee_no',$orisoft_code)->first();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ;
        if($section_code != "all"){
            $evaluator->where('tb_employee_evaluator.section_code', 'like','%'.$section_code.'%');
        }else{
            if($search_division == "all"){
                $checka = strpos($orisoft_all_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_all_code->division_code);
                }
                $evaluator->where(function ($query) use($arr_division_code) {
                    foreach ($arr_division_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.division_code','like','%'.$valuexxx.'%');
                    }
                });
                // $evaluator = $evaluator->whereIn('tb_employee_evaluator.division_code',$arr_division_code);
            }else{
                // dd('search_division');
                $evaluator = $evaluator->where('tb_employee_evaluator.division_code', 'like','%'.$search_division.'%');
            }

            if($search_department == "all"){
                $arr_department_code = [];
                $checka = strpos($orisoft_all_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_all_code->department_code);
                }
                $evaluator->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $valuexxx) {
                        $query->orWhere('tb_employee_evaluator.department_code','like','%'.$valuexxx.'%');
                    }
                });
                // foreach ($arr_department_code as $valuexxx) {
                //     $evaluator = $evaluator->orwhere('tb_employee_evaluator.department_code', 'like','%'.$valuexxx.'%');
                // }
                // $evaluator = $evaluator->whereIn('tb_employee_evaluator.department_code',$arr_department_code);
            }else{
                // dd('search_department');
                $evaluator = $evaluator->where('tb_employee_evaluator.department_code', 'like','%'.$search_department.'%');
            }

            if($section_code == "all"){
                $arr_section_code = [];
                $checka = strpos($orisoft_all_code->section_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_all_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_all_code->section_code);
                }
                $evaluator->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                    }
                });
            }
        }
        $evaluator = $evaluator->where('tb_employee_evaluator.evaluator_active','1')->groupBy('tb_employee_evaluator.employee_no')->orderBy('employee_no', 'ASC')->get();
        $result = [
            'data'                => $evaluator,
        ];
        echo json_encode($result);

    }

    public function get_form_list(Request $request)
    {
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        $group_form = DB::table('group_form')
        ->select('id','form_ref','form_th','form_en')
        ->where('group_form.form_year_use_start',$previousYear)
        ->orderBy('form_ref', 'ASC')->get();
        $result = [
            'data'                => $group_form,
        ];
        echo json_encode($result);

    }

    public function export_excel_set_evaluate(Request $request)
    {
        $search_year      = $request->input('search_year');
        $previousYear = $search_year;

        $searchText      = $request->input('searchText');
        $search_position      = $request->input('search_position');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_employee_no      = $request->input('search_employee_no');
        $search_status      = $request->input('search_status');


        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_th',
        'tb_employee.employee_local_name_en',
        'tb_employee.position_description',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee_final_score.evaluator_name_th',
        'tb_employee_final_score.evaluator_name_en'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($search_division == "all"){
            $checka = strpos($orisoft_all_code->division_code,',');
            $arr_division_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->division_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_division_code,$value);
                    }
                }
            }else{
                array_push($arr_division_code,$orisoft_all_code->division_code);
            }
            $datarow = $datarow->whereIn('tb_employee.division_code',$arr_division_code);
        }

        if($search_department == "all"){
            $arr_department_code = [];
            $checka = strpos($orisoft_all_code->department_code,',');
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->department_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_department_code,$value);
                    }
                }
            }else{
                array_push($arr_department_code,$orisoft_all_code->department_code);
            }
            $datarow = $datarow->whereIn('tb_employee.department_code',$arr_department_code);
        }

        if($search_section == "all"){
            $arr_section_code = [];
            $checka = strpos($orisoft_all_code->section_code,',');
            if($checka >= 0){
                $ex = explode(',',$orisoft_all_code->section_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_section_code,$value);
                    }
                }
            }else{
                array_push($arr_section_code,$orisoft_all_code->section_code);
            }
            $datarow->where(function ($query) use($arr_section_code) {
                foreach ($arr_section_code as $value) {
                    $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                }
            });
        }

        if($searchText != ""){
            $searchText = $searchText;
            $datarow->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee.orisoft_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.position_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.division_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.department_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.section_description','like','%'.$searchText.'%');
                $query->orWhere('tb_employee_final_score.evaluator_name_en','like','%'.$searchText.'%');
            });
        }
        if($search_position != "all"){
            $datarow->where('tb_employee.position_code', 'like','%'.$search_position.'%');
        }
        if($search_division != "all"){
            $datarow->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        }
        if($search_department != "all"){
            $datarow->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all"){
            $datarow->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $datarow->where('tb_employee_final_score.evaluator_no', 'like','%'.$search_employee_no.'%');
            }
        }
        if($search_status != "all"){
            $datarow->where('tb_employee_final_score.status_evaluation', '=',$search_status);
        }

        $datarow->orderBy('tb_employee.orisoft_no','asc');
        $datarow = $datarow->get();


        $data = [];
        if(count($datarow)>0){
            foreach ($datarow as $value) {
                $status_evaluation = '';
                if($value->status_evaluation == '1'){
                    $status_evaluation = 'In progress';
                }
                if($value->status_evaluation == '3'){
                    $status_evaluation = 'Approved';
                }
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')->select('evaluator_active')->where('employee_no',$value->orisoft_no)->first();

                if($tb_employee_evaluator){
                    if($tb_employee_evaluator->evaluator_active == '1'){
                        $eva = 'Active';
                    }else{
                        $eva = 'InActive';
                    }
                }else{
                    if($value->evaluator_active == '1'){
                        $eva = 'Active';
                    }else{
                        $eva = 'InActive';
                    }
                }

                $data[] = array(
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "div"=> $value->division_description,
                    "dept"=> $value->department_description,
                    "sect"=> $value->section_description,
                    "eva"=> $eva,
                    "evaN"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "form"=> $value->form_import,
                    "status"=> $status_evaluation,
                );
            }
        }else{
            $data = [];
        }


        $excel = public_path('upload/orisoft/')."template_set_eva.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);

        $sheet = $spreadsheet->getActiveSheet();
        // $sheet2 = $spreadsheet->getSheet(1);
        // $sheet3 = $spreadsheet->getSheet(2);
        // $sheet4 = $spreadsheet->getSheet(3);

        // dd($data);
        // exit;
        $numsheet1 = 2;
        if($data){
            foreach ($data as $key => $value) {
                $sheet->setCellValue('A'.$numsheet1, $value['code']);
                $sheet->setCellValue('B'.$numsheet1, $value['name']);
                $sheet->setCellValue('C'.$numsheet1, $value['position']);
                $sheet->setCellValue('D'.$numsheet1, $value['div']);
                $sheet->setCellValue('E'.$numsheet1, $value['dept']);
                $sheet->setCellValue('F'.$numsheet1, $value['sect']);
                $sheet->setCellValue('G'.$numsheet1, $value['eva']);
                $sheet->setCellValue('H'.$numsheet1, $value['evaN']);
                $sheet->setCellValue('I'.$numsheet1, $value['form']);
                $sheet->setCellValue('J'.$numsheet1, $value['status']);
                $numsheet1++;
            }
        }
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Set Evaluators and PA Forms.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
}
