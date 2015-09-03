<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags'; 

    public function posts()
    {
        return $this->morphedByMany('App\Weixin', 'weixin_tag');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function videos()
    {
        return $this->morphedByMany('App\Article', 'article_tag');
    }
}
