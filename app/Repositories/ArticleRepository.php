<?php

namespace App\Repositories;


//additional includes
use App\Article;
use App\Category;
use App\User;
use Auth;

class ArticleRepository {

    public function destroy($id)
    {
        return Article::destroy($id);
    }

    public function getAll()
    {
        return Category::all(['id', 'name as value']);
    }

    public function getArticleById($id)
    {
        return Article::find($id);
    }

    public function getUserArticles()
    {
        $User = new User;

        return $User->getArticles();
    }

    public function update($request)
    {
        $Article                       = Article::find($request->id);
        $Article->article_category_id  = $request->category;
        $Article->contents             = $request->editor;
        $Article->image_path           = ($request->imgInput? $request->imgInput : null);
        $Article->slug                 = $request->slug;
        $Article->title                = $request->title;

        $Article->save();

        return true;
    }

    public function store($request)
    {
        $Article                       = new Article;
        $Article->article_category_id  = $request->category;
        $Article->contents             = $request->editor;
        $Article->image_path           = ($request->imgInput? $request->imgInput : null);
        $Article->slug                 = $request->slug;
        $Article->title                = $request->title;
        $Article->updated_user_id      = Auth::user()->id;

        $Article->save();

        return true;
    }
}