<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ["id",
    "orisoft_code",
    "name",
    "email",
    "profile_photo_path",
    "email_verified_at",
    "password",
    "avatar",
    "remember_token",
    "section_code",
    "section_description",
    "created_at",
    "updated_at",
    "last_login_at",
    "last_login_ip"];
     public $timestamp = false;
}
