<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\Repositories\CategoryRepository;
use Auth;
use Exception;
use Response;
use View;

class CategoryController extends Controller
{

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * @param none
     *
     * @return \views
     */
    public function index()
    {
        $formData               = [];
        $formData['categories'] = $this->category->getAll();

        return View::make('category.list', $formData);
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function store(Request $request)
    {
        try {
            $this->category->store($request);

            return redirect()->route('category.list')->with(['categoryAddMessage' => true, 'message' => 'Category added.']);
        } catch (Excception $e) {
            return redirect()->route('category.list')->withErrors($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return \views
     */
    public function destroy(Request $request)
    {
        try{
            $this->category->destroy($request->id);

            return Response::json(['success' => true, 'message' => 'Category deleted.']);
        } catch(Exception $e) {
            return Response::json(['success' => false, 'message' => $e]);
        }
    }
}
