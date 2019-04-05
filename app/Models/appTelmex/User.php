<?php
namespace App\Models\appTelmex;

//use App\Models\User\Address;
//use App\Models\User\Profile;
//use App\Models\User\Sns;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Define la relación para el historial de passord's
     *
     *
     */

    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class,'user_id');

    }
}
