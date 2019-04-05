<?php

namespace App\Apptelmex\admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $table = 'catfin_empresas';

    public function centro()
    {
        return $this->hasMany(Centro::class,'catfin_empresa_id');
    }

}
