<?php

namespace App\Models\appTelmex\admin;

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
