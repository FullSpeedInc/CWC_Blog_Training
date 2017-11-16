<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    protected $table = 'articles';
}
