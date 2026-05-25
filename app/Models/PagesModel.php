<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    protected $table    = 'pages';
    protected $fillable = ['name','slug_title','slug_url','description','sort','status'];
}
