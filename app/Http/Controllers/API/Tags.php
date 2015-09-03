<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Tag;
use App\Http\Controllers\Controller;

class Tags extends Controller
{
	public function getIndex()
	{
		return Tag::all();
	}
}