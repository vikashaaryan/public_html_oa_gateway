<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTypeModel extends Model
{
    protected $table    = 'article_type';
    protected $fillable = ['name','status'];

}
