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

class ExcelmonthController extends Controller
{
    public function export_excel_month(Request $request)
    {
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
        $gatall->where('tb_employee_final_score.salary_type','Monthly');
        

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
        // dd($gatall);
        // exit;

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

        $excel = public_path('upload/orisoft/')."template_Increment_month.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);
        // $spreadsheet2 = $reader->load($excel);
        // $spreadsheet3 = $reader->load($excel);
        // $spreadsheet4 = $reader->load($excel);

        $sheet3 = $spreadsheet->getActiveSheet();
        $sheet3 = $spreadsheet->getSheet(0);
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3 = $spreadsheet->getSheet(2);
        // }
        
        $sheet4 = $spreadsheet->getSheet(1);
        // $sheet2 = $spreadsheet->getActiveSheet(1);
        // $sheet3 = $spreadsheet->getActiveSheet(2);
        
        
        
        // $sheet->setCellValue('A1', '1');
        // $sheet2->setCellValue('A1', '2');
        // $sheet3->setCellValue('A1', '3');
        $sheet3->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // $sheet2->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // }
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

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
                if($search_division == "all" || $search_division == ""){
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
        
                if($search_department == "all" || $search_department == ""){
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
                    $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
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
                    $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_countsection);
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_countsection);
                    }
                }
                
            }
            if(trans(request()->segment(1)) == 'manager'){
                if($orisoft_code == "000002"){
                    $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else if($orisoft_code == "990002"){
                
                }else{
                    $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                        
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
                            $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                        
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{
    
            }
            if($search_division != "all" && $search_division != ""){
                $arr_search_division_total_Monthly = [];
                $checka_total_Monthly = strpos($search_division,',');
                if($checka_total_Monthly >= 0){
                    $ex_total_Monthly = explode(',',$search_division);
                    if(count($ex_total_Monthly)>0){
                        foreach ($ex_total_Monthly as $value) {
                            array_push($arr_search_division_total_Monthly,$value);
                        }
                    }
                }else{
                    array_push($arr_search_division_total_Monthly,$search_division);
                }
                if(count($arr_search_division_total_Monthly) > 0){
                    $total_Monthly->whereIn('tb_employee.division_code', $arr_search_division_total_Monthly);
                }
            }
            // if($search_division != "all"){
            //     $total_Monthly->where('tb_employee.division_code', 'like','%'.$search_division.'%');
            // }
            if($search_department != "all" && $search_department != ""){
                $total_Monthly->where('tb_employee.department_code', 'like','%'.$search_department.'%');
            }
            if($search_section != "all" && $search_section != ""){
                $total_Monthly->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                    $total_Monthly->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
                }
            }
            if($search_grade != "all" && $search_grade != ""){
                $total_Monthly->where('tb_employee_final_score.grade_proposed',$search_grade);
            }
            if($search_status != "all" && $search_status != ""){
                if($search_status == "-1"){
                    $total_Monthly->where('tb_employee_final_score.status_salary','0');
                }else{
                    $total_Monthly->where('tb_employee_final_score.status_salary',$search_status);
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
        // dd($gatall);
        // exit;
        






























































































        // if($search_month_day == "all" || $search_month_day == "2"){
        $gatall_2 = DB::table('tb_employee_final_score')
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
            $gatall_2->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $gatall_2->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall_2->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        $gatall_2->where('tb_employee_final_score.salary_type','Monthly');
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checka_2 = strpos($orisoft_all_code->division_code,',');
                $arr_division_code_2 = [];
                if($checka_2 >= 0){
                    $ex_2 = explode(',',$orisoft_all_code->division_code);
                    if(count($ex_2)>0){
                        foreach ($ex_2 as $value) {
                            array_push($arr_division_code_2,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code_2,$orisoft_all_code->division_code);
                }
                $gatall_2 = $gatall_2->whereIn('tb_employee.division_code',$arr_division_code_2);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_code_2 = [];
                $checka_2 = strpos($orisoft_all_code->department_code,',');
                if($checka_2 >= 0){
                    $ex_2 = explode(',',$orisoft_all_code->department_code);
                    if(count($ex_2)>0){
                        foreach ($ex_2 as $value) {
                            array_push($arr_department_code_2,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code_2,$orisoft_all_code->department_code);
                }
                $gatall_2 = $gatall_2->whereIn('tb_employee.department_code',$arr_department_code_2);
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
                $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_2 = [];
                $countsection_2 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_2 = $countsection_2->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_2)>0){
                    foreach ($countsection_2 as $value) {
                        array_push($arr_countsection_2,$value->division_code);
                    }
                }
                $gatall_2 = $gatall_2->whereIn('tb_employee.division_code',$arr_countsection_2);
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_countsection);
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.division_code',$arr_division_code);
                    
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
                        $gatall_2 = $gatall_2->whereIn('tb_employee.department_code',$arr_department_code);
                    
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_gatall_2 = [];
            $checka_gatall_2 = strpos($search_division,',');
            if($checka_gatall_2 >= 0){
                $ex_gatall_2 = explode(',',$search_division);
                if(count($ex_gatall_2)>0){
                    foreach ($ex_gatall_2 as $value) {
                        array_push($arr_search_division_gatall_2,$value);
                    }
                }
            }else{
                array_push($arr_search_division_gatall_2,$search_division);
            }
            if(count($arr_search_division_gatall_2) > 0){
                $gatall_2->whereIn('tb_employee.division_code', $arr_search_division_gatall_2);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall_2->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $gatall_2->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $gatall_2->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                $gatall_2->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $gatall_2->where('tb_employee_final_score.salary_type','Monthly');
        if($search_grade != "all" && $search_grade != ""){
            $gatall_2->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $gatall_2->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall_2->where('tb_employee_final_score.status_salary',$search_status);
            }
        }


        $gatall_2->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
        ->orderBy('tb_employee_final_score.total_score', 'DESC');
        $gatall_2 = $gatall_2->get();
        

        ///////////////////////////////////

        $nooo_2 = 1;
        $finaldmgm_hide_3 = 0;
        if(count($gatall_2)>0){
            foreach ($gatall_2 as $key => $value) {
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
                    $finaldmgm_hide_3 += $value->final_by_md_gm_amount;
                }
                $pa_grade_2 = $value->pa_grade;
                $adjustg_2 = $value->adjust_grade;
                $current_2 = 0;
                $total_day_2 = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                $current_2 = $value->salary_old;
                if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                    $l800avg_wage_2 = $value->l800avg_wage;
                }else{
                    $l800avg_wage_2 = '';
                }
                $bsalary_wage_2 = 0;
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_2 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_2 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_2 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_2 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }
                }
                
                $salary_month_old_2 = $value->salary_month_old;
                if($value->grade_code == 'L800'){
                    $salary_month_old_2 = (float)$bsalary_wage_2*26;
                }
                $company_suggested_per_2 = $value->company_suggested_per;
                $percent_proposed_old_2 = $value->percent_proposed_old;
                $countbudget_2 = DB::table('tb_budget_action')
                            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                            ->where('tb_budget.year',$previousYear)->count();
                if($countbudget_2 > 0){
                    if($value->adjust_grade){
                        $databudget_2 = DB::table('tb_budget_action')
                        ->select('tb_budget_action.std')
                        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        ->where('tb_budget_action.grade_name',$value->adjust_grade)
                        ->where('tb_budget.year',$previousYear)->first();
                        $company_suggested_per_2 = $databudget_2->std;
                        $percent_proposed_old_2 = $databudget_2->std;
                    }
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1_2 = $value->service_days/365;
                }else{
                    $service_days1_2 = $value->service_days/365;
                };
                $service_days2_2 = $service_days1_2;
                
                $company_suggestged_amount_2 = $bsalary_wage_2*($company_suggested_per_2/100)*$service_days2_2;
                $company_suggestged_new_basic_2 = $value->company_suggestged_new_basic;
                if($value->grade_code == 'L800'){
                    $company_suggestged_new_basic_2 = round($company_suggestged_amount_2+$current_2);
                }else{
                    $company_suggestged_new_basic_2 = round($company_suggestged_amount_2+$bsalary_wage_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                }
                $value->company_suggestged_new_basic = $company_suggestged_new_basic_2;
                $amount_proposed_2 = $value->amount_proposed;
                if($bsalary_wage_2 > 0){
                    if($value->percent_proposed >= 0){
                        $amount_proposed_2 = $bsalary_wage_2*($value->percent_proposed/100)*$service_days2_2;
                    }else{
                        $amount_proposed_2 = $bsalary_wage_2*($percent_proposed_old_2/100)*$service_days2_2;
                    }
                }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $salary_new_2 = round($amount_proposed_2+$current_2);
                    }else{
                        $salary_new_2 = round($amount_proposed_2+$current_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $salary_new_2 = round($amount_proposed_2+$current_2);
                    }else{
                        $salary_new_2 = round($amount_proposed_2+$current_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }
                
                $salary_month_new_2 = ($value->salary_month_new?$value->salary_month_new:0);
                if($salary_new_2 > 0){
                    if($search_month_day != "all"){
                        if($search_month_day == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_2 = $salary_new_2*27.5;
                                $salary_month_new_2 = round($salary_month_newx_2,-1);
                            }else{
                                if($value->grade_code == 'L800'){
                                    $salary_month_new_2 = round($salary_new_2)*26;
                                }else{
                                    $salary_month_new_2 = round($salary_new_2);
                                }
                            }
                        }else{
                            $salary_month_new_2 = round($salary_new_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }else{
                        if($value->grade_code == 'L800'){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_2 = $salary_new_2*27.5;
                                $salary_month_new_2 = round($salary_month_newx_2,-1);
                            }else{
                                $salary_month_new_2 = round($salary_new_2)*26;
                            }
                        }else{
                            $salary_month_new_2 = round($salary_new_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }
                }
                
                $date_formatted_2 = '';
                if($value->date_joined){
                    $date_joined_old_2 = $value->date_joined;
                    $date_formatted_2 = date("Y-m-d", strtotime($date_joined_old_2));
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }else{
                    $service_days1 = $value->service_days/365;
                }
                
                $service_days2_2 = $service_days1;

                $data_2[] = array(
                    "id" =>  $nooo_2,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted_2,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> ($value->attendance_ol>0?number_format($value->attendance_ol,1):'0.0'),
                    "totald"=> ($total_day_2>0?number_format($total_day_2,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa1"=> ($value->adjust_grade_old1?$value->adjust_grade_old1:'-'),
                    "pa2"=> ($value->adjust_grade_old2?$value->adjust_grade_old2:'-'),
                    "pa3"=> ($value->adjust_grade_old3?$value->adjust_grade_old3:'-'),
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade_2,
                    "adjustg"=> $adjustg_2,
                    "current"=> ($current_2>0?number_format($current_2,2):''),
                    
                    "l800avg_gmdm"=> ($l800avg_wage_2>0?number_format($l800avg_wage_2,2):''),
                    "bsalaryw"=> ($bsalary_wage_2>0?number_format($bsalary_wage_2,2):''),
                    "cbsalaryw"=> ($salary_month_old_2>0?number_format($salary_month_old_2,2):''),
                    "comsugpct"=> ($company_suggested_per_2>0?number_format($company_suggested_per_2,2):0.00),
                    "comsugamt"=> ($company_suggestged_amount_2>0?number_format($company_suggestged_amount_2,2):0.00),
                    "companynewb"=> ($company_suggestged_new_basic_2>0?number_format($company_suggestged_new_basic_2,2):0.00),
                    
                    "gmgr_span2"=> ($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')),
                    
                    
                    "incpctmgr_span"=> ($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old_2,4,'.','')),
                    
                    "incamount"=> ($amount_proposed_2>0?number_format($amount_proposed_2,2):''),
                    "newbwage"=> ($salary_new_2>0?number_format($salary_new_2,2):''),
                    "newbsalary"=> ($salary_month_new_2>0?number_format($salary_month_new_2,2):''),
                    "finaldmgm"=> ($value->status_salary=='1'?($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')):''),
                    "remark_view"=> $value->remark_grade,
                    
                    
                    
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "grade_code"=> $value->grade_code,
                    "status_salary"=>$status_salary
                ); 
                $nooo_2++;
            }
        }else{
            $data_2 = [];
        }
        $countdata_2 = DB::table('tb_employee_final_score')
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
            $countdata_2->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $countdata_2->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $countdata_2->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        // if($search_month_day != "all"){
        //     if($search_month_day == "1"){
        //         $countdata_2->where('tb_employee_final_score.salary_type','Daily');
        //     }
        //     if($search_month_day == "2"){
        //         $countdata_2->where('tb_employee_final_score.salary_type','Monthly');
        //     }
        // }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checkacountdata_2 = strpos($orisoft_all_code->division_code,',');
                $arr_division_codecountdata_2 = [];
                if($checkacountdata_2 >= 0){
                    $excountdata_2 = explode(',',$orisoft_all_code->division_code);
                    if(count($excountdata_2)>0){
                        foreach ($excountdata_2 as $value) {
                            array_push($arr_division_codecountdata_2,$value);
                        }
                    }
                }else{
                    array_push($arr_division_codecountdata_2,$orisoft_all_code->division_code);
                }
                $countdata_2 = $countdata_2->whereIn('tb_employee.division_code',$arr_division_codecountdata_2);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_codecountdata_2 = [];
                $checkacountdata_2 = strpos($orisoft_all_code->department_code,',');
                if($checkacountdata_2 >= 0){
                    $excountdata_2 = explode(',',$orisoft_all_code->department_code);
                    if(count($excountdata_2)>0){
                        foreach ($excountdata_2 as $value) {
                            array_push($arr_department_codecountdata_2,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codecountdata_2,$orisoft_all_code->department_code);
                }
                $countdata_2 = $countdata_2->whereIn('tb_employee.department_code',$arr_department_codecountdata_2);
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
                $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_2 = [];
                $countsection_2 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_2 = $countsection_2->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_2)>0){
                    foreach ($countsection_2 as $value) {
                        array_push($arr_countsection_2,$value->division_code);
                    }
                }
                $countdata_2 = $countdata_2->whereIn('tb_employee.division_code',$arr_countsection_2);
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_countsection);
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.division_code',$arr_division_code);
                    
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
                        $countdata_2 = $countdata_2->whereIn('tb_employee.department_code',$arr_department_code);
                    
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_countdata_2 = [];
            $checka_countdata_2 = strpos($search_division,',');
            if($checka_countdata_2 >= 0){
                $ex_countdata_2 = explode(',',$search_division);
                if(count($ex_countdata_2)>0){
                    foreach ($ex_countdata_2 as $value) {
                        array_push($arr_search_division_countdata_2,$value);
                    }
                }
            }else{
                array_push($arr_search_division_countdata_2,$search_division);
            }
            if(count($arr_search_division_countdata_2) > 0){
                $countdata_2->whereIn('tb_employee.division_code', $arr_search_division_countdata_2);
            }
        }
        // if($search_division != "all"){
        //     $countdata_2->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $countdata_2->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $countdata_2->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                $countdata_2->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $countdata_2->where('tb_employee_final_score.salary_type','Monthly');
        if($search_grade != "all" && $search_grade != ""){
            $countdata_2->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $countdata_2->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata_2->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        $countdata_2 = $countdata_2->get();
        // dd($countdata_2);
        // exit;
        $countA_2 = 0;
        $countB_2 = 0;
        $countC_2 = 0;
        $countD_2 = 0;
        $countE_2 = 0;
        $countNoNull_2 = 0;

        $proposed_countAR_2 = 0;
        $proposed_countP_2 = 0;
        $proposed_countA_2 = 0;
        $proposed_countB_2 = 0;
        $proposed_countC_2 = 0;
        $proposed_countD_2 = 0;
        $proposed_countE_2 = 0;
        $proposed_countU_2 = 0;
        $proposed_countCD_2 = 0;
        $proposed_countNoNull_2 = 0;
        

        // dd($countdata_2);
        // exit;

        
        
        if(count($countdata_2)>0){
            foreach ($countdata_2 as $key => $value) {
                if($value->adjust_grade == 'A'){
                    $countA_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'B'){
                    $countB_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'C'){
                    $countC_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'D'){
                    $countD_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'E'){
                    $countE_2++;
                    $countNoNull_2++;
                }
    
                ///////////
    
                if($value->grade_proposed == 'AR'){
                    $proposed_countAR_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'P'){
                    $proposed_countP_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'A'){
                    $proposed_countA_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'B'){
                    $proposed_countB_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'C'){
                    $proposed_countC_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'D'){
                    $proposed_countD_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'E'){
                    $proposed_countE_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'U'){
                    $proposed_countU_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'CD'){
                    $proposed_countCD_2++;
                    $proposed_countNoNull_2++;
                }
            }
        }
        
        $sheet3->setCellValue('AI2', $countNoNull_2);
        $sheet3->setCellValue('AI4', $countA_2);
        $sheet3->setCellValue('AI5', $countB_2);
        $sheet3->setCellValue('AI6', $countC_2);
        $sheet3->setCellValue('AI7', $countD_2);
        $sheet3->setCellValue('AI8', $countE_2);
        
        
        $sumA_2 = 0;
        $sumB_2 = 0;
        $sumC_2 = 0;
        $sumD_2 = 0;
        $sumE_2 = 0;
        $bell_curve_2 = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        foreach ($bell_curve_2 as $key1 => $value1) {
            $percent_2 = $value1->percent/100;
            if($value1->grade_name == "A"){
                $sumA_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH4', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "B"){
                $sumB_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH5', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "C"){
                $sumC_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH6', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "D"){
                $sumD_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH7', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "E"){
                $sumE_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH8', ($percent_2?$percent_2:0));
            }
        }
        $sumAll_2 = $sumA_2+$sumB_2+$sumC_2+$sumD_2+$sumE_2;
        $sheet3->setCellValue('AH2', $sumAll_2);
        // dd($sumA);
        // exit;
        $sheet3->setCellValue('AI2', $sumAll_2);
        $sheet3->setCellValue('AI4', $sumA_2);
        $sheet3->setCellValue('AI5', $sumB_2);
        $sheet3->setCellValue('AI6', $sumC_2);
        $sheet3->setCellValue('AI7', $sumD_2);
        $sheet3->setCellValue('AI8', $sumE_2);
        ////////

        $proposed_sumAR_2 = ($proposed_countAR_2/$proposed_countNoNull_2)*100;
        $proposed_sumP_2 = ($proposed_countP_2/$proposed_countNoNull_2)*100;
        $proposed_sumA_2 = ($proposed_countA_2/$proposed_countNoNull_2)*100;
        $proposed_sumB_2 = ($proposed_countB_2/$proposed_countNoNull_2)*100;
        $proposed_sumC_2 = ($proposed_countC_2/$proposed_countNoNull_2)*100;
        $proposed_sumD_2 = ($proposed_countD_2/$proposed_countNoNull_2)*100;
        $proposed_sumE_2 = ($proposed_countE_2/$proposed_countNoNull_2)*100;
        $proposed_sumU_2 = ($proposed_countU_2/$proposed_countNoNull_2)*100;
        $proposed_sumCD_2 = ($proposed_countCD_2/$proposed_countNoNull_2)*100;

        $sheet3->setCellValue('AQ2', $proposed_countAR_2);
        $sheet3->setCellValue('AQ3', $proposed_countP_2);
        $sheet3->setCellValue('AQ4', $proposed_countA_2);
        $sheet3->setCellValue('AQ5', $proposed_countB_2);
        $sheet3->setCellValue('AQ6', $proposed_countC_2);
        $sheet3->setCellValue('AQ7', $proposed_countD_2);
        $sheet3->setCellValue('AQ8', $proposed_countE_2);
        $sheet3->setCellValue('AQ9', $proposed_countU_2);
        $sheet3->setCellValue('AQ10', $proposed_countCD_2);
        $sheet3->setCellValue('AQ1', $proposed_countNoNull_2);

        $sheet3->setCellValue('AR2', ($proposed_sumAR_2?number_format($proposed_sumAR_2/100,2):0));
        $sheet3->setCellValue('AR3', ($proposed_sumP_2?number_format($proposed_sumP_2/100,2):0));
        $sheet3->setCellValue('AR4', ($proposed_sumA_2?number_format($proposed_sumA_2/100,2):0));
        $sheet3->setCellValue('AR5', ($proposed_sumB_2?number_format($proposed_sumB_2/100,2):0));
        $sheet3->setCellValue('AR6', ($proposed_sumC_2?number_format($proposed_sumC_2/100,2):0));
        $sheet3->setCellValue('AR7', ($proposed_sumD_2?number_format($proposed_sumD_2/100,2):0));
        $sheet3->setCellValue('AR8', ($proposed_sumE_2?number_format($proposed_sumE_2/100,2):0));
        $sheet3->setCellValue('AR9', ($proposed_sumU_2?number_format($proposed_sumU_2/100,2):0));
        $sheet3->setCellValue('AR10', ($proposed_sumCD_2?number_format($proposed_sumCD_2/100,2):0));


        $budget_2 = DB::table('tb_budget_action')
        ->select('tb_budget_action.*')
        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
        ->where('tb_budget.year',$previousYear)
        ->orderBy('tb_budget_action.id', 'ASC')->get();
        if(count($budget_2)>0){
            foreach ($budget_2 as $key => $value1) {
                if($value1->grade_name == "AR"){
                    $sheet3->setCellValue('AL2', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM2', $value1->grade_name);
                    $sheet3->setCellValue('AN2', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "P"){
                    $sheet3->setCellValue('AL3', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM3', $value1->grade_name);
                    $sheet3->setCellValue('AN3', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "A"){
                    $sheet3->setCellValue('AL4', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM4', $value1->grade_name);
                    $sheet3->setCellValue('AN4', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "B"){
                    $sheet3->setCellValue('AL5', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM5', $value1->grade_name);
                    $sheet3->setCellValue('AN5', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "C"){
                    $sheet3->setCellValue('AL6', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM6', $value1->grade_name);
                    $sheet3->setCellValue('AN6', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "D"){
                    $sheet3->setCellValue('AL7', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM7', $value1->grade_name);
                    $sheet3->setCellValue('AN7', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "E"){
                    $sheet3->setCellValue('AL8', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM8', $value1->grade_name);
                    $sheet3->setCellValue('AN8', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "U"){
                    $sheet3->setCellValue('AL9', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM9', $value1->grade_name);
                    $sheet3->setCellValue('AN9', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "CD"){
                    $sheet3->setCellValue('AL10', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM10', $value1->grade_name);
                    $sheet3->setCellValue('AN10', ($value1->std?number_format($value1->std/100,2):0));
                }
            }
        }

        if($search_section != "all" && $search_section != ""){
            $percent_department_2 = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->where('tb_percent_department_action.section_code', 'like','%'.$search_section.'%')
            ->orderBy('tb_percent_department_action.id', 'ASC')->first();
            $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));

            $sheet3->setCellValue('AU2', ($percent_department_2->percent_monthly?($percent_department_2->percent_monthly/100):0));
        }else{
            if($search_department != "all" && $search_department != ""){
                $percent_department_2 = DB::table('tb_percent_department_action')
                ->select( 
                    DB::raw('SUM(percent_daily) AS percent_daily'),
                    DB::raw('SUM(percent_monthly) AS percent_monthly')
                )  
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year',$previousYear)
                ->where('tb_percent_department_action.department_code', 'like','%'.$search_department.'%')
                ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));
    
                $sheet3->setCellValue('AU2', ($percent_department_2->percent_monthly?($percent_department_2->percent_monthly/100):0));
            }else{
                if($search_division != "all" && $search_division != ""){
                    if($search_division){
                        $arr_search_division_percent_department_2 = [];
                        $checka_percent_department_2 = strpos($search_division,',');
                        if($checka_percent_department_2 >= 0){
                            $ex_percent_department_2 = explode(',',$search_division);
                            if(count($ex_percent_department_2)>0){
                                foreach ($ex_percent_department_2 as $value) {
                                    array_push($arr_search_division_percent_department_2,$value);
                                }
                            }
                        }else{
                            array_push($arr_search_division_percent_department_2,$search_division);
                        }
                    }
                    $percent_department_2 = DB::table('tb_percent_department_action')
                    ->select( 
                        DB::raw('SUM(percent_daily) AS percent_daily'),
                        DB::raw('SUM(percent_monthly) AS percent_monthly')
                    )  
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year',$previousYear)
                    ->whereIn('tb_percent_department_action.division_code', $arr_search_division_percent_department_2)
                    ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                    $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));
        
                    $sheet3->setCellValue('AU2', ($percent_department_2->percent_monthly?($percent_department_2->percent_monthly/100):0));
                }else{
                    $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));
                }
            }
        }
        
        

        $total_Monthly_2 = DB::table('tb_employee_final_score')
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
                $total_Monthly_2->where('tb_employee_final_score.freeze_to_approve_hr', '1');
            }else{
                if($pagenow == "2"){
                    $total_Monthly_2->where('tb_employee_final_score.freeze_to_gmdm', '1');
                }else{
                    $total_Monthly_2->where('tb_employee_final_score.freeze_to_pagrade', '1');
                }
            }

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
                if($search_division == "all" || $search_division == ""){
                    $checkatotal_Monthly_2 = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codetotal_Monthly_2 = [];
                    if($checkatotal_Monthly_2 >= 0){
                        $extotal_Monthly_2 = explode(',',$orisoft_all_code->division_code);
                        if(count($extotal_Monthly_2)>0){
                            foreach ($extotal_Monthly_2 as $value) {
                                array_push($arr_division_codetotal_Monthly_2,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codetotal_Monthly_2,$orisoft_all_code->division_code);
                    }
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.division_code',$arr_division_codetotal_Monthly_2);
                }
        
                if($search_department == "all" || $search_department == ""){
                    $arr_department_codetotal_Monthly_2 = [];
                    $checkatotal_Monthly_2 = strpos($orisoft_all_code->department_code,',');
                    if($checkatotal_Monthly_2 >= 0){
                        $extotal_Monthly_2 = explode(',',$orisoft_all_code->department_code);
                        if(count($extotal_Monthly_2)>0){
                            foreach ($extotal_Monthly_2 as $value) {
                                array_push($arr_department_codetotal_Monthly_2,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_codetotal_Monthly_2,$orisoft_all_code->department_code);
                    }
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.department_code',$arr_department_codetotal_Monthly_2);
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
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
            }

            if($orisoft_code == "000002"){
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection_2 = [];
                    $countsection_2 = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection_2 = $countsection_2->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection_2)>0){
                        foreach ($countsection_2 as $value) {
                            array_push($arr_countsection_2,$value->division_code);
                        }
                    }
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.division_code',$arr_countsection_2);
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_countsection);
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_countsection);
                    }
                }
                
            }
            if(trans(request()->segment(1)) == 'manager'){
                if($orisoft_code == "000002"){
                    $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else if($orisoft_code == "990002"){
                
                }else{
                    $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    // $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.division_code',$arr_division_code);
                        
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
                            $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.department_code',$arr_department_code);
                        
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                    // $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{
    
            }
            if($search_division != "all" && $search_division != ""){
                $arr_search_division_total_Monthly_2 = [];
                $checka_total_Monthly_2 = strpos($search_division,',');
                if($checka_total_Monthly_2 >= 0){
                    $ex_total_Monthly_2 = explode(',',$search_division);
                    if(count($ex_total_Monthly_2)>0){
                        foreach ($ex_total_Monthly_2 as $value) {
                            array_push($arr_search_division_total_Monthly_2,$value);
                        }
                    }
                }else{
                    array_push($arr_search_division_total_Monthly_2,$search_division);
                }
                if(count($arr_search_division_total_Monthly_2) > 0){
                    $total_Monthly_2->whereIn('tb_employee.division_code', $arr_search_division_total_Monthly_2);
                }
            }
            // if($search_division != "all"){
            //     $total_Monthly_2->where('tb_employee.division_code', 'like','%'.$search_division.'%');
            // }
            if($search_department != "all" && $search_department != ""){
                $total_Monthly_2->where('tb_employee.department_code', 'like','%'.$search_department.'%');
            }
            if($search_section != "all" && $search_section != ""){
                $total_Monthly_2->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                    $total_Monthly_2->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
                }
            }
            if($search_grade != "all" && $search_grade != ""){
                $total_Monthly_2->where('tb_employee_final_score.grade_proposed',$search_grade);
            }
            if($search_status != "all" && $search_status != ""){
                if($search_status == "-1"){
                    $total_Monthly_2->where('tb_employee_final_score.status_salary','0');
                }else{
                    $total_Monthly_2->where('tb_employee_final_score.status_salary',$search_status);
                }
            }
        $total_Monthly_2 = $total_Monthly_2->first();
        
        if($total_Monthly_2->current_salary_wage_month){
            if($total_Monthly_2->current_salary_wage_month > 0){
                $cal_2 = ((($total_Monthly_2->company_suggested_new_basic?$total_Monthly_2->company_suggested_new_basic:0)/($total_Monthly_2->current_salary_wage_month?$total_Monthly_2->current_salary_wage_month:0))-1)*100;
                $total_Monthly_2->company_suggested_percent = $cal_2;
            }
        }else{
            $total_Monthly_2->company_suggested_percent = 0.00;
        }
        if($total_Monthly_2->new_salary_wage_month > 0){
            $cal_month_2 = ((($total_Monthly_2->new_salary_wage_month/$total_Monthly_2->current_salary_wage_month-1)*100)* 1000)/ 1000;
        }else{
            $cal_month_2 = 0;
        }
        $cal_all_2 = $cal_month_2;
        
        // dd($cal_month_2);
        // exit;
        $sheet3->setCellValue('AU1', ($cal_month_2?$cal_month_2/100:0));



        $numrow_2 = 13;
        $final_score = [];
        if(count($data_2)>0){
            foreach ($data_2 as $key => $value) {
                
                $date1_2 = $value['joindate'];
                $date2_2 = date('Y')."-01-31";

                $diff_2 = abs(strtotime($date2_2) - strtotime($date1_2));

                $years_2 = floor($diff_2 / (365*60*60*24));
                $months_2 = floor(($diff_2 - $years_2 * 365*60*60*24) / (30*60*60*24));
                $days_2 = floor(($diff_2 - $years_2 * 365*60*60*24 - $months_2*30*60*60*24)/ (60*60*24));

                // printf("%d years, %d months, %d days\n", $years, $months, $days);
                // exit;
                if($value['pa1'] == "AR"){
                    $bg_color_pa1_2 = 'FFFFFF';
                }else if($value['pa1'] == "P"){
                    $bg_color_pa1_2 = 'FFFFFF';
                }else if($value['pa1'] == "A"){
                    $bg_color_pa1_2 = '9FCE63';
                }else if($value['pa1'] == "B"){
                    $bg_color_pa1_2 = 'BFDDE7';
                }else if($value['pa1'] == "C"){
                    $bg_color_pa1_2 = 'DAE4C0';
                }else if($value['pa1'] == "D"){
                    $bg_color_pa1_2 = 'FFFFD1';
                }else if($value['pa1'] == "E"){
                    $bg_color_pa1_2 = 'DFBAB8';
                }else if($value['pa1'] == "U"){
                    $bg_color_pa1_2 = 'FFFFFF';
                }else{
                    $bg_color_pa1_2 = 'FFFFFF';
                }
                if($value['pa2'] == "AR"){
                    $bg_color_pa2_2 = 'FFFFFF';
                }else if($value['pa2'] == "P"){
                    $bg_color_pa2_2 = 'FFFFFF';
                }else if($value['pa2'] == "A"){
                    $bg_color_pa2_2 = '9FCE63';
                }else if($value['pa2'] == "B"){
                    $bg_color_pa2_2 = 'BFDDE7';
                }else if($value['pa2'] == "C"){
                    $bg_color_pa2_2 = 'DAE4C0';
                }else if($value['pa2'] == "D"){
                    $bg_color_pa2_2 = 'FFFFD1';
                }else if($value['pa2'] == "E"){
                    $bg_color_pa2_2 = 'DFBAB8';
                }else if($value['pa2'] == "U"){
                    $bg_color_pa2_2 = 'FFFFFF';
                }else{
                    $bg_color_pa2_2 = 'FFFFFF';
                }

                if($value['pa3'] == "AR"){
                    $bg_color_pa3_2 = 'FFFFFF';
                }else if($value['pa3'] == "P"){
                    $bg_color_pa3_2 = 'FFFFFF';
                }else if($value['pa3'] == "A"){
                    $bg_color_pa3_2 = '9FCE63';
                }else if($value['pa3'] == "B"){
                    $bg_color_pa3_2 = 'BFDDE7';
                }else if($value['pa3'] == "C"){
                    $bg_color_pa3_2 = 'DAE4C0';
                }else if($value['pa3'] == "D"){
                    $bg_color_pa3_2 = 'FFFFD1';
                }else if($value['pa3'] == "E"){
                    $bg_color_pa3_2 = 'DFBAB8';
                }else if($value['pa3'] == "U"){
                    $bg_color_pa3_2 = 'FFFFFF';
                }else{
                    $bg_color_pa3_2 = 'FFFFFF';
                }
                if($value['theoryg'] == "AR"){
                    $bg_color_theoryg_2 = 'FFFFFF';
                }else if($value['theoryg'] == "P"){
                    $bg_color_theoryg_2 = 'FFFFFF';
                }else if($value['theoryg'] == "A"){
                    $bg_color_theoryg_2 = '9FCE63';
                }else if($value['theoryg'] == "B"){
                    $bg_color_theoryg_2 = 'BFDDE7';
                }else if($value['theoryg'] == "C"){
                    $bg_color_theoryg_2 = 'DAE4C0';
                }else if($value['theoryg'] == "D"){
                    $bg_color_theoryg_2 = 'FFFFD1';
                }else if($value['theoryg'] == "E"){
                    $bg_color_theoryg_2 = 'DFBAB8';
                }else if($value['theoryg'] == "U"){
                    $bg_color_theoryg_2 = 'FFFFFF';
                }else{
                    $bg_color_theoryg_2 = 'FFFFFF';
                }
                if($value['adjustg'] == "AR"){
                    $bg_color_adjustg_2 = 'FFFFFF';
                }else if($value['adjustg'] == "P"){
                    $bg_color_adjustg_2 = 'FFFFFF';
                }else if($value['adjustg'] == "A"){
                    $bg_color_adjustg_2 = '9FCE63';
                }else if($value['adjustg'] == "B"){
                    $bg_color_adjustg_2 = 'BFDDE7';
                }else if($value['adjustg'] == "C"){
                    $bg_color_adjustg_2 = 'DAE4C0';
                }else if($value['adjustg'] == "D"){
                    $bg_color_adjustg_2 = 'FFFFD1';
                }else if($value['adjustg'] == "E"){
                    $bg_color_adjustg_2 = 'DFBAB8';
                }else if($value['adjustg'] == "U"){
                    $bg_color_adjustg_2 = 'FFFFFF';
                }else{
                    $bg_color_adjustg_2 = 'FFFFFF';
                }
                if($value['gmgr_span2'] == "AR"){
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "P"){
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "A"){
                    $bg_color_gmgr_span2_2 = '9FCE63';
                }else if($value['gmgr_span2'] == "B"){
                    $bg_color_gmgr_span2_2 = 'BFDDE7';
                }else if($value['gmgr_span2'] == "C"){
                    $bg_color_gmgr_span2_2 = 'DAE4C0';
                }else if($value['gmgr_span2'] == "D"){
                    $bg_color_gmgr_span2_2 = 'FFFFD1';
                }else if($value['gmgr_span2'] == "E"){
                    $bg_color_gmgr_span2_2 = 'DFBAB8';
                }else if($value['gmgr_span2'] == "U"){
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }else{
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }
                
                $bg_color_status_salary_2 = 'f1f1f2';
                if($value['status_salary'] == 'In progress'){
                    $bg_color_status_salary_2 = 'f1f1f2';
                }
                if($value['status_salary'] == 'Reject'){
                    $bg_color_status_salary_2 = 'fff5f8';
                }
                if($value['status_salary'] == 'Approved'){
                    $bg_color_status_salary_2 = 'e8fff3';
                }
                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('A'.$numrow_2.':AX'.$numrow_2)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('000000'));
                $sheet3->setCellValue('A'.$numrow_2, $value['division_code']);
                $sheet3->setCellValue('B'.$numrow_2, $value['department_code']);
                $sheet3->setCellValue('C'.$numrow_2, $value['section_code']);
                $sheet3->setCellValue('D'.$numrow_2, ($value['grade_code']=='L800'?'Daily':'Monthly'));
                $sheet3->setCellValue('E'.$numrow_2, $value['grade_code']);
                $sheet3->setCellValue('F'.$numrow_2, $value['id']);
                $sheet3->setCellValue('G'.$numrow_2, $value['code']);
                $sheet3->setCellValue('H'.$numrow_2, $value['name']);
                $sheet3->setCellValue('I'.$numrow_2, $value['position']);
                $sheet3->setCellValue('J'.$numrow_2, $value['group']);
                $sheet3->setCellValue('K'.$numrow_2, $value['joindate']);

                $sheet3->setCellValue('L'.$numrow_2, $years_2);
                $sheet3->setCellValue('M'.$numrow_2, $months_2);
                $sheet3->setCellValue('N'.$numrow_2, $days_2);
                
                $sheet3->setCellValue('O'.$numrow_2, $value['serviced']);
                

                $sheet3->setCellValue('P'.$numrow_2, $value['sl']);
                $sheet3->setCellValue('Q'.$numrow_2, $value['pl']);
                $sheet3->setCellValue('R'.$numrow_2, $value['latet']);
                $sheet3->setCellValue('S'.$numrow_2, $value['lated']);
                $sheet3->setCellValue('T'.$numrow_2, $value['abst']);
                $sheet3->setCellValue('U'.$numrow_2, $value['absd']);
                $sheet3->setCellValue('V'.$numrow_2, $value['ol']);
                $sheet3->setCellValue('W'.$numrow_2, $value['totald']);
                $sheet3->setCellValue('X'.$numrow_2, $value['verbal']);
                $sheet3->setCellValue('Y'.$numrow_2, $value['written']);
                $sheet3->setCellValue('Z'.$numrow_2, $value['susd']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AA'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa1_2);
                $sheet3->setCellValue('AA'.$numrow_2, $value['pa1']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AB'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa2_2);
                $sheet3->setCellValue('AB'.$numrow_2, $value['pa2']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AC'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa3_2);
                $sheet3->setCellValue('AC'.$numrow_2, $value['pa3']);
                $sheet3->setCellValue('AD'.$numrow_2, $value['form']);
                $sheet3->setCellValue('AE'.$numrow_2, $value['evaluator']);
                $sheet3->setCellValue('AF'.$numrow_2, $value['total']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AG'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_theoryg_2);
                $sheet3->setCellValue('AG'.$numrow_2, $value['theoryg']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AH'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_adjustg_2);
                $sheet3->setCellValue('AH'.$numrow_2, $value['adjustg']);
                $sheet3->setCellValue('AI'.$numrow_2, $value['current']);
                $sheet3->setCellValue('AJ'.$numrow_2, $value['l800avg_gmdm']);
                $sheet3->setCellValue('AK'.$numrow_2, $value['bsalaryw']);
                $sheet3->setCellValue('AL'.$numrow_2, $value['cbsalaryw']);
                $sheet3->setCellValue('AM'.$numrow_2, $value['comsugpct']);
                $sheet3->setCellValue('AN'.$numrow_2, $value['comsugamt']);
                $sheet3->setCellValue('AO'.$numrow_2, $value['companynewb']);

                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AP'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_gmgr_span2_2);
                $sheet3->setCellValue('AP'.$numrow_2, $value['gmgr_span2']);
                $sheet3->setCellValue('AQ'.$numrow_2, $value['incpctmgr_span']);
                $sheet3->setCellValue('AR'.$numrow_2, $value['incamount']);
                $sheet3->setCellValue('AS'.$numrow_2, $value['newbwage']);
                $sheet3->setCellValue('AT'.$numrow_2, $value['newbsalary']);
                $sheet3->setCellValue('AU'.$numrow_2, $value['finaldmgm']);
                $sheet3->setCellValue('AV'.$numrow_2, $value['remark_view']);

                $spreadsheet
                ->getSheet(0)
                ->getStyle('AX'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_status_salary_2);
                $sheet3->setCellValue('AX'.$numrow_2, $value['status_salary']);
                $numrow_2++;
            }
        }
        // dd($data_2);
        // exit;
        // }


















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

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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
                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
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
                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_countsection);
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_countsection);
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Monthly_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
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
                        $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Monthly_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_total_Monthly_filter = [];
            $checka_total_Monthly_filter = strpos($search_division,',');
            if($checka_total_Monthly_filter >= 0){
                $ex_total_Monthly_filter = explode(',',$search_division);
                if(count($ex_total_Monthly_filter)>0){
                    foreach ($ex_total_Monthly_filter as $value) {
                        array_push($arr_search_division_total_Monthly_filter,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Monthly_filter,$search_division);
            }
            if(count($arr_search_division_total_Monthly_filter) > 0){
                $total_Monthly_filter->whereIn('tb_employee.division_code', $arr_search_division_total_Monthly_filter);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $total_Monthly_filter->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Monthly_filter->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Monthly_filter->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                $total_Monthly_filter->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $total_Monthly_filter->where('tb_employee_final_score.salary_type','Monthly');
        if($search_grade != "all" && $search_grade != ""){
            $total_Monthly_filter->where('tb_employee_final_score.grade_proposed',$search_grade);
        }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $total_Monthly_filter->where('tb_employee_final_score.status_salary','0');
            }else{
                $total_Monthly_filter->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        $total_Monthly_filter = $total_Monthly_filter->first();
        
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
        
        $current_salary_wage = 0;
        $company_suggested_new_basic = 0;
        $company_suggested_percent = 0;
        
        $current_salary_wage_month = 0;
        $new_salary_wage_month = 0;
        $inc_percent_proposed = 0;
        
        if($total_Monthly_filter){
            if($total_Monthly_filter->current_salary_wage){
                if($total_Monthly_filter->current_salary_wage > 0){
                    $current_salary_wage = $total_Monthly_filter->current_salary_wage;
                    if($total_Monthly_filter->company_suggested_new_basic){
                        $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
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
                if($total_Monthly_filter->company_suggested_new_basic){
                    $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
                }else{
                    $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
                }
                
                if($current_salary_wage > 0){
                    $company_suggested_percent = (($company_suggested_new_basic/$current_salary_wage)-1)*100;
                }else{
                    $company_suggested_percent = 0;
                }
            }
            
            $current_salary_wage_month = $total_Monthly_filter->current_salary_wage_month;
            $new_salary_wage_month = $total_Monthly_filter->new_salary_wage_month;
            if($current_salary_wage_month > 0){
                $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
            }else{
                $inc_percent_proposed = 0;
            }
            $total_Daily_Monthly = [
                "current_salary_wage" => $total_Monthly_filter->current_salary_wage,
                "L800_avg_wage_mwa" => $total_Monthly_filter->L800_avg_wage_mwa,
                "salary_wage_calculation" => $total_Monthly_filter->salary_wage_calculation,
                "current_salary_wage_month" => $total_Monthly_filter->current_salary_wage_month,
                "company_suggested_percent" => $company_suggested_percent,
                "company_suggested_amount" => $total_Monthly_filter->company_suggested_amount,
                "company_suggested_new_basic" => $total_Monthly_filter->company_suggested_new_basic,
                "inc_percent_proposed" => $inc_percent_proposed,
                "inc_amount_proposed" => $total_Monthly_filter->inc_amount_proposed,
                "new_basic_wage_proposed" => $total_Monthly_filter->new_basic_wage_proposed,
                "new_salary_wage_month" => $total_Monthly_filter->new_salary_wage_month,
                "final_by_md_gm_amount" => $total_Monthly_filter->final_by_md_gm_amount,
            ];
        }


        
        $numrowNew_3 = $numrow_2+6;

        
        $sheet3->setCellValue('AH'.$numrowNew_3, 'MONTHLY ');
        $sheet3->setCellValue('AI'.$numrowNew_3, ($total_Monthly_filter->current_salary_wage>0?number_format($total_Monthly_filter->current_salary_wage,2):'0.00'));
        $sheet3->setCellValue('AJ'.$numrowNew_3, ($total_Monthly_filter->L800_avg_wage_mwa>0?number_format($total_Monthly_filter->L800_avg_wage_mwa,2):'0.00'));
        $sheet3->setCellValue('AK'.$numrowNew_3, ($total_Monthly_filter->salary_wage_calculation>0?number_format($total_Monthly_filter->salary_wage_calculation,2):'0.00'));
        $sheet3->setCellValue('AL'.$numrowNew_3, ($total_Monthly_filter->current_salary_wage_month>0?number_format($total_Monthly_filter->current_salary_wage_month,2):'0.00'));
        $sheet3->setCellValue('AM'.$numrowNew_3, ($total_Monthly_filter->company_suggested_percent>0?number_format($total_Monthly_filter->company_suggested_percent,2):'0.00'));
        $sheet3->setCellValue('AN'.$numrowNew_3, ($total_Monthly_filter->company_suggested_amount>0?number_format($total_Monthly_filter->company_suggested_amount,2):'0.00'));
        $sheet3->setCellValue('AO'.$numrowNew_3, ($total_Monthly_filter->company_suggested_new_basic>0?number_format($total_Monthly_filter->company_suggested_new_basic,2):'0.00'));
        $sheet3->setCellValue('AQ'.$numrowNew_3, ($total_Monthly_filter->inc_percent_proposed>=0?number_format($total_Monthly_filter->inc_percent_proposed,2):'0.00'));
        $sheet3->setCellValue('AR'.$numrowNew_3, ($total_Monthly_filter->inc_amount_proposed>0?number_format($total_Monthly_filter->inc_amount_proposed,2):'0.00'));
        $sheet3->setCellValue('AS'.$numrowNew_3, ($total_Monthly_filter->new_basic_wage_proposed>0?number_format($total_Monthly_filter->new_basic_wage_proposed,2):'0.00'));
        $sheet3->setCellValue('AT'.$numrowNew_3, ($total_Monthly_filter->new_salary_wage_month>0?number_format($total_Monthly_filter->new_salary_wage_month,2):'0.00'));
        $sheet3->setCellValue('AU'.$numrowNew_3, ($finaldmgm_hide_3>0?number_format($finaldmgm_hide_3,2):''));

        $numrowNew_3 = $numrowNew_3+1;
        
        // $numrowNew_3 = $numrowNew_3+1;
        
        // $sheet3->setCellValue('AH'.$numrowNew_3, 'TOTAL MONTHLY+DAILY ');
        // $sheet3->setCellValue('AI'.$numrowNew_3, ($total_Daily_Monthly['current_salary_wage']>0?number_format($total_Daily_Monthly['current_salary_wage'],2):'0.00'));
        // $sheet3->setCellValue('AJ'.$numrowNew_3, ($total_Daily_Monthly['L800_avg_wage_mwa']>0?number_format($total_Daily_Monthly['L800_avg_wage_mwa'],2):'0.00'));
        // $sheet3->setCellValue('AK'.$numrowNew_3, ($total_Daily_Monthly['salary_wage_calculation']>0?number_format($total_Daily_Monthly['salary_wage_calculation'],2):'0.00'));
        // $sheet3->setCellValue('AL'.$numrowNew_3, ($total_Daily_Monthly['current_salary_wage_month']>0?number_format($total_Daily_Monthly['current_salary_wage_month'],2):'0.00'));
        // $sheet3->setCellValue('AM'.$numrowNew_3, ($total_Daily_Monthly['company_suggested_percent']>0?number_format($total_Daily_Monthly['company_suggested_percent'],2):'0.00'));
        // $sheet3->setCellValue('AN'.$numrowNew_3, ($total_Daily_Monthly['company_suggested_amount']>0?number_format($total_Daily_Monthly['company_suggested_amount'],2):'0.00'));
        // $sheet3->setCellValue('AO'.$numrowNew_3, ($total_Daily_Monthly['company_suggested_new_basic']>0?number_format($total_Daily_Monthly['company_suggested_new_basic'],2):'0.00'));
        // $sheet3->setCellValue('AQ'.$numrowNew_3, ($total_Daily_Monthly['inc_percent_proposed']>0?number_format($total_Daily_Monthly['inc_percent_proposed'],2):'0.00'));
        // $sheet3->setCellValue('AR'.$numrowNew_3, ($total_Daily_Monthly['inc_amount_proposed']>0?number_format($total_Daily_Monthly['inc_amount_proposed'],2):'0.00'));
        // $sheet3->setCellValue('AS'.$numrowNew_3, ($total_Daily_Monthly['new_basic_wage_proposed']>0?number_format($total_Daily_Monthly['new_basic_wage_proposed'],2):'0.00'));
        // $sheet3->setCellValue('AT'.$numrowNew_3, ($total_Daily_Monthly['new_salary_wage_month']>0?number_format($total_Daily_Monthly['new_salary_wage_month'],2):'0.00'));
        // $sheet3->setCellValue('AU'.$numrowNew_3, ($finaldmgm_hide>0?number_format($finaldmgm_hide,2):''));

        
        $numrowNew_3 = $numrowNew_3+1;
        
        $sheet3->setCellValue('AL'.$numrowNew_3, 'Baht/Month');
        $sheet3->setCellValue('AT'.$numrowNew_3, 'Baht/Month');

        
        $numrowNew_3 = $numrowNew_3+6;
        
        $sheet3->setCellValue('AN'.$numrowNew_3, 'Proposed by ');
        $sheet3->setCellValue('AT'.$numrowNew_3, 'Approved by ');

        
        $spreadsheet
        ->getSheet(0)
        ->getStyle('AO'.$numrowNew_3.':AQ'.$numrowNew_3)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        $spreadsheet
        ->getSheet(0)
        ->getStyle('AU'.$numrowNew_3.':AW'.$numrowNew_3)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        
        
        $numrowNew_3 = $numrowNew_3+1;
        

        $sheet3->setCellValue('AP'.$numrowNew_3, 'Div/Dept Manager');
        $sheet3->setCellValue('AV'.$numrowNew_3, 'G.M.');

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

    public function export_excel_month_approve(Request $request)
    {
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
        $gatall->where('tb_employee_final_score.salary_type','Monthly');
        

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
        // dd($gatall);
        // exit;

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

        $excel = public_path('upload/orisoft/')."template_Increment_month.xlsx";
        $reader = new Reader();
        $spreadsheet = $reader->load($excel);
        // $spreadsheet2 = $reader->load($excel);
        // $spreadsheet3 = $reader->load($excel);
        // $spreadsheet4 = $reader->load($excel);

        $sheet3 = $spreadsheet->getActiveSheet();
        $sheet3 = $spreadsheet->getSheet(0);
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3 = $spreadsheet->getSheet(2);
        // }
        
        $sheet4 = $spreadsheet->getSheet(1);
        // $sheet2 = $spreadsheet->getActiveSheet(1);
        // $sheet3 = $spreadsheet->getActiveSheet(2);
        
        
        
        // $sheet->setCellValue('A1', '1');
        // $sheet2->setCellValue('A1', '2');
        // $sheet3->setCellValue('A1', '3');
        $sheet3->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // $sheet2->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // if($search_month_day == "all" || $search_month_day == "2"){
            // $sheet3->setCellValue('C1', 'Performance Appraisal and '.date('Y').' Annual Increment');
        // }
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

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
                if($search_division == "all" || $search_division == ""){
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
        
                if($search_department == "all" || $search_department == ""){
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
                    $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
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
                    $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_countsection);
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_countsection);
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_countsection);
                    }
                }
                
            }
            if(trans(request()->segment(1)) == 'manager'){
                if($orisoft_code == "000002"){
                    $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else if($orisoft_code == "990002"){
                
                }else{
                    $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.division_code',$arr_division_code);
                        
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
                            $total_Monthly = $total_Monthly->whereIn('tb_employee.department_code',$arr_department_code);
                        
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
                        $total_Monthly = $total_Monthly->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                    // $total_Monthly->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{
    
            }
            if($search_division != "all" && $search_division != ""){
                $arr_search_division_total_Monthly = [];
                $checka_total_Monthly = strpos($search_division,',');
                if($checka_total_Monthly >= 0){
                    $ex_total_Monthly = explode(',',$search_division);
                    if(count($ex_total_Monthly)>0){
                        foreach ($ex_total_Monthly as $value) {
                            array_push($arr_search_division_total_Monthly,$value);
                        }
                    }
                }else{
                    array_push($arr_search_division_total_Monthly,$search_division);
                }
                if(count($arr_search_division_total_Monthly) > 0){
                    $total_Monthly->whereIn('tb_employee.division_code', $arr_search_division_total_Monthly);
                }
            }
            // if($search_division != "all"){
            //     $total_Monthly->where('tb_employee.division_code', 'like','%'.$search_division.'%');
            // }
            if($search_department != "all" && $search_department != ""){
                $total_Monthly->where('tb_employee.department_code', 'like','%'.$search_department.'%');
            }
            if($search_section != "all" && $search_section != ""){
                $total_Monthly->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                    $total_Monthly->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
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
                $total_Monthly = $total_Monthly->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
            }
            // if($search_grade != "all" && $search_grade != ""){
            //     $total_Monthly->where('tb_employee_final_score.grade_proposed',$search_grade);
            // }
            if($search_status != "all" && $search_status != ""){
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
            $total_Monthly = $total_Monthly->first();

        if($total_Monthly->current_salary_wage_month){
            if($total_Monthly->current_salary_wage_month > 0){
                $cal = ((($total_Monthly->company_suggested_new_basic?$total_Monthly->company_suggested_new_basic:0)/($total_Monthly->current_salary_wage_month?$total_Monthly->current_salary_wage_month:0))-1)*100;
                $total_Monthly->company_suggested_percent = $cal;
            }
        }else{
            $total_Monthly->company_suggested_percent = 0.00;
        }
        // dd($gatall);
        // exit;
        






























































































        // if($search_month_day == "all" || $search_month_day == "2"){
        $gatall_2 = DB::table('tb_employee_final_score')
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
            $gatall_2->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $gatall_2->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $gatall_2->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        $gatall_2->where('tb_employee_final_score.salary_type','Monthly');
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checka_2 = strpos($orisoft_all_code->division_code,',');
                $arr_division_code_2 = [];
                if($checka_2 >= 0){
                    $ex_2 = explode(',',$orisoft_all_code->division_code);
                    if(count($ex_2)>0){
                        foreach ($ex_2 as $value) {
                            array_push($arr_division_code_2,$value);
                        }
                    }
                }else{
                    array_push($arr_division_code_2,$orisoft_all_code->division_code);
                }
                $gatall_2 = $gatall_2->whereIn('tb_employee.division_code',$arr_division_code_2);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_code_2 = [];
                $checka_2 = strpos($orisoft_all_code->department_code,',');
                if($checka_2 >= 0){
                    $ex_2 = explode(',',$orisoft_all_code->department_code);
                    if(count($ex_2)>0){
                        foreach ($ex_2 as $value) {
                            array_push($arr_department_code_2,$value);
                        }
                    }
                }else{
                    array_push($arr_department_code_2,$orisoft_all_code->department_code);
                }
                $gatall_2 = $gatall_2->whereIn('tb_employee.department_code',$arr_department_code_2);
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
                $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_2 = [];
                $countsection_2 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_2 = $countsection_2->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_2)>0){
                    foreach ($countsection_2 as $value) {
                        array_push($arr_countsection_2,$value->division_code);
                    }
                }
                $gatall_2 = $gatall_2->whereIn('tb_employee.division_code',$arr_countsection_2);
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_countsection);
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.division_code',$arr_division_code);
                    
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
                        $gatall_2 = $gatall_2->whereIn('tb_employee.department_code',$arr_department_code);
                    
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
                    $gatall_2 = $gatall_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $gatall_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $gatall_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_gatall_2 = [];
            $checka_gatall_2 = strpos($search_division,',');
            if($checka_gatall_2 >= 0){
                $ex_gatall_2 = explode(',',$search_division);
                if(count($ex_gatall_2)>0){
                    foreach ($ex_gatall_2 as $value) {
                        array_push($arr_search_division_gatall_2,$value);
                    }
                }
            }else{
                array_push($arr_search_division_gatall_2,$search_division);
            }
            if(count($arr_search_division_gatall_2) > 0){
                $gatall_2->whereIn('tb_employee.division_code', $arr_search_division_gatall_2);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $gatall_2->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $gatall_2->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $gatall_2->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                $gatall_2->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $gatall_2->where('tb_employee_final_score.salary_type','Monthly');
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $gatall_2 = $gatall_2->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $gatall_2->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $gatall_2->where('tb_employee_final_score.status_salary','0');
            }else{
                $gatall_2->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $gatall_2->where('tb_employee.position_description','like','%Manager%');
            }else{
                $gatall_2->where('tb_employee.position_description','not like','%Manager%');
            }
        }

        $gatall_2->orderBy('tb_employee_final_score.evaluator_no', 'ASC')
        ->orderBy('tb_employee_final_score.total_score', 'DESC');
        $gatall_2 = $gatall_2->get();
        

        ///////////////////////////////////

        $nooo_2 = 1;
        $finaldmgm_hide_3 = 0;
        if(count($gatall_2)>0){
            foreach ($gatall_2 as $key => $value) {
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
                    $finaldmgm_hide_3 += $value->final_by_md_gm_amount;
                }
                $pa_grade_2 = $value->pa_grade;
                $adjustg_2 = $value->adjust_grade;
                $current_2 = 0;
                $total_day_2 = $value->attendance_sl+$value->attendance_pl+$value->attendance_late+$value->attendance_abt+$value->attendance_abs;
                $current_2 = $value->salary_old;
                if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                    $l800avg_wage_2 = $value->l800avg_wage;
                }else{
                    $l800avg_wage_2 = '';
                }
                $bsalary_wage_2 = 0;
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_2 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_2 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        if($value->l800avg_wage != "" && $value->l800avg_wage != "0.00"){
                            $bsalary_wage_2 = $value->l800avg_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }else{
                        if($value->bsalary_wage){
                            $bsalary_wage_2 = $value->bsalary_wage;
                        }else{
                            $bsalary_wage_2 = $current_2;
                        }
                    }
                }
                
                $salary_month_old_2 = $value->salary_month_old;
                if($value->grade_code == 'L800'){
                    $salary_month_old_2 = (float)$bsalary_wage_2*26;
                }
                $company_suggested_per_2 = $value->company_suggested_per;
                $percent_proposed_old_2 = $value->percent_proposed_old;
                $countbudget_2 = DB::table('tb_budget_action')
                            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                            ->where('tb_budget.year',$previousYear)->count();
                if($countbudget_2 > 0){
                    if($value->adjust_grade){
                        $databudget_2 = DB::table('tb_budget_action')
                        ->select('tb_budget_action.std')
                        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        ->where('tb_budget_action.grade_name',$value->adjust_grade)
                        ->where('tb_budget.year',$previousYear)->first();
                        $company_suggested_per_2 = $databudget_2->std;
                        $percent_proposed_old_2 = $databudget_2->std;
                    }
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1_2 = $value->service_days/365;
                }else{
                    $service_days1_2 = $value->service_days/365;
                };
                $service_days2_2 = $service_days1_2;
                
                $company_suggestged_amount_2 = $bsalary_wage_2*($company_suggested_per_2/100)*$service_days2_2;
                $company_suggestged_new_basic_2 = $value->company_suggestged_new_basic;
                if($value->grade_code == 'L800'){
                    $company_suggestged_new_basic_2 = round($company_suggestged_amount_2+$current_2);
                }else{
                    $company_suggestged_new_basic_2 = round($company_suggestged_amount_2+$bsalary_wage_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                }
                $value->company_suggestged_new_basic = $company_suggestged_new_basic_2;
                $amount_proposed_2 = $value->amount_proposed;
                if($bsalary_wage_2 > 0){
                    if($value->percent_proposed >= 0){
                        $amount_proposed_2 = $bsalary_wage_2*($value->percent_proposed/100)*$service_days2_2;
                    }else{
                        $amount_proposed_2 = $bsalary_wage_2*($percent_proposed_old_2/100)*$service_days2_2;
                    }
                }
                if($search_month_day != "all"){
                    if($search_month_day == "1"){
                        $salary_new_2 = round($amount_proposed_2+$current_2);
                    }else{
                        $salary_new_2 = round($amount_proposed_2+$current_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }else{
                    if($value->grade_code == 'L800'){
                        $salary_new_2 = round($amount_proposed_2+$current_2);
                    }else{
                        $salary_new_2 = round($amount_proposed_2+$current_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                    }
                }
                
                $salary_month_new_2 = ($value->salary_month_new?$value->salary_month_new:0);
                if($salary_new_2 > 0){
                    if($search_month_day != "all"){
                        if($search_month_day == "1"){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_2 = $salary_new_2*27.5;
                                $salary_month_new_2 = round($salary_month_newx_2,-1);
                            }else{
                                if($value->grade_code == 'L800'){
                                    $salary_month_new_2 = round($salary_new_2)*26;
                                }else{
                                    $salary_month_new_2 = round($salary_new_2);
                                }
                            }
                        }else{
                            $salary_month_new_2 = round($salary_new_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }else{
                        if($value->grade_code == 'L800'){
                            if($value->grade_proposed == 'CD'){
                                $salary_month_newx_2 = $salary_new_2*27.5;
                                $salary_month_new_2 = round($salary_month_newx_2,-1);
                            }else{
                                $salary_month_new_2 = round($salary_new_2)*26;
                            }
                        }else{
                            $salary_month_new_2 = round($salary_new_2,(trans(request()->segment(1)) == 'manager'?-2:-1));
                        }
                    }
                }
                
                $date_formatted_2 = '';
                if($value->date_joined){
                    $date_joined_old_2 = $value->date_joined;
                    $date_formatted_2 = date("Y-m-d", strtotime($date_joined_old_2));
                }
                if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                    if($value->service_days > 365){
                        $value->service_days = 365;
                    }
                    $service_days1 = $value->service_days/365;
                }else{
                    $service_days1 = $value->service_days/365;
                }
                
                $service_days2_2 = $service_days1;

                $data_2[] = array(
                    "id" =>  $nooo_2,
                    "code"=> $value->orisoft_no,
                    "name"=> (Session::get('locale') == "th" ?$value->employee_local_name_th:$value->employee_local_name_en),
                    "position"=> $value->position_description,
                    "group"=> "",
                    "joindate"=> $date_formatted_2,
                    "serviced"=> $value->service_days,
                    "sl"=> ($value->attendance_sl>0?number_format($value->attendance_sl,1):'0.0'),
                    "pl"=> ($value->attendance_pl>0?number_format($value->attendance_pl,1):'0.0'),
                    "latet"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "lated"=> ($value->attendance_late>0?number_format($value->attendance_late,1):'0.0'),
                    "abst"=> ($value->attendance_abt>0?number_format($value->attendance_abt,1):'0.0'),
                    "absd"=> ($value->attendance_abs>0?number_format($value->attendance_abs,1):'0.0'),
                    "ol"=> ($value->attendance_ol>0?number_format($value->attendance_ol,1):'0.0'),
                    "totald"=> ($total_day_2>0?number_format($total_day_2,1):'0.0'),
                    "verbal"=> ($value->attendance_vwar>0?number_format($value->attendance_vwar,1):'0.0'),
                    "written"=> ($value->attendance_wwar>0?number_format($value->attendance_wwar,1):'0.0'),
                    "susd"=> ($value->attendance_sus>0?number_format($value->attendance_sus,1):'0.0'),
                    "pa1"=> ($value->adjust_grade_old1?$value->adjust_grade_old1:'-'),
                    "pa2"=> ($value->adjust_grade_old2?$value->adjust_grade_old2:'-'),
                    "pa3"=> ($value->adjust_grade_old3?$value->adjust_grade_old3:'-'),
                    "form"=> $value->form_import,
                    "evaluator"=> (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "total"=> ($value->total_score>0?number_format($value->total_score,2):'0.00'),
                    "theoryg"=> $pa_grade_2,
                    "adjustg"=> $adjustg_2,
                    "current"=> ($current_2>0?number_format($current_2,2):''),
                    
                    "l800avg_gmdm"=> ($l800avg_wage_2>0?number_format($l800avg_wage_2,2):''),
                    "bsalaryw"=> ($bsalary_wage_2>0?number_format($bsalary_wage_2,2):''),
                    "cbsalaryw"=> ($salary_month_old_2>0?number_format($salary_month_old_2,2):''),
                    "comsugpct"=> ($company_suggested_per_2>0?number_format($company_suggested_per_2,2):0.00),
                    "comsugamt"=> ($company_suggestged_amount_2>0?number_format($company_suggestged_amount_2,2):0.00),
                    "companynewb"=> ($company_suggestged_new_basic_2>0?number_format($company_suggestged_new_basic_2,2):0.00),
                    
                    "gmgr_span2"=> ($value->grade_proposed?$value->grade_proposed:($value->adjust_grade?$value->adjust_grade:'-')),
                    
                    
                    "incpctmgr_span"=> ($value->percent_proposed>=0?number_format($value->percent_proposed,4,'.',''):number_format($percent_proposed_old_2,4,'.','')),
                    
                    "incamount"=> ($amount_proposed_2>0?number_format($amount_proposed_2,2):''),
                    "newbwage"=> ($salary_new_2>0?number_format($salary_new_2,2):''),
                    "newbsalary"=> ($salary_month_new_2>0?number_format($salary_month_new_2,2):''),
                    "finaldmgm"=> ($value->status_salary=='1'?($value->final_by_md_gm_amount>0?number_format($value->final_by_md_gm_amount,2):($salary_month_new>0?number_format($salary_month_new,2):'')):''),
                    "remark_view"=> $value->remark_grade,
                    
                    
                    
                    "division_code"=> $value->division_code,
                    "department_code"=> $value->department_code,
                    "section_code"=> $value->section_code,
                    "grade_code"=> $value->grade_code,
                    "status_salary"=>$status_salary
                ); 
                $nooo_2++;
            }
        }else{
            $data_2 = [];
        }
        $countdata_2 = DB::table('tb_employee_final_score')
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
            $countdata_2->where('tb_employee_final_score.freeze_to_approve_hr', '1');
        }else{
            if($pagenow == "2"){
                $countdata_2->where('tb_employee_final_score.freeze_to_gmdm', '1');
            }else{
                $countdata_2->where('tb_employee_final_score.freeze_to_pagrade', '1');
            }
        }
        // if($search_month_day != "all"){
        //     if($search_month_day == "1"){
        //         $countdata_2->where('tb_employee_final_score.salary_type','Daily');
        //     }
        //     if($search_month_day == "2"){
        //         $countdata_2->where('tb_employee_final_score.salary_type','Monthly');
        //     }
        // }
        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
                $checkacountdata_2 = strpos($orisoft_all_code->division_code,',');
                $arr_division_codecountdata_2 = [];
                if($checkacountdata_2 >= 0){
                    $excountdata_2 = explode(',',$orisoft_all_code->division_code);
                    if(count($excountdata_2)>0){
                        foreach ($excountdata_2 as $value) {
                            array_push($arr_division_codecountdata_2,$value);
                        }
                    }
                }else{
                    array_push($arr_division_codecountdata_2,$orisoft_all_code->division_code);
                }
                $countdata_2 = $countdata_2->whereIn('tb_employee.division_code',$arr_division_codecountdata_2);
            }

            if($search_department == "all" || $search_department == ""){
                $arr_department_codecountdata_2 = [];
                $checkacountdata_2 = strpos($orisoft_all_code->department_code,',');
                if($checkacountdata_2 >= 0){
                    $excountdata_2 = explode(',',$orisoft_all_code->department_code);
                    if(count($excountdata_2)>0){
                        foreach ($excountdata_2 as $value) {
                            array_push($arr_department_codecountdata_2,$value);
                        }
                    }
                }else{
                    array_push($arr_department_codecountdata_2,$orisoft_all_code->department_code);
                }
                $countdata_2 = $countdata_2->whereIn('tb_employee.department_code',$arr_department_codecountdata_2);
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
                $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            }
        }

        if($orisoft_code == "000002"){
            if($search_division == "all" || $search_division == ""){
                $arr_countsection_2 = [];
                $countsection_2 = DB::table('tb_percent_department_action')
                ->select('tb_percent_department_action.division_code')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                ->where('tb_percent_department_action.approve_by2','000002');
                $countsection_2 = $countsection_2->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                if(count($countsection_2)>0){
                    foreach ($countsection_2 as $value) {
                        array_push($arr_countsection_2,$value->division_code);
                    }
                }
                $countdata_2 = $countdata_2->whereIn('tb_employee.division_code',$arr_countsection_2);
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_countsection);
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.division_code',$arr_division_code);
                    
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
                        $countdata_2 = $countdata_2->whereIn('tb_employee.department_code',$arr_department_code);
                    
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
                    $countdata_2 = $countdata_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $countdata_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $countdata_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_countdata_2 = [];
            $checka_countdata_2 = strpos($search_division,',');
            if($checka_countdata_2 >= 0){
                $ex_countdata_2 = explode(',',$search_division);
                if(count($ex_countdata_2)>0){
                    foreach ($ex_countdata_2 as $value) {
                        array_push($arr_search_division_countdata_2,$value);
                    }
                }
            }else{
                array_push($arr_search_division_countdata_2,$search_division);
            }
            if(count($arr_search_division_countdata_2) > 0){
                $countdata_2->whereIn('tb_employee.division_code', $arr_search_division_countdata_2);
            }
        }
        // if($search_division != "all"){
        //     $countdata_2->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $countdata_2->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $countdata_2->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                $countdata_2->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $countdata_2->where('tb_employee_final_score.salary_type','Monthly');
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $countdata_2 = $countdata_2->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $countdata_2->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
            if($search_status == "-1"){
                $countdata_2->where('tb_employee_final_score.status_salary','0');
            }else{
                $countdata_2->where('tb_employee_final_score.status_salary',$search_status);
            }
        }
        if($search_group != "all" && $search_group != ""){
            if($search_group == "1"){
                $countdata_2->where('tb_employee.position_description','like','%Manager%');
            }else{
                $countdata_2->where('tb_employee.position_description','not like','%Manager%');
            }
        }
        $countdata_2 = $countdata_2->get();
        // dd($countdata_2);
        // exit;
        $countA_2 = 0;
        $countB_2 = 0;
        $countC_2 = 0;
        $countD_2 = 0;
        $countE_2 = 0;
        $countNoNull_2 = 0;

        $proposed_countAR_2 = 0;
        $proposed_countP_2 = 0;
        $proposed_countA_2 = 0;
        $proposed_countB_2 = 0;
        $proposed_countC_2 = 0;
        $proposed_countD_2 = 0;
        $proposed_countE_2 = 0;
        $proposed_countU_2 = 0;
        $proposed_countCD_2 = 0;
        $proposed_countNoNull_2 = 0;
        

        // dd($countdata_2);
        // exit;

        
        
        if(count($countdata_2)>0){
            foreach ($countdata_2 as $key => $value) {
                if($value->adjust_grade == 'A'){
                    $countA_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'B'){
                    $countB_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'C'){
                    $countC_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'D'){
                    $countD_2++;
                    $countNoNull_2++;
                }
                if($value->adjust_grade == 'E'){
                    $countE_2++;
                    $countNoNull_2++;
                }
    
                ///////////
    
                if($value->grade_proposed == 'AR'){
                    $proposed_countAR_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'P'){
                    $proposed_countP_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'A'){
                    $proposed_countA_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'B'){
                    $proposed_countB_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'C'){
                    $proposed_countC_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'D'){
                    $proposed_countD_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'E'){
                    $proposed_countE_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'U'){
                    $proposed_countU_2++;
                    $proposed_countNoNull_2++;
                }
                if($value->grade_proposed == 'CD'){
                    $proposed_countCD_2++;
                    $proposed_countNoNull_2++;
                }
            }
        }
        
        $sheet3->setCellValue('AI2', $countNoNull_2);
        $sheet3->setCellValue('AI4', $countA_2);
        $sheet3->setCellValue('AI5', $countB_2);
        $sheet3->setCellValue('AI6', $countC_2);
        $sheet3->setCellValue('AI7', $countD_2);
        $sheet3->setCellValue('AI8', $countE_2);
        
        
        $sumA_2 = 0;
        $sumB_2 = 0;
        $sumC_2 = 0;
        $sumD_2 = 0;
        $sumE_2 = 0;
        $bell_curve_2 = DB::table('tb_grade_action')
        ->select('tb_grade_action.*')
        ->leftJoin('tb_grade','tb_grade.id','=','tb_grade_action.grade_id')
        ->where('tb_grade.year',$previousYear)
        ->orderBy('tb_grade_action.id', 'ASC')->get();
        foreach ($bell_curve_2 as $key1 => $value1) {
            $percent_2 = $value1->percent/100;
            if($value1->grade_name == "A"){
                $sumA_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH4', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "B"){
                $sumB_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH5', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "C"){
                $sumC_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH6', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "D"){
                $sumD_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH7', ($percent_2?$percent_2:0));
            }
            if($value1->grade_name == "E"){
                $sumE_2 = ($countNoNull_2*$value1->percent)/100;
                $sheet3->setCellValue('AH8', ($percent_2?$percent_2:0));
            }
        }
        $sumAll_2 = $sumA_2+$sumB_2+$sumC_2+$sumD_2+$sumE_2;
        $sheet3->setCellValue('AH2', $sumAll_2);
        // dd($sumA);
        // exit;
        $sheet3->setCellValue('AI2', $sumAll_2);
        $sheet3->setCellValue('AI4', $sumA_2);
        $sheet3->setCellValue('AI5', $sumB_2);
        $sheet3->setCellValue('AI6', $sumC_2);
        $sheet3->setCellValue('AI7', $sumD_2);
        $sheet3->setCellValue('AI8', $sumE_2);
        ////////

        $proposed_sumAR_2 = ($proposed_countAR_2/$proposed_countNoNull_2)*100;
        $proposed_sumP_2 = ($proposed_countP_2/$proposed_countNoNull_2)*100;
        $proposed_sumA_2 = ($proposed_countA_2/$proposed_countNoNull_2)*100;
        $proposed_sumB_2 = ($proposed_countB_2/$proposed_countNoNull_2)*100;
        $proposed_sumC_2 = ($proposed_countC_2/$proposed_countNoNull_2)*100;
        $proposed_sumD_2 = ($proposed_countD_2/$proposed_countNoNull_2)*100;
        $proposed_sumE_2 = ($proposed_countE_2/$proposed_countNoNull_2)*100;
        $proposed_sumU_2 = ($proposed_countU_2/$proposed_countNoNull_2)*100;
        $proposed_sumCD_2 = ($proposed_countCD_2/$proposed_countNoNull_2)*100;

        $sheet3->setCellValue('AQ2', $proposed_countAR_2);
        $sheet3->setCellValue('AQ3', $proposed_countP_2);
        $sheet3->setCellValue('AQ4', $proposed_countA_2);
        $sheet3->setCellValue('AQ5', $proposed_countB_2);
        $sheet3->setCellValue('AQ6', $proposed_countC_2);
        $sheet3->setCellValue('AQ7', $proposed_countD_2);
        $sheet3->setCellValue('AQ8', $proposed_countE_2);
        $sheet3->setCellValue('AQ9', $proposed_countU_2);
        $sheet3->setCellValue('AQ10', $proposed_countCD_2);
        $sheet3->setCellValue('AQ1', $proposed_countNoNull_2);

        $sheet3->setCellValue('AR2', ($proposed_sumAR_2?number_format($proposed_sumAR_2/100,2):0));
        $sheet3->setCellValue('AR3', ($proposed_sumP_2?number_format($proposed_sumP_2/100,2):0));
        $sheet3->setCellValue('AR4', ($proposed_sumA_2?number_format($proposed_sumA_2/100,2):0));
        $sheet3->setCellValue('AR5', ($proposed_sumB_2?number_format($proposed_sumB_2/100,2):0));
        $sheet3->setCellValue('AR6', ($proposed_sumC_2?number_format($proposed_sumC_2/100,2):0));
        $sheet3->setCellValue('AR7', ($proposed_sumD_2?number_format($proposed_sumD_2/100,2):0));
        $sheet3->setCellValue('AR8', ($proposed_sumE_2?number_format($proposed_sumE_2/100,2):0));
        $sheet3->setCellValue('AR9', ($proposed_sumU_2?number_format($proposed_sumU_2/100,2):0));
        $sheet3->setCellValue('AR10', ($proposed_sumCD_2?number_format($proposed_sumCD_2/100,2):0));


        $budget_2 = DB::table('tb_budget_action')
        ->select('tb_budget_action.*')
        ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
        ->where('tb_budget.year',$previousYear)
        ->orderBy('tb_budget_action.id', 'ASC')->get();
        if(count($budget_2)>0){
            foreach ($budget_2 as $key => $value1) {
                if($value1->grade_name == "AR"){
                    $sheet3->setCellValue('AL2', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM2', $value1->grade_name);
                    $sheet3->setCellValue('AN2', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "P"){
                    $sheet3->setCellValue('AL3', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM3', $value1->grade_name);
                    $sheet3->setCellValue('AN3', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "A"){
                    $sheet3->setCellValue('AL4', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM4', $value1->grade_name);
                    $sheet3->setCellValue('AN4', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "B"){
                    $sheet3->setCellValue('AL5', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM5', $value1->grade_name);
                    $sheet3->setCellValue('AN5', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "C"){
                    $sheet3->setCellValue('AL6', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM6', $value1->grade_name);
                    $sheet3->setCellValue('AN6', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "D"){
                    $sheet3->setCellValue('AL7', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM7', $value1->grade_name);
                    $sheet3->setCellValue('AN7', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "E"){
                    $sheet3->setCellValue('AL8', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM8', $value1->grade_name);
                    $sheet3->setCellValue('AN8', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "U"){
                    $sheet3->setCellValue('AL9', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM9', $value1->grade_name);
                    $sheet3->setCellValue('AN9', ($value1->std?number_format($value1->std/100,2):0));
                }
                if($value1->grade_name == "CD"){
                    $sheet3->setCellValue('AL10', ($value1->budget_range_start?$value1->budget_range_start.'%':'').' - '.($value1->budget_range_end?$value1->budget_range_end.'%':''));
                    $sheet3->setCellValue('AM10', $value1->grade_name);
                    $sheet3->setCellValue('AN10', ($value1->std?number_format($value1->std/100,2):0));
                }
            }
        }

        if($search_section != "all" && $search_section != ""){
            $percent_department_2 = DB::table('tb_percent_department_action')
            ->select('tb_percent_department_action.*')
            ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
            ->where('tb_percent_department.year',$previousYear)
            ->where('tb_percent_department_action.section_code', 'like','%'.$search_section.'%')
            ->orderBy('tb_percent_department_action.id', 'ASC')->first();
            $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));

            $sheet3->setCellValue('AU2', ($percent_department_2->percent_monthly?($percent_department_2->percent_monthly/100):0));
        }else{
            if($search_department != "all" && $search_department != ""){
                $percent_department_2 = DB::table('tb_percent_department_action')
                ->select( 
                    DB::raw('SUM(percent_daily) AS percent_daily'),
                    DB::raw('SUM(percent_monthly) AS percent_monthly')
                )  
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year',$previousYear)
                ->where('tb_percent_department_action.department_code', 'like','%'.$search_department.'%')
                ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));
    
                $sheet3->setCellValue('AU2', ($percent_department_2->percent_monthly?($percent_department_2->percent_monthly/100):0));
            }else{
                if($search_division != "all" && $search_division != ""){
                    if($search_division){
                        $arr_search_division_percent_department_2 = [];
                        $checka_percent_department_2 = strpos($search_division,',');
                        if($checka_percent_department_2 >= 0){
                            $ex_percent_department_2 = explode(',',$search_division);
                            if(count($ex_percent_department_2)>0){
                                foreach ($ex_percent_department_2 as $value) {
                                    array_push($arr_search_division_percent_department_2,$value);
                                }
                            }
                        }else{
                            array_push($arr_search_division_percent_department_2,$search_division);
                        }
                    }
                    $percent_department_2 = DB::table('tb_percent_department_action')
                    ->select( 
                        DB::raw('SUM(percent_daily) AS percent_daily'),
                        DB::raw('SUM(percent_monthly) AS percent_monthly')
                    )  
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year',$previousYear)
                    ->whereIn('tb_percent_department_action.division_code', $arr_search_division_percent_department_2)
                    ->orderBy('tb_percent_department_action.id', 'ASC')->first();
                    $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));
        
                    $sheet3->setCellValue('AU2', ($percent_department_2->percent_monthly?($percent_department_2->percent_monthly/100):0));
                }else{
                    $sheet3->setCellValue('AV2', 'Approved Budget '.date('Y'));
                }
            }
        }
        
        

        $total_Monthly_2 = DB::table('tb_employee_final_score')
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
                $total_Monthly_2->where('tb_employee_final_score.freeze_to_approve_hr', '1');
            }else{
                if($pagenow == "2"){
                    $total_Monthly_2->where('tb_employee_final_score.freeze_to_gmdm', '1');
                }else{
                    $total_Monthly_2->where('tb_employee_final_score.freeze_to_pagrade', '1');
                }
            }

            if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
                if($search_division == "all" || $search_division == ""){
                    $checkatotal_Monthly_2 = strpos($orisoft_all_code->division_code,',');
                    $arr_division_codetotal_Monthly_2 = [];
                    if($checkatotal_Monthly_2 >= 0){
                        $extotal_Monthly_2 = explode(',',$orisoft_all_code->division_code);
                        if(count($extotal_Monthly_2)>0){
                            foreach ($extotal_Monthly_2 as $value) {
                                array_push($arr_division_codetotal_Monthly_2,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_codetotal_Monthly_2,$orisoft_all_code->division_code);
                    }
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.division_code',$arr_division_codetotal_Monthly_2);
                }
        
                if($search_department == "all" || $search_department == ""){
                    $arr_department_codetotal_Monthly_2 = [];
                    $checkatotal_Monthly_2 = strpos($orisoft_all_code->department_code,',');
                    if($checkatotal_Monthly_2 >= 0){
                        $extotal_Monthly_2 = explode(',',$orisoft_all_code->department_code);
                        if(count($extotal_Monthly_2)>0){
                            foreach ($extotal_Monthly_2 as $value) {
                                array_push($arr_department_codetotal_Monthly_2,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_codetotal_Monthly_2,$orisoft_all_code->department_code);
                    }
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.department_code',$arr_department_codetotal_Monthly_2);
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
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
            }

            if($orisoft_code == "000002"){
                if($search_division == "all" || $search_division == ""){
                    $arr_countsection_2 = [];
                    $countsection_2 = DB::table('tb_percent_department_action')
                    ->select('tb_percent_department_action.division_code')
                    ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                    ->where('tb_percent_department.year','like','%'.$previousYear.'%')
                    ->where('tb_percent_department_action.approve_by2','000002');
                    $countsection_2 = $countsection_2->groupBy('division_code')->orderBy('division_code', 'ASC')->get();
                    if(count($countsection_2)>0){
                        foreach ($countsection_2 as $value) {
                            array_push($arr_countsection_2,$value->division_code);
                        }
                    }
                    $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.division_code',$arr_countsection_2);
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_countsection);
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_countsection);
                    }
                }
                
            }
            if(trans(request()->segment(1)) == 'manager'){
                if($orisoft_code == "000002"){
                    $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                }else if($orisoft_code == "990002"){
                
                }else{
                    $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($orisoft_code == "000002"){
                    // $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.division_code',$arr_division_code);
                        
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
                            $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.department_code',$arr_department_code);
                        
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
                        $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                    }
                    // $total_Monthly_2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                    $total_Monthly_2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
                }
            }else{
    
            }
            if($search_division != "all" && $search_division != ""){
                $arr_search_division_total_Monthly_2 = [];
                $checka_total_Monthly_2 = strpos($search_division,',');
                if($checka_total_Monthly_2 >= 0){
                    $ex_total_Monthly_2 = explode(',',$search_division);
                    if(count($ex_total_Monthly_2)>0){
                        foreach ($ex_total_Monthly_2 as $value) {
                            array_push($arr_search_division_total_Monthly_2,$value);
                        }
                    }
                }else{
                    array_push($arr_search_division_total_Monthly_2,$search_division);
                }
                if(count($arr_search_division_total_Monthly_2) > 0){
                    $total_Monthly_2->whereIn('tb_employee.division_code', $arr_search_division_total_Monthly_2);
                }
            }
            // if($search_division != "all"){
            //     $total_Monthly_2->where('tb_employee.division_code', 'like','%'.$search_division.'%');
            // }
            if($search_department != "all" && $search_department != ""){
                $total_Monthly_2->where('tb_employee.department_code', 'like','%'.$search_department.'%');
            }
            if($search_section != "all" && $search_section != ""){
                $total_Monthly_2->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                    $total_Monthly_2->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
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
                $total_Monthly_2 = $total_Monthly_2->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
            }
            // if($search_grade != "all" && $search_grade != ""){
            //     $total_Monthly_2->where('tb_employee_final_score.grade_proposed',$search_grade);
            // }
            if($search_status != "all" && $search_status != ""){
                if($search_status == "-1"){
                    $total_Monthly_2->where('tb_employee_final_score.status_salary','0');
                }else{
                    $total_Monthly_2->where('tb_employee_final_score.status_salary',$search_status);
                }
            }
            if($search_group != "all" && $search_group != ""){
                if($search_group == "1"){
                    $total_Monthly_2->where('tb_employee.position_description','like','%Manager%');
                }else{
                    $total_Monthly_2->where('tb_employee.position_description','not like','%Manager%');
                }
            }
        $total_Monthly_2 = $total_Monthly_2->first();
        
        if($total_Monthly_2->current_salary_wage_month){
            if($total_Monthly_2->current_salary_wage_month > 0){
                $cal_2 = ((($total_Monthly_2->company_suggested_new_basic?$total_Monthly_2->company_suggested_new_basic:0)/($total_Monthly_2->current_salary_wage_month?$total_Monthly_2->current_salary_wage_month:0))-1)*100;
                $total_Monthly_2->company_suggested_percent = $cal_2;
            }
        }else{
            $total_Monthly_2->company_suggested_percent = 0.00;
        }
        if($total_Monthly_2->new_salary_wage_month > 0){
            $cal_month_2 = ((($total_Monthly_2->new_salary_wage_month/$total_Monthly_2->current_salary_wage_month-1)*100)* 1000)/ 1000;
        }else{
            $cal_month_2 = 0;
        }
        $cal_all_2 = $cal_month_2;
        
        // dd($cal_month_2);
        // exit;
        $sheet3->setCellValue('AU1', ($cal_month_2?$cal_month_2/100:0));



        $numrow_2 = 13;
        $final_score = [];
        if(count($data_2)>0){
            foreach ($data_2 as $key => $value) {
                
                $date1_2 = $value['joindate'];
                $date2_2 = date('Y')."-01-31";

                $diff_2 = abs(strtotime($date2_2) - strtotime($date1_2));

                $years_2 = floor($diff_2 / (365*60*60*24));
                $months_2 = floor(($diff_2 - $years_2 * 365*60*60*24) / (30*60*60*24));
                $days_2 = floor(($diff_2 - $years_2 * 365*60*60*24 - $months_2*30*60*60*24)/ (60*60*24));

                // printf("%d years, %d months, %d days\n", $years, $months, $days);
                // exit;
                if($value['pa1'] == "AR"){
                    $bg_color_pa1_2 = 'FFFFFF';
                }else if($value['pa1'] == "P"){
                    $bg_color_pa1_2 = 'FFFFFF';
                }else if($value['pa1'] == "A"){
                    $bg_color_pa1_2 = '9FCE63';
                }else if($value['pa1'] == "B"){
                    $bg_color_pa1_2 = 'BFDDE7';
                }else if($value['pa1'] == "C"){
                    $bg_color_pa1_2 = 'DAE4C0';
                }else if($value['pa1'] == "D"){
                    $bg_color_pa1_2 = 'FFFFD1';
                }else if($value['pa1'] == "E"){
                    $bg_color_pa1_2 = 'DFBAB8';
                }else if($value['pa1'] == "U"){
                    $bg_color_pa1_2 = 'FFFFFF';
                }else{
                    $bg_color_pa1_2 = 'FFFFFF';
                }
                if($value['pa2'] == "AR"){
                    $bg_color_pa2_2 = 'FFFFFF';
                }else if($value['pa2'] == "P"){
                    $bg_color_pa2_2 = 'FFFFFF';
                }else if($value['pa2'] == "A"){
                    $bg_color_pa2_2 = '9FCE63';
                }else if($value['pa2'] == "B"){
                    $bg_color_pa2_2 = 'BFDDE7';
                }else if($value['pa2'] == "C"){
                    $bg_color_pa2_2 = 'DAE4C0';
                }else if($value['pa2'] == "D"){
                    $bg_color_pa2_2 = 'FFFFD1';
                }else if($value['pa2'] == "E"){
                    $bg_color_pa2_2 = 'DFBAB8';
                }else if($value['pa2'] == "U"){
                    $bg_color_pa2_2 = 'FFFFFF';
                }else{
                    $bg_color_pa2_2 = 'FFFFFF';
                }

                if($value['pa3'] == "AR"){
                    $bg_color_pa3_2 = 'FFFFFF';
                }else if($value['pa3'] == "P"){
                    $bg_color_pa3_2 = 'FFFFFF';
                }else if($value['pa3'] == "A"){
                    $bg_color_pa3_2 = '9FCE63';
                }else if($value['pa3'] == "B"){
                    $bg_color_pa3_2 = 'BFDDE7';
                }else if($value['pa3'] == "C"){
                    $bg_color_pa3_2 = 'DAE4C0';
                }else if($value['pa3'] == "D"){
                    $bg_color_pa3_2 = 'FFFFD1';
                }else if($value['pa3'] == "E"){
                    $bg_color_pa3_2 = 'DFBAB8';
                }else if($value['pa3'] == "U"){
                    $bg_color_pa3_2 = 'FFFFFF';
                }else{
                    $bg_color_pa3_2 = 'FFFFFF';
                }
                if($value['theoryg'] == "AR"){
                    $bg_color_theoryg_2 = 'FFFFFF';
                }else if($value['theoryg'] == "P"){
                    $bg_color_theoryg_2 = 'FFFFFF';
                }else if($value['theoryg'] == "A"){
                    $bg_color_theoryg_2 = '9FCE63';
                }else if($value['theoryg'] == "B"){
                    $bg_color_theoryg_2 = 'BFDDE7';
                }else if($value['theoryg'] == "C"){
                    $bg_color_theoryg_2 = 'DAE4C0';
                }else if($value['theoryg'] == "D"){
                    $bg_color_theoryg_2 = 'FFFFD1';
                }else if($value['theoryg'] == "E"){
                    $bg_color_theoryg_2 = 'DFBAB8';
                }else if($value['theoryg'] == "U"){
                    $bg_color_theoryg_2 = 'FFFFFF';
                }else{
                    $bg_color_theoryg_2 = 'FFFFFF';
                }
                if($value['adjustg'] == "AR"){
                    $bg_color_adjustg_2 = 'FFFFFF';
                }else if($value['adjustg'] == "P"){
                    $bg_color_adjustg_2 = 'FFFFFF';
                }else if($value['adjustg'] == "A"){
                    $bg_color_adjustg_2 = '9FCE63';
                }else if($value['adjustg'] == "B"){
                    $bg_color_adjustg_2 = 'BFDDE7';
                }else if($value['adjustg'] == "C"){
                    $bg_color_adjustg_2 = 'DAE4C0';
                }else if($value['adjustg'] == "D"){
                    $bg_color_adjustg_2 = 'FFFFD1';
                }else if($value['adjustg'] == "E"){
                    $bg_color_adjustg_2 = 'DFBAB8';
                }else if($value['adjustg'] == "U"){
                    $bg_color_adjustg_2 = 'FFFFFF';
                }else{
                    $bg_color_adjustg_2 = 'FFFFFF';
                }
                if($value['gmgr_span2'] == "AR"){
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "P"){
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }else if($value['gmgr_span2'] == "A"){
                    $bg_color_gmgr_span2_2 = '9FCE63';
                }else if($value['gmgr_span2'] == "B"){
                    $bg_color_gmgr_span2_2 = 'BFDDE7';
                }else if($value['gmgr_span2'] == "C"){
                    $bg_color_gmgr_span2_2 = 'DAE4C0';
                }else if($value['gmgr_span2'] == "D"){
                    $bg_color_gmgr_span2_2 = 'FFFFD1';
                }else if($value['gmgr_span2'] == "E"){
                    $bg_color_gmgr_span2_2 = 'DFBAB8';
                }else if($value['gmgr_span2'] == "U"){
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }else{
                    $bg_color_gmgr_span2_2 = 'FFFFFF';
                }
                
                $bg_color_status_salary_2 = 'f1f1f2';
                if($value['status_salary'] == 'In progress'){
                    $bg_color_status_salary_2 = 'f1f1f2';
                }
                if($value['status_salary'] == 'Reject'){
                    $bg_color_status_salary_2 = 'fff5f8';
                }
                if($value['status_salary'] == 'Approved'){
                    $bg_color_status_salary_2 = 'e8fff3';
                }
                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('A'.$numrow_2.':AX'.$numrow_2)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color('000000'));
                $sheet3->setCellValue('A'.$numrow_2, $value['division_code']);
                $sheet3->setCellValue('B'.$numrow_2, $value['department_code']);
                $sheet3->setCellValue('C'.$numrow_2, $value['section_code']);
                $sheet3->setCellValue('D'.$numrow_2, ($value['grade_code']=='L800'?'Daily':'Monthly'));
                $sheet3->setCellValue('E'.$numrow_2, $value['grade_code']);
                $sheet3->setCellValue('F'.$numrow_2, $value['id']);
                $sheet3->setCellValue('G'.$numrow_2, $value['code']);
                $sheet3->setCellValue('H'.$numrow_2, $value['name']);
                $sheet3->setCellValue('I'.$numrow_2, $value['position']);
                $sheet3->setCellValue('J'.$numrow_2, $value['group']);
                $sheet3->setCellValue('K'.$numrow_2, $value['joindate']);

                $sheet3->setCellValue('L'.$numrow_2, $years_2);
                $sheet3->setCellValue('M'.$numrow_2, $months_2);
                $sheet3->setCellValue('N'.$numrow_2, $days_2);
                
                $sheet3->setCellValue('O'.$numrow_2, $value['serviced']);
                

                $sheet3->setCellValue('P'.$numrow_2, $value['sl']);
                $sheet3->setCellValue('Q'.$numrow_2, $value['pl']);
                $sheet3->setCellValue('R'.$numrow_2, $value['latet']);
                $sheet3->setCellValue('S'.$numrow_2, $value['lated']);
                $sheet3->setCellValue('T'.$numrow_2, $value['abst']);
                $sheet3->setCellValue('U'.$numrow_2, $value['absd']);
                $sheet3->setCellValue('V'.$numrow_2, $value['ol']);
                $sheet3->setCellValue('W'.$numrow_2, $value['totald']);
                $sheet3->setCellValue('X'.$numrow_2, $value['verbal']);
                $sheet3->setCellValue('Y'.$numrow_2, $value['written']);
                $sheet3->setCellValue('Z'.$numrow_2, $value['susd']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AA'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa1_2);
                $sheet3->setCellValue('AA'.$numrow_2, $value['pa1']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AB'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa2_2);
                $sheet3->setCellValue('AB'.$numrow_2, $value['pa2']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AC'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_pa3_2);
                $sheet3->setCellValue('AC'.$numrow_2, $value['pa3']);
                $sheet3->setCellValue('AD'.$numrow_2, $value['form']);
                $sheet3->setCellValue('AE'.$numrow_2, $value['evaluator']);
                $sheet3->setCellValue('AF'.$numrow_2, $value['total']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AG'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_theoryg_2);
                $sheet3->setCellValue('AG'.$numrow_2, $value['theoryg']);
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AH'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_adjustg_2);
                $sheet3->setCellValue('AH'.$numrow_2, $value['adjustg']);
                $sheet3->setCellValue('AI'.$numrow_2, $value['current']);
                $sheet3->setCellValue('AJ'.$numrow_2, $value['l800avg_gmdm']);
                $sheet3->setCellValue('AK'.$numrow_2, $value['bsalaryw']);
                $sheet3->setCellValue('AL'.$numrow_2, $value['cbsalaryw']);
                $sheet3->setCellValue('AM'.$numrow_2, $value['comsugpct']);
                $sheet3->setCellValue('AN'.$numrow_2, $value['comsugamt']);
                $sheet3->setCellValue('AO'.$numrow_2, $value['companynewb']);

                
                $spreadsheet
                ->getSheet(0)
                ->getStyle('AP'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_gmgr_span2_2);
                $sheet3->setCellValue('AP'.$numrow_2, $value['gmgr_span2']);
                $sheet3->setCellValue('AQ'.$numrow_2, $value['incpctmgr_span']);
                $sheet3->setCellValue('AR'.$numrow_2, $value['incamount']);
                $sheet3->setCellValue('AS'.$numrow_2, $value['newbwage']);
                $sheet3->setCellValue('AT'.$numrow_2, $value['newbsalary']);
                $sheet3->setCellValue('AU'.$numrow_2, $value['finaldmgm']);
                $sheet3->setCellValue('AV'.$numrow_2, $value['remark_view']);

                $spreadsheet
                ->getSheet(0)
                ->getStyle('AX'.$numrow_2)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB($bg_color_status_salary_2);
                $sheet3->setCellValue('AX'.$numrow_2, $value['status_salary']);
                $numrow_2++;
            }
        }
        // dd($data_2);
        // exit;
        // }


















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

        if($orisoft_code != "019492" && $orisoft_code != "000060" && $orisoft_code != "000002" && $orisoft_code != "000026" && $orisoft_code != "990002"){
            if($search_division == "all" || $search_division == ""){
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

            if($search_department == "all" || $search_department == ""){
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
                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
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
                $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_countsection);
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_countsection);
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_countsection);
                }
            }
            
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){
                
            }else{
                $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Monthly_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.division_code',$arr_division_code);
                    
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
                        $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.department_code',$arr_department_code);
                    
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
                    $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
                // $total_Monthly_filter->where('tb_employee_final_score.evaluator_no',$orisoft_code);
                $total_Monthly_filter->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($search_division != "all" && $search_division != ""){
            $arr_search_division_total_Monthly_filter = [];
            $checka_total_Monthly_filter = strpos($search_division,',');
            if($checka_total_Monthly_filter >= 0){
                $ex_total_Monthly_filter = explode(',',$search_division);
                if(count($ex_total_Monthly_filter)>0){
                    foreach ($ex_total_Monthly_filter as $value) {
                        array_push($arr_search_division_total_Monthly_filter,$value);
                    }
                }
            }else{
                array_push($arr_search_division_total_Monthly_filter,$search_division);
            }
            if(count($arr_search_division_total_Monthly_filter) > 0){
                $total_Monthly_filter->whereIn('tb_employee.division_code', $arr_search_division_total_Monthly_filter);
            }
        }
        // if($search_division != "all" && $search_division != ""){
        //     $total_Monthly_filter->where('tb_employee.division_code', 'like','%'.$search_division.'%');
        // }
        if($search_department != "all" && $search_department != ""){
            $total_Monthly_filter->where('tb_employee.department_code', 'like','%'.$search_department.'%');
        }
        if($search_section != "all" && $search_section != ""){
            $total_Monthly_filter->where('tb_employee.section_code', 'like','%'.$search_section.'%');
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
                $total_Monthly_filter->whereIn('tb_employee_final_score.evaluator_no', $arr_search_employee_no);
            }
        }
        $total_Monthly_filter->where('tb_employee_final_score.salary_type','Monthly');
        if($search_grade != "all" && $search_grade != ""){
            $arr_search_grade = [];
            $ex_search_grade = explode(',',$search_grade);
            if(count($ex_search_grade)>0){
                foreach ($ex_search_grade as $value) {
                    array_push($arr_search_grade,$value);
                }
            }
            $total_Monthly_filter = $total_Monthly_filter->whereIn('tb_employee_final_score.grade_proposed',$arr_search_grade);
        }
        // if($search_grade != "all" && $search_grade != ""){
        //     $total_Monthly_filter->where('tb_employee_final_score.grade_proposed',$search_grade);
        // }
        if($search_status != "all" && $search_status != ""){
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
        $total_Monthly_filter = $total_Monthly_filter->first();
        
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
        
        $current_salary_wage = 0;
        $company_suggested_new_basic = 0;
        $company_suggested_percent = 0;
        
        $current_salary_wage_month = 0;
        $new_salary_wage_month = 0;
        $inc_percent_proposed = 0;
        
        if($total_Monthly_filter){
            if($total_Monthly_filter->current_salary_wage){
                if($total_Monthly_filter->current_salary_wage > 0){
                    $current_salary_wage = $total_Monthly_filter->current_salary_wage;
                    if($total_Monthly_filter->company_suggested_new_basic){
                        $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
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
                if($total_Monthly_filter->company_suggested_new_basic){
                    $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
                }else{
                    $company_suggested_new_basic = $total_Monthly_filter->company_suggested_new_basic;
                }
                
                if($current_salary_wage > 0){
                    $company_suggested_percent = (($company_suggested_new_basic/$current_salary_wage)-1)*100;
                }else{
                    $company_suggested_percent = 0;
                }
            }
            
            $current_salary_wage_month = $total_Monthly_filter->current_salary_wage_month;
            $new_salary_wage_month = $total_Monthly_filter->new_salary_wage_month;
            if($current_salary_wage_month > 0){
                $inc_percent_proposed = (($new_salary_wage_month/$current_salary_wage_month)-1)*100;
            }else{
                $inc_percent_proposed = 0;
            }
            $total_Daily_Monthly = [
                "current_salary_wage" => $total_Monthly_filter->current_salary_wage,
                "L800_avg_wage_mwa" => $total_Monthly_filter->L800_avg_wage_mwa,
                "salary_wage_calculation" => $total_Monthly_filter->salary_wage_calculation,
                "current_salary_wage_month" => $total_Monthly_filter->current_salary_wage_month,
                "company_suggested_percent" => $company_suggested_percent,
                "company_suggested_amount" => $total_Monthly_filter->company_suggested_amount,
                "company_suggested_new_basic" => $total_Monthly_filter->company_suggested_new_basic,
                "inc_percent_proposed" => $inc_percent_proposed,
                "inc_amount_proposed" => $total_Monthly_filter->inc_amount_proposed,
                "new_basic_wage_proposed" => $total_Monthly_filter->new_basic_wage_proposed,
                "new_salary_wage_month" => $total_Monthly_filter->new_salary_wage_month,
                "final_by_md_gm_amount" => $total_Monthly_filter->final_by_md_gm_amount,
            ];
        }


        
        $numrowNew_3 = $numrow_2+6;

        
        $sheet3->setCellValue('AH'.$numrowNew_3, 'MONTHLY ');
        $sheet3->setCellValue('AI'.$numrowNew_3, ($total_Monthly_filter->current_salary_wage>0?number_format($total_Monthly_filter->current_salary_wage,2):'0.00'));
        $sheet3->setCellValue('AJ'.$numrowNew_3, ($total_Monthly_filter->L800_avg_wage_mwa>0?number_format($total_Monthly_filter->L800_avg_wage_mwa,2):'0.00'));
        $sheet3->setCellValue('AK'.$numrowNew_3, ($total_Monthly_filter->salary_wage_calculation>0?number_format($total_Monthly_filter->salary_wage_calculation,2):'0.00'));
        $sheet3->setCellValue('AL'.$numrowNew_3, ($total_Monthly_filter->current_salary_wage_month>0?number_format($total_Monthly_filter->current_salary_wage_month,2):'0.00'));
        $sheet3->setCellValue('AM'.$numrowNew_3, ($total_Monthly_filter->company_suggested_percent>0?number_format($total_Monthly_filter->company_suggested_percent,2):'0.00'));
        $sheet3->setCellValue('AN'.$numrowNew_3, ($total_Monthly_filter->company_suggested_amount>0?number_format($total_Monthly_filter->company_suggested_amount,2):'0.00'));
        $sheet3->setCellValue('AO'.$numrowNew_3, ($total_Monthly_filter->company_suggested_new_basic>0?number_format($total_Monthly_filter->company_suggested_new_basic,2):'0.00'));
        $sheet3->setCellValue('AQ'.$numrowNew_3, ($total_Monthly_filter->inc_percent_proposed>=0?number_format($total_Monthly_filter->inc_percent_proposed,2):'0.00'));
        $sheet3->setCellValue('AR'.$numrowNew_3, ($total_Monthly_filter->inc_amount_proposed>0?number_format($total_Monthly_filter->inc_amount_proposed,2):'0.00'));
        $sheet3->setCellValue('AS'.$numrowNew_3, ($total_Monthly_filter->new_basic_wage_proposed>0?number_format($total_Monthly_filter->new_basic_wage_proposed,2):'0.00'));
        $sheet3->setCellValue('AT'.$numrowNew_3, ($total_Monthly_filter->new_salary_wage_month>0?number_format($total_Monthly_filter->new_salary_wage_month,2):'0.00'));
        $sheet3->setCellValue('AU'.$numrowNew_3, ($finaldmgm_hide_3>0?number_format($finaldmgm_hide_3,2):''));

        $numrowNew_3 = $numrowNew_3+1;
        
        // $numrowNew_3 = $numrowNew_3+1;
        
        // $sheet3->setCellValue('AH'.$numrowNew_3, 'TOTAL MONTHLY+DAILY ');
        // $sheet3->setCellValue('AI'.$numrowNew_3, ($total_Daily_Monthly['current_salary_wage']>0?number_format($total_Daily_Monthly['current_salary_wage'],2):'0.00'));
        // $sheet3->setCellValue('AJ'.$numrowNew_3, ($total_Daily_Monthly['L800_avg_wage_mwa']>0?number_format($total_Daily_Monthly['L800_avg_wage_mwa'],2):'0.00'));
        // $sheet3->setCellValue('AK'.$numrowNew_3, ($total_Daily_Monthly['salary_wage_calculation']>0?number_format($total_Daily_Monthly['salary_wage_calculation'],2):'0.00'));
        // $sheet3->setCellValue('AL'.$numrowNew_3, ($total_Daily_Monthly['current_salary_wage_month']>0?number_format($total_Daily_Monthly['current_salary_wage_month'],2):'0.00'));
        // $sheet3->setCellValue('AM'.$numrowNew_3, ($total_Daily_Monthly['company_suggested_percent']>0?number_format($total_Daily_Monthly['company_suggested_percent'],2):'0.00'));
        // $sheet3->setCellValue('AN'.$numrowNew_3, ($total_Daily_Monthly['company_suggested_amount']>0?number_format($total_Daily_Monthly['company_suggested_amount'],2):'0.00'));
        // $sheet3->setCellValue('AO'.$numrowNew_3, ($total_Daily_Monthly['company_suggested_new_basic']>0?number_format($total_Daily_Monthly['company_suggested_new_basic'],2):'0.00'));
        // $sheet3->setCellValue('AQ'.$numrowNew_3, ($total_Daily_Monthly['inc_percent_proposed']>0?number_format($total_Daily_Monthly['inc_percent_proposed'],2):'0.00'));
        // $sheet3->setCellValue('AR'.$numrowNew_3, ($total_Daily_Monthly['inc_amount_proposed']>0?number_format($total_Daily_Monthly['inc_amount_proposed'],2):'0.00'));
        // $sheet3->setCellValue('AS'.$numrowNew_3, ($total_Daily_Monthly['new_basic_wage_proposed']>0?number_format($total_Daily_Monthly['new_basic_wage_proposed'],2):'0.00'));
        // $sheet3->setCellValue('AT'.$numrowNew_3, ($total_Daily_Monthly['new_salary_wage_month']>0?number_format($total_Daily_Monthly['new_salary_wage_month'],2):'0.00'));
        // $sheet3->setCellValue('AU'.$numrowNew_3, ($finaldmgm_hide>0?number_format($finaldmgm_hide,2):''));

        
        $numrowNew_3 = $numrowNew_3+1;
        
        $sheet3->setCellValue('AL'.$numrowNew_3, 'Baht/Month');
        $sheet3->setCellValue('AT'.$numrowNew_3, 'Baht/Month');

        
        $numrowNew_3 = $numrowNew_3+6;
        
        $sheet3->setCellValue('AN'.$numrowNew_3, 'Proposed by ');
        $sheet3->setCellValue('AT'.$numrowNew_3, 'Approved by ');

        
        $spreadsheet
        ->getSheet(0)
        ->getStyle('AO'.$numrowNew_3.':AQ'.$numrowNew_3)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        $spreadsheet
        ->getSheet(0)
        ->getStyle('AU'.$numrowNew_3.':AW'.$numrowNew_3)
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('000000'));
        
        
        $numrowNew_3 = $numrowNew_3+1;
        

        $sheet3->setCellValue('AP'.$numrowNew_3, 'Div/Dept Manager');
        $sheet3->setCellValue('AV'.$numrowNew_3, 'G.M.');

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
