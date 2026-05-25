<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    protected $table    = 'article';
    protected $fillable = ['title','article_type','article_id','submit_date','approve_date','publish_date','pdf','doi','doi_link','no_contents','no_author','university ','seo_title','seo_description','seo_keywords','volume','issue','copy_rights','status'];
    public function ArticleContents(){
        return $this->hasMany(ArticleContentModel::class,'article','id');
    }
    public function ArticleAuthors(){
        return $this->hasMany(ArticleAuthorModel::class,'article_id','id')->orderBy('author_sort', 'asc');
    }
    public function ArticleType(){
        return $this->hasOne(ArticleTypeModel::class,'id','article_type');
    }
    public function Issues(){
        return $this->hasOne(IssueModel::class,'id','issue');
    }
    public function ArticleSubjects()
    {
        return $this->hasMany(ArticleSubjectModel::class,'id','article');
    }

    // Optional convenience method
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
     public function ArticleTopics()
    {
        return $this->hasMany(ArticleTopicModel::class,'id','article');
    }
    public function Topics()
    {
        return $this->hasManyThrough(
            TopicModel::class,
            ArticleTopicModel::class,
            'article',     // Foreign key on article_topic table
            'id',          // Foreign key on topic table
            'id',          // Local key on article table
            'topic'        // Local key on article_topic table
        );
    }
    public function Universities(){
        return $this->hasOne(UniversityModel::class,'id','university');
    }
    public function Volumes(){
        return $this->hasOne(VolumeModel::class,'id','volume');
    }
}
