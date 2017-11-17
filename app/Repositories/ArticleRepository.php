<?php

namespace App\Repositories;


//additional includes
use App\Article;
use App\Category;
use App\User;
use Auth;

class ArticleRepository {

    /**
     * Soft deletes an article by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return Article::destroy($id);
    }

    /**
     * Retrieves all categories.
     *
     * @return mixed
     */
    public function getAllCategories()
    {
        return Category::all(['id', 'name as value']);
    }

    /**
     * Gets article details by id.
     * @param int $id
     *
     * @return mixed
     */
    public function getArticleById($id)
    {
        return Article::find($id);
    }

    /**
     * Gets all articles created by user.
     *
     * @return mixed
     */
    public function getUserArticles()
    {
        $user = new User;

        return $user->getArticles();
    }

    /**
     * Updates articles by id.
     *
     * @param Request $request
     *
     * @return boolean
     */
    public function update($request)
    {
        $article                       = Article::find($request->id);
        $article->article_category_id  = $request->category;
        $article->contents             = $request->editor;
        $article->image_path           = ($request->imgInput? $request->imgInput : null);
        $article->slug                 = $request->slug;
        $article->title                = $request->title;

        $article->save();

        return true;
    }

    /**
     * Creates a new article.
     *
     * @param Request $request
     *
     * @return boolean
     */
    public function store($request)
    {
        $article                       = new Article;
        $article->article_category_id  = $request->category;
        $article->contents             = $request->editor;
        $article->image_path           = ($request->imgInput? $request->imgInput : null);
        $article->slug                 = $request->slug;
        $article->title                = $request->title;
        $article->updated_user_id      = Auth::user()->id;

        $article->save();

        return true;
    }
}