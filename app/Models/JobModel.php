<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    protected $table    = 'job';
    protected $fillable = ['name','status'];
    public function Authors(){
         return $this->hasMany(AuthorModel::class,'job_id','id')->orderBy('sort','asc');
    }
}
