<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportReport;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
class EvaluateController extends Controller
{
    public function index()
    {
        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $orisoft = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code','tb_employee.section_description')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('evaluator_no',$orisoft_code);
        // $orisoft = $orisoft->get();

        // $section = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code','tb_employee.section_description')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        // $section = $section->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->get();


        // $department = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.department_code',
        // 'tb_employee.department_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        // $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();

        // $department_code = [];
        // if(count($department)>0){
        //     foreach ($department as $value) {
        //         array_push($department_code,$value->department_code);
        //     }
        // }

        // $section = DB::table('tb_employee_final_score')
        // ->select('tb_employee.section_code',
        // 'tb_employee.section_description',
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->whereIn('tb_employee.department_code',$department_code)
        // ;
        // $section = $section->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->get();
        // $section = DB::table('tb_section');
        // $section = $section->orderBy('id', 'ASC')->get();

        $orisoft_code = Auth::user()->orisoft_code;
        // $search_year       = $request->input('search_year');
        // $previousYear = $search_year;
        $previousYear = date('Y');


        // dd($orisoft_code);

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                 $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like',$previousYear)
                ->where('tb_percent_department_action.approve_by1','000002');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }else{
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like',$previousYear)
                ->where('tb_percent_department_action.approve_by2','000002');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
        }else if($orisoft_code == "000026"){
            if(trans(request()->segment(1)) == 'manager'){
                 $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like',$previousYear)
                ->where('tb_percent_department_action.approve_by1','000026');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }else{
                $section = DB::table('tb_percent_department_action')
                ->select('tb_section.*')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->leftJoin('tb_section','tb_section.section_code','=','tb_percent_department_action.section_code')
                ->where('tb_percent_department.year','like',$previousYear)
                ->where('tb_percent_department_action.approve_by2','000026');
                $section = $section->groupBy('tb_percent_department_action.section_code')->orderBy('tb_percent_department_action.section_code', 'ASC')->get();
            }
        }else if($orisoft_code == "990002"){
            $section = DB::table('tb_section')->get();
        }else{
            $orisoft_section_code = DB::table('tb_employee_evaluator')->where('employee_no',$orisoft_code)->first();
            if(!empty($orisoft_section_code)){
                    if($orisoft_section_code->section_code){
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

                    $section = DB::table('tb_employee_final_score')
                    ->select('tb_employee.section_code','tb_employee.section_description')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                    ;

                    $section = $section->groupBy('tb_employee.section_code')->orderBy('tb_employee.section_code', 'ASC')->get();
                    // dd($section);
                    // exit;

                    $newsec = [];
                    foreach ($section as $valuexx) {
                        array_push($newsec,$valuexx->section_code);
                    }
                    $sectionxx = DB::table('tb_employee_evaluator')
                    ->select('tb_employee_evaluator.section_code','tb_employee_evaluator.section_description')
                    ->where('tb_employee_evaluator.employee_no',$orisoft_code)
                    ;
                    $sectionxx = $sectionxx->get();
                    foreach ($sectionxx as $valuexxx) {
                        $checka = strpos($valuexxx->section_code,',');
                        $arr_section_code = [];
                        if($checka >= 0){
                            $ex = explode(',',$valuexxx->section_code);
                            if(count($ex)>0){
                                foreach ($ex as $value) {
                                    array_push($newsec,$value);
                                }
                            }
                        }else{
                            array_push($newsec,$valuexxx->section_code);
                        }
                        // array_push($newsec,$valuexxx->section_code);
                    }
                    $newsecx = array_unique( $newsec );

                    $section = DB::table('tb_section')
                    ->whereIn('tb_section.section_code',$newsecx);
                    $section = $section->orderBy('section_code', 'ASC')->get();
                }else{
                    $cut_department_code = substr($orisoft_section_code->department_code,0,2);
                    $section = DB::table('tb_section')->where('section_code','like',''.$cut_department_code.'%')->get();
                }
            }else{
                $section = DB::table('tb_section')->get();
            }
        }
        // dd($section);
        // exit;
        $search_year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
        return view('pages.evaluate.index', [
            "section" => $section,
            "userID" => $userID,
            "search_year" => $search_year,
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.evaluate.index');
    }
    public function table_evaluator_getdata(Request $request)
    {
        // ****** ใช้ในกรณัี Query จาก Database ******
        // $i = 1;
        // $search     = $request->input('search')['value'];
        // $start      = $request->input('start');
        // $pagestart  = $request->input('start')+1;
        // $length     = $request->input('length');
        // $field      = $request->input('order')[0]['column'];
        // $order      = $request->input('order')[0]['dir'];
        // $fieldby    = 'users.id';
        // $orderby    = 'asc';

        // if(empty($start)){
        //     $start = 0;
        // }

        // if(empty($length)){
        //     $length = 10;
        // }

        // $gatall = DB::table('users')
        // ->select('users.id AS id',
        //         'users.name AS name',
        //         'users.email AS email'
        // );
        // $count_data = DB::table('users')
        // ->select('users.id AS id',
        //         'users.name AS name',
        //         'users.email AS email'
        // );

        // if(!empty($search)){
        //     $gatall->where(function ($query) use($search) {
        //         $query->orWhere('users.name','like','%'.$search.'%');
        //         $query->orWhere('users.email','like','%'.$search.'%');
        //     });

        //     $count_data->where(function ($query) use($search) {
        //         $query->orWhere('users.name','like','%'.$search.'%');
        //         $query->orWhere('users.email','like','%'.$search.'%');
        //     });
        // }

        // if(empty($field)){
        //     $fieldby = 'users.id';
        //     $orderby = 'asc';
        // }
        // else{
        //     if($field == 1){
        //         $fieldby = 'users.id';
        //     }else if($field == 2){
        //         $fieldby = 'users.name';
        //     }else if($field == 3){
        //         $fieldby = 'users.email';
        //     }
        // }

        // if($order){
        //     $order = $order;
        // }
        // else{
        //     $order = 'asc';
        // }
        // $gatall->orderBy($fieldby,$order);
        // $gatall = $gatall->skip($start)->take($length)->get();

        // $count_data = $count_data->orderBy('users.id', 'DESC')->count();

        // if(count($gatall)>0){
        //     foreach ($gatall as $value) {
        //         $checkbox = '<input type="checkbox">';
        //         $data[] = array(
        //             "checkbox" =>  $checkbox,
        //             "no" =>  $pagestart,
        //             "department_name" =>  'แผนกA',
        //             "percent" =>  '50%',
        //             "user_id" =>  $value->id,
        //             "name" =>  $value->name,
        //             "email" =>  $value->email,
        //             "fieldby" =>  $fieldby,
        //             "orderby" =>  $order,
        //         );
        //         $pagestart++;
        //     }
        // }else{
        //     $data = [];
        // }

        // $totalRecords = $totalDisplay = $count_data;
        // $result = [
        //     'recordsTotal'    => $totalRecords,
        //     'recordsFiltered' => $totalDisplay,
        //     'data'            => $data,
        // ];


        // ****** ใช้ในกรณัี Mockup data ******
        for ($i=1; $i < 11; $i++) {
            $checkbox = '<input type="checkbox">';
            $data[] = array(
                "checkbox" =>  $checkbox,
                "no" =>  $i,
                "department_name" =>  'แผนกA',
                "percent" =>  '50%',
            );
        }

        $result = [
            'recordsTotal'    => 1,
            'recordsFiltered' => 1,
            'data'            => $data,
        ];
        echo json_encode($result);

    }

    public function table_test_getdata(Request $request)
    {
        function changedata($val){
            $newdate = '';
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            if($val != "" && $val != null && $val != "0000-00-00 00:00:00"){
                $newdate = date("d",strtotime($val)).'-'.$array[date('n',strtotime($val))].'-'.(date("Y",strtotime($val)));

            }
            return $newdate;
        }
        $nowyear = date('Ym');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            // $previousYear = 2024;
            $search_year       = $request->input('search_year');
            if(!empty($search_year)){
                $previousYear = $search_year;
            }else{
                $previousYear[] = date('Y');
            }
        // }

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $datarow = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_employee.employee_local_name_th AS name2',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }else{
                $datarow = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_employee.employee_local_name_th AS name2',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }
        }else if($orisoft_code == "990002"){
            $datarow = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_employee.employee_local_name_th AS name2',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else{
            $datarow = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_employee.employee_local_name_th AS name2',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }
        // echo json_encode($datarow);
        // exit();

        $orisoft_codexx = Auth::user()->orisoft_code;
        $orisoft_all_codexx = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like',$previousYear)
        ->where('employee_no',$orisoft_codexx)->first();


        if($orisoft_code == "000002"){
            // if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
            //     if(!isset($search_section)){
            //         $arr_section_codedata_all = [];
            //         $checkadata_all = strpos($orisoft_all_codexx->section_code,',');
            //         if($checkadata_all >= 0){
            //             $exdata_all = explode(',',$orisoft_all_codexx->section_code);
            //             if(count($exdata_all)>0){
            //                 foreach ($exdata_all as $value) {
            //                     array_push($arr_section_codedata_all,$value);
            //                 }
            //             }
            //         }else{
            //             array_push($arr_section_codedata_all,$orisoft_all_codexx->section_code);
            //         }
            //         $datarow = $datarow->whereIn('tb_employee.section_code',$arr_section_codedata_all);
            //     }
            // }else{
            //     if(!empty($search_section)){
            //         $datarow->whereIn('tb_employee.section_code', $search_section);
            //     }
            // }
        }else{
            if(!empty($search_section)){
                $datarow->whereIn('tb_employee.section_code', $search_section);
            }
        }



        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }

        if($search_form != '0'){
            $datarow->where('tb_employee_final_score.form_import', $search_form);
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $datarow->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarow->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array('1', $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array('2', $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array('3', $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }

        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $datarow->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $dataraw = $datarow->toRawSql();
        $datarow = $datarow->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->get();
        // echo json_encode($datarow);
        // exit();
        $edit_evaluate_employees = 'disabled';
        if (Auth::user()->can('edit evaluate employees')) {
            $edit_evaluate_employees = '';
        }
        $evaluate_evaluate_employees = 'disabled';
        if (Auth::user()->can('evaluate evaluate employees')) {
            $evaluate_evaluate_employees = '';
        }

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                ////////////////////////////////////
                if($value->form_import){
                    if($value->evaluation_criteria_id == null || $value->evaluation_criteria_id == ''){
                        $rowx = DB::table('group_form')->select('id')->where('form_ref', $value->form_import)->first();
                        $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();

                        $evaluation_criteria_id = '';
                        $evaluation_criteria_id_comma = '';
                        foreach ($row_group_form_topic as $key2 => $val2) {
                            $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
                            $evaluation_criteria_id_comma .= ',';
                        }
                        $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
                        DB::table('tb_employee_final_score')
                        ->where('id', $value->id )
                        ->update([
                            "evaluation_criteria_id" => $evaluation_criteria_id,
                            "criteria_score_old" => $evaluation_criteria_id_comma,
                            "criteria_score_new" => $evaluation_criteria_id_comma,
                            "status_pa" => '3'
                        ]);
                        $value->evaluation_criteria_id = $evaluation_criteria_id;
                        $value->criteria_score_old = $evaluation_criteria_id_comma;
                        $value->criteria_score_new = $evaluation_criteria_id_comma;
                    }
                }
                ////////////////////////////////////
                if($value->status_evaluation == '0'){
                    $status_evaluation = '';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="badge badge-light">In progress</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="badge badge-light-danger">Reject</span>';
                }else{
                    $status_evaluation = '<span class="badge badge-light-success">Finished</span>';
                }
                $cut_evaluation_criteria_id = explode(',',$value->evaluation_criteria_id);

                $topic_weight1 = DB::table('group_form')
                    ->select('compliance_weight_status','criteria_weight')
                    ->where('group_form.id', $value->group_form_id)
                    ->first();

                $attendance_score = round($value->attendance_score);
                if($attendance_score >= 0 && $attendance_score <= 2){
                    $value->attendance_score = 10;
                }else if($attendance_score >= 17 && $attendance_score <= 18){
                    $value->attendance_score = 2;
                }else if($attendance_score >= 15 && $attendance_score <= 16){
                    $value->attendance_score = 3;
                }else if($attendance_score >= 13 && $attendance_score <= 14){
                    $value->attendance_score = 4;
                }else if($attendance_score >= 11 && $attendance_score <= 12){
                    $value->attendance_score = 5;
                }else if($attendance_score >= 9 && $attendance_score <= 10){
                    $value->attendance_score = 6;
                }else if($attendance_score >= 7 && $attendance_score <= 8){
                    $value->attendance_score = 7;
                }else if($attendance_score >= 5 && $attendance_score <= 6){
                    $value->attendance_score = 8;
                }else if($attendance_score >= 3 && $attendance_score <= 4){
                    $value->attendance_score = 9;
                }else{
                    $value->attendance_score = 1;
                }

                $compliance_score = round($value->compliance_score);
                $value->compliance_score = $compliance_score;
                // if($compliance_score >= 0 && $compliance_score <= 2){
                //     $value->compliance_score = 10;
                // }else if($compliance_score >= 17 && $compliance_score <= 18){
                //     $value->compliance_score = 2;
                // }else if($compliance_score >= 15 && $compliance_score <= 16){
                //     $value->compliance_score = 3;
                // }else if($compliance_score >= 13 && $compliance_score <= 14){
                //     $value->compliance_score = 4;
                // }else if($compliance_score >= 11 && $compliance_score <= 12){
                //     $value->compliance_score = 5;
                // }else if($compliance_score >= 9 && $compliance_score <= 10){
                //     $value->compliance_score = 6;
                // }else if($compliance_score >= 7 && $compliance_score <= 8){
                //     $value->compliance_score = 7;
                // }else if($compliance_score >= 5 && $compliance_score <= 6){
                //     $value->compliance_score = 8;
                // }else if($compliance_score >= 3 && $compliance_score <= 4){
                //     $value->compliance_score = 9;
                // }else{
                //     $value->compliance_score = 1;
                // }

                $freezex = '';
                if ($value->freeze == '1') {
                    $freezex = 'disabled';
                }

                $callll = 0;
                $callll_criteria = '';
                if($value->freeze == '1'){
                    $expl = explode(',',$value->criteria_score_eva);
                }else{
                    $expl = explode(',',$value->criteria_score_new);
                }
                if(!empty($expl)){
                    foreach($expl as $key2 => $value2) {
                        $test2 = DB::table('group_form_topic')
                        ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                        ->whereIn('group_form.form_year_use_start',$previousYear)
                        ->where('group_form_topic.group_form_id',$value->group_form_id)
                        ->orderBy('group_form_topic.id','ASC')
                        ->get();
                        foreach($test2 as $key3 => $value3) {
                            if($key2 == $key3){
                                if($value2>0){
                                    $callll += $value2*$value3->topic_weight;
                                    $callll_criteria .= $value2*$value3->topic_weight.'__';
                                }

                            }
                        }
                    }
                }
                $test22 = DB::table('group_form')
                        ->whereIn('group_form.form_year_use_start',$previousYear)
                        ->where('group_form.id',$value->group_form_id)
                        ->first();
                $callll = $callll+($value->compliance_score*(!empty($test22->compliance_weight) ? $test22->compliance_weight : 1));


                $attendance_scorezzz = 0;
                // $attendance_score = round($value->attendance_score);
                if($attendance_score >= 0 && $attendance_score <= 2){
                    $attendance_scorezzz = 10;
                }else if($attendance_score >= 17 && $attendance_score <= 18){
                    $attendance_scorezzz = 2;
                }else if($attendance_score >= 15 && $attendance_score <= 16){
                    $attendance_scorezzz = 3;
                }else if($attendance_score >= 13 && $attendance_score <= 14){
                    $attendance_scorezzz = 4;
                }else if($attendance_score >= 11 && $attendance_score <= 12){
                    $attendance_scorezzz = 5;
                }else if($attendance_score >= 9 && $attendance_score <= 10){
                    $attendance_scorezzz = 6;
                }else if($attendance_score >= 7 && $attendance_score <= 8){
                    $attendance_scorezzz = 7;
                }else if($attendance_score >= 5 && $attendance_score <= 6){
                    $attendance_scorezzz = 8;
                }else if($attendance_score >= 3 && $attendance_score <= 4){
                    $attendance_scorezzz = 9;
                }else{
                    $attendance_scorezzz = 1;
                }

                $callll = $callll+($attendance_scorezzz*(!empty($test22->criteria_weight) ? $test22->criteria_weight : 1));
                $value->total_score = $callll;

                $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                $data[] = array(
                    "id" =>  '<input type="checkbox">',
                    "group_form_id"=> $value->group_form_id,
                    "evaluation_criteria_id"=> $value->evaluation_criteria_id,
                    "criteria_score_eva"=> $value->criteria_score_eva,
                    "criteria_score_old"=> $value->criteria_score_old,
                    "criteria_score_new"=> $value->criteria_score_new,
                    "code"=> $value->employee_no,
                    "name"=> (Session::get('locale') == "th" ?$value->name2:$value->name1),
                    "position"=> $value->position_name,
                    "date"=> changedata($value->date_joined),
                    "olddate"=> $value->date_joined,
                    "service"=> $value->service_days,
                    (count($cut_evaluation_criteria_id)+1)=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px"
                            data-bs-toggle="modal" data-bs-target="#complainModal"
                            onclick="gettitle('.$value->group_form_id.',0.1,'.(count($cut_evaluation_criteria_id)+1).',1,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');"
                            onfocus="gettitle('.$value->group_form_id.',0.1,'.(count($cut_evaluation_criteria_id)+1).',1,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->compliance_score?$value->compliance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="complain_score'.$value->id.'"
                            value="'.$value->compliance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->compliance_weight_status.'">',
                    "0"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px"
                            data-bs-toggle="modal" data-bs-target="#attendanceModal"
                            onclick="gettitle('.$value->group_form_id.',0,'.(count($cut_evaluation_criteria_id)+2).',2,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');"
                            onfocus="gettitle('.$value->group_form_id.',0,'.(count($cut_evaluation_criteria_id)+2).',2,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->attendance_score?$value->attendance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="attendance_score'.$value->id.'"
                            value="'.$value->attendance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->criteria_weight.'">',
                    "total"=> '<b class="total_score'.$value->id.'">'.number_format($value->total_score,1,'.','').'</b><input type="hidden" id="total_score'.$value->id.'" value="'.number_format($value->total_score,1,'.','').'">',
                    "remark"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);" '.$freezex.'>',
                    "remark_eva_review"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);" disabled>',
                    "remark_manager"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark_manager.'" onchange="update_remark_manager('.$value->id.',this.value);" disabled>',
                    "remark_manager_review"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark_manager.'" onchange="update_remark_manager('.$value->id.',this.value);" >',
                    "status"=> $status_evaluation,
                    "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                    "data_id" =>  $value->id,
                    "evaluator_name" => $evaluator_name,
                    "freeze" =>  $value->freeze,
                    "freeze_to_pagrade" =>  $value->freeze_to_pagrade,
                    "form" =>  $value->form_import
                );

                // if($value->form_import == "F1"){
                //     $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                //     $data[] = array(
                //         "id" =>  '<input type="checkbox">',
                //         "code"=> $value->employee_no,
                //         "name"=> $value->name1,
                //         "position"=> $value->position_name,
                //         "date"=> changedata($value->date_joined),
                //         "olddate"=> $value->date_joined,
                //         "service"=> $value->service_days,
                //         "1"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score1.'" onclick="gettitle('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);"> <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                //         "2"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score2.'" onclick="gettitle('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);"> ',
                //         "3"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score3.'" onclick="gettitle('.$value->group_form_id.',4,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);"> ',
                //         "4"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score4.'" onclick="gettitle('.$value->group_form_id.',6,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);"> ',
                //         "5"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score5.'" onclick="gettitle('.$value->group_form_id.',13,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);"> ',
                //         "6"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score6.'" onclick="gettitle('.$value->group_form_id.',7,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);"> ',
                //         "7"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score7.'" onclick="gettitle('.$value->group_form_id.',8,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);"> ',
                //         "8"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle('.$value->group_form_id.',9,8,1,'.$value->id.');">'.($value->evaluation_criteria_score8?$value->evaluation_criteria_score8:'0').'</button><input type="hidden" class="calAll'.$value->id.'" id="complain_score'.$value->id.'" value="'.$value->evaluation_criteria_score8.'"> ',
                //         "0"=>'<button type="button" class="btn btn-sm btn-danger" style="width:60px" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle('.$value->group_form_id.',0,9,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button><input type="hidden" class="calAll'.$value->id.'" id="attendance_score'.$value->id.'" value="'.$value->attendance_score.'"> <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="2">',
                //         "total"=> '<b class="total_score'.$value->id.'">'.$value->total_score.'</b><input type="hidden" id="total_score'.$value->id.'" value="'.$value->total_score.'">',
                //         "remark"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);">',
                //         "status"=> $status_evaluation,
                //         "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-danger btn-xs' data-bs-toggle='modal' data-bs-target='#rejectModal'><i class='ki-solid ki-cross-circle fs-5'></i></button>",
                //         "topic_weight" =>  $getdataAll,
                //         "data_id" =>  $value->id
                //     );
                // }
                // if($value->form_import == "F2"){
                //     $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                //     $data[] = array(
                //         "id" =>  '<input type="checkbox">',
                //         "code"=> $value->employee_no,
                //         "name"=> $value->name1,
                //         "position"=> $value->position_name,
                //         "date"=> changedata($value->date_joined),
                //         "olddate"=> $value->date_joined,
                //         "service"=> $value->service_days,
                //         "1"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score1.'" onclick="gettitle('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">  <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                //         "2"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score2.'" onclick="gettitle('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);"> ',
                //         "3"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score3.'" onclick="gettitle('.$value->group_form_id.',3,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);"> ',
                //         "4"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score4.'" onclick="gettitle('.$value->group_form_id.',4,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);"> ',
                //         "5"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score5.'" onclick="gettitle('.$value->group_form_id.',5,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);"> ',
                //         "6"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score6.'" onclick="gettitle('.$value->group_form_id.',6,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);"> ',
                //         "7"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score7.'" onclick="gettitle('.$value->group_form_id.',13,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);"> ',
                //         "8"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score8.'" onclick="gettitle('.$value->group_form_id.',7,8,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,8);"> ',
                //         "9"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score9.'" onclick="gettitle('.$value->group_form_id.',8,9,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,9);"> ',
                //         "10"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle('.$value->group_form_id.',9,10,1,'.$value->id.');">'.($value->evaluation_criteria_score10?$value->evaluation_criteria_score10:'0').'</button><input type="hidden" class="calAll'.$value->id.'" id="complain_score'.$value->id.'" value="'.$value->evaluation_criteria_score10.'"> ',
                //         "0"=>'<button type="button" class="btn btn-sm btn-danger" style="width:60px" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle('.$value->group_form_id.',0,11,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button><input type="hidden" class="calAll'.$value->id.'" id="attendance_score'.$value->id.'" value="'.$value->attendance_score.'"> <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="1">',
                //         "total"=> '<b class="total_score'.$value->id.'">'.$value->total_score.'</b><input type="hidden" id="total_score'.$value->id.'" value="'.$value->total_score.'">',
                //         "remark"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);">',
                //         "status"=> $status_evaluation,
                //         "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-danger btn-xs' data-bs-toggle='modal' data-bs-target='#rejectModal'><i class='ki-solid ki-cross-circle fs-5'></i></button>",
                //         "topic_weight" =>  $getdataAll,
                //         "data_id" =>  $value->id
                //     );
                // }
                // if($value->form_import == "F3"){
                //     $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                //     $data[] = array(
                //         "id" =>  '<input type="checkbox">',
                //         "code"=> $value->employee_no,
                //         "name"=> $value->name1,
                //         "position"=> $value->position_name,
                //         "date"=> changedata($value->date_joined),
                //         "olddate"=> $value->date_joined,
                //         "service"=> $value->service_days,
                //         "1"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score1.'" onclick="gettitle('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">  <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                //         "2"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score2.'" onclick="gettitle('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);"> ',
                //         "3"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score3.'" onclick="gettitle('.$value->group_form_id.',4,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);"> ',
                //         "4"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score4.'" onclick="gettitle('.$value->group_form_id.',5,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);"> ',
                //         "5"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score5.'" onclick="gettitle('.$value->group_form_id.',6,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);"> ',
                //         "6"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score6.'" onclick="gettitle('.$value->group_form_id.',7,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);"> ',
                //         "7"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score7.'" onclick="gettitle('.$value->group_form_id.',8,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);"> ',
                //         "8"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle('.$value->group_form_id.',9,8,1,'.$value->id.');">'.($value->evaluation_criteria_score8?$value->evaluation_criteria_score8:'0').'</button><input type="hidden" class="calAll'.$value->id.'" id="complain_score'.$value->id.'" value="'.$value->evaluation_criteria_score8.'"> ',
                //         "0"=>'<button type="button" class="btn btn-sm btn-danger" style="width:60px" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle('.$value->group_form_id.',0,9,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button><input type="hidden" class="calAll'.$value->id.'" id="attendance_score'.$value->id.'" value="'.$value->attendance_score.'"> <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="1">',
                //         "total"=> '<b class="total_score'.$value->id.'">'.$value->total_score.'</b><input type="hidden" id="total_score'.$value->id.'" value="'.$value->total_score.'">',
                //         "remark"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);">',
                //         "status"=> $status_evaluation,
                //         "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-danger btn-xs' data-bs-toggle='modal' data-bs-target='#rejectModal'><i class='ki-solid ki-cross-circle fs-5'></i></button>",
                //         "topic_weight" =>  $getdataAll,
                //         "data_id" =>  $value->id
                //     );
                // }
                // if($value->form_import == "F4"){
                //     $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                //     $data[] = array(
                //         "id" =>  '<input type="checkbox">',
                //         "code"=> $value->employee_no,
                //         "name"=> $value->name1,
                //         "position"=> $value->position_name,
                //         "date"=> changedata($value->date_joined),
                //         "olddate"=> $value->date_joined,
                //         "service"=> $value->service_days,
                //         "1"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score1.'" onclick="gettitle('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">  <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                //         "2"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score2.'" onclick="gettitle('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);"> ',
                //         "3"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score3.'" onclick="gettitle('.$value->group_form_id.',3,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);"> ',
                //         "4"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score4.'" onclick="gettitle('.$value->group_form_id.',4,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);"> ',
                //         "5"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score5.'" onclick="gettitle('.$value->group_form_id.',5,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);"> ',
                //         "6"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score6.'" onclick="gettitle('.$value->group_form_id.',6,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);"> ',
                //         "7"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score7.'" onclick="gettitle('.$value->group_form_id.',7,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);"> ',
                //         "8"=>'<input type="text" class="form-control form-control-sm text-center calAll'.$value->id.'" style="width:60px" min="1" max="10" value="'.$value->evaluation_criteria_score8.'" onclick="gettitle('.$value->group_form_id.',8,8,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,8);"> ',
                //         "9"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle('.$value->group_form_id.',9,9,1,'.$value->id.');">'.($value->evaluation_criteria_score9?$value->evaluation_criteria_score9:'0').'</button> <input type="hidden" class="calAll'.$value->id.'" id="complain_score'.$value->id.'" value="'.$value->evaluation_criteria_score9.'"> ',
                //         "0"=>'<button type="button" class="btn btn-sm btn-danger" style="width:60px" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle('.$value->group_form_id.',0,10,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button> <input type="hidden" class="calAll'.$value->id.'" id="attendance_score'.$value->id.'" value="'.$value->attendance_score.'"> <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="1">',
                //         "total"=> '<b class="total_score'.$value->id.'">'.$value->total_score.'</b><input type="hidden" id="total_score'.$value->id.'" value="'.$value->total_score.'">',
                //         "remark"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);">',
                //         "status"=> $status_evaluation,
                //         "action"=> "<button type='button' class='btn btn-icon btn-success btn-xs me-1' data-bs-toggle='modal' data-bs-target='#approveModal'><i class='ki-solid ki-check-circle fs-5'></i></button><button type='button' class='btn btn-icon btn-danger btn-xs' data-bs-toggle='modal' data-bs-target='#rejectModal'><i class='ki-solid ki-cross-circle fs-5'></i></button>",
                //         "topic_weight" =>  $getdataAll,
                //         "data_id" =>  $value->id
                //     );
                // }
            }

        }
        foreach ($data as $key1 => $value1) {
            // $data[$key1]['test'] = $value1['group_form_id'];
            if($value1['group_form_id']){
                $cut = explode(',',$value1['evaluation_criteria_id']);
                $cut_criteria_score_new = [];
                if($value1['criteria_score_new']){
                    $cut_criteria_score_new = explode(',',$value1['criteria_score_new']);
                }
                if ($value1['freeze'] == '1') {
                    if($value1['criteria_score_eva']){
                        $cut_criteria_score_new = explode(',',$value1['criteria_score_eva']);
                    }
                }
                // print_r(count($cut_criteria_score_new));
                // exit;
                $data[$key1]['count_evaluation_criteria_id'] = count($cut);
                foreach ($cut as $key2 => $value2) {
                    $topic_weight = DB::table('group_form_topic')
                    ->select('topic_weight')
                    ->where('group_form_topic.group_form_id', $value1['group_form_id'])
                    ->where('group_form_topic.evaluation_criteria_id', $value2)
                    ->first();
                    $freeze = '';
                    $bg_css = '';
                    if ($value1['freeze'] == '1') {
                        $freeze = 'readonly';
                        $bg_css = 'background-color: var(--bs-gray-200);';
                    }
                    $data[$key1][($key2+1)] = '<input type="text" class="form-control form-control-sm text-center calAll'.$value1['data_id'].'"
                        style="width:60px;'.$bg_css.'"
                        min="1"
                        max="10"

                        value="'.(count($cut_criteria_score_new)>0?$cut_criteria_score_new[$key2]:'').'"
                        OnKeyPress="return checknumber(this,'.$value1['data_id'].')"
                        onclick="gettitle('.$value1['group_form_id'].','.$value2.','.($key2+1).',0,'.$value1['data_id'].');"
                        onfocus="gettitle('.$value1['group_form_id'].','.$value2.','.($key2+1).',0,'.$value1['data_id'].');"
                        onchange="update_score('.$value1['data_id'].',this.value,1);"
                        '.$evaluate_evaluate_employees.' '.$freeze.'>
                        <input type="hidden" class="calAll_topic_weight'.$value1['data_id'].'" value="'.$topic_weight->topic_weight.'">';
                }
            }
        }

        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $checkYearABC = $search_year;
        }else{
            $checkYearABC[] = date('Y');
        }
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->whereIn('tb_employee_final_score.rec_year',$checkYearABC)
        ->where('tb_employee_final_score.freeze','0')
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
                        if($key == 2 && $val->end_date_real == null){
                            // $updated_at = DB::table('tb_employee_final_score')
                            // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            // ->whereIn('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                            // ->where('tb_employee_final_score.freeze','0')
                            // ->where('tb_employee.employee_status_description','Passed')
                            // ->orderBy('tb_employee_final_score.updated_at','DESC')
                            // ->first();
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }

        $result = [
            'data'              => $data,
            "dataraw" =>  $dataraw
        ];
        echo json_encode($result);

    }

    public function table_test_getdata_all(Request $request)
    {
        function changedata($val){
            $newdate = '';
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            if($val != "" && $val != null && $val != "0000-00-00 00:00:00"){
                $newdate = date("d",strtotime($val)).'-'.$array[date('n',strtotime($val))].'-'.(date("Y",strtotime($val)));

            }
            return $newdate;
        }
        $nowyear = date('Ym');
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }
        // $previousYear = date('Y');

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_month_day      = $request->input('search_month_day');

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        // echo json_encode($datarow);
        // exit();
        $orisoft_codexx = Auth::user()->orisoft_code;
        $orisoft_all_codexx = DB::table('tb_employee_evaluator')
        ->whereIn('tb_employee_evaluator.rec_year',$previousYear)
        ->where('employee_no',$orisoft_codexx)->first();


        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                if(!isset($search_section)){
                    $arr_section_codedata_all = [];
                    $checkadata_all = strpos($orisoft_all_codexx->section_code,',');
                    if($checkadata_all >= 0){
                        $exdata_all = explode(',',$orisoft_all_codexx->section_code);
                        if(count($exdata_all)>0){
                            foreach ($exdata_all as $value) {
                                array_push($arr_section_codedata_all,$value);
                            }
                        }
                    }else{
                        array_push($arr_section_codedata_all,$orisoft_all_codexx->section_code);
                    }
                    $datarow = $datarow->whereIn('tb_employee.section_code',$arr_section_codedata_all);
                }
            }else{
                if(!empty($search_section)){
                    $datarow->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $datarow->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $datarow->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarow->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $datarow->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $datarow = $datarow->orderBy('tb_employee_final_score.total_score', 'ASC')->get();


        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                ////////////////////////////////////
                if($value->form_import){
                    if($value->evaluation_criteria_id == null || $value->evaluation_criteria_id == ''){
                        $rowx = DB::table('group_form')->select('id')->where('form_ref', $value->form_import)->first();
                        $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();

                        $evaluation_criteria_id = '';
                        $evaluation_criteria_id_comma = '';
                        foreach ($row_group_form_topic as $key2 => $val2) {
                            $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
                            $evaluation_criteria_id_comma .= ',';
                        }
                        $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
                        DB::table('tb_employee_final_score')
                        ->where('id', $value->id )
                        ->update([
                            "evaluation_criteria_id" => $evaluation_criteria_id,
                            "criteria_score_old" => $evaluation_criteria_id_comma,
                            "criteria_score_new" => $evaluation_criteria_id_comma,
                            "status_pa" => '3'
                        ]);
                        $value->evaluation_criteria_id = $evaluation_criteria_id;
                        $value->criteria_score_old = $evaluation_criteria_id_comma;
                        $value->criteria_score_new = $evaluation_criteria_id_comma;
                    }
                }
                ////////////////////////////////////
                if($value->status_evaluation == '0'){
                    $status_evaluation = '';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="badge badge-light">In progress</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="badge badge-light-danger">Reject</span>';
                }else{
                    $status_evaluation = '<span class="badge badge-light-success">Finished</span>';
                }
                $cut_evaluation_criteria_id = explode(',',$value->evaluation_criteria_id);

                $topic_weight1 = DB::table('group_form')
                    ->select('compliance_weight_status','criteria_weight')
                    ->where('group_form.id', $value->group_form_id)
                    ->first();

                $attendance_score = round($value->attendance_score);
                if($attendance_score >= 0 && $attendance_score <= 2){
                    $value->attendance_score = 10;
                }else if($attendance_score >= 17 && $attendance_score <= 18){
                    $value->attendance_score = 2;
                }else if($attendance_score >= 15 && $attendance_score <= 16){
                    $value->attendance_score = 3;
                }else if($attendance_score >= 13 && $attendance_score <= 14){
                    $value->attendance_score = 4;
                }else if($attendance_score >= 11 && $attendance_score <= 12){
                    $value->attendance_score = 5;
                }else if($attendance_score >= 9 && $attendance_score <= 10){
                    $value->attendance_score = 6;
                }else if($attendance_score >= 7 && $attendance_score <= 8){
                    $value->attendance_score = 7;
                }else if($attendance_score >= 5 && $attendance_score <= 6){
                    $value->attendance_score = 8;
                }else if($attendance_score >= 3 && $attendance_score <= 4){
                    $value->attendance_score = 9;
                }else{
                    $value->attendance_score = 1;
                }

                $compliance_score = round($value->compliance_score);
                $value->compliance_score = $compliance_score;
                // if($compliance_score >= 0 && $compliance_score <= 2){
                //     $value->compliance_score = 10;
                // }else if($compliance_score >= 17 && $compliance_score <= 18){
                //     $value->compliance_score = 2;
                // }else if($compliance_score >= 15 && $compliance_score <= 16){
                //     $value->compliance_score = 3;
                // }else if($compliance_score >= 13 && $compliance_score <= 14){
                //     $value->compliance_score = 4;
                // }else if($compliance_score >= 11 && $compliance_score <= 12){
                //     $value->compliance_score = 5;
                // }else if($compliance_score >= 9 && $compliance_score <= 10){
                //     $value->compliance_score = 6;
                // }else if($compliance_score >= 7 && $compliance_score <= 8){
                //     $value->compliance_score = 7;
                // }else if($compliance_score >= 5 && $compliance_score <= 6){
                //     $value->compliance_score = 8;
                // }else if($compliance_score >= 3 && $compliance_score <= 4){
                //     $value->compliance_score = 9;
                // }else{
                //     $value->compliance_score = 1;
                // }

                $freezex = '';
                if ($value->freeze == '1') {
                    $freezex = 'disabled';
                }

                $callll = 0;
                $callll_criteria = '';
                if($value->freeze == '1'){
                    $expl = explode(',',$value->criteria_score_eva);
                }else{
                    $expl = explode(',',$value->criteria_score_new);
                }
                if(!empty($expl)){
                    foreach($expl as $key2 => $value2) {
                        $test2 = DB::table('group_form_topic')
                        ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                        ->whereIn('group_form.form_year_use_start',$previousYear)
                        ->where('group_form_topic.group_form_id',$value->group_form_id)
                        ->orderBy('group_form_topic.id','ASC')
                        ->get();
                        foreach($test2 as $key3 => $value3) {
                            if($key2 == $key3){
                                if($value2>0){
                                    $callll += $value2*$value3->topic_weight;
                                    $callll_criteria .= $value2*$value3->topic_weight.'__';
                                }

                            }
                        }
                    }
                }
                $test22 = DB::table('group_form')
                        ->whereIn('group_form.form_year_use_start',$previousYear)
                        ->where('group_form.id',$value->group_form_id)
                        ->first();
                $callll = $callll+($value->compliance_score*(!empty($test22->compliance_weight) ? $test22->compliance_weight : 1));


                $attendance_scorezzz = 0;
                // $attendance_score = round($value->attendance_score);
                if($attendance_score >= 0 && $attendance_score <= 2){
                    $attendance_scorezzz = 10;
                }else if($attendance_score >= 17 && $attendance_score <= 18){
                    $attendance_scorezzz = 2;
                }else if($attendance_score >= 15 && $attendance_score <= 16){
                    $attendance_scorezzz = 3;
                }else if($attendance_score >= 13 && $attendance_score <= 14){
                    $attendance_scorezzz = 4;
                }else if($attendance_score >= 11 && $attendance_score <= 12){
                    $attendance_scorezzz = 5;
                }else if($attendance_score >= 9 && $attendance_score <= 10){
                    $attendance_scorezzz = 6;
                }else if($attendance_score >= 7 && $attendance_score <= 8){
                    $attendance_scorezzz = 7;
                }else if($attendance_score >= 5 && $attendance_score <= 6){
                    $attendance_scorezzz = 8;
                }else if($attendance_score >= 3 && $attendance_score <= 4){
                    $attendance_scorezzz = 9;
                }else{
                    $attendance_scorezzz = 1;
                }

                $callll = $callll+($attendance_scorezzz*(!empty($test22->criteria_weight) ? $test22->criteria_weight : 1));
                $value->total_score = $callll;

                $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                $data[] = array(
                    "id" =>  '<input type="checkbox">',
                    "group_form_id"=> $value->group_form_id,
                    "evaluation_criteria_id"=> $value->evaluation_criteria_id,
                    "criteria_score_old"=> $value->criteria_score_old,
                    "criteria_score_new"=> $value->criteria_score_new,
                    "code"=> $value->employee_no,
                    "name"=> (Session::get('locale') == "th" ?$value->name2:$value->name1),
                    "position"=> $value->position_name,
                    "date"=> changedata($value->date_joined),
                    "olddate"=> $value->date_joined,
                    "service"=> $value->service_days,
                    (count($cut_evaluation_criteria_id)+1)=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px"
                            data-bs-toggle="modal" data-bs-target="#complainModal"
                            onclick="gettitle('.$value->group_form_id.',0.1,'.(count($cut_evaluation_criteria_id)+1).',1,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');"
                            onfocus="gettitle('.$value->group_form_id.',0.1,'.(count($cut_evaluation_criteria_id)+1).',1,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->compliance_score?$value->compliance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="complain_score'.$value->id.'"
                            value="'.$value->compliance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->compliance_weight_status.'">',
                    "0"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px"
                            data-bs-toggle="modal" data-bs-target="#attendanceModal"
                            onclick="gettitle('.$value->group_form_id.',0,'.(count($cut_evaluation_criteria_id)+2).',2,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');"
                            onfocus="gettitle('.$value->group_form_id.',0,'.(count($cut_evaluation_criteria_id)+2).',2,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->attendance_score?$value->attendance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="attendance_score'.$value->id.'"
                            value="'.$value->attendance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->criteria_weight.'">',
                    "total"=> '<b class="total_score'.$value->id.'">'.number_format($value->total_score,1,'.','').'</b><input type="hidden" id="total_score'.$value->id.'" value="'.number_format($value->total_score,1,'.','').'">',
                    "remark"=> '<input type="text" class="form-control form-control-sm" style="width:150px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);" '.$freezex.'>',
                    "remark_eva_review"=> '<input type="text" class="form-control form-control-sm" style="width:150px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);" disabled>',
                    "remark_manager"=> '<input type="text" class="form-control form-control-sm" style="width:150px" value="'.$value->remark_manager.'" onchange="update_remark_manager('.$value->id.',this.value);" disabled>',
                    "remark_manager_review"=> '<input type="text" class="form-control form-control-sm" style="width:150px" value="'.$value->remark_manager.'" onchange="update_remark_manager('.$value->id.',this.value);" >',
                    "status"=> $status_evaluation,
                    "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                    "data_id" =>  $value->id,
                    "evaluator_name" => $evaluator_name,
                    "freeze" =>  $value->freeze,
                    "form" =>  $value->form_import,
                );
            }

        }



        $result = [
            'data'              => $data,
        ];
        echo json_encode($result);

    }

    public function table_test_getdata_m(Request $request)
    {
        function changedata_m($val){
            $newdate = '';
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            if($val != "" && $val != null && $val != "0000-00-00 00:00:00"){
                $newdate = date("d",strtotime($val)).'-'.$array[date('n',strtotime($val))].'-'.(date("Y",strtotime($val)));

            }
            return $newdate;
        }
        $nowyear = date('Ym');
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like',$previousYear);

        if(!empty($search_section)){
            $datarow->whereIn('tb_employee.section_code', $search_section);
        }

        if($search_form != '0'){
            $datarow->where('tb_employee_final_score.form_import', $search_form);
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $datarow->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarow->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if($search_form == "F1"){
                if(in_array("1", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
                }
                if(in_array("2", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
                }
                if(in_array("3", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
                }
            }else if($search_form == "F2"){
                if(in_array("1", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [1, 3]);
                }
                if(in_array("2", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [4, 7]);
                }
                if(in_array("3", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [8, 10]);
                }
            }else if($search_form == "F3"){
                if(in_array("1", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
                }
                if(in_array("2", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
                }
                if(in_array("3", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
                }
            }else{
                if(in_array("1", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [1, 3]);
                }
                if(in_array("2", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [4, 7]);
                }
                if(in_array("3", $search_complaince_score)){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [8, 10]);
                }
            }

        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $datarow->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $datarow = $datarow->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                if($value->status_evaluation == '0'){
                    $status_evaluation = '';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="badge badge-light">In progress</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="badge badge-light-danger">Reject</span>';
                }else{
                    $status_evaluation = '<span class="badge badge-light-success">Finished</span>';
                }
                if($value->form_import == "F1"){
                    $select1 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score1){
                            $select1 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select1 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select2 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score2){
                            $select2 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select2 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select3 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score3){
                            $select3 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select3 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select4 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score4){
                            $select4 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select4 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select5 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score5){
                            $select5 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select5 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select6 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score6){
                            $select6 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select6 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select7 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score7){
                            $select7 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select7 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                    $data[] = array(
                        "topic_weight" =>  $getdataAll,
                        "data_id" =>  $value->id,
                        "all" => '  <div class="card p-5 shadow-none border-gray-300 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault'.$value->id.'" value="'.$value->id.'"/>
                                            <label class="form-check-label text-dark" for="flexCheckDefault">
                                                Emp no.: '.$value->employee_no.'
                                            </label>
                                        </div>
                                        <p class="mb-0 fw-bold text-dark fs-4">'.$value->name1.'</p>
                                        <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>'.$value->position_name.'</p>
                                        <div class="row gx-2">
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>'.changedata_m($value->date_joined).'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Service days:<br></span>'.$value->service_days.'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class=""><span class="small text-gray-800">สถานะ:<br></span>'.$status_evaluation.'</p>
                                            </div>
                                        </div>
                                        <div class="QForm showdetail_score'.$value->id.'">

                                        </div>
                                        <h5 class="mb-2 text-black">Criteria</h5>
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">
                                                    '.$select1.'
                                                </select>
                                                <div class="topic_weight_hidden_m'.$value->id.'" style="display:none;"></div>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);">
                                                    '.$select2.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',4,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);">
                                                   '.$select3.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',6,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);">
                                                    '.$select4.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',13,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);">
                                                    '.$select5.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',7,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);">
                                                    '.$select6.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',8,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);">
                                                    '.$select7.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onfocus="gettitle_m('.$value->group_form_id.',9,8,1,'.$value->id.');">'.($value->evaluation_criteria_score8?$value->evaluation_criteria_score8:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="complain_score_m'.$value->id.'" value="'.$value->evaluation_criteria_score8.'">
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onfocus="gettitle_m('.$value->group_form_id.',0,9,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="attendance_score_m'.$value->id.'" value="'.$value->attendance_score.'">
                                                <input type="hidden" class="calAll_topic_weight_m'.$value->id.'" value="2">
                                            </div>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col-12">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                    </div>',
                    );
                }
                if($value->form_import == "F2"){
                    $select1 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score1){
                            $select1 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select1 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select2 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score2){
                            $select2 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select2 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select3 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score3){
                            $select3 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select3 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select4 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score4){
                            $select4 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select4 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select5 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score5){
                            $select5 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select5 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select6 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score6){
                            $select6 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select6 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select7 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score7){
                            $select7 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select7 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select8 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score8){
                            $select8 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select8 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select9 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score9){
                            $select9 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select9 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                    $data[] = array(
                        "topic_weight" =>  $getdataAll,
                        "data_id" =>  $value->id,
                        "all" => '  <div class="card p-5 shadow-none border-gray-300 mb-3" >
                                        <div class="form-check">
                                            <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault'.$value->id.'" value="'.$value->id.'"/>
                                            <label class="form-check-label text-dark" for="flexCheckDefault">
                                                Emp no.: '.$value->employee_no.'
                                            </label>
                                        </div>
                                        <p class="mb-0 fw-bold text-dark fs-4">'.$value->name1.'</p>
                                        <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>'.$value->position_name.'</p>
                                        <div class="row gx-2">
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>'.changedata_m($value->date_joined).'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Service days:<br></span>'.$value->service_days.'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class=""><span class="small text-gray-800">สถานะ:<br></span>'.$status_evaluation.'</p>
                                            </div>
                                        </div>
                                        <div class="QForm showdetail_score'.$value->id.'">

                                        </div>
                                        <h5 class="mb-2 text-black">Criteria</h5>
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">
                                                    '.$select1.'
                                                </select>
                                                <div class="topic_weight_hidden_m'.$value->id.'" ></div>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);">
                                                    '.$select2.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',3,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);">
                                                   '.$select3.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',4,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);">
                                                    '.$select4.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',5,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);">
                                                    '.$select5.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',6,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);">
                                                    '.$select6.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',13,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);">
                                                    '.$select7.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',7,8,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,8);">
                                                    '.$select7.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',8,9,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,9);">
                                                    '.$select7.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onfocus="gettitle_m('.$value->group_form_id.',9,10,1,'.$value->id.');">'.($value->evaluation_criteria_score10?$value->evaluation_criteria_score10:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="complain_score_m'.$value->id.'" value="'.$value->evaluation_criteria_score10.'">
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onfocus="gettitle_m('.$value->group_form_id.',0,11,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="attendance_score_m'.$value->id.'" value="'.$value->attendance_score.'">
                                                <input type="hidden" class="calAll_topic_weight_m'.$value->id.'" value="2">
                                            </div>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col-12">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                    </div>',
                    );
                }
                if($value->form_import == "F3"){
                    $select1 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score1){
                            $select1 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select1 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select2 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score2){
                            $select2 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select2 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select3 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score3){
                            $select3 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select3 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select4 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score4){
                            $select4 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select4 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select5 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score5){
                            $select5 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select5 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select6 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score6){
                            $select6 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select6 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select7 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score7){
                            $select7 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select7 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                    $data[] = array(
                        "topic_weight" =>  $getdataAll,
                        "data_id" =>  $value->id,
                        "all" => '  <div class="card p-5 shadow-none border-gray-300 mb-3" >
                                        <div class="form-check">
                                            <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault'.$value->id.'" value="'.$value->id.'"/>
                                            <label class="form-check-label text-dark" for="flexCheckDefault">
                                                Emp no.: '.$value->employee_no.'
                                            </label>
                                        </div>
                                        <p class="mb-0 fw-bold text-dark fs-4">'.$value->name1.'</p>
                                        <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>'.$value->position_name.'</p>
                                        <div class="row gx-2">
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>'.changedata_m($value->date_joined).'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Service days:<br></span>'.$value->service_days.'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class=""><span class="small text-gray-800">สถานะ:<br></span>'.$status_evaluation.'</p>
                                            </div>
                                        </div>
                                        <div class="QForm showdetail_score'.$value->id.'">

                                        </div>
                                        <h5 class="mb-2 text-black">Criteria</h5>
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">
                                                    '.$select1.'
                                                </select>
                                                <div class="topic_weight_hidden_m'.$value->id.'" style="display:none;"></div>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);">
                                                    '.$select2.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',4,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);">
                                                   '.$select3.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',6,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);">
                                                    '.$select4.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',13,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);">
                                                    '.$select5.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',7,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);">
                                                    '.$select6.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',8,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);">
                                                    '.$select7.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onfocus="gettitle_m('.$value->group_form_id.',9,8,1,'.$value->id.');">'.($value->evaluation_criteria_score8?$value->evaluation_criteria_score8:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="complain_score_m'.$value->id.'" value="'.$value->evaluation_criteria_score8.'">
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onfocus="gettitle_m('.$value->group_form_id.',0,9,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="attendance_score_m'.$value->id.'" value="'.$value->attendance_score.'">
                                                <input type="hidden" class="calAll_topic_weight_m'.$value->id.'" value="2">
                                            </div>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col-12">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                    </div>',
                    );
                }
                if($value->form_import == "F4"){
                    $select1 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score1){
                            $select1 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select1 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select2 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score2){
                            $select2 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select2 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select3 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score3){
                            $select3 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select3 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select4 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score4){
                            $select4 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select4 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select5 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score5){
                            $select5 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select5 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select6 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score6){
                            $select6 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select6 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select7 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score7){
                            $select7 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select7 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $select8 = '';
                    for ($i=1; $i < 11; $i++) {
                        if($i == $value->evaluation_criteria_score8){
                            $select8 .= '<option value="'.$i.'" selected>'.$i.'</option>';
                        }else{
                            $select8 .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $getdataAll = DB::table('group_form_topic')->select('group_form_topic.topic_weight')->where('group_form_topic.group_form_id', $value->group_form_id)->get();

                    $data[] = array(
                        "topic_weight" =>  $getdataAll,
                        "data_id" =>  $value->id,
                        "all" => '  <div class="card p-5 shadow-none border-gray-300 mb-3"">
                                        <div class="form-check">
                                            <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault'.$value->id.'" value="'.$value->id.'"/>
                                            <label class="form-check-label text-dark" for="flexCheckDefault">
                                                Emp no.: '.$value->employee_no.'
                                            </label>
                                        </div>
                                        <p class="mb-0 fw-bold text-dark fs-4">'.$value->name1.'</p>
                                        <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>'.$value->position_name.'</p>
                                        <div class="row gx-2">
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>'.changedata_m($value->date_joined).'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-black"><span class="small text-gray-800">Service days:<br></span>'.$value->service_days.'</p>
                                            </div>
                                            <div class="col-4">
                                                <p class=""><span class="small text-gray-800">สถานะ:<br></span>'.$status_evaluation.'</p>
                                            </div>
                                        </div>
                                        <div class="QForm showdetail_score'.$value->id.'">

                                        </div>
                                        <h5 class="mb-2 text-black">Criteria</h5>
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',1,1,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,1);">
                                                    '.$select1.'
                                                </select>
                                                <div class="topic_weight_hidden_m'.$value->id.'" style="display:none;"></div>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',2,2,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,2);">
                                                    '.$select2.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',3,3,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,3);">
                                                   '.$select3.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',4,4,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,4);">
                                                    '.$select4.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',5,5,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,5);">
                                                    '.$select5.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',6,6,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,6);">
                                                    '.$select6.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',7,7,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,7);">
                                                    '.$select7.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                <select class="form-select form-select-sm calAll_m'.$value->id.'" onfocus="gettitle_m('.$value->group_form_id.',8,8,0,'.$value->id.');" onchange="update_score('.$value->id.',this.value,8);">
                                                    '.$select8.'
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onfocus="gettitle_m('.$value->group_form_id.',9,8,1,'.$value->id.');">'.($value->evaluation_criteria_score9?$value->evaluation_criteria_score9:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="complain_score_m'.$value->id.'" value="'.$value->evaluation_criteria_score9.'">
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onfocus="gettitle_m('.$value->group_form_id.',0,9,2,'.$value->id.');">'.($value->attendance_score?$value->attendance_score:'0').'</button>
                                                <input type="hidden" class="calAll_m'.$value->id.'" id="attendance_score_m'.$value->id.'" value="'.$value->attendance_score.'">
                                                <input type="hidden" class="calAll_topic_weight_m'.$value->id.'" value="2">
                                            </div>
                                        </div>
                                        <div class="row gx-2">
                                            <div class="col-12">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                    </div>',
                    );
                }
            }
        }

        $result = [
            'data'              => $data,
        ];
        echo json_encode($result);

    }

    public function get_form(Request $request)
    {
        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $nowyear = date('Ym');
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $CountF1 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }else{
                $CountF1 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }
        }else if($orisoft_code == "990002"){
            $CountF1 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else{
            $CountF1 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF1->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF1->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $CountF1->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $CountF1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != '0'){
            $CountF1->where('tb_employee_final_score.form_import', 'F1');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF1->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF1->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF1 = $CountF1->orderBy('tb_employee_final_score.id', 'DESC')->get();
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $CountF2 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }else{
                $CountF2 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }
        }else if($orisoft_code == "990002"){
            $CountF2 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else{
            $CountF2 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF2->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF2->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $CountF2->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $CountF2->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != '0'){
            $CountF2->where('tb_employee_final_score.form_import', 'F2');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF2->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF2->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF2->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF2 = $CountF2->orderBy('tb_employee_final_score.id', 'DESC')->get();

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $CountF3 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }else{
                $CountF3 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }
        }else if($orisoft_code == "990002"){
            $CountF3 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else{
            $CountF3 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF3->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF3->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $CountF3->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $CountF3->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != '0'){
            $CountF3->where('tb_employee_final_score.form_import', 'F3');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF3->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF3->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF3 = $CountF3->orderBy('tb_employee_final_score.id', 'DESC')->get();
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $CountF4 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }else{
                $CountF4 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.*',
                'tb_employee.date_joined AS date_joined',
                'tb_employee.employee_local_name_en AS name1',
                'tb_position.position_description AS position_name')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820');
            }
        }else if($orisoft_code == "990002"){
            $CountF4 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else{
            $CountF4 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.*',
            'tb_employee.date_joined AS date_joined',
            'tb_employee.employee_local_name_en AS name1',
            'tb_position.position_description AS position_name')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF4->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF4->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $CountF4->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $CountF4->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != '0'){
            $CountF4->where('tb_employee_final_score.form_import', 'F4');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF4->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF4->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF4->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $CountF4Raw = $CountF4->toRawSql();
        $CountF4 = $CountF4->orderBy('tb_employee_final_score.id', 'DESC')->get();
        $checkCountF1 = 0;
        $checkCountF1_same = 0;
        if(count($CountF1)>0){
            foreach ($CountF1 as $value) {
                $sub1 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub1);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF1++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF1_same++;
                    }
                }
            }
        }
        $checkCountF2 = 0;
        $checkCountF2_same = 0;
        if(count($CountF2)>0){
            foreach ($CountF2 as $value) {
                $sub2 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub2);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF2++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF2_same++;
                    }
                }
            }
        }
        $checkCountF3 = 0;
        $checkCountF3_same = 0;
        if(count($CountF3)>0){
            foreach ($CountF3 as $value) {
                $sub3 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub3);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF3++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF3_same++;
                    }
                }
            }
        }
        $checkCountF4 = 0;
        $checkCountF4_same = 0;
        if(count($CountF4)>0){
            foreach ($CountF4 as $value) {
                $sub4 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub4);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF4++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF4_same++;
                    }
                }
            }
        }
        $count_total_td = DB::table('group_form_topic')
                    ->select('id')
                    ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                    ->where('group_form.form_ref', $search_form)
                    ->whereIn('group_form.form_year_use_start', $previousYear)
                    ->whereIn('group_form.form_year_use_end', $previousYear)
                    ->count();
        $count_topic_weight = DB::table('group_form_topic')
                    ->select('group_form_topic.id','group_form_topic.topic_weight')
                    ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                    ->where('group_form.form_ref', $search_form)
                    ->whereIn('group_form.form_year_use_start', $previousYear)
                    ->whereIn('group_form.form_year_use_end', $previousYear)
                    ->get();
        $count_topic_weight2 = DB::table('group_form')
                    ->select('group_form.criteria_weight','group_form.compliance_weight')
                    ->where('group_form.form_ref', $search_form)
                    ->whereIn('group_form.form_year_use_start', $previousYear)
                    ->whereIn('group_form.form_year_use_end', $previousYear)
                    ->first();

        $result = [
            'f1'                => count($CountF1),
            'f2'                => count($CountF2),
            'f3'                => count($CountF3),
            'f4'                => count($CountF4),
            'f4raw'             => $CountF4Raw,
            'count_total_td'                => $count_total_td,
            'count_topic_weight'                => $count_topic_weight,
            'criteria_weight'                => $count_topic_weight2->criteria_weight,
            'compliance_weight'                => $count_topic_weight2->compliance_weight,
            'checkCountF1'                => $checkCountF1,
            'checkCountF2'                => $checkCountF2,
            'checkCountF3'                => $checkCountF3,
            'checkCountF4'                => $checkCountF4,
            'checkCountF1_same'                => $checkCountF1_same,
            'checkCountF2_same'                => $checkCountF2_same,
            'checkCountF3_same'                => $checkCountF3_same,
            'checkCountF4_same'                => $checkCountF4_same,
        ];
        echo json_encode($result);

    }

    public function get_form_all(Request $request)
    {
        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $nowyear = date('Ym');
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        $CountF1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){

        }else{
            if(!empty($search_section)){
                $CountF1->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $CountF1->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $CountF1->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }
        // if($search_form != '0'){
            $CountF1->where('tb_employee_final_score.form_import', 'F1');
        // }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF1->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF1->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF1 = $CountF1->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){

        }else{
            if(!empty($search_section)){
                $CountF2->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $CountF2->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $CountF2->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }
        // if($search_form != '0'){
            $CountF2->where('tb_employee_final_score.form_import', 'F2');
        // }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF2->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF2->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF2->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF2 = $CountF2->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){

        }else{
            if(!empty($search_section)){
                $CountF3->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $CountF3->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $CountF3->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }
        // if($search_form != '0'){
            $CountF3->where('tb_employee_final_score.form_import', 'F3');
        // }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF3->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF3->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF3 = $CountF3->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF4 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){

        }else{
            if(!empty($search_section)){
                $CountF4->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $CountF4->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $CountF4->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }
        // if($search_form != '0'){
            $CountF4->where('tb_employee_final_score.form_import', 'F4');
        // }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF4->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF4->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF4->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF4 = $CountF4->orderBy('tb_employee_final_score.id', 'DESC')->get();
        $checkCountF1 = 0;
        $checkCountF1_same = 0;
        if(count($CountF1)>0){
            foreach ($CountF1 as $value) {
                $sub1 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub1);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF1++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF1_same++;
                    }
                }
            }
        }
        $checkCountF2 = 0;
        $checkCountF2_same = 0;
        if(count($CountF2)>0){
            foreach ($CountF2 as $value) {
                $sub2 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub2);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF2++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF2_same++;
                    }
                }
            }
        }
        $checkCountF3 = 0;
        $checkCountF3_same = 0;
        if(count($CountF3)>0){
            foreach ($CountF3 as $value) {
                $sub3 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub3);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF3++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF3_same++;
                    }
                }
            }
        }
        $checkCountF4 = 0;
        $checkCountF4_same = 0;
        if(count($CountF4)>0){
            foreach ($CountF4 as $value) {
                $sub4 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub4);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF4++;
                    }
                }
                if($value->criteria_score_eva && $value->status_evaluation != '3' && $value->freeze == 0){
                    if($value->criteria_score_eva == $value->criteria_score_new){
                        $checkCountF4_same++;
                    }
                }
            }
        }

        $result = [
            'f1'                => count($CountF1),
            'f2'                => count($CountF2),
            'f3'                => count($CountF3),
            'f4'                => count($CountF4),
            // 'count_total_td'                => $count_total_td,
            'checkCountF1'                => $checkCountF1,
            'checkCountF2'                => $checkCountF2,
            'checkCountF3'                => $checkCountF3,
            'checkCountF4'                => $checkCountF4,
            'checkCountF1_same'                => $checkCountF1_same,
            'checkCountF2_same'                => $checkCountF2_same,
            'checkCountF3_same'                => $checkCountF3_same,
            'checkCountF4_same'                => $checkCountF4_same,
        ];
        echo json_encode($result);

    }

    public function check_value_null(Request $request)
    {
        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $nowyear = date('Ym');
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');

        $CountF1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF1->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF1->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if($search_form != '0'){
            $CountF1->where('tb_employee_final_score.form_import', 'F1');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF1->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF1->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF1 = $CountF1->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF2->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF2->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if($search_form != '0'){
            $CountF2->where('tb_employee_final_score.form_import', 'F2');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF2->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF2->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF2->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF2 = $CountF2->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF3->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF3->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if($search_form != '0'){
            $CountF3->where('tb_employee_final_score.form_import', 'F3');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF3->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF3->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF3 = $CountF3->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF4 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $CountF4->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $CountF4->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if($search_form != '0'){
            $CountF4->where('tb_employee_final_score.form_import', 'F4');
        }

        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $CountF4->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF4->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $CountF4->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF4 = $CountF4->orderBy('tb_employee_final_score.id', 'DESC')->get();
        $checkCountF1 = 0;
        if(count($CountF1)>0){
            foreach ($CountF1 as $value) {
                $sub1 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub1);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF1++;
                    }
                }
            }
        }
        $checkCountF2 = 0;
        if(count($CountF2)>0){
            foreach ($CountF2 as $value) {
                $sub2 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub2);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF2++;
                    }
                }
            }
        }
        $checkCountF3 = 0;
        if(count($CountF3)>0){
            foreach ($CountF3 as $value) {
                $sub3 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub3);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF3++;
                    }
                }
            }
        }
        $checkCountF4 = 0;
        if(count($CountF4)>0){
            foreach ($CountF4 as $value) {
                $sub4 = substr($value->criteria_score_new,0,-1);
                $explode = explode(',',$sub4);
                foreach ($explode as $value2) {
                    if($value2 == ''){
                        $checkCountF4++;
                    }
                }
            }
        }
        $result = [
            'checkCountF1'                => $checkCountF1,
            'checkCountF2'                => $checkCountF2,
            'checkCountF3'                => $checkCountF3,
            'checkCountF4'                => $checkCountF4,
        ];
        echo json_encode($result);
    }

    public function get_form_2(Request $request)
    {
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            if(is_array($search_year)){
                $previousYear = $search_year;
            }else{
                $previousYear[] = $search_year;
            }
        }else{
            $previousYear[] = date('Y');
        }
        $search_form      = $request->input('search_form');
        $count_total_td = DB::table('group_form_topic')
                    ->select('id')
                    ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                    ->where('group_form.form_ref', $search_form)
                    ->whereIn('group_form.form_year_use_start', $previousYear)
                    ->whereIn('group_form.form_year_use_end', $previousYear)
                    ->count();
        $count_topic_weight = DB::table('group_form_topic')
                    ->select('group_form_topic.id','group_form_topic.topic_weight')
                    ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                    ->where('group_form.form_ref', $search_form)
                    ->whereIn('group_form.form_year_use_start', $previousYear)
                    ->whereIn('group_form.form_year_use_end', $previousYear)
                    ->get();
        $count_topic_weight2 = DB::table('group_form')
                    ->select('group_form.criteria_weight','group_form.compliance_weight')
                    ->where('group_form.form_ref', $search_form)
                    ->whereIn('group_form.form_year_use_start', $previousYear)
                    ->whereIn('group_form.form_year_use_end', $previousYear)
                    ->first();
        $result = [
            'count_total_td'                => $count_total_td,
            'count_topic_weight'                => $count_topic_weight,
            'criteria_weight'                => $count_topic_weight2->criteria_weight,
            'compliance_weight'                => $count_topic_weight2->compliance_weight,
        ];
        echo json_encode($result);

    }

    public function update_score(Request $request)
    {
        $id      = $request->input('id');
        $criteria_score_old_all      = $request->input('criteria_score_old_all');
        $score      = $request->input('score');
        $total_score      = $request->input('total_score');
        $number      = $request->input('number');
        // if($number == '1'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score1' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '2'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score2' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '3'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score3' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '4'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score4' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '5'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score5' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '6'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score6' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '7'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score7' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '8'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score8' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }
        // if($number == '9'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score9' => $request->input('score'),
        //         'total_score' => $total_score
        //     ]);
        // }

        $getdata = DB::table('tb_employee_final_score')
        ->select('total_score','criteria_score_new')
        ->where('tb_employee_final_score.id', $request->input('id'))
        ->first();
        if($total_score > 0){
            DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
                'status_evaluation' => '1',
                'total_score' => $total_score,
                'criteria_score_old' => $getdata->criteria_score_new,
                'criteria_score_new' => $criteria_score_old_all
            ]);
        }

        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }
        $checkcount = 0;
        $check = explode(',',$criteria_score_old_all);
        foreach ($check as $value) {
            if($value == ""){
                $checkcount++;
            }
        }
        if($checkcount == 0){
            DB::table('tb_employee_final_score')
            ->where('id', $request->input('id') )
            ->update([
                "status_pa" => '4'
            ]);
        }

        $result = [
            'id'                => $id,
            'score'                => $score,
            'number'                => $number
        ];
        echo json_encode($result);

    }

    public function update_remark(Request $request)
    {
        $id             = $request->input('id');
        $remark         = $request->input('remark');
        DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
            'remark' => $request->input('remark')
        ]);
        $result = [
            'id'                => $id,
            'remark'                => $remark
        ];
        echo json_encode($result);
    }

    public function update_remark_manager(Request $request)
    {
        $id             = $request->input('id');
        $remark         = $request->input('remark');
        DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
            'remark_manager' => $request->input('remark')
        ]);
        $result = [
            'id'                => $id,
            'remark_manager'                => $remark
        ];
        echo json_encode($result);
    }

    public function gettitle(Request $request)
    {
        $id      = $request->input('id');
        $number      = $request->input('number');

        $data = DB::table('group_form_topic')
        ->select('group_form_topic.*',
                'evaluation_criteria.title_th AS criteria_th',
                'evaluation_criteria.title_en AS criteria_en',
                'group_form.criteria_weight',
                'group_form.compliance_weight',
                )
        ->leftJoin('evaluation_criteria','evaluation_criteria.id','=','group_form_topic.evaluation_criteria_id')
        ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id');

        if($id != ""){
            $data->where('group_form_topic.group_form_id', $id);
        }
        if($number != ""){
            $data->where('group_form_topic.evaluation_criteria_id', $number);
        }

        $data = $data->orderBy('group_form_topic.id', 'ASC')->first();

        $data2 = DB::table('group_form_score_level')->where('group_form_score_level.group_form_id', $id);
        $data2 = $data2->orderBy('group_form_score_level.id', 'ASC')->get();


        $data3 = DB::table('group_form')
        ->select('group_form.criteria_weight',
                'group_form.compliance_weight',
                );
        $data3 = $data3->where('group_form.id', $id)->first();

        $result = [
            'data'                => $data,
            'data2'               => $data2,
            'compliance_weight'     => $data3->compliance_weight,
            'criteria_weight'     => $data3->criteria_weight,
        ];
        echo json_encode($result);

    }

    public function evaluate_get_all(Request $request)
    {
        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $orisoft_code = Auth::user()->orisoft_code;

        if($orisoft_code == "000002"){
            $division_code = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.division_code'
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else if($orisoft_code == "000026"){
            $division_code = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.division_code'
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else if($orisoft_code == "990002"){
            $division_code = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.division_code'
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }else{
            $division_code = DB::table('tb_employee_final_score')
            ->select(
            'tb_employee.division_code'
            )
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820');
        }
        $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        $new_division_code = [];
        if(count($division_code)>0){
            foreach ($division_code as $value) {
                array_push($new_division_code,$value->division_code);
            }
        }
        // echo json_encode($division_code);
        // exit;
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }
        if($orisoft_code == "000002" || $orisoft_code == "990002"){
            $data = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation','>=', '0')
            ->whereIn('tb_employee.division_code',$new_division_code)
            ;
        }else if($orisoft_code == "000026"){
            $data = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation','>=', '0')
            ->whereIn('tb_employee.division_code',$new_division_code)
            ;
        }else{
            $data = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation','>=', '0')
            ->whereIn('tb_employee.division_code',$new_division_code)
            ;
        }
        if(trans(request()->segment(1)) == 'manager'){
            if($orisoft_code == "000002"){
                $data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){

            }else{
                $data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                $data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){

            }else{
                $data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $data->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $data->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $data->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $data->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if($search_form != '0'){
        //     $data->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $data->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data = $data->count();
        // echo json_encode($division_code);
        // exit;
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $data1 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '<=' ,'1')
                ->whereIn('tb_employee.division_code',$new_division_code);
            }else{
                $data1 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '<=' ,'1')
                ->whereIn('tb_employee.division_code',$new_division_code);
            }
        }else if($orisoft_code == "990002"){
            $data1 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation', '<=' ,'1')
            ->whereIn('tb_employee.division_code',$new_division_code);
        }else{
            $data1 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation', '<=' ,'1')
            ->whereIn('tb_employee.division_code',$new_division_code);
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $data1->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $data1->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $data1->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $data1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if($search_form != '0'){
        //     $data1->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $data1->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data1->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data1 = $data1->count();

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $data2 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '2')
                ->whereIn('tb_employee.division_code',$new_division_code);
            }else{
                $data2 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '2')
                ->whereIn('tb_employee.division_code',$new_division_code);
            }
        }else if($orisoft_code == "990002"){
            $data2 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation', '2')
            ->whereIn('tb_employee.division_code',$new_division_code);
        }else{
            $data2 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation', '2')
            ->whereIn('tb_employee.division_code',$new_division_code);
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $data2->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $data2->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $data2->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $data2->where('tb_employee_final_score.salary_type','Monthly');
            }
        }

        // if($search_form != '0'){
        //     $data2->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $data2->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data2->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data2->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data2 = $data2->count();

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){
                $data3 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '3')
                ->whereIn('tb_employee.division_code',$new_division_code);
            }else{
                $data3 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '3')
                ->whereIn('tb_employee.division_code',$new_division_code);
            }
        }else if($orisoft_code == "990002"){
            $data3 = DB::table('tb_employee_final_score')
                ->select('tb_employee_final_score.id')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like',$previousYear)
                ->where('tb_employee.employee_status_description','Passed')
                ->whereNot('tb_employee.grade_code','L810')
                ->whereNot('tb_employee.grade_code','L820')
                ->where('tb_employee_final_score.status_evaluation', '3')
                ->whereIn('tb_employee.division_code',$new_division_code);
        }else{
            $data3 = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.id')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
            ->where('tb_employee_final_score.rec_year','like',$previousYear)
            ->where('tb_employee.employee_status_description','Passed')
            ->whereNot('tb_employee.grade_code','L810')
            ->whereNot('tb_employee.grade_code','L820')
            ->where('tb_employee_final_score.status_evaluation', '3')
            ->whereIn('tb_employee.division_code',$new_division_code);
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $data3->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $data3->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $data3->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $data3->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if($search_form != '0'){
        //     $data3->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $data3->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data3->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data3 = $data3->count();

        $result = [
            'data'                => $data,
            'data1'               => $data1,
            'data2'               => $data2,
            'data3'               => $data3,
            'orisoft_code'        => $orisoft_code
        ];
        echo json_encode($result);

    }


    public function evaluate_get_all_review(Request $request)
    {
        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $division_code = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->where('tb_employee.employee_status_description','Passed')
        // ->whereNot('tb_employee.grade_code','L810')
        // ->whereNot('tb_employee.grade_code','L820');
        // $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        // $new_division_code = [];
        // if(count($division_code)>0){
        //     foreach ($division_code as $value) {
        //         array_push($new_division_code,$value->division_code);
        //     }
        // }

        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            if(is_array($search_year)){
                $previousYear = $search_year;
            }else{
                $previousYear = [$search_year];
            }
        }else{
            $previousYear[] = date('Y');
        }
        // $data = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->where('tb_employee_final_score.rec_year','like',$previousYear)
        // ->where('tb_employee.employee_status_description','Passed')
        // ->whereNot('tb_employee.grade_code','L810')
        // ->whereNot('tb_employee.grade_code','L820')
        // ->where('tb_employee_final_score.freeze','1');

        $data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->whereIn('tb_employee_final_score.rec_year',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation' ,'>=','1')
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->whereIn('tb_employee_evaluator.rec_year',$previousYear)
        ->where('employee_no',$orisoft_code)->first();

        if(trans(request()->segment(1)) == 'manager'){
            $data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                $data->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){

            }else{
                $data->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }

        if($orisoft_code == "000002"){

        }else if($orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $data = $data->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if(!empty($search_division_code)){
                if(in_array('all', $search_division_code)){
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
                    $data = $data->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $data = $data->whereIn('tb_employee.division_code',$search_division_code);
                }
            }

            if(!empty($search_department_code)){
                    if(in_array('all', $search_department_code)){
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
                    $data = $data->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $data = $data->whereIn('tb_employee.department_code',$search_department_code);
                }
            }

        }
        // ->where('tb_employee_final_score.status_evaluation','>=', '0')
        // ->whereIn('tb_employee.division_code',$new_division_code);
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $data->where('tb_employee.division_code', $search_division_code);
        //     }
        // }
        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $data->where('tb_employee.department_code', $search_department_code);
        //     }
        // }
        if($search_employee_no != "all"){
            $data->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $data->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }
        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $data->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $data->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $data->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        // if($search_form != '0'){
        //     $data->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if($search_status == '1'){
                $data->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $datax_count = $data->get();
        $data_count = $data->count();

        // $data1 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->where('tb_employee_final_score.rec_year','like',$previousYear)
        // ->where('tb_employee.employee_status_description','Passed')
        // ->whereNot('tb_employee.grade_code','L810')
        // ->whereNot('tb_employee.grade_code','L820')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.status_evaluation', '<=' ,'1')
        // ->whereIn('tb_employee.division_code',$new_division_code);
        $data1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->whereIn('tb_employee_final_score.rec_year',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation' ,'1')
        ;

        if(trans(request()->segment(1)) == 'manager'){
            $data1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                $data1->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){

            }else{
                $data1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }

        if($orisoft_code == "000002"){

        }else if($orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $data1 = $data1->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if(!empty($search_division_code)){
                if(in_array('all', $search_division_code)){
                    $checka1 = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code1 = [];
                    if($checka1 >= 0){
                        $ex1 = explode(',',$orisoft_all_code->division_code);
                        if(count($ex1)>0){
                            foreach ($ex1 as $value) {
                                array_push($arr_division_code1,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code1,$orisoft_all_code->division_code);
                    }
                    $data1 = $data1->whereIn('tb_employee.division_code',$arr_division_code1);
                }else{
                    $data1 = $data1->whereIn('tb_employee.division_code',$search_division_code);
                }
            }

            if(!empty($search_department_code)){
                if(in_array('all', $search_department_code)){
                    $arr_department_code1 = [];
                    $checka1 = strpos($orisoft_all_code->department_code,',');
                    if($checka1 >= 0){
                        $ex1 = explode(',',$orisoft_all_code->department_code);
                        if(count($ex1)>0){
                            foreach ($ex1 as $value) {
                                array_push($arr_department_code1,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code1,$orisoft_all_code->department_code);
                    }
                    $data1 = $data1->whereIn('tb_employee.department_code',$arr_department_code1);
                }else{
                    $data1 = $data1->whereIn('tb_employee.department_code',$search_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $data1->where('tb_employee.division_code', $search_division_code);
        //     }
        // }
        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $data1->where('tb_employee.department_code', $search_department_code);
        //     }
        // }
        if($search_employee_no != "all"){
            $data1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $data1->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }
        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $data1->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $data1->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $data1->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        // if($search_form != '0'){
        //     $data1->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if($search_status == '1'){
                $data1->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data1->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data1_count = $data1->count();

        // $data2 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->where('tb_employee_final_score.rec_year','like',$previousYear)
        // ->where('tb_employee.employee_status_description','Passed')
        // ->whereNot('tb_employee.grade_code','L810')
        // ->whereNot('tb_employee.grade_code','L820')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.status_evaluation', '2')
        // ->whereIn('tb_employee.division_code',$new_division_code);

        $data2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->whereIn('tb_employee_final_score.rec_year', $previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '2')
        ;
        if(trans(request()->segment(1)) == 'manager'){
            $data2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }elseif($orisoft_code == "000026"){
            $data2 = $data2->where('tb_employee_final_score.evaluator_no','000026');
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                $data2->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){

            }else{
                $data2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }

        if($orisoft_code == "000002"){

        }else if($orisoft_code == "990002"){

        }else{
            if(!empty($search_division_code)){
                if(in_array('all', $search_division_code)){
                    $checka2 = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code2 = [];
                    if($checka2 >= 0){
                        $ex2 = explode(',',$orisoft_all_code->division_code);
                        if(count($ex2)>0){
                            foreach ($ex2 as $value) {
                                array_push($arr_division_code2,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code2,$orisoft_all_code->division_code);
                    }
                    $data2 = $data2->whereIn('tb_employee.division_code',$arr_division_code2);
                }else{
                    $data2 = $data2->whereIn('tb_employee.division_code',$search_division_code);
                }
            }

            if(!empty($search_department_code)){
                if(in_array('all', $search_department_code)){
                    $arr_department_code2 = [];
                    $checka2 = strpos($orisoft_all_code->department_code,',');
                    if($checka2 >= 0){
                        $ex2 = explode(',',$orisoft_all_code->department_code);
                        if(count($ex2)>0){
                            foreach ($ex2 as $value) {
                                array_push($arr_department_code2,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code2,$orisoft_all_code->department_code);
                    }
                    $data2 = $data2->whereIn('tb_employee.department_code',$arr_department_code2);
                }else{
                    $data2 = $data2->whereIn('tb_employee.department_code',$search_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $data2->where('tb_employee.division_code', $search_division_code);
        //     }
        // }
        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $data2->where('tb_employee.department_code', $search_department_code);
        //     }
        // }
        if($search_employee_no != "all"){
            $data2->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $data2->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }
        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $data2->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $data2->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $data2->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }
        // if($search_form != '0'){
        //     $data2->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if($search_status == '1'){
                $data2->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data2->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data2->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data2_count = $data2->count();

        // $data3 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->where('tb_employee_final_score.rec_year','like',$previousYear)
        // ->where('tb_employee.employee_status_description','Passed')
        // ->whereNot('tb_employee.grade_code','L810')
        // ->whereNot('tb_employee.grade_code','L820')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.status_evaluation', '3')
        // ->whereIn('tb_employee.division_code',$new_division_code);
        $data3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->whereIn('tb_employee_final_score.rec_year', $previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ;
        if(trans(request()->segment(1)) == 'manager'){
            $data3->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($orisoft_code == "000002"){
                $data3->where('tb_employee_final_score.evaluator_no',$orisoft_code);
            }else if($orisoft_code == "990002"){

            }else{
                $data3->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
            }
        }else{

        }
        if($orisoft_code == "000002"){

        }else if($orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $data3 = $data3->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if(!empty($search_division_code)){
                if(in_array('all', $search_division_code)){
                    $checka3 = strpos($orisoft_all_code->division_code,',');
                    $arr_division_code3 = [];
                    if($checka3 >= 0){
                        $ex3 = explode(',',$orisoft_all_code->division_code);
                        if(count($ex3)>0){
                            foreach ($ex3 as $value) {
                                array_push($arr_division_code3,$value);
                            }
                        }
                    }else{
                        array_push($arr_division_code3,$orisoft_all_code->division_code);
                    }
                    $data3 = $data3->whereIn('tb_employee.division_code',$arr_division_code3);
                }else{
                    $data3 = $data3->whereIn('tb_employee.division_code',$search_division_code);
                }
            }

            if(!empty($search_department_code)){
                if(in_array('all', $search_department_code)){
                    $arr_department_code3 = [];
                    $checka3 = strpos($orisoft_all_code->department_code,',');
                    if($checka3 >= 0){
                        $ex3 = explode(',',$orisoft_all_code->department_code);
                        if(count($ex3)>0){
                            foreach ($ex3 as $value) {
                                array_push($arr_department_code3,$value);
                            }
                        }
                    }else{
                        array_push($arr_department_code3,$orisoft_all_code->department_code);
                    }
                    $data3 = $data3->whereIn('tb_employee.department_code',$arr_department_code3);
                }else{
                    $data3 = $data3->whereIn('tb_employee.department_code',$search_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $data3->where('tb_employee.division_code', $search_division_code);
        //     }
        // }
        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $data3->where('tb_employee.department_code', $search_department_code);
        //     }
        // }
        if($search_employee_no != "all"){
            $data3->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $data3->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }
        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $data3->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!empty($search_month_day)){
            if(!in_array("all", $search_month_day)){
                if(in_array("1", $search_month_day)){
                    $data3->where('tb_employee_final_score.salary_type','Daily');
                }
                if(in_array("2", $search_month_day)){
                    $data3->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }
        // if($search_form != '0'){
        //     $data3->where('tb_employee_final_score.form_import', $search_form);
        // }
        if(!empty($search_status)){
            if($search_status == '1'){
                $data3->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $data3->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }
        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $data3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $data3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $data3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }
        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $data3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $data3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $data3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }
        $data3_count = $data3->count();

        $result = [
            'data'                => $data_count,
            'data1'               => $data1_count,
            'data2'               => $data2_count,
            'data3'               => $data3_count,
            'datax'               => $datax_count,

            'data_query'                => $data->toRawSql(),
            'data1_query'               => $data1->toRawSql(),
            'data2_query'               => $data2->toRawSql(),
            'data3_query'               => $data3->toRawSql(),
            // 'orisoft_code'        => $orisoft_code
        ];
        echo json_encode($result);

    }

    public function count_pa_grade(Request $request)
    {
        $search_division      = $request->input('search_division');
        $search_department      = $request->input('search_department');
        $search_section      = $request->input('search_section');
        $search_employee_no      = $request->input('search_employee_no');
        $search_status      = $request->input('search_status');
        $search_month_day      = $request->input('search_month_day');

        $orisoft_code = Auth::user()->orisoft_code;
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear = date('Y');
        }
        $data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        // ->where('tb_employee_final_score.status_evaluation','>=', '1')
        ;

        if(isset($search_division)){
            if(count($search_division) > 0){
                $data->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $data->whereIn('tb_employee.section_code', $search_section);
                    }
                }
            }
        }else{
            if(isset($search_section)){
                if(count($search_section) > 0){
                    $data->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }

        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $data->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $data = $data->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all"){
        //     $data = $data->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all"){
        //     $data = $data->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all"){
        //     $data = $data->whereIn('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if(!empty($search_status)){
        //     $data = $data->whereIn('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $data = $data->count();
        // $data = $data->skip(0)->take(22)->count();

        $data1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->whereNull('tb_employee_final_score.adjust_grade');

        if(isset($search_division)){
            if(count($search_division) > 0){
                $data1->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data1->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $data1->whereIn('tb_employee.section_code', $search_section);
                    }
                }
            }
        }else{
            if(isset($search_section)){
                if(count($search_section) > 0){
                    $data1->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }

        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $data1->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $data1 = $data1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all"){
        //     $data1 = $data1->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all"){
        //     $data1 = $data1->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all"){
        //     $data1 = $data1->whereIn('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data1->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if(!empty($search_status)){
        //     $data1 = $data1->whereIn('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $data1 = $data1->count();
        // $data1 = $data1->skip(0)->take(22)->count();

        $data2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '2');

        if(isset($search_division)){
            if(count($search_division) > 0){
                $data2->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data2->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $data2->whereIn('tb_employee.section_code', $search_section);
                    }
                }
            }
        }else{
            if(isset($search_section)){
                if(count($search_section) > 0){
                    $data2->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }

        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $data2->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $data2 = $data2->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all"){
        //     $data2 = $data2->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all"){
        //     $data2 = $data2->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all"){
        //     $data2 = $data2->whereIn('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data2->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data2->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if(!empty($search_status)){
        //     $data2 = $data2->whereIn('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $data2 = $data2->count();
        // $data2 = $data2->skip(0)->take(22)->count();

        $data3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->whereNotNull('tb_employee_final_score.adjust_grade');

        if(isset($search_division)){
            if(count($search_division) > 0){
                $data3->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data3->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $data3->whereIn('tb_employee.section_code', $search_section);
                    }
                }
            }
        }else{
            if(isset($search_section)){
                if(count($search_section) > 0){
                    $data3->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }

        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $data3->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $data3 = $data3->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all"){
        //     $data3 = $data3->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all"){
        //     $data3 = $data3->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all"){
        //     $data3 = $data3->whereIn('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data3->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data3->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if(!empty($search_status)){
        //     $data3 = $data3->whereIn('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $data3 = $data3->count();
        // $data3 = $data3->skip(0)->take(22)->count();






        $data4 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze_to_pagrade','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if(isset($search_division)){
            if(count($search_division) > 0){
                $data4->whereIn('tb_employee.division_code', $search_division);
            }
        }
        if(isset($search_department)){
            if(count($search_department) > 0){
                $data4->whereIn('tb_employee.department_code', $search_department);
            }
        }
        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(isset($search_section)){
                    if(count($search_section) > 0){
                        $data4->whereIn('tb_employee.section_code', $search_section);
                    }
                }
            }
        }else{
            if(isset($search_section)){
                if(count($search_section) > 0){
                    $data4->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }

        if($search_employee_no){
            if(count($search_employee_no) > 0){
                $data4->whereIn('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }
        // if($search_employee_no != "all"){
        //     $data4 = $data4->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_division != "all"){
        //     $data4 = $data4->where('tb_employee.division_code', $search_division);
        // }
        // if($search_department != "all"){
        //     $data4 = $data4->where('tb_employee.department_code', $search_department);
        // }
        // if($search_section != "all"){
        //     $data4 = $data4->whereIn('tb_employee.section_code', $search_section);
        // }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $data4->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $data4->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if(!empty($search_status)){
        //     $data4 = $data4->whereIn('tb_employee_final_score.status_evaluation', $search_status);
        // }
        $data4 = $data4->count();

        $result = [
            'data'                => $data,
            'data1'               => $data1,
            'data2'               => $data2,
            'data3'               => $data3,
            'data4'               => $data4,
        ];
        echo json_encode($result);

    }

    public function get_compliance_attendance(Request $request)
    {
        $id      = $request->input('id');
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }
        $data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.attendance_abt',
        'attendance_wwar',
        'attendance_vwar',
        'attendance_abs',
        'attendance_sl',
        'attendance_pl',
        'attendance_late',
        'attendance_sus'
        )
        ->where('id',$id)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->first();
        echo json_encode($data);

    }

    public function freeze(Request $request)
    {
        $search_year      = $request->input('search_year');
        $year_array = [];
        if(!empty($search_year)){
            array_push($year_array, $search_year);
        }else{
            array_push($year_array, date('Y'));
        }

        $orisoft_code = Auth::user()->orisoft_code;
        $tb_employee_evaluator = DB::table('tb_employee_evaluator')
        ->whereIn('tb_employee_evaluator.rec_year',$year_array)
        ->where('employee_no',$orisoft_code)->first();

        if(trans(request()->segment(1)) == 'manager'){
            // $arr = ['101','114'];
            $arrManager = ['101','114'];
            $arrAsst = ['101','114'];
        }else if(trans(request()->segment(1)) == 'mtl'){
            // $arr = ['101','114'];
            $arrManager = ['103','104','105','108'];
            $arrAsst = ['103','104','105','108'];
        }else{
            $arrManager = ['105','103'];
            $arrAsst = ['105','106','103','114'];
        }

        // dd($orisoft_code, $tb_employee_evaluator, $year_array);

        $email = '';
        $section_code = '';
        $employee_no = '';
        $datarow = DB::table('tb_employee_evaluator')
        ->whereIn('tb_employee_evaluator.rec_year',$year_array)
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->whereIn('tb_employee_evaluator.position_code',$arrManager);
        $checka = strpos($tb_employee_evaluator->section_code,',');
        if($checka >= 0){
            $ex = explode(',',$tb_employee_evaluator->section_code);
            if(count($ex)>0){
                foreach ($ex as $value) {
                    $datarow->where(function ($query) use($value) {
                        $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                    });
                }
            }
        }else{
            $datarow = $datarow->Where('tb_employee_evaluator.section_code','like','%'.$tb_employee_evaluator->section_code.'%');
        }
        $datarow = $datarow->first();

        if(!$datarow){
            $datarow2 = DB::table('tb_employee_evaluator')
            ->whereIn('tb_employee_evaluator.rec_year',$year_array)
            ->where('tb_employee_evaluator.evaluator_active','1')
            ->whereIn('tb_employee_evaluator.position_code',$arrAsst);
            $checka = strpos($tb_employee_evaluator->section_code,',');
            // dd($checka);
            if($checka){
                $ex = explode(',',$tb_employee_evaluator->section_code);

                if(count($ex)>0){
                    foreach ($ex as $value) {
                        $section_code .= $value.',';
                        $datarow2->where(function ($query) use($value) {
                            $query->orWhere('tb_employee_evaluator.section_code','like','%'.$value.'%');
                        });
                    }
                    $section_code = substr($section_code,0,-2);
                }
            }else{
                $section_code = $tb_employee_evaluator->section_code;
                $datarow2 = $datarow2->Where('tb_employee_evaluator.section_code','like','%'.$tb_employee_evaluator->section_code.'%');
            }
            $datarow2 = $datarow2->first();
            // dd($datarow2);
            // exit;
            if($datarow2){
                $employee_no = $datarow2->employee_no;
            }

        }else{
            $section_code = $tb_employee_evaluator->section_code;
            $employee_no = $datarow->employee_no;
        }
        // dd($section_code);
        // exit;




        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        $search_year       = $request->input('search_year');
        $previousYear = [];

        if(!empty($search_year)){
            array_push($previousYear, $search_year);
        }else{
            $previousYear[] = date('Y');
        }

        $data1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->whereIn('tb_employee_final_score.rec_year',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation', '<=' ,'2');

        // $data1 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.id')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        // ->where('tb_employee_final_score.rec_year','like',$previousYear)
        // ->where('tb_employee_final_score.status_evaluation', '<=' ,'1');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $data1->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $data1->whereIn('tb_employee.section_code', $search_section);
            }
        }

        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $data1->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $data1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $data1 = $data1->get();

        if($data1){
            foreach ($data1 as $key => $value) {
                if($value->freeze == '0' && $value->status_evaluation == '2'){
                    DB::table('tb_employee_final_score')
                    ->whereIn('tb_employee_final_score.rec_year',$previousYear)
                    ->where('id', $value->id )
                    ->update([
                        "status_evaluation" => '1'
                    ]);
                }
                DB::table('tb_employee_final_score')
                ->whereIn('tb_employee_final_score.rec_year',$previousYear)
                ->where('id', $value->id )
                ->update([
                    "freeze" => '1',
                    "criteria_score_eva" => $value->criteria_score_new
                ]);
            }

        }

        $users = DB::table('users')
        ->select('email')
        ->where('orisoft_code',$employee_no)->first();
        // dd($section_code);
        // exit;
        if (trans(request()->segment(1)) == 'mtl') {
            $link = 'http://milepa/mtl/evaluateReview';
        } else if (trans(request()->segment(1)) == 'manager') {
            $link = 'http://milepa/manager/evaluateReview';
        } else {
            $link = 'http://milepa/mil/evaluateReview';
        }
        $count = 0;
        $view_mail = '<html>
                        <body>
                            <p>Production Link for EPA (ฐานข้อมูลจริงที่ใช้ประเมินผล)</p>
                            <a href="http://milepa" target="_blank"><p>'.$link.'</p></a>
                            <p>Evaluator Code : '.$tb_employee_evaluator->employee_no.'</p>
                            <p>Evaluator Name : '.(Session::get('locale') == "th"?$tb_employee_evaluator->employee_name_th:$tb_employee_evaluator->employee_name_en).'</p>
                            <p>Section Code : '.$section_code.'</p>
                        </body>
                    </html>';
        $arr = [$users->email];
        // $arr = ['koranatsoi17@gmail.com'];
        if($users->email){
            $save = Mail::send([], ['Evaluator has completed the evaluation. - '.$section_code], function ($message) use ($view_mail,$arr,$section_code) {
                $message
                // ->from($address = 'koranatsoi17@gmail.com', $name = 'koranatsoi17')
                // ->to('koranatsoi17@gmail.com')
                ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                ->to($arr)
                ->subject('Evaluator has completed the evaluation. - '.$section_code);
                $message->html($view_mail);
            });
            if($save){
                $count++;
            }
            else{
                $count = 0;
            }
        }

        $search_year       = $request->input('search_year');
        $checkYearABC = [];

        if(!empty($search_year)){
            array_push($checkYearABC, $search_year);
        }else{
            $checkYearABC[] = date('Y');
        }
        // $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->whereIn('tb_employee_final_score.rec_year',$checkYearABC)
        ->where('tb_employee_final_score.freeze','0')
        ->where('tb_employee.employee_status_description','Passed')
        ->count();
        if($countABC == 0){
            $tb_pa_timeline = DB::table('tb_pa_timeline')->whereIn('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                ->get();
                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($key == 2 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }

        $result = [
            'status'                => 200,
            'data'                      => $data1,
            'sendmail'                      => ($count > 0?200:500),
        ];
        echo json_encode($result);

    }

    public function freeze_to_pagrade(Request $request)
    {
        $search_year       = $request->input('search_year');
        if(!empty($search_year)){
            $previousYear = $search_year;
        }else{
            $previousYear[] = date('Y');
        }

        $userID = Auth::user()->id;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_month_day      = $request->input('search_month_day');
        $search_form         = $request->input('search_form');

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        if(!empty($search_form)){
            $datarow->where('tb_employee_final_score.form_import', $search_form);
        }

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like',$previousYear)
        ->where('employee_no',$orisoft_code)->first();


        if(is_array($search_department_code)){
            if(in_array('all',$search_division_code)){
                if($orisoft_code == "990002" || $orisoft_code == "000002"){

                }else{
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
            }else{
                $datarow->whereIn('tb_employee.division_code', $search_division_code);
            }
        }else{
            if($search_division_code == "all"){
                if($orisoft_code == "990002" || $orisoft_code == "000002"){

                }else{
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
            }else{
                $datarow->where('tb_employee.division_code', $search_division_code);
            }
        }


        if(is_array($search_department_code)){
            if(in_array('all',$search_department_code)){
                if($orisoft_code == "990002" || $orisoft_code == "000002"){

                }else{
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
            }else{
                $datarow->whereIn('tb_employee.department_code', $search_department_code);
            }
        }else{
            if($search_department_code == "all"){
                if($orisoft_code == "990002" || $orisoft_code == "000002"){

                }else{
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
            }else{
                $datarow->where('tb_employee.department_code', $search_department_code);
            }
        }
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)

        // exit;
        // if(isset($search_division_code)){
        //     if($search_division_code != "all"){
        //         $datarow->where('tb_employee.division_code', $search_division_code);
        //     }
        // }

        // if(isset($search_department_code)){
        //     if($search_department_code != "all"){
        //         $datarow->where('tb_employee.department_code', $search_department_code);
        //     }
        // }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $datarow->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(isset($search_section)){
                    if($search_section != "all"){
                        $datarow->whereIn('tb_employee.section_code', $search_section);
                    }
                }
            }
        }else{
            if(isset($search_section)){
                if(is_array($search_section)){
                    if(!in_array('all', $search_section)){
                        $datarow->whereIn('tb_employee.section_code', $search_section);
                    }
                }else{
                    if($search_section != "all"){
                        $datarow->where('tb_employee.section_code', $search_section);
                    }
                }

            }
        }


        if(isset($search_month_day)){
            if(in_array("1", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        // if(isset($search_status)){
        //     $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        // }

        if(isset($search_complaince_score)){
            if($search_complaince_score == "1"){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(isset($search_attendance_score)){
            if($search_attendance_score == "1"){
                $datarow->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $datarow->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $datarow->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }


        $datarow_res = $datarow->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.total_score', 'ASC')->get();


        if($datarow_res){
            foreach ($datarow_res as $key => $value) {
                DB::table('tb_employee_final_score')
                ->where('id', $value->id )
                ->update([
                    "freeze_to_pagrade" => '1'
                ]);
            }

        }
        $search_year       = $request->input('search_year');
        $checkYearABC = $search_year;
        if(empty($search_year)){
            $checkYearABC = date('Y');
        }

        // $checkYearABC = date('Y');
        $countABC = DB::table('tb_employee_final_score')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
        ->where('tb_employee_final_score.freeze_to_pagrade','0')
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
                        if($key == 3 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                    }
                }
            }
        }

        $result = [
            'status'                => 200,
            'data'                      => $datarow_res,
            'data_sql'              => $datarow->toRawSql()
        ];
        echo json_encode($result);

    }

    public function export_excel_evaluate(Request $request)
    {
        function changedata($val){
            $newdate = '';
            $array = ['',"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
            if($val != "" && $val != null && $val != "0000-00-00 00:00:00"){
                $newdate = date("d",strtotime($val)).'-'.$array[date('n',strtotime($val))].'-'.(date("Y",strtotime($val)));

            }
            return $newdate;
        }
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_month_day      = $request->input('search_month_day');

        $datarowx = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $datarowx->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $datarowx->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $datarowx->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $datarowx->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $datarowx->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarowx->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $datarowx->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $datarowx->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $datarowx->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $datarowx->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $datarowx->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $datarowx->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $datarowx = $datarowx->orderBy('tb_employee_final_score.total_score', 'DESC')->get();
        if($datarowx){
            foreach ($datarowx as $key => $value) {
                $attendance_score = round($value->attendance_score);
                if($attendance_score >= 0 && $attendance_score <= 2){
                    $value->attendance_score = 10;
                }else if($attendance_score >= 17 && $attendance_score <= 18){
                    $value->attendance_score = 2;
                }else if($attendance_score >= 15 && $attendance_score <= 16){
                    $value->attendance_score = 3;
                }else if($attendance_score >= 13 && $attendance_score <= 14){
                    $value->attendance_score = 4;
                }else if($attendance_score >= 11 && $attendance_score <= 12){
                    $value->attendance_score = 5;
                }else if($attendance_score >= 9 && $attendance_score <= 10){
                    $value->attendance_score = 6;
                }else if($attendance_score >= 7 && $attendance_score <= 8){
                    $value->attendance_score = 7;
                }else if($attendance_score >= 5 && $attendance_score <= 6){
                    $value->attendance_score = 8;
                }else if($attendance_score >= 3 && $attendance_score <= 4){
                    $value->attendance_score = 9;
                }else{
                    $value->attendance_score = 1;
                }

                $compliance_score = round($value->compliance_score);
                $value->compliance_score = $compliance_score;

                $callll = 0;
                $callll_criteria = '';
                if($value->freeze == '1'){
                    $expl = explode(',',$value->criteria_score_eva);
                }else{
                    $expl = explode(',',$value->criteria_score_new);
                }
                if(!empty($expl)){
                    foreach($expl as $key2 => $value2) {
                        $test2 = DB::table('group_form_topic')
                        ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                        ->whereIn('group_form.form_year_use_start',$previousYear)
                        ->where('group_form_topic.group_form_id',$value->group_form_id)
                        ->orderBy('group_form_topic.id','ASC')
                        ->get();
                        foreach($test2 as $key3 => $value3) {
                            if($key2 == $key3){
                                if($value2>0){
                                    $callll += $value2*$value3->topic_weight;
                                    $callll_criteria .= $value2*$value3->topic_weight.'__';
                                }

                            }
                        }
                    }
                }
                $test22 = DB::table('group_form')
                        ->whereIn('group_form.form_year_use_start',$previousYear)
                        ->where('group_form.id',$value->group_form_id)
                        ->first();
                $callll = $callll+($value->compliance_score*$test22->compliance_weight);


                $attendance_scorezzz = 0;
                // $attendance_score = round($value->attendance_score);
                if($attendance_score >= 0 && $attendance_score <= 2){
                    $attendance_scorezzz = 10;
                }else if($attendance_score >= 17 && $attendance_score <= 18){
                    $attendance_scorezzz = 2;
                }else if($attendance_score >= 15 && $attendance_score <= 16){
                    $attendance_scorezzz = 3;
                }else if($attendance_score >= 13 && $attendance_score <= 14){
                    $attendance_scorezzz = 4;
                }else if($attendance_score >= 11 && $attendance_score <= 12){
                    $attendance_scorezzz = 5;
                }else if($attendance_score >= 9 && $attendance_score <= 10){
                    $attendance_scorezzz = 6;
                }else if($attendance_score >= 7 && $attendance_score <= 8){
                    $attendance_scorezzz = 7;
                }else if($attendance_score >= 5 && $attendance_score <= 6){
                    $attendance_scorezzz = 8;
                }else if($attendance_score >= 3 && $attendance_score <= 4){
                    $attendance_scorezzz = 9;
                }else{
                    $attendance_scorezzz = 1;
                }

                $callll = $callll+($attendance_scorezzz*$test22->criteria_weight);

                $tb_employee_final_scorex = DB::table('tb_employee_final_score')->where('id',$value->id)->first();
                if(!$tb_employee_final_scorex->total_score_old){
                    if($tb_employee_final_scorex->total_score_old == 0){
                        DB::table('tb_employee_final_score')->where('id',$value->id)
                        ->update([
                            "total_score_old" => $callll,
                        ]);
                    }
                }
            }
        }






        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like',$previousYear)
        ->where('tb_employee.employee_status_description','Passed')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002"){
            if(trans(request()->segment(1)) == 'manager' || trans(request()->segment(1)) == 'mtl'){

            }else{
                if(!empty($search_section)){
                    $datarow->whereIn('tb_employee.section_code', $search_section);
                }
            }
        }else{
            if(!empty($search_section)){
                $datarow->whereIn('tb_employee.section_code', $search_section);
            }
        }
        if(!in_array("all", $search_month_day)){
            if(in_array("1", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if(in_array("2", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if(!empty($search_status)){
            if(in_array('1' , $search_status)){
                $datarow->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarow->whereIn('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if(!empty($search_complaince_score)){
            if(in_array("1", $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if(in_array("2", $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if(in_array("3", $search_complaince_score)){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if(!empty($search_attendance_score)){
            if(in_array("1", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if(in_array("2", $search_attendance_score)){
                $datarow->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if(in_array("3", $search_attendance_score)){
                $datarow->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $datarow = $datarow->orderBy('tb_employee_final_score.total_score_old', 'DESC')->get();


        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                if($value->status_evaluation == '0'){
                    $status_evaluation = '';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = 'In progress';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = 'Reject';
                }else{
                    $status_evaluation = 'Finished';
                }




                $data[] = array(
                    "code"=> $value->employee_no,
                    "name"=> (Session::get('locale') == "th" ?$value->name2:$value->name1),
                    "position"=> $value->position_name,
                    "date"=> changedata($value->date_joined),
                    "olddate"=> $value->date_joined,
                    "service"=> $value->service_days,
                    "form" =>  $value->form_import,
                    "total"=> number_format($value->total_score,1,'.',''),
                    "remark"=> $value->remark,
                    "status"=> $status_evaluation,
                );
            }

        }

        $excel = public_path('upload/orisoft/')."template_form.xlsx";
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
                $sheet->setCellValue('D'.$numsheet1, $value['date']);
                $sheet->setCellValue('E'.$numsheet1, $value['service']);
                $sheet->setCellValue('F'.$numsheet1, $value['form']);
                $sheet->setCellValue('G'.$numsheet1, $value['total']);
                $sheet->setCellValue('H'.$numsheet1, $value['remark']);
                $sheet->setCellValue('I'.$numsheet1, $value['status']);
                $numsheet1++;
            }
        }
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Evaluate_'.$orisoft_code.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function test_freeze(Request $request)
    {
        $count = 0;
        $view_mail = '<html>
                        <body>
                            <p>Test Link for EPA (ฐานข้อมูล Test ที่ใช้ประเมินผล)</p>
                            <a href="http://milepa" target="_blank"><p>Test</p></a>
                            <p>Evaluator Code : 000000</p>
                            <p>Evaluator Name : Test</p>
                            <p>Section Code : Test</p>
                        </body>
                    </html>';
        $arr = ['koranatsoi17@gmail.com'];
        $save = Mail::send([], ['Evaluator has completed the evaluation.'], function ($message) use ($view_mail,$arr) {
            $message
            ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
            ->to($arr)
            ->subject('Evaluator has completed the evaluation.');
            $message->html($view_mail);
        });
        if($save){
            $count++;
        }
        else{
            $count = 0;
        }

        $result = [
            'status'                => ($count > 0?200:500),
            'message'                      => $save
        ];
        echo json_encode($result);

    }
}
