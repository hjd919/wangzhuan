<?php

namespace App;

use Artesaos\Defender\Traits\HasDefender;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasDefender;

    // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $table      = 'backend_users';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 属于该用户的身份。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
