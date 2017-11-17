<?php

namespace App\Repositories;


//additional includes
use App\Category;
use Auth;

class CategoryRepository {

    public function destroy($id)
    {
        return Category::destroy($id);
    }

    public function getAll()
    {
        return Category::select(['id', 'name'])
                         ->orderBy('name')
                         ->paginate(5);
    }

    public function store($request)
    {
        $userId                    = Auth::user()->id;
        $Category                  = new Category;
        $Category->name            = $request->name;
        $Category->updated_user_id = $userId;

        $Category->save();

        return true;
    }
}