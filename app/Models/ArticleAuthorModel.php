<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleAuthorModel extends Model
{
    protected $table    = 'article_author';
    protected $fillable = ['article_id','author_name','about_author','author_sort'];
    public function Article(){
        return $this->hasOne(ArticleModel::class,'id','article_id');
    }
}
