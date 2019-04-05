<?php

namespace App\Models\appTelmex\admin;

use App\Models\appTelmex\catpro\Sitio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SitioSap extends Model
{
    use SoftDeletes;

    protected $table = 'admin_sitio_sap';

    public function centro()
    {
        return $this->belongsTo(Centro::class,'admin_centro_id');
    }
    public function sitio()
    {
        return $this->hasMany(Sitio::class,'admin_sitio_sap_id');
    }
}
