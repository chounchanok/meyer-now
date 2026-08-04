<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalAll extends Model
{
    use HasFactory;
    protected $table = 'tb_total_all';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
                        "year",
                        "total_type",
                        "current_salary_wage",
                        "L800_avg_wage_mwa",
                        "salary_wage_calculation",
                        "current_salary_wage_month",
                        "company_suggested_percent",
                        "company_suggested_amount",
                        "company_suggested_new_basic",
                        "inc_percent_proposed",
                        "inc_amount_proposed",
                        "new_basic_wage_proposed",
                        "new_salary_wage_month",
                        "created_at",
                        "updated_at",
                        "created_by",
                        "updated_by"];
     public $timestamp = false;
}
