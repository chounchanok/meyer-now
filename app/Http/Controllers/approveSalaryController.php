<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportReport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use App\Models\TotalAll;

class approveSalaryController extends Controller
{
    public function index()
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        
        $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
        $section = DB::table('tb_section')->orderBy('id', 'ASC')->get();

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

        $data_in = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '0')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data_reject = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '1')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();

        $data_finish = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_salary', '2')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->count();


        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();
        if($orisoft_code == '000060' || $orisoft_code == '019492' || $orisoft_code == '000026' || $orisoft_code == '000002'){
            $position = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.position_code',
            'tb_employee.position_description',
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no');
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
        $search_year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();

        $position_jd = DB::table('tb_position')->where('position_code','!=','114');
        $position_jd = $position_jd->groupBy('tb_position.position_code')->orderBy('position_code', 'ASC')->get();
        $grade_code = DB::table('tb_grade_code')->orderBy('id', 'ASC')->get();
        return view('pages.approveSalary.index', [
            // "division" => $division,
            "department" => $department,
            "section" => $section,
            // "bell_curve" => $bell_curve,
            // "budget" => $budget,
            // "percent_department" => $percent_department,
            // "data_all" => $data_all,
            // "data_in" => $data_in,
            // "data_reject" => $data_reject,
            // "data_finish" => $data_finish,
            "grade_code" => $grade_code,
            "position" => $position,
            "position_jd" => $position_jd,
            "division" => $division,
            "bell_curve" => $bell_curve,
            "budget" => $budget,
            "percent_department" => $percent_department,
            "data_all" => $data_all,
            // "data_in" => $data_in,
            "data_reject" => $data_reject,
            "data_finish" => $data_finish,
            "search_year" => $search_year,
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.approveSalary.index');
    }
    public function table_apvS_getdata(Request $request)
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
                            <option class='' value='gradeAR'>AR</option>
                            <option class='gradeP' value='gradeP'>P</option>
                            <option class='gradeA' value='gradeA'>A</option>
                            <option class='gradeB' value='gradeB'>B</option>
                            <option class='gradeC' value='gradeC' selected>C</option>
                            <option class='gradeD' value='gradeD'>D</option>
                            <option class='gradeE' value='gradeE'>E</option>
                            <option class='' value='gradeU'>U</option>
                            <option class='' value='gradeCD'>CD</option>
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
            );  
        }
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result); 

    }
    public function table_ors_getdata_old(Request $request)
    {
        for ($i=1; $i < 11; $i++) { 
            $data[] = array(
                "id" =>  '<input type="checkbox">',
                "code"=> "123456789",
                "name"=> "จันทรัตว์ ชัยชนา",
                "reason"=> "skilled operator",
                "remark"=> "Full year",
                "actDate"=> "7/23/2007",
                "value"=> "<span class='text-end fw-bold text-primary'>365</span>",
                "effDate"=> "2023/04/01",
                "status"=> "GM approve",
            );  
        }
        $result = [
            'recordsTotal'    => 10,
            'recordsFiltered' => 10,
            'data'            => $data,
        ];
        echo json_encode($result); 

    }

    public function table_ors_getdata(Request $request)
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
        $search_year             = $request->input('search_year');
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
            $previousYear = $search_year;
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
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;

        $count_data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;

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
        
        if($like['tab2_search_division'] != "all"){
            $gatall->where('tb_employee.division_code', 'like','%'.$like['tab2_search_division'].'%');
            $count_data->where('tb_employee.division_code', 'like','%'.$like['tab2_search_division'].'%');
        }
        if($like['tab2_search_department'] != "all"){
            $gatall->where('tb_employee.department_code', 'like','%'.$like['tab2_search_department'].'%');
            $count_data->where('tb_employee.department_code', 'like','%'.$like['tab2_search_department'].'%');
        }
        if($like['tab2_search_section'] != "all"){
            $gatall->where('tb_employee.section_code', 'like','%'.$like['tab2_search_section'].'%');
            $count_data->where('tb_employee.section_code', 'like','%'.$like['tab2_search_section'].'%');
        }

        if($like['tab2_search_month_day'] != "all"){
            if($like['tab2_search_month_day'] == "1"){
                $gatall->where('tb_employee_final_score.salary_type','Daily');
                $count_data->where('tb_employee_final_score.salary_type','Daily');
            }
            if($like['tab2_search_month_day'] == "2"){
                $gatall->where('tb_employee_final_score.salary_type','Monthly');
                $count_data->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($like['tab2_search_status'] != "all"){
            if($like['tab2_search_status'] == '-1'){
                $like['tab2_search_status'] = '0';
            }
            $gatall->where('tb_employee_final_score.status_salary', '=',$like['tab2_search_status']);
            $count_data->where('tb_employee_final_score.status_salary', '=',$like['tab2_search_status']);
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
                $status_salary = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_salary == '0'){
                    $status_salary = '<span class="set_status'.$value->id.' badge badge-light">In progress</span>';
                }
                if($value->status_salary == '2'){
                    $status_salary = '<span class="set_status'.$value->id.' badge badge-light-danger">Reject</span>';
                }
                if($value->status_salary == '1'){
                    $status_salary = '<span class="set_status'.$value->id.' badge badge-light-success">GM Approved</span>';
                }
                if($like['tab2_search_month_day'] != "all"){
                    if($like['tab2_search_month_day'] == "1"){
                        $current = $value->salary_old;
                    }else{
                        $current = $value->salary_month_old;
                    }
                }
                if($like['tab2_search_month_day'] != "all"){
                    if(@$like['tab2_search_month_day'] == "2"){
                        if($value->bsalary_wage){
                            $bsalary_wage = $value->bsalary_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }
                }
                if($like['tab2_search_month_day'] != "all"){
                    if(@$like['tab2_search_month_day'] == "1"){
                        if($value->l800avg_wage != ""){
                            $bsalary_wage = $value->bsalary_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }
                }
                // if(date('Y-m') <= (date('Y').'-2')){
                //     $previousYear = date('Y', strtotime('-1 year'));
                // }else{
                    $previousYear = date('Y');
                // }
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
                        $percent_proposed_old = $databudget->std;
                    }
                }

                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }else{
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }
                $service_days2 = $service_days1;

                $amount_proposed = $value->amount_proposed;
                if($bsalary_wage > 0){
                    // if($value->percent_proposed){
                        // $amount_proposed = $bsalary_wage*($value->percent_proposed/100)*$service_days2;
                        if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                            $amount_proposed = $value->final_by_md_gm_amount-$value->salary_old;
                        }else{
                            $amount_proposed = $bsalary_wage*($value->percent_proposed/100)*$service_days2;
                        }
                    // }else{
                    //     $amount_proposed = $bsalary_wage*($percent_proposed_old/100)*$service_days2;
                    // }
                }
                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select2" name="checkbox2-'.$value->orisoft_no.'" id="checkbox2-'.$value->orisoft_no.'" value="'.$value->id.'" data-id="'.$value->id.'">',
                    "code"=> $value->orisoft_no,
                    "name"=> $value->employee_local_name_en,
                    "reason"=> "ANIC",
                    "remark"=> 'INCR',
                    "actDate"=> $value->approve_date,
                    "value"=> '<span class="text-end fw-bold text-primary">
                                        '.($amount_proposed>0?number_format($amount_proposed,2):'0').'
                                    </span>',
                    "effDate"=> $value->approve_date,
                    "status"=> $status_salary,
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

    public function orisoft_excel($test,$id)
    {
        $cut = explode(',',$id);
        $salary_type = $cut[0];
        $activity_date = $cut[1];
        $search_year = $cut[2];
        if($activity_date != ""){
            $test1 = explode('-',$activity_date);
            $activity_date = $test1[0].'/'.$test1[1].'/'.$test1[2];
        }
        $data0 = [];
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = $search_year;
        // }
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id',
                'tb_employee_final_score.employee_no',
                'tb_employee_final_score.approve_date',
                'tb_employee_final_score.amount_proposed',
                'tb_employee_final_score.salary_old',
                'tb_employee_final_score.final_by_md_gm_amount',
                'tb_employee_final_score.salary_new',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_approve_hr','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_salary', '1')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic');

        if($salary_type == "1"){
            $gatall->where('tb_employee_final_score.salary_type','Daily');
            $gatall->where('tb_employee_final_score.grade_proposed','!=','CD');
        }
        if($salary_type == "2"){
            $gatall->where('tb_employee_final_score.salary_type','Monthly');
        }
        $gatall = $gatall->orderBy('tb_employee_final_score.employee_no','ASC')->get();

        
        

        $excel = public_path('upload/orisoft/')."Orisoft.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('G1', Auth::user()->name);
        $sheet->setCellValue('G2', $activity_date);

        $sheet = $spreadsheet->getActiveSheet();

        $x = 4;
        $final_score = [];
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                $amount_proposed = 0;
                if($salary_type == "1"){
                    $amount_proposed = $value->salary_new - $value->salary_old;
                }
                if($salary_type == "2"){
                    $amount_proposed = round($value->amount_proposed,-1);
                }

                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->final_by_md_gm_amount){
                        $amount_proposed = $value->final_by_md_gm_amount-$value->salary_old;
                    }
                }
                array_push($final_score,$value->id);
                $sheet->setCellValue('A'.$x, $value->employee_no);
                $sheet->setCellValue('B'.$x, "INCR");
                $sheet->setCellValue('C'.$x, "1");
                $sheet->setCellValue('D'.$x, "ANIC");
                $sheet->setCellValue('E'.$x, "INCR");
                $sheet->setCellValue('F'.$x, $activity_date);
                $sheet->setCellValue('G'.$x, number_format($amount_proposed, 0, '.', ''));
                $sheet->setCellValue('H'.$x, $activity_date);
                $x++;
            }
        }
        DB::table('tb_employee_final_score')
            ->whereIn('id', $final_score)
            ->update([
            'approve_date' => $activity_date
        ]);
        if(trans(request()->segment(1)) == 'manager'){
            $output_file = date('Y').' Upload Orisoft Manager';
        }elseif($salary_type == '1'){
            $output_file = date('Y').' Upload Orisoft L800';
        }else{
            $output_file = date('Y').' Upload Orisoft L600 700';
        }

        $checkYearABC = date('Y');
        $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
        if($tb_pa_timeline){
            $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
            ->where('pa_timeline_id', $tb_pa_timeline->id)
            ->get();
            if(count($tb_pa_timeline_action)>0){
                foreach ($tb_pa_timeline_action as $key => $val) {
                    if($key == 11){
                        $id = DB::table('tb_pa_timeline_action')
                        ->where('id', $val->id )
                        ->update(["end_date_real" => date('Y-m-d')]);
                    }
                }
            }
        }
        

        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$output_file.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function orisoft_excel_old($test,$id)
    {
        $cut = explode(',',$id);
        $salary_type = $cut[0];
        $activity_date = $cut[1];
        if($activity_date != ""){
            $test1 = explode('-',$activity_date);
            $activity_date = $test1[2].'/'.$test1[1].'/'.$test1[0];
        }
        $data0 = [];
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id',
                'tb_employee_final_score.employee_no',
                'tb_employee_final_score.approve_date',
                'tb_employee_final_score.amount_proposed',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_approve_hr','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_salary', '1')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic');

        if($salary_type == ""){
            // $gatall->where('tb_employee_final_score.salary_type','Daily');
        }else{
            if($salary_type == "1"){
                $gatall->where('tb_employee_final_score.salary_type','Daily');
            }
            if($salary_type == "2"){
                $gatall->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        
        $gatall = $gatall->orderBy('tb_employee_final_score.employee_no','ASC')->get();

        
        

        $excel = public_path('upload/orisoft/')."Orisoft.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('G1', Auth::user()->name);
        $sheet->setCellValue('G2', date('Y/m/d'));

        $sheet = $spreadsheet->getActiveSheet();

        $x = 4;
        $final_score = [];
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                array_push($final_score,$value->id);
                $sheet->setCellValue('A'.$x, $value->employee_no);
                $sheet->setCellValue('B'.$x, "INCR");
                $sheet->setCellValue('C'.$x, "1");
                $sheet->setCellValue('D'.$x, "ANIC");
                $sheet->setCellValue('E'.$x, "INCR");
                $sheet->setCellValue('F'.$x, $activity_date);
                $sheet->setCellValue('G'.$x, number_format($value->amount_proposed,0, '.', ''));
                $sheet->setCellValue('H'.$x, $activity_date);
                $x++;
            }
        }
        DB::table('tb_employee_final_score')
            ->whereIn('id', $final_score)
            ->update([
            'approve_date' => $activity_date
        ]);
        if($salary_type == ""){
            $output_file = date('Y').' Upload Orisoft';
        }else{
            if($salary_type == '1'){
                $output_file = date('Y').' Upload Orisoft L800';
            }else{
                $output_file = date('Y').' Upload Orisoft L600 700';
            }
        }
        
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$output_file.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function update_status_pa(Request $request)
    {
        $salary_type      = $request->input('search_month_day');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id',
                'tb_employee_final_score.employee_no',
                'tb_employee_final_score.approve_date',
                'tb_employee_final_score.amount_proposed',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;

        if($salary_type == "1"){
            $gatall->where('tb_employee_final_score.salary_type','Daily');
        }
        if($salary_type == "2"){
            $gatall->where('tb_employee_final_score.salary_type','Monthly');
        }
        $gatall = $gatall->orderBy('tb_employee_final_score.employee_no','ASC')->get();

        if(count($gatall) > 0){
            foreach($gatall AS $val){
                DB::table('tb_employee_final_score')
                ->where('id', $val->id )
                ->update([
                    "status_pa" => '14'
                ]);
            }
        }
        
        // DB::table('tb_employee_final_score')
        // ->where('id', $orisoft_no[$key]['id'] )
        // ->update([
        //     "evaluator_no" => $specify_eva_code,
        //     "evaluator_name_th" => $row->employee_local_name_th,
        //     "evaluator_name_en" => $row->employee_local_name_en,
        //     "status_pa" => '3'
        // ]);
        $result = [
            'status'    => 200
        ];
        echo json_encode($result);
    }

    public function user_excel($test)
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        

        $gatall = DB::table('users')
        ->select('tb_employee_evaluator.*',
        'users.email',
        'users.orisoft_code',
        'users.name AS user_name',
        )
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','users.orisoft_code')
        ->where('users.orisoft_code','!=','000000')
        ;
        $gatall = $gatall->orderBy('users.orisoft_code','ASC')->get();

        // dd($gatall);
        // exit;

        $excel = public_path('upload/orisoft/')."Export Users.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);

        $sheet = $spreadsheet->getActiveSheet();

        $x = 2;
        $final_score = [];
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                // array_push($final_score,$value->id);
                if($value->orisoft_code == '000002'){
                    $sheet->setCellValue('A'.$x, $value->orisoft_code);
                    $sheet->setCellValue('B'.$x, $value->user_name);
                    $sheet->setCellValue('C'.$x, $value->user_name);
                }else{
                    $sheet->setCellValue('A'.$x, $value->employee_no);
                    $sheet->setCellValue('B'.$x, $value->employee_name_en);
                    $sheet->setCellValue('C'.$x, $value->employee_name_th);
                }
                
                $sheet->setCellValue('D'.$x, $value->position_code);
                $sheet->setCellValue('E'.$x, $value->position_description);
                $sheet->setCellValue('F'.$x, $value->division_code);
                $sheet->setCellValue('G'.$x, $value->department_code);
                $sheet->setCellValue('H'.$x, $value->section_code);
                $sheet->setCellValue('I'.$x, $value->grade_code);
                $sheet->setCellValue('J'.$x, $value->grade_description);
                $sheet->setCellValue('K'.$x, $value->email);
                $x++;
            }
        }
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Export_User.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function table_approve_salary_getdata(Request $request)
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
        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_employee_no       = $request->input('search_employee_no');
        $search_year       = $request->input('search_year');
        $search_grade       = $request->input('search_grade');
        $search_group       = $request->input('search_group');
        $pagenow       = $request->input('pagenow');
        $pagenow_salary       = $request->input('pagenow_salary');
        $search_not_up_salary       = $request->input('search_not_up_salary');
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
            $previousYear = $search_year;
        // }

        // dd($search_employee_no);
        // exit;

        
        
        // dd($evaluator);
        // exit;

        // dd(Auth::user()->can('view salary increase'));
        // exit;
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.id AS employee_id',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_description',
        'tb_employee.division_code',
        'tb_employee.department_code',
        'tb_employee.section_code',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee.grade_code',
        'tb_employee.date_joined',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.id','2147')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        // ->whereIn('tb_employee_final_score.evaluator_no',$evaluator_code)
        ;

        if($pagenow_salary == "1"){
            if($like['search_status'] != "all"){
                if($like['search_status'] == "-1"){
                    $gatall->where('tb_employee_final_score.freeze_to_approve_hr', '0');
                }else{
                    $gatall->where('tb_employee_final_score.freeze_to_approve_hr', '1');
                }
            }
        }else{
            if($pagenow == "2"){
                $gatall->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        
        $count_data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.id','2147')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        // ->whereIn('tb_employee_final_score.evaluator_no',$evaluator_code)
        ;

        if($pagenow_salary == "1"){
            if($like['search_status'] != "all"){
                if($like['search_status'] == "-1"){
                    $count_data->where('tb_employee_final_score.freeze_to_approve_hr', '0');
                }else{
                    $count_data->where('tb_employee_final_score.freeze_to_approve_hr', '1');
                }
            }
        }else{
            if($pagenow == "2"){
                $count_data->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $count_data->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                    // exit;
                    $gatall->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
                    $count_data->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
                    // $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                    // $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
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
                $gatall->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
                $count_data->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
                // $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                // $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
            
            }
            // if($like['search_department'] == "all" || $like['search_department'] == ""){
                
            // }
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
                $gatall->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                    }
                });
                $count_data->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                    }
                });
                // $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_code);
                // $count_data = $count_data->whereIn('tb_employee.section_code',$arr_section_code);
            
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_countsection);
                    $count_data = $count_data->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_countsection);
                    $count_data = $count_data->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            // if(!isset($search_division)){
            //         $arr_countsection = [];
            //         $countsection = DB::table('tb_percent_department_action')
            //         ->select('tb_percent_department_action.division_code')
            //         ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            //         ->where('tb_percent_department.year','like','%'.$previousYear.'%')
            //         ->where('tb_percent_department_action.approve_by2','000026');
            //         $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
            //         if(count($countsection)>0){
            //             foreach ($countsection as $value) {
            //                 array_push($arr_countsection,$value->division_code);
            //             }
            //         }
            //         $gatall = $gatall->whereIn('tb_employee.division_code',$arr_countsection);
            //         $count_data = $count_data->whereIn('tb_employee.division_code',$arr_countsection);
                
            // }
            $arr_countsection = [];
            if(trans(request()->segment(1)) == 'manager'){
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        foreach ($search_division as $value) {
                            $department = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.department_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.division_code','like','%'.$value.'%')
                            ->where('tb_percent_department_action.approve_by1','000026');
                            $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                        }
                        if(count($department)>0){
                            foreach ($department as $value) {
                                array_push($arr_countsection,$value->department_code);
                            }
                        }
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                        $count_data = $count_data->whereIn('tb_employee.department_code',$arr_countsection);
                    }
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    if(count($department)>0){
                        foreach ($department as $value) {
                            array_push($arr_countsection,$value->department_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                    $count_data = $count_data->whereIn('tb_employee.department_code',$arr_countsection);
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
                            ->where('tb_percent_department_action.approve_by2','000026');
                            $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                        }
                        if(count($department)>0){
                            foreach ($department as $value) {
                                array_push($arr_countsection,$value->department_code);
                            }
                        }
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                        $count_data = $count_data->whereIn('tb_employee.department_code',$arr_countsection);
                    }
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    if(count($department)>0){
                        foreach ($department as $value) {
                            array_push($arr_countsection,$value->department_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                    $count_data = $count_data->whereIn('tb_employee.department_code',$arr_countsection);
                }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                
                // }
                // if(!isset($search_department)){
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
                //         $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                
                }
                if(!isset($search_department)){
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
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                
                // }
                // if(!isset($search_department)){
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
                //         $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);
                
                // }
                // if(!isset($search_department)){
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
                //         $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $count_data = $count_data->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);
                
                }
                if(!isset($search_department)){
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
                        $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $count_data = $count_data->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $count_data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);
                
                // }
                // if(!isset($search_department)){
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
                //         $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $count_data = $count_data->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $count_data = $count_data->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $count_data = $count_data->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $count_data = $count_data->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $count_data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $count_data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        
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
        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $gatall->whereIn('tb_employee.division_code', $search_division);
                $count_data->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $gatall->whereIn('tb_employee.department_code', $search_department);
                $count_data->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $gatall->whereIn('tb_employee.section_code', $search_section);
                $count_data->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        //     $count_data->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($like['search_department'] != "all" && $like['search_department'] != ""){
        //     $gatall->where('tb_employee.department_code', 'like','%'.$like['search_department'].'%');
        //     $count_data->where('tb_employee.department_code', 'like','%'.$like['search_department'].'%');
        // }
        // if($like['search_section'] != "all" && $like['search_section'] != ""){
        //     $gatall->where('tb_employee.section_code', 'like','%'.$like['search_section'].'%');
        //     $count_data->where('tb_employee.section_code', 'like','%'.$like['search_section'].'%');
        // }
        
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $gatall->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                $count_data->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
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
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $gatall->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
                $count_data->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($like['search_grade'] != "all"){
        //     $gatall->where('tb_employee_final_score.grade_proposed',$like['search_grade']);
        //     $count_data->where('tb_employee_final_score.grade_proposed',$like['search_grade']);
        // }
        // if($like['search_status'] != "all"){
        //     $gatall->where('tb_employee_final_score.status_salary', '=',$like['search_status']);
        //     $count_data->where('tb_employee_final_score.status_salary', '=',$like['search_status']);
        // }
        if($search_not_up_salary == "1"){
            $gatall->whereNotNull('tb_employee_final_score.not_up_salary');
            $count_data->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $gatall->whereNull('tb_employee_final_score.not_up_salary');
            $count_data->whereNull('tb_employee_final_score.not_up_salary');
        }
        // $gatall = $gatall->get();
        // $result = [
        //     'gatall'    => $gatall
        // ];
        // echo json_encode($result);
        // exit;
        if($like['search_status'] != "all"){
            if($like['search_status'] == "-1"){
                // $gatall->where('tb_employee_final_score.status_salary','0');
                // $count_data->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall->where('tb_employee_final_score.status_salary',$like['search_status']);
                $count_data->where('tb_employee_final_score.status_salary',$like['search_status']);
            }
        }
        
        if($like['search_group'] != "all"){
            if($like['search_group'] == "1"){
                $gatall->where('tb_employee.position_description','like','%Manager%');
                $count_data->where('tb_employee.position_description','like','%Manager%');
            }else{
                $gatall->where('tb_employee.position_description','not like','%Manager%');
                $count_data->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($like['search_complaince_score'] != "all"){
            if($like['search_complaince_score'] == "1"){
                $gatall->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
                $count_data->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($like['search_complaince_score'] == "2"){
                $gatall->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
                $count_data->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($like['search_complaince_score'] == "3"){
                $gatall->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
                $count_data->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($like['search_attendance_score'] != "all"){
            if($like['search_attendance_score'] == "1"){
                $gatall->where('tb_employee_final_score.attendance_score', '>=' ,'15');
                $count_data->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($like['search_attendance_score'] == "2"){
                $gatall->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
                $count_data->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($like['search_attendance_score'] == "3"){
                $gatall->where('tb_employee_final_score.attendance_score', '<=' ,'6');
                $count_data->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
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

        if(isset($pagenow_salary)){
            if($field == 1){
                $fieldby = 'tb_employee_final_score.employee_no';
            }
            else{
                if($field == 3){
                    $fieldby = 'tb_employee.division_description';
                }else if($field == 4){
                    $fieldby = 'tb_employee.department_description';
                }else if($field == 5){
                    $fieldby = 'tb_employee.section_description';
                }else if($field == 6){
                    $fieldby = 'tb_employee.position_description';
                }else if($field == 8){
                    $fieldby = 'tb_employee.date_joined';
                }else if($field == 9){
                    $fieldby = 'tb_employee_final_score.service_days';
                }else if($field == 10){
                    $fieldby = 'tb_employee_final_score.attendance_sl';
                }else if($field == 11){
                    $fieldby = 'tb_employee_final_score.attendance_pl';
                }else if($field == 13){
                    $fieldby = 'tb_employee_final_score.attendance_late';
                }else if($field == 14){
                    $fieldby = 'tb_employee_final_score.attendance_abt';
                }else if($field == 15){
                    $fieldby = 'tb_employee_final_score.attendance_abs';
                }else if($field == 16){
                    $fieldby = 'tb_employee_final_score.attendance_ol';
                }else if($field == 17){
                    $fieldby = 'tb_employee_final_score.attendance_score';
                }else if($field == 18){
                    $fieldby = 'tb_employee_final_score.attendance_vwar';
                }else if($field == 19){
                    $fieldby = 'tb_employee_final_score.attendance_wwar';
                }else if($field == 20){
                    $fieldby = 'tb_employee_final_score.attendance_sus';
                }else if($field == 21){
                    $fieldby = 'tb_employee_final_score.adjust_grade_old1';
                }else if($field == 22){
                    $fieldby = 'tb_employee_final_score.adjust_grade_old2';
                }else if($field == 23){
                    $fieldby = 'tb_employee_final_score.adjust_grade_old3';
                }else if($field == 24){
                    $fieldby = 'tb_employee_final_score.form_import';
                }else if($field == 25){
                    $fieldby = 'tb_employee_final_score.evaluator_name_en';
                }else if($field == 26){
                    $fieldby = 'tb_employee_final_score.total_score';
                }else if($field == 27){
                    $fieldby = 'tb_employee_final_score.pa_grade';
                }else if($field == 28){
                    $fieldby = 'tb_employee_final_score.adjust_grade';
                }else if($field == 29){
                    $fieldby = 'tb_employee_final_score.salary_old';
                }else if($field == 31){
                    $fieldby = 'tb_employee_final_score.bsalary_wage';
                }else if($field == 32){
                    $fieldby = 'tb_employee_final_score.salary_month_old';
                }else if($field == 33){
                    $fieldby = 'tb_employee_final_score.company_suggested_per';
                }else if($field == 34){
                    $fieldby = 'tb_employee_final_score.company_suggestged_amount';
                }else if($field == 35){
                    $fieldby = 'tb_employee_final_score.company_suggestged_new_basic';
                }else if($field == 36){
                    $fieldby = 'tb_employee_final_score.grade_proposed';
                }else if($field == 37){
                    $fieldby = 'tb_employee_final_score.percent_proposed';
                }else if($field == 38){
                    $fieldby = 'tb_employee_final_score.amount_proposed';
                }else if($field == 39){
                    $fieldby = 'tb_employee_final_score.salary_new';
                }else if($field == 40){
                    $fieldby = 'tb_employee_final_score.salary_month_new';
                }else if($field == 41){
                    $fieldby = 'tb_employee_final_score.final_by_md_gm_amount';
                }else if($field == 43){
                    $fieldby = 'tb_employee_final_score.status_salary';
                }
            }
        }else{
            if($pagenow == "1"){
                if($field == 1){
                    $fieldby = 'tb_employee_final_score.employee_no';
                }
                else{
                    if($field == 3){
                        $fieldby = 'tb_employee.division_description';
                    }else if($field == 4){
                        $fieldby = 'tb_employee.department_description';
                    }else if($field == 5){
                        $fieldby = 'tb_employee.section_description';
                    }else if($field == 6){
                        $fieldby = 'tb_employee.position_description';
                    }else if($field == 8){
                        $fieldby = 'tb_employee.date_joined';
                    }else if($field == 9){
                        $fieldby = 'tb_employee_final_score.service_days';
                    }else if($field == 10){
                        $fieldby = 'tb_employee_final_score.attendance_sl';
                    }else if($field == 11){
                        $fieldby = 'tb_employee_final_score.attendance_pl';
                    }else if($field == 13){
                        $fieldby = 'tb_employee_final_score.attendance_late';
                    }else if($field == 14){
                        $fieldby = 'tb_employee_final_score.attendance_abt';
                    }else if($field == 15){
                        $fieldby = 'tb_employee_final_score.attendance_abs';
                    }else if($field == 16){
                        $fieldby = 'tb_employee_final_score.attendance_ol';
                    }else if($field == 17){
                        $fieldby = 'tb_employee_final_score.attendance_score';
                    }else if($field == 18){
                        $fieldby = 'tb_employee_final_score.attendance_vwar';
                    }else if($field == 19){
                        $fieldby = 'tb_employee_final_score.attendance_wwar';
                    }else if($field == 20){
                        $fieldby = 'tb_employee_final_score.attendance_sus';
                    }else if($field == 21){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old1';
                    }else if($field == 22){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old2';
                    }else if($field == 23){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old3';
                    }else if($field == 24){
                        $fieldby = 'tb_employee_final_score.form_import';
                    }else if($field == 25){
                        $fieldby = 'tb_employee_final_score.evaluator_name_en';
                    }else if($field == 26){
                        $fieldby = 'tb_employee_final_score.total_score';
                    }else if($field == 27){
                        $fieldby = 'tb_employee_final_score.pa_grade';
                    }else if($field == 28){
                        $fieldby = 'tb_employee_final_score.adjust_grade';
                    }else if($field == 29){
                        $fieldby = 'tb_employee_final_score.salary_old';
                    }else if($field == 31){
                        $fieldby = 'tb_employee_final_score.bsalary_wage';
                    }else if($field == 32){
                        $fieldby = 'tb_employee_final_score.salary_month_old';
                    }else if($field == 33){
                        $fieldby = 'tb_employee_final_score.company_suggested_per';
                    }else if($field == 34){
                        $fieldby = 'tb_employee_final_score.company_suggestged_amount';
                    }else if($field == 35){
                        $fieldby = 'tb_employee_final_score.company_suggestged_new_basic';
                    }else if($field == 36){
                        $fieldby = 'tb_employee_final_score.grade_proposed';
                    }else if($field == 37){
                        $fieldby = 'tb_employee_final_score.percent_proposed';
                    }else if($field == 38){
                        $fieldby = 'tb_employee_final_score.amount_proposed';
                    }else if($field == 39){
                        $fieldby = 'tb_employee_final_score.salary_new';
                    }else if($field == 40){
                        $fieldby = 'tb_employee_final_score.salary_month_new';
                    }else if($field == 41){
                        $fieldby = 'tb_employee_final_score.final_by_md_gm_amount';
                    }else if($field == 43){
                        $fieldby = 'tb_employee_final_score.status_salary';
                    }
                }
            }else{
                if($field == 1){
                    $fieldby = 'tb_employee_final_score.employee_no';
                }
                else{
                    if($field == 3){
                        $fieldby = 'tb_employee.division_description';
                    }else if($field == 4){
                        $fieldby = 'tb_employee.department_description';
                    }else if($field == 5){
                        $fieldby = 'tb_employee.section_description';
                    }else if($field == 6){
                        $fieldby = 'tb_employee.position_description';
                    }else if($field == 8){
                        $fieldby = 'tb_employee.date_joined';
                    }else if($field == 9){
                        $fieldby = 'tb_employee_final_score.service_days';
                    }else if($field == 10){
                        $fieldby = 'tb_employee_final_score.attendance_sl';
                    }else if($field == 11){
                        $fieldby = 'tb_employee_final_score.attendance_pl';
                    }else if($field == 13){
                        $fieldby = 'tb_employee_final_score.attendance_late';
                    }else if($field == 14){
                        $fieldby = 'tb_employee_final_score.attendance_abt';
                    }else if($field == 15){
                        $fieldby = 'tb_employee_final_score.attendance_abs';
                    }else if($field == 16){
                        $fieldby = 'tb_employee_final_score.attendance_ol';
                    }else if($field == 17){
                        $fieldby = 'tb_employee_final_score.attendance_score';
                    }else if($field == 18){
                        $fieldby = 'tb_employee_final_score.attendance_vwar';
                    }else if($field == 19){
                        $fieldby = 'tb_employee_final_score.attendance_wwar';
                    }else if($field == 20){
                        $fieldby = 'tb_employee_final_score.attendance_sus';
                    }else if($field == 21){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old1';
                    }else if($field == 22){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old2';
                    }else if($field == 23){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old3';
                    }else if($field == 24){
                        $fieldby = 'tb_employee_final_score.form_import';
                    }else if($field == 25){
                        $fieldby = 'tb_employee_final_score.evaluator_name_en';
                    }else if($field == 26){
                        $fieldby = 'tb_employee_final_score.total_score';
                    }else if($field == 27){
                        $fieldby = 'tb_employee_final_score.pa_grade';
                    }else if($field == 28){
                        $fieldby = 'tb_employee_final_score.adjust_grade';
                    }else if($field == 29){
                        $fieldby = 'tb_employee_final_score.salary_old';
                    }else if($field == 31){
                        $fieldby = 'tb_employee_final_score.bsalary_wage';
                    }else if($field == 32){
                        $fieldby = 'tb_employee_final_score.salary_month_old';
                    }else if($field == 33){
                        $fieldby = 'tb_employee_final_score.company_suggested_per';
                    }else if($field == 34){
                        $fieldby = 'tb_employee_final_score.company_suggestged_amount';
                    }else if($field == 35){
                        $fieldby = 'tb_employee_final_score.company_suggestged_new_basic';
                    }else if($field == 36){
                        $fieldby = 'tb_employee_final_score.grade_proposed';
                    }else if($field == 37){
                        $fieldby = 'tb_employee_final_score.percent_proposed';
                    }else if($field == 38){
                        $fieldby = 'tb_employee_final_score.amount_proposed';
                    }else if($field == 39){
                        $fieldby = 'tb_employee_final_score.salary_new';
                    }else if($field == 40){
                        $fieldby = 'tb_employee_final_score.salary_month_new';
                    }else if($field == 41){
                        $fieldby = 'tb_employee_final_score.percent_proposed_gmdm';
                    }else if($field == 42){
                        $fieldby = 'tb_employee_final_score.amount_proposed_gmdm';
                    }else if($field == 43){
                        $fieldby = 'tb_employee_final_score.salary_new_gmdm';
                    }else if($field == 44){
                        $fieldby = 'tb_employee_final_score.salary_month_new_gmdm';
                    }else if($field == 45){
                        $fieldby = 'tb_employee_final_score.final_by_md_gm_amount';
                    }else if($field == 47){
                        $fieldby = 'tb_employee_final_score.status_salary';
                    }
                }
            }
        }
        
        

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }

        if($field == 0){
            $gatall->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
            ->orderBy('tb_employee_final_score.total_score', 'DESC');
            $gatall = $gatall->skip($start)->take($length)->get();

            $count_data = $count_data->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
            ->orderBy('tb_employee_final_score.total_score', 'DESC')->count();
        }else{
            $gatall->orderBy($fieldby,$order);
            $gatall = $gatall->skip($start)->take($length)->get();

            $count_data->orderBy($fieldby,$order);
            $count_data = $count_data->skip($start)->take($length)->count();
        }
        

        
        if($pagenow == "2"){
            if(Auth::user()->can('view review salary')){
                $gatall = $gatall;
                $count_data = $count_data;
            }else{
                $gatall = [];
                $count_data = 0;
            }
        }
        
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                $status_salary = '<span class="set_status'.$value->id.' badge" style="height: 34px;"></span>';
                if($value->status_salary == '0'){
                    $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                        <span class="set_status'.$value->id.' badge badge-light" style="height: 34px;">In progress</span>
                                    </div>';
                }
                if($value->status_salary == '2'){
                    $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                        <span class="set_status'.$value->id.' badge bg-danger text-light" style="height: 34px;">Reject</span>
                                    </div>';
                }
                if($value->status_salary == '1'){
                    if($value->not_up_salary){
                        $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                            <span class="set_status'.$value->id.' badge bg-success text-light" style="height: 34px;">Finished</span>
                                        </div>';
                    }else{
                        $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                            <span class="set_status'.$value->id.' badge bg-success text-light" style="height: 34px;">Approved</span>
                                        </div>';
                    }
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
                $current = 0;
                $total_day = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                if($like['search_month_day'] != "all"){
                    if($like['search_month_day'] == "1"){
                        $current = $value->salary_old;
                    }else{
                        $current = $value->salary_month_old;
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $current = $value->salary_old;
                    }else{
                        $current = $value->salary_month_old;
                    }
                }
                if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                    $l800avg_wage = $value->l800avg_wage;
                }else{
                    $l800avg_wage = '';
                }
                $bsalary_wage = 0;
                if($like['search_month_day'] != "all"){
                    if(@$like['search_month_day'] == "1"){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage = $value->l800avg_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage = $value->bsalary_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage = $value->l800avg_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }else{
                        if($value->bsalary_wage){
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
                    // $previousYear = date('Y');
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
                    $company_suggestged_new_basic = round($company_suggestged_amount+$current);
                }else{
                    $company_suggestged_new_basic = round($company_suggestged_amount+$bsalary_wage,(trans(request()->segment(1)) == 'manager'?-2:-1));
                }
                $value->company_suggestged_new_basic = $company_suggestged_new_basic;
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
                if($like['search_month_day'] != "all"){
                    if(@$like['search_month_day'] == "1"){
                        $salary_new = round($amount_proposed+$current);
                    }else{
                        $salary_new = round($amount_proposed+$current,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $salary_new = round($amount_proposed+$current);
                    }else{
                        $salary_new = round($amount_proposed+$current,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }
                
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
                        }else{
                            $salary_month_new = round($salary_new,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }else{
                        if($value->grade_code == 'L800'){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx = $salary_new*27.5;
                                $salary_month_new = round($salary_month_newx,-1);
                            }else{
                                $salary_month_new = round($salary_new)*26;
                            }
                        }else{
                            $salary_month_new = round($salary_new,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }
                }

                // DB::table('tb_employee_final_score')->where('id',$value->id)
                // ->update([
                //     "company_suggested_per" => $company_suggested_per,
                //     "company_suggestged_amount" => $company_suggestged_amount,
                //     "company_suggestged_new_basic" => $company_suggestged_new_basic,
                //     "grade_proposed_old" => ($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade),
                //     "grade_proposed" => ($value->grade_proposed?$value->grade_proposed:$value->adjust_grade),
                //     "percent_proposed_old" => $percent_proposed_old,
                //     "percent_proposed" => ($value->percent_proposed>=0?$value->percent_proposed:$percent_proposed_old),
                //     "amount_proposed" => $amount_proposed,
                //     "salary_new" => $salary_new,
                //     "salary_month_new" => $salary_month_new,
                //     "final_by_md_gm_amount" => ($value->final_by_md_gm_amount>0?$value->final_by_md_gm_amount:($salary_month_new>0?$salary_month_new:0))
                // ]);
                
                $date_formatted = '';
                if($value->date_joined){
                    $date_joined_old = $value->date_joined;
                    $date_formatted = date("Y-m-d", strtotime($date_joined_old));
                }

                $approve_review_salary = 'style="display:none;"';
                if (Auth::user()->can('approve review salary')) {
                    $approve_review_salary = 'style="display:block;"';
                }
                $action = '';
                if($value->status_salary == '1'){
                    $action = '<div style="display: flex;align-items: center;justify-content: center;">
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                </div>';
                }else if($value->status_salary == '2'){
                    $action = '<div style="display: flex;align-items: center;justify-content: center;">
                                <button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                </div>';
                }else{
                    $action = '<div style="display: flex;align-items: center;justify-content: center;">
                                <button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                </div>';
                }

                $disabled = '';
                if(!$value->adjust_grade){
                    $disabled = 'disabled="disabled"';
                }
                $old_grade_disabled = '';
                if(!$value->grade_proposed_old){
                    $old_grade_disabled = 'style="display:none;"';
                }
                $old_percent_proposed_oldd = '';
                if(!$value->percent_proposed_old){
                    $old_percent_proposed_oldd = 'style="display:none;"';
                }

                

                $freeze_to_gmdm = '';
                if($pagenow == "1"){
                    if ($value->freeze_to_gmdm == '1') {
                        $freeze_to_gmdm = 'disabled';
                    }
                }

                $freeze_to_approve_hr = '';
                if($pagenow == "2"){
                    if ($value->freeze_to_approve_hr == '1') {
                        $freeze_to_approve_hr = 'disabled';
                    }
                }
                

                $disabled_l800avg_wage = '';
                if($value->grade_code != 'L800'){
                    $disabled_l800avg_wage = 'disabled';
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

                $info_grade_p_display = 'display:none;';
                if($value->grade_proposed == "AR" || $value->grade_proposed == "P" || $value->grade_proposed == "U" || $value->grade_proposed == "CD"){
                    $info_grade_p_display = '';
                }
                $info_grade_p = '<button type="button" class="btn btn-icon btn-light btn-xs me-1 change_class_info'.$value->id.'" onclick="change_class_info(\''.$value->grade_proposed.'\','.$key.','.$value->id.','.$value->employee_id.');" style="'.$info_grade_p_display.'">
                                        <i class="ki-outline ki-information-2 fs-5"></i>
                                    </button>';
                $info_grade_p_approve = '';
                if($value->grade_proposed == "AR" || $value->grade_proposed == "P" || $value->grade_proposed == "U" || $value->grade_proposed == "CD"){
                    $info_grade_p_approve = '<button type="button" class="btn btn-icon btn-light btn-xs change_class_info'.$value->id.'" onclick="change_class_info(\''.$value->grade_proposed.'\','.$key.','.$value->id.','.$value->employee_id.');">
                                        <i class="ki-outline ki-information-2 fs-5"></i>
                                    </button>';
                    if($value->grade_proposed == "P"){
                        $info_grade_p_approve .= '<button type="button" class="btn btn-icon btn-info btn-xs me-1 open_jd'.$value->id.'" onclick="open_jd('.$key.','.$value->id.','.$value->employee_id.');" style="font-size: 10px;'.$info_grade_p_display.'">
                                            JD
                                        </button>';
                    }                
                }

                $bgx = '';
                $tb_budget_action = DB::table('tb_budget_action')
                ->select('tb_budget_action.*')
                ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                ->where('tb_budget.year',$previousYear)
                ->orderBy('tb_budget_action.id', 'ASC')->get();
                if(count($tb_budget_action)>0){
                    foreach ($tb_budget_action as $keyzz => $valuezz) {
                        if($value->grade_proposed == $valuezz->grade_name){
                            if($valuezz->budget_range_start && $valuezz->budget_range_start > 0){
                                if($value->percent_proposed < $valuezz->budget_range_start || $value->percent_proposed > $valuezz->budget_range_end){
                                    if($pagenow == "2"){
                                        $bgx = 'background-color:rgb(255 211 211);';
                                    }
                                }
                            }
                        }
                    }
                }
                
                $pa3 = DB::table('tb_employee_final_score')
                ->select('grade_proposed','adjust_grade_old2','adjust_grade_old3')
                ->where('tb_employee_final_score.employee_no',$value->employee_no)
                ->where('tb_employee_final_score.rec_year',($previousYear-1))->first();
                
                if($value->adjust_grade_old1 == null){
                    if($pa3){
                        DB::table('tb_employee_final_score')->where('id',$value->id)
                        ->update([
                            "adjust_grade_old1" => $pa3->adjust_grade_old2,
                            "adjust_grade_old2" => $pa3->adjust_grade_old3,
                            "adjust_grade_old3" => $pa3->grade_proposed,
                        ]);
                        $value->adjust_grade_old1 = $pa3->adjust_grade_old2;
                        $value->adjust_grade_old2 = $pa3->adjust_grade_old3;
                        $value->adjust_grade_old3 = $pa3->grade_proposed;
                    }
                }
                if($value->adjust_grade_old1 == "P"){
                    $class_pa1 = 'gradeP';
                }else if($value->adjust_grade_old1 == "A"){
                    $class_pa1 = 'gradeA';
                }else if($value->adjust_grade_old1 == "B"){
                    $class_pa1 = 'gradeB';
                }else if($value->adjust_grade_old1 == "C"){
                    $class_pa1 = 'gradeC';
                }else if($value->adjust_grade_old1 == "D"){
                    $class_pa1 = 'gradeD';
                }else if($value->adjust_grade_old1 == "E"){
                    $class_pa1 = 'gradeE';
                }else{
                    $class_pa1 = '';
                }
                if($value->adjust_grade_old2 == "P"){
                    $class_pa2 = 'gradeP';
                }else if($value->adjust_grade_old2 == "A"){
                    $class_pa2 = 'gradeA';
                }else if($value->adjust_grade_old2 == "B"){
                    $class_pa2 = 'gradeB';
                }else if($value->adjust_grade_old2 == "C"){
                    $class_pa2 = 'gradeC';
                }else if($value->adjust_grade_old2 == "D"){
                    $class_pa2 = 'gradeD';
                }else if($value->adjust_grade_old2 == "E"){
                    $class_pa2 = 'gradeE';
                }else{
                    $class_pa2 = '';
                }
                if($value->adjust_grade_old3 == "P"){
                    $class_pa3 = 'gradeP';
                }else if($value->adjust_grade_old3 == "A"){
                    $class_pa3 = 'gradeA';
                }else if($value->adjust_grade_old3 == "B"){
                    $class_pa3 = 'gradeB';
                }else if($value->adjust_grade_old3 == "C"){
                    $class_pa3 = 'gradeC';
                }else if($value->adjust_grade_old3 == "D"){
                    $class_pa3 = 'gradeD';
                }else if($value->adjust_grade_old3 == "E"){
                    $class_pa3 = 'gradeE';
                }else{
                    $class_pa3 = '';
                }
                $data[] = array(
                    "id" =>  ($value->not_up_salary?'':'<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->orisoft_no.'" id="checkbox-'.$value->orisoft_no.'" value="'.$value->id.'" data-id="'.$value->id.'">').'
                            <input type="hidden" class="salary_month_new" id="salary_month_new'.$value->id.'" name="salary_month_new[]" value="'.$salary_month_new.'">
                            <input type="hidden" class="comsugpct" id="comsugpct'.$value->id.'" name="comsugpct[]" value="'.($company_suggested_per>0?number_format($company_suggested_per,2,'.',''):0.00).'">
                            <input type="hidden" class="comsugamt" id="comsugamt'.$value->id.'" name="comsugamt[]" value="'.($company_suggestged_amount>0?number_format($company_suggestged_amount,2,'.',''):0.00).'">
                            <input type="hidden" class="companynewb" id="companynewb'.$value->id.'" name="companynewb[]" value="'.($company_suggestged_new_basic>0?number_format($company_suggestged_new_basic,2,'.',''):0.00).'">',
                    "divi"=> $value->division_code,
                    "dept"=> $value->department_code,
                    "sect"=> $value->section_code,
                    "code"=> $value->orisoft_no.' 
                                <button type="button" class="btn btn-icon btn-light btn-xs me-1" id="infoModal" onclick="set_info('.$value->id.');">
                                    <i class="ki-outline ki-information-2 fs-5"></i>
                                </button>',
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> '<span class="position_description'.$value->id.'">'.$value->position_description.'</span>',
                    "group"=> "",
                    "joindate"=> $date_formatted,
                    "serviced"=> $value->service_days.'<input type="hidden" id="service_days'.$value->id.'" value="'.$service_days2.'">',
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> ($value->attendance_ol>0?number_format($value->attendance_ol,1):'0.0'),
                    "totald"=> ($total_day>0?number_format($total_day,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa1"=> '<span class="form-control text-center form-select-sm selectG '.$class_pa1.'">'.($value->adjust_grade_old1?$value->adjust_grade_old1:'-').'</span>',
                    "pa2"=> '<span class="form-control text-center form-select-sm selectG '.$class_pa2.'">'.($value->adjust_grade_old2?$value->adjust_grade_old2:'-').'</span>',
                    "pa3"=> '<span class="form-control text-center form-select-sm selectG '.$class_pa3.'">'.($value->adjust_grade_old3?$value->adjust_grade_old3:'-').'</span>',
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade,
                    "adjustg"=> $adjustg,
                    "current"=> '<span class="show_salary_old'.$value->id.'">'.($current>0?number_format($current,2):'').'</span><input type="hidden" class="salary_old" id="salary_old'.$value->id.'" name="salary_old[]" value="'.$current.'">',
                    // "l800avg"=> ($value->grade_code == 'L800'?'<input type="text" class="form-control form-control-sm fw-bold" id="l800avg_wage'.$value->id.'" value="'.($l800avg_wage>0?number_format($l800avg_wage,2):'').'" min="0" min="999" maxlength="3" onchange="update_l800avg_wage('.$value->id.');" OnKeyPress="return checknumber(this,'.$value->id.',\'l800avg_wage\')" '.$freeze_to_gmdm.' '.$disabled_l800avg_wage.'>':''),
                    "l800avg"=> '<span class="l800avg_wage'.$value->id.'">'.($l800avg_wage>0?number_format($l800avg_wage,2):'').'</span>',
                    "l800avg_gmdm"=> '<span class="l800avg_wage'.$value->id.'">'.($l800avg_wage>0?number_format($l800avg_wage,2):'').'</span>',
                    "bsalaryw"=> '<span class="show_bsalary_wage'.$value->id.'">'.($bsalary_wage>0?number_format($bsalary_wage,2):'').'</span><input type="hidden" class="bsalaryw" id="bsalaryw'.$value->id.'" name="bsalaryw[]" value="'.($bsalary_wage>0?number_format($bsalary_wage,2,'.',''):'').'">',
                    "cbsalaryw"=> '<span class="show_salary_month_old'.$value->id.'">'.($salary_month_old>0?number_format($salary_month_old,2):'').'</span><input type="hidden" class="salary_month_old" id="salary_month_old'.$value->id.'" name="salary_month_old[]" value="'.($salary_month_old>0?number_format($salary_month_old,2,'.',''):'').'">',
                    "comsugpct"=> '<span class="show_company_suggested_per'.$value->id.'">'.($company_suggested_per>0?number_format($company_suggested_per,2):0.00).'%</span>',
                    "comsugamt"=> '<span class="show_company_suggestged_amount'.$value->id.'">'.($company_suggestged_amount>0?number_format($company_suggestged_amount,2):0.00).'</span>',
                    "companynewb"=> '<span class="show_company_suggestged_new_basic'.$value->id.'">'.($company_suggestged_new_basic>0?number_format($company_suggestged_new_basic,2):0.00).'</span>',
                    "gmgr_span"=> '<span class="form-select form-select-sm selectG '.$class_gmgr.'">'.($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')).'</span>'.$info_grade_p,
                    "gmgr_span2"=> '<span class="badge w-100 text-center fs-3 d-block py-2 mb-0 selectG '.$class_gmgr.'">'.($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')).'</span>'.$info_grade_p,
                    "gmgr_span_approve"=> '<div style="text-align:center;min-width: 60px;"><span class="badge w-100 text-center fs-3 d-block py-2 mb-0 selectG '.$class_gmgr.'">'.($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')).'</span>'.$info_grade_p_approve.'</div><input type="hidden" class="id_gmgr" id="hidden_grade_proposed'.$value->id.'" name="hidden_grade_proposed[]" value="'.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'">',
                    "gmgr_view"=> '<select class="form-select form-select-sm selectG '.$class_gmgr.'" id="id_gmgr'.$value->id.'" style="width:80px" disabled>
                                <option class="" value="AR" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':''))).'>AR</option>
                                <option class="gradeP" value="P" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='P'?'selected':''):($value->adjust_grade=='P'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='P'?'selected':''):($value->adjust_grade=='P'?'selected':''))).'>P</option>
                                <option class="gradeA" value="A" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='A'?'selected':''):($value->adjust_grade=='A'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='A'?'selected':''):($value->adjust_grade=='A'?'selected':''))).'>A</option>
                                <option class="gradeB" value="B" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='B'?'selected':''):($value->adjust_grade=='B'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='B'?'selected':''):($value->adjust_grade=='B'?'selected':''))).'>B</option>
                                <option class="gradeC" value="C" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='C'?'selected':''):($value->adjust_grade=='C'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='C'?'selected':''):($value->adjust_grade=='C'?'selected':''))).'>C</option>
                                <option class="gradeD" value="D" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='D'?'selected':''):($value->adjust_grade=='D'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='D'?'selected':''):($value->adjust_grade=='D'?'selected':''))).'>D</option>
                                <option class="gradeE" value="E" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='E'?'selected':''):($value->adjust_grade=='E'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='E'?'selected':''):($value->adjust_grade=='E'?'selected':''))).'>E</option>
                                <option class="" value="U" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='U'?'selected':''):($value->adjust_grade=='U'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='U'?'selected':''):($value->adjust_grade=='U'?'selected':''))).'>U</option>
                                '.($value->grade_code == 'L800'?'<option class="" value="CD" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':''))).'>CD</option>':'').'
                            </select>
                            <span class="small fw-bold grade_proposed_old'.$value->id.'" '.$old_grade_disabled.'>
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade)).' &#62; 
                            </span>
                            <span class="small fw-bold changecolor'.$value->id.'">
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'
                            </span>
                            '.$info_grade_p.'',
                    "gmgr"=> '<select class="form-select form-select-sm selectG '.$class_gmgr.'" id="id_gmgr'.$value->id.'" style="width:80px" onchange="change_class(this,'.$key.','.$value->id.','.$value->employee_id.');" '.$disabled.' '.($value->not_up_salary?'disabled':'').' '.$freeze_to_gmdm.' '.$freeze_to_approve_hr.'>
                                <option class="" value="AR" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':''))).'>AR</option>
                                <option class="gradeP" value="P" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='P'?'selected':''):($value->adjust_grade=='P'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='P'?'selected':''):($value->adjust_grade=='P'?'selected':''))).'>P</option>
                                <option class="gradeA" value="A" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='A'?'selected':''):($value->adjust_grade=='A'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='A'?'selected':''):($value->adjust_grade=='A'?'selected':''))).'>A</option>
                                <option class="gradeB" value="B" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='B'?'selected':''):($value->adjust_grade=='B'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='B'?'selected':''):($value->adjust_grade=='B'?'selected':''))).'>B</option>
                                <option class="gradeC" value="C" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='C'?'selected':''):($value->adjust_grade=='C'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='C'?'selected':''):($value->adjust_grade=='C'?'selected':''))).'>C</option>
                                <option class="gradeD" value="D" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='D'?'selected':''):($value->adjust_grade=='D'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='D'?'selected':''):($value->adjust_grade=='D'?'selected':''))).'>D</option>
                                <option class="gradeE" value="E" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='E'?'selected':''):($value->adjust_grade=='E'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='E'?'selected':''):($value->adjust_grade=='E'?'selected':''))).'>E</option>
                                <option class="" value="U" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='U'?'selected':''):($value->adjust_grade=='U'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='U'?'selected':''):($value->adjust_grade=='U'?'selected':''))).'>U</option>
                                '.($value->grade_code == 'L800'?'<option class="" value="CD" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':''))).'>CD</option>':'').'
                            </select>
                            <span class="small fw-bold grade_proposed_old'.$value->id.'" '.$old_grade_disabled.'>
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade)).' &#62; 
                            </span>
                            <span class="small fw-bold changecolor'.$value->id.'">
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'
                            </span>
                            <input type="hidden" class="id_gmgr" id="hidden_grade_proposed'.$value->id.'" name="hidden_grade_proposed[]" value="'.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'">
                            '.$info_grade_p.'',
                    "incpctmgr_span"=> '<span class="small fw-bold -bottom-32">'.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'%</span>',
                    "incpctmgr_view"=> '<input type="text" id="percent_proposed'.$value->id.'" class="form-control form-control-sm '.($value->edit_by_dmgm==1?'bg-light-warning':'').'" value="'.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'" readonly >
                                    <span class="small fw-bold percent_proposed_old'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($percent_proposed_old>0?number_format($percent_proposed_old,4,'.',''):'').'% &#62; 
                                    </span>
                                    <span class="small fw-bold -bottom-32 text-primary percent_proposed'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'%
                                    </span>
                                    ',
                    "incpctmgr"=> '<input type="text" id="percent_proposed'.$value->id.'" class="form-control form-control-sm '.($value->edit_by_dmgm==1?'bg-light-warning':'').'" value="'.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'" onchange="change_class_input(this,'.$key.','.$value->id.',0);" OnKeyPress="return checknumber(this,'.$value->id.',\'percent_proposed\')" '.$disabled.' '.($value->not_up_salary?'disabled':'').' '.$freeze_to_gmdm.' '.$freeze_to_approve_hr.' style="'.$bgx.'">
                                    <span class="small fw-bold percent_proposed_old'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($percent_proposed_old>0?number_format($percent_proposed_old,4,'.',''):'').'% &#62; 
                                    </span>
                                    <span class="small fw-bold -bottom-32 text-primary percent_proposed'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'%
                                    </span>',
                    "incpctmgr_gmdm"=> '<span class="small fw-bold -bottom-32 percent_proposed_old_gmdm'.$value->id.'">
                                            '.($value->percent_proposed_gmdm>0?number_format($value->percent_proposed_gmdm,4,'.',''):($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.',''))).'%
                                        </span>',
                    "incamount"=> '<span class="small fw-bold -bottom-32 amount_proposed'.$value->id.'">
                                        '.($amount_proposed>0?number_format($amount_proposed,2):'0.00').'
                                    </span>',
                    "incamount_gmdm"=> '<span class="small fw-bold -bottom-32 amount_proposed_gmdm'.$value->id.'">
                                        '.($value->amount_proposed_gmdm>0?number_format($value->amount_proposed_gmdm,2):($amount_proposed>0?number_format($amount_proposed,2):'')).'
                                    </span>',
                    "newbwage"=> '<span class="small fw-bold -bottom-32 salary_new'.$value->id.'">
                                        '.($salary_new>0?number_format($salary_new,2):'').'
                                    </span>
                                    <input type="hidden" class="salary_new" id="salary_new'.$value->id.'" name="salary_new[]" value="'.$salary_new.'">',
                    "newbwage_gmdm"=> '<span class="small fw-bold -bottom-32 salary_new_gmdm'.$value->id.'">
                                        '.($value->salary_new_gmdm>0?number_format($value->salary_new_gmdm,2):($salary_new>0?number_format($salary_new,2):'')).'
                                    </span>
                                    <input type="hidden" class="salary_new_gmdm" id="salary_new_gmdm'.$value->id.'" name="salary_new_gmdm[]" value="'.$salary_new.'">',
                    "newbsalary"=> '<span class="text-primary fw-bold salary_month_new'.$value->id.'">
                                        '.($salary_month_new>0?number_format($salary_month_new,2):'').'
                                    </span>
                                    ',
                    "newbsalary_gmdm"=> '<span class="text-primary fw-bold salary_month_new_gmdm'.$value->id.'">
                                        '.($value->salary_month_new_gmdm>0?number_format($value->salary_month_new_gmdm,2):($salary_month_new>0?number_format($salary_month_new,2):'')).'
                                    </span>
                                    <input type="hidden" class="salary_month_new_gmdm" id="salary_month_new_gmdm'.$value->id.'" name="salary_month_new_gmdm[]" value="'.$salary_month_new.'">',
                    "finaldmgm"=> '<span class="text-success fw-bold final_by_md_gm_amount'.$value->id.'">'.($value->status_salary=='1'?($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')):'').'</span>
                                    <input type="hidden" class="status_salary_hide" value="'.$value->status_salary.'">
                                    <input type="hidden" class="grade_code_hide" value="'.$value->grade_code.'">
                                    <input type="hidden" class="finaldmgm_hide" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2, '.', ''):($salary_month_new>0?number_format($salary_month_new,2, '.', ''):'')).'" >',
                    "finaldmgm_edit"=> '<input type="text" class="form-control form-control-sm '.($value->freeze_to_gmdm_edit==1?'text-light':'text-success').' fw-bold  '.($value->freeze_to_gmdm_edit==1?'bg-success':'bg-light-success').'" id="final_by_md_gm_amount'.$value->id.'" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')).'" onchange="update_final_by_md_gm_amount('.$value->id.','.($value->salary_type=='Daily'?'1':'2').');" min="0.00" OnKeyPress="return checknumber_final(this,'.$value->id.',\'final_by_md_gm_amount\',event)" style="width: 100px;">
                                    <input type="hidden" class="status_salary_hide" value="'.$value->status_salary.'">
                                    <input type="hidden" class="grade_code_hide" value="'.$value->grade_code.'">
                                    <input type="hidden" id="finaldmgm_hide'.$value->id.'" class="finaldmgm_hide" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2, '.', ''):($salary_month_new>0?number_format($salary_month_new,2, '.', ''):'')).'" >',
                    "remark_view"=> $value->remark_grade,
                    "remark"=> '<input type="text" class="form-control form-control-sm" id="remark_grade'.$value->id.'" style="width:250px" value="'.$value->remark_grade.'" onchange="update_remark_grade(\''.$value->id.'\');">',
                    "status"=> $status_salary,
                    "action"=> $action,
                    "fieldby" =>  $fieldby,
                    "orderby" =>  $order,
                    "freeze_to_gmdm"=> $value->freeze_to_gmdm,
                    // "not_up_salary"=> ($value->not_up_salary && $value->not_up_salary != ""?'
                    //                 <div style="display: flex;align-items: center;justify-content: center;">
                    //                     <span class="set_status1178 badge bg-danger text-light" style="height: 34px;"><i class="bi-check-circle fs-5"></i></span>
                    //                 </div>':''),
                ); 
                $pagestart++;
            }
        }else{
            $data = [];
        }

        $totalRecords = $totalDisplay = $count_data;

        $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
        ->where('tb_employee_final_score.freeze_to_gmdm','0')
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
                        if($key == 7 && $val->end_date_real == null){
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
            'gatall_calall'   => $count_data
        ];
        echo json_encode($result);
    }

    public function all_detail_approve(Request $request)
    {
        $search_not_up_salary             = $request->input('search_not_up_salary');
        $search_division             = $request->input('search_division');
        $search_department             = $request->input('search_department');
        $search_section             = $request->input('search_section');
        $search_employee_no             = $request->input('search_employee_no');
        $search_month_day             = $request->input('search_month_day');
        $search_grade             = $request->input('search_grade');
        $search_status             = $request->input('search_status');
        $search_group             = $request->input('search_group');
        $search_complaince_score             = $request->input('search_complaince_score');
        $search_attendance_score             = $request->input('search_attendance_score');
        $pagenow             = $request->input('pagenow');
        $pagenow_salary             = $request->input('pagenow_salary');
        $search_year       = $request->input('search_year');
            $previousYear = $search_year;
        
            
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $total_Daily = DB::table('tb_employee_final_score')
            ->select( 
                DB::raw('SUM(salary_old) AS current_salary_wage'),
                DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                DB::raw('SUM(salary_month_new) AS new_salary_wage_month'),
                DB::raw('SUM(final_by_md_gm_amount) AS final_by_md_gm_amount')
            )                                       
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')   
            ->where('tb_employee_final_score.status_evaluation', '3')                                                                                                                                                                                                                                                                
            ->where('tb_employee_final_score.salary_type','Daily')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->where('tb_employee.employee_status_description','Passed')
            // ->where('tb_employee_final_score.freeze','1')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            
            ->whereNotNull('tb_employee_final_score.salary_old')
            ->whereNotNull('tb_employee_final_score.adjust_grade')
            ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic');
            
            if($pagenow_salary == "1"){
                $total_Daily->where('tb_employee_final_score.freeze_to_approve_hr', '1');
            }else{
                if($pagenow == "2"){
                    $total_Daily->where('tb_employee_final_score.freeze_to_gmdm', '1');
                }else{
                    $total_Daily->where('tb_employee_final_score.freeze_to_pagrade', '1');
                }
            }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkatotal_Daily = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codetotal_Daily = [];
                    if($checkatotal_Daily >= 0){
                        $extotal_Daily = explode(',',$orisoft_all_code->division_code);
                        if(count($extotal_Daily)>0){
                            foreach ($extotal_Daily as $value) {
                                array_push($arr_division_codetotal_Daily,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codetotal_Daily,$orisoft_all_code->division_code);
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_division_codetotal_Daily);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codetotal_Daily = [];
                $checkatotal_Daily = strpos($orisoft_all_code->department_code,',');
                if($checkatotal_Daily >= 0){
                    $extotal_Daily = explode(',',$orisoft_all_code->department_code);
                    if(count($extotal_Daily)>0){
                        foreach ($extotal_Daily as $value) {
                            array_push($arr_department_codetotal_Daily,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codetotal_Daily,$orisoft_all_code->department_code);
                }
                $total_Daily = $total_Daily->whereIn('tb_employee.department_code',$arr_department_codetotal_Daily);
            }
            // if($search_department == "all" || $search_department == ""){
                
            // }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_countsection);
                
                }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_countsection);
                
                }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                
                // }
                // if(!isset($search_department)){
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
                //         $total_Daily = $total_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                
                }
                if(!isset($search_department)){
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
                        $total_Daily = $total_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                
                // }
                // if(!isset($search_department)){
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
                //         $total_Daily = $total_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_Daily = $total_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_Daily = $total_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        
        if($search_not_up_salary == "1"){
            $total_Daily->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
            $total_Daily->whereNull('tb_employee_final_score.not_up_salary');
        }
        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $total_Daily->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $total_Daily->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $total_Daily->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all"){
        //     $total_Daily->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all"){
        //     $total_Daily->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $total_Daily->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_month_day != "all"){
        //     if($search_month_day == "1"){
        //         $total_Daily->where('tb_employee_final_score.salary_type','Daily');
        //     }
        //     if($search_month_day == "2"){
        //         $total_Daily->where('tb_employee_final_score.salary_type','Monthly');
        //     }
        // }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $total_Daily->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $total_Daily->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     $total_Daily->where('tb_employee_final_score.status_salary', '=',$search_status);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $total_Daily->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Daily->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $total_Daily->where('tb_employee.position_description','like','%Manager%');
            }else{
                $total_Daily->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $total_Daily->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $total_Daily->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $total_Daily->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $total_Daily->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $total_Daily->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $total_Daily->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $total_Daily = $total_Daily->first();
        // echo json_encode($total_Daily);
        // exit;
        if($total_Daily->current_salary_wage){
            if($total_Daily->current_salary_wage > 0){
                $cal = ((($total_Daily->company_suggested_new_basic?$total_Daily->company_suggested_new_basic:0)/($total_Daily->current_salary_wage?$total_Daily->current_salary_wage:0))-1)*100;
                $total_Daily->company_suggested_percent = $cal;
            }
        }else{
            $total_Daily->company_suggested_percent = 0.00;
        }
        

        $total_Monthly = DB::table('tb_employee_final_score')
            ->select( 
                DB::raw('SUM(salary_old) AS current_salary_wage'),
                DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
                DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
                DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
                DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
                DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
                DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
                DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
                DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
                DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
                DB::raw('SUM(salary_month_new) AS new_salary_wage_month'),
                DB::raw('SUM(final_by_md_gm_amount) AS final_by_md_gm_amount')
            )                                   
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                       
            ->where('tb_employee_final_score.salary_type','Monthly')
            ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
            ->where('tb_employee.employee_status_description','Passed')
            // ->where('tb_employee_final_score.freeze','1')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation', '3')
            ->whereNotNull('tb_employee_final_score.salary_month_old')
            ->whereNotNull('tb_employee_final_score.adjust_grade')
            ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic');

            if($pagenow_salary == "1"){
                $total_Monthly->where('tb_employee_final_score.freeze_to_approve_hr', '1');
            }else{
                if($pagenow == "2"){
                    $total_Monthly->where('tb_employee_final_score.freeze_to_gmdm', '1');
                }else{
                    $total_Monthly->where('tb_employee_final_score.freeze_to_pagrade', '1');
                }
            }

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
                if(!isset($search_division)){
                        $checkatotal_Monthly = strpos($orisoft_all_code->division_code,',');
                        $arr_division_codetotal_Monthly = [];
                        if($checkatotal_Monthly >= 0){
                            $extotal_Monthly = explode(',',$orisoft_all_code->division_code);
                            if(count($extotal_Monthly)>0){
                                foreach ($extotal_Monthly as $value) {
                                    array_push($arr_division_codetotal_Monthly,$value);
                                }
                            }
                        }else{
                            array_push($arr_division_codetotal_Monthly,$orisoft_all_code->division_code);
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_codetotal_Monthly);
                    
                }
                // if($search_division == "all" || $search_division == ""){
                    
                // }
                if(!isset($search_department)){
                    $arr_department_codetotal_Monthly = [];
                    $checkatotal_Monthly = strpos($orisoft_all_code->department_code,',');
                    if($checkatotal_Monthly >= 0){
                        $extotal_Monthly = explode(',',$orisoft_all_code->department_code);
                        if(count($extotal_Monthly)>0){
                            foreach ($extotal_Monthly as $value) {
                                array_push($arr_department_codetotal_Monthly,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_codetotal_Monthly,$orisoft_all_code->department_code);
                    }
                    $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_codetotal_Monthly);
                }
                // if($search_department == "all" || $search_department == ""){
                    
                // }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
            }

            if($orisoft_code == "990002"){
                if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
                // if($search_division == "all" || $search_division == ""){
                    
                // }
            }

            if($orisoft_code == "000002"){
                if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000002');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
                // if($search_division == "all" || $search_division == ""){
                    
                // }
            }
    
            if($orisoft_code == "000026"){
                if(trans(request()->segment(1)) == 'manager'){
                    if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by1','000026');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
                }else{
                    if(!isset($search_division)){
                        $arr_countsection = [];
                        $countsection = DB::table('tb_percent_department_action')
                        ->select('tb_percent_department_action.division_code')
                        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                        ->where('tb_percent_department_action.approve_by2','000026');
                        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                        if(count($countsection)>0){
                            foreach ($countsection as $value) {
                                array_push($arr_countsection,$value->division_code);
                            }
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
                    
                }
                }
                
                // if($search_division == "all" || $search_division == ""){
                    
                // }
            }

            if(trans(request()->segment(1)) == 'manager'){
                if($orisoft_code == "000002"){
                    // if(!isset($search_division)){
                    //     $checka = strpos($orisoft_all_code->division_code,',');
                    //     $arr_division_code = [];
                    //     if($checka >= 0){
                    //         $ex = explode(',',$orisoft_all_code->division_code);
                    //         if(count($ex)>0){
                    //             foreach ($ex as $value) {
                    //                 array_push($arr_division_code,$value);
                    //             }
                    //         }
                    //     }else{
                    //         array_push($arr_division_code,$orisoft_all_code->division_code);
                    //     }
                    //     $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                        
                    // }
                    // if(!isset($search_department)){
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
                    //         $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                        
                    // }
                    // if(!isset($search_section)){
                    //     $arr_section_codedata_all = [];
                    //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    //     if($checkadata_all >= 0){
                    //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                    //         if(count($exdata_all)>0){
                    //             foreach ($exdata_all as $value) {
                    //                 array_push($arr_section_codedata_all,$value);
                    //             }
                    //         }
                    //     }else{
                    //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    //     }
                    //     $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    // }
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else if($orisoft_code == "990002"){
                
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                        
                    }
                    if(!isset($search_department)){
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
                            $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                        
                    }
                    if(!isset($search_section)){
                        $arr_section_codedata_all = [];
                        $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        if($checkadata_all >= 0){
                            $exdata_all = explode(',',$orisoft_all_code->section_code);
                            if(count($exdata_all)>0){
                                foreach ($exdata_all as $value) {
                                    array_push($arr_section_codedata_all,$value);
                                }
                            }
                        }else{
                            array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    // if(!isset($search_division)){
                    //     $checka = strpos($orisoft_all_code->division_code,',');
                    //     $arr_division_code = [];
                    //     if($checka >= 0){
                    //         $ex = explode(',',$orisoft_all_code->division_code);
                    //         if(count($ex)>0){
                    //             foreach ($ex as $value) {
                    //                 array_push($arr_division_code,$value);
                    //             }
                    //         }
                    //     }else{
                    //         array_push($arr_division_code,$orisoft_all_code->division_code);
                    //     }
                    //     $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                        
                    // }
                    // if(!isset($search_department)){
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
                    //         $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                        
                    // }
                    // if(!isset($search_section)){
                    //     $arr_section_codedata_all = [];
                    //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    //     if($checkadata_all >= 0){
                    //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                    //         if(count($exdata_all)>0){
                    //             foreach ($exdata_all as $value) {
                    //                 array_push($arr_section_codedata_all,$value);
                    //             }
                    //         }
                    //     }else{
                    //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    //     }
                    //     $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    // }
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else if($orisoft_code == "990002"){
                
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                        
                    }
                    if(!isset($search_department)){
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
                            $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                        
                    }
                    if(!isset($search_section)){
                        $arr_section_codedata_all = [];
                        $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        if($checkadata_all >= 0){
                            $exdata_all = explode(',',$orisoft_all_code->section_code);
                            if(count($exdata_all)>0){
                                foreach ($exdata_all as $value) {
                                    array_push($arr_section_codedata_all,$value);
                                }
                            }
                        }else{
                            array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        }
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{
    
            }
            if($search_not_up_salary == "1"){
                $total_Monthly->whereNotNull('tb_employee_final_score.not_up_salary');
            }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
                $total_Monthly->whereNull('tb_employee_final_score.not_up_salary');
            }
            if(isset($search_division)){
                if(count($search_division) > 0){
                    $total_Monthly->whereIn('tb_employee.division_code', $search_division);
                }
            }
            if(isset($search_department)){
                if(count($search_department) > 0){
                    $total_Monthly->whereIn('tb_employee.department_code', $search_department);
                }
            }
            if(isset($search_section)){
                if(count($search_section) > 0){
                    $total_Monthly->whereIn('tb_employee.section_code', $search_section);
                }
            }
            // if($search_division != "all"){
            //     $total_Monthly->where('tb_employee.division_code', 'like','%'.$search_division.'%');
            // }
            // if($search_department != "all"){
            //     $total_Monthly->where('tb_employee.department_code', 'like','%'.$search_department.'%');
            // }
            // if($search_section != "all"){
            //     $total_Monthly->where('tb_employee.section_code', 'like','%'.$search_section.'%');
            // }
            if(isset($search_employee_no)){
                if(count($search_employee_no) > 0){
                    $total_Monthly->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                }
            }
            // if($search_month_day != "all"){
            //     if($search_month_day == "1"){
            //         $total_Monthly->where('tb_employee_final_score.salary_type','Daily');
            //     }
            //     if($search_month_day == "2"){
            //         $total_Monthly->where('tb_employee_final_score.salary_type','Monthly');
            //     }
            // }
            if(isset($search_grade)){
                if(count($search_grade) > 0){
                    $total_Monthly->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
                }
            }
            // if($search_grade != "all"){
            //     $total_Monthly->where('tb_employee_final_score.grade_proposed',$search_grade);
            // }
            // if($search_status != "all"){
            //     $total_Monthly->where('tb_employee_final_score.status_salary', '=',$search_status);
            // }
            if($search_status != "all"){
                if($search_status == "-1"){
                    $total_Monthly->where('tb_employee_final_score.status_salary','0');
                }else{
                    $total_Monthly->where('tb_employee_final_score.status_salary',$search_status);
                }
            }
            if($search_group != "all" && $search_group != ""){
                if($search_group == "1"){
                    $total_Monthly->where('tb_employee.position_description','like','%Manager%');
                }else{
                    $total_Monthly->where('tb_employee.position_description','not like','%Manager%');
                }
            }
            if($search_complaince_score != "all"){
                if($search_complaince_score == "1"){
                    $total_Monthly->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
                }
                if($search_complaince_score == "2"){
                    $total_Monthly->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
                }
                if($search_complaince_score == "3"){
                    $total_Monthly->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
                }
            }
    
            if($search_attendance_score != "all"){
                if($search_attendance_score == "1"){
                    $total_Monthly->where('tb_employee_final_score.attendance_score', '>=' ,'15');
                }
                if($search_attendance_score == "2"){
                    $total_Monthly->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
                }
                if($search_attendance_score == "3"){
                    $total_Monthly->where('tb_employee_final_score.attendance_score', '<=' ,'6');
                }
            }
            $total_Monthly = $total_Monthly->first();

        if($total_Monthly->current_salary_wage_month){
            if($total_Monthly->current_salary_wage_month > 0){
                $cal = ((($total_Monthly->company_suggested_new_basic?$total_Monthly->company_suggested_new_basic:0)/($total_Monthly->current_salary_wage_month?$total_Monthly->current_salary_wage_month:0))-1)*100;
                $total_Monthly->company_suggested_percent = $cal;
            }
        }else{
            $total_Monthly->company_suggested_percent = 0.00;
        }

        
        
        
        

        $countdata = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.adjust_grade','tb_employee_final_score.grade_proposed')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        // ->whereNotNull('tb_employee_final_score.pa_grade')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ;
        if($pagenow_salary == "1"){
            $countdata->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $countdata->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $countdata->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkacountdata = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codecountdata = [];
                    if($checkacountdata >= 0){
                        $excountdata = explode(',',$orisoft_all_code->division_code);
                        if(count($excountdata)>0){
                            foreach ($excountdata as $value) {
                                array_push($arr_division_codecountdata,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codecountdata,$orisoft_all_code->division_code);
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_codecountdata);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codecountdata = [];
                $checkacountdata = strpos($orisoft_all_code->department_code,',');
                if($checkacountdata >= 0){
                    $excountdata = explode(',',$orisoft_all_code->department_code);
                    if(count($excountdata)>0){
                        foreach ($excountdata as $value) {
                            array_push($arr_department_codecountdata,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codecountdata,$orisoft_all_code->department_code);
                }
                $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_codecountdata);
            }
            // if($search_department == "all" || $search_department == ""){
                
            // }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $countdata = $countdata->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
                }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_countsection);
                
                }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $countdata = $countdata->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $countdata->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $countdata = $countdata->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $countdata->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $countdata = $countdata->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $countdata->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $countdata = $countdata->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $countdata = $countdata->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $countdata = $countdata->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $countdata->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $countdata->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
            $countdata->whereNull('tb_employee_final_score.not_up_salary');
        }
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
        // if($search_division != "all"){
        //     $countdata->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all"){
        //     $countdata->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all"){
        //     $countdata->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $countdata->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_month_day != "all"){
        //     if($search_month_day == "1"){
        //         $countdata->where('tb_employee_final_score.salary_type','Daily');
        //     }
        //     if($search_month_day == "2"){
        //         $countdata->where('tb_employee_final_score.salary_type','Monthly');
        //     }
        // }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $countdata->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $countdata->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     $countdata->where('tb_employee_final_score.status_salary', '=',$search_status);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $countdata->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $countdata->where('tb_employee.position_description','like','%Manager%');
            }else{
                $countdata->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $countdata->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $countdata->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $countdata->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $countdata->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $countdata = $countdata->get();

        $count_total_all = DB::table('tb_total_all')
        ->where('tb_total_all.year','like','%'.$previousYear.'%')
        ->count();
        
        // $total_Daily = DB::table('tb_employee_final_score')->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->whereNotNull('tb_employee_final_score.salary_old')
        // ->whereNotNull('tb_employee_final_score.salary_new')
        // ->where('tb_employee_final_score.salary_type','Daily')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->sum('tb_employee_final_score.salary_new');

        if($count_total_all == 0){
            $TotalAll = TotalAll::create([
                "year" => $previousYear,
                "total_type" => '0'
            ]);
            $TotalAll = TotalAll::create([
                "year" => $previousYear,
                "total_type" => '1'
            ]);
            $TotalAll = TotalAll::create([
                "year" => $previousYear,
                "total_type" => '2'
            ]);
        }else{
            DB::table('tb_total_all')
            ->where('tb_total_all.year',$previousYear)
            ->where('tb_total_all.total_type','0')
            ->update([
                "current_salary_wage" => $total_Daily->current_salary_wage,
                "L800_avg_wage_mwa" => $total_Daily->L800_avg_wage_mwa,
                "salary_wage_calculation" => $total_Daily->salary_wage_calculation,
                "current_salary_wage_month" => $total_Daily->current_salary_wage_month,
                "company_suggested_percent" => $total_Daily->company_suggested_percent,
                "company_suggested_amount" => $total_Daily->company_suggested_amount,
                "company_suggested_new_basic" => $total_Daily->company_suggested_new_basic,
                "inc_percent_proposed" => $total_Daily->inc_percent_proposed,
                "inc_amount_proposed" => round($total_Daily->inc_amount_proposed),
                "new_basic_wage_proposed" => $total_Daily->new_basic_wage_proposed,
                "new_salary_wage_month" => $total_Daily->new_salary_wage_month,
            ]);
            DB::table('tb_total_all')->where('tb_total_all.year',$previousYear)->where('tb_total_all.total_type','1')
            ->update([
                "current_salary_wage" => $total_Monthly->current_salary_wage,
                "L800_avg_wage_mwa" => $total_Monthly->L800_avg_wage_mwa,
                "salary_wage_calculation" => $total_Monthly->salary_wage_calculation,
                "current_salary_wage_month" => $total_Monthly->current_salary_wage_month,
                "company_suggested_percent" => $total_Monthly->company_suggested_percent,
                "company_suggested_amount" => $total_Monthly->company_suggested_amount,
                "company_suggested_new_basic" => $total_Monthly->company_suggested_new_basic,
                "inc_percent_proposed" => $total_Monthly->inc_percent_proposed,
                "inc_amount_proposed" => $total_Monthly->inc_amount_proposed,
                "new_basic_wage_proposed" => $total_Monthly->new_basic_wage_proposed,
                "new_salary_wage_month" => $total_Monthly->new_salary_wage_month,
            ]);
            DB::table('tb_total_all')->where('tb_total_all.year',$previousYear)->where('tb_total_all.total_type','2')
            ->update([
                "current_salary_wage" => $total_Daily->current_salary_wage+$total_Monthly->current_salary_wage,
                "L800_avg_wage_mwa" => $total_Daily->L800_avg_wage_mwa+$total_Monthly->L800_avg_wage_mwa,
                "salary_wage_calculation" => $total_Daily->salary_wage_calculation+$total_Monthly->salary_wage_calculation,
                "current_salary_wage_month" => $total_Daily->current_salary_wage_month+$total_Monthly->current_salary_wage_month,
                "company_suggested_percent" => $total_Daily->company_suggested_percent+$total_Monthly->company_suggested_percent,
                "company_suggested_amount" => $total_Daily->company_suggested_amount+$total_Monthly->company_suggested_amount,
                "company_suggested_new_basic" => $total_Daily->company_suggested_new_basic+$total_Monthly->company_suggested_new_basic,
                "inc_percent_proposed" => $total_Daily->inc_percent_proposed+$total_Monthly->inc_percent_proposed,
                "inc_amount_proposed" => round($total_Daily->inc_amount_proposed)+$total_Monthly->inc_amount_proposed,
                "new_basic_wage_proposed" => $total_Daily->new_basic_wage_proposed+$total_Monthly->new_basic_wage_proposed,
                "new_salary_wage_month" => $total_Daily->new_salary_wage_month+$total_Monthly->new_salary_wage_month,
            ]);
        }
        $tb_total_all = DB::table('tb_total_all')
        ->where('tb_total_all.year','like','%'.$previousYear.'%')
        ->get();


        $total_Daily_filter = DB::table('tb_employee_final_score')
        ->select( 
            DB::raw('SUM(salary_old) AS current_salary_wage'),
            DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
            DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
            DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
            DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
            DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
            DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
            DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
            DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
            DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
            DB::raw('SUM(salary_month_new) AS new_salary_wage_month'),
            DB::raw('SUM(final_by_md_gm_amount) AS final_by_md_gm_amount')
        )                 
        // ->select('tb_employee_final_score.id','tb_employee_final_score.percent_proposed')          
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                                 
        ->where('tb_employee_final_score.salary_type','Daily')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        
        ;
        if($pagenow_salary == "1"){
            $total_Daily_filter->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $total_Daily_filter->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $total_Daily_filter->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkatotal_Daily_filter = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codetotal_Daily_filter = [];
                    if($checkatotal_Daily_filter >= 0){
                        $extotal_Daily_filter = explode(',',$orisoft_all_code->division_code);
                        if(count($extotal_Daily_filter)>0){
                            foreach ($extotal_Daily_filter as $value) {
                                array_push($arr_division_codetotal_Daily_filter,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codetotal_Daily_filter,$orisoft_all_code->division_code);
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_division_codetotal_Daily_filter);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codetotal_Daily_filter = [];
                $checkatotal_Daily_filter = strpos($orisoft_all_code->department_code,',');
                if($checkatotal_Daily_filter >= 0){
                    $extotal_Daily_filter = explode(',',$orisoft_all_code->department_code);
                    if(count($extotal_Daily_filter)>0){
                        foreach ($extotal_Daily_filter as $value) {
                            array_push($arr_department_codetotal_Daily_filter,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codetotal_Daily_filter,$orisoft_all_code->department_code);
                }
                $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_codetotal_Daily_filter);
            }
            // if($search_department == "all" || $search_department == ""){
                
            // }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $total_Daily_filter->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
            $total_Daily_filter->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $total_Daily_filter->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $total_Daily_filter->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $total_Daily_filter->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily_filter->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all"){
        //     $total_Daily_filter->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all"){
        //     $total_Daily_filter->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $total_Daily_filter->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_month_day != "all"){
            // $total_Daily_filter->where('tb_employee_final_score.salary_type','Daily');
        // }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $total_Daily_filter->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $total_Daily_filter->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     $total_Daily_filter->where('tb_employee_final_score.status_salary', '=',$search_status);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $total_Daily_filter->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Daily_filter->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $total_Daily_filter->where('tb_employee.position_description','like','%Manager%');
            }else{
                $total_Daily_filter->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $total_Daily_filter->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $total_Daily_filter->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $total_Daily_filter->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $total_Daily_filter->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $total_Daily_filter->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $total_Daily_filter->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $total_Daily_filter = $total_Daily_filter->first();
        // dd($total_Daily_filter->inc_amount_proposed);
        // exit;
        
        if($total_Daily_filter){
            if(!$total_Daily_filter->current_salary_wage){
                $total_Daily_filter->current_salary_wage = 0.00;
            }
            if(!$total_Daily_filter->L800_avg_wage_mwa){
                $total_Daily_filter->L800_avg_wage_mwa = 0.00;
            }
            if(!$total_Daily_filter->salary_wage_calculation){
                $total_Daily_filter->salary_wage_calculation = 0.00;
            }
            if(!$total_Daily_filter->current_salary_wage_month){
                $total_Daily_filter->current_salary_wage_month = 0.00;
            }
            if(!$total_Daily_filter->company_suggested_percent){
                $total_Daily_filter->company_suggested_percent = 0.00;
            }
            if(!$total_Daily_filter->company_suggested_amount){
                $total_Daily_filter->company_suggested_amount = 0.00;
            }
            if(!$total_Daily_filter->company_suggested_new_basic){
                $total_Daily_filter->company_suggested_new_basic = 0.00;
            }
            if(!$total_Daily_filter->inc_percent_proposed >= 0){
                $total_Daily_filter->inc_percent_proposed = 0.00;
            }
            if(!$total_Daily_filter->inc_amount_proposed){
                $total_Daily_filter->inc_amount_proposed = 0.00;
            }else{
                $total_Daily_filter->inc_amount_proposed = round($total_Daily_filter->inc_amount_proposed);
            }
            if(!$total_Daily_filter->new_basic_wage_proposed){
                $total_Daily_filter->new_basic_wage_proposed = 0.00;
            }
            if(!$total_Daily_filter->new_salary_wage_month){
                $total_Daily_filter->new_salary_wage_month = 0.00;
            }
            if($total_Daily_filter->salary_wage_calculation){
                if($total_Daily_filter->salary_wage_calculation > 0){
                    $cal = ((($total_Daily_filter->company_suggested_new_basic?$total_Daily_filter->company_suggested_new_basic:0)/($total_Daily_filter->salary_wage_calculation?$total_Daily_filter->salary_wage_calculation:0))-1)*100;
                    $total_Daily_filter->company_suggested_percent = $cal;
                }
                if($total_Daily_filter->current_salary_wage_month > 0){
                    // echo json_encode($total_Daily_filter);
                    // exit;
                    $cal2 = ((($total_Daily_filter->final_by_md_gm_amount?$total_Daily_filter->final_by_md_gm_amount:0)/($total_Daily_filter->current_salary_wage_month?$total_Daily_filter->current_salary_wage_month:0))-1)*100;
                    $total_Daily_filter->inc_percent_proposed = $cal2;
                }
            }else{
                $total_Daily_filter->company_suggested_percent = 0.00;
            }
        }
        
        

        $total_Monthly_filter = DB::table('tb_employee_final_score')
        ->select( 
            DB::raw('SUM(salary_old) AS current_salary_wage'),
            DB::raw('SUM(l800avg_wage) AS L800_avg_wage_mwa'),
            DB::raw('SUM(bsalary_wage) AS salary_wage_calculation'),
            DB::raw('SUM(salary_month_old) AS current_salary_wage_month'),
            DB::raw('SUM(company_suggested_per) AS company_suggested_percent'),
            DB::raw('SUM(company_suggestged_amount) AS company_suggested_amount'),
            DB::raw('SUM(company_suggestged_new_basic) AS company_suggested_new_basic'),
            DB::raw('SUM(percent_proposed) AS inc_percent_proposed'),
            DB::raw('SUM(amount_proposed) AS inc_amount_proposed'),
            DB::raw('SUM(salary_new) AS new_basic_wage_proposed'),
            DB::raw('SUM(salary_month_new) AS new_salary_wage_month'),
            DB::raw('SUM(final_by_md_gm_amount) AS final_by_md_gm_amount')
        )          
        // ->select('tb_employee_final_score.id','tb_employee_final_score.company_suggestged_new_basic')                         
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')                                                                                                                                                                                                                                                                            
        ->where('tb_employee_final_score.salary_type','Monthly')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        
        ;

        if($pagenow_salary == "1"){
            $total_Monthly_filter->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $total_Monthly_filter->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $total_Monthly_filter->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkatotal_Monthly_filter = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codetotal_Monthly_filter = [];
                    if($checkatotal_Monthly_filter >= 0){
                        $extotal_Monthly_filter = explode(',',$orisoft_all_code->division_code);
                        if(count($extotal_Monthly_filter)>0){
                            foreach ($extotal_Monthly_filter as $value) {
                                array_push($arr_division_codetotal_Monthly_filter,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codetotal_Monthly_filter,$orisoft_all_code->division_code);
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_codetotal_Monthly_filter);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codetotal_Monthly_filter = [];
                $checkatotal_Monthly_filter = strpos($orisoft_all_code->department_code,',');
                if($checkatotal_Monthly_filter >= 0){
                    $extotal_Monthly_filter = explode(',',$orisoft_all_code->department_code);
                    if(count($extotal_Monthly_filter)>0){
                        foreach ($extotal_Monthly_filter as $value) {
                            array_push($arr_department_codetotal_Monthly_filter,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codetotal_Monthly_filter,$orisoft_all_code->department_code);
                }
                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_codetotal_Monthly_filter);
            }
            // if($search_department == "all" || $search_department == ""){
                
            // }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Monthly_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Monthly_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $total_Monthly_filter->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
            $total_Monthly_filter->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $total_Monthly_filter->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $total_Monthly_filter->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $total_Monthly_filter->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $total_Monthly_filter->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all" && $search_department != ""){
        //     $total_Monthly_filter->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all" && $search_section != ""){
        //     $total_Monthly_filter->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $total_Monthly_filter->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_month_day != "all"){
            // $total_Monthly_filter->where('tb_employee_final_score.salary_type','Monthly');
        // }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $total_Monthly_filter->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $total_Monthly_filter->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     $total_Monthly_filter->where('tb_employee_final_score.status_salary', '=',$search_status);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $total_Monthly_filter->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Monthly_filter->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $total_Monthly_filter->where('tb_employee.position_description','like','%Manager%');
            }else{
                $total_Monthly_filter->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $total_Monthly_filter->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $total_Monthly_filter->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $total_Monthly_filter->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $total_Monthly_filter->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $total_Monthly_filter->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $total_Monthly_filter->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $total_Monthly_filter = $total_Monthly_filter->first();
        // dd($total_Monthly_filter);
        // exit;
        if($total_Monthly_filter){
            if(!$total_Monthly_filter->current_salary_wage){
                $total_Monthly_filter->current_salary_wage = 0.00;
            }
            if(!$total_Monthly_filter->L800_avg_wage_mwa){
                $total_Monthly_filter->L800_avg_wage_mwa = 0.00;
            }
            if(!$total_Monthly_filter->salary_wage_calculation){
                $total_Monthly_filter->salary_wage_calculation = 0.00;
            }
            if(!$total_Monthly_filter->current_salary_wage_month){
                $total_Monthly_filter->current_salary_wage_month = 0.00;
            }
            if(!$total_Monthly_filter->company_suggested_percent){
                $total_Monthly_filter->company_suggested_percent = 0.00;
            }
            if(!$total_Monthly_filter->company_suggested_amount){
                $total_Monthly_filter->company_suggested_amount = 0.00;
            }
            if(!$total_Monthly_filter->company_suggested_new_basic){
                $total_Monthly_filter->company_suggested_new_basic = 0.00;
            }
            if(!$total_Monthly_filter->inc_percent_proposed >= 0){
                $total_Monthly_filter->inc_percent_proposed = 0.00;
            }
            if(!$total_Monthly_filter->inc_amount_proposed){
                $total_Monthly_filter->inc_amount_proposed = 0.00;
            }
            if(!$total_Monthly_filter->new_basic_wage_proposed){
                $total_Monthly_filter->new_basic_wage_proposed = 0.00;
            }
            if(!$total_Monthly_filter->new_salary_wage_month){
                $total_Monthly_filter->new_salary_wage_month = 0.00;
            }
            if($total_Monthly_filter->company_suggested_percent){
                if($total_Monthly_filter->current_salary_wage > 0){
                    $cal = ((($total_Monthly_filter->company_suggested_new_basic?$total_Monthly_filter->company_suggested_new_basic:0)/($total_Monthly_filter->current_salary_wage?$total_Monthly_filter->current_salary_wage:0))-1)*100;
                    $total_Monthly_filter->company_suggested_percent = $cal;
                }
            }else{
                $total_Monthly_filter->company_suggested_percent = 0.00;
            }
            if($total_Monthly_filter->inc_percent_proposed >= 0){
                if($total_Monthly_filter->current_salary_wage > 0){
                    $cal2 = ((($total_Monthly_filter->new_basic_wage_proposed?$total_Monthly_filter->new_basic_wage_proposed:0)/($total_Monthly_filter->current_salary_wage?$total_Monthly_filter->current_salary_wage:0))-1)*100;
                    $total_Monthly_filter->inc_percent_proposed = $cal2;
                }
            }else{
                $total_Monthly_filter->inc_percent_proposed = 0.00;
            }
        }
        
        // dd($total_Daily_filter);
        // dd($total_Monthly_filter);
        // exit;
        $current_salary_wage = 0;
        $company_suggested_new_basic = 0;
        $company_suggested_percent = 0;
        
        $current_salary_wage_month = 0;
        $new_salary_wage_month = 0;
        $inc_percent_proposed = 0;

        if($total_Monthly_filter){
            if($total_Daily_filter->current_salary_wage){
                if($total_Daily_filter->current_salary_wage > 0){
                    $current_salary_wage = $total_Daily_filter->current_salary_wage+$total_Monthly_filter->current_salary_wage;
                    if($total_Daily_filter->company_suggested_new_basic){
                        $company_suggested_new_basic = $total_Daily_filter->company_suggested_new_basic+$total_Monthly_filter->company_suggested_new_basic;
                    }else{
                        $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
                    }
                    if($current_salary_wage > 0){
                        $company_suggested_percent = (($company_suggested_new_basic/$current_salary_wage)-1)*100;
                    }else{
                        $company_suggested_percent = 0;
                    }
                }
            }else{
                $current_salary_wage = $total_Monthly_filter->current_salary_wage;
                if($total_Daily_filter->company_suggested_new_basic){
                    $company_suggested_new_basic = $total_Daily_filter->company_suggested_new_basic+$total_Monthly_filter->company_suggested_new_basic;
                }else{
                    $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
                }
                // $company_suggested_new_basic = $total_Daily_filter->company_suggested_new_basic+$total_Monthly_filter->company_suggested_new_basic;
                // dd((($company_suggested_new_basic/$current_salary_wage)-1));
                if($current_salary_wage > 0){
                    $company_suggested_percent = (($company_suggested_new_basic/$current_salary_wage)-1)*100;
                }else{
                    $company_suggested_percent = 0;
                }
            }
            // exit;
            if($total_Daily_filter->current_salary_wage_month){
                if($total_Daily_filter->current_salary_wage_month > 0){
                    $current_salary_wage_month = $total_Daily_filter->current_salary_wage_month+$total_Monthly_filter->current_salary_wage_month;
                    $new_salary_wage_month = $total_Daily_filter->new_salary_wage_month+$total_Monthly_filter->new_salary_wage_month;
                    if($current_salary_wage_month > 0){
                        $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
                    }else{
                        $inc_percent_proposed = 0;
                    }
                }
            }else{
                $current_salary_wage_month = $total_Monthly_filter->current_salary_wage_month;
                $new_salary_wage_month = $total_Daily_filter->new_salary_wage_month+$total_Monthly_filter->new_salary_wage_month;
                if($current_salary_wage_month > 0){
                    $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
                }else{
                    $inc_percent_proposed = 0;
                }
            }
            $total_Daily_Monthly = [
                "current_salary_wage" => $total_Daily_filter->current_salary_wage+$total_Monthly_filter->current_salary_wage,
                "L800_avg_wage_mwa" => $total_Daily_filter->L800_avg_wage_mwa+$total_Monthly_filter->L800_avg_wage_mwa,
                "salary_wage_calculation" => $total_Daily_filter->salary_wage_calculation+$total_Monthly_filter->salary_wage_calculation,
                "current_salary_wage_month" => $total_Daily_filter->current_salary_wage_month+$total_Monthly_filter->current_salary_wage_month,
                "company_suggested_percent" => $company_suggested_percent,
                "company_suggested_amount" => $total_Daily_filter->company_suggested_amount+$total_Monthly_filter->company_suggested_amount,
                "company_suggested_new_basic" => $total_Daily_filter->company_suggested_new_basic+$total_Monthly_filter->company_suggested_new_basic,
                "inc_percent_proposed" => $inc_percent_proposed,
                "inc_amount_proposed" => round($total_Daily_filter->inc_amount_proposed)+$total_Monthly_filter->inc_amount_proposed,
                "new_basic_wage_proposed" => $total_Daily_filter->new_basic_wage_proposed+$total_Monthly_filter->new_basic_wage_proposed,
                "new_salary_wage_month" => $total_Daily_filter->new_salary_wage_month+$total_Monthly_filter->new_salary_wage_month,
                "final_by_md_gm_amount" => $total_Daily_filter->final_by_md_gm_amount+$total_Monthly_filter->final_by_md_gm_amount,
            ];
        }else{
            if($total_Daily_filter->current_salary_wage_month > 0){
                $current_salary_wage = $total_Daily_filter->current_salary_wage+0;
                $company_suggested_new_basic = $total_Daily_filter->company_suggested_new_basic+0;
                if($current_salary_wage > 0){
                    $company_suggested_percent = (($company_suggested_new_basic/$current_salary_wage)-1)*100;
                }else{
                    $company_suggested_percent = 0;
                }
            }
            if($total_Daily_filter->current_salary_wage_month > 0){
                $current_salary_wage_month = $total_Daily_filter->current_salary_wage_month+0;
                $new_salary_wage_month = $total_Daily_filter->new_salary_wage_month+0;
                if($current_salary_wage_month > 0){
                    $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
                }else{
                    $inc_percent_proposed = 0;
                }
                
            }
            $total_Daily_Monthly = [
                "current_salary_wage" => $total_Daily_filter->current_salary_wage+0,
                "L800_avg_wage_mwa" => $total_Daily_filter->L800_avg_wage_mwa+0,
                "salary_wage_calculation" => $total_Daily_filter->salary_wage_calculation+0,
                "current_salary_wage_month" => $total_Daily_filter->current_salary_wage_month+0,
                "company_suggested_percent" => $company_suggested_percent,
                "company_suggested_amount" => $total_Daily_filter->company_suggested_amount+0,
                "company_suggested_new_basic" => $total_Daily_filter->company_suggested_new_basic+0,
                "inc_percent_proposed" => $inc_percent_proposed,
                "inc_amount_proposed" => round($total_Daily_filter->inc_amount_proposed)+0,
                "new_basic_wage_proposed" => $total_Daily_filter->new_basic_wage_proposed+0,
                "new_salary_wage_month" => $total_Daily_filter->new_salary_wage_month+0,
                "final_by_md_gm_amount" => $total_Daily_filter->final_by_md_gm_amount+0,
            ];
        }
        
        
        
        $data_all = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')    
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ;
        // if(trans(request()->segment(1)) == 'manager'){

        // }else if(trans(request()->segment(1)) == 'mtl'){
        //     if($orisoft_code != "000002" && $orisoft_code != "990002"){
        //         $data_all->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        //     }
        // }else{

        // }
        if($pagenow == "2"){
            $data_all->where('tb_employee_final_score.freeze_to_pagrade', '1');
        }else{
            $data_all->where('tb_employee_final_score.freeze_to_pagrade', '1');
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkadata_all = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codedata_all = [];
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->division_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_division_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codedata_all,$orisoft_all_code->division_code);
                    }
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_division_codedata_all);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->department_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->department_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_department_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codedata_all,$orisoft_all_code->department_code);
                }
                $data_all = $data_all->whereIn('tb_employee.department_code',$arr_department_codedata_all);
            }

            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $data_all = $data_all->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_countsection);
                
                }
                if(!isset($search_department)){
                    $arr_department_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->department_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->department_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_department_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_codedata_all,$orisoft_all_code->department_code);
                    }
                    $data_all = $data_all->whereIn('tb_employee.department_code',$arr_department_codedata_all);
                }
    
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_all = $data_all->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $data_all = $data_all->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $data_all = $data_all->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $data_all = $data_all->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $data_all->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $data_all = $data_all->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_all = $data_all->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $data_all->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $data_all->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $data_all = $data_all->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $data_all = $data_all->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $data_all = $data_all->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $data_all->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $data_all = $data_all->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $data_all = $data_all->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_all = $data_all->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $data_all->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $data_all->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $data_all->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $data_all->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $data_all->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data_all->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $data_all->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $data_all->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all" && $search_department != ""){
        //     $data_all->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all" && $search_section != ""){
        //     $data_all->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $data_all->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data_all->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data_all->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $data_all->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $data_all->where('tb_employee.position_description','like','%Manager%');
            }else{
                $data_all->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        // if($search_grade != "all"){
        //     $data_all->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     $data_all->where('tb_employee_final_score.status_salary', '=',$search_status);
        // }
        // if($search_status != "all"){
        //     if($search_status == "-1"){
        //         $data_all->where('tb_employee_final_score.status_salary','0');
        //     }else{
        //         $data_all->where('tb_employee_final_score.status_salary',$search_status);
        //     }
        // }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $data_all->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $data_all->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $data_all->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $data_all->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $data_all->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $data_all->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data_all = $data_all->count();

        // $data_in = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')    
        // ->where('tb_employee_final_score.status_salary', '0')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
        // if($search_division != "all"){
        //     $data_in->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all"){
        //     $data_in->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all"){
        //     $data_in->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }

        // if($search_month_day != "all"){
        //     if($search_month_day == "1"){
        //         $data_in->where('tb_employee_final_score.salary_type','Daily');
        //     }
        //     if($search_month_day == "2"){
        //         $data_in->where('tb_employee_final_score.salary_type','Monthly');
        //     }
        // }
        // if($search_grade != "all"){
        //     $data_in->where('tb_employee.pa_grade', 'like','%'.$search_grade.'%');
        // }
        // if($search_status != "all"){
        //     $data_in->where('tb_employee_final_score.status_salary', '=',$search_status);
        // }
        // $data_in = $data_in->count();

        $data_reject = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')    
        ->where('tb_employee_final_score.status_salary', '2')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ;

        if($pagenow_salary == "1"){
            $data_reject->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $data_reject->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $data_reject->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkadata_reject = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codedata_reject = [];
                    if($checkadata_reject >= 0){
                        $exdata_reject = explode(',',$orisoft_all_code->division_code);
                        if(count($exdata_reject)>0){
                            foreach ($exdata_reject as $value) {
                                array_push($arr_division_codedata_reject,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codedata_reject,$orisoft_all_code->division_code);
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_division_codedata_reject);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codedata_reject = [];
                $checkadata_reject = strpos($orisoft_all_code->department_code,',');
                if($checkadata_reject >= 0){
                    $exdata_reject = explode(',',$orisoft_all_code->department_code);
                    if(count($exdata_reject)>0){
                        foreach ($exdata_reject as $value) {
                            array_push($arr_department_codedata_reject,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codedata_reject,$orisoft_all_code->department_code);
                }
                $data_reject = $data_reject->whereIn('tb_employee.department_code',$arr_department_codedata_reject);
            
            }
            // if($search_department == "all" || $search_department == ""){
                
            // }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $data_reject = $data_reject->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $data_reject = $data_reject->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $data_reject = $data_reject->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $data_reject->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $data_reject = $data_reject->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $data_reject->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $data_reject->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $data_reject = $data_reject->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $data_reject = $data_reject->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $data_reject->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $data_reject = $data_reject->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $data_reject = $data_reject->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_reject = $data_reject->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $data_reject->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $data_reject->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $data_reject->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $data_reject->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $data_reject->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data_reject->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $data_reject->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $data_reject->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all" && $search_department != ""){
        //     $data_reject->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all" && $search_section != ""){
        //     $data_reject->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $data_reject->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data_reject->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data_reject->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $data_reject->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $data_reject->where('tb_employee.position_description','like','%Manager%');
            }else{
                $data_reject->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        // if($search_grade != "all"){
        //     $data_reject->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     if($search_status == "-1"){
        //         $data_reject->where('tb_employee_final_score.status_salary','0');
        //     }else{
        //         $data_reject->where('tb_employee_final_score.status_salary',$search_status);
        //     }
        // }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $data_reject->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $data_reject->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $data_reject->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $data_reject->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $data_reject->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $data_reject->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data_reject = $data_reject->count();

        $data_finish = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')    
        ->where('tb_employee_final_score.status_salary', '1')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ;

        if($pagenow_salary == "1"){
            $data_finish->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $data_finish->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $data_finish->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
            if(!isset($search_division)){
                    $checkadata_finish = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codedata_finish = [];
                    if($checkadata_finish >= 0){
                        $exdata_finish = explode(',',$orisoft_all_code->division_code);
                        if(count($exdata_finish)>0){
                            foreach ($exdata_finish as $value) {
                                array_push($arr_division_codedata_finish,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codedata_finish,$orisoft_all_code->division_code);
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_division_codedata_finish);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
            if(!isset($search_department)){
                $arr_department_codedata_finish = [];
                $checkadata_finish = strpos($orisoft_all_code->department_code,',');
                if($checkadata_finish >= 0){
                    $exdata_finish = explode(',',$orisoft_all_code->department_code);
                    if(count($exdata_finish)>0){
                        foreach ($exdata_finish as $value) {
                            array_push($arr_department_codedata_finish,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codedata_finish,$orisoft_all_code->department_code);
                }
                $data_finish = $data_finish->whereIn('tb_employee.department_code',$arr_department_codedata_finish);
            }
            // if($search_department == "all" || $search_department == ""){
                
            // }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $data_finish = $data_finish->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
            // if($search_division == "all" || $search_division == ""){
                
            // }
        }

        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $data_finish = $data_finish->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $data_finish = $data_finish->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $data_finish->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $data_finish = $data_finish->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $data_finish->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $data_finish->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $data_finish = $data_finish->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $data_finish = $data_finish->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $data_finish->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $data_finish = $data_finish->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $data_finish = $data_finish->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $data_finish = $data_finish->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $data_finish->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $data_finish->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $data_finish->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $data_finish->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $data_finish->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data_finish->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $data_finish->whereIn('tb_employee.section_code', $search_section);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $data_finish->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        // if($search_department != "all" && $search_department != ""){
        //     $data_finish->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        // }
        // if($search_section != "all" && $search_section != ""){
        //     $data_finish->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        // }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $data_finish->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data_finish->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data_finish->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $data_finish->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $data_finish->where('tb_employee.position_description','like','%Manager%');
            }else{
                $data_finish->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        // if($search_grade != "all"){
        //     $data_finish->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        // if($search_status != "all"){
        //     if($search_status == "-1"){
        //         $data_finish->where('tb_employee_final_score.status_salary','0');
        //     }else{
        //         $data_finish->where('tb_employee_final_score.status_salary',$search_status);
        //     }
        // }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $data_finish->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $data_finish->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $data_finish->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $data_finish->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $data_finish->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $data_finish->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data_finish = $data_finish->count();



        $percent_department = [];
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $secx = DB::table('tb_employee_evaluator')
                ->whereIn('tb_employee_evaluator.employee_no',$search_employee_no)
                ->first();

                $percent_department = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.section_code','like','%'.$secx->section_code.'%')
                ->first();
            }else{
                $percent_department = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.section_code',$search_section)
                ->first();
            }
        }else{
            $percent_department = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.section_code',$search_section)
                ->first();
        }
        
































        $total_footer_Daily = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee_final_score.*',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee_final_score.salary_type','Daily')
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;
        if($pagenow_salary == "1"){
            $total_footer_Daily->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $total_footer_Daily->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $total_footer_Daily->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                    $total_footer_Daily->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
            }
            if(!isset($search_department)){
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
                $total_footer_Daily->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
            }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_countsection);
            }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_countsection);
            }
        }
        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_countsection);
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_countsection);
            }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_footer_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_footer_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_footer_Daily->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_footer_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_footer_Daily = $total_footer_Daily->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_footer_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_footer_Daily->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $total_footer_Daily->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
            $total_footer_Daily->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $total_footer_Daily->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $total_footer_Daily->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $total_footer_Daily->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $total_footer_Daily->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $total_footer_Daily->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $total_footer_Daily->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $total_footer_Daily->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_footer_Daily->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $total_footer_Daily->where('tb_employee.position_description','like','%Manager%');
            }else{
                $total_footer_Daily->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $total_footer_Daily->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $total_footer_Daily->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $total_footer_Daily->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $total_footer_Daily->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $total_footer_Daily->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $total_footer_Daily->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $total_footer_Daily = $total_footer_Daily->get();
        $salary_old_gmdm_Daily = 0;
        $percent_proposed_old_gmdm_Daily = 0;
        $percent_proposed_gmdm_Daily = 0;
        $percent_proposed_gmdm_Dailyxxx = '';
        $amount_proposed_gmdm_Daily = 0;
        $salary_new_gmdm_Daily = 0;
        $salary_month_new_gmdm_Daily = 0;
        $final_by_md_gm_amountxxx = 0;
        if(count($total_footer_Daily)>0){
            foreach ($total_footer_Daily as $key => $value_footer) {
                $salary_old_gmdm_Daily += $value_footer->salary_month_old;

                if($value_footer->percent_proposed_old_gmdm == 0){
                    $percent_proposed_old_gmdm_Daily += $value_footer->percent_proposed_old;
                }else{
                    $percent_proposed_old_gmdm_Daily += $value_footer->percent_proposed_old_gmdm;
                }
                // $value_footer->amount_proposed = $value_footer->amount_proposed;
                
                
                
                
                if($value_footer->amount_proposed_gmdm == 0){
                    $amount_proposed_gmdm_Daily += round($value_footer->amount_proposed);
                }else{
                    $amount_proposed_gmdm_Daily += $value_footer->amount_proposed_gmdm;
                }
                if($value_footer->salary_new_gmdm == 0){
                    $salary_new_gmdm_Daily += $value_footer->salary_new;
                }else{
                    $salary_new_gmdm_Daily += $value_footer->salary_new_gmdm;
                }
                if($value_footer->salary_month_new_gmdm == 0){
                    $salary_month_new_gmdm_Daily += $value_footer->salary_month_new;
                }else{
                    $salary_month_new_gmdm_Daily += $value_footer->salary_month_new_gmdm;
                }

                $final_by_md_gm_amountxxx += $value_footer->final_by_md_gm_amount;
            }
        }
        // dd($total_footer_Daily);
        // exit;
        
        if($salary_old_gmdm_Daily > 0 && $final_by_md_gm_amountxxx > 0){
            $cal2_value_footer = ((($final_by_md_gm_amountxxx?$final_by_md_gm_amountxxx:0)/($salary_old_gmdm_Daily?$salary_old_gmdm_Daily:0))-1)*100;
            // $value_footer->percent_proposed_gmdm = $cal2_value_footer;
            $percent_proposed_gmdm_Daily += $cal2_value_footer;
            $percent_proposed_gmdm_Dailyxxx .= $final_by_md_gm_amountxxx.'---'.$salary_old_gmdm_Daily;
        }





        $total_footer_Monthly = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee_final_score.*',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee_final_score.salary_type','Monthly')
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;
        if($pagenow_salary == "1"){
            $total_footer_Monthly->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $total_footer_Monthly->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $total_footer_Monthly->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                    $total_footer_Monthly->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
            }
            if(!isset($search_department)){
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
                $total_footer_Monthly->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
            }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
            }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
            }
        }
        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
            }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_footer_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_footer_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_footer_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $total_footer_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $total_footer_Monthly = $total_footer_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_footer_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_footer_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $total_footer_Monthly->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2" || $search_not_up_salary == "3"){
            $total_footer_Monthly->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $total_footer_Monthly->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $total_footer_Monthly->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $total_footer_Monthly->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $total_footer_Monthly->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $total_footer_Monthly->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $total_footer_Monthly->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $total_footer_Monthly->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_footer_Monthly->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $total_footer_Monthly->where('tb_employee.position_description','like','%Manager%');
            }else{
                $total_footer_Monthly->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $total_footer_Monthly->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $total_footer_Monthly->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $total_footer_Monthly->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $total_footer_Monthly->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $total_footer_Monthly->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $total_footer_Monthly->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $total_footer_Monthly = $total_footer_Monthly->get();
        $salary_old_gmdm_Monthly = 0;
        $percent_proposed_old_gmdm_Monthly = 0;
        $percent_proposed_gmdm_Monthly = 0;
        $amount_proposed_gmdm_Monthly = 0;
        $salary_new_gmdm_Monthly = 0;
        $salary_month_new_gmdm_Monthly = 0;
        if(count($total_footer_Monthly)>0){
            foreach ($total_footer_Monthly as $key => $value_footer) {
                $salary_old_gmdm_Monthly += $value_footer->salary_old;

                if($value_footer->percent_proposed_old_gmdm == 0){
                    $percent_proposed_old_gmdm_Monthly += $value_footer->percent_proposed_old;
                }else{
                    $percent_proposed_old_gmdm_Monthly += $value_footer->percent_proposed_old_gmdm;
                }
                
                
                
                if($value_footer->amount_proposed_gmdm == 0){
                    $amount_proposed_gmdm_Monthly += $value_footer->amount_proposed;
                }else{
                    $amount_proposed_gmdm_Monthly += $value_footer->amount_proposed_gmdm;
                }
                if($value_footer->salary_new_gmdm == 0){
                    $salary_new_gmdm_Monthly += $value_footer->salary_new;
                }else{
                    $salary_new_gmdm_Monthly += $value_footer->salary_new_gmdm;
                }
                if($value_footer->salary_month_new_gmdm == 0){
                    $salary_month_new_gmdm_Monthly += $value_footer->salary_month_new;
                }else{
                    $salary_month_new_gmdm_Monthly += $value_footer->salary_month_new_gmdm;
                }
            }
        }

        if($salary_old_gmdm_Monthly > 0 && $salary_new_gmdm_Monthly > 0){
            $cal2_value_footer = ((($salary_new_gmdm_Monthly?$salary_new_gmdm_Monthly:0)/($salary_old_gmdm_Monthly?$salary_old_gmdm_Monthly:0))-1)*100;
            $value_footer->percent_proposed_gmdm = $cal2_value_footer;
            $percent_proposed_gmdm_Monthly += $value_footer->percent_proposed_gmdm;
        }

        $current_salary_wage_monthx = $total_Daily_filter->current_salary_wage_month+$total_Monthly_filter->current_salary_wage_month;
        // dd($salary_month_new_gmdm_Daily);
        // exit;
        $salary_month_new_gmdm_Monthly_Daily = $salary_month_new_gmdm_Daily+$salary_month_new_gmdm_Monthly;
        $percent_proposed_gmdm_Monthly_Daily = 0;
        if($current_salary_wage_monthx > 0 && $salary_month_new_gmdm_Monthly_Daily > 0){
            // $cal2_value_footer = ((($salary_new_gmdm_Daily?$salary_new_gmdm_Daily:0)/($salary_old_gmdm_Daily?$salary_old_gmdm_Daily:0))-1)*100;
            // $value_footer->percent_proposed_gmdm = $cal2_value_footer;
            // $percent_proposed_gmdm_Daily += $value_footer->percent_proposed_gmdm;
            
            $current_salary_wage_month = $total_Daily_filter->current_salary_wage_month+$total_Monthly_filter->current_salary_wage_month;
            if($current_salary_wage_month > 0){
                $percent_proposed_gmdm_Monthly_Daily = (($salary_month_new_gmdm_Monthly_Daily/$current_salary_wage_month)-1)*100;
            }else{
                $percent_proposed_gmdm_Monthly_Daily = 0;
            }
        }

        $total_Daily_filter->percent_proposed_old_gmdm = $percent_proposed_old_gmdm_Daily;
        $total_Daily_filter->percent_proposed_gmdm = $percent_proposed_gmdm_Daily;
        $total_Daily_filter->percent_proposed_gmdmxxx = $percent_proposed_gmdm_Dailyxxx;
        $total_Daily_filter->amount_proposed_gmdm = round($amount_proposed_gmdm_Daily);
        $total_Daily_filter->salary_new_gmdm = $salary_new_gmdm_Daily;
        $total_Daily_filter->salary_month_new_gmdm = $salary_month_new_gmdm_Daily;

        $total_Monthly_filter->percent_proposed_old_gmdm = $percent_proposed_old_gmdm_Monthly;
        $total_Monthly_filter->percent_proposed_gmdm = $percent_proposed_gmdm_Monthly;
        $total_Monthly_filter->amount_proposed_gmdm = $amount_proposed_gmdm_Monthly;
        $total_Monthly_filter->salary_new_gmdm = $salary_new_gmdm_Monthly;
        $total_Monthly_filter->salary_month_new_gmdm = $salary_month_new_gmdm_Monthly;

        // if($total_Daily_filter->current_salary_wage_month){
        //     if($total_Daily_filter->current_salary_wage_month > 0){
        //         $current_salary_wage_month = $total_Daily_filter->current_salary_wage_month+$total_Monthly_filter->current_salary_wage_month;
        //         $new_salary_wage_month = $total_Daily_filter->new_salary_wage_month+$total_Monthly_filter->new_salary_wage_month;
        //         if($current_salary_wage_month > 0){
        //             $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
        //         }else{
        //             $inc_percent_proposed = 0;
        //         }
        //     }
        // }else{
        //     $current_salary_wage_month = $total_Monthly_filter->current_salary_wage_month;
        //     $new_salary_wage_month = $total_Daily_filter->new_salary_wage_month+$total_Monthly_filter->new_salary_wage_month;
        //     if($current_salary_wage_month > 0){
        //         $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
        //     }else{
        //         $inc_percent_proposed = 0;
        //     }
        // }
        
        $total_Daily_Monthly['percent_proposed_old_gmdm'] = $percent_proposed_gmdm_Monthly_Daily;
        $total_Daily_Monthly['percent_proposed_gmdm'] = $percent_proposed_gmdm_Monthly_Daily;
        $total_Daily_Monthly['amount_proposed_gmdm'] = round($amount_proposed_gmdm_Daily)+$amount_proposed_gmdm_Monthly;
        $total_Daily_Monthly['salary_new_gmdm'] = $salary_new_gmdm_Daily+$salary_new_gmdm_Monthly;
        $total_Daily_Monthly['salary_month_new_gmdm'] = $salary_month_new_gmdm_Daily+$salary_month_new_gmdm_Monthly;


        

        $submit_to_dmgm = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.id','2147')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        
        // ->whereIn('tb_employee_final_score.evaluator_no',$evaluator_code)
        ;
        if($pagenow_salary == "1"){
            $submit_to_dmgm->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $submit_to_dmgm->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $submit_to_dmgm->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                    $submit_to_dmgm->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
            }
            if(!isset($search_department)){
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
                $submit_to_dmgm->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
            }
            if(!isset($search_section)){
                $arr_section_codedata_all = [];
                $checkadata_all = strpos($orisoft_all_code->section_code,',');
                if($checkadata_all >= 0){
                    $exdata_all = explode(',',$orisoft_all_code->section_code);
                    if(count($exdata_all)>0){
                        foreach ($exdata_all as $value) {
                            array_push($arr_section_codedata_all,$value);
                        }
                    }
                }else{
                    array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                }
                $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }else{
                if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $submit_to_dmgm->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $submit_to_dmgm->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $submit_to_dmgm->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // if(!isset($search_division)){
                //     $checka = strpos($orisoft_all_code->division_code,',');
                //     $arr_division_code = [];
                //     if($checka >= 0){
                //         $ex = explode(',',$orisoft_all_code->division_code);
                //         if(count($ex)>0){
                //             foreach ($ex as $value) {
                //                 array_push($arr_division_code,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_division_code,$orisoft_all_code->division_code);
                //     }
                //     $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_division_code);
                    
                // }
                // if(!isset($search_department)){
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
                //         $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.department_code',$arr_department_code);
                    
                // }
                // if(!isset($search_section)){
                //     $arr_section_codedata_all = [];
                //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                //     if($checkadata_all >= 0){
                //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                //         if(count($exdata_all)>0){
                //             foreach ($exdata_all as $value) {
                //                 array_push($arr_section_codedata_all,$value);
                //             }
                //         }
                //     }else{
                //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                //     }
                //     $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                // }
                // $submit_to_dmgm->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
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
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $submit_to_dmgm = $submit_to_dmgm->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $submit_to_dmgm->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $submit_to_dmgm->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_not_up_salary == "1"){
            $submit_to_dmgm->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $submit_to_dmgm->whereNull('tb_employee_final_score.not_up_salary');
        }
        if(isset($search_division)){
            if(count($search_division) > 0){
                $submit_to_dmgm->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $submit_to_dmgm->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $submit_to_dmgm->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $submit_to_dmgm->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $submit_to_dmgm->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $submit_to_dmgm->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $submit_to_dmgm->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        // if($search_grade != "all"){
        //     $submit_to_dmgm->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all"){
            if($search_status == "-1"){
                $submit_to_dmgm->where('tb_employee_final_score.status_salary','0');
            }else{
                $submit_to_dmgm->where('tb_employee_final_score.status_salary','0');
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $submit_to_dmgm->where('tb_employee.position_description','like','%Manager%');
            }else{
                $submit_to_dmgm->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($search_complaince_score != "all"){
            if($search_complaince_score == "1"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "all"){
            if($search_attendance_score == "1"){
                $submit_to_dmgm->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $submit_to_dmgm->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $submit_to_dmgm->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $submit_to_dmgm = $submit_to_dmgm->count();

        if($pagenow == "2"){
            if(Auth::user()->can('view review salary')){
                $submit_to_approve_hr = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
                ->where('tb_employee.employee_status_description','Passed')
                // ->where('tb_employee_final_score.id','2147')
                // ->where('tb_employee_final_score.freeze','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '3')
                ->whereNotNull('tb_employee_final_score.salary_month_old')
                ->whereNotNull('tb_employee_final_score.adjust_grade')
                ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                
                // ->whereIn('tb_employee_final_score.evaluator_no',$evaluator_code)
                ;
                $submit_to_approve_hr->where('tb_employee_final_score.freeze_to_approve_hr', '1');

                $orisoft_code = Auth::user()->orisoft_code;
                $orisoft_all_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                            $submit_to_approve_hr->where(function ($query) use($arr_division_code) {
                                foreach ($arr_division_code as $value) {
                                    $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                                }
                            });
                    }
                    if(!isset($search_department)){
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
                        $submit_to_approve_hr->where(function ($query) use($arr_department_code) {
                            foreach ($arr_department_code as $value) {
                                $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                            }
                        });
                    }
                    if(!isset($search_section)){
                        $arr_section_codedata_all = [];
                        $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        if($checkadata_all >= 0){
                            $exdata_all = explode(',',$orisoft_all_code->section_code);
                            if(count($exdata_all)>0){
                                foreach ($exdata_all as $value) {
                                    array_push($arr_section_codedata_all,$value);
                                }
                            }
                        }else{
                            array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        }
                        $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                }
                if($orisoft_code == "990002"){
                    if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                }
                if($orisoft_code == "000002"){
                    if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                }

                if($orisoft_code == "000026"){
                    if(trans(request()->segment(1)) == 'manager'){
                        if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by1','000026');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                    }else{
                        if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by2','000026');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                    }
                    
                }
                if(trans(request()->segment(1)) == 'manager'){
                    if($orisoft_code == "000002"){
                        // if(!isset($search_division)){
                        //     $checka = strpos($orisoft_all_code->division_code,',');
                        //     $arr_division_code = [];
                        //     if($checka >= 0){
                        //         $ex = explode(',',$orisoft_all_code->division_code);
                        //         if(count($ex)>0){
                        //             foreach ($ex as $value) {
                        //                 array_push($arr_division_code,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_division_code,$orisoft_all_code->division_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        // }
                        // if(!isset($search_department)){
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
                        //         $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        // }
                        // if(!isset($search_section)){
                        //     $arr_section_codedata_all = [];
                        //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        //     if($checkadata_all >= 0){
                        //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                        //         if(count($exdata_all)>0){
                        //             foreach ($exdata_all as $value) {
                        //                 array_push($arr_section_codedata_all,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        // }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    }else if($orisoft_code == "990002"){
                
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
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        }
                        if(!isset($search_department)){
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
                                $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        }
                        if(!isset($search_section)){
                            $arr_section_codedata_all = [];
                            $checkadata_all = strpos($orisoft_all_code->section_code,',');
                            if($checkadata_all >= 0){
                                $exdata_all = explode(',',$orisoft_all_code->section_code);
                                if(count($exdata_all)>0){
                                    foreach ($exdata_all as $value) {
                                        array_push($arr_section_codedata_all,$value);
                                    }
                                }
                            }else{
                                array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                        $submit_to_approve_hr->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                    }
                }else if(trans(request()->segment(1)) == 'mtl'){
                    if($orisoft_code == "000002"){
                        // if(!isset($search_division)){
                        //     $checka = strpos($orisoft_all_code->division_code,',');
                        //     $arr_division_code = [];
                        //     if($checka >= 0){
                        //         $ex = explode(',',$orisoft_all_code->division_code);
                        //         if(count($ex)>0){
                        //             foreach ($ex as $value) {
                        //                 array_push($arr_division_code,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_division_code,$orisoft_all_code->division_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        // }
                        // if(!isset($search_department)){
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
                        //         $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        // }
                        // if(!isset($search_section)){
                        //     $arr_section_codedata_all = [];
                        //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        //     if($checkadata_all >= 0){
                        //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                        //         if(count($exdata_all)>0){
                        //             foreach ($exdata_all as $value) {
                        //                 array_push($arr_section_codedata_all,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        // }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    }else if($orisoft_code == "990002"){
                
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
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        }
                        if(!isset($search_department)){
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
                                $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        }
                        if(!isset($search_section)){
                            $arr_section_codedata_all = [];
                            $checkadata_all = strpos($orisoft_all_code->section_code,',');
                            if($checkadata_all >= 0){
                                $exdata_all = explode(',',$orisoft_all_code->section_code);
                                if(count($exdata_all)>0){
                                    foreach ($exdata_all as $value) {
                                        array_push($arr_section_codedata_all,$value);
                                    }
                                }
                            }else{
                                array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                        $submit_to_approve_hr->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                    }
                }else{
        
                }
                if($search_not_up_salary == "1"){
                    $submit_to_approve_hr->whereNotNull('tb_employee_final_score.not_up_salary');
                }else if($search_not_up_salary == "2"){
                    $submit_to_approve_hr->whereNull('tb_employee_final_score.not_up_salary');
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee.division_code', $search_division);
                    }
                }
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee.department_code', $search_department);
                    }
                }
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee.section_code', $search_section);
                    }
                }
                if(isset($search_employee_no)){
                    if(count($search_employee_no) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                    }
                }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $submit_to_approve_hr->where('tb_employee_final_score.salary_type','Daily');
                    }
                    if($search_month_day == "2"){
                        $submit_to_approve_hr->where('tb_employee_final_score.salary_type','Monthly');
                    }
                }
                if(isset($search_grade)){
                    if(count($search_grade) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
                    }
                }
                // if($search_grade != "all"){
                //     $submit_to_approve_hr->where('tb_employee_final_score.grade_proposed',$search_grade);
                // }
                if($search_status != "all"){
                    if($search_status == "-1"){
                        $submit_to_approve_hr->where('tb_employee_final_score.status_salary','0');
                    }else{
                        $submit_to_approve_hr->where('tb_employee_final_score.status_salary','0');
                    }
                }
                if($search_group != "all" && $search_group != ""){
                    if($search_group == "1"){
                        $submit_to_approve_hr->where('tb_employee.position_description','like','%Manager%');
                    }else{
                        $submit_to_approve_hr->where('tb_employee.position_description','not like','%Manager%');
                    }
                }
                if($search_complaince_score != "all"){
                    if($search_complaince_score == "1"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
                    }
                    if($search_complaince_score == "2"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
                    }
                    if($search_complaince_score == "3"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
                    }
                }

                if($search_attendance_score != "all"){
                    if($search_attendance_score == "1"){
                        $submit_to_approve_hr->where('tb_employee_final_score.attendance_score', '>=' ,'15');
                    }
                    if($search_attendance_score == "2"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
                    }
                    if($search_attendance_score == "3"){
                        $submit_to_approve_hr->where('tb_employee_final_score.attendance_score', '<=' ,'6');
                    }
                }
                $submit_to_approve_hr = $submit_to_approve_hr->count();
                $result = [
                    'percent_department'=> $percent_department,
                    // 'current_salary_wage'=> $current_salary_wage,
                    'total_Daily'=> $total_Daily_filter,
                    'total_Monthly'=> $total_Monthly_filter,
                    'total_Daily_Monthly'=> $total_Daily_Monthly,
                    'footer'=> $tb_total_all,
                    'countdata'=>$countdata,
                    "data_all" => $data_all,
                    "data_in" => $data_all-$submit_to_dmgm,
                    "data_reject" => $data_reject,
                    "data_finish" => $data_finish,
                    "submit_to_dmgm" => $submit_to_dmgm,
                    "submit_to_approve_hr" => $submit_to_approve_hr
                ];
            }else{
                $result = [];
            }
        }else{
            if($pagenow_salary == "1"){
                $submit_to_approve_hr = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                // ->where('tb_employee_final_score.evaluator_no',$orisoft_code->orisoft_code)
                ->where('tb_employee.employee_status_description','Passed')
                // ->where('tb_employee_final_score.id','2147')
                // ->where('tb_employee_final_score.freeze','1')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '3')
                ->whereNotNull('tb_employee_final_score.salary_month_old')
                ->whereNotNull('tb_employee_final_score.adjust_grade')
                ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
                
                // ->whereIn('tb_employee_final_score.evaluator_no',$evaluator_code)
                ;
                // if($search_status != "all"){
                //     if($search_status == "-1"){
                //         $submit_to_approve_hr->where('tb_employee_final_score.freeze_to_approve_hr', '0');
                //     }else{
                        $submit_to_approve_hr->where('tb_employee_final_score.freeze_to_approve_hr', '1');
                //     }
                // }
                // $submit_to_approve_hr = $submit_to_approve_hr->get();
                // $result = [
                //     'submit_to_approve_hr'    => $submit_to_approve_hr
                // ];
                // echo json_encode($result);
                // exit;
                $orisoft_code = Auth::user()->orisoft_code;
                $orisoft_all_code = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
                ->where('employee_no',$orisoft_code)->first();

                if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                            $submit_to_approve_hr->where(function ($query) use($arr_division_code) {
                                foreach ($arr_division_code as $value) {
                                    $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                                }
                            });
                    }
                    if(!isset($search_department)){
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
                        $submit_to_approve_hr->where(function ($query) use($arr_department_code) {
                            foreach ($arr_department_code as $value) {
                                $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                            }
                        });
                    }
                    if(!isset($search_section)){
                        $arr_section_codedata_all = [];
                        $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        if($checkadata_all >= 0){
                            $exdata_all = explode(',',$orisoft_all_code->section_code);
                            if(count($exdata_all)>0){
                                foreach ($exdata_all as $value) {
                                    array_push($arr_section_codedata_all,$value);
                                }
                            }
                        }else{
                            array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        }
                        $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                }
                if($orisoft_code == "990002"){
                    if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                }
                if($orisoft_code == "000002"){
                    if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by2','000002');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                }

                if($orisoft_code == "000026"){
                    if(trans(request()->segment(1)) == 'manager'){
                        if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by1','000026');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                    }else{
                        if(!isset($search_division)){
                            $arr_countsection = [];
                            $countsection = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.division_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.approve_by2','000026');
                            $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                            if(count($countsection)>0){
                                foreach ($countsection as $value) {
                                    array_push($arr_countsection,$value->division_code);
                                }
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_countsection);
                        
                    }
                    }
                    
                }
                if(trans(request()->segment(1)) == 'manager'){
                    if($orisoft_code == "000002"){
                        // if(!isset($search_division)){
                        //     $checka = strpos($orisoft_all_code->division_code,',');
                        //     $arr_division_code = [];
                        //     if($checka >= 0){
                        //         $ex = explode(',',$orisoft_all_code->division_code);
                        //         if(count($ex)>0){
                        //             foreach ($ex as $value) {
                        //                 array_push($arr_division_code,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_division_code,$orisoft_all_code->division_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        // }
                        // if(!isset($search_department)){
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
                        //         $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        // }
                        // if(!isset($search_section)){
                        //     $arr_section_codedata_all = [];
                        //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        //     if($checkadata_all >= 0){
                        //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                        //         if(count($exdata_all)>0){
                        //             foreach ($exdata_all as $value) {
                        //                 array_push($arr_section_codedata_all,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        // }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    }else if($orisoft_code == "990002"){
                
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
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        }
                        if(!isset($search_department)){
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
                                $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        }
                        if(!isset($search_section)){
                            $arr_section_codedata_all = [];
                            $checkadata_all = strpos($orisoft_all_code->section_code,',');
                            if($checkadata_all >= 0){
                                $exdata_all = explode(',',$orisoft_all_code->section_code);
                                if(count($exdata_all)>0){
                                    foreach ($exdata_all as $value) {
                                        array_push($arr_section_codedata_all,$value);
                                    }
                                }
                            }else{
                                array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                        $submit_to_approve_hr->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                    }
                }else if(trans(request()->segment(1)) == 'mtl'){
                    if($orisoft_code == "000002"){
                        // if(!isset($search_division)){
                        //     $checka = strpos($orisoft_all_code->division_code,',');
                        //     $arr_division_code = [];
                        //     if($checka >= 0){
                        //         $ex = explode(',',$orisoft_all_code->division_code);
                        //         if(count($ex)>0){
                        //             foreach ($ex as $value) {
                        //                 array_push($arr_division_code,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_division_code,$orisoft_all_code->division_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        // }
                        // if(!isset($search_department)){
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
                        //         $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        // }
                        // if(!isset($search_section)){
                        //     $arr_section_codedata_all = [];
                        //     $checkadata_all = strpos($orisoft_all_code->section_code,',');
                        //     if($checkadata_all >= 0){
                        //         $exdata_all = explode(',',$orisoft_all_code->section_code);
                        //         if(count($exdata_all)>0){
                        //             foreach ($exdata_all as $value) {
                        //                 array_push($arr_section_codedata_all,$value);
                        //             }
                        //         }
                        //     }else{
                        //         array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                        //     }
                        //     $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        // }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    }else if($orisoft_code == "990002"){
                
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
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.division_code',$arr_division_code);
                            
                        }
                        if(!isset($search_department)){
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
                                $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.department_code',$arr_department_code);
                            
                        }
                        if(!isset($search_section)){
                            $arr_section_codedata_all = [];
                            $checkadata_all = strpos($orisoft_all_code->section_code,',');
                            if($checkadata_all >= 0){
                                $exdata_all = explode(',',$orisoft_all_code->section_code);
                                if(count($exdata_all)>0){
                                    foreach ($exdata_all as $value) {
                                        array_push($arr_section_codedata_all,$value);
                                    }
                                }
                            }else{
                                array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                            }
                            $submit_to_approve_hr = $submit_to_approve_hr->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                        }
                        // $submit_to_approve_hr->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                        $submit_to_approve_hr->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                    }
                }else{
        
                }
                if($search_not_up_salary == "1"){
                    $submit_to_approve_hr->whereNotNull('tb_employee_final_score.not_up_salary');
                }else if($search_not_up_salary == "2"){
                    $submit_to_approve_hr->whereNull('tb_employee_final_score.not_up_salary');
                }
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee.division_code', $search_division);
                    }
                }
                if(isset($search_department)){
                    if(count($search_department) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee.department_code', $search_department);
                    }
                }
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee.section_code', $search_section);
                    }
                }
                if(isset($search_employee_no)){
                    if(count($search_employee_no) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
                    }
                }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $submit_to_approve_hr->where('tb_employee_final_score.salary_type','Daily');
                    }
                    if($search_month_day == "2"){
                        $submit_to_approve_hr->where('tb_employee_final_score.salary_type','Monthly');
                    }
                }
                if(isset($search_grade)){
                    if(count($search_grade) > 0){
                        $submit_to_approve_hr->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
                    }
                }
                // if($search_grade != "all"){
                //     $submit_to_approve_hr->where('tb_employee_final_score.grade_proposed',$search_grade);
                // }
                // if($search_status != "all"){
                //     if($search_status == "-1"){
                //         $submit_to_approve_hr->where('tb_employee_final_score.status_salary','0');
                //     }else{
                //         $submit_to_approve_hr->where('tb_employee_final_score.status_salary','0');
                //     }
                // }
                if($search_group != "all" && $search_group != ""){
                    if($search_group == "1"){
                        $submit_to_approve_hr->where('tb_employee.position_description','like','%Manager%');
                    }else{
                        $submit_to_approve_hr->where('tb_employee.position_description','not like','%Manager%');
                    }
                }
                if($search_complaince_score != "all"){
                    if($search_complaince_score == "1"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
                    }
                    if($search_complaince_score == "2"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
                    }
                    if($search_complaince_score == "3"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
                    }
                }

                if($search_attendance_score != "all"){
                    if($search_attendance_score == "1"){
                        $submit_to_approve_hr->where('tb_employee_final_score.attendance_score', '>=' ,'15');
                    }
                    if($search_attendance_score == "2"){
                        $submit_to_approve_hr->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
                    }
                    if($search_attendance_score == "3"){
                        $submit_to_approve_hr->where('tb_employee_final_score.attendance_score', '<=' ,'6');
                    }
                }
                $submit_to_approve_hr = $submit_to_approve_hr->count();
                $result = [
                    'percent_department'=> $percent_department,
                    // 'current_salary_wage'=> $current_salary_wage,
                    'total_Daily'=> $total_Daily_filter,
                    'total_Monthly'=> $total_Monthly_filter,
                    'total_Daily_Monthly'=> $total_Daily_Monthly,
                    'footer'=> $tb_total_all,
                    'countdata'=>$countdata,
                    "data_all" => $data_all,
                    "data_in" => $data_all-$data_finish,
                    "data_reject" => $data_reject,
                    "data_finish" => $data_finish,
                    "submit_to_dmgm" => $submit_to_dmgm,
                    "submit_to_approve_hr" => $submit_to_approve_hr,
                ];
            }else{
                $result = [
                    'percent_department'=> $percent_department,
                    // 'current_salary_wage'=> $current_salary_wage,
                    'total_Daily'=> $total_Daily_filter,
                    'total_Monthly'=> $total_Monthly_filter,
                    'total_Daily_Monthly'=> $total_Daily_Monthly,
                    'footer'=> $tb_total_all,
                    'countdata'=>$countdata,
                    "data_all" => $data_all,
                    "data_in" => $data_all-$data_finish,
                    "data_reject" => $data_reject,
                    "data_finish" => $data_finish,
                    "submit_to_dmgm" => $submit_to_dmgm,
                    "submit_to_approve_hr" => []
                ];
            }
            
        }
        
        echo json_encode($result); 
    }

    public function table_approve_salary_getdata_test(Request $request)
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
        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_employee_no       = $request->input('search_employee_no');
        $search_year       = $request->input('search_year');
        $search_grade       = $request->input('search_grade');
        $search_group       = $request->input('search_group');
        $pagenow       = $request->input('pagenow');
        $pagenow_salary       = $request->input('pagenow_salary');
        $search_not_up_salary       = $request->input('search_not_up_salary');
        $like = $request->Like;

        if(empty($start)){
            $start = 0;
        }

        if(empty($length)){
            $length = 10;
        }

            $previousYear = $search_year;

        
        
        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.id AS employee_id',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_description',
        'tb_employee.division_code',
        'tb_employee.department_code',
        'tb_employee.section_code',
        'tb_employee.division_description',
        'tb_employee.department_description',
        'tb_employee.section_description',
        'tb_employee.grade_code',
        'tb_employee.date_joined',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->whereNotNull('tb_employee_final_score.salary_month_old')
        ->whereNotNull('tb_employee_final_score.adjust_grade')
        ->whereNotNull('tb_employee_final_score.company_suggestged_new_basic')
        ;

        if($pagenow_salary == "1"){
            if($like['search_status'] != "all"){
                if($like['search_status'] == "-1"){
                    $gatall->where('tb_employee_final_score.freeze_to_approve_hr', '0');
                }else{
                    $gatall->where('tb_employee_final_score.freeze_to_approve_hr', '1');
                }
            }
        }else{
            if($pagenow == "2"){
                $gatall->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        
        


        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "990002" && $orisoft_code != "000002" && $orisoft_code != "000026"){
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
                    $gatall->where(function ($query) use($arr_division_code) {
                        foreach ($arr_division_code as $value) {
                            $query->orWhere('tb_employee.division_code','like','%'.$value.'%');
                        }
                    });
            }
            if(!isset($search_department)){
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
                $gatall->where(function ($query) use($arr_department_code) {
                    foreach ($arr_department_code as $value) {
                        $query->orWhere('tb_employee.department_code','like','%'.$value.'%');
                    }
                });
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
                $gatall->where(function ($query) use($arr_section_code) {
                    foreach ($arr_section_code as $value) {
                        $query->orWhere('tb_employee.section_code','like','%'.$value.'%');
                    }
                });
            }
        }
        if($orisoft_code == "990002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }
        if($orisoft_code == "000002"){
            if(!isset($search_division)){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->division_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_countsection);
                
            }
        }

        if($orisoft_code == "000026"){
            $arr_countsection = [];
            if(trans(request()->segment(1)) == 'manager'){
                if(isset($search_division)){
                    if(count($search_division) > 0){
                        foreach ($search_division as $value) {
                            $department = DB::table('tb_percent_department_action')
                            ->select('tb_percent_department_action.department_code')
                            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                            ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                            ->where('tb_percent_department_action.division_code','like','%'.$value.'%')
                            ->where('tb_percent_department_action.approve_by1','000026');
                            $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                        }
                        if(count($department)>0){
                            foreach ($department as $value) {
                                array_push($arr_countsection,$value->department_code);
                            }
                        }
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                    }
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by1','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    if(count($department)>0){
                        foreach ($department as $value) {
                            array_push($arr_countsection,$value->department_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
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
                            ->where('tb_percent_department_action.approve_by2','000026');
                            $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                        }
                        if(count($department)>0){
                            foreach ($department as $value) {
                                array_push($arr_countsection,$value->department_code);
                            }
                        }
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                    }
                }
                if(!isset($search_division)){
                    $department = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.department_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $department = $department->groupBy('department_code')->orderBy('department_code', 'ASC')->get();
                    if(count($department)>0){
                        foreach ($department as $value) {
                            array_push($arr_countsection,$value->department_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.department_code',$arr_countsection);
                }
            }
        }
        
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                
            }else if($orisoft_code == "990002"){
                
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
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                
                }
                if(!isset($search_department)){
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
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                
            }else if($orisoft_code == "990002"){
                
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
                    $gatall = $gatall->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if(!isset($search_department)){
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
                        $gatall = $gatall->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_code->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_code->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_code->section_code);
                    }
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
       
        
        if(@$like['searchText'] != ""){
            $searchText = @$like['searchText'];
            $gatall->where(function ($query) use($searchText) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$searchText.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$searchText.'%');
            });
        }
        
        if(isset($search_division)){
            if(count($search_division) > 0){
                $gatall->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $gatall->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if(isset($search_section)){
            if(count($search_section) > 0){
                $gatall->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(isset($search_employee_no)){
            if(count($search_employee_no) > 0){
                $gatall->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        if($like['search_month_day'] != "all"){
            if($like['search_month_day'] == "1"){
                $gatall->where('tb_employee_final_score.salary_type','Daily');
            }
            if($like['search_month_day'] == "2"){
                $gatall->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(isset($search_grade)){
            if(count($search_grade) > 0){
                $gatall->whereIn('tb_employee_final_score.grade_proposed', $search_grade);
            }
        }
        if($search_not_up_salary == "1"){
            $gatall->whereNotNull('tb_employee_final_score.not_up_salary');
        }else if($search_not_up_salary == "2"){
            $gatall->whereNull('tb_employee_final_score.not_up_salary');
        }
        if($like['search_status'] != "all"){
            if($like['search_status'] == "-1"){
                
            }else{
                $gatall->where('tb_employee_final_score.status_salary',$like['search_status']);
            }
        }
        
        if($like['search_group'] != "all"){
            if($like['search_group'] == "1"){
                $gatall->where('tb_employee.position_description','like','%Manager%');
            }else{
                $gatall->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        if($like['search_complaince_score'] != "all"){
            if($like['search_complaince_score'] == "1"){
                $gatall->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($like['search_complaince_score'] == "2"){
                $gatall->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($like['search_complaince_score'] == "3"){
                $gatall->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($like['search_attendance_score'] != "all"){
            if($like['search_attendance_score'] == "1"){
                $gatall->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($like['search_attendance_score'] == "2"){
                $gatall->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($like['search_attendance_score'] == "3"){
                $gatall->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        if(!empty($search)){
            $gatall->where(function ($query) use($search) {
                $query->orWhere('tb_employee_final_score.employee_no','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_th','like','%'.$search.'%');
                $query->orWhere('tb_employee.employee_local_name_en','like','%'.$search.'%');
            });
        }

        if(isset($pagenow_salary)){
            if($field == 1){
                $fieldby = 'tb_employee_final_score.employee_no';
            }
            else{
                if($field == 3){
                    $fieldby = 'tb_employee.division_description';
                }else if($field == 4){
                    $fieldby = 'tb_employee.department_description';
                }else if($field == 5){
                    $fieldby = 'tb_employee.section_description';
                }else if($field == 6){
                    $fieldby = 'tb_employee.position_description';
                }else if($field == 8){
                    $fieldby = 'tb_employee.date_joined';
                }else if($field == 9){
                    $fieldby = 'tb_employee_final_score.service_days';
                }else if($field == 10){
                    $fieldby = 'tb_employee_final_score.attendance_sl';
                }else if($field == 11){
                    $fieldby = 'tb_employee_final_score.attendance_pl';
                }else if($field == 13){
                    $fieldby = 'tb_employee_final_score.attendance_late';
                }else if($field == 14){
                    $fieldby = 'tb_employee_final_score.attendance_abt';
                }else if($field == 15){
                    $fieldby = 'tb_employee_final_score.attendance_abs';
                }else if($field == 16){
                    $fieldby = 'tb_employee_final_score.attendance_ol';
                }else if($field == 17){
                    $fieldby = 'tb_employee_final_score.attendance_score';
                }else if($field == 18){
                    $fieldby = 'tb_employee_final_score.attendance_vwar';
                }else if($field == 19){
                    $fieldby = 'tb_employee_final_score.attendance_wwar';
                }else if($field == 20){
                    $fieldby = 'tb_employee_final_score.attendance_sus';
                }else if($field == 21){
                    $fieldby = 'tb_employee_final_score.adjust_grade_old1';
                }else if($field == 22){
                    $fieldby = 'tb_employee_final_score.adjust_grade_old2';
                }else if($field == 23){
                    $fieldby = 'tb_employee_final_score.adjust_grade_old3';
                }else if($field == 24){
                    $fieldby = 'tb_employee_final_score.form_import';
                }else if($field == 25){
                    $fieldby = 'tb_employee_final_score.evaluator_name_en';
                }else if($field == 26){
                    $fieldby = 'tb_employee_final_score.total_score';
                }else if($field == 27){
                    $fieldby = 'tb_employee_final_score.pa_grade';
                }else if($field == 28){
                    $fieldby = 'tb_employee_final_score.adjust_grade';
                }else if($field == 29){
                    $fieldby = 'tb_employee_final_score.salary_old';
                }else if($field == 31){
                    $fieldby = 'tb_employee_final_score.bsalary_wage';
                }else if($field == 32){
                    $fieldby = 'tb_employee_final_score.salary_month_old';
                }else if($field == 33){
                    $fieldby = 'tb_employee_final_score.company_suggested_per';
                }else if($field == 34){
                    $fieldby = 'tb_employee_final_score.company_suggestged_amount';
                }else if($field == 35){
                    $fieldby = 'tb_employee_final_score.company_suggestged_new_basic';
                }else if($field == 36){
                    $fieldby = 'tb_employee_final_score.grade_proposed';
                }else if($field == 37){
                    $fieldby = 'tb_employee_final_score.percent_proposed';
                }else if($field == 38){
                    $fieldby = 'tb_employee_final_score.amount_proposed';
                }else if($field == 39){
                    $fieldby = 'tb_employee_final_score.salary_new';
                }else if($field == 40){
                    $fieldby = 'tb_employee_final_score.salary_month_new';
                }else if($field == 41){
                    $fieldby = 'tb_employee_final_score.final_by_md_gm_amount';
                }else if($field == 43){
                    $fieldby = 'tb_employee_final_score.status_salary';
                }
            }
        }else{
            if($pagenow == "1"){
                if($field == 1){
                    $fieldby = 'tb_employee_final_score.employee_no';
                }
                else{
                    if($field == 3){
                        $fieldby = 'tb_employee.division_description';
                    }else if($field == 4){
                        $fieldby = 'tb_employee.department_description';
                    }else if($field == 5){
                        $fieldby = 'tb_employee.section_description';
                    }else if($field == 6){
                        $fieldby = 'tb_employee.position_description';
                    }else if($field == 8){
                        $fieldby = 'tb_employee.date_joined';
                    }else if($field == 9){
                        $fieldby = 'tb_employee_final_score.service_days';
                    }else if($field == 10){
                        $fieldby = 'tb_employee_final_score.attendance_sl';
                    }else if($field == 11){
                        $fieldby = 'tb_employee_final_score.attendance_pl';
                    }else if($field == 13){
                        $fieldby = 'tb_employee_final_score.attendance_late';
                    }else if($field == 14){
                        $fieldby = 'tb_employee_final_score.attendance_abt';
                    }else if($field == 15){
                        $fieldby = 'tb_employee_final_score.attendance_abs';
                    }else if($field == 16){
                        $fieldby = 'tb_employee_final_score.attendance_ol';
                    }else if($field == 17){
                        $fieldby = 'tb_employee_final_score.attendance_score';
                    }else if($field == 18){
                        $fieldby = 'tb_employee_final_score.attendance_vwar';
                    }else if($field == 19){
                        $fieldby = 'tb_employee_final_score.attendance_wwar';
                    }else if($field == 20){
                        $fieldby = 'tb_employee_final_score.attendance_sus';
                    }else if($field == 21){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old1';
                    }else if($field == 22){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old2';
                    }else if($field == 23){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old3';
                    }else if($field == 24){
                        $fieldby = 'tb_employee_final_score.form_import';
                    }else if($field == 25){
                        $fieldby = 'tb_employee_final_score.evaluator_name_en';
                    }else if($field == 26){
                        $fieldby = 'tb_employee_final_score.total_score';
                    }else if($field == 27){
                        $fieldby = 'tb_employee_final_score.pa_grade';
                    }else if($field == 28){
                        $fieldby = 'tb_employee_final_score.adjust_grade';
                    }else if($field == 29){
                        $fieldby = 'tb_employee_final_score.salary_old';
                    }else if($field == 31){
                        $fieldby = 'tb_employee_final_score.bsalary_wage';
                    }else if($field == 32){
                        $fieldby = 'tb_employee_final_score.salary_month_old';
                    }else if($field == 33){
                        $fieldby = 'tb_employee_final_score.company_suggested_per';
                    }else if($field == 34){
                        $fieldby = 'tb_employee_final_score.company_suggestged_amount';
                    }else if($field == 35){
                        $fieldby = 'tb_employee_final_score.company_suggestged_new_basic';
                    }else if($field == 36){
                        $fieldby = 'tb_employee_final_score.grade_proposed';
                    }else if($field == 37){
                        $fieldby = 'tb_employee_final_score.percent_proposed';
                    }else if($field == 38){
                        $fieldby = 'tb_employee_final_score.amount_proposed';
                    }else if($field == 39){
                        $fieldby = 'tb_employee_final_score.salary_new';
                    }else if($field == 40){
                        $fieldby = 'tb_employee_final_score.salary_month_new';
                    }else if($field == 41){
                        $fieldby = 'tb_employee_final_score.final_by_md_gm_amount';
                    }else if($field == 43){
                        $fieldby = 'tb_employee_final_score.status_salary';
                    }
                }
            }else{
                if($field == 1){
                    $fieldby = 'tb_employee_final_score.employee_no';
                }
                else{
                    if($field == 3){
                        $fieldby = 'tb_employee.division_description';
                    }else if($field == 4){
                        $fieldby = 'tb_employee.department_description';
                    }else if($field == 5){
                        $fieldby = 'tb_employee.section_description';
                    }else if($field == 6){
                        $fieldby = 'tb_employee.position_description';
                    }else if($field == 8){
                        $fieldby = 'tb_employee.date_joined';
                    }else if($field == 9){
                        $fieldby = 'tb_employee_final_score.service_days';
                    }else if($field == 10){
                        $fieldby = 'tb_employee_final_score.attendance_sl';
                    }else if($field == 11){
                        $fieldby = 'tb_employee_final_score.attendance_pl';
                    }else if($field == 13){
                        $fieldby = 'tb_employee_final_score.attendance_late';
                    }else if($field == 14){
                        $fieldby = 'tb_employee_final_score.attendance_abt';
                    }else if($field == 15){
                        $fieldby = 'tb_employee_final_score.attendance_abs';
                    }else if($field == 16){
                        $fieldby = 'tb_employee_final_score.attendance_ol';
                    }else if($field == 17){
                        $fieldby = 'tb_employee_final_score.attendance_score';
                    }else if($field == 18){
                        $fieldby = 'tb_employee_final_score.attendance_vwar';
                    }else if($field == 19){
                        $fieldby = 'tb_employee_final_score.attendance_wwar';
                    }else if($field == 20){
                        $fieldby = 'tb_employee_final_score.attendance_sus';
                    }else if($field == 21){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old1';
                    }else if($field == 22){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old2';
                    }else if($field == 23){
                        $fieldby = 'tb_employee_final_score.adjust_grade_old3';
                    }else if($field == 24){
                        $fieldby = 'tb_employee_final_score.form_import';
                    }else if($field == 25){
                        $fieldby = 'tb_employee_final_score.evaluator_name_en';
                    }else if($field == 26){
                        $fieldby = 'tb_employee_final_score.total_score';
                    }else if($field == 27){
                        $fieldby = 'tb_employee_final_score.pa_grade';
                    }else if($field == 28){
                        $fieldby = 'tb_employee_final_score.adjust_grade';
                    }else if($field == 29){
                        $fieldby = 'tb_employee_final_score.salary_old';
                    }else if($field == 31){
                        $fieldby = 'tb_employee_final_score.bsalary_wage';
                    }else if($field == 32){
                        $fieldby = 'tb_employee_final_score.salary_month_old';
                    }else if($field == 33){
                        $fieldby = 'tb_employee_final_score.company_suggested_per';
                    }else if($field == 34){
                        $fieldby = 'tb_employee_final_score.company_suggestged_amount';
                    }else if($field == 35){
                        $fieldby = 'tb_employee_final_score.company_suggestged_new_basic';
                    }else if($field == 36){
                        $fieldby = 'tb_employee_final_score.grade_proposed';
                    }else if($field == 37){
                        $fieldby = 'tb_employee_final_score.percent_proposed';
                    }else if($field == 38){
                        $fieldby = 'tb_employee_final_score.amount_proposed';
                    }else if($field == 39){
                        $fieldby = 'tb_employee_final_score.salary_new';
                    }else if($field == 40){
                        $fieldby = 'tb_employee_final_score.salary_month_new';
                    }else if($field == 41){
                        $fieldby = 'tb_employee_final_score.percent_proposed_gmdm';
                    }else if($field == 42){
                        $fieldby = 'tb_employee_final_score.amount_proposed_gmdm';
                    }else if($field == 43){
                        $fieldby = 'tb_employee_final_score.salary_new_gmdm';
                    }else if($field == 44){
                        $fieldby = 'tb_employee_final_score.salary_month_new_gmdm';
                    }else if($field == 45){
                        $fieldby = 'tb_employee_final_score.final_by_md_gm_amount';
                    }else if($field == 47){
                        $fieldby = 'tb_employee_final_score.status_salary';
                    }
                }
            }
        }
        
        

        if($order){
            $order = $order;
        }
        else{
            $order = 'asc';
        }

        if($field == 0){
            $gatall->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
            ->orderBy('tb_employee_final_score.total_score', 'DESC');
            $gatall = $gatall->skip($start)->take($length)->get();
        }else{
            $gatall->orderBy($fieldby,$order);
            $gatall = $gatall->skip($start)->take($length)->get();
        }
        
        
    }

    public function table_approve_salary_getdata_test2(Request $request)
    {
        // -- Helper function
        function change_date($date){
            return $date ? explode(' ', $date)[0] : null;
        }

        // -- Prepare Request
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $order_column_index = $request->input('order.0.column');
        $order_dir = $request->input('order.0.dir', 'asc');
        $searchYear = $request->input('search_year');
        $like = $request->input('Like', []);
        $pagenow_salary = $request->input('pagenow_salary');
        $pagenow = $request->input('pagenow');
        $search_not_up_salary = $request->input('search_not_up_salary');
        $search_division = $request->input('search_division');
        $search_department = $request->input('search_department');
        $search_section = $request->input('search_section');
        $search_employee_no = $request->input('search_employee_no');
        $search_grade = $request->input('search_grade');

        $user = Auth::user();
        $orisoft_code = $user->orisoft_code;

        // -- Start Query
        $query = DB::table('tb_employee_final_score as fs')
        ->select([
            'fs.id', 'fs.employee_no', 'fs.status_salary', 'fs.status_evaluation',
            'fs.bsalary_wage','fs.pa_grade', 'fs.adjust_grade', 'fs.grade_proposed', 'fs.not_up_salary',
            'fs.company_suggested_per', 'fs.company_suggestged_amount', 'fs.company_suggestged_new_basic',
            'fs.percent_proposed', 'fs.percent_proposed_old',
            'fs.service_days',
            'fs.attendance_sl', 'fs.attendance_pl', 'fs.attendance_late', 'fs.attendance_abt', 'fs.attendance_abs',
            'fs.attendance_ol', 'fs.attendance_vwar', 'fs.attendance_wwar', 'fs.attendance_sus',
            'fs.salary_old', 'fs.salary_month_old', 'fs.l800avg_wage',
            'fs.salary_new', 'fs.salary_month_new', 'fs.amount_proposed',
            'fs.form_import',
            'fs.evaluator_name_th', 'fs.evaluator_name_en',
            'fs.total_score',
            'fs.remark_grade',
            'fs.final_by_md_gm_amount',
            'fs.freeze_to_gmdm', 'fs.freeze_to_gmdm_edit', 'fs.freeze_to_approve_hr',
            'fs.edit_by_dmgm','fs.amount_proposed_gmdm','fs.salary_type',
            'fs.grade_proposed_manager',
            'fs.grade_proposed_old','fs.adjust_grade_old1', 'fs.adjust_grade_old2', 'fs.adjust_grade_old3',
            'fs.percent_proposed_gmdm',
            'fs.salary_new_gmdm', 'fs.salary_month_new_gmdm',
            'e.orisoft_no', 'e.employee_local_name_th', 'e.employee_local_name_en',
            'e.position_description', 'e.division_code', 'e.department_code', 'e.section_code',
            'e.division_description', 'e.department_description', 'e.section_description',
            'e.grade_code', 'e.date_joined', 'e.employee_status_description','e.id AS employee_id',
        ])
        ->leftJoin('tb_employee as e', 'e.orisoft_no', '=', 'fs.employee_no')
        ->where('fs.rec_year', 'like', "%{$searchYear}%")
        ->where('fs.status_evaluation', 3)
        ->whereNotNull('fs.salary_month_old')
        ->whereNotNull('fs.adjust_grade')
        ->whereNotNull('fs.company_suggestged_new_basic')
        ->where('e.employee_status_description', 'Passed')
        ->whereNotIn('e.grade_code', ['L810', 'L820']);

        // -- Filter by Page Type
        if ($pagenow_salary == "1" && isset($like['search_status'])) {
            if ($like['search_status'] == "-1") {
                $query->where('fs.freeze_to_approve_hr', 0);
            } else {
                $query->where('fs.freeze_to_approve_hr', 1);
            }
        } else {
            if ($pagenow == "2") {
                $query->where('fs.freeze_to_gmdm', 1);
            } else {
                $query->where('fs.freeze_to_pagrade', 1);
            }
        }

        // -- Advanced Filters
        if (!empty($search_division)) {
            $query->whereIn('e.division_code', $search_division);
        }
        if (!empty($search_department)) {
            $query->whereIn('e.department_code', $search_department);
        }
        if (!empty($search_section)) {
            $query->whereIn('e.section_code', $search_section);
        }
        if (!empty($search_employee_no)) {
            $query->whereIn('fs.evaluator_no', $search_employee_no);
        }
        if (!empty($search_grade)) {
            $query->whereIn('fs.grade_proposed', $search_grade);
        }
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('fs.employee_no', 'like', "%$search%")
                ->orWhere('e.employee_local_name_th', 'like', "%$search%")
                ->orWhere('e.employee_local_name_en', 'like', "%$search%");
            });
        }
        if (!empty($like['searchText'])) {
            $query->where(function($q) use ($like) {
                $q->where('fs.employee_no', 'like', "%{$like['searchText']}%")
                ->orWhere('e.employee_local_name_th', 'like', "%{$like['searchText']}%")
                ->orWhere('e.employee_local_name_en', 'like', "%{$like['searchText']}%");
            });
        }

        // -- Special Conditions
        if ($search_not_up_salary == "1") {
            $query->whereNotNull('fs.not_up_salary');
        } elseif ($search_not_up_salary == "2") {
            $query->whereNull('fs.not_up_salary');
        }

        // -- Ordering
        $columns = [
            1 => 'fs.employee_no',
            3 => 'e.division_description',
            4 => 'e.department_description',
            5 => 'e.section_description',
            6 => 'e.position_description',
            8 => 'e.date_joined',
            9 => 'fs.service_days',
            // ... add more mapping if needed
        ];
        $orderBy = $columns[$order_column_index] ?? 'fs.id';

        $query->orderBy($orderBy, $order_dir);

        // -- Get Paginated Result
        $data = $query->skip($start)->take($length)->get();

        if(count($data)>0){
            foreach ($data as $key => $value) {
                $status_salary = '<span class="set_status'.$value->id.' badge" style="height: 34px;"></span>';
                if($value->status_salary == '0'){
                    $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                        <span class="set_status'.$value->id.' badge badge-light" style="height: 34px;">In progress</span>
                                    </div>';
                }
                if($value->status_salary == '2'){
                    $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                        <span class="set_status'.$value->id.' badge bg-danger text-light" style="height: 34px;">Reject</span>
                                    </div>';
                }
                if($value->status_salary == '1'){
                    if($value->not_up_salary){
                        $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                            <span class="set_status'.$value->id.' badge bg-success text-light" style="height: 34px;">Finished</span>
                                        </div>';
                    }else{
                        $status_salary = '<div style="display: flex;align-items: center;justify-content: center;">
                                            <span class="set_status'.$value->id.' badge bg-success text-light" style="height: 34px;">Approved</span>
                                        </div>';
                    }
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
                $current = 0;
                $total_day = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                if($like['search_month_day'] != "all"){
                    if($like['search_month_day'] == "1"){
                        $current = $value->salary_old;
                    }else{
                        $current = $value->salary_month_old;
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $current = $value->salary_old;
                    }else{
                        $current = $value->salary_month_old;
                    }
                }
                if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                    $l800avg_wage = $value->l800avg_wage;
                }else{
                    $l800avg_wage = '';
                }
                $bsalary_wage = 0;
                if($like['search_month_day'] != "all"){
                    if(@$like['search_month_day'] == "1"){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage = $value->l800avg_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage = $value->bsalary_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage = $value->l800avg_wage;
                        }else{
                            $bsalary_wage = $current;
                        }
                    }else{
                        if($value->bsalary_wage){
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
                $company_suggested_per = $value->company_suggested_per;
                $percent_proposed_old = $value->percent_proposed_old;
                $countbudget = DB::table('tb_budget_action')
                            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                            ->where('tb_budget.year',$searchYear)->count();
                if($countbudget > 0){
                    if($value->adjust_grade){
                        $databudget = DB::table('tb_budget_action')
                        ->select('tb_budget_action.std')
                        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        ->where('tb_budget_action.grade_name',$value->adjust_grade)
                        ->where('tb_budget.year',$searchYear)->first();
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
                    $company_suggestged_new_basic = round($company_suggestged_amount+$current);
                }else{
                    $company_suggestged_new_basic = round($company_suggestged_amount+$bsalary_wage,(trans(request()->segment(1)) == 'manager'?-2:-1));
                }
                $value->company_suggestged_new_basic = $company_suggestged_new_basic;
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
                if($like['search_month_day'] != "all"){
                    if(@$like['search_month_day'] == "1"){
                        $salary_new = round($amount_proposed+$current);
                    }else{
                        $salary_new = round($amount_proposed+$current,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $salary_new = round($amount_proposed+$current);
                    }else{
                        $salary_new = round($amount_proposed+$current,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }
                
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
                        }else{
                            $salary_month_new = round($salary_new,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }else{
                        if($value->grade_code == 'L800'){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx = $salary_new*27.5;
                                $salary_month_new = round($salary_month_newx,-1);
                            }else{
                                $salary_month_new = round($salary_new)*26;
                            }
                        }else{
                            $salary_month_new = round($salary_new,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }
                }

                // DB::table('tb_employee_final_score')->where('id',$value->id)
                // ->update([
                //     "company_suggested_per" => $company_suggested_per,
                //     "company_suggestged_amount" => $company_suggestged_amount,
                //     "company_suggestged_new_basic" => $company_suggestged_new_basic,
                //     "grade_proposed_old" => ($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade),
                //     "grade_proposed" => ($value->grade_proposed?$value->grade_proposed:$value->adjust_grade),
                //     "percent_proposed_old" => $percent_proposed_old,
                //     "percent_proposed" => ($value->percent_proposed>=0?$value->percent_proposed:$percent_proposed_old),
                //     "amount_proposed" => $amount_proposed,
                //     "salary_new" => $salary_new,
                //     "salary_month_new" => $salary_month_new,
                //     "final_by_md_gm_amount" => ($value->final_by_md_gm_amount>0?$value->final_by_md_gm_amount:($salary_month_new>0?$salary_month_new:0))
                // ]);
                
                $date_formatted = '';
                if($value->date_joined){
                    $date_joined_old = $value->date_joined;
                    $date_formatted = date("Y-m-d", strtotime($date_joined_old));
                }

                $approve_review_salary = 'style="display:none;"';
                if (Auth::user()->can('approve review salary')) {
                    $approve_review_salary = 'style="display:block;"';
                }
                $action = '';
                if($value->status_salary == '1'){
                    $action = '<div style="display: flex;align-items: center;justify-content: center;">
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                </div>';
                }else if($value->status_salary == '2'){
                    $action = '<div style="display: flex;align-items: center;justify-content: center;">
                                <button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                </div>';
                }else{
                    $action = '<div style="display: flex;align-items: center;justify-content: center;">
                                <button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal" '.$approve_review_salary.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                </div>';
                }

                $disabled = '';
                if(!$value->adjust_grade){
                    $disabled = 'disabled="disabled"';
                }
                $old_grade_disabled = '';
                if(!$value->grade_proposed_old){
                    $old_grade_disabled = 'style="display:none;"';
                }
                $old_percent_proposed_oldd = '';
                if(!$value->percent_proposed_old){
                    $old_percent_proposed_oldd = 'style="display:none;"';
                }

                

                $freeze_to_gmdm = '';
                if($pagenow == "1"){
                    if ($value->freeze_to_gmdm == '1') {
                        $freeze_to_gmdm = 'disabled';
                    }
                }

                $freeze_to_approve_hr = '';
                if($pagenow == "2"){
                    if ($value->freeze_to_approve_hr == '1') {
                        $freeze_to_approve_hr = 'disabled';
                    }
                }
                

                $disabled_l800avg_wage = '';
                if($value->grade_code != 'L800'){
                    $disabled_l800avg_wage = 'disabled';
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

                $info_grade_p_display = 'display:none;';
                if($value->grade_proposed == "AR" || $value->grade_proposed == "P" || $value->grade_proposed == "U" || $value->grade_proposed == "CD"){
                    $info_grade_p_display = '';
                }
                $info_grade_p = '<button type="button" class="btn btn-icon btn-light btn-xs me-1 change_class_info'.$value->id.'" onclick="change_class_info(\''.$value->grade_proposed.'\','.$key.','.$value->id.','.$value->employee_id.');" style="'.$info_grade_p_display.'">
                                        <i class="ki-outline ki-information-2 fs-5"></i>
                                    </button>';
                $info_grade_p_approve = '';
                if($value->grade_proposed == "AR" || $value->grade_proposed == "P" || $value->grade_proposed == "U" || $value->grade_proposed == "CD"){
                    $info_grade_p_approve = '<button type="button" class="btn btn-icon btn-light btn-xs change_class_info'.$value->id.'" onclick="change_class_info(\''.$value->grade_proposed.'\','.$key.','.$value->id.','.$value->employee_id.');">
                                        <i class="ki-outline ki-information-2 fs-5"></i>
                                    </button>';
                    if($value->grade_proposed == "P"){
                        $info_grade_p_approve .= '<button type="button" class="btn btn-icon btn-info btn-xs me-1 open_jd'.$value->id.'" onclick="open_jd('.$key.','.$value->id.','.$value->employee_id.');" style="font-size: 10px;'.$info_grade_p_display.'">
                                            JD
                                        </button>';
                    }                
                }

                $bgx = '';
                $tb_budget_action = DB::table('tb_budget_action')
                ->select('tb_budget_action.*')
                ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                ->where('tb_budget.year',$searchYear)
                ->orderBy('tb_budget_action.id', 'ASC')->get();
                if(count($tb_budget_action)>0){
                    foreach ($tb_budget_action as $keyzz => $valuezz) {
                        if($value->grade_proposed == $valuezz->grade_name){
                            if($valuezz->budget_range_start && $valuezz->budget_range_start > 0){
                                if($value->percent_proposed < $valuezz->budget_range_start || $value->percent_proposed > $valuezz->budget_range_end){
                                    if($pagenow == "2"){
                                        $bgx = 'background-color:rgb(255 211 211);';
                                    }
                                }
                            }
                        }
                    }
                }
                
                $pa3 = DB::table('tb_employee_final_score')
                ->select('grade_proposed','adjust_grade_old2','adjust_grade_old3')
                ->where('tb_employee_final_score.employee_no',$value->employee_no)
                ->where('tb_employee_final_score.rec_year',($searchYear-1))->first();
                
                if($value->adjust_grade_old1 == null){
                    if($pa3){
                        DB::table('tb_employee_final_score')->where('id',$value->id)
                        ->update([
                            "adjust_grade_old1" => $pa3->adjust_grade_old2,
                            "adjust_grade_old2" => $pa3->adjust_grade_old3,
                            "adjust_grade_old3" => $pa3->grade_proposed,
                        ]);
                        $value->adjust_grade_old1 = $pa3->adjust_grade_old2;
                        $value->adjust_grade_old2 = $pa3->adjust_grade_old3;
                        $value->adjust_grade_old3 = $pa3->grade_proposed;
                    }
                }
                if($value->adjust_grade_old1 == "P"){
                    $class_pa1 = 'gradeP';
                }else if($value->adjust_grade_old1 == "A"){
                    $class_pa1 = 'gradeA';
                }else if($value->adjust_grade_old1 == "B"){
                    $class_pa1 = 'gradeB';
                }else if($value->adjust_grade_old1 == "C"){
                    $class_pa1 = 'gradeC';
                }else if($value->adjust_grade_old1 == "D"){
                    $class_pa1 = 'gradeD';
                }else if($value->adjust_grade_old1 == "E"){
                    $class_pa1 = 'gradeE';
                }else{
                    $class_pa1 = '';
                }
                if($value->adjust_grade_old2 == "P"){
                    $class_pa2 = 'gradeP';
                }else if($value->adjust_grade_old2 == "A"){
                    $class_pa2 = 'gradeA';
                }else if($value->adjust_grade_old2 == "B"){
                    $class_pa2 = 'gradeB';
                }else if($value->adjust_grade_old2 == "C"){
                    $class_pa2 = 'gradeC';
                }else if($value->adjust_grade_old2 == "D"){
                    $class_pa2 = 'gradeD';
                }else if($value->adjust_grade_old2 == "E"){
                    $class_pa2 = 'gradeE';
                }else{
                    $class_pa2 = '';
                }
                if($value->adjust_grade_old3 == "P"){
                    $class_pa3 = 'gradeP';
                }else if($value->adjust_grade_old3 == "A"){
                    $class_pa3 = 'gradeA';
                }else if($value->adjust_grade_old3 == "B"){
                    $class_pa3 = 'gradeB';
                }else if($value->adjust_grade_old3 == "C"){
                    $class_pa3 = 'gradeC';
                }else if($value->adjust_grade_old3 == "D"){
                    $class_pa3 = 'gradeD';
                }else if($value->adjust_grade_old3 == "E"){
                    $class_pa3 = 'gradeE';
                }else{
                    $class_pa3 = '';
                }
                $formatted_data[] = array(
                    "id" =>  ($value->not_up_salary?'':'<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->orisoft_no.'" id="checkbox-'.$value->orisoft_no.'" value="'.$value->id.'" data-id="'.$value->id.'">').'
                            <input type="hidden" class="salary_month_new" id="salary_month_new'.$value->id.'" name="salary_month_new[]" value="'.$salary_month_new.'">
                            <input type="hidden" class="comsugpct" id="comsugpct'.$value->id.'" name="comsugpct[]" value="'.($company_suggested_per>0?number_format($company_suggested_per,2,'.',''):0.00).'">
                            <input type="hidden" class="comsugamt" id="comsugamt'.$value->id.'" name="comsugamt[]" value="'.($company_suggestged_amount>0?number_format($company_suggestged_amount,2,'.',''):0.00).'">
                            <input type="hidden" class="companynewb" id="companynewb'.$value->id.'" name="companynewb[]" value="'.($company_suggestged_new_basic>0?number_format($company_suggestged_new_basic,2,'.',''):0.00).'">',
                    "divi"=> $value->division_code,
                    "dept"=> $value->department_code,
                    "sect"=> $value->section_code,
                    "code"=> $value->orisoft_no.' 
                                <button type="button" class="btn btn-icon btn-light btn-xs me-1" id="infoModal" onclick="set_info('.$value->id.');">
                                    <i class="ki-outline ki-information-2 fs-5"></i>
                                </button>',
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> '<span class="position_description'.$value->id.'">'.$value->position_description.'</span>',
                    "group"=> "",
                    "joindate"=> $date_formatted,
                    "serviced"=> $value->service_days.'<input type="hidden" id="service_days'.$value->id.'" value="'.$service_days2.'">',
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> ($value->attendance_ol>0?number_format($value->attendance_ol,1):'0.0'),
                    "totald"=> ($total_day>0?number_format($total_day,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa1"=> '<span class="form-control text-center form-select-sm selectG '.$class_pa1.'">'.($value->adjust_grade_old1?$value->adjust_grade_old1:'-').'</span>',
                    "pa2"=> '<span class="form-control text-center form-select-sm selectG '.$class_pa2.'">'.($value->adjust_grade_old2?$value->adjust_grade_old2:'-').'</span>',
                    "pa3"=> '<span class="form-control text-center form-select-sm selectG '.$class_pa3.'">'.($value->adjust_grade_old3?$value->adjust_grade_old3:'-').'</span>',
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade,
                    "adjustg"=> $adjustg,
                    "current"=> '<span class="show_salary_old'.$value->id.'">'.($current>0?number_format($current,2):'').'</span><input type="hidden" class="salary_old" id="salary_old'.$value->id.'" name="salary_old[]" value="'.$current.'">',
                    // "l800avg"=> ($value->grade_code == 'L800'?'<input type="text" class="form-control form-control-sm fw-bold" id="l800avg_wage'.$value->id.'" value="'.($l800avg_wage>0?number_format($l800avg_wage,2):'').'" min="0" min="999" maxlength="3" onchange="update_l800avg_wage('.$value->id.');" OnKeyPress="return checknumber(this,'.$value->id.',\'l800avg_wage\')" '.$freeze_to_gmdm.' '.$disabled_l800avg_wage.'>':''),
                    "l800avg"=> '<span class="l800avg_wage'.$value->id.'">'.($l800avg_wage>0?number_format($l800avg_wage,2):'').'</span>',
                    "l800avg_gmdm"=> '<span class="l800avg_wage'.$value->id.'">'.($l800avg_wage>0?number_format($l800avg_wage,2):'').'</span>',
                    "bsalaryw"=> '<span class="show_bsalary_wage'.$value->id.'">'.($bsalary_wage>0?number_format($bsalary_wage,2):'').'</span><input type="hidden" class="bsalaryw" id="bsalaryw'.$value->id.'" name="bsalaryw[]" value="'.($bsalary_wage>0?number_format($bsalary_wage,2,'.',''):'').'">',
                    "cbsalaryw"=> '<span class="show_salary_month_old'.$value->id.'">'.($salary_month_old>0?number_format($salary_month_old,2):'').'</span><input type="hidden" class="salary_month_old" id="salary_month_old'.$value->id.'" name="salary_month_old[]" value="'.($salary_month_old>0?number_format($salary_month_old,2,'.',''):'').'">',
                    "comsugpct"=> '<span class="show_company_suggested_per'.$value->id.'">'.($company_suggested_per>0?number_format($company_suggested_per,2):0.00).'%</span>',
                    "comsugamt"=> '<span class="show_company_suggestged_amount'.$value->id.'">'.($company_suggestged_amount>0?number_format($company_suggestged_amount,2):0.00).'</span>',
                    "companynewb"=> '<span class="show_company_suggestged_new_basic'.$value->id.'">'.($company_suggestged_new_basic>0?number_format($company_suggestged_new_basic,2):0.00).'</span>',
                    "gmgr_span"=> '<span class="form-select form-select-sm selectG '.$class_gmgr.'">'.($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')).'</span>'.$info_grade_p,
                    "gmgr_span2"=> '<span class="badge w-100 text-center fs-3 d-block py-2 mb-0 selectG '.$class_gmgr.'">'.($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')).'</span>'.$info_grade_p,
                    "gmgr_span_approve"=> '<div style="text-align:center;min-width: 60px;"><span class="badge w-100 text-center fs-3 d-block py-2 mb-0 selectG '.$class_gmgr.'">'.($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')).'</span>'.$info_grade_p_approve.'</div><input type="hidden" class="id_gmgr" id="hidden_grade_proposed'.$value->id.'" name="hidden_grade_proposed[]" value="'.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'">',
                    "gmgr_view"=> '<select class="form-select form-select-sm selectG '.$class_gmgr.'" id="id_gmgr'.$value->id.'" style="width:80px" disabled>
                                <option class="" value="AR" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':''))).'>AR</option>
                                <option class="gradeP" value="P" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='P'?'selected':''):($value->adjust_grade=='P'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='P'?'selected':''):($value->adjust_grade=='P'?'selected':''))).'>P</option>
                                <option class="gradeA" value="A" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='A'?'selected':''):($value->adjust_grade=='A'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='A'?'selected':''):($value->adjust_grade=='A'?'selected':''))).'>A</option>
                                <option class="gradeB" value="B" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='B'?'selected':''):($value->adjust_grade=='B'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='B'?'selected':''):($value->adjust_grade=='B'?'selected':''))).'>B</option>
                                <option class="gradeC" value="C" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='C'?'selected':''):($value->adjust_grade=='C'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='C'?'selected':''):($value->adjust_grade=='C'?'selected':''))).'>C</option>
                                <option class="gradeD" value="D" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='D'?'selected':''):($value->adjust_grade=='D'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='D'?'selected':''):($value->adjust_grade=='D'?'selected':''))).'>D</option>
                                <option class="gradeE" value="E" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='E'?'selected':''):($value->adjust_grade=='E'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='E'?'selected':''):($value->adjust_grade=='E'?'selected':''))).'>E</option>
                                <option class="" value="U" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='U'?'selected':''):($value->adjust_grade=='U'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='U'?'selected':''):($value->adjust_grade=='U'?'selected':''))).'>U</option>
                                '.($value->grade_code == 'L800'?'<option class="" value="CD" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':''))).'>CD</option>':'').'
                            </select>
                            <span class="small fw-bold grade_proposed_old'.$value->id.'" '.$old_grade_disabled.'>
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade)).' &#62; 
                            </span>
                            <span class="small fw-bold changecolor'.$value->id.'">
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'
                            </span>
                            '.$info_grade_p.'',
                    "gmgr"=> '<select class="form-select form-select-sm selectG '.$class_gmgr.'" id="id_gmgr'.$value->id.'" style="width:80px" onchange="change_class(this,'.$key.','.$value->id.','.$value->employee_id.');" '.$disabled.' '.($value->not_up_salary?'disabled':'').' '.$freeze_to_gmdm.' '.$freeze_to_approve_hr.'>
                                <option class="" value="AR" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='AR'?'selected':''):($value->adjust_grade=='AR'?'selected':''))).'>AR</option>
                                <option class="gradeP" value="P" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='P'?'selected':''):($value->adjust_grade=='P'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='P'?'selected':''):($value->adjust_grade=='P'?'selected':''))).'>P</option>
                                <option class="gradeA" value="A" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='A'?'selected':''):($value->adjust_grade=='A'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='A'?'selected':''):($value->adjust_grade=='A'?'selected':''))).'>A</option>
                                <option class="gradeB" value="B" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='B'?'selected':''):($value->adjust_grade=='B'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='B'?'selected':''):($value->adjust_grade=='B'?'selected':''))).'>B</option>
                                <option class="gradeC" value="C" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='C'?'selected':''):($value->adjust_grade=='C'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='C'?'selected':''):($value->adjust_grade=='C'?'selected':''))).'>C</option>
                                <option class="gradeD" value="D" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='D'?'selected':''):($value->adjust_grade=='D'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='D'?'selected':''):($value->adjust_grade=='D'?'selected':''))).'>D</option>
                                <option class="gradeE" value="E" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='E'?'selected':''):($value->adjust_grade=='E'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='E'?'selected':''):($value->adjust_grade=='E'?'selected':''))).'>E</option>
                                <option class="" value="U" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='U'?'selected':''):($value->adjust_grade=='U'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='U'?'selected':''):($value->adjust_grade=='U'?'selected':''))).'>U</option>
                                '.($value->grade_code == 'L800'?'<option class="" value="CD" '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?($value->grade_proposed_manager=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':'')):($value->grade_proposed?($value->grade_proposed=='CD'?'selected':''):($value->adjust_grade=='CD'?'selected':''))).'>CD</option>':'').'
                            </select>
                            <span class="small fw-bold grade_proposed_old'.$value->id.'" '.$old_grade_disabled.'>
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed_old?$value->grade_proposed_old:$value->adjust_grade)).' &#62; 
                            </span>
                            <span class="small fw-bold changecolor'.$value->id.'">
                                '.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'
                            </span>
                            <input type="hidden" class="id_gmgr" id="hidden_grade_proposed'.$value->id.'" name="hidden_grade_proposed[]" value="'.($value->freeze_to_gmdm=='1' && $pagenow=='1'?($value->grade_proposed_manager?$value->grade_proposed_manager:$value->adjust_grade):($value->grade_proposed?$value->grade_proposed:$value->adjust_grade)).'">
                            '.$info_grade_p.'',
                    "incpctmgr_span"=> '<span class="small fw-bold -bottom-32">'.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'%</span>',
                    "incpctmgr_view"=> '<input type="text" id="percent_proposed'.$value->id.'" class="form-control form-control-sm '.($value->edit_by_dmgm==1?'bg-light-warning':'').'" value="'.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'" readonly >
                                    <span class="small fw-bold percent_proposed_old'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($percent_proposed_old>0?number_format($percent_proposed_old,4,'.',''):'').'% &#62; 
                                    </span>
                                    <span class="small fw-bold -bottom-32 text-primary percent_proposed'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'%
                                    </span>
                                    ',
                    "incpctmgr"=> '<input type="text" id="percent_proposed'.$value->id.'" class="form-control form-control-sm '.($value->edit_by_dmgm==1?'bg-light-warning':'').'" value="'.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'" onchange="change_class_input(this,'.$key.','.$value->id.',0);" OnKeyPress="return checknumber(this,'.$value->id.',\'percent_proposed\')" '.$disabled.' '.($value->not_up_salary?'disabled':'').' '.$freeze_to_gmdm.' '.$freeze_to_approve_hr.' style="'.$bgx.'">
                                    <span class="small fw-bold percent_proposed_old'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($percent_proposed_old>0?number_format($percent_proposed_old,4,'.',''):'').'% &#62; 
                                    </span>
                                    <span class="small fw-bold -bottom-32 text-primary percent_proposed'.$value->id.'" '.$old_percent_proposed_oldd.'>
                                        '.($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')).'%
                                    </span>',
                    "incpctmgr_gmdm"=> '<span class="small fw-bold -bottom-32 percent_proposed_old_gmdm'.$value->id.'">
                                            '.($value->percent_proposed_gmdm>0?number_format($value->percent_proposed_gmdm,4,'.',''):($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.',''))).'%
                                        </span>',
                    "incamount"=> '<span class="small fw-bold -bottom-32 amount_proposed'.$value->id.'">
                                        '.($amount_proposed>0?number_format($amount_proposed,2):'0.00').'
                                    </span>',
                    "incamount_gmdm"=> '<span class="small fw-bold -bottom-32 amount_proposed_gmdm'.$value->id.'">
                                        '.($value->amount_proposed_gmdm>0?number_format($value->amount_proposed_gmdm,2):($amount_proposed>0?number_format($amount_proposed,2):'')).'
                                    </span>',
                    "newbwage"=> '<span class="small fw-bold -bottom-32 salary_new'.$value->id.'">
                                        '.($salary_new>0?number_format($salary_new,2):'').'
                                    </span>
                                    <input type="hidden" class="salary_new" id="salary_new'.$value->id.'" name="salary_new[]" value="'.$salary_new.'">',
                    "newbwage_gmdm"=> '<span class="small fw-bold -bottom-32 salary_new_gmdm'.$value->id.'">
                                        '.($value->salary_new_gmdm>0?number_format($value->salary_new_gmdm,2):($salary_new>0?number_format($salary_new,2):'')).'
                                    </span>
                                    <input type="hidden" class="salary_new_gmdm" id="salary_new_gmdm'.$value->id.'" name="salary_new_gmdm[]" value="'.$salary_new.'">',
                    "newbsalary"=> '<span class="text-primary fw-bold salary_month_new'.$value->id.'">
                                        '.($salary_month_new>0?number_format($salary_month_new,2):'').'
                                    </span>
                                    ',
                    "newbsalary_gmdm"=> '<span class="text-primary fw-bold salary_month_new_gmdm'.$value->id.'">
                                        '.($value->salary_month_new_gmdm>0?number_format($value->salary_month_new_gmdm,2):($salary_month_new>0?number_format($salary_month_new,2):'')).'
                                    </span>
                                    <input type="hidden" class="salary_month_new_gmdm" id="salary_month_new_gmdm'.$value->id.'" name="salary_month_new_gmdm[]" value="'.$salary_month_new.'">',
                    "finaldmgm"=> '<span class="text-success fw-bold final_by_md_gm_amount'.$value->id.'">'.($value->status_salary=='1'?($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')):'').'</span>
                                    <input type="hidden" class="status_salary_hide" value="'.$value->status_salary.'">
                                    <input type="hidden" class="grade_code_hide" value="'.$value->grade_code.'">
                                    <input type="hidden" class="finaldmgm_hide" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2, '.', ''):($salary_month_new>0?number_format($salary_month_new,2, '.', ''):'')).'" >',
                    "finaldmgm_edit"=> '<input type="text" class="form-control form-control-sm '.($value->freeze_to_gmdm_edit==1?'text-light':'text-success').' fw-bold  '.($value->freeze_to_gmdm_edit==1?'bg-success':'bg-light-success').'" id="final_by_md_gm_amount'.$value->id.'" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')).'" onchange="update_final_by_md_gm_amount('.$value->id.','.($value->salary_type=='Daily'?'1':'2').');" min="0.00" OnKeyPress="return checknumber_final(this,'.$value->id.',\'final_by_md_gm_amount\',event)" style="width: 100px;">
                                    <input type="hidden" class="status_salary_hide" value="'.$value->status_salary.'">
                                    <input type="hidden" class="grade_code_hide" value="'.$value->grade_code.'">
                                    <input type="hidden" id="finaldmgm_hide'.$value->id.'" class="finaldmgm_hide" value="'.($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2, '.', ''):($salary_month_new>0?number_format($salary_month_new,2, '.', ''):'')).'" >',
                    "remark_view"=> $value->remark_grade,
                    "remark"=> '<input type="text" class="form-control form-control-sm" id="remark_grade'.$value->id.'" style="width:250px" value="'.$value->remark_grade.'" onchange="update_remark_grade(\''.$value->id.'\');">',
                    "status"=> $status_salary,
                    "action"=> $action,
                    "fieldby" =>  $orderBy,
                    // "orderby" =>  $order,
                    "freeze_to_gmdm"=> $value->freeze_to_gmdm,
                    // "not_up_salary"=> ($value->not_up_salary && $value->not_up_salary != ""?'
                    //                 <div style="display: flex;align-items: center;justify-content: center;">
                    //                     <span class="set_status1178 badge bg-danger text-light" style="height: 34px;"><i class="bi-check-circle fs-5"></i></span>
                    //                 </div>':''),
                ); 
                // $pagestart++;
            }
        }else{
            $formatted_data = [];
        }
        
        return response()->json([
            'data' => $formatted_data,
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
            'gatall_calall' => count($data),
        ]);
    }
}
