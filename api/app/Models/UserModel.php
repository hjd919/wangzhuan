<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public $timestamps  = false;
    protected $fillable = ['*'];

    public function isNew($openid)
    {
        return $this->where(['openid' => $openid])->first();
    }

    public function create($userdata)
    {
        return $this->create($userdata);
    }
}
