<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\Article;
use View;

class ArticleController extends Controller
{
    public function index()
    {
        $formData             = [];
        $formData['articles'] = Article::select(['id', 'name'])
                                        ->orderBy('name')
                                        ->paginate(5);

        return View::make('article.list', $formData);
    }
}
