<?php

namespace App\Models\pa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patimeline extends Model
{
    use HasFactory;
    protected $table = 'tb_pa_timeline';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
