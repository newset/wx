<?php

namespace App\Http\Controllers\API;

use DB;
use App\User;
use App\Tag;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Tags extends Controller
{
	public function getIndex()
	{
		return Tag::all();
	}

	public function postImport(Request $req)
	{
		$data = [];
		$status = true;
		if ($req->input('tags')) {
			$data = explode("\n", $req->input('tags'));
			$insert = [];
			for ($i=0; $i < count($data); $i++) { 
				array_push($insert, ['name'=>$data[$i]]);
			}

			$res = [];
			try {
				 DB::table('tags')->insert($insert);
			} catch (Exception $e) {
				$status = false; 
			}
			
		}

		return ['status'=> $status, 'tags'=> Tag::all()];
	}
}