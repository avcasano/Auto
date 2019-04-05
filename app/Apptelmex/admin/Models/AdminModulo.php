<?php

namespace App\Apptelmex\admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AdminMudulos
 * @package App\Apptelmex\admin\Models
 * @version March 20, 2019, 7:23 pm UTC
 *
 * @property string slug
 * @property string descripcion
 */
class AdminModulo extends Model
{
    
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'admin_modulos';
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [ 'slug','descripcion',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'slug' => 'string',
        'descripcion' => 'string'
    ];
}