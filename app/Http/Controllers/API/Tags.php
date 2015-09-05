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
		$color = ['red', 'pink', 'blue', 'purple', 'green', 'yellow', 'indigo', 'cyan', 'lime', 'brown', 'orange', 'gray'];

		$data = [];
		$status = true;
		if ($req->input('tags')) {
			$data = explode("\n", $req->input('tags'));

			for ($i=0; $i < count($data); $i++) { 

				list($cate, $name) = explode('-', $data[$i]);
				$category = DB::table('categories')->where('name', $cate)->first();
				$cateId = 0;
				if ($category) {
					$cateId = $category->id;
				}else{
					$cateId = DB::table('categories')->insertGetId(
					    ['name' => $cate, 'color' => $color[rand(0, count($color)-1)]]
					);
				}

				$tag =Tag::where('name', $name)->first();
				if ($tag) {
					$tag->category_id = $cateId;
					$tag->save();
				}else{
					Tag::create(['name'=>$name, 'category_id'=>$cateId]);
				}
			}
		}

		return ['status'=> $status, 'tags'=> $this->getIndex()];
	}
}