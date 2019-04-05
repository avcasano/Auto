<?php

namespace App\Models\appTelmex\admin;

use Illuminate\Database\Eloquent\Model;

class PasswordSecurity extends Model
{
    protected $table = 'admin_password_securities';
    protected $fillable = ['user_id','password_expiry_days','password_updated_at','created_at','updated_at'];    
}
