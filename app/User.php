<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

//additional includes
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private function articles()
    {
        return $this->hasMany('App\Article', 'updated_user_id', 'id');
    }

    public function getArticles()
    {
        switch (Auth::user()->role) {
            case 1:
                return Article::join('article_category', 'article_category.id', '=', 'articles.article_category_id')
                                ->join('users', 'users.id', '=', 'articles.updated_user_id')
                                ->select('users.id as user_id', 'users.username', 'articles.title',
                                    'articles.slug', 'articles.contents', 'articles.id as article_id',
                                    'article_category.name as category')
                                ->paginate(5);
                break;
            default:
                return $this->find(Auth::user()->id)
                            ->articles()
                            ->join('users', 'users.id', '=', 'articles.updated_user_id')
                            ->join('article_category', 'article_category.id', '=', 'articles.article_category_id')
                            ->select('users.id as user_id', 'users.username', 'articles.title', 'articles.slug',
                                'articles.contents', 'articles.id as article_id', 'article_category.name as category')
                            ->paginate(5);
        }
    }
}
