<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLogModel extends Model
{
    use HasFactory;
    protected $table = 'tb_employee_log';
    protected $primaryKey = 'ID_EMPLOYEE';
    protected $fillable = ["ID_EMPLOYEE","ID_FILE","ORISOFT_NO","ENG_TITLE","TH_TITLE","EMPLOYEE_LOCAL_NAME","EMPLOYEE_NAME","GRADE_CODE","DIVISION_CODE","DEPARTMENT_CODE","SECTION_CODE","POSITION_DESCRIPTION","SECTION_DESCRIPTION","DEPARTMENT_DESCRIPTION","DIVISION_DESCRIPTION","GRADE_DESCRIPTION","ID","BIRTH_DATE","DATE_JOINED","EMPLOYEE_TYPE","EMPLOYEE_TYPE_DESCRIPTION","HOME_CONTACT1","MAIL_ADDRESS1","POSITION_CODE","DATE_RESIGNED","DATE_RETIREMENT","DATE_CONFIRMED","EMPLOYEE_STATUS","EMPLOYEE_STATUS_DESCRIPTION","sort","created_by","updated_by","created_at","updated_at"];
     public $timestamp = false;
}
