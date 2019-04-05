<?php

namespace App\Apptelmex\admin\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    protected $guarded = [];
    protected $table = 'admin_password_histories';

    public function post()
    {
        return $this->belongsTo('User');
    }

}
