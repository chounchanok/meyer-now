<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;
    protected $table = 'tb_employee_attendance_log';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
                        "id_file",
                        "rec_year",
                        "employee_no",
                        "title_en",
                        "title_th",
                        "EMPLOYEE_NAME",
                        "EMPLOYEE_LOCAL_NAME",
                        "POSITION_CODE",
                        "POSITION_DESCRIPTION",
                        "DIVISION_CODE",
                        "DIVISION_DESCRIPTION",
                        "DEPARTMENT_CODE",
                        "DEPARTMENT_DESCRIPTION",
                        "SECTION_CODE",
                        "SECTION_DESCRIPTION",
                        "GRADE_CODE",
                        "GRADE_DESCRIPTION",
                        "DATE_JOINED",
                        "service_days",
                        "attendance_sl",
                        "attendance_pl",
                        "attendance_late",
                        "attendance_abs",
                        "attendance_abt",
                        "attendance_sus",
                        "attendance_wwar",
                        "attendance_vwar",
                        "form_import",
                        "group_form_id",
                        "evaluator_no",
                        "created_by",
                        "updated_by",
                        "created_at",
                        "updated_at"];
     public $timestamp = false;
}
