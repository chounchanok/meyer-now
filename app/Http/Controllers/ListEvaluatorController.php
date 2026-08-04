<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportReport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ListEvaluatorController extends Controller
{
    public function index()
    {
        // $year = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.rec_year')
        // ->groupBy('tb_employee_final_score.rec_year')->get();

        // $position = DB::table('tb_position')->orderBy('id', 'ASC')->get();
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        // $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
        // $evaluator = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee.employee_local_name_th',
        //         'tb_employee.employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        // ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        // $section = DB::table('tb_section');
        // $section = $section->orderBy('id', 'ASC')->get();

        // $orisoft_code = Auth::user()->orisoft_code;
        // $section_code = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code',
        // 'tb_employee.section_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->groupBy('tb_employee.section_code');
        // $section_code = $section_code->get();

        // $test1 = [];
        // if($section_code){
        //     foreach ($section_code as $key => $value) {
        //         array_push($test1,$value->section_code);
        //     }
        // }

        // $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $orisoft_division_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code->orisoft_code)->first();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        ->orderBy('tb_employee_evaluator.employee_no', 'ASC')->get();

        // $position = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.position_code',
        // 'tb_employee.position_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();



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
            if(!empty($orisoft_all_code->division_code)){
                $checka = strpos($orisoft_all_code->division_code,',');
            }
            $arr_division_code = [];
            $arr_department_code2 = [];
            $arr_department_code = [];
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



        // dd($arr_department_code);
        // exit;








        // $division = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code',
        // 'tb_employee.division_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $division = $division->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();

        // $division = DB::table('tb_employee_evaluator')
        // // ->select(
        // // 'tb_employee.division_code',
        // // 'tb_employee.division_description',
        // // )
        // // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_evaluator.division_code',$orisoft_division_code->division_code);
        // $division = $division->groupBy('tb_employee_evaluator.division_code')->orderBy('division_code', 'ASC')->get();




        // else{
        //     $department_count = DB::table('tb_employee_final_score')
        //     ->select(
        //     'tb_employee.department_code',
        //     'tb_employee.department_description',
        //     )
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //     $department_count = $department_count->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->count();
        //     if($department_count == 0){
        //         $department = DB::table('tb_employee_evaluator')
        //         ->where('tb_employee_evaluator.department_code',$orisoft_division_code->department_code);
        //         $department = $department->groupBy('tb_employee_evaluator.department_code')->orderBy('department_code', 'ASC')->get();
        //     }else{
        //         $department = DB::table('tb_employee_final_score')
        //         ->select(
        //         'tb_employee.department_code',
        //         'tb_employee.department_description',
        //         )
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        //         $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();
        //     }
        // }

        // dd($department);
        // exit();
        // $new_department_code = [];
        // if(count($department)>0){
        //     foreach ($department as $value) {
        //         array_push($new_department_code,$value->department_code);
        //     }
        // }

        // $department = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.department_code',
        // 'tb_employee.department_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();

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
        // $section = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code',
        // 'tb_employee.section_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        // ->whereIn('tb_employee.division_code',$new_division_code)
        // ;
        // $section = $section->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->get();

        // $checka = strpos($orisoft_division_code->division_code,',');
        // $arr_division_code = [];
        // if($checka >= 0){
        //     $ex = explode(',',$orisoft_division_code->division_code);
        //     if(count($ex)>0){
        //         foreach ($ex as $value) {
        //             array_push($arr_division_code,$value);
        //         }
        //     }
        // }else{
        //     array_push($arr_division_code,$orisoft_division_code->division_code);
        //     $search_division      = $orisoft_division_code->division_code;
        //     if($search_division){
        //         $sub = substr($search_division,0,1);
        //         if($sub == 'G' || $sub == 'P'){
        //             $department = DB::table('tb_department')
        //             ->where('tb_department.department_code','like','%'.$orisoft_division_code->department_code.'%')->get();
        //         }else{
        //             $department = DB::table('tb_department')
        //             ->where('tb_department.department_code','like',''.$sub.'%')->get();
        //         }
        //     }
        // }

        // $division = DB::table('tb_division')
        // ->whereIn('tb_division.division_code',$arr_division_code);
        // $division = $division->groupBy('tb_division.division_code')->orderBy('division_code', 'ASC')->get();

        $year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
        return view('pages.ListEvaluator.index', [
            "year" => $year,
            "evaluator" => $evaluator,
            "position" => $position,
            // "division" => $division,
            // "department" => $department,
            // "section" => $section
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.ListEvaluator.index');
    }

    public function table_listE_getdata(Request $request)
    {
        $search_year      = $request->input('search_year');
        $search_position      = $request->input('search_position');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_status      = $request->input('search_status');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.employee_local_name_en',
        'tb_employee.position_description',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee.employee_status_description',
        'tb_employee.id AS employee_id',
        'tb_employee.employee_status_description_na'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->first();



            if($search_division == "0"){
                if($orisoft_code == "000002"){
                    if(trans(request()->segment(1)) == 'manager'){

                    }else if(trans(request()->segment(1)) == 'mtl'){
                        $datarow->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    }else{

                    }
                }else if($orisoft_code == "990002"){

                }else{
                    if(trans(request()->segment(1)) == 'manager'){
                        $checka = strpos($orisoft_all_code->section_code,',');
                        $arr_section_code = [];
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
                        if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){

                        }else{
                            $datarow = $datarow->whereIn('tb_employee.section_code',$arr_section_code);
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
                            if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){

                            }else{
                                $datarow = $datarow->whereIn('tb_employee.division_code',$arr_division_code);
                            }
                        }
                    }
                }

            }



            if($search_department == "0"){
                if($orisoft_code == "000002"){
                    if(trans(request()->segment(1)) == 'manager'){

                    }else if(trans(request()->segment(1)) == 'mtl'){
                        $datarow->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    }else{

                    }
                }else if($orisoft_code == "990002"){

                }else{
                    if(trans(request()->segment(1)) == 'manager'){
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
                        if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){

                        }else{
                            $datarow = $datarow->whereIn('tb_employee.section_code',$arr_section_code);
                        }
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
                            if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){

                            }else{
                                $datarow = $datarow->whereIn('tb_employee.department_code',$arr_department_code);
                            }
                        }
                    }
                }
            }

        // dd($arr_department_code);
        // exit;
        if($search_year != "0"){
            $datarow->where(function ($query) use($search_year) {
                $query->orWhere('tb_employee_final_score.rec_year','like','%'.$search_year.'%');
            });
        }

        if($search_position != "0"){
            $datarow = $datarow->where('tb_employee.position_code', $search_position);
        }
        if($search_division != "0"){
            $datarow = $datarow->where('tb_employee.division_code', $search_division);
        }
        if($search_department != "0"){
            $datarow = $datarow->where('tb_employee.department_code', $search_department);
        }
        if($search_section != "0"){
            $datarow = $datarow->where('tb_employee.section_code', $search_section);
            if(trans(request()->segment(1)) == 'manager'){

            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    $datarow->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else{
                    $datarow->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{

            }
        }
        if($search_status != "0"){
            $datarow = $datarow->where('tb_employee.employee_status_description', $search_status);
        }
        $datarow = $datarow->orderBy('tb_employee_final_score.id','ASC')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $display_none = '';
                $checkbox = '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">';
                if($value->status_evaluation <= 1){
                    $display_none = 'display:none;';
                    $checkbox = '';
                }
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->employee_status_description_na == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">NE</span>';
                }else{
                    if($value->employee_status_description == 'Passed'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Passed</span>';
                    }else if($value->employee_status_description == 'Transferred'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-warning">Transferred</span>';
                    }else if($value->employee_status_description == 'Resigned'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">Resigned</span>';
                    }
                }


                $edit_review_evaluate_employees = 'style="display:none;"';
                if (Auth::user()->can('edit review evaluate employees')) {
                    $edit_review_evaluate_employees = 'style="display:block;"';
                }
                $edit_review_evaluate_employees2 = 'display:none;';
                if (Auth::user()->can('edit review evaluate employees')) {
                    $edit_review_evaluate_employees2 = 'display:block;';
                }
                if($orisoft_code == "000060" || $orisoft_code == "990002"){
                    $employee_local_name_en = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal_attendance" onclick="get_attendance('.$value->id.')" >'.$value->employee_local_name_en.'</a>';
                }else{
                    $employee_local_name_en = $value->employee_local_name_en;
                }
                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">',
                    "order"=> $key+1,
                    "code"=> $value->employee_no,
                    "name"=> $employee_local_name_en,
                    "position"=> $value->position_description,
                    "div"=> $value->division_description,
                    "dept"=> $value->department_description,
                    "sect"=> $value->section_description,
                    "status"=> $status_evaluation,
                    "action"=> '<div style="display: flex;">
                                <button type="button" class="btn btn-icon btn-success btn-xs me-1" data-bs-toggle="modal" data-bs-target="#approveModalSingle" onclick="fetchEmployee_pass('.$value->employee_id.','.$value->id.')" '.$edit_review_evaluate_employees.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#transferModal" onclick="fetchEmployee('.$value->employee_id.','.$value->id.')" '.$edit_review_evaluate_employees.'>
                                    <i class="ki-solid ki-arrows-loop fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#resignModal" onclick="fetchEmployee_resign('.$value->employee_id.','.$value->id.')" '.$edit_review_evaluate_employees.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#resignModal_na" onclick="fetchEmployee_resign_na('.$value->employee_id.','.$value->id.')" style="'.$edit_review_evaluate_employees2.'margin-left: 4px;">
                                    NE
                                </button>
                                </div>',
                );
            }
        }
        // for ($i=1; $i < 11; $i++) {
        //     $data[] = array(
        //         "id" =>  '<input type="checkbox">',
        //         "order"=> "$i",
        //         "code"=> "123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>",
        //         "name"=> "Chantarat Chaichana",
        //         "position"=> "xxxxxxxx",
        //         "div"=> "xxxx",
        //         "dept"=> "xxxx",
        //         "sect"=> "xxxx",
        //         "status"=> "status",
        //         "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-warning text-dark btn-xs me-1' data-bs-toggle='modal' data-bs-target='#transferModal'><i class='ki-solid ki-arrows-loop fs-5'></i></button><button type='button' class='btn btn-icon btn-danger btn-xs' data-bs-toggle='modal' data-bs-target='#resignModal'><i class='ki-solid ki-cross-circle fs-5'></i></button>",

        //     );
        // }

        $result = [
            'data'            => $data,
        ];
        echo json_encode($result);

    }

    public function ListEvaluator_update_status_all(Request $request)
    {
        $id             = $request->input('id');
        $status_evaluation         = $request->input('status_evaluation');

        if(!empty($id)){
            foreach($id AS $val){
                $data = DB::table('tb_employee_final_score')
                ->select('employee_no')
                ->where('id', $val)
                ->first();
                DB::table('tb_employee')->where('orisoft_no', $data->employee_no)
                ->update([
                    'employee_status_description' => 'Passed',
                    'resign_effective_date' => NULL
                ]);
            }
        }
        $result = [
            'id'                => $id,
            'status_evaluation'                => $status_evaluation
        ];
        echo json_encode($result);
    }

    public function get_transferred(Request $request)
    {
        $id                             = $request->input('id');
        $data = DB::table('tb_employee')
        ->select('employee_local_name_en','division_code','department_code','section_code','transferred_effective_date')
        ->where('id', $id)
        ->first();
        echo json_encode($data);
    }

    public function save_pass(Request $request)
    {
        $id                     = $request->input('id');

        DB::table('tb_employee')->where('id', $id )->update([
            'employee_status_description' => 'Passed',
            'resign_effective_date' => NULL,
            "division_code_transferred" => NULL,
            "department_code_transferred" => NULL,
            "section_code_transferred" => NULL,
        ]);
        $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee')
        ->whereNull('employee_status_description')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 0 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }
        $result = [
            'id'                => $id
        ];
        echo json_encode($result);
    }

    public function save_transferred(Request $request)
    {
        $id                             = $request->input('id');
        $division_code_transferred          = $request->input('division');
        $department_code_transferred        = $request->input('department');
        $section_code_transferred           = $request->input('section');
        $transferred_effective_date           = $request->input('transferred_effective_date');

        DB::table('tb_employee')->where('id', $id)
        ->update([
            'employee_status_description' => 'Transferred',
            "division_code_transferred" => $division_code_transferred,
            "department_code_transferred" => $department_code_transferred,
            "section_code_transferred" => $section_code_transferred,
            "transferred_effective_date" => $transferred_effective_date
        ]);
        $result = [
            'id'                => $id
        ];
        echo json_encode($result);
    }

    public function save_resign(Request $request)
    {
        $id                     = $request->input('id');
        $id_final_resign                     = $request->input('id_final_resign');
        $resign_effective_date  = $request->input('resign_effective_date');

        DB::table('tb_employee')->where('id', $id )->update([
            'employee_status_description' => 'Resigned',
            'resign_effective_date' => $resign_effective_date,
            "division_code_transferred" => NULL,
            "department_code_transferred" => NULL,
            "section_code_transferred" => NULL,
            "transferred_effective_date" => NULL
        ]);
        $result = [
            'id'                => $id
        ];
        echo json_encode($result);
    }

    public function save_resign_na(Request $request)
    {
        $id                     = $request->input('id');
        $id_final_resign                     = $request->input('id_final_resign');
        $resign_effective_date  = $request->input('resign_effective_date');

        DB::table('tb_employee')->where('id', $id )->update([
            'employee_status_description' => 'Resigned',
            'employee_status_description_na' => '1',
        ]);
        $result = [
            'id'                => $id
        ];
        echo json_encode($result);
    }

    public function get_division(Request $request)
    {
        $pagenow      = $request->input('pagenow');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        $orisoft_code = Auth::user()->orisoft_code;

        $orisoft_division_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    $orisoft_division_code = DB::table('tb_employee_evaluator')
                    ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                    ->where('employee_no',$orisoft_code)->first();

                    $checka = strpos($orisoft_division_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_division_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_division_code->division_code);
                    }

                    $division = DB::table('tb_division')
                    ->whereIn('tb_division.division_code',$arr_division_code);
                    $division = $division->orderBy('division_code', 'ASC')->get();
                }else{
                    $division = DB::table('tb_percent_department_action')
                    ->select('tb_division.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $division = $division->groupBy('tb_percent_department_action.division_code')->orderBy('tb_percent_department_action.division_code', 'ASC')->get();
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($pagenow == '1'){
                    $division = DB::table('tb_employee_final_score')
                    ->select('tb_division.*')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->leftJoin('tb_division','tb_division.division_code','=','tb_employee.division_code')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.evaluator_no','000002');
                    $division = $division->groupBy('tb_employee.division_code')->orderBy('tb_employee.division_code', 'ASC')->get();
                }else{
                    $division = DB::table('tb_percent_department_action')
                    ->select('tb_division.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $division = $division->groupBy('tb_percent_department_action.division_code')->orderBy('tb_percent_department_action.division_code', 'ASC')->get();
                }
            }else{
                $division = DB::table('tb_percent_department_action')
                ->select('tb_division.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $division = $division->groupBy('tb_percent_department_action.division_code')->orderBy('tb_percent_department_action.division_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $orisoft_division_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_division_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_division_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_division_code->division_code);
                }
                $division = DB::table('tb_division')
                ->whereIn('tb_division.division_code',$arr_division_code);
                $division = $division->orderBy('division_code', 'ASC')->get();
            }else{
                // dd($arr_department_code);
                // exit();
                $division = DB::table('tb_percent_department_action')
                ->select('tb_division.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                ->where('tb_percent_department_action.approve_by2','000026')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                $division = $division->groupBy('tb_percent_department_action.division_code')
                ->orderBy('tb_percent_department_action.division_code', 'ASC')->get();
                if(!$division){
                    $division = DB::table('tb_percent_department_action')
                    ->select('tb_division.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $division = $division->groupBy('tb_percent_department_action.division_code')->orderBy('tb_percent_department_action.division_code', 'ASC')->get();

                }
            }
        }else if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "990002"){
            $division = DB::table('tb_division');
            $division = $division->orderBy('division_code', 'ASC')->get();
        }else{
            $checka = strpos($orisoft_division_code->division_code,',');
            $arr_division_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_division_code->division_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_division_code,$value);
                    }
                }
            }else{
                array_push($arr_division_code,$orisoft_division_code->division_code);
            }
            $division = DB::table('tb_division')
            ->whereIn('tb_division.division_code',$arr_division_code);
            $division = $division->orderBy('division_code', 'ASC')->get();
        }

        // dd($arr_division_code);
        // exit;


        $result = [
            'data'                => $division,
            'orisoft_code'        => $orisoft_code
        ];
        echo json_encode($result);

    }

    public function get_division_salary(Request $request)
    {
        $pagenow      = $request->input('pagenow');
        $search_year      = $request->input('search_year');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "990002"){
            $division = DB::table('tb_division');
            $division = $division->orderBy('division_code', 'ASC')->get();
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    $orisoft_division_code = DB::table('tb_employee_evaluator')
                    ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                    ->where('employee_no',$orisoft_code)->first();

                    $checka = strpos($orisoft_division_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_division_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_division_code->division_code);
                    }

                    $division = DB::table('tb_division')
                    ->whereIn('tb_division.division_code',$arr_division_code);
                    $division = $division->orderBy('division_code', 'ASC')->get();
                }else{
                    $division = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $division = $division->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                }
            }else{
                $division = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $division = $division->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $orisoft_division_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_division_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_division_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_division_code->division_code);
                }

                $division = DB::table('tb_division')
                ->whereIn('tb_division.division_code',$arr_division_code);
                $division = $division->orderBy('division_code', 'ASC')->get();
            }else{
                $division = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by1','000026')
                ->orWhere('tb_percent_department_action.approve_by2','000026');
                $division = $division->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
            }
        }else{
            $orisoft_division_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            if(!empty($orisoft_division_code)){
                $checka = strpos($orisoft_division_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_division_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_division_code->division_code);
                }

                $division = DB::table('tb_division')
                ->whereIn('tb_division.division_code',$arr_division_code);
                $division = $division->orderBy('division_code', 'ASC')->get();
            }else{
                $division = DB::table('tb_division');
                $division = $division->orderBy('division_code', 'ASC')->get();
            }

        }


        $result = [
            'data'                => $division
        ];
        echo json_encode($result);

    }

    public function get_division_review_salary(Request $request)
    {
        $pagenow      = $request->input('pagenow');
        $search_year      = $request->input('search_year');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "990002" || $orisoft_code == "000002"){
            $division = DB::table('tb_division');
            $division = $division->orderBy('division_code', 'ASC')->get();
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    $orisoft_division_code = DB::table('tb_employee_evaluator')
                    ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                    ->where('employee_no',$orisoft_code)->first();

                    $checka = strpos($orisoft_division_code->division_code,',');
                    $arr_division_code = [];
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_division_code->division_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_division_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code,$orisoft_division_code->division_code);
                    }

                    $division = DB::table('tb_division')
                    ->whereIn('tb_division.division_code',$arr_division_code);
                    $division = $division->orderBy('division_code', 'ASC')->get();
                }else{
                    $division = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $division = $division->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                }
            }else{
                $percent_department_count = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2', $orisoft_code )
                ->count();
                $percent_department_count3 = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by3', $orisoft_code )
                ->count();
                // dd($percent_department_count);
                // exit;
                if($percent_department_count > 0 && $percent_department_count3 == 0){
                    if(isset($search_division)){
                        $division = DB::table('tb_percent_department_action')
                        ->select('tb_division.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->groupBy('tb_percent_department_action.division_code')
                        ->orderBy('tb_division.division_code', 'ASC')->get();
                    }else{
                        $division = DB::table('tb_percent_department_action')
                        ->select('tb_division.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->groupBy('tb_percent_department_action.division_code')
                        ->orderBy('tb_division.division_code', 'ASC')->get();
                    }
                }else if($percent_department_count3 > 0){
                    if(isset($search_division)){
                        $division = DB::table('tb_percent_department_action')
                        ->select('tb_division.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                        ->groupBy('tb_percent_department_action.division_code')
                        ->orderBy('tb_division.division_code', 'ASC')->get();
                    }else{
                        $division = DB::table('tb_percent_department_action')
                        ->select('tb_division.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_division','tb_division.division_code','=','tb_percent_department_action.division_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                        ->groupBy('tb_percent_department_action.division_code')
                        ->orderBy('tb_division.division_code', 'ASC')->get();
                    }
                }else{
                    $division = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $division = $division->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                }

            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $orisoft_division_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_division_code->division_code,',');
                $arr_division_code = [];
                if($checka >= 0){
                    $ex = explode(',',$orisoft_division_code->division_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_division_code,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code,$orisoft_division_code->division_code);
                }

                $division = DB::table('tb_division')
                ->whereIn('tb_division.division_code',$arr_division_code);
                $division = $division->orderBy('division_code', 'ASC')->get();
            }else{
                $division = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by1','000026')
                ->orWhere('tb_percent_department_action.approve_by2','000026');
                $division = $division->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
            }
        }else{
            $orisoft_division_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            $checka = strpos($orisoft_division_code->division_code,',');
            $arr_division_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_division_code->division_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_division_code,$value);
                    }
                }
            }else{
                array_push($arr_division_code,$orisoft_division_code->division_code);
            }

            $division = DB::table('tb_division')
            ->whereIn('tb_division.division_code',$arr_division_code);
            $division = $division->orderBy('division_code', 'ASC')->get();
        }


        $result = [
            'data'                => $division
        ];
        echo json_encode($result);

    }

    public function get_department(Request $request)
    {
        $search_division      = $request->input('search_division');
        $orisoft_code = Auth::user()->orisoft_code;
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');

        $orisoft_department_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $arr_department_code = [];
        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }else{
            if(!empty($orisoft_department_code)){
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
            }
        }

        if(is_array($search_division)){
            if(!is_array($search_division)){
                $search_division = [$search_division];
            }
            if(in_array("0", $search_division) || in_array("all", $search_division)){
                $department = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code);
                    $department = $department->orderBy('department_code', 'ASC')->get();
            }else{
                if($orisoft_code == "000060" || $orisoft_code == "000002" || $orisoft_code == "019492"){
                    $department = DB::table('tb_department');
                    $department = $department->whereIn('department_code',$arr_department_code)->orderBy('department_code', 'ASC')->get();
                }else{
                    $sub = [];
                    if (!empty($search_division)) {
                        foreach ($search_division as $value) {
                            $_sub = substr($value,0,1);
                            array_push($sub,$_sub);
                        }
                    }
                    if(trans(request()->segment(1)) == 'mtl'){
                        if($orisoft_code == "000002"){
                            $department = DB::table('tb_employee_final_score')
                            ->select('tb_department.*')
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->leftJoin('tb_department','tb_department.department_code','=','tb_employee.department_code')
                            ->whereIn('tb_employee.division_code',$search_division)
                            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            ->where('tb_employee_final_score.evaluator_no','000002')
                            ->where('tb_employee.employee_status_description','Passed')
                            ->whereNot('tb_employee.grade_code','L810')
                            ->whereNot('tb_employee.grade_code','L820');
                            $department = $department->groupBy('tb_employee.department_code')->orderBy('tb_employee.department_code', 'ASC')->get();
                        }else if($orisoft_code == "990002"){
                            $department = DB::table('tb_department')
                            ->whereIn('tb_department.department_code',$sub);
                            $department = $department->orderBy('department_code', 'ASC')->orderBy('department_code','ASC')->get();
                        }else{
                            $department = DB::table('tb_department');
                            $department = $department->whereIn('department_code',$arr_department_code)->orderBy('department_code', 'ASC')->get();
                        }
                    }else{
                        if(!empty($arr_department_code)){
                            $_department = DB::table('tb_department')
                            ->whereIn('tb_department.department_code',$arr_department_code);
                            $department = $_department->orderBy('department_code','ASC')->get();
                        }else{
                            $_department = DB::table('tb_department');
                            foreach ($sub as $_sub) {
                                $_department->orWhere('tb_department.department_code','like',$_sub.'%');
                            }
                            $department = $_department->orderBy('department_code','ASC')->get();
                        }

                    }
                }
            }
        }else{
            if($orisoft_code == "000060" || $orisoft_code == "000002" || $orisoft_code == "019492"){
                $search_division_llike = substr($search_division,0,1);
                $department = DB::table('tb_department');
                $department = $department->where('department_code','like',$search_division_llike.'%')->orderBy('department_code', 'ASC')->get();
            }else{
                if(!empty($arr_department_code)){
                    $_department = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code);
                    $department = $_department->orderBy('department_code','ASC')->get();
                }else{
                    $sub = [];
                    if (!empty($search_division)) {
                        foreach ($search_division as $value) {
                            $_sub = substr($value,0,1);
                            array_push($sub,$_sub);
                        }
                    }
                    $_department = DB::table('tb_department');
                    foreach ($sub as $_sub) {
                        $_department->orWhere('tb_department.department_code','like',$_sub.'%');
                    }
                    $department = $_department->orderBy('department_code','ASC')->get();
                }
            }
        }

        $result = [
            'data' => $department,
            'orisoft_code' => $orisoft_code
        ];
        echo json_encode($result);

    }

    public function get_department_salary(Request $request)
    {
        $search_year      = $request->input('search_year');
        $previousYear = $search_year;
        $search_division      = $request->input('search_division');
        $pagenow      = $request->input('pagenow');
        $orisoft_code = Auth::user()->orisoft_code;
        $raw = '';

        $orisoft_department_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "990002"){
            if(isset($search_division)){
                if(count($search_division) > 0){
                    // foreach ($search_division as $value) {
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        // ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                        // $sub = substr($value,0,1);
                        // $department = DB::table('tb_department')
                        // ->where('tb_department.department_code','like',''.$sub.'%')->get();
                    // }
                }
            }
            if(!isset($search_division)){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_department.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->groupBy('tb_percent_department_action.department_code')
                ->orderBy('tb_department.department_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    $arr_department_code = [];
                    $checka = strpos($orisoft_department_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_department_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_department_code->department_code);
                    }
                    // dd($arr_department_code);
                    // exit();
                    if(!isset($search_division)){
                        $department = DB::table('tb_department')
                        ->whereIn('tb_department.department_code',$arr_department_code);
                        $department = $department->orderBy('department_code', 'ASC')->get();
                    }
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $department = DB::table('tb_percent_department_action')
                            ->select('tb_department.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.department_code')
                            ->orderBy('tb_department.department_code', 'ASC')->get();
                        }
                    }
                }else{
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            foreach ($search_division as $value) {
                                $department = DB::table('tb_percent_department_action')
                                ->select('tb_percent_department_action.department_code')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->where('tb_percent_department_action.division_code','like','%'.$value.'%')
                                ->where('tb_percent_department_action.approve_by2','000002');
                                $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                            }
                        }
                    }
                    if(!isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.department_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    }
                }
            }else{
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        foreach ($search_division as $value) {
                            $department = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.department_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.division_code','like','%'.$value.'%')
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                        }
                    }
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                }
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $arr_department_code = [];
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
                // dd($arr_department_code);
                // exit();
                if(!isset($search_division)){
                    $department = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code);
                    $department = $department->orderBy('department_code', 'ASC')->get();
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                    }
                }
            }else{
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $_department = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.department_code')
                            ->leftJoin('tb_percent_department', 'tb_percent_department.id', '=', 'tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year', 'like', '%' . $previousYear . '%');

                        $_department->where(function ($query) use ($search_division) {
                            foreach ($search_division as $value) {
                                $sub = substr($value, 0, 1);
                                $query->orWhere('tb_percent_department_action.department_code', 'like', $sub . '%');
                            }
                        });
                        $department = $_department->groupBy('tb_percent_department_action.department_code') // ระบุชื่อตารางด้วย
                            ->orderBy('tb_percent_department_action.department_code', 'ASC') // ระบุชื่อตารางด้วย
                            ->get();
                    }
                }else{
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026')
                    ->orWhere('tb_percent_department_action.approve_by2','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                }
            }
        }else{
            $arr_department_code = [];
            if(!empty($orisoft_department_code)){
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
                // dd($arr_department_code);
                // exit();
                if(!isset($search_division)){
                    $department_raw = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code)->orderBy('department_code', 'ASC');
                    $raw = $department_raw->toRawSql();
                    $department = $department_raw->get();
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        // dd($orisoft_code);
                        // exit();
                        $department_raw = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC');
                        $raw = $department_raw->toRawSql();
                        $department = $department_raw->get();
                    }
                }
            }else{
                $department_raw = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC');
                $raw = $department_raw->toRawSql();
                $department = $department_raw->get();
            }
        }

        $result = [
            'data'                => $department,
            'raw'                 => $raw,
        ];
        echo json_encode($result);

    }

    public function get_department_review_salary(Request $request)
    {
        $search_year      = $request->input('search_year');
        $previousYear = $search_year;
        $search_division      = $request->input('search_division');
        $pagenow      = $request->input('pagenow');
        $orisoft_code = Auth::user()->orisoft_code;

        $orisoft_department_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code == "019492" || $orisoft_code == "000060"  || $orisoft_code == "990002" || $orisoft_code == "000002"){
            if(isset($search_division)){
                if(count($search_division) > 0){
                    // foreach ($search_division as $value) {
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        // ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                        // $sub = substr($value,0,1);
                        // $department = DB::table('tb_department')
                        // ->where('tb_department.department_code','like',''.$sub.'%')->get();
                    // }
                }
            }
            if(!isset($search_division)){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_department.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->groupBy('tb_percent_department_action.department_code')
                ->orderBy('tb_department.department_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    $arr_department_code = [];
                    $checka = strpos($orisoft_department_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_department_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_department_code->department_code);
                    }
                    // dd($arr_department_code);
                    // exit();
                    if(!isset($search_division)){
                        $department = DB::table('tb_department')
                        ->whereIn('tb_department.department_code',$arr_department_code);
                        $department = $department->orderBy('department_code', 'ASC')->get();
                    }
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $department = DB::table('tb_percent_department_action')
                            ->select('tb_department.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.department_code')
                            ->orderBy('tb_department.department_code', 'ASC')->get();
                        }
                    }
                }else{
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            foreach ($search_division as $value) {
                                $department = DB::table('tb_percent_department_action')
                                ->select('tb_percent_department_action.department_code')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->where('tb_percent_department_action.division_code','like','%'.$value.'%')
                                ->where('tb_percent_department_action.approve_by2','000002');
                                $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                            }
                        }
                    }
                    if(!isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.department_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    }
                }
            }else{
                $percent_department_count = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2', $orisoft_code )
                ->count();
                $percent_department_count3 = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by3', $orisoft_code )
                ->count();

                if($percent_department_count > 0 && $percent_department_count3 == 0){
                    if(isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                    }else{
                        // dd($percent_department_count);
                        // exit;
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                        // dd($percent_department_count);
                        // exit;
                    }
                }else if($percent_department_count3 > 0){
                    // dd($percent_department_count3);
                    // exit;
                    if(isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                    }else{
                        // dd($percent_department_count);
                        // exit;
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                        // dd($percent_department_count);
                        // exit;
                    }
                }else{
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            foreach ($search_division as $value) {
                                $department = DB::table('tb_percent_department_action')
                                ->select('tb_percent_department_action.department_code')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->where('tb_percent_department_action.division_code','like','%'.$value.'%')
                                ->where('tb_percent_department_action.approve_by2','000002');
                                $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                            }
                        }
                    }
                    if(!isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.department_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    }
                }
            }
        }else if($orisoft_code == "000026" || $orisoft_code == "013591"){
            if(trans(request()->segment(1)) == 'manager'){
                $arr_department_code = [];
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
                // dd($arr_department_code);
                // exit();
                if(!isset($search_division)){
                    $department = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code);
                    $department = $department->orderBy('department_code', 'ASC')->get();
                    // echo '1';
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                        // echo '2';
                    }
                }
            }else{

                $arr_department_code = [];
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }


                if(isset($arr_department_code)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    if(!empty($search_division)){
                        $department->whereIn('tb_percent_department_action.division_code',$search_division);
                    }
                    // ->whereIn('tb_percent_department_action.division_code',$search_division);
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    // echo '3';
                }elseif(isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.division_code',$search_division);
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    // echo '4';
                }
                // dd($arr_department_code, $orisoft_department_code, $department);
            }

        }else{
            $percent_department_count = DB::table('tb_percent_department_action')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            ->where('tb_percent_department_action.approve_by2', $orisoft_code )
            ->count();
            $percent_department_count3 = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by3', $orisoft_code )
                ->count();
            // dd($percent_department_count);
            // exit;
            if($percent_department_count > 0 && $percent_department_count3 == 0){
                if(isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_department.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.division_code',$search_division)
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->groupBy('tb_percent_department_action.department_code')
                    ->orderBy('tb_department.department_code', 'ASC')->get();
                }else{
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_department.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->groupBy('tb_percent_department_action.department_code')
                    ->orderBy('tb_department.department_code', 'ASC')->get();
                }
            }else if($percent_department_count3 > 0){
                if(isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_department.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.division_code',$search_division)
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                    ->groupBy('tb_percent_department_action.department_code')
                    ->orderBy('tb_department.department_code', 'ASC')->get();
                }else{
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_department.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                    ->groupBy('tb_percent_department_action.department_code')
                    ->orderBy('tb_department.department_code', 'ASC')->get();
                }
            }else{
                $arr_department_code = [];
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
                // dd($arr_department_code);
                // exit();
                if(!isset($search_division)){
                    $department = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code);
                    $department = $department->orderBy('department_code', 'ASC')->get();
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        // dd($orisoft_code);
                        // exit();
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                        // $department = DB::table('tb_percent_department_action');
                        // foreach ($search_division as $value) {
                        //     $sub = substr($value,0,1);

                        //     // $sub = substr($value,0,1);
                        //     // $department = $department->where(function ($query) use($arr_department_code,$sub) {
                        //     //     if($sub == 'G' || $sub == 'P'){
                        //     //         $arr_department_code2 = [];
                        //     //         foreach ($arr_department_code as $value22) {
                        //     //             $sub2 = substr($value22,0,1);
                        //     //             if($sub2 == 'G' || $sub2 == 'P'){
                        //     //                 array_push($arr_department_code2,$value22);
                        //     //             }
                        //     //         }
                        //     //         $query->whereIn('tb_percent_department_action.department_code',$arr_department_code2);
                        //     //     }else{
                        //     //         $query->where('tb_percent_department_action.department_code','like',''.$sub.'%');
                        //     //     }
                        //     //     // $query->orWhere('tb_department.department_code','like',''.$sub.'%');
                        //     // });
                        //     $department = $department->where('tb_department.department_code','like',''.$sub.'%');
                        // }

                        // $department = $department->get();

                    }
                }
            }
        }

        $result = [
            'data'                => $department
        ];
        echo json_encode($result);

    }

    public function get_department_salary_jd(Request $request)
    {
        $previousYear = $request->input('search_year');
        $search_division      = (int)$request->input('search_division');
        $pagenow      = $request->input('pagenow');
        $orisoft_code = Auth::user()->orisoft_code;

        $orisoft_department_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code == "019492" || $orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "990002"){
            if(isset($search_division)){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_department.*')
                ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department_action.division_code',$search_division)
                ->groupBy('tb_percent_department_action.department_code')
                ->orderBy('tb_department.department_code', 'ASC')->get();
            }
            if(!isset($search_division)){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_department.*')
                ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->groupBy('tb_percent_department_action.department_code')
                ->orderBy('tb_department.department_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    $arr_department_code = [];
                    $checka = strpos($orisoft_department_code->department_code,',');
                    if($checka >= 0){
                        $ex = explode(',',$orisoft_department_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_department_code->department_code);
                    }
                    if(!isset($search_division)){
                        $department = DB::table('tb_department')
                        ->whereIn('tb_department.department_code',$arr_department_code);
                        $department = $department->orderBy('department_code', 'ASC')->get();
                    }
                    if(isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                    }
                }else{
                    if(isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.department_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.division_code','like','%'.$search_division.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    }
                    if(!isset($search_division)){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.department_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    }
                }
            }else{
                if(isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.division_code','like','%'.$search_division.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                }
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $arr_department_code = [];
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
                // dd($arr_department_code);
                // exit();
                if(!isset($search_division)){
                    $department = DB::table('tb_department')
                    ->whereIn('tb_department.department_code',$arr_department_code);
                    $department = $department->orderBy('department_code', 'ASC')->get();
                }
                if(isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_department.*')
                    ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                    ->where('tb_percent_department_action.division_code',$search_division)
                    ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                    ->groupBy('tb_percent_department_action.department_code')
                    ->orderBy('tb_department.department_code', 'ASC')->get();
                }
            }else{
                if(isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.division_code','like','%'.$search_division.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                }
            }
        }else{
            $arr_department_code = [];
            $checka = strpos($orisoft_department_code->department_code,',');
            if($checka >= 0){
                $ex = explode(',',$orisoft_department_code->department_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_department_code,$value);
                    }
                }
            }else{
                array_push($arr_department_code,$orisoft_department_code->department_code);
            }
            // $result = [
            //     'arr_department_code'                => $arr_department_code
            // ];
            // echo json_encode($result);
            // exit;
            // dd($arr_department_code);
            // exit();
            if(count($arr_department_code)>0){
                $department = DB::table('tb_department')
                ->whereIn('tb_department.department_code',$arr_department_code);
                $department = $department->orderBy('department_code', 'ASC')->get();
            }
            // if(isset($search_division)){
            //     $department = DB::table('tb_percent_department_action')
            //     ->select('tb_department.*')
            //     ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
            //     ->whereIn('tb_percent_department_action.division_code',$search_division)
            //     ->where('tb_percent_department_action.approve_by1',$orisoft_code)
            //     ->groupBy('tb_percent_department_action.department_code')
            //     ->orderBy('tb_department.department_code', 'ASC')->get();
            // }
        }

        $result = [
            'data'                => $department
        ];
        echo json_encode($result);

    }

    public function get_department_pa_grade(Request $request)
    {
        $previousYear = date('Y');
        $search_division      = $request->input('search_division');
        $orisoft_code = Auth::user()->orisoft_code;

        $orisoft_department_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code == "019492" || $orisoft_code == "000060"  || $orisoft_code == "000002" ){
            if(isset($search_division)){
                if(count($search_division) > 0){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->join('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)

                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                }
            }
            if(!isset($search_division)){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_department.*')
                ->join('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->groupBy('tb_percent_department_action.department_code')
                ->orderBy('tb_department.department_code', 'ASC')->get();
            }
            // $sub = substr($search_division,0,1);
            // dd($sub);
            // exit;
            // $department = DB::table('tb_department')
            // ->where('tb_department.department_code','like',''.$sub.'%')->orderBy('department_code', 'ASC')->get();
        }else if($orisoft_code == "000002"){
            $department = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.department_code','tb_department.department_description')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            ->where('tb_percent_department_action.division_code','like','%'.$search_division.'%')
            ->where('tb_percent_department_action.approve_by2','000002');
            $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.department_code','tb_department.department_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.division_code','like','%'.$search_division.'%')
                ->where('tb_percent_department_action.approve_by1','000026');
                $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
            }else{
                $department = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.department_code','tb_department.department_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.division_code','like','%'.$search_division.'%')
                ->orWhere('tb_percent_department_action.approve_by1','000026')
                ->orWhere('tb_percent_department_action.approve_by2','000026');
                $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
            }

        }else if($orisoft_code == "990002"){
            if(isset($search_division)){
                if(count($search_division) > 0){
                        $department = DB::table('tb_percent_department_action')
                        ->select('tb_department.*')
                        ->join('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)

                        ->groupBy('tb_percent_department_action.department_code')
                        ->orderBy('tb_department.department_code', 'ASC')->get();
                }
            }
            if(!isset($search_division)){
                $department = DB::table('tb_percent_department_action')
                ->select('tb_department.*')
                ->join('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->join('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->groupBy('tb_percent_department_action.department_code')
                ->orderBy('tb_department.department_code', 'ASC')->get();
            }
            // $sub = substr($search_division,0,1);
            // $department = DB::table('tb_department')
            // ->where('tb_department.department_code','like',''.$sub.'%')->orderBy('department_code', 'ASC')->get();
        }else{
            $arr_department_code = [];
            if(!isset($search_division)){
                $checka = strpos($orisoft_department_code->department_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_department_code->department_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_department_code,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code,$orisoft_department_code->department_code);
                }
                $department = DB::table('tb_department')
                ->whereIn('tb_department.department_code',$arr_department_code);
                $department = $department->orderBy('department_code', 'ASC')->get();
            }
            if(isset($search_division)){
                if(count($search_division) > 0){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_department.*')
                    ->leftJoin('tb_department','tb_department.department_code','=','tb_percent_department_action.department_code')
                    ->whereIn('tb_percent_department_action.division_code',$search_division)
                    ->groupBy('tb_percent_department_action.department_code')
                    ->orderBy('tb_department.department_code', 'ASC')->get();
                }
            }
        }

        $result = [
            'data' => $department
        ];
        echo json_encode($result);

    }

    public function get_section(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $orisoft_code = Auth::user()->orisoft_code;

        $search_year       = $request->input('search_year');
        $previousYear = $search_year;

        $arr_section_code = [];
        if($orisoft_code == "000002" || $orisoft_code == "990002" || $orisoft_code == "000026"){

        }else{
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('employee_no',$orisoft_code)
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')->first();
            if(!empty($orisoft_section_code)){
                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
            }
        }
        // dd($orisoft_section_code);
        $i = 1;
        // exit();
        if(!is_array($search_division)){
            $search_division = [];
        }
        if(!is_array($search_department)){
            $search_department = [];
        }

        if((in_array("0", $search_division) || in_array("all", $search_division)) && (in_array("0", $search_department) || in_array("all", $search_department))){
            if($orisoft_code == "000060"  || $orisoft_code == "000002" || $orisoft_code == "019492"){
                $section = DB::table('tb_section');
                $section = $section->orderBy('section_code', 'ASC')->get();
                // echo '1';
            }else{
                $section = DB::table('tb_section')
                ->whereIn('tb_section.section_code',$arr_section_code);
                $section = $section->orderBy('section_code', 'ASC')->get();
                // echo '2';
            }
        }else{
            // dd($arr_section_code);
            // exit();
            if($orisoft_code == '000023'){
                $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('employee_no',$orisoft_code)
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                    // echo '3';
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                    // echo '4';
                }

            }else if($orisoft_code == '000047'){
                $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
                // echo '5';
            }else{
                if(!in_array("0", $search_division) || !in_array("all", $search_division)){

                    if($orisoft_code == "000026"){
                        $search_division = $request->input('search_division');

                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.section_code','tb_section.section_description')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division);
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }else{

                        // echo '6';
                        // dd($arr_section_code);
                        $likeConditions = [];
                        $arr_section_code_gp = [];

                        foreach ($arr_section_code as $value) {
                            $sub = substr($value, 0, 1);
                            array_push($arr_section_code_gp, $value);
                        }

                        if(!empty($search_department)){
                            foreach ($search_department as $_department) {
                                if (is_string($_department)) {
                                    $sub_department = substr($_department, 0, 2);
                                    $likeConditions_department[] = $sub_department . '%';
                                }
                            }
                            $likeConditions_department = array_unique($likeConditions_department);
                        }

                        if(!empty($search_division)){
                            foreach ($search_division as $_division) {
                                if (is_string($_division)) {
                                    $sub = substr($_division, 0, 1);
                                    $likeConditions[] = $sub . '%';
                                }
                            }
                            $likeConditions = array_unique($likeConditions);
                        }

                        $sectionQuery = DB::table('tb_section');

                        if (($orisoft_code == "000060" || $orisoft_code == "000002" || $orisoft_code == "019492")) {
                            // echo '6';
                            $sectionQuery->where(function ($query) use ($likeConditions) {
                                foreach ($likeConditions as $like) {
                                    $sub = substr($like, 0, 1);
                                    if ($sub == 'G' || $sub == 'P') {
                                        $query->orWhere('tb_section.section_code', 'LIKE', $like);
                                    }
                                }
                            });

                        } else {
                            // echo '7 และ 8';
                            if(empty($search_department) || $search_department == 'All'){
                                if($orisoft_code != "000012"){
                                    $sectionQuery->whereIn('tb_section.section_code', $arr_section_code_gp);
                                }else{
                                    $_search_department = substr($request->input('search_department'), 0, 2);
                                    $sectionQuery->where('tb_section.section_code', 'like', $_search_department . '%');
                                }
                                if (!empty($likeConditions)) {
                                    $sectionQuery->where(function ($query) use ($likeConditions) {
                                        foreach ($likeConditions as $likeValue) {
                                            // echo $likeValue.',';
                                            $query->orWhere('tb_section.section_code', 'LIKE', $likeValue);
                                        }
                                    });
                                }
                            }else{
                                $sectionQuery->whereIn('tb_section.section_code', $arr_section_code_gp);
                                // dd($likeConditions_department, $arr_section_code_gp);
                                if (!empty($likeConditions_department)) {
                                    $sectionQuery->where(function ($query) use ($likeConditions_department) {
                                        foreach ($likeConditions_department as $_likeConditions_department) {
                                            // echo $likeValue.',';
                                            $query->orWhere('tb_section.section_code', 'LIKE', $_likeConditions_department);
                                        }
                                    });
                                }
                            }
                        }
                        $section = $sectionQuery->get();
                    }
                }else{
                    if($orisoft_code == "000002" || $orisoft_code == "990002"){
                        $sub = substr($search_department,0,2);
                        $section = DB::table('tb_section')
                        ->where('tb_section.section_code','like',''.$sub.'%')->get();
                        // echo '9';
                    }else{
                        if(empty($arr_section_code)){
                            $search_division = $request->input('search_division');

                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.section_code','tb_section.section_description')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division);
                            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                            // dd($section);

                        }else{

                            if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){
                                $sub = substr($search_department,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$sub.'%')->get();
                                // echo '11';
                            }else{

                                if(count($arr_section_code) == 1){
                                    $section = DB::table('tb_section')
                                    ->whereIn('tb_section.section_code',$arr_section_code)->get();
                                    // echo '12';
                                }else{

                                    if($orisoft_code == "000002" || $orisoft_code == "000026"){
                                        if((!in_array("0", $search_division) && !in_array("all", $search_division)) && (!in_array("0", $search_department) || !in_array("all", $search_department))){
                                            foreach ($search_department as $key => $_department) {
                                                $sub = substr($_department,0,2);
                                                if(trans(request()->segment(1)) == 'manager'){
                                                    $section = DB::table('tb_section')
                                                    ->whereIn('tb_section.section_code',$arr_section_code)->get();
                                                    // echo '13';
                                                }else{
                                                    $section = DB::table('tb_section')
                                                    ->where('tb_section.section_code','like',''.$sub.'%')
                                                    ->whereIn('tb_section.section_code',$arr_section_code)->get();
                                                    // echo '14';
                                                }
                                            }
                                        }else{
                                            $section = DB::table('tb_section')
                                            ->whereIn('tb_section.section_code',$arr_section_code)->get();
                                            // echo '15';
                                        }

                                        // dd($section);
                                        // exit();
                                    }else{
                                        foreach ($search_department as $key => $_department) {
                                            $sub = substr($search_department,0,2);
                                            $section = DB::table('tb_section')
                                            ->where('tb_section.section_code','like',''.$sub.'%')->get();
                                            // echo '16';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // exit();

                    // exit();

                }
            }
        }

        // $sql = $sectionQuery->toSql();
        // $bindings = $sectionQuery->getBindings();

        // dd($arr_section_code, $section, $arr_section_code_gp, $sql, $bindings);

        $result = [
            'data'                => $section
        ];
        echo json_encode($result);

    }

    public function get_section_salary(Request $request)
    {

        $search_division      = $request->input('search_division');
        $search_year      = $request->input('search_year');
        $pagenow      = $request->input('pagenow');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            $checka = strpos($orisoft_section_code->section_code,',');
            $arr_section_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_section_code->section_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_section_code,$value);
                    }
                }
            }else{
                array_push($arr_section_code,$orisoft_section_code->section_code);
            }
        }

        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else if($orisoft_code == '019492' || $orisoft_code == '000060' || $orisoft_code == "990002"){
            if(isset($search_department)){
                if(count($search_department) > 0){
                    $section = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.department_code',$search_department);
                    $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
                }
            }
            if(!isset($search_department)){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
            // $sub = substr($search_department,0,2);
            // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    if(!isset($search_department)){
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->whereIn('tb_percent_department_action.division_code',$search_division)
                                ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                                ->groupBy('tb_percent_department_action.section_code')
                                ->orderBy('tb_section.section_code', 'ASC')->get();
                                // $sub = substr($search_division,0,1);
                                // if($sub == 'G' || $sub == 'P'){
                                //     $arr_section_code2 = [];
                                //     foreach ($arr_section_code as $value) {
                                //         $sub2 = substr($value,0,1);
                                //         if($sub2 == 'G' || $sub2 == 'P'){
                                //             array_push($arr_section_code2,$value);
                                //         }
                                //     }
                                //     $section = DB::table('tb_section')
                                //     ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                                // }else{
                                //     $section = DB::table('tb_section')
                                //     ->where('tb_section.section_code','like',''.$sub.'%')->get();
                                // }
                            }
                        }
                        if(!isset($search_division)){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                        }
                    }else{

                        if($arr_section_code[0] == ""){
                            $checkax = strpos($orisoft_section_code->department_code,',');
                            $arr_department_code = [];
                            if($checkax >= 0){
                                $ex = explode(',',$orisoft_section_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_section_code->department_code);
                            }
                            if(count($arr_department_code)>0){
                                foreach ($arr_department_code as $valuexx) {
                                    $subxx = substr($valuexx,0,2);
                                    $section = DB::table('tb_section')
                                    ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                                }
                            }
                        }else{
                            if(count($arr_section_code) == 1){
                                $section = DB::table('tb_section')
                                ->whereIn('tb_section.section_code',$arr_section_code)->get();
                            }else{
                                $sub = substr($search_department,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            }
                        }
                    }
                }else{
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.department_code',$search_department)
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        }
                    }
                    if(!isset($search_department)){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
            }else{
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.department_code',$search_department)
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
                if(!isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_department)){
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                            // echo '1';
                        }
                    }
                    if(!isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                        // echo '2';
                    }
                }else{

                    if($arr_section_code[0] == ""){
                        $checkax = strpos($orisoft_section_code->department_code,',');
                        $arr_department_code = [];
                        if($checkax >= 0){
                            $ex = explode(',',$orisoft_section_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_section_code->department_code);
                        }
                        if(count($arr_department_code)>0){
                            foreach ($arr_department_code as $valuexx) {
                                $subxx = substr($valuexx,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                            }
                        }
                    }else{
                        if(count($arr_section_code) == 1){
                            $section = DB::table('tb_section')
                            ->whereIn('tb_section.section_code',$arr_section_code)->get();
                            // echo '3';
                        }else{
                            $sub = substr($search_department,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            // echo '4';
                        }
                    }
                }
            }else{
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                            if(!empty($search_division)){
                            $section->whereIn('tb_percent_department_action.division_code',$search_division);
                            }
                            if(!empty($search_department)){
                                $section->whereIn('tb_percent_department_action.department_code',$search_department);
                            }
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        // echo '5';
                    }
                }
                if(!isset($search_department)){

                    $orisoft_section_code = DB::table('tb_employee_evaluator')
                        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                        ->where('employee_no',$orisoft_code)->first();
                    $checkax = strpos($orisoft_section_code->department_code,',');
                    $arr_department_code = [];
                    if($checkax >= 0){
                        $ex = explode(',',$orisoft_section_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_section_code->department_code);
                    }

                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                            if(!empty($search_division)){
                                $section->whereIn('tb_percent_department_action.division_code',$search_division);
                            }
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    // echo '6';
                }
            }

            // dd($section, @$search_department, @$arr_department_code);

        }else{
            if(!isset($search_department)){
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                }
                if(!isset($search_division)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }
            }else{

                if($arr_section_code[0] == ""){
                    $checkax = strpos($orisoft_section_code->department_code,',');
                    $arr_department_code = [];
                    if($checkax >= 0){
                        $ex = explode(',',$orisoft_section_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_section_code->department_code);
                    }
                    if(count($arr_department_code)>0){
                        foreach ($arr_department_code as $valuexx) {
                            $subxx = substr($valuexx,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                        }
                    }
                }else{
                    if(count($arr_section_code) == 1){
                        $section = DB::table('tb_section')
                        ->whereIn('tb_section.section_code',$arr_section_code)->get();
                    }else{
                        if(isset($search_department)){
                            if(count($search_department) > 0){
                                $section = DB::table('tb_percent_department_action')
                                    ->select('tb_section.*')
                                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                    ->whereIn('tb_percent_department_action.department_code',$search_department);
                                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                            }
                        }
                        // $sub = substr($search_department,0,2);
                        // $section = DB::table('tb_section')
                        // ->where('tb_section.section_code','like',''.$sub.'%')->get();
                    }
                }
            }
        }

        // $sub = substr($search_department,0,2);
        // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();

        // $orisoft_code = Auth::user()->orisoft_code;

        // $orisoft_section_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code)->first();

        // $checka = strpos($orisoft_section_code->section_code,',');
        // $arr_section_code = [];
        // if($checka >= 0){
        //     $ex = explode(',',$orisoft_section_code->section_code);
        //     if(count($ex)>0){
        //         foreach ($ex as $value) {
        //             array_push($arr_section_code,$value);
        //         }
        //     }
        // }else{
        //     array_push($arr_section_code,$orisoft_section_code->section_code);
        // }
        // // dd($arr_section_code);
        // // exit();
        // if(($search_division == "0" || $search_division == "all") && ($search_department == "0" || $search_department == "all")){
        //     $section = DB::table('tb_section')
        //     ->whereIn('tb_section.section_code',$arr_section_code);
        //     $section = $section->orderBy('section_code', 'ASC')->get();
        // }else{
        //     // dd($arr_section_code);
        //     // exit();
        //     if($orisoft_code == '000023'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
        //     }else if($orisoft_code == '000047'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        //     }else{
        //         if($search_department == '0' || $search_department == 'all'){
        //             $sub = substr($search_division,0,1);
        //             if($sub == 'G' || $sub == 'P'){
        //                 $arr_section_code2 = [];
        //                 foreach ($arr_section_code as $value) {
        //                     $sub2 = substr($value,0,1);
        //                     if($sub2 == 'G' || $sub2 == 'P'){
        //                         array_push($arr_section_code2,$value);
        //                     }
        //                 }
        //                 $section = DB::table('tb_section')
        //                 ->whereIn('tb_section.section_code',$arr_section_code2)->get();
        //             }else{
        //                 $section = DB::table('tb_section')
        //                 ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //             }
        //         }else{
        //             if($arr_section_code[0] == ""){

        //                 $checkax = strpos($orisoft_section_code->department_code,',');
        //                 $arr_department_code = [];
        //                 if($checkax >= 0){
        //                     $ex = explode(',',$orisoft_section_code->department_code);
        //                     if(count($ex)>0){
        //                         foreach ($ex as $value) {
        //                             array_push($arr_department_code,$value);
        //                         }
        //                     }
        //                 }else{
        //                     array_push($arr_department_code,$orisoft_section_code->department_code);
        //                 }
        //                 if(count($arr_department_code)>0){
        //                     foreach ($arr_department_code as $valuexx) {
        //                         $subxx = substr($valuexx,0,2);
        //                         $section = DB::table('tb_section')
        //                         ->where('tb_section.section_code','like',''.$subxx.'%')->get();
        //                     }
        //                 }
        //                 // dd($arr_department_code);
        //             }else{
        //                 if(count($arr_section_code) == 1){
        //                     $section = DB::table('tb_section')
        //                     ->whereIn('tb_section.section_code',$arr_section_code)->get();
        //                 }else{
        //                     $sub = substr($search_department,0,2);
        //                     $section = DB::table('tb_section')
        //                     ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //                 }
        //             }
        //             // exit();

        //             // dd($arr_section_code);
        //             // exit();

        //         }
        //     }
        // }

        $result = [
            'data'                => $section
        ];
        echo json_encode($result);

    }

    public function get_section_salary_approve(Request $request)
    {

        $search_division      = $request->input('search_division');
        $search_year      = $request->input('search_year');
        $pagenow      = $request->input('pagenow');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
            ->where('employee_no',$orisoft_code)->first();

            $checka = strpos($orisoft_section_code->section_code,',');
            $arr_section_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_section_code->section_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_section_code,$value);
                    }
                }
            }else{
                array_push($arr_section_code,$orisoft_section_code->section_code);
            }
        }

        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else if($orisoft_code == '019492' || $orisoft_code == '000060' || $orisoft_code == "990002"){
            if(isset($search_department)){
                if(count($search_department) > 0){
                    $section = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.department_code',$search_department);
                    $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
                }
            }
            if(!isset($search_department)){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
            // $sub = substr($search_department,0,2);
            // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    if(!isset($search_department)){
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->whereIn('tb_percent_department_action.division_code',$search_division)
                                ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                                ->groupBy('tb_percent_department_action.section_code')
                                ->orderBy('tb_section.section_code', 'ASC')->get();
                                // $sub = substr($search_division,0,1);
                                // if($sub == 'G' || $sub == 'P'){
                                //     $arr_section_code2 = [];
                                //     foreach ($arr_section_code as $value) {
                                //         $sub2 = substr($value,0,1);
                                //         if($sub2 == 'G' || $sub2 == 'P'){
                                //             array_push($arr_section_code2,$value);
                                //         }
                                //     }
                                //     $section = DB::table('tb_section')
                                //     ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                                // }else{
                                //     $section = DB::table('tb_section')
                                //     ->where('tb_section.section_code','like',''.$sub.'%')->get();
                                // }
                            }
                        }
                        if(!isset($search_division)){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                        }
                    }else{

                        if($arr_section_code[0] == ""){
                            $checkax = strpos($orisoft_section_code->department_code,',');
                            $arr_department_code = [];
                            if($checkax >= 0){
                                $ex = explode(',',$orisoft_section_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_section_code->department_code);
                            }
                            if(count($arr_department_code)>0){
                                foreach ($arr_department_code as $valuexx) {
                                    $subxx = substr($valuexx,0,2);
                                    $section = DB::table('tb_section')
                                    ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                                }
                            }
                        }else{
                            if(count($arr_section_code) == 1){
                                $section = DB::table('tb_section')
                                ->whereIn('tb_section.section_code',$arr_section_code)->get();
                            }else{
                                $sub = substr($search_department,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            }
                        }
                    }
                }else{
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.department_code',$search_department)
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        }
                    }
                    if(!isset($search_department)){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
            }else{
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.department_code',$search_department)
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
                if(!isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_department)){
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                            // $sub = substr($search_division,0,1);
                            // if($sub == 'G' || $sub == 'P'){
                            //     $arr_section_code2 = [];
                            //     foreach ($arr_section_code as $value) {
                            //         $sub2 = substr($value,0,1);
                            //         if($sub2 == 'G' || $sub2 == 'P'){
                            //             array_push($arr_section_code2,$value);
                            //         }
                            //     }
                            //     $section = DB::table('tb_section')
                            //     ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                            // }else{
                            //     $section = DB::table('tb_section')
                            //     ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            // }
                        }
                    }
                    if(!isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                }else{

                    if($arr_section_code[0] == ""){
                        $checkax = strpos($orisoft_section_code->department_code,',');
                        $arr_department_code = [];
                        if($checkax >= 0){
                            $ex = explode(',',$orisoft_section_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_section_code->department_code);
                        }
                        if(count($arr_department_code)>0){
                            foreach ($arr_department_code as $valuexx) {
                                $subxx = substr($valuexx,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                            }
                        }
                    }else{
                        if(count($arr_section_code) == 1){
                            $section = DB::table('tb_section')
                            ->whereIn('tb_section.section_code',$arr_section_code)->get();
                        }else{
                            $sub = substr($search_department,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$sub.'%')->get();
                        }
                    }
                }
            }else{
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.department_code',$search_department)
                        ->where('tb_percent_department_action.approve_by2','000026');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
                if(!isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
            }

        }else{
            if(!isset($search_department)){
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                        // $sub = substr($search_division,0,1);
                        // if($sub == 'G' || $sub == 'P'){
                        //     $arr_section_code2 = [];
                        //     foreach ($arr_section_code as $value) {
                        //         $sub2 = substr($value,0,1);
                        //         if($sub2 == 'G' || $sub2 == 'P'){
                        //             array_push($arr_section_code2,$value);
                        //         }
                        //     }
                        //     $section = DB::table('tb_section')
                        //     ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                        // }else{
                        //     $section = DB::table('tb_section')
                        //     ->where('tb_section.section_code','like',''.$sub.'%')->get();
                        // }
                    }
                }
                if(!isset($search_division)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }
            }else{

                if($arr_section_code[0] == ""){
                    $checkax = strpos($orisoft_section_code->department_code,',');
                    $arr_department_code = [];
                    if($checkax >= 0){
                        $ex = explode(',',$orisoft_section_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_section_code->department_code);
                    }
                    if(count($arr_department_code)>0){
                        foreach ($arr_department_code as $valuexx) {
                            $subxx = substr($valuexx,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                        }
                    }
                }else{
                    if(count($arr_section_code) == 1){
                        $section = DB::table('tb_section')
                        ->whereIn('tb_section.section_code',$arr_section_code)->get();
                    }else{
                        if(isset($search_department)){
                            if(count($search_department) > 0){
                                $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->whereIn('tb_percent_department_action.department_code',$search_department);
                                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                            }
                        }
                        // $sub = substr($search_department,0,2);
                        // $section = DB::table('tb_section')
                        // ->where('tb_section.section_code','like',''.$sub.'%')->get();
                    }
                }
            }
        }

        // $sub = substr($search_department,0,2);
        // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();

        // $orisoft_code = Auth::user()->orisoft_code;

        // $orisoft_section_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code)->first();

        // $checka = strpos($orisoft_section_code->section_code,',');
        // $arr_section_code = [];
        // if($checka >= 0){
        //     $ex = explode(',',$orisoft_section_code->section_code);
        //     if(count($ex)>0){
        //         foreach ($ex as $value) {
        //             array_push($arr_section_code,$value);
        //         }
        //     }
        // }else{
        //     array_push($arr_section_code,$orisoft_section_code->section_code);
        // }
        // // dd($arr_section_code);
        // // exit();
        // if(($search_division == "0" || $search_division == "all") && ($search_department == "0" || $search_department == "all")){
        //     $section = DB::table('tb_section')
        //     ->whereIn('tb_section.section_code',$arr_section_code);
        //     $section = $section->orderBy('section_code', 'ASC')->get();
        // }else{
        //     // dd($arr_section_code);
        //     // exit();
        //     if($orisoft_code == '000023'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
        //     }else if($orisoft_code == '000047'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        //     }else{
        //         if($search_department == '0' || $search_department == 'all'){
        //             $sub = substr($search_division,0,1);
        //             if($sub == 'G' || $sub == 'P'){
        //                 $arr_section_code2 = [];
        //                 foreach ($arr_section_code as $value) {
        //                     $sub2 = substr($value,0,1);
        //                     if($sub2 == 'G' || $sub2 == 'P'){
        //                         array_push($arr_section_code2,$value);
        //                     }
        //                 }
        //                 $section = DB::table('tb_section')
        //                 ->whereIn('tb_section.section_code',$arr_section_code2)->get();
        //             }else{
        //                 $section = DB::table('tb_section')
        //                 ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //             }
        //         }else{
        //             if($arr_section_code[0] == ""){

        //                 $checkax = strpos($orisoft_section_code->department_code,',');
        //                 $arr_department_code = [];
        //                 if($checkax >= 0){
        //                     $ex = explode(',',$orisoft_section_code->department_code);
        //                     if(count($ex)>0){
        //                         foreach ($ex as $value) {
        //                             array_push($arr_department_code,$value);
        //                         }
        //                     }
        //                 }else{
        //                     array_push($arr_department_code,$orisoft_section_code->department_code);
        //                 }
        //                 if(count($arr_department_code)>0){
        //                     foreach ($arr_department_code as $valuexx) {
        //                         $subxx = substr($valuexx,0,2);
        //                         $section = DB::table('tb_section')
        //                         ->where('tb_section.section_code','like',''.$subxx.'%')->get();
        //                     }
        //                 }
        //                 // dd($arr_department_code);
        //             }else{
        //                 if(count($arr_section_code) == 1){
        //                     $section = DB::table('tb_section')
        //                     ->whereIn('tb_section.section_code',$arr_section_code)->get();
        //                 }else{
        //                     $sub = substr($search_department,0,2);
        //                     $section = DB::table('tb_section')
        //                     ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //                 }
        //             }
        //             // exit();

        //             // dd($arr_section_code);
        //             // exit();

        //         }
        //     }
        // }

        $result = [
            'data'                => $section
        ];
        echo json_encode($result);

    }

    public function get_section_review_salary(Request $request)
    {

        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_year      = $request->input('search_year');
        $pagenow      = $request->input('pagenow');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('employee_no',$orisoft_code)->first();

            $checka = strpos($orisoft_section_code->section_code,',');
            $arr_section_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_section_code->section_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_section_code,$value);
                    }
                }
            }else{
                array_push($arr_section_code,$orisoft_section_code->section_code);
            }
        }

        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else if($orisoft_code == '019492' || $orisoft_code == '000060' || $orisoft_code == "990002"){
            if(isset($search_department)){
                if(count($search_department) > 0){
                    $section = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.department_code',$search_department);
                    $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
                }
            }
            if(!isset($search_department)){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
            // $sub = substr($search_department,0,2);
            // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    if(!isset($search_department)){
                        if(isset($search_division)){
                            if(count($search_division) > 0){
                                $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                ->whereIn('tb_percent_department_action.division_code',$search_division)
                                ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                                ->groupBy('tb_percent_department_action.section_code')
                                ->orderBy('tb_section.section_code', 'ASC')->get();
                                // $sub = substr($search_division,0,1);
                                // if($sub == 'G' || $sub == 'P'){
                                //     $arr_section_code2 = [];
                                //     foreach ($arr_section_code as $value) {
                                //         $sub2 = substr($value,0,1);
                                //         if($sub2 == 'G' || $sub2 == 'P'){
                                //             array_push($arr_section_code2,$value);
                                //         }
                                //     }
                                //     $section = DB::table('tb_section')
                                //     ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                                // }else{
                                //     $section = DB::table('tb_section')
                                //     ->where('tb_section.section_code','like',''.$sub.'%')->get();
                                // }
                            }
                        }
                        if(!isset($search_division)){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                        }
                    }else{

                        if($arr_section_code[0] == ""){
                            $checkax = strpos($orisoft_section_code->department_code,',');
                            $arr_department_code = [];
                            if($checkax >= 0){
                                $ex = explode(',',$orisoft_section_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_section_code->department_code);
                            }
                            if(count($arr_department_code)>0){
                                foreach ($arr_department_code as $valuexx) {
                                    $subxx = substr($valuexx,0,2);
                                    $section = DB::table('tb_section')
                                    ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                                }
                            }
                        }else{
                            if(count($arr_section_code) == 1){
                                $section = DB::table('tb_section')
                                ->whereIn('tb_section.section_code',$arr_section_code)->get();
                            }else{
                                $sub = substr($search_department,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            }
                        }
                    }
                }else{
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.department_code',$search_department)
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        }
                    }
                    if(!isset($search_department)){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
            }else{
                $percent_department_count = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2', $orisoft_code )
                ->count();
                $percent_department_count3 = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by3', $orisoft_code )
                ->count();
                if($percent_department_count > 0 && $percent_department_count3 == 0){
                    if(isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }else{
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                }else if($percent_department_count3 > 0){
                    if(isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->whereIn('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }else{
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                        ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                }else{
                    if(isset($search_department)){
                        if(count($search_department) > 0){
                            $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.department_code',$search_department)
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        }
                    }
                    if(!isset($search_department)){
                        $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_department)){
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                            // echo '1';
                        }
                    }
                    if(!isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                        // echo '2';
                    }
                }else{

                    if($arr_section_code[0] == ""){
                        $checkax = strpos($orisoft_section_code->department_code,',');
                        $arr_department_code = [];
                        if($checkax >= 0){
                            $ex = explode(',',$orisoft_section_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_section_code->department_code);
                        }
                        if(count($arr_department_code)>0){
                            foreach ($arr_department_code as $valuexx) {
                                $subxx = substr($valuexx,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                            }
                        }
                    }else{
                        if(count($arr_section_code) == 1){
                            $section = DB::table('tb_section')
                            ->whereIn('tb_section.section_code',$arr_section_code)->get();
                            // echo '3';
                        }else{
                            $sub = substr($search_department,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            // echo '4';
                        }
                    }
                }
            }else{
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->whereIn('tb_percent_department_action.department_code',$search_department);
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        // echo '5';
                    }
                }
                if(!isset($search_department)){

                    $orisoft_section_code = DB::table('tb_employee_evaluator')
                        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                        ->where('employee_no',$orisoft_code)->first();
                    $checkax = strpos($orisoft_section_code->department_code,',');
                    $arr_department_code = [];
                    if($checkax >= 0){
                        $ex = explode(',',$orisoft_section_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_section_code->department_code);
                    }

                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    if(!empty($search_department)){
                            $section->whereIn('tb_percent_department_action.department_code',$search_department);
                    }elseif(!empty($search_division)){
                            $section->whereIn('tb_percent_department_action.division_code',$search_division);
                    }
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    // echo '6';
                    // dd($section, $search_department, $search_division);
                }
            }

        }else{
            $percent_department_count = DB::table('tb_percent_department_action')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            ->where('tb_percent_department_action.approve_by2', $orisoft_code )
            ->count();
            $percent_department_count3 = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by3', $orisoft_code )
                ->count();
            if($percent_department_count > 0 && $percent_department_count3 == 0){
                if(isset($search_division)){
                    $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.division_code',$search_division)
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }
            }else if($percent_department_count3 > 0){
                if(isset($search_division)){
                    $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->whereIn('tb_percent_department_action.division_code',$search_division)
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2',$orisoft_code)
                    ->orWhere('tb_percent_department_action.approve_by3',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }
            }else{
                if(!isset($search_department)){
                    if(isset($search_division)){
                        if(count($search_division) > 0){
                            $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->whereIn('tb_percent_department_action.division_code',$search_division)
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                            // $sub = substr($search_division,0,1);
                            // if($sub == 'G' || $sub == 'P'){
                            //     $arr_section_code2 = [];
                            //     foreach ($arr_section_code as $value) {
                            //         $sub2 = substr($value,0,1);
                            //         if($sub2 == 'G' || $sub2 == 'P'){
                            //             array_push($arr_section_code2,$value);
                            //         }
                            //     }
                            //     $section = DB::table('tb_section')
                            //     ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                            // }else{
                            //     $section = DB::table('tb_section')
                            //     ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            // }
                        }
                    }
                    if(!isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                }else{

                    if($arr_section_code[0] == ""){
                        $checkax = strpos($orisoft_section_code->department_code,',');
                        $arr_department_code = [];
                        if($checkax >= 0){
                            $ex = explode(',',$orisoft_section_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_section_code->department_code);
                        }
                        if(count($arr_department_code)>0){
                            foreach ($arr_department_code as $valuexx) {
                                $subxx = substr($valuexx,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                            }
                        }
                    }else{
                        if(count($arr_section_code) == 1){
                            $section = DB::table('tb_section')
                            ->whereIn('tb_section.section_code',$arr_section_code)->get();
                        }else{
                            if(isset($search_department)){
                                if(count($search_department) > 0){
                                    $section = DB::table('tb_percent_department_action')
                                ->select('tb_section.*')
                                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                                    ->whereIn('tb_percent_department_action.department_code',$search_department);
                                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                                }
                            }
                            // $sub = substr($search_department,0,2);
                            // $section = DB::table('tb_section')
                            // ->where('tb_section.section_code','like',''.$sub.'%')->get();
                        }
                    }
                }
            }
        }

        // $sub = substr($search_department,0,2);
        // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();

        // $orisoft_code = Auth::user()->orisoft_code;

        // $orisoft_section_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code)->first();

        // $checka = strpos($orisoft_section_code->section_code,',');
        // $arr_section_code = [];
        // if($checka >= 0){
        //     $ex = explode(',',$orisoft_section_code->section_code);
        //     if(count($ex)>0){
        //         foreach ($ex as $value) {
        //             array_push($arr_section_code,$value);
        //         }
        //     }
        // }else{
        //     array_push($arr_section_code,$orisoft_section_code->section_code);
        // }
        // // dd($arr_section_code);
        // // exit();
        // if(($search_division == "0" || $search_division == "all") && ($search_department == "0" || $search_department == "all")){
        //     $section = DB::table('tb_section')
        //     ->whereIn('tb_section.section_code',$arr_section_code);
        //     $section = $section->orderBy('section_code', 'ASC')->get();
        // }else{
        //     // dd($arr_section_code);
        //     // exit();
        //     if($orisoft_code == '000023'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
        //     }else if($orisoft_code == '000047'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        //     }else{
        //         if($search_department == '0' || $search_department == 'all'){
        //             $sub = substr($search_division,0,1);
        //             if($sub == 'G' || $sub == 'P'){
        //                 $arr_section_code2 = [];
        //                 foreach ($arr_section_code as $value) {
        //                     $sub2 = substr($value,0,1);
        //                     if($sub2 == 'G' || $sub2 == 'P'){
        //                         array_push($arr_section_code2,$value);
        //                     }
        //                 }
        //                 $section = DB::table('tb_section')
        //                 ->whereIn('tb_section.section_code',$arr_section_code2)->get();
        //             }else{
        //                 $section = DB::table('tb_section')
        //                 ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //             }
        //         }else{
        //             if($arr_section_code[0] == ""){

        //                 $checkax = strpos($orisoft_section_code->department_code,',');
        //                 $arr_department_code = [];
        //                 if($checkax >= 0){
        //                     $ex = explode(',',$orisoft_section_code->department_code);
        //                     if(count($ex)>0){
        //                         foreach ($ex as $value) {
        //                             array_push($arr_department_code,$value);
        //                         }
        //                     }
        //                 }else{
        //                     array_push($arr_department_code,$orisoft_section_code->department_code);
        //                 }
        //                 if(count($arr_department_code)>0){
        //                     foreach ($arr_department_code as $valuexx) {
        //                         $subxx = substr($valuexx,0,2);
        //                         $section = DB::table('tb_section')
        //                         ->where('tb_section.section_code','like',''.$subxx.'%')->get();
        //                     }
        //                 }
        //                 // dd($arr_department_code);
        //             }else{
        //                 if(count($arr_section_code) == 1){
        //                     $section = DB::table('tb_section')
        //                     ->whereIn('tb_section.section_code',$arr_section_code)->get();
        //                 }else{
        //                     $sub = substr($search_department,0,2);
        //                     $section = DB::table('tb_section')
        //                     ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //                 }
        //             }
        //             // exit();

        //             // dd($arr_section_code);
        //             // exit();

        //         }
        //     }
        // }

        $result = [
            'data'                => $section
        ];
        echo json_encode($result);

    }

    public function get_section_salary_jd(Request $request)
    {
        $previousYear = date('Y');
        // $previousYear = 2024;
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $pagenow      = $request->input('pagenow');

        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('employee_no',$orisoft_code)->first();

            $checka = strpos($orisoft_section_code->section_code,',');
            $arr_section_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_section_code->section_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_section_code,$value);
                    }
                }
            }else{
                array_push($arr_section_code,$orisoft_section_code->section_code);
            }
        }

        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else if($orisoft_code == '019492' || $orisoft_code == '000060' || $orisoft_code == "990002"){
            if(isset($search_department)){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.department_code',$search_department);
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
            if(!isset($search_department)){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager'){
                if($pagenow == '1'){
                    if(!isset($search_department)){
                        if(isset($search_division)){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.division_code',$search_division)
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                        }
                        if(!isset($search_division)){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                            ->groupBy('tb_percent_department_action.section_code')
                            ->orderBy('tb_section.section_code', 'ASC')->get();
                        }
                    }else{

                        if($arr_section_code[0] == ""){
                            $checkax = strpos($orisoft_section_code->department_code,',');
                            $arr_department_code = [];
                            if($checkax >= 0){
                                $ex = explode(',',$orisoft_section_code->department_code);
                                if(count($ex)>0){
                                    foreach ($ex as $value) {
                                        array_push($arr_department_code,$value);
                                    }
                                }
                            }else{
                                array_push($arr_department_code,$orisoft_section_code->department_code);
                            }
                            if(count($arr_department_code)>0){
                                foreach ($arr_department_code as $valuexx) {
                                    $subxx = substr($valuexx,0,2);
                                    $section = DB::table('tb_section')
                                    ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                                }
                            }
                        }else{
                            if(count($arr_section_code) == 1){
                                $section = DB::table('tb_section')
                                ->whereIn('tb_section.section_code',$arr_section_code)->get();
                            }else{
                                $sub = substr($search_department,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$sub.'%')->get();
                            }
                        }
                    }
                }else{
                    if(isset($search_department)){
                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.department_code',$search_department)
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                    if(!isset($search_department)){
                        $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    }
                }
            }else{
                if(isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.department_code',$search_department)
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
                if(!isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_department)){
                    if(isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department_action.division_code',$search_division)
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                    if(!isset($search_division)){
                        $section = DB::table('tb_percent_department_action')
                        ->select('tb_section.*')
                        ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                        ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                        ->groupBy('tb_percent_department_action.section_code')
                        ->orderBy('tb_section.section_code', 'ASC')->get();
                    }
                }else{

                    if($arr_section_code[0] == ""){
                        $checkax = strpos($orisoft_section_code->department_code,',');
                        $arr_department_code = [];
                        if($checkax >= 0){
                            $ex = explode(',',$orisoft_section_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_section_code->department_code);
                        }
                        if(count($arr_department_code)>0){
                            foreach ($arr_department_code as $valuexx) {
                                $subxx = substr($valuexx,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                            }
                        }
                    }else{
                        if(count($arr_section_code) == 1){
                            $section = DB::table('tb_section')
                            ->whereIn('tb_section.section_code',$arr_section_code)->get();
                        }else{
                            $sub = substr($search_department,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$sub.'%')->get();
                        }
                    }
                }
            }else{
                if(isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.department_code',$search_department)
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
                if(!isset($search_department)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                }
            }

        }else{
            if(!isset($search_department)){
                if(isset($search_division)){
                    $section = DB::table('tb_percent_department_action')
                    ->select('tb_section.*')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.division_code',$search_division)
                    ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }
                if(!isset($search_division)){
                    $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1',$orisoft_code)
                    ->groupBy('tb_percent_department_action.section_code')
                    ->orderBy('tb_section.section_code', 'ASC')->get();
                }
            }else{

                if($arr_section_code[0] == ""){
                    $checkax = strpos($orisoft_section_code->department_code,',');
                    $arr_department_code = [];
                    if($checkax >= 0){
                        $ex = explode(',',$orisoft_section_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_section_code->department_code);
                    }
                    if(count($arr_department_code)>0){
                        foreach ($arr_department_code as $valuexx) {
                            $subxx = substr($valuexx,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                        }
                    }
                }else{
                    if(count($arr_section_code) == 1){
                        $section = DB::table('tb_section')
                        ->whereIn('tb_section.section_code',$arr_section_code)->get();
                    }else{
                        if(isset($search_department)){
                            $section = DB::table('tb_percent_department_action')
                            ->select('tb_section.*')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.department_code',$search_department);
                            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                        }
                    }
                }
            }
        }

        $result = [
            'data'                => $section
        ];
        echo json_encode($result);

    }

    public function get_section_pa_grade(Request $request)
    {
        $previousYear = date('Y');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');

        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('employee_no',$orisoft_code)->first();

            $checka = strpos($orisoft_section_code->section_code,',');
            $arr_section_code = [];
            if($checka >= 0){
                $ex = explode(',',$orisoft_section_code->section_code);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_section_code,$value);
                    }
                }
            }else{
                array_push($arr_section_code,$orisoft_section_code->section_code);
            }
        }

        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else if($orisoft_code == '019492' || $orisoft_code == '000060'){
            if(count($search_department) > 0){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department);
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }
            // $sub = substr($search_department,0,2);
            // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();
        }else if($orisoft_code == "000002"){
            $section = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.section_code','tb_section.section_description')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            ->whereIn('tb_percent_department_action.department_code',$search_department)
            ->where('tb_percent_department_action.approve_by2','000002');
            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department)
                ->where('tb_percent_department_action.approve_by1','000026');
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }else{
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department)
                ->where('tb_percent_department_action.approve_by2','000026');
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }

        }else if($orisoft_code == "990002"){
            $section = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.section_code','tb_section.section_description')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            ->whereIn('tb_percent_department_action.department_code',$search_department);
            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
        }else{
            if($search_department == '0' || $search_department == 'all'){
                $sub = substr($search_division,0,1);
                if($sub == 'G' || $sub == 'P'){
                    $arr_section_code2 = [];
                    foreach ($arr_section_code as $value) {
                        $sub2 = substr($value,0,1);
                        if($sub2 == 'G' || $sub2 == 'P'){
                            array_push($arr_section_code2,$value);
                        }
                    }
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                }else{
                    $section = DB::table('tb_section')
                    ->where('tb_section.section_code','like',''.$sub.'%')->get();
                }
            }else{

                if($arr_section_code[0] == ""){
                    $checkax = strpos($orisoft_section_code->department_code,',');
                    $arr_department_code = [];
                    if($checkax >= 0){
                        $ex = explode(',',$orisoft_section_code->department_code);
                        if(count($ex)>0){
                            foreach ($ex as $value) {
                                array_push($arr_department_code,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code,$orisoft_section_code->department_code);
                    }
                    if(count($arr_department_code)>0){
                        foreach ($arr_department_code as $valuexx) {
                            $subxx = substr($valuexx,0,2);
                            $section = DB::table('tb_section')
                            ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                        }
                    }
                }else{
                    if(count($arr_section_code) == 1){
                        $section = DB::table('tb_section')
                        ->whereIn('tb_section.section_code',$arr_section_code)->get();
                    }else{
                        $sub = substr($search_department,0,2);
                        $section = DB::table('tb_section')
                        ->where('tb_section.section_code','like',''.$sub.'%')->get();
                    }
                }
            }
        }

        // $sub = substr($search_department,0,2);
        // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();

        // $orisoft_code = Auth::user()->orisoft_code;

        // $orisoft_section_code = DB::table('tb_employee_evaluator')
        // ->where('employee_no',$orisoft_code)->first();

        // $checka = strpos($orisoft_section_code->section_code,',');
        // $arr_section_code = [];
        // if($checka >= 0){
        //     $ex = explode(',',$orisoft_section_code->section_code);
        //     if(count($ex)>0){
        //         foreach ($ex as $value) {
        //             array_push($arr_section_code,$value);
        //         }
        //     }
        // }else{
        //     array_push($arr_section_code,$orisoft_section_code->section_code);
        // }
        // // dd($arr_section_code);
        // // exit();
        // if(($search_division == "0" || $search_division == "all") && ($search_department == "0" || $search_department == "all")){
        //     $section = DB::table('tb_section')
        //     ->whereIn('tb_section.section_code',$arr_section_code);
        //     $section = $section->orderBy('section_code', 'ASC')->get();
        // }else{
        //     // dd($arr_section_code);
        //     // exit();
        //     if($orisoft_code == '000023'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
        //     }else if($orisoft_code == '000047'){
        //         $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        //     }else{
        //         if($search_department == '0' || $search_department == 'all'){
        //             $sub = substr($search_division,0,1);
        //             if($sub == 'G' || $sub == 'P'){
        //                 $arr_section_code2 = [];
        //                 foreach ($arr_section_code as $value) {
        //                     $sub2 = substr($value,0,1);
        //                     if($sub2 == 'G' || $sub2 == 'P'){
        //                         array_push($arr_section_code2,$value);
        //                     }
        //                 }
        //                 $section = DB::table('tb_section')
        //                 ->whereIn('tb_section.section_code',$arr_section_code2)->get();
        //             }else{
        //                 $section = DB::table('tb_section')
        //                 ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //             }
        //         }else{
        //             if($arr_section_code[0] == ""){

        //                 $checkax = strpos($orisoft_section_code->department_code,',');
        //                 $arr_department_code = [];
        //                 if($checkax >= 0){
        //                     $ex = explode(',',$orisoft_section_code->department_code);
        //                     if(count($ex)>0){
        //                         foreach ($ex as $value) {
        //                             array_push($arr_department_code,$value);
        //                         }
        //                     }
        //                 }else{
        //                     array_push($arr_department_code,$orisoft_section_code->department_code);
        //                 }
        //                 if(count($arr_department_code)>0){
        //                     foreach ($arr_department_code as $valuexx) {
        //                         $subxx = substr($valuexx,0,2);
        //                         $section = DB::table('tb_section')
        //                         ->where('tb_section.section_code','like',''.$subxx.'%')->get();
        //                     }
        //                 }
        //                 // dd($arr_department_code);
        //             }else{
        //                 if(count($arr_section_code) == 1){
        //                     $section = DB::table('tb_section')
        //                     ->whereIn('tb_section.section_code',$arr_section_code)->get();
        //                 }else{
        //                     $sub = substr($search_department,0,2);
        //                     $section = DB::table('tb_section')
        //                     ->where('tb_section.section_code','like',''.$sub.'%')->get();
        //                 }
        //             }
        //             // exit();

        //             // dd($arr_section_code);
        //             // exit();

        //         }
        //     }
        // }

        $result = [
            'data'                => $section
        ];
        echo json_encode($result);

    }

    public function filter_section(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $orisoft_code = Auth::user()->orisoft_code;
        $previousYear = date('Y');
        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $tb_section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else{
            if($search_department == '0'){
                $sub = substr($search_division,0,1);
                $tb_section = DB::table('tb_section')
                ->where('tb_section.section_code','like',''.$sub.'%')->get();
            }else{
                $sub = substr($search_department,0,2);
                $tb_section = DB::table('tb_section')
                ->where('tb_section.section_code','like',''.$sub.'%')->get();
            }
        }
        $result = [
            'data'                => $tb_section,
            // 'sub'                => $sub
        ];
        echo json_encode($result);

    }

    public function get_division_transfer(Request $request)
    {
        $division = DB::table('tb_division');
        $division = $division->orderBy('division_code', 'ASC')->get();

        $result = [
            'data'                => $division
        ];
        echo json_encode($result);

    }

    public function export_excel_list_Employees(Request $request)
    {
        $previousYear = date('Y');

        $search_year      = $request->input('search_year');
        $search_position      = $request->input('search_position');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_status      = $request->input('search_status');

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.employee_local_name_en',
        'tb_employee.position_description',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee.employee_status_description',
        'tb_employee.id AS employee_id'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($search_division == "0"){
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
            if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){

            }else{
                $datarow = $datarow->whereIn('tb_employee.division_code',$arr_division_code);
            }
        }

        if($search_department == "0"){
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
            if($orisoft_code == "000060" || $orisoft_code == "000002"  || $orisoft_code == "019492"){

            }else{
                $datarow = $datarow->whereIn('tb_employee.department_code',$arr_department_code);
            }

        }
        if($search_year != "0"){
            $datarow->where(function ($query) use($search_year) {
                $query->orWhere('tb_employee_final_score.rec_year','like','%'.$search_year.'%');
            });
        }

        if($search_position != "0"){
            $datarow = $datarow->where('tb_employee.position_code', $search_position);
        }
        if($search_division != "0"){
            $datarow = $datarow->where('tb_employee.division_code', $search_division);
        }
        if($search_department != "0"){
            $datarow = $datarow->where('tb_employee.department_code', $search_department);
        }
        if($search_section != "0"){
            $datarow = $datarow->where('tb_employee.section_code', $search_section);
        }
        if($search_status != "0"){
            $datarow = $datarow->where('tb_employee.employee_status_description', $search_status);
        }
        $datarow = $datarow->orderBy('tb_employee_final_score.id','ASC')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $status_evaluation = '';
                if($value->employee_status_description == 'Passed'){
                    $status_evaluation = 'Passed';
                }else if($value->employee_status_description == 'Transferred'){
                    $status_evaluation = 'Transferred';
                }else if($value->employee_status_description == 'Resigned'){
                    $status_evaluation = 'Resigned';
                }
                $data[] = array(
                    "order"=> $key+1,
                    "code"=> $value->employee_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "div"=> $value->division_description,
                    "dept"=> $value->department_description,
                    "sect"=> $value->section_description,
                    "status"=> $status_evaluation,
                );
            }
        }


        $excel = public_path('upload/orisoft/')."template_review_employee.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);

        $sheet = $spreadsheet->getActiveSheet();
        // dd($data);
        // exit;
        $numsheet1 = 2;
        if($data){
            foreach ($data as $key => $value) {
                $sheet->setCellValue('A'.$numsheet1, $value['order']);
                $sheet->setCellValue('B'.$numsheet1, $value['code']);
                $sheet->setCellValue('C'.$numsheet1, $value['name']);
                $sheet->setCellValue('D'.$numsheet1, $value['position']);
                $sheet->setCellValue('E'.$numsheet1, $value['div']);
                $sheet->setCellValue('F'.$numsheet1, $value['dept']);
                $sheet->setCellValue('G'.$numsheet1, $value['sect']);
                $sheet->setCellValue('H'.$numsheet1, $value['status']);
                $numsheet1++;
            }
        }
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Review Lists of Evaluated Employees.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
























    public function get_section_user(Request $request)
    {
        $search_year      = $request->input('search_year');
        $previousYear = $search_year;
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $arr_section_code = [];

        $orisoft_code = Auth::user()->orisoft_code;
        if($orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            $orisoft_section_code = DB::table('tb_employee_evaluator')
            ->where('employee_no',$orisoft_code)->first();
            if(!empty($orisoft_section_code)){
                $checka = strpos($orisoft_section_code->section_code,',');
                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
            }
        }

        if($orisoft_code == '000023'){
            $arr_section_code = [];
                $orisoft_section_code = DB::table('tb_employee_evaluator')
                ->where('employee_no',$orisoft_code)->first();

                $checka = strpos($orisoft_section_code->section_code,',');

                if($checka >= 0){
                    $ex = explode(',',$orisoft_section_code->section_code);
                    if(count($ex)>0){
                        foreach ($ex as $value) {
                            array_push($arr_section_code,$value);
                        }
                    }
                }else{
                    array_push($arr_section_code,$orisoft_section_code->section_code);
                }
                if(trans(request()->segment(1)) == 'mtl'){
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
                }
        }else if($orisoft_code == '000047'){
            $section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else if($orisoft_code == '019492' || $orisoft_code == '000060'){

            if(count($search_department) > 0){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department);
                $sectionraw = $section->toRawSql();
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }
            // $sub = substr($search_department,0,2);
            // $section = DB::table('tb_section')->where('tb_section.section_code','like',''.$sub.'%')->get();
        }else if($orisoft_code == "000002"){
            $section = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.section_code','tb_section.section_description')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            ->whereIn('tb_percent_department_action.department_code',$search_department)
            ->where('tb_percent_department_action.approve_by2','000002');
                $sectionraw = $section->toRawSql();
            $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department)
                ->where('tb_percent_department_action.approve_by1','000026');
                $sectionraw = $section->toRawSql();
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }else{
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department)
                ->where('tb_percent_department_action.approve_by2','000026');
                $sectionraw = $section->toRawSql();
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }

        }else if($orisoft_code == "990002"){
            if(count($search_department) > 0){
                $section = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.section_code','tb_section.section_description')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->whereIn('tb_percent_department_action.department_code',$search_department);
                $sectionraw = $section->toRawSql();
                $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
            }
            // $section = DB::table('tb_percent_department_action')
            // ->select('tb_percent_department_action.section_code','tb_section.section_description')
            // ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            // ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
            // ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            // ->whereIn('tb_percent_department_action.department_code',$search_department);
            // $section = $section->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
        }else{
            if($search_department == '0' || $search_department == 'all'){
                $sub = substr($search_division,0,1);
                if($sub == 'G' || $sub == 'P'){
                    $arr_section_code2 = [];
                    foreach ($arr_section_code as $value) {
                        $sub2 = substr($value,0,1);
                        if($sub2 == 'G' || $sub2 == 'P'){
                            array_push($arr_section_code2,$value);
                        }
                    }
                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$arr_section_code2)->get();
                }else{
                    $section = DB::table('tb_section')
                    ->where('tb_section.section_code','like',''.$sub.'%')->get();
                }
            }else{
                if(empty($arr_section_code)){
                    if(!empty($orisoft_section_code)){
                        $checkax = strpos($orisoft_section_code->department_code,',');
                        $arr_department_code = [];
                        if($checkax >= 0){
                            $ex = explode(',',$orisoft_section_code->department_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($arr_department_code,$value);
                                }
                            }
                        }else{
                            array_push($arr_department_code,$orisoft_section_code->department_code);
                        }
                        if(count($arr_department_code)>0){
                            foreach ($arr_department_code as $valuexx) {
                                $subxx = substr($valuexx,0,2);
                                $section = DB::table('tb_section')
                                ->where('tb_section.section_code','like',''.$subxx.'%')->get();
                            }
                        }
                    }else{
                        $section = DB::table('tb_section');
                        foreach ($request->input('search_department') as $_department) {
                            $_section_code = substr($_department,0,2);
                            $section->orWhere('tb_section.section_code','like',''.$_section_code.'%');
                        }
                        $section = $section->get();
                    }
                }else{
                    if(count($arr_section_code) == 1){
                        $section = DB::table('tb_section')
                        ->whereIn('tb_section.section_code',$arr_section_code)->get();
                    }else{
                        $sub = substr($search_department,0,2);
                        $section = DB::table('tb_section')
                        ->where('tb_section.section_code','like',''.$sub.'%')->get();
                    }
                }
            }
        }

        $result = [
            'data'                => $section,
            'sectionraw'          => $sectionraw,
        ];
        echo json_encode($result);

    }
    public function get_attendance(Request $request)
    {
        $id                             = $request->input('id');
        $data = DB::table('tb_employee_final_score')
        ->where('id', $id)
        ->first();
        echo json_encode($data);
    }
    public function update_attendance(Request $request)
    {
        $id                             = $request->input('id');
        $attendance_sl                             = $request->input('attendance_sl');
        $attendance_pl                             = $request->input('attendance_pl');
        $attendance_late                             = $request->input('attendance_late');
        $attendance_abs                             = $request->input('attendance_abs');
        $attendance_abt                             = $request->input('attendance_abt');
        $attendance_cl                             = $request->input('attendance_cl');
        $attendance_ol                             = $request->input('attendance_ol');
        $attendance_sus                             = $request->input('attendance_sus');
        $attendance_wwar                             = $request->input('attendance_wwar');
        $attendance_vwar                             = $request->input('attendance_vwar');

        $compliance_score                             = $request->input('compliance_score');
        $attendance_score                             = $request->input('attendance_score');
        $not_up_salary                             = $request->input('not_up_salary');
        $code_employee_final_attendance                             = $request->input('code_employee_final_attendance');
        $data = DB::table('tb_employee_final_score')
        ->where('id', $id )
        ->update([
            'attendance_sl' => $attendance_sl,
            'attendance_pl' => $attendance_pl,
            'attendance_late' => $attendance_late,
            'attendance_abs' => $attendance_abs,
            'attendance_abt' => $attendance_abt,
            'attendance_cl' => $attendance_cl,
            'attendance_ol' => $attendance_ol,
            'attendance_sus' => $attendance_sus,
            'attendance_wwar' => $attendance_wwar,
            'attendance_vwar' => $attendance_vwar,

            'compliance_score' => $compliance_score,
            'attendance_score' => $attendance_score,
            'not_up_salary' => ($not_up_salary==1?$code_employee_final_attendance:null),
        ]);
        if($not_up_salary==1){
            $value = DB::table('tb_employee_final_score')->where('id',$id)->first();
            DB::table('tb_employee_final_score')->where('id',$id)
            ->update([
                "percent_proposed" => 0,
                "amount_proposed" => 0,
                "salary_new" => $value->bsalary_wage,
                "salary_month_new" => $value->salary_month_old,
                "amount_proposed" => 0,
                "percent_proposed_old_gmdm" => 0,
                "percent_proposed_gmdm" => 0,
                "amount_proposed_gmdm" => 0,
                "salary_new_gmdm" => $value->bsalary_wage,
                "salary_month_new_gmdm" => $value->salary_month_old,
                "final_by_md_gm_amount" => 0,
                "status_salary" => '1',
                "status_pa" => '14',
                "freeze_to_gmdm" => '1',
                "freeze_to_gmdm_edit" => '0',
                "freeze_to_approve_hr" => '1',
            ]);
        }
        echo json_encode($data);
    }
}
