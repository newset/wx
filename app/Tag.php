<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags'; 

    public static $autoValidate = true;

    protected static $rules = [
    	'name' => 'required|unique'
    ];

    protected $guarded = ['id'];

    public $timestamps = false;

    public function validate($data){
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        // return the result
        return $v->passes();
    }

    public function weixin()
    {
        return $this->morphedByMany('App\Weixin', 'weixin_tag');
    }

}
