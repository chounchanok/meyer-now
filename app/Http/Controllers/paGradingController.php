<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class paGradingController extends Controller
{
    public function index()
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }

        $position = DB::table('tb_position')->orderBy('id', 'ASC')->get();
        $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        ->orderBy('tb_employee_evaluator.employee_no', 'ASC')->get();


        $section = DB::table('tb_section');
        $section = $section->orderBy('id', 'ASC')->get();

        $bell_curve = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->where('tb_grade_action.grade_name','!=','U')
        ->where('tb_grade_action.grade_name','!=','CD')
        ->orderBy('tb_grade_action.id', 'ASC')->get();

        $search_year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
        return view('pages.paGrading.index', [
            "position" => $position,
            "division" => $division,
            "department" => $department,
            "evaluator" => $evaluator,
            "section" => $section,
            "bell_curve" => $bell_curve,
            "search_year" => $search_year,
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.paGrading.index');
    }

    public function table_paGrading_getdata_old(Request $request)
    {
        for ($i=1; $i < 11; $i++) { 
            $data[] = array(
                "id" =>  '<input type="checkbox">',
                "evaluator"=> "Phudis Khomkhai",
                "code"=> "123456789",
                "name"=> "Chantarat Chaichana",
                "position"=> "xxxxxxxx",
                "div"=> "xxxx",
                "dept"=> "xxxx",
                "sect"=> "xxxx",
                "theoryG"=> "<h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>",
                "score"=> "100",
                "adjG"=> "<h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>",
                "status"=> "status",
                "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-warning text-dark btn-xs me-1' data-bs-toggle='modal' data-bs-target='#editModal'><i class='ki-solid ki-pencil fs-5'></i></button>",
                
            );  
        }
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result); 

    }

    public function table_paGrading_getdata(Request $request)
    {
        $search_employee_no      = $request->input('search_employee_no');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_status      = $request->input('search_status');
        $update_grade      = $request->input('update_grade');
        $search_month_day      = $request->input('search_month_day');

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }
        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_description',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        // ->where('tb_employee_final_score.status_evaluation','3')
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if(isset($search_division)){
            if(count($search_division) > 0){
                $datarow->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $datarow->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $datarow->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $datarow->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_status != "0"){
            if($search_status == "1"){
                $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
            }
            if($search_status == "2"){
                $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                $datarow = $datarow->whereNull('tb_employee_final_score.adjust_grade');
            }
            if($search_status == "3"){
                $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                $datarow = $datarow->whereNotNull('tb_employee_final_score.adjust_grade');
            }
        }

        $datarow = $datarow->orderBy('tb_employee_final_score.total_score','DESC');

        $dataraw = $datarow->toRawSql();
        $datarow = $datarow->get();

        if(count($datarow) == 2){
            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->where('tb_grade_action.grade_name','!=','U')
            ->where('tb_grade_action.grade_name','!=','CD')
            ->orderBy('tb_grade_action.id', 'ASC')->get();
            $percentAR = 0;
            $percentP = 0;
            $percentA = 0;
            $percentB = 0;
            $percentC = 0;
            $percentD = 0;
            $percentE = 0;
            $countall = count($datarow);
            if($bell_curve){
                foreach ($bell_curve as $keyx => $valuex) {
                    if($valuex->grade_name == 'AR'){
                        $percentAR = $valuex->percent;
                    }
                    if($valuex->grade_name == 'P'){
                        $percentP = $valuex->percent;
                    }
                    if($valuex->grade_name == 'A'){
                        $percentA = $valuex->percent;
                    }
                    if($valuex->grade_name == 'B'){
                        $percentB = $valuex->percent;
                    }
                    if($valuex->grade_name == 'C'){
                        $percentC = $valuex->percent;
                    }
                    if($valuex->grade_name == 'D'){
                        $percentD = $valuex->percent;
                    }
                    if($valuex->grade_name == 'E'){
                        $percentE = $valuex->percent;
                    }
                }
            }

            
            $calAR = round(($countall*$percentAR)/100);
            $calP = round(($countall*$percentP)/100);
            $calA = round(($countall*$percentA)/100);
            if((($countall*$percentB)/100) > (($countall*$percentD)/100)){
                $calB = ceil(($countall*$percentB)/100);
            }else{
                $calB = round(($countall*$percentB)/100);
            }
            
            $calC = round(($countall*$percentC)/100);
            if((($countall*$percentB)/100) > (($countall*$percentD)/100)){
                $calD = floor(($countall*$percentD)/100);
            }else{
                $calD = round(($countall*$percentD)/100);
            }
            
            $calE = round(($countall*$percentE)/100);

            $subcalAR = round(($countall*$percentAR)/100);
            $subcalP = round(($countall*$percentP)/100);
            $subcalA = round(($countall*$percentA)/100);
            $subcalB = round(($countall*$percentB)/100);
            $subcalC = round(($countall*$percentC)/100);
            $subcalD = round(($countall*$percentD)/100);
            $subcalE = round(($countall*$percentE)/100);

            $xcheck_calAR = round(($countall*$percentAR)/100);
            $xcheck_calP = round(($countall*$percentP)/100);
            $xcheck_calA = round(($countall*$percentA)/100);
            $xcheck_calB = round(($countall*$percentB)/100);
            $xcheck_calC = round(($countall*$percentC)/100);
            $xcheck_calD = round(($countall*$percentD)/100);
            $xcheck_calE = round(($countall*$percentE)/100);

            $check_calAR = round(($countall*$percentAR)/100);
            $check_calP = round(($countall*$percentP)/100);
            $check_calA = round(($countall*$percentA)/100);
            $check_calB = round(($countall*$percentB)/100);
            $check_calC = round(($countall*$percentC)/100);
            $check_calD = round(($countall*$percentD)/100);
            $check_calE = round(($countall*$percentE)/100);
            // $theo = round( $value->total_score ,2 )


            $data = [];
            $data_total = [];
            $checkA = 0;
            $theo_grade1 = '';
            if($datarow){
                foreach ($datarow as $key => $value) {
            //         dd($calD);
            // exit;
                    $theo_grade = '';
                    if($calAR > 0){
                        $theo_grade = 'AR';
                        $calAR -= 1;
                    }else if($calP > 0){
                        $theo_grade = 'P';
                        $calP -= 1;
                    }else if($calA > 0){
                        $theo_grade = 'A';
                        $calA -= 1;
                    }else if($calB > 0){
                        $theo_grade = 'B';
                        $calB -= 1;
                    }else if($calC > 0){
                        $theo_grade = 'C';
                        $calC -= 1;
                    }else if($calD > 0){
                        $theo_grade = 'D';
                        $calD -= 1;
                    }else{
                        $theo_grade = 'E';
                        $calE -= 1;
                    }
                    if($key == 0){
                        $theo_grade1 = $theo_grade;
                    }
                    if($key == 1){
                        if($theo_grade1 == "AR"){
                            $theo_grade = 'P';
                        }else if($theo_grade1 == "P"){
                            $theo_grade = 'A';
                        }else if($theo_grade1 == "A"){
                            $theo_grade = 'B';
                        }else if($theo_grade1 == "B"){
                            $theo_grade = 'C';
                        }else if($theo_grade1 == "C"){
                            $theo_grade = 'D';
                        }else if($theo_grade1 == "D"){
                            $theo_grade = 'E';
                        }
                    }
                    // echo $theo_grade;
                    // dd($theo_grade);
                    // exit;
                    // $theo = round( $value->total_score ,2 )
                    if($search_employee_no != "all" && $search_employee_no != ""){
                        if($value->pa_grade){
                            // if($value->pa_grade != $theo_grade){
                            //     $value->pa_grade = $theo_grade;
                            //     DB::table('tb_employee_final_score')->where('id', $value->id )->update([
                            //         'pa_grade' => $theo_grade,
                                    
                            //     ]);
                            // }else{
                                if($update_grade == '1' && $search_employee_no != '' && $value->pa_grade_edit == '0'){
                                    $value->pa_grade = $theo_grade;
                                    DB::table('tb_employee_final_score')->where('id', $value->id )->update([
                                        'pa_grade' => $theo_grade,
                                        
                                    ]);
                                }
                            // }
                        }else{
                            $value->pa_grade = $theo_grade;
                            if($search_employee_no != "0"){
                                DB::table('tb_employee_final_score')->where('id', $value->id )->update([
                                    'pa_grade' => $theo_grade
                                ]);
                            }
                        }
                    }
                    
                    

                    
                    

                    // $value->adjust_grade = $theo_grade;
                    
                    
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                    if($value->status_evaluation == '0'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '1'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '3'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                    }
                    if($value->pa_grade == 'A'){
                        $grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'B'){
                        $grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'C'){
                        $grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'D'){
                        $grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'E'){
                        $grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else{
                        $grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }
                    
                    // <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="set_editModal_id('.$value->id.',\''.$value->adjust_grade.'\');" data-bs-toggle="modal" data-bs-target="#editModal" '.$edit_pa_grading.'>
                    //                     <i class="ki-solid ki-pencil fs-5"></i>
                    //                 </button>
                    if($value->adjust_grade == 'A'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'B'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'C'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'D'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'E'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else{
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }

                    $edit_pa_grading = 'style="display:none;"';
                    if (Auth::user()->can('edit pa grading')) {
                        $edit_pa_grading = 'style="display:block;"';
                    }
                    // <button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$edit_pa_grading.'>
                    //                     <i class="ki-solid ki-check-circle fs-5"></i>
                    //                 </button>
                    $data[] = array(
                        "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.','.$value->pa_grade.'" date-id="'.$value->employee_no.'" >',
                        "evaluator"=> $value->evaluator_name_en,
                        "code"=> $value->employee_no,
                        "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                        "position"=> $value->position_description,
                        "div"=> $value->division_description,
                        "dept"=> $value->department_description,
                        "sect"=> $value->section_description,
                        "total_score"=> $value->total_score,
                        "pa_grade"=>$value->pa_grade,
                        "theoryG"=> $grade.'<input type="hidden" id="theoryG_'.$value->id.'" value="'.$value->pa_grade.'">',
                        "adjust_grade"=> $adjust_grade,
                        "status"=> $status_evaluation,
                        "action"=> '
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="set_editModal_id('.$value->id.',\''.$value->adjust_grade.'\');" data-bs-toggle="modal" data-bs-target="#editModal" '.$edit_pa_grading.'>
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>',
                        "checkA"=> $checkA,
                        "final_id"=> $value->id
                    );  
                }
            }
            // dd($datarow);
            // exit;
        }else{
            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->where('tb_grade_action.grade_name','!=','U')
            ->where('tb_grade_action.grade_name','!=','CD')
            ->orderBy('tb_grade_action.id', 'ASC')->get();
            $percentAR = 0;
            $percentP = 0;
            $percentA = 0;
            $percentB = 0;
            $percentC = 0;
            $percentD = 0;
            $percentE = 0;
            $countall = count($datarow);
            if($bell_curve){
                foreach ($bell_curve as $keyx => $valuex) {
                    if($valuex->grade_name == 'AR'){
                        $percentAR = $valuex->percent;
                    }
                    if($valuex->grade_name == 'P'){
                        $percentP = $valuex->percent;
                    }
                    if($valuex->grade_name == 'A'){
                        $percentA = $valuex->percent;
                    }
                    if($valuex->grade_name == 'B'){
                        $percentB = $valuex->percent;
                    }
                    if($valuex->grade_name == 'C'){
                        $percentC = $valuex->percent;
                    }
                    if($valuex->grade_name == 'D'){
                        $percentD = $valuex->percent;
                    }
                    if($valuex->grade_name == 'E'){
                        $percentE = $valuex->percent;
                    }
                }
            }
            $calAR = round(($countall*$percentAR)/100);
            $calP = round(($countall*$percentP)/100);
            $calA = round(($countall*$percentA)/100);
            $calB = round(($countall*$percentB)/100);
            $calC = round(($countall*$percentC)/100);
            $calD = round(($countall*$percentD)/100);
            $calE = round(($countall*$percentE)/100);

            $subcalAR = round(($countall*$percentAR)/100);
            $subcalP = round(($countall*$percentP)/100);
            $subcalA = round(($countall*$percentA)/100);
            $subcalB = round(($countall*$percentB)/100);
            $subcalC = round(($countall*$percentC)/100);
            $subcalD = round(($countall*$percentD)/100);
            $subcalE = round(($countall*$percentE)/100);

            $xcheck_calAR = round(($countall*$percentAR)/100);
            $xcheck_calP = round(($countall*$percentP)/100);
            $xcheck_calA = round(($countall*$percentA)/100);
            $xcheck_calB = round(($countall*$percentB)/100);
            $xcheck_calC = round(($countall*$percentC)/100);
            $xcheck_calD = round(($countall*$percentD)/100);
            $xcheck_calE = round(($countall*$percentE)/100);

            $check_calAR = round(($countall*$percentAR)/100);
            $check_calP = round(($countall*$percentP)/100);
            $check_calA = round(($countall*$percentA)/100);
            $check_calB = round(($countall*$percentB)/100);
            $check_calC = round(($countall*$percentC)/100);
            $check_calD = round(($countall*$percentD)/100);
            $check_calE = round(($countall*$percentE)/100);
            // $theo = round( $value->total_score ,2 )


            $data = [];
            $data_total = [];
            $checkA = 0;
            if($datarow){
                foreach ($datarow as $key => $value) {
                    
                    $theo_grade = '';
                    if($calAR > 0){
                        $theo_grade = 'AR';
                        $calAR -= 1;
                    }else if($calP > 0){
                        $theo_grade = 'P';
                        $calP -= 1;
                    }else if($calA > 0){
                        $theo_grade = 'A';
                        $calA -= 1;
                    }else if($calB > 0){
                        $theo_grade = 'B';
                        $calB -= 1;
                    }else if($calC > 0){
                        $theo_grade = 'C';
                        $calC -= 1;
                    }else if($calD > 0){
                        $theo_grade = 'D';
                        $calD -= 1;
                    }else{
                        $theo_grade = 'E';
                        $calE -= 1;
                    }
                    // $theo = round( $value->total_score ,2 )
                    if($search_employee_no != "all" && $search_employee_no != ""){
                        if($value->pa_grade){
                            if($update_grade == '1' && $search_employee_no != '' && $value->pa_grade_edit == '0'){
                                $value->pa_grade = $theo_grade;
                                DB::table('tb_employee_final_score')->where('id', $value->id )->update([
                                    'pa_grade' => $theo_grade,
                                    
                                ]);
                            }
                        }else{
                            $value->pa_grade = $theo_grade;
                            if($search_employee_no != "0"){
                                DB::table('tb_employee_final_score')->where('id', $value->id )->update([
                                    'pa_grade' => $theo_grade
                                ]);
                            }
                        }
                    }
                    
                    

                    
                    

                    // $value->adjust_grade = $theo_grade;
                    
                    
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                    if($value->status_evaluation == '0'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '1'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '3'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                    }
                    if($value->pa_grade == 'A'){
                        $grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'B'){
                        $grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'C'){
                        $grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'D'){
                        $grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'E'){
                        $grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0 pointer" onclick="set_edittheory_Modal_id('.$value->id.',\''.$value->pa_grade.'\');" data-bs-toggle="modal" data-bs-target="#theory_editModal">'.$value->pa_grade.'</h1>';
                    }else{
                        $grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }
                    // <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="set_editModal_id('.$value->id.',\''.$value->adjust_grade.'\');" data-bs-toggle="modal" data-bs-target="#editModal" '.$edit_pa_grading.'>
                    //                     <i class="ki-solid ki-pencil fs-5"></i>
                    //                 </button>
                    if($value->adjust_grade == 'A'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'B'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'C'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'D'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'E'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else{
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }

                    $edit_pa_grading = 'style="display:none;"';
                    if (Auth::user()->can('edit pa grading')) {
                        $edit_pa_grading = 'style="display:block;"';
                    }
                    // <button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$edit_pa_grading.'>
                    //     <i class="ki-solid ki-check-circle fs-5"></i>
                    // </button>
                    $data[] = array(
                        "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.','.$value->pa_grade.'" date-id="'.$value->employee_no.'" >',
                        "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                        "code"=> $value->employee_no,
                        "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                        "position"=> $value->position_description,
                        "div"=> $value->division_description,
                        "dept"=> $value->department_description,
                        "sect"=> $value->section_description,
                        "total_score"=> $value->total_score,
                        "pa_grade"=>$value->pa_grade,
                        "theoryG"=> $grade.'<input type="hidden" id="theoryG_'.$value->id.'" value="'.$value->pa_grade.'">',
                        "adjust_grade"=> $adjust_grade,
                        "status"=> $status_evaluation,
                        "action"=> '
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="set_editModal_id('.$value->id.',\''.$value->adjust_grade.'\');" data-bs-toggle="modal" data-bs-target="#editModal" '.$edit_pa_grading.'>
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>',
                        "checkA"=> $checkA,
                        "final_id"=> $value->id
                    );  
                }
            }
        }
        $search_year       = $request->input('search_year');
        $checkYearABC = $search_year;
        // $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
        ->whereNull('tb_employee_final_score.adjust_grade')
        ->where('tb_employee.employee_status_description','Passed')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 4 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }
        $result = [
            'data'            => $data,
            'data_total' =>$data_total,
            'check_calA' => $check_calA,
            'check_calB' => $check_calB,
            'check_calC' => $check_calC,
            'check_calD' => $check_calD,
            'check_calE' => $check_calE,
            // 'dataxxx' => $dataxxx,
            'xcheck_calA'=>$xcheck_calA,
            'xcheck_calB'=>$xcheck_calB,
            'xcheck_calC'=>$xcheck_calC,
            'xcheck_calD'=>$xcheck_calD,
            'xcheck_calE'=>$xcheck_calE,
            'dataraw'=>$dataraw,
            
            // 'nxxx'=>$nxxx,
            // 'age'=>$age
        ];
        echo json_encode($result); 

    }

    public function editModal_update(Request $request)
    {
        $id             = $request->input('id');
        $pa_grade         = $request->input('pa_grade');
        $adjust_grade         = $request->input('adjust_grade');
        DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
            'pa_grade' => $pa_grade,
            'adjust_grade' => $request->input('adjust_grade'),
            // 'status_evaluation' => '1'
        ]);
        
        $result = [
            'id'                => $id,
            'adjust_grade'      => $adjust_grade,
            // 'status_evaluation' => '1'
        ];
        echo json_encode($result); 
    }

    public function editModal_theoretical_update(Request $request)
    {
        $id             = $request->input('id');
        $pa_grade         = $request->input('pa_grade');
        DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
            'pa_grade' => $pa_grade,
            'pa_grade_edit' => '1'
        ]);
        $search_year       = $request->input('search_year');
        $checkYearABC = $search_year;
        // $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
        ->whereNull('tb_employee_final_score.adjust_grade')
        ->where('tb_employee.employee_status_description','Passed')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 4 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }
        $result = [
            'id'                => $id,
        ];
        echo json_encode($result); 
    }

    public function editModal_update_all(Request $request)
    {
        $id             = $request->input('id');
        $adjust_grade         = $request->input('adjust_grade');
        
        if(!empty($id)){
            foreach($id AS $val){
                DB::table('tb_employee_final_score')->where('id', $val['id'] )->update([
                    'pa_grade' => $val['grade'],
                    'adjust_grade' => $request->input('adjust_grade'),
                    // 'status_evaluation' => '1'
                ]);
            }
        }
        $result = [
            'id'                => $id,
            'adjust_grade'      => $adjust_grade,
            // 'status_evaluation' => '1'
        ];
        echo json_encode($result); 
    }

    public function bell_curve_detail(Request $request)
    {
        $search_division             = $request->input('search_division');
        $search_department             = $request->input('search_department');
        $search_section             = $request->input('search_section');
        $search_employee_no             = $request->input('search_employee_no');
        $search_status             = $request->input('search_status');
        $search_month_day      = $request->input('search_month_day');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }
        
        $countdata = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.adjust_grade')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','3')
        ->whereNotNull('tb_employee_final_score.pa_grade')
        ;

        if(isset($search_division)){
            if(count($search_division) > 0){
                $countdata->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $countdata->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $countdata->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $countdata->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all" && $search_employee_no != ""){
        //     $countdata = $countdata->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all" && $search_division != ""){
        //     $countdata = $countdata->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all" && $search_department != ""){
        //     $countdata = $countdata->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all" && $search_section != ""){
        //     $countdata = $countdata->where('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $countdata->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $countdata->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if($search_status != "0"){
        //     $countdata = $countdata->where('tb_employee_final_score.status_evaluation', $search_status);
        // }
        // $countdata = $countdata->get();
        $countdata = $countdata->get();

        $result = [
            'countdata'=>$countdata
        ];
        echo json_encode($result); 
    }

    public function adjustModal_update_all(Request $request)
    {
        $search_employee_no      = $request->input('search_employee_no');
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_status      = $request->input('search_status');
        $search_month_day      = $request->input('search_month_day');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
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
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','3');
        ;

        // if(isset($search_division)){
        //     if(count($search_division) > 0){
        //         $datarow->whereIn('tb_employee.division_code', $search_division);
        //     }
        // }
        // if(isset($search_department)){
        //     if(count($search_department) > 0){
        //         $datarow->whereIn('tb_employee.department_code', $search_department);
        //     }
        // }
        // if(isset($search_section)){
        //     if(count($search_section) > 0){
        //         $datarow->whereIn('tb_employee.section_code', $search_section);
        //     }
        // }
        if (!empty($search_division)) {
            $datarow->where(function ($query) use ($search_division) {
                foreach ($search_division as $division) {
                    $query->orWhereRaw("FIND_IN_SET(?, tb_employee.division_code)", [$division]);
                }
            });
        }
        
        // 🔹 ค้นหา department_code ด้วย FIND_IN_SET()
        if (!empty($search_department)) {
            $datarow->where(function ($query) use ($search_department) {
                foreach ($search_department as $department) {
                    $query->orWhereRaw("FIND_IN_SET(?, tb_employee.department_code)", [$department]);
                }
            });
        }
        
        // 🔹 ค้นหา search_section ด้วย FIND_IN_SET()
        if (!empty($search_section)) {
            $datarow->where(function ($query) use ($search_section) {
                foreach ($search_section as $section) {
                    $query->orWhereRaw("FIND_IN_SET(?, tb_employee.section_code)", [$section]);
                }
            });
        }
        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $datarow->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $datarow = $datarow->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all"){
        //     $datarow = $datarow->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all"){
        //     $datarow = $datarow->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all"){
        //     $datarow = $datarow->where('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_status != "0"){
            if($search_status == "1"){
                $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
            }
            if($search_status == "2"){
                $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                $datarow = $datarow->whereNull('tb_employee_final_score.adjust_grade');
            }
            if($search_status == "3"){
                $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                $datarow = $datarow->whereNotNull('tb_employee_final_score.adjust_grade');
            }
            
            // $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        }else{
            // $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
            // $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
        }
        // if($search_status != "0"){
        //     $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $datarow = $datarow->orderBy('tb_employee_final_score.total_score','DESC');

        $datarow = $datarow->get();
        // dd($datarow);
        //     exit;
        if(count($datarow) == 2){
            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->where('tb_grade_action.grade_name','!=','U')
            ->where('tb_grade_action.grade_name','!=','CD')
            ->orderBy('tb_grade_action.id', 'ASC')->get();
            $percentAR = 0;
            $percentP = 0;
            $percentA = 0;
            $percentB = 0;
            $percentC = 0;
            $percentD = 0;
            $percentE = 0;
            $countall = count($datarow);
            if($bell_curve){
                foreach ($bell_curve as $keyx => $valuex) {
                    if($valuex->grade_name == 'AR'){
                        $percentAR = $valuex->percent;
                    }
                    if($valuex->grade_name == 'P'){
                        $percentP = $valuex->percent;
                    }
                    if($valuex->grade_name == 'A'){
                        $percentA = $valuex->percent;
                    }
                    if($valuex->grade_name == 'B'){
                        $percentB = $valuex->percent;
                    }
                    if($valuex->grade_name == 'C'){
                        $percentC = $valuex->percent;
                    }
                    if($valuex->grade_name == 'D'){
                        $percentD = $valuex->percent;
                    }
                    if($valuex->grade_name == 'E'){
                        $percentE = $valuex->percent;
                    }
                }
            }
            $calAR = round(($countall*$percentAR)/100);
            $calP = round(($countall*$percentP)/100);
            $calA = round(($countall*$percentA)/100);
            if((($countall*$percentB)/100) > (($countall*$percentD)/100)){
                $calB = ceil(($countall*$percentB)/100);
            }else{
                $calB = round(($countall*$percentB)/100);
            }
            
            $calC = round(($countall*$percentC)/100);
            if((($countall*$percentB)/100) > (($countall*$percentD)/100)){
                $calD = floor(($countall*$percentD)/100);
            }else{
                $calD = round(($countall*$percentD)/100);
            }
            $calE = round(($countall*$percentE)/100);

            // dd($calB);
            // exit;
            $subcalAR = round(($countall*$percentAR)/100);
            $subcalP = round(($countall*$percentP)/100);
            $subcalA = round(($countall*$percentA)/100);
            $subcalB = round(($countall*$percentB)/100);
            $subcalC = round(($countall*$percentC)/100);
            $subcalD = round(($countall*$percentD)/100);
            $subcalE = round(($countall*$percentE)/100);
            

            $data = [];
            $data_total = [];
            $checkA = 0;
            $theo_grade1 = '';
            if($datarow){
                foreach ($datarow as $key => $value) {
                    
                    $theo_grade = '';
                    if($calAR > 0){
                        $theo_grade = 'AR';
                        $calAR -= 1;
                    }else if($calP > 0){
                        $theo_grade = 'P';
                        $calP -= 1;
                    }else if($calA > 0){
                        $theo_grade = 'A';
                        $calA -= 1;
                    }else if($calB > 0){
                        $theo_grade = 'B';
                        $calB -= 1;
                    }else if($calC > 0){
                        $theo_grade = 'C';
                        $calC -= 1;
                    }else if($calD > 0){
                        $theo_grade = 'D';
                        $calD -= 1;
                    }else{
                        $theo_grade = 'E';
                        $calE -= 1;
                    }
                    // $theo = round( $value->total_score ,2 )
                    
                    if($key == 0){
                        $theo_grade1 = $theo_grade;
                    }
                    if($key == 1){
                        if($theo_grade1 == "AR"){
                            $theo_grade = 'P';
                        }else if($theo_grade1 == "P"){
                            $theo_grade = 'A';
                        }else if($theo_grade1 == "A"){
                            $theo_grade = 'B';
                        }else if($theo_grade1 == "B"){
                            $theo_grade = 'C';
                        }else if($theo_grade1 == "C"){
                            $theo_grade = 'D';
                        }else if($theo_grade1 == "D"){
                            $theo_grade = 'E';
                        }
                    }
                    
                    // echo $theo_grade;
                    $value->pa_grade = $theo_grade;
                    $value->adjust_grade = $theo_grade;
                    
                    
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                    if($value->status_evaluation == '0'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '1'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '3'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                    }
                    if($value->pa_grade == 'A'){
                        $grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'B'){
                        $grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'C'){
                        $grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'D'){
                        $grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'E'){
                        $grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else{
                        $grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }
                    if($value->adjust_grade == 'A'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'B'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'C'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'D'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'E'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else{
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }

                    
                    $data[] = array(
                        "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.','.$value->pa_grade.'" date-id="'.$value->employee_no.'" >',
                        "evaluator"=> $value->evaluator_name_en,
                        "code"=> $value->employee_no,
                        "name"=> $value->employee_local_name_en,
                        "position"=> $value->position_description,
                        "div"=> $value->division_description,
                        "dept"=> $value->department_description,
                        "sect"=> $value->section_description,
                        "total_score"=> $value->total_score,
                        "pa_grade"=>$value->pa_grade,
                        "theoryG"=> $grade.'<input type="hidden" id="theoryG_'.$value->id.'" value="'.$value->pa_grade.'">',
                        "adjust_grade"=> $adjust_grade,
                        "status"=> $status_evaluation,
                        "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-5"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="set_editModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>',
                        "checkA"=> $checkA,
                        "final_id"=> $value->id
                    );  
                }
            }
        }else{
            $bell_curve = DB::table('tb_grade_action')
            ->select('tb_grade_action.*')
            ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
            ->where('tb_grade.year',$previousYear)
            ->where('tb_grade_action.grade_name','!=','U')
            ->where('tb_grade_action.grade_name','!=','CD')
            ->orderBy('tb_grade_action.id', 'ASC')->get();
            $percentAR = 0;
            $percentP = 0;
            $percentA = 0;
            $percentB = 0;
            $percentC = 0;
            $percentD = 0;
            $percentE = 0;
            $countall = count($datarow);
            if($bell_curve){
                foreach ($bell_curve as $keyx => $valuex) {
                    if($valuex->grade_name == 'AR'){
                        $percentAR = $valuex->percent;
                    }
                    if($valuex->grade_name == 'P'){
                        $percentP = $valuex->percent;
                    }
                    if($valuex->grade_name == 'A'){
                        $percentA = $valuex->percent;
                    }
                    if($valuex->grade_name == 'B'){
                        $percentB = $valuex->percent;
                    }
                    if($valuex->grade_name == 'C'){
                        $percentC = $valuex->percent;
                    }
                    if($valuex->grade_name == 'D'){
                        $percentD = $valuex->percent;
                    }
                    if($valuex->grade_name == 'E'){
                        $percentE = $valuex->percent;
                    }
                }
            }
            $calAR = round(($countall*$percentAR)/100);
            $calP = round(($countall*$percentP)/100);
            $calA = round(($countall*$percentA)/100);
            $calB = round(($countall*$percentB)/100);
            $calC = round(($countall*$percentC)/100);
            $calD = round(($countall*$percentD)/100);
            $calE = round(($countall*$percentE)/100);

            $subcalAR = round(($countall*$percentAR)/100);
            $subcalP = round(($countall*$percentP)/100);
            $subcalA = round(($countall*$percentA)/100);
            $subcalB = round(($countall*$percentB)/100);
            $subcalC = round(($countall*$percentC)/100);
            $subcalD = round(($countall*$percentD)/100);
            $subcalE = round(($countall*$percentE)/100);
            

            $data = [];
            $data_total = [];
            $checkA = 0;
            if($datarow){
                foreach ($datarow as $key => $value) {
                    
                    $theo_grade = '';
                    if($calAR > 0){
                        $theo_grade = 'AR';
                        $calAR -= 1;
                    }else if($calP > 0){
                        $theo_grade = 'P';
                        $calP -= 1;
                    }else if($calA > 0){
                        $theo_grade = 'A';
                        $calA -= 1;
                    }else if($calB > 0){
                        $theo_grade = 'B';
                        $calB -= 1;
                    }else if($calC > 0){
                        $theo_grade = 'C';
                        $calC -= 1;
                    }else if($calD > 0){
                        $theo_grade = 'D';
                        $calD -= 1;
                    }else{
                        $theo_grade = 'E';
                        $calE -= 1;
                    }
                    // $theo = round( $value->total_score ,2 )
                    $value->pa_grade = $theo_grade;

                    
                    

                    $value->adjust_grade = $theo_grade;
                    
                    
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                    if($value->status_evaluation == '0'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '1'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                    }else if($value->status_evaluation == '3'){
                        $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                    }
                    if($value->pa_grade == 'A'){
                        $grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'B'){
                        $grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'C'){
                        $grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'D'){
                        $grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else if($value->pa_grade == 'E'){
                        $grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                    }else{
                        $grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }
                    if($value->adjust_grade == 'A'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'B'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'C'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'D'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else if($value->adjust_grade == 'E'){
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                    }else{
                        $adjust_grade = '<h1 class="set_adjust_grade'.$value->id.' badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                    }

                    
                    $data[] = array(
                        "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.','.$value->pa_grade.'" date-id="'.$value->employee_no.'" >',
                        "evaluator"=> $value->evaluator_name_en,
                        "code"=> $value->employee_no,
                        "name"=> $value->employee_local_name_en,
                        "position"=> $value->position_description,
                        "div"=> $value->division_description,
                        "dept"=> $value->department_description,
                        "sect"=> $value->section_description,
                        "total_score"=> $value->total_score,
                        "pa_grade"=>$value->pa_grade,
                        "theoryG"=> $grade.'<input type="hidden" id="theoryG_'.$value->id.'" value="'.$value->pa_grade.'">',
                        "adjust_grade"=> $adjust_grade,
                        "status"=> $status_evaluation,
                        "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-5"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="set_editModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>',
                        "checkA"=> $checkA,
                        "final_id"=> $value->id
                    );  
                }
            }
            
            
        }

        // dd($data);
        // exit;
        // exit;
        $dataxxx = [];
        $datagroup = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.evaluator_no',
        'tb_employee_final_score.total_score'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','3');

        if (!empty($search_division)) {
            $datagroup->where(function ($query) use ($search_division) {
                foreach ($search_division as $division) {
                    $query->orWhereRaw("FIND_IN_SET(?, tb_employee.division_code)", [$division]);
                }
            });
        }
        
        // 🔹 ค้นหา department_code ด้วย FIND_IN_SET()
        if (!empty($search_department)) {
            $datagroup->where(function ($query) use ($search_department) {
                foreach ($search_department as $department) {
                    $query->orWhereRaw("FIND_IN_SET(?, tb_employee.department_code)", [$department]);
                }
            });
        }
        
        // 🔹 ค้นหา search_section ด้วย FIND_IN_SET()
        if (!empty($search_section)) {
            $datagroup->where(function ($query) use ($search_section) {
                foreach ($search_section as $section) {
                    $query->orWhereRaw("FIND_IN_SET(?, tb_employee.section_code)", [$section]);
                }
            });
        }
        // if(isset($search_division)){
        //     if(count($search_division) > 0){
        //         $datagroup->whereIn('tb_employee.division_code', $search_division);
        //     }
        // }
        // if(isset($search_department)){
        //     if(count($search_department) > 0){
        //         $datagroup->whereIn('tb_employee.department_code', $search_department);
        //     }
        // }
        // if(isset($search_section)){
        //     if(count($search_section) > 0){
        //         $datagroup->whereIn('tb_employee.section_code', $search_section);
        //     }
        // }
        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $datagroup->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $datagroup = $datagroup->where('tb_employee_final_score.evaluator_no',$search_employee_no);
        // }
        // if($search_division != "all"){
        //     $datagroup = $datagroup->where('tb_employee.division_code',$search_division);
        // }
        // if($search_department != "all"){
        //     $datagroup = $datagroup->where('tb_employee.department_code',$search_department);
        // }
        // if($search_section != "all"){
        //     $datagroup = $datagroup->where('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $datagroup->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $datagroup->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_status != "0"){
            if($search_status == "1"){
                $datagroup = $datagroup->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datagroup = $datagroup->where('tb_employee_final_score.status_evaluation','3');
            }
            if($search_status == "2"){
                $datagroup = $datagroup->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datagroup = $datagroup->where('tb_employee_final_score.status_evaluation','3');
                $datagroup = $datagroup->whereNull('tb_employee_final_score.adjust_grade');
            }
            if($search_status == "3"){
                $datagroup = $datagroup->where('tb_employee_final_score.freeze_to_pagrade','1');
                $datagroup = $datagroup->where('tb_employee_final_score.status_evaluation','3');
                $datagroup = $datagroup->whereNotNull('tb_employee_final_score.adjust_grade');
            }
            
            // $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        }else{
            // $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
            // $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
        }
        // if($search_status != "0"){
        //     $datagroup = $datagroup->where('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $datagroup = $datagroup->groupBy('total_score');
        $datagroup = $datagroup->orderBy('tb_employee_final_score.total_score','DESC');
        $datagroup = $datagroup->get();

        // dd($datagroup);
        // exit;

        if($datagroup){
            foreach ($datagroup as $key => $value) {
                $datagroupxxx = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.evaluator_no',
                'tb_employee_final_score.pa_grade',
                'tb_employee_final_score.total_score'
                )
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                ->where('tb_employee_final_score.evaluator_no',$value->evaluator_no)
                ->where('tb_employee_final_score.total_score',$value->total_score)
                ->where('tb_employee.employee_status_description','Passed')
                ->where('tb_employee_final_score.freeze_to_pagrade','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation','3');
                
                if (!empty($search_division)) {
                    $datagroupxxx->where(function ($query) use ($search_division) {
                        foreach ($search_division as $division) {
                            $query->orWhereRaw("FIND_IN_SET(?, tb_employee.division_code)", [$division]);
                        }
                    });
                }
                
                // 🔹 ค้นหา department_code ด้วย FIND_IN_SET()
                if (!empty($search_department)) {
                    $datagroupxxx->where(function ($query) use ($search_department) {
                        foreach ($search_department as $department) {
                            $query->orWhereRaw("FIND_IN_SET(?, tb_employee.department_code)", [$department]);
                        }
                    });
                }
                
                // 🔹 ค้นหา search_section ด้วย FIND_IN_SET()
                if (!empty($search_section)) {
                    $datagroupxxx->where(function ($query) use ($search_section) {
                        foreach ($search_section as $section) {
                            $query->orWhereRaw("FIND_IN_SET(?, tb_employee.section_code)", [$section]);
                        }
                    });
                }
                // if(isset($search_division)){
                //     if(count($search_division) > 0){
                //         $datagroupxxx->whereIn('tb_employee.division_code', $search_division);
                //     }
                // }
                // if(isset($search_department)){
                //     if(count($search_department) > 0){
                //         $datagroupxxx->whereIn('tb_employee.department_code', $search_department);
                //     }
                // }
                // if(isset($search_section)){
                //     if(count($search_section) > 0){
                //         $datagroupxxx->whereIn('tb_employee.section_code', $search_section);
                //     }
                // }
                if($search_employee_no){
                    if(count($search_employee_no) > 0){
                        $datagroupxxx->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                    }
                }
                // if($search_employee_no != "all"){
                //     $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.evaluator_no',$search_employee_no);
                // }
                // if($search_division != "all"){
                //     $datagroupxxx = $datagroupxxx->where('tb_employee.division_code',$search_division);
                // }
                // if($search_department != "all"){
                //     $datagroupxxx = $datagroupxxx->where('tb_employee.department_code',$search_department);
                // }
                // if($search_section != "all"){
                //     $datagroupxxx = $datagroupxxx->where('tb_employee.section_code', $search_section);
                // }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $datagroupxxx->where('tb_employee_final_score.salary_type','Daily');
                    }
                    if($search_month_day == "2"){
                        $datagroupxxx->where('tb_employee_final_score.salary_type','Monthly');
                    }
                }
                if($search_status != "0"){
                    if($search_status == "1"){
                        $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.freeze_to_pagrade','1');
                        $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.status_evaluation','3');
                    }
                    if($search_status == "2"){
                        $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.freeze_to_pagrade','1');
                        $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.status_evaluation','3');
                        $datagroupxxx = $datagroupxxx->whereNull('tb_employee_final_score.adjust_grade');
                    }
                    if($search_status == "3"){
                        $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.freeze_to_pagrade','1');
                        $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.status_evaluation','3');
                        $datagroupxxx = $datagroupxxx->whereNotNull('tb_employee_final_score.adjust_grade');
                    }
                    
                    // $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
                }else{
                    // $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                    // $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                }
                // if($search_status != "0"){
                //     $datagroupxxx = $datagroupxxx->where('tb_employee_final_score.status_evaluation', $search_status);
                // }
                $datagroupxxx = $datagroupxxx->groupBy('pa_grade');
                $datagroupxxx = $datagroupxxx->orderBy('tb_employee_final_score.total_score','DESC');
                $datagroupxxx = $datagroupxxx->get();

                // echo "<pre>";
                // print_r($datagroupxxx);
                // echo "<br>";
                // dd($datagroupxxx);
                // exit;


                if($datagroupxxx){
                    foreach ($datagroupxxx as $keyx => $valuex) {
                        if($valuex->pa_grade){
                            $datagroupzzzz = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.evaluator_no',
                            'tb_employee_final_score.pa_grade'
                            )
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            ->where('tb_employee_final_score.evaluator_no',$value->evaluator_no)
                            ->where('tb_employee_final_score.total_score',$value->total_score)
                            ->where('tb_employee_final_score.pa_grade',$valuex->pa_grade)
                            ->where('tb_employee.employee_status_description','Passed')
                            ->where('tb_employee_final_score.freeze_to_pagrade','1')
                            ->whereNot('tb_employee.grade_code','L810')
                            ->whereNot('tb_employee.grade_code','L820')
                            ->where('tb_employee_final_score.status_evaluation','3');
                    
                            if (!empty($search_division)) {
                                $datagroupzzzz->where(function ($query) use ($search_division) {
                                    foreach ($search_division as $division) {
                                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee.division_code)", [$division]);
                                    }
                                });
                            }
                            
                            // 🔹 ค้นหา department_code ด้วย FIND_IN_SET()
                            if (!empty($search_department)) {
                                $datagroupzzzz->where(function ($query) use ($search_department) {
                                    foreach ($search_department as $department) {
                                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee.department_code)", [$department]);
                                    }
                                });
                            }
                            
                            // 🔹 ค้นหา search_section ด้วย FIND_IN_SET()
                            if (!empty($search_section)) {
                                $datagroupzzzz->where(function ($query) use ($search_section) {
                                    foreach ($search_section as $section) {
                                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee.section_code)", [$section]);
                                    }
                                });
                            }
                            // if(isset($search_division)){
                            //     if(count($search_division) > 0){
                            //         $datagroupzzzz->whereIn('tb_employee.division_code', $search_division);
                            //     }
                            // }
                            // if(isset($search_department)){
                            //     if(count($search_department) > 0){
                            //         $datagroupzzzz->whereIn('tb_employee.department_code', $search_department);
                            //     }
                            // }
                            // if(isset($search_section)){
                            //     if(count($search_section) > 0){
                            //         $datagroupzzzz->whereIn('tb_employee.section_code', $search_section);
                            //     }
                            // }
                            if($search_employee_no){
                                if(count($search_employee_no) > 0){
                                    $datagroupzzzz->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                                }
                            }
                            // if($search_employee_no != "all"){
                            //     $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.evaluator_no',$search_employee_no);
                            // }
                            // if($search_division != "all"){
                            //     $datagroupzzzz = $datagroupzzzz->where('tb_employee.division_code',$search_division);
                            // }
                            // if($search_department != "all"){
                            //     $datagroupzzzz = $datagroupzzzz->where('tb_employee.department_code',$search_department);
                            // }
                            // if($search_section != "all"){
                            //     $datagroupzzzz = $datagroupzzzz->where('tb_employee.section_code', $search_section);
                            // }
                            if($search_month_day != "all"){
                                if($search_month_day == "1"){
                                    $datagroupzzzz->where('tb_employee_final_score.salary_type','Daily');
                                }
                                if($search_month_day == "2"){
                                    $datagroupzzzz->where('tb_employee_final_score.salary_type','Monthly');
                                }
                            }
                            if($search_status != "0"){
                                if($search_status == "1"){
                                    $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.freeze_to_pagrade','1');
                                    $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.status_evaluation','3');
                                }
                                if($search_status == "2"){
                                    $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.freeze_to_pagrade','1');
                                    $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.status_evaluation','3');
                                    $datagroupzzzz = $datagroupzzzz->whereNull('tb_employee_final_score.adjust_grade');
                                }
                                if($search_status == "3"){
                                    $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.freeze_to_pagrade','1');
                                    $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.status_evaluation','3');
                                    $datagroupzzzz = $datagroupzzzz->whereNotNull('tb_employee_final_score.adjust_grade');
                                }
                                
                                // $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
                            }else{
                                // $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                                // $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                            }
                            // if($search_status != "0"){
                            //     $datagroupzzzz = $datagroupzzzz->where('tb_employee_final_score.status_evaluation', $search_status);
                            // }
                            $datagroupzzzz = $datagroupzzzz->groupBy('pa_grade');
                            $datagroupzzzz = $datagroupzzzz->orderBy('tb_employee_final_score.total_score','DESC');
                            $datagroupzzzz = $datagroupzzzz->count();

                            // echo "<pre>";
                            // print_r($datagroupzzzz);
                            // echo "<br>";

                            $datagroupxxxcount = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.evaluator_no',
                            'tb_employee_final_score.pa_grade'
                            )
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                            ->where('tb_employee_final_score.evaluator_no',$value->evaluator_no)
                            ->where('tb_employee_final_score.total_score',$valuex->total_score)
                            ->where('tb_employee.employee_status_description','Passed')
                            ->where('tb_employee_final_score.freeze_to_pagrade','1')
                            ->whereNot('tb_employee.grade_code','L810')
                            ->whereNot('tb_employee.grade_code','L820')
                            ->where('tb_employee_final_score.status_evaluation','3');
                    
                            if (!empty($search_division)) {
                                $datagroupxxxcount->where(function ($query) use ($search_division) {
                                    foreach ($search_division as $division) {
                                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee.division_code)", [$division]);
                                    }
                                });
                            }
                            
                            // 🔹 ค้นหา department_code ด้วย FIND_IN_SET()
                            if (!empty($search_department)) {
                                $datagroupxxxcount->where(function ($query) use ($search_department) {
                                    foreach ($search_department as $department) {
                                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee.department_code)", [$department]);
                                    }
                                });
                            }
                            
                            // 🔹 ค้นหา search_section ด้วย FIND_IN_SET()
                            if (!empty($search_section)) {
                                $datagroupxxxcount->where(function ($query) use ($search_section) {
                                    foreach ($search_section as $section) {
                                        $query->orWhereRaw("FIND_IN_SET(?, tb_employee.section_code)", [$section]);
                                    }
                                });
                            }
                            // if(isset($search_division)){
                            //     if(count($search_division) > 0){
                            //         $datagroupxxxcount->whereIn('tb_employee.division_code', $search_division);
                            //     }
                            // }
                            // if(isset($search_department)){
                            //     if(count($search_department) > 0){
                            //         $datagroupxxxcount->whereIn('tb_employee.department_code', $search_department);
                            //     }
                            // }
                            // if(isset($search_section)){
                            //     if(count($search_section) > 0){
                            //         $datagroupxxxcount->whereIn('tb_employee.section_code', $search_section);
                            //     }
                            // }
                            if($search_employee_no){
                                if(count($search_employee_no) > 0){
                                    $datagroupxxxcount->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                                }
                            }
                            // if($search_employee_no != "all"){
                            //     $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.evaluator_no',$search_employee_no);
                            // }
                            // if($search_division != "all"){
                            //     $datagroupxxxcount = $datagroupxxxcount->where('tb_employee.division_code',$search_division);
                            // }
                            // if($search_department != "all"){
                            //     $datagroupxxxcount = $datagroupxxxcount->where('tb_employee.department_code',$search_department);
                            // }
                            // if($search_section != "all"){
                            //     $datagroupxxxcount = $datagroupxxxcount->where('tb_employee.section_code', $search_section);
                            // }
                            if($search_month_day != "all"){
                                if($search_month_day == "1"){
                                    $datagroupxxxcount->where('tb_employee_final_score.salary_type','Daily');
                                }
                                if($search_month_day == "2"){
                                    $datagroupxxxcount->where('tb_employee_final_score.salary_type','Monthly');
                                }
                            }
                            if($search_status != "0"){
                                if($search_status == "1"){
                                    $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.freeze_to_pagrade','1');
                                    $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.status_evaluation','3');
                                }
                                if($search_status == "2"){
                                    $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.freeze_to_pagrade','1');
                                    $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.status_evaluation','3');
                                    $datagroupxxxcount = $datagroupxxxcount->whereNull('tb_employee_final_score.adjust_grade');
                                }
                                if($search_status == "3"){
                                    $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.freeze_to_pagrade','1');
                                    $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.status_evaluation','3');
                                    $datagroupxxxcount = $datagroupxxxcount->whereNotNull('tb_employee_final_score.adjust_grade');
                                }
                                
                                // $datarow = $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
                            }else{
                                // $datarow = $datarow->where('tb_employee_final_score.freeze_to_pagrade','1');
                                // $datarow = $datarow->where('tb_employee_final_score.status_evaluation','3');
                            }
                            // if($search_status != "0"){
                            //     $datagroupxxxcount = $datagroupxxxcount->where('tb_employee_final_score.status_evaluation', $search_status);
                            // }
                            $datagroupxxxcount = $datagroupxxxcount->groupBy('pa_grade');
                            $datagroupxxxcount = $datagroupxxxcount->orderBy('tb_employee_final_score.total_score','DESC');
                            $datagroupxxxcount = $datagroupxxxcount->get();
                            
                            // echo "<pre>";
                            // print_r($datagroupzzzz);
                            // echo "<br>";

                            $dataxxx[] = array(
                                "Score"=> $value->total_score,
                                "TheoreticalLevel"=>$valuex->pa_grade,
                                "Total"=>$datagroupzzzz,
                                "count"=>count($datagroupxxxcount)
                            );  
                        }
                    }
                }
                
            }
        }
        
        // dd($dataxxx);
        // exit;

        $xScore = '';
        foreach ($dataxxx as $key => $value) {
            if($dataxxx[$key]['count'] == 1){
                $dataxxx[$key]['status'] = 'ok';
                $dataxxx[$key]['new'] = $dataxxx[$key]['TheoreticalLevel'];
            }else{
                $dataxxx[$key]['status'] = 'chk';
            }
            if($dataxxx[$key]['status'] == 'chk'){
                $xScorex = 0;
                foreach ($dataxxx as $keyxx => $valuexx) {
                    if($dataxxx[$keyxx]['Score'] == $dataxxx[$key]['Score']){
                        if($xScorex < $dataxxx[$keyxx]['Total']){
                            $xScorex = $dataxxx[$keyxx]['Total'];
                            $dataxxx[$key]['new'] = $dataxxx[$keyxx]['TheoreticalLevel'];
                        }
                    }
                }
            }
            if($value['TheoreticalLevel'] == 'A'){
                $dataxxx[$key]['Grade'] = $subcalA;
            }
            if($value['TheoreticalLevel'] == 'B'){
                $dataxxx[$key]['Grade'] = $subcalB;
            }
            if($value['TheoreticalLevel'] == 'C'){
                $dataxxx[$key]['Grade'] = $subcalC;
            }
            if($value['TheoreticalLevel'] == 'D'){
                $dataxxx[$key]['Grade'] = $subcalD;
            }
            if($value['TheoreticalLevel'] == 'E'){
                $dataxxx[$key]['Grade'] = $subcalE;
            }
        }
        // dd($dataxxx);
        // exit;
        foreach ($data as $key => $value) {
            if($value['total_score']){
                foreach ($dataxxx as $keyxx => $valuexx) {
                    if($valuexx['Score'] == $value['total_score']){
                        if($search_employee_no != "0"){
                            DB::table('tb_employee_final_score')->where('id', $value['final_id'] )->update([
                                'adjust_grade' => $valuexx['new']
                            ]);
                        }
                    }
                }
            }
        }
        // dd($datarow);
        // exit;
        $search_year       = $request->input('search_year');
        $checkYearABC = $search_year;
        // $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
        ->whereNull('tb_employee_final_score.adjust_grade')
        ->where('tb_employee.employee_status_description','Passed')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 4 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }
        
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result); 
    }
}
