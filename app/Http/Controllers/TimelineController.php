<?php

namespace App\Http\Controllers;

use App\DataTables\TimelineDataTable;
use App\Http\Controllers\Controller;
use App\Models\EmployeeLogModel;
use App\Models\EmployeeModel;
use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\pa\Action;
use App\Models\pa\Patimeline;
use App\Models\Users;

use Auth;
// use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TimelineController extends Controller
{
    public function index(TimelineDataTable $dataTable)
    {
        $send_mail = DB::table('users')
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','users.orisoft_code')
        ->orwhere('tb_employee_evaluator.position_code','106')
        ->orderBy('users.id', 'ASC')->get();

        $send_mail_manager = DB::table('users')
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','users.orisoft_code')
        ->where('tb_employee_evaluator.position_code','105')
        ->orderBy('users.id', 'ASC')->get();

        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        if(trans(request()->segment(1)) == 'manager'){
            $arrHr = ['104'];
            $arrManager = ['104','105','106','103'];
        }else if(trans(request()->segment(1)) == 'mtl'){
            $arrHr = ['104'];
            $arrManager = ['104','105','106','103'];
        }else{
            $arrHr = ['106'];
            $arrManager = ['105','106','103'];
        }
        
        $data_hr = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->whereIn('tb_employee_evaluator.position_code',$arrHr)
        ->orderBy('tb_employee_evaluator.employee_no', 'ASC')->get();

        $data_manager = DB::table('tb_employee_evaluator')
        ->select('tb_employee_evaluator.employee_no',
                'tb_employee_evaluator.employee_name_th',
                'tb_employee_evaluator.employee_name_en')
        ->whereIn('tb_employee_evaluator.position_code',$arrManager)
        ->orderBy('tb_employee_evaluator.employee_no', 'ASC')->get();
        
        return $dataTable->render('pages.apps.pa.timeline.config_timeline', [
            'year' => Patimeline::orderby('created', 'desc')->get(),
            "send_mail" => $send_mail,
            "send_mail_manager" => $send_mail_manager,
            "data_hr" => $data_hr,
            "data_manager" => $data_manager
        ]);
        // return view('pages.pa.timeline.index');
    }

    public function config_timeline(TimelineDataTable $dataTable)
    {
        $send_mail = DB::table('users')
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','users.orisoft_code')
        ->orwhere('tb_employee_evaluator.position_code','106')
        ->orderBy('users.id', 'ASC')->get();

        $send_mail_manager = DB::table('users')
        ->leftJoin('tb_employee_evaluator','tb_employee_evaluator.employee_no','=','users.orisoft_code')
        ->where('tb_employee_evaluator.position_code','105')
        ->orderBy('users.id', 'ASC')->get();

        // $employee = DB::table('tb_employee')->select('id','employee_local_name_th')->where('position_code','')->get();
        return $dataTable->render('pages.apps.pa.timeline.config_timeline', [
            'year' => Patimeline::orderby('created', 'asc')->get(),
            "send_mail" => $send_mail,
            "send_mail_manager" => $send_mail_manager
        ]);
    }

    public function table_timeline_getdata(Request $request)
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
        $like = $request->Like;
        $timeline = Patimeline::when($like, function ($query) use ($like) {
            if (@$like['year'] != "") {
                $query->where('year', @$like['year']);
            }
        })->orderby('created', 'asc')->get();
        if (count($timeline) > 0) {
            for ($i = 0; $i < count($timeline); $i++) {
                $title = $timeline[$i]->title;
                $date = date('Y-m-d', strtotime($timeline[$i]->date));
                $button = '<a href="timeline/config_timeline"  type="button">การจัดการ</a>';
                $data[] = array(
                    "no" =>  $i + 1,
                    "name" => $title,
                    "year" => $date,
                    "button" =>  $button,
                );
            }
            $result = [
                'recordsTotal'    => count($timeline),
                'recordsFiltered' => count($timeline),
                'data'            => $data,
            ];
            echo json_encode($result);
        } else {
            $data[] = array(
                "no" =>  '-',
                "name" => 'ไม่พบข้อมูล',
                "year" => '-',
                "button" =>  '-',
            );
            $result = [
                'recordsTotal'    => count($timeline),
                'recordsFiltered' => count($timeline),
                'data'            => $data,
            ];
            echo json_encode($result);
        }
    }

    public function table_config_timeline_getdata(Request $request)
    {
        $like = $request->Like;
        $search_year = $request->search_year;
        $action = Action::when($like, function ($query) use ($like) {
            if (@$like['id'] != "") {
                $query->where('pa_timeline_id', @$like['id']);
            }
        })->orderby('created', 'asc')->get();
        // $result = [
        //     '$search_year'            => $search_year,
        //     '$action'            => $action,
        //     '$like'            => $like,
        //     'id'            => $like['id'],
        // ];
        // echo json_encode($result);
        // exit;
        if ($like['id'] != "no") {
            for ($i = 0; $i < count($action); $i++) {
                $topic = $action[$i]->action_name;
                $hr = $action[$i]->hr;
                $manager = $action[$i]->manager;
                $dm = $action[$i]->dm;
                $gm = $action[$i]->gm;
                $id = $action[$i]->id;
                
                if ($action[$i]->start_date != null) {
                    $plan_start = date('d/M', strtotime($action[$i]->start_date));
                } else $plan_start = '';

                if ($action[$i]->end_date != null) {
                    $plan_end = date('d/M', strtotime($action[$i]->end_date));
                } else $plan_end = '';

                if ($action[$i]->start_date_real != null) {
                    $real_start = date('d/M', strtotime($action[$i]->start_date_real));
                } else $real_start = '';

                if ($action[$i]->end_date_real != null) {
                    $real_end = date('d/M', strtotime($action[$i]->end_date_real));
                } else $real_end = '';

                if($action[$i]->end_date){
                    if($action[$i]->start_date == $action[$i]->end_date){
                        $timeline_plan = date("j M", strtotime($action[$i]->end_date));
                    }else{
                        $start_date = $action[$i]->start_date;
                        $end_date = $action[$i]->end_date;
                        $start_date_formatted = date("j", strtotime($start_date));
                        $end_date_formatted = date("j M", strtotime($end_date));
                        $timeline_plan = $start_date_formatted . '-' . $end_date_formatted;
                    } 
                }else{
                    $timeline_plan = "-";
                }
                if($action[$i]->end_date_real){
                    if($action[$i]->start_date_real == $action[$i]->end_date_real){
                        $timeline_real = date("j M", strtotime($action[$i]->end_date_real));
                    }else{
                        $start_date_real = $action[$i]->start_date_real;
                        $end_date_real = $action[$i]->end_date_real;
                        $start_date_real_formatted = date("j", strtotime($start_date_real));
                        $end_date_real_formatted = date("j M", strtotime($end_date_real));
                        if($start_date_real == null){
                            $timeline_real = $end_date_real_formatted;
                        }else{
                            $timeline_real = $start_date_real_formatted . '-' . $end_date_real_formatted;
                        }
                    }   
                }else{
                    $timeline_real = "-";
                }
                
                $check = '';
                $checkActive = 'InActive';
                $checkbgcolor = 'background-color: #FFF5F8;';
                $checkcolor = 'color: #F1416C;';
                if($action[$i]->status==1){
                    $check = 'checked="checked"';
                    $checkActive = 'Active';
                    $checkbgcolor = 'background-color: #E8FFF3;';
                    $checkcolor = 'color: #50CD89;';
                }
                
                $data[] = array(
                    "id" => $id,
                    "status" => '<div style="display: flex;align-items: center;justify-content: center;">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
                                        <input class="form-check-input h-30px w-50px" type="checkbox" value="1" id="flexSwitchDefault'.$id.'" '.$check.'  onchange="changeactive('.$id.');"/>
                                    </div>
                                    <div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;'.$checkbgcolor.'">
                                        <span style="'.$checkcolor.'">'.$checkActive.'</span>
                                    </div>
                                </div>',
                    "checkbox" =>  '',
                    "no" =>  $i + 1,
                    "topic" => '<div class="overflow">' . $topic . '</div>',
                    "timeline_plan" =>  $timeline_plan,
                    "timeline_real" =>  $timeline_real,
                    "hr" => $hr,
                    "manager" =>  $manager,
                    "dm" =>  $dm,
                    "gm" =>  $gm,
                    "hr_select" =>  $action[$i]->manager_select,
                    "manager_select" =>  $action[$i]->manager_select,
                );
            }

            $checkYearABC = $search_year;
            $countABC0 = DB::table('tb_employee')
            ->whereNull('employee_status_description')
            ->count();
            
            $countABC1 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.group_form_id','0')
            ->whereNull('tb_employee_final_score.evaluator_no')
            ->where('tb_employee.employee_status_description','!=','Resigned')
            ->count();

            $countABC2 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.freeze','0')
            ->where('tb_employee.employee_status_description','Passed')
            ->count();

            $countABC3 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.freeze_to_pagrade','0')
            ->where('tb_employee.employee_status_description','Passed')
            ->count();

            $countABC4 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->whereNull('tb_employee_final_score.adjust_grade')
            ->where('tb_employee.employee_status_description','Passed')
            ->count();
            
            $countABC5 = DB::table('tb_budget_action')
            ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
            ->where('tb_budget.year','like','%'.$checkYearABC.'%')
            ->whereNull('tb_budget_action.std')
            ->where('tb_budget_action.grade_name','!=','U')
            ->where('tb_budget_action.grade_name','!=','CD')
            ->count();
            
            $countABC7 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.freeze_to_gmdm','0')
            ->where('tb_employee.employee_status_description','Passed')
            ->count();
            
            $countABC9 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.salary_type','Daily')
            ->where('tb_employee_final_score.freeze_to_approve_hr','0')
            ->where('tb_employee.employee_status_description','Passed')
            ->count();
            
            $countABC10 = DB::table('tb_employee_final_score')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.salary_type','Monthly')
            ->where('tb_employee_final_score.freeze_to_approve_hr','0')
            ->where('tb_employee.employee_status_description','Passed')
            ->count();
            $countABC1_get = DB::table('tb_employee_final_score')
            ->select('tb_employee_final_score.updated_at')
            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
            ->where('tb_employee_final_score.group_form_id','!=','0')
            ->whereNotNull('tb_employee_final_score.evaluator_no')
            ->where('tb_employee.employee_status_description','!=','Resigned')
            ->orderBy('tb_employee_final_score.updated_at','desc')
            ->first();
            
            $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYearABC)->first();
            if($tb_pa_timeline){
                $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')
                ->where('pa_timeline_id', $tb_pa_timeline->id)
                // ->whereNull('end_date_real')
                ->get();

                if(count($tb_pa_timeline_action)>0){
                    foreach ($tb_pa_timeline_action as $key => $val) {
                        if($countABC0 == 0 && $key == 0 && $val->end_date_real == null){
                            $id = DB::table('tb_pa_timeline_action')
                            ->where('id', $val->id )
                            ->update(["end_date_real" => date('Y-m-d')]);
                        }
                        if($countABC1 == 0 && $key == 1 && $val->end_date_real == null){
                            $countABC1_get = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.updated_at')
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                            ->where('tb_employee_final_score.group_form_id','!=','0')
                            ->whereNotNull('tb_employee_final_score.evaluator_no')
                            ->where('tb_employee.employee_status_description','!=','Resigned')
                            ->orderBy('tb_employee_final_score.updated_at','desc')
                            ->first();
                            if($countABC1_get ){
                                $id = DB::table('tb_pa_timeline_action')
                                ->where('id', $val->id )
                                ->update(["end_date_real" => $countABC1_get->updated_at]);
                            }
                            
                        }
                        if($countABC2 == 0 && $key == 2 && $val->end_date_real == null){
                            $countABC2_get = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.updated_at')
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                            ->where('tb_employee_final_score.freeze','1')
                            ->where('tb_employee.employee_status_description','Passed')
                            ->orderBy('tb_employee_final_score.updated_at','desc')
                            ->first();
                            if($countABC2_get ){
                                $id = DB::table('tb_pa_timeline_action')
                                ->where('id', $val->id )
                                ->update(["end_date_real" => $countABC2_get->updated_at]);
                            }
                            
                        }
                        if($countABC3 == 0 && $key == 3 && $val->end_date_real == null){
                            $countABC3_get = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.updated_at')
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                            ->where('tb_employee_final_score.freeze_to_pagrade','1')
                            ->where('tb_employee.employee_status_description','Passed')
                            ->orderBy('tb_employee_final_score.updated_at','desc')
                            ->first();
                            if($countABC3_get ){
                                $id = DB::table('tb_pa_timeline_action')
                                ->where('id', $val->id )
                                ->update(["end_date_real" => $countABC3_get->updated_at]);
                            }
                            
                        }
                        if($countABC4 == 0 && $key == 4 && $val->end_date_real == null){
                            $countABC4_get = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.updated_at')
                            ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                            ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                            ->whereNotNull('tb_employee_final_score.adjust_grade')
                            ->where('tb_employee.employee_status_description','Passed')
                            ->orderBy('tb_employee_final_score.updated_at','desc')
                            ->first();
                            if($countABC4_get){
                                $id = DB::table('tb_pa_timeline_action')
                                ->where('id', $val->id )
                                ->update(["end_date_real" => $countABC4_get->updated_at]);
                            }
                            
                        }
                        // if($countABC5 == 0 && $key == 5 && $val->end_date_real == null){
                        //     $countABC5_get = DB::table('tb_budget_action')
                        //     ->select('tb_budget_action.updated')
                        //     ->leftJoin('tb_budget','tb_budget.id','=','tb_budget_action.budget_id')
                        //     ->where('tb_budget.year','like','%'.$checkYearABC.'%')
                        //     ->whereNotNull('tb_budget_action.std')
                        //     ->where('tb_budget_action.grade_name','!=','U')
                        //     ->where('tb_budget_action.grade_name','!=','CD')
                        //     ->orderBy('tb_budget_action.updated','desc')
                        //     ->first();
                        //     $id = DB::table('tb_pa_timeline_action')
                        //     ->where('id', $val->id )
                        //     ->update(["end_date_real" => $countABC5_get->updated]);
                        // }
                        // if($countABC7 == 0 && $key == 7 && $val->end_date_real == null){
                        //     $countABC7_get = DB::table('tb_employee_final_score')
                        //     ->select('tb_employee_final_score.updated_at')
                        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                        //     ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                        //     ->where('tb_employee_final_score.freeze_to_gmdm','1')
                        //     ->where('tb_employee.employee_status_description','Passed')
                        //     ->orderBy('tb_employee_final_score.updated_at','desc')
                        //     ->first();
                        //     $id = DB::table('tb_pa_timeline_action')
                        //     ->where('id', $val->id )
                        //     ->update(["end_date_real" => $countABC7_get->updated_at]);
                        // }
                        // if($countABC9 == 0 && $key == 9 && $val->end_date_real == null){
                        //     $countABC9_get = DB::table('tb_employee_final_score')
                        //     ->select('tb_employee_final_score.updated_at')
                        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                        //     ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                        //     ->where('tb_employee_final_score.salary_type','Daily')
                        //     ->where('tb_employee_final_score.freeze_to_approve_hr','1')
                        //     ->where('tb_employee.employee_status_description','Passed')
                        //     ->orderBy('tb_employee_final_score.updated_at','desc')
                        //     ->first();
                        //     $id = DB::table('tb_pa_timeline_action')
                        //     ->where('id', $val->id )
                        //     ->update(["end_date_real" => $countABC9_get->updated_at]);
                        // }
                        // if($countABC10 == 0 && $key == 10 && $val->end_date_real == null){
                        //     $countABC10_get = DB::table('tb_employee_final_score')
                        //     ->select('tb_employee_final_score.updated_at')
                        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                        //     ->where('tb_employee_final_score.rec_year','like','%'.$checkYearABC.'%')
                        //     ->where('tb_employee_final_score.salary_type','Monthly')
                        //     ->where('tb_employee_final_score.freeze_to_approve_hr','1')
                        //     ->where('tb_employee.employee_status_description','Passed')
                        //     ->orderBy('tb_employee_final_score.updated_at','desc')
                        //     ->first();
                        //     $id = DB::table('tb_pa_timeline_action')
                        //     ->where('id', $val->id )
                        //     ->update(["end_date_real" => $countABC10_get->updated_at]);
                        // }
                    }
                }
                $result = [
                    'recordsTotal'    => 1,
                    'recordsFiltered' => 1,
                    'data'            => $data,
                ];
            }else{
                $result = [
                    'recordsTotal'    => 1,
                    'recordsFiltered' => 1,
                    'data'            => [],
                ];
            }
            

            // $result = [
            //     'countABC1'            => $countABC1,
            //     'countABC1_get'            => $countABC1_get,
            //     'tb_pa_timeline_action'            => $tb_pa_timeline_action,
            // ];
            // echo json_encode($result);
            // exit;
            
            
            
            
            echo json_encode($result);
        } else {
            $data = [];
            $result = [
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => $data,
            ];
            echo json_encode($result);
        }
    }
    public function add_timeline()
    {
        try {

            $date = date('Y-m-d');
            $year = date('Y');
            $timeline = Patimeline::where('year', $year)->get();
            $action_name[0] = 'Review Evaluator Lists';
            $action_name[1] = 'HR distributes PA Forms to Managers';
            $action_name[2] = 'Managers return the completed PA Forms to HR';
            $action_name[3] = 'HR Inputs PA Scores into a summary Excel file';
            $action_name[4] = 'Discuss and Finalise the annual increment budget with GM';
            $action_name[5] = 'Meeting with managers to inform the timeline, %increment budget of each PA Grade, and Guideline.';
            $action_name[6] = 'HR distributed Annual Increment Excel';
            $action_name[7] = 'Managers complete annual increment Excel file and review their increment proposal with director of
            manufacturing or GM for approval (this step shall depending on the organization structure)';
            $action_name[8] = 'Announce the annual increment to all MIL staff';
            $action_name[9] = 'For all Daily Workers/Operators: Managers submit the final/approved increment to HR';
            $action_name[10] = 'For all Monthly Employees: Managers submit the final/approved increment to HR';
            $action_name[11] = 'HR summarize the results of increment of all divisions/departments and send to GM for final review';
            $action_name[12] = 'Payment new salary Apr ' . $year . ' - Daily Workers';
            $action_name[13] = 'Payment new salary Apr ' . $year . ' - Monthly Employee';

            if (count($timeline) > 0) {
                DB::rollback();
                $status = 409;
                $message = "มีเลขที่นี้แล้ว";
            } else {
                $oldYear = date('Y') - 1;
                $newYear = date('Y'); // สมมุติว่าในปีปัจจุบันจะได้ 2025
                $countrecords = DB::table('tb_employee_evaluator')->where('rec_year', $oldYear)->count();
                if($countrecords == 0){
                    $records = DB::table('tb_employee_evaluator')->where('rec_year', $oldYear)->get();
                    foreach ($records as $record) {
                        // แปลง object เป็น array
                        $data = (array)$record;
                        // หากมีคอลัมน์ primary key (เช่น id) ให้ unset เพื่อให้ระบบสร้างค่าใหม่ให้ record ใหม่
                        unset($data['id']);
                        // เปลี่ยนค่าในฟิลด์ year จาก 2024 เป็นปีปัจจุบัน (2025)
                        $data['rec_year'] = $newYear;
                        
                        // Insert ข้อมูลใหม่
                        DB::table('tb_employee_evaluator')->insert($data);
                    }
                }
                
                
                $data = new Patimeline();
                $data->title = 'Performance Appraisal and ' . $year . ' annual increment';
                $data->date = $date;
                $data->year = $year;
                $data->save();
                if ($data->save()) {
                    for ($i = 0; $i < 14; $i++) {
                        $data = Patimeline::all()->Last();
                        $action = new Action();
                        $action->pa_timeline_id = $data->id;
                        $action->action_name = $action_name[$i];
                        $action->save();
                    }

                    
                    DB::commit();
                    $status = 200;
                    $message = "บันทึกสำเร็จ";
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function fetch_config($test,$id)
    {
        $action = Action::find($id);
        
        
        // $hr_select_des = null;
        // if($action->hr_select){
        //     $a = explode(',',$action->hr_select);
        //     foreach ($a as $key2 => $val2) {
        //         $data = Users::where('orisoft_code', $val2)->first();
        //         $hr_select_des .= $data->name.',';
        //     }
        // }
        // $hr_select_des = substr($hr_select_des,0,-1);
        // $action->hr_select_des = $hr_select_des;


        // $manager_select_des = null;
        // if($action->manager_select){
        //     $a2 = explode(',',$action->manager_select);
        //     foreach ($a2 as $key2 => $val2) {
        //         $data2 = Users::where('orisoft_code', $val2)->first();
        //         $manager_select_des .= $data2->name.',';
        //     }
        // }
        // $manager_select_des = substr($manager_select_des,0,-1);
        // $action->manager_select_des = $manager_select_des;

        // $action->manager_select_des = $data2->name;
        return $action;
    }
    public function addedit_action(Request $request)
    {
        $add_hr_select = NULL;
        if(isset($request->add_hr_select)){
            if(count($request->add_hr_select) > 0){
                foreach ($request->add_hr_select as $key2 => $val2) {
                    $add_hr_select .= $val2.',';
                }
                $add_hr_select = substr($add_hr_select,0,-1);
            }
        }
        $add_manager_select = NULL;
        if(isset($request->add_manager_select)){
            if(count($request->add_manager_select) > 0){
                foreach ($request->add_manager_select as $key2 => $val2) {
                    $add_manager_select .= $val2.',';
                }
                $add_manager_select = substr($add_manager_select,0,-1);
            }
        }
        
        
        // dd($add_hr_select);
        // exit;
        try {
            $action = new Action();
            
            $action->action_name = $request->add_title;
            $action->start_date = $request->add_start_date;
            $action->end_date = $request->add_end_date;
            $action->start_date_real = $request->add_start_date_real;
            $action->end_date_real = $request->add_end_date_real;
            if ($request->add_hr != 'active') {
                $action->hr = 'inactive';
            } else {
                $action->hr = 'active';
            }
            if ($request->add_manager != 'active') {
                $action->manager = 'inactive';
            } else {
                $action->manager = 'active';
            }
            if ($request->add_dm != 'active') {
                $action->dm = 'inactive';
            } else {
                $action->dm = 'active';
            }
            if ($request->add_gm != 'active') {
                $action->gm = 'inactive';
            } else {
                $action->gm = 'active';
            }
            $data = Patimeline::all()->Last();
            $action->pa_timeline_id = $data->id;
            $action->hr_select = $add_hr_select;
            $action->manager_select = $add_manager_select;
            $action->save();
            if ($action->save()) {

                DB::commit();
                $status = 200;
                $message = "บันทึกสำเร็จ";
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function edit_action(Request $request)
    {
        $hr_select = NULL;
        if(isset($request->hr_select)){
            if(count($request->hr_select) > 0){
                foreach ($request->hr_select as $key2 => $val2) {
                    $hr_select .= $val2.',';
                }
                $hr_select = substr($hr_select,0,-1);
            }
        }
        $manager_select = NULL;
        if(isset($request->manager_select)){
            if(count($request->manager_select) > 0){
                foreach ($request->manager_select as $key2 => $val2) {
                    $manager_select .= $val2.',';
                }
                $manager_select = substr($manager_select,0,-1);
            }
        }
        
        
        // dd($hr_select);
        // exit;
        try {
            $action = Action::find($request->id_action);
            $action->action_name = $request->title;
            $action->start_date = $request->start_date;
            $action->end_date = $request->end_date;
            $action->start_date_real = $request->start_date_real;
            $action->end_date_real = $request->end_date_real;
            if ($request->hr != 'active') {
                $action->hr = 'inactive';
            } else {
                $action->hr = 'active';
            }
            if ($request->manager != 'active') {
                $action->manager = 'inactive';
            } else {
                $action->manager = 'active';
            }
            if ($request->dm != 'active') {
                $action->dm = 'inactive';
            } else {
                $action->dm = 'active';
            }
            if ($request->gm != 'active') {
                $action->gm = 'inactive';
            } else {
                $action->gm = 'active';
            }
            $action->hr_select = $hr_select;
            $action->manager_select = $manager_select;
            $action->save();
            if ($action->save()) {

                DB::commit();
                $status = 200;
                $message = "บันทึกสำเร็จ";
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function make_group()
    {
        try {
            $get_section = EmployeeLogModel::select('SECTION_CODE', 'SECTION_DESCRIPTION')
                ->groupby('SECTION_CODE', 'SECTION_DESCRIPTION')
                ->get();
            $get_division = EmployeeLogModel::select('DIVISION_CODE', 'DIVISION_DESCRIPTION')
                ->groupby('DIVISION_CODE', 'DIVISION_DESCRIPTION')
                ->get();
            $get_department = EmployeeLogModel::select('DEPARTMENT_CODE', 'DEPARTMENT_DESCRIPTION')
                ->groupby('DEPARTMENT_CODE', 'DEPARTMENT_DESCRIPTION')
                ->get();
            $get_position = EmployeeLogModel::select('POSITION_CODE', 'POSITION_DESCRIPTION')
                ->groupby('POSITION_CODE', 'POSITION_DESCRIPTION')
                ->get();

            foreach ($get_section as $section) {
                $existingSection = Section::where('section_code', $section->SECTION_CODE)->first();
                if (!$existingSection) {
                    $input_section = new Section();
                    $input_section->section_code = $section->SECTION_CODE;
                    $input_section->section_description = $section->SECTION_DESCRIPTION;
                    $input_section->save();
                }
            }

            foreach ($get_division as $division) {
                $existingDivision = Division::where('division_code', $division->DIVISION_CODE)->first();
                if ($existingDivision) {
                    $input_division = new Division();
                    $input_division->division_code = $division->DIVISION_CODE;
                    $input_division->division_description = $division->DIVISION_DESCRIPTION;
                    $input_division->save();
                }
            }
            foreach ($get_department as $department) {
                $existingDepartment = Department::where('department_code', $department->DEPARTMENT_CODE)->first();
                if ($existingDepartment) {
                    $input_deparment = new Department();
                    $input_deparment->deparment_code = $department->DEPARTMENT_CODE;
                    $input_deparment->deparment_description = $department->DEPARTMENT_DESCRIPTION;
                    $input_deparment->save();
                }
            }
            foreach ($get_position as $position) {
                $existingPosition = Department::where('POSITION_CODE', $position->POSITION_CODE)->first();
                if ($existingPosition) {
                    $input_position = new Position();
                    $input_position->position_code = $position->POSITION_CODE;
                    $input_position->position_description = $position->POSITION_DESCRIPTION;
                    $input_position->save();
                }
            }
            if ($input_section->save() && $input_position->save() && $input_division->save() && $input_position->save()) {
                DB::commit();
                $status = 200;
                $message = "บันทึกสำเร็จ";
            }
        } catch (\Exception $e) {
            DB::rollback();
            $status = 500;
            $message = "บันทึกไม่สำเร็จ";
            dd($e);
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function timeline_changeactive(Request $request)
    {
        $id = DB::table('tb_pa_timeline_action')
        ->where('id', $request->input('id') )
        ->update(['status' => $request->input('status')]);

        // DB::table('evaluation_criteria')->where('id', $request->input('id'))->delete();
        // $id = DB::table('evaluation_criteria')->where('id', $request->input('id') )
        // ->update([
        //     'criteria_active' => '0'
        // ]);
        $data = array(
            "status" =>  200
        );
        echo json_encode($data); 
    }

    public function changeactiveuser(Request $request)
    {
        $id = DB::table('users')
        ->where('id', $request->input('id') )
        ->update(['active' => $request->input('status')]);
        $data = array(
            "status" =>  200
        );
        echo json_encode($data); 
    }

    public function reset_password(Request $request)
    {
        $Users = Users::where('id', $request->input('id'))->first();
        $pass = Hash::make($Users->orisoft_code);
        $id = DB::table('users')
        ->where('id', $request->input('id') )
        ->update(["password" => $pass]);
        $data = array(
            "status" =>  200
        );
        echo json_encode($pass); 
    }

    

    public function test_enddate(Request $request)
    {
        $checkYear = date('Y');
        // $count = DB::table('tb_employee_final_score')
        // ->where('rec_year','like','%'.$checkYear.'%')
        // ->where('status_pa','<=','1')
        // ->count();
        // if($count == 0){
        //     $tb_pa_timeline = DB::table('tb_pa_timeline')->where('year', $checkYear)->first();
        //     $tb_pa_timeline_action = DB::table('tb_pa_timeline_action')->where('pa_timeline_id', $tb_pa_timeline->id)->get();
        //     if(count($tb_pa_timeline_action)>0){
        //         foreach ($tb_pa_timeline_action as $key => $val) {
        //             if($key == 0){
        //                 $id = DB::table('tb_pa_timeline_action')
        //                 ->where('id', $val->id )
        //                 ->update(["end_date_real" => date('Y-m-d')]);
        //             }
        //         }
        //     }
        // }

        $updated_at = DB::table('tb_employee_final_score')
                        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                        ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                        ->where('tb_employee_final_score.freeze','0')
                        ->where('tb_employee.employee_status_description','Passed')
                        ->orderBy('tb_employee_final_score.updated_at','DESC')
                        ->first();

        $data = array(
            "updated_at" =>  $updated_at
        );
        echo json_encode($data); 
    }
}
