<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluator extends Model
{
    use HasFactory;
    protected $table = 'tb_employee_evaluator';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
    "import_id",
    "rec_year",
    "employee_no",
    "evaluator_active",
    "employee_name_th",
    "employee_name_en",
    "position_code",
    "position_description",
    "grade_code",
    "grade_description",
    "division_code",
    "division_description",
    "department_code",
    "department_description",
    "section_code",
    "section_description",
    "group_description",
    "approve_pa_score_by",
    "created_by",
    "updated_by",
    "created_at",
    "updated_at"];
     public $timestamp = false;
}
