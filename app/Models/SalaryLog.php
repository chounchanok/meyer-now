<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryLog extends Model
{
    use HasFactory;
    protected $table = 'tb_employee_salary_log';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
                        "id_file",
                        "rec_year",
                        "branch",
                        "employee_no",
                        "employee_name",
                        "division_code",
                        "department_code",
                        "section_code",
                        "grade_code",
                        "category",
                        "position_code",
                        "position_description",
                        "salary",
                        "salary_month",
                        "date_joined",
                        "created_by",
                        "updated_by",
                        "created_at",
                        "updated_at"];
     public $timestamp = false;
}
