<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use App\Models\Users;

use App\Models\EvaluateLog;
use App\Models\EmployeeEvaluator;
use App\Models\EmployeeModel;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Division;
use App\Models\group\Department;
use App\Models\group\Grademaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ImportFileEmployeeEvt implements ToModel
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function covert($code)
    {
        if ($code < 100) {
            $a = "0000$code";
        } else if ($code < 1000) {
            $a = "000$code";
        } else if ($code < 10000) {
            $a = "00$code";
        } else if ($code < 100000) {
            $a = "0$code";
        } else {
            $a = "$code";
        }
        return $a;
    }
    public function model(array $row)
    {
        //  dd($row, $this->id);

        if (!isset($row[2])) {
            return null;
        }
        if ($row[0] == 'Evaluator_ no' || $row[0] == 'Evaluator-No' || $row[0] == 'Evaluator _No') {
            return null;
        }

        // dd($row);
        // exit;

        // ini_set('max_execution_time', 180);
        // ini_set('memory_limit', '1024M');

        $six_digit_random_number = random_int(100000, 999999);
        // dd($six_digit_random_number);
        // exit;
        // $view_mail = '<html>
        //                 <body>
        //                     <p>Username : Test</p>
        //                     <p>Password : '.$six_digit_random_number.'</p>
        //                 </body>
        //             </html>';
        // $arr = ['koranatsoi17@gmail.com'];
        // $arr = array_unique( $arr );
        // $save = Mail::send([], ['E-PA System - Username and Password'], function ($message) use ($view_mail,$arr) {
        //     $message
        //     ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
        //     ->to($arr)
        //     ->subject('E-PA System - Username and Password');
        //     $message->html($view_mail);
        // });
        // if($save){
        //     echo 'ok';
        // }
        // else{
        //     echo 'error';
        // }
        // exit;






        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
        $previousYear = date('Ym');
        $checkYear = date('Y');
        // }

        if (trans(request()->segment(1)) == 'mtl') {
            $Emp = EvaluateLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "Evaluator_name" => $row[1],
                "Evaluator_Localname" => $row[2],
                "Evaluator_position_code" => $row[3],
                "Evaluator_position_DESCRIPTION" => $row[4],
                "Evaluator_DIVISION_CODE" => $row[5],
                "Evaluator_DIVISION_DESCRIPTION" => $row[6],
                "Evaluator_DEPARTMENT_CODE" => $row[7],
                "Evaluator_DEPARTMENT_DESCRIPTION" => $row[8],
                "Evaluator_SECTION_CODE" => $row[9],
                "Evaluator_SECTION_DESCRIPTION" => $row[10],
                "Evaluator_GRADE_CODE" => $row[11],
                "Evaluator_GRADE_DESCRIPTION" => $row[12],
                // "employee_name_th" => $row[3],
                // "employee_name_en" => $row[4],
                // "approve_pa_score_by" => sprintf("%'.06d\n", $row[11]),
                // "approve_name_en" => $row[10],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);

            $countPosition = Position::where('position_code', $row[3])->count();
            if($countPosition == 0){
                $CreatePosition = Position::create([
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            // $countDivision = Division::where('division_code', $row[5])->count();
            // if($countDivision == 0){
            //     $CreateDivision = Division::create([
            //         "division_code" => $row[5],
            //         "division_description" => $row[6],
            //         "created_by" => Auth::user()->id,
            //         "updated_by" => '0',
            //         "created" => date('Y-m-d H:i:s'),
            //         "updated" => null,
            //     ]);
            // }
            // $countDepartment = Department::where('department_code', $row[7])->count();
            // if($countDepartment == 0){
            //     $CreateDepartment = Department::create([
            //         "department_code" => $row[7],
            //         "department_description" => $row[8],
            //         "created_by" => Auth::user()->id,
            //         "updated_by" => '0',
            //         "created" => date('Y-m-d H:i:s'),
            //         "updated" => null,
            //     ]);
            // }
            // $countSection = Section::where('section_code', $row[9])->count();
            // if($countSection == 0){
            //     $CreateSection = Section::create([
            //         "section_code" => $row[9],
            //         "section_description" => $row[10],
            //         "created_by" => Auth::user()->id,
            //         "updated_by" => '0',
            //         "created" => date('Y-m-d H:i:s'),
            //         "updated" => null,
            //     ]);
            // }
            $countGrademaster = Grademaster::where('grade_code', $row[11])->count();
            if($countGrademaster == 0){
                $CreateGrademaster = Grademaster::create([
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }

            $count = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
            if ($count == 0) {
                $Emp = EmployeeEvaluator::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "evaluator_active" => '1',
                    "employee_name_th" => $row[2],
                    "employee_name_en" => $row[1],
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    // "approve_pa_score_by" => sprintf("%'.06d\n", $row[11]),
                    // "approve_name_en" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
                DB::table('tb_employee_final_score')
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->update([
                        "evaluator_active" => '1',
                    ]);
            } else {
                $rowdata = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->orderBy('id', 'desc')
                    ->first();
                DB::table('tb_employee_evaluator')->where('id', $rowdata->id)->update([
                    "import_id" => $this->id,
                    "evaluator_active" => '1',
                    "employee_name_th" => $row[2],
                    "employee_name_en" => $row[1],
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    // 'approve_pa_score_by' => sprintf("%'.06d\n", $row[11]),
                    // "approve_name_en" => $row[10],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
                DB::table('tb_employee_final_score')
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->update([
                        "evaluator_active" => '1',
                    ]);
            }

            $countUsers = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
            if ($countUsers == 0) {
                $Users = Users::create([
                    "orisoft_code" => sprintf("%06d", $row[0]),
                    "name" => $row[1],
                    "email" => ($row[13]!=""?$row[13]:NULL),
                    "password" => Hash::make(sprintf("%06d", $row[0])),
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
                $rowusers = DB::table('users')->where('orisoft_code',sprintf("%06d", $row[0]))->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();

                $orisoft_codexxx = sprintf("%06d", $row[0]);

                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }
                if($row[3] == '103' || $row[3] == '105' || $row[3] == '108'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($row[3] == '101' || $row[3] == '103' || $row[3] == '105' || $row[3] == '108'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($row[3] == '100' || $row[3] == '101'){
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','7')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '7',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }

                if($orisoft_codexxx == "019492"){
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_rolesxx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','3')
                    ->count();
                    if($check_users_model_has_rolesxx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '3',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($orisoft_codexxx == "000060"){
                    $check_users_model_has_rolesz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_roleszz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','4')
                    ->count();
                    if($check_users_model_has_roleszz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '4',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
            } else {
                $rowusers = DB::table('users')->where('orisoft_code',sprintf("%06d", $row[0]))->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();
                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }

                $orisoft_codexxx = sprintf("%06d", $row[0]);
                if($row[3] == '101' || $row[3] == '103' || $row[3] == '105' || $row[3] == '108'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($row[3] == '100' || $row[3] == '101'){
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','7')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '7',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
            }
            if ($row[7]) {
                DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                    ->where('tb_employee.department_code', $row[7])
                    ->where('tb_employee_final_score.status_pa', '0')
                    ->update([
                        "status_pa" => '1'
                    ]);
            }
        } else if (trans(request()->segment(1)) == 'manager') {
            $Emp = EvaluateLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "Evaluator_name" => $row[1],
                "Evaluator_Localname" => $row[2],
                "Evaluator_position_code" => $row[3],
                "Evaluator_position_DESCRIPTION" => $row[4],
                "Evaluator_DIVISION_CODE" => $row[5],
                "Evaluator_DIVISION_DESCRIPTION" => $row[6],
                "Evaluator_DEPARTMENT_CODE" => $row[7],
                "Evaluator_DEPARTMENT_DESCRIPTION" => $row[8],
                "Evaluator_SECTION_CODE" => $row[9],
                "Evaluator_SECTION_DESCRIPTION" => $row[10],
                "Evaluator_GRADE_CODE" => $row[11],
                "Evaluator_GRADE_DESCRIPTION" => $row[12],
                // "employee_name_th" => $row[3],
                // "employee_name_en" => $row[4],
                // "approve_pa_score_by" => sprintf("%'.06d\n", $row[11]),
                // "approve_name_en" => $row[10],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);

            $countPosition = Position::where('position_code', $row[3])->count();
            if($countPosition == 0){
                $CreatePosition = Position::create([
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDivision = Division::where('division_code', $row[5])->count();
            if($countDivision == 0){
                $CreateDivision = Division::create([
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDepartment = Department::where('department_code', $row[7])->count();
            if($countDepartment == 0){
                $CreateDepartment = Department::create([
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countSection = Section::where('section_code', $row[9])->count();
            if($countSection == 0){
                $CreateSection = Section::create([
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countGrademaster = Grademaster::where('grade_code', $row[11])->count();
            if($countGrademaster == 0){
                $CreateGrademaster = Grademaster::create([
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }

            $count = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
            if ($count == 0) {
                $Emp = EmployeeEvaluator::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "evaluator_active" => '1',
                    "employee_name_th" => $row[2],
                    "employee_name_en" => $row[1],
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    // "approve_pa_score_by" => sprintf("%'.06d\n", $row[11]),
                    // "approve_name_en" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
                DB::table('tb_employee_final_score')
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->update([
                        "evaluator_active" => '1',
                    ]);
            } else {
                $rowdata = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->orderBy('id', 'desc')
                    ->first();
                DB::table('tb_employee_evaluator')->where('id', $rowdata->id)->update([
                    "import_id" => $this->id,
                    "evaluator_active" => '1',
                    "employee_name_th" => $row[2],
                    "employee_name_en" => $row[1],
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    // 'approve_pa_score_by' => sprintf("%'.06d\n", $row[11]),
                    // "approve_name_en" => $row[10],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
                DB::table('tb_employee_final_score')
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->update([
                        "evaluator_active" => '1',
                    ]);
            }

            $countUsers = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
            if ($countUsers == 0) {
                $Users = Users::create([
                    "orisoft_code" => sprintf("%06d", $row[0]),
                    "name" => $row[1],
                    "email" => ($row[13]!=""?$row[13]:NULL),
                    "password" => Hash::make(sprintf("%06d", $row[0])),
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
                $rowusers = DB::table('users')->where('orisoft_code',sprintf("%06d", $row[0]))->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();

                $orisoft_codexxx = sprintf("%06d", $row[0]);

                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }
                // if($row[3] == '103' || $row[3] == '105' || $row[3] == '106' || $row[3] == '114'){
                //     $check_users_model_has_roles = DB::table('users_model_has_roles')
                //     ->where('users_model_has_roles.model_id',$rowusers->id)
                //     ->where('users_model_has_roles.role_id','6')
                //     ->count();
                //     if($check_users_model_has_roles == 0){
                //         DB::table('users_model_has_roles')->insert([
                //             'role_id' => '6',
                //             'model_type' => 'App\Models\User',
                //             'model_id' => $rowusers->id
                //         ]);
                //     }
                // }
                if($row[3] == '100' || $row[3] == '101'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }

                if($orisoft_codexxx == "019492"){
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_rolesxx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','3')
                    ->count();
                    if($check_users_model_has_rolesxx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '3',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($orisoft_codexxx == "000060"){
                    $check_users_model_has_rolesz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_roleszz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','4')
                    ->count();
                    if($check_users_model_has_roleszz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '4',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
            } else {
                // $rowdataUsers = Users::where('orisoft_code', sprintf("%06d", $row[0]))
                //     ->orderBy('id', 'desc')
                //     ->first();
                // if($row[13] != ""){
                //     DB::table('Users')->where('id', $rowdataUsers->id)->update([
                //         // "email" => ($row[13]!=""?$row[13]:NULL),
                //         'updated_at' => date('Y-m-d H:i:s'),
                //     ]);
                // }

                $rowusers = DB::table('users')->where('orisoft_code',sprintf("%06d", $row[0]))->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();
                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }

                $orisoft_codexxx = sprintf("%06d", $row[0]);

                if($row[3] == '101' || $row[3] == '114'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($row[3] == '100' || $row[3] == '101'){
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','7')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '7',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                // if($orisoft_codexxx == "019492" || $orisoft_codexxx == "990002"){
                //     $check_users_model_has_rolesz = DB::table('users_model_has_roles')
                //     ->where('users_model_has_roles.model_id',$rowusers->id)
                //     ->where('users_model_has_roles.role_id','2')
                //     ->count();
                //     if($check_users_model_has_rolesz == 0){
                //         DB::table('users_model_has_roles')->insert([
                //             'role_id' => '2',
                //             'model_type' => 'App\Models\User',
                //             'model_id' => $rowusers->id
                //         ]);
                //     }
                //     $check_users_model_has_roleszz = DB::table('users_model_has_roles')
                //     ->where('users_model_has_roles.model_id',$rowusers->id)
                //     ->where('users_model_has_roles.role_id','3')
                //     ->count();
                //     if($check_users_model_has_roleszz == 0){
                //         DB::table('users_model_has_roles')->insert([
                //             'role_id' => '3',
                //             'model_type' => 'App\Models\User',
                //             'model_id' => $rowusers->id
                //         ]);
                //     }
                // }
            }
            if ($row[7]) {
                DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                    ->where('tb_employee.department_code', $row[7])
                    ->where('tb_employee_final_score.status_pa', '0')
                    ->update([
                        "status_pa" => '1'
                    ]);
            }
        } else {
            $Emp = EvaluateLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "Evaluator_name" => $row[1],
                "Evaluator_Localname" => $row[2],
                "Evaluator_position_code" => $row[3],
                "Evaluator_position_DESCRIPTION" => $row[4],
                "Evaluator_DIVISION_CODE" => $row[5],
                "Evaluator_DIVISION_DESCRIPTION" => $row[6],
                "Evaluator_DEPARTMENT_CODE" => $row[7],
                "Evaluator_DEPARTMENT_DESCRIPTION" => $row[8],
                "Evaluator_SECTION_CODE" => $row[9],
                "Evaluator_SECTION_DESCRIPTION" => $row[10],
                "Evaluator_GRADE_CODE" => $row[11],
                "Evaluator_GRADE_DESCRIPTION" => $row[12],
                // "employee_name_th" => $row[3],
                // "employee_name_en" => $row[4],
                // "approve_pa_score_by" => sprintf("%'.06d\n", $row[11]),
                // "approve_name_en" => $row[10],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);

            $countPosition = Position::where('position_code', $row[3])->count();
            if($countPosition == 0){
                $CreatePosition = Position::create([
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDivision = Division::where('division_code', $row[5])->count();
            if($countDivision == 0){
                $CreateDivision = Division::create([
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDepartment = Department::where('department_code', $row[7])->count();
            if($countDepartment == 0){
                $CreateDepartment = Department::create([
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countSection = Section::where('section_code', $row[9])->count();
            if($countSection == 0){
                $CreateSection = Section::create([
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countGrademaster = Grademaster::where('grade_code', $row[11])->count();
            if($countGrademaster == 0){
                $CreateGrademaster = Grademaster::create([
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }

            // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
            // if ($countEmployeeModel == 0) {
            //     $rowGrade = Grademaster::where('grade_code', $row[5])->first();
            //     $rowDivision = Division::where('division_code', $row[6])->first();
            //     $rowDepartment = Department::where('department_code', $row[7])->first();
            //     $rowSection = Section::where('section_code', $row[8])->first();
            //     $rowPosition = Position::where('position_description', $row[9])->first();

            //     $CreateEmployeeModel = EmployeeModel::create([
            //         "orisoft_no" => sprintf("%06d", $row[0]),
            //         "title_en" => $row[1],
            //         "title_th" => $row[2],
            //         "employee_local_name_th" => $row[3],
            //         "employee_local_name_en" => $row[4],
            //         "grade_code" => $row[5],
            //         "grade_description" => ($rowGrade ? $rowGrade->grade_description : null),
            //         "division_code" => $row[6],
            //         "division_description" => ($rowDivision ? $rowDivision->division_description : null),
            //         "department_code" => $row[7],
            //         "department_description" => ($rowDepartment ? $rowDepartment->department_description : null),
            //         "section_code" => $row[8],
            //         "section_description" => ($rowSection ? $rowSection->section_description : null),
            //         "position_code" => ($rowPosition ? $rowPosition->position_code : null),
            //         "position_description" => $row[9],
            //         "created_by" => Auth::user()->id,
            //         "updated_by" => '0',
            //         "created_at" => date('Y-m-d H:i:s'),
            //         "updated_at" => null,
            //     ]);
            // } else {
            //     $rowGrade = Grademaster::where('grade_code', $row[5])->first();
            //     $rowDivision = Division::where('division_code', $row[6])->first();
            //     $rowDepartment = Department::where('department_code', $row[7])->first();
            //     $rowSection = Section::where('section_code', $row[8])->first();
            //     $rowPosition = Position::where('position_description', $row[9])->first();
            //     DB::table('tb_employee')->where('orisoft_no', sprintf("%06d", $row[0]))->update([
            //         "title_en" => $row[1],
            //         "title_th" => $row[2],
            //         "employee_local_name_th" => $row[3],
            //         "employee_local_name_en" => $row[4],
            //         "grade_code" => $row[5],
            //         "grade_description" => ($rowGrade ? $rowGrade->grade_description : null),
            //         "division_code" => $row[6],
            //         "division_description" => ($rowDivision ? $rowDivision->division_description : null),
            //         "department_code" => $row[7],
            //         "department_description" => ($rowDepartment ? $rowDepartment->department_description : null),
            //         "section_code" => $row[8],
            //         "section_description" => ($rowSection ? $rowSection->section_description : null),
            //         "position_code" => ($rowPosition ? $rowPosition->position_code : null),
            //         "position_description" => $row[9],
            //         'updated_at' => date('Y-m-d H:i:s'),
            //         'updated_by' => Auth::user()->id,
            //     ]);
            // }

            $count = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
            if ($count == 0) {
                $Emp = EmployeeEvaluator::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "evaluator_active" => '1',
                    "employee_name_th" => $row[2],
                    "employee_name_en" => $row[1],
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    // "approve_pa_score_by" => sprintf("%'.06d\n", $row[11]),
                    // "approve_name_en" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
                DB::table('tb_employee_final_score')
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->update([
                        "evaluator_active" => '1',
                    ]);
            } else {
                $rowdata = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->orderBy('id', 'desc')
                    ->first();
                DB::table('tb_employee_evaluator')->where('id', $rowdata->id)->update([
                    "import_id" => $this->id,
                    "evaluator_active" => '1',
                    "employee_name_th" => $row[2],
                    "employee_name_en" => $row[1],
                    "position_code" => $row[3],
                    "position_description" => $row[4],
                    "grade_code" => $row[11],
                    "grade_description" => $row[12],
                    "division_code" => $row[5],
                    "division_description" => $row[6],
                    "department_code" => $row[7],
                    "department_description" => $row[8],
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    // 'approve_pa_score_by' => sprintf("%'.06d\n", $row[11]),
                    // "approve_name_en" => $row[10],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
                DB::table('tb_employee_final_score')
                    ->where('rec_year', 'like', '%' . $checkYear . '%')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->update([
                        "evaluator_active" => '1',
                    ]);
            }

            $countUsers = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
            if ($countUsers == 0) {
                $Users = Users::create([
                    "orisoft_code" => sprintf("%06d", $row[0]),
                    "name" => $row[1],
                    "email" => ($row[13]!=""?$row[13]:NULL),
                    "password" => Hash::make(sprintf("%06d", $row[0])),
                    "section_code" => $row[9],
                    "section_description" => $row[10],
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
                $rowusers = DB::table('users')->where('orisoft_code',sprintf("%06d", $row[0]))->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();

                $orisoft_codexxx = sprintf("%06d", $row[0]);

                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }
                if($row[3] == '103' || $row[3] == '105' || $row[3] == '106' || $row[3] == '114'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }



                    if($orisoft_codexxx == "000060" && $rowusers->email){
                        // $six_digit_random_number = random_int(100000, 999999);
                        // DB::table('users')
                        // ->where('users.id', $rowusers->id)
                        // ->update([
                        //     "password" => Hash::make(sprintf("%06d", $six_digit_random_number)),
                        // ]);
                        // $view_mail = '<html>
                        //                     <body>
                        //                     <p>Username : '.$rowusers->orisoft_code.'</p>
                        //                     <p>Password : '.$six_digit_random_number.'</p>
                        //                     <p>Link E-PA : <a href="http://milepa/mil/dashboard" target="_blank"> >>> Click here <<< </a></p>
                        //                     </body>
                        //                 </html>';
                        // $arr = ['koranatsoi17@gmail.com'];
                        // // $arr = [$rowusers->email];
                        // $arr = array_unique( $arr );
                        // $save = Mail::send([], ['E-PA System - Username and Password'], function ($message) use ($view_mail,$arr) {
                        //     $message
                        //     ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                        //     ->to($arr)
                        //     ->subject('E-PA System - Username and Password');
                        //     $message->html($view_mail);
                        // });
                    }
                    // $sub = substr($row[5],0,1);
                    // if($sub == 'G' || $sub == 'P'){
                    //     $department_code_sub = '';
                    //     $department_description_sub = '';
                    //     $tb_department = DB::table('tb_department')->where('department_code','like',''.$sub.'%')->get();
                    //     foreach ($tb_department as $value) {
                    //         $department_code_sub .= $value->department_code.',';
                    //         $department_description_sub .= $value->department_description.',';
                    //     }
                    //     $sub = substr($department_code_sub,0,-1);
                    //     $sub = substr($department_description_sub,0,-1);
                    // }else{

                    // }

                }

                if($orisoft_codexxx == "019492"){
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_rolesxx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','3')
                    ->count();
                    if($check_users_model_has_rolesxx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '3',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($orisoft_codexxx == "000060"){
                    $check_users_model_has_rolesz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_roleszz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','4')
                    ->count();
                    if($check_users_model_has_roleszz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '4',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
            } else {
                // $rowdataUsers = Users::where('orisoft_code', sprintf("%06d", $row[0]))
                //     ->orderBy('id', 'desc')
                //     ->first();
                // if($row[13] != ""){
                //     DB::table('Users')->where('id', $rowdataUsers->id)->update([
                //         // "email" => ($row[13]!=""?$row[13]:NULL),
                //         'updated_at' => date('Y-m-d H:i:s'),
                //     ]);
                // }

                $rowusers = DB::table('users')->where('orisoft_code',sprintf("%06d", $row[0]))->first();
                $check_users_model_has_roles = DB::table('users_model_has_roles')
                ->where('users_model_has_roles.model_id',$rowusers->id)
                ->where('users_model_has_roles.role_id','8')
                ->count();
                if($check_users_model_has_roles == 0){
                    DB::table('users_model_has_roles')->insert([
                        'role_id' => '8',
                        'model_type' => 'App\Models\User',
                        'model_id' => $rowusers->id
                    ]);
                }

                $orisoft_codexxx = sprintf("%06d", $row[0]);

                if($row[3] == '103' || $row[3] == '105' || $row[3] == '106' || $row[3] == '114'){
                    $check_users_model_has_roles = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','6')
                    ->count();
                    if($check_users_model_has_roles == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '6',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }

                    if($orisoft_codexxx == "000060" && $rowusers->email){
                        // $six_digit_random_number = random_int(100000, 999999);
                        // DB::table('users')
                        // ->where('users.id', $rowusers->id)
                        // ->update([
                        //     "password" => Hash::make(sprintf("%06d", $six_digit_random_number)),
                        // ]);
                        // $view_mail = '<html>
                        //                     <body>
                        //                     <p>Username : '.$rowusers->orisoft_code.'</p>
                        //                     <p>Password : '.$six_digit_random_number.'</p>
                        //                     <p>Link E-PA : <a href="http://milepa/mil/dashboard" target="_blank">Click here</a></p>
                        //                     </body>
                        //                 </html>';
                        // $arr = ['koranatsoi17@gmail.com'];
                        // // $arr = [$rowusers->email];
                        // // $arr = array_unique( $arr );
                        // $save = Mail::send([], ['E-PA System - Username and Password'], function ($message) use ($view_mail,$arr) {
                        //     $message
                        //     ->from($address = 'swadmin@meyer-mil.com', $name = 'swadmin')
                        //     ->to($arr)
                        //     ->subject('E-PA System - Username and Password');
                        //     $message->html($view_mail);
                        // });
                    }
                }

                if($orisoft_codexxx == "019492"){
                    $check_users_model_has_rolesz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_roleszz = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','3')
                    ->count();
                    if($check_users_model_has_roleszz == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '3',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
                if($orisoft_codexxx == "000060"){
                    $check_users_model_has_rolesxx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','2')
                    ->count();
                    if($check_users_model_has_rolesxx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '2',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                    $check_users_model_has_rolesx = DB::table('users_model_has_roles')
                    ->where('users_model_has_roles.model_id',$rowusers->id)
                    ->where('users_model_has_roles.role_id','4')
                    ->count();
                    if($check_users_model_has_rolesx == 0){
                        DB::table('users_model_has_roles')->insert([
                            'role_id' => '4',
                            'model_type' => 'App\Models\User',
                            'model_id' => $rowusers->id
                        ]);
                    }
                }
            }
            if ($row[7]) {
                DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                    ->where('tb_employee.department_code', $row[7])
                    ->where('tb_employee_final_score.status_pa', '0')
                    ->update([
                        "status_pa" => '1'
                    ]);

            }
        }


        // $countUser = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
        // if($countUser != 0){
        //     DB::table('users')->where('orisoft_code', sprintf("%06d", $row[0]) )->update([
        //         "email" => $row[4]
        //     ]);
        // }
    }
}
