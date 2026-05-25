<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTopicModel extends Model
{
    protected $table    = 'article_topic';
    protected $fillable = ['article','topic'];
    public function Topic()
    {
        return $this->belongsTo(TopicModel::class,'topic','id');
    }
     public function Article()
    {
        return $this->belongsTo(ArticleModel::class,'article','id');
    }
}
