<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps  = false;
    protected $fillable = ['*'];

    public function isNew($openid)
    {
        return $this->where(['openid' => $openid])->first();
    }

    public function add($userdata)
    {
        return self::create($userdata);
    }
}
