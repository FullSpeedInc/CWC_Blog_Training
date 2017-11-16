<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\Article;
use App\User;
use Auth;
use Response;
use View;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $formData                  = [];
        $user                      = new User;
        $formData['currentPage']   = ($request->page? $request->page: 1);
        $paginatorLenght           = 5;
        $articles                  = $user->getArticles();
        $articleSize               = sizeof($articles);
        $formData['articles']      = $articles->forPage($formData['currentPage'], $paginatorLenght);
        $formData['paginatorLast'] = ceil($articleSize/$paginatorLenght);

        return View::make('article.list', $formData);
    }

    public function create()
    {
        $formData['categories'] = Category::all(['id', 'name as value']);

        return View::make('article.create', $formData);

    }

    public function destroy(Request $request)
    {
        try{
            Article::destroy($request->id);

            return Response::json(['success' => true, 'message' => 'Article deleted.']);
        } catch(Exception $e) {
            return Response::json(['success' => false, 'message' => $e]);
        }
    }

    public function edit($id = null)
    {
        $formData               = [];
        $formData['article']    = Article::find($id);
        $formData['categories'] = Category::all(['id', 'name as value']);

        return View::make('article.edit', $formData);

    }

    public function store(Request $request)
    {
        try{
            $Article = new Article;

            $Article->article_category_id  = $request->category;
            $Article->contents             = $request->editor;
            $Article->image_path           = ($request->imgInput? $request->imgInput : null);
            $Article->slug                 = $request->slug;
            $Article->title                = $request->title;
            $Article->updated_user_id      = Auth::user()->id;

            $Article->save();

            return redirect()->route('article.list')->with(['articleAddMessage' => true, 'message' => 'Article added.']);
        } catch (Exception $e) {
            return redirect()->route('article.list')->withErrors($e);
        }
    }

    public function update(Request $request)
    {
        try{
            $Article = Article::find($request->id);

            $Article->article_category_id  = $request->category;
            $Article->contents             = $request->editor;
            $Article->image_path           = ($request->imgInput? $request->imgInput : null);
            $Article->slug                 = $request->slug;
            $Article->title                = $request->title;

            $Article->save();

            return redirect()->route('article.list')->with(['articleAddMessage' => true, 'message' => 'Article updated.']);
        } catch (Exception $e) {
            return redirect()->route('article.list')->withErrors($e);
        }
    }
}
