<?php

namespace App\Models\group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Position extends Model
{
    use HasFactory;
    protected $table = 'tb_position';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
                        "position_code",
                        "position_description",
                        "created_by",
                        "updated_by",
                        "created",
                        "updated"];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
