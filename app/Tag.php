<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags'; 

    public function weixin()
    {
        return $this->morphedByMany('App\Weixin', 'weixin_tag');
    }

}
