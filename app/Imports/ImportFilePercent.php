<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Users;

use App\Http\Controllers\Controller;
use App\Models\EvaluateLog;
use App\Models\EmployeeEvaluator;
use App\Models\EmployeeModel;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Division;
use App\Models\group\Department;
use App\Models\group\Grademaster;
use App\Models\EmployeeFinalScore;
use App\Models\formEvaluate\formEvaluate;
use App\Models\PercentDepartmentAction;
use App\Models\PercentDepartment;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class ImportFilePercent implements ToModel
{
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
    public function modelbk(array $row)
    {

        // if (!isset($row[0])) {
        //     return null;
        // }
        if ($row[0] == 'Set %Increase by Dept.') {
            return null;
        }
        if ($row[0] == 'Division Name') {
            return null;
        }
        // ini_set('max_execution_time',180);
        // ini_set('memory_limit', '1024M');

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Ym');
            $checkYear = date('Y');
        // }

        // dd($row);
        // exit;

        $data = DB::table('tb_percent_department')->where('year', $checkYear)->count();
        if($data == 0){
            $CreatePercentDepartment = PercentDepartment::create([
                "title" => '% Department Year '.$checkYear,
                "year" => $checkYear,
                "date" => date('Y-m-d'),
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created" => date('Y-m-d H:i:s'),
                "updated" => null,
            ]);
        }else{

        }

        $tb_percent_department = DB::table('tb_percent_department')->where('year', $checkYear)->first();

        $checka1 = strpos($row[8],' ');
        if($checka1 > 0){
            if(trans(request()->segment(1)) == 'manager'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else{
                    $employee_name_en = explode(' ',$row[8]);
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->count();
                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->first();
                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $approve_by1 = NULL;
                    }
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else if($row[8] == "joseph" || $row[8] == "Joseph"){
                    $approve_by1 = '000002';
                }else{
                    $employee_name_en = explode(' ',$row[8]);
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$employee_name_en[0].'%')->count();
                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$employee_name_en[0].'%')->first();
                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $approve_by1 = NULL;
                    }
                }
            }else{
                $employee_name_en = explode(' ',$row[8]);
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->count();
                if($tb_employee_evaluator > 0){
                    $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->first();
                    $approve_by1 = $tb_employee_evaluatorx->employee_no;
                }else{
                    $approve_by1 = NULL;
                }
            }

            // echo $approve_by1."___";
        }else{
            if(trans(request()->segment(1)) == 'manager'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else{
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$row[8].'%')->count();
                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$row[8].'%')->first();
                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $approve_by1 = NULL;
                    }
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else if($row[8] == "joseph" || $row[8] == "Joseph"){
                    $approve_by1 = '000002';
                }else{
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->count();

                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->first();

                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $approve_by1 = NULL;
                    }
                }
            }else{
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->count();
                if($tb_employee_evaluator > 0){
                    $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->first();
                    $approve_by1 = $tb_employee_evaluatorx->employee_no;
                }else{
                    $approve_by1 = NULL;
                }
            }

            // echo $approve_by1."___";
        }
        // echo $approve_by1."___";
        // dd($approve_by1);
        // exit;

        if(trans(request()->segment(1)) == 'manager'){
            if($row[9] == "Joseph" || $row[9] == "joseph"){
                $approve_by2 = "000002";
            }else{
                $approve_by2 = "000042";
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($row[9] == "Joseph" || $row[9] == "joseph"){
                $approve_by2 = "000002";
            }else{
                $approve_by2 = "000002";
            }
        }else{
            if($row[9] == "Komkrit"){
                $approve_by2 = "000026";
            }else{
                $approve_by2 = "000002";
            }
        }

        $division_code = "\''.$row[2].'\'";
        $department_code = "\''.$row[3].'\'";
        $section_code = "\''.$row[4].'\'";

        $data2 = DB::table('tb_percent_department_action')
        ->where('percent_department_id', $tb_percent_department->id)
        ->where('division_code', 'like','%'.$row[2].'%')
        ->where('department_code', 'like','%'.$row[3].'%')
        ->where('section_code', 'like','%'.$row[4].'%')
        ->count();
        // echo $row[3]."___";
        // echo "<pre>";
        // print_r($data2);
        // dd($data2);
        // exit;
        if($data2 == 0){
            if($row[2]){
                $PercentDepartmentAction = PercentDepartmentAction::create([
                    "percent_department_id" => $tb_percent_department->id,
                    "division_code" => $row[2],
                    "department_code" => $row[3],
                    "section_code" => $row[4],
                    "percent_daily" => ($row[6]*100),
                    "percent_monthly" => ($row[7]*100),
                    "approve_by1" => $approve_by1,
                    "approve_by2" => $approve_by2,
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
        }else{
            if($row[2]){
                DB::table('tb_percent_department_action')
                ->where('percent_department_id', $tb_percent_department->id)
                ->where('division_code', 'like','%'.$row[2].'%')
                ->where('department_code', 'like','%'.$row[3].'%')
                ->where('section_code', 'like','%'.$row[4].'%')
                ->update([
                    "percent_daily" => ($row[6]*100),
                    "percent_monthly" => ($row[7]*100),
                    "approve_by1" => $approve_by1,
                    "approve_by2" => $approve_by2,
                ]);
            }
        }
        // dd($data2);
        // exit;















        ////////// Case 1 //////////
        // $countUser = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
        // if($countUser == 0){
        //     $data = ['name' => $row[1]];
        //     $data['orisoft_code'] = $row[0];
        //     $data['profile_photo_path'] = NULL;
        //     $data['password'] = Hash::make($row[0].'@e-pa.com');
        //     $user = Users::updateOrCreate(['email' => $row[0].'@e-pa.com'], $data);

        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
        //     if($countEmployeeEvaluator == 0){
        //         $CreateEmployeeEvaluator = EmployeeEvaluator::create([
        //             "rec_year" => $checkYear,
        //             "employee_no" => sprintf("%06d", $row[0]),
        //             "employee_name_th" => $row[2],
        //             "employee_name_en" => $row[1],
        //             "evaluator_active" => '1',
        //             "created_by" => Auth::user()->id,
        //             "updated_by" => '0',
        //             "created_at" => date('Y-m-d H:i:s'),
        //             "updated_at" => null,
        //         ]);
        //     }
        // }else{
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
        //     if($countEmployeeEvaluator == 0){
        //         $CreateEmployeeEvaluator = EmployeeEvaluator::create([
        //             "rec_year" => $checkYear,
        //             "employee_no" => sprintf("%06d", $row[0]),
        //             "employee_name_th" => $row[2],
        //             "employee_name_en" => $row[1],
        //             "evaluator_active" => '1',
        //             "created_by" => Auth::user()->id,
        //             "updated_by" => '0',
        //             "created_at" => date('Y-m-d H:i:s'),
        //             "updated_at" => null,
        //         ]);
        //     }
        // }

        ////////// Case 2 update email //////////
        // $countUser = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
        // if($countUser != 0){
        //     DB::table('users')->where('orisoft_code', sprintf("%06d", $row[0]) )->update([
        //         "email" => $row[4]
        //     ]);
        // }

        ////////// Case 3 update position_code ของ ผู้ประเมิน //////////
        // $countEmployeeEvaluator = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
        // if($countEmployeeEvaluator != 0){
        //     $rowPosition = Position::where('position_description',$row[3])->first();
        //     DB::table('tb_employee_evaluator')->where('employee_no', sprintf("%06d", $row[0]) )->update([
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[3],
        //     ]);
        // }

        ////////// Case 4 2023 Annual Increment L800 //////////
        // $countPosition = Position::where('position_description', $row[8])->count();
        // if($countPosition == 0){
        //     $CreatePosition = Position::create([
        //         "position_description" => $row[8],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDivision = Division::where('division_code', $row[0])->count();
        // if($countDivision == 0){
        //     $CreateDivision = Division::create([
        //         "division_code" => $row[0],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDepartment = Department::where('department_code', $row[1])->count();
        // if($countDepartment == 0){
        //     $CreateDepartment = Department::create([
        //         "department_code" => $row[1],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countSection = Section::where('section_code', $row[2])->count();
        // if($countSection == 0){
        //     $CreateSection = Section::create([
        //         "section_code" => $row[2],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countGrademaster = Grademaster::where('grade_code', $row[4])->count();
        // if($countGrademaster == 0){
        //     $CreateGrademaster = Grademaster::create([
        //         "grade_code" => $row[4],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }

        // $rowDivision = Division::where('division_code',$row[0])->first();
        // $rowDepartment = Department::where('department_code',$row[1])->first();
        // $rowSection = Section::where('section_code',$row[2])->first();
        // $rowGrade = Grademaster::where('grade_code',$row[4])->first();
        // $rowPosition = Position::where('position_description',$row[8])->first();

        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[6]))->count();
        // if($countEmployeeModel == 0){
        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "orisoft_no" => sprintf("%06d", $row[6]),
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     DB::table('tb_employee')
        //     ->where('orisoft_no', sprintf("%06d", $row[6]) )
        //     ->update([
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // $countformEvaluate = formEvaluate::where('form_ref',$row[15])->where('form_year_use_start',$checkYear)->count();
        // if($countformEvaluate == 0){
        //     $group_form_id = 0;
        // }else{
        //     $rowformEvaluate = formEvaluate::where('form_ref',$row[15])->where('form_year_use_start',$checkYear)->first();
        //     $group_form_id = $rowformEvaluate->id;
        // }
        // $count = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[6]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // if($count == 0){
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[16])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[15]){
        //         $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[15])->where('form_year_use_start', $checkYear)->first();
        //         $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //         foreach ($row_group_form_topic as $key2 => $val2) {
        //             $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //             $evaluation_criteria_id_comma .= ',';
        //         }
        //         $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //     }
        //     $Emp = EmployeeFinalScore::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[6]),
        //         "form_import" => $row[15],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => $countEmployeeEvaluator->employee_no,
        //         "evaluator_name_en" => $row[16],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[12],
        //         "adjust_grade_old2" => $row[13],
        //         "adjust_grade_old3" => $row[14],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:NULL),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "status_pa" => '3',
        //         "created_by" => Auth::user()->id,
        //         "created_at" => date('Y-m-d H:i:s'),
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }else{
        //     $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[6]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[16])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[15]){
        //         if($rowdata->evaluation_criteria_id == null || $rowdata->evaluation_criteria_id == ''){
        //             $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[15])->where('form_year_use_start', $checkYear)->first();
        //             $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //             foreach ($row_group_form_topic as $key2 => $val2) {
        //                 $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //                 $evaluation_criteria_id_comma .= ',';
        //             }
        //             $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //         }
        //     }
        //     DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //         "form_import" => $row[15],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => $countEmployeeEvaluator->employee_no,
        //         "evaluator_name_en" => $row[16],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[12],
        //         "adjust_grade_old2" => $row[13],
        //         "adjust_grade_old3" => $row[14],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:$rowdata->evaluation_criteria_id),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "status_pa" => '3',
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }

        ////////// Case 5 2023 Annual Increment L600-700 //////////
        // $countPosition = Position::where('position_description', $row[8])->count();
        // if($countPosition == 0){
        //     $CreatePosition = Position::create([
        //         "position_description" => $row[8],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDivision = Division::where('division_code', $row[0])->count();
        // if($countDivision == 0){
        //     $CreateDivision = Division::create([
        //         "division_code" => $row[0],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDepartment = Department::where('department_code', $row[1])->count();
        // if($countDepartment == 0){
        //     $CreateDepartment = Department::create([
        //         "department_code" => $row[1],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countSection = Section::where('section_code', $row[2])->count();
        // if($countSection == 0){
        //     $CreateSection = Section::create([
        //         "section_code" => $row[2],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countGrademaster = Grademaster::where('grade_code', $row[4])->count();
        // if($countGrademaster == 0){
        //     $CreateGrademaster = Grademaster::create([
        //         "grade_code" => $row[4],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }

        // $rowDivision = Division::where('division_code',$row[0])->first();
        // $rowDepartment = Department::where('department_code',$row[1])->first();
        // $rowSection = Section::where('section_code',$row[2])->first();
        // $rowGrade = Grademaster::where('grade_code',$row[4])->first();
        // $rowPosition = Position::where('position_description',$row[8])->first();

        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[6]))->count();
        // if($countEmployeeModel == 0){
        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "orisoft_no" => sprintf("%06d", $row[6]),
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     DB::table('tb_employee')
        //     ->where('orisoft_no', sprintf("%06d", $row[6]) )
        //     ->update([
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // $countformEvaluate = formEvaluate::where('form_ref',$row[13])->where('form_year_use_start',$checkYear)->count();
        // if($countformEvaluate == 0){
        //     $group_form_id = 0;
        // }else{
        //     $rowformEvaluate = formEvaluate::where('form_ref',$row[13])->where('form_year_use_start',$checkYear)->first();
        //     $group_form_id = $rowformEvaluate->id;
        // }
        // $count = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[6]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // if($count == 0){
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[14])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[13]){
        //         $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[13])->where('form_year_use_start', $checkYear)->first();
        //         $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //         foreach ($row_group_form_topic as $key2 => $val2) {
        //             $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //             $evaluation_criteria_id_comma .= ',';
        //         }
        //         $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //     }
        //     $Emp = EmployeeFinalScore::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[6]),
        //         "form_import" => $row[13],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => ($countEmployeeEvaluator?$countEmployeeEvaluator->employee_no:NULL),
        //         "evaluator_name_en" => $row[14],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[10],
        //         "adjust_grade_old2" => $row[11],
        //         "adjust_grade_old3" => $row[12],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:NULL),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "status_pa" => '3',
        //         "created_by" => Auth::user()->id,
        //         "created_at" => date('Y-m-d H:i:s'),
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }else{
        //     $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[6]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[14])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[13]){
        //         if($rowdata->evaluation_criteria_id == null || $rowdata->evaluation_criteria_id == ''){
        //             $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[13])->where('form_year_use_start', $checkYear)->first();
        //             $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //             foreach ($row_group_form_topic as $key2 => $val2) {
        //                 $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //                 $evaluation_criteria_id_comma .= ',';
        //             }
        //             $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //         }
        //     }
        //     DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //         "form_import" => $row[13],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => ($countEmployeeEvaluator?$countEmployeeEvaluator->employee_no:NULL),
        //         "evaluator_name_en" => $row[14],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[10],
        //         "adjust_grade_old2" => $row[11],
        //         "adjust_grade_old3" => $row[12],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:$rowdata->evaluation_criteria_id),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "status_pa" => '3',
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }

        ////////// Case 6 2023-Evaluator checklist orange ผู้ประเมิน.xls //////////
        // $count = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))->count();
        // if($count == 0){
        //     $rowPosition = Position::where('position_description',$row[4])->first();
        //     $Emp = EmployeeEvaluator::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[0]),
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[1],
        //         "employee_name_en" => $row[2],
        //         "grade_code" => $row[3],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[4],
        //         "division_code" => $row[5],
        //         "group_description" => $row[6],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no', sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }else{
        //     $rowPosition = Position::where('position_description',$row[4])->first();
        //     $rowdata = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->orderBy('id','desc')
        //     ->first();
        //     DB::table('tb_employee_evaluator')->where('id', $rowdata->id )->update([
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[1],
        //         "employee_name_en" => $row[2],
        //         "grade_code" => $row[3],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[4],
        //         "division_code" => $row[5],
        //         "group_description" => $row[6],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no',  sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }

        ////////// Case 7 2023-Evaluator checklist orange ผู้ถูกประเมิน.xls //////////
        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
        // if($countEmployeeModel == 0){
        //     $rowGrade = Grademaster::where('grade_code',$row[13])->first();
        //     $rowDivision = Division::where('division_code',$row[5])->first();
        //     $rowDepartment = Department::where('department_code',$row[7])->first();
        //     $rowSection = Section::where('section_code',$row[9])->first();
        //     $rowPosition = Position::where('position_code',$row[3])->first();

        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "orisoft_no" => sprintf("%06d", $row[0]),
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "grade_code" => ($rowGrade?$rowGrade->grade_code:null),
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "division_code" => ($rowDivision?$rowDivision->division_code:null),
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => ($rowDepartment?$rowDepartment->department_code:null),
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => ($rowSection?$rowSection->section_code:null),
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => ($rowPosition?$rowPosition->position_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
        //         "service_days" => $row[17],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     $rowGrade = Grademaster::where('grade_code',$row[13])->first();
        //     $rowDivision = Division::where('division_code',$row[5])->first();
        //     $rowDepartment = Department::where('department_code',$row[7])->first();
        //     $rowSection = Section::where('section_code',$row[9])->first();
        //     $rowPosition = Position::where('position_code',$row[3])->first();

        //     DB::table('tb_employee')->where('orisoft_no', sprintf("%06d", $row[0]) )->update([
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "grade_code" => ($rowGrade?$rowGrade->grade_code:null),
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "division_code" => ($rowDivision?$rowDivision->division_code:null),
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => ($rowDepartment?$rowDepartment->department_code:null),
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => ($rowSection?$rowSection->section_code:null),
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => ($rowPosition?$rowPosition->position_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
        //         "service_days" => $row[17],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // $count = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))->count();
        // if($count == 0){
        //     $rowEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en',$row[10])->first();
        //     $Emp = EmployeeEvaluator::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[0]),
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[24],
        //         "employee_name_en" => $row[23],
        //         "approve_pa_score_by" => ($rowEmployeeEvaluator?$rowEmployeeEvaluator->employee_no:NULL),
        //         "approve_name_en" => ($rowEmployeeEvaluator?$rowEmployeeEvaluator->employee_name_en:NULL),
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no', sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }else{
        //     $rowdata = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->orderBy('id','desc')
        //     ->first();
        //     $rowEmployeeEvaluatorx = EmployeeEvaluator::where('employee_name_en',$row[10])->first();
        //     DB::table('tb_employee_evaluator')->where('id', $rowdata->id )->update([
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[24],
        //         "employee_name_en" => $row[23],
        //         "approve_pa_score_by" => ($rowEmployeeEvaluatorx?$rowEmployeeEvaluatorx->employee_no:NULL),
        //         "approve_name_en" => ($rowEmployeeEvaluatorx?$rowEmployeeEvaluatorx->employee_name_en:NULL),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no', sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }
        // if($row[7]){
        //     DB::table('tb_employee_final_score')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //     ->where('tb_employee.department_code',$row[7])
        //     ->where('tb_employee_final_score.status_pa','0')
        //     ->update([
        //         "status_pa" => '1'
        //     ]);
        // }

        // $countx = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[0]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // $countformEvaluate = formEvaluate::where('form_ref',$row[19])->where('form_year_use_start',$checkYear)->count();
        // if($countformEvaluate == 0){
        //     $group_form_id = 0;
        // }else{
        //     $rowformEvaluate = formEvaluate::where('form_ref',$row[19])->where('form_year_use_start',$checkYear)->first();
        //     $group_form_id = $rowformEvaluate->id;
        // }
        // if($countx == 0){
        //     $Emp = EmployeeFinalScore::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[0]),
        //         "service_days" => $row[17],
        //         "previous_form" => $row[18],
        //         "form_import" => $row[19],
        //         "group_form_id" => $group_form_id,
        //         "previous_evaluator_no" => ($row[20]?sprintf("%06d", $row[20]):NULL),
        //         "evaluator_no" => sprintf("%06d", $row[21]),
        //         "evaluator_name_th" => $row[24],
        //         "evaluator_name_en" => $row[23],
        //         "dept_manager_approve_score" => $row[10],
        //         "dmgm_approve_salary" => $row[11],
        //         "created_by" => Auth::user()->id,
        //         "created_at" => date('Y-m-d H:i:s'),
        //     ]);
        // }else{
        //     $rowdatax = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     DB::table('tb_employee_final_score')->where('id', $rowdatax->id )->update([
        //         "service_days" => $row[17],
        //         "previous_form" => $row[18],
        //         "form_import" => $row[19],
        //         "group_form_id" => $group_form_id,
        //         "previous_evaluator_no" => ($row[20]?sprintf("%06d", $row[20]):NULL),
        //         "evaluator_no" => sprintf("%06d", $row[21]),
        //         "evaluator_name_th" => $row[24],
        //         "evaluator_name_en" => $row[23],
        //         "dept_manager_approve_score" => $row[10],
        //         "dmgm_approve_salary" => $row[11],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        ////////// Case 7 2023-Evaluator checklist orange ผู้ถูกประเมิน.xlsx อัพเฉพาะ ข้อประเมิน //////////
        ////////// $row[13] Monthly
        ////////// $row[15] Daily
        // $countx = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[6]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // if($countx == 0){

        // }else{
        //     $rowdatax = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[6]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[15]){
        //         $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[15])->where('form_year_use_start', $checkYear)->first();
        //         $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //         foreach ($row_group_form_topic as $key2 => $val2) {
        //             $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //             $evaluation_criteria_id_comma .= ',';
        //         }
        //         $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //     }
        //     DB::table('tb_employee_final_score')->where('id', $rowdatax->id )->update([
        //         "evaluation_criteria_id" => $evaluation_criteria_id,
        //         "criteria_score_old" => $evaluation_criteria_id_comma,
        //         "criteria_score_new" => $evaluation_criteria_id_comma,
        //     ]);
        // }



















        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
        // if($countEmployeeModel == 0){
        //     $rowPosition = Position::where('position_description',$row[3])->first();
        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "users_id" => $user->id,
        //         "orisoft_no" => sprintf("%06d", $row[0]),
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[3],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     $rowPosition = Position::where('position_description',$row[3])->first();
        //     DB::table('tb_employee')->where('orisoft_no', sprintf("%06d", $row[0]) )->update([
        //         "users_id" => $user->id,
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[3],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // echo json_encode($data);




    }

    public function model(array $row)
    {

        // if (!isset($row[0])) {
        //     return null;
        // }
        if ($row[0] == 'Set %Increase by Dept.') {
            return null;
        }
        if ($row[0] == 'Division Name') {
            return null;
        }
        // ini_set('max_execution_time',180);
        // ini_set('memory_limit', '1024M');

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Ym');
            $checkYear = date('Y');
        // }

        // dd($row);
        // exit;

        $data = DB::table('tb_percent_department')->where('year', $checkYear)->count();
        if($data == 0){
            $CreatePercentDepartment = PercentDepartment::create([
                "title" => '% Department Year '.$checkYear,
                "year" => $checkYear,
                "date" => date('Y-m-d'),
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created" => date('Y-m-d H:i:s'),
                "updated" => null,
            ]);
        }else{

        }

        $tb_percent_department = DB::table('tb_percent_department')->where('year', $checkYear)->first();

        $checka1 = strpos($row[8],' ');
        if($checka1 > 0){
            if(trans(request()->segment(1)) == 'manager'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else{
                    $employee_name_en = explode(' ',$row[8]);
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->count();
                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->first();
                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $tb_users = DB::table('users')->where('name', 'like',''.$employee_name_en[0].'%')->count();
                        if($tb_users > 0){
                            $tb_usersx = DB::table('users')->where('name', 'like',''.$employee_name_en[0].'%')->first();
                            $approve_by1 = $tb_usersx->orisoft_code;
                        }else{
                            $approve_by1 = NULL;
                        }
                    }
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else if($row[8] == "joseph" || $row[8] == "Joseph"){
                    $approve_by1 = '000002';
                }else{
                    $employee_name_en = explode(' ',$row[8]);
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$employee_name_en[0].'%')->count();
                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$employee_name_en[0].'%')->first();
                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $tb_users = DB::table('users')->where('name', 'like',''.$employee_name_en[0].'%')->count();
                        if($tb_users > 0){
                            $tb_usersx = DB::table('users')->where('name', 'like',''.$employee_name_en[0].'%')->first();
                            $approve_by1 = $tb_usersx->orisoft_code;
                        }else{
                            $approve_by1 = NULL;
                        }
                    }
                }
            }else{
                $employee_name_en = explode(' ',$row[8]);
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->count();
                if($tb_employee_evaluator > 0){
                    $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$employee_name_en[0].'%')->first();
                    $approve_by1 = $tb_employee_evaluatorx->employee_no;
                }else{
                    $tb_users = DB::table('users')->where('name', 'like',''.$employee_name_en[0].'%')->count();
                    if($tb_users > 0){
                        $tb_usersx = DB::table('users')->where('name', 'like',''.$employee_name_en[0].'%')->first();
                        $approve_by1 = $tb_usersx->orisoft_code;
                    }else{
                        $approve_by1 = NULL;
                    }
                }
            }

            // echo $approve_by1."___";
        }else{
            if(trans(request()->segment(1)) == 'manager'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else{
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$row[8].'%')->count();
                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like','%'.$row[8].'%')->first();
                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $tb_users = DB::table('users')->where('name', 'like',''.$row[8].'%')->count();
                        if($tb_users > 0){
                            $tb_usersx = DB::table('users')->where('name', 'like',''.$row[8].'%')->first();
                            $approve_by1 = $tb_usersx->orisoft_code;
                        }else{
                            $approve_by1 = NULL;
                        }
                    }
                }
            }else if(trans(request()->segment(1)) == 'mtl'){
                if($row[8] == "SIU KAI KWOK" || $row[8] == "KSK"){
                    $approve_by1 = '000023';
                }else if($row[8] == "joseph" || $row[8] == "Joseph"){
                    $approve_by1 = '000002';
                }else{
                    $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->count();

                    if($tb_employee_evaluator > 0){
                        $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->first();

                        $approve_by1 = $tb_employee_evaluatorx->employee_no;
                    }else{
                        $tb_users = DB::table('users')->where('name', 'like',''.$row[8].'%')->count();
                        if($tb_users > 0){
                            $tb_usersx = DB::table('users')->where('name', 'like',''.$row[8].'%')->first();
                            $approve_by1 = $tb_usersx->orisoft_code;
                        }else{
                            $approve_by1 = NULL;
                        }
                    }
                }
            }else{
                $tb_employee_evaluator = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->count();
                if($tb_employee_evaluator > 0){
                    $tb_employee_evaluatorx = DB::table('tb_employee_evaluator')->where('employee_name_en', 'like',''.$row[8].'%')->first();
                    $approve_by1 = $tb_employee_evaluatorx->employee_no;
                }else{
                    $tb_users = DB::table('users')->where('name', 'like',''.$row[8].'%')->count();
                    if($tb_users > 0){
                        $tb_usersx = DB::table('users')->where('name', 'like',''.$row[8].'%')->first();
                        $approve_by1 = $tb_usersx->orisoft_code;
                    }else{
                        $approve_by1 = NULL;
                    }
                }
            }

            // echo $approve_by1."___";
        }
        // echo $approve_by1."___";
        // dd($approve_by1);
        // exit;

        if(trans(request()->segment(1)) == 'manager'){
            if($row[9] == "Joseph" || $row[9] == "joseph"){
                $approve_by2 = "000002";
            }else{
                $approve_by2 = "000042";
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($row[9] == "Joseph" || $row[9] == "joseph"){
                $approve_by2 = "000002";
            }else{
                $approve_by2 = "000002";
            }
        }else{
            if($row[9] == "Komkrit"){
                $approve_by2 = "000026";
            }else if($row[9] == "Tanawat"){
                $approve_by2 = "013591";
            }else{
                $approve_by2 = "000002";
            }
        }
        $approve_by3 = null;
        if(trans(request()->segment(1)) == 'manager'){
            if($row[10] == "Joseph" || $row[10] == "joseph"){
                $approve_by3 = "000002";
            }else{
                $approve_by3 = "000042";
            }
        }else if(trans(request()->segment(1)) == 'mtl'){
            if($row[10] == "Joseph" || $row[10] == "joseph"){
                $approve_by3 = "000002";
            }else{
                $approve_by3 = "000002";
            }
        }else{
            if($row[10] != "-"){
                if($row[10] == "Komkrit"){
                    $approve_by3 = "000026";
                }else if($row[10] == "Joseph" || $row[10] == "joseph"){
                    $approve_by3 = "000002";
                }
            }
        }

        $division_code = "\''.$row[2].'\'";
        $department_code = "\''.$row[3].'\'";
        $section_code = "\''.$row[4].'\'";

        $data2 = DB::table('tb_percent_department_action')
        ->where('percent_department_id', $tb_percent_department->id)
        ->where('division_code', 'like','%'.$row[2].'%')
        ->where('department_code', 'like','%'.$row[3].'%')
        ->where('section_code', 'like','%'.$row[4].'%')
        ->count();
        // echo $row[3]."___";
        // echo "<pre>";
        // print_r($data2);
        // dd($data2);
        // exit;
        if($data2 == 0){
            if($row[2]){
                $PercentDepartmentAction = PercentDepartmentAction::create([
                    "percent_department_id" => $tb_percent_department->id,
                    "division_code" => $row[2],
                    "department_code" => $row[3],
                    "section_code" => $row[4],
                    "percent_daily" => ($row[6]*100),
                    "percent_monthly" => ($row[7]*100),
                    "approve_by1" => $approve_by1,
                    "approve_by2" => $approve_by2,
                    "approve_by3" => $approve_by3,
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
        }else{
            if($row[2]){
                DB::table('tb_percent_department_action')
                ->where('percent_department_id', $tb_percent_department->id)
                ->where('division_code', 'like','%'.$row[2].'%')
                ->where('department_code', 'like','%'.$row[3].'%')
                ->where('section_code', 'like','%'.$row[4].'%')
                ->update([
                    "percent_daily" => ($row[6]*100),
                    "percent_monthly" => ($row[7]*100),
                    "approve_by1" => $approve_by1,
                    "approve_by2" => $approve_by2,
                    "approve_by3" => $approve_by3,
                ]);
            }
        }
        // dd($data2);
        // exit;















        ////////// Case 1 //////////
        // $countUser = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
        // if($countUser == 0){
        //     $data = ['name' => $row[1]];
        //     $data['orisoft_code'] = $row[0];
        //     $data['profile_photo_path'] = NULL;
        //     $data['password'] = Hash::make($row[0].'@e-pa.com');
        //     $user = Users::updateOrCreate(['email' => $row[0].'@e-pa.com'], $data);

        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
        //     if($countEmployeeEvaluator == 0){
        //         $CreateEmployeeEvaluator = EmployeeEvaluator::create([
        //             "rec_year" => $checkYear,
        //             "employee_no" => sprintf("%06d", $row[0]),
        //             "employee_name_th" => $row[2],
        //             "employee_name_en" => $row[1],
        //             "evaluator_active" => '1',
        //             "created_by" => Auth::user()->id,
        //             "updated_by" => '0',
        //             "created_at" => date('Y-m-d H:i:s'),
        //             "updated_at" => null,
        //         ]);
        //     }
        // }else{
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
        //     if($countEmployeeEvaluator == 0){
        //         $CreateEmployeeEvaluator = EmployeeEvaluator::create([
        //             "rec_year" => $checkYear,
        //             "employee_no" => sprintf("%06d", $row[0]),
        //             "employee_name_th" => $row[2],
        //             "employee_name_en" => $row[1],
        //             "evaluator_active" => '1',
        //             "created_by" => Auth::user()->id,
        //             "updated_by" => '0',
        //             "created_at" => date('Y-m-d H:i:s'),
        //             "updated_at" => null,
        //         ]);
        //     }
        // }

        ////////// Case 2 update email //////////
        // $countUser = Users::where('orisoft_code', sprintf("%06d", $row[0]))->count();
        // if($countUser != 0){
        //     DB::table('users')->where('orisoft_code', sprintf("%06d", $row[0]) )->update([
        //         "email" => $row[4]
        //     ]);
        // }

        ////////// Case 3 update position_code ของ ผู้ประเมิน //////////
        // $countEmployeeEvaluator = EmployeeEvaluator::where('employee_no', sprintf("%06d", $row[0]))->count();
        // if($countEmployeeEvaluator != 0){
        //     $rowPosition = Position::where('position_description',$row[3])->first();
        //     DB::table('tb_employee_evaluator')->where('employee_no', sprintf("%06d", $row[0]) )->update([
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[3],
        //     ]);
        // }

        ////////// Case 4 2023 Annual Increment L800 //////////
        // $countPosition = Position::where('position_description', $row[8])->count();
        // if($countPosition == 0){
        //     $CreatePosition = Position::create([
        //         "position_description" => $row[8],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDivision = Division::where('division_code', $row[0])->count();
        // if($countDivision == 0){
        //     $CreateDivision = Division::create([
        //         "division_code" => $row[0],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDepartment = Department::where('department_code', $row[1])->count();
        // if($countDepartment == 0){
        //     $CreateDepartment = Department::create([
        //         "department_code" => $row[1],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countSection = Section::where('section_code', $row[2])->count();
        // if($countSection == 0){
        //     $CreateSection = Section::create([
        //         "section_code" => $row[2],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countGrademaster = Grademaster::where('grade_code', $row[4])->count();
        // if($countGrademaster == 0){
        //     $CreateGrademaster = Grademaster::create([
        //         "grade_code" => $row[4],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }

        // $rowDivision = Division::where('division_code',$row[0])->first();
        // $rowDepartment = Department::where('department_code',$row[1])->first();
        // $rowSection = Section::where('section_code',$row[2])->first();
        // $rowGrade = Grademaster::where('grade_code',$row[4])->first();
        // $rowPosition = Position::where('position_description',$row[8])->first();

        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[6]))->count();
        // if($countEmployeeModel == 0){
        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "orisoft_no" => sprintf("%06d", $row[6]),
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     DB::table('tb_employee')
        //     ->where('orisoft_no', sprintf("%06d", $row[6]) )
        //     ->update([
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // $countformEvaluate = formEvaluate::where('form_ref',$row[15])->where('form_year_use_start',$checkYear)->count();
        // if($countformEvaluate == 0){
        //     $group_form_id = 0;
        // }else{
        //     $rowformEvaluate = formEvaluate::where('form_ref',$row[15])->where('form_year_use_start',$checkYear)->first();
        //     $group_form_id = $rowformEvaluate->id;
        // }
        // $count = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[6]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // if($count == 0){
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[16])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[15]){
        //         $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[15])->where('form_year_use_start', $checkYear)->first();
        //         $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //         foreach ($row_group_form_topic as $key2 => $val2) {
        //             $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //             $evaluation_criteria_id_comma .= ',';
        //         }
        //         $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //     }
        //     $Emp = EmployeeFinalScore::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[6]),
        //         "form_import" => $row[15],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => $countEmployeeEvaluator->employee_no,
        //         "evaluator_name_en" => $row[16],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[12],
        //         "adjust_grade_old2" => $row[13],
        //         "adjust_grade_old3" => $row[14],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:NULL),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "status_pa" => '3',
        //         "created_by" => Auth::user()->id,
        //         "created_at" => date('Y-m-d H:i:s'),
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }else{
        //     $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[6]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[16])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[15]){
        //         if($rowdata->evaluation_criteria_id == null || $rowdata->evaluation_criteria_id == ''){
        //             $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[15])->where('form_year_use_start', $checkYear)->first();
        //             $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //             foreach ($row_group_form_topic as $key2 => $val2) {
        //                 $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //                 $evaluation_criteria_id_comma .= ',';
        //             }
        //             $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //         }
        //     }
        //     DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //         "form_import" => $row[15],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => $countEmployeeEvaluator->employee_no,
        //         "evaluator_name_en" => $row[16],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[12],
        //         "adjust_grade_old2" => $row[13],
        //         "adjust_grade_old3" => $row[14],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:$rowdata->evaluation_criteria_id),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "status_pa" => '3',
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }

        ////////// Case 5 2023 Annual Increment L600-700 //////////
        // $countPosition = Position::where('position_description', $row[8])->count();
        // if($countPosition == 0){
        //     $CreatePosition = Position::create([
        //         "position_description" => $row[8],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDivision = Division::where('division_code', $row[0])->count();
        // if($countDivision == 0){
        //     $CreateDivision = Division::create([
        //         "division_code" => $row[0],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countDepartment = Department::where('department_code', $row[1])->count();
        // if($countDepartment == 0){
        //     $CreateDepartment = Department::create([
        //         "department_code" => $row[1],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countSection = Section::where('section_code', $row[2])->count();
        // if($countSection == 0){
        //     $CreateSection = Section::create([
        //         "section_code" => $row[2],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }
        // $countGrademaster = Grademaster::where('grade_code', $row[4])->count();
        // if($countGrademaster == 0){
        //     $CreateGrademaster = Grademaster::create([
        //         "grade_code" => $row[4],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created" => date('Y-m-d H:i:s'),
        //         "updated" => null,
        //     ]);
        // }

        // $rowDivision = Division::where('division_code',$row[0])->first();
        // $rowDepartment = Department::where('department_code',$row[1])->first();
        // $rowSection = Section::where('section_code',$row[2])->first();
        // $rowGrade = Grademaster::where('grade_code',$row[4])->first();
        // $rowPosition = Position::where('position_description',$row[8])->first();

        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[6]))->count();
        // if($countEmployeeModel == 0){
        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "orisoft_no" => sprintf("%06d", $row[6]),
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     DB::table('tb_employee')
        //     ->where('orisoft_no', sprintf("%06d", $row[6]) )
        //     ->update([
        //         "employee_local_name_en" => $row[7],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[8],
        //         "division_code" => $row[0],
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => $row[1],
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => $row[2],
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "grade_code" => $row[4],
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // $countformEvaluate = formEvaluate::where('form_ref',$row[13])->where('form_year_use_start',$checkYear)->count();
        // if($countformEvaluate == 0){
        //     $group_form_id = 0;
        // }else{
        //     $rowformEvaluate = formEvaluate::where('form_ref',$row[13])->where('form_year_use_start',$checkYear)->first();
        //     $group_form_id = $rowformEvaluate->id;
        // }
        // $count = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[6]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // if($count == 0){
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[14])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[13]){
        //         $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[13])->where('form_year_use_start', $checkYear)->first();
        //         $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //         foreach ($row_group_form_topic as $key2 => $val2) {
        //             $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //             $evaluation_criteria_id_comma .= ',';
        //         }
        //         $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //     }
        //     $Emp = EmployeeFinalScore::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[6]),
        //         "form_import" => $row[13],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => ($countEmployeeEvaluator?$countEmployeeEvaluator->employee_no:NULL),
        //         "evaluator_name_en" => $row[14],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[10],
        //         "adjust_grade_old2" => $row[11],
        //         "adjust_grade_old3" => $row[12],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:NULL),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:NULL),
        //         "status_pa" => '3',
        //         "created_by" => Auth::user()->id,
        //         "created_at" => date('Y-m-d H:i:s'),
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }else{
        //     $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[6]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     $countEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en', $row[14])->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[13]){
        //         if($rowdata->evaluation_criteria_id == null || $rowdata->evaluation_criteria_id == ''){
        //             $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[13])->where('form_year_use_start', $checkYear)->first();
        //             $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //             foreach ($row_group_form_topic as $key2 => $val2) {
        //                 $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //                 $evaluation_criteria_id_comma .= ',';
        //             }
        //             $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //         }
        //     }
        //     DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //         "form_import" => $row[13],
        //         "group_form_id" => $group_form_id,
        //         "evaluator_no" => ($countEmployeeEvaluator?$countEmployeeEvaluator->employee_no:NULL),
        //         "evaluator_name_en" => $row[14],
        //         "salary_type" => $row[3],
        //         "adjust_grade_old1" => $row[10],
        //         "adjust_grade_old2" => $row[11],
        //         "adjust_grade_old3" => $row[12],
        //         "evaluation_criteria_id" => ($evaluation_criteria_id!=""?$evaluation_criteria_id:$rowdata->evaluation_criteria_id),
        //         "criteria_score_old" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "criteria_score_new" => ($evaluation_criteria_id_comma!=""?$evaluation_criteria_id_comma:$rowdata->evaluation_criteria_id_comma),
        //         "status_pa" => '3',
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     if($row[1]){
        //         DB::table('tb_employee_final_score')
        //         ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //         ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //         ->where('tb_employee.department_code',$row[1])
        //         ->where('tb_employee_final_score.status_pa','0')
        //         ->update([
        //             "status_pa" => '1'
        //         ]);
        //     }
        // }

        ////////// Case 6 2023-Evaluator checklist orange ผู้ประเมิน.xls //////////
        // $count = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))->count();
        // if($count == 0){
        //     $rowPosition = Position::where('position_description',$row[4])->first();
        //     $Emp = EmployeeEvaluator::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[0]),
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[1],
        //         "employee_name_en" => $row[2],
        //         "grade_code" => $row[3],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[4],
        //         "division_code" => $row[5],
        //         "group_description" => $row[6],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no', sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }else{
        //     $rowPosition = Position::where('position_description',$row[4])->first();
        //     $rowdata = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->orderBy('id','desc')
        //     ->first();
        //     DB::table('tb_employee_evaluator')->where('id', $rowdata->id )->update([
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[1],
        //         "employee_name_en" => $row[2],
        //         "grade_code" => $row[3],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[4],
        //         "division_code" => $row[5],
        //         "group_description" => $row[6],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no',  sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }

        ////////// Case 7 2023-Evaluator checklist orange ผู้ถูกประเมิน.xls //////////
        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
        // if($countEmployeeModel == 0){
        //     $rowGrade = Grademaster::where('grade_code',$row[13])->first();
        //     $rowDivision = Division::where('division_code',$row[5])->first();
        //     $rowDepartment = Department::where('department_code',$row[7])->first();
        //     $rowSection = Section::where('section_code',$row[9])->first();
        //     $rowPosition = Position::where('position_code',$row[3])->first();

        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "orisoft_no" => sprintf("%06d", $row[0]),
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "grade_code" => ($rowGrade?$rowGrade->grade_code:null),
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "division_code" => ($rowDivision?$rowDivision->division_code:null),
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => ($rowDepartment?$rowDepartment->department_code:null),
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => ($rowSection?$rowSection->section_code:null),
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => ($rowPosition?$rowPosition->position_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
        //         "service_days" => $row[17],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     $rowGrade = Grademaster::where('grade_code',$row[13])->first();
        //     $rowDivision = Division::where('division_code',$row[5])->first();
        //     $rowDepartment = Department::where('department_code',$row[7])->first();
        //     $rowSection = Section::where('section_code',$row[9])->first();
        //     $rowPosition = Position::where('position_code',$row[3])->first();

        //     DB::table('tb_employee')->where('orisoft_no', sprintf("%06d", $row[0]) )->update([
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "grade_code" => ($rowGrade?$rowGrade->grade_code:null),
        //         "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //         "division_code" => ($rowDivision?$rowDivision->division_code:null),
        //         "division_description" => ($rowDivision?$rowDivision->division_description:null),
        //         "department_code" => ($rowDepartment?$rowDepartment->department_code:null),
        //         "department_description" => ($rowDepartment?$rowDepartment->department_description:null),
        //         "section_code" => ($rowSection?$rowSection->section_code:null),
        //         "section_description" => ($rowSection?$rowSection->section_description:null),
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => ($rowPosition?$rowPosition->position_description:null),
        //         "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
        //         "service_days" => $row[17],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // $count = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))->count();
        // if($count == 0){
        //     $rowEmployeeEvaluator = EmployeeEvaluator::where('employee_name_en',$row[10])->first();
        //     $Emp = EmployeeEvaluator::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[0]),
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[24],
        //         "employee_name_en" => $row[23],
        //         "approve_pa_score_by" => ($rowEmployeeEvaluator?$rowEmployeeEvaluator->employee_no:NULL),
        //         "approve_name_en" => ($rowEmployeeEvaluator?$rowEmployeeEvaluator->employee_name_en:NULL),
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no', sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }else{
        //     $rowdata = EmployeeEvaluator::where('employee_no',sprintf("%06d", $row[0]))
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->orderBy('id','desc')
        //     ->first();
        //     $rowEmployeeEvaluatorx = EmployeeEvaluator::where('employee_name_en',$row[10])->first();
        //     DB::table('tb_employee_evaluator')->where('id', $rowdata->id )->update([
        //         "evaluator_active" => '1',
        //         "employee_name_th" => $row[24],
        //         "employee_name_en" => $row[23],
        //         "approve_pa_score_by" => ($rowEmployeeEvaluatorx?$rowEmployeeEvaluatorx->employee_no:NULL),
        //         "approve_name_en" => ($rowEmployeeEvaluatorx?$rowEmployeeEvaluatorx->employee_name_en:NULL),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        //     DB::table('tb_employee_final_score')
        //     ->where('rec_year','like','%'.$checkYear.'%')
        //     ->where('employee_no', sprintf("%06d", $row[0]) )
        //     ->update([
        //         "evaluator_active" => '1',
        //     ]);
        // }
        // if($row[7]){
        //     DB::table('tb_employee_final_score')
        //     ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
        //     ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
        //     ->where('tb_employee.department_code',$row[7])
        //     ->where('tb_employee_final_score.status_pa','0')
        //     ->update([
        //         "status_pa" => '1'
        //     ]);
        // }

        // $countx = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[0]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // $countformEvaluate = formEvaluate::where('form_ref',$row[19])->where('form_year_use_start',$checkYear)->count();
        // if($countformEvaluate == 0){
        //     $group_form_id = 0;
        // }else{
        //     $rowformEvaluate = formEvaluate::where('form_ref',$row[19])->where('form_year_use_start',$checkYear)->first();
        //     $group_form_id = $rowformEvaluate->id;
        // }
        // if($countx == 0){
        //     $Emp = EmployeeFinalScore::create([
        //         "rec_year" => $checkYear,
        //         "employee_no" => sprintf("%06d", $row[0]),
        //         "service_days" => $row[17],
        //         "previous_form" => $row[18],
        //         "form_import" => $row[19],
        //         "group_form_id" => $group_form_id,
        //         "previous_evaluator_no" => ($row[20]?sprintf("%06d", $row[20]):NULL),
        //         "evaluator_no" => sprintf("%06d", $row[21]),
        //         "evaluator_name_th" => $row[24],
        //         "evaluator_name_en" => $row[23],
        //         "dept_manager_approve_score" => $row[10],
        //         "dmgm_approve_salary" => $row[11],
        //         "created_by" => Auth::user()->id,
        //         "created_at" => date('Y-m-d H:i:s'),
        //     ]);
        // }else{
        //     $rowdatax = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     DB::table('tb_employee_final_score')->where('id', $rowdatax->id )->update([
        //         "service_days" => $row[17],
        //         "previous_form" => $row[18],
        //         "form_import" => $row[19],
        //         "group_form_id" => $group_form_id,
        //         "previous_evaluator_no" => ($row[20]?sprintf("%06d", $row[20]):NULL),
        //         "evaluator_no" => sprintf("%06d", $row[21]),
        //         "evaluator_name_th" => $row[24],
        //         "evaluator_name_en" => $row[23],
        //         "dept_manager_approve_score" => $row[10],
        //         "dmgm_approve_salary" => $row[11],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        ////////// Case 7 2023-Evaluator checklist orange ผู้ถูกประเมิน.xlsx อัพเฉพาะ ข้อประเมิน //////////
        ////////// $row[13] Monthly
        ////////// $row[15] Daily
        // $countx = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[6]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->count();
        // if($countx == 0){

        // }else{
        //     $rowdatax = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[6]))
        //             ->where('rec_year','like','%'.$checkYear.'%')
        //             ->orderBy('id','desc')
        //             ->first();
        //     $evaluation_criteria_id = '';
        //     $evaluation_criteria_id_comma = '';
        //     if($row[15]){
        //         $rowx = DB::table('group_form')->select('id')->where('form_ref', $row[15])->where('form_year_use_start', $checkYear)->first();
        //         $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $rowx->id)->get();
        //         foreach ($row_group_form_topic as $key2 => $val2) {
        //             $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
        //             $evaluation_criteria_id_comma .= ',';
        //         }
        //         $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
        //     }
        //     DB::table('tb_employee_final_score')->where('id', $rowdatax->id )->update([
        //         "evaluation_criteria_id" => $evaluation_criteria_id,
        //         "criteria_score_old" => $evaluation_criteria_id_comma,
        //         "criteria_score_new" => $evaluation_criteria_id_comma,
        //     ]);
        // }



















        // $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
        // if($countEmployeeModel == 0){
        //     $rowPosition = Position::where('position_description',$row[3])->first();
        //     $CreateEmployeeModel = EmployeeModel::create([
        //         "users_id" => $user->id,
        //         "orisoft_no" => sprintf("%06d", $row[0]),
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[3],
        //         "created_by" => Auth::user()->id,
        //         "updated_by" => '0',
        //         "created_at" => date('Y-m-d H:i:s'),
        //         "updated_at" => null,
        //     ]);
        // }else{
        //     $rowPosition = Position::where('position_description',$row[3])->first();
        //     DB::table('tb_employee')->where('orisoft_no', sprintf("%06d", $row[0]) )->update([
        //         "users_id" => $user->id,
        //         "employee_local_name_th" => $row[2],
        //         "employee_local_name_en" => $row[1],
        //         "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //         "position_description" => $row[3],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => Auth::user()->id,
        //     ]);
        // }

        // echo json_encode($data);




    }
}
