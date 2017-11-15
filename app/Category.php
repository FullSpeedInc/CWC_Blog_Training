<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'article_category';
}
