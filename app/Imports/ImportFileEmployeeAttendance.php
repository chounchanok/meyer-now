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
use Illuminate\Support\Facades\Session;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use DateTime;

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

    public function modelbk(array $row)
    {
        // ✅ ข้าม header row
        if (!isset($row[0]) || in_array($row[0], ['employee_no', 'EMPLOYEE_NO', 'No.', 'Emp. No.'])) {
            return null;
        }

        // ini_set('max_execution_time', 180);
        // ini_set('memory_limit', '1024M');

        $checkYear = date('Y');
        if(trans(request()->segment(1)) == 'mtl'){
            // ✅ แปลงวันที่จาก Excel (ถ้ามี)
            $dateJoined = is_numeric($row[13])
                ? Carbon::instance(Date::excelToDateTimeObject((float) $row[13]))->subYears(543)->format('Y-m-d')
                : null;

            // ✅ สร้างข้อมูลพนักงาน
            $employeeData = [
                "orisoft_no" => sprintf("%06d", $row[0]),
                "employee_local_name_en" => $row[3] ?? null,
                "employee_local_name_th" => $row[4] ?? null,
                "position_code" => $row[5] ?? null,
                "position_description" => $row[6] ?? null,
                "division_code" => $row[7] ?? null,
                "division_description" => $row[8] ?? null,
                "department_code" => $row[9] ?? null,
                "department_description" => $row[10] ?? null,
                "section_code" => $row[11] ?? null,
                "section_description" => $row[12] ?? null,
                "grade_code" => $row[13] ?? null,
                "grade_description" => $row[14] ?? null,
                "date_joined" => $dateJoined,
                "service_days" => $row[16],
                "created_by" => Auth::id(),
                "updated_by" => 0,
                "created_at" => now(),
                "updated_at" => null,
            ];

            $AttendanceLogData = [
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => $row[1] ?? null,
                "title_th" => $row[2] ?? null,
                "employee_local_name_en" => $row[3] ?? null,
                "employee_local_name_th" => $row[4] ?? null,
                "position_code" => $row[5] ?? null,
                "position_description" => $row[6] ?? null,
                "division_code" => $row[7] ?? null,
                "division_description" => $row[8] ?? null,
                "department_code" => $row[9] ?? null,
                "department_description" => $row[10] ?? null,
                "section_code" => $row[11] ?? null,
                "section_description" => $row[12] ?? null,
                "grade_code" => $row[13] ?? null,
                "grade_description" => $row[14] ?? null,
                "date_joined" => $dateJoined,
                "service_days" => $row[16],

                "attendance_sl" => ($row[17]!=''?$row[17]:0),
                "attendance_pl" => ($row[18]!=''?$row[18]:0),
                "attendance_late" => ($row[19]!=''?$row[19]:0),
                "attendance_abs" => ($row[20]!=''?$row[20]:0),
                "attendance_abt" => ($row[21]!=''?$row[21]:0),
                "attendance_cl" => ($row[22]!=''?$row[22]:0),
                "attendance_ol" => ($row[23]!=''?$row[23]:0),
                "attendance_sus" => ($row[24]!=''?$row[24]:0),
                "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                "attendance_vwar" => ($row[26]!=''?$row[26]:0),
                "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                "created_by" => Auth::id(),
                "updated_by" => 0,
                "created_at" => now(),
                "updated_at" => null,
            ];
            EmployeeModel::create($AttendanceLogData);
            // ✅ ตรวจสอบว่าพนักงานมีอยู่แล้วหรือยัง
            $exists = EmployeeModel::where('orisoft_no', $employeeData['orisoft_no'])->exists();

            if (!$exists) {
                EmployeeModel::create($employeeData);
            } else {
                EmployeeModel::where('orisoft_no', $employeeData['orisoft_no'])->update($employeeData);
            }

            // ✅ ใช้ `upsert()` เพื่อเพิ่มข้อมูลตำแหน่ง, แผนก ฯลฯ (ลดจำนวน query)
            Position::updateOrCreate(['position_code' => $row[5]], ['position_description' => $row[6]]);
            Division::updateOrCreate(['division_code' => $row[7]], ['division_description' => $row[8]]);
            Department::updateOrCreate(['department_code' => $row[9]], ['department_description' => $row[10]]);
            Section::updateOrCreate(['section_code' => $row[11]], ['section_description' => $row[12]]);
            Grademaster::updateOrCreate(['grade_code' => $row[13]], ['grade_description' => $row[14]]);
        }else{
            // ✅ แปลงวันที่จาก Excel (ถ้ามี)
                $dateJoined = is_numeric($row[15])
                ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                : null;

            // ✅ สร้างข้อมูลพนักงาน
            $employeeData = [
                "orisoft_no" => sprintf("%06d", $row[0]),
                "title_en" => $row[1] ?? null,
                "title_th" => $row[2] ?? null,
                "employee_local_name_en" => $row[3] ?? null,
                "employee_local_name_th" => $row[4] ?? null,
                "position_code" => $row[5] ?? null,
                "position_description" => $row[6] ?? null,
                "division_code" => $row[7] ?? null,
                "division_description" => $row[8] ?? null,
                "department_code" => $row[9] ?? null,
                "department_description" => $row[10] ?? null,
                "section_code" => $row[11] ?? null,
                "section_description" => $row[12] ?? null,
                "grade_code" => $row[13] ?? null,
                "grade_description" => $row[14] ?? null,
                "date_joined" => $dateJoined,
                "service_days" => $row[16],
                "created_by" => Auth::id(),
                "updated_by" => 0,
                "created_at" => now(),
                "updated_at" => null,
            ];

            $AttendanceLogData = [
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => $row[1] ?? null,
                "title_th" => $row[2] ?? null,
                "employee_local_name_en" => $row[3] ?? null,
                "employee_local_name_th" => $row[4] ?? null,
                "position_code" => $row[5] ?? null,
                "position_description" => $row[6] ?? null,
                "division_code" => $row[7] ?? null,
                "division_description" => $row[8] ?? null,
                "department_code" => $row[9] ?? null,
                "department_description" => $row[10] ?? null,
                "section_code" => $row[11] ?? null,
                "section_description" => $row[12] ?? null,
                "grade_code" => $row[13] ?? null,
                "grade_description" => $row[14] ?? null,
                "date_joined" => $dateJoined,
                "service_days" => $row[16],

                "attendance_sl" => ($row[17]!=''?$row[17]:0),
                "attendance_pl" => ($row[18]!=''?$row[18]:0),
                "attendance_late" => ($row[19]!=''?$row[19]:0),
                "attendance_abs" => ($row[20]!=''?$row[20]:0),
                "attendance_abt" => ($row[21]!=''?$row[21]:0),
                "attendance_cl" => ($row[22]!=''?$row[22]:0),
                "attendance_ol" => ($row[23]!=''?$row[23]:0),
                "attendance_sus" => ($row[24]!=''?$row[24]:0),
                "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                "attendance_vwar" => ($row[26]!=''?$row[26]:0),
                "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                "created_by" => Auth::id(),
                "updated_by" => 0,
                "created_at" => now(),
                "updated_at" => null,
            ];
            EmployeeModel::create($AttendanceLogData);
            // ✅ ตรวจสอบว่าพนักงานมีอยู่แล้วหรือยัง
            $exists = EmployeeModel::where('orisoft_no', $employeeData['orisoft_no'])->exists();

            if (!$exists) {
                EmployeeModel::create($employeeData);
            } else {
                EmployeeModel::where('orisoft_no', $employeeData['orisoft_no'])->update($employeeData);
            }

            // ✅ ใช้ `upsert()` เพื่อเพิ่มข้อมูลตำแหน่ง, แผนก ฯลฯ (ลดจำนวน query)
            Position::updateOrCreate(['position_code' => $row[5]], ['position_description' => $row[6]]);
            Division::updateOrCreate(['division_code' => $row[7]], ['division_description' => $row[8]]);
            Department::updateOrCreate(['department_code' => $row[9]], ['department_description' => $row[10]]);
            Section::updateOrCreate(['section_code' => $row[11]], ['section_description' => $row[12]]);
            Grademaster::updateOrCreate(['grade_code' => $row[13]], ['grade_description' => $row[14]]);
        }


        // ✅ เช็คว่ามี record ใน `tb_employee_final_score` หรือยัง
        $count = DB::table('tb_employee_final_score')
            ->where('employee_no', $employeeData['orisoft_no'])
            ->where('rec_year', 'like', '%' . $checkYear . '%')
            ->count();

        if ($count == 0) {
            DB::table('tb_employee_final_score')->insert([
                "import_id" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => $employeeData['orisoft_no'],
                "compliance_score" => 10,
                "created_by" => Auth::id(),
                "created_at" => now(),
            ]);

        }

        return null; // ✅ ลดการโหลดข้อมูลคืน
    }
    public function model_bk2(array $row)
    {
        //  dd($row, $this->id);
        // dd(trans(request()->segment(1)));

        if (!isset($row[0])) {
            return null;
        }
        if ($row[0] == 'employee_no' || $row[0] == 'EMPLOYEE_NO' || $row[0] == 'No.' || $row[0] == 'Emp. No.') {
            return null;
        }
        // if (isset($row[15]) && $row[15] != "" && $row[15]) {
        //     $thaiDate = $row[15];

        //     // แปลงวันที่จาก พ.ศ. เป็น ค.ศ.
        //     $dateParts = explode("/", $thaiDate); // แยกเป็น [15, 08, 2534]
        //     $day = $dateParts[0];
        //     $month = $dateParts[1];
        //     $year = $dateParts[2] - 543; // แปลง พ.ศ. → ค.ศ.

        //     // สร้างวันที่ในรูปแบบ Y-m-d
        //     $row[15] = Carbon::createFromFormat('Y-m-d', "$year-$month-$day")->format('Y-m-d');
        // }

        // dd($row);
        // exit;


        // dd($datejoin);
        // exit;
        // ini_set('max_execution_time',360);
        // ini_set('memory_limit', '2048M');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
            $checkYear = date('Y');
        // }

        // dd(trans(request()->segment(1)));
        // exit;

        if(trans(request()->segment(1)) == 'mtl'){
            $Emp = AttendanceLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => null,
                "title_th" => null,
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
                "DATE_JOINED" => is_numeric($row[15])
                ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                : null,
                // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "service_days" => $row[16],

                "attendance_sl" => ($row[17]!=''?$row[17]:0),
                "attendance_pl" => ($row[18]!=''?$row[18]:0),
                "attendance_late" => ($row[19]!=''?$row[19]:0),
                "attendance_abs" => ($row[20]!=''?$row[20]:0),
                "attendance_abt" => ($row[21]!=''?$row[21]:0),
                "attendance_cl" => ($row[22]!=''?$row[22]:0),
                "attendance_ol" => ($row[23]!=''?$row[23]:0),
                "attendance_sus" => ($row[24]!=''?$row[24]:0),
                "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                "attendance_vwar" => ($row[26]!=''?$row[26]:0),
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
                    "title_en" => null,
                    "title_th" => null,
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
                    "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                    // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
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
                    "title_en" => null,
                    "title_th" => null,
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
                    "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                    // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                    "service_days" => $row[16],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
            }
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
                $calcompliance = 10-($row[21]+($row[26]*2)+($row[25]*5)+($row[24]*10));
                $Emp = EmployeeFinalScore::create([
                    "import_id" => $this->id,
                    "rec_year" => $checkYear,
                    "employee_no" => sprintf("%06d", $row[0]),
                    "service_days" => $row[15],
                    "attendance_sl" => ($row[17]!=''?$row[17]:0),
                    "attendance_pl" => ($row[18]!=''?$row[18]:0),
                    "attendance_late" => ($row[19]!=''?$row[19]:0),
                    "attendance_abs" => ($row[20]!=''?$row[20]:0),
                    "attendance_abt" => ($row[21]!=''?$row[21]:0),
                    "attendance_cl" => ($row[22]!=''?$row[22]:0),
                    "attendance_ol" => ($row[23]!=''?$row[23]:0),
                    "attendance_sus" => ($row[24]!=''?$row[24]:0),
                    "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                    "attendance_vwar" => ($row[26]!=''?$row[26]:0),
                    "compliance_score" => ($calcompliance > 0?$calcompliance:1),
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
                $calcompliance = 10-($row[21]+($row[26]*2)+($row[25]*5)+($row[24]*10));
                DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
                    "import_id" => $this->id,
                    "service_days" => $row[16],
                    "attendance_sl" => ($row[17]!=''?$row[17]:0),
                    "attendance_pl" => ($row[18]!=''?$row[18]:0),
                    "attendance_late" => ($row[19]!=''?$row[19]:0),
                    "attendance_abs" => ($row[20]!=''?$row[20]:0),
                    "attendance_abt" => ($row[21]!=''?$row[21]:0),
                    "attendance_cl" => ($row[22]!=''?$row[22]:0),
                    "attendance_ol" => ($row[23]!=''?$row[23]:0),
                    "attendance_sus" => ($row[24]!=''?$row[24]:0),
                    "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                    "attendance_vwar" => ($row[26]!=''?$row[26]:0),
                    "compliance_score" => ($calcompliance > 0?$calcompliance:1),
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
            $Emp = AttendanceLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => null,
                "title_th" => null,
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
                "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "service_days" => $row[16],

                "attendance_sl" => ($row[17]!=''?$row[17]:0),
                "attendance_pl" => ($row[18]!=''?$row[18]:0),
                "attendance_late" => ($row[19]!=''?$row[19]:0),
                "attendance_abs" => ($row[20]!=''?$row[20]:0),
                "attendance_abt" => ($row[21]!=''?$row[21]:0),
                "attendance_cl" => ($row[22]!=''?$row[22]:0),
                "attendance_ol" => ($row[23]!=''?$row[23]:0),
                "attendance_sus" => ($row[24]!=''?$row[24]:0),
                "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                "attendance_vwar" => ($row[26]!=''?$row[26]:0),

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
                    "title_en" => null,
                    "title_th" => null,
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
                    "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                    // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
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
                    "title_en" => null,
                    "title_th" => null,
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
                    "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                    // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
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
                $calcompliance = 10-($row[21]+($row[26]*2)+($row[25]*5)+($row[24]*10));
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
                    "attendance_sl" => ($row[17]!=''?$row[17]:0),
                    "attendance_pl" => ($row[18]!=''?$row[18]:0),
                    "attendance_late" => ($row[19]!=''?$row[19]:0),
                    "attendance_abs" => ($row[20]!=''?$row[20]:0),
                    "attendance_abt" => ($row[21]!=''?$row[21]:0),
                    "attendance_cl" => ($row[22]!=''?$row[22]:0),
                    "attendance_ol" => ($row[23]!=''?$row[23]:0),
                    "attendance_sus" => ($row[24]!=''?$row[24]:0),
                    "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                    "attendance_vwar" => ($row[26]!=''?$row[26]:0),
                    "compliance_score" => ($calcompliance > 0?$calcompliance:1),
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
                $calcompliance = 10-($row[21]+($row[26]*2)+($row[25]*5)+($row[24]*10));
                DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
                    "import_id" => $this->id,
                    "service_days" => $row[16],
                    // "form_import" => $row[17],
                    // "group_form_id" => $group_form_id,
                    // "evaluator_no" => sprintf("%06d", $row[18]),
                    // "evaluator_name_th" => $row[20],
                    // "evaluator_name_en" => $row[19],
                    "attendance_sl" => ($row[17]!=''?$row[17]:0),
                    "attendance_pl" => ($row[18]!=''?$row[18]:0),
                    "attendance_late" => ($row[19]!=''?$row[19]:0),
                    "attendance_abs" => ($row[20]!=''?$row[20]:0),
                    "attendance_abt" => ($row[21]!=''?$row[21]:0),
                    "attendance_cl" => ($row[22]!=''?$row[22]:0),
                    "attendance_ol" => ($row[23]!=''?$row[23]:0),
                    "attendance_sus" => ($row[24]!=''?$row[24]:0),
                    "attendance_wwar" => ($row[25]!=''?$row[25]:0),
                    "attendance_vwar" => ($row[26]!=''?$row[26]:0),
                    "compliance_score" => ($calcompliance > 0?$calcompliance:1),
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
        }else{
            // dd($row);
            // exit;
            $Emp = AttendanceLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "title_en" => null,
                "title_th" => null,
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
                "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "service_days" => $row[16],

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
                "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                "not_up_salary" => $row[27] || null,
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
                    "title_en" => null,
                    "title_th" => null,
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
                    "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                    // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
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
                    "title_en" => null,
                    "title_th" => null,
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
                    "DATE_JOINED" => is_numeric($row[15])
                    ? Carbon::instance(Date::excelToDateTimeObject((float) $row[15]))->subYears(543)->format('Y-m-d')
                    : null,
                    // "DATE_JOINED" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
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
                $calcompliance = 10-($row[21]+($row[26]*2)+($row[25]*5)+($row[24]*10));
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
                    "compliance_score" => ($calcompliance > 0?$calcompliance:1),
                    "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                    "salary_type" => $salary_type,
                    "salary_old" => $salary_old,
                    "bsalary_wage" => $salary_old,
                    "salary_month_old" => $salary_month_old,
                    "not_up_salary" => $row[27] || null,
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
                $calcompliance = 10-($row[21]+($row[26]*2)+($row[25]*5)+($row[24]*10));
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
                    "compliance_score" => ($calcompliance > 0?$calcompliance:1),
                    "attendance_score" => $row[17]+$row[18]+$row[19]+$row[20],
                    "not_up_salary" => $row[27] || null,
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
    public function model_not_up_salary(array $row)
    {

        if (!isset($row[0])) {
            return null;
        }
        if ($row[0] == 'employee_no' || $row[0] == 'EMPLOYEE_NO' || $row[0] == 'No.' || $row[0] == 'Emp. No.') {
            return null;
        }
        // ini_set('max_execution_time',360);
        // ini_set('memory_limit', '2048M');
        $previousYear = date('Y');
        $checkYear = date('Y');
        // dd($row);
        // exit;
        // ใช้ DB transaction เพื่อให้ทุกการเปลี่ยนแปลงสำเร็จพร้อมกัน
        DB::transaction(function () use ($row, $checkYear) {
            $userId = Auth::user()->id;
            $employeeNo = sprintf("%06d", $row[0]);

            // ใช้ updateOrCreate สำหรับ EmployeeFinalScore
            DB::table('tb_employee_final_score')
            ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
            ->where('tb_employee_final_score.employee_no', $employeeNo)
            ->update(["not_up_salary" => $row[27]]);
            // dd($row);
            // exit;
        });

    }
    public function model3db(array $row)
    {

        if (!isset($row[0])) {
            return null;
        }
        if ($row[0] == 'employee_no' || $row[0] == 'EMPLOYEE_NO' || $row[0] == 'No.' || $row[0] == 'Emp. No.') {
            return null;
        }
        // ini_set('max_execution_time',360);
        // ini_set('memory_limit', '2048M');
        $previousYear = date('Y');
        $checkYear = date('Y');

        if(trans(request()->segment(1)) == 'mtl'){
            // ใช้ DB transaction เพื่อให้ทุกการเปลี่ยนแปลงสำเร็จพร้อมกัน
            DB::transaction(function () use ($row, $checkYear) {
                $userId = Auth::user()->id;
                $employeeNo = sprintf("%06d", $row[0]);

                $convertedDate = Carbon::create(1900, 1, 1)->addDays($row[15] - 2)->format('Y-m-d');
                // $attendanceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
                // $attendanceDate = $date->format("Y-m-d").' 00:00:00';
                // dd($row[15]);
                // exit;
                // $attendanceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
                // if($row[13] && $row[13] != ""){
                //     // $date = DateTime::createFromFormat("d/m/Y", $row[13]);
                //     // $date->modify("-543 years");
                //     $cut = explode('/',$row[13]);

                //     $cut1 = (int)$cut[2]-543;
                //     // dd($cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00');
                //     // exit;
                //     $attendanceDate = $cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00';
                //     // $attendanceDate = $row[15].' 00:00:00';

                //     // $attendanceDate = $date->format("Y-m-d").' 00:00:00';
                // }else{
                //     $attendanceDate = null;
                // }


                // dd($attendanceDate);
                // exit;
                // สร้าง AttendanceLog
                AttendanceLog::create([
                    "id_file"               => $this->id,
                    "rec_year"              => $checkYear,
                    "employee_no"           => $employeeNo,
                    "title_en"              => null,
                    "title_th"              => null,
                    "EMPLOYEE_NAME"         => $row[1],
                    "EMPLOYEE_LOCAL_NAME"   => $row[2],
                    "POSITION_CODE"         => $row[3],
                    "POSITION_DESCRIPTION"  => $row[4],
                    "DIVISION_CODE"         => $row[5],
                    "DIVISION_DESCRIPTION"  => $row[6],
                    "DEPARTMENT_CODE"       => $row[7],
                    "DEPARTMENT_DESCRIPTION"=> $row[8],
                    "SECTION_CODE"          => $row[9],
                    "SECTION_DESCRIPTION"   => $row[10],
                    "GRADE_CODE"            => $row[11],
                    "GRADE_DESCRIPTION"     => $row[12],
                    "DATE_JOINED"           => $convertedDate,
                    "service_days"          => $row[15],
                    "attendance_sl"         => ($row[16]/9),
                    "attendance_pl"         => ($row[17]/9),
                    // "attendance_late"       => $row[17],
                    "attendance_abs"        => $row[22],
                    // "attendance_abt"        => $row[19],
                    "attendance_cl"         => ($row[18]/9),
                    "attendance_ol"         => $row[19],
                    "attendance_sus"        => $row[20],
                    "attendance_wwar"       => $row[23],
                    "attendance_vwar"       => $row[24],
                    "attendance_score"      => $row[16] + $row[17] + $row[22],
                    // "not_up_salary" => $row[27] || null,
                    "created_by"            => $userId,
                    "updated_by"            => '0',
                    "created_at"            => now(),
                    "updated_at"            => null,
                ]);

                // ใช้ updateOrCreate เพื่อลด query ซ้ำ สำหรับข้อมูล master
                Position::updateOrCreate(
                    ["position_code" => $row[3]],
                    [
                        "position_description" => $row[4],
                        "created_by"           => $userId,
                        "updated_by"           => '0',
                        "created"              => now(),
                        "updated"              => null,
                    ]
                );
                Division::updateOrCreate(
                    ["division_code" => $row[5]],
                    [
                        "division_description" => $row[6],
                        "created_by"           => $userId,
                        "updated_by"           => '0',
                        "created"              => now(),
                        "updated"              => null,
                    ]
                );
                Department::updateOrCreate(
                    ["department_code" => $row[7]],
                    [
                        "department_description" => $row[8],
                        "created_by"             => $userId,
                        "updated_by"             => '0',
                        "created"                => now(),
                        "updated"                => null,
                    ]
                );
                Section::updateOrCreate(
                    ["section_code" => $row[9]],
                    [
                        "section_description" => $row[10],
                        "created_by"          => $userId,
                        "updated_by"          => '0',
                        "created"             => now(),
                        "updated"             => null,
                    ]
                );
                Grademaster::updateOrCreate(
                    ["grade_code" => $row[11]],
                    [
                        "grade_description" => $row[12],
                        "created_by"        => $userId,
                        "updated_by"        => '0',
                        "created"           => now(),
                        "updated"           => null,
                    ]
                );

                // อัปเดตหรือสร้าง EmployeeModel
                EmployeeModel::updateOrCreate(
                    ["orisoft_no" => $employeeNo],
                    [
                        "title_en"                  => null,
                        "title_th"                  => null,
                        "employee_local_name_en"    => $row[1],
                        "employee_local_name_th"    => $row[2],
                        "position_code"             => $row[3],
                        "position_description"      => $row[4],
                        "division_code"             => $row[5],
                        "division_description"      => $row[6],
                        "department_code"           => $row[7],
                        "department_description"    => $row[8],
                        "section_code"              => $row[9],
                        "section_description"       => $row[10],
                        "grade_code"                => $row[11],
                        "grade_description"         => $row[12],
                        "DATE_JOINED"               => $convertedDate,
                        "service_days"              => $row[15],
                        "created_by"                => $userId,
                        "updated_by"                => '0',
                        "created_at"                => now(),
                        "updated_at"                => null,
                    ]
                );

                // คำนวณข้อมูลสำหรับ EmployeeFinalScore
                $calcompliance = 10 - ($row[24] + ($row[14] * 2) + ($row[23] * 5) + ($row[20] * 10));
                // $attendanceScore = $row[15] + $row[16] + $row[17] + $row[18];
                $salaryType = ($row[11] === 'L800') ? 'Daily' : 'Monthly';
                $salaryOld = ($salaryType === 'Monthly') ? 20000 : 300;
                $salaryMonthOld = ($salaryType === 'Daily') ? ((float)$salaryOld * 26) : $salaryOld;

                // ใช้ updateOrCreate สำหรับ EmployeeFinalScore
                EmployeeFinalScore::updateOrCreate(
                    [
                        "employee_no" => $employeeNo,
                        "rec_year"    => $checkYear,
                    ],
                    [
                        "import_id"         => $this->id,
                        "service_days"      => $row[15],
                        "attendance_sl"         => ($row[16]/9),
                        "attendance_pl"         => ($row[17]/9),
                        // "attendance_late"       => $row[17],
                        "attendance_abs"        => $row[22],
                        // "attendance_abt"        => $row[19],
                        "attendance_cl"         => ($row[18]/9),
                        "attendance_ol"         => $row[19],
                        "attendance_sus"        => $row[20],
                        "attendance_wwar"       => $row[23],
                        "attendance_vwar"       => $row[24],
                        "attendance_score"      => $row[16] + $row[17] + $row[22],
                        "compliance_score"  => ($calcompliance > 0 ? $calcompliance : 1),
                        "salary_type"       => $salaryType,
                        "salary_old"       => $row[14],
                        "l800avg_wage"     => ($row[11] == 'L800' ? $row[14] : 0),
                        "bsalary_wage"     => $row[14],
                        "salary_month_old" => $row[14],
                        "created_by"        => $userId,
                        "created_at"        => now(),
                    ]
                );

                // อัปเดต status_pa ถ้ามีเงื่อนไขตรงกัน
                if ($row[4]) {
                    DB::table('tb_employee_final_score')
                        ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                        ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                        ->where('tb_employee.department_code', $row[7])
                        ->where('tb_employee_final_score.status_pa', '0')
                        ->update(["status_pa" => '1']);
                }
            });
        }else if(trans(request()->segment(1)) == 'manager'){
            // ใช้ DB transaction เพื่อให้ทุกการเปลี่ยนแปลงสำเร็จพร้อมกัน
            DB::transaction(function () use ($row, $checkYear) {
                $userId = Auth::user()->id;
                $employeeNo = sprintf("%06d", $row[0]);

                $convertedDate = Carbon::create(1900, 1, 1)->addDays($row[15] - 2)->format('Y-m-d');
                // $attendanceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
                // $attendanceDate = $date->format("Y-m-d").' 00:00:00';
                // dd($row[15]);
                // exit;
                // $attendanceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
                // if($row[13] && $row[13] != ""){
                //     // $date = DateTime::createFromFormat("d/m/Y", $row[13]);
                //     // $date->modify("-543 years");
                //     $cut = explode('/',$row[13]);

                //     $cut1 = (int)$cut[2]-543;
                //     // dd($cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00');
                //     // exit;
                //     $attendanceDate = $cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00';
                //     // $attendanceDate = $row[15].' 00:00:00';

                //     // $attendanceDate = $date->format("Y-m-d").' 00:00:00';
                // }else{
                //     $attendanceDate = null;
                // }


                // dd($attendanceDate);
                // exit;
                // สร้าง AttendanceLog
                AttendanceLog::create([
                    "id_file"               => $this->id,
                    "rec_year"              => $checkYear,
                    "employee_no"           => $employeeNo,
                    "title_en"              => null,
                    "title_th"              => null,
                    "EMPLOYEE_NAME"         => $row[1],
                    "EMPLOYEE_LOCAL_NAME"   => $row[2],
                    "POSITION_CODE"         => $row[3],
                    "POSITION_DESCRIPTION"  => $row[4],
                    "DIVISION_CODE"         => $row[5],
                    "DIVISION_DESCRIPTION"  => $row[6],
                    "DEPARTMENT_CODE"       => $row[7],
                    "DEPARTMENT_DESCRIPTION"=> $row[8],
                    "SECTION_CODE"          => $row[9],
                    "SECTION_DESCRIPTION"   => $row[10],
                    "GRADE_CODE"            => $row[11],
                    "GRADE_DESCRIPTION"     => $row[12],
                    "DATE_JOINED"           => $convertedDate,
                    "service_days"          => $row[15],
                    "attendance_sl"         => ($row[16]),
                    "attendance_pl"         => ($row[17]),
                    // "attendance_late"       => $row[17],
                    "attendance_abs"        => $row[22],
                    // "attendance_abt"        => $row[19],
                    "attendance_cl"         => ($row[18]),
                    "attendance_ol"         => $row[19],
                    "attendance_sus"        => $row[20],
                    "attendance_wwar"       => $row[23],
                    "attendance_vwar"       => $row[24],
                    "attendance_score"      => $row[16] + $row[17] + $row[22],
                    // "not_up_salary" => $row[27] || null,
                    "created_by"            => $userId,
                    "updated_by"            => '0',
                    "created_at"            => now(),
                    "updated_at"            => null,
                ]);

                // ใช้ updateOrCreate เพื่อลด query ซ้ำ สำหรับข้อมูล master
                Position::updateOrCreate(
                    ["position_code" => $row[3]],
                    [
                        "position_description" => $row[4],
                        "created_by"           => $userId,
                        "updated_by"           => '0',
                        "created"              => now(),
                        "updated"              => null,
                    ]
                );
                Division::updateOrCreate(
                    ["division_code" => $row[5]],
                    [
                        "division_description" => $row[6],
                        "created_by"           => $userId,
                        "updated_by"           => '0',
                        "created"              => now(),
                        "updated"              => null,
                    ]
                );
                Department::updateOrCreate(
                    ["department_code" => $row[7]],
                    [
                        "department_description" => $row[8],
                        "created_by"             => $userId,
                        "updated_by"             => '0',
                        "created"                => now(),
                        "updated"                => null,
                    ]
                );
                Section::updateOrCreate(
                    ["section_code" => $row[9]],
                    [
                        "section_description" => $row[10],
                        "created_by"          => $userId,
                        "updated_by"          => '0',
                        "created"             => now(),
                        "updated"             => null,
                    ]
                );
                Grademaster::updateOrCreate(
                    ["grade_code" => $row[11]],
                    [
                        "grade_description" => $row[12],
                        "created_by"        => $userId,
                        "updated_by"        => '0',
                        "created"           => now(),
                        "updated"           => null,
                    ]
                );

                // อัปเดตหรือสร้าง EmployeeModel
                EmployeeModel::updateOrCreate(
                    ["orisoft_no" => $employeeNo],
                    [
                        "title_en"                  => null,
                        "title_th"                  => null,
                        "employee_local_name_en"    => $row[1],
                        "employee_local_name_th"    => $row[2],
                        "position_code"             => $row[3],
                        "position_description"      => $row[4],
                        "division_code"             => $row[5],
                        "division_description"      => $row[6],
                        "department_code"           => $row[7],
                        "department_description"    => $row[8],
                        "section_code"              => $row[9],
                        "section_description"       => $row[10],
                        "grade_code"                => $row[11],
                        "grade_description"         => $row[12],
                        "DATE_JOINED"               => $convertedDate,
                        "service_days"              => $row[15],
                        "created_by"                => $userId,
                        "updated_by"                => '0',
                        "created_at"                => now(),
                        "updated_at"                => null,
                    ]
                );

                // คำนวณข้อมูลสำหรับ EmployeeFinalScore
                $calcompliance = 10 - ($row[24] + ($row[14] * 2) + ($row[23] * 5) + ($row[20] * 10));
                // $attendanceScore = $row[15] + $row[16] + $row[17] + $row[18];
                $salaryType = ($row[11] === 'L800') ? 'Daily' : 'Monthly';
                $salaryOld = ($salaryType === 'Monthly') ? 20000 : 300;
                $salaryMonthOld = ($salaryType === 'Daily') ? ((float)$salaryOld * 26) : $salaryOld;

                // ใช้ updateOrCreate สำหรับ EmployeeFinalScore
                EmployeeFinalScore::updateOrCreate(
                    [
                        "employee_no" => $employeeNo,
                        "rec_year"    => $checkYear,
                    ],
                    [
                        "import_id"         => $this->id,
                        "service_days"      => $row[15],
                        "attendance_sl"         => ($row[16]),
                        "attendance_pl"         => ($row[17]),
                        // "attendance_late"       => $row[17],
                        "attendance_abs"        => $row[22],
                        // "attendance_abt"        => $row[19],
                        "attendance_cl"         => ($row[18]),
                        "attendance_ol"         => $row[19],
                        "attendance_sus"        => $row[20],
                        "attendance_wwar"       => $row[23],
                        "attendance_vwar"       => $row[24],
                        "attendance_score"      => $row[16] + $row[17] + $row[22],
                        "compliance_score"  => ($calcompliance > 0 ? $calcompliance : 1),
                        "salary_type"       => $salaryType,
                        "salary_old"       => $row[14],
                        "l800avg_wage"     => ($row[11] == 'L800' ? $row[14] : 0),
                        "bsalary_wage"     => $row[14],
                        "salary_month_old" => $row[14],
                        "created_by"        => $userId,
                        "created_at"        => now(),
                    ]
                );

                // อัปเดต status_pa ถ้ามีเงื่อนไขตรงกัน
                if ($row[4]) {
                    DB::table('tb_employee_final_score')
                        ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                        ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                        ->where('tb_employee.department_code', $row[7])
                        ->where('tb_employee_final_score.status_pa', '0')
                        ->update(["status_pa" => '1']);
                }
            });
        }else{
            // ใช้ DB transaction เพื่อให้ทุกการเปลี่ยนแปลงสำเร็จพร้อมกัน
            DB::transaction(function () use ($row, $checkYear) {
                $userId = Auth::user()->id;
                $employeeNo = sprintf("%06d", $row[0]);
                // $attendanceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
                if($row[15] && $row[15] != ""){
                    // $date = DateTime::createFromFormat("d/m/Y", $row[15]);
                    // $date->modify("-543 years");
                    $cut = explode('/',$row[15]);

                    $cut1 = (int)$cut[2]-543;
                    // dd($cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00');
                    // exit;
                    $attendanceDate = $cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00';
                    // $attendanceDate = $row[15].' 00:00:00';

                    // $attendanceDate = $date->format("Y-m-d").' 00:00:00';
                }else{
                    $attendanceDate = null;
                }


                // dd($attendanceDate);
                // exit;
                // สร้าง AttendanceLog
                AttendanceLog::create([
                    "id_file"               => $this->id,
                    "rec_year"              => $checkYear,
                    "employee_no"           => $employeeNo,
                    "title_en"              => null,
                    "title_th"              => null,
                    "EMPLOYEE_NAME"         => $row[3],
                    "EMPLOYEE_LOCAL_NAME"   => $row[4],
                    "POSITION_CODE"         => $row[5],
                    "POSITION_DESCRIPTION"  => $row[6],
                    "DIVISION_CODE"         => $row[7],
                    "DIVISION_DESCRIPTION"  => $row[8],
                    "DEPARTMENT_CODE"       => $row[9],
                    "DEPARTMENT_DESCRIPTION"=> $row[10],
                    "SECTION_CODE"          => $row[11],
                    "SECTION_DESCRIPTION"   => $row[12],
                    "GRADE_CODE"            => $row[13],
                    "GRADE_DESCRIPTION"     => $row[14],
                    "DATE_JOINED"           => $attendanceDate,
                    "service_days"          => $row[16],
                    "attendance_sl"         => $row[17],
                    "attendance_pl"         => $row[18],
                    "attendance_late"       => $row[19],
                    "attendance_abs"        => $row[20],
                    "attendance_abt"        => $row[21],
                    "attendance_cl"         => $row[22],
                    "attendance_ol"         => $row[23],
                    "attendance_sus"        => $row[24],
                    "attendance_wwar"       => $row[25],
                    "attendance_vwar"       => $row[26],
                    "attendance_score"      => $row[17] + $row[18] + $row[19] + $row[20],
                    "not_up_salary" => $row[27] || null,
                    "created_by"            => $userId,
                    "updated_by"            => '0',
                    "created_at"            => now(),
                    "updated_at"            => null,
                ]);

                // ใช้ updateOrCreate เพื่อลด query ซ้ำ สำหรับข้อมูล master
                Position::updateOrCreate(
                    ["position_code" => $row[5]],
                    [
                        "position_description" => $row[6],
                        "created_by"           => $userId,
                        "updated_by"           => '0',
                        "created"              => now(),
                        "updated"              => null,
                    ]
                );
                Division::updateOrCreate(
                    ["division_code" => $row[7]],
                    [
                        "division_description" => $row[8],
                        "created_by"           => $userId,
                        "updated_by"           => '0',
                        "created"              => now(),
                        "updated"              => null,
                    ]
                );
                Department::updateOrCreate(
                    ["department_code" => $row[9]],
                    [
                        "department_description" => $row[10],
                        "created_by"             => $userId,
                        "updated_by"             => '0',
                        "created"                => now(),
                        "updated"                => null,
                    ]
                );
                Section::updateOrCreate(
                    ["section_code" => $row[11]],
                    [
                        "section_description" => $row[12],
                        "created_by"          => $userId,
                        "updated_by"          => '0',
                        "created"             => now(),
                        "updated"             => null,
                    ]
                );
                Grademaster::updateOrCreate(
                    ["grade_code" => $row[13]],
                    [
                        "grade_description" => $row[14],
                        "created_by"        => $userId,
                        "updated_by"        => '0',
                        "created"           => now(),
                        "updated"           => null,
                    ]
                );

                // อัปเดตหรือสร้าง EmployeeModel
                EmployeeModel::updateOrCreate(
                    ["orisoft_no" => $employeeNo],
                    [
                        "title_en"                  => null,
                        "title_th"                  => null,
                        "employee_local_name_en"    => $row[3],
                        "employee_local_name_th"    => $row[4],
                        "position_code"             => $row[5],
                        "position_description"      => $row[6],
                        "division_code"             => $row[7],
                        "division_description"      => $row[8],
                        "department_code"           => $row[9],
                        "department_description"    => $row[10],
                        "section_code"              => $row[11],
                        "section_description"       => $row[12],
                        "grade_code"                => $row[13],
                        "grade_description"         => $row[14],
                        "DATE_JOINED"               => $attendanceDate,
                        "service_days"              => $row[16],
                        "created_by"                => $userId,
                        "updated_by"                => '0',
                        "created_at"                => now(),
                        "updated_at"                => null,
                    ]
                );

                // คำนวณข้อมูลสำหรับ EmployeeFinalScore
                $calcompliance = 10 - ($row[21] + ($row[26] * 2) + ($row[25] * 5) + ($row[24] * 10));
                $attendanceScore = $row[17] + $row[18] + $row[19] + $row[20];
                $salaryType = ($row[13] === 'L800') ? 'Daily' : 'Monthly';
                $salaryOld = ($salaryType === 'Monthly') ? 20000 : 300;
                $salaryMonthOld = ($salaryType === 'Daily') ? ((float)$salaryOld * 26) : $salaryOld;

                // ใช้ updateOrCreate สำหรับ EmployeeFinalScore
                EmployeeFinalScore::updateOrCreate(
                    [
                        "employee_no" => $employeeNo,
                        "rec_year"    => $checkYear,
                    ],
                    [
                        "import_id"         => $this->id,
                        "service_days"      => $row[16],
                        "attendance_sl"     => $row[17],
                        "attendance_pl"     => $row[18],
                        "attendance_late"   => $row[19],
                        "attendance_abs"    => $row[20],
                        "attendance_abt"    => $row[21],
                        "attendance_cl"     => $row[22],
                        "attendance_ol"     => $row[23],
                        "attendance_sus"    => $row[24],
                        "attendance_wwar"   => $row[25],
                        "attendance_vwar"   => $row[26],
                        "compliance_score"  => ($calcompliance > 0 ? $calcompliance : 1),
                        "attendance_score"  => $attendanceScore,
                        "salary_type"       => $salaryType,
                        "salary_old"        => $salaryOld,
                        "bsalary_wage"      => $salaryOld,
                        "salary_month_old"  => $salaryMonthOld,
                        "created_by"        => $userId,
                        "created_at"        => now(),
                        "not_up_salary" => $row[27] || null
                    ]
                );

                // อัปเดต status_pa ถ้ามีเงื่อนไขตรงกัน
                if ($row[6]) {
                    DB::table('tb_employee_final_score')
                        ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                        ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                        ->where('tb_employee.department_code', $row[9])
                        ->where('tb_employee_final_score.status_pa', '0')
                        ->update(["status_pa" => '1']);
                }
            });
        }

    }
    public function model(array $row)
    {

        if (!isset($row[0])) {
            return null;
        }
        if ($row[0] == 'employee_no' || $row[0] == 'EMPLOYEE_NO' || $row[0] == 'No.' || $row[0] == 'Emp. No.') {
            return null;
        }

        $previousYear = date('Y');
        $checkYear = date('Y');

        // ใช้ DB transaction เพื่อให้ทุกการเปลี่ยนแปลงสำเร็จพร้อมกัน
        DB::transaction(function () use ($row, $checkYear) {
            $userId = Auth::user()->id;
            $employeeNo = sprintf("%06d", $row[0]);
            // $attendanceDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
            if($row[15] && $row[15] != ""){
                // $date = DateTime::createFromFormat("d/m/Y", $row[15]);
                // $date->modify("-543 years");
                $cut = explode('/',$row[15]);

                $cut1 = (int)$cut[2]-543;
                // dd($cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00');
                // exit;
                $attendanceDate = $cut1.'-'.$cut[1].'-'.$cut[0].' 00:00:00';
                // $attendanceDate = $row[15].' 00:00:00';

                // $attendanceDate = $date->format("Y-m-d").' 00:00:00';
            }else{
                $attendanceDate = null;
            }


            // dd($attendanceDate);
            // exit;
            // สร้าง AttendanceLog
            $salaryType = ($row[13] === 'L800') ? 'Daily' : 'Monthly';
            $salaryOld = ($salaryType === 'Monthly') ? $row[16] : $row[16];
            $salaryMonthOld = ($salaryType === 'Daily') ? ((float)$salaryOld * 27) : $salaryOld;
            AttendanceLog::create([
                "id_file"               => $this->id,
                "rec_year"              => $checkYear,
                "employee_no"           => $employeeNo,
                "title_en"              => null,
                "title_th"              => null,
                "EMPLOYEE_NAME"         => $row[3],
                "EMPLOYEE_LOCAL_NAME"   => $row[4],
                "POSITION_CODE"         => $row[5],
                "POSITION_DESCRIPTION"  => $row[6],
                "DIVISION_CODE"         => $row[7],
                "DIVISION_DESCRIPTION"  => $row[8],
                "DEPARTMENT_CODE"       => $row[9],
                "DEPARTMENT_DESCRIPTION"=> $row[10],
                "SECTION_CODE"          => $row[11],
                "SECTION_DESCRIPTION"   => $row[12],
                "GRADE_CODE"            => $row[13],
                "GRADE_DESCRIPTION"     => $row[14],
                "DATE_JOINED"           => $attendanceDate,
                "service_days"          => $row[17],
                "attendance_sl"         => $row[18],
                "attendance_pl"         => $row[19],
                "attendance_late"       => $row[20],
                "attendance_abs"        => $row[21],
                "attendance_abt"        => $row[22],
                "attendance_cl"         => $row[23],
                "attendance_ol"         => $row[24],
                "attendance_sus"        => $row[25],
                "attendance_wwar"       => $row[26],
                "attendance_vwar"       => $row[27],
                "attendance_score"      => $row[18] + $row[19] + $row[20] + $row[21],
                "salary_old"       => $row[16],
                "l800avg_wage"     => ($row[13] == 'L800' ? $row[16] : 0),
                "bsalary_wage"     => $row[16],
                "salary_month_old" => $salaryMonthOld,
                "not_up_salary" => $row[28] || null,
                "remark_special" => $row[29] || null,
                "created_by"            => $userId,
                "updated_by"            => '0',
                "created_at"            => now(),
                "updated_at"            => null,
            ]);

            // ใช้ updateOrCreate เพื่อลด query ซ้ำ สำหรับข้อมูล master
            Position::updateOrCreate(
                ["position_code" => $row[5]],
                [
                    "position_description" => $row[6],
                    "created_by"           => $userId,
                    "updated_by"           => '0',
                    "created"              => now(),
                    "updated"              => null,
                ]
            );
            Division::updateOrCreate(
                ["division_code" => $row[7]],
                [
                    "division_description" => $row[8],
                    "created_by"           => $userId,
                    "updated_by"           => '0',
                    "created"              => now(),
                    "updated"              => null,
                ]
            );
            Department::updateOrCreate(
                ["department_code" => $row[9]],
                [
                    "department_description" => $row[10],
                    "created_by"             => $userId,
                    "updated_by"             => '0',
                    "created"                => now(),
                    "updated"                => null,
                ]
            );
            Section::updateOrCreate(
                ["section_code" => $row[11]],
                [
                    "section_description" => $row[12],
                    "created_by"          => $userId,
                    "updated_by"          => '0',
                    "created"             => now(),
                    "updated"             => null,
                ]
            );
            Grademaster::updateOrCreate(
                ["grade_code" => $row[13]],
                [
                    "grade_description" => $row[14],
                    "created_by"        => $userId,
                    "updated_by"        => '0',
                    "created"           => now(),
                    "updated"           => null,
                ]
            );

            // อัปเดตหรือสร้าง EmployeeModel
            EmployeeModel::updateOrCreate(
                ["orisoft_no" => $employeeNo],
                [
                    "title_en"                  => null,
                    "title_th"                  => null,
                    "employee_local_name_en"    => $row[3],
                    "employee_local_name_th"    => $row[4],
                    "position_code"             => $row[5],
                    "position_description"      => $row[6],
                    "division_code"             => $row[7],
                    "division_description"      => $row[8],
                    "department_code"           => $row[9],
                    "department_description"    => $row[10],
                    "section_code"              => $row[11],
                    "section_description"       => $row[12],
                    "grade_code"                => $row[13],
                    "grade_description"         => $row[14],
                    "DATE_JOINED"               => $attendanceDate,
                    "service_days"              => $row[17],
                    "created_by"                => $userId,
                    "updated_by"                => '0',
                    "created_at"                => now(),
                    "updated_at"                => null,
                ]
            );

            // คำนวณข้อมูลสำหรับ EmployeeFinalScore
            $calcompliance = 10 - ($row[22] + ($row[27] * 2) + ($row[26] * 5) + ($row[25] * 10));
            $attendanceScore = $row[18] + $row[19] + $row[20] + $row[21];
            $salaryType = ($row[13] === 'L800') ? 'Daily' : 'Monthly';
            $salaryOld = ($salaryType === 'Monthly') ? $row[16] : $row[16];
            $salaryMonthOld = ($salaryType === 'Daily') ? ((float)$salaryOld * 27) : $salaryOld;

            // ใช้ updateOrCreate สำหรับ EmployeeFinalScore
            EmployeeFinalScore::updateOrCreate(
                [
                    "employee_no" => $employeeNo,
                    "rec_year"    => $checkYear,
                ],
                [
                    "import_id"         => $this->id,
                    "service_days"      => $row[17],
                    "attendance_sl"     => $row[18],
                    "attendance_pl"     => $row[19],
                    "attendance_late"   => $row[20],
                    "attendance_abs"    => $row[21],
                    "attendance_abt"    => $row[22],
                    "attendance_cl"     => $row[23],
                    "attendance_ol"     => $row[24],
                    "attendance_sus"    => $row[25],
                    "attendance_wwar"   => $row[26],
                    "attendance_vwar"   => $row[27],
                    "compliance_score"  => ($calcompliance > 0 ? $calcompliance : 1),
                    "attendance_score"  => $attendanceScore,
                    "salary_type"       => $salaryType,
                    "salary_old"       => $row[16],
                    "l800avg_wage"     => ($row[13] == 'L800' ? $row[16] : 0),
                    "bsalary_wage"     => $row[16],
                    "salary_month_old" => $salaryMonthOld,
                    "created_by"        => $userId,
                    "created_at"        => now(),
                    "not_up_salary" => $row[28] || null
                ]
            );

            // อัปเดต status_pa ถ้ามีเงื่อนไขตรงกัน
            if ($row[6]) {
                DB::table('tb_employee_final_score')
                    ->leftJoin('tb_employee', 'tb_employee.orisoft_no', '=', 'tb_employee_final_score.employee_no')
                    ->where('tb_employee_final_score.rec_year', 'like', '%' . $checkYear . '%')
                    ->where('tb_employee.department_code', $row[9])
                    ->where('tb_employee_final_score.status_pa', '0')
                    ->update(["status_pa" => '1']);
            }
        });

    }
}
