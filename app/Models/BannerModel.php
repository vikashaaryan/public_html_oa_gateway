<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table    = 'banner';
    protected $fillable = ['article','status'];
    public function Articles(){
        return $this->hasOne(ArticleModel::class,'id','article');
    }
    public function Subjects()
    {
        return $this->hasManyThrough(
            SubjectModel::class,
            ArticleSubjectModel::class,
            'article', // Foreign key on article_subject table
            'id',         // Foreign key on subjects table
            'id',         // Local key on article table
            'subject'  // Local key on article_subject table
        );
    }
    public function Contents(){
        return $this->hasMany(ArticleContentModel::class,'article','article');
    }
}
