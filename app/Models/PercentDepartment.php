<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PercentDepartment extends Model
{
    use HasFactory;
    protected $table = 'tb_percent_department';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
    "title",
    "year",
    "date",
    "active",
    "created",
    "updated",
    "created_by",
    "updated_by"];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
