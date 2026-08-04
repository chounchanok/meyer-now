<?php

namespace App\Models\formEvaluate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formEvaluate extends Model
{
    use HasFactory;
    protected $table = 'group_form';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
