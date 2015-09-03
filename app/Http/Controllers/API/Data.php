<?php

namespace App\Http\Controllers\API;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Data extends Controller
{
	public function getIndex(Request $req)
	{
		$user = $req->user();
		$marked = DB::table('user_marked')->where('user_id', $user->id)->count();

		return [
			'marked' => $marked
		];
	}
}