<?php

namespace App\Models\appTelmex\catpro;

use App\Models\appTelmex\admin\TipoSitio;
use App\Models\appTelmex\admin\SitioSap;
use App\Models\appTelmex\admin\LibPisa;
use App\Models\appTelmex\catfin\Division;
use App\Models\appTelmex\catfin\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sitio extends Model
{
    use SoftDeletes;

    protected $table = 'catpro_sitios';

    public function tipositio()
    {
        return $this->belongsTo(TipoSitio::class,'admin_tipo_sitio_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class,'catpro_proveedor_id');
    }
    public function sitiosap()
    {
        return $this->belongsTo(SitioSap::class,'admin_sitio_sap_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class,'catfin_division_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class,'catfin_area_id');
    }
    public function libpisa()
    {
        return $this->belongsTo(LibPisa::class,'admin_lib_pisa_id');
    }
}
