<?php

namespace App\Http\Controllers\API;

use DB;
use App\Weixin;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Data extends Controller
{
	public function getIndex(Request $req)
	{
		$user = $req->user();
		$marked = DB::table('user_marked')->where('user_id', $user->id)->count();
		$total = $unmarked = 0;

		if (!Session::get('total_wx_count')) {
			Session::set('total_wx_count', Weixin::count());
			Session::set('unmarked_wx_count', Weixin::whereNull('marking')->orWhere('marking', 0)->count());
		}

		$total = Session::get('total_wx_count');
		$unmarked = Session::get('unmarked_wx_count');

		return [
			'me' => $marked,
			'total' => $total,
			'unmarked' => $unmarked,
			'marked' => $total-$unmarked,
			'pending' => Weixin::where('marking', 0)->count()
		];
	}

	public function getUser(Request $req)
	{
		return $req->user();
	}


}