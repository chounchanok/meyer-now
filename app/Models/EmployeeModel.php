<?php

namespace App\Models;

use App\Models\group\Department;
use App\Models\group\Division;
use App\Models\group\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;
    protected $table = 'tb_employee';
    protected $primaryKey = 'id';
    protected $fillable = [
        "id",
        "employee_import_id",
        "orisoft_no",
        "title_en",
        "title_th",
        "employee_local_name_th",
        "employee_local_name_en",
        "grade_code",
        "division_code",
        "department_code",
        "position_code",
        "section_code",
        "position_description",
        "section_description",
        "department_description",
        "division_description",
        "grade_description",
        "ref_log_id",
        "birth_date",
        "date_joined",
        "employee_type",
        "employee_type_description",
        "home_contact_1",
        "mail_address_1",
        "position_code",
        "date_resigned",
        "date_retirement",
        "date_confirmed",
        "employee_status",
        "employee_status_description",
        "sort",
        "created_at",
        "updated_at"
    ];
    public $timestamp = false;

    public function department()
    {
        return $this->hasOne(Department::class, 'department_code', 'department_code');
    }
    public function division()
    {
        return $this->hasOne(Division::class, 'division_code', 'division_code');
    }
    public function position()
    {
        return $this->hasOne(Position::class, 'position_code', 'position_code');
    }
    public function employeelog()
    {
        return $this->hasOne(EmployeeLogModel::class, 'ORISOFT_NO', 'orisoft_no');
    }

    public function getNameAttribute()
    {
        return $this->LanguageLocale('employee_local_name');
    }

    public function LanguageLocale($name)
    {
        if (\Config::get('land') != 'en') {
            $name = $name . '_th';
        } else {
            $name = $name . '_en';
        }
        return $this->$name;
    }
}
