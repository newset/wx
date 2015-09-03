<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Weixin;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WeixinCtrl extends Controller
{


	public function getIndex()
	{
		return Weixin::paginate();
	}

	public function getShow(Request $request, $id)
	{
		// 获取未标记公众号
		$user_id = $request->user()->id;
		$valid = false;
		DB::transaction(function () use($user_id, $id, &$valid) {
			$condition = [
				'weixin_id' => $id
			];

			$row = DB::table('user_marked')->where($condition)->first();

			if ($row) {
				if ( $row->user_id == $user_id) {
					$valid = true;
				}
			}else{
				$condition['user_id'] = $user_id;
				DB::table('user_marked')->insert($condition);
				$valid = true;
			}
		});

		if ($valid) {
			return Weixin::with(['articles', 'tags'])->find($id);
		}else{
			return response(['error'=> '已有其他用户标记该公众号'], 400);
		}
		
	}

	public function postMark(Request $req)
	{	
		$user_id =$req->user()->id;

		return $req->input();
	}

	private function getNext()
	{

	}
}