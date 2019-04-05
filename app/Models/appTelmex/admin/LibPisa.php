<?php

namespace App\Models\appTelmex\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibPisa extends Model
{
    use SoftDeletes;

    protected $table = 'admin_lib_pisa';

    public function sitiopisa()
    {
        return $this->hasMany(SitioPisa::class,'admin_lib_pisa_id');
    }
    public function sitio()
    {
        return $this->hasMany(Sitio::class,'admin_lib_pisa_id');
    }

}
