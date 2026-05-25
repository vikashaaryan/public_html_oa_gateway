<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleSubjectModel extends Model
{
    protected $table    = 'article_subject';
    protected $fillable = ['article','subject'];
    public function Subjects()
    {
        return $this->belongsTo(SubjectModel::class,'subject','id');
    }
     public function Article()
    {
        return $this->belongsTo(ArticleModel::class,'article','id');
    }

}
