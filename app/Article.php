<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    
    public function weixin()
    {
        return $this->belongsTo('App\Weixin');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'article_tag');
    }
}
