<?php

namespace App\Models\pa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Action extends Model
{
    use HasFactory;
    protected $table = 'tb_pa_timeline_action';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
    public function timeline()
    {
        return $this->hasOne(Patimeline::class, 'id', 'pa_timeline_id');
    }
}
