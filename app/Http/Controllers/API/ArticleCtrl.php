<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Article;
use App\Http\Controllers\Controller;

class ArticleCtrl extends Controller
{
	public function getIndex()
	{
		return Article::paginate(15);
	}
}