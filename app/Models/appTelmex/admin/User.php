<?php

namespace App\Models\appTelmex\admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'admin_users';

    public function PasswordHistory()
    {
      //return $this->hasMany(PasswordHistory::class,'user_id');
      //return $this->hasMany('PasswordHistory');
      return $this->hasMany('PasswordHistory');
    }

}
