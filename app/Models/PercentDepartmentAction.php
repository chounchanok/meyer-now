<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\PercentDepartment;

class PercentDepartmentAction extends Model
{
    use HasFactory;
    protected $table = 'tb_percent_department_action';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
    "percent_department_id",
    "division_code",
    "department_code",
    "section_code",
    "percent_daily",
    "percent_monthly",
    "approve_by1",
    "approve_by2",
    "approve_by3",
    "active",
    "created",
    "updated",
    "created_by",
    "updated_by"];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
    public function timeline()
    {
        return $this->hasOne(PercentDepartment::class, 'id', 'grade_id');
    }
}
