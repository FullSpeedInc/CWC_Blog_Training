<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//additional includes
use App\Category;
use Auth;
use Exception;
use Response;
use View;

class CategoryController extends Controller
{
    public function index()
    {
        $formData               = [];
        $formData['categories'] = Category::select(['id', 'name'])
                                          ->orderBy('name')
                                          ->paginate(5);

        return View::make('category.list', $formData);
    }

    public function store(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $Category = new Category;

            $Category->name            = $request->name;
            $Category->updated_user_id = $userId;

            $Category->save();

            return redirect()->route('category.list')->with(['categoryAddMessage' => true, 'message' => 'Category added.']);
        } catch (Excception $e) {
            return redirect()->route('category.list')->withErrors($e);
        }
    }

    public function destroy(Request $request)
    {
        try{
            Category::destroy($request->id);

            return Response::json(['success' => true, 'message' => 'Category deleted.']);
        } catch(Exception $e) {
            return Response::json(['success' => false, 'message' => $e]);
        }
    }
}
