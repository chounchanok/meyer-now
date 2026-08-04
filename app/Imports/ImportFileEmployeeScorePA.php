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
        // ini_set('memory_limit', '2048M');

        //  dd($row);
        //  exit;

        // if(date('Y-m') <= (date('Y').'-2')){
        //     $previousYear = date('Ym', strtotime('-1 year'));
        //     $checkYear = date('Y', strtotime('-1 year'));
        // }else{
            $previousYear = date('Ym');
            $checkYear = date('Y');
        // }

        if(trans(request()->segment(1)) == 'mtl'){
            $countformEvaluate = formEvaluate::where('form_ref',$row[21])->count();
            if($countformEvaluate == 0){
                $group_form_id = 0;
            }else{
                $rowformEvaluate = formEvaluate::where('form_ref',$row[21])->first();
                $group_form_id = $rowformEvaluate->id;
            }
            $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[2]))
            ->where('rec_year','like','%'.$checkYear.'%')
            ->first();

            if($rowdata){
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
                    "previous_form" => ($row[20]!="" && $row[20]!="-"?$row[20]:NULL),
                    "form_import" => ($row[21]!="" && $row[21]!="-"?$row[21]:NULL),
                    "group_form_id" => ($row[21]!="" && $row[21]!="-"?$group_form_id:0),
                    // "previous_evaluator_no" => ($row[7]!=""?sprintf("%06d", $row[7]):NULL),
                    "evaluator_no" => ($row[22]!=""?sprintf("%06d", $row[22]):NULL),
                    "evaluator_name_th" => $row[24],
                    "evaluator_name_en" => $row[23],
                    "evaluation_criteria_id" => $evaluation_criteria_id,
                    "criteria_score_eva" => $evaluation_criteria_id_comma,
                    "criteria_score_old" => $evaluation_criteria_id_comma,
                    "criteria_score_new" => $evaluation_criteria_id_comma,
                ]);
            }
        }else if(trans(request()->segment(1)) == 'manager'){
            $countformEvaluate = formEvaluate::where('form_ref',$row[21])->count();
            if($countformEvaluate == 0){
                $group_form_id = 0;
            }else{
                $rowformEvaluate = formEvaluate::where('form_ref',$row[21])->first();
                $group_form_id = $rowformEvaluate->id;
            }
            $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[2]))
            ->where('rec_year','like','%'.$checkYear.'%')
            ->first();

            if($rowdata){
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
                    "previous_form" => ($row[20]!="" && $row[20]!="-"?$row[20]:NULL),
                    "form_import" => ($row[21]!="" && $row[21]!="-"?$row[21]:NULL),
                    "group_form_id" => ($row[21]!="" && $row[21]!="-"?$group_form_id:0),
                    // "previous_evaluator_no" => ($row[7]!=""?sprintf("%06d", $row[7]):NULL),
                    "evaluator_no" => ($row[22]!=""?sprintf("%06d", $row[22]):NULL),
                    "evaluator_name_th" => $row[24],
                    "evaluator_name_en" => $row[23],
                    "evaluation_criteria_id" => $evaluation_criteria_id,
                    "criteria_score_eva" => $evaluation_criteria_id_comma,
                    "criteria_score_old" => $evaluation_criteria_id_comma,
                    "criteria_score_new" => $evaluation_criteria_id_comma,
                ]);
            }
        }else{
            $countformEvaluate = formEvaluate::where('form_ref',$row[21])->count();
            if($countformEvaluate == 0){
                $group_form_id = 0;
            }else{
                $rowformEvaluate = formEvaluate::where('form_ref',$row[21])->first();
                $group_form_id = $rowformEvaluate->id;
            }
            $rowdata = EmployeeFinalScore::where('employee_no',sprintf("%06d", $row[2]))
            ->where('rec_year','like','%'.$checkYear.'%')
            ->first();

            if($rowdata){
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
                    "previous_form" => ($row[20]!="" && $row[20]!="-"?$row[20]:NULL),
                    "form_import" => ($row[21]!="" && $row[21]!="-"?$row[21]:NULL),
                    "group_form_id" => ($row[21]!="" && $row[21]!="-"?$group_form_id:0),
                    // "previous_evaluator_no" => ($row[7]!=""?sprintf("%06d", $row[7]):NULL),
                    "evaluator_no" => ($row[22]!=""?sprintf("%06d", $row[22]):NULL),
                    "evaluator_name_th" => $row[24],
                    "evaluator_name_en" => $row[23],
                    "evaluation_criteria_id" => $evaluation_criteria_id,
                    "criteria_score_eva" => $evaluation_criteria_id_comma,
                    "criteria_score_old" => $evaluation_criteria_id_comma,
                    "criteria_score_new" => $evaluation_criteria_id_comma,
                ]);
            }
        }

    }
}
