<?php

namespace App\Imports;
use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\EmployeeModel;
use App\Models\EmployeeFinalScore;
use App\Models\group\Division;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Grademaster;
use App\Models\group\Department;
use App\Models\formEvaluate\formEvaluate;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImportFileEmployeeAttendance implements ToModel
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
        // dd(trans(request()->segment(1)));

        if (!isset($row[2])) {
            return null;
        }
        if ($row[0] == 'EMPLOYEE_NO' || $row[0] == 'No.') {
            return null;
        }
        // dd($row);
        // exit;


        // dd($datejoin);
        // exit;
        // ini_set('max_execution_time',180);
        // ini_set('memory_limit', '1024M');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
            $checkYear = date('Y');
        // }

        if(trans(request()->segment(1)) == 'mtl'){
            $Emp = AttendanceLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => $row[1],
                "title_th" => $row[2],
                "EMPLOYEE_NAME" => $row[3],
                "EMPLOYEE_LOCAL_NAME" => $row[4],
                "POSITION_CODE" => $row[5],
                "POSITION_DESCRIPTION" => $row[6],
                "DIVISION_CODE" => $row[7],
                "DIVISION_DESCRIPTION" => $row[8],
                "DEPARTMENT_CODE" => $row[9],
                "DEPARTMENT_DESCRIPTION" => $row[10],
                "SECTION_CODE" => $row[11],
                "SECTION_DESCRIPTION" => $row[12],
                "GRADE_CODE" => $row[13],
                "GRADE_DESCRIPTION" => $row[14],
                "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "service_days" => $row[16],

                "attendance_sl" => $row[17],
                "attendance_pl" => $row[18],
                "attendance_late" => $row[19],
                "attendance_abs" => $row[20],
                "attendance_abt" => $row[21],
                "attendance_sus" => $row[22],
                "attendance_wwar" => $row[23],
                "attendance_vwar" => $row[24],
                "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);

            $countPosition = Position::where('position_code', $row[5])->count();
            if($countPosition == 0){
                $CreatePosition = Position::create([
                    "position_code" => $row[5],
                    "position_description" => $row[6],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDivision = Division::where('division_code', $row[7])->count();
            if($countDivision == 0){
                $CreateDivision = Division::create([
                    "division_code" => $row[7],
                    "division_description" => $row[8],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDepartment = Department::where('department_code', $row[9])->count();
            if($countDepartment == 0){
                $CreateDepartment = Department::create([
                    "department_code" => $row[9],
                    "department_description" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countSection = Section::where('section_code', $row[11])->count();
            if($countSection == 0){
                $CreateSection = Section::create([
                    "section_code" => $row[11],
                    "section_description" => $row[12],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countGrademaster = Grademaster::where('grade_code', $row[13])->count();
            if($countGrademaster == 0){
                $CreateGrademaster = Grademaster::create([
                    "grade_code" => $row[13],
                    "grade_description" => $row[14],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }

            $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
            if($countEmployeeModel == 0){
                $CreateEmployeeModel = EmployeeModel::create([
                    "orisoft_no" => sprintf("%06d", $row[0]),
                    "title_en" => $row[1],
                    "title_th" => $row[2],
                    "employee_local_name_en" => $row[3],
                    "employee_local_name_th" => $row[4],
                    "position_code" => $row[5],
                    "position_description" => $row[6],
                    "division_code" => $row[7],
                    "division_description" => $row[8],
                    "department_code" => $row[9],
                    "department_description" => $row[10],
                    "section_code" => $row[11],
                    "section_description" => $row[12],
                    "grade_code" => $row[13],
                    "grade_description" => $row[14],
                    "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                    "service_days" => $row[16],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
            }else{
                DB::table('tb_employee')
                ->where('orisoft_no', sprintf("%06d", $row[0]) )
                ->update([
                    "title_en" => $row[1],
                    "title_th" => $row[2],
                    "employee_local_name_en" => $row[3],
                    "employee_local_name_th" => $row[4],
                    "position_code" => $row[5],
                    "position_description" => $row[6],
                    "division_code" => $row[7],
                    "division_description" => $row[8],
                    "department_code" => $row[9],
                    "department_description" => $row[10],
                    "section_code" => $row[11],
                    "section_description" => $row[12],
                    "grade_code" => $row[13],
                    "grade_description" => $row[14],
                    "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                    "service_days" => $row[16],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
            }
            // $countformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->count();
            // if($countformEvaluate == 0){
            //     $group_form_id = 0;
            // }else{
            //     $rowformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->first();
            //     $group_form_id = $rowformEvaluate->id;
            // }
            $count = DB::table('tb_employee_final_score')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->where('rec_year','like','%'.$checkYear.'%')
                    ->count();
            if($count == 0){
                $Emp = EmployeeFinalScore::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "service_days" => $row[16],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => $row[17],
                    "attendance_pl" => $row[18],
                    "attendance_late" => $row[19],
                    "attendance_abs" => $row[20],
                    "attendance_abt" => $row[21],
                    "attendance_cl" => $row[22],
                    "attendance_ol" => $row[23],
                    "attendance_sus" => $row[24],
                    "attendance_wwar" => $row[25],
                    "attendance_vwar" => $row[26],
                    "compliance_score" => $row[23]+$row[24]+$row[25]+$row[26],
                    "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                    "created_by" => Auth::user()->id,
                    "created_at" => date('Y-m-d H:i:s'),
                ]);
                if($row[6]){
                    DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                    ->where('tb_employee.department_code',$row[9])
                    ->where('tb_employee_final_score.status_pa','0')
                    ->update([
                        "status_pa" => '1'
                    ]);
                }
            }else{
                $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
                        ->where('rec_year','like','%'.$checkYear.'%')
                        ->orderBy('id','desc')
                        ->first();
                DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
                    "import_id" => $this->id,
                    "service_days" => $row[16],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => $row[17],
                    "attendance_pl" => $row[18],
                    "attendance_late" => $row[19],
                    "attendance_abs" => $row[20],
                    "attendance_abt" => $row[21],
                    "attendance_cl" => $row[22],
                    "attendance_ol" => $row[23],
                    "attendance_sus" => $row[24],
                    "attendance_wwar" => $row[25],
                    "attendance_vwar" => $row[26],
                    "compliance_score" => $row[23]+$row[24]+$row[25]+$row[26],
                    "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
                if($row[6]){
                    DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                    ->where('tb_employee.department_code',$row[9])
                    ->where('tb_employee_final_score.status_pa','0')
                    ->update([
                        "status_pa" => '1'
                    ]);
                }
            }
        }else if(trans(request()->segment(1)) == 'manager'){
            $position_description = $row[4];
            $Emp = AttendanceLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "service_days" => $row[11],
                "attendance_sl" => $row[12],
                "attendance_pl" => $row[13],
                "attendance_late" => $row[14],
                "attendance_abs" => $row[15],
                "attendance_abt" => $row[16],
                "attendance_sus" => $row[19],
                "attendance_wwar" => $row[20],
                "attendance_vwar" => $row[21],
                "attendance_score" => $row[12]+$row[13]+$row[14]+$row[15],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);

            $countPosition = Position::where('position_description', $row[4])->count();
            if($countPosition == 0){
                $CreatePosition = Position::create([
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
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDepartment = Department::where('department_code', $row[6])->count();
            if($countDepartment == 0){
                $CreateDepartment = Department::create([
                    "department_code" => $row[6],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countSection = Section::where('section_code', $row[7])->count();
            if($countSection == 0){
                $CreateSection = Section::create([
                    "section_code" => $row[7],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countGrademaster = Grademaster::where('grade_code', $row[8])->count();
            if($countGrademaster == 0){
                $CreateGrademaster = Grademaster::create([
                    "grade_code" => $row[8],
                    "grade_description" => $row[9],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }

            $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
            if($countEmployeeModel == 0){
                $CreateEmployeeModel = EmployeeModel::create([
                    "orisoft_no" => sprintf("%06d", $row[0]),
                    "employee_local_name_en" => $row[2],
                    "employee_local_name_th" => $row[3],
                    // "position_code" => $row[4],
                    "position_description" => $row[4],
                    "division_code" => $row[5],
                    // "division_description" => $row[7],
                    "department_code" => $row[6],
                    // "department_description" => $row[9],
                    "section_code" => $row[7],
                    // "section_description" => $row[11],
                    "grade_code" => $row[8],
                    "grade_description" => $row[9],
                    "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
                    "service_days" => $row[11],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
            }else{
                DB::table('tb_employee')
                ->where('orisoft_no', sprintf("%06d", $row[0]) )
                ->update([
                    "employee_local_name_en" => $row[2],
                    "employee_local_name_th" => $row[3],
                    // "position_code" => $row[4],
                    "position_description" => $row[4],
                    "division_code" => $row[5],
                    // "division_description" => $row[7],
                    "department_code" => $row[6],
                    // "department_description" => $row[9],
                    "section_code" => $row[7],
                    // "section_description" => $row[11],
                    "grade_code" => $row[8],
                    "grade_description" => $row[9],
                    "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
                    "service_days" => $row[11],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);

                $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
                if($countEmployeeModel == 0){
                    $CreateEmployeeModel = EmployeeModel::create([
                        "orisoft_no" => sprintf("%06d", $row[0]),
                        "employee_local_name_en" => $row[2],
                        "employee_local_name_th" => $row[3],
                        // "position_code" => $row[4],
                        "position_description" => $row[4],
                        "division_code" => $row[5],
                        // "division_description" => $row[7],
                        "department_code" => $row[6],
                        // "department_description" => $row[9],
                        "section_code" => $row[7],
                        // "section_description" => $row[11],
                        "grade_code" => $row[8],
                        "grade_description" => $row[9],
                        "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
                        "service_days" => $row[11],
                        "created_by" => Auth::user()->id,
                        "updated_by" => '0',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => null,
                    ]);
                }else{
                    DB::table('tb_employee')
                    ->where('orisoft_no', sprintf("%06d", $row[0]) )
                    ->update([
                        "employee_local_name_en" => $row[2],
                        "employee_local_name_th" => $row[3],
                        // "position_code" => $row[4],
                        "position_description" => $row[4],
                        "division_code" => $row[5],
                        // "division_description" => $row[7],
                        "department_code" => $row[6],
                        // "department_description" => $row[9],
                        "section_code" => $row[7],
                        // "section_description" => $row[11],
                        "grade_code" => $row[8],
                        "grade_description" => $row[9],
                        "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
                        "service_days" => $row[11],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id,
                    ]);
                }

                // $countformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->count();
                // if($countformEvaluate == 0){
                //     $group_form_id = 0;
                // }else{
                //     $rowformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->first();
                //     $group_form_id = $rowformEvaluate->id;
                // }
                $count = DB::table('tb_employee_final_score')
                        ->where('employee_no', sprintf("%06d", $row[0]))
                        ->where('rec_year','like','%'.$checkYear.'%')
                        ->count();
                if($count == 0){
                    $Emp = EmployeeFinalScore::create([
                        "import_id" => $this->id,
                        "rec_year" => $checkYear,
                        "employee_no" => sprintf("%06d", $row[0]),
                        "service_days" => $row[11],
                        // "form_import" => $row[17],
                        // "group_form_id" => $group_form_id,
                        // "evaluator_no" => sprintf("%06d", $row[18]),
                        // "evaluator_name_th" => $row[20],
                        // "evaluator_name_en" => $row[19],
                        "attendance_sl" => $row[12],
                        "attendance_pl" => $row[13],
                        "attendance_late" => $row[14],
                        "attendance_abs" => $row[15],
                        "attendance_abt" => $row[16],
                        "attendance_sus" => $row[19],
                        "attendance_wwar" => $row[20],
                        "attendance_vwar" => $row[21],
                        "compliance_score" => $row[16]+$row[19]+$row[20]+$row[21],
                        "attendance_score" => $row[12]+$row[13]+$row[14]+$row[15],
                        "created_by" => Auth::user()->id,
                        "created_at" => date('Y-m-d H:i:s'),
                    ]);
                    if($row[6]){
                        DB::table('tb_employee_final_score')
                        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                        ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                        ->where('tb_employee.department_code',$row[6])
                        ->where('tb_employee_final_score.status_pa','0')
                        ->update([
                            "status_pa" => '1'
                        ]);
                    }
                }else{
                    $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
                            ->where('rec_year','like','%'.$checkYear.'%')
                            ->orderBy('id','desc')
                            ->first();
                    DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
                        "import_id" => $this->id,
                        "service_days" => $row[11],
                        // "form_import" => $row[17],
                        // "group_form_id" => $group_form_id,
                        // "evaluator_no" => sprintf("%06d", $row[18]),
                        // "evaluator_name_th" => $row[20],
                        // "evaluator_name_en" => $row[19],
                        "attendance_sl" => $row[12],
                        "attendance_pl" => $row[13],
                        "attendance_late" => $row[14],
                        "attendance_abs" => $row[15],
                        "attendance_abt" => $row[16],
                        "attendance_sus" => $row[19],
                        "attendance_wwar" => $row[20],
                        "attendance_vwar" => $row[21],
                        "compliance_score" => $row[16]+$row[19]+$row[20]+$row[21],
                        "attendance_score" => $row[12]+$row[13]+$row[14]+$row[15],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id,
                    ]);
                    if($row[6]){
                        DB::table('tb_employee_final_score')
                        ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                        ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                        ->where('tb_employee.department_code',$row[6])
                        ->where('tb_employee_final_score.status_pa','0')
                        ->update([
                            "status_pa" => '1'
                        ]);
                    }
                }
            }

            // $countformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->count();
            // if($countformEvaluate == 0){
            //     $group_form_id = 0;
            // }else{
            //     $rowformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->first();
            //     $group_form_id = $rowformEvaluate->id;
            // }
            $count = DB::table('tb_employee_final_score')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->where('rec_year','like','%'.$checkYear.'%')
                    ->count();
            if($count == 0){
                $Emp = EmployeeFinalScore::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "service_days" => $row[11],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => $row[12],
                    "attendance_pl" => $row[13],
                    "attendance_late" => $row[14],
                    "attendance_abs" => $row[15],
                    "attendance_abt" => $row[16],
                    "attendance_sus" => $row[19],
                    "attendance_wwar" => $row[20],
                    "attendance_vwar" => $row[21],
                    "compliance_score" => $row[16]+$row[19]+$row[20]+$row[21],
                    "attendance_score" => $row[12]+$row[13]+$row[14]+$row[15],
                    "created_by" => Auth::user()->id,
                    "created_at" => date('Y-m-d H:i:s'),
                ]);
                if($row[6]){
                    DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                    ->where('tb_employee.department_code',$row[6])
                    ->where('tb_employee_final_score.status_pa','0')
                    ->update([
                        "status_pa" => '1'
                    ]);
                }
            }else{
                $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
                        ->where('rec_year','like','%'.$checkYear.'%')
                        ->orderBy('id','desc')
                        ->first();
                DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
                    "import_id" => $this->id,
                    "service_days" => $row[11],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => $row[12],
                    "attendance_pl" => $row[13],
                    "attendance_late" => $row[14],
                    "attendance_abs" => $row[15],
                    "attendance_abt" => $row[16],
                    "attendance_sus" => $row[19],
                    "attendance_wwar" => $row[20],
                    "attendance_vwar" => $row[21],
                    "compliance_score" => $row[16]+$row[19]+$row[20]+$row[21],
                    "attendance_score" => $row[12]+$row[13]+$row[14]+$row[15],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
                if($row[6]){
                    DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                    ->where('tb_employee.department_code',$row[6])
                    ->where('tb_employee_final_score.status_pa','0')
                    ->update([
                        "status_pa" => '1'
                    ]);
                }
            }
        }else{
            $Emp = AttendanceLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => $row[1],
                "title_th" => $row[2],
                "EMPLOYEE_NAME" => $row[3],
                "EMPLOYEE_LOCAL_NAME" => $row[4],
                "POSITION_CODE" => $row[5],
                "POSITION_DESCRIPTION" => $row[6],
                "DIVISION_CODE" => $row[7],
                "DIVISION_DESCRIPTION" => $row[8],
                "DEPARTMENT_CODE" => $row[9],
                "DEPARTMENT_DESCRIPTION" => $row[10],
                "SECTION_CODE" => $row[11],
                "SECTION_DESCRIPTION" => $row[12],
                "GRADE_CODE" => $row[13],
                "GRADE_DESCRIPTION" => $row[14],
                "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "service_days" => $row[16],

                "attendance_sl" => $row[17],
                "attendance_pl" => $row[18],
                "attendance_late" => $row[19],
                "attendance_abs" => $row[20],
                "attendance_abt" => $row[21],
                "attendance_sus" => $row[22],
                "attendance_wwar" => $row[23],
                "attendance_vwar" => $row[24],
                "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);

            $countPosition = Position::where('position_code', $row[5])->count();
            if($countPosition == 0){
                $CreatePosition = Position::create([
                    "position_code" => $row[5],
                    "position_description" => $row[6],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDivision = Division::where('division_code', $row[7])->count();
            if($countDivision == 0){
                $CreateDivision = Division::create([
                    "division_code" => $row[7],
                    "division_description" => $row[8],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countDepartment = Department::where('department_code', $row[9])->count();
            if($countDepartment == 0){
                $CreateDepartment = Department::create([
                    "department_code" => $row[9],
                    "department_description" => $row[10],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countSection = Section::where('section_code', $row[11])->count();
            if($countSection == 0){
                $CreateSection = Section::create([
                    "section_code" => $row[11],
                    "section_description" => $row[12],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }
            $countGrademaster = Grademaster::where('grade_code', $row[13])->count();
            if($countGrademaster == 0){
                $CreateGrademaster = Grademaster::create([
                    "grade_code" => $row[13],
                    "grade_description" => $row[14],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created" => date('Y-m-d H:i:s'),
                    "updated" => null,
                ]);
            }

            $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
            if($countEmployeeModel == 0){
                $CreateEmployeeModel = EmployeeModel::create([
                    "orisoft_no" => sprintf("%06d", $row[0]),
                    "title_en" => $row[1],
                    "title_th" => $row[2],
                    "employee_local_name_en" => $row[3],
                    "employee_local_name_th" => $row[4],
                    "position_code" => $row[5],
                    "position_description" => $row[6],
                    "division_code" => $row[7],
                    "division_description" => $row[8],
                    "department_code" => $row[9],
                    "department_description" => $row[10],
                    "section_code" => $row[11],
                    "section_description" => $row[12],
                    "grade_code" => $row[13],
                    "grade_description" => $row[14],
                    "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                    "service_days" => $row[16],
                    "created_by" => Auth::user()->id,
                    "updated_by" => '0',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => null,
                ]);
            }else{
                DB::table('tb_employee')
                ->where('orisoft_no', sprintf("%06d", $row[0]) )
                ->update([
                    "title_en" => $row[1],
                    "title_th" => $row[2],
                    "employee_local_name_en" => $row[3],
                    "employee_local_name_th" => $row[4],
                    "position_code" => $row[5],
                    "position_description" => $row[6],
                    "division_code" => $row[7],
                    "division_description" => $row[8],
                    "department_code" => $row[9],
                    "department_description" => $row[10],
                    "section_code" => $row[11],
                    "section_description" => $row[12],
                    "grade_code" => $row[13],
                    "grade_description" => $row[14],
                    "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                    "service_days" => $row[16],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
            }
            // $countformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->count();
            // if($countformEvaluate == 0){
            //     $group_form_id = 0;
            // }else{
            //     $rowformEvaluate = formEvaluate::where('form_ref',$row[17])->where('form_year_use_start',$checkYear)->first();
            //     $group_form_id = $rowformEvaluate->id;
            // }
            $count = DB::table('tb_employee_final_score')
                    ->where('employee_no', sprintf("%06d", $row[0]))
                    ->where('rec_year','like','%'.$checkYear.'%')
                    ->count();
            if($count == 0){
                $salary_type = 'Monthly';
                if($row[13] == 'L800'){
                    $salary_type = 'Daily';
                }
                $salary_old = 0;
                if($salary_type == 'Monthly'){
                    $salary_old = 20000;
                }else{
                    $salary_old = 300;
                }
                $salary_month_old = $salary_old;
                if($salary_type == 'Daily'){
                    $salary_month_old = (float)$salary_old*26;
                }

                $Emp = EmployeeFinalScore::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "service_days" => $row[16],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => $row[17],
                    "attendance_pl" => $row[18],
                    "attendance_late" => $row[19],
                    "attendance_abs" => $row[20],
                    "attendance_abt" => $row[21],
                    "attendance_cl" => $row[22],
                    "attendance_ol" => $row[23],
                    "attendance_sus" => $row[24],
                    "attendance_wwar" => $row[25],
                    "attendance_vwar" => $row[26],
                    "compliance_score" => $row[23]+$row[24]+$row[25]+$row[26],
                    "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                    "salary_type" => $salary_type,
                    "salary_old" => $salary_old,
                    "bsalary_wage" => $salary_old,
                    "salary_month_old" => $salary_month_old,
                    "created_by" => Auth::user()->id,
                    "created_at" => date('Y-m-d H:i:s'),
                ]);
                if($row[6]){
                    DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                    ->where('tb_employee.department_code',$row[9])
                    ->where('tb_employee_final_score.status_pa','0')
                    ->update([
                        "status_pa" => '1'
                    ]);
                }
            }else{
                $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
                        ->where('rec_year','like','%'.$checkYear.'%')
                        ->orderBy('id','desc')
                        ->first();
                DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
                    "import_id" => $this->id,
                    "service_days" => $row[16],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => $row[17],
                    "attendance_pl" => $row[18],
                    "attendance_late" => $row[19],
                    "attendance_abs" => $row[20],
                    "attendance_abt" => $row[21],
                    "attendance_cl" => $row[22],
                    "attendance_ol" => $row[23],
                    "attendance_sus" => $row[24],
                    "attendance_wwar" => $row[25],
                    "attendance_vwar" => $row[26],
                    "compliance_score" => $row[23]+$row[24]+$row[25]+$row[26],
                    "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
                if($row[6]){
                    DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                    ->where('tb_employee.department_code',$row[9])
                    ->where('tb_employee_final_score.status_pa','0')
                    ->update([
                        "status_pa" => '1'
                    ]);
                }
            }
        }

    }
}
