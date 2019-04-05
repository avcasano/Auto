<?php

namespace App\Apptelmex\admin\Models;
use App\Models\appTelmex\catpro\Sitio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoSitio extends Model
{
    use SoftDeletes;

    protected $table = 'admin_tipo_sitios';

    public function sitio()
    {
        return $this->hasMany(Sitio::class,'admin_tipo_sitio_id');
    }
}
