<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleContentModel extends Model
{
    protected $table    = 'article_content';
    protected $fillable = ['article','title','description'];
    public function Article(){
        return $this->hasOne(ArticleModel::class,'id','article');
    }
}
