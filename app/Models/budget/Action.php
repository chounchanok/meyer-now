<?php

namespace App\Models\budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Action extends Model
{
    use HasFactory;
    protected $table = 'tb_budget_action';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
    public function timeline()
    {
        return $this->hasOne(Budget::class, 'id', 'budget_id');
    }
}
