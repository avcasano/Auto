<?php

namespace App\Models\appTelmex\catfin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $table = 'catfin_areas';

    public function sitio()
    {
        return $this->hasMany(Sitio::class,'catfin_area_id');
    }
}
