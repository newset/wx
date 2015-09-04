<?php

namespace App\Http\Controllers\API;

use DB;
use App\User;
use App\Tag;
use App\Category;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Tags extends Controller
{
	public function getIndex()
	{
		return Category::with(['tags'])->get();
	}

	public function postImport(Request $req)
	{
		$data = [];
		$status = true;
		if ($req->input('tags')) {
			$data = explode("\n", $req->input('tags'));

			for ($i=0; $i < count($data); $i++) { 

				list($cate, $name) = explode('-', $data[$i]);

				$tag =Tag::where('name', $name)->first();
				if ($tag) {
					$tag->category_id = $cate;
					$tag->save();
				}else{
					Tag::create(['name'=>$name, 'category_id'=>$cate]);
				}
			}
		}

		return ['status'=> $status, 'tags'=> $this->getIndex()];
	}
}