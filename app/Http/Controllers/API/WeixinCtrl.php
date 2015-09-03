<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Weixin;
use App\Http\Controllers\Controller;

class WeixinCtrl extends Controller
{
	public function getIndex()
	{
		return Weixin::paginate();
	}
}