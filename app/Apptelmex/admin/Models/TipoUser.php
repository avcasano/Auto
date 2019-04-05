<?php

namespace App\Apptelmex\admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoUser extends Model
{
    use SoftDeletes;

    protected $table = 'admin_tipo_users';
}
