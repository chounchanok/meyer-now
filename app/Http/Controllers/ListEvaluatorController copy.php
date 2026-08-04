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

class ListEvaluatorController extends Controller
{
    public function index()
    {
        $year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->get();

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
        
        $userID = Auth::user()->id;
        $orisoft_code = DB::table('users')
        ->select('orisoft_code')
        ->where('id',$userID)->first();

        $orisoft_division_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code->orisoft_code)->first();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        $position = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee.position_code',
        'tb_employee.position_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();

        // $division = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code',
        // 'tb_employee.division_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code);
        // $division = $division->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();

        // $division = DB::table('tb_employee_evaluator')
        // ->select(
        // 'tb_employee.division_code',
        // 'tb_employee.division_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','tb_employee_final_score.employee_no')
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

        $division = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.division_code',$orisoft_division_code->division_code);
        $division = $division->groupBy('tb_employee_evaluator.division_code')->orderBy('division_code', 'ASC')->get();

        $department = [];
        $search_division      = $orisoft_division_code->division_code;
        if($orisoft_code->orisoft_code == "000003"){
            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P100');
                $query->orWhere('tb_department.department_code','P400');
            });
            $department = $department->get();
        }else if($orisoft_code->orisoft_code == "013591"){
            $division = DB::table('tb_division');
            $division->where(function ($query) {
                $query->orWhere('tb_division.division_code','P000');
                $query->orWhere('tb_division.division_code','6000');
            });
            $division = $division->get();

            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P300');
                $query->orWhere('tb_department.department_code','PDDD');
            });
            $department = $department->get();
        }else if($orisoft_code->orisoft_code == "000008"){
            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P700');
                $query->orWhere('tb_department.department_code','PAAA');
            });
            $department = $department->get();
        }else if($orisoft_code->orisoft_code == "000026"){
            $division = DB::table('tb_division');
            $division->where(function ($query) {
                $query->orWhere('tb_division.division_code','P000');
                $query->orWhere('tb_division.division_code','8000');
                $query->orWhere('tb_division.division_code','Y000');
                $query->orWhere('tb_division.division_code','Z000');
            });
            $division = $division->get();

            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P800');
                $query->orWhere('tb_department.department_code','8200');
                $query->orWhere('tb_department.department_code','Y200');
                $query->orWhere('tb_department.department_code','Z100');
                $query->orWhere('tb_department.department_code','Z200');
            });
            $department = $department->get();
        }else{
            if($search_division){
                $sub = substr($search_division,0,1);
                if($sub == 'G' || $sub == 'P'){
                    $department = DB::table('tb_department')
                    ->where('tb_department.department_code','like','%'.$orisoft_division_code->department_code.'%')->get();
                }else{
                    $department = DB::table('tb_department')
                    ->where('tb_department.department_code','like',''.$sub.'%')->get();
                }
            }
        }
        
        return view('pages.ListEvaluator.index', [
            "year" => $year,
            "evaluator" => $evaluator,
            "position" => $position,
            "division" => $division,
            "department" => $department,
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
            $previousYear = date('Y');
        // }

        // $orisoft_code = Auth::user()->orisoft_code;
        // $section_code = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->groupBy('tb_employee.section_code');
        // $section_code = $section_code->get()->toArray();

        // $test1 = [];
        // if($section_code){
        //     foreach ($section_code as $key => $value) {
        //         array_push($test1,$value->section_code);
        //     }
        // }
        $userID = Auth::user()->id;
        $orisoft_code = DB::table('users')
        ->select('orisoft_code')
        ->where('id',$userID)->first();

        $orisoft_division_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code->orisoft_code)->first();
        
        $department = [];
        $search_division      = $orisoft_division_code->division_code;
        if($orisoft_code->orisoft_code == "000003"){
            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P100');
                $query->orWhere('tb_department.department_code','P400');
            });
            $department = $department->get();
        }else if($orisoft_code->orisoft_code == "013591"){
            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P300');
                $query->orWhere('tb_department.department_code','PDDD');
                $query->orWhere('tb_department.department_code','6200');
                $query->orWhere('tb_department.department_code','6300');
                $query->orWhere('tb_department.department_code','6400');
            });
            $department = $department->get();
        }else if($orisoft_code->orisoft_code == "000008"){
            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P700');
                $query->orWhere('tb_department.department_code','PAAA');
            });
            $department = $department->get();
        }else if($orisoft_code->orisoft_code == "000026"){
            $department = DB::table('tb_department');
            $department->where(function ($query) {
                $query->orWhere('tb_department.department_code','P800');
                $query->orWhere('tb_department.department_code','8200');
                $query->orWhere('tb_department.department_code','Y200');
                $query->orWhere('tb_department.department_code','Z100');
                $query->orWhere('tb_department.department_code','Z200');
            });
            $department = $department->get();
        }else{
            if($search_division){
                $sub = substr($search_division,0,1);
                if($sub == 'G' || $sub == 'P'){
                    $department = DB::table('tb_department')
                    ->where('tb_department.department_code','like','%'.$orisoft_division_code->department_code.'%')->get();
                }else{
                    $department = DB::table('tb_department')
                    ->where('tb_department.department_code','like',''.$sub.'%')->get();
                }
            }
        }

        $new_department_code = [];
        if(count($department)>0){
            foreach ($department as $value) {
                array_push($new_department_code,$value->department_code);
            }
        }
        // echo json_encode($new_division_code); 
        // exit;
        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.employee_local_name_en',
        'tb_position.position_description',
        'tb_division.division_description',
        'tb_department.department_description',
        'tb_section.section_description',
        'tb_employee.employee_status_description',
        'tb_employee.id AS employee_id'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->leftJoin('tb_division','tb_division.division_code','=','tb_employee.division_code')
        ->leftJoin('tb_department','tb_department.department_code','=','tb_employee.department_code')
        ->leftJoin('tb_section','tb_section.section_code','=','tb_employee.section_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereIn('tb_employee.department_code',$new_department_code);

        

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
        if($search_section != "all"){
            $datarow = $datarow->where('tb_employee.section_code', $search_section);
        }
        if($search_status != "0"){
            $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
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
                if($value->employee_status_description == 'Passed'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Passed</span>';
                }else if($value->employee_status_description == 'Transferred'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-warning">Transferred</span>';
                }else if($value->employee_status_description == 'Resigned'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">Resigned</span>';
                }

                $edit_review_evaluate_employees = 'style="display:none;"';
                if (Auth::user()->can('edit review evaluate employees')) {
                    $edit_review_evaluate_employees = 'style="display:block;"';
                }
                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">',
                    "order"=> $key+1,
                    "code"=> $value->employee_no,
                    "name"=> $value->employee_local_name_en,
                    "position"=> $value->position_description,
                    "div"=> $value->division_description,
                    "dept"=> $value->department_description,
                    "sect"=> $value->section_description,
                    "status"=> $status_evaluation,
                    "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" data-bs-toggle="modal" data-bs-target="#approveModalSingle" onclick="fetchEmployee_pass('.$value->employee_id.','.$value->id.')" '.$edit_review_evaluate_employees.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#transferModal" onclick="fetchEmployee('.$value->employee_id.','.$value->id.')" '.$edit_review_evaluate_employees.'>
                                    <i class="ki-solid ki-arrows-loop fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#resignModal" onclick="fetchEmployee_resign('.$value->employee_id.','.$value->id.')" '.$edit_review_evaluate_employees.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>',
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

    public function filter_department(Request $request)
    {
        $search_division      = $request->input('search_division');
        $orisoft_code = Auth::user()->orisoft_code;
        

        $orisoft_division_code = DB::table('tb_employee_evaluator')
        ->where('employee_no',$orisoft_code)->first();

        $department = [];
        if($search_division == '0'){
            if($orisoft_code == "000003"){
                $department = DB::table('tb_department');
                $department->where(function ($query) {
                    $query->orWhere('tb_department.department_code','P100');
                    $query->orWhere('tb_department.department_code','P400');
                });
                $department = $department->get();
            }else if($orisoft_code == "013591"){
                $department = DB::table('tb_department');
                $department->where(function ($query) {
                    $query->orWhere('tb_department.department_code','P300');
                    $query->orWhere('tb_department.department_code','PDDD');
                    $query->orWhere('tb_department.department_code','6200');
                    $query->orWhere('tb_department.department_code','6300');
                    $query->orWhere('tb_department.department_code','6400');
                });
                $department = $department->get();
            }else if($orisoft_code == "000008"){
                $department = DB::table('tb_department');
                $department->where(function ($query) {
                    $query->orWhere('tb_department.department_code','P700');
                    $query->orWhere('tb_department.department_code','PAAA');
                });
                $department = $department->get();
            }else if($orisoft_code == "000026"){
                $department = DB::table('tb_department');
                $department->where(function ($query) {
                    $query->orWhere('tb_department.department_code','P800');
                    $query->orWhere('tb_department.department_code','8200');
                    $query->orWhere('tb_department.department_code','Y200');
                    $query->orWhere('tb_department.department_code','Z100');
                    $query->orWhere('tb_department.department_code','Z200');
                });
                $department = $department->get();
            }else{
                if($search_division){
                    $sub = substr($search_division,0,1);
                    if($sub == 'G' || $sub == 'P'){
                        $department = DB::table('tb_department')
                        ->where('tb_department.department_code','like','%'.$orisoft_division_code->department_code.'%')->get();
                    }else{
                        $department = DB::table('tb_department')
                        ->where('tb_department.department_code','like',''.$sub.'%')->get();
                    }
                }
            }
        }else{
            $sub = substr($search_division,0,2);
            $department = DB::table('tb_department')
            ->where('tb_department.department_code','like',''.$sub.'%')->get();
        }
        
        $result = [
            'data'                => $department,
            // 'sub'                => $sub
        ];
        echo json_encode($result); 

    }

    public function filter_section(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $orisoft_code = Auth::user()->orisoft_code;

        if($orisoft_code == '000023'){
            $tb_section = DB::table('tb_section')->where('tb_section.section_code','G3TC')->get();
        }else if($orisoft_code == '000047'){
            $tb_section = DB::table('tb_section')->where('tb_section.section_code','G3AC')->get();
        }else{  
            if($search_department == '0'){
                if($orisoft_code == "000003"){
                    $tb_section = DB::table('tb_section');
                    $tb_section->where(function ($query) {
                        $query->orWhere('tb_section.section_code','like','P1%');
                        $query->orWhere('tb_section.section_code','like','P4%');
                    });
                    $tb_section = $tb_section->get();
                }else if($orisoft_code == "013591"){
                    $tb_section = DB::table('tb_section');
                    $tb_section->where(function ($query) {
                        $query->orWhere('tb_section.section_code','like','P3%');
                        $query->orWhere('tb_section.section_code','like','PD%');
                        $query->orWhere('tb_section.section_code','like','62%');
                        $query->orWhere('tb_section.section_code','like','63%');
                        $query->orWhere('tb_section.section_code','like','64%');
                    });
                    $tb_section = $tb_section->get();
                }else if($orisoft_code == "000008"){
                    $tb_section = DB::table('tb_section');
                    $tb_section->where(function ($query) {
                        $query->orWhere('tb_section.section_code','like','P7%');
                        $query->orWhere('tb_section.section_code','like','PA%');
                    });
                    $tb_section = $tb_section->get();
                }else if($orisoft_code == "000026"){
                    $tb_section = DB::table('tb_section');
                    $tb_section->where(function ($query) {
                        $query->orWhere('tb_section.section_code','like','P8%');
                        $query->orWhere('tb_section.section_code','like','82%');
                        $query->orWhere('tb_section.section_code','like','86%');
                        $query->orWhere('tb_section.section_code','like','Y2%');
                        $query->orWhere('tb_section.section_code','like','Z1%');
                        $query->orWhere('tb_section.section_code','like','Z2%');
                    });
                    $tb_section = $tb_section->get();
                }else{
                    $sub = substr($search_division,0,1);
                    $tb_section = DB::table('tb_section')
                    ->where('tb_section.section_code','like',''.$sub.'%')->get();
                }
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
}
