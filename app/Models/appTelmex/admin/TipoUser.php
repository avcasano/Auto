<?php

namespace App\Models\appTelmex\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoUser extends Model
{
    use SoftDeletes;

    protected $table = 'admin_tipo_users';
}
