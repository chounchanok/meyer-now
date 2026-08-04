<?php

namespace App\Http\Controllers;

use App\DataTables\FollowDataTable;
use App\Http\Controllers\Controller;
use App\Models\EmployeeModel;
use App\Models\User;
use App\Models\EmployeeFinalScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FollowController extends Controller
{
    public function index(FollowDataTable $dataTable)
    {
        $department = DB::table('tb_department')->select('id','department_code','department_description')->get();
        return $dataTable->render('pages.apps.pa.follow.index', [
            "department" => $department,
            'year' => EmployeeFinalScore::groupBy('rec_year')->orderby('rec_year', 'asc')->get()
        ]);
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        // return $dataTable->render('pages.apps.pa.follow.index', [
        //     $department = EmployeeModel::whereIn('id', function ($qur) {
        //         $qur->select(DB::raw('MAX(id)'))
        //             ->from('tb_employee')
        //             ->groupBy('DEPARTMENT_CODE');
        //     })->get(),

        // ]);
    }

    public function hr_page(FollowDataTable $dataTable)
    {
        $yearnow = date('Y');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
        //     $previousYear = date('Ym');
            $checkYear = date('Y');
        // }
        $timeline = DB::table('tb_pa_timeline')->select('id')->where('year', $checkYear )->first();
        $pa_timeline_action = DB::table('tb_pa_timeline_action')->where('pa_timeline_id',$timeline->id)->get();
        $factory = DB::table('factory')->get();
        $department = DB::table('tb_department')->select('id','department_code','department_description')->get();
        return $dataTable->render('pages.apps.pa.follow.hr', [
            "pa_timeline_action" => $pa_timeline_action,
            "factory" => $factory,
            "department" => $department,
            'year' => EmployeeFinalScore::groupBy('rec_year')->orderby('rec_year', 'asc')->get()
        ]);
    }

    public function table_follow_getdata(Request $request)
    {
        $search_department      = $request->input('search_department');
        $previousYear      = $request->input('year');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
        //     $previousYear = date('Y');
        // }

        $timeline = DB::table('tb_pa_timeline')->select('id')->where('year', $previousYear )->first();
        if(!$timeline){
            $result = [
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ];
            echo json_encode($result);
            return false;
        }
        $pa_timeline_action = DB::table('tb_pa_timeline_action')->where('pa_timeline_id',$timeline->id)->get();
        
        $active1 = 0;
        $active2 = 0;
        $active3 = 0;
        $active4 = 0;
        $active5 = 0;
        $active6 = 0;
        $active7 = 0;
        $active8 = 0;
        $active9 = 0;
        $active10 = 0;
        $active11 = 0;
        $active12 = 0;
        $active13 = 0;
        $active14 = 0;
        foreach ($pa_timeline_action as $keyxxx => $valuexxx) {
            if($keyxxx == 0){
                if($valuexxx->status == '1'){
                    $active1++;
                }
            }
            if($keyxxx == 1){
                if($valuexxx->status == '1'){
                    $active2++;
                }
            }
            if($keyxxx == 2){
                if($valuexxx->status == '1'){
                    $active3++;
                }
            }
            if($keyxxx == 3){
                if($valuexxx->status == '1'){
                    $active4++;
                }
            }
            if($keyxxx == 4){
                if($valuexxx->status == '1'){
                    $active5++;
                }
            }
            if($keyxxx == 5){
                if($valuexxx->status == '1'){
                    $active6++;
                }
            }
            if($keyxxx == 6){
                if($valuexxx->status == '1'){
                    $active7++;
                }
            }
            if($keyxxx == 7){
                if($valuexxx->status == '1'){
                    $active8++;
                }
            }
            if($keyxxx == 8){
                if($valuexxx->status == '1'){
                    $active9++;
                }
            }
            if($keyxxx == 9){
                if($valuexxx->status == '1'){
                    $active10++;
                }
            }
            if($keyxxx == 10){
                if($valuexxx->status == '1'){
                    $active11++;
                }
            }
            if($keyxxx == 11){
                if($valuexxx->status == '1'){
                    $active12++;
                }
            }
            if($keyxxx == 12){
                if($valuexxx->status == '1'){
                    $active13++;
                }
            }
            if($keyxxx == 13){
                if($valuexxx->status == '1'){
                    $active14++;
                }
            }
        }
        // dd($active14);
        // exit;
        
        $department = EmployeeModel::groupBy('tb_employee.department_code');
        if($search_department != '0'){
            $department  = $department->where('tb_employee.department_code', $search_department);
        }
        $department  = $department->get();
        
        // $all = EmployeeFinalScore::
        // select('tb_employee_final_score.*',
        // 'tb_employee.department_description AS department_description',
        // 'tb_employee.employee_local_name_th AS employee_local_name_th')
        // ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        // ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
        // if($search_department != '0'){
        //     $all  = $all ->where('tb_employee.department_code', $search_department);
        // }
        // $all  = $all ->count();

        
        if (count($department) > 0) {
            // $data = [];
            foreach ($department as $key => $value) {
                
                
                
                // $data[] = array(
                //     "no" =>  $key + 1,
                //     "department_name" =>  $value->department_description,
                // );
                $data[$key]['no'] = $key + 1;
                $data[$key]['department_name'] = $value->department_description;

                // array_push($data,array(
                //     "no" =>  $key + 1,
                //     "department_name" =>  $value->department_description
                // ));
                if($active1 > 0){
                    $all1 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all1  = $all1 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all1 = $all1->where('tb_employee.department_code', $value->department_code);
                    }
                    $all1  = $all1 ->count();
                    
                    $progress1 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '1');
                    if($search_department != '0'){
                        $progress1 = $progress1->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress1 = $progress1->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress1 = $progress1->count();
                    $sum_progress1 = 0;
                    if($progress1 > 0){
                        $sum_progress1 = ($progress1/$all1)*100;
                    }
                    $data[$key]['percent1'] = '<span style="min-width:100px;">'.number_format($sum_progress1,2).'%'.'</span>';
                }else{
                    $data[$key]['percent1'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                
                if($active2 > 0){
                    $all2 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all2  = $all2 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all2 = $all2->where('tb_employee.department_code', $value->department_code);
                    }
                    $all2  = $all2 ->count();

                    $progress2 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '2');
                    if($search_department != '0'){
                        $progress2 = $progress2->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress2 = $progress2->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress2 = $progress2->count();
                    $sum_progress2 = 0;
                    if($progress2 > 0){
                        $sum_progress2 = ($progress2/$all2)*100;
                    }
                    $data[$key]['percent2'] = '<span style="min-width:100px;">'.number_format($sum_progress2,2).'%'.'</span>';
                }else{
                    $data[$key]['percent2'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
    
                if($active3 > 0){
                    $all3 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all3  = $all3 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all3 = $all3->where('tb_employee.department_code', $value->department_code);
                    }
                    $all3  = $all3 ->count();

                    $progress3 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '3');
                    if($search_department != '0'){
                        $progress3 = $progress3->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress3 = $progress3->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress3 = $progress3->count();
                    $sum_progress3 = 0;
                    if($progress3 > 0){
                        $sum_progress3 = ($progress3/$all3)*100;
                    }
                    $data[$key]['percent3'] = '<span style="min-width:100px;">'.number_format($sum_progress3,2).'%'.'</span>';
                }else{
                    $data[$key]['percent3'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active4 > 0){
                    $all4 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all4  = $all4 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all4 = $all4->where('tb_employee.department_code', $value->department_code);
                    }
                    $all4  = $all4 ->count();

                    $progress4 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '4');
                    if($search_department != '0'){
                        $progress4 = $progress4->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress4 = $progress4->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress4 = $progress4->count();
                    $sum_progress4 = 0;
                    if($progress4 > 0){
                        $sum_progress4 = ($progress4/$all4)*100;
                    }
                    $data[$key]['percent4'] = '<span style="min-width:100px;">'.number_format($sum_progress4,2).'%'.'</span>';
                }else{
                    $data[$key]['percent4'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active5 > 0){
                    $all5 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all5  = $all5 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all5 = $all5->where('tb_employee.department_code', $value->department_code);
                    }
                    $all5  = $all5 ->count();

                    $progress5 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '5');
                    if($search_department != '0'){
                        $progress5 = $progress5->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress5 = $progress5->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress5 = $progress5->count();
                    $sum_progress5 = 0;
                    if($progress5 > 0){
                        $sum_progress5 = ($progress5/$all5)*100;
                    }
                    $data[$key]['percent5'] = '<span style="min-width:100px;">'.number_format($sum_progress5,2).'%'.'</span>';
                }else{
                    $data[$key]['percent5'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active6 > 0){
                    $all6 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all6  = $all6 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all6 = $all6->where('tb_employee.department_code', $value->department_code);
                    }
                    $all6  = $all6 ->count();

                    $progress6 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '6');
                    if($search_department != '0'){
                        $progress6 = $progress6->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress6 = $progress6->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress6 = $progress6->count();
                    $sum_progress6 = 0;
                    if($progress6 > 0){
                        $sum_progress6 = ($progress6/$all6)*100;
                    }
                    $data[$key]['percent6'] = '<span style="min-width:100px;">'.number_format($sum_progress6,2).'%'.'</span>';
                }else{
                    $data[$key]['percent6'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active7 > 0){
                    $all7 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all7  = $all7 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all7 = $all7->where('tb_employee.department_code', $value->department_code);
                    }
                    $all7  = $all7 ->count();

                    $progress7 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '7');
                    if($search_department != '0'){
                        $progress7 = $progress7->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress7 = $progress7->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress7 = $progress7->count();
                    $sum_progress7 = 0;
                    if($progress7 > 0){
                        $sum_progress7 = ($progress7/$all7)*100;
                    }
                    $data[$key]['percent7'] = '<span style="min-width:100px;">'.number_format($sum_progress7,2).'%'.'</span>';
                }else{
                    $data[$key]['percent7'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active8 > 0){
                    $all8 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all8  = $all8 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all8 = $all8->where('tb_employee.department_code', $value->department_code);
                    }
                    $all8  = $all8 ->count();

                    $progress8 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '8');
                    if($search_department != '0'){
                        $progress8 = $progress8->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress8 = $progress8->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress8 = $progress8->count();
                    $sum_progress8 = 0;
                    if($progress8 > 0){
                        $sum_progress8 = ($progress8/$all8)*100;
                    }
                    $data[$key]['percent8'] = '<span style="min-width:100px;">'.number_format($sum_progress8,2).'%'.'</span>';
                }else{
                    $data[$key]['percent8'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active9 > 0){
                    $all9 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all9  = $all9 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all9 = $all9->where('tb_employee.department_code', $value->department_code);
                    }
                    $all9  = $all9 ->count();

                    $progress9 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '9');
                    if($search_department != '0'){
                        $progress9 = $progress9->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress9 = $progress9->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress9 = $progress9->count();
                    $sum_progress9 = 0;
                    if($progress9 > 0){
                        $sum_progress9 = ($progress9/$all9)*100;
                    }
                    $data[$key]['percent9'] = '<span style="min-width:100px;">'.number_format($sum_progress9,2).'%'.'</span>';
                }else{
                    $data[$key]['percent9'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active10 > 0){
                    $all10 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all10  = $all10 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all10 = $all10->where('tb_employee.department_code', $value->department_code);
                    }
                    $all10  = $all10 ->count();

                    $progress10 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '10');
                    if($search_department != '0'){
                        $progress10 = $progress10->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress10 = $progress10->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress10 = $progress10->count();
                    $sum_progress10 = 0;
                    if($progress10 > 0){
                        $sum_progress10 = ($progress10/$all10)*100;
                    }
                    $data[$key]['percent10'] = '<span style="min-width:100px;">'.number_format($sum_progress10,2).'%'.'</span>';
                }else{
                    $data[$key]['percent10'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active11 > 0){
                    $all11 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all11  = $all11 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all11 = $all11->where('tb_employee.department_code', $value->department_code);
                    }
                    $all11  = $all11 ->count();

                    $progress11 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '11');
                    if($search_department != '0'){
                        $progress11 = $progress11->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress11 = $progress11->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress11 = $progress11->count();
                    $sum_progress11 = 0;
                    if($progress11 > 0){
                        $sum_progress11 = ($progress11/$all11)*100;
                    }
                    $data[$key]['percent11'] = '<span style="min-width:100px;">'.number_format($sum_progress11,2).'%'.'</span>';
                }else{
                    $data[$key]['percent11'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active12 > 0){
                    $all12 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all12  = $all12 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all12 = $all12->where('tb_employee.department_code', $value->department_code);
                    }
                    $all12  = $all12 ->count();

                    $progress12 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '12');
                    if($search_department != '0'){
                        $progress12 = $progress12->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress12 = $progress12->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress12 = $progress12->count();
                    $sum_progress12 = 0;
                    if($progress12 > 0){
                        $sum_progress12 = ($progress12/$all12)*100;
                    }
                    $data[$key]['percent12'] = '<span style="min-width:100px;">'.number_format($sum_progress12,2).'%'.'</span>';
                }else{
                    $data[$key]['percent12'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active13 > 0){
                    $all13 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all13  = $all13 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all13 = $all13->where('tb_employee.department_code', $value->department_code);
                    }
                    $all13  = $all13 ->count();

                    $progress13 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '13');
                    if($search_department != '0'){
                        $progress13 = $progress13->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress13 = $progress13->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress13 = $progress13->count();
                    $sum_progress13 = 0;
                    if($progress13 > 0){
                        $sum_progress13 = ($progress13/$all13)*100;
                    }
                    $data[$key]['percent13'] = '<span style="min-width:100px;">'.number_format($sum_progress13,2).'%'.'</span>';
                }else{
                    $data[$key]['percent13'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                if($active14 > 0){
                    $all14 = EmployeeFinalScore::
                    select('tb_employee_final_score.*',
                    'tb_employee.department_description AS department_description',
                    'tb_employee.employee_local_name_th AS employee_local_name_th')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%');
                    if($search_department != '0'){
                        $all14  = $all14 ->where('tb_employee.department_code', $search_department);
                    }else{
                        $all14 = $all14->where('tb_employee.department_code', $value->department_code);
                    }
                    $all14  = $all14 ->count();

                    $progress14 = DB::table('tb_employee_final_score')->select('tb_employee_final_score.status_pa')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
                    ->where('tb_employee_final_score.status_pa','!=', '0')
                    ->where('tb_employee_final_score.status_pa','>=', '14');
                    if($search_department != '0'){
                        $progress14 = $progress14->where('tb_employee.department_code', $search_department);
                    }else{
                        $progress14 = $progress14->where('tb_employee.department_code', $value->department_code);
                    }
                    $progress14 = $progress14->count();
                    $sum_progress14 = 0;
                    if($progress14 > 0){
                        $sum_progress14 = ($progress14/$all14)*100;
                    }
                    $data[$key]['percent14'] = '<span style="min-width:100px;">'.number_format($sum_progress14,2).'%'.'</span>';
                }else{
                    $data[$key]['percent14'] = '<span style="min-width:100px;"><div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;background-color: #FFF5F8;"><span style="color: #F1416C;">InActive</span></div></span>';
                }
                // $data[] = array(
                    // "no" =>  $key + 1,
                    // "department_name" =>  $value->department_description,
                    // "percent1" =>  number_format($sum_progress1,2).'%',
                    // "percent2" =>  number_format($sum_progress2,2).'%',
                    // "percent3" =>  number_format($sum_progress3,2).'%',
                    // "percent4" =>  number_format($sum_progress4,2).'%',
                    // "percent5" =>  number_format($sum_progress5,2).'%',
                    // "percent6" =>  number_format($sum_progress6,2).'%',
                    // "percent7" =>  number_format($sum_progress7,2).'%',
                    // "percent8" =>  number_format($sum_progress8,2).'%',
                    // "percent9" =>  number_format($sum_progress9,2).'%',
                    // "percent10" =>  number_format($sum_progress10,2).'%',
                    // "percent11" =>  number_format($sum_progress11,2).'%',
                    // "percent12" =>  number_format($sum_progress12,2).'%',
                    // "percent13" =>  number_format($sum_progress13,2).'%',
                    // "percent14" =>  number_format($sum_progress14,2).'%'
                // );
            }

            
            
            $result = [
                'recordsTotal'    => count($data),
                'recordsFiltered' => count($data),
                'data'            => $data,
            ];
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

    public function table_hr_getdata(Request $request)
    {
        $search_task      = $request->input('search_task');
        $search_department      = $request->input('search_department');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $department = EmployeeFinalScore::
        select('tb_employee_final_score.*',
        'tb_employee.department_description AS department_description',
        'tb_employee.employee_local_name_en AS employee_local_name_en')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.department_code', $search_department);

        if($search_task != '0'){
            $department->where(function ($query) use($search_task) {
                $query->orWhere('tb_employee_final_score.status_pa','!=', '0');
                $query->orWhere('tb_employee_final_score.status_pa','>=', $search_task);
            });
            // $department = $department->where('tb_employee_final_score.status_pa','!=', '0');
            // $department = $department->where('tb_employee_final_score.status_pa','>=', $search_task);
        }
        $department = $department->get();

        if (count($department) > 0) {
            foreach ($department as $key => $value) {
                $evaluator = DB::table('tb_employee')
                ->select('employee_local_name_en')
                ->where('orisoft_no', $value->evaluator_no )
                ->first();
                if($evaluator){
                    $evaluator_name = $evaluator->employee_local_name_en;
                }else{
                    $evaluator_name = "";
                }
                $checkbox = '<input type="checkbox">';
                $status_evaluation = '<span class="set_status'.$value->id.' badge"></span>';
                if($value->status_evaluation == '1'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light">In progress</span>';
                }else if($value->status_evaluation == '2'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-danger">Reject</span>';
                }else if($value->status_evaluation == '3'){
                    $status_evaluation = '<span class="set_status'.$value->id.' badge badge-light-success">Approved</span>';
                }
                $data[] = array(
                    "no" =>  $key + 1,
                    "employee_code" => $value->employee_no,
                    "name" =>  $value->employee_local_name_en,
                    "factory" =>  'MIL',
                    "department" => $value->department_description,
                    "form" =>  $value->form_import,
                    "evaluator" =>  $evaluator_name,
                    "status" =>  $status_evaluation,
                );
            }
            $result = [
                'recordsTotal'    => count($data),
                'recordsFiltered' => count($data),
                'data'            => $data,
            ];
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

    public function count_progress(Request $request)
    {
        $search_task      = $request->input('search_task');
        $search_department      = $request->input('search_department');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $approve = EmployeeFinalScore::
        select('tb_employee_final_score.*',
        'tb_employee.department_description AS department_description',
        'tb_employee.employee_local_name_th AS employee_local_name_th')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.department_code', $search_department)
        ->where('tb_employee_final_score.status_evaluation', '3')
        ->count();

        $all = EmployeeFinalScore::
        select('tb_employee_final_score.*',
        'tb_employee.department_description AS department_description',
        'tb_employee.employee_local_name_th AS employee_local_name_th')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee.department_code', $search_department)
        ->count();
        
        
        $progress = DB::table('tb_employee_final_score')
        ->select('tb_employee_final_score.status_pa')
        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        ->where('tb_employee_final_score.rec_year','like','%'.$previousYear.'%')
        ->where('tb_employee_final_score.status_evaluation', '<','3');
        if($search_task != '0'){
            $progress = $progress->where('tb_employee_final_score.status_pa','!=', '0');
            $progress = $progress->where('tb_employee_final_score.status_pa','>=', $search_task);
        }
        if($search_department != '0'){
            $progress = $progress->where('tb_employee.department_code', $search_department);
        }
        $progress = $progress->count();

        $sum_progress = 0;
        if($approve > 0){
            $sum_progress = ($approve/$all)*100;
        }
        
        $result = [
            'approve'        => $approve,
            'all'            => $all,
            'progress'       => $progress,
            'sum_progress'       => $sum_progress,
        ];
        echo json_encode($result);
    }

    public function get_column(Request $request)
    {
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
        // }
        $datarow = DB::table('tb_pa_timeline_action')
        ->select('tb_pa_timeline_action.start_date_real','tb_pa_timeline_action.end_date_real','tb_pa_timeline_action.action_name','tb_pa_timeline_action.status')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year','like','%'.$previousYear.'%')
        // ->where('tb_pa_timeline_action.status','1')
        ->get();
        echo json_encode($datarow);
    }
}
