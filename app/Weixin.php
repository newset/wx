<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weixin extends Model
{
    protected $table = 'weixins';

    // 关系
    public function articles()
    {
        return $this->hasMany('App\Article')->orderBy('pubtime', 'desc');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'weixin_tag');
    }
}
