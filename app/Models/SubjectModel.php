<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    protected $table    = 'subject';
    protected $fillable = ['name','description','long_description','article_count','status'];
}
