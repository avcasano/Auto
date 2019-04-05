<?php

namespace App\Models\appTelmex;

use App\Models\appTelmex\TelaImport;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;


class TelaImportField extends Model
{
  use AdminBuilder;

    protected $table = 'tela_import_fields';
    protected $fillable = ['field', 'tipo', 'nulos','rule', 'model'];


    public function telaimport()
    {
        return $this->belongsTo(TelaImport::class,'tela_import_id');
    }

}
