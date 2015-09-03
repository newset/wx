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
		$data = $req->input();

		// 判断当前 weixin是否由登录用户标记
		$weixin = DB::table('user_marked')->where(['user_id'=>$user_id, 'weixin_id'=>$data['id']])->first();
		if (!$weixin) {
			return ['error'=>'无操作权限', 'code'=>1];
		}

		DB::table('weixin_tags')->where('weixin_tag_id', $data['id'])->delete();

		$tags = $data['tags'];
		$insert = [];
		for ($i=0; $i < count($tags); $i++) { 
			$item = ['weixin_tag_id'=> $data['id'], 'tag_id'=>$tags[$i], 'weixin_tag_type'=>'App\Weixin'];
			array_push($insert, $item);
		}
		DB::table('weixin_tags')->insert($insert);

		// 获取下一个
		// ->whereNotIn('id', [1, 2, 3]);

		return ['code'=>0];
	}

	private function getNext()
	{

	}
}