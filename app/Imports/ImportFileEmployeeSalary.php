<?php

namespace App\Imports;
use App\Http\Controllers\Controller;
use App\Models\SalaryLog;
use App\Models\EmployeeEvaluator;
use App\Models\EmployeeFinalScore;
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

class ImportFileEmployeeSalary implements ToModel
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
        //  dd($row, $this->id);

        if (!isset($row[2])) {
            return null;
        }
        if ($row[0] == 'Division_code' || $row[0] == 'employee_no') {
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

        //  dd($row);
        //  exit;

        if(trans(request()->segment(1)) == 'mtl'){
            $salary = 0;
            $l800avg_wage = 0;
            $bsalary_wage = 0;
            $salary_month = 0;
            $salary_type = null;
            $salary = $row[13];
            $salary_month = $row[13];
            $l800avg_wage = 0;
            $bsalary_wage = $row[13];
            $salary_type = 'Monthly';

            $Emp = SalaryLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                // "branch" => $row[0],
                "employee_no" => sprintf("%06d", $row[10]),
                "employee_name" => $row[11],
                "division_code" => $row[0],
                "department_code" => $row[2],
                "section_code" => $row[4],
                "grade_code" => $row[6],
                // "category" => $row[5],
                "position_code" => $row[8],
                "position_description" => $row[9],
                "salary" => $salary,
                "salary_month" => $salary_month,
                "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);


            DB::table('tb_employee_final_score')
            ->where('employee_no', sprintf("%06d", $row[10]))
            ->where('rec_year','like','%'.$checkYear.'%')
            ->update([
                "import_score_id" => $this->id,
                "salary_type" => $salary_type,
                "salary_old" => $salary,
                "l800avg_wage" => $l800avg_wage,
                "bsalary_wage" => $bsalary_wage,
                "salary_month_old" => $salary_month,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);
        }else if(trans(request()->segment(1)) == 'manager'){
            $salary = 0;
            $l800avg_wage = 0;
            $bsalary_wage = 0;
            $salary_month = 0;
            $salary_type = null;

            $salary = $row[17];
            $salary_month = $row[17];
            $l800avg_wage = 0;
            $bsalary_wage = $row[17];
            $salary_type = 'Monthly';

            $Emp = SalaryLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                // "branch" => $row[0],
                "employee_no" => sprintf("%06d", $row[0]),
                "employee_name" => $row[3],
                "division_code" => $row[7],
                "department_code" => $row[9],
                "section_code" => $row[10],
                "grade_code" => $row[12],
                // "category" => $row[5],
                "position_code" => $row[5],
                "position_description" => $row[6],
                "salary" => $salary,
                "salary_month" => $salary_month,
                "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);


            DB::table('tb_employee_final_score')
            ->where('employee_no', sprintf("%06d", $row[0]))
            ->where('rec_year','like','%'.$checkYear.'%')
            ->update([
                "import_score_id" => $this->id,
                "salary_type" => $salary_type,
                "salary_old" => $salary,
                "l800avg_wage" => $l800avg_wage,
                "bsalary_wage" => $bsalary_wage,
                "salary_month_old" => $salary_month,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);
        }else{
            $salary = 0;
            $l800avg_wage = 0;
            $bsalary_wage = 0;
            $salary_month = 0;
            $salary_type = null;
            $salary = $row[17];
            $salary_month = $row[17];
            $l800avg_wage = 0;
            $bsalary_wage = $row[17];
            $salary_type = 'Monthly';

            $Emp = SalaryLog::create([
                "id_file" => $this->id,
                "rec_year" => $checkYear,
                // "branch" => $row[0],
                "employee_no" => sprintf("%06d", $row[0]),
                "employee_name" => $row[11],
                "division_code" => $row[0],
                "department_code" => $row[2],
                "section_code" => $row[4],
                "grade_code" => $row[6],
                // "category" => $row[5],
                "position_code" => $row[8],
                "position_description" => $row[9],
                "salary" => $salary,
                "salary_month" => $salary_month,
                "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);


            DB::table('tb_employee_final_score')
            ->where('employee_no', sprintf("%06d", $row[0]))
            ->where('rec_year','like','%'.$checkYear.'%')
            ->update([
                "import_score_id" => $this->id,
                "salary_type" => $salary_type,
                "salary_old" => $salary,
                "l800avg_wage" => $l800avg_wage,
                "bsalary_wage" => $bsalary_wage,
                "salary_month_old" => $salary_month,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);
        }

    }

    public function modelbk2(array $row)
    {
        //  dd($row, $this->id);

        if (!isset($row[2])) {
            return null;
        }
        if ($row[0] == 'DIVISION_CODE' || $row[0] == 'Division_code' || $row[0] == 'employee_no') {
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

        //  dd($row);
        //  exit;
         $employeeNo = sprintf("%06d", $row[10]);
         $Emp = SalaryLog::create([
            "id_file" => $this->id,
            "rec_year" => $checkYear,
            // "branch" => $row[0],
            "employee_no" => $employeeNo,
            "employee_name" => $row[11],
            "division_code" => $row[0],
            "department_code" => $row[2],
            "section_code" => $row[4],
            "grade_code" => $row[6],
            // "category" => $row[5],
            "position_code" => $row[8],
            "position_description" => $row[9],
            "salary" => $row[13],
            "salary_month" => $row[13],
            "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
            "created_by" => Auth::user()->id,
            "updated_by" => '0',
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => null,
        ]);


        DB::table('tb_employee_final_score')
        ->where('employee_no', $employeeNo)
        ->where('rec_year','like','%'.$checkYear.'%')
        ->update([
            "import_score_id" => $this->id,
            // "salary_type" => $salary_type,
            "salary_old" => $row[13],
            "l800avg_wage" => ($row[6]=='L800'?$row[13]:0),
            "bsalary_wage" => $row[13],
            "salary_month_old" => $row[13],
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);

    }

    public function model(array $row)
    {
        // ตรวจสอบข้อมูลเบื้องต้น
        if (!isset($row[2])) {
            return null;
        }
        if (in_array($row[0], ['DIVISION_CODE', 'Division_code', 'employee_no'])) {
            return null;
        }

        // ปรับแต่งค่าการทำงาน (หากจำเป็น)
        // ini_set('max_execution_time', 360);
        // ini_set('memory_limit', '2048M');

        // กำหนดปีที่ใช้งาน
        $checkYear = date('Y'); // ปีปัจจุบัน เช่น 2025

        // Cache ค่าที่ใช้ซ้ำ
        $userId = Auth::user()->id;
        $currentTimestamp = now(); // ใช้ Carbon::now() แทน date('Y-m-d H:i:s')
        $employeeNo = sprintf("%06d", $row[10]);

        // ใช้ Transaction ครอบทั้งการสร้าง record และ update ใน DB
        DB::transaction(function () use ($row, $employeeNo, $checkYear, $userId, $currentTimestamp) {
            // สร้าง record ใน SalaryLog
            $salaryLogData = [
                "id_file"              => $this->id,
                "rec_year"             => $checkYear,
                "employee_no"          => $employeeNo,
                "employee_name"        => $row[11],
                "division_code"        => $row[0],
                "department_code"      => $row[2],
                "section_code"         => $row[4],
                "grade_code"           => $row[6],
                "position_code"        => $row[8],
                "position_description" => $row[9],
                "salary"               => $row[13],
                "salary_month"         => $row[13],
                "date_joined"          => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
                "created_by"           => $userId,
                "updated_by"           => '0',
                "created_at"           => $currentTimestamp,
                "updated_at"           => null,
            ];
            SalaryLog::create($salaryLogData);

            // Update ตาราง tb_employee_final_score สำหรับ record ที่มี employee_no และ rec_year ตรงกัน
            DB::table('tb_employee_final_score')
                ->where('employee_no', $employeeNo)
                ->where('rec_year', 'like', '%'.$checkYear.'%')
                ->update([
                    "import_score_id"  => $this->id,
                    "salary_old"       => $row[13],
                    "l800avg_wage"     => ($row[6] == 'L800' ? $row[13] : 0),
                    "bsalary_wage"     => $row[13],
                    "salary_month_old" => $row[13],
                    "updated_at"       => $currentTimestamp,
                    "updated_by"       => $userId,
                ]);
        });
    }
}
