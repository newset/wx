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
			
			for ($i=0; $i < count($data); $i++) { 
				try {
					DB::table('tags')->insert(['name'=>$data[$i]]);
				} catch (Exception $e) {
					$status = false; 
				}
			}
			
		}

		return ['status'=> $status, 'tags'=> Tag::all()];
	}
}