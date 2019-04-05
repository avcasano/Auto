<?php

namespace App\Models\appTelmex\admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centro extends Model
{
    use SoftDeletes;

    protected $table = 'admin_centros';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class,'catfin_empresa_id');
    }
    public function sitiosap()
    {
        return $this->hasMany(SitioSap::class,'admin_centro_id');
    }
}
