<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluateLog extends Model
{
    use HasFactory;
    protected $table = 'tb_employee_evaluator_log';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
    "id_file",
    "rec_year",
    "employee_no",
    "Evaluator_name",
    "Evaluator_Localname",
    "Evaluator_position_code",
    "Evaluator_position_DESCRIPTION",
    "Evaluator_DIVISION_CODE",
    "Evaluator_DIVISION_DESCRIPTION",
    "Evaluator_DEPARTMENT_CODE",
    "Evaluator_DEPARTMENT_DESCRIPTION",
    "Evaluator_SECTION_CODE",
    "Evaluator_SECTION_DESCRIPTION",
    "Evaluator_GRADE_CODE",
    "Evaluator_GRADE_DESCRIPTION",
    "approve_pa_score_by",
    "created_by",
    "updated_by",
    "created_at",
    "updated_at"];
     public $timestamp = false;
}
