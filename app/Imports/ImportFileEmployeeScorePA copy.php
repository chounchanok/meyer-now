<?php

namespace App\Imports;
use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\FinalScoreLog;
use App\Models\EmployeeModel;
use App\Models\EmployeeFinalScore;
use App\Models\group\Position;
use App\Models\group\Section;
use App\Models\group\Grademaster;

use App\Models\formEvaluate\formEvaluate;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImportFileEmployeeScorePA implements ToModel
{
    private $id;
    private $form;
    private $weight;

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
        //  dd($row[0]);
        //  exit;
        // if (!isset($row[2])) {
        //     return null;
        // }
        if (!isset($row[2])) {
            return null;
        }
        if ($row[0] == 'Year') {
            return null;
        }

        // ini_set('max_execution_time',180);
        // ini_set('memory_limit', '1024M');

        //  dd($row);
        //  exit;

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Ym');
            $checkYear = date('Y');
        // }

        $countformEvaluate = formEvaluate::where('form_ref',$row[5])->count();
        if($countformEvaluate == 0){
            $group_form_id = 0;
        }else{
            $rowformEvaluate = formEvaluate::where('form_ref',$row[5])->first();
            $group_form_id = $rowformEvaluate->id;
        }
        $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[2]))
        ->where('rec_year','like','%'.$checkYear.'%')
        ->first();

        // $eva = EmployeeModel::select('employee_local_name_th','employee_local_name_en')->where('orisoft_no',$row[6])->first();
        if($rowdata){
        //     dd($rowdata);
        // exit;
            $row_group_form_topic = DB::table('group_form_topic')->select('evaluation_criteria_id')->where('group_form_id', $group_form_id)->get();

            $evaluation_criteria_id = '';
            $evaluation_criteria_id_comma = '';
            foreach ($row_group_form_topic as $key2 => $val2) {
                $evaluation_criteria_id .= $val2->evaluation_criteria_id.',';
                $evaluation_criteria_id_comma .= ',';
            }
            $evaluation_criteria_id = substr($evaluation_criteria_id,0,-1);
            DB::table('tb_employee_final_score')
            ->where('employee_no', sprintf("%06d", $row[2]) )
            ->update([
                "previous_form" => ($row[5]!="" && $row[5]!="-"?$row[5]:NULL),
                "form_import" => ($row[5]!="" && $row[5]!="-"?$row[5]:NULL),
                "group_form_id" => ($row[5]!="" && $row[5]!="-"?$group_form_id:0),
                "previous_evaluator_no" => ($row[7]!=""?sprintf("%06d", $row[7]):NULL),
                "evaluator_no" => ($row[7]!=""?sprintf("%06d", $row[7]):NULL),
                "evaluator_name_th" => $row[9],
                "evaluator_name_en" => $row[8],
                "evaluation_criteria_id" => $evaluation_criteria_id,
                "criteria_score_old" => $evaluation_criteria_id_comma,
                "criteria_score_new" => $evaluation_criteria_id_comma,
            ]);
        }

        // exit;





        // if($row[5] != ""){
        //     $this->form = $row[5];
        // }
        // // if($row[0] != "" && $row[1] == null){
        // //     echo $row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.$row[14].','.$row[15].','.$row[16];
        // // }
        // // echo $row[0];
        // // exit;

        // if($row[0] != "" && $row[1] == null){
        //     $this->weight .= $row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.$row[14].','.$row[15].','.$row[16].','.$row[17];
        // }else{
        //     $countformEvaluate = formEvaluate::where('form_ref',$row[5])->count();
        //     if($countformEvaluate == 0){
        //         $group_form_id = 0;
        //     }else{
        //         $rowformEvaluate = formEvaluate::where('form_ref',$row[5])->first();
        //         $group_form_id = $rowformEvaluate->id;
        //     }

        //     $countEmployeeModel = EmployeeModel::where('orisoft_no', sprintf("%06d", $row[0]))->count();
        //     if($countEmployeeModel == 0){
        //         $rowPosition = Position::where('position_description',$row[2])->first();
        //         $rowSection = Section::where('section_code',$row[3])->first();
        //         $rowGrade = Grademaster::where('grade_code',$row[4])->first();
        //         $CreateEmployeeModel = EmployeeModel::create([
        //             "orisoft_no" => sprintf("%06d", $row[0]),
        //             "employee_local_name_th" => $row[1],
        //             "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //             "position_description" => $row[2],
        //             "section_code" => $row[3],
        //             "section_description" => ($rowSection?$rowSection->section_description:null),
        //             "grade_code" => $row[4],
        //             "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //             "created_by" => Auth::user()->id,
        //             "updated_by" => '0',
        //             "created_at" => date('Y-m-d H:i:s'),
        //             "updated_at" => null,
        //         ]);
        //     }else{
        //         $rowPosition = Position::where('position_description',$row[2])->first();
        //         $rowSection = Section::where('section_code',$row[3])->first();
        //         $rowGrade = Grademaster::where('grade_code',$row[4])->first();
        //         DB::table('tb_employee')->where('orisoft_no', sprintf("%06d", $row[0]) )->update([
        //             "employee_local_name_th" => $row[1],
        //             "position_code" => ($rowPosition?$rowPosition->position_code:null),
        //             "position_description" => $row[2],
        //             "section_code" => $row[3],
        //             "section_description" => ($rowSection?$rowSection->section_description:null),
        //             "grade_code" => $row[4],
        //             "grade_description" => ($rowGrade?$rowGrade->grade_description:null),
        //             'updated_at' => date('Y-m-d H:i:s'),
        //             'updated_by' => Auth::user()->id,
        //         ]);
        //     }

        //     $cut = explode(',',$this->weight);
        //     if($row[0] != "" && $row[0] != null){
        //         $eva = EmployeeModel::select('employee_local_name_th','employee_local_name_en')->where('orisoft_no',$row[6])->first();
        //         if($this->form == "F1"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             $Emp = FinalScoreLog::create([
        //                 "id_file" => $this->id,
        //                 "rec_year" => $checkYear,
        //                 "employee_no" => sprintf("%06d", $row[0]),
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "attendance_score" => $row[15],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[18],
        //                 "created_by" => Auth::user()->id,
        //                 "updated_by" => '0',
        //                 "created_at" => date('Y-m-d H:i:s'),
        //                 "updated_at" => null,
        //             ]);
        //         }else if($this->form == "F2"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8])+($row[16]*$cut[9])+($row[17]*$cut[10]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             $Emp = FinalScoreLog::create([
        //                 "id_file" => $this->id,
        //                 "rec_year" => $checkYear,
        //                 "employee_no" => sprintf("%06d", $row[0]),
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "evaluation_criteria_score9" => $row[15],
        //                 "evaluation_criteria_score10" => $row[16],
        //                 "attendance_score" => $row[17],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adj    `ust_grade" => $pa_grade,
        //                 "remark" => $row[20],
        //                 "created_by" => Auth::user()->id,
        //                 "updated_by" => '0',
        //                 "created_at" => date('Y-m-d H:i:s'),
        //                 "updated_at" => null,
        //             ]);
        //         }else if($this->form == "F3"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             $Emp = FinalScoreLog::create([
        //                 "id_file" => $this->id,
        //                 "rec_year" => $checkYear,
        //                 "employee_no" => sprintf("%06d", $row[0]),
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "attendance_score" => $row[15],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[18],
        //                 "created_by" => Auth::user()->id,
        //                 "updated_by" => '0',
        //                 "created_at" => date('Y-m-d H:i:s'),
        //                 "updated_at" => null,
        //             ]);
        //         }else if($this->form == "F4"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8])+($row[16]*$cut[9]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             $Emp = FinalScoreLog::create([
        //                 "id_file" => $this->id,
        //                 "rec_year" => $checkYear,
        //                 "employee_no" => sprintf("%06d", $row[0]),
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "evaluation_criteria_score9" => $row[15],
        //                 "attendance_score" => $row[16],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[19],
        //                 "created_by" => Auth::user()->id,
        //                 "updated_by" => '0',
        //                 "created_at" => date('Y-m-d H:i:s'),
        //                 "updated_at" => null,
        //             ]);
        //         }
        //     }

        //     $count = DB::table('tb_employee_final_score')
        //         ->where('employee_no', sprintf("%06d", $row[0]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->where('form_import',$row[5])
        //         ->count();

        //     // $count = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
        //     // ->where('rec_year','like','%'.$checkYear.'%')
        //     // ->where('form_import',$row[5])
        //     // ->count();

        //     // dd(sprintf("%06d", $row[0]));

        //     if($count == 0){
        //         if($row[0] != "" && $row[0] != null){
        //             $eva = EmployeeModel::select('employee_local_name_th','employee_local_name_en')->where('orisoft_no',$row[6])->first();
        //             if($this->form == "F1"){
        //                 $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8]);
        //                 if($total < 50){
        //                     $pa_grade = 'E';
        //                 }else if($total <= 59){
        //                     $pa_grade = 'D';
        //                 }else if($total <= 69){
        //                     $pa_grade = 'C';
        //                 }else if($total <= 79){
        //                     $pa_grade = 'B';
        //                 }else{
        //                     $pa_grade = 'A';
        //                 }
        //                 $Emp = EmployeeFinalScore::create([
        //                     "import_score_id" => $this->id,
        //                     "rec_year" => $checkYear,
        //                     "employee_no" => sprintf("%06d", $row[0]),
        //                     "form_import" => $row[5],
        //                     "group_form_id" => $group_form_id,
        //                     "evaluator_no" => $row[6],
        //                     "evaluator_name_th" => $eva->employee_local_name_th,
        //                     "evaluator_name_en" => $eva->employee_local_name_en,
        //                     "evaluation_criteria_score1" => $row[7],
        //                     "evaluation_criteria_score2" => $row[8],
        //                     "evaluation_criteria_score3" => $row[9],
        //                     "evaluation_criteria_score4" => $row[10],
        //                     "evaluation_criteria_score5" => $row[11],
        //                     "evaluation_criteria_score6" => $row[12],
        //                     "evaluation_criteria_score7" => $row[13],
        //                     "evaluation_criteria_score8" => $row[14],
        //                     "attendance_score" => $row[15],
        //                     "total_score" => $total,
        //                     "pa_grade" => $pa_grade,
        //                     "adjust_grade" => $pa_grade,
        //                     "remark" => $row[18],
        //                     "created_by" => Auth::user()->id,
        //                     "created_at" => date('Y-m-d H:i:s'),
        //                 ]);
        //             }else if($this->form == "F2"){
        //                 $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8])+($row[16]*$cut[9])+($row[17]*$cut[10]);
        //                 if($total < 50){
        //                     $pa_grade = 'E';
        //                 }else if($total <= 59){
        //                     $pa_grade = 'D';
        //                 }else if($total <= 69){
        //                     $pa_grade = 'C';
        //                 }else if($total <= 79){
        //                     $pa_grade = 'B';
        //                 }else{
        //                     $pa_grade = 'A';
        //                 }
        //                 $Emp = EmployeeFinalScore::create([
        //                     "import_score_id" => $this->id,
        //                     "rec_year" => $checkYear,
        //                     "employee_no" => sprintf("%06d", $row[0]),
        //                     "form_import" => $row[5],
        //                     "group_form_id" => $group_form_id,
        //                     "evaluator_no" => $row[6],
        //                     "evaluator_name_th" => $eva->employee_local_name_th,
        //                     "evaluator_name_en" => $eva->employee_local_name_en,
        //                     "evaluation_criteria_score1" => $row[7],
        //                     "evaluation_criteria_score2" => $row[8],
        //                     "evaluation_criteria_score3" => $row[9],
        //                     "evaluation_criteria_score4" => $row[10],
        //                     "evaluation_criteria_score5" => $row[11],
        //                     "evaluation_criteria_score6" => $row[12],
        //                     "evaluation_criteria_score7" => $row[13],
        //                     "evaluation_criteria_score8" => $row[14],
        //                     "evaluation_criteria_score9" => $row[15],
        //                     "evaluation_criteria_score10" => $row[16],
        //                     "attendance_score" => $row[17],
        //                     "total_score" => $total,
        //                     "pa_grade" => $pa_grade,
        //                     "adjust_grade" => $pa_grade,
        //                     "remark" => $row[20],
        //                     "created_by" => Auth::user()->id,
        //                     "created_at" => date('Y-m-d H:i:s'),
        //                 ]);
        //             }else if($this->form == "F3"){
        //                 $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8]);
        //                 if($total < 50){
        //                     $pa_grade = 'E';
        //                 }else if($total <= 59){
        //                     $pa_grade = 'D';
        //                 }else if($total <= 69){
        //                     $pa_grade = 'C';
        //                 }else if($total <= 79){
        //                     $pa_grade = 'B';
        //                 }else{
        //                     $pa_grade = 'A';
        //                 }
        //                 $Emp = EmployeeFinalScore::create([
        //                     "import_score_id" => $this->id,
        //                     "rec_year" => $checkYear,
        //                     "employee_no" => sprintf("%06d", $row[0]),
        //                     "form_import" => $row[5],
        //                     "group_form_id" => $group_form_id,
        //                     "evaluator_no" => $row[6],
        //                     "evaluator_name_th" => $eva->employee_local_name_th,
        //                     "evaluator_name_en" => $eva->employee_local_name_en,
        //                     "evaluation_criteria_score1" => $row[7],
        //                     "evaluation_criteria_score2" => $row[8],
        //                     "evaluation_criteria_score3" => $row[9],
        //                     "evaluation_criteria_score4" => $row[10],
        //                     "evaluation_criteria_score5" => $row[11],
        //                     "evaluation_criteria_score6" => $row[12],
        //                     "evaluation_criteria_score7" => $row[13],
        //                     "evaluation_criteria_score8" => $row[14],
        //                     "attendance_score" => $row[15],
        //                     "total_score" => $total,
        //                     "pa_grade" => $pa_grade,
        //                     "adjust_grade" => $pa_grade,
        //                     "remark" => $row[18],
        //                     "created_by" => Auth::user()->id,
        //                     "created_at" => date('Y-m-d H:i:s'),
        //                 ]);
        //             }else if($this->form == "F4"){
        //                 $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8])+($row[16]*$cut[9]);
        //                 if($total < 50){
        //                     $pa_grade = 'E';
        //                 }else if($total <= 59){
        //                     $pa_grade = 'D';
        //                 }else if($total <= 69){
        //                     $pa_grade = 'C';
        //                 }else if($total <= 79){
        //                     $pa_grade = 'B';
        //                 }else{
        //                     $pa_grade = 'A';
        //                 }
        //                 $Emp = EmployeeFinalScore::create([
        //                     "import_score_id" => $this->id,
        //                     "rec_year" => $checkYear,
        //                     "employee_no" => sprintf("%06d", $row[0]),
        //                     "form_import" => $row[5],
        //                     "group_form_id" => $group_form_id,
        //                     "evaluator_no" => $row[6],
        //                     "evaluator_name_th" => $eva->employee_local_name_th,
        //                     "evaluator_name_en" => $eva->employee_local_name_en,
        //                     "evaluation_criteria_score1" => $row[7],
        //                     "evaluation_criteria_score2" => $row[8],
        //                     "evaluation_criteria_score3" => $row[9],
        //                     "evaluation_criteria_score4" => $row[10],
        //                     "evaluation_criteria_score5" => $row[11],
        //                     "evaluation_criteria_score6" => $row[12],
        //                     "evaluation_criteria_score7" => $row[13],
        //                     "evaluation_criteria_score8" => $row[14],
        //                     "evaluation_criteria_score9" => $row[15],
        //                     "attendance_score" => $row[16],
        //                     "total_score" => $total,
        //                     "pa_grade" => $pa_grade,
        //                     "adjust_grade" => $pa_grade,
        //                     "remark" => $row[19],
        //                     "created_by" => Auth::user()->id,
        //                     "created_at" => date('Y-m-d H:i:s'),
        //                 ]);
        //             }
        //         }
        //     }else{
        //         $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[0]))
        //         ->where('rec_year','like','%'.$checkYear.'%')
        //         ->where('form_import',$row[5])
        //         ->orderBy('id','desc')
        //         ->first();
        //         $eva = EmployeeModel::select('employee_local_name_th','employee_local_name_en')->where('orisoft_no',$row[6])->first();
        //         if($this->form == "F1"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //                 "import_score_id" => $this->id,
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "attendance_score" => $row[15],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[18],
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //                 'updated_by' => Auth::user()->id,
        //             ]);
        //         }else if($this->form == "F2"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8])+($row[16]*$cut[9])+($row[17]*$cut[10]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //                 "import_score_id" => $this->id,
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "evaluation_criteria_score9" => $row[15],
        //                 "evaluation_criteria_score10" => $row[16],
        //                 "attendance_score" => $row[17],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[20],
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //                 'updated_by' => Auth::user()->id,
        //             ]);
        //         }else if($this->form == "F3"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //                 "import_score_id" => $this->id,
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "attendance_score" => $row[15],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[18],
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //                 'updated_by' => Auth::user()->id,
        //             ]);
        //         }else if($this->form == "F4"){
        //             $total = ($row[7]*$cut[0])+($row[8]*$cut[1])+($row[9]*$cut[2])+($row[10]*$cut[3])+($row[11]*$cut[4])+($row[12]*$cut[5])+($row[13]*$cut[6])+($row[14]*$cut[7])+($row[15]*$cut[8])+($row[16]*$cut[9]);
        //             if($total < 50){
        //                 $pa_grade = 'E';
        //             }else if($total <= 59){
        //                 $pa_grade = 'D';
        //             }else if($total <= 69){
        //                 $pa_grade = 'C';
        //             }else if($total <= 79){
        //                 $pa_grade = 'B';
        //             }else{
        //                 $pa_grade = 'A';
        //             }
        //             DB::table('tb_employee_final_score')->where('id', $rowdata->id )->update([
        //                 "import_score_id" => $this->id,
        //                 "form_import" => $row[5],
        //                 "group_form_id" => $group_form_id,
        //                 "evaluator_no" => $row[6],
        //                 "evaluator_name_th" => $eva->employee_local_name_th,
        //                 "evaluator_name_en" => $eva->employee_local_name_en,
        //                 "evaluation_criteria_score1" => $row[7],
        //                 "evaluation_criteria_score2" => $row[8],
        //                 "evaluation_criteria_score3" => $row[9],
        //                 "evaluation_criteria_score4" => $row[10],
        //                 "evaluation_criteria_score5" => $row[11],
        //                 "evaluation_criteria_score6" => $row[12],
        //                 "evaluation_criteria_score7" => $row[13],
        //                 "evaluation_criteria_score8" => $row[14],
        //                 "evaluation_criteria_score9" => $row[15],
        //                 "attendance_score" => $row[16],
        //                 "total_score" => $total,
        //                 "pa_grade" => $pa_grade,
        //                 "adjust_grade" => $pa_grade,
        //                 "remark" => $row[19],
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //                 'updated_by' => Auth::user()->id,
        //             ]);
        //         }
        //     }


        // }

        // if($this->weight != ""){
        //     if($this->form == "F1"){
        //         $rowformEvaluate_data = formEvaluate::where('form_ref',$this->form)->first();
        //         $group_form_id_data = $rowformEvaluate_data->id;
        //         $cut = explode(',',$this->weight);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '1' )->update(["topic_weight" => $cut[0]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '2' )->update(["topic_weight" => $cut[1]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '4' )->update(["topic_weight" => $cut[2]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '6' )->update(["topic_weight" => $cut[3]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '13' )->update(["topic_weight" => $cut[4]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '7' )->update(["topic_weight" => $cut[5]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '8' )->update(["topic_weight" => $cut[6]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '9' )->update(["topic_weight" => $cut[7]]);

        //     }else if($this->form == "F2"){
        //         $rowformEvaluate_data = formEvaluate::where('form_ref',$this->form)->first();
        //         $group_form_id_data = $rowformEvaluate_data->id;
        //         $cut = explode(',',$this->weight);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '1' )->update(["topic_weight" => $cut[0]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '2' )->update(["topic_weight" => $cut[1]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '3' )->update(["topic_weight" => $cut[2]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '4' )->update(["topic_weight" => $cut[3]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '5' )->update(["topic_weight" => $cut[4]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '6' )->update(["topic_weight" => $cut[5]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '13' )->update(["topic_weight" => $cut[6]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '7' )->update(["topic_weight" => $cut[7]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '8' )->update(["topic_weight" => $cut[8]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '9' )->update(["topic_weight" => $cut[9]]);

        //     }else if($this->form == "F3"){
        //         $rowformEvaluate_data = formEvaluate::where('form_ref',$this->form)->first();
        //         $group_form_id_data = $rowformEvaluate_data->id;
        //         $cut = explode(',',$this->weight);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '1' )->update(["topic_weight" => $cut[0]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '2' )->update(["topic_weight" => $cut[1]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '4' )->update(["topic_weight" => $cut[2]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '5' )->update(["topic_weight" => $cut[3]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '6' )->update(["topic_weight" => $cut[4]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '7' )->update(["topic_weight" => $cut[5]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '8' )->update(["topic_weight" => $cut[6]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '9' )->update(["topic_weight" => $cut[7]]);

        //     }else if($this->form == "F4"){
        //         $rowformEvaluate_data = formEvaluate::where('form_ref',$this->form)->first();
        //         $group_form_id_data = $rowformEvaluate_data->id;
        //         $cut = explode(',',$this->weight);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '1' )->update(["topic_weight" => $cut[0]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '2' )->update(["topic_weight" => $cut[1]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '3' )->update(["topic_weight" => $cut[2]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '4' )->update(["topic_weight" => $cut[3]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '5' )->update(["topic_weight" => $cut[4]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '6' )->update(["topic_weight" => $cut[5]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '7' )->update(["topic_weight" => $cut[6]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '8' )->update(["topic_weight" => $cut[7]]);
        //         DB::table('group_form_topic')->where('group_form_id', $group_form_id_data )->where('evaluation_criteria_id', '9' )->update(["topic_weight" => $cut[8]]);

        //     }
        // }
    }
}
