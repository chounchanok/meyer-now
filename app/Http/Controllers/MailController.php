<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use Illuminate\Http\Request;
use App\Models\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function alert_send_mail()
    {
        // dd('2');
        // $return_data = [
        //     'data'          => [],
        //     'status'        => '500',
        // ];
        // return response()->json($return_data);
        // exit();

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
        //     $checkYear = date('Y');
        // }
        $checkYear = date('Y');

        $pa_timeline_action = DB::table('tb_pa_timeline_action')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$checkYear)->get();
        
        $count = 0;
        if(count($pa_timeline_action)>0){
            foreach ($pa_timeline_action as $key => $value) {
                if($value->start_date_real){
                    $day1 = date ("Y-m-d", strtotime("-3 day", strtotime($value->start_date_real)));
                    if(date ("Y-m-d") == $day1){
                        $view_mail = '';
                        $arr = [];
                        $Person = '';
                        if($value->hr == 'active'){
                            if($value->hr_select){
                                $a1 = explode(',',$value->hr_select);
                                foreach ($a1 as $key2 => $val2) {
                                    $users1 = Users::where('orisoft_code', $val2)->first();
                                    $Person .= $users1->name.',';
                                    array_push($arr,$users1->email);
                                }
                            }
                            // $users1 = DB::table('users')->where('users.orisoft_code',$value->hr_select)->first();
                            // $Person .= $users1->name.',';
                            // array_push($arr,$users1->email);
                            // array_push($arr,'koranatsoi17@gmail.com');
                        }
                        if($value->manager == 'active'){
                            if($value->manager_select){
                                $a2 = explode(',',$value->manager_select);
                                foreach ($a2 as $key2 => $val2) {
                                    $users2 = Users::where('orisoft_code', $val2)->first();
                                    $Person .= $users2->name.',';
                                    array_push($arr,$users2->email);
                                }
                            }
                            // $users1 = DB::table('users')->where('users.orisoft_code',$value->manager_select)->first();
                            // $Person .= $users1->name.',';
                            // array_push($arr,$users1->email);
                            // array_push($arr,'koranatsoi35@gmail.com');
                        }
                        if($value->dm == 'active'){
                            $Person .= 'KOMKRIT VONGKAVIVATHANAKUL,';
                            array_push($arr,'komkrit@meyer-mil.com');
                        }
                        if($value->gm == 'active'){
                            $Person .= 'Joseph Lo,';
                            array_push($arr,'joe@meyer-mil.com');
                        }
                        if($Person != ""){
                            $Person = substr($Person,0,-1);
                        }
                        $view_mail = '<html>
                                    <body>
                                        <p>Task : '.$value->action_name.'</p>
                                        <p>Timeline Plan : '.$value->start_date.' - '.$value->end_date.'</p>
                                        <p>Timeline Actual : '.$value->start_date_real.' - '.$value->end_date_real.'</p>
                                        <p>Person in charge: : '.$Person.'</p>
                                    </body>
                                </html>
                        ';
                        $arr = array_unique( $arr );
                        // $arr = ['koranatsoi17@gmail.com'];
                        $save = Mail::send([], [$value->action_name], function ($message) use ($view_mail,$arr) {
                            $message
                            // ->from($address = 'koranatsoi17@gmail.com', $name = 'koranatsoi17')
                            ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                            ->to($arr) 
                            ->subject('Notification: 1 day left until the scheduled task day.');
                            $message->html($view_mail);
                        });
                        if($save){
                            $count++;
                        }
                        else{
                            $count = 0;
                        }
                    }
                }
            }
        }

        
        
        
        

        if($count > 0){
            $return_data = [
                'data'          => [],
                'status'        => '200',
                'message'       => 'insert success'
            ];
        }
        else{
            $return_data = [
                'data'          => [],
                'status'        => '500',
                'message'       => 'insert failed'
            ];
        }
        return response()->json($return_data);
    }

    public function alert_send_mail_test()
    {
        // dd('2');
        // $return_data = [
        //     'data'          => [],
        //     'status'        => '500',
        // ];
        // return response()->json($return_data);
        // exit();

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
        //     $checkYear = date('Y');
        // }
        $checkYear = date('Y');

        $pa_timeline_action = DB::table('tb_pa_timeline_action')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$checkYear)->get();
        
        $count = 0;
        if(count($pa_timeline_action)>0){
            foreach ($pa_timeline_action as $key => $value) {
                if($value->start_date_real){
                    // $day1 = date ("Y-m-d", strtotime("-1 day", strtotime($value->start_date_real)));
                    // if(date ("Y-m-d") == $day1){
                        $view_mail = '<html>
                                        <body>
                                            <p>Task : Test</p>
                                            <p>Timeline Plan : Test</p>
                                            <p>Timeline Actual : Test</p>
                                            <p>Person in charge: : Test</p>
                                        </body>
                                    </html>';
                        $arr = ['koranatsoi17@gmail.com'];
                        $Person = 'Test';
                        if($value->hr == 'active'){
                            // if($value->hr_select){
                            //     $a1 = explode(',',$value->hr_select);
                            //     foreach ($a1 as $key2 => $val2) {
                            //         $users1 = Users::where('orisoft_code', $val2)->first();
                            //         $Person .= $users1->name.',';
                            //         array_push($arr,$users1->email);
                            //     }
                            // }
                            // $users1 = DB::table('users')->where('users.orisoft_code',$value->hr_select)->first();
                            // $Person .= $users1->name.',';
                            // array_push($arr,$users1->email);
                            // array_push($arr,'koranatsoi17@gmail.com');
                        }
                        if($value->manager == 'active'){
                            // if($value->manager_select){
                            //     $a2 = explode(',',$value->manager_select);
                            //     foreach ($a2 as $key2 => $val2) {
                            //         $users2 = Users::where('orisoft_code', $val2)->first();
                            //         $Person .= $users2->name.',';
                            //         array_push($arr,$users2->email);
                            //     }
                            // }
                            // $users1 = DB::table('users')->where('users.orisoft_code',$value->manager_select)->first();
                            // $Person .= $users1->name.',';
                            // array_push($arr,$users1->email);
                            // array_push($arr,'koranatsoi35@gmail.com');
                        }
                        if($value->dm == 'active'){
                            // $Person .= 'KOMKRIT VONGKAVIVATHANAKUL,';
                            // array_push($arr,'komkrit@meyer-mil.com');
                        }
                        if($value->gm == 'active'){
                            // $Person .= 'Joseph Lo,';
                            // array_push($arr,'joe@meyer-mil.com');
                        }
                        if($Person != ""){
                            // $Person = substr($Person,0,-1);
                        }
                        // $view_mail = '<html>
                        //             <body>
                        //                 <p>Task : '.$value->action_name.'</p>
                        //                 <p>Timeline Plan : '.$value->start_date.' - '.$value->end_date.'</p>
                        //                 <p>Timeline Actual : '.$value->start_date_real.' - '.$value->end_date_real.'</p>
                        //                 <p>Person in charge: : '.$Person.'</p>
                        //             </body>
                        //         </html>
                        // ';
                        $arr = array_unique( $arr );
                        $save = Mail::send([], [$value->action_name], function ($message) use ($view_mail,$arr) {
                            $message
                            ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                            ->to($arr) 
                            ->subject('Notification: 1 day left until the scheduled task day.');
                            $message->html($view_mail);
                        });
                        if($save){
                            $count++;
                        }
                        else{
                            $count = 0;
                        }
                    // }
                }
            }
        }

        
        
        
        

        if($count > 0){
            $return_data = [
                'data'          => [],
                'status'        => '200',
                'message'       => 'insert success'
            ];
        }
        else{
            $return_data = [
                'data'          => [],
                'status'        => '500',
                'message'       => 'insert failed'
            ];
        }
        return response()->json($return_data);
    }

    public function new_send_mail_mil()
    {
        $checkYear = date('Y');

        $pa_timeline_action = DB::connection('mil')->table('tb_pa_timeline_action')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$checkYear)->get();
        $data = [];
        $datahtml = [];
        $dataall = [];
        $count = 0;
        if(count($pa_timeline_action)>0){
            foreach ($pa_timeline_action as $key => $value) {
                if($value->end_date){
                    $day1 = date ("Y-m-d", strtotime("-3 day", strtotime($value->end_date)));
                    
                    if(date ("Y-m-d") == $day1){
                        // echo $day1.'<br>';
                        $view_mail = '';
                        $arr = [];
                        $Person = '';
                        if($value->hr == 'active'){
                            if($value->hr_select){
                                $a1 = explode(',',$value->hr_select);
                                foreach ($a1 as $key2 => $val2) {
                                    $users1 = DB::connection('mil')->table('users')->where('orisoft_code', $val2)->first();
                                    $Person .= $users1->name.',';
                                    array_push($arr,$users1->email);
                                }
                            }
                            // $users1 = DB::table('users')->where('users.orisoft_code',$value->hr_select)->first();
                            // $Person .= $users1->name.',';
                            // array_push($arr,$users1->email);
                            // array_push($arr,'koranatsoi17@gmail.com');
                        }
                        if($value->manager == 'active'){
                            if($value->manager_select){
                                $a2 = explode(',',$value->manager_select);
                                foreach ($a2 as $key2 => $val2) {
                                    $users2 = DB::connection('mil')->table('users')->where('orisoft_code', $val2)->first();
                                    $Person .= $users2->name.',';
                                    array_push($arr,$users2->email);
                                }
                            }else{
                                $users_manager_select = DB::connection('mil')->table('users')
                                ->select('users.name','users.email','users.orisoft_code')
                                ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                ->where('tb_employee_final_score.freeze','0')
                                ->where('tb_employee_final_score.freeze_to_pagrade','0')
                                ->where('tb_employee_final_score.rec_year',date('Y'))
                                ->groupBy('tb_employee_final_score.evaluator_no')
                                ->get();
                                if(count($users_manager_select) > 0){
                                    foreach ($users_manager_select as $key => $val) {
                                        if($val->email){
                                            $Person .= $val->name.' (Evaluators evaluate the PA score in the E-PA Program)<br>';
                                            array_push($arr,$val->email);
                                        }else{
                                            $users_first = DB::connection('mil')->table('users')
                                            ->select('tb_employee_final_score.evaluator_no','users.name','users.email')
                                            ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                            ->where('tb_employee_final_score.employee_no',$val->orisoft_code)
                                            ->first();
                                            if($users_first){
                                                $Person .= $val->name.' (Evaluators evaluate the PA score in the E-PA Program)<br>';
                                                array_push($arr,$users_first->email);
                                            }
                                        }
                                        
                                    }
                                }
                                $users_manager_select2 = DB::connection('mil')->table('users')
                                ->select('users.name','users.email','users.orisoft_code')
                                ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                ->where('tb_employee_final_score.freeze','1')
                                ->where('tb_employee_final_score.freeze_to_pagrade','0')
                                ->where('tb_employee_final_score.rec_year',date('Y'))
                                ->groupBy('tb_employee_final_score.evaluator_no')
                                ->get();
                                if(count($users_manager_select2) > 0){
                                    foreach ($users_manager_select2 as $key => $val) {
                                        if($val->email){
                                            $Person .= $val->name.' (Managers "Review and Approve PA Scores" in the E-PA Program)<br>';
                                            array_push($arr,$val->email);
                                        }else{
                                            $users_first = DB::connection('mil')->table('users')
                                            ->select('tb_employee_final_score.evaluator_no','users.name','users.email')
                                            ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                            ->where('tb_employee_final_score.employee_no',$val->orisoft_code)
                                            ->first();
                                            if($users_first){
                                                $Person .= $val->name.' (Managers "Review and Approve PA Scores" in the E-PA Program)<br>';
                                                array_push($arr,$users_first->email);
                                            }
                                        }
                                        
                                    }
                                }
                            }
                            // $users1 = DB::table('users')->where('users.orisoft_code',$value->manager_select)->first();
                            // $Person .= $users1->name.',';
                            // array_push($arr,$users1->email);
                            // array_push($arr,'koranatsoi35@gmail.com');
                        }
                        if($value->dm == 'active'){
                            $Person .= 'KOMKRIT VONGKAVIVATHANAKUL,';
                            array_push($arr,'komkrit@meyer-mil.com');
                        }
                        if($value->gm == 'active'){
                            $Person .= 'Joseph Lo,';
                            array_push($arr,'joe@meyer-mil.com');
                        }
                        if($Person != ""){
                            $Person = substr($Person,0,-1);
                        }
                        $view_mail = '<html>
                                    <body>
                                        <p>Task : '.$value->action_name.'</p>
                                        <p>Timeline Plan : '.$value->start_date.' - '.$value->end_date.'</p>
                                        <p>Timeline Actual : '.$value->start_date_real.' - '.$value->end_date_real.'</p>
                                        <p>Person in charge: : '.$Person.'</p>
                                    </body>
                                </html>
                        ';
                        $arr = array_unique( $arr );
                        // echo "<pre>";
                        // print_r($arr);
                        array_push($data,$arr);
                        array_push($datahtml,$Person);
                        array_push($dataall,$view_mail);
                        // $save = Mail::send([], [$value->action_name], function ($message) use ($view_mail,$arr) {
                        //     $message
                        //     // ->from($address = 'koranatsoi17@gmail.com', $name = 'koranatsoi17')
                        //     // ->to('koranatsoi17@gmail.com') 
                        //     ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                        //     ->to($arr) 
                        //     ->subject('Notification: 3 day left until the scheduled task day.');
                        //     $message->html($view_mail);
                        // });
                        try {
                            // พยายามส่งเมล
                            Mail::send([], [$value->action_name], function ($message) use ($view_mail, $arr) {
                                $message
                                ->from('swadmin@meyer-mil.com', 'swadmin')
                                // ->from($address = 'koranatsoi17@gmail.com', $name = 'koranatsoi17')
                                // ->to('koranatsoi17@gmail.com') 
                                ->to($arr)
                                ->subject('Notification: 3 day left until the scheduled task day.');
                                $message->html($view_mail);
                            });
                            
                            // ถ้าส่งเมลสำเร็จ
                            $mailStatus   = 'success';
                            $save         = true;
                            $errorMessage = null;
                            $count++;  // เพิ่ม count เมื่อส่งสำเร็จ
                        } catch (\Exception $e) {
                            // ถ้าส่งเมลเกิดข้อผิดพลาด
                            $mailStatus   = 'error';
                            $save         = false;
                            $errorMessage = $e->getMessage();
                            $count = 0;
                        }
                        DB::connection('mil')->table('logmail')->insert([
                            'status'  => $mailStatus,
                            'html'    => $view_mail,
                            'email'   => json_encode($arr), // แปลง array เป็น JSON เพื่อบันทึก
                            'save'    => $save,             // เก็บสถานะส่งเมล
                            'error'   => $errorMessage,     // เก็บข้อความ error ถ้ามี
                            'created' => date('Y-m-d H:i:s')
                        ]);
                        
                    }
                }
            }
        }
        
        
        if($count == 0){
            DB::connection('mil')->table('logmail')->insert([
                'status'  => 'No data',
                'html'    => null,
                'email'   => null, // แปลง array เป็น JSON เพื่อบันทึก
                'save'    => null,             // เก็บสถานะส่งเมล
                'error'   => null,     // เก็บข้อความ error ถ้ามี
                'created' => date('Y-m-d H:i:s')
            ]);
        }
        // if($count > 0){
            $return_data = [
                'count'          => $count,
                'data'          => $data,
                'datahtml'          => $datahtml,
                'dataall'          => $dataall,
                'status'        => '200',
                'message'       => 'send success',
            ];
        // }
        // else{
        //     $return_data = [
        //         'data'          => [],
        //         'status'        => '500',
        //         'message'       => 'insert failed'
        //     ];
        // }
        return response()->json($return_data);
    }

    public function new_send_mail_mtl()
    {
        $checkYear = date('Y');

        $pa_timeline_action = DB::connection('mtl')->table('tb_pa_timeline_action')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$checkYear)->get();
        $data = [];
        $datahtml = [];
        $dataall = [];
        $count = 0;
        if(count($pa_timeline_action)>0){
            foreach ($pa_timeline_action as $key => $value) {
                if($value->end_date){
                    $day1 = date ("Y-m-d", strtotime("-3 day", strtotime($value->end_date)));
                    
                    if(date ("Y-m-d") == $day1){
                        // echo $day1.'<br>';
                        $view_mail = '';
                        $arr = [];
                        $Person = '';
                        if($value->hr == 'active'){
                            if($value->hr_select){
                                $a1 = explode(',',$value->hr_select);
                                foreach ($a1 as $key2 => $val2) {
                                    $users1 = DB::connection('mtl')->table('users')->where('orisoft_code', $val2)->first();
                                    $Person .= $users1->name.',';
                                    array_push($arr,$users1->email);
                                }
                            }
                        }
                        if($value->manager == 'active'){
                            if($value->manager_select){
                                $a2 = explode(',',$value->manager_select);
                                foreach ($a2 as $key2 => $val2) {
                                    $users2 = DB::connection('mtl')->table('users')->where('orisoft_code', $val2)->first();
                                    $Person .= $users2->name.',';
                                    array_push($arr,$users2->email);
                                }
                            }else{
                                $users_manager_select = DB::connection('mtl')->table('users')
                                ->select('users.name','users.email','users.orisoft_code')
                                ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                ->where('tb_employee_final_score.freeze','0')
                                ->where('tb_employee_final_score.freeze_to_pagrade','0')
                                ->where('tb_employee_final_score.rec_year',date('Y'))
                                ->groupBy('tb_employee_final_score.evaluator_no')
                                ->get();
                                if(count($users_manager_select) > 0){
                                    foreach ($users_manager_select as $key => $val) {
                                        if($val->email){
                                            $Person .= $val->name.' (Evaluators evaluate the PA score in the E-PA Program)<br>';
                                            array_push($arr,$val->email);
                                        }else{
                                            $users_first = DB::connection('mtl')->table('users')
                                            ->select('tb_employee_final_score.evaluator_no','users.name','users.email')
                                            ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                            ->where('tb_employee_final_score.employee_no',$val->orisoft_code)
                                            ->first();
                                            if($users_first){
                                                $Person .= $val->name.' (Evaluators evaluate the PA score in the E-PA Program)<br>';
                                                array_push($arr,$users_first->email);
                                            }
                                        }
                                        
                                    }
                                }
                                $users_manager_select2 = DB::connection('mtl')->table('users')
                                ->select('users.name','users.email','users.orisoft_code')
                                ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                ->where('tb_employee_final_score.freeze','1')
                                ->where('tb_employee_final_score.freeze_to_pagrade','0')
                                ->where('tb_employee_final_score.rec_year',date('Y'))
                                ->groupBy('tb_employee_final_score.evaluator_no')
                                ->get();
                                if(count($users_manager_select2) > 0){
                                    foreach ($users_manager_select2 as $key => $val) {
                                        if($val->email){
                                            $Person .= $val->name.' (Managers "Review and Approve PA Scores" in the E-PA Program)<br>';
                                            array_push($arr,$val->email);
                                        }else{
                                            $users_first = DB::connection('mtl')->table('users')
                                            ->select('tb_employee_final_score.evaluator_no','users.name','users.email')
                                            ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                            ->where('tb_employee_final_score.employee_no',$val->orisoft_code)
                                            ->first();
                                            if($users_first){
                                                $Person .= $val->name.' (Managers "Review and Approve PA Scores" in the E-PA Program)<br>';
                                                array_push($arr,$users_first->email);
                                            }
                                        }
                                        
                                    }
                                }
                            }
                        }
                        if($value->dm == 'active'){
                            $Person .= 'KOMKRIT VONGKAVIVATHANAKUL,';
                            array_push($arr,'komkrit@meyer-mil.com');
                        }
                        if($value->gm == 'active'){
                            $Person .= 'Joseph Lo,';
                            array_push($arr,'joe@meyer-mil.com');
                        }
                        if($Person != ""){
                            $Person = substr($Person,0,-1);
                        }
                        $view_mail = '<html>
                                    <body>
                                        <p>Task : '.$value->action_name.'</p>
                                        <p>Timeline Plan : '.$value->start_date.' - '.$value->end_date.'</p>
                                        <p>Timeline Actual : '.$value->start_date_real.' - '.$value->end_date_real.'</p>
                                        <p>Person in charge: : '.$Person.'</p>
                                    </body>
                                </html>
                        ';
                        $arr = array_unique( $arr );
                        // echo "<pre>";
                        // print_r($arr);
                        array_push($data,$arr);
                        array_push($datahtml,$Person);
                        array_push($dataall,$view_mail);
                        try {
                            // พยายามส่งเมล
                            Mail::send([], [$value->action_name], function ($message) use ($view_mail, $arr) {
                                $message
                                ->from('swadmin@meyer-mil.com', 'swadmin')
                                // ->from($address = 'koranatsoi17@gmail.com', $name = 'koranatsoi17')
                                // ->to('koranatsoi17@gmail.com') 
                                ->to($arr)
                                ->subject('Notification: 3 day left until the scheduled task day.');
                                $message->html($view_mail);
                            });
                            
                            // ถ้าส่งเมลสำเร็จ
                            $mailStatus   = 'success';
                            $save         = true;
                            $errorMessage = null;
                            $count++;  // เพิ่ม count เมื่อส่งสำเร็จ
                        } catch (\Exception $e) {
                            // ถ้าส่งเมลเกิดข้อผิดพลาด
                            $mailStatus   = 'error';
                            $save         = false;
                            $errorMessage = $e->getMessage();
                            $count = 0;
                        }
                        DB::connection('mtl')->table('logmail')->insert([
                            'status'  => $mailStatus,
                            'html'    => $view_mail,
                            'email'   => json_encode($arr), // แปลง array เป็น JSON เพื่อบันทึก
                            'save'    => $save,             // เก็บสถานะส่งเมล
                            'error'   => $errorMessage,     // เก็บข้อความ error ถ้ามี
                            'created' => date('Y-m-d H:i:s')
                        ]);
                        
                    }
                }
            }
        }
        
        
        if($count == 0){
            DB::connection('mtl')->table('logmail')->insert([
                'status'  => 'No data',
                'html'    => null,
                'email'   => null, // แปลง array เป็น JSON เพื่อบันทึก
                'save'    => null,             // เก็บสถานะส่งเมล
                'error'   => null,     // เก็บข้อความ error ถ้ามี
                'created' => date('Y-m-d H:i:s')
            ]);
        }
            $return_data = [
                'count'          => $count,
                'data'          => $data,
                'datahtml'          => $datahtml,
                'dataall'          => $dataall,
                'status'        => '200',
                'message'       => 'send success',
            ];
        return response()->json($return_data);
    }

    public function new_send_mail_manager()
    {
        $checkYear = date('Y');

        $pa_timeline_action = DB::connection('manager')->table('tb_pa_timeline_action')
        ->leftJoin('tb_pa_timeline','tb_pa_timeline.id','=','tb_pa_timeline_action.pa_timeline_id')
        ->where('tb_pa_timeline.year',$checkYear)->get();
        $data = [];
        $datahtml = [];
        $dataall = [];
        $count = 0;
        if(count($pa_timeline_action)>0){
            foreach ($pa_timeline_action as $key => $value) {
                if($value->end_date){
                    $day1 = date ("Y-m-d", strtotime("-3 day", strtotime($value->end_date)));
                    
                    if(date ("Y-m-d") == $day1){
                        // echo $day1.'<br>';
                        $view_mail = '';
                        $arr = [];
                        $Person = '';
                        if($value->hr == 'active'){
                            if($value->hr_select){
                                $a1 = explode(',',$value->hr_select);
                                foreach ($a1 as $key2 => $val2) {
                                    $users1 = DB::connection('manager')->table('users')->where('orisoft_code', $val2)->first();
                                    $Person .= $users1->name.',';
                                    array_push($arr,$users1->email);
                                }
                            }
                        }
                        if($value->manager == 'active'){
                            if($value->manager_select){
                                $a2 = explode(',',$value->manager_select);
                                foreach ($a2 as $key2 => $val2) {
                                    $users2 = DB::connection('manager')->table('users')->where('orisoft_code', $val2)->first();
                                    $Person .= $users2->name.',';
                                    array_push($arr,$users2->email);
                                }
                            }else{
                                $users_manager_select = DB::connection('manager')->table('users')
                                ->select('users.name','users.email','users.orisoft_code')
                                ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                ->where('tb_employee_final_score.freeze','0')
                                ->where('tb_employee_final_score.freeze_to_pagrade','0')
                                ->where('tb_employee_final_score.rec_year',date('Y'))
                                ->groupBy('tb_employee_final_score.evaluator_no')
                                ->get();
                                if(count($users_manager_select) > 0){
                                    foreach ($users_manager_select as $key => $val) {
                                        if($val->email){
                                            $Person .= $val->name.' (Evaluators evaluate the PA score in the E-PA Program)<br>';
                                            array_push($arr,$val->email);
                                        }else{
                                            $users_first = DB::connection('manager')->table('users')
                                            ->select('tb_employee_final_score.evaluator_no','users.name','users.email')
                                            ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                            ->where('tb_employee_final_score.employee_no',$val->orisoft_code)
                                            ->first();
                                            if($users_first){
                                                $Person .= $val->name.' (Evaluators evaluate the PA score in the E-PA Program)<br>';
                                                array_push($arr,$users_first->email);
                                            }
                                        }
                                        
                                    }
                                }
                                $users_manager_select2 = DB::connection('manager')->table('users')
                                ->select('users.name','users.email','users.orisoft_code')
                                ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                ->where('tb_employee_final_score.freeze','1')
                                ->where('tb_employee_final_score.freeze_to_pagrade','0')
                                ->where('tb_employee_final_score.rec_year',date('Y'))
                                ->groupBy('tb_employee_final_score.evaluator_no')
                                ->get();
                                if(count($users_manager_select2) > 0){
                                    foreach ($users_manager_select2 as $key => $val) {
                                        if($val->email){
                                            $Person .= $val->name.' (Managers "Review and Approve PA Scores" in the E-PA Program)<br>';
                                            array_push($arr,$val->email);
                                        }else{
                                            $users_first = DB::connection('manager')->table('users')
                                            ->select('tb_employee_final_score.evaluator_no','users.name','users.email')
                                            ->leftJoin('tb_employee_final_score','tb_employee_final_score.evaluator_no','=','users.orisoft_code')
                                            ->where('tb_employee_final_score.employee_no',$val->orisoft_code)
                                            ->first();
                                            if($users_first){
                                                $Person .= $val->name.' (Managers "Review and Approve PA Scores" in the E-PA Program)<br>';
                                                array_push($arr,$users_first->email);
                                            }
                                        }
                                        
                                    }
                                }
                            }
                        }
                        if($value->dm == 'active'){
                            $Person .= 'KOMKRIT VONGKAVIVATHANAKUL,';
                            array_push($arr,'komkrit@meyer-mil.com');
                        }
                        if($value->gm == 'active'){
                            $Person .= 'Joseph Lo,';
                            array_push($arr,'joe@meyer-mil.com');
                        }
                        if($Person != ""){
                            $Person = substr($Person,0,-1);
                        }
                        $view_mail = '<html>
                                    <body>
                                        <p>Task : '.$value->action_name.'</p>
                                        <p>Timeline Plan : '.$value->start_date.' - '.$value->end_date.'</p>
                                        <p>Timeline Actual : '.$value->start_date_real.' - '.$value->end_date_real.'</p>
                                        <p>Person in charge: : '.$Person.'</p>
                                    </body>
                                </html>
                        ';
                        $arr = array_unique( $arr );
                        // echo "<pre>";
                        // print_r($arr);
                        array_push($data,$arr);
                        array_push($datahtml,$Person);
                        array_push($dataall,$view_mail);
                        try {
                            // พยายามส่งเมล
                            Mail::send([], [$value->action_name], function ($message) use ($view_mail, $arr) {
                                $message
                                ->from('swadmin@meyer-mil.com', 'swadmin')
                                // ->from($address = 'koranatsoi17@gmail.com', $name = 'koranatsoi17')
                                // ->to('koranatsoi17@gmail.com') 
                                ->to($arr)
                                ->subject('Notification: 3 day left until the scheduled task day.');
                                $message->html($view_mail);
                            });
                            
                            // ถ้าส่งเมลสำเร็จ
                            $mailStatus   = 'success';
                            $save         = true;
                            $errorMessage = null;
                            $count++;  // เพิ่ม count เมื่อส่งสำเร็จ
                        } catch (\Exception $e) {
                            // ถ้าส่งเมลเกิดข้อผิดพลาด
                            $mailStatus   = 'error';
                            $save         = false;
                            $errorMessage = $e->getMessage();
                            $count = 0;
                        }
                        DB::connection('manager')->table('logmail')->insert([
                            'status'  => $mailStatus,
                            'html'    => $view_mail,
                            'email'   => json_encode($arr), // แปลง array เป็น JSON เพื่อบันทึก
                            'save'    => $save,             // เก็บสถานะส่งเมล
                            'error'   => $errorMessage,     // เก็บข้อความ error ถ้ามี
                            'created' => date('Y-m-d H:i:s')
                        ]);
                        
                    }
                }
            }
        }
        
        
        if($count == 0){
            DB::connection('manager')->table('logmail')->insert([
                'status'  => 'No data',
                'html'    => null,
                'email'   => null, // แปลง array เป็น JSON เพื่อบันทึก
                'save'    => null,             // เก็บสถานะส่งเมล
                'error'   => null,     // เก็บข้อความ error ถ้ามี
                'created' => date('Y-m-d H:i:s')
            ]);
        }
            $return_data = [
                'count'          => $count,
                'data'          => $data,
                'datahtml'          => $datahtml,
                'dataall'          => $dataall,
                'status'        => '200',
                'message'       => 'send success',
            ];
        return response()->json($return_data);
    }

    public function reset_password_login(Request $request)
    {
        $checkmail = 0;
        $rowusers = DB::connection($request->input('form_action'))->table('users')->where('email', $request->input('email'))->first();
        if($rowusers){
            if($rowusers->email){
                $six_digit_random_number = random_int(100000, 999999);
                DB::connection($request->input('form_action'))->table('users')
                ->where('users.id', $rowusers->id)
                ->update([
                    "password" => Hash::make(sprintf("%06d", $six_digit_random_number)),
                ]);
                $view_mail = '<html>
                                    <body>
                                    <a href="http://milepa" target="_blank"><p>http://milepa</p></a>
                                    <p>Username : '.$rowusers->orisoft_code.'</p>
                                    <p>Password : '.$six_digit_random_number.'</p>
                                    <p>After you login to EPA, please change your password to new password immediately. </p>
                                    </body>
                                </html>';
                $arr = [$rowusers->email];
                // $arr = ['koranatsoi17@gmail.com'];
                $arr = array_unique( $arr );
                $save = Mail::send([], ['Reset Password Complete'], function ($message) use ($view_mail,$arr) {
                    $message
                    ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                    // ->from($address = 'koranatsoi17@gmail.com', $name = 'swadmin')
                    ->to($arr) 
                    ->subject('Reset Password Complete');
                    $message->html($view_mail);
                });
                if($save){
                    $checkmail = $checkmail;
                }
                else{
                    $checkmail++;
                }
                $data = array(
                    "status" =>  200
                );
            }else{
                $data = array(
                    "status" =>  500
                );
            }
        }else{
            $data = array(
                "status" =>  500
            );
        }

        // $Users = DB::connection($request->input('form_action'))->table('users')->where('email', $request->input('email'))->first();
        // if($Users){
        //     $pass = Hash::make($Users->orisoft_code);
        //     $id = DB::connection($request->input('form_action'))->table('users')
        //     ->where('id', $Users->id )
        //     ->update(["password" => $pass]);
        //     $data = array(
        //         "status" =>  200
        //     );
        // }else{
        //     $data = array(
        //         "status" =>  500
        //     );
        // }
        echo json_encode($data); 
    }
}
