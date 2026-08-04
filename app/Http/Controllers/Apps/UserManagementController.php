<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view users|create users|edit users|delete users', ['only' => ['index', 'show']]);
        $this->middleware('permission:create users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        $roles = DB::table('users_roles')->get();
        $division = DB::table('tb_division')->get();
        $position = DB::table('tb_position')->get();
        $grade_code = DB::table('tb_grade_code')->get();

        addJavascriptFile('assets/js/custom/apps/user-management/users/list/add.js');
        return $dataTable->render('pages.apps.user-management.users.list', [
            "roles" => $roles,
            "division" => $division,
            "position" => $position,
            "grade_code" => $grade_code,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($test,User $user)
    {
        $users = DB::table('users');
        $users = $users->where('id', Auth::user()->id)->first();
        return view('pages.apps.user-management.users.show',[
            "users" => $users
        ],compact('user') );
        return view('pages.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function check_current_password_header(Request $request)
    {
        $user_id = Auth::user()->id;
        $current_password      = $request->input('current_password');
        $user = DB::table('users')
        ->where('users.id',$user_id)
        ->first();
        
        $result = [
            'check'=>Hash::check($current_password, $user->password)
        ];
        echo json_encode($result);
    }

    public function check_current_password(Request $request)
    {
        $user_id      = $request->input('user_id');
        $current_password      = $request->input('current_password');
        $user = DB::table('users')
        ->where('users.id',$user_id)
        ->first();
        
        $result = [
            'check'=>Hash::check($current_password, $user->password)
        ];
        echo json_encode($result);
    }

    public function change_password_header(Request $request)
    {
        $user_id = Auth::user()->id;
        $new_password      = $request->input('new_password');
        
        DB::table('users')->where('id', $user_id )->update([
            "password" => Hash::make($new_password)
        ]);

        $result = [
            'status'=>200
        ];
        echo json_encode($result);
    }

    public function change_password(Request $request)
    {
        $user_id      = $request->input('user_id');
        $new_password      = $request->input('new_password');
        
        DB::table('users')->where('id', $user_id )->update([
            "password" => Hash::make($new_password)
        ]);

        $result = [
            'status'=>200
        ];
        echo json_encode($result);
    }

    public function get_user_data(Request $request)
    {
        $id      = $request->input('id');
        $search_year      = $request->input('search_year');

        $user = DB::table('users')->where('id', $id )->first();
        // if(count($user)>0){
        //     foreach ($user as $value) {
                $users_model_has_roles = DB::table('users_model_has_roles')
                ->where('model_id',$user->id)->get();
        //     }
        // }
        $tb_employee_evaluator = DB::table('tb_employee_evaluator')
        ->where('rec_year',$search_year)
        ->where('employee_no',$user->orisoft_code)
        ->first();
        if(!$tb_employee_evaluator){
            $tb_employee_evaluator = DB::table('tb_employee_evaluator')
            ->where('rec_year',(date('Y')-1))
            ->where('employee_no',$user->orisoft_code)
            ->first();
            $GetIdevaluator = DB::table('tb_employee_evaluator')->insertGetId([
                "rec_year" => $search_year,
                "employee_no" => sprintf("%06d", $tb_employee_evaluator->employee_no),
                "evaluator_active" => 1,
                "employee_name_th" => $tb_employee_evaluator->employee_name_th,
                "employee_name_en" => $tb_employee_evaluator->employee_name_en,
                "position_code" => $tb_employee_evaluator->position_code,
                "position_description" => $tb_employee_evaluator->position_description,
                "grade_code" => $tb_employee_evaluator->grade_code,
                "grade_description" => $tb_employee_evaluator->grade_description,
                "division_code" => $tb_employee_evaluator->division_code,
                "division_description" => $tb_employee_evaluator->division_description,
                "department_code" => $tb_employee_evaluator->department_code,
                "department_description" => $tb_employee_evaluator->department_description,
                "section_code" => $tb_employee_evaluator->section_code,
                "section_description" => $tb_employee_evaluator->section_description,
                "created_by" => Auth::user()->id
            ]);
        }
        $result = [
            'status'=>200,
            'data'=>$user,
            'role'=>$users_model_has_roles,
            'manager'=>$tb_employee_evaluator,
        ];
        echo json_encode($result);
    }

    public function addedituser_action(Request $request)
    {
        $name_th               = $request->input('name_th');
        $name               = $request->input('name');
        $orisoft_code       = $request->input('orisoft_code');
        $email              = $request->input('email');
        $role               = $request->input('role');
        $division_code       = $request->input('division_code');
        $department_code       = $request->input('department_code');
        $section_code       = $request->input('section_code');
        $position_code       = $request->input('position_code');
        $grade_code       = $request->input('grade_code');
        // $new_password      = $request->input('new_password');

        $userscount = DB::table('users')->where('orisoft_code',$orisoft_code)->count();
        $tb_division = DB::table('tb_division')->whereIn('division_code',$division_code)->get();
        $tb_department = DB::table('tb_department')->whereIn('department_code',$department_code)->get();
        $tb_section = DB::table('tb_section')->whereIn('section_code',$section_code)->get();
        $tb_position = DB::table('tb_position')->where('position_code',$position_code)->first();
        $tb_grade_code = DB::table('tb_grade_code')->where('grade_code',$grade_code)->first();

        $division_code1 = '';
        $division_description = '';
        if($tb_division){
            foreach ($tb_division as $key => $value) {
                $division_code1 .= $value->division_code.',';
                $division_description .= $value->division_description.',';
            }
        }
        $division_description = substr($division_description,0,-1);
        $division_code1 = substr($division_code1,0,-1);

        $department_code1 = '';
        $department_description = '';
        if($tb_department){
            foreach ($tb_department as $key => $value) {
                $department_code1 .= $value->department_code.',';
                $department_description .= $value->department_description.',';
            }
        }
        $department_description = substr($department_description,0,-1);
        $department_code1 = substr($department_code1,0,-1);

        $section_description = '';
        $section_code1 = '';
        $section_description1 = '';
        $section_code2 = '';
        if($tb_section){
            foreach ($tb_section as $key => $value) {
                $section_code1 = $value->section_code;
                $section_description1 = $value->section_description;

                $section_code2 .= $value->section_code.',';
                $section_description .= $value->section_description.',';
            }
        }
        $section_code2 = substr($section_code2,0,-1);
        $section_description = substr($section_description,0,-1);
        // $result = [
        //     'division_description'=>$division_description,
        //     'department_description'=>$department_description,
        //     'section_description'=>$section_description,
        // ];
        // echo json_encode($result);

        if($userscount == 0){
            $GetId = DB::table('users')->insertGetId([
                "name" => $name,
                "orisoft_code" => sprintf("%06d", $orisoft_code),
                "email" => $email,
                "password" => Hash::make(sprintf("%06d", $orisoft_code)),
                "section_code" => $section_code1,
                "section_description" => $section_description1,
            ]);
            $orisoft_all_code = DB::table('tb_employee_evaluator')->where('employee_no',$orisoft_code)->where('rec_year',date('Y'))->count();
            if($orisoft_all_code == 0){
                $GetIdevaluator = DB::table('tb_employee_evaluator')->insertGetId([
                    "rec_year" => date('Y'),
                    "employee_no" => sprintf("%06d", $orisoft_code),
                    "evaluator_active" => 1,
                    "employee_name_th" => $name_th,
                    "employee_name_en" => $name,
                    "position_code" => $position_code,
                    "position_description" => $tb_position->position_description,
                    "grade_code" => $grade_code,
                    "grade_description" => $tb_grade_code->grade_description,
                    "division_code" => $division_code1,
                    "division_description" => $division_description,
                    "department_code" => $department_code1,
                    "department_description" => $department_description,
                    "section_code" => $section_code2,
                    "section_description" => $section_description,
                    "created_by" => Auth::user()->id
                ]);
            }
            for($i = 0; $i < count($role); $i++) {
                $users_roles = DB::table('users_roles')->where('name',$role[$i])->first();
                $users_model_has_roles = DB::table('users_model_has_roles')->insertGetId([
                    "role_id" => $users_roles->id,
                    "model_type" => 'App\Models\User',
                    "model_id" => $GetId,
                ]);
            }

            //////////////////////////////////////////// Send mail to Manager & Asst.Manager ////////////////////////////////////////////
            $checkmail = 0;
            if($email){
                $six_digit_random_number = random_int(100000, 999999);
                DB::table('users')
                ->where('users.id', $GetId)
                ->update([
                    "password" => Hash::make(sprintf("%06d", $six_digit_random_number)),
                ]);
                $view_mail = '<html>
                                    <body>
                                    <p>Production Link for EPA (ฐานข้อมูลจริงที่ใช้ประเมินผล)</p>
                                    <a href="http://milepa" target="_blank"><p>http://milepa</p></a>
                                    <p>Username : '.$orisoft_code.'</p>
                                    <p>Password : '.$six_digit_random_number.'</p>
                                    <p>After you login to EPA, please change your password to new password immediately. </p>
                                    </body>
                                </html>';
                $arr = [$email];
                // $arr = ['koranatsoi17@gmail.com'];
                $arr = array_unique( $arr );
                $save = Mail::send([], ['EPA Link for access EPA Production Database (MILEPA)'], function ($message) use ($view_mail,$arr) {
                    $message
                    // ->from($address = 'koranatsoi17@gmail.com', $name = 'swadmin')
                    ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                    ->to($arr) 
                    ->subject('EPA Link for access EPA Production Database (MILEPA)');
                    $message->html($view_mail);
                });
                if($save){
                    $checkmail = $checkmail;
                }
                else{
                    $checkmail++;
                }
            }
            //////////////////////////////////////////// Send mail to Manager & Asst.Manager ////////////////////////////////////////////

            
            $result = [
                'status'=>200,
                'orisoft_code'=>$GetId,
                'checkmail' => $checkmail
            ];
        }else{
            $result = [
                'status'=>500,
            ];
        }
        
        echo json_encode($result);
    }

    public function edituser_action(Request $request)
    {
        $id               = $request->input('id');
        $name_th               = $request->input('name_th');
        $name               = $request->input('name');
        $orisoft_code       = $request->input('orisoft_code');
        $email              = $request->input('email');
        $role               = $request->input('role');
        $division_code       = $request->input('division_code');
        $department_code       = $request->input('department_code');
        $section_code       = $request->input('section_code');
        $position_code       = $request->input('position_code');
        $grade_code       = $request->input('grade_code');
        // $new_password      = $request->input('new_password');

        $userscount = DB::table('users')->where('orisoft_code',$orisoft_code)->count();
        $tb_division = DB::table('tb_division')->whereIn('division_code',$division_code)->get();
        $tb_department = DB::table('tb_department')->whereIn('department_code',$department_code)->get();
        $tb_section = DB::table('tb_section')->whereIn('section_code',$section_code)->get();
        $tb_position = DB::table('tb_position')->where('position_code',$position_code)->first();
        $tb_grade_code = DB::table('tb_grade_code')->where('grade_code',$grade_code)->first();

        $division_code1 = '';
        $division_description = '';
        if($tb_division){
            foreach ($tb_division as $key => $value) {
                $division_code1 .= $value->division_code.',';
                $division_description .= $value->division_description.',';
            }
        }
        $division_description = substr($division_description,0,-1);
        $division_code1 = substr($division_code1,0,-1);

        $department_code1 = '';
        $department_description = '';
        if($tb_department){
            foreach ($tb_department as $key => $value) {
                $department_code1 .= $value->department_code.',';
                $department_description .= $value->department_description.',';
            }
        }
        $department_description = substr($department_description,0,-1);
        $department_code1 = substr($department_code1,0,-1);

        $section_description = '';
        $section_code1 = '';
        $section_description1 = '';
        $section_code2 = '';
        if($tb_section){
            foreach ($tb_section as $key => $value) {
                $section_code1 = $value->section_code;
                $section_description1 = $value->section_description;

                $section_code2 .= $value->section_code.',';
                $section_description .= $value->section_description.',';
            }
        }
        $section_code2 = substr($section_code2,0,-1);
        $section_description = substr($section_description,0,-1);
        // $result = [
        //     'division_description'=>$division_description,
        //     'department_description'=>$department_description,
        //     'section_description'=>$section_description,
        // ];
        // echo json_encode($result);

        if($userscount > 0){
            DB::table('users')
                ->where('users.id', $id)
                ->update([
                    "name" => $name,
                    "email" => $email,
                    "section_code" => $section_code1,
                    "section_description" => $section_description1,
                ]);
            $orisoft_all_code = DB::table('tb_employee_evaluator')
            ->where('employee_no',$orisoft_code)
            ->where('rec_year',date('Y'))->count();
            if($orisoft_all_code > 0){
                DB::table('tb_employee_evaluator')
                ->where('tb_employee_evaluator.employee_no', $orisoft_code)
                ->where('rec_year',date('Y'))
                ->update([
                    "employee_name_th" => $name_th,
                    "employee_name_en" => $name,
                    "position_code" => $position_code,
                    "position_description" => $tb_position->position_description,
                    "grade_code" => $grade_code,
                    "grade_description" => $tb_grade_code->grade_description,
                    "division_code" => $division_code1,
                    "division_description" => $division_description,
                    "department_code" => $department_code1,
                    "department_description" => $department_description,
                    "section_code" => $section_code2,
                    "section_description" => $section_description,
                ]);
            }

            DB::table('users_model_has_roles')->where('model_id', $id)->delete();

            for($i = 0; $i < count($role); $i++) {
                $users_roles = DB::table('users_roles')->where('name',$role[$i])->first();
                $users_model_has_roles_check = DB::table('users_model_has_roles')
                ->where('role_id',$users_roles->id)
                ->where('model_id',$id)
                ->count();
                if($users_model_has_roles_check == 0){
                    $users_model_has_roles = DB::table('users_model_has_roles')->insertGetId([
                        "role_id" => $users_roles->id,
                        "model_type" => 'App\Models\User',
                        "model_id" => $id,
                    ]);
                }
            }
            $result = [
                'status'=>200,
                'orisoft_code'=>$id,
            ];
        }else{
            $result = [
                'status'=>500,
            ];
        }
        
        echo json_encode($result);
    }
}
