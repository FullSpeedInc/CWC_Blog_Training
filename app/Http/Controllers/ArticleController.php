<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\Repositories\ArticleRepository;
use App\User;
use Auth;
use Response;
use View;

class ArticleController extends Controller
{
    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function index(Request $request)
    {
        $formData                  = [];
        $user                      = new User;
        $formData['currentPage']   = ($request->page? $request->page: 1);
        $paginatorLenght           = 5;
        $articles                  = $this->article->getUserArticles();
        $articleSize               = sizeof($articles);
        $formData['articles']      = $articles->forPage($formData['currentPage'], $paginatorLenght);
        $formData['paginatorLast'] = ceil($articleSize/$paginatorLenght);

        return View::make('article.list', $formData);
    }

    /**
     * @param none
     *
     * @return \views
     */
    public function create()
    {
        $formData['categories'] = $this->article->getAll();

        return View::make('article.create', $formData);

    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function destroy(Request $request)
    {
        try{
            $this->article->destroy($request->id);

            return Response::json(['success' => true, 'message' => 'Article deleted.']);
        } catch(Exception $e) {
            return Response::json(['success' => false, 'message' => $e]);
        }
    }

    /**
     * @param int $id
     *
     * @return \views
     */
    public function edit($id = null)
    {
        $formData               = [];
        $formData['article']    = $this->article->getArticleById($id);
        $formData['categories'] = Category::all(['id', 'name as value']);

        return View::make('article.edit', $formData);
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function store(Request $request)
    {
        try{
            $this->article->store($request);

            return redirect()->route('article.list')->with(['articleAddMessage' => true, 'message' => 'Article added.']);
        } catch (Exception $e) {
            return redirect()->route('article.list')->withErrors($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function update(Request $request)
    {
        try{
            $this->article->update($request);

            return redirect()->route('article.list')->with(['articleAddMessage' => true, 'message' => 'Article updated.']);
        } catch (Exception $e) {
            return redirect()->route('article.list')->withErrors($e);
        }
    }
}
