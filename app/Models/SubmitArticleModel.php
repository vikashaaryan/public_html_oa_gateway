<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmitArticleModel extends Model
{
    protected $table    = 'submit_article';
    protected $fillable = ['first_name','last_name','email_address','institution','title','subject','abstract','document','comments'];
}
