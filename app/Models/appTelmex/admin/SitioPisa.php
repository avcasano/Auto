<?php

namespace App\Models\appTelmex\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SitioPisa extends Model
{
    use SoftDeletes;

    protected $table = 'admin_sitio_pisa';

    public function libpisa()
        {
            return $this->belongsTo(LibPisa::class,'admin_lib_pisa_id');
        }

}
