<?php

namespace App\Models\apptelmex\catfin;

use App\Models\appTelmex\catfin\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;
    protected $table = 'catfin_divisiones';

    public function sitio()
    {
        return $this->hasMany(Sitio::class,'catfin_division_id');
    }

}
