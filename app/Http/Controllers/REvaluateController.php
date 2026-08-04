<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
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
class REvaluateController extends Controller
{
    public function index()
    {
        // $division = DB::table('tb_division')->orderBy('id', 'ASC')->get();
        // $department = DB::table('tb_department')->orderBy('id', 'ASC')->get();
        // $evaluator = DB::table('tb_employee_evaluator')
        // ->select('tb_employee_evaluator.employee_no',
        //         'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
        //         'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        // ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        // $section = DB::table('tb_section');
        // $section = $section->orderBy('id', 'ASC')->get();

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $division_code = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee.division_code'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        $new_division_code = [];
        if(count($division_code)>0){
            foreach ($division_code as $value) {
                array_push($new_division_code,$value->division_code);
            }
        }



        $division = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee.division_code',
        'tb_employee.division_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        $division = $division->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();

        $department = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee.department_code',
        'tb_employee.department_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        $department = $department->groupBy('tb_employee.department_code')->orderBy('department_code', 'ASC')->get();

        $department_code = [];
        if(count($department)>0){
            foreach ($department as $value) {
                array_push($department_code,$value->department_code);
            }
        }

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.division_code',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        ->whereIn('tb_employee.division_code',$new_division_code)
        ->whereIn('tb_employee.department_code',$department_code)
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->orderBy('tb_employee_evaluator.id', 'ASC')->get();


        $section = DB::table('tb_employee_final_score')
        ->select('tb_employee.section_code',
        'tb_employee.section_description',
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->whereIn('tb_employee.department_code',$department_code)
        ;
        $section = $section->groupBy('tb_employee.section_code')->orderBy('section_code', 'ASC')->get();
        $search_year = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.rec_year')
        ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
        return view('pages.evaluateReview.index', [
            "division" => $division,
            "department" => $department,
            "evaluator" => $evaluator,
            "section" => $section,
            "search_year" => $search_year,
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // return view('pages.evaluateReview.index');
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
        //         $checkbox = '<input type="checkbox" class="checkbox-select" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">';
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

    public function table_test_getdata_old(Request $request)
    {
        for ($i=1; $i < 11; $i++) {
            $data[] = array(
                "id" =>  '<input type="checkbox">',
                "code"=> "123456789",
                "name"=> "จันทรัตว์ ชัยชนา",
                "position"=> "xxxxxxxxxxx",
                "date"=> "11-JUL-1994",
                "service"=> "365",
                "evaluator"=> "xxxxxx xxxxxxxxxx",
                "1"=>"<input type='text' class='form-control form-control-sm text-center bg-light-warning' style='width:60px' min='1' max='10' value='8' onclick='gettitle(1);'><span class='small fw-bold'>9 &#62; <span class='text-primary'>8</span></span>",
                "2"=>"<input type='text' class='form-control form-control-sm text-center' style='width:60px' min='1' max='10' value='9' onclick='gettitle(2);'><span class='small fw-bold'>9 &#62; <span class='text-primary'>9</span></span>",
                "3"=>"<input type='text' class='form-control form-control-sm text-center' style='width:60px' min='1' max='10' value='7' onclick='gettitle(3);'><span class='small fw-bold'>7 &#62; <span class='text-primary'>7</span></span>",
                "4"=>"<input type='text' class='form-control form-control-sm text-center' style='width:60px' min='1' max='10' value='5' onclick='gettitle(4);'><span class='small fw-bold'>5 &#62; <span class='text-primary'>5</span></span>",
                "5"=>"<input type='text' class='form-control form-control-sm text-center' style='width:60px' min='1' max='10' value='10' onclick='gettitle(5);'><span class='small fw-bold'>10 &#62; <span class='text-primary'>10</span></span>",
                "6"=>"<input type='text' class='form-control form-control-sm text-center' style='width:60px' min='1' max='10' value='6' onclick='gettitle(6);'><span class='small fw-bold'>6 &#62; <span class='text-primary'>6</span></span>",
                "7"=>"<input type='text' class='form-control form-control-sm text-center' style='width:60px' min='1' max='10' value='6' onclick='gettitle(7);'><span class='small fw-bold'>6 &#62; <span class='text-primary'>6</span></span>",
                "8"=>"<button type='button' class='btn btn-sm btn-primary' style='width:60px' data-bs-toggle='modal' data-bs-target='#complainModal' onclick='gettitle(8);'>10</button>",
                "9"=>"<button type='button' class='btn btn-sm btn-danger' style='width:60px' data-bs-toggle='modal' data-bs-target='#attendanceModal' onclick='gettitle(9);'>9</button>",
                "total"=> "
                    <p class='fw-bold mb-0'>82.5</p>
                    <span class='small fw-bold'>82.5 &#62; <span class='text-primary'>81.5</span></span>",
                "remark"=> "<input type='text' class='form-control form-control-sm' style='width:250px'>",
                "status"=> "Reject",
                "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="ki-solid ki-check-circle fs-5"></i></button><button type="button" class="btn btn-icon btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="ki-solid ki-cross-circle fs-5"></i></button>',

            );
        }
        $result = [
            'data'            => $data,
        ];
        echo json_encode($result);

    }

    public function Review_table_test_getdata(Request $request)
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
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $division_code = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        // $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        // $new_division_code = [];
        // if(count($division_code)>0){
        //     foreach ($division_code as $value) {
        //         array_push($new_division_code,$value->division_code);
        //     }
        // }

        // $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_no', Auth::user()->orisoft_code)->first();

        // dd($tb_employee_evaluator);
        // exit;
        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        // $datarow = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        // 'tb_employee.date_joined AS date_joined',
        // 'tb_employee.employee_local_name_en AS name1',
        // 'tb_position.position_description AS position_name')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->whereNot('tb_employee.grade_code','L810')
        // ->whereNot('tb_employee.grade_code','L820');

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.status_evaluation','>=',1)

        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        if($orisoft_code != "990002"){
            $datarow->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }

        // if($orisoft_code == "019492" || $orisoft_code == "000012"){
        //     if(trans(request()->segment(1)) == 'manager'){
        //         $datarow->where('tb_employee_final_score.evaluator_no', $orisoft_code);
        //     }else{

        //     }

        // }

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $datarow = $datarow->where('tb_employee_final_score.evaluator_no','000026');
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
                    $datarow = $datarow->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $datarow = $datarow->whereIn('tb_employee.division_code',$search_division_code);
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
                    $datarow = $datarow->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $datarow = $datarow->whereIn('tb_employee.department_code',$search_department_code);
                }
            }else{
                if($orisoft_code == "000003"){
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
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $datarow->where('tb_employee.division_code', $search_division_code);
        //     }
        // }

        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $datarow->where('tb_employee.department_code', $search_department_code);
        //     }
        // }

        if($search_employee_no != "all"){
            $datarow->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $datarow->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }

        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $datarow->where('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array('all', $search_month_day)){
                if($search_month_day == "1"){
                    $datarow->where('tb_employee_final_score.salary_type','Daily');
                }
                if($search_month_day == "2"){
                    $datarow->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        if($search_form != "0"){
            $datarow->where('tb_employee_final_score.form_import', $search_form);
        }

        if($search_status != "0"){
            $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $datarow->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
            // if($search_form == "F1"){
            //     if($search_complaince_score == "1"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
            //     }
            //     if($search_complaince_score == "2"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
            //     }
            //     if($search_complaince_score == "3"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
            //     }
            // }else if($search_form == "F2"){
            //     if($search_complaince_score == "1"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [1, 3]);
            //     }
            //     if($search_complaince_score == "2"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [4, 7]);
            //     }
            //     if($search_complaince_score == "3"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [8, 10]);
            //     }
            // }else if($search_form == "F3"){
            //     if($search_complaince_score == "1"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
            //     }
            //     if($search_complaince_score == "2"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
            //     }
            //     if($search_complaince_score == "3"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
            //     }
            // }else{
            //     if($search_complaince_score == "1"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [1, 3]);
            //     }
            //     if($search_complaince_score == "2"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [4, 7]);
            //     }
            //     if($search_complaince_score == "3"){
            //         $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [8, 10]);
            //     }
            // }

        }

        if($search_attendance_score != "0"){
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

        $dataraw = $datarow->toRawSql();
        $datarow = $datarow->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.employee_no', 'ASC')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_evaluation == '0'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">Reject</span>';
                }else if($value->status_evaluation == '3'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
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

                $evaluator_name = '';
                $evaluator_namex = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.employee_no', $value->evaluator_no)->first();
                if($evaluator_namex){
                    // if($("#isLocale").val() == '1'){
                    //     name = row.evaluator_name.employee_name_en;
                    // }else{
                    //     name = row.evaluator_name.employee_name_th;
                    // }
                    if(Session::get('locale') == "th"){
                        $evaluator_name = $evaluator_namex->employee_name_th;
                    }else{
                        $evaluator_name = $evaluator_namex->employee_name_en;
                    }
                }else{
                    $evaluator_name = '';
                }
                $freeze_to_pagrade = '';
                $checkbox = '<input type="checkbox" class="checkbox-select-'.$value->form_import.'" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'">';
                if ($value->freeze_to_pagrade == '1') {
                    $freeze_to_pagrade = 'disabled';
                    $checkbox = '';
                }
                $data[] = array(
                    "id" =>  $checkbox,
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
                            onclick="gettitle('.$value->group_form_id.',0.1,'.(count($cut_evaluation_criteria_id)+1).',1,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->compliance_score?$value->compliance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="complain_score'.$value->id.'"
                            value="'.$value->compliance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->compliance_weight_status.'">',
                    "0"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px"
                            data-bs-toggle="modal" data-bs-target="#attendanceModal"
                            onclick="gettitle('.$value->group_form_id.',0,'.(count($cut_evaluation_criteria_id)+2).',2,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->attendance_score?$value->attendance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="attendance_score'.$value->id.'"
                            value="'.$value->attendance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->criteria_weight.'">',
                    "total"=> '<b class="total_score'.$value->id.'">'.number_format($value->total_score,1,'.','').'</b><input type="hidden" id="total_score'.$value->id.'" value="'.number_format($value->total_score,1,'.','').'">',
                    "remark"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);" >',
                    "remark_eva_review"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark.'" onchange="update_remark('.$value->id.',this.value);" disabled>',
                    "remark_manager"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark_manager.'" onchange="update_remark_manager('.$value->id.',this.value);" disabled>',
                    "remark_manager_review"=> '<input type="text" class="form-control form-control-sm" style="width:250px" value="'.$value->remark_manager.'" onchange="update_remark_manager('.$value->id.',this.value);" '.$freeze_to_pagrade.'>',
                    "status"=> $status_evaluation,
                    "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$freeze_to_pagrade.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal" '.$freeze_to_pagrade.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                    "data_id" =>  $value->id,
                    "evaluator_name" => $evaluator_name,
                    "freeze_to_pagrade" =>  $value->freeze_to_pagrade,
                );
            }
        }


        foreach ($data as $key1 => $value1) {
            // $data[$key1]['test'] = $value1['group_form_id'];
            if($value1['group_form_id']){
                if($value1['evaluation_criteria_id']){
                    $cut = explode(',',$value1['evaluation_criteria_id']);
                    $cut_criteria_score_new = explode(',',$value1['criteria_score_new']);
                    $cut_criteria_score_eva = explode(',',$value1['criteria_score_eva']);
                    $data[$key1]['count_evaluation_criteria_id'] = count($cut);
                    foreach ($cut as $key2 => $value2) {
                        $topic_weightx = DB::table('group_form_topic')
                        ->select('topic_weight')
                        ->where('group_form_topic.group_form_id', $value1['group_form_id'])
                        ->where('group_form_topic.evaluation_criteria_id', $value2)
                        ->first();
                        $freeze = '';
                        $bg_css = '';
                        if ($value1['freeze_to_pagrade'] == '1') {
                            $freeze = 'readonly';
                            $bg_css = 'background-color: var(--bs-gray-200);';
                        }
                        if((float)$cut_criteria_score_new[$key2] > (float)$cut_criteria_score_eva[$key2]){
                            $color = 'bg-light-success';
                        }else if((float)$cut_criteria_score_new[$key2] < (float)$cut_criteria_score_eva[$key2]){
                            $color = 'bg-light-danger';
                        }else{
                            $color = '';
                        }
                        $data[$key1][($key2+1)] = '<input type="text" class="form-control form-control-sm text-center calAll'.$value1['data_id'].' '.$color.'"
                            style="width:60px;'.$bg_css.'"
                            min="1"
                            max="10"
                            value="'.($cut_criteria_score_new[$key2]?$cut_criteria_score_new[$key2]:'').'"
                            onclick="gettitle('.$value1['group_form_id'].','.$value2.','.($key2+1).',0,'.$value1['data_id'].');"
                            onfocus="gettitle('.$value1['group_form_id'].','.$value2.','.($key2+1).',0,'.$value1['data_id'].');"
                            onchange="update_score('.$value1['data_id'].',this.value,1);"
                            '.$freeze.'>
                            <input type="hidden" class="calAll_topic_weight'.$value1['data_id'].'" value="'.$topic_weightx->topic_weight.'">';
                    }
                }else{
                    for ($i=1; $i < 11; $i++) {
                        $data[$key1][$i] = '<input type="text" class="form-control form-control-sm text-center calAll'.$value1['data_id'].'"
                            style="width:60px"
                            min="1"
                            max="10"
                            value=""';
                    }
                }
            }
        }
        $search_year       = $request->input('search_year');
        $checkYearABC = $search_year;
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
            'data'              => $data,
            'dataraw'           => $dataraw,
        ];
        echo json_encode($result);

    }

    public function Review_table_test_getdata_m(Request $request)
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
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }

        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
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
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        if($search_division_code != "all"){
            $datarow->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $datarow->where('tb_employee.department_code', $search_department_code);
        }

        if($search_employee_no != "all"){
            $datarow->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }

        if($search_section != "all"){
            $datarow->where('tb_employee.section_code', $search_section);
        }

        if($search_form != "0"){
            $datarow->where('tb_employee_final_score.form_import', $search_form);
        }

        if($search_status != "0"){
            $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
        }

        if($search_complaince_score != "0"){
            if($search_form == "F1"){
                if($search_complaince_score == "1"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
                }
                if($search_complaince_score == "2"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
                }
                if($search_complaince_score == "3"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
                }
            }else if($search_form == "F2"){
                if($search_complaince_score == "1"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [1, 3]);
                }
                if($search_complaince_score == "2"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [4, 7]);
                }
                if($search_complaince_score == "3"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [8, 10]);
                }
            }else if($search_form == "F3"){
                if($search_complaince_score == "1"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
                }
                if($search_complaince_score == "2"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
                }
                if($search_complaince_score == "3"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
                }
            }else{
                if($search_complaince_score == "1"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [1, 3]);
                }
                if($search_complaince_score == "2"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [4, 7]);
                }
                if($search_complaince_score == "3"){
                    $datarow->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [8, 10]);
                }
            }

        }

        if($search_attendance_score != "0"){
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

        $datarow = $datarow->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_evaluation == '0'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">Reject</span>';
                }else if($value->status_evaluation == '3'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
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
                    $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                    if($evaluator_name){
                        $employee_local_name_th = $evaluator_name->employee_local_name_th;
                    }else{
                        $employee_local_name_th = '';
                    }
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
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Evaluator:<br></span>
                                                    <span class="h2 text-black fw-bold">'.$employee_local_name_th.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                <i class="ki-solid ki-check-circle fs-1"></i>
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="ki-solid ki-cross-circle fs-1"></i>
                                                Reject
                                            </button>
                                        </div>
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
                    $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                    if($evaluator_name){
                        $employee_local_name_th = $evaluator_name->employee_local_name_th;
                    }else{
                        $employee_local_name_th = '';
                    }
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
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Evaluator:<br></span>
                                                    <span class="h2 text-black fw-bold">'.$employee_local_name_th.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                <i class="ki-solid ki-check-circle fs-1"></i>
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="ki-solid ki-cross-circle fs-1"></i>
                                                Reject
                                            </button>
                                        </div>
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
                    $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                    if($evaluator_name){
                        $employee_local_name_th = $evaluator_name->employee_local_name_th;
                    }else{
                        $employee_local_name_th = '';
                    }
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
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Evaluator:<br></span>
                                                    <span class="h2 text-black fw-bold">'.$employee_local_name_th.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                <i class="ki-solid ki-check-circle fs-1"></i>
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="ki-solid ki-cross-circle fs-1"></i>
                                                Reject
                                            </button>
                                        </div>
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
                    $evaluator_name = DB::table('tb_employee')->select('tb_employee.employee_local_name_th','tb_employee.employee_local_name_en')->where('tb_employee.orisoft_no', $value->evaluator_no)->first();
                    if($evaluator_name){
                        $employee_local_name_th = $evaluator_name->employee_local_name_th;
                    }else{
                        $employee_local_name_th = '';
                    }
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
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Total score:<br></span>
                                                    <span class="h1 text-black fw-bold total_score'.$value->id.'" >'.$value->total_score.'</span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-black  mb-2">
                                                    <span class="small text-gray-800">Evaluator:<br></span>
                                                    <span class="h2 text-black fw-bold">'.$employee_local_name_th.'</span>
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <span class="small text-gray-800">Note:<br></span>
                                            '.$value->remark.'
                                        </p>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                <i class="ki-solid ki-check-circle fs-1"></i>
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="ki-solid ki-cross-circle fs-1"></i>
                                                Reject
                                            </button>
                                        </div>
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

    public function Review_get_form(Request $request)
    {
        $nowyear = date('Ym');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }
        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        // $division_code = DB::table('tb_employee_final_score')
        // ->select(
        // 'tb_employee.division_code'
        // )
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        // $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        // $new_division_code = [];
        // if(count($division_code)>0){
        //     foreach ($division_code as $value) {
        //         array_push($new_division_code,$value->division_code);
        //     }
        // }
        $countsection = DB::table('tb_percent_department_action')
        ->select('tb_percent_department_action.division_code')
        ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
        ->where('tb_percent_department.year','like','%'.$previousYear.'%')
        ->where('tb_percent_department_action.approve_by1',Auth::user()->orisoft_code);
        $countsection = $countsection->groupBy('division_code')->orderBy('division_code', 'ASC')->get();

        $tb_employee_evaluator = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no', Auth::user()->orisoft_code)->first();

        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
        $search_complaince_score      = $request->input('search_complaince_score');
        $search_attendance_score      = $request->input('search_attendance_score');
        $search_status      = $request->input('search_status');
        $search_section      = $request->input('search_section');
        $search_form      = $request->input('search_form');
        $search_month_day      = $request->input('search_month_day');

        // $CountF1 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        // 'tb_employee.date_joined AS date_joined',
        // 'tb_employee.employee_local_name_en AS name1',
        // 'tb_position.position_description AS position_name')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)
        // ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        $CountF1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.employee_no','!=',$orisoft_code)
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','>=',1)
        ;
        if($orisoft_code != "990002"){
            $CountF1->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF1 = $CountF1->where('tb_employee_final_score.evaluator_no','000026');
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
                    $CountF1 = $CountF1->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $CountF1 = $CountF1->whereIn('tb_employee.division_code',$search_division_code);
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
                    $CountF1 = $CountF1->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $CountF1 = $CountF1->whereIn('tb_employee.department_code',$search_department_code);
                }
            }else{
                if($orisoft_code == "000003"){
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
                    $CountF1 = $CountF1->whereIn('tb_employee.department_code',$arr_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $CountF1->where('tb_employee.division_code', $search_division_code);
        //     }
        // }

        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $CountF1->where('tb_employee.department_code', $search_department_code);
        //     }
        // }

        if($search_employee_no != "all"){
            $CountF1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $CountF1->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }

        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $CountF1->where('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array('all', $search_month_day)){
                if($search_month_day == "1"){
                    $CountF1->where('tb_employee_final_score.salary_type','Daily');
                }
                if($search_month_day == "2"){
                    $CountF1->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        $CountF1->where('tb_employee_final_score.form_import', 'F1');

        if($search_status != "0"){
            $CountF1->where('tb_employee_final_score.status_evaluation', $search_status);
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $rawCountF1 = $CountF1->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.employee_no', 'ASC')->toRawSql();
        $CountF1 = $CountF1->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.employee_no', 'ASC')->get();

        // $CountF1 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        // 'tb_employee.date_joined AS date_joined',
        // 'tb_employee.employee_local_name_en AS name1',
        // 'tb_position.position_description AS position_name')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.status_evaluation','>=', '0')
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code);

        // if($search_division_code != "all"){
        //     $CountF1->where('tb_employee.division_code', $search_division_code);
        // }
        // if($search_department_code != "all"){
        //     $CountF1->where('tb_employee.department_code', $search_department_code);
        // }
        // if($search_employee_no != "all"){
        //     $CountF1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        // }
        // if($search_section != ""){
        //     $CountF1->where('tb_employee.section_code', $search_section);
        // }
        // if($search_form != ""){
        //     $CountF1->where('tb_employee_final_score.form_import', 'F1');
        // }
        // if($search_status != "0"){
        //     $CountF1->where('tb_employee_final_score.status_evaluation', $search_status);
        // }
        // if($search_complaince_score != "0"){
        //     if($search_complaince_score != "0"){
        //         if($search_complaince_score == "1"){
        //             $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
        //         }
        //         if($search_complaince_score == "2"){
        //             $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
        //         }
        //         if($search_complaince_score == "3"){
        //             $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
        //         }
        //     }
        //     // if($search_form == "F1"){
        //     //     if($search_complaince_score == "1"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
        //     //     }
        //     //     if($search_complaince_score == "2"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
        //     //     }
        //     //     if($search_complaince_score == "3"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
        //     //     }
        //     // }else if($search_form == "F2"){
        //     //     if($search_complaince_score == "1"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [1, 3]);
        //     //     }
        //     //     if($search_complaince_score == "2"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [4, 7]);
        //     //     }
        //     //     if($search_complaince_score == "3"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score10', [8, 10]);
        //     //     }
        //     // }else if($search_form == "F3"){
        //     //     if($search_complaince_score == "1"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [1, 3]);
        //     //     }
        //     //     if($search_complaince_score == "2"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [4, 7]);
        //     //     }
        //     //     if($search_complaince_score == "3"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score8', [8, 10]);
        //     //     }
        //     // }else{
        //     //     if($search_complaince_score == "1"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [1, 3]);
        //     //     }
        //     //     if($search_complaince_score == "2"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [4, 7]);
        //     //     }
        //     //     if($search_complaince_score == "3"){
        //     //         $CountF1->whereBetween('tb_employee_final_score.evaluation_criteria_score9', [8, 10]);
        //     //     }
        //     // }

        // }

        // if($search_attendance_score != "0"){
        //     if($search_attendance_score == "1"){
        //         $CountF1->whereBetween('tb_employee_final_score.attendance_score', [1, 3]);
        //     }
        //     if($search_attendance_score == "2"){
        //         $CountF1->whereBetween('tb_employee_final_score.attendance_score', [4, 7]);
        //     }
        //     if($search_attendance_score == "3"){
        //         $CountF1->whereBetween('tb_employee_final_score.attendance_score', [8, 10]);
        //     }
        // }
        // $CountF1 = $CountF1->orderBy('tb_employee_final_score.id', 'DESC')->get();

        // $CountF2 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        // 'tb_employee.date_joined AS date_joined',
        // 'tb_employee.employee_local_name_en AS name1',
        // 'tb_position.position_description AS position_name')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)
        // ;
        $CountF2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.employee_no','!=',$orisoft_code)
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','>=',1)
        ;
        if($orisoft_code != "990002"){
            $CountF2->where('tb_employee_final_score.employee_no','!=',$orisoft_code);
        }
        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF2 = $CountF2->where('tb_employee_final_score.evaluator_no','000026');
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
                    $CountF2 = $CountF2->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $CountF2 = $CountF2->whereIn('tb_employee.division_code',$search_division_code);
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
                    $CountF2 = $CountF2->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $CountF2 = $CountF2->whereIn('tb_employee.department_code',$search_department_code);
                }
            }else{
                if($orisoft_code == "000003"){
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
                    $CountF2 = $CountF2->whereIn('tb_employee.department_code',$arr_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $CountF2->where('tb_employee.division_code', $search_division_code);
        //     }
        // }

        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $CountF2->where('tb_employee.department_code', $search_department_code);
        //     }
        // }

        if($search_employee_no != "all"){
            $CountF2->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $CountF2->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }

        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $CountF2->where('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array('all', $search_month_day)){
                if($search_month_day == "1"){
                    $CountF2->where('tb_employee_final_score.salary_type','Daily');
                }
                if($search_month_day == "2"){
                    $CountF2->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        $CountF2->where('tb_employee_final_score.form_import', 'F2');

        if($search_status != "0"){
            $CountF2->where('tb_employee_final_score.status_evaluation', $search_status);
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF2->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF2 = $CountF2->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.employee_no', 'ASC')->get();

        // $CountF3 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        // 'tb_employee.date_joined AS date_joined',
        // 'tb_employee.employee_local_name_en AS name1',
        // 'tb_position.position_description AS position_name')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)
        // ;
        $CountF3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.employee_no','!=',$orisoft_code)
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','>=',1)
        ;
        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF3 = $CountF3->where('tb_employee_final_score.evaluator_no','000026');
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
                    $CountF3 = $CountF3->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $CountF3 = $CountF3->whereIn('tb_employee.division_code',$search_division_code);
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
                    $CountF3 = $CountF3->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $CountF3 = $CountF3->whereIn('tb_employee.department_code',$search_department_code);
                }
            }else{
                if($orisoft_code == "000003"){
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
                    $CountF3 = $CountF3->whereIn('tb_employee.department_code',$arr_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $CountF3->where('tb_employee.division_code', $search_division_code);
        //     }
        // }

        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $CountF3->where('tb_employee.department_code', $search_department_code);
        //     }
        // }

        if($search_employee_no != "all"){
            $CountF3->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $CountF3->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }

        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $CountF3->where('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array('all', $search_month_day)){
                if($search_month_day == "1"){
                    $CountF3->where('tb_employee_final_score.salary_type','Daily');
                }
                if($search_month_day == "2"){
                    $CountF3->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        $CountF3->where('tb_employee_final_score.form_import', 'F3');

        if($search_status != "0"){
            $CountF3->where('tb_employee_final_score.status_evaluation', $search_status);
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF3 = $CountF3->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.employee_no', 'ASC')->get();

        // $CountF4 = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.*',
        // 'tb_employee.date_joined AS date_joined',
        // 'tb_employee.employee_local_name_en AS name1',
        // 'tb_position.position_description AS position_name')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        // ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)
        // ;
        $CountF4 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        // ->where('tb_employee_final_score.freeze','1')
        // ->where('tb_employee_final_score.employee_no','!=',$orisoft_code)
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','>=',1)
        ;
        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF4 = $CountF4->where('tb_employee_final_score.evaluator_no','000026');
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
                    $CountF4 = $CountF4->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $CountF4 = $CountF4->whereIn('tb_employee.division_code',$search_division_code);
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
                    $CountF4 = $CountF4->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $CountF4 = $CountF4->whereIn('tb_employee.department_code',$search_department_code);
                }
            }else{
                if($orisoft_code == "000003"){
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
                    $CountF4 = $CountF4->whereIn('tb_employee.department_code',$arr_department_code);
                }
            }
        }
        // if(!empty($search_division_code)){
        //     if(!in_array('all', $search_division_code)){
        //         $CountF4->where('tb_employee.division_code', $search_division_code);
        //     }
        // }

        // if(!empty($search_department_code)){
        //     if(!in_array('all', $search_department_code)){
        //         $CountF4->where('tb_employee.department_code', $search_department_code);
        //     }
        // }

        if($search_employee_no != "all"){
            $CountF4->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }else{
            if($orisoft_code == '013591' || $orisoft_code == "019264" || $orisoft_code == "000012" || $orisoft_code == "000023"){
                $CountF4->where('tb_employee_final_score.evaluator_no', $orisoft_code);
            }
        }

        if(!empty($search_section)){
            if(!in_array('all', $search_section)){
                $CountF4->where('tb_employee.section_code', $search_section);
            }
        }

        if(!empty($search_month_day)){
            if(!in_array('all', $search_month_day)){
                if($search_month_day == "1"){
                    $CountF4->where('tb_employee_final_score.salary_type','Daily');
                }
                if($search_month_day == "2"){
                    $CountF4->where('tb_employee_final_score.salary_type','Monthly');
                }
            }
        }

        $CountF4->where('tb_employee_final_score.form_import', 'F4');

        if($search_status != "0"){
            $CountF4->where('tb_employee_final_score.status_evaluation', $search_status);
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF4->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF4 = $CountF4->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->orderBy('tb_employee_final_score.employee_no', 'ASC')->get();

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

        if($search_form != ""){
            $count_total_td = DB::table('group_form_topic')
                        ->select('id')
                        ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                        ->where('group_form.form_ref', $search_form)
                        ->where('group_form.form_year_use_start','>=', $previousYear)
                        ->where('group_form.form_year_use_end','<=',$previousYear)
                        ->count();
            $count_topic_weight = DB::table('group_form_topic')
                        ->select('group_form_topic.id','group_form_topic.topic_weight')
                        ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
                        ->where('group_form.form_ref', $search_form)
                        ->where('group_form.form_year_use_start','>=', $previousYear)
                        ->where('group_form.form_year_use_end','<=',$previousYear)
                        ->get();
            $count_topic_weight2 = DB::table('group_form')
                        ->select('group_form.criteria_weight','group_form.compliance_weight')
                        ->where('group_form.form_ref', $search_form)
                        ->where('group_form.form_year_use_start','>=', $previousYear)
                        ->where('group_form.form_year_use_end','<=',$previousYear)
                        ->first();
        }

        $result = [
            'f1'                => count($CountF1),
            'rawCountF1'        => $rawCountF1,
            'f2'                => count($CountF2),
            'f3'                => count($CountF3),
            'f4'                => count($CountF4),
            'count_total_td'                => ($search_form != ""?$count_total_td:0),
            'count_topic_weight'                => ($search_form != ""?$count_topic_weight:[]),
            'criteria_weight'                => ($search_form != ""?$count_topic_weight2->criteria_weight:0),
            'compliance_weight'                => ($search_form != ""?$count_topic_weight2->compliance_weight:0),
            'checkCountF1'                => $checkCountF1,
            'checkCountF2'                => $checkCountF2,
            'checkCountF3'                => $checkCountF3,
            'checkCountF4'                => $checkCountF4,
        ];
        echo json_encode($result);

    }

    public function check_value_null_review(Request $request)
    {
        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $nowyear = date('Ym');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
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

        $CountF1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        if($search_division_code != "all"){
            $CountF1->where('tb_employee.division_code', $search_division_code);
        }
        if($search_department_code != "all"){
            $CountF1->where('tb_employee.department_code', $search_department_code);
        }
        if($search_employee_no != "all"){
            $CountF1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }
        if($search_section != "all"){
            $CountF1->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF1->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != "0"){
            $CountF1->where('tb_employee_final_score.form_import', 'F1');
        }

        if($search_status != "0"){
            if($search_status == '1'){
                $CountF1->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF1->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        if($search_division_code != "all"){
            $CountF2->where('tb_employee.division_code', $search_division_code);
        }
        if($search_department_code != "all"){
            $CountF2->where('tb_employee.department_code', $search_department_code);
        }
        if($search_employee_no != "all"){
            $CountF2->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }
        if($search_section != "all"){
            $CountF2->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF2->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF2->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != "0"){
            $CountF2->where('tb_employee_final_score.form_import', 'F2');
        }

        if($search_status != "0"){
            if($search_status == '1'){
                $CountF2->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF2->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        if($search_division_code != "all"){
            $CountF3->where('tb_employee.division_code', $search_division_code);
        }
        if($search_department_code != "all"){
            $CountF3->where('tb_employee.department_code', $search_department_code);
        }
        if($search_employee_no != "all"){
            $CountF3->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }
        if($search_section != "all"){
            $CountF3->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF3->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF3->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != "0"){
            $CountF3->where('tb_employee_final_score.form_import', 'F3');
        }

        if($search_status != "0"){
            if($search_status == '1'){
                $CountF3->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF3->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');

        if($search_division_code != "all"){
            $CountF4->where('tb_employee.division_code', $search_division_code);
        }
        if($search_department_code != "all"){
            $CountF4->where('tb_employee.department_code', $search_department_code);
        }
        if($search_employee_no != "all"){
            $CountF4->where('tb_employee_final_score.evaluator_no', $search_employee_no);
        }
        if($search_section != "all"){
            $CountF4->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF4->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF4->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        if($search_form != "0"){
            $CountF4->where('tb_employee_final_score.form_import', 'F4');
        }

        if($search_status != "0"){
            if($search_status == '1'){
                $CountF4->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $CountF4->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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

    public function Review_update_score(Request $request)
    {
        $id      = $request->input('id');
        $criteria_score_old_all      = $request->input('criteria_score_old_all');
        $score      = $request->input('score');
        $old_score      = $request->input('old_score');
        $total_score      = $request->input('total_score');
        $total_score_old      = $request->input('total_score_old');
        $number      = $request->input('number');
        // if($number == '1'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score1' => $request->input('score'),
        //         'evaluation_criteria_score_old1' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '2'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score2' => $request->input('score'),
        //         'evaluation_criteria_score_old2' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '3'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score3' => $request->input('score'),
        //         'evaluation_criteria_score_old3' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '4'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score4' => $request->input('score'),
        //         'evaluation_criteria_score_old4' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '5'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score5' => $request->input('score'),
        //         'evaluation_criteria_score_old5' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '6'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score6' => $request->input('score'),
        //         'evaluation_criteria_score_old6' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '7'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score7' => $request->input('score'),
        //         'evaluation_criteria_score_old7' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '8'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score8' => $request->input('score'),
        //         'evaluation_criteria_score_old8' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }
        // if($number == '9'){
        //     DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //         'evaluation_criteria_score9' => $request->input('score'),
        //         'evaluation_criteria_score_old9' => $request->input('old_score'),
        //         'total_score' => $total_score,
        //         'total_score_old' => $request->input('total_score_old')
        //     ]);
        // }

        // $getdata = DB::table('tb_employee_final_score')
        // ->select('tb_employee_final_score.total_score')
        // ->where('tb_employee_final_score.id', $request->input('id'))
        // ->where('tb_employee_final_score.status_evaluation', '0')
        // ->first();
        // if($getdata){
        //     if($getdata->total_score > 0){
        //         DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
        //             'status_evaluation' => '1'
        //         ]);
        //     }
        // }
        $getdata = DB::table('tb_employee_final_score')
        // ->select('total_score','criteria_score_new')
        ->where('tb_employee_final_score.id', $request->input('id'))
        ->first();
        if($total_score > 0){
            DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
                'status_evaluation' => '1',
                'status_pa' => '4',
                'total_score' => $total_score,
                'total_score_old' => $request->input('total_score_old'),
                'criteria_score_old' => $getdata->criteria_score_new,
                'criteria_score_new' => $criteria_score_old_all,
                'freeze_to_pagrade' => '0',
            ]);
        }

        $getdata2 = DB::table('tb_employee_final_score')
        // ->select('total_score','criteria_score_new')
        ->where('tb_employee_final_score.id', $request->input('id'))
        ->first();
        $criteria_score_eva = explode(',',$getdata2->criteria_score_eva);
        $criteria_score_new = explode(',',$getdata2->criteria_score_new);
        $color_arr = [];
        if(count($criteria_score_eva)>0){
            foreach ($criteria_score_eva as $key => $value) {
                // dd((float)$criteria_score_new[$key]);
                // exit;
                if((float)$criteria_score_new[$key] > (float)$value){
                    $color = 'bg-light-success';
                }else if((float)$criteria_score_new[$key] < (float)$value){
                    $color = 'bg-light-danger';
                }else{
                    $color = '';
                }
                array_push($color_arr,$color);
            }
        }



        $result = [
            'id'                => $id,
            'score'                => $score,
            'number'                => $number,
            'color_arr'                => $color_arr
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

    public function gettitle(Request $request)
    {
        $id      = $request->input('id');
        $number      = $request->input('number');

        $data = DB::table('group_form_topic')
        ->select('group_form_topic.*','evaluation_criteria.title_th AS criteria_th','evaluation_criteria.title_en AS criteria_en')
        ->leftJoin('evaluation_criteria','evaluation_criteria.id','=','group_form_topic.evaluation_criteria_id');

        if($id != ""){
            $data->where('group_form_topic.group_form_id', $id);
        }
        if($number != ""){
            $data->where('group_form_topic.evaluation_criteria_id', $number);
        }

        $data = $data->orderBy('group_form_topic.id', 'ASC')->first();

        $data2 = DB::table('group_form_score_level')->where('group_form_score_level.group_form_id', $id);
        $data2 = $data2->orderBy('group_form_score_level.id', 'ASC')->get();

        $result = [
            'data'                => $data,
            'data2'               => $data2,
        ];
        echo json_encode($result);

    }

    public function evaluate_get_all(Request $request)
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $search_year       = $request->input('search_year');
            $previousYear = $search_year;
            // $previousYear = date('Y');
        // }

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();

        $division_code = DB::table('tb_employee_final_score')
        ->select(
        'tb_employee.division_code'
        )
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.evaluator_no',$orisoft_code);
        $division_code = $division_code->groupBy('tb_employee.division_code')->orderBy('division_code', 'ASC')->get();
        $new_division_code = [];
        if(count($division_code)>0){
            foreach ($division_code as $value) {
                array_push($new_division_code,$value->division_code);
            }
        }

        $data = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_evaluation','>=', '0')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereIn('tb_employee.division_code',$new_division_code)
        ->count();

        $data1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_evaluation', '0')
        ->orwhere('tb_employee_final_score.status_evaluation', '1')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereIn('tb_employee.division_code',$new_division_code)
        ->count();

        $data2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_evaluation', '2')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereIn('tb_employee.division_code',$new_division_code)
        ->count();

        $data3 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.id')
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->whereIn('tb_employee.division_code',$new_division_code)
        ->count();

        $result = [
            'data'                => $data,
            'data1'               => $data1,
            'data2'               => $data2,
            'data3'               => $data3,
        ];
        echo json_encode($result);

    }

    public function get_compliance_attendance(Request $request)
    {
        $id      = $request->input('id');
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
        ->first();
        echo json_encode($data);

    }

    public function Review_update_status(Request $request)
    {
        $id             = $request->input('id');
        $status_evaluation         = $request->input('status_evaluation');

        // $count_total_td = DB::table('group_form_topic')
        //             ->select('id')
        //             ->leftJoin('group_form','group_form.id','=','group_form_topic.group_form_id')
        //             ->where('group_form.form_ref', $search_form)
        //             ->where('group_form.form_year_use_start','>=', $previousYear)
        //             ->where('group_form.form_year_use_end','<=',$previousYear)
        //             ->count();

        DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
            'status_evaluation' => $request->input('status_evaluation'),
            'freeze' => ($status_evaluation=='2'?'0':'1')
        ]);
        if($status_evaluation=='2'){
            DB::table('tb_employee_final_score')->where('id', $request->input('id') )->update([
                'freeze_to_pagrade' => '0'
            ]);
        }
        if($request->input('status_evaluation') == '3'){
            DB::table('tb_employee_final_score')
            ->where('id', $request->input('id'))
            ->update([
                "status_pa" => '5'
            ]);
        }



        $result = [
            'id'                => $id,
            'status_evaluation'                => $status_evaluation
        ];
        echo json_encode($result);
    }

    public function Review_update_status_all(Request $request)
    {
        $id             = $request->input('id');
        $status_evaluation         = $request->input('status_evaluation');

        if(!empty($id)){
            foreach($id AS $val){
                DB::table('tb_employee_final_score')->where('id', $val )->update([
                    'status_evaluation' => $request->input('status_evaluation'),
                    'freeze' => ($status_evaluation=='2'?'0':'1')
                ]);
                if($request->input('status_evaluation') == '3'){
                    DB::table('tb_employee_final_score')
                    ->where('id', $val )
                    ->update([
                        "status_pa" => '5'
                    ]);
                }
            }
        }



        $result = [
            'id'                => $id,
            'status_evaluation'                => $status_evaluation
        ];
        echo json_encode($result);
    }

    public function get_eva(Request $request)
    {
        $section_code      = $request->input('section_code');

        $evaluator = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.division_code',
                'tb_employee_evaluator.employee_name_th AS employee_local_name_th',
                'tb_employee_evaluator.employee_name_en AS employee_local_name_en')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_evaluator.employee_no')
        ->where('tb_employee.section_code',$section_code)
        ->where('tb_employee_evaluator.evaluator_active','1')
        ->orderBy('tb_employee_evaluator.id', 'ASC')->get();

        $result = [
            'data'                => $evaluator,
        ];
        echo json_encode($result);

    }

    //////////

    public function review_table_test_getdata_all(Request $request)
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
        $previousYear = $search_year;
        if(empty($search_year)){
            $previousYear = date('Y');
        }
        // $previousYear = date('Y');

        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
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

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed');
        // ->where('tb_employee_final_score.freeze','1');
        $datarow = $datarow->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ->where('tb_employee_final_score.status_evaluation','>=',1)
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$previousYear.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $datarow = $datarow->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if(is_array($search_division_code)){
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
                    $datarow = $datarow->whereIn('tb_employee.division_code',$arr_division_code);
                }else{
                    $datarow = $datarow->whereIn('tb_employee.division_code',$search_division_code);
                }
            }else{
                if($search_division_code == "all"){
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
                }else{
                    $datarow = $datarow->where('tb_employee.division_code',$search_division_code);
                }
            }


            if(is_array($search_department_code)){
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
                    $datarow = $datarow->whereIn('tb_employee.department_code',$arr_department_code);
                }else{
                    $datarow = $datarow->whereIn('tb_employee.department_code',$search_department_code);
                }
            }else{
                if($search_department_code == 'all'){
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
                }else{
                    $datarow = $datarow->where('tb_employee.department_code',$search_department_code);
                }
            }

        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $datarow->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if(!empty($search_section)){
            if(is_array($search_section)){
                if(!in_array("all", $search_section)){
                    $datarow->whereIn('tb_employee.section_code', $search_section);
                }
            }else{
                if($search_section != 'all'){
                    $datarow->where('tb_employee.section_code', $search_section);
                }
            }
        }


        if(!in_array("all", $search_month_day)){
            if(!in_array("1", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Daily');
            }
            if(!in_array("2", $search_month_day)){
                $datarow->where('tb_employee_final_score.salary_type','Monthly');
            }
        }

        if($search_status != "0"){
            if($search_status == '1'){
                $datarow->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if($search_complaince_score != "0"){
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

        if($search_attendance_score != "0"){
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

        $dataraw = $datarow->toRawSql();
        $datarow = $datarow->orderBy('tb_employee_final_score.total_score', 'DESC')->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->get();


        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_evaluation == '0'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">Wait for approval</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">Reject</span>';
                }else if($value->status_evaluation == '3'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
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

                $evaluator_name = '';
                $evaluator_namex = DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.employee_no', $value->evaluator_no)->first();
                if($evaluator_namex){
                    // if($("#isLocale").val() == '1'){
                    //     name = row.evaluator_name.employee_name_en;
                    // }else{
                    //     name = row.evaluator_name.employee_name_th;
                    // }
                    if(Session::get('locale') == "th"){
                        $evaluator_name = $evaluator_namex->employee_name_th;
                    }else{
                        $evaluator_name = $evaluator_namex->employee_name_en;
                    }
                }else{
                    $evaluator_name = '';
                }
                $freeze_to_pagrade = '';
                if ($value->freeze_to_pagrade == '1') {
                    $freeze_to_pagrade = 'disabled';
                }
                $freezex = '';
                if ($value->freeze == '1') {
                    $freezex = 'disabled';
                }
                $data[] = array(
                    "id" =>  '<input type="checkbox" class="checkbox-select-all" name="checkbox-'.$value->id.'" id="checkbox-'.$value->id.'" value="'.$value->id.'" '.$freeze_to_pagrade.'>',
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
                            onclick="gettitle('.$value->group_form_id.',0.1,'.(count($cut_evaluation_criteria_id)+1).',1,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
                                '.($value->compliance_score?$value->compliance_score:'0').'
                        </button>
                        <input type="hidden" class="calAll'.$value->id.'"
                            id="complain_score'.$value->id.'"
                            value="'.$value->compliance_score.'">
                        <input type="hidden" class="calAll_topic_weight'.$value->id.'" value="'.$topic_weight1->compliance_weight_status.'">',
                    "0"=>'<button type="button" class="btn btn-sm btn-primary" style="width:60px"
                            data-bs-toggle="modal" data-bs-target="#attendanceModal"
                            onclick="gettitle('.$value->group_form_id.',0,'.(count($cut_evaluation_criteria_id)+2).',2,'.$value->id.',\''.$value->employee_no.'\',\''.$value->name1.'\');">
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
                    "action"=> '<button type="button" class="btn btn-icon btn-success btn-xs me-1" onclick="set_approveModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#approveModal" '.$freeze_to_pagrade.'>
                                    <i class="ki-solid ki-check-circle fs-5"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" onclick="set_rejectModal_id('.$value->id.');" data-bs-toggle="modal" data-bs-target="#rejectModal" '.$freeze_to_pagrade.'>
                                    <i class="ki-solid ki-cross-circle fs-5"></i>
                                </button>
                                <div class="topic_weight_hidden'.$value->id.'" style="display:none;"></div>',
                    "data_id" =>  $value->id,
                    "evaluator_name" => $evaluator_name,
                    "freeze_to_pagrade" =>  $value->freeze_to_pagrade,
                    "form" =>  $value->form_import,
                );
            }
        }

        foreach ($data as $key1 => $value1) {
            // $data[$key1]['test'] = $value1['group_form_id'];
            if($value1['group_form_id']){
                if($value1['evaluation_criteria_id']){
                    $cut = explode(',',$value1['evaluation_criteria_id']);
                    $cut_criteria_score_new = explode(',',$value1['criteria_score_new']);
                    $data[$key1]['count_evaluation_criteria_id'] = count($cut);
                    foreach ($cut as $key2 => $value2) {
                        $topic_weightx = DB::table('group_form_topic')
                        ->select('topic_weight')
                        ->where('group_form_topic.group_form_id', $value1['group_form_id'])
                        ->where('group_form_topic.evaluation_criteria_id', $value2)
                        ->first();
                        $freeze = '';
                        if ($value1['freeze_to_pagrade'] == '1') {
                            $freeze = 'disabled';
                        }
                        $data[$key1][($key2+1)] = '<input type="text" class="form-control form-control-sm text-center calAll'.$value1['data_id'].'"
                            style="width:60px"
                            min="1"
                            max="10"
                            value="'.($cut_criteria_score_new[$key2]?$cut_criteria_score_new[$key2]:'').'"
                            onclick="gettitle('.$value1['group_form_id'].','.$value2.','.($key2+1).',0,'.$value1['data_id'].');"
                            onfocus="gettitle('.$value1['group_form_id'].','.$value2.','.($key2+1).',0,'.$value1['data_id'].');"
                            onchange="update_score('.$value1['data_id'].',this.value,1);"
                            '.$freeze.'>
                            <input type="hidden" class="calAll_topic_weight'.$value1['data_id'].'" value="'.$topic_weightx->topic_weight.'">';
                    }
                }else{
                    for ($i=1; $i < 11; $i++) {
                        $data[$key1][$i] = '<input type="text" class="form-control form-control-sm text-center calAll'.$value1['data_id'].'"
                            style="width:60px"
                            min="1"
                            max="10"
                            value=""';
                    }
                }
            }
        }
        $result = [
            'data'              => $data,
            'raw'               => $dataraw,
        ];
        echo json_encode($result);

    }

    public function review_get_form_all(Request $request)
    {
        $userID = Auth::user()->id;
        $orisoft_code = Auth::user()->orisoft_code;
        // $orisoft_code = DB::table('users')
        // ->select('orisoft_code')
        // ->where('id',$userID)->first();
        $search_year       = $request->input('search_year');
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();

        $nowyear = date('Ym');
        if(empty($search_year)){
            $previousYear = date('Y');
        } else {
            $previousYear = $search_year;
        }

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{

            // $previousYear = date('Y');
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

        $CountF1 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');


        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF1 = $CountF1->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if($search_division_code == "all"){
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
                $CountF1 = $CountF1->whereIn('tb_employee.division_code',$arr_division_code);
            }

            if($search_department_code == "all"){
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
                $CountF1 = $CountF1->whereIn('tb_employee.department_code',$arr_department_code);
            }
        }
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)

        // exit;
        if($search_division_code != "all"){
            $CountF1->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF1->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF1->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF1->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF1->where('tb_employee_final_score.form_import', 'F1');

        // if($search_status != "0"){
        //     if($search_status == '1'){
        //         $CountF1->where(function ($query) use($search_status) {
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '0');
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '1');
        //         });
        //     }else{
        //         $CountF1->where('tb_employee_final_score.status_evaluation', $search_status);
        //     }
        // }
        // $CountF1->whereIn('tb_employee_final_score.status_evaluation', ['1','2']);
        $CountF1->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF1->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF1->where('tb_employee_final_score.status_evaluation', '2');

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF1->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $rawCountF1 = $CountF1->orderBy('tb_employee_final_score.id', 'DESC')->toRawSql();
        $CountF1 = $CountF1->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $CountF2 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF2 = $CountF2->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if($search_division_code == "all"){
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
                $CountF2 = $CountF2->whereIn('tb_employee.division_code',$arr_division_code);
            }

            if($search_department_code == "all"){
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
                $CountF2 = $CountF2->whereIn('tb_employee.department_code',$arr_department_code);
            }
        }
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)

        // exit;
        if($search_division_code != "all"){
            $CountF2->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF2->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF2->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF2->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF2->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF2->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF2->where('tb_employee_final_score.form_import', 'F2');

        // if($search_status != "0"){
        //     if($search_status == '1'){
        //         $CountF2->where(function ($query) use($search_status) {
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '0');
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '1');
        //         });
        //     }else{
        //         $CountF2->where('tb_employee_final_score.status_evaluation', $search_status);
        //     }
        // }
        $CountF2->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF2->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF2->where('tb_employee_final_score.status_evaluation', '2');
        // $CountF2->whereIn('tb_employee_final_score.status_evaluation', ['1','2']);

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF3 = $CountF3->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if($search_division_code == "all"){
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
                $CountF3 = $CountF3->whereIn('tb_employee.division_code',$arr_division_code);
            }

            if($search_department_code == "all"){
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
                $CountF3 = $CountF3->whereIn('tb_employee.department_code',$arr_department_code);
            }
        }
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)

        // exit;
        if($search_division_code != "all"){
            $CountF3->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF3->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF3->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF3->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF3->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF3->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF3->where('tb_employee_final_score.form_import', 'F3');

        // if($search_status != "0"){
        //     if($search_status == '1'){
        //         $CountF3->where(function ($query) use($search_status) {
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '0');
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '1');
        //         });
        //     }else{
        //         $CountF3->where('tb_employee_final_score.status_evaluation', $search_status);
        //     }
        // }
        $CountF3->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF3->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF3->where('tb_employee_final_score.status_evaluation', '2');
        // $CountF3->whereIn('tb_employee_final_score.status_evaluation', ['1','2']);

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF3->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF3 = $CountF3->orderBy('tb_employee_final_score.id', 'DESC')->get();
        // dd($CountF3);
        // exit;
        $CountF4 = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');

        if($orisoft_code == "000002" || $orisoft_code == "990002"){

        }elseif($orisoft_code == "000026"){
            $CountF4 = $CountF4->where('tb_employee_final_score.evaluator_no','000026');
        }else{
            if($search_division_code == "all"){
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
                $CountF4 = $CountF4->whereIn('tb_employee.division_code',$arr_division_code);
            }

            if($search_department_code == "all"){
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
                $CountF4 = $CountF4->whereIn('tb_employee.department_code',$arr_department_code);
            }
        }
        // ->where('tb_employee.division_code',$tb_employee_evaluator->division_code)

        // exit;
        if($search_division_code != "all"){
            $CountF4->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF4->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF4->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF4->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF4->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF4->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF4->where('tb_employee_final_score.form_import', 'F4');

        // if($search_status != "0"){
        //     if($search_status == '1'){
        //         $CountF4->where(function ($query) use($search_status) {
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '0');
        //             $query->orWhere('tb_employee_final_score.status_evaluation', '1');
        //         });
        //     }else{
        //         $CountF4->where('tb_employee_final_score.status_evaluation', $search_status);
        //     }
        // }
        $CountF4->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF4->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF4->where('tb_employee_final_score.status_evaluation', '2');
        // $CountF4->whereIn('tb_employee_final_score.status_evaluation', ['1','2']);

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF4->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF4 = $CountF4->orderBy('tb_employee_final_score.id', 'DESC')->get();

        // dd($CountF4);
        // exit;

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
            'f1'                => count($CountF1),
            'rawCountF1'                => $rawCountF1,
            'f2'                => count($CountF2),
            'f3'                => count($CountF3),
            'f4'                => count($CountF4),
            // 'count_total_td'                => $count_total_td,
            'checkCountF1'                => $checkCountF1,
            'checkCountF2'                => $checkCountF2,
            'checkCountF3'                => $checkCountF3,
            'checkCountF4'                => $checkCountF4,
        ];
        echo json_encode($result);

    }

    public function check_approve_null(Request $request)
    {
        $userID = Auth::user()->id;
        $search_year       = $request->input('search_year');
        $previousYear = $search_year;
        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();


        // $previousYear = date('Y');

        $search_division_code      = $request->input('search_division_code');
        $search_department_code      = $request->input('search_department_code');
        $search_employee_no      = $request->input('search_employee_no');
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
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');



        if($search_division_code == "all"){
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
            $CountF1 = $CountF1->whereIn('tb_employee.division_code',$arr_division_code);
        }

        if($search_department_code == "all"){
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
            $CountF1 = $CountF1->whereIn('tb_employee.department_code',$arr_department_code);
        }

        if($search_division_code != "all"){
            $CountF1->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF1->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF1->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF1->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF1->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF1->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF1->where('tb_employee_final_score.form_import', 'F1');
        $CountF1->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF1->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF1->where('tb_employee_final_score.status_evaluation', '2');

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF1->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF1->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF1->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');



        if($search_division_code == "all"){
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
            $CountF2 = $CountF2->whereIn('tb_employee.division_code',$arr_division_code);
        }

        if($search_department_code == "all"){
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
            $CountF2 = $CountF2->whereIn('tb_employee.department_code',$arr_department_code);
        }

        if($search_division_code != "all"){
            $CountF2->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF2->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF2->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF2->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF2->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF2->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF2->where('tb_employee_final_score.form_import', 'F2');
        $CountF2->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF2->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF2->where('tb_employee_final_score.status_evaluation', '2');

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF2->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF2->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF2->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');



        if($search_division_code == "all"){
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
            $CountF3 = $CountF3->whereIn('tb_employee.division_code',$arr_division_code);
        }

        if($search_department_code == "all"){
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
            $CountF3 = $CountF3->whereIn('tb_employee.department_code',$arr_department_code);
        }

        if($search_division_code != "all"){
            $CountF3->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF3->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF3->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF3->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF3->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF3->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF3->where('tb_employee_final_score.form_import', 'F3');
        $CountF3->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF3->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF3->where('tb_employee_final_score.status_evaluation', '2');
        // $CountF3->whereIn('tb_employee_final_score.status_evaluation', ['1','2']);

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF3->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF3->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF3->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
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
        // ->where('tb_employee_final_score.evaluator_no',$orisoft_code)
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820');



        if($search_division_code == "all"){
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
            $CountF4 = $CountF4->whereIn('tb_employee.division_code',$arr_division_code);
        }

        if($search_department_code == "all"){
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
            $CountF4 = $CountF4->whereIn('tb_employee.department_code',$arr_department_code);
        }

        if($search_division_code != "all"){
            $CountF4->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $CountF4->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $CountF4->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $CountF4->where('tb_employee.section_code', $search_section);
        }
        if($search_month_day != "all"){
            if($search_month_day == "1"){
                $CountF4->where('tb_employee_final_score.salary_type','Daily');
            }
            if($search_month_day == "2"){
                $CountF4->where('tb_employee_final_score.salary_type','Monthly');
            }
        }
        $CountF4->where('tb_employee_final_score.form_import', 'F4');
        $CountF4->where(function ($query) use($search_status) {
            $query->orWhere('tb_employee_final_score.status_evaluation', '1');
            $query->orWhere('tb_employee_final_score.status_evaluation', '2');
        });
        // $CountF4->where('tb_employee_final_score.status_evaluation', '1');
        // $CountF4->where('tb_employee_final_score.status_evaluation', '2');
        // $CountF4->whereIn('tb_employee_final_score.status_evaluation', ['1','2']);

        if($search_complaince_score != "0"){
            if($search_complaince_score == "1"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [1, 3]);
            }
            if($search_complaince_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [4, 7]);
            }
            if($search_complaince_score == "3"){
                $CountF4->whereBetween('tb_employee_final_score.compliance_score', [8, 10]);
            }
        }

        if($search_attendance_score != "0"){
            if($search_attendance_score == "1"){
                $CountF4->where('tb_employee_final_score.attendance_score', '>=' ,'15');
            }
            if($search_attendance_score == "2"){
                $CountF4->whereBetween('tb_employee_final_score.attendance_score', [7, 14]);
            }
            if($search_attendance_score == "3"){
                $CountF4->where('tb_employee_final_score.attendance_score', '<=' ,'6');
            }
        }

        $CountF4 = $CountF4->orderBy('tb_employee_final_score.id', 'DESC')->get();

        $result = [
            'f1'                => count($CountF1),
            'f2'                => count($CountF2),
            'f3'                => count($CountF3),
            'f4'                => count($CountF4),
        ];
        echo json_encode($result);
    }

    public function export_excel_review_evaluate(Request $request)
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
        // $previousYear = date('Y');

        // $userID = Auth::user()->id;
        // $orisoft_code = Auth::user()->orisoft_code;
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

        $datarow = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.*',
        'tb_employee.date_joined AS date_joined',
        'tb_employee.employee_local_name_en AS name1',
        'tb_employee.employee_local_name_th AS name2',
        'tb_position.position_description AS position_name')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->leftJoin('tb_position','tb_position.position_code','=','tb_employee.position_code')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.employee_status_description','Passed')
        ->where('tb_employee_final_score.freeze','1')
        ->whereNot('tb_employee.grade_code','L810')
        ->whereNot('tb_employee.grade_code','L820')
        ;

        $orisoft_code = Auth::user()->orisoft_code;
        $orisoft_all_code = DB::table('tb_employee_evaluator')
        ->where('tb_employee_evaluator.rec_year','like','%'.$search_year.'%')
        ->where('employee_no',$orisoft_code)->first();

        if($search_division_code == "all"){
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

        if($search_department_code == "all"){
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

        if($search_division_code != "all"){
            $datarow->where('tb_employee.division_code', $search_division_code);
        }

        if($search_department_code != "all"){
            $datarow->where('tb_employee.department_code', $search_department_code);
        }

        if(isset($search_employee_no)){
            if($search_employee_no != "all"){
                $datarow->where('tb_employee_final_score.evaluator_no', $search_employee_no);
            }
        }

        if($search_section != "all"){
            $datarow->where('tb_employee.section_code', $search_section);
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
            if($search_status == '1'){
                $datarow->where(function ($query) use($search_status) {
                    $query->orWhere('tb_employee_final_score.status_evaluation', '0');
                    $query->orWhere('tb_employee_final_score.status_evaluation', '1');
                });
            }else{
                $datarow->where('tb_employee_final_score.status_evaluation', $search_status);
            }
        }

        if($search_complaince_score != "0"){
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

        if($search_attendance_score != "0"){
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

        $datarow = $datarow->orderBy('tb_employee_final_score.total_score', 'DESC')->orderBy('tb_employee_final_score.evaluator_no', 'ASC')->get();


        $data = [];
        if($datarow){
            foreach ($datarow as $key => $value) {
                $status_evaluation = '';
                if($value->status_evaluation == '0'){
                    $status_evaluation = '';
                }else if($value->status_evaluation == '1'){
                    $status_evaluation = 'Wait for approval';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = 'Reject';
                }else if($value->status_evaluation == '3'){
                    $status_evaluation = 'Approved';
                }
                $data[] = array(
                    "code"=> $value->employee_no,
                    "name"=> (Session::get('locale') == "th" ?$value->name2:$value->name1),
                    "position"=> $value->position_name,
                    "date"=> changedata($value->date_joined),
                    "service"=> $value->service_days,
                    "evaluator_name" => (Session::get('locale') == "th" ?$value->evaluator_name_th:$value->evaluator_name_en),
                    "form" =>  $value->form_import,
                    "total"=> number_format($value->total_score,1,'.',''),
                    "remark"=> $value->remark,
                    "remark_manager"=> $value->remark_manager,
                    "status"=> $status_evaluation,
                );
            }
        }


        $excel = public_path('upload/orisoft/')."template_form_review.xlsx";
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
                $sheet->setCellValue('F'.$numsheet1, $value['evaluator_name']);
                $sheet->setCellValue('G'.$numsheet1, $value['form']);
                $sheet->setCellValue('H'.$numsheet1, $value['total']);
                $sheet->setCellValue('I'.$numsheet1, $value['remark']);
                $sheet->setCellValue('J'.$numsheet1, $value['remark_manager']);
                $sheet->setCellValue('K'.$numsheet1, $value['status']);
                $numsheet1++;
            }
        }
        // กำหนดชื่อไฟล์ excel ที่ต้องการ
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Evaluate_Review.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
}
