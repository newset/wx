<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Weixin;
use DB;
use Illuminate\Http\Request;
use Session;

class WeixinCtrl extends Controller {

	public function getIndex() {
		return Weixin::paginate();
	}

	public function getShow(Request $request, $id) {
		// 获取未标记公众号
		return Weixin::with(['articles' => function ($q) {
			return $q->where('idx', 1);
		}, 'tags'])->find($id);
	}

	public function postMark(Request $req) {
		$user = $req->user();
		$data = $req->input();

		$tags = $data['tags'];
		$insert = [];
		for ($i = 0; $i < count($tags); $i++) {
			$item = ['weixin_tag_id' => $data['id'], 'tag_id' => $tags[$i], 'weixin_tag_type' => 'App\Weixin'];
			array_push($insert, $item);
		}

		DB::transaction(function () use ($insert, $data, $user) {
			DB::table('weixin_tags')->where('weixin_tag_id', $data['id'])->delete();
			DB::table('weixin_tags')->insert($insert);
			DB::table('user_marked')->insert(['user_id' => $user->id, 'weixin_id' => $data['id'], 'valid' => 1]);

			// update
			Weixin::where('id', $data['id'])->update(['marking' => 1]);
		});

		// 更新统计
		$unmarked = Session::get('unmarked_wx_count');
		Session::set('unmarked_wx_count', $unmarked - 1);

		// 获取下一个
		$next = $this->next($user->last_wx);
		$user->last_wx = $next->id;
		$user->save();

		return ['code' => 0, 'next' => $next];
	}

	public function getNext(Request $req) {
		$user = $req->user();
		$weixin = $this->next($user->last_wx);
		if ($user->last_wx != $weixin->id) {
			$user->last_wx = $weixin->id;
			$user->save();
		}

		return $weixin;
	}

	private function next($last) {
		$next = null;
		if ($last) {
			$row = Weixin::with(['articles', 'tags'])->where('marking', 0)->find($last);
			if ($row) {
				return $row;
			}

		}

		DB::transaction(function () use (&$next) {
			$next = Weixin::with(['articles', 'tags'])->whereNull('marking')->orderBy('priority', 'desc')->first();
			$next->marking = 0;
			$next->save();
		});

		return $next;
	}
}
