<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalScoreLog extends Model
{
    use HasFactory;
    protected $table = 'tb_employee_final_score_log';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
                        "id_file",
                        "rec_year",
                        "employee_no",
                        "form_import",
                        "group_form_id",
                        "evaluator_no",
                        "evaluation_criteria_score1",
                        "evaluation_criteria_score2",
                        "evaluation_criteria_score3",
                        "evaluation_criteria_score4",
                        "evaluation_criteria_score5",
                        "evaluation_criteria_score6",
                        "evaluation_criteria_score7",
                        "evaluation_criteria_score8",
                        "evaluation_criteria_score9",
                        "attendance_score",
                        "total_score",
                        "pa_grade",
                        "adjust_grade",
                        "remark",
                        "created_by",
                        "updated_by",
                        "created_at",
                        "updated_at"];
     public $timestamp = false;
}
