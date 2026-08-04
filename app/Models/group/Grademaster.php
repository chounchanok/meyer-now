<?php

namespace App\Models\group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Grademaster extends Model
{
    use HasFactory;
    protected $table = 'tb_grade_code';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
                        "grade_code",
                        "grade_description",
                        "created_by",
                        "updated_by",
                        "created",
                        "updated"];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
