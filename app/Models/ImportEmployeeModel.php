<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportEmployeeModel extends Model
{
    use HasFactory;
    protected $table = 'tb_import_employee';
    protected $primaryKey = 'id_file';
    protected $fillable = ["id_file","name","path","size","created_at","updated_at"];
     public $timestamp = false;
}
