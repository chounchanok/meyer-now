<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\group\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportReport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\TotalAll;

class ExceldayController extends Controller
{
    public function export_excel_day(Request $request){
        set_time_limit(300);

        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_employee_no       = $request->input('search_employee_no');
        $search_month_day       = $request->input('search_month_day');
        $search_grade       = $request->input('search_grade');
        $search_status       = $request->input('search_status');
        $pagenow       = $request->input('pagenow');
        $pagenow_salary       = $request->input('pagenow_salary');
        $search_year       = $request->input('search_year');

        $previousYear = $search_year;
        
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.id AS employee_id',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_code',
        'tb_employee.position_description',
        'tb_employee.division_code',
        'tb_employee.division_description',
        'tb_employee.department_code',
        'tb_employee.department_description',
        'tb_employee.section_code',
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
            $gatall->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $gatall->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        $gatall->where('tb_employee_final_score.salary_type','Daily');
        

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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

            if($search_section == "all" || $search_section == ""){
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
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
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
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                if($search_department == "all" || $search_department == ""){
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
                if($search_section == "all" || $search_section == ""){
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

        if($search_division != "all" && $search_division != ""){
            $arr_search_division = [];
            $checka = strpos($search_division,',');
            if($checka >= 0){
                $ex = explode(',',$search_division);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_division,$value);
                    }
                }
            }else{
                array_push($arr_search_division,$search_division);
            }
            if(count($arr_search_division) > 0){
                $gatall->whereIn('tb_employee.division_code', $arr_search_division);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $gatall->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $gatall->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $gatall->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        if($search_grade != "all" && $search_grade != ""){
            $gatall->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $gatall->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall->where('tb_employee_final_score.status_salary',$search_status);
            }
        }

        $gatall->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
        ->orderBy('tb_employee_final_score.total_score', 'DESC');
        $gatall = $gatall->get();
        

        ///////////////////////////////////

        $nooo = 1;
        $finaldmgm_hide = 0;
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                $status_salary = '';
                if($value->status_salary == '0'){
                    $status_salary = 'In progress';
                }
                if($value->status_salary == '2'){
                    $status_salary = 'Reject';
                }
                if($value->status_salary == '1'){
                    $status_salary = 'Approved';
                }

                if($value->status_salary == '1'){
                    $finaldmgm_hide += $value->final_by_md_gm_amount;
                }
                $pa_grade = $value->pa_grade;

                $adjustg = $value->adjust_grade;
                $current = 0;
                $total_day = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
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
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
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
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
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
                    if($search_month_day != "all"){
                        if($search_month_day == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx = $salary_new*27.5;
                                $salary_month_new = round($salary_month_newx,-1);
                            }else{
                                if($value->grade_code == 'L800'){
                                    $salary_month_new = round($salary_new);
                                }else{
                                    $salary_month_new = round($salary_new)*26;
                                }
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
                
                $date_formatted = '';
                if($value->date_joined){
                    $date_joined_old = $value->date_joined;
                    $date_formatted = date("Y-m-d", strtotime($date_joined_old));
                }

                $approve_review_salary = 'style="display:none;"';
                if (Auth::user()->can('approve review salary')) {
                    $approve_review_salary = 'style="display:block;"';
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

                $data[] = array(
                    "id" =>  $nooo,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?$value->attendance_sl:'0.0'),
                    "pl"=> ($value->attendance_pl>0?$value->attendance_pl:'0.0'),
                    "latet"=> ($value->attendance_abt>0?$value->attendance_abt:'0.0'),
                    "lated"=> ($value->attendance_late>0?$value->attendance_late:'0.0'),
                    "abst"=> ($value->attendance_abt>0?$value->attendance_abt:'0.0'),
                    "absd"=> ($value->attendance_abs>0?$value->attendance_abs:'0.0'),
                    "ol"=> ($value->attendance_ol>0?$value->attendance_ol:'0.0'),
                    "totald"=> ($total_day>0?$total_day:'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?$value->attendance_vwar:'0.0'),
                    "written"=> ($value->attendance_wwar>0?$value->attendance_wwar:'0.0'),
                    "susd"=> ($value->attendance_sus>0?$value->attendance_sus:'0.0'),
                    "pa1"=> ($value->adjust_grade_old1?$value->adjust_grade_old1:'-'),
                    "pa2"=> ($value->adjust_grade_old2?$value->adjust_grade_old2:'-'),
                    "pa3"=> ($value->adjust_grade_old3?$value->adjust_grade_old3:'-'),
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?$value->total_score:'0.00'),
                    "theoryg"=> $pa_grade,
                    "adjustg"=> $adjustg,
                    "current"=> ($current>0?$current:''),
                    
                    "l800avg_gmdm"=> ($l800avg_wage>0?$l800avg_wage:''),
                    "bsalaryw"=> ($bsalary_wage>0?$bsalary_wage:''),
                    "cbsalaryw"=> ($salary_month_old>0?$salary_month_old:''),
                    "comsugpct"=> ($company_suggested_per>0?$company_suggested_per:0.00),
                    "comsugamt"=> ($company_suggestged_amount>0?$company_suggestged_amount:0.00),
                    "companynewb"=> ($company_suggestged_new_basic>0?$company_suggestged_new_basic:0.00),
                    
                    "gmgr_span2"=> ($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')),
                    
                    
                    "incpctmgr_span"=> ($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')),
                    
                    "incamount"=> ($amount_proposed>0?$amount_proposed:''),
                    "newbwage"=> ($salary_new>0?$salary_new:''),
                    "newbsalary"=> ($salary_month_new>0?$salary_month_new:''),
                    "finaldmgm"=> ($value->status_salary=='1'?($value->final_by_md_gm_amount>0?$value->final_by_md_gm_amount:($salary_month_new>0?$salary_month_new:'')):''),
                    "remark_view"=> $value->remark_grade,
                    
                    
                    
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "grade_code"=> $value->grade_code,
                    "status_salary"=>$status_salary
                ); 
                $nooo++;
            }
        }else{
            $data = [];
        }
        ///////////////////////////////////////////////////////////////
        
        // dd($countdata);
        // exit;
        
        $excel = public_path('upload/orisoft/')."template_Increment_day.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);
        // $spreadsheet2 = $reader->load($excel);
        // $spreadsheet3 = $reader->load($excel);
        // $spreadsheet4 = $reader->load($excel);

        $sheet2 = $spreadsheet->getActiveSheet();
        $sheet2 = $spreadsheet->getSheet(0);
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3 = $spreadsheet->getSheet(2);
        // }
        
        $sheet4 = $spreadsheet->getSheet(1);
        // $sheet2 = $spreadsheet->getActiveSheet(1);
        // $sheet3 = $spreadsheet->getActiveSheet(2);
        
        
        
        // $sheet->setCellValue('A1', '1');
        // $sheet2->setCellValue('A1', '2');
        // $sheet3->setCellValue('A1', '3');
        // $sheet->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        $sheet2->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // }
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
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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

            if($search_section == "all" || $search_section == ""){
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

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
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
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                if($search_department == "all" || $search_department == ""){
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
                if($search_section == "all" || $search_section == ""){
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
        if($search_division){
            $arr_search_division_total_Daily = [];
            $checka_total_Daily = strpos($search_division,',');
            if($checka_total_Daily >= 0){
                $ex_total_Daily = explode(',',$search_division);
                if(count($ex_total_Daily)>0){
                    foreach ($ex_total_Daily as $value) {
                        array_push($arr_search_division_total_Daily,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Daily,$search_division);
            }
            if(count($arr_search_division_total_Daily) > 0){
                $total_Daily->whereIn('tb_employee.division_code', $arr_search_division_total_Daily);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Daily->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Daily->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $total_Daily->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        if($search_grade != "all" && $search_grade != ""){
            $total_Daily->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $total_Daily->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Daily->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        $total_Daily = $total_Daily->first();
        
        if($total_Daily->current_salary_wage){
            if($total_Daily->current_salary_wage > 0){
                $cal = ((($total_Daily->company_suggested_new_basic?$total_Daily->company_suggested_new_basic:0)/($total_Daily->current_salary_wage?$total_Daily->current_salary_wage:0))-1)*100;
                $total_Daily->company_suggested_percent = $cal;
            }
        }else{
            $total_Daily->company_suggested_percent = 0.00;
        }
        // dd($gatall);
        // exit;






































        $gatall_1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.id AS employee_id',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_code',
        'tb_employee.position_description',
        'tb_employee.division_code',
        'tb_employee.division_description',
        'tb_employee.department_code',
        'tb_employee.department_description',
        'tb_employee.section_code',
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
            $gatall_1->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $gatall_1->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall_1->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checka_1 = strpos($orisoft_all_code->division_code,',');
                $arr_division_code_1 = [];
                if($checka_1 >= 0){
                    $ex_1 = explode(',',$orisoft_all_code->division_code);
                    if(count($ex_1)>0){
                        foreach ($ex_1 as $value) {
                            array_push($arr_division_code_1,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code_1,$orisoft_all_code->division_code);
                }
                $gatall_1 = $gatall_1->whereIn('tb_employee.division_code',$arr_division_code_1);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_code_1 = [];
                $checka_1 = strpos($orisoft_all_code->department_code,',');
                if($checka_1 >= 0){
                    $ex_1 = explode(',',$orisoft_all_code->department_code);
                    if(count($ex_1)>0){
                        foreach ($ex_1 as $value) {
                            array_push($arr_department_code_1,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code_1,$orisoft_all_code->department_code);
                }
                $gatall_1 = $gatall_1->whereIn('tb_employee.department_code',$arr_department_code_1);
            }

            if($search_section == "all" || $search_section == ""){
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
                $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_1 = [];
                $countsection_1 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_1 = $countsection_1->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_1)>0){
                    foreach ($countsection_1 as $value) {
                        array_push($arr_countsection_1,$value->division_code);
                    }
                }
                $gatall_1 = $gatall_1->whereIn('tb_employee.division_code',$arr_countsection_1);
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                    $gatall_1 = $gatall_1->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if($search_department == "all" || $search_department == ""){
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
                        $gatall_1 = $gatall_1->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if($search_section == "all" || $search_section == ""){
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
                    $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division){
            $arr_search_division_gatall_1 = [];
            $checka_gatall_1 = strpos($search_division,',');
            if($checka_gatall_1 >= 0){
                $ex_gatall_1 = explode(',',$search_division);
                if(count($ex_gatall_1)>0){
                    foreach ($ex_gatall_1 as $value) {
                        array_push($arr_search_division_gatall_1,$value);
                    }
                }
            }else{
                array_push($arr_search_division_gatall_1,$search_division);
            }
            if(count($arr_search_division_gatall_1) > 0){
                $gatall_1->whereIn('tb_employee.division_code', $arr_search_division_gatall_1);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall_1->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $gatall_1->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $gatall_1->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $gatall_1->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $gatall_1->where('tb_employee_final_score.salary_type','Daily');
        if($search_grade != "all" && $search_grade != ""){
            $gatall_1->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $gatall_1->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall_1->where('tb_employee_final_score.status_salary',$search_status);
            }
        }


        $gatall_1->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
        ->orderBy('tb_employee_final_score.total_score', 'DESC');
        $gatall_1 = $gatall_1->get();
        

        ///////////////////////////////////

        $nooo_1 = 1;
        $finaldmgm_hide_2 = 0;
        if(count($gatall_1)>0){
            foreach ($gatall_1 as $key => $value) {
                $status_salary = '';
                if($value->status_salary == '0'){
                    $status_salary = 'In progress';
                }
                if($value->status_salary == '2'){
                    $status_salary = 'Reject';
                }
                if($value->status_salary == '1'){
                    $status_salary = 'Approved';
                }
                  
                if($value->status_salary == '1'){
                    $finaldmgm_hide_2 += $value->final_by_md_gm_amount;
                }
                $pa_grade_1 = $value->pa_grade;
                $adjustg_1 = $value->adjust_grade;
                $current_1 = 0;
                $total_day_1 = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                $current_1 = $value->salary_old;
                if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                    $l800avg_wage_1 = $value->l800avg_wage;
                }else{
                    $l800avg_wage_1 = '';
                }
                $bsalary_wage_1 = 0;
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_1 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_1 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_1 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_1 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }
                }
                
                $salary_month_old_1 = $value->salary_month_old;
                if($value->grade_code == 'L800'){
                    $salary_month_old_1 = (float)$bsalary_wage_1*26;
                }
                $company_suggested_per_1 = $value->company_suggested_per;
                $percent_proposed_old_1 = $value->percent_proposed_old;
                $countbudget_1 = DB::table('tb_budget_action')
                            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                            ->where('tb_budget.year',$previousYear)->count();
                if($countbudget_1 > 0){
                    if($value->adjust_grade){
                        $databudget_1 = DB::table('tb_budget_action')
                        ->select('tb_budget_action.std')
                        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        ->where('tb_budget_action.grade_name',$value->adjust_grade)
                        ->where('tb_budget.year',$previousYear)->first();
                        $company_suggested_per_1 = $databudget_1->std;
                        $percent_proposed_old_1 = $databudget_1->std;
                    }
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1_1 = $value->service_days/365;
                }else{
                    $service_days1_1 = $value->service_days/365;
                }
                $service_days2_1 = $service_days1_1;
                
                $company_suggestged_amount_1 = $bsalary_wage_1*($company_suggested_per_1/100)*$service_days2_1;
                $company_suggestged_new_basic_1 = $value->company_suggestged_new_basic;
                if($value->grade_code == 'L800'){
                    $company_suggestged_new_basic_1 = round($company_suggestged_amount_1+$current_1);
                }else{
                    $company_suggestged_new_basic_1 = round($company_suggestged_amount_1+$bsalary_wage_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                }
                $value->company_suggestged_new_basic = $company_suggestged_new_basic_1;
                $amount_proposed_1 = $value->amount_proposed;
                if($bsalary_wage_1 > 0){
                    if($value->percent_proposed >= 0){
                        $amount_proposed_1 = $bsalary_wage_1*($value->percent_proposed/100)*$service_days2_1;
                    }else{
                        $amount_proposed_1 = $bsalary_wage_1*($percent_proposed_old_1/100)*$service_days2_1;
                    }
                }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $salary_new_1 = round($amount_proposed_1+$current_1);
                    }else{
                        $salary_new_1 = round($amount_proposed_1+$current_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $salary_new_1 = round($amount_proposed_1+$current_1);
                    }else{
                        $salary_new_1 = round($amount_proposed_1+$current_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }
                
                $salary_month_new_1 = ($value->salary_month_new?$value->salary_month_new:0);
                if($salary_new_1 > 0){
                    if($search_month_day != "all"){
                        if($search_month_day == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_1 = $salary_new_1*27.5;
                                $salary_month_new_1 = round($salary_month_newx_1,-1);
                            }else{
                                if($value->grade_code == 'L800'){
                                    $salary_month_new_1 = round($salary_new_1)*26;
                                }else{
                                    $salary_month_new_1 = round($salary_new_1);
                                }
                            }
                        }else{
                            $salary_month_new_1 = round($salary_new_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }else{
                        if($value->grade_code == 'L800'){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_1 = $salary_new_1*27.5;
                                $salary_month_new_1 = round($salary_month_newx_1,-1);
                            }else{
                                $salary_month_new_1 = round($salary_new_1)*26;
                            }
                        }else{
                            $salary_month_new_1 = round($salary_new_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }
                }
                
                $date_formatted_1 = '';
                if($value->date_joined){
                    $date_joined_old_1 = $value->date_joined;
                    $date_formatted_1 = date("Y-m-d", strtotime($date_joined_old_1));
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }else{
                    $service_days1 = $value->service_days/365;
                }
                
                $service_days2_1 = $service_days1;

                $data_1[] = array(
                    "id" =>  $nooo_1,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted_1,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> ($value->attendance_ol>0?number_format($value->attendance_ol,1):'0.0'),
                    "totald"=> ($total_day_1>0?number_format($total_day_1,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa1"=> ($value->adjust_grade_old1?$value->adjust_grade_old1:'-'),
                    "pa2"=> ($value->adjust_grade_old2?$value->adjust_grade_old2:'-'),
                    "pa3"=> ($value->adjust_grade_old3?$value->adjust_grade_old3:'-'),
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade_1,
                    "adjustg"=> $adjustg_1,
                    "current"=> ($current_1>0?number_format($current_1,2):''),
                    
                    "l800avg_gmdm"=> ($l800avg_wage_1>0?number_format($l800avg_wage_1,2):''),
                    "bsalaryw"=> ($bsalary_wage_1>0?number_format($bsalary_wage_1,2):''),
                    "cbsalaryw"=> ($salary_month_old_1>0?number_format($salary_month_old_1,2):''),
                    "comsugpct"=> ($company_suggested_per_1>0?number_format($company_suggested_per_1,2):0.00),
                    "comsugamt"=> ($company_suggestged_amount_1>0?number_format($company_suggestged_amount_1,2):0.00),
                    "companynewb"=> ($company_suggestged_new_basic_1>0?number_format($company_suggestged_new_basic_1,2):0.00),
                    
                    "gmgr_span2"=> ($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')),
                    
                    
                    "incpctmgr_span"=> ($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old_1,4,'.','')),
                    
                    "incamount"=> ($amount_proposed_1>0?number_format($amount_proposed_1,2):''),
                    "newbwage"=> ($salary_new_1>0?number_format($salary_new_1,2):''),
                    "newbsalary"=> ($salary_month_new_1>0?number_format($salary_month_new_1,2):''),
                    "finaldmgm"=> ($value->status_salary=='1'?($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')):''),
                    "remark_view"=> $value->remark_grade,
                    
                    
                    
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "grade_code"=> $value->grade_code,
                    "status_salary"=>$status_salary
                ); 
                $nooo_1++;
            }
        }else{
            $data_1 = [];
        }
        $countdata_1 = DB::table('tb_employee_final_score')
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
            $countdata_1->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $countdata_1->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $countdata_1->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checkacountdata_1 = strpos($orisoft_all_code->division_code,',');
                $arr_division_codecountdata_1 = [];
                if($checkacountdata_1 >= 0){
                    $excountdata_1 = explode(',',$orisoft_all_code->division_code);
                    if(count($excountdata_1)>0){
                        foreach ($excountdata_1 as $value) {
                            array_push($arr_division_codecountdata_1,$value);
                        }
                    }
                }else{
                    array_push($arr_division_codecountdata_1,$orisoft_all_code->division_code);
                }
                $countdata_1 = $countdata_1->whereIn('tb_employee.division_code',$arr_division_codecountdata_1);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_codecountdata_1 = [];
                $checkacountdata_1 = strpos($orisoft_all_code->department_code,',');
                if($checkacountdata_1 >= 0){
                    $excountdata_1 = explode(',',$orisoft_all_code->department_code);
                    if(count($excountdata_1)>0){
                        foreach ($excountdata_1 as $value) {
                            array_push($arr_department_codecountdata_1,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codecountdata_1,$orisoft_all_code->department_code);
                }
                $countdata_1 = $countdata_1->whereIn('tb_employee.department_code',$arr_department_codecountdata_1);
            }

            if($search_section == "all" || $search_section == ""){
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
                $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_1 = [];
                $countsection_1 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_1 = $countsection_1->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_1)>0){
                    foreach ($countsection_1 as $value) {
                        array_push($arr_countsection_1,$value->division_code);
                    }
                }
                $countdata_1 = $countdata_1->whereIn('tb_employee.division_code',$arr_countsection_1);
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                    $countdata_1 = $countdata_1->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if($search_department == "all" || $search_department == ""){
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
                        $countdata_1 = $countdata_1->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if($search_section == "all" || $search_section == ""){
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
                    $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_countdata_1 = [];
            $checka_countdata_1 = strpos($search_division,',');
            if($checka_countdata_1 >= 0){
                $ex_countdata_1 = explode(',',$search_division);
                if(count($ex_countdata_1)>0){
                    foreach ($ex_countdata_1 as $value) {
                        array_push($arr_search_division_countdata_1,$value);
                    }
                }
            }else{
                array_push($arr_search_division_countdata_1,$search_division);
            }
            if(count($arr_search_division_countdata_1) > 0){
                $countdata_1->whereIn('tb_employee.division_code', $arr_search_division_countdata_1);
            }
        }
        // if($search_division != "all"){
        //     $countdata_1->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $countdata_1->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $countdata_1->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $countdata_1->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $countdata_1->where('tb_employee_final_score.salary_type','Daily');
        if($search_grade != "all" && $search_grade != ""){
            $countdata_1->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $countdata_1->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata_1->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        $countdata_1 = $countdata_1->get();
        // dd($countdata_1);
        // exit;
        $countA_1 = 0;
        $countB_1 = 0;
        $countC_1 = 0;
        $countD_1 = 0;
        $countE_1 = 0;
        $countNoNull_1 = 0;

        $proposed_countAR_1 = 0;
        $proposed_countP_1 = 0;
        $proposed_countA_1 = 0;
        $proposed_countB_1 = 0;
        $proposed_countC_1 = 0;
        $proposed_countD_1 = 0;
        $proposed_countE_1 = 0;
        $proposed_countU_1 = 0;
        $proposed_countCD_1 = 0;
        $proposed_countNoNull_1 = 0;
        

        // dd($countdata_1);
        // exit;

        
        
        if(count($countdata_1)>0){
            foreach ($countdata_1 as $key => $value) {
                if($value->adjust_grade == 'A'){
                    $countA_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'B'){
                    $countB_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'C'){
                    $countC_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'D'){
                    $countD_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'E'){
                    $countE_1++;
                    $countNoNull_1++;
                }
    
                ///////////
    
                if($value->grade_proposed == 'AR'){
                    $proposed_countAR_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'P'){
                    $proposed_countP_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'A'){
                    $proposed_countA_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'B'){
                    $proposed_countB_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'C'){
                    $proposed_countC_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'D'){
                    $proposed_countD_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'E'){
                    $proposed_countE_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'U'){
                    $proposed_countU_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'CD'){
                    $proposed_countCD_1++;
                    $proposed_countNoNull_1++;
                }
            }
        }
        
        $sheet2->setCellValue('AI2', $countNoNull_1);
        $sheet2->setCellValue('AI4', $countA_1);
        $sheet2->setCellValue('AI5', $countB_1);
        $sheet2->setCellValue('AI6', $countC_1);
        $sheet2->setCellValue('AI7', $countD_1);
        $sheet2->setCellValue('AI8', $countE_1);
        
        $sumA_1 = 0;
        $sumB_1 = 0;
        $sumC_1 = 0;
        $sumD_1 = 0;
        $sumE_1 = 0;
        $bell_curve_1 = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        foreach ($bell_curve_1 as $key1 => $value1) {
            $percent_1 = $value1->percent/100;
            if($value1->grade_name == "A"){
                $sumA_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH4', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "B"){
                $sumB_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH5', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "C"){
                $sumC_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH6', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "D"){
                $sumD_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH7', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "E"){
                $sumE_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH8', ($percent_1?$percent_1:0));
            }
        }
        $sumAll_1 = $sumA_1+$sumB_1+$sumC_1+$sumD_1+$sumE_1;
        $sheet2->setCellValue('AH2', $sumAll_1);
        // dd($sumA);
        // exit;
        $sheet2->setCellValue('AI2', $sumAll_1);
        $sheet2->setCellValue('AI4', $sumA_1);
        $sheet2->setCellValue('AI5', $sumB_1);
        $sheet2->setCellValue('AI6', $sumC_1);
        $sheet2->setCellValue('AI7', $sumD_1);
        $sheet2->setCellValue('AI8', $sumE_1);
        ////////
        
        $proposed_sumAR_1 = ($proposed_countAR_1>0?($proposed_countAR_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumP_1 = ($proposed_countP_1>0?($proposed_countP_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumA_1 = ($proposed_countA_1>0?($proposed_countA_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumB_1 = ($proposed_countB_1>0?($proposed_countB_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumC_1 = ($proposed_countC_1>0?($proposed_countC_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumD_1 = ($proposed_countD_1>0?($proposed_countD_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumE_1 = ($proposed_countE_1>0?($proposed_countE_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumU_1 = ($proposed_countU_1>0?($proposed_countU_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumCD_1 = ($proposed_countCD_1>0?($proposed_countCD_1/$proposed_countNoNull_1)*100:0);

        $sheet2->setCellValue('AQ2', $proposed_countAR_1);
        $sheet2->setCellValue('AQ3', $proposed_countP_1);
        $sheet2->setCellValue('AQ4', $proposed_countA_1);
        $sheet2->setCellValue('AQ5', $proposed_countB_1);
        $sheet2->setCellValue('AQ6', $proposed_countC_1);
        $sheet2->setCellValue('AQ7', $proposed_countD_1);
        $sheet2->setCellValue('AQ8', $proposed_countE_1);
        $sheet2->setCellValue('AQ9', $proposed_countU_1);
        $sheet2->setCellValue('AQ10', $proposed_countCD_1);
        $sheet2->setCellValue('AQ1', $proposed_countNoNull_1);

        $sheet2->setCellValue('AR2', ($proposed_sumAR_1?number_format($proposed_sumAR_1/100,2):0));
        $sheet2->setCellValue('AR3', ($proposed_sumP_1?number_format($proposed_sumP_1/100,2):0));
        $sheet2->setCellValue('AR4', ($proposed_sumA_1?number_format($proposed_sumA_1/100,2):0));
        $sheet2->setCellValue('AR5', ($proposed_sumB_1?number_format($proposed_sumB_1/100,2):0));
        $sheet2->setCellValue('AR6', ($proposed_sumC_1?number_format($proposed_sumC_1/100,2):0));
        $sheet2->setCellValue('AR7', ($proposed_sumD_1?number_format($proposed_sumD_1/100,2):0));
        $sheet2->setCellValue('AR8', ($proposed_sumE_1?number_format($proposed_sumE_1/100,2):0));
        $sheet2->setCellValue('AR9', ($proposed_sumU_1?number_format($proposed_sumU_1/100,2):0));
        $sheet2->setCellValue('AR10', ($proposed_sumCD_1?number_format($proposed_sumCD_1/100,2):0));


        $budget_1 = DB::table('tb_budget_action')
        ->select('tb_budget_action.*')
        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
        ->where('tb_budget.year',$previousYear)
        ->orderBy('tb_budget_action.id', 'ASC')->get();
        if(count($budget_1)>0){
            foreach ($budget_1 as $key => $value1) {
                if($value1->grade_name == "AR"){
                    $sheet2->setCellValue('AL2', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM2', $value1->grade_name);
                    $sheet2->setCellValue('AN2', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "P"){
                    $sheet2->setCellValue('AL3', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM3', $value1->grade_name);
                    $sheet2->setCellValue('AN3', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "A"){
                    $sheet2->setCellValue('AL4', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM4', $value1->grade_name);
                    $sheet2->setCellValue('AN4', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "B"){
                    $sheet2->setCellValue('AL5', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM5', $value1->grade_name);
                    $sheet2->setCellValue('AN5', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "C"){
                    $sheet2->setCellValue('AL6', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM6', $value1->grade_name);
                    $sheet2->setCellValue('AN6', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "D"){
                    $sheet2->setCellValue('AL7', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM7', $value1->grade_name);
                    $sheet2->setCellValue('AN7', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "E"){
                    $sheet2->setCellValue('AL8', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM8', $value1->grade_name);
                    $sheet2->setCellValue('AN8', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "U"){
                    $sheet2->setCellValue('AL9', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM9', $value1->grade_name);
                    $sheet2->setCellValue('AN9', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "CD"){
                    $sheet2->setCellValue('AL10', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM10', $value1->grade_name);
                    $sheet2->setCellValue('AN10', ($value1->std?number_format($value1->std/100,2):0));
                }
            }
        }

        if($search_section != "all" && $search_section != ""){
            $percent_department_1 = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->where('tb_percent_department_action.section_code', 'like','%'.$search_section.'%')
            ->orderBy('tb_percent_department_action.id', 'ASC')->first();
            $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));

            $sheet2->setCellValue('AU2', ($percent_department_1->percent_daily?($percent_department_1->percent_daily/100):0));
        }else{
            if($search_department != "all" && $search_department != ""){
                $percent_department_1 = DB::table('tb_percent_department_action')
                ->select( 
                    DB::raw('SUM(percent_daily) AS percent_daily'),
                    DB::raw('SUM(percent_monthly) AS percent_monthly')
                )  
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year',$previousYear)
                ->where('tb_percent_department_action.department_code', 'like','%'.$search_department.'%')
                ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));
    
                $sheet2->setCellValue('AU2', ($percent_department_1->percent_daily?($percent_department_1->percent_daily/100):0));
            }else{
                if($search_division != "all" && $search_division != ""){
                    if($search_division){
                        $arr_search_division_countdata_1 = [];
                        $checka_countdata_1 = strpos($search_division,',');
                        if($checka_countdata_1 >= 0){
                            $ex_countdata_1 = explode(',',$search_division);
                            if(count($ex_countdata_1)>0){
                                foreach ($ex_countdata_1 as $value) {
                                    array_push($arr_search_division_countdata_1,$value);
                                }
                            }
                        }else{
                            array_push($arr_search_division_countdata_1,$search_division);
                        }
                    }
                    $percent_department_1 = DB::table('tb_percent_department_action')
                    ->select( 
                        DB::raw('SUM(percent_daily) AS percent_daily'),
                        DB::raw('SUM(percent_monthly) AS percent_monthly')
                    )  
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year',$previousYear)
                    ->whereIn('tb_percent_department_action.division_code', $arr_search_division_countdata_1)
                    ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                    $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));
        
                    $sheet2->setCellValue('AU2', ($percent_department_1->percent_daily?($percent_department_1->percent_daily/100):0));
                }else{
                    $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));
                }
            }
        }
        
        $total_Daily_1 = DB::table('tb_employee_final_score')
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
                $total_Daily_1->where('tb_employee_final_score.freeze_to_approve_hr', '1');
            }else{
                if($pagenow == "2"){
                    $total_Daily_1->where('tb_employee_final_score.freeze_to_gmdm', '1');
                }else{
                    $total_Daily_1->where('tb_employee_final_score.freeze_to_pagrade', '1');
                }
            }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checkatotal_Daily_1 = strpos($orisoft_all_code->division_code,',');
                $arr_division_codetotal_Daily_1 = [];
                if($checkatotal_Daily_1 >= 0){
                    $extotal_Daily_1 = explode(',',$orisoft_all_code->division_code);
                    if(count($extotal_Daily_1)>0){
                        foreach ($extotal_Daily_1 as $value) {
                            array_push($arr_division_codetotal_Daily_1,$value);
                        }
                    }
                }else{
                    array_push($arr_division_codetotal_Daily_1,$orisoft_all_code->division_code);
                }
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.division_code',$arr_division_codetotal_Daily_1);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_codetotal_Daily_1 = [];
                $checkatotal_Daily_1 = strpos($orisoft_all_code->department_code,',');
                if($checkatotal_Daily_1 >= 0){
                    $extotal_Daily_1 = explode(',',$orisoft_all_code->department_code);
                    if(count($extotal_Daily_1)>0){
                        foreach ($extotal_Daily_1 as $value) {
                            array_push($arr_department_codetotal_Daily_1,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codetotal_Daily_1,$orisoft_all_code->department_code);
                }
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.department_code',$arr_department_codetotal_Daily_1);
            }

            if($search_section == "all" || $search_section == ""){
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
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_1 = [];
                $countsection_1 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_1 = $countsection_1->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_1)>0){
                    foreach ($countsection_1 as $value) {
                        array_push($arr_countsection_1,$value->division_code);
                    }
                }
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.division_code',$arr_countsection_1);
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if($search_department == "all" || $search_department == ""){
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
                        $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if($search_section == "all" || $search_section == ""){
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
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_total_Daily_1 = [];
            $checka_total_Daily_1 = strpos($search_division,',');
            if($checka_total_Daily_1 >= 0){
                $ex_total_Daily_1 = explode(',',$search_division);
                if(count($ex_total_Daily_1)>0){
                    foreach ($ex_total_Daily_1 as $value) {
                        array_push($arr_search_division_total_Daily_1,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Daily_1,$search_division);
            }
            if(count($arr_search_division_total_Daily_1) > 0){
                $total_Daily_1->whereIn('tb_employee.division_code', $arr_search_division_total_Daily_1);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily_1->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Daily_1->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Daily_1->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $total_Daily_1->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        if($search_grade != "all" && $search_grade != ""){
            $total_Daily_1->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $total_Daily_1->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Daily_1->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        $total_Daily_1 = $total_Daily_1->first();
        
        if($total_Daily_1->current_salary_wage){
            if($total_Daily_1->current_salary_wage > 0){
                $cal_1 = ((($total_Daily_1->company_suggested_new_basic?$total_Daily_1->company_suggested_new_basic:0)/($total_Daily_1->current_salary_wage?$total_Daily_1->current_salary_wage:0))-1)*100;
                $total_Daily_1->company_suggested_percent = $cal_1;
            }
        }else{
            $total_Daily_1->company_suggested_percent = 0.00;
        }
        

        
        
        if($total_Daily->new_basic_wage_proposed > 0){
            $cal_daily_1 = ((($total_Daily->new_basic_wage_proposed/$total_Daily->current_salary_wage-1)*100)* 1000)/ 1000;
        }else{
            $cal_daily_1 = 0;
        }
        $cal_all_1 = $cal_daily_1;
        // dd($cal_month_1);
        // exit;
        $sheet2->setCellValue('AU1', ($cal_daily_1?$cal_daily_1/100:0));



        $numrow_1 = 13;
        $final_score = [];
        if(count($data_1)>0){
            foreach ($data_1 as $key => $value) {
                
                $date1_1 = $value['joindate'];
                $date2_1 = date('Y')."-01-31";

                $diff_1 = abs(strtotime($date2_1) - strtotime($date1_1));

                $years_1 = floor($diff_1 / (365*60*60*24));
                $months_1 = floor(($diff_1 - $years_1 * 365*60*60*24) / (30*60*60*24));
                $days_1 = floor(($diff_1 - $years_1 * 365*60*60*24 - $months_1*30*60*60*24)/ (60*60*24));

                // printf("%d years, %d months, %d days\n", $years, $months, $days);
                // exit;
                if($value['pa1'] == "AR"){
                    $bg_color_pa1_1 = 'FFFFFF';
                }else if($value['pa1'] == "P"){
                    $bg_color_pa1_1 = 'FFFFFF';
                }else if($value['pa1'] == "A"){
                    $bg_color_pa1_1 = '9FCE63';
                }else if($value['pa1'] == "B"){
                    $bg_color_pa1_1 = 'BFDDE7';
                }else if($value['pa1'] == "C"){
                    $bg_color_pa1_1 = 'DAE4C0';
                }else if($value['pa1'] == "D"){
                    $bg_color_pa1_1 = 'FFFFD1';
                }else if($value['pa1'] == "E"){
                    $bg_color_pa1_1 = 'DFBAB8';
                }else if($value['pa1'] == "U"){
                    $bg_color_pa1_1 = 'FFFFFF';
                }else{
                    $bg_color_pa1_1 = 'FFFFFF';
                }
                if($value['pa2'] == "AR"){
                    $bg_color_pa2_1 = 'FFFFFF';
                }else if($value['pa2'] == "P"){
                    $bg_color_pa2_1 = 'FFFFFF';
                }else if($value['pa2'] == "A"){
                    $bg_color_pa2_1 = '9FCE63';
                }else if($value['pa2'] == "B"){
                    $bg_color_pa2_1 = 'BFDDE7';
                }else if($value['pa2'] == "C"){
                    $bg_color_pa2_1 = 'DAE4C0';
                }else if($value['pa2'] == "D"){
                    $bg_color_pa2_1 = 'FFFFD1';
                }else if($value['pa2'] == "E"){
                    $bg_color_pa2_1 = 'DFBAB8';
                }else if($value['pa2'] == "U"){
                    $bg_color_pa2_1 = 'FFFFFF';
                }else{
                    $bg_color_pa2_1 = 'FFFFFF';
                }

                if($value['pa3'] == "AR"){
                    $bg_color_pa3_1 = 'FFFFFF';
                }else if($value['pa3'] == "P"){
                    $bg_color_pa3_1 = 'FFFFFF';
                }else if($value['pa3'] == "A"){
                    $bg_color_pa3_1 = '9FCE63';
                }else if($value['pa3'] == "B"){
                    $bg_color_pa3_1 = 'BFDDE7';
                }else if($value['pa3'] == "C"){
                    $bg_color_pa3_1 = 'DAE4C0';
                }else if($value['pa3'] == "D"){
                    $bg_color_pa3_1 = 'FFFFD1';
                }else if($value['pa3'] == "E"){
                    $bg_color_pa3_1 = 'DFBAB8';
                }else if($value['pa3'] == "U"){
                    $bg_color_pa3_1 = 'FFFFFF';
                }else{
                    $bg_color_pa3_1 = 'FFFFFF';
                }
                if($value['theoryg'] == "AR"){
                    $bg_color_theoryg_1 = 'FFFFFF';
                }else if($value['theoryg'] == "P"){
                    $bg_color_theoryg_1 = 'FFFFFF';
                }else if($value['theoryg'] == "A"){
                    $bg_color_theoryg_1 = '9FCE63';
                }else if($value['theoryg'] == "B"){
                    $bg_color_theoryg_1 = 'BFDDE7';
                }else if($value['theoryg'] == "C"){
                    $bg_color_theoryg_1 = 'DAE4C0';
                }else if($value['theoryg'] == "D"){
                    $bg_color_theoryg_1 = 'FFFFD1';
                }else if($value['theoryg'] == "E"){
                    $bg_color_theoryg_1 = 'DFBAB8';
                }else if($value['theoryg'] == "U"){
                    $bg_color_theoryg_1 = 'FFFFFF';
                }else{
                    $bg_color_theoryg_1 = 'FFFFFF';
                }
                if($value['adjustg'] == "AR"){
                    $bg_color_adjustg_1 = 'FFFFFF';
                }else if($value['adjustg'] == "P"){
                    $bg_color_adjustg_1 = 'FFFFFF';
                }else if($value['adjustg'] == "A"){
                    $bg_color_adjustg_1 = '9FCE63';
                }else if($value['adjustg'] == "B"){
                    $bg_color_adjustg_1 = 'BFDDE7';
                }else if($value['adjustg'] == "C"){
                    $bg_color_adjustg_1 = 'DAE4C0';
                }else if($value['adjustg'] == "D"){
                    $bg_color_adjustg_1 = 'FFFFD1';
                }else if($value['adjustg'] == "E"){
                    $bg_color_adjustg_1 = 'DFBAB8';
                }else if($value['adjustg'] == "U"){
                    $bg_color_adjustg_1 = 'FFFFFF';
                }else{
                    $bg_color_adjustg_1 = 'FFFFFF';
                }
                if($value['gmgr_span2'] == "AR"){
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "P"){
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "A"){
                    $bg_color_gmgr_span2_1 = '9FCE63';
                }else if($value['gmgr_span2'] == "B"){
                    $bg_color_gmgr_span2_1 = 'BFDDE7';
                }else if($value['gmgr_span2'] == "C"){
                    $bg_color_gmgr_span2_1 = 'DAE4C0';
                }else if($value['gmgr_span2'] == "D"){
                    $bg_color_gmgr_span2_1 = 'FFFFD1';
                }else if($value['gmgr_span2'] == "E"){
                    $bg_color_gmgr_span2_1 = 'DFBAB8';
                }else if($value['gmgr_span2'] == "U"){
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }else{
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }

                $bg_color_status_salary_1 = 'f1f1f2';
                if($value['status_salary'] == 'In progress'){
                    $bg_color_status_salary_1 = 'f1f1f2';
                }
                if($value['status_salary'] == 'Reject'){
                    $bg_color_status_salary_1 = 'fff5f8';
                }
                if($value['status_salary'] == 'Approved'){
                    $bg_color_status_salary_1 = 'e8fff3';
                }
                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('A'.$numrow_1.':AX'.$numrow_1)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('000000'));
                $sheet2->setCellValue('A'.$numrow_1, $value['division_code']);
                $sheet2->setCellValue('B'.$numrow_1, $value['department_code']);
                $sheet2->setCellValue('C'.$numrow_1, $value['section_code']);
                $sheet2->setCellValue('D'.$numrow_1, ($value['grade_code']=='L800'?'Daily':'Monthly'));
                $sheet2->setCellValue('E'.$numrow_1, $value['grade_code']);
                $sheet2->setCellValue('F'.$numrow_1, $value['id']);
                $sheet2->setCellValue('G'.$numrow_1, $value['code']);
                $sheet2->setCellValue('H'.$numrow_1, $value['name']);
                $sheet2->setCellValue('I'.$numrow_1, $value['position']);
                $sheet2->setCellValue('J'.$numrow_1, $value['group']);
                $sheet2->setCellValue('K'.$numrow_1, $value['joindate']);

                $sheet2->setCellValue('L'.$numrow_1, $years_1);
                $sheet2->setCellValue('M'.$numrow_1, $months_1);
                $sheet2->setCellValue('N'.$numrow_1, $days_1);
                
                $sheet2->setCellValue('O'.$numrow_1, $value['serviced']);
                

                $sheet2->setCellValue('P'.$numrow_1, $value['sl']);
                $sheet2->setCellValue('Q'.$numrow_1, $value['pl']);
                $sheet2->setCellValue('R'.$numrow_1, $value['latet']);
                $sheet2->setCellValue('S'.$numrow_1, $value['lated']);
                $sheet2->setCellValue('T'.$numrow_1, $value['abst']);
                $sheet2->setCellValue('U'.$numrow_1, $value['absd']);
                $sheet2->setCellValue('V'.$numrow_1, $value['ol']);
                $sheet2->setCellValue('W'.$numrow_1, $value['totald']);
                $sheet2->setCellValue('X'.$numrow_1, $value['verbal']);
                $sheet2->setCellValue('Y'.$numrow_1, $value['written']);
                $sheet2->setCellValue('Z'.$numrow_1, $value['susd']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AA'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa1_1);
                $sheet2->setCellValue('AA'.$numrow_1, $value['pa1']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AB'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa2_1);
                $sheet2->setCellValue('AB'.$numrow_1, $value['pa2']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AC'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa3_1);
                $sheet2->setCellValue('AC'.$numrow_1, $value['pa3']);
                $sheet2->setCellValue('AD'.$numrow_1, $value['form']);
                $sheet2->setCellValue('AE'.$numrow_1, $value['evaluator']);
                $sheet2->setCellValue('AF'.$numrow_1, $value['total']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AG'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_theoryg_1);
                $sheet2->setCellValue('AG'.$numrow_1, $value['theoryg']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AH'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_adjustg_1);
                $sheet2->setCellValue('AH'.$numrow_1, $value['adjustg']);
                $sheet2->setCellValue('AI'.$numrow_1, $value['current']);
                $sheet2->setCellValue('AJ'.$numrow_1, $value['l800avg_gmdm']);
                $sheet2->setCellValue('AK'.$numrow_1, $value['bsalaryw']);
                $sheet2->setCellValue('AL'.$numrow_1, $value['cbsalaryw']);
                $sheet2->setCellValue('AM'.$numrow_1, $value['comsugpct']);
                $sheet2->setCellValue('AN'.$numrow_1, $value['comsugamt']);
                $sheet2->setCellValue('AO'.$numrow_1, $value['companynewb']);

                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AP'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_gmgr_span2_1);
                $sheet2->setCellValue('AP'.$numrow_1, $value['gmgr_span2']);
                $sheet2->setCellValue('AQ'.$numrow_1, $value['incpctmgr_span']);
                $sheet2->setCellValue('AR'.$numrow_1, $value['incamount']);
                $sheet2->setCellValue('AS'.$numrow_1, $value['newbwage']);
                $sheet2->setCellValue('AT'.$numrow_1, $value['newbsalary']);
                $sheet2->setCellValue('AU'.$numrow_1, $value['finaldmgm']);
                $sheet2->setCellValue('AV'.$numrow_1, $value['remark_view']);

                $spreadsheet
                ->getSheet(0)
                ->getStyle('AX'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_status_salary_1);
                $sheet2->setCellValue('AX'.$numrow_1, $value['status_salary']);
                $numrow_1++;
            }
        }













































































        function month($datadate){
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            // $array = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
            return date("d",strtotime($datadate)).'-'.$array[date('n',strtotime($datadate))].'-'.(date("Y",strtotime($datadate)));

        }
        function month_between($datadate){
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            // $array = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
            return $array[date('n',strtotime($datadate))].' '.(date("Y",strtotime($datadate)));

        }
        function DateDiff($strDate1,$strDate2){
            return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
        }
        $sheet4->setCellValue('A1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        $numsheet4 = 3;
        $nosheet4 = 1;
        $bell_curve_2 = DB::table('tb_pa_timeline_action')
        ->select('tb_pa_timeline_action.*')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$previousYear)
        ->orderBy('tb_pa_timeline_action.id', 'ASC')->get();
        foreach ($bell_curve_2 as $key1 => $value1) {
            if($value1->start_date){
                if($value1->start_date == $value1->end_date){
                    $value1->start_date = month($value1->start_date);
                }else{
                    $cal = DateDiff($value1->start_date,$value1->end_date)+1;
                    $cut1 = explode('-',$value1->start_date);
                    $cut2 = explode('-',$value1->end_date);
                    $newdata = $cut1[2].' - '.$cut2[2].' ';
                    $value1->start_date = $newdata.month_between($value1->end_date);
                }
            }
            if($value1->start_date_real){
                if($value1->start_date_real == $value1->end_date_real){
                    $value1->start_date_real = month($value1->start_date_real);
                }else{
                    $cal = DateDiff($value1->start_date_real,$value1->end_date_real)+1;
                    $cut1 = explode('-',$value1->start_date_real);
                    $cut2 = explode('-',$value1->end_date_real);
                    $newdata = $cut1[2].' - '.$cut2[2].' ';
                    $value1->start_date_real = $newdata.month_between($value1->end_date_real);
                }
            }
            $person = '';
            if($value1->hr == 'active'){
                $person .= 'HR / ';
            }
            if($value1->manager == 'active'){
                if($value1->manager_select == '019492'){
                    $person .= 'Pimnada / ';
                }else{
                    $person .= 'Managers / ';
                }
            }
            if($value1->dm == 'active'){
                $person .= 'DM / ';
            }
            if($value1->gm == 'active'){
                $person .= 'GM / ';
            }
            $person = substr($person,0,-3);
            $sheet4->setCellValue('A'.$numsheet4, $nosheet4.'.'.$value1->action_name);
            $sheet4->setCellValue('B'.$numsheet4, $value1->start_date);
            $sheet4->setCellValue('C'.$numsheet4, $value1->start_date_real);
            $sheet4->setCellValue('D'.$numsheet4, $person);
            $sheet4->setCellValue('E'.$numsheet4, ($value1->hr == 'active'?'/':''));
            $sheet4->setCellValue('F'.$numsheet4, ($value1->manager == 'active'?'/':''));
            $sheet4->setCellValue('G'.$numsheet4, ($value1->dm == 'active'?'/':''));
            $sheet4->setCellValue('H'.$numsheet4, ($value1->gm == 'active'?'/':''));
            $numsheet4++;
            $nosheet4++;
        }



















































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

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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

            if($search_section == "all" || $search_section == ""){
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
        
        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
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
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                if($search_department == "all" || $search_department == ""){
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
                if($search_section == "all" || $search_section == ""){
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
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_total_Daily_filter = [];
            $checka_total_Daily_filter = strpos($search_division,',');
            if($checka_total_Daily_filter >= 0){
                $ex_total_Daily_filter = explode(',',$search_division);
                if(count($ex_total_Daily_filter)>0){
                    foreach ($ex_total_Daily_filter as $value) {
                        array_push($arr_search_division_total_Daily_filter,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Daily_filter,$search_division);
            }
            if(count($arr_search_division_total_Daily_filter) > 0){
                $total_Daily_filter->whereIn('tb_employee.division_code', $arr_search_division_total_Daily_filter);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily_filter->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Daily_filter->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Daily_filter->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $total_Daily_filter->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $total_Daily_filter->where('tb_employee_final_score.salary_type','Daily');
        if($search_grade != "all" && $search_grade != ""){
            $total_Daily_filter->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $total_Daily_filter->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Daily_filter->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        $total_Daily_filter = $total_Daily_filter->first();
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
                if($total_Daily_filter->final_by_md_gm_amount > 0){
                    $cal2 = ((($total_Daily_filter->final_by_md_gm_amount?$total_Daily_filter->final_by_md_gm_amount:0)/($total_Daily_filter->current_salary_wage?$total_Daily_filter->current_salary_wage:0))-1)*100;
                    $total_Daily_filter->inc_percent_proposed = $cal2;
                }
            }else{
                $total_Daily_filter->company_suggested_percent = 0.00;
            }
        }
        
        

        
        
        $current_salary_wage = 0;
        $company_suggested_new_basic = 0;
        $company_suggested_percent = 0;
        
        $current_salary_wage_month = 0;
        $new_salary_wage_month = 0;
        $inc_percent_proposed = 0;
        
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


        
        $numrowNew_2 = $numrow_1+6;

        
        
        
        $numrowNew_2 = $numrowNew_2+1;
        
        $sheet2->setCellValue('AH'.$numrowNew_2, 'DAILY ');
        $sheet2->setCellValue('AI'.$numrowNew_2, ($total_Daily_filter->current_salary_wage>0?number_format($total_Daily_filter->current_salary_wage,2):'0.00'));
        $sheet2->setCellValue('AJ'.$numrowNew_2, ($total_Daily_filter->L800_avg_wage_mwa>0?number_format($total_Daily_filter->L800_avg_wage_mwa,2):'0.00'));
        $sheet2->setCellValue('AK'.$numrowNew_2, ($total_Daily_filter->salary_wage_calculation>0?number_format($total_Daily_filter->salary_wage_calculation,2):'0.00'));
        $sheet2->setCellValue('AL'.$numrowNew_2, ($total_Daily_filter->current_salary_wage_month>0?number_format($total_Daily_filter->current_salary_wage_month,2):'0.00'));
        $sheet2->setCellValue('AM'.$numrowNew_2, ($total_Daily_filter->company_suggested_percent>0?number_format($total_Daily_filter->company_suggested_percent,2):'0.00'));
        $sheet2->setCellValue('AN'.$numrowNew_2, ($total_Daily_filter->company_suggested_amount>0?number_format($total_Daily_filter->company_suggested_amount,2):'0.00'));
        $sheet2->setCellValue('AO'.$numrowNew_2, ($total_Daily_filter->company_suggested_new_basic>0?number_format($total_Daily_filter->company_suggested_new_basic,2):'0.00'));
        $sheet2->setCellValue('AQ'.$numrowNew_2, ($total_Daily_filter->inc_percent_proposed>=0?number_format($total_Daily_filter->inc_percent_proposed,2):'0.00'));
        $sheet2->setCellValue('AR'.$numrowNew_2, ($total_Daily_filter->inc_amount_proposed>0?number_format(round($total_Daily_filter->inc_amount_proposed),2):'0.00'));
        $sheet2->setCellValue('AS'.$numrowNew_2, ($total_Daily_filter->new_basic_wage_proposed>0?number_format($total_Daily_filter->new_basic_wage_proposed,2):'0.00'));
        $sheet2->setCellValue('AT'.$numrowNew_2, ($total_Daily_filter->new_salary_wage_month>0?number_format($total_Daily_filter->new_salary_wage_month,2):'0.00'));
        $sheet2->setCellValue('AU'.$numrowNew_2, ($finaldmgm_hide_2>0?number_format($finaldmgm_hide_2,2):''));
        
        $numrowNew_2 = $numrowNew_2+1;
        
        // $sheet2->setCellValue('AH'.$numrowNew_2, 'TOTAL MONTHLY+DAILY ');
        // $sheet2->setCellValue('AI'.$numrowNew_2, ($total_Daily_Monthly['current_salary_wage']>0?number_format($total_Daily_Monthly['current_salary_wage'],2):'0.00'));
        // $sheet2->setCellValue('AJ'.$numrowNew_2, ($total_Daily_Monthly['L800_avg_wage_mwa']>0?number_format($total_Daily_Monthly['L800_avg_wage_mwa'],2):'0.00'));
        // $sheet2->setCellValue('AK'.$numrowNew_2, ($total_Daily_Monthly['salary_wage_calculation']>0?number_format($total_Daily_Monthly['salary_wage_calculation'],2):'0.00'));
        // $sheet2->setCellValue('AL'.$numrowNew_2, ($total_Daily_Monthly['current_salary_wage_month']>0?number_format($total_Daily_Monthly['current_salary_wage_month'],2):'0.00'));
        // $sheet2->setCellValue('AM'.$numrowNew_2, ($total_Daily_Monthly['company_suggested_percent']>0?number_format($total_Daily_Monthly['company_suggested_percent'],2):'0.00'));
        // $sheet2->setCellValue('AN'.$numrowNew_2, ($total_Daily_Monthly['company_suggested_amount']>0?number_format($total_Daily_Monthly['company_suggested_amount'],2):'0.00'));
        // $sheet2->setCellValue('AO'.$numrowNew_2, ($total_Daily_Monthly['company_suggested_new_basic']>0?number_format($total_Daily_Monthly['company_suggested_new_basic'],2):'0.00'));
        // $sheet2->setCellValue('AQ'.$numrowNew_2, ($total_Daily_Monthly['inc_percent_proposed']>0?number_format($total_Daily_Monthly['inc_percent_proposed'],2):'0.00'));
        // $sheet2->setCellValue('AR'.$numrowNew_2, ($total_Daily_Monthly['inc_amount_proposed']>0?number_format($total_Daily_Monthly['inc_amount_proposed'],2):'0.00'));
        // $sheet2->setCellValue('AS'.$numrowNew_2, ($total_Daily_Monthly['new_basic_wage_proposed']>0?number_format($total_Daily_Monthly['new_basic_wage_proposed'],2):'0.00'));
        // $sheet2->setCellValue('AT'.$numrowNew_2, ($total_Daily_Monthly['new_salary_wage_month']>0?number_format($total_Daily_Monthly['new_salary_wage_month'],2):'0.00'));
        // $sheet2->setCellValue('AU'.$numrowNew_2, ($finaldmgm_hide>0?number_format($finaldmgm_hide,2):''));

        
        // $numrowNew_2 = $numrowNew_2+1;
        $sheet2->setCellValue('AL'.$numrowNew_2, 'Baht/Month');
        $sheet2->setCellValue('AT'.$numrowNew_2, 'Baht/Month');

        $numrowNew_2 = $numrowNew_2+6;
        
        $sheet2->setCellValue('AN'.$numrowNew_2, 'Proposed by ');
        $sheet2->setCellValue('AT'.$numrowNew_2, 'Approved by ');

        $spreadsheet
        ->getSheet(0)
        ->getStyle('AO'.$numrowNew_2.':AQ'.$numrowNew_2)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        $spreadsheet
        ->getSheet(0)
        ->getStyle('AU'.$numrowNew_2.':AW'.$numrowNew_2)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        
        $numrowNew_2 = $numrowNew_2+1;
        
        $sheet2->setCellValue('AP'.$numrowNew_2, 'Div/Dept Manager');
        $sheet2->setCellValue('AV'.$numrowNew_2, 'G.M.');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // $spreadsheet->createSheet();
        // $spreadsheet->setActiveSheetIndex(2);
        // $spreadsheet->getActiveSheet()->setTitle('Monthly');
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // $spreadsheet->createSheet();
        // $spreadsheet->setActiveSheetIndex(3);
        // $spreadsheet->getActiveSheet()->setTitle('Timeline 2023');
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PA _ '.date('Y').' Increment.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function export_excel_day_approve(Request $request){
        set_time_limit(300);

        $search_division       = $request->input('search_division');
        $search_department       = $request->input('search_department');
        $search_section       = $request->input('search_section');
        $search_employee_no       = $request->input('search_employee_no');
        $search_month_day       = $request->input('search_month_day');
        $search_grade       = $request->input('search_grade');
        $search_status       = $request->input('search_status');
        $search_group       = $request->input('search_group');
        $pagenow       = $request->input('pagenow');
        $pagenow_salary       = $request->input('pagenow_salary');
        $search_year       = $request->input('search_year');

        $previousYear = $search_year;
        
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $gatall = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.id AS employee_id',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_code',
        'tb_employee.position_description',
        'tb_employee.division_code',
        'tb_employee.division_description',
        'tb_employee.department_code',
        'tb_employee.department_description',
        'tb_employee.section_code',
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
            $gatall->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $gatall->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        $gatall->where('tb_employee_final_score.salary_type','Daily');
        

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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

            if($search_section == "all" || $search_section == ""){
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
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
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
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $gatall = $gatall->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $gatall->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                if($search_department == "all" || $search_department == ""){
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
                if($search_section == "all" || $search_section == ""){
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

        if($search_division != "all" && $search_division != ""){
            $arr_search_division = [];
            $checka = strpos($search_division,',');
            if($checka >= 0){
                $ex = explode(',',$search_division);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_division,$value);
                    }
                }
            }else{
                array_push($arr_search_division,$search_division);
            }
            if(count($arr_search_division) > 0){
                $gatall->whereIn('tb_employee.division_code', $arr_search_division);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $gatall->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $gatall->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $gatall->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $gatall = $gatall->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $gatall->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $gatall->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $gatall->where('tb_employee.position_description','like','%Manager%');
            }else{
                $gatall->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        $gatall->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
        ->orderBy('tb_employee_final_score.total_score', 'DESC');
        $gatall = $gatall->get();
        

        ///////////////////////////////////

        $nooo = 1;
        $finaldmgm_hide = 0;
        if(count($gatall)>0){
            foreach ($gatall as $key => $value) {
                $status_salary = '';
                if($value->status_salary == '0'){
                    $status_salary = 'In progress';
                }
                if($value->status_salary == '2'){
                    $status_salary = 'Reject';
                }
                if($value->status_salary == '1'){
                    $status_salary = 'Approved';
                }

                if($value->status_salary == '1'){
                    $finaldmgm_hide += $value->final_by_md_gm_amount;
                }
                $pa_grade = $value->pa_grade;

                $adjustg = $value->adjust_grade;
                $current = 0;
                $total_day = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
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
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
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
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
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
                    if($search_month_day != "all"){
                        if($search_month_day == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx = $salary_new*27.5;
                                $salary_month_new = round($salary_month_newx,-1);
                            }else{
                                if($value->grade_code == 'L800'){
                                    $salary_month_new = round($salary_new);
                                }else{
                                    $salary_month_new = round($salary_new)*26;
                                }
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
                
                $date_formatted = '';
                if($value->date_joined){
                    $date_joined_old = $value->date_joined;
                    $date_formatted = date("Y-m-d", strtotime($date_joined_old));
                }

                $approve_review_salary = 'style="display:none;"';
                if (Auth::user()->can('approve review salary')) {
                    $approve_review_salary = 'style="display:block;"';
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

                $data[] = array(
                    "id" =>  $nooo,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?$value->attendance_sl:'0.0'),
                    "pl"=> ($value->attendance_pl>0?$value->attendance_pl:'0.0'),
                    "latet"=> ($value->attendance_abt>0?$value->attendance_abt:'0.0'),
                    "lated"=> ($value->attendance_late>0?$value->attendance_late:'0.0'),
                    "abst"=> ($value->attendance_abt>0?$value->attendance_abt:'0.0'),
                    "absd"=> ($value->attendance_abs>0?$value->attendance_abs:'0.0'),
                    "ol"=> ($value->attendance_ol>0?$value->attendance_ol:'0.0'),
                    "totald"=> ($total_day>0?$total_day:'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?$value->attendance_vwar:'0.0'),
                    "written"=> ($value->attendance_wwar>0?$value->attendance_wwar:'0.0'),
                    "susd"=> ($value->attendance_sus>0?$value->attendance_sus:'0.0'),
                    "pa1"=> ($value->adjust_grade_old1?$value->adjust_grade_old1:'-'),
                    "pa2"=> ($value->adjust_grade_old2?$value->adjust_grade_old2:'-'),
                    "pa3"=> ($value->adjust_grade_old3?$value->adjust_grade_old3:'-'),
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?$value->total_score:'0.00'),
                    "theoryg"=> $pa_grade,
                    "adjustg"=> $adjustg,
                    "current"=> ($current>0?$current:''),
                    
                    "l800avg_gmdm"=> ($l800avg_wage>0?$l800avg_wage:''),
                    "bsalaryw"=> ($bsalary_wage>0?$bsalary_wage:''),
                    "cbsalaryw"=> ($salary_month_old>0?$salary_month_old:''),
                    "comsugpct"=> ($company_suggested_per>0?$company_suggested_per:0.00),
                    "comsugamt"=> ($company_suggestged_amount>0?$company_suggestged_amount:0.00),
                    "companynewb"=> ($company_suggestged_new_basic>0?$company_suggestged_new_basic:0.00),
                    
                    "gmgr_span2"=> ($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')),
                    
                    
                    "incpctmgr_span"=> ($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old,4,'.','')),
                    
                    "incamount"=> ($amount_proposed>0?$amount_proposed:''),
                    "newbwage"=> ($salary_new>0?$salary_new:''),
                    "newbsalary"=> ($salary_month_new>0?$salary_month_new:''),
                    "finaldmgm"=> ($value->status_salary=='1'?($value->final_by_md_gm_amount>0?$value->final_by_md_gm_amount:($salary_month_new>0?$salary_month_new:'')):''),
                    "remark_view"=> $value->remark_grade,
                    
                    
                    
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "grade_code"=> $value->grade_code,
                    "status_salary"=>$status_salary
                ); 
                $nooo++;
            }
        }else{
            $data = [];
        }
        ///////////////////////////////////////////////////////////////
        
        // dd($countdata);
        // exit;
        
        $excel = public_path('upload/orisoft/')."template_Increment_day.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);
        // $spreadsheet2 = $reader->load($excel);
        // $spreadsheet3 = $reader->load($excel);
        // $spreadsheet4 = $reader->load($excel);

        $sheet2 = $spreadsheet->getActiveSheet();
        $sheet2 = $spreadsheet->getSheet(0);
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3 = $spreadsheet->getSheet(2);
        // }
        
        $sheet4 = $spreadsheet->getSheet(1);
        // $sheet2 = $spreadsheet->getActiveSheet(1);
        // $sheet3 = $spreadsheet->getActiveSheet(2);
        
        
        
        // $sheet->setCellValue('A1', '1');
        // $sheet2->setCellValue('A1', '2');
        // $sheet3->setCellValue('A1', '3');
        // $sheet->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        $sheet2->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // }
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
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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

            if($search_section == "all" || $search_section == ""){
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

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
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
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily = $total_Daily->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Daily->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                if($search_department == "all" || $search_department == ""){
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
                if($search_section == "all" || $search_section == ""){
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
        if($search_division){
            $arr_search_division_total_Daily = [];
            $checka_total_Daily = strpos($search_division,',');
            if($checka_total_Daily >= 0){
                $ex_total_Daily = explode(',',$search_division);
                if(count($ex_total_Daily)>0){
                    foreach ($ex_total_Daily as $value) {
                        array_push($arr_search_division_total_Daily,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Daily,$search_division);
            }
            if(count($arr_search_division_total_Daily) > 0){
                $total_Daily->whereIn('tb_employee.division_code', $arr_search_division_total_Daily);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Daily->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Daily->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $total_Daily->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $total_Daily = $total_Daily->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $total_Daily->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
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
        $total_Daily = $total_Daily->first();
        
        if($total_Daily->current_salary_wage){
            if($total_Daily->current_salary_wage > 0){
                $cal = ((($total_Daily->company_suggested_new_basic?$total_Daily->company_suggested_new_basic:0)/($total_Daily->current_salary_wage?$total_Daily->current_salary_wage:0))-1)*100;
                $total_Daily->company_suggested_percent = $cal;
            }
        }else{
            $total_Daily->company_suggested_percent = 0.00;
        }
        // dd($gatall);
        // exit;






































        $gatall_1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.id AS employee_id',
        'tb_employee.orisoft_no',
        'tb_employee.employee_local_name_en',
        'tb_employee.employee_local_name_th',
        'tb_employee.position_code',
        'tb_employee.position_description',
        'tb_employee.division_code',
        'tb_employee.division_description',
        'tb_employee.department_code',
        'tb_employee.department_description',
        'tb_employee.section_code',
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
            $gatall_1->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $gatall_1->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall_1->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checka_1 = strpos($orisoft_all_code->division_code,',');
                $arr_division_code_1 = [];
                if($checka_1 >= 0){
                    $ex_1 = explode(',',$orisoft_all_code->division_code);
                    if(count($ex_1)>0){
                        foreach ($ex_1 as $value) {
                            array_push($arr_division_code_1,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code_1,$orisoft_all_code->division_code);
                }
                $gatall_1 = $gatall_1->whereIn('tb_employee.division_code',$arr_division_code_1);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_code_1 = [];
                $checka_1 = strpos($orisoft_all_code->department_code,',');
                if($checka_1 >= 0){
                    $ex_1 = explode(',',$orisoft_all_code->department_code);
                    if(count($ex_1)>0){
                        foreach ($ex_1 as $value) {
                            array_push($arr_department_code_1,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code_1,$orisoft_all_code->department_code);
                }
                $gatall_1 = $gatall_1->whereIn('tb_employee.department_code',$arr_department_code_1);
            }

            if($search_section == "all" || $search_section == ""){
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
                $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_1 = [];
                $countsection_1 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_1 = $countsection_1->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_1)>0){
                    foreach ($countsection_1 as $value) {
                        array_push($arr_countsection_1,$value->division_code);
                    }
                }
                $gatall_1 = $gatall_1->whereIn('tb_employee.division_code',$arr_countsection_1);
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                    $gatall_1 = $gatall_1->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if($search_department == "all" || $search_department == ""){
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
                        $gatall_1 = $gatall_1->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if($search_section == "all" || $search_section == ""){
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
                    $gatall_1 = $gatall_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $gatall_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division){
            $arr_search_division_gatall_1 = [];
            $checka_gatall_1 = strpos($search_division,',');
            if($checka_gatall_1 >= 0){
                $ex_gatall_1 = explode(',',$search_division);
                if(count($ex_gatall_1)>0){
                    foreach ($ex_gatall_1 as $value) {
                        array_push($arr_search_division_gatall_1,$value);
                    }
                }
            }else{
                array_push($arr_search_division_gatall_1,$search_division);
            }
            if(count($arr_search_division_gatall_1) > 0){
                $gatall_1->whereIn('tb_employee.division_code', $arr_search_division_gatall_1);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall_1->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $gatall_1->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $gatall_1->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $gatall_1->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $gatall_1->where('tb_employee_final_score.salary_type','Daily');
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $gatall_1 = $gatall_1->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $gatall_1->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $gatall_1->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall_1->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $gatall_1->where('tb_employee.position_description','like','%Manager%');
            }else{
                $gatall_1->where('tb_employee.position_description','not like','%Manager%');
            }
        }

        $gatall_1->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
        ->orderBy('tb_employee_final_score.total_score', 'DESC');
        $gatall_1 = $gatall_1->get();
        

        ///////////////////////////////////

        $nooo_1 = 1;
        $finaldmgm_hide_2 = 0;
        if(count($gatall_1)>0){
            foreach ($gatall_1 as $key => $value) {
                $status_salary = '';
                if($value->status_salary == '0'){
                    $status_salary = 'In progress';
                }
                if($value->status_salary == '2'){
                    $status_salary = 'Reject';
                }
                if($value->status_salary == '1'){
                    $status_salary = 'Approved';
                }
                  
                if($value->status_salary == '1'){
                    $finaldmgm_hide_2 += $value->final_by_md_gm_amount;
                }
                $pa_grade_1 = $value->pa_grade;
                $adjustg_1 = $value->adjust_grade;
                $current_1 = 0;
                $total_day_1 = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                $current_1 = $value->salary_old;
                if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                    $l800avg_wage_1 = $value->l800avg_wage;
                }else{
                    $l800avg_wage_1 = '';
                }
                $bsalary_wage_1 = 0;
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_1 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_1 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_1 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_1 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_1 = $current_1;
                        }
                    }
                }
                
                $salary_month_old_1 = $value->salary_month_old;
                if($value->grade_code == 'L800'){
                    $salary_month_old_1 = (float)$bsalary_wage_1*26;
                }
                $company_suggested_per_1 = $value->company_suggested_per;
                $percent_proposed_old_1 = $value->percent_proposed_old;
                $countbudget_1 = DB::table('tb_budget_action')
                            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                            ->where('tb_budget.year',$previousYear)->count();
                if($countbudget_1 > 0){
                    if($value->adjust_grade){
                        $databudget_1 = DB::table('tb_budget_action')
                        ->select('tb_budget_action.std')
                        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        ->where('tb_budget_action.grade_name',$value->adjust_grade)
                        ->where('tb_budget.year',$previousYear)->first();
                        $company_suggested_per_1 = $databudget_1->std;
                        $percent_proposed_old_1 = $databudget_1->std;
                    }
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1_1 = $value->service_days/365;
                }else{
                    $service_days1_1 = $value->service_days/365;
                }
                $service_days2_1 = $service_days1_1;
                
                $company_suggestged_amount_1 = $bsalary_wage_1*($company_suggested_per_1/100)*$service_days2_1;
                $company_suggestged_new_basic_1 = $value->company_suggestged_new_basic;
                if($value->grade_code == 'L800'){
                    $company_suggestged_new_basic_1 = round($company_suggestged_amount_1+$current_1);
                }else{
                    $company_suggestged_new_basic_1 = round($company_suggestged_amount_1+$bsalary_wage_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                }
                $value->company_suggestged_new_basic = $company_suggestged_new_basic_1;
                $amount_proposed_1 = $value->amount_proposed;
                if($bsalary_wage_1 > 0){
                    if($value->percent_proposed >= 0){
                        $amount_proposed_1 = $bsalary_wage_1*($value->percent_proposed/100)*$service_days2_1;
                    }else{
                        $amount_proposed_1 = $bsalary_wage_1*($percent_proposed_old_1/100)*$service_days2_1;
                    }
                }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $salary_new_1 = round($amount_proposed_1+$current_1);
                    }else{
                        $salary_new_1 = round($amount_proposed_1+$current_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $salary_new_1 = round($amount_proposed_1+$current_1);
                    }else{
                        $salary_new_1 = round($amount_proposed_1+$current_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }
                
                $salary_month_new_1 = ($value->salary_month_new?$value->salary_month_new:0);
                if($salary_new_1 > 0){
                    if($search_month_day != "all"){
                        if($search_month_day == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_1 = $salary_new_1*27.5;
                                $salary_month_new_1 = round($salary_month_newx_1,-1);
                            }else{
                                if($value->grade_code == 'L800'){
                                    $salary_month_new_1 = round($salary_new_1)*26;
                                }else{
                                    $salary_month_new_1 = round($salary_new_1);
                                }
                            }
                        }else{
                            $salary_month_new_1 = round($salary_new_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }else{
                        if($value->grade_code == 'L800'){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_1 = $salary_new_1*27.5;
                                $salary_month_new_1 = round($salary_month_newx_1,-1);
                            }else{
                                $salary_month_new_1 = round($salary_new_1)*26;
                            }
                        }else{
                            $salary_month_new_1 = round($salary_new_1,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }
                }
                
                $date_formatted_1 = '';
                if($value->date_joined){
                    $date_joined_old_1 = $value->date_joined;
                    $date_formatted_1 = date("Y-m-d", strtotime($date_joined_old_1));
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }else{
                    $service_days1 = $value->service_days/365;
                }
                
                $service_days2_1 = $service_days1;

                $data_1[] = array(
                    "id" =>  $nooo_1,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted_1,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> ($value->attendance_ol>0?number_format($value->attendance_ol,1):'0.0'),
                    "totald"=> ($total_day_1>0?number_format($total_day_1,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa1"=> ($value->adjust_grade_old1?$value->adjust_grade_old1:'-'),
                    "pa2"=> ($value->adjust_grade_old2?$value->adjust_grade_old2:'-'),
                    "pa3"=> ($value->adjust_grade_old3?$value->adjust_grade_old3:'-'),
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade_1,
                    "adjustg"=> $adjustg_1,
                    "current"=> ($current_1>0?number_format($current_1,2):''),
                    
                    "l800avg_gmdm"=> ($l800avg_wage_1>0?number_format($l800avg_wage_1,2):''),
                    "bsalaryw"=> ($bsalary_wage_1>0?number_format($bsalary_wage_1,2):''),
                    "cbsalaryw"=> ($salary_month_old_1>0?number_format($salary_month_old_1,2):''),
                    "comsugpct"=> ($company_suggested_per_1>0?number_format($company_suggested_per_1,2):0.00),
                    "comsugamt"=> ($company_suggestged_amount_1>0?number_format($company_suggestged_amount_1,2):0.00),
                    "companynewb"=> ($company_suggestged_new_basic_1>0?number_format($company_suggestged_new_basic_1,2):0.00),
                    
                    "gmgr_span2"=> ($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')),
                    
                    
                    "incpctmgr_span"=> ($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old_1,4,'.','')),
                    
                    "incamount"=> ($amount_proposed_1>0?number_format($amount_proposed_1,2):''),
                    "newbwage"=> ($salary_new_1>0?number_format($salary_new_1,2):''),
                    "newbsalary"=> ($salary_month_new_1>0?number_format($salary_month_new_1,2):''),
                    "finaldmgm"=> ($value->status_salary=='1'?($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')):''),
                    "remark_view"=> $value->remark_grade,
                    
                    
                    
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "grade_code"=> $value->grade_code,
                    "status_salary"=>$status_salary
                ); 
                $nooo_1++;
            }
        }else{
            $data_1 = [];
        }
        $countdata_1 = DB::table('tb_employee_final_score')
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
            $countdata_1->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $countdata_1->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $countdata_1->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checkacountdata_1 = strpos($orisoft_all_code->division_code,',');
                $arr_division_codecountdata_1 = [];
                if($checkacountdata_1 >= 0){
                    $excountdata_1 = explode(',',$orisoft_all_code->division_code);
                    if(count($excountdata_1)>0){
                        foreach ($excountdata_1 as $value) {
                            array_push($arr_division_codecountdata_1,$value);
                        }
                    }
                }else{
                    array_push($arr_division_codecountdata_1,$orisoft_all_code->division_code);
                }
                $countdata_1 = $countdata_1->whereIn('tb_employee.division_code',$arr_division_codecountdata_1);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_codecountdata_1 = [];
                $checkacountdata_1 = strpos($orisoft_all_code->department_code,',');
                if($checkacountdata_1 >= 0){
                    $excountdata_1 = explode(',',$orisoft_all_code->department_code);
                    if(count($excountdata_1)>0){
                        foreach ($excountdata_1 as $value) {
                            array_push($arr_department_codecountdata_1,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codecountdata_1,$orisoft_all_code->department_code);
                }
                $countdata_1 = $countdata_1->whereIn('tb_employee.department_code',$arr_department_codecountdata_1);
            }

            if($search_section == "all" || $search_section == ""){
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
                $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_1 = [];
                $countsection_1 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_1 = $countsection_1->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_1)>0){
                    foreach ($countsection_1 as $value) {
                        array_push($arr_countsection_1,$value->division_code);
                    }
                }
                $countdata_1 = $countdata_1->whereIn('tb_employee.division_code',$arr_countsection_1);
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                    $countdata_1 = $countdata_1->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if($search_department == "all" || $search_department == ""){
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
                        $countdata_1 = $countdata_1->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if($search_section == "all" || $search_section == ""){
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
                    $countdata_1 = $countdata_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $countdata_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_countdata_1 = [];
            $checka_countdata_1 = strpos($search_division,',');
            if($checka_countdata_1 >= 0){
                $ex_countdata_1 = explode(',',$search_division);
                if(count($ex_countdata_1)>0){
                    foreach ($ex_countdata_1 as $value) {
                        array_push($arr_search_division_countdata_1,$value);
                    }
                }
            }else{
                array_push($arr_search_division_countdata_1,$search_division);
            }
            if(count($arr_search_division_countdata_1) > 0){
                $countdata_1->whereIn('tb_employee.division_code', $arr_search_division_countdata_1);
            }
        }
        // if($search_division != "all"){
        //     $countdata_1->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $countdata_1->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $countdata_1->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $countdata_1->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $countdata_1->where('tb_employee_final_score.salary_type','Daily');
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $gatall_1 = $gatall_1->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $gatall_1->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $countdata_1->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata_1->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $countdata_1->where('tb_employee.position_description','like','%Manager%');
            }else{
                $countdata_1->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        $countdata_1 = $countdata_1->get();
        // dd($countdata_1);
        // exit;
        $countA_1 = 0;
        $countB_1 = 0;
        $countC_1 = 0;
        $countD_1 = 0;
        $countE_1 = 0;
        $countNoNull_1 = 0;

        $proposed_countAR_1 = 0;
        $proposed_countP_1 = 0;
        $proposed_countA_1 = 0;
        $proposed_countB_1 = 0;
        $proposed_countC_1 = 0;
        $proposed_countD_1 = 0;
        $proposed_countE_1 = 0;
        $proposed_countU_1 = 0;
        $proposed_countCD_1 = 0;
        $proposed_countNoNull_1 = 0;
        

        // dd($countdata_1);
        // exit;

        
        
        if(count($countdata_1)>0){
            foreach ($countdata_1 as $key => $value) {
                if($value->adjust_grade == 'A'){
                    $countA_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'B'){
                    $countB_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'C'){
                    $countC_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'D'){
                    $countD_1++;
                    $countNoNull_1++;
                }
                if($value->adjust_grade == 'E'){
                    $countE_1++;
                    $countNoNull_1++;
                }
    
                ///////////
    
                if($value->grade_proposed == 'AR'){
                    $proposed_countAR_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'P'){
                    $proposed_countP_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'A'){
                    $proposed_countA_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'B'){
                    $proposed_countB_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'C'){
                    $proposed_countC_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'D'){
                    $proposed_countD_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'E'){
                    $proposed_countE_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'U'){
                    $proposed_countU_1++;
                    $proposed_countNoNull_1++;
                }
                if($value->grade_proposed == 'CD'){
                    $proposed_countCD_1++;
                    $proposed_countNoNull_1++;
                }
            }
        }
        
        $sheet2->setCellValue('AI2', $countNoNull_1);
        $sheet2->setCellValue('AI4', $countA_1);
        $sheet2->setCellValue('AI5', $countB_1);
        $sheet2->setCellValue('AI6', $countC_1);
        $sheet2->setCellValue('AI7', $countD_1);
        $sheet2->setCellValue('AI8', $countE_1);
        
        $sumA_1 = 0;
        $sumB_1 = 0;
        $sumC_1 = 0;
        $sumD_1 = 0;
        $sumE_1 = 0;
        $bell_curve_1 = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        foreach ($bell_curve_1 as $key1 => $value1) {
            $percent_1 = $value1->percent/100;
            if($value1->grade_name == "A"){
                $sumA_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH4', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "B"){
                $sumB_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH5', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "C"){
                $sumC_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH6', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "D"){
                $sumD_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH7', ($percent_1?$percent_1:0));
            }
            if($value1->grade_name == "E"){
                $sumE_1 = ($countNoNull_1*$value1->percent)/100;
                $sheet2->setCellValue('AH8', ($percent_1?$percent_1:0));
            }
        }
        $sumAll_1 = $sumA_1+$sumB_1+$sumC_1+$sumD_1+$sumE_1;
        $sheet2->setCellValue('AH2', $sumAll_1);
        // dd($sumA);
        // exit;
        $sheet2->setCellValue('AI2', $sumAll_1);
        $sheet2->setCellValue('AI4', $sumA_1);
        $sheet2->setCellValue('AI5', $sumB_1);
        $sheet2->setCellValue('AI6', $sumC_1);
        $sheet2->setCellValue('AI7', $sumD_1);
        $sheet2->setCellValue('AI8', $sumE_1);
        ////////
        
        $proposed_sumAR_1 = ($proposed_countAR_1>0?($proposed_countAR_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumP_1 = ($proposed_countP_1>0?($proposed_countP_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumA_1 = ($proposed_countA_1>0?($proposed_countA_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumB_1 = ($proposed_countB_1>0?($proposed_countB_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumC_1 = ($proposed_countC_1>0?($proposed_countC_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumD_1 = ($proposed_countD_1>0?($proposed_countD_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumE_1 = ($proposed_countE_1>0?($proposed_countE_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumU_1 = ($proposed_countU_1>0?($proposed_countU_1/$proposed_countNoNull_1)*100:0);
        $proposed_sumCD_1 = ($proposed_countCD_1>0?($proposed_countCD_1/$proposed_countNoNull_1)*100:0);

        $sheet2->setCellValue('AQ2', $proposed_countAR_1);
        $sheet2->setCellValue('AQ3', $proposed_countP_1);
        $sheet2->setCellValue('AQ4', $proposed_countA_1);
        $sheet2->setCellValue('AQ5', $proposed_countB_1);
        $sheet2->setCellValue('AQ6', $proposed_countC_1);
        $sheet2->setCellValue('AQ7', $proposed_countD_1);
        $sheet2->setCellValue('AQ8', $proposed_countE_1);
        $sheet2->setCellValue('AQ9', $proposed_countU_1);
        $sheet2->setCellValue('AQ10', $proposed_countCD_1);
        $sheet2->setCellValue('AQ1', $proposed_countNoNull_1);

        $sheet2->setCellValue('AR2', ($proposed_sumAR_1?number_format($proposed_sumAR_1/100,2):0));
        $sheet2->setCellValue('AR3', ($proposed_sumP_1?number_format($proposed_sumP_1/100,2):0));
        $sheet2->setCellValue('AR4', ($proposed_sumA_1?number_format($proposed_sumA_1/100,2):0));
        $sheet2->setCellValue('AR5', ($proposed_sumB_1?number_format($proposed_sumB_1/100,2):0));
        $sheet2->setCellValue('AR6', ($proposed_sumC_1?number_format($proposed_sumC_1/100,2):0));
        $sheet2->setCellValue('AR7', ($proposed_sumD_1?number_format($proposed_sumD_1/100,2):0));
        $sheet2->setCellValue('AR8', ($proposed_sumE_1?number_format($proposed_sumE_1/100,2):0));
        $sheet2->setCellValue('AR9', ($proposed_sumU_1?number_format($proposed_sumU_1/100,2):0));
        $sheet2->setCellValue('AR10', ($proposed_sumCD_1?number_format($proposed_sumCD_1/100,2):0));


        $budget_1 = DB::table('tb_budget_action')
        ->select('tb_budget_action.*')
        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
        ->where('tb_budget.year',$previousYear)
        ->orderBy('tb_budget_action.id', 'ASC')->get();
        if(count($budget_1)>0){
            foreach ($budget_1 as $key => $value1) {
                if($value1->grade_name == "AR"){
                    $sheet2->setCellValue('AL2', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM2', $value1->grade_name);
                    $sheet2->setCellValue('AN2', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "P"){
                    $sheet2->setCellValue('AL3', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM3', $value1->grade_name);
                    $sheet2->setCellValue('AN3', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "A"){
                    $sheet2->setCellValue('AL4', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM4', $value1->grade_name);
                    $sheet2->setCellValue('AN4', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "B"){
                    $sheet2->setCellValue('AL5', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM5', $value1->grade_name);
                    $sheet2->setCellValue('AN5', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "C"){
                    $sheet2->setCellValue('AL6', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM6', $value1->grade_name);
                    $sheet2->setCellValue('AN6', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "D"){
                    $sheet2->setCellValue('AL7', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM7', $value1->grade_name);
                    $sheet2->setCellValue('AN7', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "E"){
                    $sheet2->setCellValue('AL8', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM8', $value1->grade_name);
                    $sheet2->setCellValue('AN8', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "U"){
                    $sheet2->setCellValue('AL9', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM9', $value1->grade_name);
                    $sheet2->setCellValue('AN9', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "CD"){
                    $sheet2->setCellValue('AL10', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet2->setCellValue('AM10', $value1->grade_name);
                    $sheet2->setCellValue('AN10', ($value1->std?number_format($value1->std/100,2):0));
                }
            }
        }

        if($search_section != "all" && $search_section != ""){
            $percent_department_1 = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->where('tb_percent_department_action.section_code', 'like','%'.$search_section.'%')
            ->orderBy('tb_percent_department_action.id', 'ASC')->first();
            $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));

            $sheet2->setCellValue('AU2', ($percent_department_1->percent_daily?($percent_department_1->percent_daily/100):0));
        }else{
            if($search_department != "all" && $search_department != ""){
                $percent_department_1 = DB::table('tb_percent_department_action')
                ->select( 
                    DB::raw('SUM(percent_daily) AS percent_daily'),
                    DB::raw('SUM(percent_monthly) AS percent_monthly')
                )  
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year',$previousYear)
                ->where('tb_percent_department_action.department_code', 'like','%'.$search_department.'%')
                ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));
    
                $sheet2->setCellValue('AU2', ($percent_department_1->percent_daily?($percent_department_1->percent_daily/100):0));
            }else{
                if($search_division != "all" && $search_division != ""){
                    if($search_division){
                        $arr_search_division_countdata_1 = [];
                        $checka_countdata_1 = strpos($search_division,',');
                        if($checka_countdata_1 >= 0){
                            $ex_countdata_1 = explode(',',$search_division);
                            if(count($ex_countdata_1)>0){
                                foreach ($ex_countdata_1 as $value) {
                                    array_push($arr_search_division_countdata_1,$value);
                                }
                            }
                        }else{
                            array_push($arr_search_division_countdata_1,$search_division);
                        }
                    }
                    $percent_department_1 = DB::table('tb_percent_department_action')
                    ->select( 
                        DB::raw('SUM(percent_daily) AS percent_daily'),
                        DB::raw('SUM(percent_monthly) AS percent_monthly')
                    )  
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year',$previousYear)
                    ->whereIn('tb_percent_department_action.division_code', $arr_search_division_countdata_1)
                    ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                    $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));
        
                    $sheet2->setCellValue('AU2', ($percent_department_1->percent_daily?($percent_department_1->percent_daily/100):0));
                }else{
                    $sheet2->setCellValue('AV2', 'Approved Budget '.date('Y'));
                }
            }
        }
        
        $total_Daily_1 = DB::table('tb_employee_final_score')
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
                $total_Daily_1->where('tb_employee_final_score.freeze_to_approve_hr', '1');
            }else{
                if($pagenow == "2"){
                    $total_Daily_1->where('tb_employee_final_score.freeze_to_gmdm', '1');
                }else{
                    $total_Daily_1->where('tb_employee_final_score.freeze_to_pagrade', '1');
                }
            }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checkatotal_Daily_1 = strpos($orisoft_all_code->division_code,',');
                $arr_division_codetotal_Daily_1 = [];
                if($checkatotal_Daily_1 >= 0){
                    $extotal_Daily_1 = explode(',',$orisoft_all_code->division_code);
                    if(count($extotal_Daily_1)>0){
                        foreach ($extotal_Daily_1 as $value) {
                            array_push($arr_division_codetotal_Daily_1,$value);
                        }
                    }
                }else{
                    array_push($arr_division_codetotal_Daily_1,$orisoft_all_code->division_code);
                }
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.division_code',$arr_division_codetotal_Daily_1);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_codetotal_Daily_1 = [];
                $checkatotal_Daily_1 = strpos($orisoft_all_code->department_code,',');
                if($checkatotal_Daily_1 >= 0){
                    $extotal_Daily_1 = explode(',',$orisoft_all_code->department_code);
                    if(count($extotal_Daily_1)>0){
                        foreach ($extotal_Daily_1 as $value) {
                            array_push($arr_department_codetotal_Daily_1,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codetotal_Daily_1,$orisoft_all_code->department_code);
                }
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.department_code',$arr_department_codetotal_Daily_1);
            }

            if($search_section == "all" || $search_section == ""){
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
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_1 = [];
                $countsection_1 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_1 = $countsection_1->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_1)>0){
                    foreach ($countsection_1 as $value) {
                        array_push($arr_countsection_1,$value->division_code);
                    }
                }
                $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.division_code',$arr_countsection_1);
            }
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.division_code',$arr_division_code);
                    
                }
                if($search_department == "all" || $search_department == ""){
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
                        $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.department_code',$arr_department_code);
                    
                }
                if($search_section == "all" || $search_section == ""){
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
                    $total_Daily_1 = $total_Daily_1->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Daily_1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_total_Daily_1 = [];
            $checka_total_Daily_1 = strpos($search_division,',');
            if($checka_total_Daily_1 >= 0){
                $ex_total_Daily_1 = explode(',',$search_division);
                if(count($ex_total_Daily_1)>0){
                    foreach ($ex_total_Daily_1 as $value) {
                        array_push($arr_search_division_total_Daily_1,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Daily_1,$search_division);
            }
            if(count($arr_search_division_total_Daily_1) > 0){
                $total_Daily_1->whereIn('tb_employee.division_code', $arr_search_division_total_Daily_1);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily_1->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Daily_1->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Daily_1->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $total_Daily_1->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $total_Daily_1 = $total_Daily_1->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $total_Daily_1->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $total_Daily_1->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Daily_1->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $total_Daily_1->where('tb_employee.position_description','like','%Manager%');
            }else{
                $total_Daily_1->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        $total_Daily_1 = $total_Daily_1->first();
        
        if($total_Daily_1->current_salary_wage){
            if($total_Daily_1->current_salary_wage > 0){
                $cal_1 = ((($total_Daily_1->company_suggested_new_basic?$total_Daily_1->company_suggested_new_basic:0)/($total_Daily_1->current_salary_wage?$total_Daily_1->current_salary_wage:0))-1)*100;
                $total_Daily_1->company_suggested_percent = $cal_1;
            }
        }else{
            $total_Daily_1->company_suggested_percent = 0.00;
        }
        

        
        
        if($total_Daily->new_basic_wage_proposed > 0){
            $cal_daily_1 = ((($total_Daily->new_basic_wage_proposed/$total_Daily->current_salary_wage-1)*100)* 1000)/ 1000;
        }else{
            $cal_daily_1 = 0;
        }
        $cal_all_1 = $cal_daily_1;
        // dd($cal_month_1);
        // exit;
        $sheet2->setCellValue('AU1', ($cal_daily_1?$cal_daily_1/100:0));



        $numrow_1 = 13;
        $final_score = [];
        if(count($data_1)>0){
            foreach ($data_1 as $key => $value) {
                
                $date1_1 = $value['joindate'];
                $date2_1 = date('Y')."-01-31";

                $diff_1 = abs(strtotime($date2_1) - strtotime($date1_1));

                $years_1 = floor($diff_1 / (365*60*60*24));
                $months_1 = floor(($diff_1 - $years_1 * 365*60*60*24) / (30*60*60*24));
                $days_1 = floor(($diff_1 - $years_1 * 365*60*60*24 - $months_1*30*60*60*24)/ (60*60*24));

                // printf("%d years, %d months, %d days\n", $years, $months, $days);
                // exit;
                if($value['pa1'] == "AR"){
                    $bg_color_pa1_1 = 'FFFFFF';
                }else if($value['pa1'] == "P"){
                    $bg_color_pa1_1 = 'FFFFFF';
                }else if($value['pa1'] == "A"){
                    $bg_color_pa1_1 = '9FCE63';
                }else if($value['pa1'] == "B"){
                    $bg_color_pa1_1 = 'BFDDE7';
                }else if($value['pa1'] == "C"){
                    $bg_color_pa1_1 = 'DAE4C0';
                }else if($value['pa1'] == "D"){
                    $bg_color_pa1_1 = 'FFFFD1';
                }else if($value['pa1'] == "E"){
                    $bg_color_pa1_1 = 'DFBAB8';
                }else if($value['pa1'] == "U"){
                    $bg_color_pa1_1 = 'FFFFFF';
                }else{
                    $bg_color_pa1_1 = 'FFFFFF';
                }
                if($value['pa2'] == "AR"){
                    $bg_color_pa2_1 = 'FFFFFF';
                }else if($value['pa2'] == "P"){
                    $bg_color_pa2_1 = 'FFFFFF';
                }else if($value['pa2'] == "A"){
                    $bg_color_pa2_1 = '9FCE63';
                }else if($value['pa2'] == "B"){
                    $bg_color_pa2_1 = 'BFDDE7';
                }else if($value['pa2'] == "C"){
                    $bg_color_pa2_1 = 'DAE4C0';
                }else if($value['pa2'] == "D"){
                    $bg_color_pa2_1 = 'FFFFD1';
                }else if($value['pa2'] == "E"){
                    $bg_color_pa2_1 = 'DFBAB8';
                }else if($value['pa2'] == "U"){
                    $bg_color_pa2_1 = 'FFFFFF';
                }else{
                    $bg_color_pa2_1 = 'FFFFFF';
                }

                if($value['pa3'] == "AR"){
                    $bg_color_pa3_1 = 'FFFFFF';
                }else if($value['pa3'] == "P"){
                    $bg_color_pa3_1 = 'FFFFFF';
                }else if($value['pa3'] == "A"){
                    $bg_color_pa3_1 = '9FCE63';
                }else if($value['pa3'] == "B"){
                    $bg_color_pa3_1 = 'BFDDE7';
                }else if($value['pa3'] == "C"){
                    $bg_color_pa3_1 = 'DAE4C0';
                }else if($value['pa3'] == "D"){
                    $bg_color_pa3_1 = 'FFFFD1';
                }else if($value['pa3'] == "E"){
                    $bg_color_pa3_1 = 'DFBAB8';
                }else if($value['pa3'] == "U"){
                    $bg_color_pa3_1 = 'FFFFFF';
                }else{
                    $bg_color_pa3_1 = 'FFFFFF';
                }
                if($value['theoryg'] == "AR"){
                    $bg_color_theoryg_1 = 'FFFFFF';
                }else if($value['theoryg'] == "P"){
                    $bg_color_theoryg_1 = 'FFFFFF';
                }else if($value['theoryg'] == "A"){
                    $bg_color_theoryg_1 = '9FCE63';
                }else if($value['theoryg'] == "B"){
                    $bg_color_theoryg_1 = 'BFDDE7';
                }else if($value['theoryg'] == "C"){
                    $bg_color_theoryg_1 = 'DAE4C0';
                }else if($value['theoryg'] == "D"){
                    $bg_color_theoryg_1 = 'FFFFD1';
                }else if($value['theoryg'] == "E"){
                    $bg_color_theoryg_1 = 'DFBAB8';
                }else if($value['theoryg'] == "U"){
                    $bg_color_theoryg_1 = 'FFFFFF';
                }else{
                    $bg_color_theoryg_1 = 'FFFFFF';
                }
                if($value['adjustg'] == "AR"){
                    $bg_color_adjustg_1 = 'FFFFFF';
                }else if($value['adjustg'] == "P"){
                    $bg_color_adjustg_1 = 'FFFFFF';
                }else if($value['adjustg'] == "A"){
                    $bg_color_adjustg_1 = '9FCE63';
                }else if($value['adjustg'] == "B"){
                    $bg_color_adjustg_1 = 'BFDDE7';
                }else if($value['adjustg'] == "C"){
                    $bg_color_adjustg_1 = 'DAE4C0';
                }else if($value['adjustg'] == "D"){
                    $bg_color_adjustg_1 = 'FFFFD1';
                }else if($value['adjustg'] == "E"){
                    $bg_color_adjustg_1 = 'DFBAB8';
                }else if($value['adjustg'] == "U"){
                    $bg_color_adjustg_1 = 'FFFFFF';
                }else{
                    $bg_color_adjustg_1 = 'FFFFFF';
                }
                if($value['gmgr_span2'] == "AR"){
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "P"){
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "A"){
                    $bg_color_gmgr_span2_1 = '9FCE63';
                }else if($value['gmgr_span2'] == "B"){
                    $bg_color_gmgr_span2_1 = 'BFDDE7';
                }else if($value['gmgr_span2'] == "C"){
                    $bg_color_gmgr_span2_1 = 'DAE4C0';
                }else if($value['gmgr_span2'] == "D"){
                    $bg_color_gmgr_span2_1 = 'FFFFD1';
                }else if($value['gmgr_span2'] == "E"){
                    $bg_color_gmgr_span2_1 = 'DFBAB8';
                }else if($value['gmgr_span2'] == "U"){
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }else{
                    $bg_color_gmgr_span2_1 = 'FFFFFF';
                }

                $bg_color_status_salary_1 = 'f1f1f2';
                if($value['status_salary'] == 'In progress'){
                    $bg_color_status_salary_1 = 'f1f1f2';
                }
                if($value['status_salary'] == 'Reject'){
                    $bg_color_status_salary_1 = 'fff5f8';
                }
                if($value['status_salary'] == 'Approved'){
                    $bg_color_status_salary_1 = 'e8fff3';
                }
                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('A'.$numrow_1.':AX'.$numrow_1)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('000000'));
                $sheet2->setCellValue('A'.$numrow_1, $value['division_code']);
                $sheet2->setCellValue('B'.$numrow_1, $value['department_code']);
                $sheet2->setCellValue('C'.$numrow_1, $value['section_code']);
                $sheet2->setCellValue('D'.$numrow_1, ($value['grade_code']=='L800'?'Daily':'Monthly'));
                $sheet2->setCellValue('E'.$numrow_1, $value['grade_code']);
                $sheet2->setCellValue('F'.$numrow_1, $value['id']);
                $sheet2->setCellValue('G'.$numrow_1, $value['code']);
                $sheet2->setCellValue('H'.$numrow_1, $value['name']);
                $sheet2->setCellValue('I'.$numrow_1, $value['position']);
                $sheet2->setCellValue('J'.$numrow_1, $value['group']);
                $sheet2->setCellValue('K'.$numrow_1, $value['joindate']);

                $sheet2->setCellValue('L'.$numrow_1, $years_1);
                $sheet2->setCellValue('M'.$numrow_1, $months_1);
                $sheet2->setCellValue('N'.$numrow_1, $days_1);
                
                $sheet2->setCellValue('O'.$numrow_1, $value['serviced']);
                

                $sheet2->setCellValue('P'.$numrow_1, $value['sl']);
                $sheet2->setCellValue('Q'.$numrow_1, $value['pl']);
                $sheet2->setCellValue('R'.$numrow_1, $value['latet']);
                $sheet2->setCellValue('S'.$numrow_1, $value['lated']);
                $sheet2->setCellValue('T'.$numrow_1, $value['abst']);
                $sheet2->setCellValue('U'.$numrow_1, $value['absd']);
                $sheet2->setCellValue('V'.$numrow_1, $value['ol']);
                $sheet2->setCellValue('W'.$numrow_1, $value['totald']);
                $sheet2->setCellValue('X'.$numrow_1, $value['verbal']);
                $sheet2->setCellValue('Y'.$numrow_1, $value['written']);
                $sheet2->setCellValue('Z'.$numrow_1, $value['susd']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AA'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa1_1);
                $sheet2->setCellValue('AA'.$numrow_1, $value['pa1']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AB'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa2_1);
                $sheet2->setCellValue('AB'.$numrow_1, $value['pa2']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AC'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa3_1);
                $sheet2->setCellValue('AC'.$numrow_1, $value['pa3']);
                $sheet2->setCellValue('AD'.$numrow_1, $value['form']);
                $sheet2->setCellValue('AE'.$numrow_1, $value['evaluator']);
                $sheet2->setCellValue('AF'.$numrow_1, $value['total']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AG'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_theoryg_1);
                $sheet2->setCellValue('AG'.$numrow_1, $value['theoryg']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AH'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_adjustg_1);
                $sheet2->setCellValue('AH'.$numrow_1, $value['adjustg']);
                $sheet2->setCellValue('AI'.$numrow_1, $value['current']);
                $sheet2->setCellValue('AJ'.$numrow_1, $value['l800avg_gmdm']);
                $sheet2->setCellValue('AK'.$numrow_1, $value['bsalaryw']);
                $sheet2->setCellValue('AL'.$numrow_1, $value['cbsalaryw']);
                $sheet2->setCellValue('AM'.$numrow_1, $value['comsugpct']);
                $sheet2->setCellValue('AN'.$numrow_1, $value['comsugamt']);
                $sheet2->setCellValue('AO'.$numrow_1, $value['companynewb']);

                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AP'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_gmgr_span2_1);
                $sheet2->setCellValue('AP'.$numrow_1, $value['gmgr_span2']);
                $sheet2->setCellValue('AQ'.$numrow_1, $value['incpctmgr_span']);
                $sheet2->setCellValue('AR'.$numrow_1, $value['incamount']);
                $sheet2->setCellValue('AS'.$numrow_1, $value['newbwage']);
                $sheet2->setCellValue('AT'.$numrow_1, $value['newbsalary']);
                $sheet2->setCellValue('AU'.$numrow_1, $value['finaldmgm']);
                $sheet2->setCellValue('AV'.$numrow_1, $value['remark_view']);

                $spreadsheet
                ->getSheet(0)
                ->getStyle('AX'.$numrow_1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_status_salary_1);
                $sheet2->setCellValue('AX'.$numrow_1, $value['status_salary']);
                $numrow_1++;
            }
        }













































































        function month($datadate){
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            // $array = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
            return date("d",strtotime($datadate)).'-'.$array[date('n',strtotime($datadate))].'-'.(date("Y",strtotime($datadate)));

        }
        function month_between($datadate){
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            // $array = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
            return $array[date('n',strtotime($datadate))].' '.(date("Y",strtotime($datadate)));

        }
        function DateDiff($strDate1,$strDate2){
            return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
        }
        $sheet4->setCellValue('A1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        $numsheet4 = 3;
        $nosheet4 = 1;
        $bell_curve_2 = DB::table('tb_pa_timeline_action')
        ->select('tb_pa_timeline_action.*')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$previousYear)
        ->orderBy('tb_pa_timeline_action.id', 'ASC')->get();
        foreach ($bell_curve_2 as $key1 => $value1) {
            if($value1->start_date){
                if($value1->start_date == $value1->end_date){
                    $value1->start_date = month($value1->start_date);
                }else{
                    $cal = DateDiff($value1->start_date,$value1->end_date)+1;
                    $cut1 = explode('-',$value1->start_date);
                    $cut2 = explode('-',$value1->end_date);
                    $newdata = $cut1[2].' - '.$cut2[2].' ';
                    $value1->start_date = $newdata.month_between($value1->end_date);
                }
            }
            if($value1->start_date_real){
                if($value1->start_date_real == $value1->end_date_real){
                    $value1->start_date_real = month($value1->start_date_real);
                }else{
                    $cal = DateDiff($value1->start_date_real,$value1->end_date_real)+1;
                    $cut1 = explode('-',$value1->start_date_real);
                    $cut2 = explode('-',$value1->end_date_real);
                    $newdata = $cut1[2].' - '.$cut2[2].' ';
                    $value1->start_date_real = $newdata.month_between($value1->end_date_real);
                }
            }
            $person = '';
            if($value1->hr == 'active'){
                $person .= 'HR / ';
            }
            if($value1->manager == 'active'){
                if($value1->manager_select == '019492'){
                    $person .= 'Pimnada / ';
                }else{
                    $person .= 'Managers / ';
                }
            }
            if($value1->dm == 'active'){
                $person .= 'DM / ';
            }
            if($value1->gm == 'active'){
                $person .= 'GM / ';
            }
            $person = substr($person,0,-3);
            $sheet4->setCellValue('A'.$numsheet4, $nosheet4.'.'.$value1->action_name);
            $sheet4->setCellValue('B'.$numsheet4, $value1->start_date);
            $sheet4->setCellValue('C'.$numsheet4, $value1->start_date_real);
            $sheet4->setCellValue('D'.$numsheet4, $person);
            $sheet4->setCellValue('E'.$numsheet4, ($value1->hr == 'active'?'/':''));
            $sheet4->setCellValue('F'.$numsheet4, ($value1->manager == 'active'?'/':''));
            $sheet4->setCellValue('G'.$numsheet4, ($value1->dm == 'active'?'/':''));
            $sheet4->setCellValue('H'.$numsheet4, ($value1->gm == 'active'?'/':''));
            $numsheet4++;
            $nosheet4++;
        }



















































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

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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

            if($search_section == "all" || $search_section == ""){
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
        
        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
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
        }

        if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                if($search_division == "all" || $search_division == ""){
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
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }else{
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection = [];
                    $countsection = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.section_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000026');
                    $countsection = $countsection->groupBy('section_code')->orderBy('section_code', 'ASC')->get();
                    if(count($countsection)>0){
                        foreach ($countsection as $value) {
                            array_push($arr_countsection,$value->section_code);
                        }
                    }
                    $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Daily_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Daily_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                if($search_division == "all" || $search_division == ""){
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
                if($search_department == "all" || $search_department == ""){
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
                if($search_section == "all" || $search_section == ""){
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
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_total_Daily_filter = [];
            $checka_total_Daily_filter = strpos($search_division,',');
            if($checka_total_Daily_filter >= 0){
                $ex_total_Daily_filter = explode(',',$search_division);
                if(count($ex_total_Daily_filter)>0){
                    foreach ($ex_total_Daily_filter as $value) {
                        array_push($arr_search_division_total_Daily_filter,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Daily_filter,$search_division);
            }
            if(count($arr_search_division_total_Daily_filter) > 0){
                $total_Daily_filter->whereIn('tb_employee.division_code', $arr_search_division_total_Daily_filter);
            }
        }
        // if($search_division != "all"){
        //     $total_Daily_filter->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Daily_filter->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Daily_filter->where('tb_employee.section_code', 'like','%'.$search_section.'%');
        }
        if($search_employee_no != "all" && $search_employee_no != ""){
            $arr_search_employee_no = [];
            $checka = strpos($search_employee_no,',');
            if($checka >= 0){
                $ex = explode(',',$search_employee_no);
                if(count($ex)>0){
                    foreach ($ex as $value) {
                        array_push($arr_search_employee_no,$value);
                    }
                }
            }else{
                array_push($arr_search_employee_no,$search_employee_no);
            }
            if(count($arr_search_employee_no) > 0){
                $total_Daily_filter->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $total_Daily_filter->where('tb_employee_final_score.salary_type','Daily');
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $total_Daily_filter = $total_Daily_filter->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $total_Daily_filter->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
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
        $total_Daily_filter = $total_Daily_filter->first();
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
                if($total_Daily_filter->final_by_md_gm_amount > 0){
                    $cal2 = ((($total_Daily_filter->final_by_md_gm_amount?$total_Daily_filter->final_by_md_gm_amount:0)/($total_Daily_filter->current_salary_wage?$total_Daily_filter->current_salary_wage:0))-1)*100;
                    $total_Daily_filter->inc_percent_proposed = $cal2;
                }
            }else{
                $total_Daily_filter->company_suggested_percent = 0.00;
            }
        }
        
        

        
        
        $current_salary_wage = 0;
        $company_suggested_new_basic = 0;
        $company_suggested_percent = 0;
        
        $current_salary_wage_month = 0;
        $new_salary_wage_month = 0;
        $inc_percent_proposed = 0;
        
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


        
        $numrowNew_2 = $numrow_1+6;

        
        
        
        $numrowNew_2 = $numrowNew_2+1;
        
        $sheet2->setCellValue('AH'.$numrowNew_2, 'DAILY ');
        $sheet2->setCellValue('AI'.$numrowNew_2, ($total_Daily_filter->current_salary_wage>0?number_format($total_Daily_filter->current_salary_wage,2):'0.00'));
        $sheet2->setCellValue('AJ'.$numrowNew_2, ($total_Daily_filter->L800_avg_wage_mwa>0?number_format($total_Daily_filter->L800_avg_wage_mwa,2):'0.00'));
        $sheet2->setCellValue('AK'.$numrowNew_2, ($total_Daily_filter->salary_wage_calculation>0?number_format($total_Daily_filter->salary_wage_calculation,2):'0.00'));
        $sheet2->setCellValue('AL'.$numrowNew_2, ($total_Daily_filter->current_salary_wage_month>0?number_format($total_Daily_filter->current_salary_wage_month,2):'0.00'));
        $sheet2->setCellValue('AM'.$numrowNew_2, ($total_Daily_filter->company_suggested_percent>0?number_format($total_Daily_filter->company_suggested_percent,2):'0.00'));
        $sheet2->setCellValue('AN'.$numrowNew_2, ($total_Daily_filter->company_suggested_amount>0?number_format($total_Daily_filter->company_suggested_amount,2):'0.00'));
        $sheet2->setCellValue('AO'.$numrowNew_2, ($total_Daily_filter->company_suggested_new_basic>0?number_format($total_Daily_filter->company_suggested_new_basic,2):'0.00'));
        $sheet2->setCellValue('AQ'.$numrowNew_2, ($total_Daily_filter->inc_percent_proposed>=0?number_format($total_Daily_filter->inc_percent_proposed,2):'0.00'));
        $sheet2->setCellValue('AR'.$numrowNew_2, ($total_Daily_filter->inc_amount_proposed>0?number_format(round($total_Daily_filter->inc_amount_proposed),2):'0.00'));
        $sheet2->setCellValue('AS'.$numrowNew_2, ($total_Daily_filter->new_basic_wage_proposed>0?number_format($total_Daily_filter->new_basic_wage_proposed,2):'0.00'));
        $sheet2->setCellValue('AT'.$numrowNew_2, ($total_Daily_filter->new_salary_wage_month>0?number_format($total_Daily_filter->new_salary_wage_month,2):'0.00'));
        $sheet2->setCellValue('AU'.$numrowNew_2, ($finaldmgm_hide_2>0?number_format($finaldmgm_hide_2,2):''));
        
        $numrowNew_2 = $numrowNew_2+1;
        
        // $sheet2->setCellValue('AH'.$numrowNew_2, 'TOTAL MONTHLY+DAILY ');
        // $sheet2->setCellValue('AI'.$numrowNew_2, ($total_Daily_Monthly['current_salary_wage']>0?number_format($total_Daily_Monthly['current_salary_wage'],2):'0.00'));
        // $sheet2->setCellValue('AJ'.$numrowNew_2, ($total_Daily_Monthly['L800_avg_wage_mwa']>0?number_format($total_Daily_Monthly['L800_avg_wage_mwa'],2):'0.00'));
        // $sheet2->setCellValue('AK'.$numrowNew_2, ($total_Daily_Monthly['salary_wage_calculation']>0?number_format($total_Daily_Monthly['salary_wage_calculation'],2):'0.00'));
        // $sheet2->setCellValue('AL'.$numrowNew_2, ($total_Daily_Monthly['current_salary_wage_month']>0?number_format($total_Daily_Monthly['current_salary_wage_month'],2):'0.00'));
        // $sheet2->setCellValue('AM'.$numrowNew_2, ($total_Daily_Monthly['company_suggested_percent']>0?number_format($total_Daily_Monthly['company_suggested_percent'],2):'0.00'));
        // $sheet2->setCellValue('AN'.$numrowNew_2, ($total_Daily_Monthly['company_suggested_amount']>0?number_format($total_Daily_Monthly['company_suggested_amount'],2):'0.00'));
        // $sheet2->setCellValue('AO'.$numrowNew_2, ($total_Daily_Monthly['company_suggested_new_basic']>0?number_format($total_Daily_Monthly['company_suggested_new_basic'],2):'0.00'));
        // $sheet2->setCellValue('AQ'.$numrowNew_2, ($total_Daily_Monthly['inc_percent_proposed']>0?number_format($total_Daily_Monthly['inc_percent_proposed'],2):'0.00'));
        // $sheet2->setCellValue('AR'.$numrowNew_2, ($total_Daily_Monthly['inc_amount_proposed']>0?number_format($total_Daily_Monthly['inc_amount_proposed'],2):'0.00'));
        // $sheet2->setCellValue('AS'.$numrowNew_2, ($total_Daily_Monthly['new_basic_wage_proposed']>0?number_format($total_Daily_Monthly['new_basic_wage_proposed'],2):'0.00'));
        // $sheet2->setCellValue('AT'.$numrowNew_2, ($total_Daily_Monthly['new_salary_wage_month']>0?number_format($total_Daily_Monthly['new_salary_wage_month'],2):'0.00'));
        // $sheet2->setCellValue('AU'.$numrowNew_2, ($finaldmgm_hide>0?number_format($finaldmgm_hide,2):''));

        
        // $numrowNew_2 = $numrowNew_2+1;
        $sheet2->setCellValue('AL'.$numrowNew_2, 'Baht/Month');
        $sheet2->setCellValue('AT'.$numrowNew_2, 'Baht/Month');

        $numrowNew_2 = $numrowNew_2+6;
        
        $sheet2->setCellValue('AN'.$numrowNew_2, 'Proposed by ');
        $sheet2->setCellValue('AT'.$numrowNew_2, 'Approved by ');

        $spreadsheet
        ->getSheet(0)
        ->getStyle('AO'.$numrowNew_2.':AQ'.$numrowNew_2)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        $spreadsheet
        ->getSheet(0)
        ->getStyle('AU'.$numrowNew_2.':AW'.$numrowNew_2)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        
        $numrowNew_2 = $numrowNew_2+1;
        
        $sheet2->setCellValue('AP'.$numrowNew_2, 'Div/Dept Manager');
        $sheet2->setCellValue('AV'.$numrowNew_2, 'G.M.');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // $spreadsheet->createSheet();
        // $spreadsheet->setActiveSheetIndex(2);
        // $spreadsheet->getActiveSheet()->setTitle('Monthly');
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // $spreadsheet->createSheet();
        // $spreadsheet->setActiveSheetIndex(3);
        // $spreadsheet->getActiveSheet()->setTitle('Timeline 2023');
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PA _ '.date('Y').' Increment.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
}
