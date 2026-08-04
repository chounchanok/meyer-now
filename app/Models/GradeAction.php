<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Grade;

class GradeAction extends Model
{
    use HasFactory;
    protected $table = 'tb_grade_action';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
    public function timeline()
    {
        return $this->hasOne(Grade::class, 'id', 'grade_id');
    }
}
