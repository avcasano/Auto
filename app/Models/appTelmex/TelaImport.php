<?php

namespace App\Models\appTelmex;

use App\Models\appTelmex\TelaImporField;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;



class TelaImport extends Model
{
    use AdminBuilder;
    public $timestamps = true;
    protected $table = 'tela_imports';

    //protected $relations ='TelaImporField.tela_import_id';

    public function telaimportfield()
    {
        return $this->hasMany(TelaImportField::class,'tela_import_id');
    }

}
