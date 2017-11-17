<?php

namespace App\Repositories;


//additional includes
use App\Article;
use App\Category;
use Auth;

class CategoryRepository {

    /**
     * Soft deletes the category by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        if (Article::where(['article_category_id' => $id, 'deleted_at' => null])->count())
        {
            return false;
        }

        return Category::destroy($id);
    }

    /**
     * Gets all categories
     *
     * @return pagination
     */
    public function getAll()
    {
        return Category::select(['id', 'name'])
                         ->orderBy('name')
                         ->paginate(5);
    }

    /**
     * Saves new category.
     *
     * @return boolean
     */
    public function store($request)
    {
        $userId                    = Auth::user()->id;
        $category                  = new Category;
        $category->name            = $request->name;
        $category->updated_user_id = $userId;

        $category->save();

        return true;
    }
}