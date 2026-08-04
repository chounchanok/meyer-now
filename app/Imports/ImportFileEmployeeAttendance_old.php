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

        if (!isset($row[2])) {
            return null;
        }
        // ini_set('max_execution_time',180);
        // ini_set('memory_limit', '1024M');
        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Y');
            $checkYear = date('Y');
        // }

        $Emp = AttendanceLog::create([
            "id_file" => $this->id,
            "rec_year" => $checkYear,
            "employee_no" => sprintf("%06d", $row[0]),
            "service_days" => $row[14],
            "attendance_sl" => $row[15],
            "attendance_pl" => $row[16],
            "attendance_late" => $row[17],
            "attendance_abs" => $row[18],
            "attendance_abt" => $row[19],
            "attendance_sus" => $row[20],
            "attendance_wwar" => $row[21],
            "attendance_vwar" => $row[22],
            "attendance_score" => $row[15]+$row[16]+$row[17]+$row[18],
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
        $countDivision = Division::where('division_code', $row[3])->count();
        if($countDivision == 0){
            $CreateDivision = Division::create([
                "division_code" => $row[3],
                "division_description" => $row[4],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created" => date('Y-m-d H:i:s'),
                "updated" => null,
            ]);
        }
        $countDepartment = Department::where('department_code', $row[3])->count();
        if($countDepartment == 0){
            $CreateDepartment = Department::create([
                "department_code" => $row[3],
                "department_description" => $row[4],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created" => date('Y-m-d H:i:s'),
                "updated" => null,
            ]);
        }
        $countSection = Section::where('section_code', $row[3])->count();
        if($countSection == 0){
            $CreateSection = Section::create([
                "section_code" => $row[3],
                "section_description" => $row[4],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created" => date('Y-m-d H:i:s'),
                "updated" => null,
            ]);
        }
        $countGrademaster = Grademaster::where('grade_code', $row[3])->count();
        if($countGrademaster == 0){
            $CreateGrademaster = Grademaster::create([
                "grade_code" => $row[3],
                "grade_description" => $row[4],
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
                "employee_local_name_en" => $row[1],
                "employee_local_name_th" => $row[2],
                "position_code" => $row[3],
                "position_description" => $row[4],
                "division_code" => $row[5],
                "division_description" => $row[6],
                "department_code" => $row[7],
                "department_description" => $row[8],
                "section_code" => $row[9],
                "section_description" => $row[10],
                "grade_code" => $row[11],
                "grade_description" => $row[12],
                "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[13]),
                "service_days" => $row[14],
                "created_by" => Auth::user()->id,
                "updated_by" => '0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => null,
            ]);
        }else{
            DB::table('tb_employee')
            ->where('orisoft_no', sprintf("%06d", $row[0]) )
            ->update([
                "employee_local_name_en" => $row[1],
                "employee_local_name_th" => $row[2],
                "position_code" => $row[3],
                "position_description" => $row[4],
                "division_code" => $row[5],
                "division_description" => $row[6],
                "department_code" => $row[7],
                "department_description" => $row[8],
                "section_code" => $row[9],
                "section_description" => $row[10],
                "grade_code" => $row[11],
                "grade_description" => $row[12],
                "date_joined" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[13]),
                "service_days" => $row[14],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);
        }

        $count = DB::table('tb_employee_final_score')
                ->where('employee_no', sprintf("%06d", $row[0]))
                ->where('rec_year','like','%'.$checkYear.'%')
                ->count();
        if($count == 0){
            $Emp = EmployeeFinalScore::create([
                "import_id" => $this->id,
                "rec_year" => $checkYear,
                "employee_no" => sprintf("%06d", $row[0]),
                "service_days" => $row[14],
                "attendance_sl" => $row[15],
                "attendance_pl" => $row[16],
                "attendance_late" => $row[17],
                "attendance_abs" => $row[18],
                "attendance_abt" => $row[19],
                "attendance_sus" => $row[20],
                "attendance_wwar" => $row[21],
                "attendance_vwar" => $row[22],
                "compliance_score" => $row[19]+$row[20]+$row[21]+$row[22],
                "attendance_score" => $row[15]+$row[16]+$row[17]+$row[18],
                "created_by" => Auth::user()->id,
                "created_at" => date('Y-m-d H:i:s'),
            ]);
            if($row[7]){
                DB::table('tb_employee_final_score')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                ->where('tb_employee.department_code',$row[7])
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
                "service_days" => $row[14],
                "attendance_sl" => $row[15],
                "attendance_pl" => $row[16],
                "attendance_late" => $row[17],
                "attendance_abs" => $row[18],
                "attendance_abt" => $row[19],
                "attendance_sus" => $row[20],
                "attendance_wwar" => $row[21],
                "attendance_vwar" => $row[22],
                "compliance_score" => $row[19]+$row[20]+$row[21]+$row[22],
                "attendance_score" => $row[15]+$row[16]+$row[17]+$row[18],
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            ]);
            if($row[7]){
                DB::table('tb_employee_final_score')
                ->leftJoin('tb_employee','tb_employee.orisoft_no','=','tb_employee_final_score.employee_no')
                ->where('tb_employee_final_score.rec_year','like','%'.$checkYear.'%')
                ->where('tb_employee.department_code',$row[7])
                ->where('tb_employee_final_score.status_pa','0')
                ->update([
                    "status_pa" => '1'
                ]);
            }
        }
    }
}
