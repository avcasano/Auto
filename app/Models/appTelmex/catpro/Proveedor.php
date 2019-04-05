<?php

namespace App\Models\appTelmex\catpro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use SoftDeletes;

    protected $table = 'catpro_proveedores';

    public function sitio()
    {
        return $this->hasMany(Sitio::class,'catpro_proveedor_id');
    }
}
