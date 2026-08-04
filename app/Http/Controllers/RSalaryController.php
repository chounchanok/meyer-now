<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class RSalaryController extends Controller
{
    public function index()
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $bell_curve = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->orderBy('tb_grade_action.id', 'ASC')->get();

        $budget = DB::table('tb_budget_action')
        ->select('tb_budget_action.*')
        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
        ->where('tb_budget.year',$previousYear)
        ->orderBy('tb_budget_action.id', 'ASC')->get();

        $percent_department = DB::table('tb_percent_department_action')
        ->select('tb_percent_department_action.*')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year',$previousYear)
        ->orderBy('tb_percent_department_action.id', 'ASC')->get();
        
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $data_all = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data_reject = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '2')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data_finish = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '1')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();
        
        if($orisoft_code == '000060' || $orisoft_code == '019492' || $orisoft_code == '000026' || $orisoft_code == '000002'){
            $position = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.position_code',
            'tb_employee.position_description',
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no');
            // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();
        }else{
            $position = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.position_code',
            'tb_employee.position_description',
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            $position = $position->groupBy('tb_employee.position_code')->orderBy('position_code', 'ASC')->get();
        }
        

        $positionx = DB::table('tb_position')->where('position_code','>','114');
        $positionx = $positionx->groupBy('tb_position.position_code')->orderBy('position_code', 'ASC')->get();

        $position_jd = DB::table('tb_position')->where('position_code','!=','114');
        $position_jd = $position_jd->groupBy('tb_position.position_code')->orderBy('position_code', 'ASC')->get();

        $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();

        $search_year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
        
        $grade_code = DB::table('tb_grade_code')->orderBy('id', 'ASC')->get();

        return view('pages.salaryReview.index', [
            "position" => $positionx,
            "position_jd" => $position_jd,
            "division" => $division,
            "grade_code" => $grade_code,
            // "department" => $department,
            // "section" => $section,
            "bell_curve" => $bell_curve,
            "budget" => $budget,
            "percent_department" => $percent_department,
            "data_all" => $data_all,
            // "data_in" => $data_in,
            "data_reject" => $data_reject,
            "data_finish" => $data_finish,
            "search_year" => $search_year,
        ]);
    }
    public function table_rsalary_getdata_old(Request $request)
    {
        for ($i=1; $i < 11; $i++) { 
            $data[] = array(
                "id" =>  '<input type="checkbox">',
                "code"=> "123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>",
                "name"=> "จันทรัตว์ ชัยชนา",
                "position"=> "skilled operator",
                "group"=> "Full year",
                "joindate"=> "7/23/2007",
                "serviced"=> "365",
                "sl"=> "2",
                "pl"=> "0",
                "latet"=> "0",
                "lated"=> "-",
                "abst"=> "0",
                "absd"=> "0",
                "ol"=> "0",
                "totald"=> "2.0",
                "verbal"=> "0",
                "written"=> "0",
                "susd"=> "0",
                "pa2020"=> "<h1 class='badge gradeP w-100 text-center fs-3 d-block py-2 mb-0'>P</h1>",
                "pa2021"=> "<h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>",
                "pa2022"=> "<h1 class='badge gradeB w-100 text-center fs-3 d-block py-2 mb-0'>B</h1>",
                "form"=> "F2",
                "evaluator"=> "xxxxxx xxxxxxxxxx",
                "total"=> "93.0",
                "theoryg"=> "<h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>",
                "adjustg"=> "<h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>",
                "current"=> "15,070.00",
                "l800avg"=> "-",
                "bsalaryw"=> "15,070.00",
                "cbsalaryw"=> "15,070.00",
                "comsugpct"=> "6.00%",
                "comsugamt"=> "904.20",
                "companynewb"=> "15,907.00",
                "gmgr"=> "<select class='form-select form-select-sm selectG gradeC' style='width:80px' onchange='change_class(this,".$i.");'>
                            <option class='' value='AR'>AR</option>
                            <option class='gradeP' value='P'>P</option>
                            <option class='gradeA' value='A'>A</option>
                            <option class='gradeB' value='B'>B</option>
                            <option class='gradeC' value='C' selected>C</option>
                            <option class='gradeD' value='D'>D</option>
                            <option class='gradeE' value='E'>E</option>
                            <option class='' value='U'>U</option>
                            <option class='' value='CD'>CD</option>
                        </select>
                        <span class='small fw-bold'>C &#62; <span class='changecolor".$i."'>C</span></span>",
                "incpctmgr"=> "<input type='text' class='form-control form-control-sm bg-light-warning' value='3.00'>
                                <span class='small fw-bold'>6.00% &#62; <span class='text-primary'>3.00%</span></span>",
                "incamount"=> "452.10",
                "newbwage"=> "15,520.00",
                "newbsalary"=> "<span class='text-primary fw-bold'>15520.00</span>",
                "finaldmgm"=> "<span class='text-success fw-bold'>15520.00</span>",
                "remark"=> "<input type='text' class='form-control form-control-sm' style='width:250px'>",
                "status"=> "Reject", 
                "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-danger btn-xs' data-bs-toggle='modal' data-bs-target='#rejectModal'><i class='ki-solid ki-cross-circle fs-5'></i></button>",
            );  
        }
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result); 

    }

    public function table_rsalary_getdata(Request $request)
    {
        function change_date($date){
            if($date){
                $cut = explode(' ',$date);
                $date = $cut[0];
            }
            return $date;
        }
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
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.position_description',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee.grade_code',
        'tb_employee.date_joined',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        $count_data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        if(@$like['searchText'] != ""){
            $searchText = @$like['searchText'];
            $gatall->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
            });
            $count_data->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
            });
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
        }

        if($like['search_month_day'] != "all"){
            if($like['search_month_day'] == "1"){
                $gatall->where('tb_employee_final_score.salary_type','Daily');
                $count_data->where('tb_employee_final_score.salary_type','Daily');
            }
            if($like['search_month_day'] == "2"){
                $gatall->where('tb_employee_final_score.salary_type','Monthly');
                $count_data->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($like['search_grade'] != "all"){
            $gatall->where('tb_employee.grade_proposed', 'like','%'.$like['search_grade'].'%');
            $count_data->where('tb_employee.grade_proposed', 'like','%'.$like['search_grade'].'%');
        }
        if($like['search_status'] != "all"){
            $gatall->where('tb_employee_final_score.status_salary', '=',$like['search_status']);
            $count_data->where('tb_employee_final_score.status_salary', '=',$like['search_status']);
        }

        if(!empty($search)){
            $gatall->where(function ($query) use($search) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
            });

            $count_data->where(function ($query) use($search) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
            });
        }

        if(empty($field)){
            $fieldby = 'tb_employee_final_score.employee_no';
        }
        else{
            if($field == 1){
                $fieldby = 'tb_employee_final_score.employee_no';
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

        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                $status_salary = '<span class="set_status'.$value->id.' badge" style="height: 34px;"></span>';
                if($value->status_salary == '0'){
                    $status_salary = '<span class="set_status'.$value->id.' badge badge-light" style="height: 34px;">In progress</span>';
                }
                if($value->status_salary == '2'){
                    $status_salary = '<span class="set_status'.$value->id.' badge bg-danger text-light" style="height: 34px;">Reject</span>';
                }
                if($value->status_salary == '1'){
                    $status_salary = '<span class="set_status'.$value->id.' badge bg-success text-light" style="height: 34px;">Approved</span>';
                }
                // "pa2020"=> "<h1 class='badge gradeP w-100 text-center fs-3 d-block py-2 mb-0'>P</h1>",
                // "pa2021"=> "<h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>",
                // "pa2022"=> "<h1 class='badge gradeB w-100 text-center fs-3 d-block py-2 mb-0'>B</h1>",
                if($value->pa_grade == "P"){
                    $pa_grade = '<h1 class="badge gradeP w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }else if($value->pa_grade == "A"){
                    $pa_grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }else if($value->pa_grade == "B"){
                    $pa_grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }else if($value->pa_grade == "C"){
                    $pa_grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }else if($value->pa_grade == "D"){
                    $pa_grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }else if($value->pa_grade == "E"){
                    $pa_grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }else{
                    $pa_grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0">'.$value->pa_grade.'</h1>';
                }
                $class_gmgr = '';

                if($value->adjust_grade == "P"){
                    $adjustg = '<h1 class="badge gradeP w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                }else if($value->adjust_grade == "A"){
                    $adjustg = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                }else if($value->adjust_grade == "B"){
                    $adjustg = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                }else if($value->adjust_grade == "C"){
                    $adjustg = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                }else if($value->adjust_grade == "D"){
                    $adjustg = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                }else if($value->adjust_grade == "E"){
                    $adjustg = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'.$value->adjust_grade.'</h1>';
                }else{
                    $adjustg = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0">'.$value->grade_proposed.'</h1>';
                }
                
                if($value->grade_proposed == "P"){
                    $class_gmgr = 'gradeP';
                }else if($value->grade_proposed == "A"){
                    $class_gmgr = 'gradeA';
                }else if($value->grade_proposed == "B"){
                    $class_gmgr = 'gradeB';
                }else if($value->grade_proposed == "C"){
                    $class_gmgr = 'gradeC';
                }else if($value->grade_proposed == "D"){
                    $class_gmgr = 'gradeD';
                }else if($value->grade_proposed == "E"){
                    $class_gmgr = 'gradeE';
                }else{
                    if(!$value->grade_proposed){
                        if($value->adjust_grade == "P"){
                            $class_gmgr = 'gradeP';
                        }else if($value->adjust_grade == "A"){
                            $class_gmgr = 'gradeA';
                        }else if($value->adjust_grade == "B"){
                            $class_gmgr = 'gradeB';
                        }else if($value->adjust_grade == "C"){
                            $class_gmgr = 'gradeC';
                        }else if($value->adjust_grade == "D"){
                            $class_gmgr = 'gradeD';
                        }else if($value->adjust_grade == "E"){
                            $class_gmgr = 'gradeE';
                        }else{
                            $class_gmgr = '';
                        }
                    }else{
                        $class_gmgr = '';
                    }
                }
                $total_day = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                if($like['search_month_day'] != "all"){
                    if($like['search_month_day'] == "1"){
                        $current = $value->salary_old;
                    }else{
                        $current = $value->salary_month_old;
                    }
                }
                if($like['search_month_day'] != "all"){
                    if(@$like['search_month_day'] == "2"){
                        if($value->bsalary_wage){
                            $bsalary_wage = $value->bsalary_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }
                }
                if($value->l800avg_wage != ""){
                    $l800avg_wage = $value->l800avg_wage;
                }else{
                    $l800avg_wage = '-';
                }
                if($like['search_month_day'] != "all"){
                    if(@$like['search_month_day'] == "1"){
                        if($value->l800avg_wage != ""){
                            $bsalary_wage = $value->bsalary_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }
                }
                $salary_month_old = $value->salary_month_old;
                if($value->grade_code == 'L800'){
                    $salary_month_old = (float)$bsalary_wage*26;
                }
                
                // if(date('Y-m') <= (date('Y').'-2')){
                //     $previousYear = date('Y', strtotime('-1 year'));
                // }else{
                    $previousYear = date('Y');
                // }
                $company_suggested_per = $value->company_suggested_per;
                $percent_proposed_old = $value->percent_proposed_old;
                $countbudget = DB::table('tb_budget_action')
                            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                            ->where('tb_budget.year',$previousYear)->count();
                if($countbudget > 0){
                    if($value->adjust_grade){
                        $databudget = DB::table('tb_budget_action')
                        ->select('tb_budget_action.std')
                        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        ->where('tb_budget_action.grade_name',$value->adjust_grade)
                        ->where('tb_budget.year',$previousYear)->first();
                        $company_suggested_per = $databudget->std;
                        $percent_proposed_old = $databudget->std;
                    }
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }else{
                    $service_days1 = $value->service_days/365;
                }
                
                $service_days2 = $service_days1;
                $company_suggestged_amount = $bsalary_wage*($company_suggested_per/100)*$service_days2;
                $company_suggestged_new_basic = $value->company_suggestged_new_basic;
                if($value->grade_code == 'L800'){
                    $company_suggestged_new_basic = $company_suggestged_amount+$current;
                }else{
                    $company_suggestged_new_basic = $company_suggestged_amount+$bsalary_wage;
                }
                $amount_proposed = $value->amount_proposed;
                if($bsalary_wage > 0){
                    if($value->percent_proposed >= 0){
                        $amount_proposed = $bsalary_wage*($value->percent_proposed/100)*$service_days2;
                    }else{
                        $amount_proposed = $bsalary_wage*($percent_proposed_old/100)*$service_days2;
                    }
                }
                // $salary_new = $value->salary_new;
                // if($salary_new == "" || $salary_new == NULL){
                //     $salary_new = $amount_proposed+$current;
                // }
                $salary_new = $amount_proposed+$current;
                $salary_month_new = ($value->salary_month_new?$value->salary_month_new:0);
                if($salary_new > 0){
                    if($like['search_month_day'] != "all"){
                        if(@$like['search_month_day'] == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx = $salary_new*27.5;
                                $salary_month_new = round($salary_month_newx,-1);
                            }else{
                                $salary_month_new = round($salary_new)*26;
                            }
                            // $salary_month_new = $salary_new*26;
                        }else{
                            $salary_month_new = $salary_new;
                        }
                    }
                }

                DB::table('tb_employee_final_score')->where('id',$value->id)
                ->update([
                    "company_suggested_per" => $company_suggested_per,
                    "company_suggestged_amount" => $company_suggestged_amount,
                    "company_suggestged_new_basic" => $company_suggestged_new_basic
                ]);
                
                $date_formatted = '';
                if($value->date_joined){
                    $date_joined_old = $value->date_joined;
                    $date_formatted = date("j M Y", strtotime($date_joined_old));
                }

                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->orisoft_no.'" id="checkbox-'.$value->orisoft_no.'" value="'.$value->id.'" data-id="'.$value->id.'">',
                    "code"=> $value->orisoft_no.' 
                                <button type="button" class="btn btn-icon btn-light btn-xs me-1" id="infoModal" onclick="set_info('.$value->id.');">
                                    <i class="ki-outline ki-information-2 fs-5"></i>
                                </button>',
                    "name"=> $value->employee_local_name_en,
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> '0.0',
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> '0.0',
                    "totald"=> ($total_day>0?number_format($total_day,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa2020"=> "",
                    "pa2021"=> "",
                    "pa2022"=> "",
                    "form"=> $value->form_import,
                    "evaluator"=> $value->evaluator_name_en,
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade,
                    "adjustg"=> $adjustg,
                    "current"=> ($current>0?number_format($current,2):'').'<input type="hidden" class="salary_old" name="salary_old[]" value="'.$current.'">',
                    "l800avg"=> ($value->l800avg_wage>0?number_format($value->l800avg_wage,2):''),
                    "bsalaryw"=> ($bsalary_wage>0?number_format($bsalary_wage,2):''),
                    "cbsalaryw"=> ($salary_month_old>0?number_format($salary_month_old,2):'').'<input type="hidden" class="salary_month_old" name="salary_month_old[]" value="'.$salary_month_old.'">',
                    "comsugpct"=> ($company_suggested_per>0?number_format($company_suggested_per,2):0.00).'%',
                    "comsugamt"=> ($company_suggestged_amount>0?number_format($company_suggestged_amount,2):0.00),
                    "companynewb"=> ($company_suggestged_new_basic>0?number_format($company_suggestged_new_basic,2):0.00),
                    "gmgr"=> '<select class="form-select form-select-sm selectG '.$class_gmgr.'" id="id_gmgr'.$value->id.'" style="width:80px" onchange="change_class(this,'.$key.','.$value->id.');">
                                <option class="" value="AR" '.($value->grade_proposed?($value->grade_proposed=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':'')).'>AR</option>
                                <option class="gradeP" value="P" '.($value->grade_proposed?($value->grade_proposed=='P'?'selected':''):($value->adjust_grade=='P'?'selected':'')).'>P</option>
                                <option class="gradeA" value="A" '.($value->grade_proposed?($value->grade_proposed=='A'?'selected':''):($value->adjust_grade=='A'?'selected':'')).'>A</option>
                                <option class="gradeB" value="B" '.($value->grade_proposed?($value->grade_proposed=='B'?'selected':''):($value->adjust_grade=='B'?'selected':'')).'>B</option>
                                <option class="gradeC" value="C" '.($value->grade_proposed?($value->grade_proposed=='C'?'selected':''):($value->adjust_grade=='C'?'selected':'')).'>C</option>
                                <option class="gradeD" value="D" '.($value->grade_proposed?($value->grade_proposed=='D'?'selected':''):($value->adjust_grade=='D'?'selected':'')).'>D</option>
                                <option class="gradeE" value="E" '.($value->grade_proposed?($value->grade_proposed=='E'?'selected':''):($value->adjust_grade=='E'?'selected':'')).'>E</option>
                                <option class="" value="U" '.($value->grade_proposed?($value->grade_proposed=='U'?'selected':''):($value->adjust_grade=='U'?'selected':'')).'>U</option>
                                <option class="" value="CD" '.($value->grade_proposed?($value->grade_proposed=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':'')).'>CD</option>
                            </select>
                            <span class="small fw-bold grade_proposed_old'.$value->id.'">
                                '.($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade).' &#62; 
                            </span>
                            <span class="small fw-bold changecolor'.$value->id.'">
                                '.($value->grade_proposed?$value->grade_proposed:$value->adjust_grade).'
                            </span>',
                    "incpctmgr"=> '<input type="text" class="form-control form-control-sm '.($value->edit_by_dmgm==1?'bg-light-warning':'').'" value="'.($value->percent_proposed>=0?number_format($value->percent_proposed,2, '.', ''):number_format($value->percent_proposed_old,2, '.', '')).'" min="0.00" onkeyup="change_class_input(this,'.$key.','.$value->id.',1);">
                                    <span class="small fw-bold percent_proposed_old'.$value->id.'">
                                        '.($percent_proposed_old>0?number_format($percent_proposed_old,2):'').'% &#62; 
                                    </span>
                                    <span class="small fw-bold -bottom-32 text-primary percent_proposed'.$value->id.'">
                                        '.($value->percent_proposed>=0?number_format($value->percent_proposed,2):number_format($percent_proposed_old,2)).'%
                                    </span>',
                    "incamount"=> '<span class="small fw-bold -bottom-32 amount_proposed'.$value->id.'">
                                        '.($amount_proposed>0?number_format($amount_proposed,2):'').'
                                    </span>',
                    "newbwage"=> '<span class="small fw-bold -bottom-32 salary_new'.$value->id.'">
                                        '.($salary_new>0?number_format($salary_new,2):'').'
                                    </span>
                                    <input type="hidden" class="salary_new" name="salary_new[]" value="'.$salary_new.'">',
                    "newbsalary"=> '<span class="text-primary fw-bold salary_month_new'.$value->id.'">
                                        '.($salary_month_new>0?number_format($salary_month_new,2):'').'
                                    </span>
                                    <input type="hidden" class="salary_month_new" name="salary_month_new[]" value="'.$salary_month_new.'">',
                    "finaldmgm"=> '<input type="text" class="form-control form-control-sm text-success fw-bold bg-light-success" id="final_by_md_gm_amount'.$value->id.'" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2, '.', ''):'').'" onchange="update_final_by_md_gm_amount('.$value->id.');" min="0.00" onkeydown="checknumber('.$value->id.');">',
                    "remark"=> '<input type="text" class="form-control form-control-sm" id="remark_grade'.$value->orisoft_no.'" style="width:250px" value="'.$value->remark_grade.'" onchange="update_remark_grade(\''.$value->id.'\');">',
                    "status"=> $status_salary,
                    "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>',
                    "fieldby" =>  $fieldby,
                    "orderby" =>  $order,
                ); 
                $pagestart++;
            }
        }else{
            $data = [];
        }

        $totalRecords = $totalDisplay = $count_data;
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $data
        ];
        echo json_encode($result);
    }

    public function approve_salary(Request $request)
    {
        $id             = $request->input('id');
        $status_salary         = $request->input('status_salary');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        $newdata = DB::table('tb_employee_final_score')
        ->where('tb_employee_final_score.rec_year',$previousYear)
                        // ->select('tb_employee_final_score.salary_month_new')
                        ->where('tb_employee_final_score.id',$id)->first();

        $newdatax = DB::table('tb_employee')
        ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
        ->where('tb_employee.orisoft_no',$newdata->employee_no)
        ->where('tb_employee_final_score.rec_year',$previousYear)
        ->first();
        $position_description = $newdatax->position_description;
        if($newdata->grade_proposed == 'P' || $newdata->grade_proposed == 'CD'){
            
            if($newdatax->position_code_change){
                $tb_position = DB::table('tb_position')
                ->where('tb_position.position_code',$newdatax->position_code_change)
                ->first();
                // DB::table('tb_employee')
                // ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
                //     ->where('tb_employee.orisoft_no', $newdatax->orisoft_no )
                //     ->where('tb_employee_final_score.rec_year',$previousYear)
                //     ->update([
                //     "position_code_old" => $newdatax->position_code,
                //     "position_code" => $newdatax->position_code_change,
                //     "position_description_old" => $newdatax->position_description,
                //     "position_description" => $tb_position->position_description
                // ]);
                // $position_description = $tb_position->position_description;
            }
        }                

        // if($newdata->grade_proposed_manager == 'CD'){
        //     $info = DB::table('tb_employee_final_score')
        //     ->where('tb_employee_final_score.id',$id)
        //     ->first();
        //     if($info->salary_type == "Daily"){
        //         if($info->bsalary_wage){
        //             $cal = $info->bsalary_wage*(1+(10/100))*27.5;
        //         }else{
        //             $cal = $info->salary_old*(1+(10/100))*27.5;
        //         }
        //         DB::table('tb_employee_final_score')
        //         ->where('tb_employee_final_score.id', $id )
        //         ->update([
        //             "salary_type" => 'Monthly',
        //             "salary_old" => $cal,
        //             "bsalary_wage" => $cal,
        //             "salary_month_old" => $cal
        //         ]);
        //     }
        // }

        DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
            // 'final_by_md_gm_amount' => $newdata->salary_month_new,
            'status_salary' => $request->input('status_salary'),
            "status_pa" => '8',
            'status_salary_approve3' => '3',
            'freeze_to_gmdm' => ($status_salary=='2'?'0':'1')
        ]);

        
        
        $result = [
            'id'                => $id,
            'status_salary'                => $status_salary,
            'position_description'=> $position_description
        ];
        echo json_encode($result); 
    }

    public function approve_salary_all(Request $request)
    {
        $id             = $request->input('id');
        $status_salary         = $request->input('status_salary');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        if(!empty($id)){
            foreach($id AS $val){
                
                $newdata = DB::table('tb_employee_final_score')
                ->where('tb_employee_final_score.rec_year',$previousYear)
                        // ->select('tb_employee_final_score.salary_month_new')
                        ->where('tb_employee_final_score.id',$val)->first();

                $newdatax = DB::table('tb_employee')
                ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
                ->where('tb_employee.orisoft_no',$newdata->employee_no)
                ->where('tb_employee_final_score.rec_year',$previousYear)
                ->first();
                if($newdata->grade_proposed == 'P' || $newdata->grade_proposed == 'CD'){
                    
                    if($newdatax->position_code_change){
                        $tb_position = DB::table('tb_position')
                        ->where('tb_position.position_code',$newdatax->position_code_change)
                        ->first();
                        // DB::table('tb_employee')
                        // ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
                        //     ->where('tb_employee.orisoft_no', $newdatax->orisoft_no )
                        //     ->where('tb_employee_final_score.rec_year',$previousYear)
                        //     ->update([
                        //     "position_code_old" => $newdatax->position_code,
                        //     "position_code" => $newdatax->position_code_change,
                        //     "position_description_old" => $newdatax->position_description,
                        //     "position_description" => $tb_position->position_description
                        // ]);
                    }
                }  
                
                // if($newdata->grade_proposed_manager == 'CD'){
                //     $info = DB::table('tb_employee_final_score')
                //     ->where('tb_employee_final_score.id',$val)
                //     ->first();
                //     if($info->salary_type == "Daily"){
                //         if($info->bsalary_wage){
                //             $cal = $info->bsalary_wage*(1+(10/100))*27.5;
                //         }else{
                //             $cal = $info->salary_old*(1+(10/100))*27.5;
                //         }
                //         DB::table('tb_employee_final_score')
                //         ->where('tb_employee_final_score.id', $val )
                //         ->update([
                //             "salary_type" => 'Monthly',
                //             "salary_old" => $cal,
                //             "bsalary_wage" => $cal,
                //             "salary_month_old" => $cal
                //         ]);
                //     }
                // }

                DB::table('tb_employee_final_score')->where('id', $val )->update([
                    // 'final_by_md_gm_amount' => $newdata->salary_month_new,
                    'status_salary' => $request->input('status_salary'),
                    "status_pa" => '8',
                    'freeze_to_gmdm' => ($status_salary=='2'?'0':'1')
                ]);
            }
        }

        

        $result = [
            'id'                => $id,
            'status_salary'                => $status_salary
        ];
        echo json_encode($result); 
    }

    public function approve_salary_approve3(Request $request)
    {
        $id             = $request->input('id');
        $status_salary         = $request->input('status_salary');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        $newdata = DB::table('tb_employee_final_score')
        ->where('tb_employee_final_score.rec_year',$previousYear)
                        // ->select('tb_employee_final_score.salary_month_new')
                        ->where('tb_employee_final_score.id',$id)->first();

        $newdatax = DB::table('tb_employee')
        ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
        ->where('tb_employee.orisoft_no',$newdata->employee_no)
        ->where('tb_employee_final_score.rec_year',$previousYear)
        ->first();
        $position_description = $newdatax->position_description;
        
        if($status_salary == 1){
            DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
                'status_salary_approve3' => '1'
            ]);
        }else{
            DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
                'status_salary' => '0',
                'status_salary_approve3' => '0'
            ]);
        }
        

        
        
        $result = [
            'id'                => $id,
            'status_salary'                => $status_salary,
            'position_description'=> $position_description
        ];
        echo json_encode($result); 
    }

    public function approve_salary_all_approve3(Request $request)
    {
        $id             = $request->input('id');
        $status_salary         = $request->input('status_salary');
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        // $previousYear = date('Y');
        
        if(!empty($id)){
            foreach($id AS $val){
                
                $newdata = DB::table('tb_employee_final_score')
                ->where('tb_employee_final_score.rec_year',$previousYear)
                        // ->select('tb_employee_final_score.salary_month_new')
                        ->where('tb_employee_final_score.id',$val)->first();

                $newdatax = DB::table('tb_employee')
                ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
                ->where('tb_employee.orisoft_no',$newdata->employee_no)
                ->where('tb_employee_final_score.rec_year',$previousYear)
                ->first();
                if($newdata->grade_proposed == 'P' || $newdata->grade_proposed == 'CD'){
                    
                    if($newdatax->position_code_change){
                        $tb_position = DB::table('tb_position')
                        ->where('tb_position.position_code',$newdatax->position_code_change)
                        ->first();
                        // DB::table('tb_employee')
                        // ->leftJoin('tb_employee_final_score','tb_employee_final_score.employee_no','=','tb_employee.orisoft_no')
                        //     ->where('tb_employee.orisoft_no', $newdatax->orisoft_no )
                        //     ->where('tb_employee_final_score.rec_year',$previousYear)
                        //     ->update([
                        //     "position_code_old" => $newdatax->position_code,
                        //     "position_code" => $newdatax->position_code_change,
                        //     "position_description_old" => $newdatax->position_description,
                        //     "position_description" => $tb_position->position_description
                        // ]);
                    }
                }  
                
                // if($newdata->grade_proposed_manager == 'CD'){
                //     $info = DB::table('tb_employee_final_score')
                //     ->where('tb_employee_final_score.id',$val)
                //     ->first();
                //     if($info->salary_type == "Daily"){
                //         if($info->bsalary_wage){
                //             $cal = $info->bsalary_wage*(1+(10/100))*27.5;
                //         }else{
                //             $cal = $info->salary_old*(1+(10/100))*27.5;
                //         }
                //         DB::table('tb_employee_final_score')
                //         ->where('tb_employee_final_score.id', $val )
                //         ->update([
                //             "salary_type" => 'Monthly',
                //             "salary_old" => $cal,
                //             "bsalary_wage" => $cal,
                //             "salary_month_old" => $cal
                //         ]);
                //     }
                // }

                DB::table('tb_employee_final_score')->where('id', $val )->update([
                    // 'final_by_md_gm_amount' => $newdata->salary_month_new,
                    'status_salary' => $request->input('status_salary'),
                    "status_pa" => '8',
                    'freeze_to_gmdm' => ($status_salary=='2'?'0':'1')
                ]);
            }
        }

        

        $result = [
            'id'                => $id,
            'status_salary'                => $status_salary
        ];
        echo json_encode($result); 
    }

    public function approve_salary_get_all(Request $request)
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }
        $data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '0')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '1')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '2')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $result = [
            'data'                => $data,
            'data1'               => $data1,
            'data2'               => $data2,
            'data3'               => $data3,
        ];
        echo json_encode($result); 

    }

    // public function update_final_by_md_gm_amount(Request $request)
    // {
    //     $id             = $request->input('id');
    //     $final_by_md_gm_amount             = $request->input('final_by_md_gm_amount');
    //     if(date('Y-m') <= (date('Y').'-2')){
    //         $previousYear = date('Y', strtotime('-1 year'));
    //     }else{
    //         $previousYear = date('Y');
    //     }

    //     DB::table('tb_employee_final_score')
    //     ->where('tb_employee_final_score.id', $id )
    //     ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
    //     ->update([
    //         "final_by_md_gm_amount" => $final_by_md_gm_amount
    //     ]);
        
    //     $result = [
    //         'id'                => $id
    //     ];
    //     echo json_encode($result); 
    // }
}
