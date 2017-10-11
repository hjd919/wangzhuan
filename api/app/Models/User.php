<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class User extends Model
{
    protected $fillable = ['*'];

    public function isNew($openid)
    {
        return $this->where(['openid' => $openid])->first();
    }

    public function add($userdata)
    {
        Log::info(var_export($userdata, true));
        return self::create($userdata);
    }
}
